<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Pengaturan extends CI_Controller {
	
	var $dircut = 'referensi';
	var $param = array(
			'aplikasi',
			'aplikasi_code',
			'aplikasi_s',
			'aplikasi_logo',
			'aplikasi_logo_only',
			'aplikasi_logo_ext',
			'ibukota',
			'alamat',
			'pemerintah',
			'pemerintah_s',
			'pemerintah_logo',
			'pemerintah_logo_bw',
			'instansi',
			'instansi_s',
			'instansi_code',
			'copyright',
			'multi_unit',
			'demo',
			'login_captcha',
			'default_pass',
			'main_color',
			'theme_pinta',
			'theme_data',
			'foto_latar_login');
	
	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));

	}

	public function index() {
	
		$this->form_profil();
		
	}

	function get_app() {
		
		$app_active = $this->general_model->get_param('app_active');
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi',
			'where' => array('id_aplikasi IN ('.$app_active.') AND aktif = 1' => null)));

	}

	function form_profil() {
	
		$data['title'] = 'Pengaturan Parameter';
		$data['breadcrumb'] = array('' => 'Pengaturan', 'umum/profil' => 'Umum');
        if (!empty($this->dircut)) $data['dircut'] = $this->dircut;
        
		$app = $this->get_app();
		$tab = array();
		foreach($app->result() as $ap) {
		$tabulate = load_controller($ap->folder,'parameter_'.$ap->folder,'tab');
		
		if (!empty($tabulate)) {
			$tabulate = array_merge_recursive($tabulate,array('folder' => $ap->folder,'nama' => $ap->nama_aplikasi));
			$tab[] = $tabulate;
			}
		}
		
		$data['tab'] = $tab;
		$data['content'] = "umum/umum_view";
		$this->load->view('home', $data);
	}
	
	function save_setting() {
	
		$app = $this->get_app();
		$tab = array();

		foreach($app->result() as $ap) { load_controller($ap->folder,'parameter_'.$ap->folder,'save_data'); }
		
		$this->session->set_flashdata('ok','Penyimpanan pengaturan umum berhasil dilakukan');
		redirect('inti/pengaturan');
		
	}
	
	function parameter() {

		$data['breadcrumb'] = array('' => 'Manajemen', 'inti/pengaturan/pengaturan' => 'Pengaturan Parameter');

		$data['got'] = $this->general_model->get_param($this->param,2);

		$data['title'] 	 = '<i class="fa fa-cog"></i> &nbsp; Pengaturan Dasar';
		$data['content'] = "umum/parameter_view";
		$this->load->view('home', $data);
	}
	
	function dir_check($dir) {
		
		$path = './uploads/'.$dir;
		if (!is_dir($path)) mkdir($path,0777,TRUE);
		
	}
	
	function save_aturan() {
		$this->dir_check('logo');
		
		$param = $this->input->post('param');
		$vale = $this->input->post('vale');
		$i = 0;
		$simpan = array();
		foreach ($param as $p) {
			if ($param[$i] == "aplikasi_logo") {
				if (!empty($_FILES['logo_app']['name'])) {
		
					$logo_app_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_app_logo = FCPATH.'uploads/logo/'.$logo_app_lama->row('val');
					if (file_exists($path_app_logo)) unlink($path_app_logo);
					$path_appthumb_logo = FCPATH.'uploads/logo/thumbnails/'.$logo_app_lama->row('val');
					$delete_thumb = unlink($path_appthumb_logo);
					
					$config['upload_path'] = './uploads/logo/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']	= '1000000';
					$config['max_width']  = '1024000';
					$config['max_height']  = '7680000';
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('logo_app')){
						$data['error'] = $this->upload->display_errors();
						echo $data['error'];
					} else {
						$data = $this->upload->data();
						$vale[$i] = $data['file_name'];
						$konfigurasi = array(
							'source_image'=>$data['full_path'],
							'new_image'=>'./uploads/logo/thumbnails/',
							'maintain_ration' => true,
							'width' => 400,
							'height' =>300
							);
						$this->load->library('image_lib', $konfigurasi);
						$this->image_lib->resize();
					}
					
				}
				
				if ($this->input->post('reset_logo')) {
					$logo_app_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_app_logo = FCPATH.'uploads/logo/'.$logo_app_lama->row('val');
					if (file_exists($path_app_logo)) unlink($path_app_logo);
					$path_appthumb_logo = FCPATH.'uploads/logo/thumbnails/'.$logo_app_lama->row('val');
					$delete_thumb = unlink($path_appthumb_logo);
				}
			} else if ($param[$i] == "pemerintah_logo") {
				if (!empty($_FILES['logo_pemerintah']['name'])) {
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'uploads/logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'uploads/logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
		
					$config['upload_path'] = './uploads/logo/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']	= '1000000';
					$config['max_width']  = '1024000';
					$config['max_height']  = '7680000';
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('logo_pemerintah')){
						$data['error'] = $this->upload->display_errors();
						echo $data['error'];
					}else {
						$data = $this->upload->data();
						$vale[$i] = $data['file_name'];
						$konfigurasi = array(
							'source_image'=> $data['full_path'],
							'new_image'=>'./uploads/logo/thumbnails/',
							'maintain_ration' => true,
							'width' => 400,
							'height' =>300
							);
						$this->load->library('image_lib', $konfigurasi);
						$this->image_lib->resize();
					}
					
				}
				if ($this->input->post('reset_logo_pemerintah')) {
		
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'uploads/logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'uploads/logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
				}
			} else if ($param[$i] == "pemerintah_logo_bw") {
				if (!empty($_FILES['logo_pemerintah_bw']['name'])) {
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'uploads/logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'uploads/logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
		
					$config['upload_path'] = './uploads/logo/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']	= '1000000';
					$config['max_width']  = '1024000';
					$config['max_height']  = '7680000';
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('logo_pemerintah_bw')){
						$data['error'] = $this->upload->display_errors();
						echo $data['error'];
					}else {
						$data = $this->upload->data();
						$vale[$i] = $data['file_name'];
						$konfigurasi = array(
							'source_image'=>$data['full_path'],
							'new_image'=>'./uploads/logo/thumbnails/',
							'maintain_ration' => true,
							'width' => 400,
							'height' =>300
							);
						$this->load->library('image_lib', $konfigurasi);
						$this->image_lib->resize();
					}
					
				}
				if ($this->input->post('reset_logo_pemerintah')) {
		
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'uploads/logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'uploads/logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
				}
			} else  if ($param[$i] == "foto_latar_login") {
				if (!empty($_FILES['foto_latar_login']['name'])) {
					$logo_app_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					$vv = $logo_app_lama->row('val');
					if ($vv != NULL) {
					$path_app_logo = FCPATH.'uploads/backdrop/'.$logo_app_lama->row('val');
					if (file_exists($path_app_logo)) unlink($path_app_logo);
					$path_appthumb_logo = FCPATH.'uploads/backdrop/'.$logo_app_lama->row('val').'_thumbs';
					$delete_thumb = unlink($path_appthumb_logo);
					}
					
					$config['upload_path'] = './uploads/backdrop';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']	= '1000000';
					$config['max_width']  = '1024000';
					$config['max_height']  = '7680000';
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('foto_latar_login')){
						$data['error'] = $this->upload->display_errors();
					} else {
						$data = $this->upload->data();
						$vale[$i] = $data['file_name'];
						/*$konfigurasi = array(
							'source_image'=> $data['full_path'],
							'file_name' => $data['file_name'].'_thumbs',
							'new_image'=>'./uploads/backdrop',
							'maintain_ration' => true,
							'width' => 400,
							'height' =>300
							);
						$this->load->library('image_lib', $konfigurasi);
						$this->image_lib->resize();*/
					}
					
				}
			
			} 
			
			
			$g = $this->general_model->datagrab(array('tabel' => 'parameter','where' => array('param' => $param[$i])));
			if ($g->num_rows() > 0) $this->general_model->save_data(array('tabel' => 'parameter','data' => array('val' => $vale[$i]),'where' => array('param' => $param[$i])));
			else $this->general_model->save_data(array('tabel' => 'parameter','data' => array('param' => $param[$i],'val' => $vale[$i])));

			$i+=1;
		}
		
		/* demo */
		$param  = 'demo';
		$val = $this->input->post('demo'); 
		$g = $this->general_model->datagrab(array('tabel' => 'parameter','where' => array('param' => $param)));
		if ($g->num_rows() > 0) $this->general_model->save_data(array('tabel' => 'parameter','data' => array('val' => $val),'where' => array('param' => $param)));
		else $this->general_model->save_data(array('tabel' => 'parameter','data' => array('param' => $param,'val' => $val)));

		$param  = 'multi_unit';
		$val = $this->input->post('multi_unit'); 
		$g = $this->general_model->datagrab(array('tabel' => 'parameter','where' => array('param' => $param)));
		if ($g->num_rows() > 0) $this->general_model->save_data(array('tabel' => 'parameter','data' => array('val' => $val),'where' => array('param' => $param)));
		else $this->general_model->save_data(array('tabel' => 'parameter','data' => array('param' => $param,'val' => $val)));
		
		$param  = 'login_captcha';
		$val = $this->input->post('login_captcha'); 
		$g = $this->general_model->datagrab(array('tabel' => 'parameter','where' => array('param' => $param)));
		if ($g->num_rows() > 0) $this->general_model->save_data(array('tabel' => 'parameter','data' => array('val' => $val),'where' => array('param' => $param)));
		else $this->general_model->save_data(array('tabel' => 'parameter','data' => array('param' => $param,'val' => $val)));
		
		$param  = 'aplikasi_logo_only';
		$val = $this->input->post('aplikasi_logo_only'); 

		$g = $this->general_model->datagrab(array('tabel' => 'parameter','where' => array('param' => $param)));
		if ($g->num_rows() > 0) $this->general_model->save_data(array('tabel' => 'parameter','data' => array('val' => ($val == 0?NULL:$val)),'where' => array('param' => $param)));
		else $this->general_model->save_data(array('tabel' => 'parameter','data' => array('param' => $param,'val' => $val)));

		$this->session->set_flashdata('ok','Pengaturan berhasil disimpan');
		redirect('inti/pengaturan/parameter');
	}

	function reset_pengaturan() {
		
		$param = $this->param;
			
		for($i = 0; $i < count($param); $i++) {
			$this->general_model->delete_data('parameter','param',$param[$i]);
		}
		
		/*-- Init Aplikasi --*/
		
		$appdata = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('aktif' => 1)));

		$app_active = array();
		foreach($appdata->result() as $res) {
			$path = './application/controllers/'.$res->folder;
			if(file_exists($path)) $app_active[] = $res->id_aplikasi;
		}
		
		$par = $this->general_model->get_param($param,1);	

		for($i = 0; $i < count($param); $i++) {
			if (!in_array($param[$i],$par)) {
			$conf = @$this->config->config[$param[$i]];
				if (!empty($conf)) {
					$simpan = array(
						'param' => $param[$i],
						'val' => $conf
					); $this->general_model->save_data('parameter',$simpan);

				}
			}
		}	

		$active = $this->general_model->get_param('app_active');
		
		if (empty($active)) $this->general_model->save_data('parameter',array('param' => 'app_active','val' => implode(',',$app_active)));
		else $this->general_model->save_data('parameter',array('val' => implode(',',$app_active)),'param','app_active');
		
		// Inisialisasi Logo
		
		$this->load->helper('directory');
		$map = directory_map('./uploads/logo/', 1);
		
		foreach($map as $o) {
			if (preg_match("/\./i", $o)) unlink('./uploads/logo/'.$o);
		}
		
		$this->session->set_flashdata('ok','Reset Pengaturan berhasil dilakukan');
		redirect('inti/pengaturan/parameter');
		
	}
	
}