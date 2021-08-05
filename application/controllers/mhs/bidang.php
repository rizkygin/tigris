<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Bidang extends CI_Controller {

	var $dir = 'schedul';
	
	function __construct() {
	
		parent::__construct();
		
	}
	
	public function index() {
		
		$this->list_unit();
	
	}
	
	function in_app() {
		
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
		
	}
	
	function list_unit($offset = null) {

		$total_unit =  $this->general_model->datagrab(array('tabel'=>'ref_unit'));
		
		if ($total_unit->num_rows() == 1) {
	
			redirect($this->dir.'/bidang/tabel_bidang/'.in_de(array('id' => $total_unit->row()->id_unit)));
		
		} else {
		
			$data['breadcrumb'] = array('' => $this->dir, $this->dir.'/bidang' => 'Unit Organisasi');
			
			$data['tabel'] = load_controller('inti','unitkerja','list_unit',in_de(array('dir' => $this->dir,'link' => $this->dir.'/bidang/tabel_bidang/')));
			$data['title'] = 'Daftar Unit Kerja';
			$data['content'] = "umum/standard_view";
			$this->load->view('home', $data);
			
		}
	}
	
	
	function tabel_bidang($o = null) {

		/* Urutkan */
		
		$o = un_de($o);
	
		$unit_data = $this->general_model->datagrab(array(
			'tabel'=> 'ref_unit',
			'where' => array('id_unit' => $o['id']),
			'order' => 'urut'
		))->row();

		$data['breadcrumb'] = array('' => $this->in_app(), $this->dir.'/bidang' => 'Daftar Unit Organisasi');
		if (!empty($o['redir'])) $data['dir_cut'] = $o['redir'];

		$data['title']		= 'Unit Organisasi pada '.$this->in_app();
		$data['content']	= 'umum/standard_view';
		
		$btn_bid_root = anchor('#','<i class="fa fa-plus-square"></i> &nbsp; Unit Organisasi','class="btn btn-xs btn-edit btn-success" act="'.site_url($this->dir.'/bidang/add_bidang/'.in_de(array('level_bidang' => '1','id_unit' => $o['id']))).'"');
		
		$data['tabel'] = load_controller('inti','unitorganisasi','list_bidang',array('id' => $o['id'],'dir' => $this->dir));
		
		$data['extra_tombol'] = '<h4 class="box-title pull-right">'.$unit_data->unit.'</h4>';
		$data['tombol'] = anchor($this->dir.'/bidang/list_unit/','<i class="fa fa-arrow-left"></i> Daftar Unit Kerja/SKPD','class="btn btn-default"');
		if ($this->session->flashdata('balik')) $data['tombol'].= ' &nbsp; '.anchor($this->dir.'/unit','<i class="fa fa-arrow-left"></i> Kembali Pindahkan Unit','class="btn btn-primary"');
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function pindah_kosong($p) {
		
		load_controller('inti','unitorganisasi','pindah_kosong',$this->dir,$p);
	
	}
	
	function pindah_bidang($p) {
		
		load_controller('inti','unitorganisasi','pindah_bidang',$this->dir,$p);
	
	}
	
	function add_bidang($param) {
		
		load_controller('inti','unitorganisasi','add_bidang',$this->dir,$param);
	
	}

	function removing($par){
		
		load_controller('inti','unitorganisasi','removing',$this->dir,$par);
		
	}
	
	function urutkan($par) {
		
		load_controller('inti','unitorganisasi','urutkan',$this->dir,$par);
	
	}
}