<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tesis extends CI_Controller {
	var $dir = 'tigris/Tesis';
	// var $next = 1;
	function __construct() {
		
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
		$this->db->query('SET SESSION sql_mode =
		                  REPLACE(REPLACE(REPLACE(
		                  @@sql_mode,
		                  "ONLY_FULL_GROUP_BY,", ""),
		                  ",ONLY_FULL_GROUP_BY", ""),
		                  "ONLY_FULL_GROUP_BY", "")');
	}

	function cr($e) {
	    return $this->general_model->check_role($this->id_petugas,$e);
    }

	public function index() {
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Tesis');
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
			'tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
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

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>$from, 'order'=>'id_tesis ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where,'order'=>'a.id_tesis DESC'));


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Judul Tesis','Mahasiswa','Kelas');
				$urutan_bidang = $this->general_model->datagrabs([
					'tabel' => [
						'ref_bidang_ujian_tesis a' => '',
						'ref_bidang bidang' => 'a.id_ref_bidang = bidang.id_bidang'
					],
					'select' => 'bidang.id_bidang,bidang.nama_bidang',
					'order' => 'a.urut ASC'
				])->result();

				foreach($urutan_bidang as $key => $bidang){
					$id_bidangs[] = $bidang->id_bidang;
					$heads[] = array('data' => $bidang->nama_bidang);
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
			$no = 1 + $offs;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/tesis/on/'.in_de(array('id_tesis' => $row->id_tesis,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/tesis/on/'.in_de(array('id_tesis' => $row->id_tesis,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_tesis);
				


				$id_pegawai = $this->session->userdata('id_pegawai');

				$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');



				$cek_jml = $this->general_model->datagrab(array('tabel'=>'ref_tesis','where'=>array('id_bidang'=>@$id_bidang)))->num_rows();


				$cek_jml2 = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>@$id_bidang,'status_ver'=>1)))->num_rows();


				$cek_status_t = $this->general_model->datagrab(array('tabel'=>'tesis','where'=>array('id_tesis'=>@$row->id_tesis)))->row();


				$cek_jdl = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'judul_tesis'=>$row->judul_tesis)))->row();

				$terakhir = 1;
				$selesai = false;
				// cek($urutan_bidang);
				foreach ($id_bidangs as $id_bidang){
					$cek_jmls = $this->general_model->datagrab(array('tabel'=>'ref_tesis','where'=>array('id_bidang'=>$id_bidang)))->num_rows();
					$cek_bidang = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>1)))->num_rows();
					$cek_bidang_tertolak = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>2)))->num_rows();

					if($cek_jmls-$cek_bidang <= 0 ){
						$terakhir += 1;
					}
					if(sizeof($id_bidangs) == $terakhir){
						$selesai = true;
					}
				}
				if($selesai) {
					$warna = 'background-color:#eee;color:#222;';
				}elseif(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){

					$warna = 'background-color:#9DF495;color:#0C5106;';
					
				}else{
	
					$warna = 'background-color:#FFFFD1;color:#605A01;';
					
				}

				$rows[] = 	array('data'=>$no,'style'=>''.$warna.';text-align:center');
				/*$rows[] = 	$row->kode_Seminar Hasil Penelitian;*/
				$rows[] = array(
					'data' => $row->judul_tesis,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->nama.' '.$row->nip,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->nama_program_konsentrasi,
					'style'=>$warna);
				
				foreach($id_bidangs as $id_bidang){
					// $rows[] = $return;

					$cek_jmls = $this->general_model->datagrab(array('tabel'=>'ref_tesis','where'=>array('id_bidang'=>$id_bidang)))->num_rows();
					$cek_bidang = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>1)))->num_rows();
					$cek_bidang_tertolak = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>2)))->num_rows();
					
					// cek($cek_jmls);
					// cek($cek_bidang);
					if(($cek_jmls-$cek_bidang) <= 0 ){
						$return = '<i class="fa fa-check" style="color:blue"></i> Selesai';

					}else if(($cek_jmls-$cek_bidang) != 0 && $cek_bidang_tertolak > 0){
						$return = '<span class="badge badge-pill badge-danger"  style="background-color:red">Tertolak</span>';
					}else{
						if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
							$return = 'dalam Proses';
						}else{
							
							//sudah upload
							$sudah_upload = $this->general_model->datagrabs([
								'tabel' => [
									'mhs_tesis mhs' => '',
									'ref_tesis syarat' => ['mhs.id_ref_tesis = syarat.id_ref_tesis','left'] ,
								],'where' => [
									'mhs.id_mahasiswa' => $row->id_mahasiswa,
									'syarat.id_bidang' => $id_bidang
								],
								'select' => 'mhs.id_ref_tesis'
							]);
							// if($row->id_mahasiswa == 108){
							// 	// cek($sudah_diverif->row());
							// 	cek($this->db->last_query());
							// 	// cek($row);
							// }
							$sudah_diverif = $this->general_model->datagrabs([
								'tabel' => 'veri_tesis',
								'where' => [
									'id_mahasiswa' => $row->id_mahasiswa,
									'id_bidang' => $id_bidang
								],
								'select' => 'distinct id_ref_tesis'
							]);
							
							if($sudah_upload->num_rows() > 0 ){
								if($this->general_model->check_bidang($this->session->userdata('id_pegawai'))->id_bidang == $id_bidang){
									$menunggu = true;

									$syarat_menunggu = $sudah_upload->num_rows()-$sudah_diverif->num_rows();
								}
								$return = $sudah_upload->num_rows()-$sudah_diverif->num_rows(). ' Syarat Menunggu';

								if($sudah_upload->num_rows()-$sudah_diverif->num_rows() == 0){
									$return = 'Menunggu';

								}
							}else{
								$return = 'Menunggu Proses';
							}
						}
					}
					// $rows[] = $return . 'id_bidang : ' . $id_bidang ;
					$rows[] = $return;

				}
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_tesis'=>$row->id_tesis))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');

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
				}

				$cek_jdl = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'judul_tesis'=>$row->judul_tesis)))->row();



				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {

					$verifikasi1 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary  btn-flat" act="" title="Verifikasi data..."');
					if($cek_jml==$cek_jml2){
						$rows[] = 'SELESAI';
					}else{
						if(empty($menunggu)){
							$rows[] = array('data'=>$cek_jml-$cek_jml2.' belum selesai','style'=>'text-align:center','class'=>'blink_me');
						}else{

							if($syarat_menunggu/(int)$cek_jml == 1){
								$rows[] = array('data'=>'Butuh verifikasi','style'=>'text-align:center','class'=>'blink_me');
							}
							elseif($syarat_menunggu == 0){
								$rows[] = array('data'=>'Menunggu','style'=>'text-align:center','class'=>'blink_me');
							}else{
								$rows[] = array('data'=>$syarat_menunggu.'/'.$cek_jml.' Syarat butuh verifikasi','style'=>'text-align:center','class'=>'blink_me');
							}
							
						}
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

					if($selesai){
						if($selesai){
							if(@$cek_jdl->status_n_pj == 2){

								$verifikasi22 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))),'<i class="fa fa-list"></i> ubah status', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
							
									if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
								
										$rows[] = 	$verifikasi22;
										
									}else{
										$rows[] = 	'data sudah di non aktifkan';
									}
								
							}else{
								$verifikasi22 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))),'<i class="fa fa-list"></i> Selesai', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
								$rows[] = 	$verifikasi22;
							}
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

		$cek_pengajuan_judul = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pj'=>1,'status_tesis'=>1,'status_n_pj'=>1)))->num_rows();
		$cek_pengajuan_judul2 = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pj'=>NULL,'status_tesis'=>0,'status_n_pj'=>NULL)))->num_rows();
		$cek_pengajuan_judul3 = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pj'=>1,'status_tesis'=>0,'status_n_pj'=>1)))->num_rows();

			$cek_peproposal_tesis2 = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pt'=>NULL)))->num_rows();
		$cek_peproposal_tesis3 = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pt'=>1,'status_n_pt'=>1)))->num_rows();


		$cek_petesis2 = $this->general_model->datagrab(array('tabel'=>'tesis','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_t'=>NULL)))->num_rows();
		$cek_tesisx = $this->general_model->datagrab(array('tabel'=>'tesis','where'=>array('id_mahasiswa'=>@$id_pegawai)))->num_rows();
		
		$cek_tanggal = $this->general_model->datagrab(array('tabel'=>'periode_pu','where'=>array('MONTH(start_date)='.date('m')=>null)));
		/*cek($cek_tanggal->row('start_date'));
		cek($cek_tanggal->row('end_date'));
		cek($cek_tanggal->row('id_ref_semester'));
		cek($cek_tanggal->row('id_periode_pu'));
		
		cek($cek_tesis2);*/
		//cek($cek_pengajuan_judul2);

		$from_tahun = array(
			'peg_pegawai a' => '',
			'ref_tahun e' => array('a.id_ref_tahun = e.id_ref_tahun','left')
		);
		$cek_tahun = $this->general_model->datagrab(array('tabel'=>$from_tahun,'where'=>array('a.id_pegawai'=>@$id_pegawai)))->row();


		if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
			$sudah_upload_ba_proposal = $this->general_model->datagrabs([
				'tabel' => 'review_ujian',
				'where' => [
					'jenis_review' => 1,
					'id_mahasiswa' => $this->session->userdata('id_pegawai')
				]
			])->row();
			// cek($sudah_upload_ba_proposal);
			// die();
			if($cek_pengajuan_judul2 == 1){
				if($cek_tanggal->row('start_date') == NULL AND $cek_tanggal->row('end_date') == NULL){
					$btn_tambah = '';
				}else{
					if(date('Y-m-d') >= $cek_tanggal->row('start_date') AND date('Y-m-d') <= $cek_tanggal->row('end_date')){
						
						
						if($cek_petesis2 == 1){

							$btn_tambah ='';
						}else{
							if($cek_pengajuan_judul3 == 1 && !empty($sudah_upload_ba_proposal)){
								
								$btn_tambah = anchor(site_url($this->dir.'/pendaftaran_ujian/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Tambah Tesis', 'class="btn btn-success btn-editx btn-flat" act="" title="Klik untuk tambah data"');
							}
							elseif(empty($sudah_upload_ba_proposal)){
								$btn_tambah = '<div class="alert alert-danger blink btn-editx btn-flat col-lg-6"><i class="fa fa-warning fa-btn"></i> Belum Upload Berita Acara Proposal </div>';

							}
							else{

							$btn_tambah ='';
							}
						}
					}else{
						$btn_tambah = '';
					}
				}



			}else{
				if($cek_pengajuan_judul3 == 1){

					if($cek_peproposal_tesis2 == 1){

							$btn_tambah = '';
					}else{
						if($cek_peproposal_tesis3 == 1){
							
								if($cek_petesis2 == 0 && !empty($sudah_upload_ba_proposal)){
									$btn_tambah = anchor(site_url($this->dir.'/pendaftaran_ujian/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Tambah Tesis', 'class="btn btn-success btn-editx btn-flat" act="" title="Klik untuk tambah data"');

								}
								elseif(empty($sudah_upload_ba_proposal)){
									$btn_tambah = '<div class="alert alert-danger blink btn-editx btn-flat col-lg-6"><i class="fa fa-warning fa-btn"></i> Belum Upload Berita Acara Proposal </div>';
	
								}
								else{
										
									$btn_tambah = '';
								}

						}else{
								$btn_tambah = anchor(site_url($this->dir.'/pendaftaran_ujian/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Tambah Tesis', 'class="btn btn-success btn-editx btn-flat" act="" title="Klik untuk tambah data"');
						}
					}

				}else{
						$btn_tambah = '';
				}
			}
		}else{
			$btn_tambah = '';
		
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
		$title = 'Tesis';
		
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

		$rentang = $this->general_model->datagrabs([
			'tabel' => 'ref_rentang',
			'where' => [
				'id' => 1,
			]
		])->row()->rentang;
		$tanggal_mendaftar_proposal = $this->general_model->datagrabs([
			'tabel' => 'proposal_tesis',
			'where' => [
				'id_mahasiswa' => $id_mahasiswa,
				'status_n_pt' => 1,
			],
			'select' => 'tgl_pt'
		])->row()->tgl_pt;
		$tanggal_bisa = date_create($tanggal_mendaftar_proposal);
		date_add($tanggal_bisa,date_interval_create_from_date_string($rentang . " days"));
		$now = date_create(date('Y-m-d'));
		$interval = date_diff($now,$tanggal_bisa);
		$interval = $interval->format('%a');

		if($interval > 0){
			$this->session->set_flashdata('fail', 'Belum saatnya mendaftar Ujian Tesis');
			redirect($this->dir);
		}
		$dt = $this->general_model->datagrab(array(
					'tabel' => 'pengajuan_judul',
					'where' => array('id_mahasiswa' => $id_mahasiswa,'status_pj' =>1,'status_tesis' =>0)))->row();

		$param1 =
			array(
				'tabel'=>'tesis',
				'data' => array(
					'id_mahasiswa'=>$id_mahasiswa,
					'id_pemb_1'=>$dt->id_pemb_1,
					'id_pemb_2'=>$dt->id_pemb_2,
					'id_periode_pu'=>$id_periode_pu,
					'id_ref_semester'=>$id_ref_semester,
					'judul_tesis'=>$dt->judul_tesis,
					'tgl_t'=>date('Y-m-d'),
					'status_proses'=> 0,
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
				'tabel'=>'tesis',
				'data' => array(
					'status'=>$o['status']
					),
			);

			$param1['where'] = array('id_tesis'=>$o['id_tesis']);
			$this->general_model->simpan_data($param1);
			redirect($this->dir);
		}

	function urut($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'tesis',
				'data' => array(
					'urut'=>$o['no2']
					),
			);

			$param1['where'] = array('id_tesis'=>$o['id1']);
			$this->general_model->simpan_data($param1);
			/*die();*/



		$param2 =
			array(
				'tabel'=>'tesis',
				'data' => array(
					'urut'=>$o['no1']
					),
			);

			$param2['where'] = array('id_tesis'=>$o['id2']);
			 $this->general_model->simpan_data($param2);




		//$this->general_model->save_data('tesis',array('urut' => $o['no2']),'id_tesis',$o['id1']);
		//$this->general_model->save_data('tesis',array('urut' => $o['no1']),'id_tesis',$o['id2']);
		redirect($this->dir);

	}


    public function add_data($param=NULL,$id_ref_semester=NULL){
    	$o = un_de($param);
    	$id= $o['id_tesis'];
    	$id_periode_pu= $param;
    	$id_ref_semester= $id_ref_semester;
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/tesis/save_aksi'),

        'id_tesis' => set_value('id_tesis'),
		);
        $from = array(
			'tesis a' => '',
			'peg_pegawai c' => array('c.id_pegawai = a.id_mahasiswa','left'),
			'peg_pegawai d' => array('d.id_pegawai = a.id_pemb_1','left'),
			'peg_pegawai e' => array('e.id_pegawai = a.id_pemb_2','left'),
			'ref_program_konsentrasi b' => array('c.id_konsentrasi = b.id_ref_program_konsentrasi','left'),
			'ref_semester f' => array('f.id_ref_semester = a.id_ref_semester','left')
		);
		$select = 'a.*, b.nama_program_konsentrasi,c.id_pegawai,c.nama as x,d.nama as xx,e.nama as xxx,f.*';
		$data['title'] = (!empty($id)) ? 'Ubah Data Tesis' : 'Tesis Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'select' => $select,
					'where' => array('a.id_tesis' => $id),
					'order' => 'urut ASC'))->row() : null;
   	
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_pembimbing1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_pembimbing2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_aksi/'.$id.'/'.$id_ref_semester.'/'.$id_periode_pu;
		$data['multi'] = 1;
		$data['dir'] = base_url($this->dir);
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_tesis" class="id_tesis" value="'.$id .'"/>';
		if(!empty($id)){

			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$dt->id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$dt->id_periode_pu .'"/>';
			$data['form_data'] .= '<input type="hidden" name="judul_tesis" class="judul_tesis" value="'.$dt->judul_tesis .'"/>';
		}else{

			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$id_periode_pu .'"/>';
			$data['form_data'] .= '<input type="hidden" name="judul_tesis" class="judul_tesis" value="'.$dt->judul_tesis .'"/>';
		}
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
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
			
			
			$pemb = $this->general_model->datagrab(array(
				'tabel' => array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				),
				'where' => array('a.id_mahasiswa' => $dt->id_mahasiswa)));
			
			$no = 1; $dd = '';
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
		$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '</div>';
			if(!empty($id)){
				$data['form_data'] .= '<div class="col-lg-12">';

				$data['form_data'] .= '<br><br><h1>Syarat Tesis</h1><hr>';
			
				$dt_kom = $this->general_model->datagrab(array(
					'tabel'=>array(
						'ref_tesis a' => '',
						'ref_bidang b' => array('a.id_bidang = b.id_bidang','left')
					),
					'order' => 'a.urut asc')
				);
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
					<th>Status Verifikasi</th>
					</tr>
				</thead>

				<tbody>
				';
				$no = 1;
				$proses = $dt->status_proses;
				$next = $proses + 1 ;
		
				$boleh = array();
			
				foreach ($dt_kom->result() as $kom) {
					$dtnilai = $this->general_model->datagrab(array('tabel'=>'mhs_tesis','where'=>array('id_tesis'=>$id, 'id_ref_tesis'=>$kom->id_ref_tesis)));

					$dt_kom_pro = $this->general_model->datagrab(array('tabel'=>'veri_tesis', 'where'=>array('id_tesis'=>$dt->id_tesis, 'id_ref_tesis'=>$kom->id_ref_tesis, 'id_mahasiswa'=>$dt->id_mahasiswa)));
					// if($kom->id_bidang == 5 ){
					// 	cek($this->db->last_query());
					// 	die();
					// }
					$dt_veri = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$dt->id_tesis, 'id_ref_tesis'=>$kom->id_ref_tesis, 'id_mahasiswa'=>$dt->id_mahasiswa)));
					$hapus_field = anchor('#',' x ','class="btn btn-xs btn-danger btn-delete" act="'.site_url($this->dir.'/delete_field/'.in_de(array('id_veri_tesis'=>$dt_kom_pro->row('id_veri_tesis'),'id_mahasiswa'=>$dt->id_mahasiswa,'id_tesis'=>$dt->id_tesis,'id_mhs_tesis'=>$dtnilai->row('id_mhs_tesis')))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');

					$pengisian_file = $this->general_model->datagrabs([
						'tabel' => 'ref_bidang_ujian_tesis',
						'where' => [
							'urut' => $next,
							'id_ref_bidang' => $kom->id_bidang
						]
					])->row();

					
					if(empty($pengisian_file)){
						$isi_file = '';
						//jika file nya sudah pernah di upload
						if(!empty($dtnilai->row())){
							$isi_file = '';
							if($dtnilai->row('berkas') != null){
								$isi_file .= '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> ';
							}
							if($dtnilai->row('link') != null){
								$isi_file = '<a href="'.$dtnilai->row('link').'" class="fancybox" target="_blank">'.'Tinjau Link'.'</a> ';
							}
							//jika mahasasiswa yang harus isi dan belum di verifikasi maka mahasiswa bisa hapus data
							if($kom->wajib_isi == 1 && empty($dt_veri->row())){
								$isi_file .= $hapus_field;
							}
						}elseif($dt_kom_pro->row()){
							// if($)
							if($kom->id_ref_tipe_field == 1){
								$isi_file .= 'Berkas ';
	
							}
							if($dt_kom_pro->row('status_ver') == 1 ){
								$isi_file .= 'Disetujui';
	
							}else{
								$isi_file .= 'Ditolak';
							}
	
						}
							
					}
					elseif(!empty($pengisian_file)){
						$isi_file = '';
						
						if(empty($dtnilai->row())){
							switch($kom->id_ref_tipe_field){
								case 1:
									$isi_file = 'Hard Copy';
									break;
								case 2:
									$isi_file = form_upload('berkas['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
									break;
								case 3 : 
									$isi_file = form_input('link['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('link'),'class="form-control" placeholder="link" style="width:100%"');
									break;
								case 4 || 5:
									$isi_file = '<span class="blink_me"> dalam proses</span>';
									break;
								case 6 :
									$isi_file = form_upload('berkas['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
									$isi_file .= form_input('link['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('link'),'class="form-control" placeholder="link" style="width:100%"');
									break;
							}
						}
						elseif(!empty($dtnilai->row())){
							$isi_file = '';
							if($dtnilai->row('berkas') != null){
								$isi_file .= '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> ';
							}
							if($dtnilai->row('link') != null){
								$isi_file = '<a href="'.$dtnilai->row('link').'" class="fancybox" target="_blank">'.'Tinjau Link'.'</a> ';
							}
							//jika mahasasiswa yang harus isi dan belum di verifikasi maka mahasiswa bisa hapus data
							if($kom->wajib_isi == 1 && empty($dt_veri->row())){
								$isi_file .= $hapus_field;
							}
						}
					}
					$chk = NULL;
					if($id!=NULL){
						$dt_kom_pro = $this->general_model->datagrab(array('tabel'=>'mhs_tesis', 'where'=>array('id_mhs_tesis'=>@$p['id_mhs_tesis'], 'id_ref_tesis'=>$kom->id_ref_tesis) ));
						$chk = ($dt_kom_pro->num_rows() > 0) ? 'checked' : '';
					}
					if($dt_veri->row('status_ver') == 1){
						$status_veri ='Lolos <p>catatan : '.$dt_veri->row('catatan');

					}elseif($dt_veri->row('status_ver') == 2){
						$status_veri =' Tolak <p>catatan : '.$dt_veri->row('catatan');

					}else{
						$status_veri ='-';

					}

					$data['form_data'] .= '
					
					<tr>
					<th style="text-align:left">'.$no.'</th>
					<th style="text-align:left">'.$kom->nama_syarat.'</th>
					<th style="text-align:left">'.$kom->keterangan_tesis.'</th>
					<th style="text-align:left">'.$kom->nama_bidang.'</th>
					<th style="text-align:left">
					<div class="col-lg-12">'.form_hidden('id_berkas[]', $kom->id_ref_tesis).$isi_file.'</th>
					<th style="text-align:left">
					<div class="col-lg-12">'.$status_veri.'</th>
					
					</tr>';
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
    }


    public function verifikasi($param=NULL){
    	$o = un_de($param);
    	$id= $o['id_tesis'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/tesis/save_verifikasi'),

        'id_tesis' => set_value('id_tesis'),
		);
        $from = array(
			'tesis a' => '',
			'peg_pegawai c' => array('c.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi b' => array('c.id_konsentrasi = b.id_ref_program_konsentrasi','left'),
			'ref_semester f' => array('f.id_ref_semester = c.id_ref_semester','left'),
			'ref_tahun g' => array('g.id_ref_tahun = c.id_ref_tahun','left')
		);
		$select = 'a.*, b.nama_program_konsentrasi,c.id_pegawai,c.nama as xxx,f.nama_semester,g.nama_tahun';
		$data['title'] = 'Verifikasi Tesis';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,'select' => $select,
					'where' => array('a.id_tesis' => $id)))->row() : null;
		$pembimbing = $this->general_model->datagrabs([
			'tabel' => [
				'pengajuan_judul pengajuan_judul' => '',
				'mhs_pembimbing pemb' => 'pengajuan_judul.id_mahasiswa = pemb.id_mahasiswa',
				'peg_pegawai peg' => 'pemb.id_pembimbing = peg.id_pegawai'
			],
			'where' => [
				'pengajuan_judul.id_mahasiswa' => $o['id_mahasiswa'],
				'pengajuan_judul.judul_tesis' => $dt->judul_tesis,
				'pengajuan_judul.status_n_pj' => 1,
				'pemb.status_pemb' => 1,
			],
			'select' => 'peg.nama'
		])->result();
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_pembimbing1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_pembimbing2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_verifikasi/'.$id;
		$data['multi'] = 1;
		$data['dir'] = base_url($this->dir);
		
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_pendaftaran_ujian" class="id_pendaftaran_ujian" value="'.$id .'"/>';
		
		$bidang_yang_menangani_dosen_penguji  = $this->general_model->datagrabs([
			'tabel' => 'ref_tesis',
			'where' => [
				'id_ref_tipe_field' => 5
			]
		])->row();
		if ($this->general_model->check_bidang($this->session->userdata('id_pegawai'))->id_bidang == $bidang_yang_menangani_dosen_penguji->id_bidang) {
			
			
			$fromx = array(
					'peg_pegawai b' =>'' ,
					'ref_tipe_dosen c' => array('c.id_ref_tipe_dosen = b.id_ref_tipe_dosen','left')
				);

			$dt_pegawai = $this->general_model->datagrab(array('tabel'=>$fromx,'where'=>array('id_tipe'=>2)));
			$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Penguji</label>';
			foreach ($dt_pegawai->result() as $kom) {

			$data['form_data'] .= '<div class="col-lg-12">';
			$chk_pem = NULL;
				$dt_mhs = $this->general_model->datagrab(array('tabel'=>'mhs_penguji', 'where'=>array('id_pendaftaran_ujian'=>$dt->id_tesis, 'id_pembimbing'=>$kom->id_pegawai, 'id_mahasiswa'=>$dt->id_mahasiswa, 'tipe_ujian'=>3)));
				
				$jumlah_mhs = $this->general_model->datagrab(array('tabel'=>'mhs_penguji','select'=>'count(id_mahasiswa) as x', 'where'=>array('id_pembimbing'=>$kom->id_pegawai)))->row();




			$cek_periode = $this->general_model->datagrab(array('tabel'=>'periode_pu','where'=>array('MONTH(start_date)='.date('m')=>null)));
			$fromcc = array(
					'mhs_penguji b' =>'' ,
					'proposal_tesis c' => array('c.id_proposal_tesis = b.id_pendaftaran_ujian','left')
				);
			$cek_jumlah_pem = $this->general_model->datagrab(array('tabel'=>$fromcc,'select'=>'count(b.id_mahasiswa) as x,c.status_n_pt,b.tipe_ujian', 'where'=>array('b.id_pembimbing'=>$kom->id_pegawai,'c.status_n_pt'=>1,'b.tipe_ujian'=>1,'b.id_ref_semester'=>$cek_periode->row('id_ref_semester'))))->row();

			$fromdd = array(
					'mhs_penguji b' =>'' ,
					'seminar_hp c' => array('c.id_seminar_hp = b.id_pendaftaran_ujian','left')
				);
			$cek_jumlah_shp = $this->general_model->datagrab(array('tabel'=>$fromdd,'select'=>'count(b.id_mahasiswa) as x,c.status_n_shp', 'where'=>array('b.id_pembimbing'=>$kom->id_pegawai,'c.status_n_shp'=>1,'b.tipe_ujian'=>2,'b.id_ref_semester'=>$cek_periode->row('id_ref_semester'))))->row();

			$fromee = array(
					'mhs_penguji b' =>'' ,
					'tesis c' => array('c.id_tesis = b.id_pendaftaran_ujian','left')
				);
			$cek_jumlah_t = $this->general_model->datagrab(array('tabel'=>$fromee,'select'=>'count(b.id_mahasiswa) as x,c.status_n_t', 'where'=>array('b.id_pembimbing'=>$kom->id_pegawai,'c.status_n_t !='=>2,'b.tipe_ujian'=>3,'b.id_ref_semester'=>$cek_periode->row('id_ref_semester'))))->row();
			//cek($kom->id_pegawai	);
			//cek($cek_jumlah_pem->x);

				$id_pegawai = $this->session->userdata('id_pegawai');
				
				//cek($cek_jumlah_pem->id_pembimbing);
				if($kom->id_ref_tipe_dosen == 2 OR $kom->tipe_dosen == 'LUAR BIASA'){
					$dt_tipe = 'iya';
				}else{
					$dt_tipe = 'bukan';
				}





				$chk_pem = ($dt_mhs->num_rows() > 0) ? 'checked' : '';
				if(($cek_jumlah_pem->x+$cek_jumlah_shp->x+$cek_jumlah_t->x) >= 6){
					$chk_pem = ($dt_mhs->num_rows() > 0) ? 'checked' : '';
				
					$data['form_data'] .= '<input  disabled="disabled" name="pemb[]'.$kom->id_pegawai.'" '.$chk_pem.' type="checkbox" value="'.$kom->id_pegawai.'" class="incheck" style="margin-top: -2px"> '.$kom->nama.'---'.$kom->tipe_dosen.'---'.' (<b>'.($cek_jumlah_pem->x+$cek_jumlah_shp->x+$cek_jumlah_t->x).'</b>)';
				}else{
					$chk_pem = ($dt_mhs->num_rows() > 0) ? 'checked' : '';
				
					$data['form_data'] .= '<input  name="pemb[]'
					.$kom->id_pegawai.'" '
					.$chk_pem.' type="checkbox" value="'
					.$kom->id_pegawai
					.'" class="incheck" style="margin-top: -2px"> '
					.$kom->nama.'---'
					.$kom->tipe_dosen.'---'.' (<b>'
					.($cek_jumlah_pem->x+$cek_jumlah_t->x).'</b>)';
				}
				/*	
				$data['form_data'] .= '<input  name="pemb[]'.$kom->id_pegawai.'" '.$chk_pem.' type="checkbox" value="'.$kom->id_pegawai.'" class="incheck" style="margin-top: -2px"> '.$kom->nama.' (<b>'.@$jumlah_mhs->x.'</b>)';*/
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
				<td>'.@$dt->xxx.'</td>
			</tr>
			
			<tr>
				<td>Dosen Pembimbing</td>';
				$data['form_data'] .= '<td><ul>';
				foreach($pembimbing as $pemb){
					$data['form_data'] .= '<li>';
					$data['form_data'] .= @$pemb->nama;
					$data['form_data'] .= '</li>';

				}
				$data['form_data'] .= '</ul>';
				$data['form_data'] .= '</td>';
			$data['form_data'] .= '
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
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad")) {
			$data['form_data'] .= '<div class="col-lg-6">';
			$btn_tambah= anchor(site_url($this->dir.'/tambah_data/'.$dt->id_periode_pu.'/'.$dt->id_ref_semester.'/'.$id),'<i class="fa fa-pencil fa-btn"></i> Edit Judul dan Pembimbing', 'class="btn btn-warning btn-editx btn-flat" act="" title="Klik untuk tambah data"');
			$data['form_data'] .= '</div>';
		}
		$data['form_data'] .= '<div class="col-lg-12">';

			$data['form_data'] .= '<br><br><h1>Syarat Tesis</h1><hr>';
			
			$id_pegawai = $this->session->userdata('id_pegawai');

			$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');
			
			$from_q = array(
				'ref_tesis a' => '',
				'ref_bidang b' => array('a.id_bidang = b.id_bidang','left')
			);
			if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

				$dt_kom = $this->general_model->datagrab(array('tabel'=>$from_q));
			}else{

				$dt_kom = $this->general_model->datagrab(array('tabel'=>$from_q,'where'=>array('b.id_bidang'=>@$id_bidang)));
			}

			$dt_sem = $this->general_model->datagrab(array('tabel'=>'tesis','where'=>array('id_tesis'=>$dt->id_tesis)))->row();


			$data['form_data'] .= '<input type="hidden" name="id_pegawai" class="id_pegawai" value="'.$id_pegawai .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_bidang" class="id_bidang" value="'.$id_bidang .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_mahasiswa" class="id_mahasiswa" value="'.$dt->id_mahasiswa .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$dt_sem->id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$dt_sem->id_periode_pu .'"/>';
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
          <th style="width:300px">Verifikasi dan Catatan</th>
        </tr>
    </thead>

    <tbody>
';
$no = 1;
			foreach ($dt_kom->result() as $kom) {





				$chk = NULL;
				$dt_kom_pro = $this->general_model->datagrab(array('tabel'=>'veri_tesis', 'where'=>array('id_tesis'=>$dt->id_tesis, 'id_ref_tesis'=>$kom->id_ref_tesis, 'id_mahasiswa'=>$dt->id_mahasiswa)));
				/*cek($dt->id_tesis);
				cek($kom->id_ref_tesis);
				cek($dt->id_mahasiswa);*/
				$chk = ($dt_kom_pro->num_rows() > 0) ? 'checked' : '';
			
				$dtnilai = $this->general_model->datagrab(array('tabel'=>'mhs_tesis','where'=>array('id_tesis'=>$id, 'id_ref_tesis'=>$kom->id_ref_tesis)));
				/*cek($kom->wajib_isi);
				die();*/
				$hapus_field = anchor('#',' x ','class="btn btn-xs btn-danger btn-delete" act="'.site_url($this->dir.'/delete_field_ver/'.in_de(array('id_veri_tesis'=>$dt_kom_pro->row('id_veri_tesis'),'id_mahasiswa'=>$dt->id_mahasiswa,'id_tesis'=>$dt->id_tesis,'id_mhs_tesis'=>$dtnilai->row('id_mhs_tesis')))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data ini"');
				$hapus_verifikasi = anchor('#',' x ','class="btn btn-xs btn-warning btn-delete" act="'.site_url($this->dir.'/delete_verifikasi/'.in_de(array('id_veri_tesis'=>$dt_kom_pro->row('id_veri_tesis'),'id_mahasiswa'=>$dt->id_mahasiswa,'id_tesis'=>$dt->id_tesis,'id_mhs_tesis'=>$dtnilai->row('id_mhs_tesis')))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk merubah status verifikasi"');
				//cek($kom->wajib_isi != NULL ? 'ada':'kosong');
				if($kom->wajib_isi != NULL){
					if($dtnilai->row('berkas') != NULL){
	          			$isi_file = '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> ';
	          			
					}else{
						//cek($kom->id_ref_tipe_field);
						if($kom->id_ref_tipe_field == 1){
							$isi_file = 'Hard Copy';
						}
						elseif($kom->id_ref_tipe_field == 5){
							$isi_file = 'Pemilihan Dosen Penguji';
						}
						elseif($kom->id_ref_tipe_field == 2){

	          				$isi_file = 'Belum Ada file';
						}else{
							if($dtnilai->row('link') == NULL){

	          					$isi_file = 'Belum Ada Link';
		          			}else{
		          				$xx = str_replace("http://","",$dtnilai->row('link'));
		          			$isi_file = '<a href="https://'.$xx.'" class="fancybox" target="_blank">'."Tinjau Link".'</a> ';
		          			}
						}
					}
	          	}else{/*
	          		cek($kom->id_ref_tipe_field);*/
	          		if($kom->id_ref_tipe_field == 1){
							$isi_file = 'Hard Copy';
					}
					elseif($kom->id_ref_tipe_field == 5){
						$isi_file = 'Pemilihan Dosen Penguji';
					}
					elseif($kom->id_ref_tipe_field == 2){
						if($dtnilai->row('berkas') == NULL){

	          					$isi_file = form_upload('berkas['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('berkas'),'class="form-control" placeholder="Nilai"');
		          			}else{
		          				$isi_file = '<a href="'.base_url('/uploads/'.$dtnilai->row('berkas')).'" class="fancybox" target="_blank">'.$dtnilai->row('berkas').'</a> '.$hapus_field;
		          			}
					}else{
							if($dtnilai->row('link') == NULL){

	          					$isi_file = form_input('link['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('link'),'class="form-control" placeholder="link" style="width:100%"');
		          			}else{
		          				$xx = str_replace("http://","",$dtnilai->row('link'));
		          			$isi_file = '<a href="https://'.$xx.'" class="fancybox" target="_blank">'.$dtnilai->row('link').'</a> '.$hapus_field;
		          			}


	          				
					}
	          	}


				$data['form_data'] .= '
					

							

       
		        <tr>
		          <th style="text-align:left">'.$no.'</th>
		          <th style="text-align:left">'.$kom->nama_syarat.'</th>
		          <th style="text-align:left">'.$kom->keterangan_tesis.'</th>
		          <th style="text-align:left">'.$kom->nama_bidang.'</th>
		            <th style="text-align:left">
		          <div class="col-lg-12">'.form_hidden('id_berkas[]', $kom->id_ref_tesis).$isi_file.'</div></th>
		          
		          ';
		         if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

					$data['form_data'] .= '<th style="text-align:left"><i class="fa fa-check"></i></th>';
				}else{

			$data['form_data'] .= '<th style="text-align:left">';
			/*$data['form_data'] .=  form_radio('status_ver['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('status_ver'),'class="form-control" placeholder="status_ver" style="width:100%"');*/


			if($dt_kom_pro->row('status_ver') == NULL){


				if($dtnilai->row('berkas') != NULL OR $kom->id_ref_tipe_field == 1 OR $dtnilai->row('link') != NULL){

					$data['form_data'] .=  '<label>
		                      <input type="radio" value="1" name="status_ver['.$kom->id_ref_tesis.']" class="flat-blue" '.((!empty($dt_kom_pro) and $dt_kom_pro->row('status_ver') == "1") ? 'checked' : '').' /> <i>Lolos</i> 
		                    </label>&nbsp;  &nbsp;  &nbsp;';
					$data['form_data'] .=  '<label>
		                      <input type="radio" value="2" name="status_ver['.$kom->id_ref_tesis.']" class="flat-blue" '.((!empty($dt_kom_pro) and $dt_kom_pro->row('status_ver') == "2") ? 'checked' : '').' /> <i>Tolak</i> 
		                    </label>&nbsp;  &nbsp;  &nbsp;';
					$data['form_data'] .=  form_input('catatan['.$kom->id_ref_tesis.']',($dtnilai->num_rows()==NULL) ? NULL : $dtnilai->row('catatan'),'class="form-control" placeholder="catatan" style="width:100%"');

	  			}else{

	  			}
  			}else{
  				$data['form_data'] .=(($dt_kom_pro->row('status_ver') == 1)?'lolos':'Tolak').' <p>catatan : '.$dt_kom_pro->row('catatan').' '.$hapus_verifikasi;
  			}

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

if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

			$data['form_data'] .= '<p><label>Status Tesis</label><p>';
			$data['form_data'] .= '<label>
                      <input type="radio" value="1" name="status_n_t" class="flat-blue" '.((!empty($dt) and $dt->status_n_t == "1") ? 'checked' : '').' /> <i>Lolos</i> 
                    </label>&nbsp;  &nbsp;  &nbsp;';
			$data['form_data'] .= '<label>
                      <input type="radio" value="2" name="status_n_t" class="flat-blue" '.((!empty($dt) and $dt->status_n_t == "2") ? 'checked' : '').' /> <i>Berhenti/ Mengulang</i>
                    </label>';
}
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
		// var_dump($in);
    	// die();

    	$id_ref_semester = $this->input->post('id_ref_semester');
    	$id_periode_pu = $this->input->post('id_periode_pu');
    	
    	/*die();*/
		$berkas = $this->input->post('id_berkas');
		$link = $this->input->post('link');
		//$links = $this->input->post('link');

		// cek($berkas);die();
		$id_pegawai = $this->session->userdata('id_pegawai');
		$id_mahasiswa = $this->input->post('id_mahasiswa');
		/*cek($_FILES);
		die();*/
		$id_pembimbing_1 = $this->input->post('id_pembimbing_1');
		$id_pembimbing_2 = $this->input->post('id_pembimbing_2');
    	$id_tesis = $this->input->post('id_tesis');
    	$judul_tesis = $this->input->post('judul_tesis',TRUE);
    	$id_ref_program_konsentrasi = $this->input->post('id_ref_program_konsentrasi',TRUE);
    	$keterangan_seminar_penelitian = $this->input->post('keterangan_seminar_penelitian',TRUE);
    	/*$kode_Tesis = $this->input->post('kode_Tesis');*/
    	$cek_ref_prog = $this->general_model->datagrabs(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>$id_pegawai)))->row();
    	//cek($cek_ref_prog->id_program_studi);
    	$tgl_skrg = date('Y-m-d');
            if(empty($id_tesis)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'tesis','where'=>array('judul_tesis'=>$judul_tesis),'select'=>'id_tesis, MAX(id_tesis) as id'))->row();
                if(empty($cek_prop->id_tesis)) {
                	
                	$id_prop = $this->general_model->save_data('tesis',array('id_mahasiswa' => $id_pegawai,
					'judul_tesis' => $judul_tesis,
					'id_ref_semester' => $id_ref_semester,
					'id_periode_pu' => $id_periode_pu,
					'status_proses' => 0));
					// 'tgl_pj' => date('Y-m-d')));
					$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');

	            }else{
	                $id_prop = $cek_prop->id_tesis ;
	                $this->session->set_flashdata('fail', 'Nama Tesis sudah ada...');
	            }
            }else{
            	
            	$par = array(
					'tabel'=>'tesis',
					'data'=>array(
						'judul_tesis'=>$judul_tesis,
						'id_ref_semester' => $id_ref_semester,
						'id_periode_pu' => $id_periode_pu
						),
					);

					$par['where'] = array('id_tesis'=>$id_tesis);

				$sim = $this->general_model->save_data($par);
						
				foreach ($berkas as $key => $value) {
					# code...
					// cek($value);
					// cek($key);
					// cek($value);
					$mahasiswa = $this->general_model->datagrab([
						'tabel' => 'peg_pegawai',
						'where'=> [
							'id_pegawai' => $id_mahasiswa
						]
					])->row();
					if(isset($_FILES['berkas']['name'][$value]))
						$_FILES['file'] = array(
						'name'=>$mahasiswa->username ."-". $_FILES['berkas']['name'][$value],
						'type'=>$_FILES['berkas']['type'][$value],
						'tmp_name'=>$_FILES['berkas']['tmp_name'][$value],
						'error'=>$_FILES['berkas']['error'][$value],
						'size'=>$_FILES['berkas']['size'][$value],
					);
					else $_FILES['file'] = array();

					/*cek(@$_FILES['file']['size']);
					die();*/
					if(@$_FILES['file']['size'] > 0) {
						$this->upload->do_upload('file');
						$data_upload = $this->upload->data();
						
						$this->general_model->save_data('mhs_tesis', array(
							'id_tesis'=>$id_tesis,
							'id_mahasiswa'=>$id_mahasiswa,
							'id_ref_tesis'=>$value,
							'berkas'=>$data_upload['file_name'],
						));
						
					

					$cek_linkx = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$value)))->num_rows();
					if($cek_linkx>0){
						$cek_linkxx = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$cek_linkx->id_tesis,'id_mahasiswa'=>$cek_linkx->id_mahasiswa,'id_ref_tesis'=>$cek_linkx->id_ref_tesis)))->num_rows();

						if($cek_linkxx > 0) 
							$this->general_model->delete_data(array(
							'tabel' => 'veri_tesis',
							'where' => array(
								'id_tesis' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_tesis' => $value)));
						}
					}
					
				}

				if(!empty($link)){
					foreach ($link as $key => $value) {
						$pars = array(
							'tabel'=>'mhs_tesis',
							'data'=>array(
								'id_tesis'=>$id_tesis,
								'id_mahasiswa' => $id_mahasiswa,
								'id_ref_tesis' => $key,
								'link' => $value
								),
							);
	
						$cek_link = $this->general_model->datagrabs(array('tabel'=>'mhs_tesis','where'=>array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key)))->num_rows();
						/*cek($cek_link);
						die();*/
						if($cek_link > 0) $pars['where'] = array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key);
	
	
							
						$sim = $this->general_model->save_data($pars);
							/*
											cek($id_tesis);
											cek($id_mahasiswa);*/
											/*cek($key);
											die();*/
						$cek_linkx = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key)))->num_rows();
						
						if($cek_linkx > 0) 
							$this->general_model->delete_data(array(
							'tabel' => 'veri_tesis',
							'where' => array(
								'id_tesis' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_tesis' => $key)));
	
	
	
										/*if($cek_linkx > 0) $this->general_model->delete_data('veri_tesis','id_tesis',$id_tesis,'id_mahasiswa',$id_mahasiswa,'id_ref_tesis',$key);
						*/
	
					}
				}
				
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
    		}


            redirect($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_tesis'=>$id_tesis)));
}


    function save_verifikasi(){
    		$config = array(
			'allowed_types' => 'jpg|gif|png|jpeg|JPG|PNG|mp4|pdf',
			'upload_path' => 'uploads',
			'overwrite' => TRUE,
		);
		
    	$this->load->library('upload');
		
		$this->upload->initialize($config);
		$this->upload->do_upload('tes');
		$in = $this->input->post();


		$berkas = $this->input->post('id_berkas');
		$link = $this->input->post('link');
		$status_ver = $this->input->post('status_ver');
		$catatan = $this->input->post('catatan');
		// var_dump($in);
	
		
		// var_dump($status_ver);
		// die();
		$id_pegawai = $this->input->post('id_pegawai');
		$id_mahasiswa = $this->input->post('id_mahasiswa');
		$id_ref_semester = $this->input->post('id_ref_semester');
		$id_periode_pu = $this->input->post('id_periode_pu');
		/*cek($id_periode_pu);
		die();*/

		$status_n_t = $this->input->post('status_n_t');
		if($status_n_t == NULL){
			$status_n_t = 1;
		}else{
			$status_n_t = $status_n_t;
		}


		$id_bidang = $this->input->post('id_bidang');
		$id_tesis = $this->input->post('id_pendaftaran_ujian');
		$klm = $this->input->post('klm');
		$pemb = @$this->input->post('pemb');
		if(!empty($pemb) && sizeof($pemb) > 2){
			$this->session->set_flashdata('fail', 'Penguji melebihi dari 2 dosen!');
			redirect($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_proposal_tesis'=>$id_proposal_tesis)));
		
		}
		$this->general_model->delete_data(array(
			'tabel' => 'mhs_penguji',
			'where' => array(
				'id_pendaftaran_ujian' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_semester' => $id_ref_semester,'id_periode_pu' => $id_periode_pu,
				'tipe_ujian' =>3)
			)
		);
    	if($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){


			$id_tesis = $this->input->post('id_pendaftaran_ujian');
				foreach ($pemb as $key => $value) {

					$cek_beban_proposal = $this->general_model->datagrabs([
						'tabel' => 'mhs_penguji',
						'where' => [
							
							'tipe_ujian' => 1,
							'status_peng' => 1,
							'id_pembimbing' => $value
						]
					])->num_rows();
					
					$cek_beban_tesis = $this->general_model->datagrabs([
						'tabel' => 'mhs_penguji',
						'where' => [
							
							'tipe_ujian' => 3,
							'status_peng' => 1,
							'id_pembimbing' => $value
						]
					])->num_rows();

					// cek($value);
					// cek($cek_beban_proposal);
					// cek($cek_beban_tesis);
					$dosen = $this->general_model->datagrabs([
						'tabel' => 'peg_pegawai',
						'where' => [
							'id_pegawai' => $value
						]
					])->row();
					if($cek_beban_proposal + $cek_beban_tesis >= 6){
						$this->session->set_flashdata('fail', 'Dosen'.$dosen->nama.' melebihi beban maksimum');
						redirect($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_proposal_tesis'=>$id_proposal_tesis)));
					}
					
					$this->general_model->save_data('mhs_penguji', array(
						'id_pendaftaran_ujian'=>$id_tesis,
						'tipe_ujian'=>3,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_semester'=>$id_ref_semester,
						'id_periode_pu'=>$id_periode_pu,
						'id_pembimbing'=>$value,
						'status_peng'=>1
					));
				}
						



			$par = array(
					'tabel'=>'tesis',
					'data'=>array(
						'status_t' => 1,
						'status_n_t' =>$status_n_t
						),
					);

					$par['where'] = array('id_tesis'=>$id_tesis);

				$sim = $this->general_model->save_data($par);
					


				$cek_judul = $this->general_model->datagrabs(array('tabel'=>'tesis','where'=>array('id_tesis'=>$id_tesis)))->row();

				if($status_n_t == 2){
					$par1 = array(
						'tabel'=>'mhs_pembimbing',
						'data'=>array(
							'status_pemb' => 0
						),
					);

					$par1['where'] = array('id_mahasiswa' => $id_mahasiswa);
					$sim = $this->general_model->save_data($par1);

					$parxx = array(
						'tabel'=>'mhs_penguji',
						'data'=>array(
							'status_peng' => 0
						),
					);

					$parxx['where'] = array(
						'id_pendaftaran_ujian' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_semester' => $id_ref_semester,'id_periode_pu' => $id_periode_pu,'tipe_ujian' =>3);
					$sim = $this->general_model->save_data($parxx);

					$par1 = array(
						'tabel'=>'pengajuan_judul',
						'data'=>array(
							'status_tesis' => 1,
							'status_n_pj' => 2
						),
					);

					$par1['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);
					$sim = $this->general_model->save_data($par1);

					$par2 = array(
						'tabel'=>'tesis',
						'data'=>array(
							'status_n_t' => 2,
							'status_t' => 2
						),
					);

					$par2['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);
					$sim = $this->general_model->save_data($par2);

					$par3 = array(
						'tabel'=>'proposal_tesis',
						'data'=>array(
							'status_n_pt' => 2,
							'status_pt' => 2
						),
					);

					$par3['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);
					$sim = $this->general_model->save_data($par3);

					$par4 = array(
						'tabel'=>'tesis',
						'data'=>array(
							'status_n_t' => 2
						),
					);

					$par4['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);
					$sim = $this->general_model->save_data($par4);
				}else{
						
					$par1 = array(
						'tabel'=>'pengajuan_judul',
						'data'=>array(
							'status_tesis' => 0,
							'status_n_pj' => 1
						),
					);

					$par1['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);

					$sim = $this->general_model->save_data($par1);

					$par2 = array(
						'tabel'=>'tesis',
						'data'=>array(
							'status_n_t' => 1
						),
					);

					$par2['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);
					$sim = $this->general_model->save_data($par2);

					$par3 = array(
						'tabel'=>'tesis',
						'data'=>array(
							'status_n_t' => 1
						),
					);

					$par3['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);
					$sim = $this->general_model->save_data($par3);

					$par4 = array(
						'tabel'=>'tesis',
						'data'=>array(
							'status_n_t' => 1
						),
					);

					$par4['where'] = array('id_mahasiswa'=>$id_mahasiswa,'judul_tesis'=>$cek_judul->judul_tesis);
					$sim = $this->general_model->save_data($par4);


				}
				if($status_n_t){
					$id_ref = $this->general_model->datagrabs([
						'tabel' => 'ref_tesis',
						'where' => [
							// 'id_bidang' => 5,
							//pemilihan dosen penguji
							'id_ref_tipe_field' => 5
						]
					])->row('id_ref_tesis');
					$pars_n_t = array(
						'tabel'=>'veri_tesis',
						'data'=>array(
							'id_tesis'=>$id_tesis,
							'id_mahasiswa'=>$id_mahasiswa,
							'id_bidang'=>$this->general_model->check_bidang($this->session->userdata('id_pegawai'))->id_bidang,
							'id_ref_tesis'=>$id_ref,
							'status'=>1,
							'status_ver'=>$status_n_t
							),
						);
						$this->general_model->delete_data([
							'tabel'=>'veri_tesis',
							'where' => [
								'id_bidang'=>$this->general_model->check_bidang($this->session->userdata('id_pegawai'))->id_bidang,
								'status'=>1,
								'id_tesis'=>$id_tesis,
								'id_mahasiswa'=>$id_mahasiswa,
							]
						]);
					$sim = $this->general_model->save_data($pars_n_t);
				}

			$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
    	}else{
			
    		foreach ($berkas as $key => $value) {
				$mahasiswa = $this->general_model->datagrab([
					'tabel' => 'peg_pegawai',
					'where'=> [
						'id_pegawai' => $id_mahasiswa
					]
				])->row();
				if(isset($_FILES['berkas']['name'][$value]))
					$_FILES['file'] = array(
					'name'=>$mahasiswa->username ."-". $_FILES['berkas']['name'][$value],
					'type'=>$_FILES['berkas']['type'][$value],
					'tmp_name'=>$_FILES['berkas']['tmp_name'][$value],
					'error'=>$_FILES['berkas']['error'][$value],
					'size'=>$_FILES['berkas']['size'][$value],
				);
				else $_FILES['file'] = array();
				
				if(@$_FILES['file']['size'] > 0) {
					$this->upload->do_upload('file');
					$data_upload = $this->upload->data();
					// cek($data_upload);
					// cek('yeay');
					$this->general_model->save_data('mhs_tesis', array(
						'id_tesis'=>$id_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_tesis'=>$value,
						'berkas'=>$data_upload['file_name'],
					));
					
				
					$cek_link = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$value)));
					// cek($this->db->last_query());
					// die();
					$cek_linkx = $cek_link->row();
					if(@$cek_link->num_rows() > 0){
						// die('hmmm');
						$cek_linkxx = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$cek_linkx->id_tesis,'id_mahasiswa'=>$cek_linkx->id_mahasiswa,'id_ref_tesis'=>$cek_linkx->id_ref_tesis)))->num_rows();
									/*cek($value);
									die();*/
									if($cek_linkxx > 0) 
										$this->general_model->delete_data(array(
										'tabel' => 'veri_tesis',
										'where' => array(
											'id_tesis' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_tesis' => $value)));
					}else{

					}
					
				}
				
			}
			if($link != NULL){

				foreach (@$link as $key => $value) {
					$pars = array(
					'tabel'=>'mhs_tesis',
					'data'=>array(
						'id_tesis'=>$id_tesis,
						'id_mahasiswa' => $id_mahasiswa,
						'id_ref_tesis' => $key,
						'link' => $value
						),
					);

				$cek_link = $this->general_model->datagrabs(array('tabel'=>'mhs_tesis','where'=>array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key)));
				
				if($cek_link->num_rows() > 0) $pars['where'] = array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key);

				$sim = $this->general_model->save_data($pars);
				$cek_linkx = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key)))->num_rows();
				
				if($cek_linkx > 0) 
					$this->general_model->delete_data(array(
					'tabel' => 'veri_tesis',
					'where' => array(
						'id_tesis' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_tesis' => $key)));
				}
			}
			foreach ($status_ver as $key => $value) {
				// cek($key);
				// cek($value);
				$pars = array(
					'tabel'=>'veri_tesis',
					'data'=>array(
						'id_tesis'=>$id_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_tesis'=>$key,
						'id_bidang'=>$id_bidang,
						'status'=>1,
						'status_ver'=>$value
						),
					);

				
				$sim = $this->general_model->save_data($pars);
				// cek($this->db->last_query());
				// die();

		
				$cek_linkx = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key,'status_ver'=>2)))->row();
				if(@$cek_linkx->id_veri_tesis != NULL){
					$cek_linkxx = $this->general_model->datagrabs(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>$cek_linkx->id_tesis,'id_mahasiswa'=>$cek_linkx->id_mahasiswa,'id_ref_tesis'=>$cek_linkx->id_ref_tesis)))->num_rows();
					/*cek($cek_linkx);
					die();*/
					if($cek_linkxx > 0) 
						$this->general_model->delete_data(array(
						'tabel' => 'mhs_tesis',
						'where' => array(
							'id_tesis' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_tesis' => $key)));
				}
				if($value == 1){
					$disetujui +=1 ;
				}

			}
			foreach ($catatan as $key => $value) {
				$parx = array(
					'tabel'=>'veri_tesis',
					'data'=>array(
						'catatan' =>$value
						),
					);

					$parx['where'] = array('id_tesis'=>$id_tesis,'id_mahasiswa'=>$id_mahasiswa,'id_ref_tesis'=>$key);

				$sim = $this->general_model->save_data($parx);
			}

			$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
			
    	}
		$disetujui = $this->general_model->datagrabs([
			'tabel' => 'veri_tesis',
			'where' => [
				'id_bidang' => $id_bidang,
				'id_mahasiswa' => $id_mahasiswa,
				'id_tesis' => $id_tesis,
				'status_ver' => 1
			],
			'select' => 'DISTINCT id_ref_tesis'
		])->num_rows();
		
		$cek_jumlah_perbidang_yang_dituju = $this->general_model->datagrabs(
			[
				'tabel'=>'ref_tesis',
				'where'=>array('id_bidang'=>@$id_bidang)
		])->num_rows();
		
	
		// var_dump($cek_jumlah_perbidang_yang_dituju);
		// var_dump($disetujui);
		// die();
		if($cek_jumlah_perbidang_yang_dituju - $disetujui == 0 ){
			$tesis_proses = $this->general_model->datagrabs([

				'tabel' => 'ref_bidang_ujian_tesis',
				'where' => [
					'id_ref_bidang' => $id_bidang
				]
			])->row();
			
			// $complete = 1;
			if($tesis_proses){

				$this->general_model->save_data([
					'tabel' => 'tesis',
					'where' => [
						'id_tesis' => $id_tesis,
					],
					'data' => [
						'status_proses' => $this->proses_bidang_selanjutnya($tesis_proses->urut,$id_tesis),
					]
				]);
			}
		}

		redirect($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_tesis'=>$id_tesis)));

    }
	function proses_bidang_selanjutnya($urut,$id_tesis){
		$urutan_selanjutnya = $urut + 1;

		$next_bidang  = $this->general_model->datagrabs([
			'tabel' => 'ref_bidang_ujian_tesis',
			'where' => [
				'urut' => $urutan_selanjutnya
			]
		])->row('id_ref_bidang');
		// cek($next_bidang);
		// cek($this->db->last_query());
		// die();
		$bool = $this->cek_apakah_bidang_selanjutnya_sudah_selesai($next_bidang,$id_tesis);
		// cek($bool);
		// die();
		if($next_bidang == null){
			return $urut;
		}else{
			if($bool){
				return $this->proses_bidang_selanjutnya($urutan_selanjutnya,$id_tesis);
			}else{
				return $urut;
			}
		}
		
	}
	function cek_apakah_bidang_selanjutnya_sudah_selesai($next_bidang,$id_tesis){
		$jumlah_syarat_next_bidang = $this->general_model->datagrabs([
			'tabel' => 'ref_tesis',
			'where' => [
				'id_bidang' => $next_bidang
			]
			])->num_rows();
		$jumlah_veri_next_bidang = $this->general_model->datagrabs([
			'tabel' => 'veri_tesis',
			'where' => [
				'id_bidang' => $next_bidang,
				'id_tesis'=>$id_tesis,
				'status_ver' => 1,
			],
			'select' => 'DISTINCT id_ref_tesis'

		])->num_rows();
		if($jumlah_syarat_next_bidang - $jumlah_veri_next_bidang == 0){
			return true;
		}else{
			return false;
		}
	}
	function delete_data($code) {
		$sn = un_de($code);
		$id_tesis = $sn['id_tesis'];
		$del = $this->general_model->delete_data('tesis','id_tesis',$id_tesis);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
	function delete_field($code) {
		$sn = un_de($code);
		$id_veri_tesis = $sn['id_veri_tesis'];
		$id_mhs_tesis = $sn['id_mhs_tesis'];
		$id_mahasiswa = $sn['id_mahasiswa'];
		$id_tesis = $sn['id_tesis'];
		/*cek($id_mhs_tesis);
		cek($id_mahasiswa);
		cek($id_tesis);
		die();*/
		$del = $this->general_model->delete_data('mhs_tesis','id_mhs_tesis',$id_mhs_tesis);


		$del = $this->general_model->delete_data('veri_tesis','id_veri_tesis',$id_veri_tesis);
		$delx = $this->general_model->delete_data('mhs_tesis','id_mhs_tesis',$id_mhs_tesis);

		if ($del) {
			$this->session->set_flashdata('ok','Data Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Data Gagal di Hapus');
		}
		redirect($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_tesis'=>$id_tesis)));
	}
	function delete_field_ver($code) {
		$sn = un_de($code);
		$id_veri_tesis = $sn['id_veri_tesis'];
		$id_mhs_tesis = $sn['id_mhs_tesis'];
		$id_mahasiswa = $sn['id_mahasiswa'];
		$id_tesis = $sn['id_tesis'];
		/*cek($id_mhs_tesis);
		cek($id_mahasiswa);
		cek($id_tesis);
		die();*/

		$del = $this->general_model->delete_data('veri_tesis','id_veri_tesis',$id_veri_tesis);
		$delx = $this->general_model->delete_data('mhs_tesis','id_mhs_tesis',$id_mhs_tesis);

		if ($del) {
			$this->session->set_flashdata('ok','Data Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Data Gagal di Hapus');
		}
		redirect($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_tesis'=>$id_tesis)));
	}
	function delete_verifikasi($code) {
		$sn = un_de($code);
		$id_veri_tesis = $sn['id_veri_tesis'];
		$id_mhs_tesis = $sn['id_mhs_tesis'];
		$id_mahasiswa = $sn['id_mahasiswa'];
		$id_tesis = $sn['id_tesis'];
		// cek($id_id_tesis);
		// cek($sn);
		// die();
		
		$urut = $this->general_model->datagrabs([
			'tabel' => [
				'veri_tesis veri' => '',
				'ref_tesis ref' => 'veri.id_ref_tesis = ref.id_ref_tesis',
				'ref_bidang_ujian_tesis bidang' => 'ref.id_bidang = bidang.id_ref_bidang' 
			],
			'where' => [
				'veri.id_veri_tesis' => $id_veri_tesis
			],
			'select' => 'bidang.urut'
			])->row();
			// cek($this->db->last_query());
			// var_dump($urut->urut-1);
			// die();
		$status_proses = $this->general_model->datagrabs([
			'tabel' => 'tesis',
			'where' => [
				'id_tesis' => $id_tesis
			]
		])->row('status_proses');
		$proses = $urut->urut-1;
		if($status_proses < $proses){
			$proses = $status_proses;
		}
		$del = $this->general_model->delete_data('veri_tesis','id_veri_tesis',$id_veri_tesis);
		$delx = $this->general_model->delete_data('mhs_tesis','id_mhs_tesis',$id_mhs_tesis);

			
		
		$del_proses = $this->general_model->simpan_data([
			'tabel' => 'tesis',
			'where' => [
				'id_mahasiswa' => $id_mahasiswa,
				'id_tesis' => $id_tesis,
			],
			'data' => [
				'status_proses' => $proses
			]
			]
			
		); 
		if ($del AND $delx) {
			$this->session->set_flashdata('ok','Data Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Data Gagal di Hapus');
		}
		redirect($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$id_mahasiswa,'id_tesis'=>$id_tesis)));
	}



    public function tambah_data($id_periode_pu=NULL,$id_ref_semester=NULL,$id=NULL){
    	/*$o = un_de($param);
    	$id= $o['id_proposal_tesis'];*/
    	$id_periode_pu= $id_periode_pu;
    	$id_ref_semester= $id_ref_semester;
    	$id= $id;
    	//$id_ref_semester= $id_ref_semester;
    	/*cek($param);*/
        /*$data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/pengajuan_judul/save_aksi'),

        'id_proposal_tesis' => set_value('id_proposal_tesis'),
		);*/
		$id_mahasiswa = $this->session->userdata('id_pegawai');
        $from = array(
			'tesis a' => '',
			'ref_program_konsentrasi b' => array('a.id_ref_program_konsentrasi = b.id_ref_program_konsentrasi','left'),
			'ref_semester e' => array('a.id_ref_semester = e.id_ref_semester','left')
		);
		$data['title'] = (!empty($id)) ? 'Ubah Data Judul' : 'Data Judul';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'where' => array('a.id_tesis' => @$id)))->row() : null;
       
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));
		$cb_pembimbing1 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$cb_pembimbing2 = $this->general_model->combo_box(array('tabel'=>'peg_pegawai','key'=>'id_pegawai','val'=>array('nama'),'where'=>array('id_tipe'=>2)));
		$data['form_link'] = $this->dir.'/save_aksi_judul/'.$id_periode_pu.'/'.$id_ref_semester.'/'.$id;
		$data['multi'] = 1;
		$data['dir'] = base_url($this->dir);
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_tesis" class="id_tesis" value="'.$id .'"/>';
		$data['form_data'] .= '<input type="hidden" name="id_mahasiswa" class="id_mahasiswa" value="'.$id_mahasiswa .'"/>';
		if(!empty($id)){

			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$dt->id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$dt->id_periode_pu .'"/>';
		}else{

			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$id_periode_pu .'"/>';
		}
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Judul Tesis</label>';
			$data['form_data'] .= form_textarea('judul_tesis', @$dt->judul_tesis,'class="form-control" placeholder="Judul Tesis" required');
			
			$data['form_data'] .= '</div>';
			$fromx = array(
					'peg_pegawai b' =>'' ,
					'ref_tipe_dosen c' => array('c.id_ref_tipe_dosen = b.id_ref_tipe_dosen','left')
				);

			$dt_pegawai = $this->general_model->datagrab(array('tabel'=>$fromx,'where'=>array('id_tipe'=>2)));

			$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Pembimbing</label>';
			foreach ($dt_pegawai->result() as $kom) {

			$data['form_data'] .= '<div class="col-lg-12">';

			$cek_periode = $this->general_model->datagrab(array('tabel'=>'periode_pu','where'=>array('MONTH(start_date)='.date('m')=>null)));
			$cek_jumlah_pem = $this->general_model->datagrab(array('tabel'=>'mhs_pembimbing','select'=>'count(id_mahasiswa) as x,id_pembimbing', 'where'=>array('id_pembimbing'=>$kom->id_pegawai, 'status_pemb'=>1, 'id_ref_semester'=>$cek_periode->row('id_ref_semester'))))->row();

				$id_pegawai = $this->session->userdata('id_pegawai');
				
				//cek($cek_jumlah_pem->id_pembimbing);
				if($kom->id_ref_tipe_dosen == 2 OR $kom->tipe_dosen == 'LUAR BIASA'){
					$dt_tipe = 'iya';
				}else{
					$dt_tipe = 'bukan';
				}

				/*$cek_tipe_dosen = $this->general_model->datagrab(array('tabel'=>'periode_pu','where'=>array('MONTH(start_date)='.date('m')=>null)));
				*/
					//cek($cek_jumlah_pem->x);
					//$cek_periode->row('id_ref_semester');

				$chk_pem = NULL;
				$dt_mhs = $this->general_model->datagrab(array('tabel'=>'mhs_pembimbing', 'where'=>array('id_pembimbing'=>$kom->id_pegawai, 'id_mahasiswa'=>@$dt->id_mahasiswa)));
				

				$jumlah_mhs = $this->general_model->datagrab(array('tabel'=>'mhs_pembimbing','select'=>'count(id_mahasiswa) as x', 'where'=>array('id_pembimbing'=>$kom->id_pegawai, 'status_pemb'=>1)))->row();
				if($cek_jumlah_pem->x >= 3){
					$chk_pem = ($dt_mhs->num_rows() > 0) ? 'checked' : '';
					
					if($kom->id_ref_tipe_dosen == 2 OR $kom->tipe_dosen == 'LUAR BIASA'){
						$data['form_data'] .= '<input  disabled="disabled" name="pemb[]'.$kom->id_pegawai.'" '.$chk_pem.' type="checkbox" value="'.$kom->id_pegawai.'" class="incheck" style="margin-top: -2px"> '.$kom->nama.'---'.$kom->tipe_dosen.'---'.' (<b>'.@$jumlah_mhs->x.'</b>)';
					}else{
						$data['form_data'] .= '<input  name="pemb[]'.$kom->id_pegawai.'" '.$chk_pem.' type="checkbox" value="'.$kom->id_pegawai.'" class="incheck" style="margin-top: -2px"> '.$kom->nama.'---'.$kom->tipe_dosen.'---'.' (<b>'.@$jumlah_mhs->x.'</b>)';
					}


				}else{
					$chk_pem = ($dt_mhs->num_rows() > 0) ? 'checked' : '';
				
					$data['form_data'] .= '<input  name="pemb[]'.$kom->id_pegawai.'" '.$chk_pem.' type="checkbox" value="'.$kom->id_pegawai.'" class="incheck" style="margin-top: -2px"> '.$kom->nama.'---'.$kom->tipe_dosen.'---'.' (<b>'.@$jumlah_mhs->x.'</b>)';
				}
				
				$data['form_data'] .= '</div>';
			}
			/*$data['form_data'] .= '<p><label>Pembimbing 1</label>';
			$data['form_data'] .= form_dropdown('id_pemb_1', $cb_pembimbing1,@$dt->id_pemb_1,'class="form-control combo-box"  required style="width: 100%"');
			$data['form_data'] .= '<p><label>Pembimbing 2</label>';
			$data['form_data'] .= form_dropdown('id_pemb_2', $cb_pembimbing2,@$dt->id_pemb_2,'class="form-control combo-box" style="width: 100%"');*/
			$data['form_data'] .= '</div>';
		

			$data['content'] = 'umum/pengajuan_judul_form';
			$this->load->view('home', $data);


		//$this->load->view('umum/form_view', $data);
    }



    function save_aksi_judul(){

		$id_pegawai = $this->session->userdata('id_pegawai');
    	$judul_tesis = $this->input->post('judul_tesis',TRUE);
    	$id_ref_semester = $this->input->post('id_ref_semester');
    	$id_periode_pu = $this->input->post('id_periode_pu');
    	$id_tesis = $this->input->post('id_tesis');
    	$id_mahasiswa = $this->input->post('id_mahasiswa');
/*cek($id_tesis);cek($judul_tesis);die();
cek($id_ref_semester);
cek($id_periode_pu);
cek($id_mahasiswa);
*/
		/*$id_mahasiswa = $this->session->userdata('id_pegawai');*/
		$klm = $this->input->post('klm');
		$pemb = $this->input->post('pemb');
    	 if(empty($id_tesis)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'tesis','where'=>array('judul_tesis'=>$judul_tesis),'select'=>'id_tesis, MAX(id_tesis) as id'))->row();
                if(empty($cek_prop->id_tesis)) {
                	
                	$id_prop = $this->general_model->save_data('tesis',array('id_mahasiswa' => $id_pegawai,'judul_tesis' => $judul_tesis,'id_ref_semester' => $id_ref_semester,'id_periode_pu' => $id_periode_pu,'tgl_t' => date('Y-m-d')));
	                

                	$id_tesis = $this->db->insert_id();

                	$this->general_model->delete_data(array(
					'tabel' => 'mhs_pembimbing',
					'where' => array('id_mahasiswa' => $id_mahasiswa,'status_pemb' =>1)));
					/*'where' => array(
						'id_pengajuan_judul' => $id_tesis,'id_mahasiswa' => $id_mahasiswa,'id_ref_semester' => $id_ref_semester,'id_periode_pu' => $id_periode_pu,'tipe'=>2)));*/
				foreach ($pemb as $key => $value) {
					$this->general_model->save_data('mhs_pembimbing', array(
						'id_pengajuan_judul'=>$id_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_semester'=>$id_ref_semester,
						'id_periode_pu'=>$id_periode_pu,
						'id_pembimbing'=>$value,
						'tipe'=>4,
						'status_pemb'=>1
					));
				}


					$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');


	            }else{
	                $id_prop = $cek_prop->id_tesis ;
	                $this->session->set_flashdata('fail', 'Nama Pengajuan Judul sudah ada...');
	            }
            }else{
            	$parx = array(
					'tabel'=>'tesis',
					'data'=>array(
						'judul_tesis'=>$judul_tesis
						),
					);

					$parx['where'] = array('id_tesis'=>$id_tesis);

				$sim = $this->general_model->save_data($parx);

            	$this->general_model->delete_data(array(
					'tabel' => 'mhs_pembimbing',
					'where' => array('id_mahasiswa' => $id_mahasiswa,'status_pemb' =>1)));
				foreach ($pemb as $key => $value) {
					$this->general_model->save_data('mhs_pembimbing', array(
						'id_pengajuan_judul'=>$id_tesis,
						'id_mahasiswa'=>$id_mahasiswa,
						'id_ref_semester'=>$id_ref_semester,
						'id_periode_pu'=>$id_periode_pu,
						'id_pembimbing'=>$value,
						'tipe'=>4,
						'status_pemb'=>1
					));
				}


					$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');


			}
            redirect($this->dir);
    }
}