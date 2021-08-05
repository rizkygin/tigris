<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Pengaturan extends CI_Controller {
	
	var $dircut = 'referensi';
	
	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));

	}

	public function index() {
	
		$this->form_profil();
		
	}

	function get_app() {
		
		$app_active = $this->general_model->get_param('app_active');
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi',
			'where' => array('id_aplikasi IN ('.$app_active.') AND aktif = 1' => null)));

	}

	function form_profil() {
	
		$data['title'] = 'Pengaturan Parameter';
		$data['breadcrumb'] = array('' => 'Pengaturan', 'umum/profil' => 'Umum');
        if (!empty($this->dircut)) $data['dircut'] = $this->dircut;
        
		$app = $this->get_app();
		$tab = array();
		foreach($app->result() as $ap) {
		$tabulate = load_controller($ap->folder,'parameter_'.$ap->folder,'tab');
		
		if (!empty($tabulate)) {
			$tabulate = array_merge_recursive($tabulate,array('folder' => $ap->folder,'nama' => $ap->nama_aplikasi));
			$tab[] = $tabulate;
			}
		}
		
		$data['tab'] = $tab;
		$data['content'] = "umum/umum_view";
		$this->load->view('home', $data);
	}
	
	function save_setting() {
	
		$app = $this->get_app();
		$tab = array();

		foreach($app->result() as $ap) { load_controller($ap->folder,'parameter_'.$ap->folder,'save_data'); }
		
		$this->session->set_flashdata('ok','Penyimpanan pengaturan umum berhasil dilakukan');
		redirect('inti/pengaturan');
		
	}
	
	// -- Pengaturan Aplikasi -- 
	
	function aplikasi() {
		
		$s = $this->session->userdata('login_state');
		if ($s == 'root') {
	
			$data['breadcrumb'] = array('' => 'Root', 'inti/pengaturan/dasar' => 'Dasar', 'pengaturan/aplikasi' => 'Aplikasi');
				
			$offset = !empty($offset) ? $offset : null;
			
			$query = $this->general_model->datagrab(array('tabel'=>'ref_aplikasi','order' => 'urut','where' => array("id_par_aplikasi IS NULL" => null)));
			
			
			$this->table->set_template(array('table_open'=>'<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
			$this->table->set_heading(array('data'=>'No','style'=>'width:20px;text-align:center'),'',array('data' => 'Nama/Kode Aplikasi','colspan' => 2),'Deskripsi',array('data' => 'Aksi','colspan' => 2));
		
			$no = 1;
			foreach($query->result() as $row) {
				$ext = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('id_par_aplikasi' => $row->id_aplikasi)));
				
				$path_ava = './assets/logo/'.$row->folder.'.png';
				$ava = (file_exists($path_ava)) ? base_url().'assets/logo/'.$row->folder.'.png' : base_url().'assets/logo/referensi.png';
				
				$rows = array(
					array('data'=>$no,'class'=>'text-center'),
					'<div class="app-icon" style="background: '.(($row->aktif == 1)?$row->warna:'#ccc').'"><img src="'.$ava.'"/></div>',					
					array('data' => $row->nama_aplikasi.' ('.$row->kode_aplikasi.')','colspan' => 2,'class' => ($row->aktif == 1)?null:'text-muted'),
					array('data' => $row->deskripsi,'class' => ($row->aktif == 1)?null:'text-muted'));

					$s = null;
					if (file_exists('./application/controllers/'.$row->folder.'/db.php')) {
						$s = '<li>'.anchor(site_url($row->folder.'/db'),'<i class="fa fa-database"></i> Pemutakhiran Database','class="btn-db"').'</li>';
					} 
					
					$rows[] = '<div class="btn-group">
						<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
						<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right">
						<li>'.anchor('#','<i class="fa fa-pencil"></i> Ubah Redaksional','class="btn-edit" act="'.site_url('referensi/aplikasi/form_data/'.in_de(array('id' => $row->id_aplikasi,'status' => 'root'))).'"').'</li>
						<li>'.anchor('#','<i class="fa fa-trash"></i> Lepas &amp; Hapus Modul','class="btn-delete" act="'.site_url('pengaturan/aplikasi/delete_aplikasi/'.$row->id_aplikasi).'" msg="Apakah Anda ingin menghapus data <b>'.$row->kode_aplikasi.'</b>?"').'</li>'.$s.'
						</ul>
						</div>';
					$rows[] = ($row->aktif == 1) ? anchor('inti/pengaturan/saklar/off/'.$row->id_aplikasi,'<span class="btn btn-info btn-xs"><i class="fa fa-power-off"></i></span>') : anchor('inti/pengaturan/saklar/on/'.$row->id_aplikasi, '<span class="btn btn-default btn-xs"><i class="fa fa-circle-o"></i></span>');
					
					$this->table->add_row($rows);
					
					foreach($ext->result() as $e) {
						
						$path_ava_e = './assets/logo/'.$e->folder.'.png';
						$ava_e = (file_exists($path_ava_e)) ? base_url().'assets/logo/'.$e->folder.'.png' : base_url().'assets/logo/referensi.png';
						
						$rowsd = array('','','<div class="app-icon" style="background: '.$row->warna.'"><img src="'.$ava.'" style="width: 26px;"/></div>',					
						array('data' => $e->nama_aplikasi.' ('.$e->kode_aplikasi.')','class' => ($row->aktif == 1)?null:'text-muted'),
						array('data' => $e->deskripsi,'class' => ($row->aktif == 1)?null:'text-muted'));
						
						$ss = null;
						if (file_exists('./application/controllers/'.$row->folder.'/db.php')) {
						$ss = '<li>'.anchor(site_url($row->folder.'/db'),'<i class="fa fa-database"></i> Pemutakhiran Database','class="btn-db"').'</li>';
						} 
						
						$rowsd[] = '<div class="btn-group">
						<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
						<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right">
						<li>'.anchor('#','<i class="fa fa-pencil"></i> Ubah Redaksional','class="btn-edit" act="'.site_url('referensi/aplikasi/form_data/'.in_de(array('id' => $e->id_aplikasi,'status' => 'root'))).'"').'</li>
						<li>'.anchor('#','<i class="fa fa-trash"></i> Lepas &amp; Hapus Modul','class="btn-delete" act="'.site_url('pengaturan/aplikasi/delete_aplikasi/'.$e->id_aplikasi).'" msg="Apakah Anda ingin menghapus data <b>'.$e->kode_aplikasi.'</b>?"').'</li>'.$ss.'
						</ul>
						</div>';
						
						$rowsd[] = ($e->aktif == 1) ?  anchor('inti/pengaturan/saklar/off/'.$e->id_aplikasi,'<span class="btn btn-info btn-xs"><i class="fa fa-power-off"></i></span>') :  anchor('inti/pengaturan/saklar/on/'.$e->id_aplikasi,'<span class="btn btn-default btn-xs"><i class="fa fa-circle-o"></i></span>');
						
					
						$this->table->add_row($rowsd);
					}
					$no++;
				}
			$data['tabel'] = $this->table->generate();
			
			$data['tombol'] = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Modul Aplikasi','class="btn-edit btn btn-success" act="'.site_url('referensi/aplikasi/form_data/'.in_de(array('status' => 'root'))).'"');
			$data['load_view'] = 'umum/aplikasi_eks_view';
			
			
			$data['total'] = $query->num_rows();
			$data['title'] 		= 'Pengaturan Aplikasi';
			$data['content'] 	= "umum/standard_view";
			
		} else {
			$data['content'] 	= "umum/forbidden_view";
		}
		$this->load->view('home', $data);
	}
	
	function saklar($t,$id) {
		$simpan = ($t == 'on') ? array('aktif' => 1) : array('aktif' => 0);
		$this->general_model->save_data('ref_aplikasi',$simpan,'id_aplikasi',$id);
		
		$on = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi', 'where' => array('aktif' => 1)));
		$on_app = array();
		foreach($on->result() as $a) {
			$on_app[] = $a->id_aplikasi;
		}
		
		$this->general_model->save_data('parameter',array('val' => implode(',',$on_app)),'param','app_active');
		
		$this->session->set_flashdata('ok','Status Aplikasi berhasil diubah');
		redirect('inti/pengaturan/aplikasi');
	}
	
	function delete_aplikasi($id){

			$delete = $this->general_model->delete_data('ref_aplikasi','id_aplikasi',$id);
			
			if($delete) $this->session->set_flashdata('ok','Data berhasil dihapus');
			else $this->session->set_flashdata('ok','Data gagal dihapus');
			
			redirect('pengaturan/aplikasi');
	}

	function parameter() {

		$data['breadcrumb'] = array('' => 'Manajemen', 'inti/pengaturan/pengaturan' => 'Pengaturan Parameter');

		$data['got'] = $this->general_model->get_param(array(
			'aplikasi',
			'aplikasi_code',
			'aplikasi_s',
			'aplikasi_logo',
			'aplikasi_logo_ext',
			'ibukota',
			'alamat',
			'pemerintah',
			'pemerintah_s',
			'pemerintah_logo',
			'pemerintah_logo_bw',
			'instansi',
			'instansi_s',
			'instansi_code',
			'copyright',
			'multi_unit',
			'demo',
			'main_color'),2);

		$data['title'] 	 = '<i class="fa fa-cog"></i> &nbsp; Pengaturan Dasar';
		$data['content'] = "umum/parameter_view";
		$this->load->view('home', $data);
	}
	
	function save_aturan() {
		
		$param = $this->input->post('param');
		$vale = $this->input->post('vale');
		$i = 0;
		$simpan = array();
		foreach ($param as $p) {
			if ($param[$i] == "aplikasi_logo") {
				if (!empty($_FILES['logo_app']['name'])) {
					$logo_app_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_app_logo = FCPATH.'logo/'.$logo_app_lama->row('val');
					if (file_exists($path_app_logo)) unlink($path_app_logo);
					$path_appthumb_logo = FCPATH.'logo/thumbnails/'.$logo_app_lama->row('val');
					$delete_thumb = unlink($path_appthumb_logo);
					
					$config['upload_path'] = './logo/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']	= '1000000';
					$config['max_width']  = '1024000';
					$config['max_height']  = '7680000';
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('logo_app')){
						$data['error'] = $this->upload->display_errors();
						echo $data['error'];
					} else {
						$data = $this->upload->data();
						$vale[$i] = $data['file_name'];
						$konfigurasi = array(
							'source_image'=>$data['full_path'],
							'new_image'=>'./logo/thumbnails/',
							'maintain_ration' => true,
							'width' => 400,
							'height' =>300
							);
						$this->load->library('image_lib', $konfigurasi);
						$this->image_lib->resize();
					}
					
				}
				
				if ($this->input->post('reset_logo')) {
					$logo_app_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_app_logo = FCPATH.'logo/'.$logo_app_lama->row('val');
					if (file_exists($path_app_logo)) unlink($path_app_logo);
					$path_appthumb_logo = FCPATH.'logo/thumbnails/'.$logo_app_lama->row('val');
					$delete_thumb = unlink($path_appthumb_logo);
				}
			} else if ($param[$i] == "pemerintah_logo") {
				if (!empty($_FILES['logo_pemerintah']['name'])) {
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
		
					$config['upload_path'] = './logo/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']	= '1000000';
					$config['max_width']  = '1024000';
					$config['max_height']  = '7680000';
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('logo_pemerintah')){
						$data['error'] = $this->upload->display_errors();
						echo $data['error'];
					}else {
						$data = $this->upload->data();
						$vale[$i] = $data['file_name'];
						$konfigurasi = array(
							'source_image'=>$data['full_path'],
							'new_image'=>'./logo/thumbnails/',
							'maintain_ration' => true,
							'width' => 400,
							'height' =>300
							);
						$this->load->library('image_lib', $konfigurasi);
						$this->image_lib->resize();
					}
					
				}
				if ($this->input->post('reset_logo_pemerintah')) {
		
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
				}
			} else if ($param[$i] == "pemerintah_logo_bw") {
				if (!empty($_FILES['logo_pemerintah_bw']['name'])) {
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
		
					$config['upload_path'] = './logo/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']	= '1000000';
					$config['max_width']  = '1024000';
					$config['max_height']  = '7680000';
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('logo_pemerintah_bw')){
						$data['error'] = $this->upload->display_errors();
						echo $data['error'];
					}else {
						$data = $this->upload->data();
						$vale[$i] = $data['file_name'];
						$konfigurasi = array(
							'source_image'=>$data['full_path'],
							'new_image'=>'./logo/thumbnails/',
							'maintain_ration' => true,
							'width' => 400,
							'height' =>300
							);
						$this->load->library('image_lib', $konfigurasi);
						$this->image_lib->resize();
					}
					
				}
				if ($this->input->post('reset_logo_pemerintah')) {
		
					$logo_pemerintah_lama = $this->general_model->datagrab(array('tabel'=>'parameter', 'select'=>'val', 'where'=>array('param'=>$param[$i])));
					
					$path_pem_logo = FCPATH.'logo/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pem_logo)) unlink($path_pem_logo);
					
					$path_pemthumb_logo = FCPATH.'logo/thumbnails/'.$logo_pemerintah_lama->row('val');
					if (file_exists($path_pemthumb_logo)) unlink($path_pemthumb_logo);
				}
			}
			
			
			$g = $this->general_model->datagrab(array('tabel' => 'parameter','where' => array('param' => $param[$i])));
			if ($g->num_rows() > 0) $this->general_model->save_data(array('tabel' => 'parameter','data' => array('val' => $vale[$i]),'where' => array('param' => $param[$i])));
			else $this->general_model->save_data(array('tabel' => 'parameter','data' => array('param' => $param[$i],'val' => $vale[$i])));

			$i+=1;
		}
		$this->session->set_flashdata('ok','Pengaturan berhasil disimpan');
		redirect('inti/pengaturan/parameter');
	}

	function impor() {
		
		$data['breadcrumb'] = array('' => 'Manajemen', 'inti/pengaturan/impor' => 'Impor Kepegawaian');

		$data['tabel'] = '
        
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#excel">File Excel</a></li>
          <li><a data-toggle="tab" href="#csv">File CSV</a></li>
          <li><a data-toggle="tab" href="#page">Halaman Impor</a></li>
        </ul>
        <div class="tab-content no-padding">
       		<div id="excel" class="tab-pane active">&nbsp;<br>'.
       		form_open_multipart('inti/pengaturan/excel_importing','id="form_excel" role="form"').
       		'<div class="row"><div class="col-lg-4">'.
       		'<p>'.form_label('Status Data').'<br><label>'.form_checkbox('on_reset',1,NULL).'<span style="font-weight: lighter"> &nbsp; Kosongkan Data / Inisiasi</span></label></p>'.
       		'<p>'.form_label('Mulai Baris Impor').form_input('baris',2,'class="form-control"  style="max-width: 100px" onkeyup="return formatNumber(this)"').'</p>'.
       		'<p>'.form_label('Pilih File Excel').form_upload('excel_impor','class="form-control"').'</p>'.
       		'</div>
       		<div class="col-lg-8">'.form_label('Nomor Kolom (dari kiri)').'</div>
       		<div class="col-lg-4">'.
       			'<p><div class="input-group"><div class="input-group-addon">NIP</div>'.form_input('k_nip',2,'class="form-control" placeholder="2"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">NIP Lama</div>'.form_input('k_nip_lama',3,'class="form-control" placeholder="3"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Nama</div>'.form_input('k_nama',4,'class="form-control" placeholder="4"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Gelar Depan</div>'.form_input('k_gelar_depan',5,'class="form-control" placeholder="5"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Gelar Belakang</div>'.form_input('k_gelar_belakang',6,'class="form-control" placeholder="6"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Tempat Lahir</div>'.form_input('k_tempat_lahir',7,'class="form-control" placeholder="7"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Tanggal Lahir</div>'.form_input('k_tanggal_lahir',8,'class="form-control" placeholder="8"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">TMT CPNS</div>'.form_input('k_tmt_cpns',10,'class="form-control" placeholder="10"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">TMT PNS</div>'.form_input('k_tmt_pns',11,'class="form-control" placeholder="11"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Jenis Kelamin</div>'.form_input('k_jenis_kelamin',12,'class="form-control" placeholder="12"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Agama</div>'.form_input('k_agama',null,'class="form-control" placeholder="..."').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Alamat</div>'.form_input('k_alamat',null,'class="form-control" placeholder="..."').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">NIK/KTP</div>'.form_input('k_nik',null,'class="form-control" placeholder="..."').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">NPWP</div>'.form_input('k_npwp',null,'class="form-control" placeholder="..."').'</div></p>'.
       			
       			'</div><div class="col-lg-4">'.	
       			'<p><div class="input-group"><div class="input-group-addon">Golru/Pangkat</div>'.form_input('k_golru',13,'class="form-control" placeholder="13"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">TMT Golru/Pangkat</div>'.form_input('k_tmt_golru',14,'class="form-control" placeholder="14"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">MKG Tahun</div>'.form_input('k_mkg_tahun',15,'class="form-control" placeholder="15"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">MKG Bulan</div>'.form_input('k_mkg_bulan',16,'class="form-control" placeholder="16"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Eselon</div>'.form_input('k_eselon',17,'class="form-control" placeholder="17"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">TMT Jabatan Struktural</div>'.form_input('k_tmt_s',18,'class="form-control" placeholder="18"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Jabatan Struktural</div>'.form_input('k_s',19,'class="form-control" placeholder="19"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">TMT Jabatan Fungsional Tertentu</div>'.form_input('k_tmt_jft',20,'class="form-control" placeholder="20"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Jabatan Fungsional Tertentu</div>'.form_input('k_jft',21,'class="form-control" placeholder="21"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Jabatan Fungsional Umum</div>'.form_input('k_jfu',22,'class="form-control" placeholder="22"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Unit Organisasi</div>'.form_input('k_bidang',23,'class="form-control" placeholder="23"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Unit Kerja</div>'.form_input('k_unit',23,'class="form-control" placeholder="23"').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Jenjang</div>'.form_input('k_jenjang',null,'class="form-control" placeholder="..."').'</div></p>'.
       			'<p><div class="input-group"><div class="input-group-addon">Jurusan</div>'.form_input('k_jurusan',null,'class="form-control" placeholder="..."').'</div></p>'.
       		'</div></div>'.
       		'<p>'.form_submit('btn_process','Impor Excel','class="btn btn-proses btn-success"').'</p>'.
       		'</div>
       		<div id="csv" class="tab-pane">&nbsp;<br>'.
       		form_open_multipart('inti/pengaturan/csv_importing','id="form_csv" role="form"').
			'<p><label>'.form_checkbox('on_reset',1,NULL).' &nbsp; Kosongkan Data / Inisiasi</label></p>'.
       		'<p>'.form_label('Pilih File CSV').form_upload('csv_impor').'</p>'.
       		'<p>'.form_submit('btn_process','Impor CSV','class="btn btn-proses btn-success"').'</p>'.
       		'</div>
            <div id="page" class="tab-pane">&nbsp;<br>'.
			form_open('inti/pengaturan/impor_proses','id="form_impor"').
			'<p>'.form_label('URL Impor').form_textarea('tujuan','http://localhost/yes/simpegdiy/home/impor','class="form-control" style="height: 80px"').'</p>'.
			'<p>'.form_submit('btn_submit','Periksa','class="btn btn-success"').'</p>'.form_close().'</div></div>';
		
		$data['script'] = "
			$(document).ready(function() {
				$('.btn-proses').click(function() {
					$(this).addClass('disabled').attr('disabled','disabled').val('Proses Impor ...');
					setInterval('menunggu()',2000);
				});			
				
			});
			function menunggu() {
				$.ajax({
				  url: 'total_temp',
				  cache: false,
				  dataType: 'json',
				  success: function(msg) {
					$('.btn-proses').val('Proses Impor ... ('+msg+' data)').show();
				  },error:function(error){
					show_error(error);
				}
			});
			}";
		
		$data['title'] 	 = '<i class="fa fa-download"></i> &nbsp; Impor Kepegawaian';
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function impor_proses($search = null,$offset = null) {
		
		//cek(un_de($search));
		
		$tuj = $this->input->post('tujuan');
		
		$se = array();
		
		if ($search) {
			$o = un_de($search);
			$se['tx'] = @$o['tx'];
			$se['imp'] = @$o['imp'];
			$se['off'] = $offset;
			$se['t'] = site_url('inti/pengaturan/impor_proses/');
		} else {
			$se['imp'] = $tuj;
			$se['off'] = $offset;
			$se['t'] = site_url('inti/pengaturan/impor_proses/');
		}
	
		
		$data['title'] 	 = '<i class="fa fa-download"></i> &nbsp; Impor Kepegawaian';
		$data['tujuan'] = $se['imp'];
		$data['offs'] = $se['off'];
		$data['se'] = in_de($se);
		
		$data['offset'] = !empty($offset) ? $offset : null;
		
		$data['content'] = "referensi/impor_view";
		$this->load->view('home', $data);
		
	}
	
	function importing() {
		
		$pilih = $this->input->post('pilih');
		$nip = $this->input->post('nip');
		$nip_lama = $this->input->post('nip_lama');
		$nama = $this->input->post('nama');
		$g_depan = $this->input->post('gelar_depan');
		$g_belakang = $this->input->post('gelar_belakang');
		$unit = $this->input->post('unit');
		$bidang = $this->input->post('bidang');
		$gol = $this->input->post('gol');
		$tmt_pangkat = $this->input->post('tmt_pangkat');
		$jabatan = $this->input->post('jabatan');
		$tmt_jab = $this->input->post('tmt_jab');
		$eselon = $this->input->post('eselon');
		$bup = $this->input->post('bup');
		
		$gnd = $this->input->post('id_jeniskelamin');
		$tgl_lahir = $this->input->post('tgl_lahir');
		$tmpt = strtoupper($this->input->post('tempat_lahir'));
		$cpns_tmt = $this->input->post('tmt_cpns');
		$mkg_bulan = $this->input->post('mkg_bulan');
		$mkg_tahun = $this->input->post('mkg_tahun');
		$alamat = $this->input->post('alamat');
		$no_nik = $this->input->post('ktp');
		$no_npwp = $this->input->post('npwp');
		$agama = strtoupper($this->input->post('agama'));

		$total = 0;
		
		foreach($pilih as $p => $v) {
			
			// Pegawai
			
			$c_nip = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => array('nip' => $nip[$v]),'select' => 'count(nip) as jml,id_pegawai'))->row();
			if (empty($c_nip->jml) and !empty($dat['nip']) and !empty($dat['nama'])) {
				$total += 1;
				/* -- Tempat Lahir -- */
				
				if (!empty($tmpt[$v])) {
					$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $tmpt[$v]),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
					if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $tmpt[$v]));
					else $id_tmpt = $c_tempat->id_lokasi;
				}
				
				if (!empty($agama[$v])) {
					/* -- Agama -- */
					$c_agama = $this->general_model->datagrab(array('tabel' => 'ref_agama','where' => array('agama' => $agama[$v]),'select' => 'count(id_agama) as jml,id_agama'))->row();
					if (empty($c_agama->jml)) $id_agama = $this->general_model->save_data('ref_agama', array('agama' => $agama[$v]));	
					else $id_agama = $c_agama->id_agama;
				}
				$nip_simpan = !empty($nip[$v]) ? $nip[$v] : $nip_lama[$v];
				
				$s_peg = array(
					'username' => $nip_simpan,
					'password' => md5($nip_simpan),//md5('qwerty'),
					'id_tipe_pegawai' => 1,
					'nip_lama' => $nip_lama[$v],
					'nip' => $nip[$v],
					'nama' => $nama[$v],
					'gelar_depan' => $g_depan[$v],
					'gelar_belakang' => $g_belakang[$v],
					'id_jeniskelamin' => !empty($gnd[$v])?$gnd[$v]:1,
					'id_tempat_lahir' => !empty($id_tmpt)?$id_tmpat:0,
					'id_agama' => !empty($id_agama)?$id_agama:0,
					'tanggal_lahir' => @$tgl_lahir[$v],
					'cpns_tmt' => @$cpns_tmt[$v],
					'mkg_bulan' => @$mkg_bulan[$v],
					'mkg_tahun' => @$mkg_tahun[$v],
					'no_nik' => @$no_nik[$v],
					'no_npwp' => @$no_npwp[$v]
				); $id_peg = $this->general_model->save_data('peg_pegawai',$s_peg);
			} else {
				$id_peg = $c_nip->id_pegawai;
			}
			
			// Unit
			
			$c_unit = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('unit' => $unit[$v]),'select' => 'count(id_unit) as jml,id_unit'))->row();
			if (empty($c_unit->jml)) {
				$id_unit = $this->general_model->save_data('ref_unit', array('unit' => $unit[$v],'level_unit' => '1'));
			} else {
				$id_unit = $c_unit->id_unit;
			}
			
			// Bidang
			
			$c_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('nama_bidang' => $bidang[$v],'id_unit' => $id_unit),'select' => 'count(id_bidang) as jml,id_bidang'))->row();
			
			$ur_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $id_unit),'select' => 'MAX(urut) as urutan'))->row();
			
			if (empty($c_bid->jml)) {
				$s_bid = array(
					'id_unit' => $id_unit,
					'nama_bidang' => $bidang[$v],
					'level' => 1,
					'urut' => $ur_bid->urutan+1	
				);
				$id_bidang = $this->general_model->save_data('ref_bidang',$s_bid);
			} else {
				$id_bidang = $c_bid->id_bidang;
			}
			
			// Jabatan
			
			$c_jab = $this->general_model->datagrab(array('tabel' => 'ref_jabatan','where' => array('nama_jabatan' => $jabatan[$v]),'select' => 'count(id_jabatan) as jml,id_jabatan'))->row();
			if (empty($c_jab->jml)) {
				$s_jab = array(
					'id_eselon' => $eselon[$v],
					'id_jab_jenis' => (($eselon[$v] == '9') ? 2 : 1),
					'nama_jabatan' => $jabatan[$v],
					'stat_jab' => (($eselon[$v] == '9') ? '2' : '1'),
					'bup' => $bup[$v]	
				);
				$id_jab = $this->general_model->save_data('ref_jabatan',$s_jab);
			} else {
				$id_jab = $c_jab->id_jabatan;
			}
			
			/* -- Simpan Jabatan -- */
		
			$where_jab = array(
				'id_pegawai' => $id_peg,
				'id_jabatan' => $id_jab,
				'id_unit' => $id_unit,
				'id_bidang' => $id_bidang,
				'tmt_jabatan' => $tmt_jab[$v]);
			$cek_jab = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where' => $where_jab));
		
			if ($cek_jab->num_rows() == 0) {
			
			$this->general_model->save_data('peg_jabatan',array('status' => 0),'id_pegawai',$id_peg);
			
			$simpan_jabatan = array(
				'id_pegawai' => $id_peg,
				'id_jabatan' => $id_jab,
				'id_unit' => $id_unit,
				'id_bidang' => $id_bidang,
				'tmt_jabatan' => $tmt_jab[$v],
				'id_status_pegawai' => '2',
				'status' => '1'
			); $this->general_model->save_data('peg_jabatan',$simpan_jabatan);
			
			}
			
			/* -- Simpan Golru -- */
			
			$where_golru = array(
				'id_pegawai' => $id_peg,
				'id_golru_jenis' => '1',
				'id_golru' => $gol[$v],
				'tmt_pangkat' => $tmt_pangkat[$v]);
			$cek_golru = $this->general_model->datagrab(array('tabel' => 'peg_pangkat','where' => $where_golru));

			if ($cek_golru->num_rows() == 0) {
			
			$this->general_model->save_data('peg_pangkat',array('status' => 0),'id_pegawai',$id_peg);
			
			$simpan_golru = array(
				'id_pegawai' => $id_peg,
				'id_golru_jenis' => '1',
				'id_golru' => $gol[$v],
				'tmt_pangkat' => $tmt_pangkat[$v],
				'status' => '1'
			); $this->general_model->save_data('peg_pangkat',$simpan_golru);
			
			}
			
		}
	
		$tujuan = $this->input->post('tujuan');
		$se = $this->input->post('se');
		$offs = $this->input->post('offs');
		
		$this->session->set_flashdata('ok', $total. ' data pegawai berhasil diproses');
		
		redirect('inti/pengaturan/impor_proses/'.$se.'/'.$offs);
		
		
	}
	
	function csv_importing() {
		
		$res = $this->input->post('on_reset');

		if (empty($_FILES['csv_impor']['tmp_name'])) {
			$error = 'Pilih dokumen CSV';
		} else {
			$this->load->library('upload');
			$this->upload->initialize(array(
				'file_name' => 'pegawai.csv',
				'upload_path' => './uploads/',
				'allowed_types' => '*'));
			if (! $this->upload->do_upload('csv_impor')) {
				$error = $this->upload->display_errors();
			} else {
				$data_up = $this->upload->data();
				$this->load->library('csvreader');
		        $data_read = $this->csvreader->parse_file('./uploads/'.$data_up['file_name']);
				
				$total = 0;
				if (!empty($res)) {
				$tab_delete = array(
					'peg_anak',
					'peg_beasiswa',
					'peg_cuti',
					'peg_diklatpim',
					'peg_dokumen',
					'peg_formal',
					'peg_hukdis',
					'peg_ijintugas_belajar',
					'peg_informal',
					'peg_inpassing',
					'peg_jabatan',
					'peg_kartu',
					'peg_karyatulis',
					'peg_keluarga',
					'peg_kesejahteraan',
					'peg_kgb',
					'peg_nilai',
					'peg_organisasi',
					'peg_pangkat',
					'peg_penghargaan',
					'peg_pensiun',
					'per_perkawinan',
					'peg_sertifikasi',
					'peg_tes',
					'peg_tugas',
					'peg_tunjangan',
					'peg_upi',
					'peg_pegawai',
					'ref_lokasi',
					'ref_agama',
					'ref_jurusan',
					'ref_lembaga',
					'ref_lokasi',
					'ref_unit',
					'ref_bidang',
					'ref_jabatan');
				
				$this->general_model->dataempty($tab_delete);
				}
				
				//cek($data_read);
				//exit;
				foreach($data_read as $dat) {
					$total += 1;
					if (!empty($dat['nip']) and !empty($dat['nama'])) {
					// Pegawai
					
					$c_nip = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => array('nip' => $dat['nip']),'select' => 'count(nip) as jml,id_pegawai'))->row();
					if (empty($c_nip->jml)) {
						
						/* -- Tempat Lahir -- */
						
						if (!empty($dat['tempat_lahir'])) {
							$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $dat['tempat_lahir']),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
							if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $dat['tempat_lahir']));
							else $id_tmpt = $c_tempat->id_lokasi;
						}
						
						if (!empty($dat['agama'])) {
							/* -- Agama -- */
							$c_agama = $this->general_model->datagrab(array('tabel' => 'ref_agama','where' => array('agama' => $dat['agama']),'select' => 'count(id_agama) as jml,id_agama'))->row();
							if (empty($c_agama->jml)) $id_agama = $this->general_model->save_data('ref_agama', array('agama' => $dat['agama']));	
							else $id_agama = $c_agama->id_agama;
						}
						
						$nip_simpan = !empty($dat['nip']) ? $dat['nip'] : $dat['nip_lama'];
						
						$gnd = !empty($dat['jenis_kelamin']) ? ($dat['jenis_kelamin'] == "L"?"1":"2") : null;
						
						$s_peg = array(
							'username' => $nip_simpan,
							'password' => md5($nip_simpan),//md5('qwerty'),
							'id_tipe_pegawai' => 1,
							'nip_lama' => $dat['nip_lama'],
							'nip' => $dat['nip'],
							'nama' => $dat['nama'],
							'gelar_depan' => !empty($dat['gelar_depan'])?$dat['gelar_depan']:null,
							'gelar_belakang' => !empty($dat['gelar_belakang'])?$dat['gelar_belakang']:null,
							'id_jeniskelamin' => $gnd,
							'id_tempat_lahir' => !empty($id_tmpt)?$id_tmpt:0,
							'id_agama' => !empty($id_agama)?$id_agama:0,
							'tanggal_lahir' => !empty($dat['tanggal_lahir']) ? $dat['tanggal_lahir'] : null,
							'mkg_bulan' => !empty($dat['mkg_bulan'])?$dat['mkg_bulan']:null,
							'mkg_tahun' => !empty($dat['mkg_tahun'])?$dat['mkg_tahun']:null,
							'no_nik' => !empty($dat['nik'])?$dat['nik']:null,
							'no_npwp' => !empty($dat['npwp'])?$dat['npwp']:null,
							'alamat' => !empty($dat['alamat'])?$dat['alamat']:null
						); 
						
						if (!empty($dat['cpns_tmt'])) $s_peg['cpns_tmt'] = $dat['tmt_cpns'];
						
						$id_peg = $this->general_model->save_data('peg_pegawai',$s_peg);
					} else {
						$id_peg = $c_nip->id_pegawai;
					}
					
					// Unit
					
					$c_unit = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('unit' => $dat['unit']),'select' => 'count(id_unit) as jml,id_unit'))->row();
					if (empty($c_unit->jml)) {
						$id_unit = $this->general_model->save_data('ref_unit', array('unit' => $dat['unit'],'level_unit' => '1'));
					} else {
						$id_unit = $c_unit->id_unit;
					}
					
					// Bidang
					
					$c_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('nama_bidang' => $dat['bidang'],'id_unit' => $id_unit),'select' => 'count(id_bidang) as jml,id_bidang'))->row();
					
					$ur_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $id_unit),'select' => 'MAX(urut) as urutan'))->row();
					
					if (empty($c_bid->jml)) {
						$s_bid = array(
							'id_unit' => $id_unit,
							'nama_bidang' => $dat['bidang'],
							'level' => 1,
							'urut' => $ur_bid->urutan+1	
						);
						$id_bidang = $this->general_model->save_data('ref_bidang',$s_bid);
					} else {
						$id_bidang = $c_bid->id_bidang;
					}
					
					// Jabatan
					
					if (!empty($dat['jabatan']) or !empty($dat['jab_struktural']) or !empty($dat['jab_ft']) or !empty($dat['jab_fu'])) {
					
					if (!empty($dat['jabatan'])) $nama_jabatan = $dat['jabatan'];
					else if (!empty($dat['jab_struktural'])) $nama_jabatan = $dat['jab_struktural'];					else if (!empty($dat['jab_ft'])) $nama_jabatan = $dat['jab_ft'];
					else if (!empty($dat['jab_fu'])) $nama_jabatan = $dat['jab_fu'];
					
					$ess_data = array(
							'' => '9',
							'11' => '0',	
							'12' => '1',
							'21' => '2',
							'22' => '3',
							'31' => '4',
							'32' => '5',
							'41' => '6',
							'42' => '7',
							'51' => '8'
						);
						
					$ess = !empty($ess_data[$dat['eselon']])?$ess_data[strtoupper($dat['eselon'])]:9;
					
					if (!empty($dat['jabatan'])) {
						$stat_jab = (($ess == '9') ? '2' : '1'); }
					else if (!empty($dat['jab_struktural'])) $stat_jab = 1;
					else if (!empty($dat['jab_ft'])) $stat_jab = 2;
					else if (!empty($dat['jab_fu'])) $stat_jab = 3;
					
					$c_jab = $this->general_model->datagrab(array(
						'tabel' => 'ref_jabatan',
						'where' => array('nama_jabatan' => $nama_jabatan),
						'select' => 'count(id_jabatan) as jml,id_jabatan'))->row();
					if (empty($c_jab->jml)) {
						/*
							$ess_data = array(
							'' => '9',
							'I.A' => '0',	
							'I.B' => '1',
							'II.A' => '2',
							'II.B' => '3',
							'III.A' => '4',
							'III.B' => '5',
							'IV.A' => '6',
							'IV.B' => '7',
							'V.A' => '8'
						);
						*/
						
						$s_jab = array(
							'id_eselon' => $ess,
							'id_jab_jenis' => (($ess == '9') ? 2 : 1),
							'nama_jabatan' => $nama_jabatan,
							'stat_jab' => $stat_jab,
							'bup' => !empty($dat['bup'])?$dat['bup']:58	
						);
						$id_jab = $this->general_model->save_data('ref_jabatan',$s_jab);
					} else {
						$id_jab = $c_jab->id_jabatan;
					}
					
					if (!empty($dat['jabatan'])) $tmt_jab = !empty($dat['tmt_jabatan'])?$dat['tmt_jabatan']:(!empty($dat['tmt_pns']) ? $dat['tmt_pns'] : $dat['tmt_cpns']);
					else if (!empty($dat['jab_struktural'])) $tmt_jab = $dat['tmt_struktural'];
					else if (!empty($dat['jab_ft'])) $tmt_jab = $dat['tmt_jft'];
					else if (!empty($dat['jab_fu'])) $tmt_jab = !empty($dat['tmt_pns']) ? $dat['tmt_pns'] : $dat['tmt_cpns'];
					
					}
					
					
					if (!empty($id_jab)) {
					
					/* -- Simpan Jabatan -- */
				
					$where_jab = array(
						'id_pegawai' => $id_peg,
						'id_jabatan' => $id_jab,
						'id_unit' => $id_unit,
						'id_bidang' => $id_bidang,
						'tmt_jabatan' => $tmt_jab);
					$cek_jab = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where' => $where_jab));
				
					if ($cek_jab->num_rows() == 0) {
					
					$this->general_model->save_data('peg_jabatan',array('status' => 0),'id_pegawai',$id_peg);
					
					$simpan_jabatan = array(
						'id_pegawai' => $id_peg,
						'id_jabatan' => $id_jab,
						'id_unit' => $id_unit,
						'id_bidang' => $id_bidang,
						'tmt_jabatan' => $tmt_jab,
						'id_status_pegawai' => '2',
						'status' => '1'
					); $this->general_model->save_data('peg_jabatan',$simpan_jabatan);
					
					}
					}
				
					
					/* -- Simpan Golru -- */
					
					$gol_data = array(
							'I/a' => 1,	
							'I/b' => 3,
							'I/c' => 3,
							'I/d' => 4,	
							'II/a' => 5,
							'II/b' => 6,
							'II/c' => 7,	
							'II/d' => 8,
							'III/a' => 9,
							'III/b' => 10,	
							'III/c' => 11,
							'III/d' => 12,
							'IV/a' => 13,
							'IV/b' => 14,
							'IV/c' => 15,
							'IV/d' => 16,
							'IV/e' => 17);
					
					$id_golru = !empty($gol_data[$dat['golru']])?$gol_data[$dat['golru']]:null;
					if(!empty($id_golru)) {
					$where_golru = array(
						'id_pegawai' => $id_peg,
						'id_golru_jenis' => '1',
						'id_golru' => $id_golru,
						'tmt_pangkat' => $dat['tmt_golru']);
					$cek_golru = $this->general_model->datagrab(array('tabel' => 'peg_pangkat','where' => $where_golru));
		
					if ($cek_golru->num_rows() == 0) {
					
					$this->general_model->save_data('peg_pangkat',array('status' => 0),'id_pegawai',$id_peg);
					
					$simpan_golru = array(
						'id_pegawai' => $id_peg,
						'id_golru_jenis' => '1',
						'id_golru' => $id_golru,
						'tmt_pangkat' => $dat['tmt_golru'],
						'status' => '1'
					); $this->general_model->save_data('peg_pangkat',$simpan_golru);
					
					}
					}
					
					/* -- Pendidikan -- */
					
					if (!empty($dat['lembaga']) and !empty($dat['jenjang']) and !empty($dat['lulus'])) {
					
					/* ---- Lembaga ---- */
					
					$c_lembaga = $this->general_model->datagrab(array(
						'tabel' => 'ref_lembaga',
						'where' => array('UPPER(lembaga_pendidikan)' => strtoupper($dat['lembaga'])),
						'select' => 'count(*) as jml,id_lembaga'
					))->row();
					if ($c_lembaga->jml > 0) $id_lembaga = $c_lembaga->id_lembaga;
					else $id_lembaga = $this->general_model->save_data('ref_lembaga',array('lembaga_pendidikan' => strtoupper($dat['lembaga'])));
					
					/* ---- Jenjang ---- */
					$c_jenjang = $this->general_model->datagrab(array(
						'tabel' => 'ref_bentuk_pendidikan',
						'where' => array('singkatan_pendidikan' => strtoupper($dat['jenjang'])),
						'select' => 'count(*) as jml,id_bentuk_pendidikan'))->row();
					if ($c_jenjang->jml > 0) $id_jenjang = $c_jenjang->id_bentuk_pendidikan;
					else $id_jenjang = $this->general_model->save_data('ref_bentuk_pendidikan',array('singkatan_pendidikan' => $dat['jenjang']));
					
					/* ---- Jurusan ---- */
					$c_jurusan = $this->general_model->datagrab(array(
						'tabel' => 'ref_jurusan',
						'where' => array('UPPER(jurusan)' => strtoupper($dat['jurusan'])),
						'select' => 'count(*) as jml,id_jurusan'
					))->row();
					if ($c_jurusan->jml > 0) $id_jurusan = $c_jurusan->id_jurusan;
					else $id_jurusan = $this->general_model->save_data('ref_jurusan',array('jurusan' => strtoupper($dat['jurusan'])));
					
					$where_pendidikan = array(
						'id_pegawai' => $id_peg,
						'id_bentuk_pendidikan' => $id_jenjang,
						'id_lembaga' => $id_lembaga,
						'id_jurusan' => $id_jurusan,
						'tahun_selesai' => $dat['lulus']);
					$cek_pendidikan = $this->general_model->datagrab(array('tabel' => 'peg_formal','where' => $where_pendidikan));
		
					if ($cek_pendidikan->num_rows() == 0) {
					
					$this->general_model->save_data('peg_formal',array('status' => 0),'id_pegawai',$id_peg);
					
					$simpan_pendidikan = array(
						'id_pegawai' => $id_peg,
						'id_bentuk_pendidikan' => $id_jenjang,
						'id_lembaga' => $id_lembaga,
						'id_jurusan' => $id_jurusan,
						'tahun_selesai' => $dat['lulus'],
						'status' => '1'
					); $this->general_model->save_data('peg_formal',$simpan_pendidikan);
					
					
					}
					
					}
					
					}
				}
			}
		}
		
		unlink(FCPATH.'uploads/pegawai.csv');

		if (!empty($error)) $this->session->set_flashdata('fail',$error);
		else $this->session->set_flashdata('ok','Impor <b>'.$total.' pegawai</b> berhasil disimpan');
		
		redirect('inti/pengaturan/impor');
	}
	
	
	function reset_pengaturan() {
		
		$param = array(
			'aplikasi',
			'aplikasi_code',
			'aplikasi_s',
			'aplikasi_logo_ext',
			'aplikasi_logo',
			'pemerintah',
			'pemerintah_s',
			'pemerintah_logo','pemerintah_logo_bw',
			'pemerintah_logo_ext',
			'ibukota',
			'instansi',
			'instansi_s',
			'instansi_code',
			'copyright',
			'multi_unit',
			'main_color');
			
		for($i = 0; $i < count($param); $i++) {
			$this->general_model->delete_data('parameter','param',$param[$i]);
		}
		
		/*-- Init Aplikasi --*/
		
		$appdata = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('aktif' => 1)));

		$app_active = array();
		foreach($appdata->result() as $res) {
			$path = './application/controllers/'.$res->folder;
			if(file_exists($path)) $app_active[] = $res->id_aplikasi;
		}
		
		$par = $this->general_model->get_param($param,1);	

		for($i = 0; $i < count($param); $i++) {
			if (!in_array($param[$i],$par)) {
			$conf = @$this->config->config[$param[$i]];
				if (!empty($conf)) {
					$simpan = array(
						'param' => $param[$i],
						'val' => $conf
					); $this->general_model->save_data('parameter',$simpan);

				}
			}
		}	

		$active = $this->general_model->get_param('app_active');
		
		if (empty($active)) $this->general_model->save_data('parameter',array('param' => 'app_active','val' => implode(',',$app_active)));
		else $this->general_model->save_data('parameter',array('val' => implode(',',$app_active)),'param','app_active');
		
		// Inisialisasi Logo
		
		$this->load->helper('directory');
		$map = directory_map('./logo/', 1);
		
		foreach($map as $o) {
			if (preg_match("/\./i", $o)) unlink('./logo/'.$o);
		}
		
		$this->session->set_flashdata('ok','Reset Pengaturan berhasil dilakukan');
		redirect('inti/pengaturan/parameter');
		
	}
	
	function balik_tanggal($t) {
		
		if (!empty($t)) {
			$t = explode(' - ',$t);
			return $t[2].'-'.$t[1].'-'.$t[0];
		}
		
		
	} 
	
	function excel_importing() {
		
		$res = $this->input->post('on_reset');

		if (empty($_FILES['excel_impor']['tmp_name'])) {
			$error = 'Pilih dokumen Excel yang akan diupload';
		} else {
			$this->load->library('upload');
			$this->upload->initialize(array(
				'upload_path' => './uploads/',
				'allowed_types' => '*'));
			if (! $this->upload->do_upload('excel_impor')) {
				$error = $this->upload->display_errors();
			} else {
				$data_up = $this->upload->data();
				$this->load->library('excel_reader');
		 $this->excel_reader->setOutputEncoding('CP1251');
		 $this->excel_reader->read('./uploads/'.$data_up['file_name']);
		 error_reporting(E_ALL ^ E_NOTICE);
		 
		 $brs = $this->input->post('baris');
		 
		 $data = $this->excel_reader->sheets[0];
		 $this->general_model->dataempty(array('temp_pegawai'));
		 if (!empty($res)) {
				$tab_delete = array(
					'peg_anak',
					'peg_beasiswa',
					'peg_cuti',
					'peg_diklatpim',
					'peg_dokumen',
					'peg_formal',
					'peg_hukdis',
					'peg_ijintugas_belajar',
					'peg_informal',
					'peg_inpassing',
					'peg_jabatan',
					'peg_kartu',
					'peg_karyatulis',
					'peg_keluarga',
					'peg_kesejahteraan',
					'peg_kgb',
					'peg_nilai',
					'peg_organisasi',
					'peg_pangkat',
					'peg_penghargaan',
					'peg_pensiun',
					'per_perkawinan',
					'peg_sertifikasi',
					'peg_tes',
					'peg_tugas',
					'peg_tunjangan',
					'peg_upi',
					'peg_pegawai',
					'ref_lokasi',
					'ref_agama',
					'ref_jurusan',
					'ref_lembaga',
					'ref_lokasi',
					'ref_unit',
					'ref_bidang',
					'ref_jabatan');
				
				$this->general_model->dataempty($tab_delete); }
		 
		 $total = 0;
		 $this->general_model->dataempty(array('temp_pegawai'));
		 for ($i = (!empty($brs)?$brs:1); $i <= $data['numRows']; $i++) {
			 	
			 	 $jft = $data['cells'][$i][$this->input->post('k_jft')];
				 $tmt_jft = $data['cells'][$i][$this->input->post('k_tmt_jft')];
				 $struktural = $data['cells'][$i][$this->input->post('k_s')];
				 $tmt_s = $data['cells'][$i][$this->input->post('k_tmt_s')];
				 
				 $tmt_p = $data['cells'][$i][$this->input->post('k_tmt_pns')];
				 $tmt_cp = $data['cells'][$i][$this->input->post('k_tmt_cpns')];
				 
				 if (!empty($jft)) {
					$jns = 2;
					$jab = $jft;
					$tmt_jab = $this->balik_tanggal((!empty($tmt_jft)?$tmt_jft:(!empty($tmt_p)?$tmt_p:$tmt_cp))); 
				 } else if (!empty($struktural)) {
					$jns = 1;
					$jab = $struktural;
					$tmt_jab = $this->balik_tanggal((!empty($tmt_s)?$tmt_s:(!empty($tmt_p)?$tmt_p:$tmt_cp))); 
				 } else {
					$jns = 3;
					$jab = $data['cells'][$i][$this->input->post('k_jfu')];
					$tmt_jab = $this->balik_tanggal((!empty($tmt_p)?$tmt_p:$tmt_cp));
				 } 	
				 	
				$si = array(
					'nip' => $data['cells'][$i][$this->input->post('k_nip')],
					'nip_lama' => $data['cells'][$i][$this->input->post('k_nip_lama')],
					'nama' => $data['cells'][$i][$this->input->post('k_nama')],
					'gelar_depan' => $data['cells'][$i][$this->input->post('k_gelar_depan')],
					'gelar_belakang' => $data['cells'][$i][$this->input->post('k_gelar_belakang')],
					'tempat_lahir' => $data['cells'][$i][$this->input->post('k_tempat_lahir')],
					'tanggal_lahir' => $this->balik_tanggal($data['cells'][$i][$this->input->post('k_tanggal_lahir')]),
					'jenis_kelamin' => $data['cells'][$i][$this->input->post('k_jenis_kelamin')],
					'mkg_bulan' => $data['cells'][$i][$this->input->post('k_mkg_bulan')],
					'mkg_tahun' => $data['cells'][$i][$this->input->post('k_mkg_tahun')],	
					'tmt_cpns' => $this->balik_tanggal($tmt_cp),
					'tmt_pns' => $this->balik_tanggal($tmt_p),
					'jabatan' => $jab,
					'tmt_jabatan' => $tmt_jab,
					'eselon' => $data['cells'][$i][$this->input->post('k_eselon')],
					'jenis_jabatan' => $jns,
					'golru' => $data['cells'][$i][$this->input->post('k_golru')],
					'tmt_golru' => $this->balik_tanggal($data['cells'][$i][$this->input->post('k_tmt_golru')]),
					'bidang' => $data['cells'][$i][$this->input->post('k_bidang')],
					'unit' => $data['cells'][$i][$this->input->post('k_unit')]); 

					$nik = $this->input->post('k_nik');
					$npwp = $this->input->post('k_npwp');
					$alamat = $this->input->post('k_alamat');
					$agama = $this->input->post('k_agama');
					if (!empty($nik)) $si['no_nik'] = $data['cells'][$i][$nik];
					if (!empty($npwp)) $si['no_npwp'] = $data['cells'][$i][$npwp];
					if (!empty($alamat)) $si['alamat'] = $data['cells'][$i][$alamat];
					if (!empty($agama)) $si['agama'] = $data['cells'][$i][$agama];
					
					$this->general_model->save_data('temp_pegawai',$si); 	
					$total += 1;
				
			}
		}
		
		unlink(FCPATH.'uploads/'.$data_up['file_name']);
		}

		if (!empty($error)) $this->session->set_flashdata('fail',$error);
		else $this->session->set_flashdata('ok','Impor <b>'.$total.' pegawai</b> berhasil disimpan di tabel temporer');
		
		redirect('inti/pengaturan/impor_excel_next');
	
	}
	
	function impor_excel_next() {
		
		$sm = $this->general_model->datagrab(array('tabel' => 'temp_pegawai','limit' => 5, 'offset' => 0));
		
		$data['overflow'] = 1;
		
		$this->table->set_template(array('table_open'=>'<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
		$this->table->set_heading(
			array('data'=>'No','style'=>'width:20px;text-align:center'),
			'NIP',
			'NIP Lama',
			'Nama',
			'Gelar Depan',
			'Gelar Belakang',
			'Tempat Lahir',
			'Tanggal Lahir',
			'Jenis Kelamin',
			'MKG Tahun',
			'MKG Bulan',
			'TMT CPNS',
			'TMT PNS',
			'Jabatan',
			'TMT Jabatan',
			'Eselon',
			'Jenis Jabatan',
			'Golru/Pangkat',
			'TMT Golru/Pangkat',
			'Unit Organisasi',
			'Unit Kerja',
			'Alamat',
			'NIK',
			'NPWP',
			'Agama',
			'Jenjang',
			'Jurusan');
		$no = 1;
		foreach($sm->result() as $s) {
			
			$this->table->add_row(
				$no,
				$s->nip,
				$s->nip_lama,
				$s->nama,
				$s->gelar_depan,
				$s->gelar_belakang,
				$s->tempat_lahir,
				tanggal($s->tanggal_lahir),
				$s->jenis_kelamin,
				$s->mkg_bulan,
				$s->mkg_tahun,
				tanggal($s->tmt_cpns),
				tanggal($s->tmt_pns),
				$s->jabatan,
				tanggal($s->tmt_jabatan),
				$s->eselon,
				$s->jenis_jabatan,
				$s->golru,
				tanggal($s->tmt_golru),
				$s->bidang,
				$s->unit,
				$s->alamat,
				$s->no_nik,
				$s->no_npwp,
				$s->agama,
				$s->jenjang,
				$s->jurusan
			);
			$no += 1;
		}
	
		$data['title'] = 'Sampel Impor dari Excel';
		$data['script'] = "
			function menunggu() {
				$.ajax({
					url: 'jumlah',
					cache: false,
					success: function(msg) {
						$('.btn-save').attr('disabled','disabled').val('Proses Impor ... ('+msg+')').show();
					},error:function(error){
						show_error(error);
					}
				});
			}
			setInterval('menunggu()',2000);";
			
		$data['tabel'] = $this->table->generate();
		$data['box_footer'] = 
			anchor('inti/pengaturan/push_data','<i class="fa fa-btn fa-save"></i> Teruskan','class="btn btn-primary btn-save"').' '.
			anchor('inti/pengaturan/kembali','<i class="fa fa-refresh fa-btn"></i> Batalkan!','class="btn btn-danger"');
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function jumlah() {
		
		$jml =$this->general_model->datagrab(array(
			'tabel' => 'peg_pegawai',
			'select' => 'count(id_pegawai) as jml'
		))->row();
		
		die($jml->jml);
		
	}
	
	function total_temp() {
		
		$jml = $this->general_model->datagrab(array(
				'tabel' => 'temp_pegawai',
			'select' => 'count(id_temp) as jml'
		))->row();
		die($jml->jml);
	}
	
	function kembali() {
		
		$this->general_model->dataempty(array('temp_pegawai'));
		$this->session->set_flashdata('ok','Impor Excel berhasil dibatalkan ...');
		redirect('inti/pengaturan/impor');
		
	}
	
	function push_data() {
		
		$t = $this->session->flashdata('t');
		
		$total = (!empty($t)?$t:0);
		$sm = $this->general_model->datagrab(array('tabel' => 'temp_pegawai','limit' => 1000, 'offset' => $total+=1));
		
		foreach($sm->result() as $dat) {
			if (!empty($dat->nip) and !empty($dat->nama)) {		
					$c_nip = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => array('nip' => $dat->nip),'select' => 'count(nip) as jml,id_pegawai'))->row();
					
						
						// -- Tempat Lahir -- 
						if (!empty($dat->tempat_lahir)) {
							$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $dat->tempat_lahir),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
							if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $dat->tempat_lahir));
							else $id_tmpt = $c_tempat->id_lokasi;
						}
						
						if (!empty($dat->agama)) {
							/* -- Agama -- */
							$c_agama = $this->general_model->datagrab(array('tabel' => 'ref_agama','where' => array('agama' => $dat->agama),'select' => 'count(id_agama) as jml,id_agama'))->row();
							if (empty($c_agama->jml)) $id_agama = $this->general_model->save_data('ref_agama', array('agama' => $dat->agama));	
							else $id_agama = $c_agama->id_agama;
						}
						
						$nip_simpan = !empty($dat->nip) ? $dat->nip : $dat->nip_lama;
						
						$gnd = !empty($dat->jenis_kelamin) ? ($dat->jenis_kelamin == "L"?"1":"2") : null;
						
						$s_peg = array(
							'username' => $nip_simpan,
							'password' => md5($nip_simpan),//md5('qwerty'),
							'id_tipe_pegawai' => 1,
							'nip_lama' => $dat->nip_lama,
							'nip' => $dat->nip,
							'nama' => $dat->nama,
							'gelar_depan' => !empty($dat->gelar_depan)?$dat->gelar_depan:null,
							'gelar_belakang' => !empty($dat->gelar_belakang)?$dat->gelar_belakang:null,
							'id_jeniskelamin' => $gnd,
							'id_tempat_lahir' => !empty($id_tmpt)?$id_tmpt:0,
							'id_agama' => !empty($id_agama)?$id_agama:0,
							'tanggal_lahir' => !empty($dat->tanggal_lahir) ? $dat->tanggal_lahir : null,
							'mkg_bulan' => !empty($dat->mkg_bulan)?$dat->mkg_bulan:null,
							'mkg_tahun' => !empty($dat->mkg_tahun)?$dat->mkg_tahun:null,
							'no_nik' => !empty($dat->nik)?$dat->nik:null,
							'no_npwp' => !empty($dat->npwp)?$dat->npwp:null,
							'alamat' => !empty($dat->alamat)?$dat->alamat:null
						); 
						
						if (!empty($dat->tmp_cpns)) $s_peg['cpns_tmt'] = $dat->tmt_cpns;
					if (empty($c_nip->jml)) {
						$id_peg = $this->general_model->save_data('peg_pegawai',$s_peg);
					} else {
						$this->general_model->save_data('peg_pegawai',$s_peg,id_pegawai,$c_nip->id_pegawai);
						$id_peg = $c_nip->id_pegawai;
					}
					
					// Unit
					
					$c_unit = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('unit' => $dat->unit),'select' => 'count(id_unit) as jml,id_unit'))->row();
					if (empty($c_unit->jml)) {
						$id_unit = $this->general_model->save_data('ref_unit', array('unit' => $dat->unit,'level_unit' => '1'));
					} else {
						$id_unit = $c_unit->id_unit;
					}
					
					// Bidang
					
					$c_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('nama_bidang' => $dat->bidang,'id_unit' => $id_unit),'select' => 'count(id_bidang) as jml,id_bidang'))->row();
					
					$ur_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $id_unit),'select' => 'MAX(urut) as urutan'))->row();
					
					if (empty($c_bid->jml)) {
						$s_bid = array(
							'id_unit' => $id_unit,
							'nama_bidang' => $dat->bidang,
							'level' => 1,
							'urut' => $ur_bid->urutan+1	
						);
						$id_bidang = $this->general_model->save_data('ref_bidang',$s_bid);
					} else {
						$id_bidang = $c_bid->id_bidang;
					}
					
					// Jabatan
					
								
					$ess_data = array(
							'' => '9',
							'11' => '0',	
							'12' => '1',
							'21' => '2',
							'22' => '3',
							'31' => '4',
							'32' => '5',
							'41' => '6',
							'42' => '7',
							'51' => '8'
						);
						
					$ess = !empty($ess_data[$dat->eselon])?$ess_data[strtoupper($dat->eselon)]:9;
					
					$c_jab = $this->general_model->datagrab(array(
						'tabel' => 'ref_jabatan',
						'where' => array('nama_jabatan' => $dat->jabatan),
						'select' => 'count(id_jabatan) as jml,id_jabatan'))->row();
					if (empty($c_jab->jml)) {
						/*$ess_data = array(
							'' => '9',
							'I.A' => '0',	
							'I.B' => '1',
							'II.A' => '2',
							'II.B' => '3',
							'III.A' => '4',
							'III.B' => '5',
							'IV.A' => '6',
							'IV.B' => '7',
							'V.A' => '8'
						);
						*/
						$s_jab = array(
							'id_eselon' => $ess,
							'id_jab_jenis' => $dat->jenis_jabatan,
							'nama_jabatan' => $dat->jabatan,
							'stat_jab' => 1,
							'bup' => !empty($dat->bup)?$dat->bup:58	
						);
						$id_jab = $this->general_model->save_data('ref_jabatan',$s_jab);
					} else {
						$id_jab = $c_jab->id_jabatan;
					}
					
					}
					
					
					if (!empty($id_jab)) {
					
					/* -- Simpan Jabatan -- */
				
					$where_jab = array(
						'id_pegawai' => $id_peg,
						'id_jabatan' => $id_jab,
						'id_unit' => $id_unit,
						'id_bidang' => $id_bidang,
						'tmt_jabatan' => $dat->tmt_jabatan);
					$cek_jab = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where' => $where_jab));
				
					if ($cek_jab->num_rows() == 0) {
					
					$this->general_model->save_data('peg_jabatan',array('status' => 0),'id_pegawai',$id_peg);
					
					$simpan_jabatan = array(
						'id_pegawai' => $id_peg,
						'id_jabatan' => $id_jab,
						'id_unit' => $id_unit,
						'id_bidang' => $id_bidang,
						'tmt_jabatan' => $dat->tmt_jabatan,
						'id_status_pegawai' => '2',
						'status' => '1'
					); $this->general_model->save_data('peg_jabatan',$simpan_jabatan);
					
					}
					}
				
					
					/* -- Simpan Golru -- */
					
					$gol_data = array(
							'I/a' => 1,	
							'I/b' => 3,
							'I/c' => 3,
							'I/d' => 4,	
							'II/a' => 5,
							'II/b' => 6,
							'II/c' => 7,	
							'II/d' => 8,
							'III/a' => 9,
							'III/b' => 10,	
							'III/c' => 11,
							'III/d' => 12,
							'IV/a' => 13,
							'IV/b' => 14,
							'IV/c' => 15,
							'IV/d' => 16,
							'IV/e' => 17);
					
					$id_golru = !empty($gol_data[$dat->golru])?$gol_data[$dat->golru]:null;
					if(!empty($id_golru)) {
					$where_golru = array(
						'id_pegawai' => $id_peg,
						'id_golru_jenis' => '1',
						'id_golru' => $id_golru,
						'tmt_pangkat' => $dat->tmt_golru);
					$cek_golru = $this->general_model->datagrab(array('tabel' => 'peg_pangkat','where' => $where_golru));
		
					if ($cek_golru->num_rows() == 0) {
					
					$this->general_model->save_data('peg_pangkat',array('status' => 0),'id_pegawai',$id_peg);
					
					$simpan_golru = array(
						'id_pegawai' => $id_peg,
						'id_golru_jenis' => '1',
						'id_golru' => $id_golru,
						'tmt_pangkat' => $dat->tmt_golru,
						'status' => '1'
					); $this->general_model->save_data('peg_pangkat',$simpan_golru);
					
					}
					}
					
					/* -- Pendidikan -- */
					
					if (!empty($dat->jenjang) and !empty($dat->jurusan)) {
					
					/* ---- Lembaga ---- */
					if (!empty($dat->lembaga)) {
					$c_lembaga = $this->general_model->datagrab(array(
						'tabel' => 'ref_lembaga',
						'where' => array('UPPER(lembaga_pendidikan)' => strtoupper($dat->lembaga)),
						'select' => 'count(*) as jml,id_lembaga'
					))->row();
					if ($c_lembaga->jml > 0) $id_lembaga = $c_lembaga->id_lembaga;
					else $id_lembaga = $this->general_model->save_data('ref_lembaga',array('lembaga_pendidikan' => strtoupper($dat->lembaga)));
					}
					
					/* ---- Jenjang ---- */
					$c_jenjang = $this->general_model->datagrab(array(
						'tabel' => 'ref_bentuk_pendidikan',
						'where' => array('singkatan_pendidikan' => strtoupper($dat->jenjang)),
						'select' => 'count(*) as jml,id_bentuk_pendidikan'))->row();
					if ($c_jenjang->jml > 0) $id_jenjang = $c_jenjang->id_bentuk_pendidikan;
					else $id_jenjang = $this->general_model->save_data('ref_bentuk_pendidikan',array('singkatan_pendidikan' => $dat->jenjang));
					
					/* ---- Jurusan ---- */
					$c_jurusan = $this->general_model->datagrab(array(
						'tabel' => 'ref_jurusan',
						'where' => array('UPPER(jurusan)' => strtoupper($dat->jurusan)),
						'select' => 'count(*) as jml,id_jurusan'
					))->row();
					if ($c_jurusan->jml > 0) $id_jurusan = $c_jurusan->id_jurusan;
					else $id_jurusan = $this->general_model->save_data('ref_jurusan',array('jurusan' => strtoupper($dat->jurusan)));
					
					$where_pendidikan = array(
						'id_pegawai' => $id_peg,
						'id_bentuk_pendidikan' => $id_jenjang,
						'id_jurusan' => $id_jurusan);
					$cek_pendidikan = $this->general_model->datagrab(array('tabel' => 'peg_formal','where' => $where_pendidikan));
		
					if ($cek_pendidikan->num_rows() == 0) {
					
					$this->general_model->save_data('peg_formal',array('status' => 0),'id_pegawai',$id_peg);
					
					$s_formal = array(
						'id_pegawai' => $id_peg,
						'id_bentuk_pendidikan' => $id_jenjang,
						'id_jurusan' => $id_jurusan,
						'status' => '1'
					); 
					
					if(!empty($dat->lulus)) $s_formal['tahun_selesai'] = $dat->lulus;
					if(!empty($dat->lembaga)) $s_formal['id_lembaga'] = $id_lembaga;
					
					
					$this->general_model->save_data('peg_formal',$s_formal);
					}
					}
					$total += 1;
				}
			
		if ($sm->num_rows() > 0) {
			$this->session->set_flashdata('t',$total);
			redirect('inti/pengaturan/push_data');
		} else {
			redirect('inti/pengaturan/impor');
			$this->session->set_flashdata('ok','Data '.$total.' Pegawai berhasil disimpan ...');	
			
		}
	}

}