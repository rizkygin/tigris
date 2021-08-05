<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	var $dir = 'tigris';
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

	}

	function cr($e) {
	    return $this->general_model->check_role($this->id_petugas,$e);
    }

    function sekolah($u) {
    	return $this->general_model->cek_sekolah($u);
    }

	public function index() {
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
		$data['Penjadwalan'] = $this->general_model->datagrab(array('tabel' => 'jadwal_tesis'))->num_rows();
		$data['operator'] = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where'=>array('id_pegawai !='=>1)))->num_rows();

	



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
