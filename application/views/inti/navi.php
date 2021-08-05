<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Navi extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
	}
	
	public function index() {
		
		$this->show_navi();
	
	}
	
	function tabel_sub($r,$lev,$a,$id) {
		
		$sub_bid = $this->general_model->datagrab(array(
			'tabel'=> 'nav',
			'where' => array('id_par_nav' => $id),
			'order' => 'urut'
		));
		
		$awal = array();
		$urutkan = array();
		
		foreach ($sub_bid->result() as $row) {
			$awal[] = array($row->id_nav,$row->urut);
		}
		
		$n = 0;
		if ($sub_bid->num_rows() > 0) {
			foreach($sub_bid->result() as $row) {
				
				$btn_down = ($n+1 < $sub_bid->num_rows()) ? anchor('inti/navi/navurut/'.in_de(array('ref' => $r,'app' => $a,'id1' => $row->id_nav,'no1' => $row->urut,'id2' => @$awal[$n+1][0],'no2' => @$awal[$n+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
				$btn_up = ($n > 0) ? anchor('inti/navi/navurut/'.in_de(array('ref' => $r,'app' => $a,'id2' => $row->id_nav,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
				$urutkan = array($row->id_nav,$row->urut);
					
				
				$cell = array(array('data' => '<input type="checkbox" name="cek[]" class="cek" value="'.$row->id_nav.'">','style' => 'text-align: center'));
				for ($j=0;$j < $lev; $j++) {
					if ($j>0) $cell[] = array('data'=>'','width' => '20');
				}
		
								$links = array(
						array('data' =>
						anchor(
							'#',
							'<i class="fa fa-pencil"></i>',
							'class="btn-edit" act="'.site_url('inti/navi/form_data/'.in_de(array('ref' => $r,'id_aplikasi' => $a,'id' => $row->id_nav))).'"'),
						'class' => 'text-center'));

				
				$sub_bidd = $this->general_model->datagrab(array('tabel' => 'nav', 'where' => array('id_par_nav' => $row->id_nav)));
				if ($sub_bidd->num_rows() == 0)  {
					$links[] = 
						array('data' =>
								anchor(
								'#',
								'<i class="fa fa-trash"></i>',
								'class="btn-delete" act="'.site_url('inti/navi/removing/'.in_de(array('ref' => $r,'id' => $row->id_nav,'app' => $a))).'" msg="Apakah modul <b>'.$row->judul.'</b> akan dihapus?"'),
								'class' => 'text-center'
							);
				} else { $links[] = " "; }
			
				$links[] = ($row->aktif == 1) ? anchor('inti/navi/toggle/'.$r.'/'.$a.'/off/'.$row->id_nav,'<i class="fa fa-toggle-on"></i>') : anchor('inti/navi/toggle/'.$r.'/'.$a.'/on/'.$row->id_nav,'<i class="fa fa-toggle-off"></i>'); 
				$links[] = array('class' => 'text-center','width' => '35','data' => $btn_down);
				$links[] = array('class' => 'text-center','width' => '35','data' => $btn_up);
				$tipe = ($row->tipe == 1) ? '<span class="label bg-yellow"><i class="fa fa-key"> </i></span>' : '<span class="label bg-purple"><i class="fa fa-navicon"></i></span>';
				$icon = ($row->tipe == 1) ? 'star':(!empty($row->fa) ? $row->fa : 'circle-o');
				$kode = !empty($row->kode) ? '<b>'.$row->kode.'</b>' : null;
				$nama = !empty($row->judul) ? ' '.$row->judul : null;
				
				$btn_sub = ($row->tipe == 2 and $row->aktif == 1) ? '  &nbsp; <a href="#" class="btn-edit btn btn-xs btn-success" style="padding: 0 5px" title="Tambah SUB Modul ..." act="'.site_url('inti/navi/form_data/'.in_de(array('ref' => $r,'id_aplikasi' => $a,'id_par' => $row->id_nav))).'"><i class="fa fa-arrow-circle-down"></i></a>' : null;
				$cl_cell = ($row->aktif == 1) ? ($row->tipe == 1?'text-orange':null):'text-muted';
				$tipe = ($row->aktif == 1) ? $tipe : '<span class="label label-default"><i class="fa fa-navicon"></i></span>';
				
				$cell[] = array('data'=> '<i class="fa fa-'.$icon.'"></i> &nbsp; '.$kode.$nama.$btn_sub,'colspan'=> 8-$lev,'class' => $cl_cell,'title' => $row->link);
				$cell = array_merge_recursive($cell,$links);
					
				$this->table->add_row($cell);
				if ($sub_bidd->num_rows() > 0 and $lev < 8) $this->tabel_sub($r,$lev+1,$a,$row->id_nav);	
			$n += 1;
			}
		}
		
	}
	
	function tabel($r,$a) {
		
		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'nav',
			'where' => array('ref = '.$r.' AND id_par_nav IS NULL and id_aplikasi = "'.$a.'"' => null),
			'order' => 'urut',
		));
		
		$awal = array();
		$urutkan = array();

		
		$root_btn = anchor(
			'#',
			'<span class="btn btn-xs btn-success pull-right"><i class="fa fa-arrow-circle-down"></i> &nbsp; Root Modul</span>',
			'class="btn-edit" act="'.site_url('inti/navi/form_data/'.in_de(array('ref' => $r,'status' => 'root','id_aplikasi' => $a))).'"');
		
		foreach ($nav->result() as $row) {
			$awal[] = array($row->id_nav,$row->urut);
		}
		
		if ($nav->num_rows() > 0) {
            $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
            $this->table->set_empty("&nbsp;");	
			$this->table->set_heading(array('data'=>'<input type="checkbox" name="cek_all" id="cek_all" class="cek-all"','class'=>'center','style'=>'width:30px'),
				array('data' => 'Modul &nbsp; '.$root_btn,'colspan' => '7','class' => 'text-left'),
				array('data' => 'Aksi', 'width' => '70','colspan' => 2,'class' => 'text-center'));
				$m = 0;
				foreach ($nav->result() as $row) {
					
					$links = array(
						array('data' =>
						anchor(
							'#',
							'<i class="fa fa-pencil"></i>',
							'class="btn-edit" act="'.site_url('inti/navi/form_data/'.in_de(array('ref' => $r,'id_aplikasi' => $a,'id' => $row->id_nav))).'"'),
						'class' => 'text-center'));
					
					$btn_down = ($m+1 < $nav->num_rows()) ? anchor('inti/navi/navurut/'.in_de(array('ref' => $r,'app' => $a,'id1' => $row->id_nav,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('inti/navi/navurut/'.in_de(array('ref' => $r,'app' => $a,'id2' => $row->id_nav,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_nav,$row->urut);
					
					$subs = $this->general_model->datagrab(array('tabel' => 'nav', 'where' => array('id_par_nav' => $row->id_nav)));
					if ($subs->num_rows() == 0)  {
						$links[] = 
						array('data' =>
								anchor(
								'#',
								'<i class="fa fa-trash"></i>',
								'class="btn-delete" act="'.site_url('inti/navi/removing/'.in_de(array('ref' => $r,'id' => $row->id_nav,'app' => $a))).'" msg="Apakah modul <b>'.$row->judul.'</b> akan dihapus?"'),
								'class' => 'text-center'
							);
					}	else { $links[] = " "; }
					
					
				
					$links[] = ($row->aktif == 1) ? anchor('inti/navi/toggle/'.$r.'/'.$a.'/off/'.$row->id_nav,'<i class="fa fa-toggle-on"></i>') : anchor('inti/navi/toggle/'.$r.'/'.$a.'/on/'.$row->id_nav,'<i class="fa fa-toggle-off"></i>'); 
					$links[] = array('class' => 'text-center','width' => '35','data' => $btn_down);
					$links[] = array('class' => 'text-center','width' => '35','data' => $btn_up);
					
					$tipe = ($row->tipe == 1) ? '<span class="text-orange"><i class="fa fa-key"> </i></span>' : '<span class="label bg-purple"><i class="fa fa-navicon"></i></span>';
					$icon = ($row->tipe == 1) ? 'star':(!empty($row->fa) ? $row->fa : 'circle-o');
					$kode = !empty($row->kode) ? '<b>'.$row->kode.'</b>' : null;
					$nama = !empty($row->judul) ? ' '.$row->judul : null;
					$btn_sub = ($row->tipe == 2 and $row->aktif == 1) ? ' &nbsp; <a href="#" class="btn-edit btn btn-xs btn-success" style="padding: 0 5px" act="'.site_url('inti/navi/form_data/'.in_de(array('ref' => $r,'id_aplikasi' => $a,'id_par' => $row->id_nav))).'"><i class="fa fa-arrow-circle-down"></i></a>' : null;
				
					$cl_cell = ($row->aktif == 1) ? ($row->tipe == 1?'text-orange':null):'text-muted';
					$tipe = ($row->aktif == 1) ? $tipe : '<span class="label label-default"><i class="fa fa-navicon"></i></span>';
					
					$cell = array(
						array('data' => '<input type="checkbox" name="cek[]" class="cek" value="'.$row->id_nav.'">','style' => 'text-align: center'),
						array('data'=> '<i class="fa fa-'.$icon.'"></i> &nbsp; '.$kode.$nama.$btn_sub,'colspan'=> 7,'class' => $cl_cell,'title' => $row->link));	
					$cell = array_merge_recursive($cell,$links);
					
					$this->table->add_row($cell);
					if ($nav->num_rows() > 0) $this->tabel_sub($r,2,$a,$row->id_nav);
					$m += 1;
				}
				return  $this->table->generate();
			
		} else {
		
			return  '<div class="alert">Belum ada Modul terdaftar</div>'.$root_btn;
		
		}
		
	}
	
	function show_navi($par = null) {
		
		if (!empty($par)) $par = un_de($par);
		$jud = ($par['ref'] == 2) ? 'Referensi' : null;
		$data['breadcrumb'] = array('' => 'Pengaturan', 'referensi/nav' => 'Navigasi');
		
		$pil = $this->input->post('pil');
		$pil = !empty($pil) ? $pil : (!empty($par['app'])?$par['app']:null);
		$where = (!empty($pil)) ? array('id_aplikasi' => $pil) : null;
		
		$apps = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => $where))->row();
		$active = ($apps->aktif > 0) ? '<span class="label label-info" style="font-weight: 100; letter-spacing: 2px">Aktif</span>' : '<span class="label" style="font-weight: 100; letter-spacing: 2px">Non-Aktif</span>';
		$data['title']	= 'Pengaturan Navigasi '.$apps->nama_aplikasi.' '.$active;
		$where_ref =  ($par['ref'] == 2) ? null : 'id_aplikasi != 1 AND ';
		
		$app_combo_data = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','order' => 'urut','where' => array($where_ref.'id_par_aplikasi IS NULL' => null)));
		
		$app_combo = array('' => ' -- Pilih '.$jud.' Aplikasi -- ');
		foreach($app_combo_data->result() as $ap) {
			
			$app_child = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','order' => 'urut','where' => array($where_ref.'id_par_aplikasi = '.$ap->id_aplikasi => null)));
			$app_combo[$ap->id_aplikasi] = $ap->nama_aplikasi;
			foreach($app_child->result() as $apc) { $app_combo[$apc->id_aplikasi] = ' -- '.$apc->nama_aplikasi; }
			
		}
		
		$data['script'] = '
			$(document).ready(function() {
				$("select").select2();
				$(".change-pil").change(function() {
					$("#form_pilih").submit();
				});	
				$(".btn-import").click(function() {
					$("#form_impor").submit();
				});
			});
		';
		
		$data['tombol'] = 
			form_open('inti/navi/show_navi/'.in_de(array('ref' => $par['ref'])),'id="form_pilih"').
				form_dropdown('pil',$app_combo,!empty($pil)?$pil:null,'class="combo-box change-pil" style="width: 100%"').
			form_close();
	
		$data['title'] = 'Modul '.$jud;
		
		if (!empty($pil)) {
			$data['tabel'] = '
				<div class="row">
					<div class="col-lg-8">'.
						form_open('inti/navi/delete_navi','id="form_delete"').
						form_hidden('par',in_de(array('ref' => $par['ref'],'app' => $pil))).
						anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-bottom: 10px"').
						$this->tabel($par['ref'],$pil).
						anchor('#','<i class="fa fa-trash"></i> &nbsp; Hapus Yang Tercentang','class="btn btn-danger btn-delete-all btn-sm" style="display: none; margin-top: -10px"').
						form_close().
					'</div><div class="col-lg-4">'.
					form_open_multipart('inti/navi/read_navi','id="form_impor"').
						form_hidden('par',in_de(array('ref' => $par['ref'],'app' => $pil))).
						form_label('Impor Navigasi (CSV)').
						'<div class="alert alert-confirm"><p>'.form_upload('csv_impor').'</p>
						<p><label>'.form_checkbox('on_reset',1,NULL).' &nbsp; Kosongkan Navigasi</label></p>'.
						'<p>'.form_label(' &nbsp; ').form_button('btn-simpan','<i class="fa fa-cloud-download"></i> &nbsp; Impor','class="btn btn-import btn-success"').'</p></div>'.
						'<p>'.form_label('Ekspor Navigasi').'</p>'.anchor('inti/navi/export_csv/'.in_de(array('app' => $pil,'ref' => $par['ref'])),'<i class="fa fa-cloud-upload"></i> &nbsp; Ekspor Navigasi','class="btn btn-warning"').'</p>'.
					form_close().
					'</div>';
		
		
		} else $data['tabel'] = '<div class="alert">Pilih '.$jud.' Aplikasi </div>';
		

		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function form_data($param) {
	
		$o = un_de($param);
	
		$apps = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('id_aplikasi' => $o['id_aplikasi'])))->row();
		$data['title'] = (!empty($o['id'])) ? "Ubah" : "Tambah";
		$data['title'].= " Modul";
		$def = !empty($o['id']) ? $this->general_model->datagrab(array('tabel' => 'nav','where' => array('id_nav' => $o['id'])))->row():null;
		
		$form_par = '<p>'.form_label('Aplikasi').form_input('',$apps->nama_aplikasi,'readonly="readonly" class="form-control"').'</p>';
		
		if (!empty($o['id_par'])) {
			$par =  $this->general_model->datagrab(array('tabel' => 'nav','where' => array('id_nav' => $o['id_par'])))->row();
			$form_par.= form_hidden('id_par_nav',$o['id_par']).form_label('Navigasi Atas').form_input('',$par->kode.' '.$par->judul,'readonly="readonly" class="form-control"');
		}
	
		$id_nav = !empty($o['id'])?$o['id']:null;
		$data['script'] = 
			"$('input[type=\"radio\"].flat-blue').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass: 'iradio_minimal-blue'
			});
			$('input[type=\"radio\"].flat-green').iCheck({
				checkboxClass: 'icheckbox_minimal-green',
				radioClass: 'iradio_minimal-green'
			});
		";
		
		if (empty($def)) {
			
			$data['script'] .= "
			$('.judul-modul').keyup(function() {
				
				var ce = $('input[name=tipe]:checked').val();
				if (!ce) $('#alert-form').addClass('alert alert-danger').html('Pilih Jenis Modul!');
				else {
					var injud = $(this).val().split(' ');
					var jadi = '';
					if (ce == '1') {
						var kode_mod = '';
						
						var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
						var randomkode = '';
						for( var i=0; i < 2; i++ ) {
							randomkode += possible.charAt(Math.floor(Math.random() * possible.length));
						}
						for(i = 0; i < injud.length; i++) {
							ne = injud[i].substr(0,1).toUpperCase();
							kode_mod = kode_mod+ne;
						}
						
						var kode = '".$apps->kode_aplikasi."'
						$('.kode-modul').val(kode+kode_mod+randomkode);
						
					}
					
					for(i = 0; i < injud.length; i++) {
						ne = injud[i].substr(0,1).toUpperCase();
						if (jadi) jadi += ' ' + ne + injud[i].substr(1,50);
						else jadi = ne + injud[i].substr(1,50);
					}
					$(this).val(jadi);
				}
			});
			";
			
		}
			
		$data['form_link'] = 'inti/navi/saving';
		
		$c1 = (!empty($def) and $def->tipe == 1) ? 'checked' : null;
		$c2 = (!empty($def) and $def->tipe == 2) ? 'checked' : null;
		
		$r_kode = empty($def) ? ' readonly':null;
		
		$data['form_data'] = 
			form_hidden('aktif',!empty($def)?$def->aktif:1).
			$form_par.'
			<link href="'.base_url().'assets/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="'.base_url().'assets/plugins/iCheck/icheck.min.js"></script>
			<p>
				<label>Jenis Modul</label>
				<div class="form-group">
                    <label>
                      <input type="radio" value="1" name="tipe" class="flat-blue" '.$c1.' required/> Kewenangan
                    </label> &nbsp; 
                    <label>
                      <input type="radio" value="2" name="tipe" class="flat-blue" '.$c2.' required/> Navigasi
                    </label>
				</div>
				</p>'.
			'<div class="row"><div class="col-sm-8">'.form_label('Judul').form_input('judul',@$def->judul,'class="form-control judul-modul" required').'</div>'.
			'<div class="col-sm-4">'.form_label('Kode Kewenangan').form_input('kode',@$def->kode,'class="form-control kode-modul" '.$r_kode).'</div></div>'.
			'<p>'.form_label('Link').form_textarea('link',@$def->link,'class="form-control" style="height: 60px"').'</p>'.
			'<p>'.form_label('Icon').form_input('fa',@$def->fa,'class="form-control"').'</p>'.
			form_hidden('id_nav',$id_nav).form_hidden('id_aplikasi',$o['id_aplikasi']).form_hidden('ref',$o['ref']);
			
			
		$this->load->view('umum/form_view', $data);
	
	}
	
	function saving() {
		
		$id = $this->input->post('id_nav');
		$id_par = $this->input->post('id_par_nav');
		$id_app = $this->input->post('id_aplikasi');
		$ref = $this->input->post('ref');
		$kode =  $this->input->post('kode');

		$where_cek =  array('kode' => $kode);
		if (!empty($id)) $where_cek['id_nav != '.$id] = null;
		$cek_code = $this->general_model->datagrab(array('tabel' => 'nav', 'where' => $where_cek));
		
		if ((empty($id) and $cek_code->num_rows() > 0 and !empty($kode)) or (!empty($id) and $cek_code->num_rows() > 0 and !empty($kode))) {
			
			$ce_ket = $cek_code->row();
			$ket = '<br> pada <i>'.$ce_ket->kode.' - '.$ce_ket->judul.'</i>';
			$this->session->set_flashdata('fail', 'Kode modul <strong>'.$ce_ket->kode.'</strong> sudah pernah terdefinisi'.$ket);
			
		} else {

		$simpan = array(
			'id_aplikasi' => $id_app,
			'ref' => $ref,
			'tipe' => $this->input->post('tipe'),
			'kode' => $kode,
			'judul' => $this->input->post('judul'),
			'fa' => $this->input->post('fa'),
			'link' => $this->input->post('link'),
			'separator' => $this->input->post('separator'),
			'aktif' => $this->input->post('aktif')
		);
		
		if (!empty($id_par)) $simpan['id_par_nav'] = $id_par;
		
		if (empty($id)) {
			
			$where_urut = array('id_aplikasi' => $id_app,'ref' => 1);
			$where_urut =  (!empty($par)) ? array_merge_recursive($where,array('id_par_nav' => $par)) : array_merge_recursive($where,array('id_par_nav IS NULL' => null));
		
			$u = $this->general_model->datagrab(array(
				'tabel' => 'nav',
				'select' => 'max(urut) as urut_nav',
				'where' => $where_urut
			))->row();
			
			$simpan['urut'] = !empty($u->urut_nav) ? $u->urut_nav+1 : 1;
			
		} else {
			
			$this->urutkan($id_app,$id_par);
			
		}
		
		$par = $this->input->post('id_par_navi');
		if (!empty($par)) $simpan['id_par_navi'] = $par;
		
		$this->general_model->save_data('nav',$simpan,'id_nav',$id);
		$this->session->set_flashdata('ok', 'Modul berhasil disimpan');
		}

		redirect('inti/navi/show_navi/'.in_de(array('app' => $id_app,'ref' => $ref)));
		
	}
	
	function urutkan($id, $par = null) {
		
		$where = array('id_aplikasi' => $id,'ref' => 1);
		$where =  (!empty($par)) ? array_merge_recursive($where,array('id_par_nav' => $par)) : array_merge_recursive($where,array('id_par_nav IS NULL' => null));
		
		$u = $this->general_model->datagrab(array(
				'tabel' => 'nav',
				'where' => $where,
				'order' => 'urut'
			));

		$no = 1;
		foreach($u->result() as $ur) {
			
			$this->general_model->save_data('nav',array('urut' => $no),'id_nav',$ur->id_nav);
			$no+=1;
			
		}
		
	}
	
	function navurut($par) {
		$o = un_de($par);
		$this->general_model->save_data('nav',array('urut' => $o['no2']),'id_nav',$o['id1']);
		$this->general_model->save_data('nav',array('urut' => $o['no1']),'id_nav',$o['id2']);
		redirect('inti/navi/show_navi/'.in_de(array('app' => $o['app'],'ref' => $o['ref'])));
	}
	
	function delete_navi(){
	
		$par = $this->input->post('par');
		$cek = $this->input->post('cek');	
	
		$o = un_de($par);
		
		foreach($cek as $c) {
			$this->general_model->delete_data('nav','id_nav',$c);
			$this->urutkan($o['app']);
		}
		$this->session->set_flashdata('ok', 'Modul berhasil dihapus');
		redirect('inti/navi/show_navi/'.in_de(array('app' => $o['app'],'ref' => $o['ref'])));
		
	}
	
	function removing($par){
	
		$o = un_de($par);
		$this->general_model->delete_data('nav','id_nav',$o['id']);
		$this->urutkan($o['app']);
		$this->session->set_flashdata('ok', 'Modul berhasil dihapus');
		redirect('inti/navi/show_navi/'.in_de(array('app' => $o['app'],'ref' => $o['ref'])));
		
	}
	
	function toggle($r,$app,$on,$id) {
		
		$st = ($on == 'on') ? '1' : '0';
		$this->general_model->save_data('nav',array('aktif' => $st),'id_nav',$id);
		redirect('inti/navi/show_navi/'.in_de(array('app' => $app,'ref' => $r)));
		
	}
	
	function export_csv($par) {
	
	$o = un_de($par);
	
	$app = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('id_aplikasi' => $o['app'])))->row();
	
	$this->load->dbutil();

	$query = $this->general_model->datagrab(array(
		'tabel' => array(
			'nav n' => '',
			'nav na' => array('n.id_par_nav = na.id_nav','left')),
		'where' => array('n.id_aplikasi' => $o['app'],'n.ref' => $o['ref']),
		'select' => '
			n.id_aplikasi,
			n.ref,
			n.kode,
			n.tipe,
			n.judul,
			na.judul as par_judul,
			n.link,
			n.fa',
		'order' => 'n.id_par_nav, n.urut'
	));

	$delimiter = ",";
	$newline = "\n";
	
	$csv = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
	
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=navigasi_".$app->folder.".csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo $csv;

	}
	
	function read_navi() {
	
		$res = $this->input->post('on_reset');
	
		$par = $this->input->post('par');

		$o = un_de($par);
		$error = null;
		
		if (empty($_FILES['csv_impor']['tmp_name'])) {
			$error = 'Pilih dokumen CSV';
		} else {
			$this->load->library('upload');
			$this->upload->initialize(array(
				'file_name' => 'nav.csv',
				'upload_path' => './uploads/',
				'allowed_types' => '*'));
			if (! $this->upload->do_upload('csv_impor')) {
				$error = $this->upload->display_errors();
			} else {
				$data_up = $this->upload->data();
				$this->load->library('csvreader');
		        $data_read =   $this->csvreader->parse_file('./uploads/nav.csv');
		        
				if (!empty($res)) $this->general_model->delete_data(array('tabel' => 'nav','where' => array('id_aplikasi' => $o['app'],'ref' => $o['ref'])));
				
		        foreach($data_read as $dat) {
					$cek = $this->general_model->datagrab(array(
						'tabel' => 'nav', 
						'where' => array(
							'id_aplikasi' => $dat['id_aplikasi'],
							'ref' => $dat['ref'],
							'judul' => $dat['judul'],
							'link' => $dat['link']),
						'select' => 'count(*) as jml'))->row();

					if ($cek->jml == 0) { 
						$id_par = null;
						if (!empty($dat['par_judul'])) {
							$cek_par = $this->general_model->datagrab(array(
								'tabel' => 'nav', 
								'where' => array(
									'id_aplikasi' => $dat['id_aplikasi'],
									'judul' => $dat['par_judul'],
									'ref' => $dat['ref']),
								'select' => 'id_nav'))->row();
							$id_par = $cek_par->id_nav;
							
						}
						
						$max_num = $this->general_model->datagrab(array(
							'tabel' => 'nav','where' => array('id_aplikasi' => $dat['id_aplikasi']),
							'select' => 'MAX(urut) as max_num'
						))->row();
						$simpan = array(
							'id_aplikasi' => $dat['id_aplikasi'],
							'judul' => $dat['judul'],
							'tipe' => $dat['tipe'],
							'ref' => $dat['ref'],
							'kode' => $dat['kode'],
							'link' => $dat['link'],
							'fa' => $dat['fa'],
							'urut' => $max_num->max_num+1,
							'separator' => 0,
							'aktif' => 1
						);
						
						if (!empty($id_par)) $simpan['id_par_nav'] = $id_par;
						
						$this->general_model->save_data('nav',$simpan);
						
					}
				}
			}
		}
		
		unlink(FCPATH.'uploads/nav.csv');

		if (!empty($error)) $this->session->set_flashdata('fail',$error);
		else $this->session->set_flashdata('ok','Navigasi berhasil disimpan');
		
		redirect('inti/navi/show_navi/'.$par);
	
	}
}