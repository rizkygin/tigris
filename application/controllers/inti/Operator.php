<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operator extends CI_Controller {

	/* 
	 * Keterangan Variabel Global
	 * $indie 
	 *		TRUE = Tambah Operator Independen di controller operator
	 *		FALSE = Non-Akfif Tambah Operator
	 * $app
	 *		1 = Aplikasi Tunggal
	 *		0 = Seluruh Aplikasi
	 * $dir	
	 		Pengguna Aplikasi / Folder Aplikasi
	 */

	var $indie = 1;
	var $unit = true;
	var $app = 0;
	var $dir = 'inti';

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
		$app_std = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row();
		$this->in_app = !empty($app_std->nama_aplikasi) ? $app_std->nama_aplikasi : 'Root';

	}
	
	public function index(){
		
		$this->list_data();
	
	}
	
	function list_data($search = null, $offset = null){
		
		$data['breadcrumb'] = array('' => $this->in_app, $this->dir.'/operator' => 'Operator');
		
		$offset = !empty($offset) ? $offset : 0;
		
		$s = $this->input->post('text_search');
		if (!empty($search)) {
			$o = un_de($search);
			$vse = array('text_search' => $o['text_search']);
		} else if (!empty($s)) {
			$vse = array('text_search' => $s);
		} else {
			$vse = array('text_search' => null);
		}
		
		$se = !empty($vse) ? $se = array ('nama' => $vse['text_search'],'username' => $vse['text_search']) : null;
		
		$config['base_url']	= site_url($this->dir.'/operator/list_data/'.in_de($vse));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','search' => $se))->num_rows();
		$config['per_page']	= '10';
		$config['uri_segment'] = '5';
		
		$this->pagination->initialize($config);
		
		$data['total']			= $config['total_rows'];
		$data['links']			= $this->pagination->create_links();
		
		if ($this->indie and $this->unit) {	
			$from = array(
				'peg_pegawai p' => '',
				'peg_jabatan j' => array('j.id_pegawai = p.id_pegawai AND j.status = 1','left'),
				'ref_bidang b' => array('b.id_bidang = j.id_bidang','left'),
				'ref_unit u' => array('u.id_unit = b.id_unit','left')
			);
			$sel = 'p.nama,p.nip,p.username,p.id_pegawai,b.nama_bidang bidang, b.id_bidang,u.id_unit, u.unit';
		} else {
			$from = 'peg_pegawai';
			$sel = 'nama,nip,username,id_pegawai';
		}
		
		$dtoperator	= $this->general_model->datagrab(array(
			'tabel' => $from,
			'limit' => $config['per_page'],'offset' => $offset,
			'search' => $se,
			'order' => 'nama',
		'select' => $sel));
		
		if($dtoperator->num_rows() > 0){
		
			$this->table->set_template(array('table_open'=>'<table class="table table-bordered table-striped" style="width:auto">'));
			$heads = array('No','Nama','ID','Username');
			if ($this->indie and $this->unit) {
				$heads[] = 'Unit Kerja';
				$heads[] = 'Unit Organisasi';
			}
			$heads[] = 'Kewenangan';
			$heads[] = array('data' => 'Aksi','colspan' => 3);
			$this->table->set_heading($heads);
		
			$no = 1 + $offset;
			$app = $this->general_model->get_param('app_active');
			$where = array();
			foreach($dtoperator->result() as $row){
				if ($app != NULL) {
				$where = ($this->app == 1) ? 
					array('a.folder' => $this->dir) :
					array('a.id_aplikasi IN ('.$this->general_model->get_param('app_active').')' => null);
				}
				$role = $this->general_model->datagrab(array(
					'tabel' => array(
						'pegawai_role r' => '',
						'ref_role rr' => 'rr.id_role = r.id_role',
						'ref_aplikasi a' => 'a.id_aplikasi = rr.id_aplikasi'
					),'where' => array_merge_recursive(
						array('id_pegawai' => $row->id_pegawai),
						$where)
				));
				
				$disp_role = array();
				foreach($role->result() as $r) {
					$disp_role[] = $r->nama_role.' ('.$r->nama_aplikasi.')';
				}
			
				$link1 = '<a href="#" act="'.site_url($this->dir.'/operator/add_operator/'.(in_de($vse).'~'.$offset).'/'.$row->id_pegawai).'" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>';
				$link2= ' <a href="'.site_url($this->dir.'/operator/reset_operator/'.$row->id_pegawai).'" class="btn btn-xs btn-primary btn-reset" title="Reset Password" msg="Yakin untuk mereset password operator? <br>(Password standar adalah <b>qwerty</b>)"><i class="fa fa-repeat"></i></a>';
				
				$rows = array(array('data'=>$no,'style'=>'text-align:center'),
					$row->nama,
					$row->nip,
					$row->username);
					
					
				if ($this->indie and $this->unit) {
					$rows[] = $row->unit;
					$rows[] = $row->bidang;
					
				}
				$rows[] = !empty($disp_role) ? implode('<br/>',$disp_role) : null;
				$rows[] = $link1;
				$rows[] = $link2;
				if ($this->indie) {
					$rows[] = anchor($this->dir.'/operator/delete_data/'.$row->id_pegawai.'/'.(in_de($vse).'~'.$offset),'
						<i class="fa fa-trash"></i>','
						class="btn-delete btn btn-xs btn-danger"
						msg="Apakah Anda ingin menghapus data ini?"');
				}
				
				$this->table->add_row($rows);
				
				$no++;
			}
			$tabel = '<div class="table-responsive">'.$this->table->generate().'</div>';
		}else{
			$tabel = '<div class="alert">Tidak ada data operator</div>';
		}
		
		$data['script'] = "
		$(document).ready(function(){
			$('.go').click( function() {
				$('#form_search').submit();
				return false;
			});
			
			$('.btn-reset').click(function() {
			   $('.form-delete-msg').html($('.btn-reset').attr('msg'));
			   $('.form-title').html('<i class=\"fa fa-check-square-o\"></i> Reset Password');
			   $('.form-delete-url').attr('href',$(this).attr('href')).children().html('<i class=\"fa fa-check-square-o\"></i> Reset Password');
			   $('#modal-delete').modal('show');
			   return false;
		   });
		});";

		$data['extra_tombol'] = form_open($this->dir.'/operator','id="form_search"').
					'<div class="input-group">
				  <input name="text_search" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$vse['text_search'].'">
				  <div class="input-group-btn">
					<button class="btn btn-default"><i class="fa fa-search"></i></button>
				  </div>
				</div>'.
		form_close();
		
		if ($this->indie) {
			$data['tombol'] = anchor('','<i class="fa fa-plus fa-btn"></i> Tambah Operator','
				class="btn btn-success btn-edit" 
				act="'.site_url($this->dir.'/operator/add_operator').'"
				title="Tambah Operator"');
		}
		
		$data['tabel']	= $tabel;
		$data['title'] 	= 'Pengaturan Operator';
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
	}
	
	function add_operator($offs = null,$id = null) {
	
		$data['title']	= 'Ubah Kewenangan Operator';
		if ($this->indie and $this->unit) {
			
			$from = array('peg_pegawai p' => '','peg_jabatan j' => array('j.id_pegawai = p.id_pegawai AND j.status = 1','left'));
			$sel = 'p.*,j.id_peg_jabatan,j.id_unit,j.id_bidang';
		} else {
			
			$from = 'peg_pegawai p';
			$sel = 'p.*';
			
		}
		$data['row']	= !empty($id) ? $this->general_model->datagrab(array(
			'tabel' => $from,'where' => array('p.id_pegawai' => $id),'select' => $sel))->row() : null;
		
		$data['indie'] = $this->indie;
		$data['unit'] = $this->unit;
		
		if ($this->unit) {
			$data['link_unit'] = site_url($this->dir.'/operator/cb_bidang');
			$data['cb_unit'] = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit','key' => 'id_unit','val' => array('unit'),'order' => 'urut'));
		
			if (!empty($data['row'])) {
				
				$data['cb_bidang'] = $this->general_model->combo_box(array(
					'tabel' => 'ref_bidang',
					'key' => 'id_bidang',
					'val' => array('nama_bidang'),
					'where' => array('id_unit' => $data['row']->id_unit),
					'pilih' => ' -- Seluruh Unit Organisasi -- '));
							
			}	
		}
		$where = array();
		$apps = $this->general_model->get_param('app_active');
		if ($apps != NULL) {
		$data['offs'] = $offs;
		$where = ($this->app == 1) ? 
			array('a.folder' => $this->dir) :
			array('a.id_aplikasi IN ('.$this->general_model->get_param('app_active').')' => null); }
		
		$data['role']	= $this->general_model->datagrab(array(
			'tabel' => array(
				'ref_role r' => '',
				'ref_aplikasi a' => 'a.id_aplikasi = r.id_aplikasi'),
			'where' => $where));
		$roles = $this->general_model->datagrab(array('tabel' => array('peg_pegawai p' => '','pegawai_role rr' => 'rr.id_pegawai = p.id_pegawai'),'where' => array('p.id_pegawai' => $id)));
		$r = array();
		foreach($roles->result() as $ro) { $r[] = $ro->id_role; }
		
		$data['link_save'] = $this->dir.'/operator/save_operator';
		$data['link_foto'] = $this->dir.'/operator/save_foto';
		$data['pegawai_role'] = $r;
		$this->load->view('umum/operator_form',$data);
		
	}
	
	function save_operator(){

		$offs = $this->input->post('offs');
		$id_pegawai = $this->input->post('id_pegawai');
		$role = $this->input->post('role');
		$usr = str_replace(" ","_",strtolower($this->input->post('username')));
		
		$where = array('username' => $usr);
		if (!empty($id_pegawai)) $where['id_pegawai !='] = $id_pegawai;
		
		$cek = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => $where));

		if ($cek->num_rows() > 0) {
		
		$this->session->set_flashdata('fail','Username sudah tersedia!');
		
		} else {
			
			if ($usr != 'nimda') {
			if ($this->indie) {
				
				$simpan = array(
					'username' => $usr,
					'nama' => $this->input->post('nama'),
					'nip' => $this->input->post('nip'));
	
				if ($id_pegawai == NULL) {
					
					$simpan['password'] = md5($usr);
				}
				
			} else {
				$simpan = array('username' => $usr);
			}

			$idp = $this->general_model->save_data('peg_pegawai',$simpan,'id_pegawai',$id_pegawai);
			
			$id_peg =  (!empty($id_pegawai))?$id_pegawai:$idp;
			
			if ($this->indie and $this->unit) {
					
					$id_jab = $this->input->post('id_peg_jabatan');
					$this->general_model->save_data('peg_jabatan',array(
							'id_pegawai' => $id_peg,
							'id_unit' => $this->input->post('id_unit'),
							'id_bidang' => $this->input->post('id_bidang'),
							'status' => 1
						),'id_peg_jabatan',
						$id_jab
					);
					
			}
			if (count($role) > 0) {
			
				$this->general_model->delete_data('pegawai_role','id_pegawai',$id_peg);
				
				foreach($role as $r) {
					$this->general_model->save_data('pegawai_role',array('id_role' => $r,'id_pegawai' => $id_peg));
				}
				
				if (!empty($id_pegawai)) $psn = 'Ubah operator berhasil dilakukan ... ';
				else $psn = 'Operator berhasil ditambahkan ... '.(($this->indie)?'<br>Username : <strong>'.$usr.'</strong><br/>Password : <strong>'.$usr.'</strong>':null);
				$this->session->set_flashdata('ok',$psn);
			} else {
			
			$this->session->set_flashdata('fail','Salah satu kewenangan harus diisi!');
					
			}
			
			} else {
				
				$this->session->set_flashdata('fail','Tidak diijinkan menggunakan <i>Username</i> &nbsp; tersebut ...');
				
			}
		
		}
		redirect($this->dir.'/operator/list_data/'.str_replace('~','/',$offs));
		
	}
	
	function reset_operator($id=null){
		$this->general_model->save_data('peg_pegawai',array('password' => md5('qwerty')),'id_pegawai',$id);
		$this->session->set_flashdata('ok', 'Password operator berhasil di reset');
		redirect($this->dir.'/operator');
	}
	
	function delete_data($id,$offs = null) {
		
		if ($this->indie and $this->unit) $this->general_model->delete_data('peg_jabatan','id_pegawai',$id);
		
		$this->general_model->delete_data('peg_pegawai','id_pegawai',$id);
		$this->session->set_flashdata('ok', 'Operator berhasil dihapus ...');
		
		redirect($this->dir.'/operator/list_data/'.str_replace('~','/',$offs));
	}
	
	function cb_bidang($id) {
		$data_comb = $this->general_model->combo_box(array(
			'tabel'=>array('ref_bidang'=>''),
			'key'=>'id_bidang',
			'val'=>array('nama_bidang'),
			'order' => 'urut',
			'where'=>array('id_unit'=>$id),
			'pilih' => ' -- Seluruh Unit Organisasi -- '));
		$combo = array();
		foreach($data_comb as $k=>$v){
			$combo .= '<option value="'.$k.'">'.$v.'</option>';
		}
		echo $combo;
	}
	
	function save_foto() {
		$id = $this->input->post('id_pegawai');
		$offs = $this->input->post('offs');
		$pasfoto = $_FILES['foto']['tmp_name'];
		if (!empty($pasfoto)) {	
			
			$path = './uploads/kepegawaian/pasfoto';
			if (!is_dir($path)) mkdir($path,0777,TRUE);
		
			if (!empty($id_pegawai)) {
			
				$prev = $this->input->post('foto_prev');
				$path_pasfoto = $path.'/'.$prev;
				if(file_exists($path_pasfoto)) unlink($path_pasfoto);
					
			} 
			
			$nama_file   = $id.'.jpg';
			
			if (!file_exists($path.'/'.$nama_file)) {
				
				$this->load->library('upload');
				
				$this->upload->initialize(array(
					'upload_path' => $path,
					'allowed_types' => 'jpg|jpeg|png|gif|pdf|word',
					'file_name' => $nama_file
				));
				$this->upload->do_upload('foto');

			}
			
			$this->general_model->save_data(
				'peg_pegawai',array('photo' => $nama_file),'id_pegawai',$id);
			
			$this->session->set_flashdata('ok','Foto berhasil disimpan ...');
		} else {
			$this->session->set_flashdata('fail','Foto belum dipilih ...');
		} 
		redirect($this->dir.'/operator/list_data/'.str_replace('~','/',$offs));
		
	}
	
}
?>