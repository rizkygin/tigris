<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Barang_Model extends CI_Model {
	
	var $tabel = 'ref_barang_aset';
	
	function data_list($jenis = null, $level = null, $id = null, $is_child = null) {
	
		if (!empty($level)) $this->db->where('level',$level);
		if (!empty($id)) $this->db->where('id_brg',$id);
		if (!empty($jenis)) $this->db->where('jenis',$jenis);
		if (!empty($is_child)) $this->db->where('is_child',$is_child);
		$this->db->order_by('kode_barang');
        return $this->db->get($this->tabel);
		
    }
	
	function getListBarang($set = null,$likely=null) {
		if ($set == '1') $this->db->like('kode_barang', $likely); 
		else $this->db->like('nama_Barang', $likely); 
		$this->db->order_by('kode_Barang');
        return $this->db->get($this->tabel)->result();
	}
	
	function getListBarangChild($set = null,$likely=null) {
		if ($set == '1') $this->db->like('kode_barang', $likely); 
		else $this->db->like('nama_Barang', $likely); 
		$this->db->where('is_child','1');
		$this->db->order_by('kode_Barang');
        return $this->db->get($this->tabel)->result();
	}
	
	function get_anggarankas($limit = null, $offset = null, $likely = null ) {

		if (!empty($likely)) $this->db->like('nama_barang', $likely); 
		$this->db->where('is_child','1');
		if (isset($limit) and isset($offset)) $this->db->limit($limit,$offset);
		$this->db->order_by('kode_Barang');
        return $this->db->get($this->tabel);
	}
	
	function save_barang($data, $id) {
        if (!empty($id)) {
            $this->db->where('id_brg', $id);
            $this->db->update($this->tabel, $data);
        } else {
            $this->db->insert($this->tabel, $data);
        }
    }
	
	function cekBarangAnak($id) {
		$this->db->where('id_brg_parent',$id);
		return $this->db->get($this->tabel);
	}
	
	function notchildBarang($id) {
		$data = array('is_child' => '0');
		$this->db->where('id_brg',$id);
		$this->db->update($this->tabel,$data);
	}
	
	function makeParents($id) {
	    $data = array('is_child' => '1');
	    $this->db->where('id_brg',$id);
	    $this->db->update($this->tabel,$data);
	}
	
	function delete_barang($id) {
		$getParents = $this->data_list(null,null,null,$id)->row();
	
        $this->db->where('id_brg', $id);
        $this->db->delete($this->tabel);
		
		if (!empty($getParents)) {
			if ($this->cekBarangAnak($getParents->id_brg_parent)->num_rows() == 0) $this->makeParents($getParents->id_brg_parent);
		}

    }

}
