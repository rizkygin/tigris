<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_agenda extends CI_Controller {
	var $dir = 'schedul/laporan_agenda';

	function __construct() {
		
		parent::__construct();

		$this->load->helper('cmd');
		if (not_login(uri_string()))redirect('login');
		date_default_timezone_set('Asia/Jakarta');
		$id_pegawai = $this->session->userdata('id_pegawai');
		$this->id_petugas = $id_pegawai;
		if($this->cr('sch1')){
			$this->where = array();
		}elseif($this->cr('sch1')){
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
		$data['breadcrumb'] = array($this->dir => 'Laporan Agenda Kegiatan');
		$offset = !empty($offset) ? $offset : null;


		$tahun1=$this->input->post('id_tahun1');
		$tahun2=$this->input->post('id_tahun2');
		/*echo $tahun1;
		echo $tahun2*/;
		$cb_tahun = $this->general_model->combo_box(array('tabel'=>'sch_ref_tahun','key'=>'id_tahun','val'=>array('tahun')));
		

		$fcari = null;
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$fcari = array(
				'kode_kegiatan' 		=> $search_key,
				'nama_kegiatan' 		=> $search_key,
			);	
		} else if ($search) {
			$fcari=un_de($search);
		}
			$from = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_ref_rincian tz' => array('tz.id_ref_rincian= tj.id_ref_rincian','left'),
			'sch_ref_tahun tc' => array('tc.id_tahun= tj.id_tahun','left')
		);

		$th = ($tahun1 !=NULL or $tahun2 !=NULL) ? array('tj.id_tahun BETWEEN "'.$tahun1.'" AND "'.$tahun2.'" '=>null) : array();
		$where = array_merge($th);
		
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tc.tahun,tz.nama_rincian';
		$config['base_url']	= site_url($this->dir.'/list_data/'.in_de($fcari));
		$config['total_rows'] = $this->general_model->datagrab(array('tabel' => $from,'where'=>$where, 'select'=>$select,'search' => $fcari))->num_rows();
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		$this->pagination->initialize($config);
		$data['total']	= $config['total_rows'];
		$data['links'] = $this->pagination->create_links();
		$lim = ($offset == "cetak" or $offset == "excel") ? null : $config['per_page'];
		$offs = ($offset == "cetak" or $offset == "excel") ? null : $offset;
		$st = get_stationer();
		$dtjob = $this->general_model->datagrab(array('tabel'=>$from,'where'=>$where, 'order'=>'td.id_ref_program ASC','select'=>$select,'limit'=>$lim, 'offset'=>$offs, 'search'=>$fcari));
		if ($dtjob->num_rows() > 0) {
			$heads[]= array('data' => 'No ','colspan' => 1);
			$heads[]= array('data' => 'Program');
			$heads[]= array('data' => 'Kegiatan');
			$heads[]= array('data' => 'Rincian Kegiatan');
			$heads[]= array('data' => 'Tgl Mulai');
			$heads[]= array('data' => 'Tgl Selesai');
			$heads[]= array('data' => 'Keterangan');
			$heads[]= array('data' => 'Lokasi');
			$heads[]= array('data' => 'Indikator');
			$heads[]= array('data' => 'Sasaran');
			$heads[]= array('data' => 'Pagu','style'=>'width:130px;');
			if (!in_array($offset,array("cetak","excel")));
			$classy = (in_array($offset,array("cetak","excel"))) ? 'class="tabel_print" border=1' : 'class="table table-responsive table-striped table-bordered table-condensed"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$no = 1 + $offset;
			foreach ($dtjob->result() as $row) {
				$rows = array(
					array('data' => $no)
				);
				($row->nama_program != NULL)?
				$rows[] = array(
					'data' =>$row->nama_program) : $rows[] = array(
					'data' =>' - ','style'=>'text-align:center;');
				$rows[] = array(
					'data' =>$row->nama_kegiatan);
				$rows[] = array(
					'data' =>$row->nama_rincian);

				$rows[] = array(
					'data' =>tanggal($row->tgl_mulai));
				$rows[] = array(
					'data' =>tanggal($row->tgl_selesai));
				$rows[] = array(
					'data' =>$row->content);

				($row->lokasi != NULL) ?
				$rows[] = array(
					'data' =>$row->lokasi) : $rows[] = array(
					'data' =>' - ','style'=>'text-align:center;');

				($row->indikator != NULL) ?
				$rows[] = array(
					'data' =>$row->indikator) : $rows[] = array(
					'data' =>' - ','style'=>'text-align:center;');

				($row->sasaran != NULL) ?
				$rows[] = array(
					'data' =>$row->sasaran) : $rows[] = array(
					'data' =>' - ','style'=>'text-align:center;');

				($row->pagu != NULL) ?
				$rows[] = array(
					'data' =>rupiah($row->pagu)) : $rows[] = array(
					'data' =>' - ','style'=>'text-align:center;');

				
				$this->table->add_row($rows);
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Data masih kosong ...</div>';
		}

		
		$btn_cetak =
			'<div class="btn-group" style="margin-left: 5px;">
			<a class="btn btn-warning dropdown-toggle btn-flat" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
			<i class="fa fa-print"></i> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
			<li>'.anchor('schedul/laporan_agenda/pdf/'.in_de(array('id_tahun1'=>$tahun1)).'/'.in_de(array('id_tahun2'=>$tahun2)),'<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>
			<li>'.anchor($this->dir.'/list_data/'.in_de($fcari).'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>
			</ul>
			</div>';
		$filter =  form_open('','id="form_search" role="form"').
			    '
				    <div class="col-lg-2" style="padding:0;text-align:center;padding-top:6px;"> Periode </div>
				  	<div class="col-lg-4" style="padding:0;">
				    	<div class="input-group" style="width: 100%;">
					    	'.form_dropdown('id_tahun1', $cb_tahun, @$tahun1,'class="form-control combo-box" style="width: 100%"').'
						    	</div>
				    </div>
				  	<div class="col-lg-1" style="padding:0;text-align:center;padding-top:6px;"> <span class="badge"> s.d </span> </div>
				  	<div class="col-lg-4" style="padding:0;">
			    		<div class="input-group" style="width: 100%;">
					    	'.form_dropdown('id_tahun2', $cb_tahun, @$tahun2,'class="form-control combo-box" style="width: 100%"').'
						    	</div>
				    </div>

				  	<div class="col-lg-1" style="padding-top:0;margin-left:-15px;">
				  	<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
						
				  	</div>
					'.
				form_close();

		$data['tombol'] = $btn_cetak;
		$data['tombolx'] = $filter;

		$title = 'Laporan Agenda Kegiatan';
		
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
			$data['content'] = 'schedul/agenda_view';
			$this->load->view('home', $data);
		}
	}


 	function pdf($tahun1=NULL,$tahun2=NULL) {
		$p=un_de($tahun1);
		$q=un_de($tahun2);
		$tahunsatu=$p['id_tahun1'];
		$tahundua=$q['id_tahun2'];
		/*cek($tahunsatu);
		cek($tahundua);
		die();*/
    	$offset = !empty($offset) ? $offset : null;
		//$pengajar = $this->input->post('pengajar');
	$st = get_stationer();

		$from_non = array(
			'sch_jadwal tj' => '',
			'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
			'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
			'sch_ref_rincian tz' => array('tz.id_ref_rincian= tj.id_ref_rincian','left'),
			'sch_jenis_program tx' => array('tx.id_jenis_program= tj.id_jenis_program','left'),
			'sch_ref_tahun tc' => array('tc.id_tahun= tj.id_tahun','left')
		);
		$th = ($tahunsatu !=NULL and $tahundua !=NULL) ? array('tj.id_tahun BETWEEN "'.$tahunsatu.'" AND "'.$tahundua.'" '=>null) : array();
		$where = array_merge($th);
		$select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.*,tc.tahun,tz.nama_rincian';
		
		$data['query'] = $this->general_model->datagrab(
				array('tabel' => $from_non,
					  'select' => $select,
					  'where'=>$where));
		
		$data['bubar'] =  $this->general_model->datagrab(
					array('tabel' => $from_non,
						  'select' => $select,
						  'where'=>$where))->row();	
		$xx =  $this->general_model->datagrab(
					array('tabel' => $from_non,
						  'select' => $select,
						  'where'=>$where))->row();
		$data['tahun1'] = $tahunsatu;
		$data['tahun2'] = $tahundua;	
		$data['h_title_left'] = '
		<div class="col-lg-5" style="padding: 10px 0px 0px 0px;">

		<img src="'.base_url()."uploads/logo/logo_yes.png".'" style="height: 40px;float:left; margin-right:10px;"/>

		<h5 style="font-size: 24px;border-top:3px solid #4271B7;border-bottom:3px solid #4271B7;float:left;color:#4271B7;margin-top:5px;"><b>YOGYA EXECUTIVE SCHOOL "YES"</b></h5>
				</div>
		';
		$data['h_title_right'] = '
		
		';
		$data['h_sub_center'] = '';
		$data['tgl_cetak'] = date('d-M-Y');
		$data['company_address'] = '<div class="col-lg-6"  style="padding: 10px 0px 0px 0px;">

		<div style="text-align:right;color: #4271B7;margin-top:-20px;">
		<h6 style="font-size:10px;">Jl. Taman Siswa No. 89 Telp/Fax. (0274) 376 623 Yogyakarta 55151<br>
		Website : www.yesjogja.com<br>E-mail : info@yesjogja.com, info_yes@yahoo.co.id</h6></div>';
		$data['company_country'] = 'City-Country';
		/*$data['company_logo'] = base_url('assets/logo/brand.png');*/

    	// **** BEDO SAMBUNGAN
        // $start = 0;
        // $anjab_alat = $this->general_model->datagrabs(array(
        //     'tabel'=>'catatan', 
        //     'select'=>'*'));
        // $data = array(
        //     'h_title_left'=> 'pesis',
        //     'h_title_center'=> '<span>Laporan</span><br/> Data ',
        //     'h_sub_center'=> '',
        //     'tgl_cetak'=> date('d-M-Y'),
        //     'company_address'=>'Company Address',        
        //     'company_country'=>'City-Country',        
        //     'company_logo'=>base_url('assets/logo/brand.png'),        
        //    // 'company_logo'=>$logo_instansi      
        //     );



		 ini_set('memory_limit', '512M');
       // $html = $this->load->view('anjab_alat_pdf', $data, true);
        $html = $this->load->view('schedul/laporan_agenda_pdf', $data, true);
        $this->load->library('pdf');
        $parameters= array(
                'mode' => 'utf-8',
                'format' => 'A4',    // A4 for portrait
                'default_font_size' => '12',
                'default_font' => '',
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 40,
                'margin_bottom' => 30,
                'margin_header' => 20,
                'margin_footer' => 10,
                'orientation' => 'P' // For some reason setting orientation to "L" alone doesn't work (it should), you need to also set format to "A4-L" for landscape
            );

        $pdf = $this->pdf->load($parameters);
        // setting
        $pdf->SetProtection(array('print'));
        $pdf->SetTitle("");
        $pdf->SetWatermarkText("");
        $pdf->showWatermarkText = true;
        $pdf->watermark_font = 'DejaVuSansCondensed';
        $pdf->watermarkTextAlpha = 0.1;
        $pdf->SetDisplayMode('fullpage');
        // .setting

        $pdf->WriteHTML($html);
        $pdf->Output('laporan_agenda_kegiatan.pdf', 'I'); 
        // $pdf->Output(); 

  //  }

}

	
}