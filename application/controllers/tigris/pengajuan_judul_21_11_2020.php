<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajuan_judul extends CI_Controller {
	var $dir = 'tigris/Pengajuan_judul';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
	}

	function cr($e) {
	    return $this->general_model->check_role($this->id_petugas,$e);
    }

	public function index() {
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Pengajuan Judul');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'judul_tesis' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['judul_tesis'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['judul_tesis'];
		}

		$from = array(
			'pengajuan_judul a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_program_studi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'));

		}else{
			$where = array();
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

		$dtjnsoutput = $this->general_model->datagrabs(array('tabel'=>$from, 'order'=>'id_pengajuan_judul ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where));


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Judul Tesis','Mahasiswa','Program Konsentrasi');

			/*if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){*/
				$heads[] = array('data' => 'Akademik');
				$heads[] = array('data' => 'Perpustkaan');
				$heads[] = array('data' => 'Keuangan');
				$heads[] = array('data' => 'Pimpinan');

			/*}*/
			if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$heads[] = array('data' => 'Aksi ','colspan' => 2);

			}
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){
				$heads[] = array('data' => ' Verifikasi ','colspan' => 2);
			}else{

			}
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1 + $offset;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/pengajuan_judul/on/'.in_de(array('id_pengajuan_judul' => $row->id_pengajuan_judul,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/pengajuan_judul/on/'.in_de(array('id_pengajuan_judul' => $row->id_pengajuan_judul,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_pengajuan_judul);
				


				$id_pegawai = $this->session->userdata('id_pegawai');

				$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');



				$cek_jml = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>@$id_bidang)))->num_rows();


				$cek_jml_akademik = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>2)))->num_rows();


				$cek_jml_perustakaan = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>3)))->num_rows();


				$cek_jml_keuangan = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>4)))->num_rows();


				$cek_jml2 = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>@$id_bidang)))->num_rows();


				$cek_akademik = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>2)))->num_rows();


				$cek_perustakaan = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>3)))->num_rows();


				$cek_keuangan = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>4)))->num_rows();


				$cek_status_pj = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul)))->row();


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Pengajuan Judul;*/
				$rows[] = 	$row->judul_tesis;
				$rows[] = 	$row->nama;
				$rows[] = 	$row->nama_program_konsentrasi;
				/*if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){*/
					$rows[] = 	((($cek_jml_akademik-$cek_akademik) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_perustakaan-$cek_perustakaan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_keuangan-$cek_keuangan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_akademik==$cek_akademik) AND ($cek_jml_perustakaan==$cek_perustakaan) AND ($cek_jml_keuangan==$cek_keuangan) AND $cek_jml==$cek_jml2) ? (($cek_status_pj->status_pj != 1)? 'dalam proses' : '<i class="fa fa-check" style="color:blue"></i>') : 'Belum di verifikasi semua bidang');
				/*$rows[] = 	((($cek_jml_keuangan-$cek_keuangan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');*/

				// }
				
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_pengajuan_judul'=>$row->id_pengajuan_judul))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					$rows[] = 	$ubah;
					$rows[] =((($cek_jml_akademik==$cek_akademik) OR ($cek_jml_perustakaan==$cek_perustakaan) OR ($cek_jml_keuangan==$cek_keuangan) OR $cek_jml==$cek_jml2) ? '' : $hapus);
				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {



			
			

			
					$verifikasi1 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary  btn-flat" act="" title="Verifikasi data..."');
					
					$rows[] = 	((($cek_jml==$cek_jml2)) ? 'SELESAI' : $cek_jml-$cek_jml2.' belum di verifikasi');
					$rows[] = 	$verifikasi1;
				}

					
					
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {



			
			

			
					$verifikasi2 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
					
					if($cek_jml_akademik==$cek_akademik AND $cek_jml_perustakaan==$cek_perustakaan  AND $cek_jml_keuangan==$cek_keuangan){
						
						$rows[] = 	$verifikasi2;

					}else{
						

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
/*
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama Pengajuan Judul', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		//$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Nama Pengajuan Judul', 'class="btn btn-md btn-success btn-flat"');
		$id_pegawai = $this->session->userdata('id_pegawai');

		$cek_pengajuan_judul = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pj'=>1,'status_tesis'=>1)))->num_rows();
		$cek_pengajuan_judul2 = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_tesis'=>0)))->num_rows();
		$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai)))->num_rows();
		
		$cek_tanggal = $this->general_model->datagrab(array('tabel'=>'periode_pu','where'=>array('MONTH(start_date)='.date('m')=>null)));
		/*cek($cek_tanggal->row('start_date'));
		cek($cek_tanggal->row('end_date'));
		cek($cek_tanggal->row('id_ref_semester'));
		cek($cek_tanggal->row('id_periode_pu'));
		cek($cek_pengajuan_judul);
		cek($cek_pengajuan_judul2);*/
		if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") && $cek_pengajuan_judul == 0){

			if($cek_tanggal->row('start_date') == NULL AND $cek_tanggal->row('end_date') == NULL){
				$btn_tambah = '';
			}else{
				if(date('Y-m-d') >= $cek_tanggal->row('start_date') AND date('Y-m-d') <= $cek_tanggal->row('end_date')){

					
					if($cek_pengajuan_judul2 != 1){

						$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Pengajuan Judul', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')).'" title="Klik untuk tambah data"');
					}else{
						$btn_tambah = '';
					}
				}else{
					$btn_tambah = '';
				}
			}


			/*$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Pengajuan Judul', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/').'" title="Klik untuk tambah data"');*/
		
		}else{
				

				if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") AND date('Y-m-d') >= $cek_tanggal->row('start_date') AND date('Y-m-d') <= $cek_tanggal->row('end_date')){

					if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") AND $cek_pengajuan_judul2 != 1){

						$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Pengajuan Judul', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')).'" title="Klik untuk tambah data"');
					}else{
						$btn_tambah = '';
					}
				}else{
					$btn_tambah = '';
				}
		
		}
		
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
		$title = 'Pengajuan Judul';
		
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


	function on($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'pengajuan_judul',
				'data' => array(
					'status'=>$o['status']
					),
			);

			$param1['where'] = array('id_pengajuan_judul'=>$o['id_pengajuan_judul']);
			$this->general_model->simpan_data($param1);
			redirect($this->dir);
		}

	function urut($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'pengajuan_judul',
				'data' => array(
					'urut'=>$o['no2']
					),
			);

			$param1['where'] = array('id_pengajuan_judul'=>$o['id1']);
			$this->general_model->simpan_data($param1);
			/*die();*/



		$param2 =
			array(
				'tabel'=>'pengajuan_judul',
				'data' => array(
					'urut'=>$o['no1']
					),
			);

			$param2['where'] = array('id_pengajuan_judul'=>$o['id2']);
			 $this->general_model->simpan_data($param2);




		//$this->general_model->save_data('pengajuan_judul',array('urut' => $o['no2']),'id_pengajuan_judul',$o['id1']);
		//$this->general_model->save_data('pengajuan_judul',array('urut' => $o['no1']),'id_pengajuan_judul',$o['id2']);
		redirect($this->dir);

	}


    public function add_data($param=NULL,$id_ref_semester=NULL){
    	$o = un_de($param);
    	$id= $o['id_pengajuan_judul'];
    	$id_periode_pu= $param;
    	$id_ref_semester= $id_ref_semester;
    	/*cek($param);*/
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/pengajuan_judul/save_aksi'),

        'id_pengajuan_judul' => set_value('id_pengajuan_judul'),
		);
        $from = array(
			'pengajuan_judul a' => '',
			'ref_program_konsentrasi b' => array('a.id_ref_program_konsentrasi = b.id_ref_program_konsentrasi','left'),
			'peg_pegawai c' => array('c.id_pegawai = a.id_pembimbing_1','left'),
			'peg_pegawai d' => array('c.id_pegawai = a.id_pembimbing_2','left')
		);
		$data['title'] = (!empty($id)) ? 'Ubah Data Pengajuan Judul' : 'Pengajuan Judul Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'where' => array('a.id_pengajuan_judul' => $id)))->row() : null;
       
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_pembimbing1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_pembimbing2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_aksi/'.$id.'/'.$id_ref_semester.'/'.$id_periode_pu;
		$data['multi'] = 1;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_pengajuan_judul" class="id_pengajuan_judul" value="'.$id .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$id_ref_semester .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$id_periode_pu .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Judul Tesis</label>';
			$data['form_data'] .= form_textarea('judul_tesis', @$dt->judul_tesis,'class="form-control" placeholder="Judul Tesis" required');
			
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div class="col-lg-6">';
			if(!empty($id)){
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div class="col-lg-12">';

			$data['form_data'] .= '<br><br><h1>Syarat Pengajuan Judul</h1><hr>';
			

			 $from_dt_kom = array(
				'ref_pengajuan_judul a' => '',
				'ref_bidang b' => array('a.id_bidang = b.id_bidang','left')
			);
			$dt_kom = $this->general_model->datagrab(array('tabel'=>$from_dt_kom));
			$data['form_data'] .= '<div class="col-lg-12 col-md-12">
						<div class="row">
							<table class="table table-striped table-bordered table-condensed table-nonfluid">
    <thead>
        <tr>
          <th>No </th>
          <th width="40%">Nama Syarat</th>
          <th width="20%">Keterangan</th>
          <th>di Tujukan ke</th>
          <th>File</th>
        </tr>
    </thead>

    <tbody>
';
			$no = 1;
			foreach ($dt_kom->result() as $kom) {
				$dtnilai = $this->general_model->datagrab(array('tabel'=>'mhs_pengajuan_judul','where'=>array('id_pengajuan_judul'=>$id, 'id_ref_pengajuan_judul'=>$kom->id_ref_pengajuan_judul)));
				/*cek($kom->wajib_isi_mhs);
				die();*/
				if($kom->wajib_isi_mhs != NULL){

					$hapus_field = anchor('#',' x ','class="btn btn-xs btn-danger btn-delete" act="'.site_url($this->dir.'/delete_field/'.in_de(array('id_mhs_pengajuan_judul'=>$dtnilai->row('id_mhs_pengajuan_judul'),'id_mahasiswa'=>$dt->id_mahasiswa,'id_pengajuan_judul'=>$dt->id_pengajuan_judul))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');



					if($dtnilai->row('berkas') != NULL){
	          			/*$isi_file = form_upload('berkas['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
*/
	          			

	          			$isi_file = '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> '.$hapus_field;
	          			
					}else{
						if($kom->id_ref_tipe_field == 1){
							$isi_file = '';
						}elseif($kom->id_ref_tipe_field == 2){

	          				$isi_file = form_upload('berkas['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
						}else{
							if($dtnilai->row('link') == NULL){

	          					$isi_file = form_input('link['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="link" style="width:100%"');
		          			}else{
		          				$xx = str_replace("http://","",$dtnilai->row('link'));
		          			$isi_file = '<a href="https://'.$xx.'" class="fancybox" target="_blank">'.$dtnilai->row('link').'</a> '.$hapus_field;
		          			}


	          				
						}
					}
	          	}else{
	          		$isi_file = '';
	          	}


/*
		$id_unit = $this->session->userdata('id_unit');
cek($id_unit);*/
				$chk = NULL;
				if($id!=NULL){
					$dt_kom_pro = $this->general_model->datagrab(array('tabel'=>'mhs_pengajuan_judul', 'where'=>array('id_mhs_pengajuan_judul'=>@$p['id_mhs_pengajuan_judul'], 'id_ref_pengajuan_judul'=>$kom->id_ref_pengajuan_judul) ));
					$chk = ($dt_kom_pro->num_rows() > 0) ? 'checked' : '';
				}
				$data['form_data'] .= '
					

							

       
		        <tr>
		          <th style="text-align:left">'.$no.'</th>
		          <th style="text-align:left">'.$kom->nama_syarat.'</th>
		          <th style="text-align:left">'.$kom->keterangan_pengajuan_judul.'</th>
		          <th style="text-align:left">'.$kom->nama_bidang.'</th>
		          <th style="text-align:left">
		          <div class="col-lg-12">'.form_hidden('id_berkas[]', $kom->id_ref_pengajuan_judul).$isi_file.'</div></th>
		          
		        </tr>



						';
					$no++;
			}


				$data['form_data'] .= form_hidden('id_mahasiswa',@$o['id_mahasiswa']);

			$data['form_data'] .= '
    </tbody>
</table>
</div>
					</div>';
		}
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';

			$data['content'] = 'umum/pengajuan_judul_form';
			$this->load->view('home', $data);


		//$this->load->view('umum/form_view', $data);
    }


    public function verifikasi($param=NULL){
    	$o = un_de($param);
    	$id= $o['id_pengajuan_judul'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/pengajuan_judul/save_verifikasi'),

        'id_pengajuan_judul' => set_value('id_pengajuan_judul'),
		);
        $from = array(
			'pengajuan_judul a' => '',
			'ref_program_konsentrasi b' => array('a.id_ref_program_konsentrasi = b.id_ref_program_konsentrasi','left'),
			'peg_pegawai c' => array('c.id_pegawai = a.id_mahasiswa','left'),
			'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing_1','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_pembimbing_2','left'),
			'ref_semester f' => array('f.id_ref_semester = c.id_ref_semester','left'),
			'ref_tahun g' => array('g.id_ref_tahun = c.id_ref_tahun','left')
		);
		$select = 'a.*, b.nama_program_konsentrasi,c.id_pegawai,c.nama as x,d.nama as xx,e.nama as xxx,f.nama_semester,g.nama_tahun';
		$data['title'] = 'Verifikasi Pengajuan Judul';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,'select' => $select,
					'where' => array('a.id_pengajuan_judul' => $id)))->row() : null;
       
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_pembimbing1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_pembimbing2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_verifikasi/'.$id;
		$data['multi'] = 1;
		
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_pengajuan_judul" class="id_pengajuan_judul" value="'.$id .'"/>';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {
			
			$dt_pegawai = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_tipe'=>2)));

			$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Pembimbing</label>';
			foreach ($dt_pegawai->result() as $kom) {

			$data['form_data'] .= '<div class="col-lg-12">';
			$chk_pem = NULL;
				$dt_mhs = $this->general_model->datagrab(array('tabel'=>'mhs_pembimbing', 'where'=>array('id_pengajuan_judul'=>$dt->id_pengajuan_judul, 'id_pembimbing'=>$kom->id_pegawai, 'id_mahasiswa'=>$dt->id_mahasiswa)));
				
				$jumlah_mhs = $this->general_model->datagrab(array('tabel'=>'mhs_pembimbing','select'=>'count(id_mahasiswa) as x', 'where'=>array('id_pembimbing'=>$kom->id_pegawai)))->row();

				$chk_pem = ($dt_mhs->num_rows() > 0) ? 'checked' : '';
					
				$data['form_data'] .= '<input  name="pemb[]'.$kom->id_pegawai.'" '.$chk_pem.' type="checkbox" value="'.$kom->id_pegawai.'" class="incheck" style="margin-top: -2px"> '.$kom->nama.' (<b>'.@$jumlah_mhs->x.'</b>)';
				$data['form_data'] .= '</div>';
			}
			/*$data['form_data'] .= '<p><label>Pembimbing 1</label>';
			$data['form_data'] .= form_dropdown('id_pemb_1', $cb_pembimbing1,@$dt->id_pemb_1,'class="form-control combo-box"  required style="width: 100%"');
			$data['form_data'] .= '<p><label>Pembimbing 2</label>';
			$data['form_data'] .= form_dropdown('id_pemb_2', $cb_pembimbing2,@$dt->id_pemb_2,'class="form-control combo-box" style="width: 100%"');*/
			$data['form_data'] .= '</div>';
		}

		$data['form_data'] .= '
		<table class="table table-striped table-bordered table-condensed table-nonfluid">
			<thead>
			<tr>
				<td>Judul Tesis</td>
				<td>'.@$dt->judul_tesis.'</td>
			</tr>
			<tr>
				<td>Mahasiswa</td>
				<td>'.@$dt->x.'</td>
			</tr>
			
			<tr>
				<td>Semester</td>
				<td>'.@$dt->nama_semester.'</td>
			</tr>
			<tr>
				<td>Tahun</td>
				<td>'.@$dt->nama_tahun.'</td>
			</tr>
			<tr>
				<td>Program Konsentrasi</td>
				<td>'.@$dt->nama_program_konsentrasi.'</td>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		';
		
		$data['form_data'] .= '<div class="col-lg-12">';

			$data['form_data'] .= '<br><br><h1>Syarat Pengajuan Judul</h1><hr>';
			
			$id_pegawai = $this->session->userdata('id_pegawai');

			$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');
			
			$from_q = array(
				'ref_pengajuan_judul a' => '',
				'ref_bidang b' => array('a.id_bidang = b.id_bidang','left')
			);
			if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

				$dt_kom = $this->general_model->datagrab(array('tabel'=>$from_q));
			}else{

				$dt_kom = $this->general_model->datagrab(array('tabel'=>$from_q,'where'=>array('b.id_bidang'=>@$id_bidang)));
			}
			$data['form_data'] .= '<input type="hidden" name="id_pegawai" class="id_pegawai" value="'.$id_pegawai .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_bidang" class="id_bidang" value="'.$id_bidang .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_mahasiswa" class="id_mahasiswa" value="'.$dt->id_mahasiswa .'"/>';
			$data['form_data'] .= '<div class="col-lg-12 col-md-12">
						<div class="row">
							<table class="table table-striped table-bordered table-condensed table-nonfluid">
    <thead>
        <tr>
          <th>No </th>
          <th>Nama Syarat</th>
          <th>keterangan</th>
          <th>di Tujukan</th>
          <th>File</th>
          <th>Verifikasi</th>
        </tr>
    </thead>

    <tbody>
