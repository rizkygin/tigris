<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Unit extends CI_Controller {

	var $app = null;
	var $dir = 'tigris';

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
		$this->in_app = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
	
	}
	
	public function index() {
			
		$this->show_unit();
			
	}
	
	function tabel_sub($p,$level_unit,$id) {

		$from = array('ref_unit b' => '','peg_jabatan j' => array('j.id_peg_jabatan = b.id_kepala','left'),'peg_pegawai p' => array('p.id_pegawai = j.id_pegawai','left'));
		
		$sub_bid = $this->general_model->datagrab(array('tabel' => $from, 'where' => array('id_par_unit' => $id),'select' => 'b.*,p.nama'));
		
		$no_urut = 1;
		foreach ($sub_bid->result() as $row) {
			$this->general_model->save_data('ref_unit',array('urut' => $no_urut),'id_unit',$row->id_unit);
			$no_urut+=1;
		}
		
		if ($sub_bid->num_rows() > 0) {
			foreach($sub_bid->result() as $row) {
			
				$cell = array();
				if (!empty($p['ubah'])) {
						$cell[] =  array('data' => '<input type="checkbox" name="cek[]" class="cek" value="'.$row->id_unit.'">','style' => 'text-align: center');
				}
				for ($j=0;$j < $level_unit+1; $j++) {
					if ($j>0) $cell[] = array('data'=>'','width' => '20');
				}
				
				$link1 = '<a href="#" class="btn btn-xs btn-warning btn-edit" act="'.site_url($this->dir.'/Unit/add_unit/'.in_de(array('level_unit' => $row->level_unit,'id' => $row->id_unit))).'"><i class="fa fa-pencil"></i></a>';
				
				$sub_bidd = $this->general_model->datagrab(array('tabel' => 'ref_unit', 'where' => array('id_par_unit' => $row->id_unit)));
				if ($sub_bidd->num_rows() == 0)  {
					$link2 = '<a href="#" class="btn btn-xs btn-danger btn-delete" act="'.site_url($this->dir.'/Unit/removing/'.in_de(array('id' => $row->id_unit))).'" msg="Apakah unit <b>'.$row->kode_unit.' '.$row->unit.'</b> akan dihapus?"><i class="fa fa-trash"></i></a>';
				}
			
				$kode = !empty($row->kode_unit)?' (<b>'.$row->kode_unit.'</b>)':null;
				$nama = !empty($row->unit)?' '.$row->unit:null;
				$btn_tambah_sub = null;
				if (!empty($p['ubah'])) {
					$btn_tambah_sub = '<div class="btn-group">
						<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right">
						<li><a href="#" act="'.site_url($this->dir.'/Unit/add_sub_unit/'.$row->level_unit.'/'.$row->id_unit).'" class="btn-edit"><i class="fa fa-plus-square fa-btn"></i> Sub Unit Kerja (Kantor Pusat / Kantor Cabang)</a></li>
						<li><a href="#" act="'.site_url($this->dir.'/Unit/pindah_unit'.in_de(array('id' => $row->id_unit))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindahkan ke Bidang</a></li></ul>
						</div>';
				}
				$target = !empty($p['target']) ? 'target="'.$p['target'].'"' : null;
				$sel = !empty($p['link']) ? anchor($p['link'].in_de(array('link' => $p['link'],'id' => $row->id_unit)),$kode.$nama,'class="link-normal btn-go" id="'.$row->id_unit.'" title="'.$nama.'" '.$target) : $kode.$nama;
				$cls_text = ($row->aktif == 2) ? '<span class="text-muted"><i>'.$sel.'</i></span>' : $sel;
				$cell[] = array('data'=>  $cls_text.' &nbsp; &nbsp; &nbsp; '.$btn_tambah_sub, 'colspan' => 7-$level_unit);

				if (!empty($btn_tambah_sub)) {
					$cell[] = array('style' => 'width: 30px; text-align: center;','data' => $link1);
					if (!empty($link2)) $cell[] = array('style' => 'width: 30px; text-align: center;','data' => $link2); 
					$cell[] = '';
				}
			
				$this->table->add_row($cell);
				if ($sub_bidd->num_rows() > 0) $this->tabel_sub($p,$level_unit+1,$row->id_unit);
				
			}
		}
		
	}
	
	function tabel_unit($o = null) {
		$s = $this->general_model->get_param('multi_unit');
		$p = !empty($o) ? un_de($o) : array('ubah' => null,'link' => null);
		
		$root_bid = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array("id_par_unit = '' or id_par_unit IS NULL" => null),'order' => 'unit'));
		
		$no_urut = 1;
		foreach ($root_bid->result() as $row) {
			$this->general_model->save_data('ref_unit',array('urut' => $no_urut),'id_unit',$row->id_unit);
			$no_urut+=1;
		}
		
		if ($root_bid->num_rows() > 0) {
            $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
            $this->table->set_empty("&nbsp;");	
            
			$head = array();
			if (!empty($p['ubah'])) $head[] = array('data' => '<input type="checkbox" name="cek_all" id="cek_all" class="cek-all"','class'=>'center','style'=>'width:30px');
            $head[] = array('data' => 'Nama / Kode Unit','colspan' => '7');
			
			if (!empty($p['ubah'])) $head = array_merge_recursive($head,array(array('data' => 'Aksi','colspan' => 2,'align' => 'center')));
			
			$this->table->set_heading($head);
			
				foreach ($root_bid->result() as $row) {
					
					$link1 = '<a href="#" class="btn btn-xs btn-warning btn-edit" act="'.site_url($this->dir.'/Unit/add_unit/'.in_de(array('level_unit' => $row->level_unit,'id' => $row->id_unit))).'"><i class="fa fa-pencil"></i></a>';
					
					$sub_bid = $this->general_model->datagrab(array('tabel' => 'ref_unit', 'where' => array('id_par_unit' => $row->id_unit)));
					if ($sub_bid->num_rows() == 0)  {
						$link2 = '<a href="#" class="btn btn-xs btn-danger btn-delete" act="'.site_url($this->dir.'/Unit/removing/'.in_de(array('id' => $row->id_unit))).'" msg="Apakah unit <b>'.$row->kode_unit.' '.$row->unit.'</b> akan dihapus?"><i class="fa fa-trash"></i></a>';
					}

					$kode = !empty($row->kode_unit)?' <b>('.$row->kode_unit.')</b>':null;
					$unit = !empty($row->unit)?' '.$row->unit:null;
					$btn_tambah_sub = null;
					if (!empty($p['ubah'])) {
						
					$btn_tambah_sub = '<div class="btn-group">
						<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right">
						<li><a href="#" act="'.site_url($this->dir.'/Unit/add_sub_unit/'.$row->level_unit.'/'.$row->id_unit).'" class="btn-edit"><i class="fa fa-plus-square fa-btn"></i> Sub Unit Kerja (Kantor Pusat / Kantor Cabang)</a></li>
						<li><a href="#" act="'.site_url($this->dir.'/Unit/pindah_unit/'.in_de(array('id' => $row->id_unit))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindahkan ke Bidang</a></li></ul>
						</div>';

					}
					$target = !empty($p['target']) ? 'target="'.$p['target'].'"' : null;
					
					$sel = !empty($p['link']) ? anchor($p['link'].in_de(array('link' => $p['link'],'id' => $row->id_unit)),$unit.$kode,'class="link-normal btn-go" id="'.$row->id_unit.'" title="'.$unit.'" '.$target) : $unit.$kode;
				
					$rowsd = array();
					if (!empty($p['ubah'])) {
						$rowsd[] =  array('data' => '<input type="checkbox" name="cek[]" class="cek" value="'.$row->id_unit.'">','style' => 'text-align: center');
					}
					$cls_text = ($row->aktif == 2) ? '<span class="text-muted"><i>'.$sel.'</i></span>' : $sel;
					$rowsd[] = array('data'=> $cls_text.'&nbsp; &nbsp; &nbsp; '.$btn_tambah_sub,'colspan'=> 7);
					if (!empty($p['ubah'])) {
						$rowsd[] = array('style' => 'width: 30px; text-align: center;','data' => $link1);
						if (!empty($link2)) $rowsd[] = array('style' => 'width: 30px; text-align: center;','data' =>$link2);
					}
					$this->table->add_row($rowsd);
					if ($sub_bid->num_rows() > 0) $this->tabel_sub($p,1,$row->id_unit);
				}
				return $this->table->generate();
			
		} else {
		
		return  '<div class="alert"">Belum ada Unit Kerja terdaftar</div>';
		
		}
		
		
	}
	
	function show_unit() {
		
		$s = $this->general_model->get_param('multi_unit');

		$data['breadcrumb'] = array('' => $this->in_app, $this->dir.'/Unit' => 'Unit Kerja/SKPD');
		
		$data['title']		= 'Referensi Fakultas';
		$data['content']	= 'umum/standard_view';
		
		$data['tabel'] = 
			form_open($this->dir.'/Unit/delete_unit','id="form_delete"').
			anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-bottom: 10px"').
			$this->tabel_unit(in_de(array('ubah' => 1))).
			anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-top: -10px"').
			form_close();

			
		$data['tombol'] = 
		// ($s == 1) ? 
		anchor('#','<i class="fa fa-plus"></i> &nbsp; Fakultas','class="btn btn-edit btn-success" act="'.site_url($this->dir.'/Unit/add_unit/'.in_de(array('level_unit' => '1'))).'"')
		 // : null
		 ;
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function add_unit($param) {
		
		$from = array(
			'peg_pegawai p' => '',
			'peg_jabatan j' => 'j.id_pegawai = p.id_pegawai'
		);
		$combo_kepala = $this->general_model->combo_box(array(
			'tabel' => $from,
			'key' => 'id_peg_jabatan',
			'val' => array('nama_pegawai'),
			'select' => 'j.id_peg_jabatan,CONCAT(p.nama,"<br> NIP.",p.nip) as nama_pegawai',
			'value' => array('nama_pegawai')
		));
		
		$o = un_de($param);
		$data['title'] = (!empty($o['id'])) ? "Ubah Unit" : "Tambah Unit";
		$data['form_link'] = $this->dir.'/Unit/saving';
		$def = (!empty($o['id'])) ? $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_unit' => $o['id'])))->row():null;

		$whr_unit = !empty($def)?array('id_unit <>' => $def->id_unit):null;
		$cb_unit = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit',
			'key'=>'id_unit',
			'where' => $whr_unit,
			'val' => array('unit'),
			'pilih' => ' -- Tidak ada Unit di atasnya -- '));
		
		$data['form_data'] = 
			form_hidden('id_unit',@$def->id_unit).
			form_hidden('level_unit',$o['level_unit']).
			'<p>'.form_label('Unit di Atasnya').form_dropdown('id_par_unit',$cb_unit,@$def->id_par_unit,'class="form-control" style="width: 100%"').'</p>'.
			'<p>'.form_label('Kode Unit').form_input('kode_unit',@$def->kode_unit,'class="form-control"').'</p>'.
			'<p>'.form_label('Nama Unit').form_textarea('unit',@$def->unit,'class="form-control" style="height: 60px"').'</p>'.
			'<p>'.form_label('Alamat').form_textarea('alamat',@$def->alamat,'class="form-control" style="height: 60px"').'</p>'.
			'<p>'.form_label('Telp').form_input('telp',@$def->alamat,'class="form-control"').'</p>'.
			'<p>'.form_label('Kepala').form_dropdown('id_kepala',$combo_kepala,@$def->id_kepala,'class="combo-box form-control" style="width: 100%"').'</p>'.
			'<p>'.form_label('Aktif').form_dropdown('aktif',array('1' => 'Aktif','2'=> 'Non Aktif'),@$def->aktif,'class="combo-box form-control" style="width: 100%"').'</p>';
		$this->load->view('umum/form_view', $data);
	
	}
	
	function pindah_unit($p) {
		
		$o = un_de($p);
		
		$data['title'] = "Pindah Unker ke Unor";
		$data['form_link'] = $this->dir.'/Unit/pindah/unker';
		
		$def = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_unit' => $o['id'])))->row();	
		$combo_unit = $this->general_model->combo_box(array('tabel' => 'ref_unit','key' => 'id_unit','val' => array('unit')));
		
		$data['form_data'] = 
			form_hidden('id_unit',$def->id_unit).
			'<p>'.form_label('Nama pindah Unit Organisasi').form_input('nama',$def->unit,'class="form-control"').'</p>'.
			'<p>'.form_label('Pindahkan ke Unit Kerja').form_dropdown('unit',$combo_unit,null,'class="form-control" style="width: 100%" required').'</p>';
		
		$this->load->view('umum/form_view', $data);
	
	}
	
	function pindah($a) {
		
		if ($a == "unker") {
			
			$id = $this->input->post('id_unit');
			$un = $this->input->post('unit');
			
			$simpan = array(
				'id_unit' => $un,
				'nama_bidang' => $this->input->post('nama')
			); $this->general_model->save_data('ref_bidang',$simpan);
			
			$this->general_model->delete_data('ref_unit','id_unit',$id);
			$this->session->set_flashdata('balik',1);
			$this->session->set_flashdata('ok','Unit Kerja berhasil diubah ke Unit Organisasi');
			
			redirect($this->dir.'/bidang/tabel_bidang/'.in_de(array('id' => $un)));
			
		}
	}
	
	function add_sub_unit($level_unit,$id_par){
	
		$data['title'] = "Tambah Unit Bawahan";
		$data['form_link'] = $this->dir.'/Unit/saving_sub';

		$par = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_unit' => $id_par)))->row();

		$from = array(
			'peg_pegawai p' => '',
			'peg_jabatan j' => 'j.id_pegawai = p.id_pegawai'
		);
		
		$combo_kepala = $this->general_model->combo_box(array(
			'tabel' => $from,
			'key' => 'id_peg_jabatan',
			'select' => 'j.id_peg_jabatan,CONCAT(p.nama,"<br>NIP.",p.nip) as nama_pegawai',
			'val' => array('nama_pegawai'),
			'value' => array('nama_pegawai')
		));
		$kode_unit = !empty($par->kode_unit)?' ('.$par->kode_unit.')':null;
		$data['form_data'] = 
			form_hidden('id_par_unit',$id_par).
			form_hidden('level_unit',($level_unit+1)).
			'<p style="margin: 0 0 10px 0; padding: 0 0 5px 0; border-bottom: 1px dotted #ccc">'.
				form_label('Unit di Atasnya').form_textarea('ur',$par->unit.$kode_unit,'readonly class="form-control" style="height: 60px"').
			'</p>'.
			'<p>'.form_label('Kode Unit').form_input('kode_unit',null,'class="form-control"').'</p>'.
			'<p>'.form_label('Nama Unit').form_textarea('unit',null,'class="form-control" style="height: 60px"').'</p>'.
			'<p>'.form_label('Alamat').form_textarea('alamat',null,'class="form-control" style="height: 60px"').'</p>'.
			'<p>'.form_label('Telp').form_input('telp',null,'class="form-control"').'</p>'.
			'<p>'.form_label('Kepala Unit').form_dropdown('id_kepala',$combo_kepala,null,'class="combo-box form-control" style="width: 100%"').'</p>';
			
		$this->load->view('umum/form_view', $data);
		
	}
	
	function saving() {
		
		$id = $this->input->post('id_unit');
		$par = $this->input->post('id_par_unit');
		
		$simpan = array(
			'kode_unit' => $this->input->post('kode_unit'),
			'unit' => $this->input->post('unit'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $this->input->post('telp'),
			'level_unit' => $this->input->post('level_unit'),
			'id_kepala' => $this->input->post('id_kepala'),
			'aktif' => $this->input->post('aktif')
		);
		
		if (!empty($par)) $simpan['id_par_unit'] = $par;
		
		$this->general_model->save_data('ref_unit',$simpan,'id_unit',$id);
		$this->session->set_flashdata('ok', 'Data berhasil disimpan');
		redirect($this->dir.'/Unit');
		
	}
	
	function saving_sub(){
		
		$simpan = array(
			'id_par_unit' => $this->input->post('id_par_unit'),
			'kode_unit' => $this->input->post('kode_unit'),
			'unit' => $this->input->post('unit'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $this->input->post('telp'),
			'level_unit' => $this->input->post('level_unit'),
			'id_kepala' => $this->input->post('id_kepala')
		);
		$this->general_model->save_data('ref_unit',$simpan);
		$this->session->set_flashdata('ok', 'Data berhasil disimpan');
		redirect($this->dir.'/Unit');

	}
	
	function removing($par){
	
		$o = un_de($par);
		$this->general_model->delete_data('ref_unit','id_unit',$o['id']);
		$this->session->set_flashdata('ok', 'unit berhasil dihapus');
		redirect($this->dir.'/Unit/show_unit');
		
	}
	
	function delete_unit(){
	
		$cek = $this->input->post('cek');	
	
		foreach($cek as $c) {
			$this->general_model->delete_data('ref_unit','id_unit',$c);
		}
		$this->session->set_flashdata('ok', 'Unit Kerja berhasil dihapus');
		redirect($this->dir.'/Unit');
		
	}
	
}