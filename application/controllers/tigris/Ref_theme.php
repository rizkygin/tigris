<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_theme extends CI_Controller {
	var $dir = 'tigris/Ref_theme';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
		$this->id_petugas = $id_pegawai;
		if($this->cr('spk1')){
			/*Administrator Sapras*/
			$this->where = array();
		}elseif($this->cr('spk2')){
			/*Verivikastor Data Sekolah*/
			$this->where = array();
		}else{
			$this->where = array();
		}
	}

	function cr($e) {
	    return $this->general_model->check_role($this->id_petugas,$e);
    }

	public function index() {
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Referensi theme');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'theme' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['theme'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['theme'];
		}



		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => 'theme', 'select'=>'*','search' => $fcari,'offset'=>$offs))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>'theme', 'order'=>'id_theme ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));
		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Tema');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$no = 1 + $offset;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				$rows[] = 	$row->theme;
				

				if (!in_array($offset,array("cetak","excel"))) {
					$aktif = anchor(site_url($this->dir.'/ubah_theme/'.in_de(array('id_theme'=>$row->id_theme))), '<i class="fa fa-check"></i> Aktif', 'class="btn btn-xs btn-flat btn-danger" ');
					$nol = anchor(site_url($this->dir.'/ubah_theme/'.in_de(array('id_theme'=>$row->id_theme))), '<i class="fa fa-star"></i>', 'class="btn btn-xs btn-flat btn-silver" ');

					/*$ubah = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-flat btn-warning btn-edit" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_theme'=>$row->id_theme))).'" title="Klik untuk edit data"');*/
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_theme'=>$row->id_theme))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					$rows[] = 	($row->status == 1) ? $aktif : $nol;
					/*$rows[] = 	$hapus;*/
				}
				$this->table->add_row($rows);
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
/*
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama theme', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Tema', 'class="btn btn-md btn-success btn-flat"');
		$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
		$data['extra_tombol'] = 
				form_open($this->dir.'/list_data','id="form_search" role="form"').
				'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>'.
				form_close();

		$data['tombol'] = $btn_cetak;
		$title = 'Referensi theme';
		
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

    public function add_data($param=NULL){
    	$o = un_de($param);
    	$data['row']=$this->general_model->datagrab(array(
			'tabel' => 'theme',
			'where' => array('id_theme' => $o['id_theme'])))->row();
    	$data['back_url'] = site_url('tigris/Ref_theme');
    	$data['id_theme'] = $o['id_theme'];
    	$data['content'] = "tigris/theme_form";
		$this->load->view('home', $data);
    }


    // AJAX REQUEST:
    function get_namatheme(){
        $q = $this->input->post('query');
        $data = $this->general_model->datagrabs(array(
            'tabel'=>'theme',
            'search'=>array('theme'=>$q),
            'select'=>'*',
            // 'limit'=>5,
            // 'offset'=>0,
            ));

        
        die(json_encode($data->result()));
    }

    function ubah_theme($param=NULL){
    	$o = un_de($param);

    	$status = array(
					'tabel'=>'theme',
					'data'=>array(
						'status'=>0
						),
					);

		$status['where'] = array('status'=>1);
		$simp_stat = $this->general_model->save_data($status);

    	$par = array(
					'tabel'=>'theme',
					'data'=>array(
						'status'=>1
						),
					);

		$par['where'] = array('id_theme'=>$o['id_theme']	);

		$sim = $this->general_model->save_data($par);
		$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
     	redirect($this->dir);

    }

    function save_data(){
    	$theme = $this->input->post('theme');
    	$id_theme = $this->input->post('id_theme');
    	/*cek($id_theme);
    	die();*/
    	$par = array(
					'tabel'=>'theme',
					'data'=>array(
						'theme'=>$theme
						),
					);

					$par['where'] = array('id_theme'=>$id_theme);

				$sim = $this->general_model->save_data($par);
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
     
            redirect($this->dir);

    }

	function delete_data($code) {
		$sn = un_de($code);
		$id_theme = $sn['id_theme'];
		$del = $this->general_model->delete_data('theme','id_theme',$id_theme);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}