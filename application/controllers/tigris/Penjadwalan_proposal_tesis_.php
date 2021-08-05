<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjadwalan_proposal_tesis extends CI_Controller {
	var $dir = 'tigris/Penjadwalan_proposal_tesis';
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
		$data['breadcrumb'] = array($this->dir => 'Penjadwalan Proposal Tesis');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'judul_tesis' 		=> $search_key,
				'nama_program_konsentrasi' 		=> $search_key,
				'nama_mahasiswa' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['judul_tesis'];
			$data['for_search'] = $fcari['nama_program_konsentrasi'];
			$data['for_search'] = $fcari['nama_mahasiswa'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['judul_tesis'];
			$data['for_search'] = $fcari['nama_program_konsentrasi'];
			$data['for_search'] = $fcari['nama_mahasiswa'];
		}

		$from = array(
			'proposal_tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_penguji_1','left'),
			'peg_pegawai f' => array('f.id_pegawai = a.id_penguji_1','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_program_studi','left')
		);
		$select = 'a.*,b.nama as nama_mahasiswa,b.id_pegawai,e.nama as xx,f.nama as xxx,c.nama_program_konsentrasi';
		$where = array('a.status_pt'=>1,'a.status_n_pt'=>1);
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrabs(array('tabel' =>$from, 'select'=>$select,'search' => $fcari,'offset'=>$offs,'where'=>$where))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrabs(array('tabel'=>$from, 'order'=>'id_proposal_tesis ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari, 'select'=>$select,'where'=>$where));


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No');
				$heads[] = array('data' => 'Mahasiswa');
				$heads[] = array('data' => 'Judul Tesis','style'=>'width:200px');
				$heads[] = array('data' => 'Pembimbing');
				$heads[] = array('data' => 'Penguji');
				$heads[] = array('data' => 'Tgl Ujian dan Jam');
				$heads[] = array('data' => 'Ruang');
				$heads[] = array('data' => 'Berita Acara Ujian');
				/*$heads[] = array('data' => 'Undangan Ujian');*/
				$heads[] = array('data' => 'Aksi');



			if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){
				$heads[] = array('data' => 'Akademik');
				$heads[] = array('data' => 'Perpustkaan');
				$heads[] = array('data' => 'Keuangan');

			}
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
				/*if($row->status == 1){
					$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}*/
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


				$cek_status_pt = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis)))->row();

				$ubah_jadwal = anchor(site_url($this->dir.'/ubah_jadwal/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-info"></i>', 'class="btn btn-xs btn-primary btn btn-flat" act="" title="Tambah Jadwal Ujian..."');
				$tambah_jadwal = anchor('#','<i class="fa fa-calendar"></i>', 'class="btn btn-xs btn-primary btn-edit btn-flat" act="'.site_url($this->dir.'/tambah_jadwal/'.in_de(array('id_jadwal_ujian'=>@$row->id_jadwal_ujian,'id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Tambah Jadwal Ujian..."');
				$berita_acara = anchor(site_url($this->dir.'/berita_acara/'.in_de(array('id_jadwal_ujian'=>@$row->id_jadwal_ujian,'id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-file-pdf-o"></i>', 'class="btn btn-xs btn-success btn-flat" act=" title="berita acara..." target="_blank"');
				$undangan = anchor(site_url($this->dir.'/undangan/'.in_de(array('id_jadwal_ujian'=>@$row->id_jadwal_ujian,'id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-file-pdf-o"></i>', 'class="btn btn-xs btn-warning btn-flat" act=" title="undangan..." target="_blank"');




				$cek_jadwal = $this->general_model->datagrab(array('tabel'=>'jadwal_ujian','where'=>array('id_ujian'=>@$row->id_proposal_tesis,'tipe_ujian'=>1)))->num_rows();


				$cek_data_jadwal = $this->general_model->datagrab(array('tabel'=>'jadwal_ujian','where'=>array('id_ujian'=>@$row->id_proposal_tesis,'tipe_ujian'=>1)))->row();

				$cek_periode = $this->general_model->datagrab(array('tabel'=>'periode_pu','where'=>array('MONTH(start_date)='.date('m')=>null)));
				/*$from_pem = array(
					'mhs_penguji a' => '',
					'proposal_tesis c' => array('c.id_proposal_tesis = a.id_pendaftaran_ujian','left'),
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);
				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pendaftaran_ujian'=>$row->id_proposal_tesis,'a.id_mahasiswa'=>$row->id_mahasiswa)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $xx) {
					$bc[]= 'Penguji '.@$nox.' : <p>'.@$xx->nama.'<p>';
				$nox++;
				}

*/



				$cek_judul_tesis = $this->general_model->datagrab(array(
						'tabel' => 'pengajuan_judul',
						'where' => array('judul_tesis' => $row->judul_tesis)))->row();

		
		 		$from_pem = array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pengajuan_judul' => $cek_judul_tesis->id_pengajuan_judul)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $xx) {
					$bc[]= 'Pembimbing '.@$nox.' : <p>'.@$xx->nama.'<p>';
				$nox++;
				}



				$cek_judul_peng = $this->general_model->datagrab(array(
						'tabel' => 'proposal_tesis',
						'where' => array('judul_tesis' => $row->judul_tesis)))->row();

		
		 		$from_peng = array(
					'mhs_penguji a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$peng = $this->general_model->datagrab(array(
						'tabel' => $from_peng,
						'where' => array('a.id_pendaftaran_ujian' => $cek_judul_peng->id_proposal_tesis,'a.tipe_ujian' => 1)));
				//cek($peng->num_rows());
				$noxx=1;
				$bx=array();
				foreach ($peng->result() as $xx) {
					$bx[]= 'Penguji '.@$noxx.' : <p>'.@$xx->nama.'<p>';
				$noxx++;
				}
				
				if(@$cek_data_jadwal->ket == NULL){
					$warna = 'background-color:#9DF495;color:#0C5106;';
				}else{
					switch(@$cek_data_jadwal->ket) {
						case '1' : $warna = 'background-color:#FFFFD1;color:#605A01;';
						break;
						case '2' : $warna = 'background-color:#eee;color:#222;';
						break;
					}
				}


				//cek(count(@$bx));
				$rows[] = 	array('data'=>$no,'style'=>''.@$warna.';text-align:center');
				/*$rows[] = 	$row->kode_Pengajuan Judul;*/
				$rows[] = array(
					'data' => $row->nama_mahasiswa,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->judul_tesis,
					'style'=>$warna);
				if(count(@$bc) > 0){
					$rows[] = 	array('data'=>(count(@$bc) > 0) ? '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bc).'</li></ul>':null,'style'=>$warna);
				}else{

					$rows[] ='';
				}
				if(count(@$bx) > 0){

					$rows[] = 	array('data'=>(count(@$bx) > 0) ? '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bx).'</li></ul>':null,'style'=>$warna);
				}else{

					$rows[] ='';
				}
				//cek($cek_jadwal);
				$rows[] = 	(($cek_jadwal > 0)?konversi_tanggal('j',substr($cek_data_jadwal->tgl_mulai,0,10)).' '.konversi_tanggal('M',substr($cek_data_jadwal->tgl_mulai,0,10)).' '.konversi_tanggal('Y',substr($cek_data_jadwal->tgl_mulai,0,10)).' jam '.konversi_tanggal('H',substr($cek_data_jadwal->tgl_mulai,11,19)).':'.konversi_tanggal('i',substr($cek_data_jadwal->tgl_mulai,11,19)).'<br> s/d <br>'.konversi_tanggal('j',substr($cek_data_jadwal->tgl_selesai,0,10)).' '.konversi_tanggal('M',substr($cek_data_jadwal->tgl_selesai,0,10)).' '.konversi_tanggal('Y',substr($cek_data_jadwal->tgl_selesai,0,10)).' jam '.konversi_tanggal('H',substr($cek_data_jadwal->tgl_selesai,11,19)).':'.konversi_tanggal('i',substr($cek_data_jadwal->tgl_selesai,11,19)):'');
				$rows[] = 	(($cek_jadwal > 0)?@$cek_data_jadwal->ruang:'');
				$rows[] = 	array('data'=>(($cek_jadwal > 0)?@$berita_acara:''),'style'=>'text-align:center');;
				/*$rows[] = 	(($cek_jadwal > 0)?@$undangan:'');*/
				$rows[] = 	(($cek_jadwal > 0)?@$ubah_jadwal:@$tambah_jadwal);
				if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){
					$rows[] = 	((($cek_jml_akademik-$cek_akademik) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_perustakaan-$cek_perustakaan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_keuangan-$cek_keuangan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');

				}
				
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Edit Data..."');
					$ubah = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Edit Data..."');
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_proposal_tesis'=>$row->id_proposal_tesis))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					$rows[] = 	$ubah;
					$rows[] = 	$hapus;
				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {



			
			

			
					$verifikasi = anchor('#','<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Verifikasi data..."');
					
					$rows[] = 	((($cek_jml==$cek_jml2)) ? 'sudah diverifikasi' : $cek_jml-$cek_jml2.' belum di verifikasi');
					$rows[] = 	$verifikasi;
				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {



			
			

			
					$verifikasi = anchor('#','<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Verifikasi data..."');
					
					$rows[] = 	((($cek_jml_akademik==$cek_akademik) AND ($cek_jml_perustakaan==$cek_perustakaan) AND ($cek_jml_keuangan==$cek_keuangan) AND $cek_jml==$cek_jml2) ? (($cek_status_pt->status_pt != 1)? 'dalam proses' : 'Selesai') : 'Belum di verifikasi semua bidang');
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
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
/*
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama Penjadwalan Proposal Tesis', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		//$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Nama Penjadwalan Proposal Tesis', 'class="btn btn-md btn-success btn-flat"');
		$id_pegawai = $this->session->userdata('id_pegawai');

		$cek_proposal_tesis = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pt'=>0)))->num_rows();


			$btn_tambah = '';
		
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
		$title = 'Penjadwalan Proposal Tesis';
		
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



	function ubah_jadwal($param=NULL){

    	$o = un_de($param);
    	$id_mahasiswa= $o['id_mahasiswa'];
    	$id_proposal_tesis= $o['id_proposal_tesis'];

		/*	cek($id_mahasiswa);
			cek($id_proposal_tesis);
			die();*/
			$this->general_model->delete_data(array(
					'tabel' => 'jadwal_ujian',
					'where' => array(
						'id_mahasiswa' => $id_mahasiswa,'id_ujian' => $id_proposal_tesis,'tipe_ujian' =>1)));


			redirect($this->dir);
		}

	function pendaftaran_ujian() {
		$id_mahasiswa = $this->session->userdata('id_pegawai');
		$dt = $this->general_model->datagrab(array(
					'tabel' => 'proposal_tesis',
					'where' => array('id_mahasiswa' => $id_mahasiswa,'status_tesis' =>0)))->row();

		$param1 =
			array(
				'tabel'=>'proposal_tesis',
				'data' => array(
					'id_mahasiswa'=>$id_mahasiswa,
					'id_pemb_1'=>$dt->id_pemb_1,
					'id_pemb_2'=>$dt->id_pemb_2,
					'judul_tesis'=>$dt->judul_tesis,
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


    public function tambah_jadwal($param=NULL){

    	$o = un_de($param);
    	$id_jadwal_ujian= $o['id_jadwal_ujian'];
    	$id_mahasiswa= $o['id_mahasiswa'];
    	$id= $o['id_proposal_tesis'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/proposal_tesis/save_aksi'),

        'id_proposal_tesis' => set_value('id_proposal_tesis'),
		);
       $from = array(
			'proposal_tesis a' =>'',
			'peg_pegawai c' => array('c.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi b' => array('c.id_program_studi = b.id_ref_program_konsentrasi','left'),
			'peg_pegawai d' => array('d.id_pegawai = a.id_pemb_1','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_pemb_2','left'),
			'peg_pegawai f' => array('f.id_pegawai = a.id_penguji_1','left'),
			'peg_pegawai g' => array('g.id_pegawai = a.id_penguji_2','left')
		);
		$select = 'a.*, b.nama_program_konsentrasi,c.id_pegawai,c.nama as x,d.nama as xx,e.nama as xxx,f.nama as xxxx,g.nama as xxxxx';
		$data['title'] = (!empty($id)) ? 'Ubah Data Penjadwalan Proposal Tesis' : 'Penjadwalan Proposal Tesis Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'select' => $select,
					'where' => array('a.id_proposal_tesis' => $id)))->row() : null;
       	$dt_row = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => 'jadwal_ujian',
					'where' => array('id_ujian' => $id,'tipe_ujian' => 1)))->row() : null;
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_penguji1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_penguji2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_aksi/'.$id;
		$data['multi'] = 1;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_jadwal_ujian" class="id_jadwal_ujian" value="'.$id_jadwal_ujian .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_proposal_tesis" class="id_proposal_tesis" value="'.$id .'"/>';
		$data['form_data'] .= '<input type="hidden" name="judul_tesis" class="judul_tesis" value="'.@$dt->judul_tesis .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_ref_program_konsentrasi" class="id_ref_program_konsentrasi" value="'.@$dt->id_ref_program_konsentrasi .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<input type="hidden" name="id_pemb_1" class="id_pemb_1" value="'.@$dt->id_pemb_1 .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_pemb_2" class="id_pemb_2" value="'.@$dt->id_pemb_2 .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_penguji_1" class="id_penguji_1" value="'.@$dt->id_penguji_1 .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_penguji_2" class="id_penguji_2" value="'.@$dt->id_penguji_2 .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_mahasiswa" class="id_mahasiswa" value="'.@$dt->id_mahasiswa .'"/>';
				

				$cek_judul_tesis = $this->general_model->datagrab(array(
						'tabel' => 'pengajuan_judul',
						'where' => array('judul_tesis' => $dt->judul_tesis)))->row();

		
		 		$from_pem = array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pengajuan_judul' => $cek_judul_tesis->id_pengajuan_judul)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $xx) {
					$bc[]= 'Pembimbing '.@$nox.' : <p>'.@$xx->nama.'<p> <input type="hidden" value="'.$xx->id_pembimbing.'" name="id_pembimbing[]">';
				$nox++;
				}



				$cek_judul_peng = $this->general_model->datagrab(array(
						'tabel' => 'proposal_tesis',
						'where' => array('judul_tesis' => $dt->judul_tesis)))->row();

		
		 		$from_peng = array(
					'mhs_penguji a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$peng = $this->general_model->datagrab(array(
						'tabel' => $from_peng,
						'where' => array('a.id_pendaftaran_ujian' => $cek_judul_peng->id_proposal_tesis,'a.tipe_ujian' => 1)));
				//cek($peng->num_rows());
				$noxx=1;
				$bx=array();
				foreach ($peng->result() as $xx) {
					$bx[]= 'Penguji '.@$noxx.' : <p>'.@$xx->nama.'<p> <input type="hidden" value="'.$xx->id_pembimbing.'" name="id_penguji[]">';
				$noxx++;
				}
				
		$data['form_data'] .= '<div class="col-lg-6">';
		

		$data['form_data'] .= '
		<table class="table table-striped table-bordered table-condensed">
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
			</tr>
			<tr>
				<td>Pembimbing </td>
				<td><ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bc).'</li></ul></td>
			</tr>
			<tr>
				<td>Penguji </td>
				<td><ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bx).'</li></ul></td>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		';
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div class="col-lg-6">';
		$data['form_data'] .= '<div class="col-lg-12">';
		$data['form_data'] .= '<h1 style="padding:0;margin:0px">Jadwal Ujian Proposal Tesis</h1><hr>';
			
			$data['form_data'] .= '<p><label>Tgl/Jam Mulai</label>';
			$data['form_data'] .= form_input('tgl_mulai', !empty(@$dt_row->tgl_mulai)?@$dt_row->tgl_mulai:null,'class="form-control" id="tgl_mulai" placeholder="tanggal mulai" required');


			$data['form_data'] .= '<p><label>Tgl/Jam Selesai</label>';
			$data['form_data'] .= form_input('tgl_selesai', !empty(@$dt_row->tgl_selesai)?@$dt_row->tgl_selesai:null,'class="form-control" id="tgl_selesai" placeholder="tanggal selesai" required');


			$data['form_data'] .= '<p><label>Gedung/Ruang</label>';
			$data['form_data'] .= form_input('ruang', !empty(@$dt_row->ruang)?@$dt_row->ruang:null,'class="form-control" placeholder="Ruang Ujian" required');



			$data['form_data'] .= '<p><label>Status</label><p>';
			$data['form_data'] .= '<label>
                      <input type="radio" value="1" name="ket" class="flat-blue" '.((!empty($dt_row) and $dt_row->ket == "1") ? 'checked' : '').' /> <i>Berjalan</i> 
                    </label>&nbsp;  &nbsp;  &nbsp;';
			$data['form_data'] .= '<label>
                      <input type="radio" value="2" name="ket" class="flat-blue" '.((!empty($dt_row) and $dt_row->ket == "2") ? 'checked' : '').' /> <i>Selesai</i>
                    </label>';
			
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		$data['script'] = '$("#tgl_mulai").datetimepicker();$("#tgl_selesai").datetimepicker();initMce();';

		$this->load->view('umum/form_view', $data);
    }



    function save_aksi(){

    		$id_proposal_tesis = $this->input->post('id_proposal_tesis');
			$id_jadwal_ujian = $this->input->post('id_jadwal_ujian');
			$judul_tesis = $this->input->post('judul_tesis');
			$id_penguji_1 = $this->input->post('id_penguji_1');
			$id_penguji_2 = $this->input->post('id_penguji_2');
			$id_pemb_1 = $this->input->post('id_pemb_1');
			$id_pemb_2 = $this->input->post('id_pemb_2');
			$id_mahasiswa = $this->input->post('id_mahasiswa');
			$ruang = $this->input->post('ruang');
			$ket = $this->input->post('ket');
			


			$tgl_mulai = $this->input->post('tgl_mulai');
			$tgl_selesai = $this->input->post('tgl_selesai');
			

			$tanggal = $this->general_model->datagrab(array(
					'tabel' => 'jadwal_ujian',
					'where' => array('tgl_mulai BETWEEN "'.$tgl_mulai.'" AND "'.$tgl_selesai.'" OR tgl_selesai BETWEEN "'.$tgl_mulai.'" AND "'.$tgl_selesai.'"'=>NULL)));
/*cek();*/
			$bz=array();
			foreach ($tanggal->result() as $xx) {
				$bz[$xx->id_dosen]= $xx->id_dosen;
			}


			
	 		$from_tanggal = array(
				'jadwal_ujian a' => '',
				'peg_pegawai d' => array('d.id_pegawai = a.id_dosen','left')
			);

			$tanggalxx = $this->general_model->datagrab(array(
					'tabel' => $from_tanggal,
					'where' => array('(tgl_mulai >="'.$tgl_mulai.'" AND tgl_selesai <="'.$tgl_selesai.'") AND tgl_mulai BETWEEN "'.$tgl_mulai.'" AND "'.$tgl_selesai.'" OR tgl_selesai BETWEEN "'.$tgl_mulai.'" AND "'.$tgl_selesai.'"'=>NULL)));
			$tanggalx = $this->general_model->datagrab(array(
					'tabel' => 'peg_pegawai'));

			


			//cek($peng->num_rows())
			$bzx=array();
			foreach ($tanggalx->result() as $xx) {
				$bzx[$xx->nama]= $xx->id_pegawai;
			}


			


    		
    		$id_pembimbing = $this->input->post('id_pembimbing');
    		$id_penguji = $this->input->post('id_penguji');



    		$pp = array_keys(array_intersect($bzx, $id_pembimbing));
    		$xx = array_keys(array_intersect($bzx, $id_penguji));


    		//cek($tanggal->num_rows());
    		//cek($pp);
    		//cek($xx);
    		//cek(array_intersect($id_pembimbing, $bz));
    		//cek(array_intersect($id_penguji, $bz));

    		//cek($tanggal->num_rows());
    		//cek($tanggalx->num_rows());
    		//cek($id_pembimbing);
    		//cek($id_penguji);
    		//cek($bz);
    		/*cek(array_intersect($id_pembimbing, $bz));
    		cek(array_intersect($id_penguji, $bz));
    		cek(array($id_pembimbing,$id_penguji));
    		if(($id_pembimbing AND $id_penguji) == $bz ){
    			$dd= 'sama';
    		}else{

    			$dd= 'beda';
    		}
    		cek($dd);
			die();
*/
    		if(array_intersect($id_pembimbing, $bz)) {
    			/*if($tanggal->num_rows() == 0){

					$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
	    			
    			}else{*/
    				$this->session->set_flashdata('fail', 'Pembimbing <ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$pp).'</li></ul> Sudah ada di tanggal dan Jam ini');

					$cekss = 'Pembimbing Sudah ada di tanggal dan Jam ini';
    			/*}*/
			}else{
				if(array_intersect($id_penguji, $bz)) {
					$this->session->set_flashdata('fail', 'Penguji <ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$xx).'</li></ul> Sudah ada di tanggal dan Jam ini');
				}else{
					foreach ($id_pembimbing as $key => $value) {
						$this->general_model->save_data('jadwal_ujian', array(
							'id_mahasiswa' => $id_mahasiswa,
							'nama_judul' => $judul_tesis,
							'id_ujian' => $id_proposal_tesis,
							'tipe_ujian' => 1,
							'tgl_mulai' => $tgl_mulai,
							'tgl_selesai' => $tgl_selesai,
							'ruang' => $ruang,
							'ket' => $ket,	
							'id_dosen'=>$value
						));
					}
					foreach ($id_penguji as $key => $value) {
						$this->general_model->save_data('jadwal_ujian', array(
							'id_mahasiswa' => $id_mahasiswa,
							'nama_judul' => $judul_tesis,
							'id_ujian' => $id_proposal_tesis,
							'tipe_ujian' => 1,
							'tgl_mulai' => $tgl_mulai,
							'tgl_selesai' => $tgl_selesai,
							'ruang' => $ruang,
							'ket' => $ket,	
							'id_dosen'=>$value
						));
					}
				}/*
				$cekss = 'Tidak ada Pembimbing';*/

			}
			
    	
			//cek($cekss);
			//cek(array_intersect($bz, $bzx));

    		//cek($id_pembimbing);
    		/*
    		cek($bzx);
    		cek($id_penguji);
    		cek(array_intersect($id_penguji, $bzx));
    		cek(array_keys(array_intersect($bzx, $id_penguji)));*/
    		/*cek(array_intersect($id_penguji, $bzx));
    		cek(array_intersect($bz, $bzx));*/
				//die();
				//cek($bc);
    		//cek($id_pembimbing);

				//cek($bx);

    		//$result = !empty(array_intersect($people, $criminals));


    		/*c
    		cek($id_penguji);*/




/*cek($tgl_mulai);
die();*/
		/*	$dt =  $this->general_model->datagrab(array(
					'tabel' => 'jadwal_ujian',
					'select' => 'id_mahasiswa,id_ujian',
					'where' => array('id_mahasiswa' => $id_mahasiswa,'id_ujian' => $id_proposal_tesis,'tipe_ujian'=>1)));
			$par = array(
					'tabel'=>'jadwal_ujian',
					'data'=>array(
						'id_mahasiswa' => $id_mahasiswa,
						'nama_judul' => $judul_tesis,
						'id_ujian' => $id_proposal_tesis,
						'tipe_ujian' => 1,
						'id_penguji_1' => $id_penguji_1,
						'id_penguji_2' => $id_penguji_2,
						'id_pemb_1' => $id_pemb_1,
						'id_pemb_2' => $id_pemb_2,
						'tgl_mulai' => $tgl_mulai,
						'ruang' => $ruang,
						'ket' => $ket
						),
					);

					if($dt->num_rows() > 0) $par['where'] = array('id_mahasiswa'=>$id_mahasiswa,'id_ujian'=>$id_proposal_tesis,'tipe_ujian'=>1);
*/
				//$sim = $this->general_model->save_data($par);

				/*$id = $this->db->insert_id();

				foreach ($id_pembimbing as $key => $value) {
					$this->general_model->save_data('jadwal_pembimbing', array(
						'id_proposal_tesis'=>$id_proposal_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_pegawai'=>$id_pegawai,
						'id_bidang'=>$id_bidang,
						//'id_ref_proposal_tesis'=>$value,
						'status'=>1,
						'status_ver'=>$value
					));
				}*/
			//$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
    	

		redirect($this->dir.'/list_data');

    }

    function save_verifikasi(){
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
						'status_pt' => 1,
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


    function berita_acara($param=NULL) {
        $o=un_de($param);
        //cek($p);
    	$id_jadwal_ujian= $o['id_jadwal_ujian'];
    	$id_mahasiswa= $o['id_mahasiswa'];
    	$id= $o['id_proposal_tesis'];
        /*die();*/
        $offset = !empty($offset) ? $offset : null;
        //$pengajar = $this->input->post('pengajar');
        $st = get_stationer();
         
        $data['h_title_left'] = '
        <div class="col-lg-5" style="padding: 10px 0px 0px 0px;">

        <img src="'.base_url()."uploads/logo/logo_yes.png".'" style="height: 40px;float:left; margin-right:10px;"/>

        <h5 style="font-size: 24px;border-top:3px solid #4271B7;border-bottom:3px solid #4271B7;float:left;color:#4271B7;margin-top:5px;"><b>YOGYA EXECUTIVE SCHOOL "YES"</b></h5>
                </div>
        ';
        $data['h_title_right'] = '
        
        ';
        $data['h_sub_center'] = '';
        $data['tgl_cetak'] = date('d-M-Y');
        $data['company_address'] = '<div class="col-lg-6"  style="padding: 10px 0px 0px 0px;">

        <div style="text-align:right;color: #4271B7;margin-top:-20px;">
        <h6 style="font-size:10px;">Jl. Taman Siswa No. 89 Telp/Fax. (0274) 376 623 Yogyakarta 55151<br>
        Website : www.yesjogja.com<br>E-mail : info@yesjogja.com, info_yes@yahoo.co.id</h6></div>';
        $data['company_country'] = 'City-Country';
        /*$data['company_logo'] = base_url('assets/logo/brand.png');*/

        // **** BEDO SAMBUNGAN
        // $start = 0;
        // $anjab_alat = $this->general_model->datagrabs(array(
        //     'tabel'=>'catatan', 
        //     'select'=>'*'));
        // $data = array(
        //     'h_title_left'=> 'pesis',
        //     'h_title_center'=> '<span>Laporan</span><br/> Data ',
        //     'h_sub_center'=> '',
        //     'tgl_cetak'=> date('d-M-Y'),
        //     'company_address'=>'Company Address',        
        //     'company_country'=>'City-Country',        
        //     'company_logo'=>base_url('assets/logo/brand.png'),        
        //    // 'company_logo'=>$logo_instansi      
        //     );



         ini_set('memory_limit', '512M');
       // $html = $this->load->view('anjab_alat_pdf', $data, true);
        $html = $this->load->view('tigris/pdf', $data, true);
        $this->load->library('fpdf/fpdf');
        /*die();*/



         $from = array(
			'jadwal_ujian d' => '',
			'proposal_tesis a' => array('a.id_proposal_tesis = d.id_ujian','left'),
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'peg_pegawai g' => array('g.id_pegawai = a.id_pemb_1','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_penguji_1','left'),
			'peg_pegawai f' => array('f.id_pegawai = a.id_penguji_1','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_program_studi','left')
		);
		$select = 'd.*,a.*,b.nama as nama_mahasiswa,b.nip,e.nama as penguji_1,f.nama as penguji_2,g.nama as pemb_1,c.nama_program_konsentrasi';
          $dt_row = $this->general_model->datagrab(array('tabel'=>$from,'select'=>$select,'offset'=>$offset,'where'=>array('d.id_ujian'=>$id)))->row();
         

         $data['title']      = 'berita_acara'.@$dt_row->kode;
         $data['no_uji']         = @$dt_row->kode;




        $parameters= array(
                'mode' => 'utf-8',
                'format' => 'A4-L',    // A4 for portrait
                'default_font_size' => '12',
                'default_font' => '',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 40,
                'margin_bottom' => 30,
                'margin_header' => 20,
                'margin_footer' => 10,
                'orientation' => 'L' // For some reason setting orientation to "L" alone doesn't work (it should), you need to also set format to "A4-L" for landscape
            );
        $tabelx = '
        <table>
        <tr>
        <tr>
        </table>


        ';
        //$pdf = $this->fpdf->load($parameters);
        // setting
        $pdf = new FPDF('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','B',50);


         //$pdf->Image(base_url()."assets/logo/brand.png",10,6,60,0);
    // Times bold 15
       
    // Move to the right
        $pdf->Cell(60);

    // Line break
        // logo
        $pdf->SetLineWidth(1);



        $pdf->SetFont('Times','',16.4);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
         $pdf->Image('assets/images/corp/beritalogo.png',60,40,100,0);


        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Pada hari ini,    '.konversi_tanggal('D',substr($dt_row->tgl_mulai,0,10)).'  tanggal    '.konversi_tanggal('j',substr($dt_row->tgl_mulai,0,10)).'   Bulan    '.konversi_tanggal('M',substr($dt_row->tgl_mulai,0,10)).'  Tahun    '.konversi_tanggal('Y',substr($dt_row->tgl_mulai,0,10)).'    telah dilaksanakan');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Ujian REVIEW PROPOSAL TESIS, untuk Mahasiswa :');



        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(35);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Nama                : ');
        $pdf->SetX(64);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(210,8,''.$dt_row->nama_mahasiswa.'');



        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(35);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'NIM                  : ');
        $pdf->SetX(64);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(200,8,''.$dt_row->nip.'');



        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(35);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Bidang Kajian  : ');
        $pdf->SetX(64);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(200,8,''.$dt_row->nama_program_konsentrasi.'');


        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(35);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Judul Tesis       : ');
        $pdf->SetX(64);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(120,8,''.$dt_row->judul_tesis.'');

        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(35);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Para Reviewer terdiri dari      : ');
        $pdf->SetX(64);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(120,8,'');


       

				$cek_judul_tesis = $this->general_model->datagrab(array(
						'tabel' => 'pengajuan_judul',
						'where' => array('judul_tesis' => $dt_row->judul_tesis)))->row();

		
		 		$from_pem = array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pengajuan_judul' => $cek_judul_tesis->id_pengajuan_judul)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $xx) {
					$bc[]= '<tr><td width="370" height="60" bgcolor="#D0D0FF">'.$xx->nama.'</td>';
					$bc[].= '<td width="150" height="60" bgcolor="#D0D0FF">Pembimbing</td>';
					$bc[].= '<td width="150" height="60" bgcolor="#D0D0FF">.............................</td></tr>';
				$nox++;
				}



				$cek_judul_peng = $this->general_model->datagrab(array(
						'tabel' => 'proposal_tesis',
						'where' => array('judul_tesis' => $dt_row->judul_tesis)))->row();

		
		 		$from_peng = array(
					'mhs_penguji a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$peng = $this->general_model->datagrab(array(
						'tabel' => $from_peng,
						'where' => array('a.id_pendaftaran_ujian' => $cek_judul_peng->id_proposal_tesis,'a.tipe_ujian' => 1)));
				//cek($peng->num_rows());
				$noxx=1;
				$bx=array();
				foreach ($peng->result() as $xx) {
					$bx[]= '<tr><td width="370" height="60" bgcolor="#D0D0FF">'.$xx->nama.'</td>';
					$bx[].= '<td width="150" height="60" bgcolor="#D0D0FF">Anggota</td>';
					$bx[].= '<td width="150" height="60" bgcolor="#D0D0FF">.............................</td></tr>';
				$noxx++;
				}
				

        $html='<table border="1">
<tr>
<td width="370" height="40" bgcolor="#D0D0FF">Nama Penguji</td>
<td width="150" height="40" bgcolor="#D0D0FF">Jabatan</td>
<td width="150" height="40" bgcolor="#D0D0FF">Tanda Tangan</td>
</tr>		
'.implode(@$bc).''.implode(@$bx).'
</table>'; 
$pdf->SetLeftMargin(26);
$pdf->WriteHTML($html);

        $pdf->Ln(5);
        $pdf->SetFont('Times','',12);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->MultiCell(170,8,'Setelah mengadakan review atas proposal dari mahasiswa yang bersangkutan para Reviewer memberikan masukan untuk kesempurnaan proposal tersebut sebagaimana dalam lampiran.');
        $pdf->Ln(0);
        $pdf->SetFont('Times','',12);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->MultiCell(170,8,'Demikian berita acara ini dibuat dengan sebenar-benarnya dan dapat digunakan sebagaimana mestinya : ');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'Semarang, '.tanggal_indo(date("Y-m-d")).'');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'Mengetahui');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'Ketua Program Studi MIH');




        $pdf->SetFont('Times','',12);
        $pdf->Ln(30);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'Dr. Joko Setiyono, S.H., M.Hum');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'NIP. 19660607 199203 1 001');


        $pdf->Ln(20);
         $htmlx= '';

$pdf->SetLeftMargin(26);
$pdf->WriteHTML($htmlx);


//penguji
		 		$from_peng = array(
					'mhs_penguji a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$peng = $this->general_model->datagrab(array(
						'tabel' => $from_peng,
						'where' => array('a.id_pendaftaran_ujian' => $cek_judul_peng->id_proposal_tesis,'a.tipe_ujian' => 1)));
				//cek($peng->num_rows());

				$noxx=1;
				$bx=array();
				foreach ($peng->result() as $xx) {
					$bx[]= 
		$pdf->SetFont('Times','',16.4);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(59);
        // $pdf->Image(base_url()."assets/images/corp/beritalogo.png",60,40,100,0);
        $pdf->Image('assets/images/corp/lampiran-masukkan-proposal.png',60,NULL,100,0);


        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Nama                : ');
        $pdf->SetX(55);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(210,8,''.$dt_row->nama_mahasiswa.'');



        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'NIM                  : ');
        $pdf->SetX(55);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(200,8,''.$dt_row->nip.'');



        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Judul Tesis       : ');
        $pdf->SetX(55);
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(120,8,''.$dt_row->judul_tesis.'');





        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Dosen Penguji  : ');
        $pdf->SetX(55);
        $pdf->SetFont('Times','',10);
        $pdf->MultiCell(60,8,''.$xx->nama.'');



        $pdf->SetFont('Times','',12);
        $pdf->Ln(-25);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(10,8,'Tanda Tangan Dosen');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(149);
        $pdf->Cell(10,8,'Penguji');


        $pdf->SetFont('Times','',10);
        $pdf->Ln(20);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(135);
        $pdf->MultiCell(50,4,''.$xx->nama.'');





        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',18);
        $pdf->MultiCell(200,8,'Review Dosen Penguji
');


        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',18);
        $pdf->MultiCell(155,8,'...............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................');

        $pdf->Ln(30);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',18);
        $pdf->MultiCell(200,8,'Review Dosen Penguji
');


        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',18);
        $pdf->MultiCell(155,8,'................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................');


;
				$noxx++;
				}





				$cek_judul_tesis = $this->general_model->datagrab(array(
						'tabel' => 'pengajuan_judul',
						'where' => array('judul_tesis' => $dt_row->judul_tesis)))->row();

		
		 		$from_pem = array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pengajuan_judul' => $cek_judul_tesis->id_pengajuan_judul)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $yy) {
					$bc[]= 
					$pdf->SetFont('Times','',16.4);
			        $pdf->Ln(10);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetX(59);
			        // $pdf->Image(base_url()."assets/images/corp/beritalogo.png",60,40,100,0);
			        $pdf->Image('assets/images/corp/lampiran-masukkan-proposal.png',60,NULL,100,0);

			        $pdf->Ln(30);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',12);
			        $pdf->Cell(20,8,'Nama                       : ');
			        $pdf->SetX(63);
			        $pdf->SetFont('Times','',12);
			        $pdf->MultiCell(210,8,''.$dt_row->nama_mahasiswa.'');



			        $pdf->Ln(0);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',12);
			        $pdf->Cell(20,8,'NIM                         : ');
			        $pdf->SetX(63);
			        $pdf->SetFont('Times','',12);
			        $pdf->MultiCell(200,8,''.$dt_row->nip.'');



			        $pdf->Ln(0);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',12);
			        $pdf->Cell(20,8,'Judul Tesis              : ');
			        $pdf->SetX(63);
			        $pdf->SetFont('Times','',12);
			        $pdf->MultiCell(120,8,''.$dt_row->judul_tesis.'');





			        $pdf->Ln(10);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',12);
			        $pdf->Cell(20,8,'Dosen Pembimbing : ');
			        $pdf->SetX(63);
			        $pdf->SetFont('Times','',10);
			        $pdf->MultiCell(60,8,''.$xx->nama.'');



			        $pdf->SetFont('Times','',12);
			        $pdf->Ln(-20);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetX(140);
			        $pdf->Cell(10,8,'Tanda Tangan Dosen');

			        $pdf->SetFont('Times','',12);
			        $pdf->Ln(5);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetX(149);
			        $pdf->Cell(10,8,'Pembimbing');


			        $pdf->SetFont('Times','',10);
			        $pdf->Ln(20);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetX(135);
			        $pdf->MultiCell(50,4,''.$xx->nama.'');





			        $pdf->Ln(10);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',18);
			        $pdf->MultiCell(200,8,'Review Dosen Pembimbing
			');


        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',18);
        $pdf->MultiCell(155,8,'................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................');

        $pdf->Ln(30);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',18);
        $pdf->MultiCell(200,8,'Review Dosen Pembimbing
');


        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',18);
        $pdf->MultiCell(155,8,'................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................');
        ;
				$nox++;
				}





       

				$cek_judul_tesis = $this->general_model->datagrab(array(
						'tabel' => 'pengajuan_judul',
						'where' => array('judul_tesis' => $dt_row->judul_tesis)))->row();

		
		 		$from_pem = array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pengajuan_judul' => $cek_judul_tesis->id_pengajuan_judul)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $xx) {
					$bc[]= '- '.$xx->nama;
				$nox++;
				}




					$pdf->SetFont('Times','',16.4);
			        $pdf->Ln(150);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetX(59);
			        // $pdf->Image(base_url()."assets/images/corp/beritalogo.png",60,40,100,0);
			        $pdf->Image('assets/images/corp/panitia-sidang.png',60,NULL,100,0);

			        $pdf->Ln(10);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',12);
			        $pdf->Cell(20,8,'Ketua                       : ');
			        $pdf->SetX(63);
			        $pdf->SetFont('Times','',12);
			        $pdf->MultiCell(210,8,'Dr. Joko Setiyono, S.H., M.Hum.');



			        $pdf->Ln(0);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',12);
			        $pdf->Cell(20,8,'Sekretaris                         : ');
			        $pdf->SetX(63);
			        $pdf->SetFont('Times','',12);
			        $pdf->MultiCell(200,8,'Dr. Ratna Herawati, S.H., M.H.');



			        $pdf->Ln(2);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetFont('Times','',12);
			        $pdf->Cell(20,5,'Anggota              : ');
			        $pdf->SetX(63);
			        $pdf->SetFont('Times','',12);
			        $pdf->MultiCell(120,5,implode(@$bc));



				$cek_judul_peng = $this->general_model->datagrab(array(
						'tabel' => 'proposal_tesis',
						'where' => array('judul_tesis' => $dt_row->judul_tesis)))->row();

		
		 		$from_peng = array(
					'mhs_penguji a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$peng = $this->general_model->datagrab(array(
						'tabel' => $from_peng,
						'where' => array('a.id_pendaftaran_ujian' => $cek_judul_peng->id_proposal_tesis,'a.tipe_ujian' => 1)));
				//cek($peng->num_rows());
				$noxx=1;
				$bx=array();
				foreach ($peng->result() as $xx) {
					$bx[]= 
			        $pdf->SetFont('Times','',12);
			        $pdf->Ln(2);
			        $pdf->SetTextColor(0,0,0);
			        $pdf->SetX(63);
			        $pdf->MultiCell(100,5,'- '.$xx->nama.'');

				$noxx++;
				}





        $pdf->SetFont('Times','',12);
        $pdf->Ln(50);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'Semarang, '.tanggal_indo(date("Y-m-d")).'');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'Ketua Program Studi MIH');




        $pdf->SetFont('Times','',12);
        $pdf->Ln(30);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'Dr. Joko Setiyono, S.H., M.Hum');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(140);
        $pdf->Cell(20,8,'NIP. 19660607 199203 1 001');



       // $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'R');


    // Line break
        $pdf->Output('Penjadwalan_proposal_tesis.pdf', 'I'); 
        // $pdf->Output(); 

        //  }

        }


    function undangan($param=NULL) {
        $o=un_de($param);
        //cek($p);
    	$id_jadwal_ujian= $o['id_jadwal_ujian'];
    	$id_mahasiswa= $o['id_mahasiswa'];
    	$id= $o['id_proposal_tesis'];
        /*die();*/
        $offset = !empty($offset) ? $offset : null;
        //$pengajar = $this->input->post('pengajar');
        $st = get_stationer();
         
        $data['h_title_left'] = '
        <div class="col-lg-5" style="padding: 10px 0px 0px 0px;">

        <img src="'.base_url()."uploads/logo/logo_yes.png".'" style="height: 40px;float:left; margin-right:10px;"/>

        <h5 style="font-size: 24px;border-top:3px solid #4271B7;border-bottom:3px solid #4271B7;float:left;color:#4271B7;margin-top:5px;"><b>YOGYA EXECUTIVE SCHOOL "YES"</b></h5>
                </div>
        ';
        $data['h_title_right'] = '
        
        ';
        $data['h_sub_center'] = '';
        $data['tgl_cetak'] = date('d-M-Y');
        $data['company_address'] = '<div class="col-lg-6"  style="padding: 10px 0px 0px 0px;">

        <div style="text-align:right;color: #4271B7;margin-top:-20px;">
        <h6 style="font-size:10px;">Jl. Taman Siswa No. 89 Telp/Fax. (0274) 376 623 Yogyakarta 55151<br>
        Website : www.yesjogja.com<br>E-mail : info@yesjogja.com, info_yes@yahoo.co.id</h6></div>';
        $data['company_country'] = 'City-Country';
        /*$data['company_logo'] = base_url('assets/logo/brand.png');*/

        // **** BEDO SAMBUNGAN
        // $start = 0;
        // $anjab_alat = $this->general_model->datagrabs(array(
        //     'tabel'=>'catatan', 
        //     'select'=>'*'));
        // $data = array(
        //     'h_title_left'=> 'pesis',
        //     'h_title_center'=> '<span>Laporan</span><br/> Data ',
        //     'h_sub_center'=> '',
        //     'tgl_cetak'=> date('d-M-Y'),
        //     'company_address'=>'Company Address',        
        //     'company_country'=>'City-Country',        
        //     'company_logo'=>base_url('assets/logo/brand.png'),        
        //    // 'company_logo'=>$logo_instansi      
        //     );



         ini_set('memory_limit', '512M');
       // $html = $this->load->view('anjab_alat_pdf', $data, true);
        $html = $this->load->view('tigris/pdf', $data, true);
        $this->load->library('fpdf/fpdf');
        /*die();*/



         $from = array(
			'jadwal_ujian d' => '',
			'proposal_tesis a' => array('a.id_proposal_tesis = d.id_ujian','left'),
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_penguji_1','left'),
			'peg_pegawai f' => array('f.id_pegawai = a.id_penguji_2','left'),
			'peg_pegawai g' => array('g.id_pegawai = a.id_pemb_1','left'),
			'peg_pegawai h' => array('h.id_pegawai = a.id_pemb_2','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = a.id_ref_program_konsentrasi','left')
		);
		$select = 'd.*,a.*,b.nama as nama_mahasiswa,b.nip,e.nama as xx,f.nama as xxx,,g.nama as zz,h.nama as zzz,c.nama_program_konsentrasi';
        
          $dt_row = $this->general_model->datagrab(array('tabel'=>$from,'select'=>$select,'offset'=>$offset,'where'=>array('d.id_ujian'=>$id)))->row();
         

         


         $data['title']      = 'berita_acara'.@$dt_row->kode;
         $data['no_uji']         = @$dt_row->kode;




        $parameters= array(
                'mode' => 'utf-8',
                'format' => 'A4-L',    // A4 for portrait
                'default_font_size' => '12',
                'default_font' => '',
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 40,
                'margin_bottom' => 30,
                'margin_header' => 20,
                'margin_footer' => 10,
                'orientation' => 'L' // For some reason setting orientation to "L" alone doesn't work (it should), you need to also set format to "A4-L" for landscape
            );
        $tabelx = '
        <table>
        <tr>
        <tr>
        </table>


        ';
        //$pdf = $this->fpdf->load($parameters);
        // setting
        $pdf = new FPDF('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','B',50);


         //$pdf->Image(base_url()."assets/logo/brand.png",10,6,60,0);
    // Times bold 15
       
        $pdf->SetFont('Times','B',37.5);
        $pdf->Ln(5);
        $pdf->SetTextColor(220,50,10);
        $pdf->Cell(0,10,'MALCOM');
    // Move to the right
        $pdf->Cell(60);

    // Line break
        $pdf->Ln(10);
        // logo
        $pdf->SetTitle('Berita Acara');
        $pdf->SetLineWidth(1);


        $pdf->SetX(-105);
        $pdf->SetTextColor(900,900,900);
         $pdf->Image('assets/images/corp.png',0,0,210,0);

        $pdf->SetFont('Times','i',12);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(75);
        $pdf->Cell(10,10,'Bismillahir-Rahmaanir-Rahiim');




        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Nomor      : ');




        $pdf->SetFont('Times','',12);
        $pdf->Ln(0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(135);
        $pdf->Cell(20,8,'Yogyakarta, '.date('d-M-Y').'');



        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Lampiran  : 1 berkas');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Perihal 	    : Ujian Proposal/Tesis : ');




        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Kepada Yth.');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Tim Penguji');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Penguji I    : '.$dt_row->xx.'');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Penguji II   : '.$dt_row->xxx.'');


        $pdf->SetFont('Times','i',10);
        $pdf->Ln(20);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Assalamualaikum. W.W ');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(20);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Di mohon kesediaan dan kehadiran Bapak/Ibu pada "ujian proposal/tesis" bagi mahasiswa');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Prodi '.$dt_row->nama_program_konsentrasi.' Fakultas yang akan diselenggarakan pada :');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(12);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(55);
        $pdf->Cell(20,8,'Hari/Tanggal  : '.tanggal($dt_row->tgl_mulai).' Fakultas yang akan diselenggarakan pada :');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(7);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(55);
        $pdf->Cell(20,8,'Pukul              : '.tanggal($dt_row->tgl_mulai).' - selesai WIB');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(7);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(55);
        $pdf->Cell(20,8,'Tempat           : '.$dt_row->ruang.'');

        $pdf->SetFont('Times','',12);
        $pdf->Ln(7);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(55);
        $pdf->Cell(20,8,'Pembimbing   : '.$dt_row->zz.'');


        $pdf->Ln(7);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(55);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20,8,'Judul              : ');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(80);
        $pdf->SetFont('Times','',6);
        $pdf->Cell(20,8,''.$dt_row->judul_tesis.'');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Atas perhatian Bapak/Ibu, diucapkan terima kasih');
        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(25);
        $pdf->Cell(20,8,'Wassalamualaikum. W.W');



        $pdf->SetFont('Times','',12);
        $pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(160);
        $pdf->Cell(20,8,'Sekretaris Prodi');




        $pdf->SetFont('Times','',12);
        $pdf->Ln(30);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(160);
        $pdf->Cell(20,8,'.................................');


        $pdf->SetFont('Times','',12);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(160);
        $pdf->Cell(20,8,'NIP');




       // $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'R');


    // Line break
        $pdf->Output('invoice.pdf', 'I'); 
        // $pdf->Output(); 

        //  }

        }


}