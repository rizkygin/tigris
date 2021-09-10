<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_kelas extends CI_Controller {
	var $dir = 'tigris/Ref_kelas';
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
		$data['breadcrumb'] = array($this->dir => 'Referensi Kelas');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama_program_konsentrasi' 		=> $search_key/*,
				'nama_kegiatan' 		=> $search_key,*/
			);	
			$data['for_search'] = $fcari['nama_program_konsentrasi'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = @$fcari['nama_program_konsentrasi'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		}

		$from = array(
			'ref_program_konsentrasi a' => ''
		);

		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' =>$from, 'select'=>'*','search' => $fcari,'offset'=>$offs))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>$from, 'order'=>'urut ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));


		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'ref_program_konsentrasi',
			'order' => 'urut',
		));
		

		$awal = array();
		$urutkan = array();

		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_ref_program_konsentrasi,$rowx->urut);
		}
		


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Nama Kelas');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1 + (int) $offset;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				
				//cek($row->id_ref_program_konsentrasi);
				$btn_down = ($m+1 < $nav->num_rows()) ? anchor('tigris/Ref_program_konsentrasi/urut/'.in_de(array('id1' => $row->id_ref_program_konsentrasi,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('tigris/Ref_program_konsentrasi/urut/'.in_de(array('id2' => $row->id_ref_program_konsentrasi,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_ref_program_konsentrasi,$row->urut);


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				$rows[] = 	$row->nama_program_konsentrasi;

				if (!in_array($offset,array("cetak","excel"))) {
					$ubah = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_ref_program_konsentrasi'=>$row->id_ref_program_konsentrasi))).'" title="Edit Data Agenda Kegiatan..."');
					
					/*$ubah = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-flat btn-warning btn-edit" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_ref_program_konsentrasi'=>$row->id_ref_program_konsentrasi))).'" title="Klik untuk edit data"');*/
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_ref_program_konsentrasi'=>$row->id_ref_program_konsentrasi))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					$rows[] = 	$ubah;
					$rows[] = 	$hapus;
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
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama Kelas', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		//$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Nama Kelas', 'class="btn btn-md btn-success btn-flat"');
		
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Kelas', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/').'" title="Klik untuk tambah data"');
		
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
		$title = 'Referensi Kelas';
		
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
				'tabel'=>'ref_program_konsentrasi',
				'data' => array(
					'status'=>$o['status']
					),
			);

			$param1['where'] = array('id_ref_program_konsentrasi'=>$o['id_ref_program_konsentrasi']);
			$this->general_model->simpan_data($param1);
			redirect($this->dir);
		}

	function urut($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'ref_program_konsentrasi',
				'data' => array(
					'urut'=>$o['no2']
					),
			);

			$param1['where'] = array('id_ref_program_konsentrasi'=>$o['id1']);
			$this->general_model->simpan_data($param1);
			/*die();*/



		$param2 =
			array(
				'tabel'=>'ref_program_konsentrasi',
				'data' => array(
					'urut'=>$o['no1']
					),
			);

			$param2['where'] = array('id_ref_program_konsentrasi'=>$o['id2']);
			 $this->general_model->simpan_data($param2);




		//$this->general_model->save_data('ref_program_konsentrasi',array('urut' => $o['no2']),'id_ref_program_konsentrasi',$o['id1']);
		//$this->general_model->save_data('ref_program_konsentrasi',array('urut' => $o['no1']),'id_ref_program_konsentrasi',$o['id2']);
		redirect($this->dir);

	}


    public function add_data($param=NULL){
    	$o = un_de($param);
    	$id= @$o['id_ref_program_konsentrasi'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/ref_program_konsentrasi/save_aksi'),

        'id_ref_program_konsentrasi' => set_value('id_ref_program_konsentrasi'),
		);
        $from = array(
			'ref_program_konsentrasi a' => ''
		);
		$data['title'] = (!empty($code)) ? 'Ubah Data Kelas' : 'Kelas Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'where' => array('a.id_ref_program_konsentrasi' => $id)))->row() : null;

		$data['form_link'] = $this->dir.'/save_aksi/'.$id;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_ref_program_konsentrasi" class="id_ref_program_konsentrasi" value="'.$id .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Nama Kelas</label>';
			$data['form_data'] .= form_input('nama_program_konsentrasi', @$dt->nama_program_konsentrasi,'class="form-control" placeholder="Nama Kelas" required');
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		$this->load->view('umum/form_view', $data);
    }



    function save_aksi(){
    	$id_ref_program_konsentrasi = $this->input->post('id_ref_program_konsentrasi');
    	$nama_program_konsentrasi = $this->input->post('nama_program_konsentrasi',TRUE);

    	$keterangan_program_konsentrasi = $this->input->post('keterangan_program_konsentrasi',TRUE);
    	/*$kode_Kelas = $this->input->post('kode_Kelas');*/
    	$tgl_skrg = date('Y-m-d');
     	$u = $this->general_model->datagrab(array(
					'tabel' => 'ref_program_konsentrasi',
					'select' => 'max(urut) as urut_nav',
				))->row();
				
				$urut = !empty($u->urut_nav) ? $u->urut_nav+1 : 1;


            if(empty($id_ref_program_konsentrasi)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'ref_program_konsentrasi','where'=>array('nama_program_konsentrasi'=>$nama_program_konsentrasi),'select'=>'id_ref_program_konsentrasi, MAX(id_ref_program_konsentrasi) as id'))->row();
                if(empty($cek_prop->id_ref_program_konsentrasi)) {
                	$id_prop = $this->general_model->save_data('ref_program_konsentrasi',array('nama_program_konsentrasi' => $nama_program_konsentrasi,'urut' => $urut));
	                $this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
	            }else{
	                $id_prop = $cek_prop->id_ref_program_konsentrasi ;
	                $this->session->set_flashdata('fail', 'Nama Kelas sudah ada...');
	            }
            }else{
            	
            	$par = array(
					'tabel'=>'ref_program_konsentrasi',
					'data'=>array(
						'nama_program_konsentrasi'=>$nama_program_konsentrasi
						),
					);

					$par['where'] = array('id_ref_program_konsentrasi'=>$id_ref_program_konsentrasi);

				$sim = $this->general_model->save_data($par);
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            }

            redirect($this->dir);

    }

	function delete_data($code) {
		$sn = un_de($code);
		$id_ref_program_konsentrasi = $sn['id_ref_program_konsentrasi'];
		$del = $this->general_model->delete_data('ref_program_konsentrasi','id_ref_program_konsentrasi',$id_ref_program_konsentrasi);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}