<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Simas_model extends CI_Model {

	function data_list($tabel, $limit = null, $offset = null, $column = null, $id = null, $column_order = null) {

		$this->db->from($tabel);
		if (!empty($id)) $this->db->where($column,$id);
		if (!empty($limit) || !empty($offset)) $this->db->limit($limit,$offset);
		if(!empty($column_order)) $this->db->order_by($column_order, 'asc');
        return $this->db->get();
   
	}

	
	function save_data($tabel, $data, $column = null, $id = null,$orwhere = null){
    	if (!empty($id)) {
		    if(is_array($id)) {
				$this->db->where($id);
				if(!empty($orwhere)) $this->db->or_where($id);
			}else{	
				$this->db->where($column,$id);
			}
			
			return $this->db->update($tabel,$data);    		
    	} else {
    		return $this->db->insert($tabel,$data);	
    	}    	
		
    }
	
	function delete_data($tabel, $column=null, $id=null, $ids=null) {
		
		if(is_array($ids)) {
		    $ids = array_filter($ids);
			foreach($ids as $singleid){
				$this->db->or_where($column,$singleid);
			}
		}else if(is_array($column)){
			$this->db->where($column);
		}else{	
			$this->db->where($column,$id);
		}
		
		return $this->db->delete($tabel);		
	}
	
	function reset_status($tabel, $column, $id){
		$this->db->where($column,$id);
		return $this->db->update($tabel,array('status'=>''));
	}

	function datagrab($param) {
		
		if(!empty($param['select'])) $this->db->select($param['select'],false);
		!empty($param['tipe_join'])?$tipe=$param['tipe_join']:$tipe='';
		if (is_array($param['tabel'])) {	
			$n = 1;
			foreach($param['tabel'] as $tab => $on) {
	
				if ($n > 1) {
					if (is_array($on)) $this->db->join($tab,$on[0],$on[1],$tipe);
					else $this->db->join($tab,$on,$tipe);
				} else { $this->db->from($tab); }
				$n+=1;
			}
		} else {
		$this->db->from($param['tabel']);
		}
		if (!empty($param['where'])) {
			foreach($param['where'] as $w => $an) {
				if (!empty($an)) $this->db->where($w,$an);
				else $this->db->where($w,null,false);
			}
		}
		if (!empty($param['limit']) || !empty($param['offset'])) $this->db->limit($param['limit'],$param['offset']);
        if (!empty($param['order'])) $this->db->order_by($param['order']);
		if (!empty($param['search'])) {
			foreach($param['search'] as $sc => $vl) {
				$this->db->or_like($sc,$vl);
			}
		}
		if (!empty($param['group_by'])) $this->db->group_by($param['group_by']);
        return $this->db->get();
	}
	
	function combo_box($param) {
		if (is_array($param['tabel'])) {
			!empty($param['tipe_join'])?$tipe=$param['tipe_join']:$tipe='';
			$n = 1;
			foreach($param['tabel'] as $tab => $on) {
				if ($n > 1) $this->db->join($tab,$on,$tipe);
				else $this->db->from($tab);
				$n+=1;
			}
		} else {
			$this->db->from($param['tabel']);
		}
		
		if (!empty($param['where'])) {
	
			foreach($param['where'] as $w => $an) {
				if (!empty($an)) $this->db->where($w,$an);
				else $this->db->where($w,null,false);
			}
		}

		
		if (!empty($param['order'])) $this->db->order_by($param['order']);
		else $this->db->order_by($param['val'][0]);

		$data_combo = $this->db->get();
       
		$combo = array('' => !empty($param['pilih'])?$param['pilih']:'-- Pilih --');
        foreach($data_combo->result() as $row) {
			$valueb = array();
			foreach($param['val'] as $v) { $valueb[] = $row->$v; }
			$keyb = array();
			if (is_array($param['key'])) {
				foreach($param['key'] as $k) { $keyb[] = (strlen($row->$k) > 100)?substr($row->$k,0,100).' ...':$row->$k; }
			}
			$keyv = is_array($param['key']) ? implode("|",$keyb) : $row->$param['key'];
		
			$combo[$keyv] = implode(" ",$valueb);
		} return $combo;  
		
	}	
	
	//Khusus simas
	function save_data_kib($tabel, $data_kib, $data_gabungan, $column = null, $id = null, $id_gab = null, $orwhere = null, $jml_brg = 1){
    	if (!empty($id)) {
    		if(is_array($id) && empty($orwhere)){
				$this->db->where($id);
			}else if(is_array($id) && !empty($orwhere)){
				$this->db->or_where($id);
			}else{	
				$this->db->where($column,$id);
			}
			$this->db->update($tabel,$data_kib);
			$this->db->where($id_gab);
			$this->db->update('simas_aset_gabungan',$data_gabungan);
		} else {
			for($x=1;$x<=$jml_brg;$x++){
				$register = reg($x);
				$data_kib['register']=$register;
				$this->db->insert($tabel,$data_kib);
				$last_id = $this->db->insert_id();
				$data_gabungan['id_kib'] = $last_id;
				$this->db->insert('simas_aset_gabungan',$data_gabungan);	
			}	
    	}    		
    }
	
	function delete_gabungan($tabel,$id,$cek,$kib){
		if(is_array($cek)){
			foreach($cek as $c){
				$this->db->or_where('id_kib',$c);
			}
		}else{
			$this->db->where('id_kib',$id);
		}
		
		$this->db->where('kib',$kib);
		$this->db->delete($tabel);	
	}
	
	function data_query($sql){
		return $this->db->query($sql);	
	}
	
}
