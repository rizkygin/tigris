<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Judul extends CI_Controller {
	var $dir = 'tigris/Judul';
	function __construct() {
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
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
		$data['breadcrumb'] = array($this->dir => 'Pengajuan Judul');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		// cek($search_key);
		if (!empty($search_key)) {
			$fcari = array(
				'judul_tesis' 		=> $search_key,
				'nama_program_konsentrasi' 		=> $search_key,
				'nip' 		=> $search_key,
			);	
			// cek($fcari);
			$data['for_search'] = @$fcari['judul_tesis'];
			$data['for_search'] = @$fcari['nip'];
			$data['for_search'] = @$fcari['nama_program_konsentrasi'];
		}

		$from = array(
			'pengajuan_judul a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
			'ref_program_konsentrasi c' => array('c.id_ref_program_konsentrasi = b.id_konsentrasi','left')
		);
		$select = 'a.*,a.id_ref_program_konsentrasi as s,a.judul_tesis as xx,b.username,b.nama,b.nip,c.id_ref_program_konsentrasi as ss,c.nama_program_konsentrasi';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'));

		}else{
			$where = array(
				'status_n_pj' => null,
			);
		}
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrabs(array('tabel' =>$from, 'select'=>'*','search' => $fcari,'offset'=>$offs,'select'=>$select,'where'=>$where))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrabs(array('tabel'=>$from,'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where,'order'=>'a.id_pengajuan_judul DESC'));
		// cek($this->db->last_query());
		// die();


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Judul Tesis','Mahasiswa','Kelas','Ubah');

			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1+$offs;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				$from_pem = array(
					'mhs_pembimbing a' => '',
					'peg_pegawai d' => array('d.id_pegawai = a.id_pembimbing','left')
				);

				$pemb = $this->general_model->datagrab(array(
						'tabel' => $from_pem,
						'where' => array('a.id_pengajuan_judul' => $row->id_pengajuan_judul)));
				
				$nox=1;
				$bc=array();
				foreach ($pemb->result() as $xx) {
					$bc[]= 'Pembimbing '.@$nox.' : <p>'.@$xx->nama.'<p>';
					$nox++;
				}

				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Pengajuan Judul;*/
				$rows[] = 	$row->judul_tesis;
				$rows[] = 	$row->nama.' - '.$row->nip;
				$rows[] = 	$row->nama_program_konsentrasi;
                $ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_mahasiswa'=>$row->id_mahasiswa,'id_pengajuan_judul'=>$row->id_pengajuan_judul,'id_ref_semester'=>$row->id_ref_semester,'id_periode_pu'=>$row->id_periode_pu))),'<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-editx btn-flat" act="" title="Edit Data..."');
                $rows[] = $ubah;
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		$id_pegawai = $this->session->userdata('id_pegawai');

		$cek_pengajuan_judul = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_pj'=>1,'status_tesis'=>1,'status_n_pj'=>1)))->num_rows();
		$cek_pengajuan_judul2 = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai,'status_tesis'=>0)))->num_rows();
		$cek_pengajuan_judulx = $this->general_model->datagrab(array('tabel'=>'pengajuan_judul','where'=>array('id_mahasiswa'=>@$id_pegawai)))->num_rows();
		
		$cek_tanggal = $this->general_model->datagrab(array('tabel'=>'periode_pu',
			'where'=>array(
				'start_date <="'.date('Y-m-d').'"'=>null,
				'end_date >="'. date('Y-m-d').'"' => null
		)));
		// cek($this->db->last_query());
		
        $btn_tambah = anchor(site_url($this->dir.'/add_data/'.$cek_tanggal->row('id_periode_pu').'/'.$cek_tanggal->row('id_ref_semester')),'<i class="fa fa-plus fa-btn"></i> Tambah Pengajuan Judul', 'class="btn btn-success btn-editx btn-flat" act="" title="Klik untuk tambah data"');
		$data['extra_tombol'] = 
				form_open($this->dir.'/list_data','id="form_search" role="form"').
				'<div class="input-group">
				  	<input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
				  	<div class="input-group-btn">
						<button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
				  	</div>
				</div>'.
				form_close();

		$data['tombol'] = $btn_tambah;
		$title = 'Judul Tesis';
		
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
    public function add_data($param=NULL,$id_ref_semester=NULL){	
    	$o = un_de($param);
    	@$id= $o['id_pengajuan_judul'];
		// cek($id);
    	$id_periode_pu= $param;
    	$id_ref_semester= $id_ref_semester;

        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/judul/save_aksi'),

        'id_pengajuan_judul' => set_value('id_pengajuan_judul'),
		);
        $from = array(
			'pengajuan_judul a' => '',
			'ref_program_konsentrasi b' => array('a.id_ref_program_konsentrasi = b.id_ref_program_konsentrasi','left'),
			'peg_pegawai c' => array('c.id_pegawai = a.id_pembimbing_1','left'),
			'peg_pegawai d' => array('c.id_pegawai = a.id_pembimbing_2','left'),
			'ref_semester e' => array('a.id_ref_semester = e.id_ref_semester','left')
		);
		$data['title'] = (!empty($id)) ? 'Ubah Data Pengajuan Judul' : 'Pengajuan Judul Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'where' => array('a.id_pengajuan_judul' => $id)))->row() : null;
       
		$cb_tipe = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));

		$data['form_link'] = $this->dir.'/save_aksi/'.$id.'/'.$id_ref_semester.'/'.$id_periode_pu;
		$data['multi'] = 1;
		$data['dir'] = base_url($this->dir);
		$data['form_data'] = '';

		$data['form_data'] .= '<input type="hidden" name="id_pengajuan_judul" class="id_pengajuan_judul" value="'.$id .'"/>';
		if(!empty($id)){
			$data['id_mahasiswa'] = $dt->id_mahasiswa;
			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$dt->id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$dt->id_periode_pu .'"/>';
		}else{

			$data['form_data'] .= '<input type="hidden" name="id_ref_semester" class="id_ref_semester" value="'.$id_ref_semester .'"/>';
			$data['form_data'] .= '<input type="hidden" name="id_periode_pu" class="id_periode_pu" value="'.$id_periode_pu .'"/>';
		}
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-12">';

		$data['form_data'] .= '<div class="callout callout-info"><h5 style="font-style:italic">N O T E  : </h5>Upload Judul Mahasiswa dilakukan untuk mengajukan judul mahasiswa lewat akademik, Pastikan mahasiswa belum pernah mengajukan judul terlebih dahulu.</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
        $data['form_data'] .= '<p><label>NIM Mahasiswa</label>';
		$data['form_data'] .= '<select name = "id_mahasiswa" class="nim form-control" ></select>';

        // $data['form_data'] .= form_dropdown('nim','',@$dt->id_mahasiswa,'class="nim form_control" style="width:100%');
		
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div class="col-lg-6">';
		$data['form_data'] .= '<p><label>Judul Tesis</label>';
		$data['form_data'] .= form_textarea('judul_tesis', @$dt->judul_tesis,'class="form-control" placeholder="Judul Tesis" required id="judul_tesis"');
		
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
        
		$data['content'] = 'umum/pengajuan_judul_form_akademik';
		$this->load->view('home', $data);
    }
	function save_aksi(){
    	$id_ref_semester = $this->input->post('id_ref_semester');
    	$id_periode_pu = $this->input->post('id_periode_pu');
    	
		$berkas = $this->input->post('id_berkas');
		$link = $this->input->post('link');

		// $id_pegawai = $this->session->userdata('id_pegawai');
		$id_mahasiswa = $this->input->post('id_mahasiswa',true);

    	$id_pengajuan_judul = $this->input->post('id_pengajuan_judul');

    	$judul_tesis = $this->input->post('judul_tesis',TRUE);
		// cek($this->input->post());
		// die();
		if(empty($id_pengajuan_judul)){
			$id_prop = $this->general_model->save_data('pengajuan_judul',array(
				// 'id_mahasiswa' => $id_mahasiswa,
				'judul_tesis' => $judul_tesis,
				'id_ref_semester' => $id_ref_semester,
				'id_periode_pu' => $id_periode_pu,
				'status_proses' => 0,
				'id_mahasiswa' => $id_mahasiswa,
				'tgl_pj' => date('Y-m-d')));
			$this->session->set_flashdata('ok', 'Judul Tersimpan...');

		}else{
			$this->general_model->save_data([
				'tabel' => 'pengajuan_judul',
				'where' => [
					'id_pengajuan_judul' => $id_pengajuan_judul
				],
				'data' => [
					'judul_tesis' => $judul_tesis,
				]
			]);
			$this->session->set_flashdata('ok', 'Berhasil Merubah Judul...');

		}
    	
	                


		redirect($this->dir);

	}
    function nim($id_mahasiswa = null){
        // $mahasiswa = 
        $nim = $this->input->get('nim');
		
        $results = Array();
		if(!empty($id_mahasiswa)){
			$mahasiswa = $this->general_model->datagrabs([
				'tabel' => 'peg_pegawai',
				'where' => [
					'id_pegawai' => $id_mahasiswa
				]
			])->row();
			$results = [
				'id' => $mahasiswa->id_pegawai,
				'text' => $mahasiswa->username. ' - ' .$mahasiswa->nama
			]; 
			return die(json_encode(
				$results
			));

		}else{
			$nims = $this->general_model->datagrabs([
				'tabel' => 'peg_pegawai',
				'where' => [
					'id_tipe' => 1,
					'username LIKE "%'.$nim.'%"' => null
				]
			])->result();
			foreach($nims as $mahasiswa){
				$pernah_mengajukan_judul = 1;
				$pernah_mengajukan_judul = $this->general_model->datagrabs([
					'tabel' => 'pengajuan_judul',
					'where' => [
						'id_mahasiswa' => $mahasiswa->id_pegawai
					]
				])->row();
				if(!$pernah_mengajukan_judul){
					$results[] = [
						'id' => $mahasiswa->id_pegawai,
						'text' => $mahasiswa->username. ' - ' .$mahasiswa->nama
					]; 
				}
				
			}
			if(sizeof($results) == 0){
				$results[] = [
					'id' => null,
					'text' => 'Tidak menemukan mahasiswa'
				];
			}
			return die(json_encode([
				'results' => $results,
			]));
		}
        
    }
}