';
$no = 1;
			foreach ($dt_kom->result() as $kom) {
				$dtnilai = $this->general_model->datagrab(array('tabel'=>'mhs_pengajuan_judul','where'=>array('id_pengajuan_judul'=>$id, 'id_ref_pengajuan_judul'=>$kom->id_ref_pengajuan_judul)));
				/*cek($kom->wajib_isi_mhs);
				die();*/
				$hapus_field = anchor('#',' x ','class="btn btn-xs btn-danger btn-delete" act="'.site_url($this->dir.'/delete_field_ver/'.in_de(array('id_mhs_pengajuan_judul'=>$dtnilai->row('id_mhs_pengajuan_judul'),'id_mahasiswa'=>$dt->id_mahasiswa,'id_pengajuan_judul'=>$dt->id_pengajuan_judul))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');

				if($kom->wajib_isi_mhs != NULL){

					


					if($dtnilai->row('berkas') != NULL){
	          			/*$isi_file = form_upload('berkas['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
*/
	          			

	          			$isi_file = '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> '.$hapus_field;
	          			
					}else{
						if($kom->id_ref_tipe_field == 1){
							$isi_file = '';
						}elseif($kom->id_ref_tipe_field == 2){

	          				$isi_file = form_upload('berkas['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
						}else{
							if($dtnilai->row('link') == NULL){

	          					$isi_file = form_input('link['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="link" style="width:100%"');
		          			}else{
		          				$xx = str_replace("http://","",$dtnilai->row('link'));
		          			$isi_file = '<a href="https://'.$xx.'" class="fancybox" target="_blank">'.$dtnilai->row('link').'</a> '.$hapus_field;
		          			}


	          				
						}
					}
	          	}else{
	          		if($kom->id_ref_tipe_field == 1){
							$isi_file = '';
						}elseif($kom->id_ref_tipe_field == 2){
							if($dtnilai->row('berkas') == NULL){

	          					$isi_file = form_upload('berkas['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
		          			}else{
		          				$isi_file = '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> '.$hapus_field;
		          			}
						}else{
							if($dtnilai->row('link') == NULL){

	          					$isi_file = form_input('link['.$kom->id_ref_pengajuan_judul.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="link" style="width:100%"');
		          			}else{
		          				$xx = str_replace("http://","",$dtnilai->row('link'));
		          			$isi_file = '<a href="https://'.$xx.'" class="fancybox" target="_blank">'.$dtnilai->row('link').'</a> '.$hapus_field;
		          			}


	          				
						}
	          	}





				$chk = NULL;
				$dt_kom_pro = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul', 'where'=>array('id_pengajuan_judul'=>$dt->id_pengajuan_judul, 'id_ref_pengajuan_judul'=>$kom->id_ref_pengajuan_judul, 'id_mahasiswa'=>$dt->id_mahasiswa)));
				/*cek($dt->id_pengajuan_judul);
				cek($kom->id_ref_pengajuan_judul);
				cek($dt->id_mahasiswa);*/
				$chk = ($dt_kom_pro->num_rows() > 0) ? 'checked' : '';
			
				$data['form_data'] .= '
					

							

       
		        <tr>
		          <th style="text-align:left">'.$no.'</th>
		          <th style="text-align:left">'.$kom->nama_syarat.'</th>
		          <th style="text-align:left">'.$kom->keterangan_pengajuan_judul.'</th>
		          <th style="text-align:left">'.$kom->nama_bidang.'</th>
		            <th style="text-align:left">
		          <div class="col-lg-12">'.form_hidden('id_berkas[]', $kom->id_ref_pengajuan_judul).$isi_file.'</div></th>
		          
		          ';
		         if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

					$data['form_data'] .= '<th style="text-align:left"><i class="fa fa-check"></i></th>';
				}else{

					$data['form_data'] .= '<th style="text-align:left"><input  name="klm[]'.$kom->id_ref_pengajuan_judul.'" '.$chk.' type="checkbox" value="'.$kom->id_ref_pengajuan_judul.'" class="incheck" style="margin-top: -2px"></th>';
				}

		          
		          
		     $data['form_data'] .= '</tr>';
					$no++;
			}


				$data['form_data'] .= form_hidden('id_mahasiswa',@$o['id_mahasiswa']);

			$data['form_data'] .= '
    </tbody>
</table>
</div>
					</div>';
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		
			$data['content'] = 'umum/pengajuan_judul_form';
			$this->load->view('home', $data);
    }


    function save_aksi(){

		$config = array(
			'allowed_types' => 'jpg|gif|png|jpeg|JPG|PNG|mp4|pdf',
			'upload_path' => 'uploads',
			'overwrite' => TRUE,
		);
		
    	$this->load->library('upload');
		// $CI->load->helper('file');
		$this->upload->initialize($config);
		$this->upload->do_upload('tes');

			// $this->upload->do_upload('tes');
					// $data_upload = $this->upload->data();
					// cek($data_upload);

    	// // $fi = $_FILES['tes'];
    	// // cek($fi);
    	// die();
		// $in = $this->input->post();

    	$id_ref_semester = $this->input->post('id_ref_semester');
    	$id_periode_pu = $this->input->post('id_periode_pu');
    	
    	/*die();*/
		$berkas = [$this->input->post('id_berkas')];
		$link = $this->input->post('link');
/*cek($link);
die();*/

		// cek($berkas);die();
		$id_pegawai = $this->session->userdata('id_pegawai');
		$id_mahasiswa = $this->input->post('id_mahasiswa');
		/*cek($_FILES);
		die();*/
		$id_pembimbing_1 = $this->input->post('id_pembimbing_1');
		$id_pembimbing_2 = $this->input->post('id_pembimbing_2');
    	$id_pengajuan_judul = $this->input->post('id_pengajuan_judul');
    	$judul_tesis = $this->input->post('judul_tesis',TRUE);
    	$id_ref_program_konsentrasi = $this->input->post('id_ref_program_konsentrasi',TRUE);
    	$keterangan_seminar_penelitian = $this->input->post('keterangan_seminar_penelitian',TRUE);
    	/*$kode_Pengajuan Judul = $this->input->post('kode_Pengajuan Judul');*/
    	$cek_ref_prog = $this->general_model->datagrabs(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>$id_pegawai)))->row();
    	//cek($cek_ref_prog->id_program_studi);
    	$tgl_skrg = date('Y-m-d');
            if(empty($id_pengajuan_judul)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'pengajuan_judul','where'=>array('judul_tesis'=>$judul_tesis),'select'=>'id_pengajuan_judul, MAX(id_pengajuan_judul) as id'))->row();
                if(empty($cek_prop->id_pengajuan_judul)) {
                	
                	$id_prop = $this->general_model->save_data('pengajuan_judul',array('id_mahasiswa' => $id_pegawai,'judul_tesis' => $judul_tesis,'id_ref_semester' => $id_ref_semester,'id_periode_pu' => $id_periode_pu,'tgl_pj' => date('Y-m-d')));
	                


					$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');


	            }else{
	                $id_prop = $cek_prop->id_pengajuan_judul ;
	                $this->session->set_flashdata('fail', 'Nama Pengajuan Judul sudah ada...');
	            }
            }else{
            	
            	$par = array(
					'tabel'=>'pengajuan_judul',
					'data'=>array(
						'judul_tesis'=>$judul_tesis,
						'id_ref_semester' => $id_ref_semester,
						'id_periode_pu' => $id_periode_pu
						),
					);

					$par['where'] = array('id_pengajuan_judul'=>$id_pengajuan_judul);

				$sim = $this->general_model->save_data($par);
				// simpan berkas

			/*if(count($_FILES) > 0) $this->general_model->delete_data('mhs_pengajuan_judul', 'id_pengajuan_judul', $id_pengajuan_judul);
				*/
			// cek($berkas);
			// die();


			
			//cek($_FILES['berkas']);
			foreach ($berkas as $key => $value) {
				# code...
				// cek($value);
				// cek($key);
				// cek($value);
				if(isset($_FILES['berkas']['name'][$value]))
					$_FILES['file'] = array(
					'name'=>$_FILES['berkas']['name'][$value],
					'type'=>$_FILES['berkas']['type'][$value],
					'tmp_name'=>$_FILES['berkas']['tmp_name'][$value],
					'error'=>$_FILES['berkas']['error'][$value],
					'size'=>$_FILES['berkas']['size'][$value],
				);
				else $_FILES['file'] = array();

				// cek($_FILES['file']);

				if(@$_FILES['file']['size'] > 0) {
					$this->upload->do_upload('file');
					$data_upload = $this->upload->data();
					// cek($data_upload);

					$this->general_model->save_data('mhs_pengajuan_judul', array(
						'id_pengajuan_judul'=>$id_pengajuan_judul,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_pengajuan_judul'=>$value,
						'berkas'=>$data_upload['file_name'],
					));
					
				}
					
					
			}

			foreach ($link as $key => $value) {
				$this->general_model->save_data('mhs_pengajuan_judul', array(
						'id_pengajuan_judul'=>$id_pengajuan_judul,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_pengajuan_judul'=>$key,
						'link'=>$value,
					));
			}
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            
			

			// die();
			
           

    }


            redirect($this->dir);
}


    function save_verifikasi(){
    		$config = array(
			'allowed_types' => 'jpg|gif|png|jpeg|JPG|PNG|mp4|pdf',
			'upload_path' => 'uploads',
			'overwrite' => TRUE,
		);
		
    	$this->load->library('upload');
		// $CI->load->helper('file');
		$this->upload->initialize($config);
		$this->upload->do_upload('tes');

			// $this->upload->do_upload('tes');
					// $data_upload = $this->upload->data();
					// cek($data_upload);

    	// // $fi = $_FILES['tes'];
    	// // cek($fi);
    	// die();
		// $in = $this->input->post();


		$berkas = $this->input->post('id_berkas');
		$link = $this->input->post('link');
		

		$id_pegawai = $this->input->post('id_pegawai');
		$id_mahasiswa = $this->input->post('id_mahasiswa');
		$id_bidang = $this->input->post('id_bidang');
		$id_pengajuan_judul = $this->input->post('id_pengajuan_judul');
		$klm = $this->input->post('klm');
		$pemb = $this->input->post('pemb');
    	if($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){

			$id_pengajuan_judul = $this->input->post('id_pengajuan_judul');
			$id_pemb_1 = $this->input->post('id_pemb_1');
			$id_pemb_2 = $this->input->post('id_pemb_2');

			$this->general_model->delete_data(array(
					'tabel' => 'mhs_pembimbing',
					'where' => array(
						'id_pengajuan_judul' => $id_pengajuan_judul,'id_mahasiswa' => $id_mahasiswa)));
				foreach ($pemb as $key => $value) {
					$this->general_model->save_data('mhs_pembimbing', array(
						'id_pengajuan_judul'=>$id_pengajuan_judul,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_pembimbing'=>$value
					));
				}
						



			$par = array(
					'tabel'=>'pengajuan_judul',
					'data'=>array(
						'id_pemb_1' => $id_pemb_1,
						'id_pemb_2' => $id_pemb_2,
						'status_pj' => 1
						),
					);

					$par['where'] = array('id_pengajuan_judul'=>$id_pengajuan_judul);

				$sim = $this->general_model->save_data($par);
			$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
    	}else{


    			 	
			
			/*
			cek($klm);
			die();*/


			
			
			//cek($_FILES['berkas']);
			foreach ($berkas as $key => $value) {
				# code...
				// cek($value);
				// cek($key);
				// cek($value);
				if(isset($_FILES['berkas']['name'][$value]))
					$_FILES['file'] = array(
					'name'=>$_FILES['berkas']['name'][$value],
					'type'=>$_FILES['berkas']['type'][$value],
					'tmp_name'=>$_FILES['berkas']['tmp_name'][$value],
					'error'=>$_FILES['berkas']['error'][$value],
					'size'=>$_FILES['berkas']['size'][$value],
				);
				else $_FILES['file'] = array();

				// cek($_FILES['file']);

				if(@$_FILES['file']['size'] > 0) {
					$this->upload->do_upload('file');
					$data_upload = $this->upload->data();
					// cek($data_upload);

					$this->general_model->save_data('mhs_pengajuan_judul', array(
						'id_pengajuan_judul'=>$id_pengajuan_judul,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_pengajuan_judul'=>$value,
						'berkas'=>$data_upload['file_name'],
					));
					
				}
					
					
			}

			foreach ($link as $key => $value) {
				$this->general_model->save_data('mhs_pengajuan_judul', array(
						'id_pengajuan_judul'=>$id_pengajuan_judul,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_pengajuan_judul'=>$key,
						'link'=>$value,
					));
			}
            
			

            $klm = $this->input->post('klm');
			

			$this->general_model->delete_data(array(
					'tabel' => 'veri_pengajuan_judul',
					'where' => array(
						'id_pengajuan_judul' => $id_pengajuan_judul,'id_mahasiswa' => $id_mahasiswa,'id_bidang' => $id_bidang)));

				foreach ($klm as $key => $value) {
					$this->general_model->save_data('veri_pengajuan_judul', array(
						'id_pengajuan_judul'=>$id_pengajuan_judul,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_pegawai'=>$id_pegawai,
						'id_bidang'=>$id_bidang,
						'id_ref_pengajuan_judul'=>$value,
						'status'=>1
					));
				}

				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
			
    	}

		redirect($this->dir);

    }
	function delete_data($code) {
		$sn = un_de($code);
		$id_pengajuan_judul = $sn['id_pengajuan_judul'];
		$del = $this->general_model->delete_data('pengajuan_judul','id_pengajuan_judul',$id_pengajuan_judul);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
	function delete_field($code) {
		$sn = un_de($code);
		$id_mhs_pengajuan_judul = $sn['id_mhs_pengajuan_judul'];
		$id_mahasiswa = $sn['id_mahasiswa'];
		$id_pengajuan_judul = $sn['id_pengajuan_judul'];
		/*cek($id_mhs_pengajuan_judul);
		cek($id_mahasiswa);
		cek($id_pengajuan_judul);
		die();*/
		$del = $this->general_model->delete_data('mhs_pengajuan_judul','id_mhs_pengajuan_judul',$id_mhs_pengajuan_judul);
		if ($del) {
			$this->session->set_flashdata('ok','Data Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Data Gagal di Hapus');
		}
		redirect($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_pengajuan_judul'=>$id_pengajuan_judul)));
	}
	function delete_field_ver($code) {
		$sn = un_de($code);
		$id_mhs_pengajuan_judul = $sn['id_mhs_pengajuan_judul'];
		$id_mahasiswa = $sn['id_mahasiswa'];
		$id_pengajuan_judul = $sn['id_pengajuan_judul'];
		/*cek($id_mhs_pengajuan_judul);
		cek($id_mahasiswa);
		cek($id_pengajuan_judul);
		die();*/
		$del = $this->general_model->delete_data('mhs_pengajuan_judul','id_mhs_pengajuan_judul',$id_mhs_pengajuan_judul);
		if ($del) {
			$this->session->set_flashdata('ok','Data Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Data Gagal di Hapus');
		}
		redirect($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_pengajuan_judul'=>$id_pengajuan_judul)));
	}
}