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

        function index(){
            $data['title'] = 'Kop Surat';
            // $data['title'] = (!empty($code)) ? 'Ubah Kop surat' : 'Kelas Baru';
            // $dt = !empty($id) ?  $this->general_model->datagrab(array(
            //             'tabel' => $from,
            //             'where' => array('a.id_ref_program_konsentrasi' => $id)))->row() : null;

			$data['multi'] = 1;
            $data['form_link'] = $this->dir.'/save_aksi/';
            $data['form_data'] = '';
            // $data['form_data'] .= '<input type="hidden" name="id_ref_program_konsentrasi" class="id_ref_program_konsentrasi" value="2"/>';
            $data['form_data'] .= '<div class="row">';
            $data['form_data'] .= '<div class="col-lg-6">';
                // $data['form_data'] .= '<p><label>Kop Surat</label>';
                $data['form_data'] .= '<p ><img id="kops" style="width:768px; height:128px;" src="'.base_url().'assets/images/corp/header.png"/></p>';
                $data['form_data'] .= form_upload('kop','','class="form-control" placeholder="Nilai" id="kop"');
                $data['form_data'] .= '</div>';
            $data['form_data'] .= '</div>';
            $data['form_data'] .= '<div style="clear:both;"></div>';
            // $this->load->view('umum/form_view', $data);
			$data['content'] = 'umum/form_view';
            $data['script'] = 'function display(input) {
               
                if (input.files && input.files[0]) {
                   var reader = new FileReader();
                   reader.onload = function(event) {
                      $(`#kops`).attr(`src`, event.target.result);
                   }
                   reader.readAsDataURL(input.files[0]);
                }
             }
               
             
             $("#kop").change(function() {
                display(this);
                
             });';
			// $data['title'] 		= $title;


			$this->load->view('home', $data);

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