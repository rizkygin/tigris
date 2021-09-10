<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Bidang extends CI_Controller {

	var $dir = 'tigris';
	var $dump_unit = array();
	
	function __construct() {
		
		parent::__construct();
		$this->db->query('SET SESSION sql_mode =
			REPLACE(REPLACE(REPLACE(
			@@sql_mode,
			"ONLY_FULL_GROUP_BY,", ""),
			",ONLY_FULL_GROUP_BY", ""),
			"ONLY_FULL_GROUP_BY", "")');
	}
	
	public function index() {
		
		$this->list_unit();
	
	}
	
	function in_app() {
		
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;

		
	}
	
	function sub_unit($sub,$n) {
		foreach($sub->result() as $row) {
			$cell = array();
			for($i = 0; $i < 4-$n; $i++) {
				$cell[] = array('data' => '&nbsp &nbsp ');
			}
			
			$cell[] = array('data' => anchor($this->dir.'/Bidang/tabel_bidang/'.$row->id_unit,$row->kode_unit.' '.$row->unit,'class="link-normal"'),'colspan' => $n);
			
			$add_sub = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('id_par_unit' => $row->id_unit)));
			$this->table->add_row($cell);
			if ($add_sub->num_rows() > 0) $this->sub_unit($add_sub,$n-1); 
			
		}		
	}
	
	
	function list_unit($offset = null) {

		$total_unit =  $this->general_model->datagrab(array('tabel'=>'ref_unit'));
		
		if ($total_unit->num_rows() == 1) {
	
			redirect($this->dir.'/Bidang/tabel_bidang/'.in_de(array('id' => $total_unit->row()->id_unit)));
		
		} else {
		
			$data['breadcrumb'] = array('' => $this->dir.'', $this->dir.'/Bidang' => 'Prodi');
			$data['tabel'] = load_controller($this->dir.'','unit','tabel_unit',in_de(array('link' => $this->dir.'/Bidang/tabel_bidang/')));
			$data['title'] = 'Daftar Unit Kerja';
			$data['content'] = "umum/standard_view";
			$this->load->view('home', $data);
			
		}
	}
	
	function tabel_sub($level_bidang,$id) {
		
		$from = array('ref_bidang b' => '','ref_unit u' => 'u.id_unit = b.id_unit');
		
		$sub_bid = $this->general_model->datagrab(array(
			'tabel' => $from,
			'where' => array('b.id_par_bidang' => $id),
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
			foreach($sub_bid->result() as $row) {
			
				$cell = array();
			
				for ($j=0;$j < $level_bidang; $j++) {
					if ($j>0) $cell[] = array('data'=>'','width' => '20');
				}
				
				$btn_down = ($r+1 < $sub_bid->num_rows()) ? anchor($this->dir.'/Bidang/urutkan/'.in_de(array('unit' => $row->id_unit,'id1' => $row->id_bidang,'no1' => $row->urut,'id2' => $awal_sub[$r+1][0],'no2' =>  $awal_sub[$r+1][1])),'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info"') : '';
				$btn_up = ($r > 0) ? anchor($this->dir.'/Bidang/urutkan/'.in_de(array('unit' => $row->id_unit,'id2' => $row->id_bidang,'no2' => $row->urut,'id1' =>  !empty($urutkan_sub[0])?$urutkan_sub[0]:@$awal_sub[0],'no1' => !empty($urutkan_sub[1])?$urutkan_sub[1]:@$awal_sub[1])),'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info"') : '';
				$urutkan_sub = array($row->id_bidang,$row->urut);
				$cell_aksi = array(array('class' => 'text-center no-wrap','width' => '80','data' => $btn_down.$btn_up));
				$cell_aksi[] = array('class' => 'text-center','data' => '<a href="#" title="Ubah" class="btn-edit btn btn-xs btn-warning" act="'.site_url($this->dir.'/Bidang/add_bidang/'.in_de(array('id_par_bidang' => $row->id_par_bidang,'id' => $row->id_bidang,'id_unit' => $row->id_unit))).'"><i class="fa fa-pencil"></i></a>');
				
				$sub_bidd = $this->general_model->datagrab(array('tabel' => 'ref_bidang', 'where' => array('id_par_bidang' => $row->id_bidang)));
				if ($sub_bidd->num_rows() == 0)  {
					$cell_aksi[] = array('class' => 'text-center','data' => '<a href="#" title="Hapus" class="btn-delete btn btn-xs btn-danger" act="'.site_url($this->dir.'/Bidang/removing/'.in_de(array('id' => $row->id_bidang,'unit' => $row->id_unit))).'" msg="Apakah Bidang <b>'.$row->kode_bidang.' '.$row->nama_bidang.'</b> akan dihapus?"><i class="fa fa-trash"></i></a>');
				}
			
				$add_sub = array('id_unit' => $row->id_unit,'id_par_bidang' => $row->id_bidang);
				$kode = !empty($row->kode_bidang)?'<b>'.$row->kode_bidang.'</b>':null;
				$nama = !empty($row->nama_bidang)?' '.$row->nama_bidang:null;
				
				$btn_tambah_sub = '<div class="btn-group">
					<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-cog"></i>
					</a>
					<ul class="dropdown-menu pull-right">
					<li><a href="#" class="btn-edit" act="'.site_url($this->dir.'/Bidang/add_bidang/'.in_de($add_sub)).'"><i class="fa fa-plus-square-o"></i> Tambahkan Sub Prodi</a></li>
					<li><a href="#" act="'.site_url($this->dir.'/Bidang/pindah_bidang/'.in_de(array('id' => $row->id_bidang,'nama' => $row->nama_bidang))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindahkan ke Unit Kerja</a></li></ul>
					</div>';
				
				$cell[] = array('data'=>  $kode.$nama.' &nbsp; '.$btn_tambah_sub, 'colspan' => 8-$level_bidang);
				$cell = array_merge_recursive($cell,$cell_aksi);
			
				$this->table->add_row($cell);
				if ($sub_bidd->num_rows() > 0) $this->tabel_sub($level_bidang+1,$row->id_bidang);
				$r+=1;
			}
		}
		
	}
	
	function tabel_bidang($o = null) {

		/* Urutkan */
		
		$o = un_de($o);
		
		$unit_data = $this->general_model->datagrab(array(
			'tabel'=> 'ref_unit',
			'where' => array('id_unit' => $o['id']),
			'order' => 'urut'
		))->row();

		$data['breadcrumb'] = array('' => $this->in_app(), $this->dir.'/Bidang' => 'Daftar Prodi');
		if (!empty($o['redir'])) $data['dir_cut'] = $o['redir'];

		$data['title']		= 'Prodi';
		$data['content']	= 'umum/standard_view';
		
		$from = array('ref_bidang b' => '','ref_unit u' => 'u.id_unit = b.id_unit');
		
		$root_bid = $this->general_model->datagrab(array('tabel' => $from,'where' => array('b.id_unit = '.$o['id'].' AND id_par_bidang IS NULL' => null),'order' => 'b.urut,b.nama_bidang','select' => 'b.*'));
		
		$no_urut = 1;
		foreach ($root_bid->result() as $row) {
			$this->general_model->save_data('ref_bidang',array('urut' => $no_urut),'id_bidang',$row->id_bidang);
			$no_urut+=1;
		}
		
		$btn_bid_root = anchor('#','<i class="fa fa-plus-square"></i> &nbsp; Prodi','class="btn btn-xs btn-edit btn-success" act="'.site_url($this->dir.'/Bidang/add_bidang/'.in_de(array('level_bidang' => '1','id_unit' => $o['id']))).'"');
		
		$awal = array();
		$urutkan = array();
		
		foreach ($root_bid->result() as $row) {
			$awal[] = array($row->id_bidang,$row->urut);
		}

		if ($root_bid->num_rows() > 0) {
            $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-condensed gap">'));
            $this->table->set_empty("&nbsp;");	
			$this->table->set_heading(
				array('data' => 'Nama/Kode Prodi &nbsp; '.$btn_bid_root,'colspan' => '7'),
				array('data' => 'Aksi','class' => 'text-center','colspan' => 4));
	    
				$r = 0;
				foreach ($root_bid->result() as $row) {
					$cell = array();
					
					// -- Tombol Urut -- 
		
					$btn_down = ($r+1 < $root_bid->num_rows()) ? anchor($this->dir.'/Bidang/urutkan/'.in_de(array('unit' => $row->id_unit,'id1' => $row->id_bidang,'no1' => $row->urut,'id2' => $awal[$r+1][0],'no2' =>  $awal[$r+1][1])),'<i class="fa fa-arrow-down"></i>','class="btn btn-xs btn-info"') : '';
					$btn_up = ($r > 0) ? anchor($this->dir.'/Bidang/urutkan/'.in_de(array('unit' => $row->id_unit,'id2' => $row->id_bidang,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[$r+1][0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[$r+1][1])),'<i class="fa fa-arrow-up"></i>','class="btn btn-xs btn-info"') : '';
					$urutkan = array($row->id_bidang,$row->urut);
					$cell_aksi = array(array('class' => 'text-center no-wrap','width' => '80','data' => $btn_down.$btn_up));
					
					$cell_aksi[] = array('class' => 'text-center','width' => '40','data' => '
						<a href="#" title="Ubah" class="btn-edit btn btn-xs btn-warning" act="'.site_url($this->dir.'/Bidang/add_bidang/'.in_de(array('id' => $row->id_bidang,'id_unit' => $row->id_unit))).'"><i class="fa fa-pencil"></i></a> &nbsp;');
					
					$sub_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang', 'where' => array('id_par_bidang' => $row->id_bidang)));
					if ($sub_bid->num_rows() == 0)  {
						$cell_aksi[] = array('class' => 'text-center','width' => '35','data' => '<a href="#" title="Hapus" class="btn-delete btn btn-xs btn-danger" act="'.site_url($this->dir.'/Bidang/removing/'.in_de(array('id' => $row->id_bidang,'unit' => $row->id_unit))).'" msg="Apakah Bidang <b>'.$row->kode_bidang.' '.$row->nama_bidang.'</b> akan dihapus?"><i class="fa fa-trash"></i></a>');
					}

					
					$kode = !empty($row->kode_bidang)?'<b>'.$row->kode_bidang.'</b>':null;
					$nama = !empty($row->nama_bidang)?' '.$row->nama_bidang:null;
				
					$add_sub = array(
						'id_unit' => $row->id_unit,
						'id_par_bidang' => $row->id_bidang);
				
					$btn_tambah_sub = '<div class="btn-group">
						<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right">
						<li><a href="#" class="btn-edit" act="'.site_url($this->dir.'/Bidang/add_bidang/'.in_de($add_sub)).'"><i class="fa fa-plus-square-o"></i> Tambahkan Sub Prodi</a></li>
						<li><a href="#" act="'.site_url($this->dir.'/Bidang/pindah_bidang/'.in_de(array('id' => $row->id_bidang,'nama' => $row->nama_bidang))).'" class="btn-edit"><i class="fa fa-refresh fa-btn"></i> Pindahkan ke Unit Kerja</a></li></ul>
						</div>';
				
					$cell[] = array('data'=> $kode.$nama.' &nbsp; '.$btn_tambah_sub,'colspan'=> 7);

					$this->table->add_row(array_merge_recursive($cell,$cell_aksi));
					if ($sub_bid->num_rows() > 0) $this->tabel_sub(2,$row->id_bidang);
					$r += 1;
				}
				$data['tabel'] =  $this->table->generate();
			
		} else {
		
		$data['tabel'] =  '<div class="alert">Belum ada <strong>Prodi</strong> terdaftar </div>'.$btn_bid_root;
		
		}
		$data['extra_tombol'] = '<h4 class="box-title pull-right">'.$unit_data->unit.'</h4>';
		$data['tombol'] = anchor($this->dir.'/Bidang/list_unit/','<i class="fa fa-arrow-left"></i> Daftar Unit Kerja/SKPD','class="btn btn-default"');
		if ($this->session->flashdata('balik')) $data['tombol'].= ' &nbsp; '.anchor($this->dir.'/unit','<i class="fa fa-arrow-left"></i> Kembali Pindahkan Unit','class="btn btn-primary"');
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function pindah_bidang($p) {
		
		$o = un_de($p);
		
		$data['title'] = "Pindah Unor ke Unker";
		$data['form_link'] = $this->dir.'/Bidang/pindah';
		
		$data['form_data'] = form_hidden('id',$o['id']).
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
		$this->session->set_flashdata('ok','Prodi berhasil diubah ke Unit Kerja');
		
		redirect($this->dir.'/unit');
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
	
	function add_bidang($param) {
		
		$o = un_de($param);
		$data['title'] = (!empty($o['id'])) ? "Ubah" : "Tambah";
		$data['title'].= " Prodi";
		$def = !empty($o['id']) ? $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_bidang' => $o['id'])))->row():null;
		$form_par = null;
		
		if (!empty($o['id'])) {
		$cek = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_par_bidang' => $o['id']),'select' => 'count(*) as jml'))->row()->jml;
		if ($cek == 0) {
			$comb_unit = $this->general_model->combo_box(array('tabel' => 'ref_unit','order' => 'unit','key' => 'id_unit','val' => array('unit')));
			$form_par = '<p>'.form_label('Unit Kerja').form_dropdown('id_unit',$comb_unit,$o['id_unit'],'class="combo-box" style="width: 100%"').'</p>';
		} else {
			$form_par = form_hidden('id_unit',$o['id_unit']);
		}
		} else $form_par = form_hidden('id_unit',$o['id_unit']);
		
		
		if (!empty($o['id_par_bidang'])) {

			if (empty($o['id'])) {
				
				$par =  $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_bidang' => $o['id_par_bidang'])))->row();
				$form_par.= form_hidden('id_par_bidang',$o['id_par_bidang']).form_label('Atasan').form_input('',$par->kode_bidang.' '.$par->nama_bidang,'readonly="readonly" class="form-control"');
				
			} else {

				$this->dump_unit = array();
				$this->get_sub($o['id_unit'],$o['id']);
				
				$form_par.= form_label('Prodi di Atasnya').form_dropdown('id_par_bidang',$this->dump_unit,$o['id_par_bidang'],'class="combo-box form-control " style="width: 100%"');

			}
		
		} else {
			
			if (!empty($o['id'])) {
			
			$this->dump_unit = array();
			$this->get_sub($o['id_unit'],$o['id']);
				
			$form_par.= form_label('Prodi di Atasnya').form_dropdown('id_par_bidang',$this->dump_unit,null,'class="combo-box form-control " style="width: 100%"');
			}
		}
		
		$data['form_link'] = $this->dir.'/Bidang/saving';
		$data['form_data'] =
			@$form_par.
			form_hidden('id_bidang',@$def->id_bidang).
			'<p>'.form_label('Kode').form_input('kode_bidang',@$def->kode_bidang,'class="form-control"').'</p>'.
			'<p>'.form_label('Nama Prodi').form_input('nama_bidang',@$def->nama_bidang,'class="form-control" required').'</p>';
		
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
			'id_unit' =>  $id_unit
		);
		
		$par = $this->input->post('id_par_bidang');
		if (!empty($par)) $simpan['id_par_bidang'] = $par;
		if (empty($id)) {
			$whereis = (!empty($par)) ? array('id_unit = '.$id_unit.' AND id_par_bidang = '.$par => null) : array('id_unit = '.$id_unit.' AND id_par_bidang IS NULL' => null); 
			$num = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => $whereis,'select' => 'MAX(urut) as urutan'))->row();
			$simpan['urut'] = ($num->urutan+1);
		}
		
		$this->general_model->save_data('ref_bidang',$simpan,'id_bidang',$id);
		
		$this->urut_nomor(in_de(array('id_unit' => $id_unit,'par' => $par)));
		
		$this->session->set_flashdata('ok', 'Data berhasil disimpan');
		redirect($this->dir.'/Bidang/tabel_bidang/'.in_de(array('id' => $id_unit)));
		
	}
	
	function removing($par){
	
		$o = un_de($par);
		$this->general_model->delete_data('ref_bidang','id_bidang',$o['id']);
		$this->session->set_flashdata('ok', 'Prodi berhasil dihapus');
		redirect($this->dir.'/Bidang/tabel_bidang/'.in_de(array('id' => $o['unit'])));
		
	}
	
	function urutkan($par) {
		$o = un_de($par);
		$this->general_model->save_data('ref_bidang',array('urut' => $o['no2']),'id_bidang',$o['id1']);
		$this->general_model->save_data('ref_bidang',array('urut' => $o['no1']),'id_bidang',$o['id2']);
		redirect($this->dir.'/Bidang/tabel_bidang/'.in_de(array('id' => $o['unit'])));
	}
}