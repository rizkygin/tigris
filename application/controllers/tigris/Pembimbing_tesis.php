<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembimbing_tesis extends CI_Controller{
    var $dir = 'tigris/Pembimbing_tesis';
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
    public function index() {
		$this->list_data();
	}

    public function list_data($search=NULL, $offset=NULL,$periode=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Pembimbing Tesis');

		$offset = !empty($offset) ? $offset : null;
		if($periode == NULL){
			$periode = $this->input->post('periode_pu');
		}
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'judul_tesis' 		=> $search_key,
			);
			$data['for_search'] = @$fcari['judul_tesis'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = @$fcari['judul_tesis'];
		}

		$from = array(
			'peg_pegawai dosen_pembimbing' => '',
		);
		$select = '';
		if ($this->general_model->check_role($this->session->userdata('id_pegawai'),"mhs")){
				$where = array('a.id_mahasiswa'=>$this->session->userdata('id_pegawai'));

		}else{
			$where = array(
                'id_tipe' => 2,
            );
		}
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' =>$from, 'select'=>'*','search' => $fcari,'offset'=>$offs,'select'=>$select,'where'=>$where))->num_rows();
		$this->pagination->initialize($config);
		// $data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrab(array('tabel'=>$from,'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where));

        // cek($this->db->last_query());

		//milih periode
		if(!empty($periode)){
			$btn_tambah ='';

			if ($dtjnsoutput->num_rows() > 0) {
				// cek("data tidak kosong");
				$heads = array('No','Pembimbing','Mahasiswa','NIM','Kelas','Tesis');
	
	
				$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
				$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
				$this->table->set_heading($heads);
	
				$m = 0;
				$no = 1+$offs;
				$id_dosen_pembimbing = 0;
				foreach ($dtjnsoutput->result() as $row) {
	
					$rows = array();
	
					$warna = 'background-color:#FFFFD1;color:#605A01;';
					$mahasiswas = $this->general_model->datagrabs([
						'tabel' => [
						  'mhs_pembimbing a' => '',
						  'peg_pegawai mahasiswa' => 'a.id_mahasiswa = mahasiswa.id_pegawai'
						],
						'where' => [
							'a.id_pembimbing' => $row->id_pegawai,
							'tipe' => 0,
							'a.id_periode_pu' => $periode
						]
					]);
					// var_dump($this->db->last_query());
					// die();
					if($mahasiswas->num_rows() > 0){
		
						if($id_dosen_pembimbing != $row->id_pegawai){
							$rows[] = 	array(
							'data'=>$no,
							'style'=>''.$warna.';text-align:center',
							'rowspan' => $mahasiswas->num_rows()
							);
		
							$rows[] = array(
								'data' => $row->nama,
								'style'=>$warna,
								'rowspan' => $mahasiswas->num_rows()
							);
							$id_dosen_pembimbing = $row->id_pegawai;
						}
						foreach ($mahasiswas->result() as $mahasiswa) {
							// $this->table->add_row($rows);
		
							$data_mahasiswa = $this->general_model->datagrabs([
								'tabel' => [
									'peg_pegawai mahasiswa' => '',
									'ref_program_konsentrasi kelas' => 'mahasiswa.id_konsentrasi = kelas.id_ref_program_konsentrasi'
								],
								'where' => [
									'mahasiswa.id_pegawai' => $mahasiswa->id_mahasiswa
								]
							]);
							// cek($this->db->last_query());
							$rows[] = array(
							'data' => $data_mahasiswa->row('nama'),
							);
							$rows[] = array(
							'data' => $data_mahasiswa->row('username'),
							);
							$rows[] = array(
								'data' => $data_mahasiswa->row('nama_program_konsentrasi'),
							);
							$judul = $this->general_model->datagrabs([
							'tabel' => [
								'mhs_pembimbing a' => '',
								'peg_pegawai mahasiswa' => 'a.id_mahasiswa = mahasiswa.id_pegawai',
								'pengajuan_judul judul' => 'a.id_pengajuan_judul = judul.id_pengajuan_judul'
							],
							'where' => [
								'a.id_pembimbing' => $row->id_pegawai,
								'a.id_mhs_pembimbing' => $mahasiswa->id_mhs_pembimbing
							]
							])->row('judul_tesis');
							$rows[] = array(
								'data' => $judul,
							);
							$this->table->add_row($rows);
							$rows = [];
		
						}
						$no++;
						$m += 1;
					}
				}
				$tabel = $this->table->generate();
				// $data['content'] = $tabel;
				// cek($tabel);
			}else{
				$tabel = '<div class="alert">Data masih kosong ...</div>';
			}
			$btn_cetak =
				'<div class="btn-group" style="margin-left: 5px;">
				<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
				<i class="fa fa-print"></i> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu pull-right">
				<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/cetak/'.$periode,'<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
				<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/excel/'.$periode,'<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
				</ul>
				</div>';

			$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		}else{
			$cb_periode_pu = $this->general_model->combo_box(
				array(
				'tabel'=>[
					'periode_pu pu' => '',
					'ref_semester semester' => 'pu.id_ref_semester = semester.id_ref_semester'
				],
				'key'=>'id_periode_pu',
				'val'=>array(
					'bulan',
					'nama_semester'
				)
			));

			$data['tombol'] = 
			form_open($this->dir.'/list_data','id="form_pilih"').
				form_dropdown('periode_pu', $cb_periode_pu,'','id="periode_pu" class="form-control combo-box" style="width: 100%"').
			form_close();
			$data['script'] = '
			$(document).ready(function() {
				$("select").select2();
				$("#periode_pu").change(function() {
					$("#form_pilih").submit();
					console.log("fuck-you");
				});

			});
			';
			$tabel = '<div class="alert">Pilih Periode</div>';
		}
		
		$id_pegawai = $this->session->userdata('id_pegawai');

		
		$title = 'Rekapan Dosen Pembimbing Tesis';

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
			$data['tabel'] = @$tabel;
			$data['content'] = 'umum/standard_view';
			$this->load->view('home', $data);
		}
	}
}
?>
