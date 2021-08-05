<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembimbing_tesis extends CI_Controller{
    var $dir = 'tigris/Pembimbing_tesis';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
	}
    public function index() {
		$this->list_data();
	}

    public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Pembimbing Tesis');

		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'judul_tesis' 		=> $search_key,
			);	
			$data['for_search'] = @$fcari['judul_tesis'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = @$fcari['judul_tesis'];
		}

		$from = array(
			'peg_pegawai dosen_pembimbing' => '',
            'pengajuan_judul judul' => 'a.id_pengajuan_judul = judul.id_pengajuan_judul'
            
		);
		$select = '';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'));

		}else{
			$where = array(
                'id_tipe' => 2,
            );
		}
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' =>$from, 'select'=>'*','search' => $fcari,'offset'=>$offs,'select'=>$select,'where'=>$where))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>$from,'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where));

        // cek($this->db->last_query());

		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Pembimbing','Mahasiswa','NIM','Kelas','Tesis');

			
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1+$offs;
            $id_dosen_pembimbing = 0;
			foreach ($dtjnsoutput->result() as $row) {
            // cek($row);

				$rows = array();
				
				$warna = 'background-color:#FFFFD1;color:#605A01;';
				$mahasiswa = $this->general_model->datagrabs([
                    'tabel' => 'mhs_pembimbing',
                    'where' => [
                        'id_pembimbing' => $row->id_pegawai
                    ]
                ]);

                // cek($row);
				$rows[] = 	array('data'=>$no,'style'=>''.$warna.';text-align:center');
				/*$rows[] = 	$row->kode_Proposal Tesis;*/

                
                if($id_dosen_pembimbing != $row->id_pegawai){
                    $rows[] = array(
                        'data' => $row->nama,
                        'style'=>$warna.'rowspan:'.$mahasiswa->num_rows()
                    );
                    $id_dosen_pembimbing = $row->id_pegawai;
                }
                $data_mahasiswa = $this->general_model->datagrabs([
                    'tabel' => [
                        'peg_pegawai mahasiswa' => '',
                        'ref_program_konsentrasi kelas' => 'mahasiswa.id_konsentrasi = kelas.id_ref_program_konsentrasi'
                    ],
                    'where' => [
                        'id_pegawai' => $mahasiswa->id_mahasiswa
                    ]
                ]);
                
				$rows[] = array(
					'data' => $data_mahasiswa->row('nama'),
					'style'=>$warna);
				$rows[] = array(
					'data' => $data_mahasiswa->row('nim'),
					'style'=>$warna);
                $rows[] = array(
                    'data' => $row->judul_tesis,
                    'style'=>$warna);
                $rows[] = array(
                    'data' =>  $penguji_data,
                    'style'=>$warna);
				// $rows[] = 	array('data'=>(count(@$bc) > 0) ? '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bc).'</li></ul>':null,'style'=>'');

				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_proposal_tesis'=>$row->id_proposal_tesis))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');

					$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_n_pj'=>2)))->num_rows();


					$cek_jdl = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'judul_tesis'=>$row->judul_tesis)))->row();


					if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 1 AND @$cek_jdl->status_n_pj == 2){
						
							if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
						
								$rows[] = 	$ubah;
								
							}else{
								$rows[] = 	'data sudah di non aktifkan';
							}
						
					}else{
						$rows[] = 	$ubah;
					}
					$rows[] =((($cek_jml_akademik==$cek_akademik) OR ($cek_jml_perustakaan==$cek_perustakaan) OR ($cek_jml_keuangan==$cek_keuangan) OR $cek_jml==$cek_jml2) ? '' : $hapus);
				}

				$cek_jdl = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'judul_tesis'=>$row->judul_tesis)))->row();

				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {

					$verifikasi1 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary  btn-flat" act="" title="Verifikasi data..."');

					if($cek_jml==$cek_jml2){
						$rows[] = array('data' => 'SELESAI','style'=>$warna);

						//$rows[] = 'SELESAI';
					}else{
						$rows[] = array('data'=>$cek_jml-$cek_jml2.' belum di verifikasi','style'=>''.$warna.';text-align:center','class'=>'blink_me');
					}
					$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'status_n_pj'=>2)))->num_rows();

					if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 1 AND @$cek_jdl->status_n_pj == 2){
						
							if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
						
								$rows[] = 	$verifikasi1;
								
							}else{
								$rows[] = 	'data sudah di non aktifkan';
							}
						
					}else{
						$rows[] = 	$verifikasi1;
					}


					/*if($cek_pengajuan_judulx > 0){

						$rows[] = 	'data sudah di non aktifkan';
					}else{
						$rows[] = 	$verifikasi1;
					}*/
				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

					$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'status_n_pj'=>2)))->num_rows();

					if($cek_jml_akademik==$cek_akademik AND $cek_jml_perustakaan==$cek_perustakaan  AND $cek_jml_keuangan==$cek_keuangan){
						
						if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 1 AND @$cek_jdl->status_n_pj == 2){

							$verifikasi22 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-list"></i> ubah status', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
						
								if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
							
									$rows[] = 	$verifikasi22;
									
								}else{
									$rows[] = 	'data sudah di non aktifkan';
								}
							
						}else{
							$verifikasi22 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-list"></i> Selesai', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
							$rows[] = 	$verifikasi22;
						}
					}
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		$id_pegawai = $this->session->userdata('id_pegawai');

		$btn_tambah ='';
		$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
		$data['extra_tombol'] = 
				form_open($this->dir.'/list_data','id="form_search" role="form"').
				'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>'.
				form_close();

		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		$title = 'Rekapan Dosen Penguji Tesis';
		
		if ($offset == "cetak") {
			$data['title'] = '<h3>'.$title.'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print',$data);
		} else if ($offset == "excel") {
			$data['file_name'] = $title.'.xls';
			$data['title'] = '<h3>'.$data['title'].'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel',$data);
		} else {
			$data['title'] 		= $title;
			$data['tabel'] = $tabel;
			$data['content'] = 'umum/standard_view';
			$this->load->view('home', $data);
		}
	}
}
?>