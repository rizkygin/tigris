<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Class Ref_kop_surat extends CI_Controller{
        var $dir = 'tigris/Ref_kop_surat';
        function __construct() {
            parent::__construct();
            $this->load->helper('cmd');
            if (not_login(uri_string()))redirect('login');
            date_default_timezone_set('Asia/Jakarta');
           
        }


        function save_aksi(){
            $in = $this->input->post();
            $config = array(
                'allowed_types' => 'png',
                'upload_path' => 'assets/images/corp',
                'max_size' => 0,
                'overwrite' => TRUE,
                'width' => '768',
                'height' => '128',
                'file_name' => 'header.png'
            );
            
            $this->load->library('upload');
            // $CI->load->helper('file');
            $this->upload->initialize($config);
            if($this->upload->do_upload('kop')){
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            }else{
				$this->session->set_flashdata('fail', $this->upload->display_errors);
                
            }
            redirect($this->dir);


        }
    }
?>