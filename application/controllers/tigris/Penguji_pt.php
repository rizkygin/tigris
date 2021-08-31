<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penguji_pt extends CI_Controller{
    var $dir = 'tigris/Penguji_pt';
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
    public function list_data($search=NULL, $offset=NULL,$periode=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Penguji Proposal Tesis');

		if($periode == NULL){
			$periode = $this->input->post('periode_pu');
		}
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
			'mhs_penguji a' => '',
			// 'peg_pegawai dosen' => array('a.id_pembimbing = dosen.id_pegawai','left'),
			'peg_pegawai mahasiswa' => array('a.id_mahasiswa = mahasiswa.id_pegawai','left'),
			'ref_program_konsentrasi kelas' => array('mahasiswa.id_konsentrasi = kelas.id_ref_program_konsentrasi','left'),
            'proposal_tesis proposal_tesis' => array('proposal_tesis.id_proposal_tesis = a.id_pendaftaran_ujian','left') 
            
		);
		$select = 'distinct mahasiswa.*,mahasiswa.nama as nama_mahasiswa,mahasiswa.username as nim,kelas.nama_program_konsentrasi,proposal_tesis.*';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'));

		}else{
			$where = array(
                'status_peng' => 1,
				'tipe_ujian' => 1,
				'a.id_periode_pu' => $periode
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

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>$from, 'order'=>'proposal_tesis.id_proposal_tesis ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where,'order'=>'proposal_tesis.id_proposal_tesis DESC'));

        // cek($this->db->last_query());

		//milih periode
		if(!empty($periode)){
			if ($dtjnsoutput->num_rows() > 0) {
				$heads = array('No','Mahasiswa','NIM','Kelas','Judul Proposal Tesis','Penguji');
	
				
				$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
				$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
				$this->table->set_heading($heads);
	
				$m = 0;
				$no = 1+$offs;
				foreach ($dtjnsoutput->result() as $row) {
				// cek($row);
	
					$rows = array();
					if($row->status == 1){
						$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
					}else{
						$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');
	
					}
					
					if($row->status_pt != 1){
						$warna = 'background-color:#800000;color:white;';
	
					}else{
						$warna = '';
					}
					
	
					// cek($row);
					$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
					/*$rows[] = 	$row->kode_Proposal Tesis;*/
					$rows[] = array(
						'data' => $row->nama_mahasiswa,
						'style' => $warna
						);
					$rows[] = array(
						'data' => $row->nim,
					'style' => $warna	
					);
					$rows[] = array(
						'data' => $row->nama_program_konsentrasi,
					'style' => $warna	
					);
					$rows[] = array(
						'data' => $row->judul_tesis,
					'style' => $warna    
					);
					// tinggal dosen
					$pengujis = $this->general_model->datagrabs([
						'tabel' => 'mhs_penguji',
						'where' => [
							'id_mahasiswa' => $row->id_pegawai,
							'tipe_ujian' => 1
						]
					])->result();
					// cek($this->db->last_query());
					$penguji_data = '';
					foreach($pengujis as $penguji){
						// $rows[] = array(
						//     'data' => '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',$penguji->nama).'</li></ul>',
						//     'style'=>$warna);
						$dosen = $this->general_model->datagrabs([
							'tabel' => 'peg_pegawai',
							'where' => [
								'id_pegawai' => $penguji->id_pembimbing
							]
						])->row('nama');
						if($dosen != null){
							$penguji_data .= '<ul style="margin: 0;padding: 2px 15px"><li>'.@$dosen.'</li></ul>';
	
						}
						// $penguji_data .= $penguji->nama;
						// cek(1);
					}
					$rows[] = array(
						'data' =>  $penguji_data,
						'style' => $warna
					);
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
			$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/cetak/'.$periode,'<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/excel/'.$periode,'<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
			
			$data['tombol'] = $btn_cetak;
		}else{
			$cb_periode_pu = $this->general_model->combo_box(
				array(
				'tabel'=>[
					'periode_pu pu' => '',
					'ref_semester semester' => 'pu.id_ref_semester = semester.id_ref_semester'
				],
				'key'=>'id_periode_pu',
				'val'=>array(
					'bulan',
					'nama_semester'
				)
			));

			$data['tombol'] = 
			form_open($this->dir.'/list_data','id="form_pilih"').
				form_dropdown('periode_pu', $cb_periode_pu,'','id="periode_pu" class="form-control combo-box" style="width: 100%"').
			form_close();
			$data['script'] = '
			$(document).ready(function() {
				$("select").select2();
				$("#periode_pu").change(function() {
					$("#form_pilih").submit();
				});

			});
			';
			$tabel = '<div class="alert">Pilih Periode</div>';
		}
		
		
		$id_pegawai = $this->session->userdata('id_pegawai');
		
		//edit judul
		if(empty($periode)){
			$title = 'Rekapan Dosen Penguji Proposal Tesis';
		}
		if(!empty($periode)){
			$nama_periode = $this->general_model->datagrabs([
				'tabel'=>[
					'periode_pu pu' => '',
					'ref_semester semester' => 'pu.id_ref_semester = semester.id_ref_semester'
				],
				'where' => [
					'id_periode_pu' => $periode
				]
			])->row();
			// cek($this->db->last_query());
			// cek($nama_periode->bulan);
			// die();
			$title = 'Rekapan Dosen Penguji Proposal Tesis Bulan ' . $nama_periode->bulan . ' Semester ' .$nama_periode->nama_semester;
		}

		
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