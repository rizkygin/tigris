<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_sekretaris extends CI_Controller{
    var $dir = 'tigris/Ref_sekretaris';
	function __construct() {
		
		parent::__construct();
		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
		$this->id_petugas = $id_pegawai;
		if($this->cr('spk1')){
			/*Administrator Sapras*/
			$this->where = array();
		}elseif($this->cr('spk2')){
			/*Verivikastor Data Sekolah*/
			$this->where = array();
		}else{
			$this->where = array();
		}
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
		$data['breadcrumb'] = array($this->dir => 'Referensi Sekretaris');
		$offset = !empty($offset) ? $offset : null;
		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'nama' 		=> $search_key,
				'nama_prodi' 		=> $search_key,
				'periode' 		=> $search_key,
			);	
			$data['for_search'] = @$fcari['nama'];
			$data['for_search'] = @$fcari['nama_prodi'];
			$data['for_search'] = @$fcari['periode'];
		} else if ($search) {
			$fcari=un_de($search);
			$data['for_search'] = @$fcari['nama'];
			$data['for_search'] = @$fcari['nama_prodi'];
			$data['for_search'] = @$fcari['periode'];
		}

        $from = [
			'ref_sekretaris kaprodi' => '',
			'ref_prodi prodi' => ['kaprodi.id_ref_prodi = prodi.id_ref_prodi', 'left']
		];
		$select= 'prodi.nama_prodi,kaprodi.*';
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;


		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' =>$from, 'select'=>'*','search' => $fcari,'offset'=>$offs))->num_rows();
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();

		$dtjnsoutput = $this->general_model->datagrabs(array('select' => $select,'tabel'=>$from, 'order'=>'kaprodi.urut ASC', 'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari ,'select'=>$select));

        // cek($this->db->last_query());
		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'ref_sekretaris',
			'order' => 'urut',
		));
		

		$awal = array();
		$urutkan = array();

		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_ref_sekretaris,$rowx->urut);
		}
		


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Nama','NIP','Program Studi','Status');
			if (!in_array($offset,array("cetak","excel")))
				// $heads[] = array('data' => ' ','colspan' => 2);
				$heads[] = array('data' => ' Aksi ','colspan' => 4);
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1 + $offset;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/Ref_pengajuan_judul/on/'.in_de(array('id_ref_sekretaris' => $row->id_ref_sekretaris,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/Ref_pengajuan_judul/on/'.in_de(array('id_ref_sekretaris' => $row->id_ref_sekretaris,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_ref_pengajuan_judul);
				$btn_down = ($m+1 < $nav->num_rows()) ? anchor('tigris/Ref_pengajuan_judul/urut/'.in_de(array('id1' => $row->id_ref_sekretaris,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('tigris/Ref_pengajuan_judul/urut/'.in_de(array('id2' => $row->id_ref_sekretaris,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_ref_sekretaris,$row->urut);


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Syarat Pengajuan Judul;*/
				$rows[] = 	$row->nama;
				$rows[] = 	$row->nip;
				$rows[] = 	$row->nama_prodi;
				$rows[] = 	@$status;
				$rows[] = array('class' => 'text-center','width' => '35','data' => $btn_down);
				$rows[] = array('class' => 'text-center','width' => '35','data' => $btn_up);

				if (!in_array($offset,array("cetak","excel"))) {
					//$ubah = anchor(site_url($this->dir.'/add_data/'.in_de(array('id_ref_pengajuan_judul'=>$row->id_ref_pengajuan_judul))), '<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-flat btn-warning" ');
					$ubah = anchor('#','<i class="fa fa-pencil"></i>', 'class="btn btn-xs btn-warning btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_ref_sekretaris'=>$row->id_ref_sekretaris))).'" title="Ubah data kaprodi..."');
					
					/*$ubah = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-flat btn-warning btn-edit" act="'.site_url($this->dir.'/add_data/'.in_de(array('id_ref_sekretaris'=>$row->id_ref_sekretaris))).'" title="Klik untuk edit data"');*/
					$hapus = anchor('#','<i class="fa fa-trash"></i>','class="btn btn-xs btn-flat btn-danger btn-delete" act="'.site_url($this->dir.'/delete_data/'.in_de(array('id_ref_sekretaris'=>$row->id_ref_sekretaris))).'" msg="Apakah anda yakin ingin menghapus data ini ?" title="klik untuk menghapus data"');
					$rows[] = 	$ubah;
					$rows[] = 	$hapus;
				}
				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}
		/*
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i>Nama Syarat Pengajuan Judul', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data').'" title="Klik untuk tambah data"');*/
		//$btn_tambah = anchor(site_url($this->dir.'/add_data'), '<i class="fa fa-plus"></i> Nama Syarat Pengajuan Judul', 'class="btn btn-md btn-success btn-flat"');
		
		$btn_tambah = anchor('#','<i class="fa fa-plus fa-btn"></i> Tambah Data Sekretaris', 'class="btn btn-success btn-edit btn-flat" act="'.site_url($this->dir.'/add_data/').'" title="Klik untuk tambah data"');
		
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

		$data['tombol'] = $btn_tambah.' '.$btn_cetak;
		$title = 'Referensi Kepala Program Studi';
		
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
    	$id= @$o['id_ref_sekretaris'];
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('tigris/ref_sekretaris/save_aksi'),

        'id_ref_sekretaris' => set_value('id_ref_sekretaris'),
	    );

		$data['title'] = (!empty($o)) ? 'Ubah Data sekretaris' : 'Sekretaris Baru';
       	$dt = !empty($id) ?  $this->general_model->datagrab(array(
					'tabel' => 'ref_sekretaris',
					'where' => array('id_ref_sekretaris' => $id)))->row() : null;
		
        $cb_prodi = $this->general_model->combo_box(array(
                        'tabel' => 'ref_prodi','key' => 'id_ref_prodi','val' => array('nama_prodi')));
		$data['form_link'] = $this->dir.'/save_aksi/'.$id;
		$data['form_data'] = '';
		$data['form_data'] .= '<input type="hidden" name="id_ref_sekretaris" class="id_ref_sekretaris" value="'.$id .'"/>';
		$data['form_data'] .= '<div class="row">';
		$data['form_data'] .= '<div class="col-lg-6">';/*
			$data['form_data'] .= '<label>Kode Sekretaris</label>';
			$data['form_data'] .= form_input('kode_Sekretaris', @$dt->kode_Sekretaris,'class="form-control" placeholder="Kode Sekretaris" required');
			$data['form_data'] .= '<p></p>';*/
			$data['form_data'] .= '<p><label>Nama Sekretaris</label>';
			$data['form_data'] .= form_input('nama', @$dt->nama,'class="form-control" placeholder="Nama Sekretaris" required');
            $data['form_data'] .= '<p><label>NIP</label>';
			$data['form_data'] .= form_input('nip', @$dt->nip,'class="form-control" placeholder="NIP" required');
			$data['form_data'] .= '<p><label>Periode Menjabat</label>';
			$data['form_data'] .= form_input('periode', @$dt->periode,'class="form-control" placeholder="Periode Menjabat" required');
            $data['form_data'] .= '<p><label>Program Studi</label>';
            $data['form_data'] .= form_dropdown('id_ref_prodi',$cb_prodi,@$dt->id_ref_prodi,'class="combo-box form-control" id="id_ref_sekretaris" style="width: 100%"');
			// $data['form_data'] .= form_dropdown('id_ref_prodi', @$dt->id_ref_prodi,'class="form-control" placeholder="Bertanggung Jawab atas prodi" required');
			
			$data['form_data'] .= '</div>';
		$data['form_data'] .= '</div>';
		$data['form_data'] .= '<div style="clear:both;"></div>';
		$this->load->view('umum/form_view', $data);
    }

    function save_aksi(){
    	$id_ref_sekretaris = $this->input->post('id_ref_sekretaris');
    	$nama = $this->input->post('nama',TRUE);
    	$periode = $this->input->post('periode',TRUE);
        $id_prodi = $this->input->post('id_ref_prodi',TRUE);
        $nip = $this->input->post('nip',TRUE);
		$input = $this->input->post();

    	$tgl_skrg = date('Y-m-d');
     	$u = $this->general_model->datagrab(array(
					'tabel' => 'ref_sekretaris',
					'select' => 'max(urut) as urut_nav',
				))->row();
				
				$urut = !empty($u->urut_nav) ? $u->urut_nav+1 : 1;


            if(empty($id_ref_sekretaris)) {
            	
            	$cek_prop = $this->general_model->datagrabs(array('tabel'=>'ref_sekretaris','where'=>array('nama'=>$nama),'select'=>'id_ref_sekretaris, MAX(id_ref_sekretaris) as id'))->row();
                if(empty($cek_prop->id_ref_sekretaris)) {
                	$id_prop = $this->general_model->save_data('ref_sekretaris',array('nama' => $nama,'periode' => $periode, 'id_ref_prodi' => $id_prodi, 'nip' => $nip,'urut' => $urut,'status' => 1));
	                $this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
	            }else{
	                $id_prop = $cek_prop->id_ref_sekretaris ;
	                $this->session->set_flashdata('fail', 'Nama Sekretaris sudah ada...');
	            }
            }else{
            	
            	$par = array(
					'tabel'=>'ref_sekretaris',
					'data'=>array(
						'nama'=>$nama,'urut' => $urut,
						'periode' => $periode, 'id_ref_prodi' => $id_prodi, 'nip' => $nip
						),
					);

					$par['where'] = array('id_ref_sekretaris'=>$id_ref_sekretaris);

				$sim = $this->general_model->save_data($par);
				$this->session->set_flashdata('ok', 'Data Berhasil Disimpan...');
            }

            redirect($this->dir);

    }
	function delete_data($code) {
		$sn = un_de($code);
		$id_ref_sekretaris = $sn['id_ref_sekretaris'];
		$del = $this->general_model->delete_data('ref_sekretaris','id_ref_sekretaris',$id_ref_sekretaris);
		if ($del) {
			$this->session->set_flashdata('ok','Data Sekretaris Berhasil di Hapus');
		}else{
			$this->session->set_flashdata('fail','Jenis Output Gagal di Hapus');
		}
		redirect($this->dir.'/list_data');
	}
}
?>