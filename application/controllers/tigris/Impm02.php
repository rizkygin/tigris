<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

include "excel_reader2.php";
Class Impm02 extends CI_Controller {
	var $dir = 'tigris/Impm02';

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
        $data['content'] = 'umum/import_data_mahasiswa';
		$this->load->view('home', $data);
    }
	function upload(){
		$target = basename($_FILES['db_impor']['name']) ;
		// cek($_FILES);
		// die();
		move_uploaded_file($_FILES['db_impor']['tmp_name'], $target);

		// beri permisi agar file xls dapat di baca
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
			$tahun   = $data->val($i, 2);
			$nim  = $data->val($i, 3);
			$kelas = $data->val($i,4);

			if($this->validasi($nama,$tahun,$nim,$kelas)){
				$id_ref_tahun = $this->general_model->datagrabs([
					'tabel' => 'ref_tahun',
					'where' => [
						'nama_tahun' => $tahun
					]
				])->row();
				$ref_kelas = $this->general_model->datagrabs([
					'tabel' => 'ref_program_konsentrasi',
					'where' => [
						'nama_program_konsentrasi' => $kelas,
					]
				])->row();

				$data_mahasiswa[] = [ 
					'nama' => $nama,
					'username' => $nim,
					'nip' => $nim,
					'id_ref_tahun' => $id_ref_tahun->id_ref_tahun,
					'id_konsentrasi' => $ref_kelas->id_ref_program_konsentrasi,
					'id_program_studi' => '1',
					'password' => md5($nim),
					'id_tipe' => 1,
					'status_aktif' => 1,
					'status' => 1
				];
				$berhasil++;
			}else{
				return redirect($this->dir); 
			}
			
		}
		if($data_mahasiswa > 0){
			foreach($data_mahasiswa as $data) {
				$id = $this->general_model->save_data([
					'tabel'=> 'peg_pegawai',
					'data' => $data,
				]);
				$this->general_model->save_data('pegawai_role',array('id_role' => 9,'id_pegawai' => $id));

			}
			$this->session->set_flashdata('ok','Data Berhasil Disimpan');
		}else{
			$this->session->set_flashdata('fail','Tidak Menemukan Data Mahasiswa');
		}
		
		unlink($_FILES['db_impor']['name']);

		redirect($this->dir);
	}
	function validasi ($nama, $tahun, $nim, $kelas){
		$id_ref_tahun = $this->general_model->datagrabs([
			'tabel' => 'ref_tahun',
			'where' => [
				'nama_tahun' => $tahun
			]
		])->row();

		if(@$id_ref_tahun->id_ref_tahun == null){
			$this->session->set_flashdata('fail','Tahun Tidak Dikenali');
			return  false;
			
		}
		if(@$nama == null){
			$this->session->set_flashdata('fail','Data Bermasalah');
			return false;
		}
		if(@$nim == null){
			$this->session->set_flashdata('fail',$nama.' Tidak mempunyai Nim');
			return false;
		}
		if($nim != null){
			$cek_nim = $this->general_model->datagrabs([
				'tabel' => 'peg_pegawai',
				'where' => [
					'id_tipe' => 1,
					'username' => $nim
				]
			])->row();
			// var_dump($cek_nim);
			// die();
			if($cek_nim != null){
				$this->session->set_flashdata('fail',$nama.' Nim Sama !');
				return false;
			}
		}
		if(@$kelas == null){
			$this->session->set_flashdata('fail',$nama.' Tidak mempunyai Kelas');
			return false;
		}
		if(@$kelas != null){
			$ref_kelas = $this->general_model->datagrabs([
				'tabel' => 'ref_program_konsentrasi',
				'where' => [
					'nama_program_konsentrasi' => $kelas,
				]
			])->row();
			if($ref_kelas == null){
				$this->session->set_flashdata('fail','Kelas '.$nama.' Tidak valid');
				return false;
			}
		}
		return true;
	}
}
?>