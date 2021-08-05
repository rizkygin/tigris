<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dosen extends CI_Controller {
	var $dir = 'tigris/Dosen';
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
		$data['breadcrumb'] = array($this->dir => 'Data Dosen');

		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama' 		=> $search_key/*,
				'nama_kegiatan' 		=> $search_key,*/
			);	
			$data['for_search'] = $fcari['nama'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['nama'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		}



		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => 'peg_pegawai', 'select'=>'*','search' => $fcari,'offset'=>$offs,'where'=>array('dosen'=>1)))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>'peg_pegawai', 'order'=>'id_pegawai ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'where'=>array('dosen'=>1)));


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Nomor Induk Dosen','Nama Dosen','Prodi','Status');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$no = 1 + $offset;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/peg_pegawai/on/'.in_de(array('id_pegawai' => $row->id_pegawai,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/peg_pegawai/on/'.in_de(array('id_pegawai' => $row->id_pegawai,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				

				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Prodi;*/
				$rows[] = 	'';
				$rows[] = 	$row->nama;
				$rows[] = 	'';
				$rows[] = 	@$status;

				if (!in_array($offset,array("cetak","excel"))) {
					//$ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_pegawai'=>$row->id_pegawai))), '<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-flat btn-warning" ');
					$ubah = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_pegawai'=>$row->id_pegawai))).'" title="Edit Data Agenda Kegiatan..."');
					
					/*$ubah = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-flat btn-warning btn-edit" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_pegawai'=>$row->id_pegawai))).'" title="Klik untuk edit data"');*/
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_pegawai'=>$row->id_pegawai))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
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
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama Dosen', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		//$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Nama Dosen', 'class="btn btn-md btn-success btn-flat"');
		
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Dosen', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/').'" title="Klik untuk tambah data"');
		
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
		$title = 'Data Dosen';
		
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


	function on($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'peg_pegawai',
				'data' => array(
					'status'=>$o['status']
					),
			);

			$param1['where'] = array('id_pegawai'=>$o['id_pegawai']);
			$this->general_model->simpan_data($param1);
			redirect($this->dir);
		}

	function urut($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'peg_pegawai',
				'data' => array(
					'urut'=>$o['no2']
					),
			);

			$param1['where'] = array('id_pegawai'=>$o['id1']);
			$this->general_model->simpan_data($param1);
			/*die();*/



		$param2 =
			array(
				'tabel'=>'peg_pegawai',
				'data' => array(
					'urut'=>$o['no1']
					),
			);

			$param2['where'] = array('id_pegawai'=>$o['id2']);
			 $this->general_model->simpan_data($param2);

		redirect($this->dir);

	}


    public function add_data($param=NULL){
    	$o = un_de($param);
    	$id= $o['id_pegawai'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/peg_pegawai/save_aksi'),

        'id_pegawai' => set_value('id_pegawai'),
	);

		$data['title'] = (!empty($code)) ? 'Ubah Data Prodi' : 'Prodi Baru';
       $dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => 'peg_pegawai',
					'where' => array('id_pegawai' => $id)))->row() : null;
		
		$data['form_link'] = $this->dir.'/save_aksi/'.$id;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_pegawai" class="id_pegawai" value="'.$id .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Nama Dosen</label>';
			$data['form_data'] .= form_input('nama', @$dt->nama,'class="form-control" placeholder="Nama Dosen" required');
			
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		$this->load->view('umum/form_view', $data);
    }



    function save_aksi(){
    	$id_pegawai = $this->input->post('id_pegawai');
    	$nama = $this->input->post('nama',TRUE);
    	/*$kode_Prodi = $this->input->post('kode_Prodi');*/
    	$tgl_skrg = date('Y-m-d');
     	

            if(empty($id_pegawai)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'peg_pegawai','where'=>array('nama'=>$nama),'select'=>'id_pegawai, MAX(id_pegawai) as id'))->row();
                if(empty($cek_prop->id_pegawai)) {
                	$id_prop = $this->general_model->save_data('peg_pegawai',array('nama' => $nama,'dosen' => 1));
	                $this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
	            }else{
	                $id_prop = $cek_prop->id_pegawai ;
	                $this->session->set_flashdata('fail', 'Nama Dosen sudah ada...');
	            }
            }else{
            	
            	$par = array(
					'tabel'=>'peg_pegawai',
					'data'=>array(
						'nama'=>$nama
						),
					);

					$par['where'] = array('id_pegawai'=>$id_pegawai);

				$sim = $this->general_model->save_data($par);
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            }

            redirect($this->dir);

    }

	function delete_data($code) {
		$sn = un_de($code);
		$id_pegawai = $sn['id_pegawai'];
		$del = $this->general_model->delete_data('peg_pegawai','id_pegawai',$id_pegawai);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}