<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Ids_jadwal extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		$this->load->library('Ajax_pagination');
		$this->load->library('Ajax_pagination_gal1');
		$this->load->library('Ajax_pagination_gal2');
		$this->load->library('Ajax_pagination_gal3');
		$this->load->library('Ajax_pagination_gal4');
		$this->load->library('ajax_tvpegkes_paging_news');
		$this->perPage = 18;
		$this->perPage2 = 3;
		$this->mingdep = 2;
		$this->mini = 1;


		
	}

	function in_app() {
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
	}

	function index($offset=NULL) {
		$offset = !empty($offset) ? $offset : null;
		$data['title'] = 'Online Registration Tesis';
		
		$data['app'] = 'IDS tigris';
		$data['folder'] = $this->uri->segment(1);
		
		$data['par'] = $this->general_model->get_param(array(
			'pemerintah_logo',
			'pemerintah',
			'instansi',
			'all_reload',
			'durasi_agenda_kegiatan',
			'durasi_agenda_bulan_ini',
			'durasi_agenda_bulan_depan',
			'durasi_galeri_kiri',
			'durasi_galeri_kanan',
			'sch_warna_latar',
			'sch_warna_header',
			'sch_warna_teks_header',
			'sch_warna_judul',
			'sch_warna_teks_judul',
			'height_agenda_1',
			'height_agenda_bulan_ini_1',
			'height_agenda_bulan_depan_1',
			'height_pengumuman_1',
			'height_kalender_1',
			'height_galeri_1',
			'height_agenda_2',
			'height_agenda_bulan_ini_2',
			'height_agenda_bulan_depan_2',
			'height_pengumuman_2',
			'height_kalender_2',
			'height_galeri_2'
			),2);

		$data['kiri'] = '';	

        $total_data = $this->general_model->datagrab(array(
		            'tabel' => 'proposal_tesis',
					'where' => array('status_pt'=>1)
		          ))->num_rows();


        //pagination configuration
        $config_news['target']      = '#postNews';
        $config_news['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPengumuman';
        $config_news['total_rows']  = $total_data;
        $config_news['per_page']    = 1;
       	$config_news['uri_segment'] = '4';
        
        $this->ajax_tvpegkes_paging_news->initialize($config_news);
        //get the posts data
        //get the posts data
        $data['news'] = $this->general_model->datagrab(array(
		            'tabel' => 'news',
		            'order' => 'urut',
		            'offset'=>$offset,

		            'limit'=>1,
		            
		          ));

		
		
		$data['det'] = $this->general_model->get_param('tvinfo_durasi');

        // KIRI
        //total rows count kiri

		
		//data Rincian kegiatan
		
		$from_jadwal = array(
			'jadwal_ujian a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left')
		);
		$select = 'a.*,b.nama as nama_mahasiswa';
        $totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_jadwal, 
					'select'=>$select,
					'order'=>'a.tgl_mulai ASC',
					'group_by'=>'a.nama_judul,a.tgl_mulai,a.tgl_selesai,a.id_ujian,a.tipe_ujian',
					'where'=>array('a.ket'=>null),
					/*'where'=>array('f.tahun = YEAR(NOW())'=>null),*/
					'offset'=>$offset
			))->num_rows();

        $config['target']      = '#postPST';
        $config['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $data['total_rowsx']  = $totalRec;

       

			$config['per_page']    = $this->perPage2;
		


        /*$config['per_page']    = $this->perPage;*/
       	$config['uri_segment'] = '4';

        $this->ajax_pagination->initialize($config);



		$detail_kegiatan = $this->general_model->datagrabs(array(
			'tabel' => $from_jadwal, 
					'select'=>$select,
					'order'=>'a.tgl_mulai ASC',
					'limit'=>$config['per_page'],
					'group_by'=>'a.nama_judul,a.tgl_mulai,a.tgl_selesai,a.id_ujian,a.tipe_ujian',
					'where'=>array('a.ket'=>null),
					/*'where'=>array('f.tahun = YEAR(NOW())'=>null),
					'where'=>array('YEARWEEK(a.tgl_mulai) >=YEARWEEK(NOW()) or a.tgl_mulai IS NULL'=>null),*/
					'offset'=>$offset
			));
		// cek($this->db->last_query()); die();

		if ($detail_kegiatan->num_rows() > 0) {
			$heads3[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads3[] = array('data' => 'Mahasiswa - Judul Tesis','style'=>'background-color: #e8e8e8;width:20%');
			$heads3[] = array('data' => 'Ujian','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Tgl & Jam Ujian','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Ruang','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Pembimbing','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Penguji','style'=>'background-color: #e8e8e8;');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads3);

			$no = 1+$offset;
			foreach ($detail_kegiatan->result() as $row) {
				$rows = array();
				$jumlah_karakter_keg=strlen($row->nama_mahasiswa.$row->nama_judul);

				if(substr($row->tgl_mulai,5,2) == date('m')){
					$bg = 'background:	#c2ffbe !important;';
				}else{
					$bg = 'background:	none';

				}

				if($row->tipe_ujian == 1){
					$tipe_ujian = 'Proposal Tesis';
				}elseif($row->tipe_ujian == 2){
					$tipe_ujian = 'Seminar Hasil Penelitian';

				}else{
					$tipe_ujian = 'Tesis';

				}





				$cek_judul_tesis = $this->general_model->datagrab(array(
						'tabel' => 'pengajuan_judul',
						'where' => array('judul_tesis' => $row->nama_judul)))->row();

		
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
						'where' => array('judul_tesis' => $row->nama_judul)))->row();

		
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
				



				$rows[] = 	array('data'=>$no,'style'=>'text-align:center;'.$bg.' !important;color:#000 !important;');
				if($jumlah_karakter_keg >= 30){
					$waktu = 1*(strlen($row->nama_judul));
					//cek($waktu);
					$rows[] = array('data' => '<marquee scrolldelay="'.$waktu.'">'.$row->nama_mahasiswa.' - '.$row->nama_judul.'</marquee>','style'=>''.$bg.'');
					//$rows[] = array('data' => $row->tgl_mulai);
					//$rows[] = 	'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_judul.'</marquee></div>';
				}else{
					$rows[] = 	array('data'=>$row->nama_mahasiswa.' - '.$row->nama_judul,'style'=>''.$bg.'');
				}
				$rows[] = 	array('data'=>$tipe_ujian,'style'=>''.$bg.'');
				//cek(date('d'));
				//cek(substr($row->tgl_mulai,8,2));
				if($row->tgl_mulai != NULL){
					$rows[] = 	array('data'=>
						((substr($row->tgl_mulai,8,2) == date('d')) ? '<span style="color:red; text-align:center;font-weight:bold;">'.date('d/m/Y', strtotime($row->tgl_mulai)).' &nbsp;&nbsp;'.substr($row->tgl_mulai,11,5).'</span>' : date('d/m/Y', strtotime($row->tgl_mulai)).' &nbsp;&nbsp;'.substr($row->tgl_mulai,11,5).'</span>'),'style'=>''.$bg.'');

				}else{
					$rows[] = 	array('data'=>'Belum ada tanggal','style'=>'text-align:center;');
				}
				$rows[] = 	array('data'=>$row->ruang,'style'=>''.$bg.'');

				$rows[] = 	array('data'=>(count(@$bc) > 0) ? '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bc).'</li></ul>':null,'style'=>'');
				$rows[] = 	array('data'=>(count(@$bx) > 0) ? '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bx).'</li></ul>':null,'style'=>'');

				/*
				$rows[] = 	array('data'=>'1. '.$row->pemb_1.'<br>2. '.$row->pemb_2,'style'=>''.$bg.'');
				$rows[] = 	array('data'=>'1. '.$row->penguji_1.'<br>2. '.$row->penguji_2,'style'=>''.$bg.'');*/
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabelc = $this->table->generate();
		}else{
			$tabelc = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['data_kegiatan'] = $tabelc;
		// -- data Rincian kegiatan


		//kegiatan bulan ini	
		$form_mingguini = array(
			'jadwal_ujian a' => ''
		);

        $totalRec3 = $this->general_model->datagrab(array(
			'tabel' => $form_mingguini, 
					'select'=>'',
					'order'=>'a.tgl_mulai ASC',
				'offset'=>$offset
			))->num_rows();

        $config_gali['target']      = '#postGAL3';
        $config_gali['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL3';
        $config_gali['total_rows']  = $totalRec3;
        $config_gali['per_page']    = $this->mini;
       	$config_gali['uri_segment'] = '4';

        $this->ajax_pagination_gal3->initialize($config_gali);

        $data['total_rows']= $totalRec3;
		$data['detail_kegiatan_mi'] = $this->general_model->datagrabs(array(
			'tabel' => $form_mingguini, 
					'select'=>'',
					'order'=>'a.tgl_mulai ASC',

				'limit'=>$config_gali['per_page'],
				'offset'=>$offset
			));
		//--kegiatan bulan ini

		
		//kegiatan bulan depan		
		$form_minggudepan = array(
			'jadwal_ujian a' => ''
		);

        $totalRec4 = $this->general_model->datagrab(array(
			'tabel' => $form_minggudepan, 
					'select'=>'',
					'order'=>'a.tgl_mulai ASC',
					'where'=>array('MONTH(a.tgl_mulai)=3'=>null),
				'offset'=>$offset
			))->num_rows();

        $config_gal4['target']      = '#postGAL4';
        $config_gal4['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL4';
        $config_gal4['total_rows']  = $totalRec4;
        $config_gal4['per_page']    = $this->mingdep;
       	$config_gal4['uri_segment'] = '4';

        $this->ajax_pagination_gal4->initialize($config_gal4);



		$detail_kegiatan_de = $this->general_model->datagrabs(array(
			'tabel' => $form_minggudepan, 
					'select'=>'',
					'order'=>'a.tgl_mulai ASC',
					'where'=>array('MONTH(a.tgl_mulai)=3'=>null),
					/*'where'=>array('YEARWEEK(a.tgl_mulai)=YEARWEEK(current_date+interval 1 week)'=>null),*/
				'limit'=>$config_gal4['per_page'],
				'offset'=>$offset
			));


		if ($detail_kegiatan_de->num_rows() > 0) {
			$heads4[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads4[] = array('data' => 'Kegiatan','style'=>'background-color: #e8e8e8;width:42%');
			$heads4[] = array('data' => 'Tgl Mulai & Selesai','style'=>'background-color: #e8e8e8;width:30%');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads4);

			$no = 1;
			foreach ($detail_kegiatan_de->result() as $row) {
				$rows = array();
				
				$rows[] = 	array('data'=>$no,'style'=>'text-align:center;');
				$rows[] = 	array('data'=>$row->nama_judul);
				$rows[] = 	array('data'=>tanggal($row->tgl_mulai).' <span class="badgex"> s.d </span> '.tanggal($row->tgl_mulai),'style'=>'text-align:center;');
				
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel4 = $this->table->generate();
		}else{
			$tabel4 = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['minggu_depan'] = $tabel4;
		// -- kegiatan bulan ini


        // galeri
	      
		// GALERI FOTO 1
	      
		          
	

		$q_galeri1 = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>1,'aktif'=>1),
		            'order' => 'id_teks DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal1 = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>1,'aktif'=>1)
		          ))->num_rows();

        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL1';
        $config_gal['total_rows']  = $totalRec_gal1;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data

        $data['foto'] = $q_galeri1->result();
// ./ GALERI FOTO 1

        // GALERI KANAN
        $q_galeri2 = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>2,'aktif'=>1),
		            'order' => 'id_teks DESC',
		          'limit'=>1
		          ));
        // ./galeri

        $totalRec_gal2 = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>2,'aktif'=>1),
		          ))->num_rows();

        //pagination configuration
        $config_gal2['target']      = '#postGAL2';
        $config_gal2['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL2';
        $config_gal2['total_rows']  = $totalRec_gal1;
        $config_gal2['per_page']    = 1;
       	$config_gal2['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal2);
        
        //get the posts data

        $data['foto_kanan'] = $q_galeri2->result();
// ./ GALERI FOTO 1
        // ./GALERI KANAN
        $data['musik'] = '';
		

		$from = array(
			'jadwal_ujian tj' => ''
		);
		$select = '';
		$data['dtkalender'] = $this->general_model->datagrab(array('tabel'=>$from,'select'=>$select));

        /*$data['theme'] =$this->general_model->datagrab(array(
			'tabel' => 'sch_theme','where'=>array('status'=>1)))->row();
		$status1 =$this->general_model->datagrab(array(
			'tabel' => 'sch_theme','where'=>array('status'=>1)))->row();
*/
		/*if($status1->id_theme == 1){
			$this->load->view('tigris/2kolom',$data);
		}else{
			$this->load->view('tigris/3kolom',$data);
		}*/

		$this->load->view('tigris/2kolom',$data);

		
	}


	function ajaxPengumuman(){
		$page = $this->input->post('page', TRUE);
		// cek($page);

        if(empty($page)){
            $offset = 0;
        }else{
            $offset = $page;
        }

	
        // pengumuman

        $total_data = $this->general_model->datagrab(array(
		            'tabel' => 'news',
					'where' => array('aktif'=>1)
		          ))->num_rows();


        //pagination configuration
        $config_news['target']      = '#postNews';
        $config_news['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPengumuman';
        $config_news['total_rows']  = $total_data;
        $config_news['per_page']    = 1;
       	$config_news['uri_segment'] = '4';
        
        $this->ajax_tvpegkes_paging_news->initialize($config_news);
        //get the posts data
        //get the posts data
        $data['news'] = $this->general_model->datagrab(array(
		            'tabel' => 'news',
		            'order' => 'urut',
		            'offset'=>$offset,
					'where' => array('aktif'=>1),
		            'limit'=>1
		           
		          ));
        $data['id_gal'] = 'id_news';
        $data['offset'] = $offset;
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);
        if ($total_data > 0) {
        	# code...
        	$dt_row = $data['news']->row();
        }
        	$jeda = !empty($dt_row->jeda) ? $dt_row->jeda : 5;

        $data['paging'] = $this->ajax_tvpegkes_paging_news->create_links($jeda);
        // ./KIRI
        
        //load the view
        $this->load->view('tigris/ajax_tv_pengumuman', $data, false);
	}


	// ajax data kegiatan
	function ajaxPaginationData()
    {


        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		//data kegiatan
		
		$from_jadwal = array(
			'jadwal_ujian a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left')
		);
		$select = 'a.*,b.nama as nama_mahasiswa';
        $totalRec = $this->general_model->datagrab(array(
			'tabel' => $from_jadwal, 
					'select'=>$select,
					'order'=>'a.tgl_mulai ASC',
					'group_by'=>'a.nama_judul,a.tgl_mulai,a.tgl_selesai,a.id_ujian,a.tipe_ujian',
					'where'=>array('a.ket'=>null),
					'offset'=>$offset
			))->num_rows();

        $config['target']      = '#postPST';
        $config['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $data['total_rowsx']  = $totalRec;

       

			$config['per_page']    = $this->perPage2;
		


        /*$config['per_page']    = $this->perPage;*/
       	$config['uri_segment'] = '4';

        $this->ajax_pagination->initialize($config);



		$detail_kegiatan = $this->general_model->datagrabs(array(
			'tabel' => $from_jadwal, 
					'select'=>$select,
					'order'=>'a.tgl_mulai ASC',
					'limit'=>$config['per_page'],
					'group_by'=>'a.nama_judul,a.tgl_mulai,a.tgl_selesai,a.id_ujian,a.tipe_ujian',
					'where'=>array('a.ket'=>null),
					/*'where'=>array('f.tahun = YEAR(NOW())'=>null),
					'where'=>array('YEARWEEK(a.tgl_mulai) >=YEARWEEK(NOW()) or a.tgl_mulai IS NULL'=>null),*/
					'offset'=>$offset
			));
		// cek($this->db->last_query()); die();

		if ($detail_kegiatan->num_rows() > 0) {
			$heads3[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads3[] = array('data' => 'Mahasiswa - Judul Tesis','style'=>'background-color: #e8e8e8;width:20%');
			$heads3[] = array('data' => 'Ujian','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Tgl & Jam Ujian','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Ruang','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Pembimbing','style'=>'background-color: #e8e8e8;');
			$heads3[] = array('data' => 'Penguji','style'=>'background-color: #e8e8e8;');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads3);

			$no = 1+$offset;
			foreach ($detail_kegiatan->result() as $row) {
				$rows = array();
				$jumlah_karakter_keg=strlen($row->nama_mahasiswa.$row->nama_judul);

				if(substr($row->tgl_mulai,5,2) == date('m')){
					$bg = 'background:	#c2ffbe !important;';
				}else{
					$bg = 'background:	none';

				}

				if($row->tipe_ujian == 1){
					$tipe_ujian = 'Proposal Tesis';
				}elseif($row->tipe_ujian == 2){
					$tipe_ujian = 'Seminar Hasil Penelitian';

				}else{
					$tipe_ujian = 'Tesis';

				}





				$cek_judul_tesis = $this->general_model->datagrab(array(
						'tabel' => 'pengajuan_judul',
						'where' => array('judul_tesis' => $row->nama_judul)))->row();

		
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
						'where' => array('judul_tesis' => $row->nama_judul)))->row();

		
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
				



				$rows[] = 	array('data'=>$no,'style'=>'text-align:center;'.$bg.' !important;color:#000 !important;');
				if($jumlah_karakter_keg >= 30){
					$waktu = 1*(strlen($row->nama_judul));
					//cek($waktu);
					$rows[] = array('data' => '<marquee scrolldelay="'.$waktu.'">'.$row->nama_mahasiswa.' - '.$row->nama_judul.'</marquee>','style'=>''.$bg.'');
					//$rows[] = array('data' => $row->tgl_mulai);
					//$rows[] = 	'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_judul.'</marquee></div>';
				}else{
					$rows[] = 	array('data'=>$row->nama_mahasiswa.' - '.$row->nama_judul,'style'=>''.$bg.'');
				}
				$rows[] = 	array('data'=>$tipe_ujian,'style'=>''.$bg.'');
				//cek(date('d'));
				//cek(substr($row->tgl_mulai,8,2));
				if($row->tgl_mulai != NULL){
					$rows[] = 	array('data'=>
						((substr($row->tgl_mulai,8,2) == date('d')) ? '<span style="color:red; text-align:center;font-weight:bold;">'.date('d/m/Y', strtotime($row->tgl_mulai)).' &nbsp;&nbsp;'.substr($row->tgl_mulai,11,5).'</span>' : date('d/m/Y', strtotime($row->tgl_mulai)).' &nbsp;&nbsp;'.substr($row->tgl_mulai,11,5).'</span>'),'style'=>''.$bg.'');

				}else{
					$rows[] = 	array('data'=>'Belum ada tanggal','style'=>'text-align:center;');
				}
				$rows[] = 	array('data'=>$row->ruang,'style'=>''.$bg.'');

				$rows[] = 	array('data'=>(count(@$bc) > 0) ? '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bc).'</li></ul>':null,'style'=>'');
				$rows[] = 	array('data'=>(count(@$bx) > 0) ? '<ul style="margin: 0;padding: 2px 15px"><li>'.implode('</li><li>',@$bx).'</li></ul>':null,'style'=>'');

				/*
				$rows[] = 	array('data'=>'1. '.$row->pemb_1.'<br>2. '.$row->pemb_2,'style'=>''.$bg.'');
				$rows[] = 	array('data'=>'1. '.$row->penguji_1.'<br>2. '.$row->penguji_2,'style'=>''.$bg.'');*/
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabelc = $this->table->generate();
		}else{
			$tabelc = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['data_kegiatan'] = $tabelc;
		// -- data kegiatan

        //load the view
        $this->load->view('tigris/ajax-peserta-data', $data, false);
    }
	// ./ajax kegaitan

	// ajax kegiatan bulan ini
	function ajaxPaginationGAL3()
    {


		$page = $this->input->post('pageGAL3', TRUE);
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		//data kegiatan
		
		$form_mingguini = array(
			'jadwal_ujian a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left')
		);
		$select = 'a.*,b.nama as nama_mahasiswa';


        $totalRec3 = $this->general_model->datagrab(array(
			'tabel' => $form_mingguini, 
					'select'=>$select,
				'offset'=>$offset
			))->num_rows();

        $config_gal3['target']      = '#postGAL3';
        $config_gal3['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL3';
        $config_gal3['total_rows']  = $totalRec3;
        $config_gal3['per_page']    = $this->mini;
       	$config_gal3['uri_segment'] = '4';

        $this->ajax_pagination_gal3->initialize($config_gal3);



        $data['total_rows']= $totalRec3;
        $data['page']= $page;
		$data['detail_kegiatan_mi'] = $this->general_model->datagrabs(array(
			'tabel' => $form_mingguini, 
					'select'=>$select,

				'limit'=>$config_gal3['per_page'],
				'offset'=>$offset
			));

        $this->load->view('tigris/ajax-galeri-data-3', $data, false);
    }
	// ./ajax kegiatan bulan ini

	// ajax kegiatan bulan depan
	function ajaxPaginationGAL4()
    {


		$page = $this->input->post('pageGAL4', TRUE);
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		//data kegiatan
		
		$form_minggudepan = array(
			'jadwal_ujian a' => ''
		);

        $totalRec3 = $this->general_model->datagrab(array(
			'tabel' => $form_minggudepan, 
					'select'=>'',
					'order'=>'a.tgl_mulai ASC',
					'where'=>array('MONTH(a.tgl_mulai)='.date('m', strtotime('+1 months'))/*.' or MONTH(a.tgl_mulai)='.date('m')*/=>null),
				'offset'=>$offset
			))->num_rows();

        $config_gal4['target']      = '#postGAL4';
        $config_gal4['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL4';
        $config_gal4['total_rows']  = $totalRec3;
        $config_gal4['per_page']    = $this->mingdep;
       	$config_gal4['uri_segment'] = '4';

        $this->ajax_pagination_gal4->initialize($config_gal4);



		$detail_kegiatan_dep = $this->general_model->datagrabs(array(
			'tabel' => $form_minggudepan, 
					'select'=>'',
					'order'=>'a.tgl_mulai ASC',
					'where'=>array('MONTH(a.tgl_mulai)='.date('m', strtotime('+1 months'))/*.' or MONTH(a.tgl_mulai)='.date('m')*/=>null),
				'limit'=>$config_gal4['per_page'],
				'offset'=>$offset
			));


		if ($detail_kegiatan_dep->num_rows() > 0) {
			$heads4[]= array('data' => 'No ','style'=>'background-color: #e8e8e8;width:3%');
			$heads4[] = array('data' => 'Kegiatan','style'=>'background-color: #e8e8e8;width:42%');
			$heads4[] = array('data' => 'Tgl Mulai & Selesai','style'=>'background-color: #e8e8e8;width:30%');
			if (array("cetak","excel"))
			$classy = (array("cetak","excel")) ? 'class="table table-bordered table-condensed" style="margin-bottom: 0;"' : 'class="tabel_print" border=1';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads4);

			$no = 1+$offset;
			foreach ($detail_kegiatan_dep->result() as $row) {
				$rows = array();
				$jumlah_karakter_keg=strlen($row->nama_judul);
				$rows[] = 	array('data'=>$no,'style'=>'text-align:center;background:'.$row->color.' !important;color:#fff !important;');
				if($jumlah_karakter_keg >= 30){
					$rows[] = 	array('data'=>'<div style="width: 100%;overflow: hidden;"><marquee direction="left" scrolldelay="200">'.$row->nama_judul.'</marquee></div>','style'=>'background:'.$row->color.' !important;color:#fff !important;');
				}else{
					$rows[] = 	array('data'=>$row->nama_judul,'style'=>'background:'.$row->color.' !important;color:#fff !important;');
				}
				$rows[] = 	array('data'=>tanggal($row->tgl_mulai).' <span class="badgex"> s.d </span>','style'=>'text-align:center;background:'.$row->color.' !important;color:#fff !important;');
				
				$this->table->add_row($rows);

					
				$no++;
			}
			$tabel4 = $this->table->generate();
		}else{
			$tabel4 = '<div class="alert">Data masih kosong ...</div>';
		}

		$data['minggu_depan'] = $tabel4;
		// --  kegiatan bulan depan


        //load the view
        $this->load->view('tigris/ajax-galeri-data-4', $data, false);
    }
	// ./ajax kegiatan bulan depan


	function ajaxPaginationGAL1(){
		$page = $this->input->post('pageGAL1', TRUE);
		// cek($page);

        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		
        // galeri
	      
		  
		
        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>1,'aktif'=>1),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL1';
        $config_gal['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL1';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal1->initialize($config_gal);
        
        //get the posts data
        $data['foto'] = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>1,'aktif'=>1),
		            'order' => 'id_teks DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('tigris/ajax-galeri-data-1', $data, false);
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
	      
		  
        // ./galeri

        $totalRec_gal = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>2,'aktif'=>1),
		          ))->num_rows();


        //pagination configuration
        $config_gal['target']      = '#postGAL2';
        $config_gal['base_url']    = base_url().'tigris/Ids_jadwal/ajaxPaginationGAL2';
        $config_gal['total_rows']  = $totalRec_gal;
        $config_gal['per_page']    = 1;
       	$config_gal['uri_segment'] = '4';
        
        $this->ajax_pagination_gal2->initialize($config_gal);
        
        //get the posts data
        $data['foto_kanan'] = $this->general_model->datagrab(array(
		            'tabel' => 'teks',
					'where' => array('status'=>2,'aktif'=>1),
		            'order' => 'id_teks DESC',
		            'offset'=>$offset,
		            // 'offset'=>6,
		            'limit'=>1,
		            
		          ));
        // cek($data['foto']->num_rows());
        // cek($this->db->last_query());
        // cek($page);

        // ./KIRI
        
        //load the view
        $this->load->view('tigris/ajax-galeri-data-2', $data, false);
	}
	// ./galeri kanan





	function jadwal_json(){
		$in = $this->input->post();

		$mulai = date('Y-m-d', strtotime($this->input->post('start')));
		$selesai = date('Y-m-d', strtotime($this->input->post('end')));
		$mulai_q = date('m', strtotime($this->input->post('start')));
		$selesai_q = date('m', strtotime($this->input->post('end')));
		$selesai_t = date('Y', strtotime($this->input->post('end')));
		$awal = date('Y-m-01'); // hard-coded '01' for first day
		$akhir  = date('Y-m-t');

		$m_start = date('m', strtotime($in['start']));
		$m_end = date('m', strtotime($in['end']));

		$md_start = date('m-d', strtotime($in['start']));
		$md_end = date('m-d', strtotime($in['end']));

		$m = date('m', strtotime(date('Y-m', strtotime($in['end'])) . '- 1 month'));
		/*cek($mulai);
		cek($selesai);
		cek($mulai_q);
		cek($selesai_q);
		die();*/
		$from = array(
			'jadwal_ujian tj' => ''
		);

		//$where = array('tgl_mulai >="'.$mulai.'"'=>null, 'MONTH(tgl_mulai) <"'.$selesai_q.'"'=>null);
		$select = '';
		$where = array('(tgl_mulai >="'.$in['start'].'" AND tgl_mulai <="'.$in['end'].'") OR (MONTH(tgl_mulai) = "'.$m_start.'" OR MONTH(tgl_mulai)) AND (tgl_mulai BETWEEN "'.$in['start'].'" AND "'.$in['end'].'" OR tgl_mulai BETWEEN "'.$in['start'].'" AND "'.$in['end'].'")'=>null);

		$jadwal= $this->general_model->datagrab(array('tabel'=>$from, 'where'=>$where, 'order'=>'tj.tgl_mulai ASC','select'=>$select));
		/*cek($this->db->last_query()); die();*/
		$store = array();
		$table = null;

		if ($jadwal->num_rows() > 0) {
			foreach ($jadwal->result() as $row) {
				$store[] = array(
					'title'=>$row->nama_judul,
					'start'=>date('Y-m-d', strtotime($row->tgl_mulai)),
					'end'=>date('Y-m-d', strtotime($row->tgl_mulai.' +1 day')),
					'backgroundColor' => $row->color,
					'borderColor' => $row->color,
					'rendering' => 'background'

					);

				$table .= '<div id="external-events">
                  <div class="external-event ui-draggable" style="position: relative;color:#fff !important;background:'.$row->color.'">'.$row->nama_kegiatan.'</div>
                </div>';
			}

		}else{
			$store[] = array(
				/*'title'=>'tidak ada event',*/
					'start'=>date('Y-m-d'),
					'end'=>date('Y-m-d'),
					'backgroundColor' => 'transparent',
					'borderColor' => 'transparent'
					);
			$table .= 'Tidak ada Rincian Kegiatan';

		}

		// $store_array = array($store);
		$data = array(
			'calendar'=>$store,
			'table_kiri'=>$table
			);

		die(json_encode($data));

		// {
  //             title: 'All Day Event',
  //             start: new Date(y, m, d),
  //             backgroundColor: "#f56954", //red
  //             borderColor: "#f56954" //red
  //           }
	}	

	function ajax_musik() {
		$musik = '';
	}

	function ajax_fotokiri(){
		
      	
		$fotoxx = $this->general_model->datagrab(array(
		'tabel'=> 'teks',
		'where' => array('status'=>1),
		'order' => 'id_teks desc'));
		$data ='';
		$data .= '<script type="text/javascript" src="'.base_url('assets/js/wowslider.js').'"></script>
				<script type="text/javascript" src="'.base_url('assets/js/script.js').'"></script>';
		foreach ($fotoxx->result() as $f) {
			$jmlx=strlen($f->judul);
			$kata = strlen($f->judul);
			if($kata > 50){
				$judul = "<marquee>".$f->judul."</marquee>";
			}else{
				$judul = $f->judul;
			}
			$data .= 
				'
													<li style="width: 10%;">
					<img src="'.base_url('uploads/tvinfo/'.$f->foto).'"  title="'.$judul.'" id="wows1_0" style="visibility: visible;">
				</li>
				';
        }
        
        die(json_encode($data));
	}
	function ajax_tgl() {
		$tgl = date_indox(date('Y-m-d'),2);
		$data =array();
		$data[] = array(
			'tgl'=>$tgl
			);
		die(json_encode($data));
	}
	


	
	function get_durasi($id){
/*
		$row = $this->general_model->datagrab(array(
				'tabel'=> 'sch_widget',
			'where' => array('id_widget'=>$id)
			))->row();*/
		$durasi  = !empty(@$row) ? 0.05 : 0.05;
		die(json_encode($durasi));
	}
	function teksbergerak() {
		$par = $this->general_model->get_param(array('pemerintah_logo','pemerintah','instansi'),2);
		$mar = $this->general_model->datagrab(array(
			'tabel'=> 'teks','limit' => 10,'offset' => 0));
		
		echo '
		<marquee class="marquee-box">
			<div >'; 
					$j = 1;
					foreach($mar->result() as $m) { 
						$star = ($j > 1) ? '&nbsp;&nbsp;<img src="'.base_url('uploads/logo/'.$par['pemerintah_logo']).'" height="50">&nbsp;&nbsp; ': null;
						echo ''.$star.'<b>'.$m->teks.'</b> ';
						$j+=1;
					}
			echo '
			</div>
		</marquee>';
		
		
	}
	
	function unitbingkai() {
		
		$data['kiri'] = $this->general_model->datagrab(array(
			'tabel'=> 'sch_widget',
			'limit' => 10,
			'offset' => 0,
			'where' => array('pos' => 1),
			'order' => 'urut'));	
			
		$this->load->view('tigris/tv_unitbingkai_view',$data);
		
	}

	function get_durasi_sc($durasi, $st_data = 0, $tot=0){
		
		$data = '<script type="text/javascript">';

		if ($st_data == 1) { 
			$data .='
				var st_data = 1;
				var durasi = 4;
				
				var lf = 2;
				var max_lf = '.$tot.';

				setInterval(
				function() {
					
					if (parseInt(lf) == 1) $(\'#lf\'+max_lf).hide();
					else $(\'#lf\'+parseInt(lf-1)).hide();
					
					$(\'.no_kiri\').html(lf).show();
					$(\'#no_kiri\').attr(\'value\',lf);
					$(\'#lf\'+lf).fadeIn();
					
					if (parseInt(lf) == max_lf) lf = 1;
					else lf+=1;		

					$.ajax({
						url: \''.site_url("tigris/Ids_jadwal/get_durasi/").'/\'+ lf,
						method: \'GET\',
						dataType:"JSON",
						success: function(msg) {
							durasi = msg;
							store_int(durasi);
							get_durasi_sc(durasi, st_data, max_lf);
							console.log(durasi);
						},error:function(error){
							show_error(\'ERROR : \'+error).show();
						}
					});
				},

				parseFloat('.$durasi.')*60000);

				$(\'#lf1\').fadeIn();
				$(\'.no_kiri\').html(1).show();
			';

		} else {
			
		$data .= "$('#lf1').fadeIn();";
	
		}
	
		$data .='</script>';

		die(json_encode($st_dat));
		
	}
	
}
