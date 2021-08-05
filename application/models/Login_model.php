<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Login_Model extends CI_Model {
	
	function login_process($username,$password) {
		$this->db->select('*');
		$this->db->from('operator');
		$this->db->where('username',$username);
		$this->db->where('password',md5($password));
		return $this->db->get();
	}	
	
	function last_login($id) {	
	
		$this->db->set('last_login','NOW()');
		$this->db->where('id_operator',$id);
		$this->db->update('operator');
		
	}

}
