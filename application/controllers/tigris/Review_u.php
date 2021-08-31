<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');    

Class Review_u extends CI_Controller{
    var $dir = 'tigris/Review_u';

    function __construct() {
        parent::__construct();
        $this->load->helper('cmd');
        if (not_login(uri_string()))redirect('login');
        date_default_timezone_set('Asia/Jakarta');
       
    }
    function index(){
        $this->list_data();
    }
    public function list_data($search=NULL, $offset=NULL) {
		$data['breadcrumb'] = array($this->dir => 'Review Ujian');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		$id_pegawai = $this->session->userdata('id_pegawai');

        // cek($search_key);
		if (!empty($search_key)) {
			$fcari = array(
				'nama' 		=> $search_key,
				'nama_program_konsentrasi' 		=> $search_key,
				'review_file' 		=> $search_key,
			);	
			$data['for_search'] = @$fcari['nama'];
			$data['for_search'] = @$fcari['nama_program_konsentrasi'];
			$data['for_search'] = @$fcari['review_file'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = @$fcari['nama'];
			$data['for_search'] = @$fcari['nama_program_konsentrasi'];
			$data['for_search'] = @$fcari['review_file'];
		}

        $tipe_user = $this->general_model->datagrabs([
            'tabel' => 'peg_pegawai',
            'where' => [
                'id_pegawai' => $id_pegawai,
            ]
        ])->row();

        $from = array(
			'review_ujian a' => '',
			'peg_pegawai b' => array('b.id_pegawai = a.id_mahasiswa','left'),
            'ref_unit bb' => array('b.id_unit = b.id_unit','left'),
			'ref_bidang c' => array('b.id_bidang = c.id_bidang','left'),
			'ref_program_konsentrasi d' => array('b.id_program_studi = d.id_ref_program_konsentrasi','left'),
			'ref_tahun e' => array('b.id_ref_tahun = e.id_ref_tahun','left'),
			'ref_semester f' => array('b.id_ref_semester = f.id_ref_semester','left'),
			'ref_prodi prodi' => array('b.id_program_studi = prodi.id_ref_prodi', 'left')
		);
		$select  = [
            'a.*',
			'b.*',
			'nama_semester',
			'nama_tahun',
			'prodi.nama_prodi',
            'nama_program_konsentrasi',
		];
        $where = array('b.id_tipe'=>1);

		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;

        
		$btn_cetak =
        '<div class="btn-group" style="margin-left: 5px;">
            <a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
                <i class="fa fa-print"></i> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
                <li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
            </ul>
        </div>';
        $data['extra_tombol'] = 
            form_open($this->dir.'/list_data','id="form_search" role="form"').
            '<div class="input-group">
                  <input name="key" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$search_key.'">
                  <div class="input-group-btn">
                    <button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
                  </div>
            </div>'.
            form_close();
    
        //Jika yang login mahasiswa
        if($tipe_user->id_tipe == 1){
            $id_mahasiswa = $this->session->userdata('id_pegawai');
            $cek_propsal = $this->general_model->datagrabs([
                'tabel' => 'review_ujian',
                'where' => [
                    'id_mahasiswa' => $id_mahasiswa,
                    'jenis_review' => 1
                ]
            ])->num_rows();
            $cek_ujian = $this->general_model->datagrabs([
                'tabel' => 'review_ujian',
                'where' => [
                    'id_mahasiswa' => $id_mahasiswa,
                    'jenis_review' => 2
                ]
            ])->num_rows();
            if($cek_ujian == 0 || $cek_propsal == 0){
                $btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Data Review Ujian', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/').'" title="Klik untuk tambah data"');
            }
		    $data['tombol'] = @$btn_tambah .' '. $btn_cetak;
            $where = array('b.id_tipe'=>1 ,'a.id_mahasiswa' => $id_pegawai);

		    $dtjnsoutput = $this->general_model->datagrabs(array('tabel'=>$from,'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where,'order'=>'a.tgl_upload DESC'));
        }else{
		    $data['tombol'] = $btn_cetak;
    		$dtjnsoutput = $this->general_model->datagrabs(array('tabel'=>$from,'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari,'select'=>$select,'where'=>$where,'order'=>'a.tgl_upload DESC'));
            // cek($this->db->last_query());


        }
		


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' =>$from, 'select'=>'*','search' => $fcari,'offset'=>$offs,'select'=>$select,'where'=>$where))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();



        // var_dump($dtjnsoutput->result());
		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Mahasiswa','Nomor Induk Mahasiswa','Program Konsentrasi','Jenis Review','Berkas','Tanggal Upload');

			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1+$offs;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();

				// $from_pp = anchor(site_url($this->dir.'/form_pengesahan/'.in_de(array('id_pengajuan_judul'=>@$row->id_pengajuan_judul,'id_mahasiswa'=>$row->id_mahasiswa))),'<i class="fa fa-file-pdf-o"></i>', 'class="btn btn-xs btn-success btn-flat" act=" title="berita acara..." target="_blank"');

				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Pengajuan Judul;*/
				$rows[] = 	$row->nama;
				$rows[] = 	$row->nip;
				$rows[] = 	$row->nama_program_konsentrasi;
                // jika jenis review == 1 -> maka proposal tesis, dan jika jenis review == 2-> maka ujian tesis
                $file = '';
                if($row->jenis_review == 1){
                    $rows[] = 'Proposal Tesis';
				    $file = '<a href="'.base_url('/uploads/ujian_proposal_tesis/'.$row->review_file).'" class="fancybox" target="_blank">'.$row->review_file.'</a> ';
                    
                }else if ($row->jenis_review == 2){
                    $rows[] = 'Ujian Tesis';
				    $file = '<a href="'.base_url('/uploads/ujian_tesis/'.$row->review_file).'" class="fancybox" target="_blank">'.$row->review_file.'</a> ';

                }
                if($tipe_user->id_tipe == 1){
    				$ubah = '<a href="#" act="'.site_url($this->dir.'/add_data/'.in_de($row->id_review)).'" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>';
                    $rows[] = $file. ' '. $ubah;

                }else{
                    $rows[] = $file;

                }
                
                if($tipe_user->id_tipe != 1){
                    $ubah = '';
                    if($row->tgl_edit == null){
                        $rows[] = @$row->tgl_upload;
    
                    }else{
                        $rows[] = '<span style ="color:orange";>'.@$row->tgl_edit.'</span><sub style="margin-left:5px; color:grey; opacity: 0.4; text-decoration: underline grey;">diubah</sub>';
                        
                    }
                }else if($tipe_user->id_tipe == 1){
    				$ubah = '<a href="#" act="'.site_url($this->dir.'/add_data/'.in_de($row->id_review)).'" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i></a>';

                    if($row->tgl_edit == null){
                        $rows[] = @$row->tgl_upload;
    
                    }else{
                        $rows[] = @$row->tgl_edit;
                        
                    }
                }

                
                
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}

		// cek($cek_tanggal->row('start_date'));
		// cek($cek_tanggal->row('id_ref_semester'));
		// cek($cek_tanggal->row('id_periode_pu'));
		
		
		// cek($cek_tanggal->row('end_date'));
		// cek($cek_tanggal->row('id_ref_semester'));
		// cek($cek_tanggal->row('id_periode_pu'));
		// cek($cek_pengajuan_judul);
		// cek($cek_pengajuan_judul2);
		
		
		$title = 'Review Ujian Mahasiswa';
		
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

    public function add_data($param=NULL){
    	$o = un_de($param);
    	$id= @$o['id_review'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url($this->dir.'/save_aksi'),
		);
        $from = array(
			'review_ujian a' => ''
		);
        
        $id_mahasiswa = $this->session->userdata('id_pegawai');
        $cek_propsal = $this->general_model->datagrabs([
            'tabel' => 'review_ujian',
            'where' => [
                'id_mahasiswa' => $id_mahasiswa,
                'jenis_review' => 1
            ]
        ])->num_rows();
        $cek_ujian = $this->general_model->datagrabs([
            'tabel' => 'review_ujian',
            'where' => [
                'id_mahasiswa' => $id_mahasiswa,
                'jenis_review' => 2
            ]
        ])->num_rows();
        if($cek_propsal > 0){
            $cb_jenis = [
                '' => '--Pilih--',
                '2' => 'Ujian Tesis'
            ];
        }elseif($cek_ujian > 0){
            $cb_jenis = [
                '' => '--Pilih--',
                '1' => 'Proposal Tesis'
            ];
        }
        if(empty($id)){
            $cb_jenis = [
                '' => '--Pilih--',
                '1' => 'Proposal Tesis',
                '2' => 'Ujian Tesis'
            ];
        }
		$data['title'] = (!empty($o)) ? 'Ubah Data Berkas' : 'Tambah Berkas';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => $from,
					'where' => array('a.id_review' => $id)))->row() : null;

        $data['multi'] = 1;
		$data['form_link'] = $this->dir.'/save_aksi/'.@$id;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_review" class="id_review" value="'.@$id .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';
			$data['form_data'] .= '<p><label>Jenis Berkas</label>';
			// $data['form_data'] .= form_dropdown('jenis_review', @$dt->jenis_review,'class="form-control" placeholder="Jenis Berkas" required');
			$data['form_data'] .= form_dropdown('jenis_review', $cb_jenis,@$dt->jenis_review,'class="form-control combo-box" style="width: 100%"');
            $data['form_data'] .= '<p><label>Berkas</label>';
            $data['form_data'] .= form_upload('file_ujian','','class="form-control" placeholder="File Berkas" id="file_ujian"');
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		$this->load->view('umum/form_view', $data);
    }

    function save_aksi($id = null){
        $in = $this->input->post();
		
        $id_mahasiswa = $this->session->userdata('id_pegawai');
        $nip = $this->general_model->datagrabs([
            'tabel' => 'peg_pegawai',
            'where' => [
                'id_pegawai' => $id_mahasiswa
            ]
        ])->row()->nip;
        // var_dump($_FILES);
        // die();
        if($in['jenis_review'] == null){
            $this->session->set_flashdata('fail', 'Belum memilih jenis berkas!');
            redirect($this->dir);

        }
        
        $config = array(
            'allowed_types' => 'application/|pdf',
            
            'overwrite' => TRUE,
        );
        $config['upload_path'] ='';
        if($in['jenis_review'] == 1){
            $config['file_name'] = $nip.'-pt';

            $config['upload_path'] = 'uploads/ujian_proposal_tesis/';
            
           
        }elseif ($in['jenis_review'] == 2) {
            $config['file_name'] = $nip.'-ut';

            $config['upload_path'] = 'uploads/ujian_tesis/';
        }
        $this->load->library('upload');
        // $CI->load->helper('file');
        $this->upload->initialize($config);
        if($this->upload->do_upload('file_ujian')){
            $this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            if(empty($id)){
                $this->general_model->simpan_data([
                    'tabel'=>'review_ujian',
                    'data' =>[
                        'id_mahasiswa' => $id_mahasiswa,
                        'review_file' => $config['file_name'],
                        'jenis_review' => $in['jenis_review'],
                        'tgl_upload' => date("Y-m-d H:i:s"),
                    ]
                ]);
            }elseif(!empty($id)){
                // var_dump($id);
                // die();
                $this->general_model->simpan_data([
                    'tabel'=>'review_ujian',
                    'data' =>[
                        'review_file' => $config['file_name'],
                        'jenis_review' => $in['jenis_review'],
                        'tgl_edit' => date("Y-m-d H:i:s"),
                    ],
                    'where' => [
                        'id_review' => $id,
                    ]


                ]);
                // var_dump($this->db->last_query());
                // die();
            }
            redirect($this->dir);
            
        }else{
            $this->session->set_flashdata('fail', $this->upload->display_errors());
            // var_dump($this->upload->display_errors());
            // var_dump($config);
            // die();
            redirect($this->dir);

        }


    }
}
?>