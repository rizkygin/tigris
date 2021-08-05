<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Unitkerja extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
	}
	
	public function index() {
			
		$this->show_unit();
			
	}
	
	function in_app($e) {
		
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $e)
		))->row()->nama_aplikasi;
		
	}
	
	function tabel_unit($level,$o = null) {
		
		
		$s = $this->general_model->get_param('multi_unit');
		$p = !empty($o) ? un_de($o) : array('ubah' => null,'link' => null);
		
		$where = ($level == 1) ? array("(id_par_unit = '' or id_par_unit IS NULL)" => null) : array('id_par_unit' => $p['id_par']);
	
		if (isset($p['link'])) $where['aktif'] = 1;
		
		$root_bid = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => $where,'order' => 'urut,unit'));
			
		if ($root_bid->num_rows() > 0) {
			if ($level == 1) {
				
            $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
            $this->table->set_empty("&nbsp;");	
            
			$head = array();
			if (!empty($p['ubah'])) $head[] = array('data' => '<input type="checkbox" name="cek_all" id="cek_all" class="cek-all"','class'=>'center','style'=>'width:30px');
            $head[] = array('data' => 'Nama / Kode Unit','colspan' => '7');
			
			if (!empty($p['ubah'])) $head = array_merge_recursive($head,array(array('data' => 'Aksi','colspan' => 3,'align' => 'center')));
			
			$this->table->set_heading($head);
			}
			
				$urutkan = array();
				$awal = array();
				$r = 0;
			
				foreach ($root_bid->result() as $row) {
					$awal[] = array($row->id_unit,$row->urut);
				}
			
				foreach ($root_bid->result() as $row) {
					$jml_bidang = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where'=> array('id_unit' => $row->id_unit),'select' => 'count(*) as jml'))->row();
					$jml_bidang = (($jml_bidang->jml != NULL and $jml_bidang->jml > 0)?$jml_bidang->jml:0);
					
					$jml_jabatan = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where'=> array('id_unit' => $row->id_unit),'select' => 'count(*) as jml'))->row();
					$jml_jabatan = (($jml_jabatan->jml != NULL and $jml_jabatan->jml > 0)?$jml_jabatan->jml:0);
					$link1 = '<a href="#" class="btn btn-xs btn-warning btn-edit" act="'.site_url($p['dir'].'/unit/add_unit/'.in_de(array('dir' => $p['dir'],'id' => $row->id_unit))).'"><i class="fa fa-pencil"></i></a>';
					
					$sub_bid = $this->general_model->datagrab(array('tabel' => 'ref_unit', 'where' => array('id_par_unit' => $row->id_unit)));
					if ($sub_bid->num_rows() == 0)  {
						$link2 = '<a href="#" class="btn btn-xs btn-danger btn-delete" act="'.site_url($p['dir'].'/unit/removing/'.in_de(array('id' => $row->id_unit,'dir' => $p['dir']))).'" msg="Apakah unit <b>'.$row->kode_unit.' '.$row->unit.'</b> akan dihapus?"><i class="fa fa-trash"></i></a>';
					}
					
					$btn_down = ($r+1 < $root_bid->num_rows()) ? anchor($p['dir'].'/unit/urutkan/'.in_de(array('dir' => $p['dir'],'id1' => $row->id_unit,'no1' => $row->urut,'id2' => $awal[$r+1][0],'no2' =>  $awal[$r+1][1])),'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info"') : '';
					$btn_up = ($r > 0) ? anchor($p['dir'].'/unit/urutkan/'.in_de(array('dir' => $p['dir'],'id2' => $row->id_unit,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info"') : '';
					$urutkan = array($row->id_unit,$row->urut);

					$kode = !empty($row->kode_unit)?' <b>('.$row->kode_unit.')</b>':null;
					$unit = !empty($row->unit)?' '.$row->unit:null;
					$btn_tambah_sub = null;
					
					if (!empty($p['ubah'])) {
						
					$btn_tambah_sub = '<div class="btn-group">
						<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right">
						<li class="text-right"><a>
							<span class="text-danger">'.$jml_bidang.'</span> referensi dipakai Bidang<br>
							<span class="text-danger">'.$jml_jabatan.'</span> referensi dipakai Jabatan</a></li>
						<li class="divider"></li>
						<li><a href="#" act="'.site_url($p['dir'].'/unit/add_unit/'.in_de(array('dir' => $p['dir'],'id_par' => $row->id_unit))).'" class="btn-edit"><i class="fa fa-plus-square fa-btn"></i> Sub Unit Kerja</a></li>
						<li><a href="#" act="'.site_url($p['dir'].'/unit/pindah_unit/'.in_de(array('id' => $row->id_unit))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindahkan ke Unit Organisasi</a></li>
						<li><a href="#" act="'.site_url($p['dir'].'/unit/pindah_kosong/'.in_de(array('id' => $row->id_unit))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindah Kosongkan</a></li></ul>
						</div>';

					}
					$target = !empty($p['target']) ? 'target="'.$p['target'].'"' : null;
					
					$sel = !empty($p['link']) ? anchor($p['link'].in_de(array('link' => $p['link'],'id' => $row->id_unit)),($unit != NULL?$unit.$kode:'[Tidak Ada Nama Unit Kerja]'),'class="link-normal btn-go" id="'.$row->id_unit.'" title="'.$unit.'" '.$target) : $unit.$kode;
				
					$rowsd = array();
					if (!empty($p['ubah'])) {
						$rowsd[] =  array('data' => '<input type="checkbox" name="cek[]" class="cek" value="'.$row->id_unit.'">','style' => 'text-align: center');
					}
					for ($j=0;$j < $level; $j++) {
						if ($j>0) $rowsd[] = array('data'=>'','width' => '20');
					}
					
					$rowsd[] = array('data'=> $sel.'&nbsp; &nbsp; '.$btn_tambah_sub,'colspan'=> 7-$level,'class' => ($row->aktif == 1 or $row->aktif == null)?null:'nonaktif');
					if (!empty($p['ubah'])) {
						$rowsd[] = array('style' => 'width: 30px; text-align: center;','data' => $link1);
						$rowsd[] = (!empty($link2)) ? array('style' => 'width: 30px; text-align: center;','data' =>$link2) : ' ';
						$rowsd[] = $btn_down.$btn_up;
					}
					$this->table->add_row($rowsd);
					if ($sub_bid->num_rows() > 0) {
						
						$p['id_par'] = $row->id_unit;
						
						$this->tabel_unit($level+1,in_de($p));
					}
					$r+=1;
				}
				
		} else {
			if ($level == 1) {
				$this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
				$this->table->set_empty("&nbsp;");	
				$this->table->add_row('Belum ada Unit Kerja ...');
			}
		
		}
		
	}
	
	function show_unit($e = null) {
		
		$s = $this->general_model->get_param('multi_unit');

		$data['breadcrumb'] = array('' => $this->in_app($e), $e.'/unit' => 'Unit Kerja/SKPD');
		
		$data['title']		= 'Referensi Unit Kerja';
		$data['content']	= 'umum/standard_view';
		
		$this->tabel_unit(1,in_de(array('ubah' => 1,'dir' => $e)));
		$data['tabel'] = 
			
			form_open($e.'/unit/removing','id="form_delete"').
			anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-bottom: 10px"').
			$this->table->generate().
				'<script type="text/javascript">
					$(document).ready(function() {
						
						$(".nonaktif").parent().children("td").css({"background" : "#ededed","color": "#bbb"});
						
					});
				</script>'.
			anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-top: -10px"').
			form_close();

			
		$data['tombol'] = ($s == 1) ? anchor('#','<i class="fa fa-plus"></i> &nbsp; Unit Kerja','class="btn btn-edit btn-success" act="'.site_url($e.'/unit/add_unit/'.in_de(array('dir' => $e))).'"') : null;
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function list_unit($e) {
		$this->tabel_unit(1,$e);
		return $this->table->generate();
	}
	
	function add_unit($param = null) {
		
		$combo_kepala = $this->general_model->combo_box(array(
			'tabel' => array(
				'peg_pegawai p' => '',
				'peg_jabatan j' => 'j.id_pegawai = p.id_pegawai AND j.status = 1',
				'ref_jabatan jab' => 'jab.id_jabatan = j.id_jabatan'),
			'key' => 'id_peg_jabatan',
			'select' => 'j.id_peg_jabatan,CONCAT(p.nama,"<br> NIP.",p.nip) as nama_pegawai',
			'val' => array('nama_pegawai')
		));
		
		$o = ($param !=NULL) ? un_de($param) : null;
		$data['title'] = (!empty($o['id'])) ? "Ubah Unit" : "Tambah Unit";
		$data['form_link'] = 'inti/unitkerja/saving';
		$def = (!empty($o['id'])) ? $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_unit' => $o['id'])))->row():null;

		$whr_unit = !empty($def)?array('id_unit <>' => $def->id_unit):null;
		$cb_unit = $this->general_model->combo_box(array(
			'tabel' => 'ref_unit',
			'key'=>'id_unit',
			'where' => $whr_unit,
			'val' => array('unit'),
			'pilih' => ' -- Tidak ada Unit di atasnya -- '));
		
		if (isset($o['id_par'])) {
			
			$par = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_unit' => $o['id_par'])))->row();

			$form_inti = 
				form_hidden('id_par_unit',$o['id_par']).
				'<p style="margin: 0 0 10px 0; padding: 0 0 5px 0; border-bottom: 1px dotted #ccc">'.
					form_label('Unit di Atasnya').form_textarea('ur',$par->unit,'readonly="readonly" class="form-control" style="height: 60px"').
				'</p>';
		} else {
			if (isset($def->id_unit)) {
				$form_inti = form_hidden('id_unit',$def->id_unit).
				'<p>'.
					form_label('Unit di Atasnya').
					form_hidden('id_par_unit_ori',@$def->id_par_unit).
					form_dropdown('id_par_unit',$cb_unit,@$def->id_par_unit,'class="form-control combo-box" style="width: 100%"').'</p>';
			} else {
				$form_inti = null;
			}
		}
		
		$data['form_data'] = 
			form_hidden('dir',$o['dir']).
			$form_inti.
			'<p>'.form_label('Kode Unit').form_input('kode_unit',@$def->kode_unit,'class="form-control"').'</p>'.
			'<p>'.form_label('Nama Unit').form_textarea('unit',@$def->unit,'class="form-control" style="height: 60px"').'</p>'.
			'<p>'.form_label('Alamat').form_textarea('alamat',@$def->alamat,'class="form-control" style="height: 60px"').'</p>'.
			'<p>'.form_label('Telp').form_input('telp',@$def->alamat,'class="form-control"').'</p>'.
			'<p>'.form_label('Kepala').form_dropdown('id_kepala',$combo_kepala,@$def->id_kepala,'class="combo-box form-control" style="width: 100%"').'</p>'.
			'<p>'.form_label('Aktif').form_dropdown('aktif',array('1' => 'Aktif','2'=> 'Non Aktif'),@$def->aktif,'class="combo-box form-control" style="width: 100%"').'</p>';
		$this->load->view('umum/form_view', $data);
	
	}
	
	function pindah_kosong($dir,$p) {
		
		$o = un_de($p);
		
		$data['title'] = "Migrasi Kosong";
		$data['form_link'] = 'inti/unitkerja/pindah/kosong';
		
		$def = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_unit' => $o['id'])))->row();	
		$combo_unit = $this->general_model->combo_box(array('tabel' => 'ref_unit','key' => 'id_unit','val' => array('unit')));
		
		$data['form_data'] = 
			form_hidden('dir',$dir).
			form_hidden('id_unit',$def->id_unit).
			'<p>'.form_label('Unit Organisasi Asal').form_input('nama',$def->unit,'class="form-control" disabled="disabled"').'</p>'.
			'<p>'.form_label('Pindahkan ke Unit Kerja').form_dropdown('unit',$combo_unit,null,'class="form-control" style="width: 100%" required').'</p>';
		
		$this->load->view('umum/form_view', $data);
	
	}
	
	
	function pindah_unit($dir,$p) {
		
		$o = un_de($p);
		
		$data['title'] = "Pindah Unker ke Unor";
		$data['form_link'] = 'inti/unitkerja/pindah/unker';
		
		$def = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_unit' => $o['id'])))->row();	
		$combo_unit = $this->general_model->combo_box(array('tabel' => 'ref_unit','key' => 'id_unit','val' => array('unit')));
		
		$data['form_data'] = 
			form_hidden('dir',$dir).
			form_hidden('id_unit',$def->id_unit).
			'<p>'.form_label('Nama pindah Unit Organisasi').form_input('nama',$def->unit,'class="form-control"').'</p>'.
			'<p>'.form_label('Pindahkan ke Unit Kerja').form_dropdown('unit',$combo_unit,null,'class="form-control" style="width: 100%" required').'</p>';
		
		$this->load->view('umum/form_view', $data);
	
	}
	
	function pindah($a) {
		
		$id = $this->input->post('id_unit');
		$un = $this->input->post('unit');	
		$dir = $this->input->post('dir');
		
		switch ($a) {
			case "unker":
			
				$max = $this->general_model->datagrab(array(
					'tabel' => 'ref_bidang','select'=> 'MAX(urut) urut',
					'where' => array('id_unit' => $un)))->row();
				
				$urut = (isset($max->urut) and $max->urut != NULL)?$max->urut+1:1;
				
				$simpan = array(
					'id_unit' => $un,
					'urut' => $urut,
					'nama_bidang' => $this->input->post('nama')
				); $id_bidang = $this->general_model->save_data('ref_bidang',$simpan);
				
				$dat_jab = $this->general_model->datagrab(array(
					'tabel' => array(
						'ref_jabatan j' => '',
						'ref_bidang b' => 'b.id_bidang = j.id_bidang'),
					'where' => array('b.id_unit' => $id)));
					
				foreach($dat_jab->result() as $d) {
					
					$this->general_model->save_data('ref_jabatan',array('id_bidang' => $id_bidang),'id_jabatan',$d->id_jabatan);
					$this->general_model->save_data('peg_jabatan',array('id_bidang' => $id_bidang,'id_unit' => $un),'id_jabatan',$d->id_jabatan);
					
				}
				
				$this->general_model->delete_data('ref_bidang','id_unit',$id);
				$this->general_model->delete_data('ref_unit','id_unit',$id);
				
				$this->session->set_flashdata('balik',1);
				$this->session->set_flashdata('ok','Unit Kerja berhasil diubah ke Unit Organisasi');
				redirect($dir.'/bidang/tabel_bidang/'.in_de(array('id' => $un)));
			
			break;
			
			case "kosong":
			
				// Unit Kerja Anak
				
				$this->general_model->save_data('ref_unit',array('id_par_unit' => $un),
					'id_par_unit',$id);
					
				$this->general_model->save_data('ref_bidang',array('id_unit' => $un),'id_unit',$id);
				$this->general_model->save_data('peg_jabatan',array('id_unit' => $un),'id_unit',$id);
				
				$this->session->set_flashdata('balik',1);
				$this->session->set_flashdata('ok','Isi dari Unit Kerja berhasil dipindahkan ...');
				redirect($dir.'/unit');
				
			break;
			
		}	
		
	}
	
	function saving() {
		
		$id = $this->input->post('id_unit');
		$par = $this->input->post('id_par_unit');
		$par_ori = $this->input->post('id_par_unit_ori');
		
		$simpan = array(
			'kode_unit' => $this->input->post('kode_unit'),
			'unit' => $this->input->post('unit'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $this->input->post('telp'),
			'id_kepala' => $this->input->post('id_kepala'),
			'aktif' => $this->input->post('aktif'),
			'id_par_unit' => $par
		);
		
		if ($id == NULL or ($par != null and $par_ori != null and $par != $par_ori)) {
		
			$maxx = $this->general_model->datagrab(array(
				'tabel' => 'ref_unit','where' => ($par != NULL?array('id_par_unit' => $par):null),'select' => 'MAX(urut)+1 as urut'))->row();
			$simpan['urut'] = ($maxx->urut != null)  ? $maxx->urut : 1;
			
		}
		
		$save = $this->general_model->save_data('ref_unit',$simpan,'id_unit',$id);
		
		if ($id == NULL) {
			
			$this->general_model->save_data('ref_bidang',array(
				'id_unit' => $save,
				'nama_bidang' => $this->input->post('unit'),
				'aktif' => $this->input->post('aktif')
			));
			
		}
		
		$this->session->set_flashdata('ok', 'Data berhasil disimpan');
		redirect($this->input->post('dir').'/unit');
		
	}
	
	
	function removing($par){
	
		$o = un_de($par);
		
		$bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $o['id'])));
		foreach($bid->result() as $b) { $this->general_model->delete_data('ref_jabatan','id_bidang',$b->id_bidang); }
		
		$this->general_model->delete_data('peg_jabatan','id_unit',$o['id']);
		$this->general_model->delete_data('ref_bidang','id_unit',$o['id']);
		$this->general_model->delete_data('ref_unit','id_unit',$o['id']);
		
		$this->session->set_flashdata('ok', 'Unit berhasil dihapus');
		redirect($o['dir'].'/unit');
		
	}
	
	function urutkan($par) {
		$o = un_de($par);
		
		$this->general_model->save_data('ref_unit',array('urut' => $o['no2']),'id_unit',$o['id1']);
		$this->general_model->save_data('ref_unit',array('urut' => $o['no1']),'id_unit',$o['id2']);
		$this->session->set_flashdata('ok','Urutan berhasil disimpan');
		redirect($o['dir'].'/unit');
	}
	
}