<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class General_model extends CI_Model {
	
	function save_data($tabel, $data = null, $column = null, $id = null){
    	if (is_array($tabel)) {
			if (!empty($tabel['where'])) {
    		$this->db->where($tabel['where']);
    		return $this->db->update($tabel['tabel'],$tabel['data']);
			} else {
				$this->db->insert($tabel['tabel'],$tabel['data']);
				return $this->db->insert_id();
			}
		} else {
			if (!empty($id)) {
				$this->db->where($column,$id);
				$this->db->update($tabel,$data);
			} else {
				$this->db->insert($tabel,$data);
				return $this->db->insert_id();	
			}    	
		}
    }

    function simpan_data($param) {
    	if (!empty($param['where'])) {
    		$this->db->where($param['where']);
    		return $this->db->update($param['tabel'],$param['data']);
    	} else {
    		$this->db->insert($param['tabel'],$param['data']);
    		return $this->db->insert_id();
    	}
    	//echo $this->db->last_query();
    }
	
	function delete_data($tabel, $column = null, $id = null) {
		if (is_array($tabel)) {
			foreach($tabel['where'] as $w => $an) {
				if (is_null($an)) $this->db->where($w,null,false);
                else $this->db->where($w,$an);
			}
			return $this->db->delete($tabel['tabel']);
		} else {
			if (!empty($column)) { 
				if (is_array($column)) $this->db->where($column);
				else $this->db->where($column,$id);
			}
			return $this->db->delete($tabel);
		}
	}
	
	function reset_status($tabel, $column, $id){
		$this->db->where($column,$id);
		return $this->db->update($tabel,array('status'=>''));
	}

	function datagrab($param) {
        if (!empty($param['select'])) $this->db->select($param['select'],false);
        if (is_array($param['tabel'])) {    
            $n = 1;
            foreach($param['tabel'] as $tab => $on) {
    
                if ($n > 1) {
                    if (is_array($on)) $this->db->join($tab,$on[0],$on[1]);
                    else $this->db->join($tab,$on);
                } else { $this->db->from($tab); }
                $n+=1;
            }
        } else {
        $this->db->from($param['tabel']);
        }
        if (!empty($param['where'])) {
            foreach($param['where'] as $w => $an) {
/*                if (!empty($an)) $this->db->where($w,$an);
                else $this->db->where($w,null,false);*/
// ini bikin error kalo empty jadi di ganti null
                if (is_null($an)){
                    $this->db->where($w,null,false);
                }else {
                    $this->db->where($w,$an);
                }

            }
        }
        if(@$param['not_in'])
        if(is_array($param['not_in'])){
        foreach($param['not_in'] as $w => $an) {
/*                if (!empty($an)) $this->db->where($w,$an);
                else $this->db->where($w,null,false);*/
// ini bikin error kalo empty jadi di ganti null
                if (is_null($an)){
                    $this->db->where_not_in($w,null,false);
                }else {
                    $this->db->where_not_in($w,$an);
                }

            }
        }else{
            $this->db->where_not_in($param['not_in'],$param['not_in_isi']);
        }
//ini tambahan yang nda harus pake offset
        if (!empty($param['limit']) && !empty($param['offset'])) $this->db->limit($param['limit'],$param['offset']);
        if (!empty($param['limit']) && empty($param['offset'])) $this->db->limit($param['limit']);
        if (!empty($param['order'])) $this->db->order_by($param['order']);
        if (!empty($param['search'])) {
            foreach($param['search'] as $sc => $vl) {
                $this->db->or_like($sc,$vl);
            }
        }
        if (!empty($param['group_by'])) $this->db->group_by($param['group_by']);
        return $this->db->get();
    }

    function datagrabs($param,$ret_sql=0) {
        #$this->db->cache_on();

        if (!empty($param['count'])) {

            if (!empty($param['search'])) {

                    if (!empty($param['select'])) {
                        $this->db->select($param['select'],false);
                    }else{
                        $this->db->select('*',false);
                    }

            }else{
                 $this->db->select($param['count'],false);
            }

        }elseif(!empty($param['select'])) {
            $this->db->select($param['select'],false);
        }
        
        if (is_array($param['tabel'])) {    
            $n = 1;
            foreach($param['tabel'] as $tab => $on) {
    
                if ($n > 1) {
                    if (is_array($on)) $this->db->join($tab,$on[0],$on[1]);
                    else $this->db->join($tab,$on);
                } else { 
                    $this->db->from($tab); 
                }
                $n+=1;
            }
        } else {
            $this->db->from($param['tabel']);
        }

        if(!empty($param['wh'])) 
            $this->db->where($param['wh']);
        
        if (!empty($param['where'])) {
            foreach($param['where'] as $w => $an) {
        // ini bikin error kalo empty jadi di ganti null
                if (is_null($an)){
                    $this->db->where($w,null,false);
                }else {
                    $this->db->where($w,$an);
                }
            }
        }
        
        if( !empty($param['notin']))
            $this->db->where_not_in($param['notin']);
            
        if( !empty($param['not_in']))    
            if(is_array($param['not_in'])){
                foreach($param['not_in'] as $w => $an) 
                if (is_null($an)){
                    $this->db->where_not_in($w,null,false);
                }else {
                    $this->db->where_not_in($w,$an);
                }
            }else{
                $this->db->where_not_in($param['not_in'],$param['not_in_isi']);
            }
            
        if(!empty($param['in']))
            if(is_array($param['in'])){
                foreach($param['in'] as $w => $an) {
                    if(is_array($an)){
                        foreach ($an as $w2=> $an2) 
                        if (is_null($an2)){
                            $this->db->where_in($w2,null,false);
                        }else {
                            $this->db->where_in($w2,$an2);
                        }
                        
                    }else{
                        if (is_null($an)){
                            $this->db->where_in($w,null,false);
                        }else {
                            $this->db->where_in($w,$an);
                        }
                    }
                    
                }
             }else{
                $this->db->where_in($param['in'],$param['in_isi']);
             }
             
        #if (!empty($param['order'])) $this->db->order_by($param['order']);
        if ((!empty($param['group'])) || (!empty($param['group_by']))) 
            $this->db->group_by(!empty($param['group_by'])?$param['group_by']:$param['group']);
        //        $this->output->enable_profiler(TRUE);
        if (!empty($param['search'])) {
            
            $q= $this->db->_compile_select(); 
            
            $this->db->_reset_select();
            if (!empty($param['count'])) {
                 $this->db->select($param['count']." from ($q) t",false);
            }else{
                $this->db->select("* from ($q) t",false);    
            }

            foreach($param['search'] as $sc => $vl) 
                $this->db->or_like('t.'.$sc,$vl);
            #if (!empty($param['order'])) $this->db->order_by($param['order']);
            /*if (!empty($param['order'])) $this->db->order_by($this->remove_dot( $param['order']));
            if (!empty($param['order_by'])) $this->db->order_by($this->remove_dot($param['order_by']));*/
        }else{
            if (!empty($param['order'])) $this->db->order_by($param['order']);
            if (!empty($param['order_by'])) $this->db->order_by($param['order_by']);
        }        
        
        if (!empty($param['limit'])){
            if(!empty($param['offset'])){
                $this->db->limit($param['limit'],$param['offset']);
            }else{
                $this->db->limit($param['limit']);
            }
        }
        if($ret_sql){
            return $this->db->_compile_select(); 
        }else{
            return $this->db->get();
        }
    }
	
	function data_query($sql=null){
		return $this->db->query($sql);	
	}
	
	function combo_box($param) {
	    $combo=false;
        $data_combo =$this->datagrab($param);

        if(@$param['pilih']!="-")$combo = array('' => !empty($param['pilih'])?$param['pilih']:'-- Pilih --');
//		$combo = array('' => !empty($param['pilih'])?$param['pilih']:'-- Pilih --');
        foreach($data_combo->result() as $row) {
			$valueb = array();
			foreach($param['val'] as $v) { 
				if (is_array($v)) {
					if ($v[0] == "(") $valueb[] = "(".$row->$v[1].")";
				} else {
					$valueb[] = $row->$v; 
				}
			}
			$keyb = array();
			if (is_array($param['key'])) 
				foreach($param['key'] as $k) { $keyb[] = (strlen($row->$k) > 100)?substr($row->$k,0,100).' ...':$row->$k; }
			$paramkey=$param['key'];
			$keyv = is_array($param['key']) ? implode("|",$keyb) : $row->$paramkey;
		
			$combo[$keyv] = implode(" ",$valueb);
		} return $combo;  
		
	}	
/*	function combo_box_baru($param) {
	
        $data_combo =$this->datagrab($param);

        //if(@$param['pilih']!="-")$combo = array('' => !empty($param['pilih'])?$param['pilih']:'-- Pilih --');
//		$combo = array('' => !empty($param['pilih'])?$param['pilih']:'-- Pilih --');
        foreach($data_combo->result() as $row) {
			$valueb = array();
			foreach($param['val'] as $v) { 
				if (is_array($v)) {
					if ($v[0] == "(") $valueb[] = "(".$row->$v[1].")";
				} else {
					$valueb[] = $row->$v; 
				}
			}
			$keyb = array();
			if (is_array($param['key'])) {
				foreach($param['key'] as $k) { $keyb[] = (strlen($row->$k) > 100)?substr($row->$k,0,100).' ...':$row->$k; }
			}
			$keyv = is_array($param['key']) ? implode("|",$keyb) : $row->$param['key'];
		
			$combo[$keyv] = implode(" ",$valueb);
		} return $combo;  
		
	}	*/

	function get_param($id = null,$t = null) {
		if (is_array($id)) {
			$this->db->where("param IN ('".implode("','",$id)."')",null,false);	
			$data = $this->db->get('parameter');
			$ret = array();
			foreach($data->result() as $d) { 
				if (!empty($t) and $t == 1) $ret[]= $d->param;
				if (!empty($t) and $t == 2) $ret[$d->param]= $d->val;
				else $ret[] = $d->val; 
			}
			return $ret;
		} else {
			$this->db->where('param',$id);
			$data = $this->db->get('parameter')->row();
			return !empty($data) ? $data->val : null;
		}	
	}
	
	function check_role($id,$cod) {
		
		$this->db->from('pegawai_role p');
		$this->db->join('ref_role_nav n','n.id_role = p.id_role');
		$this->db->join('nav na','na.id_nav = n.id_nav');
		$this->db->where(array('p.id_pegawai' => $id, 'na.kode' => $cod));
		$g = $this->db->get();
		
		return ($g->num_rows() > 0) ? TRUE : FALSE;
		
	}
    function check_bidang($id) {
		
		$this->db->from('peg_pegawai p');
		$this->db->where(array('p.id_pegawai' => $id));
		$g = $this->db->get();
		
		return $g->row() ;
		
	}

	function dataempty($tab) {
		
		if (is_array($tab)) {
			foreach($tab as $t) {
				if ($this->check_tab($tab)) $this->db->query('TRUNCATE TABLE '.$t);
			}
		} else { 
			if ($this->check_tab($tab)) $this->db->empty_table($tab);
		}
		
	}
	
	function check_tab($tab) {
		
		return $this->db->table_exists($tab);
		
	}

	function cek_sekolah($u) {
		$this->db->from('skul_data_sekolah');
		$this->db->where('id_unit', $u);
		$g = $this->db->get();
		return ($g->num_rows() > 0) ? $g->row('id_sekolah') : NULL;
	}

	function cek_bidang_sekolah($o) {
		$this->db->from('skul_data_sekolah a');
		$this->db->join('ref_unit b','a.id_unit=b.id_unit');
		$this->db->join('ref_bidang c','b.id_unit=c.id_unit');
		$this->db->where('c.id_bidang', $o);
		$g = $this->db->get();
		return ($g->num_rows() > 0) ? $g->row('id_bidang') : NULL;
	}

}
