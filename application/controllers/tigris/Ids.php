<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ids extends CI_Controller {

	var $dir = 'tigris';

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
	}

	public function index() {
		
		$this->paging();
		
	}
	
	function simpan_param($par,$dat) {
		$this->general_model->save_data('parameter',array('param' => $par,'val'=> $dat));
	}
	
	function ubah_param($par,$dat) {
		$this->general_model->save_data('parameter',array('val' => $dat),'param',$par);
	}
	
	
	function save_data() {

		foreach($this->param as $o) {
			
			$g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $o)));
			if ($g->num_rows() > 0) $this->ubah_param($o,$this->input->post($o));
			else $this->simpan_param($o,$this->input->post($o));
			
		}
	
	}
	
	function paging() {
		
		$data['breadcrumb'] = array('' => 'Pengaturan', $this->dir.'/Ids' => 'Parameter');
		$data['title'] = 'Pengaturan Umum';
		
		$data['vals'] = $this->general_model->get_param(array(
			'all_reload','durasi_agenda_kegiatan','durasi_agenda_bulan_ini','durasi_agenda_bulan_depan',
			'durasi_galeri_kiri','durasi_galeri_kanan','sch_warna_latar','sch_warna_header','sch_warna_teks_header',
			'sch_warna_judul','sch_warna_teks_judul'),2);

		$title = 'Pengaturan Layout';
		$tab1 = array('text'=>'Umum', 'on'=>1, 'url'=>site_url($this->dir.'/Ids/paging/'));
		$tab2 = array('text'=>'2 Kolom', 'on'=>NULL, 'url'=>site_url($this->dir.'/Ids/dua_kolom/'));
		$tab3 = array('text'=>'3 Kolom', 'on'=>NULL, 'url'=>site_url($this->dir.'/Ids/tiga_kolom/'));
		$data['title'] 		= $title;
		$data['tabs'] = array($tab1, $tab2,$tab3);
		$data['content'] = $this->dir.'/ids_view';
		$this->load->view('home',$data);
		
	}
	
	function dua_kolom() {
		
		$data['breadcrumb'] = array('' => 'Pengaturan', $this->dir.'/Ids' => 'Parameter');
		$data['title'] = 'Pengaturan 2 Kolom';
		
		$data['vals'] = $this->general_model->get_param(array(
			'height_agenda_1','height_agenda_bulan_ini_1','height_agenda_bulan_depan_1','height_pengumuman_1','height_kalender_1','height_galeri_1'),2);

		$title = 'Pengaturan Layout';
		$tab1 = array('text'=>'Umum', 'on'=>NULL, 'url'=>site_url($this->dir.'/Ids/paging/'));
		$tab2 = array('text'=>'2 Kolom', 'on'=>1, 'url'=>site_url($this->dir.'/Ids/dua_kolom/'));
		$tab3 = array('text'=>'3 Kolom', 'on'=>NULL, 'url'=>site_url($this->dir.'/Ids/tiga_kolom/'));
		$data['title'] 		= $title;
		$data['tabs'] = array($tab1, $tab2,$tab3);
		$data['content'] = $this->dir.'/ids_dua_kolom';
		$this->load->view('home',$data);
		
	}
	
	function tiga_kolom() {
		
		$data['breadcrumb'] = array('' => 'Pengaturan', $this->dir.'/Ids' => 'Parameter');
		$data['title'] = 'Pengaturan 3 Kolom';
		
		$data['vals'] = $this->general_model->get_param(array(
			'height_agenda_2','height_agenda_bulan_ini_2','height_agenda_bulan_depan_2','height_pengumuman_2','height_kalender_2','height_galeri_2'),2);

		$title = 'Pengaturan Layout';
		$tab1 = array('text'=>'Umum', 'on'=>NULL, 'url'=>site_url($this->dir.'/Ids/paging/'));
		$tab2 = array('text'=>'2 Kolom', 'on'=>NULL, 'url'=>site_url($this->dir.'/Ids/dua_kolom/'));
		$tab3 = array('text'=>'3 Kolom', 'on'=>1, 'url'=>site_url($this->dir.'/Ids/tiga_kolom/'));
		$data['title'] 		= $title;
		$data['tabs'] = array($tab1, $tab2,$tab3);
		$data['content'] = $this->dir.'/ids_tiga_kolom';
		$this->load->view('home',$data);
		
	}
	
	function simpan() {
		
		$keys = $this->input->post('keys');
		$vals = $this->input->post('vals');
		
		for ($i = 0; $i < count($keys); $i++) {
			$g = $this->general_model->datagrab(array('tabel' => 'parameter', 'where' => array('param' => $keys[$i])));
			if ($g->num_rows() > 0) $this->ubah_param($keys[$i],$vals[$i]);
			else $this->simpan_param($keys[$i],$vals[$i]);
		}
		
		$this->session->set_flashdata('ok','Pengaturan umum berhasil disimpan ...');
		redirect($this->dir.'/Ids');
		
	}
	
}
