<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Unitorganisasi extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		
	}
	
	function sub_unit($sub,$n) {
		foreach($sub->result() as $row) {
			$cell = array();
			for($i = 0; $i < 4-$n; $i++) {
				$cell[] = array('data' => '&nbsp &nbsp ');
			}
			
			$cell[] = array('data' => anchor($this->dir.'/bidang/tabel_bidang/'.$row->id_unit,$row->kode_unit.' '.$row->unit,'class="link-normal"'),'colspan' => $n);
			
			$add_sub = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_par_unit' => $row->id_unit)));
			$this->table->add_row($cell);
			if ($add_sub->num_rows() > 0) $this->sub_unit($add_sub,$n-1); 
			
		}		
	}
	
	
	function tabel_sub($level_bidang,$o) {
		
		$from = array('ref_bidang b' => '','ref_unit u' => 'u.id_unit = b.id_unit');
		$where = ($level_bidang > 1?array('b.id_par_bidang' => $o['id']):array('(b.id_par_bidang IS NULL or b.id_par_bidang = 0) AND u.id_unit = '.$o['id'] => null));
		$sub_bid = $this->general_model->datagrab(array(
			'tabel' => $from,
			'where' => $where,
			'order' => 'b.urut,b.nama_bidang',
			'select' => 'b.*'
		));
		
		$urutkan_sub = array();
		$awal_sub = array();
		
		if ($sub_bid->num_rows() > 0) {
			foreach ($sub_bid->result() as $row) {
				$awal_sub[] = array($row->id_bidang,$row->urut);
			}

			$r = 0;
			$no = 1;
			
			foreach($sub_bid->result() as $row) {
				
				if ($row->urut == NULL) {
					
					$maxx = $this->general_model->datagrab(array(
						'tabel' => 'ref_bidang','where' => $where,'select' => 'MAX(urut)+1 as urut'))->row();
					$this->general_model->save_data('ref_bidang',array('urut' => $maxx->urut),'id_bidang',$row->id_bidang);
					
				}
			
				$jml_bidang = $this->general_model->datagrab(array('tabel' => 'ref_jabatan','where'=> array('id_bidang' => $row->id_bidang),'select' => 'count(*) as jml'))->row();
				$jml_bidang = (($jml_bidang->jml != NULL and $jml_bidang->jml > 0)?$jml_bidang->jml:0);
				
				$jml_jabatan = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where'=> array('id_bidang' => $row->id_bidang),'select' => 'count(*) as jml'))->row();
				$jml_jabatan = (($jml_jabatan->jml != NULL and $jml_jabatan->jml > 0)?$jml_jabatan->jml:0);
			
				$cell = array();
			
				for ($j=0;$j < $level_bidang; $j++) {
					if ($j>0) $cell[] = array('data'=>'','width' => '20');
				}
				
				$btn_down = ($r+1 < $sub_bid->num_rows()) ? anchor($o['dir'].'/bidang/urutkan/'.in_de(array('unit' => $row->id_unit,'id1' => $row->id_bidang,'no1' => $row->urut,'id2' => $awal_sub[$r+1][0],'no2' =>  $awal_sub[$r+1][1])),'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info"') : '';
				$btn_up = ($r > 0) ? anchor($o['dir'].'/bidang/urutkan/'.in_de(array('unit' => $row->id_unit,'id2' => $row->id_bidang,'no2' => $row->urut,'id1' =>  !empty($urutkan_sub[0])?$urutkan_sub[0]:@$awal_sub[0],'no1' => !empty($urutkan_sub[1])?$urutkan_sub[1]:@$awal_sub[1])),'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info"') : '';
				$urutkan_sub = array($row->id_bidang,$row->urut);
				$cell_aksi = array(array('class' => 'text-center no-wrap','width' => '80','data' => $btn_down.$btn_up));
				$cell_aksi[] = array('class' => 'text-center','data' => '<a href="#" class="btn-edit btn btn-xs btn-warning" act="'.site_url($o['dir'].'/bidang/add_bidang/'.in_de(array('id_par_bidang' => $row->id_par_bidang,'id' => $row->id_bidang,'id_unit' => $row->id_unit))).'"><i class="fa fa-pencil"></i></a>');
				
				$sub_bidd = $this->general_model->datagrab(array('tabel' => 'ref_bidang', 'where' => array('id_par_bidang' => $row->id_bidang)));
				$cell_aksi[] = $sub_bidd->num_rows() == 0 ?
					array('class' => 'text-center','data' => '<a href="#" class="btn-delete btn btn-xs btn-danger" act="'.site_url($o['dir'].'/bidang/removing/'.in_de(array('id' => $row->id_bidang,'unit' => $row->id_unit))).'" msg="Apakah Bidang <b>'.$row->kode_bidang.' '.$row->nama_bidang.'</b> akan dihapus?"><i class="fa fa-trash"></i></a>'):null;
					
			
				$add_sub = array('id_unit' => $row->id_unit,'id_par_bidang' => $row->id_bidang);
				$kode = !empty($row->kode_bidang)?'<b>'.$row->kode_bidang.'</b>':null;
				$nama = !empty($row->nama_bidang)?' '.$row->nama_bidang:null;
				
				$btn_tambah_sub = '<div class="btn-group">
					<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-cog"></i>
					</a>
					<ul class="dropdown-menu pull-right">
					<li class="text-right"><a>
							<span class="text-danger">'.$jml_bidang.'</span> referensi dipakai Bidang<br>
							<span class="text-danger">'.$jml_jabatan.'</span> referensi dipakai Jabatan</a></li>
						<li class="divider"></li>
					<li><a href="#" class="btn-edit" act="'.site_url($o['dir'].'/bidang/add_bidang/'.in_de($add_sub)).'"><i class="fa fa-plus-square-o"></i> Tambahkan Sub Unit Organisasi</a></li>
					<li><a href="#" act="'.site_url($o['dir'].'/bidang/pindah_bidang/'.in_de(array('id' => $row->id_bidang,'nama' => $row->nama_bidang))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindahkan ke Unit Kerja</a></li>
					<li><a href="#" act="'.site_url($o['dir'].'/bidang/pindah_kosong/'.in_de(array('id' => $row->id_unit,'id_bidang' => $row->id_bidang,'nama' => $row->nama_bidang))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindahkan Kosongkan</a></li></ul>
					</div>';
				
				$cell[] = array('data'=> $kode.$nama.' &nbsp; &nbsp; '.$btn_tambah_sub, 'colspan' => 8-$level_bidang, 'class' => ($row->aktif == 2)?'nonaktif':null);
				$cell = array_merge_recursive($cell,$cell_aksi);
			
				$this->table->add_row($cell);
				$no += 1;
				if ($sub_bidd->num_rows() > 0 and $level_bidang < 5) $this->tabel_sub($level_bidang+1,array('id' => $row->id_bidang,'dir' => $o['dir']));
				$r+=1;
			}
		}
		
	}
	
	function list_bidang($o) {
		
		$btn_bid_root = anchor('#','<i class="fa fa-plus-square"></i> &nbsp; Unit Organisasi','class="btn btn-xs btn-edit btn-success" act="'.site_url($o['dir'].'/bidang/add_bidang/'.in_de(array('level_bidang' => '1','id_unit' => $o['id']))).'"');
		
		$this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed table-nonfluid gap">'));
		$this->table->set_empty("&nbsp;");	
		$this->table->set_heading(
			array('data' => 'Nama/Kode Unit Organisasi &nbsp; '.$btn_bid_root,'colspan' => '7'),
			array('data' => 'Aksi','class' => 'text-center','colspan' => 4));
		
		$this->tabel_sub(1,$o);
		return $this->table->generate().'<script type="text/javascript">
					$(document).ready(function() {
						
						$(".nonaktif").parent().children("td").css({"background" : "#ededed","color": "#bbb"});
						
					});
				</script>';
	
	}
	
	function pindah_kosong($dir,$p) {
		
		$o = un_de($p);
		
		$data['title'] = "Pindah dan Kosongkan Unor ini";
		$data['form_link'] = 'init/unitorganisasi/kosong';
		
		$cb_bidang = $this->general_model->combo_box(array(
			'tabel' => 'ref_bidang',
			'where' => array('id_unit' => $o['id'],'id_bidang != ' => $o['id_bidang']),
			'key' => 'id_bidang',
			'val' => array('nama_bidang'),
			'order' => 'nama_bidang'
			));
		
		$data['form_data'] = 
			form_hidden('dir',$dir).
			form_hidden('id_unit',$o['id']).
			form_hidden('id_bidang_asal',$o['id_bidang']).
			'<p>'.form_label('Bidang Yang Dikosongkan').form_input('nama',$o['nama'],'class="form-control" disabled').'</p>'.
			'<p>'.form_label('Bidang Tujuan').form_dropdown('id_bidang',$cb_bidang,null,'class="form-control" style="width: 100%"').'</p>';
			
		$this->load->view('umum/form_view', $data);
	
	}
	
	function pindah_bidang($dir,$p) {
		
		$o = un_de($p);
		
		$data['title'] = "Pindah Unor ke Unker";
		$data['form_link'] = 'init/unitorganisasi/pindah';
		
		$data['form_data'] = 
			form_hidden('dir',$dir).
			form_hidden('id',$o['id']).
			'<p>'.form_label('Nama pindah Unit Kerja').form_input('nama',$o['nama'],'class="form-control"').'</p>';
			
		$this->load->view('umum/form_view', $data);
	
	}
	
	function pindah() {
		
		$id = $this->input->post('id');
		$un = $this->input->post('nama');
		
		$urut = $this->general_model->datagrab(array(
			'tabel' => 'ref_unit',
			'order' => 'urut',
			'select' => 'max(urut) as urut'
		))->row();
		
		$simpan = array(
			'unit' => $un,
			'urut' => $urut->urut+1
		); $this->general_model->save_data('ref_unit',$simpan);
		
		// Hilangkan parent
		$this->general_model->save_data('ref_bidang',array('id_par_bidang' => ''),'id_bidang',$id);
		
		$this->general_model->delete_data('ref_bidang','id_bidang',$id);
		$this->session->set_flashdata('ok','Unit Organisasi berhasil diubah ke Unit Kerja');
		
		redirect($this->input->post('dir').'/unit');
	}
	
	function kosong() {
		
		$id_bid_asal = $this->input->post('id_bidang_asal');
		$id = $this->input->post('id_bidang');
		
		$this->general_model->save_data('ref_jabatan',array('id_bidang' => $id),'id_bidang',$id_bid_asal);
		$this->general_model->save_data('peg_jabatan',array('id_bidang' => $id),'id_bidang',$id_bid_asal);
		
		$this->session->set_flashdata('ok','Isi Unit Organisasi berhasil dipindahkan');
		redirect($this->input->post('dir').'/bidang/tabel_bidang/'.in_de(array('id' => $this->input->post('id_unit'))));
		
	}
	
	function get_sub($idp,$id = null,$par = null) {

		$where = array('id_unit' => $idp);
		if (!empty($id)) $where['id_bidang != '.$id] = null;
		if (!empty($par)) $where['id_par_bidang'] = $par;
		else $where['id_par_bidang IS NULL'] = null;
		
		$p = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => $where,'order' => 'id_bidang'));
		$this->dump_unit[''] = ' -- Paling Atas --';
		if ($p->num_rows > 0) {
			foreach($p->result() as $pe):
			$this->dump_unit[$pe->id_bidang] = $pe->kode_bidang.' '.$pe->nama_bidang;
			
			$p2 = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $idp,'id_par_bidang' => $pe->id_bidang)));
			if ($p2->num_rows() > 0) $this->get_sub($idp,$id,$pe->id_bidang);
			
			endforeach;
		}
	}
	
	function add_bidang($dir,$param) {
		
		$o = un_de($param);
		
		$data['title'] = (!empty($o['id'])) ? "Ubah" : "Tambah";
		$data['title'].= " Unit Organisasi";
		$def = !empty($o['id']) ? $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_bidang' => $o['id'])))->row():null;
		$form_par = null;
		
		if (!empty($o['id'])) {
		$cek = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_par_bidang' => $o['id']),'select' => 'count(*) as jml'))->row()->jml;
		if ($cek == 0) {
			$comb_unit = $this->general_model->combo_box(array('tabel' => 'ref_unit','order' => 'unit','key' => 'id_unit','val' => array('unit')));
			$form_par = '<p>'.form_label('Unit Kerja').form_dropdown('id_unit',$comb_unit,$o['id_unit'],'class="combo-box" style="width: 100%"').'</p>';
		} else {
			//$form_par = form_hidden('id_unit',$o['id_unit']);
		}
		} 
		$form_par.= form_hidden('id_unit',$o['id_unit']);
		
		
		if (!empty($o['id_par_bidang'])) {

			if (empty($o['id'])) {
				
				$par =  $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_bidang' => $o['id_par_bidang'])))->row();
				$form_par.= 
					form_hidden('id_par_bidang',$o['id_par_bidang']).
					form_label('Atasan').form_input('',$par->kode_bidang.' '.$par->nama_bidang,'readonly="readonly" class="form-control"');
				
			} else {

				$this->dump_unit = array();
				$this->get_sub($o['id_unit'],$o['id']);
				
				$form_par.= '<p>'.
					form_label('Unit Organisasi di Atasnya').
					form_hidden('id_par_bidang_ori',$def->id_par_bidang).
					form_dropdown('id_par_bidang',$this->dump_unit,$o['id_par_bidang'],'class="combo-box form-control " style="width: 100%"').'</p>';

			}
		
		} else {
			
			if ($o['id'] != NULL) {
			
			$this->dump_unit = array();
			$this->get_sub($o['id_unit'],$o['id']);
				
			$form_par.= '<p>'.
				form_label('Unit Organisasi di Atasnya').
				form_dropdown('id_par_bidang',$this->dump_unit,null,'class="combo-box form-control " style="width: 100%"').'</p>';
			}
		}
		
		$cb_unit = $this->general_model->combo_box(array('tabel' => 'ref_unit','key' => 'id_unit','val' => array('unit'),'order' => 'unit'));
		
		$data['form_link'] = 'inti/unitorganisasi/saving';
		$data['form_data'] =
			//'<p>'.form_label('Unit Kerja').form_dropdown('id_unit',$cb_unit,isset($def->id_unit)?$def->id_unit:$o['id_unit'],'class="combo-box form-control " style="width: 100%"').'</p>'.
			($form_par != null?$form_par:null).
			form_hidden('id_bidang',@$def->id_bidang).
			form_hidden('dir',$dir).
			'<p>'.form_label('Kode').form_input('kode_bidang',@$def->kode_bidang,'class="form-control"').'</p>'.
			'<p>'.form_label('Nama Unit Organisasi').form_input('nama_bidang',@$def->nama_bidang,'class="form-control" required').'</p>'.
			'<p>'.form_label('Aktif').form_dropdown('aktif',array('1' => 'Aktif','2' => 'Non-Aktif'),@$def->aktif,'class="form-control combo-box" required style="width: 100%"').'</p>';
		
		$this->load->view('umum/form_view', $data);
	
	}
	
	function urut_nomor($par) {
		$o = un_de($par);
		$whereis = (!empty($o['par'])) ? array('id_unit = '.$o['id_unit'].' AND id_par_bidang = '.$o['par'] => null) : array('id_unit = '.$o['id_unit'].' AND id_par_bidang IS NULL' => null); 
		$num = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => $whereis,'order' => 'urut,nama_bidang'));

		$j = 1;
		foreach($num->result() as $n) {
			$this->general_model->save_data('ref_bidang',array('urut' => $j),'id_bidang',$n->id_bidang);
			$j+=1;
		}
		
	}
	
	function saving() {
	
		$id = $this->input->post('id_bidang');
		$id_unit = $this->input->post('id_unit');
		
		$simpan = array(
			'kode_bidang' => $this->input->post('kode_bidang'),
			'nama_bidang' => $this->input->post('nama_bidang'),
			'id_unit' =>  $id_unit,
			'aktif' => $this->input->post('aktif')
		);
		
		$par = $this->input->post('id_par_bidang');
		$par_ori = $this->input->post('id_par_bidang_ori');
		$simpan['id_par_bidang'] = ($par != null) ? $par : null;
		if ($id == NULL or ($par != null and $par_ori != null and $par != $par_ori)) {
		
			$whereis = (!empty($par)) ? array('id_unit = '.$id_unit.' AND id_par_bidang = '.$par => null) : array('id_unit = '.$id_unit.' AND id_par_bidang IS NULL' => null); 
			$num = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => $whereis,'select' => 'MAX(urut) as urutan'))->row();
			$simpan['urut'] = ($num->urutan+1);
		}
		
		$this->general_model->save_data('ref_bidang',$simpan,'id_bidang',$id);
		
		$this->urut_nomor(in_de(array('id_unit' => $id_unit,'par' => $par)));
		
		$this->session->set_flashdata('ok', 'Data berhasil disimpan');
		redirect($this->input->post('dir').'/bidang/tabel_bidang/'.in_de(array('id' => $id_unit)));
		
	}
	
	function removing($dir,$par){
	
		$o = un_de($par);
		$this->general_model->delete_data('ref_bidang','id_bidang',$o['id']);
		$this->session->set_flashdata('ok', 'Unit Organisasi berhasil dihapus');
		redirect($dir.'/bidang/tabel_bidang/'.in_de(array('id' => $o['unit'])));
		
	}
	
	function urutkan($dir,$par) {
		$o = un_de($par);
		$this->general_model->save_data('ref_bidang',array('urut' => $o['no2']),'id_bidang',$o['id1']);
		$this->general_model->save_data('ref_bidang',array('urut' => $o['no1']),'id_bidang',$o['id2']);
		redirect($dir.'/bidang/tabel_bidang/'.in_de(array('id' => $o['unit'])));
	}
}