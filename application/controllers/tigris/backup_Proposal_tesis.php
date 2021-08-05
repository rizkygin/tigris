<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class proposal_tesis extends CI_Controller {
	var $dir = 'tigris/Proposal_tesis';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
		$this->id_petugas = $id_pegawai;
		if($this->cr('spk1')){
			/*Administrator Sapras*/
			$this->where = array();
		}elseif($this->cr('spk2')){
			/*Verivikastor Data Sekolah*/
			$this->where = array();
		}else{
			$this->where = array();
		}
	}

	function cr($e) {
	    return $this->general_model->check_role($this->id_petugas,$e);
    }

	public function index() {
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Proposal Tesis');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'judul_tesis' 		=> $search_key/*,
				'nama_kegiatan' 		=> $search_key,*/
			);	
			$data['for_search'] = $fcari['judul_tesis'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['judul_tesis'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		}

		$from = array(
			'proposal_tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_program_studi','left')
		);
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
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' =>$from, 'select'=>'*','search' => $fcari,'offset'=>$offs,'where'=>$where))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrabs(array('tabel'=>$from, 'order'=>'id_proposal_tesis ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'where'=>$where,'order'=>'id_proposal_tesis DESC'));

		$id_pegawai = $this->session->userdata('id_pegawai');

		$cek_proposal_tesis = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_mahasiswa'=>$id_pegawai,'status_ps'=>1),'order'=>'id_mahasiswa DESC'))->num_rows();
		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Judul Tesis','Mahasiswa','Program Konsentrasi');

			/*if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){*/
				$heads[] = array('data' => 'Akademik');
				$heads[] = array('data' => 'Perpustkaan');
				$heads[] = array('data' => 'Keuangan');
				$heads[] = array('data' => 'Pimpinan');

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
					$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_proposal_tesis);
				


				$id_pegawai = $this->session->userdata('id_pegawai');

				$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');



				$cek_jml = $this->general_model->datagrab(array('tabel'=>'ref_proposal_tesis','where'=>array('id_bidang'=>@$id_bidang)))->num_rows();


				$cek_jml_akademik = $this->general_model->datagrab(array('tabel'=>'ref_proposal_tesis','where'=>array('id_bidang'=>2)))->num_rows();


				$cek_jml_perustakaan = $this->general_model->datagrab(array('tabel'=>'ref_proposal_tesis','where'=>array('id_bidang'=>3)))->num_rows();


				$cek_jml_keuangan = $this->general_model->datagrab(array('tabel'=>'ref_proposal_tesis','where'=>array('id_bidang'=>4)))->num_rows();


				$cek_jml2 = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>@$id_bidang)))->num_rows();


				$cek_akademik = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>2)))->num_rows();


				$cek_perustakaan = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>3)))->num_rows();


				$cek_keuangan = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>4)))->num_rows();


				$cek_status_ps = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis)))->row();

				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Pengajuan Judul;*/
				$rows[] = 	$row->judul_tesis;
				$rows[] = 	$row->nama;
				$rows[] = 	$row->nama_program_konsentrasi;
				/*if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){*/
					$rows[] = 	((($cek_jml_akademik == $cek_akademik)) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_perustakaan-$cek_perustakaan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_keuangan-$cek_keuangan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_akademik==$cek_akademik) AND ($cek_jml_perustakaan==$cek_perustakaan) AND ($cek_jml_keuangan==$cek_keuangan) AND $cek_jml==$cek_jml2) ? (($cek_status_ps->status_ps != 1)? 'dalam proses' : '<i class="fa fa-check" style="color:blue"></i>') : 'Belum di verifikasi semua bidang');
				
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_proposal_tesis'=>$row->id_proposal_tesis))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					$rows[] = 	$ubah;

					$rows[] =((($cek_jml_akademik==$cek_akademik) OR ($cek_jml_perustakaan==$cek_perustakaan) OR ($cek_jml_keuangan==$cek_keuangan) OR $cek_jml==$cek_jml2) ? '' : $hapus);

						/*
					$rows[] = 	$hapus;*/
				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {



			
			

			
					$verifikasi = anchor('#','<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Verifikasi data..."');
					
					$rows[] = 	((($cek_jml==$cek_jml2)) ? 'sudah diverifikasi' : $cek_jml-$cek_jml2.' belum di verifikasi');
					$rows[] = 	$verifikasi;
				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {



			
			

			
					$verifikasi = anchor('#','<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Verifikasi data..."');
					
					$rows[] = 	((($cek_jml_akademik==$cek_akademik) AND ($cek_jml_perustakaan==$cek_perustakaan) AND ($cek_jml_keuangan==$cek_keuangan) AND $cek_jml==$cek_jml2) ? (($cek_status_ps->status_ps != 1)? 'dalam proses' : 'Selesai') : 'Belum di verifikasi semua bidang');
					if($cek_jml_akademik==$cek_akademik AND $cek_jml_perustakaan==$cek_perustakaan  AND $cek_jml_keuangan==$cek_keuangan){
						
						$rows[] = 	$verifikasi;

					}else{
						

					}
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel = $this->table->generate();
		}else{
			if($cek_proposal_tesis > 0){
				$tabel = '<div class="alert">Data Masih Kosong ... ...</div>';
			}else{
				$tabel = '<div class="alert">Periode ditutup atau Harap Selesaikan <b>PENGAJUAN JUDUL</b> Sebelum Melanjutkan pendaftaran Ujian Proposal Tesis ... ...</div>';

			}
		}
		
		$id_pegawai = $this->session->userdata('id_pegawai');

		$cek_pengajuan_judul = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pj'=>1,'status_tesis'=>1)))->num_rows();
		$cek_pengajuan_judul2 = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pj'=>1,'status_tesis'=>0)))->num_rows();
		$cek_proposal_tesis = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_ps'=>NULL)))->num_rows();
		$cek_proposal_tesis2 = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_ps'=>1)))->num_rows();


		$cek_tanggal = $this->general_model->datagrab(array('tabel'=>'periode_pu','where'=>array('MONTH(start_date)='.date('m')=>null)));
		
		/*cek($cek_pengajuan_judul);
		cek($cek_pengajuan_judul2);*/
		/*$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_ps'=>'0')))->num_rows();
*/
/*
		cek($cek_pengajuan_judul2);
		cek($cek_proposal_tesis);
		cek($cek_proposal_tesis2);*//*
		cek($cek_tanggal->row('start_date'));
		cek($cek_tanggal->row('start_date'));*/
		if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") AND $cek_pengajuan_judul2 > 0 ){
			
			if($cek_tanggal->row('start_date') == NULL AND $cek_tanggal->row('end_date') == NULL){
				$btn_tambah = '';
			}else{
				if(date('Y-m-d') >= $cek_tanggal->row('start_date') AND date('Y-m-d') <= $cek_tanggal->row('end_date') AND $cek_pengajuan_judul2 > 0){
					if($cek_proposal_tesis == 1){

						
					$btn_tambah = '';


						$btn_tambahs = anchor(site_url($this->dir.'/pendaftaran_ujian/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Pendaftaran Ujian Proposal Tesis', 'class="btn btn-success btn-flat" act="" title="Klik untuk tambah data"');
					}else{
					if($cek_proposal_tesis2 == 1){
						if($cek_pengajuan_judul == 1){
							$btn_tambah = anchor(site_url($this->dir.'/pendaftaran_ujian/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Pendaftaran Ujian Proposal Tesis', 'class="btn btn-success btn-flat" act="" title="Klik untuk tambah data"');
						}else{
						$btn_tambah = '';

						}


							$btn_tambahxx = anchor(site_url($this->dir.'/pendaftaran_ujian/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Pendaftaran Ujian Proposal Tesis', 'class="btn btn-success btn-flat" act="" title="Klik untuk tambah data"');
						}else{
						$btn_tambah = '';

						}


					}
					
				}else{
					$btn_tambah = '';
				}
			}
		
				
		
			
		}else{
			$btn_tambah = anchor(site_url($this->dir.'/pendaftaran_ujian/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Pendaftaran Ujian Proposal Tesis', 'class="btn btn-success btn-flat" act="" title="Klik untuk tambah data"');
		
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
		$title = 'Proposal Tesis';
		
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


	function pendaftaran_ujian($id_1=NULL,$id_2=NULL) {
		$id_periode_pu= $id_1;
    	$id_ref_semester= $id_2;
		$id_mahasiswa = $this->session->userdata('id_pegawai');
		$dt = $this->general_model->datagrab(array(
					'tabel' => 'pengajuan_judul',
					'where' => array('id_mahasiswa' => $id_mahasiswa,'status_pj' =>1,'status_tesis' =>0)))->row();

		$param1 =
			array(
				'tabel'=>'proposal_tesis',
				'data' => array(
					'id_mahasiswa'=>$id_mahasiswa,
					'id_pemb_1'=>$dt->id_pemb_1,
					'id_pemb_2'=>$dt->id_pemb_2,
					'id_periode_pu'=>$id_periode_pu,
					'id_ref_semester'=>$id_ref_semester,
					'judul_tesis'=>$dt->judul_tesis,
					'tgl_pt'=>date('Y-m-d'),
					'id_ref_program_konsentrasi'=>$dt->id_ref_program_konsentrasi
					),
			);

			$this->general_model->simpan_data($param1);
			redirect($this->dir);
		}
	function on($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'proposal_tesis',
				'data' => array(
					'status'=>$o['status']
					),
			);

			$param1['where'] = array('id_proposal_tesis'=>$o['id_proposal_tesis']);
			$this->general_model->simpan_data($param1);
			redirect($this->dir);
		}

	function urut($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'proposal_tesis',
				'data' => array(
					'urut'=>$o['no2']
					),
			);

			$param1['where'] = array('id_proposal_tesis'=>$o['id1']);
			$this->general_model->simpan_data($param1);
			/*die();*/



		$param2 =
			array(
				'tabel'=>'proposal_tesis',
				'data' => array(
					'urut'=>$o['no1']
					),
			);

			$param2['where'] = array('id_proposal_tesis'=>$o['id2']);
			 $this->general_model->simpan_data($param2);




		//$this->general_model->save_data('proposal_tesis',array('urut' => $o['no2']),'id_proposal_tesis',$o['id1']);
		//$this->general_model->save_data('proposal_tesis',array('urut' => $o['no1']),'id_proposal_tesis',$o['id2']);
		redirect($this->dir);

	}


    public function add_data($param=NULL,$id_ref_semester=NULL){

    	$o = un_de($param);
    	$id= $o['id_proposal_tesis'];
		$id_periode_pu= $param;
    	$id_ref_semester= $id_ref_semester;
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/proposal_tesis/save_aksi'),

        'id_proposal_tesis' => set_value('id_proposal_tesis'),
		);
       $from = array(
			'proposal_tesis a' => '',
			'peg_pegawai c' => array('c.id_pegawai = a.id_mahasiswa','left'),
			'peg_pegawai d' => array('d.id_pegawai = a.id_pemb_1','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_pemb_2','left'),
			'ref_program_konsentrasi b' => array('c.id_program_studi = b.id_ref_program_konsentrasi','left'),
			'ref_semester f' => array('f.id_ref_semester = a.id_ref_semester','left')
		);
		$select = 'a.*, b.nama_program_konsentrasi,c.id_pegawai,c.nama as x,d.nama as xx,e.nama as xxx,f.*';
		$data['title'] = (!empty($id)) ? 'Ubah Data Proposal Tesis' : 'Proposal Tesis Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'select' => $select,
					'where' => array('a.id_proposal_tesis' => $id)))->row() : null;
       
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_penguji1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_penguji2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_aksi/'.$id.'/'.$id_ref_semester.'/'.$id_periode_pu;
		$data['multi'] = 1;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_proposal_tesis" class="id_proposal_tesis" value="'.$id .'"/>';

		if(!empty($id)){

			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$dt->id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$dt->id_periode_pu .'"/>';
		}else{

			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$id_periode_pu .'"/>';
		}


		$data['form_data'] .= '<input type="hidden" name="judul_tesis" class="judul_tesis" value="'.$dt->judul_tesis .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_ref_program_konsentrasi" class="id_ref_program_konsentrasi" value="'.$dt->id_ref_program_konsentrasi .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<input type="hidden" name="id_pemb_1" class="id_pemb_1" value="'.$dt->id_pemb_1 .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_pemb_2" class="id_pemb_2" value="'.$dt->id_pemb_2 .'"/>';
		$data['form_data'] .= '<div class="col-lg-8">';
			if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {
			
			$data['form_data'] .= '<p><label>Pembimbing 1</label>';
			$data['form_data'] .= form_dropdown('id_penguji_1', $cb_penguji1,@$dt->id_penguji_1,'class="form-control combo-box"  required style="width: 100%"');
			$data['form_data'] .= '<p><label>Pembimbing 2</label>';
			$data['form_data'] .= form_dropdown('id_penguji_2', $cb_penguji2,@$dt->id_penguji_2,'class="form-control combo-box" style="width: 100%"');
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
				<td>Program Konsentrasi</td>
				<td>'.@$dt->nama_program_konsentrasi.'</td>
			</tr>';

			 $from_pem = array(
				'mhs_pembimbing a' => '',
				'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
			);

			$pemb = $this->general_model->datagrab(array(
					'tabel' => $from_pem,
					'where' => array('a.id_pengajuan_judul' => $id)));
			
			$no = 1;$dd = '';
			foreach ($pemb->result() as $xx) {
				$dd.= '<tr>
				<td>Pembimbing '.@$no.'</td>
				<td>'.@$xx->nama.'</td>
			</tr>';
			$no++;
			}
			

			$data['form_data'] .= $dd.'</thead>
			<tbody>
			</tbody>
		</table>

		';
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div class="col-lg-12">';

			$data['form_data'] .= '<br><br><h1>Syarat Ujian Proposal Tesis</h1><hr>';
			

			$from_dt_kom = array(
				'ref_proposal_tesis a' => '',
				'ref_bidang b' => array('a.id_bidang = b.id_bidang','left')
			);
			$dt_kom = $this->general_model->datagrab(array('tabel'=>$from_dt_kom));
			$data['form_data'] .= '<div class="col-lg-12 col-md-12">
						<div class="row">
							<table class="table table-striped table-bordered table-condensed table-nonfluid">
    <thead>
        <tr>
          <th>No </th>
          <th>Nama Syarat</th>
          <th>Keterangan</th>
          <th>di Tujukan ke</th>
          <th>File</th>
        </tr>
    </thead>

    <tbody>
';
			$no = 1;
			foreach ($dt_kom->result() as $kom) {
				$dtnilai = $this->general_model->datagrab(array('tabel'=>'mhs_proposal_tesis','where'=>array('id_proposal_tesis'=>$id, 'id_ref_proposal_tesis'=>$kom->id_ref_proposal_tesis)));


				if(@$kom->wajib_isi != NULL){

					$hapus_field = anchor('#',' x ','class="btn btn-xs btn-danger btn-delete" act="'.site_url($this->dir.'/delete_field/'.in_de(array('id_mhs_proposal_tesis'=>$dtnilai->row('id_mhs_proposal_tesis'),'id_mahasiswa'=>$dt->id_mahasiswa,'id_proposal_tesis'=>$dt->id_proposal_tesis))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');



					if($dtnilai->row('berkas') != NULL){
	          			/*$isi_file = form_upload('berkas['.$kom->id_ref_proposal_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
*/
	          			

	          			$isi_file = '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> '.$hapus_field;
	          			
					}else{
						if($kom->id_ref_tipe_field == 1){
							$isi_file = '';
						}elseif($kom->id_ref_tipe_field == 2){

	          				$isi_file = form_upload('berkas['.$kom->id_ref_proposal_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
						}else{
							if($dtnilai->row('link') == NULL){

	          					$isi_file = form_input('link['.$kom->id_ref_proposal_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="link" style="width:100%"');
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
					$dt_kom_pro = $this->general_model->datagrab(array('tabel'=>'mhs_proposal_tesis', 'where'=>array('id_mhs_proposal_tesis'=>@$p['id_mhs_proposal_tesis'], 'id_ref_proposal_tesis'=>$kom->id_ref_proposal_tesis) ));
					$chk = ($dt_kom_pro->num_rows() > 0) ? 'checked' : '';
				}
				$data['form_data'] .= '
					

							

       
		        <tr>
		          <th style="text-align:left">'.$no.'</th>
		          <th style="text-align:left">'.$kom->nama_syarat.'</th>
		          <th style="text-align:left">'.$kom->keterangan_proposal_tesis.'</th>
		          <th style="text-align:left">'.$kom->nama_bidang.'</th>
		          <th style="text-align:left">
		          <div class="col-lg-12">'.form_hidden('id_berkas[]', $kom->id_ref_proposal_tesis).$isi_file.'</div></th>
		          
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
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		$data['content'] = 'umum/pengajuan_judul_form';
			$this->load->view('home', $data);
    }


    public function verifikasi($param=NULL){
    	$o = un_de($param);
    	$id= $o['id_proposal_tesis'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/proposal_tesis/save_verifikasi'),

        'id_proposal_tesis' => set_value('id_proposal_tesis'),
		);
        $from = array(
			'proposal_tesis a' => '',
			'ref_program_konsentrasi b' => array('a.id_ref_program_konsentrasi = b.id_ref_program_konsentrasi','left'),
			'peg_pegawai c' => array('c.id_pegawai = a.id_mahasiswa','left'),
			'peg_pegawai d' => array('d.id_pegawai = a.id_pemb_1','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_pemb_2','left'),
			'ref_semester f' => array('f.id_ref_semester = c.id_ref_semester','left'),
			'ref_tahun g' => array('g.id_ref_tahun = c.id_ref_tahun','left')
		);
		$select = 'a.*, b.nama_program_konsentrasi,c.id_pegawai,c.nama as x,d.nama as xx,e.nama as xxx,f.nama_semester,g.nama_tahun';
		$data['title'] = 'Verifikasi Proposal Tesis';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,'select' => $select,
					'where' => array('a.id_proposal_tesis' => $id)))->row() : null;
       
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_penguji1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_penguji2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_verifikasi/'.$id;
		$data['multi'] = 1;
		
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_proposal_tesis" class="id_proposal_tesis" value="'.$id .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_pemb_1" class="id_pemb_1" value="'.$dt->id_pemb_1.'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_pemb_2" class="id_pemb_2" value="'.$dt->id_pemb_2 .'"/>';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {
			
			$data['form_data'] .= '<div class="col-lg-5">';
			$data['form_data'] .= '<p><label>Penguji 1</label>';
			$data['form_data'] .= form_dropdown('id_penguji_1', $cb_penguji1,@$dt->id_penguji_1,'class="form-control combo-box"  required style="width: 100%"');
			$data['form_data'] .= '<p><label>penguji 2</label>';
			$data['form_data'] .= form_dropdown('id_penguji_2', $cb_penguji2,@$dt->id_penguji_2,'class="form-control combo-box" style="width: 100%"');
			$data['form_data'] .= '</div>';
		}

			$data['form_data'] .= '<div class="col-lg-7">';
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
			<tr>
				<td>Pembimbing</td>
				<td>'.@$dt->xx.'</td>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		';
		
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div class="col-lg-12">';

			$data['form_data'] .= '<br><br><h1>Syarat Ujian Proposal Tesis</h1><hr>';
			
			$id_pegawai = $this->session->userdata('id_pegawai');

			$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');
			
			$from_q = array(
				'ref_proposal_tesis a' => '',
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

		$data['form_data'] .= '<input type="hidden" name="id_ref_proposal_tesis" class="id_ref_proposal_tesis" value="'.@$kom->id_ref_proposal_tesis .'"/>';
				$dtnilai = $this->general_model->datagrab(array('tabel'=>'mhs_proposal_tesis','where'=>array('id_proposal_tesis'=>$id, 'id_ref_proposal_tesis'=>$kom->id_ref_proposal_tesis)));


				if($kom->wajib_isi != NULL){
					if($dtnilai->row('berkas') != NULL){
	          			/*$isi_file = form_upload('berkas['.$kom->id_ref_proposal_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
*/
	          			$isi_file = '<a target="_blank" href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" >'.$dtnilai->row('berkas').'</a>';
					}else{

	          			$isi_file = form_upload('berkas['.$kom->id_ref_proposal_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
					}
	          	}else{
	          		$isi_file = '';
	          	}





				$chk = NULL;
				$dt_kom_pro = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis', 'where'=>array('id_proposal_tesis'=>$dt->id_proposal_tesis, 'id_ref_proposal_tesis'=>$kom->id_ref_proposal_tesis, 'id_mahasiswa'=>$dt->id_mahasiswa)));
				/*cek($dt->id_proposal_tesis);
				cek($kom->id_ref_proposal_tesis);
				cek($dt->id_mahasiswa);*/
				$chk = ($dt_kom_pro->num_rows() > 0) ? 'checked' : '';
			
				$data['form_data'] .= '
					

							

       
		        <tr>
		          <th style="text-align:left">'.$no.'</th>
		          <th style="text-align:left">'.$kom->nama_syarat.'</th>
		          <th style="text-align:left">'.$kom->keterangan_proposal_tesis.'</th>
		          <th style="text-align:left">'.$kom->nama_bidang.'</th>
		          <th style="text-align:left">
		          <div class="col-lg-12" style="text-align:center;">'.form_hidden('id_ref_proposal_tesis[]', $kom->id_ref_proposal_tesis).$isi_file.'</div></th>';
		         if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

					$data['form_data'] .= '<th style="text-align:left"><i class="fa fa-check"></i></th>';
				}else{

					$data['form_data'] .= '<th style="text-align:left"><input  name="klm[]'.$kom->id_ref_proposal_tesis.'" '.$chk.' type="checkbox" value="'.$kom->id_ref_proposal_tesis.'" class="incheck" style="margin-top: -2px"></th>';
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
		$this->load->view('umum/form_view', $data);
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
    	$id_proposal_tesis = $this->input->post('id_proposal_tesis');
    	$judul_tesis = $this->input->post('judul_tesis',TRUE);
    	$id_ref_program_konsentrasi = $this->input->post('id_ref_program_konsentrasi',TRUE);
    	$keterangan_seminar_penelitian = $this->input->post('keterangan_seminar_penelitian',TRUE);
    	/*$kode_Pengajuan Judul = $this->input->post('kode_Pengajuan Judul');*/
    	$cek_ref_prog = $this->general_model->datagrabs(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>$id_pegawai)))->row();
    	//cek($cek_ref_prog->id_program_studi);
    	$tgl_skrg = date('Y-m-d');
            if(empty($id_proposal_tesis)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'proposal_tesis','where'=>array('judul_tesis'=>$judul_tesis),'select'=>'id_proposal_tesis, MAX(id_proposal_tesis) as id'))->row();
                if(empty($cek_prop->id_proposal_tesis)) {
                	
                	$id_prop = $this->general_model->save_data('proposal_tesis',array('id_mahasiswa' => $id_pegawai,'judul_tesis' => $judul_tesis,'id_ref_semester' => $id_ref_semester,'id_periode_pu' => $id_periode_pu,'tgl_pj' => date('Y-m-d')));
	                


					$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');


	            }else{
	                $id_prop = $cek_prop->id_proposal_tesis ;
	                $this->session->set_flashdata('fail', 'Nama Pengajuan Judul sudah ada...');
	            }
            }else{
            	
            	$par = array(
					'tabel'=>'proposal_tesis',
					'data'=>array(
						'judul_tesis'=>$judul_tesis,
						'id_ref_semester' => $id_ref_semester,
						'id_periode_pu' => $id_periode_pu
						),
					);

					$par['where'] = array('id_proposal_tesis'=>$id_proposal_tesis);

				$sim = $this->general_model->save_data($par);
				// simpan berkas

			/*if(count($_FILES) > 0) $this->general_model->delete_data('mhs_proposal_tesis', 'id_proposal_tesis', $id_proposal_tesis);
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
					'name'=>$mahasiswa->username ."-". $_FILES['berkas']['name'][$value],
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

					$this->general_model->save_data('mhs_proposal_tesis', array(
						'id_proposal_tesis'=>$id_proposal_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_proposal_tesis'=>$value,
						'berkas'=>$data_upload['file_name'],
					));
					
				}
					
					
			}

			foreach ($link as $key => $value) {
				$this->general_model->save_data('mhs_proposal_tesis', array(
						'id_proposal_tesis'=>$id_proposal_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_proposal_tesis'=>$key,
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
		$id_ref_semester = $this->input->post('id_ref_semester');
		$id_periode_pu = $this->input->post('id_periode_pu');
		/*cek($id_periode_pu);
		die();*/
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
						'id_pengajuan_judul' => $id_pengajuan_judul,'id_mahasiswa' => $id_mahasiswa,'id_ref_semester' => $id_ref_semester,'id_periode_pu' => $id_periode_pu)));
				foreach ($pemb as $key => $value) {
					$this->general_model->save_data('mhs_pembimbing', array(
						'id_pengajuan_judul'=>$id_pengajuan_judul,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_semester'=>$id_ref_semester,
						'id_periode_pu'=>$id_periode_pu,
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



    function save_aksis(){

		$config = array(
			'allowed_types' => 'jpg|gif|png|jpeg|JPG|PNG|mp4',
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
		// cek($berkas);die();
		$id_pegawai = $this->session->userdata('id_pegawai');
		$id_mahasiswa = $this->input->post('id_mahasiswa');
		/*cek($_FILES);
		die();*/
		$id_pemb_1 = $this->input->post('id_pemb_1');
		$id_pemb_2 = $this->input->post('id_pemb_2');
    	$id_proposal_tesis = $this->input->post('id_proposal_tesis');
    	$judul_tesis = $this->input->post('judul_tesis',TRUE);
    	$id_ref_program_konsentrasi = $this->input->post('id_ref_program_konsentrasi',TRUE);
    	$keterangan_seminar_penelitian = $this->input->post('keterangan_seminar_penelitian',TRUE);
    	/*$kode_Proposal Tesis = $this->input->post('kode_Proposal Tesis');*/
    	$tgl_skrg = date('Y-m-d');
            if(empty($id_proposal_tesis)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'proposal_tesis','where'=>array('judul_tesis'=>$judul_tesis),'select'=>'id_proposal_tesis, MAX(id_proposal_tesis) as id'))->row();
                if(empty($cek_prop->id_proposal_tesis)) {
                	
                	$id_prop = $this->general_model->save_data('proposal_tesis',array('id_mahasiswa' => $id_pegawai,'id_pemb_1' => $id_pemb_1,'id_pemb_2' => $id_pemb_2,'judul_tesis' => $judul_tesis,'id_ref_program_konsentrasi' => $id_ref_program_konsentrasi));
	                


					$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');


	            }else{
	                $id_prop = $cek_prop->id_proposal_tesis ;
	                $this->session->set_flashdata('fail', 'Nama Proposal Tesis sudah ada...');
	            }
            }else{
            	
            	$par = array(
					'tabel'=>'proposal_tesis',
					'data'=>array(
						'judul_tesis'=>$judul_tesis,
						'id_ref_program_konsentrasi' => $id_ref_program_konsentrasi,
						'id_pemb_1' => $id_pemb_1,
						'id_pemb_2' => $id_pemb_2
						),
					);

					$par['where'] = array('id_proposal_tesis'=>$id_proposal_tesis);

				$sim = $this->general_model->save_data($par);
				// simpan berkas

			/*if(count($_FILES) > 0) $this->general_model->delete_data('mhs_proposal_tesis', 'id_proposal_tesis', $id_proposal_tesis);
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

					$this->general_model->save_data('mhs_proposal_tesis', array(
						'id_proposal_tesis'=>$id_proposal_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_proposal_tesis'=>$value,
						'berkas'=>$data_upload['file_name'],
					));
					
							}
					
					

				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            }
			

			// die();
			
            redirect($this->dir);

    }


}


    function save_verifikasis(){
    	if($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){

			$id_proposal_tesis = $this->input->post('id_proposal_tesis');
			$id_penguji_1 = $this->input->post('id_penguji_1');
			$id_penguji_2 = $this->input->post('id_penguji_2');
			$id_pemb_1 = $this->input->post('id_pemb_1');
			$id_pemb_2 = $this->input->post('id_pemb_2');

			$par = array(
					'tabel'=>'proposal_tesis',
					'data'=>array(
						'id_penguji_1' => $id_penguji_1,
						'id_penguji_2' => $id_penguji_2,
						'id_pemb_1' => $id_pemb_1,
						'id_pemb_2' => $id_pemb_2,
						'status_ps' => 1,
						'tgl' => date('Y-m-d')
						),
					);

					$par['where'] = array('id_proposal_tesis'=>$id_proposal_tesis);

				$sim = $this->general_model->save_data($par);
			$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
    	}else{    		
			$id_pegawai = $this->input->post('id_pegawai');
			$id_mahasiswa = $this->input->post('id_mahasiswa');
			$id_bidang = $this->input->post('id_bidang');
			$id_proposal_tesis = $this->input->post('id_proposal_tesis');
			
			$klm = $this->input->post('klm');
			

			$this->general_model->delete_data(array(
					'tabel' => 'veri_proposal_tesis',
					'where' => array(
						'id_proposal_tesis' => $id_proposal_tesis,'id_mahasiswa' => $id_mahasiswa,'id_bidang' => $id_bidang)));

				foreach ($klm as $key => $value) {
					$this->general_model->save_data('veri_proposal_tesis', array(
						'id_proposal_tesis'=>$id_proposal_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_pegawai'=>$id_pegawai,
						'id_bidang'=>$id_bidang,
						'id_ref_proposal_tesis'=>$value,
						'status'=>1
					));
				}
						

			$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
    	}

		redirect($this->dir.'/list_data');

    }
	function delete_data($code) {
		$sn = un_de($code);
		$id_proposal_tesis = $sn['id_proposal_tesis'];
		$del = $this->general_model->delete_data('proposal_tesis','id_proposal_tesis',$id_proposal_tesis);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}