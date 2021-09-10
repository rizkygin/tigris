<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_color extends CI_Controller {
	var $dir = 'schedul/ref_color';
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
		$this->db->query('SET SESSION sql_mode =
		                  REPLACE(REPLACE(REPLACE(
		                  @@sql_mode,
		                  "ONLY_FULL_GROUP_BY,", ""),
		                  ",ONLY_FULL_GROUP_BY", ""),
		                  "ONLY_FULL_GROUP_BY", "")');
	}

	function cr($e) {
	    return $this->general_model->check_role($this->id_petugas,$e);
    }

	public function index() {
		$this->list_data();
	}

	public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Referensi Color');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'color' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['color'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['color'];
		}



		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => 'sch_color', 'select'=>'*','search' => $fcari,'offset'=>$offs))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>'sch_color', 'order'=>'id_color ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));
		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Warna','Kode Warna');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$no = 1 + $offset;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				$rows[] = 	'<div style="color:'.$row->color.'" href="#"><i class="fa fa-square"></i></a>';
				$rows[] = 	$row->color;

				if (!in_array($offset,array("cetak","excel"))) {
					$ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_color'=>$row->id_color))), '<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-flat btn-warning" ');

					/*$ubah = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-flat btn-warning btn-edit" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_color'=>$row->id_color))).'" title="Klik untuk edit data"');*/
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_color'=>$row->id_color))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					$rows[] = 	$ubah;
					$rows[] = 	$hapus;
				}
				$this->table->add_row($rows);
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
/*
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama Color', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Warna', 'class="btn btn-md btn-success btn-flat"');
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

		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		$title = 'Referensi Color';
		
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
			'tabel' => 'sch_color',
			'where' => array('id_color' => $o['id_color'])))->row();
    	$data['back_url'] = site_url('schedul/ref_color');
    	$data['id_color'] = $o['id_color'];
    	$data['content'] = "schedul/color_form";
		$this->load->view('home', $data);
    }


    // AJAX REQUEST:
    function get_namaColor(){
        $q = $this->input->post('query');
        $data = $this->general_model->datagrabs(array(
            'tabel'=>'sch_color',
            'search'=>array('color'=>$q),
            'select'=>'*',
            // 'limit'=>5,
            // 'offset'=>0,
            ));

        
        die(json_encode($data->result()));
    }

    function save_data(){
    	$color = $this->input->post('color');
    	$id_color = $this->input->post('id_color');
    	/*cek($id_color);
    	die();*/
    	$par = array(
					'tabel'=>'sch_color',
					'data'=>array(
						'color'=>$color
						),
					);

				if($id_color != NULL)	$par['where'] = array('id_color'=>$id_color);

				$sim = $this->general_model->save_data($par);
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
     
            redirect($this->dir);

    }

	function delete_data($code) {
		$sn = un_de($code);
		$id_color = $sn['id_color'];
		$del = $this->general_model->delete_data('sch_color','id_color',$id_color);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}