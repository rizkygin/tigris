<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda_kegiatan extends CI_Controller {
	var $dir = 'schedul/agenda_kegiatan';
	function __construct() {
		parent::__construct();
		$this->load->library('cfpdf');
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
		$data['breadcrumb'] = array($this->dir => 'Data Agenda Program');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama_program' 		=> $search_key,
				'nama_kegiatan' 		=> $search_key,
				'nama_rincian' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['nama_program'];
			$data['for_search'] = $fcari['nama_kegiatan'];
			$data['for_search'] = $fcari['nama_rincian'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['nama_program'];
			$data['for_search'] = $fcari['nama_kegiatan'];
			$data['for_search'] = $fcari['nama_rincian'];
		}

		$from_program = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_ref_rincian tz' => array('tz.id_ref_rincian= tj.id_ref_rincian','left'),
			'sch_jenis_program tx' => array('tx.id_jenis_program= tj.id_jenis_program','left'),
			'sch_ref_tahun tc' => array('tc.id_tahun= tj.id_tahun','left')
		);
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.*,tc.tahun,tz.*';
		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from_program, 'select'=>$select,'where'=>array('tj.id_jenis_program'=>1),'search' => $fcari))->num_rows();
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$st = get_stationer();
		$program = $this->general_model->datagrab(array('tabel'=>$from_program, 'order'=>'tj.tgl_mulai ASC','select'=>$select,'where'=>array('tj.id_jenis_program'=>1),'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));
		if ($program->num_rows() > 0) {

			$heads[]= array('data' => 'No ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Detail ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => ' ','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Periode ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Program/ Kegiatan','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Rincian','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Tgl Mulai','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Tgl Selesai','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			/*$heads[]= array('data' => 'Keterangan','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Lokasi','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Indikator','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Sasaran','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Pagu','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;width:130px;');*/
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => 'Aksi ','colspan' => 3,'style'=>'background:#f4f4f4;');
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-responsive table-striped table-bordered table-condensed"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);
			$bln = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			$no = 1 + $offset;
			foreach ($program->result() as $row) {
				
				switch($row->status) {
					case '1' : $statuse = '<span class="label label-success">Berlangsung</span>';
					break;
					case '2' : $statuse = '<span class="label label-warning">Batal</span>';
					break;
					case '3' : @$statuse = '<span class="label label-danger">Belum Ada Tanggal</span>';
					break;
				}
				$detail = anchor('schedul/agenda_kegiatan/detail_data/'.in_de(array('id_jadwal'=>$row->id_jadwal)),'<i class="fa fa-list"></i>','title="Detail Agenda Kegiatan"').' ';
				
				$rows = array(
					array('data' => $no)
				);
				$rows[] = array('data' =>$detail,'style'=>'text-align:center;');
				$rows[] = array('data' =>$statuse,'style'=>'text-align:center;');
				$rows[] = array('data' =>$row->tahun,'style'=>'text-align:center;');
				($row->nama_program != NULL)? $rows[] = array('data' =>'<b>'.$row->nama_program.'</b><br>'.$row->nama_kegiatan) : $rows[] = array('data' =>' - ','style'=>'text-align:center;');
				($row->nama_rincian != NULL)? $rows[] = array('data' =>$row->nama_rincian) : $rows[] = array('data' =>' - ','style'=>'text-align:center;');
				$rows[] = array('data' =>tanggal($row->tgl_mulai));
				$rows[] = array('data' =>tanggal($row->tgl_selesai));
				/*$rows[] = array('data' => substr($row->content, 0,30).'...');
				(@$row->lokasi != null) ? $rows[] = array('data' =>$row->lokasi) : $rows[] = array('data' =>' - ','style'=>'text-align:center;');
				(@$row->indikator != null) ? $rows[] = array('data' =>$row->indikator) :  $rows[] = array('data' =>' - ','style'=>'text-align:center;');
				(@$row->sasaran != null) ? $rows[] = array('data' =>$row->sasaran) :  $rows[] = array('data' =>' - ','style'=>'text-align:center;');
				(@$row->pagu != null) ? $rows[] = array('data' =>rupiah($row->pagu)) :  $rows[] = array('data' =>' - ','style'=>'text-align:center;');
				*/

				if (!in_array($offset,array("cetak","excel"))) {

					$ubah = anchor($this->dir.'/update/'.in_de(array('id_jadwal'=>$row->id_jadwal)),'<i class="fa fa-pencil"></i>','
						class="btn btn-xs btn-flat btn-warning"	title="Edit Data Agenda Kegiatan..."');


					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_jadwal'=>$row->id_jadwal))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					
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

		$btn_tambah = anchor($this->dir.'/add_data/','<i class="fa fa-plus fa-btn"></i> Agenda Kegiatan','class="btn btn-success btn-flat"	title="Klik untuk tambah data"');



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
		$title = 'Data Agenda Program';
		
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
			$data['tabel'] = $tabel;
			$tab1 = array('text'=>'Program', 'on'=>1, 'url'=>site_url($this->dir.'/list_data/'));
			$tab2 = array('text'=>'Non Program', 'on'=>NULL, 'url'=>site_url($this->dir.'/non_program/'));
			$tab3 = array('text'=>'Semua Agenda', 'on'=>NULL, 'url'=>site_url($this->dir.'/semua_program/'));
			$data['title'] 		= $title;
			$data['tabs'] = array($tab1, $tab2,$tab3);
			$data['content'] = 'schedul/agenda_view';
			$this->load->view('home', $data);
		}
	}

	public function semua_program($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Data Semua Agenda Kegiatan');
		$offset = !empty($offset) ? $offset : null;

		$tahun1=$this->input->post('id_tahun1');
		$tahun2=$this->input->post('id_tahun2');
		/*echo $tahun1;
		echo $tahun2;*/
		$cb_tahun = $this->general_model->combo_box(array('tabel'=>'sch_ref_tahun','key'=>'id_tahun','val'=>array('tahun')));
		
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama_program' 		=> $search_key,
				'nama_kegiatan' 		=> $search_key,
				'nama_rincian' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['nama_program'];
			$data['for_search'] = $fcari['nama_kegiatan'];
			$data['for_search'] = $fcari['nama_rincian'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['nama_program'];
			$data['for_search'] = $fcari['nama_kegiatan'];
			$data['for_search'] = $fcari['nama_rincian'];
		}

		
		$from_non = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_ref_rincian tz' => array('tz.id_ref_rincian= tj.id_ref_rincian','left'),
			'sch_jenis_program tx' => array('tx.id_jenis_program= tj.id_jenis_program','left'),
			'sch_ref_tahun tc' => array('tc.id_tahun= tj.id_tahun','left')
		);
		$th = ($tahun1 !=NULL and $tahun2 !=NULL) ? array('tj.id_tahun BETWEEN "'.$tahun1.'" AND "'.$tahun2.'" '=>null) : array();
		$where = array_merge($th);
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.*,tc.tahun,tz.nama_rincian';
		$config['base_url']	= site_url($this->dir.'/semua_program/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from_non,'where'=>$where, 'select'=>$select,'search' => $fcari))->num_rows();
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$st = get_stationer();
		$nonprogram = $this->general_model->datagrab(array('tabel'=>$from_non,'where'=>$where, 'order'=>'tj.tgl_mulai ASC','select'=>$select,'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));
		if ($nonprogram->num_rows() > 0) {

			$heads[]= array('data' => 'No ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Detail ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => ' ','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Periode ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Program/ Kegaitan','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Rincian','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Tgl Mulai','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Tgl Selesai','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Keterangan','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => 'Aksi ','colspan' => 3,'style'=>'background:#f4f4f4;');
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-responsive table-striped table-bordered table-condensed"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);
			$bln = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			$no = 1 + $offset;
			foreach ($nonprogram->result() as $row) {
				
				switch($row->status) {
					case '1' : @$statuse = '<span class="label label-success">Berlangsung</span>';
					break;
					case '2' : @$statuse = '<span class="label label-warning">Batal</span>';
					break;
					case '3' : @$statuse = '<span class="label label-danger">Belum Ada Tanggal</span>';
					break;
				}
				$detail = anchor('schedul/agenda_kegiatan/detail_data/'.in_de(array('id_jadwal'=>$row->id_jadwal)),'<i class="fa fa-list"></i>','title="Detail Agenda Kegiatan"').' ';
				
				$rows = array(
					array('data' => $no)
				);
				$rows[] = array('data' =>$detail,'style'=>'text-align:center;');
				$rows[] = array('data' =>@$statuse,'style'=>'text-align:center;');
				$rows[] = array('data' =>@$row->tahun,'style'=>'text-align:center;');
				(@$row->nama_program != NULL)
				? $rows[] = array('data' =>'<b>'.$row->nama_program.'</b><p>'.$row->nama_kegiatan)
				: $rows[] = array('data' =>' - ', 'style'=>'text-align:center;')
				;
				$rows[] = array('data' =>(@$row->nama_rincian != NULL) ? @$row->nama_rincian : '-');
				$rows[] = array('data' =>tanggal($row->tgl_mulai));
				$rows[] = array('data' =>tanggal($row->tgl_selesai));
				$rows[] = array('data' =>$row->content);
				

				if (!in_array($offset,array("cetak","excel"))) {

					$ubah = anchor($this->dir.'/update/'.in_de(array('id_jadwal'=>$row->id_jadwal)),'<i class="fa fa-pencil"></i>','
						class="btn btn-xs btn-flat btn-warning"	title="Edit Data Agenda Kegiatan..."');


					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_jadwal'=>$row->id_jadwal))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					
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
		$btn_tambah = anchor($this->dir.'/add_data/','<i class="fa fa-plus fa-btn"></i> Agenda Kegiatan','class="btn btn-success btn-flat"	title="Klik untuk tambah data"');



		$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor('schedul/agenda_kegiatan/pdf/'.in_de(array('id_tahun1'=>$tahun1)).'/'.in_de(array('id_tahun2'=>$tahun2)),'<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/semua_program/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
		$data['extra_tombol'] = 
				form_open($this->dir.'/semua_program','id="form_search" role="form"').
				'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>'.
				form_close();
		$filter =  form_open('','id="form_search" role="form"').
			    '
				    <div class="col-lg-2" style="padding:0;text-align:center;padding-top:6px;"> Periode </div>
				  	<div class="col-lg-4" style="padding:0;">
				    	<div class="input-group" style="width: 100%;">
					    	'.form_dropdown('id_tahun1', $cb_tahun, @$tahun1,'class="form-control combo-box" style="width: 100%"').'
						    	</div>
				    </div>
				  	<div class="col-lg-1" style="padding:0;text-align:center;padding-top:6px;"> <span class="badge"> s.d </span> </div>
				  	<div class="col-lg-4" style="padding:0;">
			    		<div class="input-group" style="width: 100%;">
					    	'.form_dropdown('id_tahun2', $cb_tahun, @$tahun2,'class="form-control combo-box" style="width: 100%"').'
						    	</div>
				    </div>

				  	<div class="col-lg-1" style="padding-top:0;margin-left:-15px;">
				  	<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
						
				  	</div>
					'.
				form_close();

		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		$data['tombolx'] = $filter;
		$title = 'Data Semua Agenda Kegiatan';

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
			$data['tabel'] = $tabel;
			$tab1 = array('text'=>'Program', 'on'=>null, 'url'=>site_url($this->dir.'/list_data/'));
			$tab2 = array('text'=>'Non Program', 'on'=>null, 'url'=>site_url($this->dir.'/non_program/'));
			$tab3 = array('text'=>'Semua Agenda', 'on'=>1, 'url'=>site_url($this->dir.'/semua_program/'));
			$data['title'] 		= $title;
			$data['tabs'] = array($tab1, $tab2, $tab3);
			$data['content'] = 'schedul/agenda_view';
			$this->load->view('home', $data);
			}
	}


 	function pdf($tahun1=NULL,$tahun2=NULL) {
		$p=un_de($tahun1);
		$q=un_de($tahun2);
		$tahunsatu=$p['id_tahun1'];
		$tahundua=$q['id_tahun2'];
		/*cek($tahunsatu);
		cek($tahundua);
		die();*/
    	$offset = !empty($offset) ? $offset : null;
		//$pengajar = $this->input->post('pengajar');
	$st = get_stationer();

		$from_non = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_jenis_program tx' => array('tx.id_jenis_program= tj.id_jenis_program','left'),
			'sch_ref_tahun tc' => array('tc.id_tahun= tj.id_tahun','left')
		);
		$th = ($tahunsatu !=NULL and $tahundua !=NULL) ? array('tj.id_tahun BETWEEN "'.$tahunsatu.'" AND "'.$tahundua.'" '=>null) : array();
		$where = array_merge($th);
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.*,tc.tahun';
		
		$data['query'] = $this->general_model->datagrab(
				array('tabel' => $from_non,
					  'select' => $select,
					  'where'=>$where));
		
		$data['bubar'] =  $this->general_model->datagrab(
					array('tabel' => $from_non,
						  'select' => $select,
						  'where'=>$where))->row();	
		$xx =  $this->general_model->datagrab(
					array('tabel' => $from_non,
						  'select' => $select,
						  'where'=>$where))->row();
		$data['tahun1'] = $tahunsatu;
		$data['tahun2'] = $tahundua;	
		$data['h_title_left'] = '
		<div class="col-lg-5" style="padding: 10px 0px 0px 0px;">

		<img src="'.base_url()."uploads/logo/logo_yes.png".'" style="height: 40px;float:left; margin-right:10px;"/>

		<h5 style="font-size: 24px;border-top:3px solid #4271B7;border-bottom:3px solid #4271B7;float:left;color:#4271B7;margin-top:5px;"><b>YOGYA EXECUTIVE SCHOOL "YES"</b></h5>
				</div>
		';
		$data['h_title_right'] = '
		
		';
		$data['h_sub_center'] = '';
		$data['tgl_cetak'] = date('d-M-Y');
		$data['company_address'] = '<div class="col-lg-6"  style="padding: 10px 0px 0px 0px;">

		<div style="text-align:right;color: #4271B7;margin-top:-20px;">
		<h6 style="font-size:10px;">Jl. Taman Siswa No. 89 Telp/Fax. (0274) 376 623 Yogyakarta 55151<br>
		Website : www.yesjogja.com<br>E-mail : info@yesjogja.com, info_yes@yahoo.co.id</h6></div>';
		$data['company_country'] = 'City-Country';
		/*$data['company_logo'] = base_url('assets/logo/brand.png');*/

    	// **** BEDO SAMBUNGAN
        // $start = 0;
        // $anjab_alat = $this->general_model->datagrabs(array(
        //     'tabel'=>'catatan', 
        //     'select'=>'*'));
        // $data = array(
        //     'h_title_left'=> 'pesis',
        //     'h_title_center'=> '<span>Laporan</span><br/> Data ',
        //     'h_sub_center'=> '',
        //     'tgl_cetak'=> date('d-M-Y'),
        //     'company_address'=>'Company Address',        
        //     'company_country'=>'City-Country',        
        //     'company_logo'=>base_url('assets/logo/brand.png'),        
        //    // 'company_logo'=>$logo_instansi      
        //     );



		 ini_set('memory_limit', '512M');
       // $html = $this->load->view('anjab_alat_pdf', $data, true);
        $html = $this->load->view('schedul/pdf_view', $data, true);
        $this->load->library('pdf');
        $parameters= array(
                'mode' => 'utf-8',
                'format' => 'A4',    // A4 for portrait
                'default_font_size' => '12',
                'default_font' => '',
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 40,
                'margin_bottom' => 30,
                'margin_header' => 20,
                'margin_footer' => 10,
                'orientation' => 'P' // For some reason setting orientation to "L" alone doesn't work (it should), you need to also set format to "A4-L" for landscape
            );

        $pdf = $this->pdf->load($parameters);
        // setting
        $pdf->SetProtection(array('print'));
        $pdf->SetTitle("");
        $pdf->SetWatermarkText("");
        $pdf->showWatermarkText = true;
        $pdf->watermark_font = 'DejaVuSansCondensed';
        $pdf->watermarkTextAlpha = 0.1;
        $pdf->SetDisplayMode('fullpage');
        // .setting

        $pdf->WriteHTML($html);
        $pdf->Output('presensi_kelas.pdf', 'I'); 
        // $pdf->Output(); 

  //  }

}

	function print_browser(){
		
		$data['controller']	= 'laporan_eschedul';
		$this->load->view('schedul/choice_print_view',$data);
		
	}
		function print_view($code=NULL) {
			$p=un_de($code);
			$id_tahun=$p['id_tahun'];
			/*cek($id_tahun);
			die();*/
			$tabel = '';
			
			$this->table->add_row(
				array('data' => 'Perihal', 'style' => 'width: 100px'),
				array('data' => ':', 'style' => 'width: 10px;'),
				'Laporan Rekap Permintaan Gudang'
			);
			
			$this->table->add_row(
				'Bulan/Tahun',
				':',
				date('m').'/'.date('Y')
			);
			
			$tabel .= $this->table->generate();
			
			$this->table->clear();
			
			$from_non = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_jenis_program tx' => array('tx.id_jenis_program= tj.id_jenis_program','left'),
			'sch_ref_tahun tc' => array('tc.id_tahun= tj.id_tahun','left')
		);
		$th = ($id_tahun!=NULL) ? array('tj.id_tahun'=>$id_tahun) : array();
		$where = array_merge($th);
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.*,tc.tahun';
		
			$query	= $this->general_model->datagrab(
					array('tabel' => $from_non,
						  'select' => $select,
						  'where'=>array('tj.id_tahun BETWEEN "'.$id_tahun.'" AND "'.$id_tahun.'" '=>null)));
			$total = 0;
			if($query->num_rows() != 0):
				$this->table->set_template(array('table_open' => '<table class="tabel_print"  style="width: 100%;">', 'table_close' => '</table>'));
				
				/*$rows[] = array('data' =>$detail,'style'=>'text-align:center;');
				$rows[] = array('data' =>@$statuse,'style'=>'text-align:center;');
				$rows[] = array('data' =>@$row->tahun,'style'=>'text-align:center;');
				(@$row->nama_program != NULL)
				? $rows[] = array('data' =>$row->nama_program)
				: $rows[] = array('data' =>' - ', 'style'=>'text-align:center;')
				;
				$rows[] = array('data' =>$row->nama_kegiatan);
				$rows[] = array('data' =>tanggal($row->tgl_mulai));
				$rows[] = array('data' =>tanggal($row->tgl_selesai));
				$rows[] = array('data' =>$row->content);
*/				
				$this->table->set_heading(
					array('data' => 'No','style' => 'width: 15px; '),
					array('data' => ' '),
					array('data' => 'Periode'),
					array('data' => 'Program'),
					array('data' => 'Kegiatan'),
					array('data' => 'Tgl Mulai'),
					array('data' => 'Tgl Selesai'),
					array('data' => 'Keterangan')
				);
			
				$no = 1;
				foreach($query->result() as $row){
					
					switch($row->status) {
					case '1' : @$statuse = '<span class="label label-success">Berlangsung</span>';
					break;
					case '2' : @$statuse = '<span class="label label-warning">Batal</span>';
					break;
					case '3' : @$statuse = '<span class="label label-danger">Belum Ada Tanggal</span>';
					break;
				}
					$this->table->add_row(
						$no,
						$statuse,
						@$row->tahun,
						(@$row->nama_program != NULL)
						?  $row->nama_program
						: ' - '
						,
						$row->nama_kegiatan,
						tanggal($row->tgl_mulai),
						tanggal($row->tgl_selesai),
						$row->content
					);
					$no++;
				}
				
				$tabel .= $this->table->add_row(array('data' => 'Total : '.$total.' Item', 'colspan'=>'5', 'style'=>'text-align:right','colspan'=>'7'));
				$tabel .= $this->table->generate();
			else:
				$tabel .= '<div class="alert">Belum ada data stok barang</div>';
			endif;
			
			$tabel .= '<div class="mengetahui"><p class="span-88" style="margin-bottom: 100px;">Mengetahui</p><p class="span-88">........................................<br>NIP.</p></div>';
			$tabel .= '<div class="paraf"><p class="span-88">Kota Bangun, '.tanggal_indo(date('Y-m-d'),2).'<br>Operator Gudang</p><p class="span-88">'.$this->session->userdata('nama').'<br>NIP. '.$this->session->userdata('nip').'</p></div>';
			
			$data['hal']	= 'Laporan Rekap Permintaan Gudang';
			$data['tabel']	= $tabel;
			
			$this->load->view('schedul/print_view',$data);
		}



	public function non_program($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Data Agenda Non Program');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama_program' 		=> $search_key,
				'nama_kegiatan' 		=> $search_key,
				'nama_rincian' 		=> $search_key,
			);	
			$data['for_search'] = $fcari['nama_program'];
			$data['for_search'] = $fcari['nama_kegiatan'];
			$data['for_search'] = $fcari['nama_rincian'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = $fcari['nama_program'];
			$data['for_search'] = $fcari['nama_kegiatan'];
			$data['for_search'] = $fcari['nama_rincian'];
		}


		$from_non = array(
			'sch_jadwal tj' => '',
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_ref_rincian tz' => array('tz.id_ref_rincian= tj.id_ref_rincian','left'),
			'sch_jenis_program tx' => array('tx.id_jenis_program= tj.id_jenis_program','left'),
			'sch_ref_tahun tc' => array('tc.id_tahun= tj.id_tahun','left')
		);
		$select = 'ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.*,tc.tahun,tz.nama_rincian';
		$config['base_url']	= site_url($this->dir.'/non_program/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from_non, 'select'=>$select,'where'=>array('tj.id_jenis_program'=>2),'search' => $fcari))->num_rows();
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$st = get_stationer();
		$nonprogram = $this->general_model->datagrab(array('tabel'=>$from_non, 'order'=>'tj.tgl_mulai ASC','select'=>$select,'where'=>array('tj.id_jenis_program'=>2),'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));
		if ($nonprogram->num_rows() > 0) {

			$heads[]= array('data' => 'No ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Detail ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => ' ','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Periode ','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Kegiatan','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Rincian','style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Tgl Mulai','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Tgl Selesai','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			$heads[]= array('data' => 'Keterangan','colspan' => 1,'style'=>'background-color: '.$st["main_color"].';color: #fff;');
			if (!in_array($offset,array("cetak","excel")))
				$heads[] = array('data' => 'Aksi ','colspan' => 3,'style'=>'background:#f4f4f4;');
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-responsive table-striped table-bordered table-condensed"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);
			$bln = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			$no = 1 + $offset;
			foreach ($nonprogram->result() as $row) {
				
				switch($row->status) {
					case '1' : @$statuse = '<span class="label label-success">Berlangsung</span>';
					break;
					case '2' : @$statuse = '<span class="label label-warning">Batal</span>';
					break;
					case '3' : @$statuse = '<span class="label label-danger">Belum Ada Tanggal</span>';
					break;
				}
				$detail = anchor('schedul/agenda_kegiatan/detail_data/'.in_de(array('id_jadwal'=>$row->id_jadwal)),'<i class="fa fa-list"></i>','title="Detail Agenda Kegiatan"').' ';
				
				$rows = array(
					array('data' => $no)
				);
				$rows[] = array('data' =>$detail,'style'=>'text-align:center;');
				$rows[] = array('data' =>@$statuse,'style'=>'text-align:center;');
				$rows[] = array('data' =>@$row->tahun,'style'=>'text-align:center;');
				$rows[] = array('data' =>$row->nama_kegiatan);
				$rows[] = array('data' =>($row->nama_rincian == NULL) ? ' - ' : $row->nama_rincian);
				$rows[] = array('data' =>tanggal($row->tgl_mulai));
				$rows[] = array('data' =>tanggal($row->tgl_selesai));
				$rows[] = array('data' =>$row->content);
				

				if (!in_array($offset,array("cetak","excel"))) {

					$ubah = anchor($this->dir.'/update/'.in_de(array('id_jadwal'=>$row->id_jadwal)),'<i class="fa fa-pencil"></i>','
						class="btn btn-xs btn-flat btn-warning"	title="Edit Data Agenda Kegiatan..."');


					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_jadwal'=>$row->id_jadwal))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					
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
		$btn_tambah = anchor($this->dir.'/add_data/','<i class="fa fa-plus fa-btn"></i> Agenda Kegiatan','class="btn btn-success btn-flat"	title="Klik untuk tambah data"');



		$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor($this->dir.'/non_program/'.in_de($fcari).'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/non_program/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
		$data['extra_tombol'] = 
				form_open($this->dir.'/non_program','id="form_search" role="form"').
				'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>'.
				form_close();

		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		$title = 'Data Agenda Non Program';
		$data['tabel'] = $tabel;		
		$tab1 = array('text'=>'Program', 'on'=>null, 'url'=>site_url($this->dir.'/list_data/'));
		$tab2 = array('text'=>'Non Program', 'on'=>1, 'url'=>site_url($this->dir.'/non_program/'));
		$tab3 = array('text'=>'Semua Agenda', 'on'=>null, 'url'=>site_url($this->dir.'/semua_program/'));
		$data['title'] 		= $title;
		$data['tabs'] = array($tab1, $tab2, $tab3);
		$data['content'] = 'schedul/agenda_view';
		$this->load->view('home', $data);
	}


	function detail_data($param=NULL) {
		$o = ($param !=NULL) ? un_de($param) : null;
/*
		cek($o['id_jadwal']);
		die();*/
		
		$from = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_ref_rincian tz' => array('tz.id_ref_rincian= tj.id_ref_rincian','left'),
			'sch_jenis_program tx' => array('tx.id_jenis_program= tj.id_jenis_program','left')
		);
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.*,tz.*';
		$detail_jadwal = $this->general_model->datagrab(array(
			'tabel'=>$from,
			'order'=>'tj.tgl_mulai ASC',
			'select'=>$select,
			'where'=>array('tj.id_jadwal'=>$o['id_jadwal'])
		))->row();

		$data['detail_jadwal']= @$detail_jadwal;
		$data['id_jadwal'] = $o['id_jadwal'];
		$data['nama_program'] = $detail_jadwal->nama_program;
		$data['nama_kegiatan'] = $detail_jadwal->nama_kegiatan;
		$data['nama_rincian'] = $detail_jadwal->nama_rincian;
		$data['tgl_mulai'] = $detail_jadwal->tgl_mulai;
		$data['tgl_selesai'] = $detail_jadwal->tgl_selesai;
		$data['lokasi'] = $detail_jadwal->lokasi;
		$data['indikator'] = $detail_jadwal->indikator;
		$data['sasaran'] = $detail_jadwal->sasaran;
		$data['pagu'] = $detail_jadwal->pagu;
		$data['keterangan'] = $detail_jadwal->content;
		$data['id_jenis_program'] = $detail_jadwal->id_jenis_program;

		$data['title'] 		= 'Detail Agenda Kegiatan'; 
		$data['content'] 	= 'schedul/target_view';
		
		$data['link_back'] = $this->dir.'/list_data/';
		
		$this->load->view('home', $data);
	}
	
	public function add_data($param=NULL){
    	$o = un_de($param);
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('schedul/agenda_kegiatan/save_aksi'),

        'id_ref_kegiatan' => set_value('id_ref_kegiatan'),
		);
       
        $dataview = array();
        $dataview['page_title'] = 'Nama kegiatan';
        $dataview['page_des'] = '';
        $dataview['bmain_page'] = 'Data';
        $dataview['bsub_page'] = 'Nama kegiatan';
        $dataview['title'] = '<small>Tambah</small> Nama kegiatan';
        $dataview['back_url'] = site_url('schedul/agenda_kegiatan');


    	$dataview['id_ref_kegiatan']=$o['id_ref_kegiatan'];
    	$from = array(
			'sch_ref_kegiatan a' => '',
			'sch_ref_program b' => array('a.id_ref_program = b.id_ref_program','left')
		);

        $det = $this->general_model->datagrab(array(
			'tabel' => $from,
			'where' => array('id_ref_kegiatan' => @$o['id_ref_kegiatan'])
		))->row();

        $dataview['id_ref_program']=@$det->id_ref_program;
        $dataview['nama_program']=@$det->nama_program;

    	$dataview['nama_kegiatan']=@$det->nama_kegiatan;
        // data combo
        $dataview['combo_jenis'] = $this->general_model->combo_box(array('tabel' => 'sch_jenis_program','key' => 'id_jenis_program','val' => array('nama_jenis')));
        $dataview['cb_tahun'] = $this->general_model->combo_box(array('tabel'=>'sch_ref_tahun','key'=>'id_tahun','val'=>array('tahun')));
    	
        $dataview['cb_kegiatan'] = $this->general_model->combo_box(array(
            'tabel'=>'sch_ref_kegiatan',
            'select'=>'*, concat(nama_kegiatan) nama_kegiatan_sel',
            'key'=>'id_ref_kegiatan',
            'val'=>array('nama_kegiatan_sel'),
            ));

        $dataview['content'] = 'schedul/agenda_form';

        $dataview['data'] = $data;

		$this->load->view('home', $dataview);
	}


    public function update($id){
        $o = un_de($id);
        $row = $this->general_model->datagrabs(array(
			'tabel'=>array(
				'sch_jadwal a'=>'',
				'sch_ref_program b'=>array('b.id_ref_program=a.id_ref_program', 'left'),
				'sch_ref_kegiatan c'=>array('c.id_ref_kegiatan=a.id_ref_kegiatan', 'left'),
				'sch_ref_rincian g'=>array('g.id_ref_rincian=a.id_ref_rincian', 'left'),
				'sch_color d'=>array('d.id_color=a.id_color', 'left'),
				'sch_jenis_program e'=>array('e.id_jenis_program=a.id_jenis_program', 'left'),
				'sch_ref_tahun f' => array('f.id_tahun= a.id_tahun','left')
				),
				'select'=>'a.*, b.nama_program, c.nama_kegiatan,d.*,e.*,g.nama_rincian,g.*',
				'where'=>array('id_jadwal'=>$o['id_jadwal'])
			))->row();

        if ($row) {
            $data = array(
	            'button' => 'Ubah',
	            'action' => site_url('schedul/agenda_kegiatan/save_aksi/'),
				'id_jadwal' => set_value('id_jadwal', $row->id_jadwal),
		        'id_ref_program' => set_value('id_ref_program', $row->id_ref_program),
		        'nama_program' => set_value('nama_program', $row->nama_program),
		        'id_ref_kegiatan' => set_value('id_ref_kegiatan', $row->id_ref_kegiatan),
				'nama_kegiatan' => set_value('propinsi', $row->nama_kegiatan),
		        'id_ref_rincian' => set_value('id_ref_rincian', $row->id_ref_rincian),
				'nama_rincian' => set_value('propinsi', $row->nama_rincian),
				'lokasi' => set_value('lokasi', $row->lokasi),
				'indikator' => set_value('indikator', $row->indikator),
				'sasaran' => set_value('sasaran', $row->sasaran),
				'pagu' => set_value('pagu', $row->pagu),
				'content' => set_value('content', $row->content),
				'tgl_mulai' => set_value('tgl_mulai', $row->tgl_mulai),
				'tgl_selesai' => set_value('tgl_selesai', $row->tgl_selesai),
				'id_color' => set_value('id_color', $row->id_color),
				'status' => set_value('status', $row->status),
				'jeda' => set_value('jeda', $row->jeda),
				'id_tahun' => set_value('id_tahun', $row->id_tahun),
				'id_jenis_program' => set_value('id_jenis_program', $row->id_jenis_program),
	    	);
			$id_jenis_program = $this->input->post('id_jenis_program');
	/*		$status = $this->input->post('status');
			$jeda = $this->input->post('jeda');
			$id_tahun = $this->input->post('id_tahun');*/
	        $dataview = array();
	        $dataview['page_title'] = 'Jadwal';
	        $dataview['page_des'] = '';
	        $dataview['bmain_page'] = 'Data';
	        $dataview['bsub_page'] = 'Jadwal dan Kegiatan';
	        $dataview['title'] = '<small>Ubah</small> Jadwal';
	        $dataview['back_url'] = site_url('schedul/agenda_kegiatan');
	        $dataview['content'] = 'schedul/agenda_update_form';
	        $dataview['id_jenis_program'] = $id_jenis_program;
	        /*$dataview['status'] = $status;
	        $dataview['jeda'] = $jeda;
	        $dataview['id_tahun'] = $id_tahun;*/
	        $dataview['data'] = $data;
	        $dataview['cb_tahun'] = $this->general_model->combo_box(array('tabel'=>'sch_ref_tahun','key'=>'id_tahun','val'=>array('tahun')));
    	
	        $dataview['function_script'] = "

	        function reset_search(btn, input, hidden){
	                btn.html('<i class=\"fa fa-search\"></i>');
	                btn.attr('disabled', 'disabled');

	                input.val('');
	                input.removeAttr('readonly', 'readonly');
	                hidden.val('');
	            }
	        $('#nama_program').typeahead({
	                ajax: '".site_url($this->dir.'/get_program')."',
	                displayField: 'nama_program',
	                valueField: 'id_ref_program',
	                onSelect: function(data){
	                    $('input[name=\"id_ref_program\"]').attr('value', data.value);
	                    $('#nama_program').attr('readonly', 'readonly');
	                    $('#btn_ref_prog').removeAttr('disabled');
	                    $('#btn_ref_prog').html('<i class=\"fa fa-close\"></i>');
	                   
	                }
	            });

	        $('#nama_kegiatan').typeahead({
	                ajax: '".site_url($this->dir.'/get_kegiatan')."',
	                displayField: 'nama_kegiatan',
	                valueField: 'id_ref_kegiatan',
	                onSelect: function(data){
	                    $('input[name=\"id_ref_kegiatan\"]').attr('value', data.value);
	                    $('#nama_kegiatan').attr('readonly', 'readonly');
	                    $('#btn_keg').removeAttr('disabled');
	                    $('#btn_keg').html('<i class=\"fa fa-close\"></i>');
	                   
	                }
	            });
			
        $('#nama_rincian').typeahead({
                ajax: '".site_url($this->dir.'/get_rincian')."',
                displayField: 'nama_rincian',
                valueField: 'id_ref_rincian',
                onSelect: function(data){
                    $('input[name=\"id_ref_rincian\"]').attr('value', data.value);
                    $('#nama_rincian').attr('readonly', 'readonly');
                    $('#btn_rin').removeAttr('disabled');
                    $('#btn_rin').html('<i class=\"fa fa-close\"></i>');
                   
                }
            });
	        ";

	        $dataview['include_script'] = "
	            $('.combo-box').select2();
	            $('.datepicker').datepicker({
	                  format: 'dd/mm/yyyy',
	                    // viewMode: \'years\', 
	                    // minViewMode: \'years\',
	                  todayBtn: 'linked',
	                  clearBtn: true,
	                  language: 'id',
	                  autoclose: true,
	                  todayHighlight: true
	            });
	        ";
	        $this->load->view('home', $dataview);
        } else {
            $this->session->set_flashdata('fail', 'Data tidak ditemukan....');
            redirect(site_url('schedul/agenda_kegiatan'));
        }
    }

	function get_jml() {
		$id_jenis_program = $this->input->post('id_jenis_program');
		/*cek($id_jenis_program);*/
		 $dataview['id_jenis_program'] = $id_jenis_program;
		 $dataview['cb_tahun'] = $this->general_model->combo_box(array('tabel'=>'sch_ref_tahun','key'=>'id_tahun','val'=>array('tahun')));
    	
		 $dataview['function_script'] = "

        function reset_search(btn, input, hidden){
                btn.html('<i class=\"fa fa-search\"></i>');
                btn.attr('disabled', 'disabled');

                input.val('');
                input.removeAttr('readonly', 'readonly');
                hidden.val('');
            }
        $('#nama_program').typeahead({
                ajax: '".site_url($this->dir.'/get_program')."',
                displayField: 'nama_program',
                valueField: 'id_ref_program',
                onSelect: function(data){
                    $('input[name=\"id_ref_program\"]').attr('value', data.value);
                    $('#nama_program').attr('readonly', 'readonly');
                    $('#btn_ref_prog').removeAttr('disabled');
                    $('#btn_ref_prog').html('<i class=\"fa fa-close\"></i>');
                   
                }
            });

        $('#nama_kegiatan').typeahead({
                ajax: '".site_url($this->dir.'/get_kegiatan')."',
                displayField: 'nama_kegiatan',
                valueField: 'id_ref_kegiatan',
                onSelect: function(data){
                    $('input[name=\"id_ref_kegiatan\"]').attr('value', data.value);
                    $('#nama_kegiatan').attr('readonly', 'readonly');
                    $('#btn_keg').removeAttr('disabled');
                    $('#btn_keg').html('<i class=\"fa fa-close\"></i>');
                   
                }
            });

        $('#nama_rincian').typeahead({
                ajax: '".site_url($this->dir.'/get_rincian')."',
                displayField: 'nama_rincian',
                valueField: 'id_ref_rincian',
                onSelect: function(data){
                    $('input[name=\"id_ref_rincian\"]').attr('value', data.value);
                    $('#nama_rincian').attr('readonly', 'readonly');
                    $('#btn_rin').removeAttr('disabled');
                    $('#btn_rin').html('<i class=\"fa fa-close\"></i>');
                   
                }
            });

        ";

        $dataview['include_script'] = "
            $('.combo-box').select2();
            $('.datepicker').datepicker({
                  format: 'dd/mm/yyyy',
                    // viewMode: \'years\', 
                    // minViewMode: \'years\',
                  todayBtn: 'linked',
                  clearBtn: true,
                  language: 'id',
                  autoclose: true,
                  todayHighlight: true
            });
        ";
		$this->load->view('schedul/get_jml', $dataview);
	}


    // AJAX REQUEST:
    function get_program(){
        $q = $this->input->post('query');
        $data = $this->general_model->datagrabs(array(
            'tabel'=>'sch_ref_program',
            'search'=>array('nama_program'=>$q),
            'select'=>'*',
            // 'limit'=>5,
            // 'offset'=>0,
            ));

        
        die(json_encode($data->result()));
    }
    // AJAX REQUEST:
    function get_kegiatan(){
        $q = $this->input->post('query');
        $data = $this->general_model->datagrabs(array(
            'tabel'=>'sch_ref_kegiatan',
            'search'=>array('nama_kegiatan'=>$q),
            'select'=>'*',
            ));        
        die(json_encode($data->result()));
    }

    // AJAX REQUEST:
    function get_rincian(){
        $q = $this->input->post('query');
        $data = $this->general_model->datagrabs(array(
            'tabel'=>'sch_ref_rincian',
            'search'=>array('nama_rincian'=>$q),
            'select'=>'*',
            ));        
        die(json_encode($data->result()));
    }


	function save_aksi() {
		$id_jenis_program = $this->input->post('id_jenis_program');
		$id_ref_program = $this->input->post('id_ref_program');
    	$nama_program = $this->input->post('nama_program',TRUE);
		$id_ref_kegiatan = $this->input->post('id_ref_kegiatan');
    	$nama_kegiatan = $this->input->post('nama_kegiatan',TRUE);
		$id_ref_rincian = $this->input->post('id_ref_rincian');
    	$nama_rincian = $this->input->post('nama_rincian',TRUE);
		$id_jadwal = $this->input->post('id_jadwal');


		$tgl_mulai = tanggal_php($this->input->post('tgl_mulai'));
		$tgl_selesai = tanggal_php($this->input->post('tgl_selesai'));
		/*cek($tgl_mulai);
		die();*/
		$tgl_skrg = date('Y-m-d');

		$status = $this->input->post('status');
	    $save_status = ($status != NULL) ? $status : 1;

		if($id_jenis_program == 1){
	    	//cek program
	        $cek_kode = $this->general_model->datagrabs(array('tabel'=>'sch_ref_program','select'=>'MAX(kode_program) as kode_programs'))->row();

	        $zero = '0';
			$cek_no_kode = $zero.''.($cek_kode->kode_programs + 1);


		    $cek_prog = $this->general_model->datagrabs(array('tabel'=>'sch_ref_program','where'=>array('nama_program'=>$nama_program),'select'=>'id_ref_program,MAX(id_ref_program) as id'))->row();
	        if(empty($cek_prog->id_ref_program)) {
	            $id_prog = $this->general_model->save_data('sch_ref_program',array('nama_program' => $nama_program,'kode_program'=>$cek_no_kode,'tgl_pengesah'=>$tgl_skrg)) ;
	        }else{
	            $id_prog = $cek_prog->id ;
	        }


	        //cek kegiatan
	        $cek_kode_keg = $this->general_model->datagrabs(array('tabel'=>'sch_ref_kegiatan','select'=>'MAX(kode_kegiatan) as kode_kegiatans'))->row();

	        $zero = '0';
			$cek_no_kode_kegx = $zero.''.($cek_kode_keg->kode_kegiatans + 1);

	        $cek_keg = $this->general_model->datagrabs(array('tabel'=>'sch_ref_kegiatan','where'=>array('nama_kegiatan'=>$nama_kegiatan),'select'=>'id_ref_kegiatan, MAX(id_ref_kegiatan) as id'))->row();
	        if(empty($cek_keg->id_ref_kegiatan)) {

	        	$id_keg = $this->general_model->save_data('sch_ref_kegiatan',array('id_ref_program' => $id_prog,'nama_kegiatan' => $nama_kegiatan,'kode_kegiatan'=>$cek_no_kode_kegx,'tgl_pengesah'=>$tgl_skrg));
	        }else{
	            $id_keg = $cek_keg->id_ref_kegiatan ;
	        }

	        //cek rincian
	        $cek_kode_rin = $this->general_model->datagrabs(array('tabel'=>'sch_ref_rincian','select'=>'MAX(kode_rincian) as kode_rincians'))->row();

	        $zero = '0';
			$cek_no_kode_rincx = $zero.''.($cek_kode_rin->kode_rincians + 1);

	        $cek_rin = $this->general_model->datagrabs(array('tabel'=>'sch_ref_rincian','where'=>array('nama_rincian'=>$nama_rincian),'select'=>'id_ref_rincian, MAX(id_ref_rincian) as id'))->row();
	        if(empty($cek_rin->id_ref_rincian)) {

	        	$id_rinc = $this->general_model->save_data('sch_ref_rincian',array('id_ref_kegiatan' => $id_keg,'nama_rincian' => $nama_rincian,'kode_rincian'=>$cek_no_kode_rincx,'tgl_pengesah'=>$tgl_skrg));
	        }else{
	            $id_rinc = $cek_rin->id_ref_rincian ;
	        }
	        
			$par = array(
			'tabel'=>'sch_jadwal',
			'data'=>array(
				
				'tgl_selesai'=>tanggal_php($this->input->post('tgl_selesai')),
				'id_jenis_program'=>$this->input->post('id_jenis_program'),
				'id_ref_program'=>$id_prog,
				'id_ref_kegiatan'=>$id_keg,
				'id_ref_rincian'=>$id_rinc,
				'id_tahun' => $this->input->post('id_tahun'),
				'content'=>$this->input->post('content'),
				'id_color'=>$this->input->post('id_color'),
				'lokasi'=>$this->input->post('lokasi'),
				'indikator'=>$this->input->post('indikator'),
				'sasaran'=>$this->input->post('sasaran'),
				'pagu'=>$this->input->post('pagu'),
				'jeda' => $this->input->post('jeda'),
				/*'status'=>$save_status,*/
				'id_pegawai' => $this->session->userdata('id_pegawai')
				),
			);

	       if($tgl_mulai == 0){
					$par['data']['status'] = 3 ;
			}else{

				$par['data']['status'] = $status ;
			}


			$cek_tgl = $this->general_model->datagrabs(array('tabel'=>'sch_jadwal','where'=>array('id_jadwal'=>$id_jadwal),'select'=>'id_jadwal,tgl_mulai,tgl_selesai'))->row();
	        
	        if($cek_tgl->tgl_mulai != $tgl_mulai){
				$par['data']['tgl_mulai_ubah'] = $cek_tgl->tgl_mulai ;
				$par['data']['tgl_mulai'] = $tgl_mulai ;
			}

	        if($cek_tgl->tgl_selesai != $tgl_selesai){
				$par['data']['tgl_selesai_ubah'] = $cek_tgl->tgl_selesai ;
				$par['data']['tgl_selesai'] = $tgl_selesai ;
			}


			if($id_jadwal!=NULL){
				$par['where'] = array('id_jadwal'=>$id_jadwal);
			}
			$sim = $this->general_model->save_data($par);
		}else{

			$tgl_mulai = tanggal_php($this->input->post('tgl_mulai'));
			/*cek($tgl_mulai);
			die();*/
			$tgl_selesai = tanggal_php($this->input->post('tgl_selesai'));
			$status = $this->input->post('status');
	        //cek kegiatan
	        $cek_kode_keg = $this->general_model->datagrabs(array('tabel'=>'sch_ref_kegiatan','select'=>'MAX(kode_kegiatan) as kode_kegiatans'))->row();

	        $zero = '0';
			$cek_no_kode_kegx = $zero.''.($cek_kode_keg->kode_kegiatans + 1);

	        $cek_keg = $this->general_model->datagrabs(array('tabel'=>'sch_ref_kegiatan','where'=>array('nama_kegiatan'=>$nama_kegiatan),'select'=>'id_ref_kegiatan, MAX(id_ref_kegiatan) as id'))->row();
	        if(empty($cek_keg->id_ref_kegiatan)) {

	        	$id_keg = $this->general_model->save_data('sch_ref_kegiatan',array('id_ref_program' => $id_ref_program,'nama_kegiatan' => $nama_kegiatan,'kode_kegiatan'=>$cek_no_kode_kegx));
	        }else{
	            $id_keg = $cek_keg->id_ref_kegiatan ;
	        }

	         //cek rincian
	        $cek_kode_rin = $this->general_model->datagrabs(array('tabel'=>'sch_ref_rincian','select'=>'MAX(kode_rincian) as kode_rincians'))->row();

	        $zero = '0';
			$cek_no_kode_rincx = $zero.''.($cek_kode_rin->kode_rincians + 1);

	        $cek_rin = $this->general_model->datagrabs(array('tabel'=>'sch_ref_rincian','where'=>array('nama_rincian'=>$nama_rincian),'select'=>'id_ref_rincian, MAX(id_ref_rincian) as id'))->row();
	        if(empty($cek_rin->id_ref_rincian)) {

	        	$id_rinc = $this->general_model->save_data('sch_ref_rincian',array('id_ref_kegiatan' => $id_keg,'nama_rincian' => $nama_rincian,'kode_rincian'=>$cek_no_kode_rincx,'tgl_pengesah'=>$tgl_skrg));
	        }else{
	            $id_rinc = $cek_rin->id_ref_rincian ;
	        }
	        

	        
				$par = array(
				'tabel'=>'sch_jadwal',
				'data'=>array(
					'tgl_mulai'=>tanggal_php($this->input->post('tgl_mulai')),
					'tgl_selesai'=>tanggal_php($this->input->post('tgl_selesai')),
					'id_jenis_program'=>$this->input->post('id_jenis_program'),
					'id_ref_kegiatan'=>$id_keg,
					'id_ref_rincian'=>$id_rinc,
					'id_tahun' => $this->input->post('id_tahun'),
					'content'=>$this->input->post('content'),
					'id_color'=>$this->input->post('id_color'),
					'jeda' => $this->input->post('jeda'),			
					/*'status'=>$save_status,*/
					'id_pegawai' => $this->session->userdata('id_pegawai')
					),
				);

		        if($tgl_mulai == 0){
					$par['data']['status'] = 3 ;
				}else{

					$par['data']['status'] = $status ;
				}

				$cek_tgl = $this->general_model->datagrabs(array('tabel'=>'sch_jadwal','where'=>array('id_jadwal'=>$id_jadwal),'select'=>'id_jadwal,tgl_mulai,tgl_selesai'))->row();
		        
		        if($cek_tgl->tgl_mulai != $tgl_mulai){
					$par['data']['tgl_mulai_ubah'] = $cek_tgl->tgl_mulai ;
					$par['data']['tgl_mulai'] = $tgl_mulai ;
				}

		        if($cek_tgl->tgl_selesai != $tgl_selesai){
					$par['data']['tgl_selesai_ubah'] = $cek_tgl->tgl_selesai ;
					$par['data']['tgl_selesai'] = $tgl_selesai ;
				}


				if($id_jadwal!=NULL){
					$par['where'] = array('id_jadwal'=>$id_jadwal);
				}
				$sim = $this->general_model->save_data($par);
		}
		$this->session->set_flashdata('ok','Pekerjaan Berhasil di Simpan');
		redirect($this->dir);
	}


	function del_peserta($e,$id_pelaksana) {
		$this->general_model->delete_data('spk_pelaksana','id_pelaksana',$id_pelaksana);
		$this->session->set_flashdata('ok','Data petugas Berhasil di Hapus');
		redirect($this->dir.'/add_data/'.in_de(array('id_jadwal'=>$e)));
	}


	function detail_job($id_jadwal=null){
		$p = un_de($id_jadwal);
		$idjob = $p['id_jadwal'];
		
		$from = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= td.id_nama_kegiatan','left')
		);
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.deskripsi,tj.nama_rincian,tj.status,tj.catatan';

		$data['draft'] =  $this->general_model->datagrab(array('tabel' =>$from,'select'=>'*,tj.status as statuseeee','where'=>array('id_jadwal' => $idjob)));

		$asd=$this->general_model->datagrab(array('tabel' => 'sch_jadwal','select'=>'status,catatan','where' => array('id_jadwal' => $idjob)))->row();
		@$val1=($asd->status!=1 and $asd->status!=3)?$asd->status:'2';
		@$cek1=($asd->status!=1 and $asd->status==2)? 'checked':'0';
		@$val2=($asd->status!=1 and $asd->status!=2)?$asd->status:'3';
		@$cek2=($asd->status!=1 and $asd->status==3)? 'checked':'0';
		$data['form_link'] = 'schedul/job/verifikasi/'.$id_jadwal;

		$data['form_data'] =
			'<p>'.form_label('Status').'<br>'.form_radio(array('name'=>'status','value'=>$val1, 'checked'=>$cek1)).' diterima </p><p>'.form_radio(array('name'=>'status','value'=>$val2, 'checked'=>$cek2)).' ditunda</p>
			<p>'.form_label('Catatan').'<br>'.form_textarea('catatan',@$asd->catatan,'required').'</p>';
		

		$data['title'] 		= 'Detail Job';
		
		$this->load->view('umum/form_view', $data);
		
	}
		
	function delete_data($code) {
		$sn = un_de($code);
		$id_jadwal = $sn['id_jadwal'];
		$del = $this->general_model->delete_data('sch_jadwal','id_jadwal',$id_jadwal);
		if ($del) {
			$this->session->set_flashdata('ok','Data Agenda Kegiatan Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Data Agenda Kegiatan Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}
