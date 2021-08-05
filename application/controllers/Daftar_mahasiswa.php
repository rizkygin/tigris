<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_mahasiswa extends CI_Controller {

var $param = array(
			'aplikasi',
			'aplikasi_code',
			'aplikasi_s',
			'aplikasi_logo_ext',
			'aplikasi_logo_only',
			'aplikasi_logo',
			'pemerintah',
			'pemerintah_s',
			'pemerintah_logo',
			'pemerintah_logo_bw',
			'pemerintah_logo_ext',
			'ibukota',
			'alamat',
			'instansi',
			'instansi_s',
			'instansi_code',
			'copyright',
			'multi_unit',
			'theme_pinta',
			'theme_data',
			'main_color',
			'foto_latar_login');

	function __construct() {
	
		parent::__construct();
		$this->load->model('login_model');
		
	}
	
	public function index() {		
		$this->page();
	}
	
	
	function page() {
		$data['st'] = $this->general_model->get_param($this->param,2);
		$data['cb_tipe'] = $this->general_model->combo_box(array('tabel'=>'ref_program_konsentrasi','key'=>'id_ref_program_konsentrasi','val'=>array('nama_program_konsentrasi')));


		$data['title'] = 'Daftar Mahasiswa Online Tesis';
		$this->load->view('login_mahasiswa/daftar_mhs',$data);
	}


	function simpan_data(){

		$nama = $this->input->post('nama');
		$username = $this->input->post('username');
		$id_ref_program_konsentrasi = $this->input->post('id_ref_program_konsentrasi');

		$s = array(
			'username' => $username,
			'nip' => $this->input->post('username'),
			'nama' => $this->input->post('nama'),
			'id_program_studi' => $this->input->post('id_ref_program_konsentrasi'),
			'id_tipe' => 1
		);
		$cek_datamahasiswa = $this->general_model->datagrab(array(
					'tabel' => 'peg_pegawai',
					'where' => array('nip' => $username)));


		if($cek_datamahasiswa->num_rows() > 0){
			$kembali = '
                    <a href="'.base_url('Login_mahasiswa').'" class="btn btn-success btn-xs btn-lgn pull-right">Ke Halaman Login</a>';
			$this->session->set_flashdata('fail','NIM sudah tersedia!!!, silahakan login dengan akun '.$username.' '.$kembali);
			redirect('Daftar_mahasiswa');
		}else{
			$s['password'] = md5($username);
			$id_peg = $this->general_model->save_data('peg_pegawai',$s);
			$this->general_model->save_data('pegawai_role',array('id_role' => 9,'id_pegawai' => $id_peg));

			$stat = '<br>Password sesuai dengan NIM';
			$this->session->set_flashdata('ok','Tambah'.' Mahasiswa berhasil dilakukan'.$stat);
			redirect('Login_mahasiswa');
		}
			
		
	}


	
}
