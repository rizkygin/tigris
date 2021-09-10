<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');    

Class Rentang_waktu extends CI_Controller{
    var $dir = 'tigris/Rentang_waktu';

    function __construct() {
        
        parent::__construct();
        $this->load->helper('cmd');
        if (not_login(uri_string()))redirect('login');
        date_default_timezone_set('Asia/Jakarta');
        $this->db->query('SET SESSION sql_mode =
		                  REPLACE(REPLACE(REPLACE(
		                  @@sql_mode,
		                  "ONLY_FULL_GROUP_BY,", ""),
		                  ",ONLY_FULL_GROUP_BY", ""),
		                  "ONLY_FULL_GROUP_BY", "")');
    }
    function index(){
        // $data['breadcrumb'] = array($this->dir => 'Rentang Waktu');
		$title = 'Rentang Waktu Mahasiswa Mendaftar Ujian';

        $data['multi'] = 1;
		$data['form_link'] = $this->dir.'/save_aksi/';
        $data['title'] 		= $title;

        $data['form_data'] = '';
        
        $rentang = $this->general_model->datagrabs([
            'tabel' => 'ref_rentang',
            'where' => [
                'id' => 1
            ]
        ])->row()->rentang;
			$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
        $data['form_data'] .= '<p><label>Rentang Dalam Bentuk Hari</label>';

        $data['form_data'] .= form_input('rentang', $rentang, 'class="form-control" style="width: 100%"');
    
        $data['form_data'] .= '</div>';
        $data['form_data'] .= '</div>';

		$data['form_data'] .= '<div style="clear:both;"></div>';

        $data['content'] = 'umum/form_view';

        $this->load->view('home', $data);

    }

    function save_aksi(){
        $in = $this->input->post('rentang');
        // $in['rentang'] = strval($in['rentang']);
        $data = [
            'rentang' => $in
        ];
        $this->general_model->save_data('ref_rentang',$data,'id',1);

        $this->session->set_flashdata('ok', 'Berhasil Disimpan!');
            redirect($this->dir);
    }
}

?>