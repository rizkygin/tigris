<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Periode_pu extends CI_Controller {
	var $dir = 'tigris/Periode_pu';
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
		$data['breadcrumb'] = array($this->dir => 'Periode Pendaftaran Ujian');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'bulan' 		=> $search_key/*,
				'nama_kegiatan' 		=> $search_key,*/
			);	
			$data['for_search'] = @$fcari['bulan'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = @$fcari['bulan'];
			//$data['for_search'] = $fcari['nama_kegiatan'];
		}

		$from = array(
			'periode_pu a' => '',
			'ref_semester b' => array('a.id_ref_semester=b.id_ref_semester','left')
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

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>$from, 'order'=>'b.id_ref_tahun ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));


		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'periode_pu',
			'order' => 'urut',
		));
		

		$awal = array();
		$urutkan = array();

		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_periode_pu,$rowx->urut);
		}
		


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Bulan','Tgl Mulai','Tgl Selesai','Semester');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => ' Aksi ','colspan' => 2);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1 + (int) $offset;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				
				//cek($row->id_periode_pu);
				$btn_down = ($m+1 < $nav->num_rows()) ? anchor('tigris/periode_pu/urut/'.in_de(array('id1' => $row->id_periode_pu,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('tigris/periode_pu/urut/'.in_de(array('id2' => $row->id_periode_pu,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_periode_pu,$row->urut);


				if($row->status == 1){
					$status = anchor('tigris/Periode_pu/on/'.in_de(array('id_periode_pu' => $row->id_periode_pu,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/Periode_pu/on/'.in_de(array('id_periode_pu' => $row->id_periode_pu,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				$rows[] = 	$row->bulan;
				$rows[] = 	tanggal($row->start_date);
				$rows[] = 	tanggal($row->end_date);
				$rows[] = 	$row->nama_semester;/*
				$rows[] = 	@$status;*/

				if (!in_array($offset,array("cetak","excel"))) {
					$ubah = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_periode_pu'=>$row->id_periode_pu))).'" title="Edit Data Agenda Kegiatan..."');
					
					/*$ubah = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-flat btn-warning btn-edit" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_periode_pu'=>$row->id_periode_pu))).'" title="Klik untuk edit data"');*/
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_periode_pu'=>$row->id_periode_pu))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
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
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Bulan', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		//$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Bulan', 'class="btn btn-md btn-success btn-flat"');
		
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Periode Pendaftaran Ujian', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/').'" title="Klik untuk tambah data"');
		
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
		$title = 'Periode Pendaftaran Ujian';
		
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
				'tabel'=>'periode_pu',
				'data' => array(
					'status'=>$o['status']
					),
			);

			$param1['where'] = array('id_periode_pu'=>$o['id_periode_pu']);
			$this->general_model->simpan_data($param1);
			redirect($this->dir);
		}

	function urut($par) {
		$o = un_de($par);
		$param1 =
			array(
				'tabel'=>'periode_pu',
				'data' => array(
					'urut'=>$o['no2']
					),
			);

			$param1['where'] = array('id_periode_pu'=>$o['id1']);
			$this->general_model->simpan_data($param1);
			/*die();*/



		$param2 =
			array(
				'tabel'=>'periode_pu',
				'data' => array(
					'urut'=>$o['no1']
					),
			);

			$param2['where'] = array('id_periode_pu'=>$o['id2']);
			 $this->general_model->simpan_data($param2);




		//$this->general_model->save_data('periode_pu',array('urut' => $o['no2']),'id_periode_pu',$o['id1']);
		//$this->general_model->save_data('periode_pu',array('urut' => $o['no1']),'id_periode_pu',$o['id2']);
		redirect($this->dir);

	}


    public function add_data($param=NULL){
    	$o = un_de($param);
    	$id= @$o['id_periode_pu'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/periode_pu/save_aksi'),

        'id_periode_pu' => set_value('id_periode_pu'),
		);
        $from = array(
			'periode_pu a' => ''
		);
		$data['title'] = (!empty($code)) ? 'Ubah Data Periode Pendaftaran Ujian' : 'Periode Pendaftaran Ujian Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'where' => array('a.id_periode_pu' => $id)))->row() : null;
		$cb_semester = $this->general_model->combo_box(array('tabel'=>'ref_semester','key'=>'id_ref_semester','val'=>array('nama_semester')));
		$data['form_link'] = $this->dir.'/save_aksi/'.$id;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$id .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Bulan</label>';
			$data['form_data'] .= form_input('bulan', @$dt->bulan,'class="form-control" placeholder="Bulan" required');

			$data['form_data'] .= '<p><label>Tanggal Mulai</label>';
			$data['form_data'] .= form_input('start_date', !empty(@$dt->start_date)?tanggal(@$dt->start_date):null,'class="form-control datemask" placeholder="tangal Ujian dan jam" required');

			$data['form_data'] .= '<p><label>Tanggal Selesai</label>';
			$data['form_data'] .= form_input('end_date', !empty(@$dt->end_date)?tanggal(@$dt->end_date):null,'class="form-control datemask" placeholder="tangal Ujian dan jam" required');


			$data['form_data'] .= '<p><label>Semester</label>';
			$data['form_data'] .= form_dropdown('id_ref_semester', $cb_semester,@$dt->id_ref_semester,'class="form-control combo-box" style="width: 100%"');

			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';

		$data['script'] = '';
		$this->load->view('umum/form_view', $data);
    }



    function save_aksi(){
    	$id_periode_pu = $this->input->post('id_periode_pu');
    	$bulan = $this->input->post('bulan');
    	$id_ref_semester = $this->input->post('id_ref_semester');
    	$start_date = tanggal_php($this->input->post('start_date'));
    	$end_date = tanggal_php($this->input->post('end_date'));

    	$keterangan_program_konsentrasi = $this->input->post('keterangan_program_konsentrasi',TRUE);
    	/*$kode_Periode Pendaftaran Ujian = $this->input->post('kode_Periode Pendaftaran Ujian');*/
    	$tgl_skrg = date('Y-m-d');
     	$u = $this->general_model->datagrab(array(
					'tabel' => 'periode_pu',
					'select' => 'max(urut) as urut_nav',
				))->row();
				
				$urut = !empty($u->urut_nav) ? $u->urut_nav+1 : 1;


            if(empty($id_periode_pu)) {

                	$id_prop = $this->general_model->save_data('periode_pu',array('bulan' => $bulan,'start_date' => $start_date,'end_date' => $end_date,'id_ref_semester' => $id_ref_semester,'urut' => $urut));
	                $this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
	           
            }else{
            	
            	$par = array(
					'tabel'=>'periode_pu',
					'data'=>array(
						'bulan'=>$bulan,
						'start_date'=>$start_date,
						'end_date'=>$end_date,
						'id_ref_semester'=>$id_ref_semester
						),
					);

					$par['where'] = array('id_periode_pu'=>$id_periode_pu);

				$sim = $this->general_model->save_data($par);
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            }

            redirect($this->dir);

    }

	function delete_data($code) {
		$sn = un_de($code);
		$id_periode_pu = $sn['id_periode_pu'];
		$del = $this->general_model->delete_data('periode_pu','id_periode_pu',$id_periode_pu);
		if ($del) {
			$this->session->set_flashdata('ok','Jenis Output Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}