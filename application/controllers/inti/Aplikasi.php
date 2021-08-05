<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Aplikasi extends CI_Controller {
	
	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));

	}

	public function index() {
		
		$this->load_list();
		
	}

	function get_app() {
		
		$app_active = $this->general_model->get_param('app_active');
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi',
			'where' => array('id_aplikasi IN ('.$app_active.') AND aktif = 1' => null)));

	}
	
	// -- Pengaturan Aplikasi -- 
	
	function trade($a1,$a2,$b1,$b2) {
		
		$this->general_model->save_data('ref_aplikasi',array('urut' => $b2),'id_aplikasi',$a1);
		$this->general_model->save_data('ref_aplikasi',array('urut' => $a2),'id_aplikasi',$b1);
		
		$this->session->set_flashdata('ok','Urutan berhasil disimpan ...');
		redirect('inti/aplikasi');
		
	}
	
	/* -- Init Aplikasi -- */
	
	function checking() {
		
		$this->load->helper('directory');
		$map = directory_map('./application/controllers/', 1);
		
		$fold = array();
		foreach($map as $o) {
			if (!preg_match("/\./i", $o)) $fold[] = $o;
		}
		
		$in = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi'
		));
		$app_in = array(); 
		
		foreach($in->result() as $a) {
			$app_in[] = $a->folder;
		}
		
		$l_app = array();
		foreach($fold as $fo) {
			if (!in_array($fo,$app_in) and file_exists('./application/controllers/'.$fo.'/db.php')) {
				
				$l_app[] = $fo;
			}
		}

		if (count($l_app) > 0) {
			return $l_app;
		}
		
	}
	
	function setup($o) {
		
		$p = un_de($o);
		
		if (count($p) > 0) {
			$data['app'] = $p;
			$this->load->view('umum/setup_view',$data);
		} else redirect('home');
		
	}
	
	function load_setup($a) {
		
		$a = load_controller($a,'db','init');
		
		$path_ava = './assets/logo/'.$a['folder'].'.png';
		$ava = (file_exists($path_ava)) ? base_url().'assets/logo/'.$a['folder'].'.png' : base_url().'assets/logo/referensi.png';
		
		die(json_encode(array(
			'ava' => '<div class="app-icon" style="background: '.$a['warna'].'"><img src="'.$ava.'"/></div>',
			'link_pasang' => site_url($a['folder'].'/db/set_db/home'),
			'deskripsi' => $a['deskripsi'],
			'judul' => $a['judul'],
			'warna' => $a['warna'],
		)));
		
	}
	
	function load_list() {

		$o = $this->checking();
		// cek($o);
		$data['tabel'] = null;		
		$tbl = null;
		if (!empty($o)) {
			$tbl = '<table class="table table-striped table-bordered table-condensed table-nonfluid">';
			$tbl.= '<tr>
				<th style="width:20px;text-align:center">No</th>
				<th width="40"></th>
				<th>Nama/Kode Aplikasi</th>
				<th>Deskripsi</th>
				<th></th>
				</tr>';
			$no = 1;
			foreach($o as $new_app) {
				$tbl.='<tr id="'.$new_app.'" class="load_list">
					<td class="text-center">'.$no.'</td>
					<td class="logo text-center"><i class="fa fa-spin fa-spinner"></i></td>
					<td class="judul"><i class="fa fa-spin fa-spinner fa-btn"></i> Memuat ...</td>
					<td class="deskripsi"><i class="fa fa-spin fa-spinner fa-btn"></i> Memuat ...</td>
					<td class="link-pasang"><a href="" class="btn btn-sm btn-danger"><i class="fa fa-database fa-btn"></i> Pasang!</a></td>
				</tr>';				
				$no +=1;
			}
			$tbl.= '</table>';
			$data['tabel'].= '<h4>Aplikasi Baru</h4>'.$tbl.'<br><br>';
		}
		
		

		$s = $this->session->userdata('login_state');
		if ($s == 'root') {
	
			$data['breadcrumb'] = array('' => 'Root', 'pengaturan/aplikasi' => 'Aplikasi');
				
			$offset = !empty($offset) ? $offset : null;
			
			$query = $this->general_model->datagrab(array('tabel'=>'ref_aplikasi','order' => 'urut','where' => array("id_par_aplikasi IS NULL OR id_par_aplikasi=0" => null)));

			// cek($query);
	
			$this->table->set_template(array('table_open'=>'<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
			$this->table->set_heading(
				array('data'=>'No','style'=>'width:20px;text-align:center'),
				'',
				'',
				array('data' => 'Nama/Kode Aplikasi','colspan' => 2),
				'Deskripsi',
				array('data' => 'Aksi','colspan' => 2));

			$j = 1;
			$sel = array();
			foreach($query->result() as $row){
				if ($j > 1) $sel[] = array('id' => $row->id_aplikasi,'urut' => $row->urut);
 				$j+=1;
			}
		
			$no = 1;
			$aft = null;
			foreach($query->result() as $row) {
				$this->general_model->save_data('ref_aplikasi',array('urut' => $no),'id_aplikasi',$row->id_aplikasi);
				$ext = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('id_par_aplikasi' => $row->id_aplikasi)));
				
				$path_ava = './assets/logo/'.$row->folder.'.png';
				$ava = (file_exists($path_ava)) ? base_url().'assets/logo/'.$row->folder.'.png' : base_url().'assets/logo/referensi.png';
				
				$trn = ($no < $query->num_rows() and $query->num_rows() > 1) ? anchor('inti/aplikasi/trade/'.$row->id_aplikasi.'/'.$row->urut.'/'.$sel[$no-1]['id'].'/'.$sel[$no-1]['urut'],'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info"') : null;
				$naik = ($no > 1 and $query->num_rows() > 1)  ? anchor('inti/aplikasi/trade/'.$row->id_aplikasi.'/'.$row->urut.'/'.$aft['id'].'/'.$aft['urut'],'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info"') : null;
				
				
				$rows = array(
					array('data'=>$no,'class'=>'text-center'),
					array('data' => '<input type="checkbox" name="cek[]" class="cek" value="'.$row->id_aplikasi.'">','style' => 'text-align: center'),
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
						<li>'.anchor('#','<i class="fa fa-pencil"></i> Ubah Redaksional','class="btn-edit" act="'.site_url('inti/aplikasi/form_data/'.in_de(array('id' => $row->id_aplikasi,'status' => 'root'))).'"').'</li>
						<li>'.anchor('#','<i class="fa fa-trash"></i> Lepas &amp; Hapus Modul','class="btn-delete" act="'.site_url('inti/aplikasi/delete_aplikasi/'.$row->id_aplikasi).'" msg="Apakah Anda ingin menghapus data <b>'.$row->kode_aplikasi.'</b>?"').'</li>'.$s.'
						</ul>
						</div>';
					$rows[] = ($row->aktif == 1) ? anchor('inti/aplikasi/saklar/off/'.$row->id_aplikasi,'<span class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i></span>') : anchor('inti/aplikasi/saklar/on/'.$row->id_aplikasi, '<span class="btn btn-default btn-xs"><i class="fa fa-circle-o"></i></span>');
					$rows[] = $trn.' '.$naik;
					$this->table->add_row($rows);
					
					foreach($ext->result() as $e) {
						
						$path_ava_e = './assets/logo/'.$e->folder.'.png';
						$ava_e = (file_exists($path_ava_e)) ? base_url().'assets/logo/'.$e->folder.'.png' : base_url().'assets/logo/referensi.png';
						
						$rowsd = array('',
						array('data' => '<input type="checkbox" name="cek[]" class="cek" value="'.$e->id_aplikasi.'">','style' => 'text-align: center'),
						'','<div class="app-icon" style="background: '.$row->warna.'"><img src="'.$ava.'" style="width: 26px;"/></div>',					
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
						<li>'.anchor('#','<i class="fa fa-pencil"></i> Ubah Redaksional','class="btn-edit" act="'.site_url('inti/aplikasi/form_data/'.in_de(array('id' => $e->id_aplikasi,'status' => 'root'))).'"').'</li>
						<li>'.anchor('#','<i class="fa fa-trash"></i> Lepas &amp; Hapus Modul','class="btn-delete" act="'.site_url('inti/aplikasi/delete_aplikasi/'.$e->id_aplikasi).'" msg="Apakah Anda ingin menghapus data <b>'.$e->kode_aplikasi.'</b>?"').'</li>'.$ss.'
						</ul>
						</div>';
						
						$rowsd[] = ($e->aktif == 1) ?  anchor('inti/aplikasi/saklar/off/'.$e->id_aplikasi,'<span class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i></span>') :  anchor('inti/aplikasi/saklar/on/'.$e->id_aplikasi,'<span class="btn btn-default btn-xs"><i class="fa fa-circle-o"></i></span>');
						
					
						$this->table->add_row($rowsd);
					}
					$aft = array('id' => $row->id_aplikasi,'urut' => $row->urut);
					$no++;
				}
			
			
			$data['tabel'].= form_open('inti/aplikasi/delete_aplikasi','id="form_delete"').
						anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-bottom: 10px"').
						$this->table->generate().
						anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-top: -10px"').
						form_close();
			
			
			//$data['tombol'] = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Modul Aplikasi','class="btn-edit btn btn-success" act="'.site_url('referensi/aplikasi/form_data/'.in_de(array('status' => 'root'))).'"');
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
		redirect('inti/aplikasi');
	}
	
	function form_data($par) {
			
			$o = un_de($par);
			$data['multi'] = 1;
			
			$data['title']	= empty($o['id']) ? 'Tambah Aplikasi' : 'Ubah Aplikasi';
			
			$data['form_link'] = 'inti/aplikasi/save_data';
			$def = !empty($o['id']) ? $this->general_model->datagrab(array('tabel'=>'ref_aplikasi','where'=>array('id_aplikasi'=>$o['id'])))->row(): null;
			
			$warna = !empty($o['id']) ? $def->warna : '#ccc';
			$logos = !empty($o['id']) ? $def->folder : 'logo';
			$data['form_data'] =
				form_hidden('status',$o['status']).
				form_hidden('id_aplikasi',@$def->id_aplikasi).
				'<p>'.form_label('Kode Aplikasi').form_input('kode_aplikasi',@$def->kode_aplikasi,'class="form-control" required').'</p>'.
				'<p>'.form_label('Nama Aplikasi').form_input('nama_aplikasi',@$def->nama_aplikasi,'class="form-control" required').'</p>'.
				'<p>'.form_label('Deskripsi').form_textarea('deskripsi',@$def->deskripsi,'class="form-control" style="height: 75px" rows="3"').'</p>'.
				'<p>'.form_label('Warna').
				'<div class="input-group colorize" >
				    <input name="warna" type="text" class="form-control" value="'.@$def->warna.'" />
				    <span class="input-group-addon"><i></i></span>
				</div></p><p>'.
				form_label('Icon').'
				<div style="max-width: 135px">
				<div class="app-icon" style="background: '.$warna.'; padding: 10px; width: 140px; height: 140px; margin-bottom: 10px;">
					<img src="'.base_url().'assets/logo/'.$logos.'.png" style="max-width: 110px;" /> 
				</div>
			</div>'.form_upload('icon_image').'</p>';

				
				
			if ($o['status'] == "root") {
				
				$data['form_data'].= 
					'<p>'.form_label('Folder Sistem').form_input('folder',@$def->folder,'class="form-control" required').'</p>'.
					'<p class="clear"></p>';
			}
			
			$this->load->view('umum/aplikasi_form_view',$data);
		}
		
		function save_data(){
		
			$status = $this->input->post('status');
			$id = $this->input->post('id_aplikasi');
			$kode_aplikasi = $this->input->post('kode_aplikasi');
			$folder = $this->input->post('folder');
			
			$check = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('kode_aplikasi' => $kode_aplikasi)));

			if (empty($id) and $check->num_rows > 0) {
				
				$this->session->set_flashdata('fail','Referensi Kode aplikasi telah tersedia!');

			} else {
			
			$simpan = array(
				'kode_aplikasi' => $kode_aplikasi,
				'nama_aplikasi' => $this->input->post('nama_aplikasi'),
				'deskripsi' => $this->input->post('deskripsi'),
				'warna' => $this->input->post('warna')
			);
			
			if ($status == 'root') $simpan['folder'] = $folder;
			if (empty($id)) $simpan['aktif'] = 1;
			
			if (!empty($_FILES['icon_image']['tmp_name'])) {
			
				$path_app_logo = FCPATH.'assets/logo/'.$folder.'.png';
				if (file_exists($path_app_logo)) unlink($path_app_logo);
			
				$this->load->library('upload');
				$this->upload->initialize(array(
					'file_name' => $folder.'.png',
					'upload_path' => './assets/logo/',
					'allowed_types' => '*'));
				if (! $this->upload->do_upload('icon_image')) {
					$error = $this->upload->display_errors();
				} else {
					$data_up = $this->upload->data();
				}
			}
			
			$this->general_model->save_data('ref_aplikasi',$simpan,'id_aplikasi',$id);
			if (!empty($error)) $this->session->set_flashdata('fail',$error);
			else $this->session->set_flashdata('ok','Data berhasil disimpan');
			
			}

			redirect('inti/aplikasi');
		}
	
	function delete_aplikasi($id = null){
	
		if (!empty($id)) {

			$this->delete_proses($id);
		
		} else {
			
			$cek = $this->input->post('cek');
			foreach($cek as $id) {
				$this->delete_proses($id);
			}
			
		}
		$this->session->set_flashdata('ok','Aplikasi berhasil dihapus');
		
		redirect('inti/aplikasi');
		
	}
	
	function delete_proses($id) {
		
		$role = $this->general_model->datagrab(array(
			'tabel' => 'ref_role',
			'where' => array('id_aplikasi' => $id)
		));

		$e = array();
		foreach($role->result() as $r) { $e[] = $r->id_role; }
		if (count($e) > 0) {
			$this->general_model->delete_data(array(
				'tabel' => 'pegawai_role',
				'where' => array('id_role IN ('.implode(',',$e).')' => null)));
			$this->general_model->delete_data(array(
				'tabel' => 'ref_role_nav',
				'where' => array('id_role IN ('.implode(',',$e).')' => null)));
		}

		$this->general_model->delete_data('nav','id_aplikasi',$id);
		$this->general_model->delete_data('ref_role','id_aplikasi',$id);
		$this->general_model->delete_data('ref_aplikasi','id_aplikasi',$id);
		
	}

}