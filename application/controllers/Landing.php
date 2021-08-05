<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {


	var $param = array(
			'aplikasi',
			'aplikasi_code',
			'aplikasi_s',
			'aplikasi_logo_ext',
			'aplikasi_logo_only',
			'aplikasi_logo',
			'pemerintah',
			'pemerintah_s',
			'pemerintah_logo',
			'pemerintah_logo_bw',
			'pemerintah_logo_ext',
			'ibukota',
			'alamat',
			'instansi',
			'instansi_s',
			'instansi_code',
			'copyright',
			'multi_unit',
			'theme_pinta',
			'theme_data',
			'main_color',
			'foto_latar_login');

	function __construct() {
	
		parent::__construct();
		$this->load->model('login_model');
		
	}
	
	public function index() {		
		$this->landings();
	}
	
	
	function landings() {
		$data = '';
		$this->load->view('landing',$data);
	}
}