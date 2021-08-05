<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teks extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
		$this->in_app = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row()->nama_aplikasi;
	}

	public function index() {

		$this->load_list();
	
	}
	
	function set_param() {
		
		$e = $this->general_model->get_param('tv_marquee');
		if ($e == NULL) $this->general_model->save_data('parameter',array('param' => 'tv_marquee','val' => 1));
		else $this->general_model->save_data('parameter',array('param' => 'tv_marquee','val' => 1),'param','tv_marquee');
		
	}
	
	
	function cr($e) {
	    return $this->general_model->check_role($this->session->userdata('id_pegawai'),$e);
    }
	
	function load_list($search = null, $offset = null) {
		
		$data['breadcrumb'] = array('' => $this->in_app,'tigris/Teks' => 'Teks Bergerak');
		
		$offset = !empty($offset) ? $offset : null;
		
		$key = $this->input->post('search');
		$se = array();
		
		if (!empty($key)) {
			$se['teks'] = $key;
		} else if ($search) {
			$o = un_de($search);
			$se['teks'] = @$o['teks'];
		} 
		
		$config['base_url']	= site_url('tigris/Teks/list_data/'.in_de($se));
		$config['total_rows'] = $this->general_model->datagrab(array(
			'tabel'=> 'teks',
			'search' => $se))->num_rows();
		$config['per_page']	= '10';
		$config['uri_segment'] = '5';
		
		$this->pagination->initialize($config);
		
		$data['links']	= $this->pagination->create_links();
		
		$offs = (!in_array($offset,array("cetak","excel"))) ?  $offset : null;
		$lim = (!in_array($offset,array("cetak","excel"))) ? $config['per_page'] : null;
		
		$query = $this->general_model->datagrab(array(
			'tabel' => array(
				'teks t' => '',
				'peg_pegawai p' => array('p.id_pegawai = t.id_pegawai','left')),
			'offset' => $offs,
			'limit' => '10',
			'order' => 'teks',
			'select' => 't.*,p.nama',
			'search' => $se
		));
		

		if ($query->num_rows() != 0) {
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$heads = array('No');
			if (!in_array($offset,array('cetak','excel')) and !$this->cr('DMKPE'));
			$heads = array_merge_recursive($heads,array('Teks Bergerak'));
			if (!in_array($offset,array('cetak','excel'))) $heads[] = array('data' => 'Aksi','colspan' => '3');
			$this->table->set_heading($heads);
		
			$no = (int) $offset + 1;
			foreach($query->result() as $row){
				$rows = array($no);
				/*($row->aktif == 1) ? 
				$rows[] = anchor(site_url('tigris/Teks/tidak_aktif/'.$row->id_teks),'<i class="fa fa-toggle-on"></i>','class="btn btn-xs btn-danger"')
				:
				$rows[] = anchor(site_url('tigris/Teks/aktif/'.$row->id_teks),'<i class="fa fa-toggle-off"></i>','class="btn btn-xs btn-default"')
				;*/
				$rows[] = $row->teks;
			
				if (!in_array($offset,array('cetak','excel'))) {
					$rows[] = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-warning btn-edit" act="'.site_url('tigris/Teks/form_data/'.$row->id_teks).'"');
					$rows[] = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger btn-delete" act="'.site_url('tigris/Teks/delete_data/'.$row->id_teks).'" msg="Apakah Anda ingin menghapus data ini?"');
				}
				
				$this->table->add_row($rows);
				$no++;
			}
	
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Belum ada teks bergerak ...</div>';
		}
		
		
		$btn_cetak = ($query->num_rows() > 0) ?
		'<div class="btn-group"  tyle="margin-left: 5px;">
		<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
		<i class="fa fa-print"></i> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu pull-right">
		<li>'.anchor('tigris/Teks/load_list/'.in_de($se).'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
		<li>'.anchor('tigris/Teks/load_list/'.in_de($se).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
		</ul>
		</div>' : null;
		
		$data['total'] = $config['total_rows'];
		$data['tombol'] = anchor('#','<i class="fa fa-plus fa-btn"></i> Teks Bergerak','class="btn-edit btn btn-success" act="'.site_url('tigris/Teks/form_data').'"').$btn_cetak;
		
		$data['extra_tombol'] = 
		form_open('tigris/teks','id="form_search"').
		'<div class="input-group">
                  <input name="search" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.(!empty($key)?$key:(!empty($o['arsip_jenis'])?$o['arsip_jenis']:null)).'">
                  <div class="input-group-btn">
                    <button class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>'.form_close();

		$data['tabel']	= $tabel;
	
		if ($offset == "cetak") {
			$data['title'] = '<h3>Teks Bergerak</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/print',$data);
		} else if ($offset == "excel") {
			$data['file_name'] = str_replace(" ","_",strtolower('teks_bergerak')).'.xls';
			$data['title'] = '<h3>Teks Bergerak</h3>';
			$data['content'] = $tabel;
			$this->load->view('umum/excel',$data);
		} else {
			$data['tabel'] = $tabel;
			$data['title'] = 'Teks Bergerak';
			$data['content'] = "umum/standard_view";
			$this->load->view('home', $data);
		}
	}

	function form_data($id = null) {
		
		$data['title'] = !empty($id) ? 'Ubah Teks Bergerak' : 'Tambah Teks Bergerak';
		$data['form_link'] = 'tigris/Teks/save_data';
		$def = !empty($id) ? $this->general_model->datagrab(array('tabel' => 'teks','where' => array('id_teks' => $id)))->row() : null;
		
		$data['form_data'] = 
			form_hidden('id_teks',@$def->id_teks).
			form_hidden('id_pegawai',$this->session->userdata('id_pegawai')).'
			<p>'.form_label('Teks Bergerak').form_textarea('teks',@$def->teks,'class="form-control" placeholder="Isi Teks Bergerak" style="height: 60px"').'<p>';
			
		
		$this->load->view('umum/form_view',$data);
	}
	
	
	function aktif($id_teks = null) {
		$param_status = array(
					'tabel'=>'teks',
					'data'=>array(
						'aktif'=>1
						),
					'where'=>array('id_teks'=>$id_teks)
					);
				$update_status=$this->general_model->save_data($param_status);
		
		$this->session->set_flashdata('ok','Data berhasil disimpan');
		redirect('tigris/teks');
		
	}
	function tidak_aktif($id_teks = null) {
		$param_status = array(
					'tabel'=>'teks',
					'data'=>array(
						'aktif'=>0
						),
					'where'=>array('id_teks'=>$id_teks)
					);
				$update_status=$this->general_model->save_data($param_status);
		
		$this->session->set_flashdata('ok','Data berhasil disimpan');
		redirect('tigris/teks');
		
	}
			
	function save_data() {
		
		$id = $this->input->post('id_teks');
		$simpan = array(
			'id_pegawai' => $this->input->post('id_pegawai'),
			'teks' => $this->input->post('teks')
		);
		
		if (empty($id)) {
			$u = $this->general_model->datagrab(array(
				'tabel' => 'teks',
				'select' => 'max(urut) as urut_nav',
				'where' => $where_urut
			))->row();
			
			$simpan['urut'] = $u->urut_nav+1;
		}
		
		$this->general_model->save_data('teks',$simpan,'id_teks',$id);
		
		$this->set_param();
		
		$this->session->set_flashdata('ok','Teks Bergerak berhasil disimpan ...');
		redirect('tigris/Teks');
		
	}
	
	function delete_data($e) {
		
		$this->general_model->delete_data('teks','id_teks',$e);
		$e = $this->general_model->datagrab(array(
			'tabel' => 'teks',
			'order' => 'urut'
		));
		$no = 1;
		foreach($e->result() as $a) {
			$this->general_model->save_data('teks',array('urut' => $no),'id_teks',$a->id_teks);
			$no+=1;
		}
		
		$this->set_param();
		
		$this->session->set_flashdata('ok','Teks bergerak berhasil dihapus ...');
		redirect('tigris/Teks');
		
	}

}
?>