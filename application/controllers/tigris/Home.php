<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	var $dir = 'tigris';
	var $dir_pj = 'tigris/Pengajuan_judul';
	function __construct() {
		
		parent::__construct();/*
		$this->load->library('Ajax_pagination');
		$this->load->library('Ajax_pagination_gal1');
		$this->load->library('Ajax_pagination_gal2');*/
		$this->perPage = 4;
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
		//$id_unit = $this->session->userdata('id_unit');
		$this->id_petugas = $id_pegawai;
		if($this->cr('spk1')){
			/*Administrator Simpak*/
			$this->where = array();
		}elseif($this->cr('spk2')){
			/*Verivikastor Data Simpak*/
			$this->where = array();
		}else{
			$this->where = array();
		}

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

    function sekolah($u) {
    	return $this->general_model->cek_sekolah($u);
    }

	public function index() {
		// cek("fukc you");
		// die();
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL) {
		$data['title'] = 'Dashboard';
		
		$data['app'] = 'IDS tigris';
		$data['folder'] = $this->uri->segment(1);
		
		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload'),2);	
		

		$data['breadcrumb'] = array($this->dir => 'Referensi Jenis Output');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'output' 		=> $search_key,
				'jns_pekerjaan' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['output'];
			$data['for_search'] = $fcari['jns_pekerjaan'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['output'];
			$data['for_search'] = $fcari['jns_pekerjaan'];
		}


		$data['pendaftaran'] = $this->general_model->datagrab(array('tabel' => 'pendaftaran_tesis'))->num_rows();
		/*$data['Penjadwalan'] = $this->general_model->datagrab(array('tabel' => 'jadwal_tesis'))->num_rows();*/
		$data['operator'] = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where'=>array('id_pegawai !='=>1)))->num_rows();

	

		//status selesai 
		$from_1 = array(
			'pengajuan_judul a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_pj'] = $this->general_model->datagrab(array('tabel'=>$from_1,'select'=>$select,'where'=>array('a.status_n_pj'=>1),'order'=>'a.id_pengajuan_judul DESC'));


		$from_2 = array(
			'proposal_tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_pt'] = $this->general_model->datagrab(array('tabel'=>$from_2,'select'=>$select,'where'=>array('a.status_n_pt'=>1)));

		$from_3 = array(
			'seminar_hp a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_shp'] = $this->general_model->datagrab(array('tabel'=>$from_3,'select'=>$select,'where'=>array('a.status_n_shp'=>1)));

		$from_4 = array(
			'tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_t'] = $this->general_model->datagrab(array('tabel'=>$from_4,'select'=>$select,'where'=>array('a.status_n_t'=>1)));
		//status selesai 






		//status dalam proses 
		$from_1 = array(
			'pengajuan_judul a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_p_pj'] = $this->general_model->datagrab(array('tabel'=>$from_1,'select'=>$select,'where'=>array('a.status_n_pj'=>NULL),'order'=>'a.id_pengajuan_judul DESC'));


		$from_2 = array(
			'proposal_tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_p_pt'] = $this->general_model->datagrab(array('tabel'=>$from_2,'select'=>$select,'where'=>array('a.status_n_pt'=>0)));

		$from_3 = array(
			'seminar_hp a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_p_shp'] = $this->general_model->datagrab(array('tabel'=>$from_3,'select'=>$select,'where'=>array('a.status_n_shp'=>0)));

		$from_4 = array(
			'tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		$data['jmlh_p_t'] = $this->general_model->datagrab(array('tabel'=>$from_4,'select'=>$select,'where'=>array('a.status_n_t'=>0)));
		//status dalam proses 



		//data pengajuan judul mahasiswa

		 $from_5 = array(
			'pengajuan_judul a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'),'a.status_n_pj'=>NULL);

		}else{
			$where = array('a.status_n_pj'=>NULL);
		}
		$data_pj = $this->general_model->datagrab(array('tabel'=>$from_5,'select'=>$select,'order'=>'a.id_pengajuan_judul DESC','where'=>$where));
		
		if ($data_pj->num_rows() > 0) {
			$heads = array('No','Judul Tesis','Mahasiswa','Kelas');

			$urutan_bidang = $this->general_model->datagrabs([
				'tabel' => [
					'ref_bidang_pengajuan_judul a' => '',
					'ref_bidang bidang' => 'a.id_ref_bidang = bidang.id_bidang'
				],
				'where' => [
					'a.status' => 1 
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
			$no = 1;
			foreach ($data_pj->result() as $row) {
				$rows = array();

				 $from_pem = array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pengajuan_judul' => $row->id_pengajuan_judul)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $xx) {
					$bc[]= 'Pembimbing '.@$nox.' : <p>'.@$xx->nama.'<p>';
				$nox++;
				}


				$from_pp = anchor(site_url($this->dir.'/form_pengesahan/'.in_de(array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_mahasiswa'=>$row->id_mahasiswa))),'<i class="fa fa-file-pdf-o"></i>', 'class="btn btn-xs btn-success btn-flat" act=" title="berita acara..." target="_blank"');


				if($row->status == 1){
					$status = anchor('tigris/pengajuan_judul/on/'.in_de(array('id_pengajuan_judul' => $row->id_pengajuan_judul,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/pengajuan_judul/on/'.in_de(array('id_pengajuan_judul' => $row->id_pengajuan_judul,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				$id_pegawai = $this->session->userdata('id_pegawai');

				$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');



				$cek_jml = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>@$id_bidang)))->num_rows();


				$cek_jml_akademik = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>2)))->num_rows();


				$cek_jml_perustakaan = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>3)))->num_rows();


				$cek_jml_keuangan = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>4)))->num_rows();


				$cek_jml2 = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>@$id_bidang,'status_ver'=>1)))->num_rows();


				$cek_akademik = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>2,'status_ver'=>1)))->num_rows();


				$cek_perustakaan = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>3,'status_ver'=>1)))->num_rows();


				$cek_keuangan = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>4,'status_ver'=>1)))->num_rows();


				$cek_status_pj = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul)))->row();


				// cek($row);
				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Pengajuan Judul;*/
				$rows[] = 	$row->judul_tesis;
				$rows[] = 	$row->nama.' - '.$row->nip;
				$rows[] = 	$row->nama_program_konsentrasi;
				foreach($id_bidangs as $id_bidang){
					$return = '';
					$cek_jmls = $this->general_model->datagrab(array('tabel'=>'ref_pengajuan_judul','where'=>array('id_bidang'=>$id_bidang)))->num_rows();
					$cek_bidang = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>$id_bidang,'status_ver'=>1)))->num_rows();
					$cek_bidang_tertolak = $this->general_model->datagrab(array('tabel'=>'veri_pengajuan_judul','where'=>array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_bidang'=>$id_bidang,'status_ver'=>2)))->num_rows();
					// cek($cek_jmls);
					// cek($cek_bidang);
					// cek($cek_bidang_tertolak);
					if(($cek_jmls-$cek_bidang) <= 0 ){
						$return = '<i class="fa fa-check" style="color:blue"></i> Selesai';
						// $nota_dinas += 1;

					}else if(($cek_jmls-$cek_bidang) != 0 && $cek_bidang_tertolak > 0){
						$return = '<span class="badge badge-pill badge-danger"  style="background-color:red">Tertolak</span>';
					}else{
						if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
							$return = 'dalam Proses';
						}else{
							
							//sudah upload
							$sudah_upload = $this->general_model->datagrabs([
								'tabel' => [
									'mhs_pengajuan_judul mhs' => '',
									'ref_pengajuan_judul syarat' => ['mhs.id_ref_pengajuan_judul = syarat.id_ref_pengajuan_judul','left'] ,
								],'where' => [
									'mhs.id_mahasiswa' => $row->id_mahasiswa,
									'syarat.id_bidang' => $id_bidang
								]
							]);
							$sudah_diverif = $this->general_model->datagrabs([
								'tabel' => 'veri_pengajuan_judul',
								'where' => [
									'id_mahasiswa' => $row->id_mahasiswa,
									'id_bidang' => $id_bidang
								],
								'select' => 'distinct id_ref_pengajuan_judul'
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
							//belum upload

								$return = 'Menunggu Proses';
							}
						}
					}
					// $rows[] = $return . 'id_bidang : ' . $id_bidang ;
					$rows[] = $return;
				}

				
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir_pj.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir_pj.'/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir_pj.'/delete_data/'.in_de(array('id_pengajuan_judul'=>$row->id_pengajuan_judul))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');

					$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'status_pj'=>1,'status_tesis'=>1,'status_n_pj'=>2)))->num_rows();

					$cek_pengajuan_judulx2 = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'status_pj'=>$row->status_pj,'status_tesis'=>$row->status_tesis,'status_n_pj'=>$row->status_n_pj)))->num_rows();

					if($row->status_pj ==  1 AND $row->status_tesis == 1 AND $row->status_n_pj == 2){
						
							if($row->status_pj ==  1 AND $row->status_tesis == 0 AND $row->status_n_pj == 1){
						
								$rows[] = 	$ubah;
								
							}else{
								$rows[] = 	'data di non aktifkan';
							}
						
					}else{
						$rows[] = 	$ubah;
					}
					$rows[] =((($cek_jml_akademik==$cek_akademik) OR ($cek_jml_perustakaan==$cek_perustakaan) OR ($cek_jml_keuangan==$cek_keuangan) OR $cek_jml==$cek_jml2) ? '' : $hapus);

				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {
					$verifikasi1 = anchor(site_url($this->dir_pj.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary  btn-flat" act="" title="Verifikasi data..."');
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

					$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'status_pj'=>1,'status_tesis'=>1,'status_n_pj'=>2)))->num_rows();




					if($row->status_pj ==  1 AND $row->status_tesis == 1 AND $row->status_n_pj == 2){
						
							if($row->status_pj ==  1 AND $row->status_tesis == 0 AND $row->status_n_pj == 1){
						
								$rows[] = 	$verifikasi1;
								
							}else{
								$rows[] = 	'data di non aktifkan';
							}
						
					}else{
						$rows[] = 	$verifikasi1;
					}
				}

					
					
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

					$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'status_pj'=>1,'status_tesis'=>1,'status_n_pj'=>2)))->num_rows();
					if($cek_jml_akademik==$cek_akademik AND $cek_jml_perustakaan==$cek_perustakaan  AND $cek_jml_keuangan==$cek_keuangan){
						if($row->status_pj ==  1 AND $row->status_tesis == 1 AND $row->status_n_pj == 2){
								$verifikasi22 = anchor(site_url($this->dir_pj.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))),'<i class="fa fa-list"></i> ubah status', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
				

								if($row->status_pj ==  1 AND $row->status_tesis == 0 AND $row->status_n_pj == 1){
							
									$rows[] = 	$verifikasi22;
									
								}else{
									$rows[] = 	'data di non aktifkan '.$verifikasi22;
								}
							
						}else{
							$verifikasi2 = anchor(site_url($this->dir_pj.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
				
							$rows[] = 	$verifikasi2;
						}
					}else{
						

					}
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel_pj = $this->table->generate();
		}else{
			$tabel_pj = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['tabel_pj'] = $tabel_pj;
		//data pengajuan judul mahasiswa

		//data proposal tesis mahasiswa
		
		$from_6 = array(
			'proposal_tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'),'a.status_n_pt'=>0);

		}else{
			$where = array('a.status_n_pt'=>0);
		}
		$data_pt = $this->general_model->datagrab(array('tabel'=>$from_6,'where'=>$where,'select'=>$select));
		// cek($this->db->last_query());

		

		if ($data_pt->num_rows() > 0) {
			$heads = array('No','Judul Tesis','Mahasiswa','Kelas');

			$urutan_bidang = $this->general_model->datagrabs([
				'tabel' => [
					'ref_bidang_ujian_proposal a' => '',
					'ref_bidang bidang' => 'a.id_ref_bidang = bidang.id_bidang'
				],
				'select' => 'bidang.id_bidang,bidang.nama_bidang',
				'order' => 'a.urut ASC'
			])->result();
			
			foreach($urutan_bidang as $key => $bidang){
				$id_bidang_proposal[] = $bidang->id_bidang;
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
			$no = 1 + $offset;
			foreach ($data_pt->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/proposal_tesis/on/'.in_de(array('id_proposal_tesis' => $row->id_proposal_tesis,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				
				$terakhir = 1;
				$selesai = false;
				foreach ($id_bidang_proposal as $id_bidang){
					$cek_jmls = $this->general_model->datagrab(array('tabel'=>'ref_proposal_tesis','where'=>array('id_bidang'=>$id_bidang)))->num_rows();
					$cek_bidang = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>$id_bidang,'status_ver'=>1)))->num_rows();
					$cek_bidang_tertolak = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>$id_bidang,'status_ver'=>2)))->num_rows();
				
					if($cek_jmls-$cek_bidang <= 0 ){
						$terakhir += 1;
					}
					if(sizeof($id_bidang_proposal) == $terakhir){
						$selesai = true;
					}
				}


				$id_pegawai = $this->session->userdata('id_pegawai');

				$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');



				$cek_jml = $this->general_model->datagrab(array('tabel'=>'ref_proposal_tesis','where'=>array('id_bidang'=>@$id_bidang)))->num_rows();

				$cek_jml2 = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>@$id_bidang,'status_ver'=>1)))->num_rows();


				$cek_status_pt = $this->general_model->datagrab(array('tabel'=>'proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis)))->row();

				$cek_jdl = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'judul_tesis'=>$row->judul_tesis)))->row();

					

				if($selesai) {
					
					$warna = 'background-color:#eee;color:#222;';
				}elseif(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){

					$warna = 'background-color:#9DF495;color:#0C5106;';
					
				}else{
	
					$warna = 'background-color:#FFFFD1;color:#605A01;';
					
				}
				$rows[] = 	array('data'=>$no,'style'=>''.$warna.';text-align:center');
				$rows[] = array(
					'data' => $row->judul_tesis,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->nama,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->nama_program_konsentrasi,
					'style'=>$warna);
				foreach($id_bidang_proposal as $id_bidang){

					$cek_jmls = $this->general_model->datagrab(array('tabel'=>'ref_proposal_tesis','where'=>array('id_bidang'=>$id_bidang)))->num_rows();
					$cek_bidang = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>$id_bidang,'status_ver'=>1)))->num_rows();
					$cek_bidang_tertolak = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>$id_bidang,'status_ver'=>2)))->num_rows();
					
					if(($cek_jmls-$cek_bidang) <= 0 ){
						$return = '<i class="fa fa-check" style="color:blue"></i> Selesai';
					}else if(($cek_jmls-$cek_bidang) != 0 && $cek_bidang_tertolak > 0){
						$return = '<span class="badge badge-pill badge-danger"  style="background-color:red">Tertolak</span>';
					}else{
						if($id_bidang == 5){
							$lolos_revisi = $this->general_model->datagrab(array('tabel'=>'veri_proposal_tesis','where'=>array('id_proposal_tesis'=>@$row->id_proposal_tesis,'id_bidang'=>$id_bidang,'status_ver'=>3)))->num_rows();
							if($lolos_revisi){
								$return = '<i class="fa fa-warning" style="color:orange"></i> Revisi';
							}else{
								$return = 'dalam Proses';
							}
						}else{
							$return = 'dalam Proses';

						}
					}
					$rows[] = $return;

				}		
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/Proposal_tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir.'/Proposal_tesis/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
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
				}

				$cek_jdl = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'judul_tesis'=>$row->judul_tesis)))->row();



				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {

					$verifikasi1 = anchor(site_url($this->dir.'/Proposal_tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary  btn-flat" act="" title="Verifikasi data..."');

					if($cek_jml==$cek_jml2){
						$rows[] = array('data' => 'SELESAI','style'=>$warna);
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
				}
				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")) {

				$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'status_n_pj'=>2)))->num_rows();

					if($selesai){
						if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 1 AND @$cek_jdl->status_n_pj == 2){

							$verifikasi22 = anchor(site_url($this->dir.'/Proposal_tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-list"></i> ubah status', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
						
								if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
							
									$rows[] = 	$verifikasi22;
									
								}else{
									$rows[] = 	'data sudah di non aktifkan';
								}
							
						}else{
							$verifikasi22 = anchor(site_url($this->dir.'/Proposal_tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_proposal_tesis'=>$row->id_proposal_tesis))),'<i class="fa fa-list"></i> Selesai', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
							$rows[] = 	$verifikasi22;
						}
					}else{
						

					}
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			
			$tabel_pt = $this->table->generate();
		}else{
			$tabel_pt = '<div class="alert">Data masih kosong ...</div>';
		}
		$data['tabel_pt'] = $tabel_pt;
		$from_7 = array(
			'seminar_hp a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'),'a.status_n_shp'=>0);

		}else{
			$where = array('a.status_n_shp'=>0);
		}
		$data_shp = $this->general_model->datagrab(array('tabel'=>$from_7,'where'=>$where,'select'=>$select));



		if ($data_shp->num_rows() > 0) {
			$heads = array('No','Judul Tesis','Mahasiswa','Kelas');

			/*if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){*/
				$heads[] = array('data' => 'Akademik');
				$heads[] = array('data' => 'Perpustakaan');
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
			foreach ($data_shp->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/seminar_hp/on/'.in_de(array('id_seminar_hp' => $row->id_seminar_hp,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/seminar_hp/on/'.in_de(array('id_seminar_hp' => $row->id_seminar_hp,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_seminar_hp);
				


				$id_pegawai = $this->session->userdata('id_pegawai');

				$id_bidang = $this->general_model->datagrab(array('tabel'=>'peg_pegawai','where'=>array('id_pegawai'=>@$id_pegawai)))->row('id_bidang');



				$cek_jml = $this->general_model->datagrab(array('tabel'=>'ref_seminar_hp','where'=>array('id_bidang'=>@$id_bidang)))->num_rows();


				$cek_jml_akademik = $this->general_model->datagrab(array('tabel'=>'ref_seminar_hp','where'=>array('id_bidang'=>2)))->num_rows();


				$cek_jml_perustakaan = $this->general_model->datagrab(array('tabel'=>'ref_seminar_hp','where'=>array('id_bidang'=>3)))->num_rows();


				$cek_jml_keuangan = $this->general_model->datagrab(array('tabel'=>'ref_seminar_hp','where'=>array('id_bidang'=>4)))->num_rows();


				$cek_jml2 = $this->general_model->datagrab(array('tabel'=>'veri_seminar_hp','where'=>array('id_seminar_hp'=>@$row->id_seminar_hp,'id_bidang'=>@$id_bidang,'status_ver'=>1)))->num_rows();


				$cek_akademik = $this->general_model->datagrab(array('tabel'=>'veri_seminar_hp','where'=>array('id_seminar_hp'=>@$row->id_seminar_hp,'id_bidang'=>2,'status_ver'=>1)))->num_rows();


				$cek_perustakaan = $this->general_model->datagrab(array('tabel'=>'veri_seminar_hp','where'=>array('id_seminar_hp'=>@$row->id_seminar_hp,'id_bidang'=>3,'status_ver'=>1)))->num_rows();


				$cek_keuangan = $this->general_model->datagrab(array('tabel'=>'veri_seminar_hp','where'=>array('id_seminar_hp'=>@$row->id_seminar_hp,'id_bidang'=>4,'status_ver'=>1)))->num_rows();


				$cek_status_shp = $this->general_model->datagrab(array('tabel'=>'seminar_hp','where'=>array('id_seminar_hp'=>@$row->id_seminar_hp)))->row();


				
					$cek_jdl = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$row->id_mahasiswa,'judul_tesis'=>$row->judul_tesis)))->row();

					


				if($cek_jml_akademik==$cek_akademik AND $cek_jml_perustakaan==$cek_perustakaan  AND $cek_jml_keuangan==$cek_keuangan) {
					
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
					'data' => $row->nama,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->nama_program_konsentrasi,
					'style'=>$warna);
				/*if($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"pimp")){*/
					$rows[] = 	((($cek_jml_akademik-$cek_akademik) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_perustakaan-$cek_perustakaan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_keuangan-$cek_keuangan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');
				$rows[] = 	((($cek_jml_akademik==$cek_akademik) AND ($cek_jml_perustakaan==$cek_perustakaan) AND ($cek_jml_keuangan==$cek_keuangan) AND $cek_jml==$cek_jml2) ? (($cek_status_shp->status_shp != 1)? '<span class="blink_me">dalam proses</div>' : '<i class="fa fa-check" style="color:blue"></i>') : 'Belum di verifikasi semua bidang');
				/*$rows[] = 	((($cek_jml_keuangan-$cek_keuangan) == 0) ? '<i class="fa fa-check" style="color:blue"></i>' : ' dalam Proses');*/

				// }
				
				if (!in_array($offset,array("cetak","excel")) && $this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")) {
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_seminar_hp'=>$row->id_seminar_hp))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir.'add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_seminar_hp'=>$row->id_seminar_hp,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_seminar_hp'=>$row->id_seminar_hp))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');

					$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_n_pj'=>2)))->num_rows();



					if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 1 AND @$cek_jdl->status_n_pj == 2){
						
							if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
						
								$rows[] = 	$ubah;
								
							}else{
								$rows[] = 	'data sudah di non aktifkan';
							}
						
					}else{
						$rows[] = 	$ubah;
					}

					/*

					if($cek_pengajuan_judulx > 0){

						$rows[] = 	'data sudah di non aktifkan';
					}else{
						$rows[] = 	$ubah;
					}*/

					/*
					$rows[] = 	$ubah;*/
					$rows[] =((($cek_jml_akademik==$cek_akademik) OR ($cek_jml_perustakaan==$cek_perustakaan) OR ($cek_jml_keuangan==$cek_keuangan) OR $cek_jml==$cek_jml2) ? '' : $hapus);
				}




				if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"akad") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"perp") OR $this->general_model->check_role($this->session->userdata('id_pegawai'),"keua")) {



			
			

			
					$verifikasi1 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_seminar_hp'=>$row->id_seminar_hp))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary  btn-flat" act="" title="Verifikasi data..."');
					if($cek_jml==$cek_jml2){
						$rows[] = 'SELESAI';
					}else{
						$rows[] = array('data'=>$cek_jml-$cek_jml2.' belum di verifikasi','style'=>'text-align:center','class'=>'blink_me');
					}/*
					$rows[] = 	((($cek_jml==$cek_jml2)) ? 'SELESAI' : '<span class="blink_me">'.$cek_jml-$cek_jml2.'belum di verifikasi</div>');

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

						$verifikasi22 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_seminar_hp'=>$row->id_seminar_hp))),'<i class="fa fa-list"></i> ubah status', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
					
							if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
						
								$rows[] = 	$verifikasi22;
								
							}else{
								$rows[] = 	'data sudah di non aktifkan';
							}
						
					}else{
						$verifikasi22 = anchor(site_url($this->dir.'/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_seminar_hp'=>$row->id_seminar_hp))),'<i class="fa fa-list"></i> Selesai', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
						$rows[] = 	$verifikasi22;
					}




					}else{
						

					}
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel_shp = $this->table->generate();
		}else{
			$tabel_shp = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['tabel_shp'] = $tabel_shp;
		$from_8 = array(
			'tesis a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.*,c.*,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'),'a.status_n_t'=>0);

		}else{
			$where = array('a.status_n_t'=>0);
		}
		$data_t = $this->general_model->datagrab(array('tabel'=>$from_8,'where'=>$where,'select'=>$select));

		if ($data_t->num_rows() > 0) {
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
				$id_bidang_tesis[] = $bidang->id_bidang;
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
			$no = 1 + $offset;
			foreach ($data_t->result() as $row) {
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
				foreach ($id_bidang_tesis as $id_bidang){
					$cek_jmls = $this->general_model->datagrab(array('tabel'=>'ref_tesis','where'=>array('id_bidang'=>$id_bidang)))->num_rows();
					$cek_bidang = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>1)))->num_rows();
					$cek_bidang_tertolak = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>2)))->num_rows();

					if($cek_jmls-$cek_bidang <= 0 ){
						$terakhir += 1;
					}
					if(sizeof($id_bidang_tesis) == $terakhir){
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
				$rows[] = array(
					'data' => $row->judul_tesis,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->nama,
					'style'=>$warna);
				$rows[] = array(
					'data' => $row->nama_program_konsentrasi,
					'style'=>$warna);
				foreach($id_bidang_tesis as $id_bidang){
					// $rows[] = $return;

					$cek_jmls = $this->general_model->datagrab(array('tabel'=>'ref_tesis','where'=>array('id_bidang'=>$id_bidang)))->num_rows();
					$cek_bidang = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>1)))->num_rows();
					$cek_bidang_tertolak = $this->general_model->datagrab(array('tabel'=>'veri_tesis','where'=>array('id_tesis'=>@$row->id_tesis,'id_bidang'=>$id_bidang,'status_ver'=>2)))->num_rows();
					
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
					$Verifikasi = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/Tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))).'" title="Edit Data..."');
					$ubah = anchor(site_url($this->dir.'/Tesis/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
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

					$verifikasi1 = anchor(site_url($this->dir.'/Tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))),'<i class="fa fa-list"></i>', 'class="btn btn-xs btn-primary  btn-flat" act="" title="Verifikasi data..."');
					if($cek_jml==$cek_jml2){
						$rows[] = 'SELESAI';
					}else{
						$rows[] = array('data'=>$cek_jml-$cek_jml2.' belum di verifikasi','style'=>'text-align:center','class'=>'blink_me');
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
						if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 1 AND @$cek_jdl->status_n_pj == 2){

							$verifikasi22 = anchor(site_url($this->dir.'/Tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))),'<i class="fa fa-list"></i> ubah status', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
						
								if(@$cek_jdl->status_pj ==  1 AND @$cek_jdl->status_tesis == 0 AND @$cek_jdl->status_n_pj == 1){
							
									$rows[] = 	$verifikasi22;
									
								}else{
									$rows[] = 	'data sudah di non aktifkan';
								}
							
						}else{
							$verifikasi22 = anchor(site_url($this->dir.'/Tesis/verifikasi/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_tesis'=>$row->id_tesis))),'<i class="fa fa-list"></i> Selesai', 'class="btn btn-xs btn-primary btn-flat" act="" title="Verifikasi data..."');
							$rows[] = 	$verifikasi22;
						}
					}else{
						

					}
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel_t = $this->table->generate();
		}else{
			$tabel_t = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['tabel_t'] = $tabel_t;
		//data tesis mahasiswa
		$data['content'] = $this->dir.'/dashboard';
		$this->load->view('home', $data);
	}



	function ids() {
		
		$data['title'] = 'IDS';
		
		$data['app'] = 'Information Display Sistem';
		$data['folder'] = $this->uri->segment(1);
		
		$data['par'] = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi','all_reload'),2);

		$data['data_pekerjaan'] = $this->general_model->datagrab(array('tabel' => 'spk_job'))->num_rows();
		$data['operator'] = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where'=>array('id_pegawai !='=>1)))->num_rows();

		$data['pekerjaan_pokok'] = $this->general_model->datagrab(array(
			'tabel'=>array('spk_job a'=>'',
							'spk_jns_output b'=>array('b.id_output=a.id_output','left'),
							'spk_jns_pekerjaan c'=>array('c.id_jns_pekerjaan=b.id_jns_pekerjaan','left')
						),
			'where'=>array('c.id_jns_pekerjaan'=>1),
			))->num_rows();

		$data['pekerjaan_tambahan'] = $this->general_model->datagrab(array(
			'tabel'=>array('spk_job a'=>'',
							'spk_jns_output b'=>array('b.id_output=a.id_output','left'),
							'spk_jns_pekerjaan c'=>array('c.id_jns_pekerjaan=b.id_jns_pekerjaan','left')
						),
			'where'=>array('c.id_jns_pekerjaan'=>2),
			))->num_rows();


		$from_detail = array(
								'spk_pelaksana tj' => '',
								'peg_pegawai td' => array('td.id_pegawai = tj.id_pegawai','left'),
								'spk_detail_pekerjaan tx' => array('tx.id_detail_pekerjaan = tj.id_detail_pekerjaan','left'),
								'spk_job tz' => array('tz.id_job = tj.id_job','left'),
								'spk_jns_output tw' => array('tw.id_output = tz.id_output','left'),
								'spk_jns_pekerjaan tv' => array('tv.id_jns_pekerjaan = tw.id_jns_pekerjaan','left')
							);
		$dtpekerjaan = $this->general_model->datagrab(array('tabel'=>$from_detail,'select'=>'tj.*,td.nama as nama_pegawai,tz.*,tx.pekerjaan,tw.output,tv.jns_pekerjaan,tj.status','order'=>'tj.tgl_penetapan ASC','where'=>array('tj.status !='=>1)));
		if ($dtpekerjaan->num_rows() > 0) {
			$heads[]= array('data' => 'No ');
			$heads[] = array('data' => 'Nama Pekerjaan','style'=>'width: 350px;');/*
			$heads[] = array('data' => 'Pekerjaan');*/
			$heads[] = array('data' => 'Nama Petugas');
			$heads[] = array('data' => 'Tanggal Mulai');
			$heads[] = array('data' => 'Tanggal Selesai');
			$heads[] = array('data' => 'Sisa Waktu');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table no-margin"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$no = 1;
			foreach ($dtpekerjaan->result() as $row) {
				$rows = array();
				$dt_detai = $this->general_model->datagrab(array('tabel'=>'spk_detail_pekerjaan', 'where'=>array('id_output'=>$row->id_output)))->row();


							$from_detail = array(
								'spk_pelaksana_tanggal tj' => ''
							);
							$dt_detail = $this->general_model->datagrab(array('tabel'=>$from_detail,'select'=>'MIN(tanggal) as min_tgl, MAX(tanggal) max_tgl,tj.tanggal as tgl', 'where'=>array('id_job'=>$row->id_job,'id_detail_pekerjaan'=>$row->id_detail_pekerjaan)))->row();
				

				$from_status = array(
								'spk_pelaksana tj' => ''
							);
							$dt_detailx = $this->general_model->datagrab(array('tabel'=>$from_status, 'where'=>array('tj.id_job'=>$row->id_job,'tj.id_detail_pekerjaan'=>$row->id_detail_pekerjaan)))->row();

						switch(@$dt_detailx->status_pek) {
							case '0' : $status_pek = '<span class="blink_me label label-warning">'.'<i class="fa fa-info"></i> &nbsp Belum dibaca</span>';
							break;
							case '1' : $status_pek = '<span class="label label-info">'.'<i class="fa fa-spinner"></i> &nbsp Progres</span>';
							break;
							case '2' : $status_pek = '<span class="label label-success">'.'<i class="fa fa-check"></i> &nbsp Selesai</span>';
							break;
						}			

						$tgl1 = $this->general_model->datagrab(array(
							'tabel' => array(
								'spk_pelaksana p' => '',
								'spk_job td' => array('td.id_job = p.id_job','left')),
							'where' => array('p.id_job' => $row->id_job,'p.id_detail_pekerjaan' => $row->id_detail_pekerjaan)
							))->row();

						$hari2 = $this->general_model->datagrab(array(
							'tabel' => 'spk_pelaksana_tanggal',
							'where' => array('id_job' => @$tgl1->id_job,'id_detail_pekerjaan'=>@$tgl1->id_detail_pekerjaan),
							'select' => 'count(tanggal) as jml'
						))->row()->jml;
				
						$jml_hari_pekerjaan = $hari2.' hari'; 


						$tgl_batas1 = date('Y-m-d', strtotime($dt_detail->min_tgl));
						$tgl_batas = date('Y-m-d', strtotime($dt_detail->max_tgl));
						$hari = date('Y-m-d');
						
						$newdate1 = new DateTime($hari);
						$newdate2 = new DateTime($tgl_batas);
						$jml2 = $newdate1->diff($newdate2);
						$jml_hari2 = $jml2->days;
		
						if($hari > $tgl_batas){
							$st='<span class="blink_me label label-danger" style="font-size:14px;"> LEBIH '.$jml_hari2.' Hari</span>';
						}else{
							$st='&nbsp<span class="badge">'.$jml_hari2.' Hari</span>';
						}



				$rows[] = 	array('data'=>$no,'style'=>'text-align:center;background:#f9f9f9;color:black;');
				$rows[] = 	array('data'=>$row->pekerjaan.' ('.$row->nama_aplikasi.')&nbsp; &nbsp; &nbsp;'.@$status_pek,'style'=>'font-weight:bold;;background:rgba(60, 141, 188, 0.11);');
			
				
				$rows[] = 	array('data'=>'<b>'. $row->nama_pegawai.'</b>');
				$rows[] = 	array('data'=>tanggal($dt_detail->min_tgl));
				$rows[] = 	array('data'=>tanggal($dt_detail->max_tgl));
				/*$rows[] = 	array('data'=>);*/
				$rows[] = 	array('data'=>@$st);
				
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['data_job'] = $tabel;



		$from = array(
			'spk_peg_angkakredit tw' => '',
			'spk_detail_pekerjaan th' => array('th.id_detail_pekerjaan = tw.id_detail_pekerjaan','left'),
			'spk_job tj' => array('tj.id_job = tw.id_job','left'),
			'spk_jns_output td' => array('td.id_output = tj.id_output','left'),
			'spk_jns_pekerjaan ts' => array('ts.id_jns_pekerjaan = td.id_jns_pekerjaan','left'),
			'spk_ref_tahun tt' => array('tt.id_tahun = tj.id_tahun','left'),
			'spk_ref_semester tu' => array('tu.id_semester = tj.id_semester','left'),
			'peg_pegawai tq' => array('tq.id_pegawai = tw.id_pegawai','left')
		);
		$select = 'td.output,ts.jns_pekerjaan,tj.id_job,tj.deskripsi,tj.nama_aplikasi,tj.catatan,tt.tahun,tu.semester,th.id_detail_pekerjaan,th.pekerjaan,tw.angka_kredit as ak,tq.nama as nama_pegawai,tw.angka_kredit as ak,tw.id_peg_angkakredit';

		$dtjob = $this->general_model->datagrab(array('tabel'=>$from, 'order'=>'td.id_output ASC','select'=>$select));
		if ($dtjob->num_rows() > 0) {
			$heads1[]= array('data' => 'No ');
			$heads1[] = array('data' => 'Nama Pekerjaan');
			$heads1[] = array('data' => 'Jenis Output');
			$heads1[] = array('data' => 'Jenis Pekerjaan');
			$heads1[] = array('data' => 'Nama Petugas');
			$heads1[] = array('data' => 'Angka Kredit');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table no-margin"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads1);

			$no = 1;
			foreach ($dtjob->result() as $row) {
				$rows1 = array();
				

				$from_status = array(
								'spk_pelaksana tj' => ''
							);
							$dt_detailx = $this->general_model->datagrab(array('tabel'=>$from_status, 'where'=>array('tj.id_job'=>$row->id_job,'tj.id_detail_pekerjaan'=>$row->id_detail_pekerjaan)))->row();

						switch(@$dt_detailx->status_pek) {
							case '0' : $status_pek = '<span class="blink_me label label-danger">'.'<i class="fa fa-info"></i> &nbsp Belum dibaca</span>';
							break;
							case '1' : $status_pek = '<span class="label label-info">'.'<i class="fa fa-spinner"></i> &nbsp Progres</span>';
							break;
							case '2' : $status_pek = '<span class="label label-success">'.'<i class="fa fa-check"></i> &nbsp Selesai</span>';
							break;
						}			




				$rows1[] = 	array('data'=>$no,'style'=>'text-align:center;background:#f9f9f9;color:red;');
				$rows1[] = 	array('data'=>$row->nama_aplikasi,'style'=>'font-weight:bold;;background:rgba(60, 141, 188, 0.11);');
			
				$rows1[] = 	array('data'=>'<b>'. $row->jns_pekerjaan.'</b>');
				$rows1[] = 	array('data'=>'<b>'. $row->pekerjaan.'</b>');
				$rows1[] = 	array('data'=>$row->nama_pegawai);
				$rows1[] = 	array('data'=>$row->ak);
				
				$this->table->add_row($rows1);

					
				$no++;
			}
			$tabelx = $this->table->generate();
		}else{
			$tabelx = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['data_job_selesai'] = $tabelx;



		$from_detail = array(
								'spk_pelaksana tj' => '',
								'peg_pegawai td' => array('td.id_pegawai = tj.id_pegawai','left'),
								'spk_detail_pekerjaan tx' => array('tx.id_detail_pekerjaan = tj.id_detail_pekerjaan','left'),
								'spk_job tz' => array('tz.id_job = tj.id_job','left'),
								'spk_jns_output tw' => array('tw.id_output = tz.id_output','left'),
								'spk_jns_pekerjaan tv' => array('tv.id_jns_pekerjaan = tw.id_jns_pekerjaan','left')
							);
		$dtpekerjaan = $this->general_model->datagrab(array('tabel'=>$from_detail,'select'=>'tj.*,td.nama as nama_pegawai,tz.*,tx.pekerjaan,tw.output,tv.jns_pekerjaan,tj.status','order'=>'tj.tgl_penetapan ASC','where'=>array('tj.status '=>1)));
		if ($dtpekerjaan->num_rows() > 0) {
			$heads2[]= array('data' => 'No ');
			$heads2[] = array('data' => 'Nama Pekerjaan');
			$heads2[] = array('data' => 'Pekerjaan');
			$heads2[] = array('data' => 'Nama Petugas');
			$heads2[] = array('data' => 'Status');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table no-margin" style="font-size:10px;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads2);

			$no = 1;
			foreach ($dtpekerjaan->result() as $row) {
				$rows2 = array();
				$dt_detai = $this->general_model->datagrab(array('tabel'=>'spk_detail_pekerjaan', 'where'=>array('id_output'=>$row->id_output)))->row();


							$from_detail = array(
								'spk_pelaksana_tanggal tj' => ''
							);
							$dt_detail = $this->general_model->datagrab(array('tabel'=>$from_detail,'select'=>'MIN(tanggal) as min_tgl, MAX(tanggal) max_tgl', 'where'=>array('id_job'=>$row->id_job,'id_detail_pekerjaan'=>$row->id_detail_pekerjaan)))->row();
				

				$from_status = array(
								'spk_pelaksana tj' => ''
							);
							$dt_detailx = $this->general_model->datagrab(array('tabel'=>$from_status, 'where'=>array('tj.id_job'=>$row->id_job,'tj.id_detail_pekerjaan'=>$row->id_detail_pekerjaan)))->row();

						switch(@$dt_detailx->status_pek) {
							case '0' : $status_pek = '<span class="blink_me label label-danger">'.'<i class="fa fa-info"></i> &nbsp Belum dibaca</span>';
							break;
							case '1' : $status_pek = '<span class="label label-info">'.'<i class="fa fa-spinner"></i> &nbsp Progres</span>';
							break;
							case '2' : $status_pek = '<span class="label label-success">'.'<i class="fa fa-check"></i> &nbsp Selesai</span>';
							break;
						}			



				$rows2[] = 	array('data'=>$no,'style'=>'text-align:center;background:#f9f9f9;color:black;');
				$rows2[] = 	array('data'=>$row->nama_aplikasi.' ('.$row->jns_pekerjaan.')','style'=>'font-weight:bold;;background:rgba(60, 141, 188, 0.11);');
			
				$rows2[] = 	array('data'=>'<b>'. $row->pekerjaan.'</b>');
				
				$rows2[] = 	array('data'=>'<b>'. $row->nama_pegawai.'</b>');
				$rows2[] = 	array('data'=>@$status_pek);
				
				$this->table->add_row($rows2);

					
				$no++;
			}
			$tabelxx = $this->table->generate();
		}else{
			$tabelxx = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['data_job_selesai_2'] = $tabelxx;


		$data['ak_view'] = $this->general_model->datagrab(array(
			'tabel'=>array('spk_peg_angkakredit a'=>'',
							'peg_pegawai b'=>array('a.id_pegawai=b.id_pegawai','left')
							),
			'select'=>'a.*,b.id_pegawai,b.nama as nama_pegawai,count(a.id_pegawai) as jml, sum(a.angka_kredit) as hh',
			'group_by'=>'a.id_pegawai',
			'order'=>'a.id_pegawai ASC'
			));

		$this->load->view($this->dir.'/ids_view',$data);
		
	}


	function ajaxPaginationGAL1(){
		$page = $this->input->post('pageGAL1', TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // galeri
	      
		  
	/*	$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);*/

        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => 'tvpeg_foto',
					'where' => array('status'=>1),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'kepegawaian_tv/home/ajaxPaginationGAL1';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data
        $data['foto'] = $this->general_model->datagrab(array(
		            'tabel' => 'tvpeg_foto',
					'where' => array('status'=>1),
		            'order' => 'id_foto DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('kepegawaian_tv/tv/ajax-galeri-data-1', $data, false);
	}

	// galeri kanan
	function ajaxPaginationGAL2(){
		$page = $this->input->post('pageGAL2', TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // galeri
	      
		  
	/*	$from_foto1 = array(
			'tvpeg_widget_foto p' => '',
             'tvpeg_foto i' => array('i.id_foto = p.id_foto','left')
			);
*/
        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => 'tvpeg_foto',
					'where' => array('status'=>2),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL2';
        $config_gal['base_url']    = base_url().'kepegawaian_tv/home/ajaxPaginationGAL2';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal);
        
        //get the posts data
        $data['foto_kanan'] = $this->general_model->datagrab(array(
		            'tabel' => 'tvpeg_foto',
					'where' => array('status'=>2),
		            'order' => 'id_foto DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('kepegawaian_tv/tv/ajax-galeri-data-2', $data, false);
	}
	// ./galeri kanan


	function teksbergerak() {
		$par = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi'),2);
		$mar = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_teks','limit' => 10,'offset' => 0));
		
		echo '
		<marquee class="marquee-box">
			<div >'; 
					$j = 1;
					foreach($mar->result() as $m) { 
						$star = ($j > 1) ? '&nbsp;&nbsp;<img src="'.base_url('logo/'.$par['pemerintah_logo']).'" height="50">&nbsp;&nbsp; ': null;
						echo ''.$star.'<b>'.$m->teks.'</b> ';
						$j+=1;
					}
			echo '
			</div>
		</marquee>';
		
		
	}
	
	function unitbingkai() {
		
		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel'=> 'tvpeg_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1),
			'order' => 'urut'));	
			
		$this->load->view('kepegawaian_tv/tv_unitbingkai_view',$data);
		
	}
						
					public function kirim_email()
					    {
					        // Konfigurasi email.
					        $config = [
					               'useragent' => 'CodeIgniter',
					               'protocol'  => 'smtp',
					               'mailpath'  => '/usr/sbin/sendmail',
					               'smtp_host' => 'ssl://smtp.gmail.com',
					               'smtp_user' => 'video.yesjogja@gmail.com',   // Ganti dengan email gmail Anda.
					               'smtp_pass' => 'tidakada',             // Password gmail Anda.
					               'smtp_port' => 465,
					               'smtp_keepalive' => TRUE,
					               'smtp_crypto' => 'SSL',
					               'wordwrap'  => TRUE,
					               'wrapchars' => 80,
					               'mailtype'  => 'html',
					               'charset'   => 'utf-8',
					               'validate'  => TRUE,
					               'crlf'      => "\r\n",
					               'newline'   => "\r\n",
					           ];
					 
					        // Load library email dan konfigurasinya.
					        $this->load->library('email', $config);
					 
					        // Pengirim dan penerima email.
					        $this->email->from('no-reply@anggiirawan.com', 'anggi irawan');    // Email dan nama pegirim.
					        $this->email->to('video.yesjogja@gmail.com,mantrionline@gmail.com,irawananggi08@gmail.com,fuad.yesjogja@gmail.com');                       // Penerima email.
					 
					        // Lampiran email. Isi dengan url/path file.
					        $this->email->attach('http://serveryes.ddns.net/yesindex/assets/images/bg2.png');
					 
					        // Subject email.
					        $this->email->subject('contoh kirim email masalllllllllllll!!!!!!');
					 
					        // Isi email. Bisa dengan format html.
					        $this->email->message('Ini adalah contoh email yang dikirim melalui localhost pada CodeIgniter menggunakan SMTP email Google (Gmail).');
					 
					        if ($this->email->send())
					        {
					            echo 'Sukses! email berhasil dikirim.';
					        }
					        else
					        {
					            echo 'Error! email tidak dapat dikirim.';
					        }
					    }

}
