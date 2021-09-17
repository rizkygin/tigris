<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

include "excel_reader2.php";
Class Impd01 extends CI_Controller {
	var $dir = 'tigris/Impd01';

    function __construct(){
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
		// $this->load->library('OLERead');
    }
    function index(){
		$data['form_link'] = $this->dir.'/upload/';
        $data['content'] = 'umum/import_data_dosen';
		$this->load->view('home', $data);
    }
	function upload(){
		$target = basename($_FILES['db_impor']['name']) ;
		
		move_uploaded_file($_FILES['db_impor']['tmp_name'], $target);

		chmod($_FILES['db_impor']['name'],0777);

		// mengambil isi file xls
		$data = new Spreadsheet_Excel_Reader($_FILES['db_impor']['name'],false);
		// menghitung jumlah baris data yang ada
		// cek($data);
		
		$jumlah_baris = $data->rowcount($sheet_index=0);
		// cek($jumlah_baris);
		// unlink($_FILES['db_impor']['name']);

		// die();
		$berhasil = 0;
		for ($i=2; $i<=$jumlah_baris; $i++){
 
			// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
			$nama     = $data->val($i, 1);
			$nip   = $data->val($i, 2);
			$tipe_dosen = $data->val($i,3);

			if($this->validasi($nama,$nip,$tipe_dosen)){
				$tipe = $this->general_model->datagrabs([
					'tabel' => 'ref_tipe_dosen',
					'where' => [
						'tipe_dosen' => $tipe_dosen
					]
				])->row();
				$data_dosen[] = [ 
					'username' => $nip,
					'nip' => $nip,
					'nama' => $nama,
					'id_ref_tipe_dosen' => $tipe->id_ref_tipe_dosen,
					'id_tipe' => 2,
					'status' => 1,
					'status_aktif' => 1,
				];
				$berhasil++;
			}else{
				return redirect($this->dir); 
			}
			
		}

		// var_dump($data_dosen);
		// die();
		if($data_dosen > 0){
			foreach($data_dosen as $data) {
				$id = $this->general_model->save_data([
					'tabel'=> 'peg_pegawai',
					'data' => $data,
				]);
			}
			$this->session->set_flashdata('ok','Data Berhasil Disimpan');
		}else{
			$this->session->set_flashdata('fail','Tidak Menemukan Data Dosen');
		}
		
		unlink($_FILES['db_impor']['name']);

		return redirect($this->dir);
	}


	function validasi($nama,$nip,$tipe_dosen){
		$tipe = $this->general_model->datagrabs([
			'tabel' => 'ref_tipe_dosen',
			'where' => [
				'tipe_dosen' => $tipe_dosen
			]
		])->row();
		
		$username = $this->general_model->datagrabs([
			'tabel'=> 'peg_pegawai',
			'where' => [
				'username' => $nip
			]
		])->row();
		// var_dump($nama);
		// die();
		if($nama == null){
			$this->session->set_flashdata('fail','Data Bermasalah');
			// var_dump($nama);
			// die();
			return false;
		}
		if($nip == null){
			$this->session->set_flashdata('fail','Dosen dengan '. $nama . ' tidak mempunyai NIP');
			return false;

		}
		if($tipe_dosen == null){
			$this->session->set_flashdata('fail','Tipe Dosen dengan '. $nama . ' tidak bernilai');
			return false;
		}
		if($tipe == null){
			$this->session->set_flashdata('fail','Tidak Menemukan tipe dosen yang dimaksud ');
			return false;
		}
		if($username != null){
			$this->session->set_flashdata('fail','Nip '.$nip.' sudah dipakai ');
			return false;
		}
		return true;
	}
}
?>