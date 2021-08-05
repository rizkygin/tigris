<?php

class ItemsHandler {
	var $output_int = 0;
	var $output_arr = array();
	function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('general_model');
	}  

	public function count_parent($par) {
		$where = array(
			'id_ref_kategori_paket'=>$par['id'],
			// 'parent IS NULL'=>null,
		);
		$dt = $this->ci->general_model->datagrabs(array(
			'tabel'=>array(
				'ref_kategori_paket a'=>''
			),
			'select'=>'id_ref_kategori_paket, (select count(id_produk) from produk it where it.id_ref_kategori_paket=a.id_ref_kategori_paket=0) produk, (select count(id_ref_kategori_paket) from ref_kategori_paket) child',
			'where'=>$where
		));

		if($dt->num_rows() > 0) foreach ($dt->result() as $row) {
			if($row->child == 0) $this->output_int += $row->produk;
			if($row->child > 0) $this->count_child($row->id_ref_kategori_paket);
		}
		// die();
		return $this->output_int;
	}

	public function count_child($par) {
		$dt = $this->ci->general_model->datagrabs(array(
			'tabel'=>array(
				'ref_kategori_paket a'=>''
			),
			'select'=>'id_ref_kategori_paket,(select count(id_produk) from produk it where it.id_ref_kategori_paket=a.id_ref_kategori_paket=0) produk, (select count(id_ref_kategori_paket) from ref_kategori_paket) child',
			'where'=>array('')
		));
		if($dt->num_rows() > 0) foreach ($dt->result() as $row) {
			if($row->child == 0) $this->output_int += $row->produk;
			if($row->child > 0) $this->count_child($row->id_ref_kategori_paket);
		}
	
		
	}
	

}