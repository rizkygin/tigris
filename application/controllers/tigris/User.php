<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	var $app = 16;
	
	var $indie = 1;
	var $unit = FALSE;
	var $dir = 'tigris';
	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
	}
	
	function cr($e) {
	    return $this->general_model->check_role($this->session->userdata('id_pegawai'),$e);
    }
	
	public function index(){
		$this->list_data();
	}
	
	public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Referensi User');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama' 		=> $search_key,
				'nip' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['nama'];
			$data['for_search'] = $fcari['nip'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['nama'];
			$data['for_search'] = $fcari['nip'];
		}
		
		$select =  [
			'a.*',
			'b.unit',
			'nama_bidang',
		];
		$from = array(
			'peg_pegawai a' => '',
			'ref_unit b' => array('a.id_unit = b.id_unit','left'),
			'ref_bidang c' => array('a.id_bidang = c.id_bidang','left')
		);
		$where = array('a.id_tipe'=>0);
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/User/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' =>$from,'where'=>$where, 'select'=>'*','search' => $fcari,'offset'=>$offs))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrabs(array('select' => $select, 'tabel'=>$from, 'order'=>'nama ASC','where'=>$where, 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));


		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'peg_pegawai',
			'order' => 'nama',
		));
		

		$awal = array();
		$urutkan = array();

		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_pegawai,$rowx->nama);
		}
		


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Nama','Bidang','Username','Kewenangan');
			if (!in_array($offset,array("cetak","excel")))
				// $heads[] = array('data' => ' ','colspan' => 2);
				$heads[] = array('data' => ' Aksi ','colspan' => 3);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1 + $offset;
			$app = $this->general_model->get_param('app_active');
			$where = array();
			foreach ($dtjnsoutput->result() as $row) {
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
			
				$link1 = '<a href="#" act="'.site_url($this->dir.'/User/add_operator/'.$row->id_pegawai).'" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>';
				$link2= ' <a href="'.site_url($this->dir.'/User/reset_operator/'.$row->id_pegawai).'" class="btn btn-xs btn-primary btn-reset" title="Reset Password" msg="Yakin untuk mereset password User? <br>(Password standar adalah <b>qwerty</b>)"><i class="fa fa-repeat"></i></a>';
				
				$rows = array(array('data'=>$no,'style'=>'text-align:center'),
					$row->nama,
					$row->nip,
					$row->username);
					
					
				if ($this->indie and $this->unit) {
					$rows[] = $row->unit;
					$rows[] = $row->bidang;
					
				}
				$rows[] = !empty($disp_role) ? implode('<br/>',$disp_role) : null;
				
				if ($this->indie) {
					$rows[] = anchor($this->dir.'/User/delete_data/'.$row->id_pegawai.'/'.(in_de($fcari).'~'.$offset),'
						<i class="fa fa-trash"></i>','
						class="btn-delete btn btn-xs btn-danger"
						msg="Apakah Anda ingin menghapus data ini?"');
				}

				if (!in_array($offset,array("cetak","excel"))) {
					
					$rows[] = $link1;
				$rows[] = $link2;
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
/*
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama User', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		//$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Nama User', 'class="btn btn-md btn-success btn-flat"');
		
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah User', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/User/add_operator/').'" title="Klik untuk tambah data"');
		
		$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor($this->dir.'/User/list_data/'.in_de($fcari).'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/User/list_data/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
		$data['extra_tombol'] = 
				form_open($this->dir.'/User/list_data','id="form_search" role="form"').
				'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>'.
				form_close();

		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		$title = 'Referensi User';
		
		if ($offset == "cetak") {
			$data['title'] = '<h3>'.$title.'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print',$data);
		} else if ($offset == "excel") {
			$data['file_name'] = $title.'.xls';
			$data['title'] = '<h3>'.$data['title'].'</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel',$data);
		} else {
			$data['title'] 		= $title;
			$data['tabel'] = $tabel;
			$data['content'] = 'umum/standard_view';
			$this->load->view('home', $data);
		}
	}
	
	function add_operator($id = null) {
	
		$data['title']	= 'Ubah Kewenangan User';
			
			$from = array('peg_pegawai p' => '','peg_jabatan j' => array('j.id_pegawai = p.id_pegawai AND j.status = 1','left'));
			$sel = 'p.*,j.id_peg_jabatan,j.id_unit,j.id_bidang';
		
		$data['row']	= !empty($id) ? $this->general_model->datagrabs(array(
			'tabel' => $from,'where' => array('p.id_pegawai' => $id),'select' => $sel))->row() : null;
		
		$data['indie'] = $this->indie;
		$data['unit'] = $this->unit;
		
			$data['link_unit'] = site_url($this->dir.'/User/cb_bidang');
			$data['cb_unit'] = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit','key' => 'id_unit','val' => array('unit'),'order' => 'urut'));
		
			
		$data['cb_bidang'] = $this->general_model->combo_box(array(
					'tabel' => 'ref_bidang',
					'key' => 'id_bidang',
					'val' => array('nama_bidang'),
					'where' => array('id_unit' => @$data['row']->id_unit),
					'pilih' => ' -- Seluruh Unit Organisasi -- '));
		$where = array();
		$apps = $this->general_model->get_param('app_active');
		if ($apps != NULL) {
		//$data['offs'] = $offs;
		$where = ($this->app == 1) ? 
			array('a.folder' => $this->dir) :
			array('a.id_aplikasi IN ('.$this->general_model->get_param('app_active').')' => null); }
		
		$data['role']	= $this->general_model->datagrabs(array(
			'tabel' => array(
				'ref_role r' => '',
				'ref_aplikasi a' => 'a.id_aplikasi = r.id_aplikasi'),
			'where' => $where));
		$roles = $this->general_model->datagrabs(array('tabel' => array('peg_pegawai p' => '','pegawai_role rr' => 'rr.id_pegawai = p.id_pegawai'),'where' => array('p.id_pegawai' => $id)));
		$r = array();
		foreach($roles->result() as $ro) { $r[] = $ro->id_role; }
		
		$data['link_save'] = $this->dir.'/User/save_user';
		$data['link_foto'] = $this->dir.'/User/save_foto';
		$data['pegawai_role'] = $r;
		$this->load->view('umum/operator_form',$data);
		
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
	
	function save_user(){

		$id_pegawai = $this->input->post('id_pegawai');
		$role = $this->input->post('role');

		$s = array(
			'username' => str_replace(" ","_",strtolower($this->input->post('username'))),
			'nip' => $this->input->post('nip'),
			'nama' => $this->input->post('nama'),
			'id_unit' => $this->input->post('id_unit'),
			'id_bidang' => $this->input->post('id_bidang')
		);
		
		if (!empty($id_pegawai)) {
			$this->general_model->save_data('peg_pegawai',$s,'id_pegawai',$id_pegawai);
			$id_peg = $id_pegawai;
		} else {
			$s['password'] = md5('qwerty');
			$id_peg = $this->general_model->save_data('peg_pegawai',$s);
		}
		if (count($role) > 0) {
		
			$this->general_model->delete_data('pegawai_role','id_pegawai',$id_peg);
			
			foreach($role as $r) {
				$this->general_model->save_data('pegawai_role',array('id_role' => $r,'id_pegawai' => $id_peg));
			}
		
			$g = (!empty($id_pegawai)) ? 'Ubah' : 'Tambah';
			$stat = !empty($id_pegawai) ? null : '<br>Password standard adalah (qwerty)';
			$this->session->set_flashdata('ok',$g.' operator berhasil dilakukan'.$stat);
		} else {
		
		$this->session->set_flashdata('fail','Salah satu kewenangan harus diisi!');
		
		
		}
		
		redirect('tigris/User');
		
	}
	
	function reset_operator($id=null){
		$this->general_model->save_data('peg_pegawai',array('password' => md5('qwerty')),'id_pegawai',$id);
		$this->session->set_flashdata('ok', 'Password operator berhasil di reset');
		redirect('tigris/User');
	}
	
	function hapus_operator($id) {
		
		$this->general_model->delete_data('peg_pegawai','id_pegawai',$id);
		$this->session->set_flashdata('ok','Data Operator berhasil dihapus');
		
		redirect('tigris/User');
		
	}
	function delete_data($id) {
		
		$this->general_model->delete_data('peg_pegawai','id_pegawai',$id);
		$this->session->set_flashdata('ok','Data Operator berhasil dihapus');
		
		redirect('tigris/User');
		
	}
}

?>