<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Impor extends CI_Controller {
	
	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));

	}

	public function index() {
	
		$this->load_page();
		
	}

	function load_page() {
		
		$data['breadcrumb'] = array('' => 'Manajemen', 'inti/impor' => 'Impor Data Kepegawaian');

		$data['title'] 	 = '<i class="fa fa-download fa-btn"></i> &nbsp; Impor Kepegawaian';
		$data['content'] = "umum/impor_view";
		$this->load->view('home', $data);
		
	}
	
	function impor_init() {
		
	
		if ($this->general_model->check_tab('temp_pegawai')) $this->db->query('drop table temp_pegawai');
	
		/* -- Persiapan Tabel Temp Pegawai -- */
		$this->db->query('
			
			CREATE TABLE `temp_pegawai` (
			`id_temp` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`nip` varchar(18) DEFAULT NULL,
			`nip_lama` varchar(18) DEFAULT NULL,
			`nama` varchar(255) DEFAULT NULL,
			`gelar_depan` varchar(15) DEFAULT NULL,
			`gelar_belakang` varchar(15) DEFAULT NULL,
			`tempat_lahir` varchar(20) DEFAULT NULL,
			`agama` varchar(15) DEFAULT NULL,
			`jenis_kelamin` varchar(1) DEFAULT NULL,
			`tanggal_lahir` varchar(10) DEFAULT NULL,
			`mkg_bulan` varchar(2) DEFAULT NULL,
			`mkg_tahun` varchar(2) DEFAULT NULL,
			`no_nik` varchar(32) DEFAULT NULL,
			`no_npwp` varchar(32) DEFAULT NULL,
			`alamat` varchar(255) DEFAULT NULL,
			`tmt_cpns` varchar(10) DEFAULT NULL,
			`tmt_pns` varchar(10) DEFAULT NULL,
			`jabatan` varchar(255) DEFAULT NULL,
			`tmt_jabatan` varchar(10) DEFAULT NULL,
			`eselon` varchar(5) DEFAULT NULL,
			`jenis_jabatan` int(1) DEFAULT NULL,
			`golru` varchar(5) DEFAULT NULL,
			`tmt_golru` varchar(10) DEFAULT NULL,
			`bidang` varchar(255) DEFAULT NULL,
			`unit` varchar(255) DEFAULT NULL,
			`unit_asal` varchar(255) DEFAULT NULL,
			`jenjang` varchar(64) DEFAULT NULL,
			`jurusan` varchar(255) DEFAULT NULL,
			`lulus` varchar(4) DEFAULT NULL,
			PRIMARY KEY (`id_temp`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;');

		$res = $this->input->post('on_reset');
		
		if (empty($_FILES['excel_impor']['name'])) {	
			$errors = 'Pilih dokumen Excel yang akan di-unggah ...';
		} else {
			$this->load->library('upload');
			$this->upload->initialize(array(
				'upload_path' => './uploads/',
				'allowed_types' => '*'));
			if (!$this->upload->do_upload('excel_impor')) {
				$en = $this->upload->display_errors();
				switch ($en) { 
					case 'The uploaded file exceeds the maximum allowed size in your PHP configuration file.':
					$errors = 'Unggah berkas lebih dari batas maksimum diperbolehkan ...';
					break;
					default: $errors = $en; 
				}
			} else {
				$data_up = $this->upload->data();

				$this->load->library('excel_reader');
				$this->excel_reader->setOutputEncoding('CP1251');
				$rslt_read = $this->excel_reader->read('./uploads/'.$data_up['file_name']);
				if ($rslt_read != 404) {
				$brs = $this->input->post('baris');
		 
				$data = $this->excel_reader->sheets[0];
				$this->general_model->dataempty('temp_pegawai');
		 
				if (!empty($res)) {
				$tab_delete = array(
					'peg_anak',
					'peg_beasiswa',
					'peg_cuti',
					'peg_diklatpim',
					'peg_dokumen',
					'peg_formal',
					'peg_hukdis',
					'peg_ijintugas_belajar',
					'peg_informal',
					'peg_inpassing',
					'peg_jabatan',
					'peg_kartu',
					'peg_karyatulis',
					'peg_keluarga',
					'peg_kesejahteraan',
					'peg_kgb',
					'peg_nilai',
					'peg_organisasi',
					'peg_pangkat',
					'peg_penghargaan',
					'peg_pensiun',
					'per_perkawinan',
					'peg_sertifikasi',
					'peg_tes',
					'peg_tugas',
					'peg_tunjangan',
					'peg_upi',
					'peg_pegawai',
					'ref_lokasi',
					'ref_agama',
					'ref_jurusan',
					'ref_lembaga',
					'ref_lokasi',
					'ref_unit',
					'ref_bidang',
					'ref_jabatan');
				$this->general_model->dataempty($tab_delete); }
		 
				$total = 0;

				$e = $this->general_model->get_param('impor_total');
				if (!empty($e)) $this->general_model->save_data('parameter',array('val' => $data['numRows']-($brs-1)),'param','impor_total');
				else $this->general_model->save_data('parameter',array('param' => 'impor_total','val' => $data['numRows']-($brs-1)));

				for ($i = (!empty($brs)?$brs:1); $i <= $data['numRows']; $i++) {
					
				 	 $jft = @$data['cells'][$i][$this->input->post('k_jft')];
					 $tmt_jft = @$data['cells'][$i][$this->input->post('k_tmt_jft')];
					 $struktural = @$data['cells'][$i][$this->input->post('k_s')];
					 $tmt_s = @$data['cells'][$i][$this->input->post('k_tmt_s')];
					 
					 $tmt_p = @$data['cells'][$i][$this->input->post('k_tmt_pns')];
					 $tmt_cp = @$data['cells'][$i][$this->input->post('k_tmt_cpns')];
					 
					 if (!empty($jft)) {
						$jns = 2;
						$jab = $jft;
						$tmt_jab = $this->balik_tanggal((!empty($tmt_jft)?$tmt_jft:(!empty($tmt_p)?$tmt_p:$tmt_cp))); 
					 } else if (!empty($struktural)) {
						$jns = 1;
						$jab = $struktural;
						$tmt_jab = $this->balik_tanggal((!empty($tmt_s)?$tmt_s:(!empty($tmt_p)?$tmt_p:$tmt_cp))); 
					 } else {
						$jns = 3;
						$jab = $data['cells'][$i][$this->input->post('k_jfu')];
						$tmt_jab = $this->balik_tanggal((!empty($tmt_p)?$tmt_p:$tmt_cp));
					 } 	
					 	
					$si = array(
						'nip' => @$data['cells'][$i][str_replace(array(" "),array(""),$this->input->post('k_nip'))],
						'nip_lama' => @$data['cells'][$i][str_replace(array(" "),array(""),$this->input->post('k_nip_lama'))],
						'nama' => @$data['cells'][$i][$this->input->post('k_nama')],
						'gelar_depan' => @$data['cells'][$i][$this->input->post('k_gelar_depan')],
						'gelar_belakang' => @$data['cells'][$i][$this->input->post('k_gelar_belakang')],
						'tempat_lahir' => @$data['cells'][$i][$this->input->post('k_tempat_lahir')],
						'tanggal_lahir' => @$this->balik_tanggal($data['cells'][$i][$this->input->post('k_tanggal_lahir')]),
						'jenis_kelamin' => @$data['cells'][$i][$this->input->post('k_jenis_kelamin')],
						'mkg_bulan' => @$data['cells'][$i][$this->input->post('k_mkg_bulan')],
						'mkg_tahun' => @$data['cells'][$i][$this->input->post('k_mkg_tahun')],	
						'tmt_cpns' => @$this->balik_tanggal($tmt_cp),
						'tmt_pns' => @$this->balik_tanggal($tmt_p),
						'jabatan' => $jab,
						'tmt_jabatan' => $tmt_jab,
						'eselon' => @$data['cells'][$i][$this->input->post('k_eselon')],
						'jenis_jabatan' => $jns,
						'golru' => @$data['cells'][$i][$this->input->post('k_golru')],
						'tmt_golru' => @$this->balik_tanggal($data['cells'][$i][$this->input->post('k_tmt_golru')]),
						'bidang' => @$data['cells'][$i][$this->input->post('k_bidang')],
						'unit' => @$data['cells'][$i][$this->input->post('k_unit')],
						'unit_asal' => @$data['cells'][$i][$this->input->post('k_unit_asal')],
						'jenjang' => @$data['cells'][$i][$this->input->post('k_jenjang')],
						'jurusan' => @$data['cells'][$i][$this->input->post('k_jurusan')],
						'lulus' => @$data['cells'][$i][$this->input->post('k_lulus')]);
		
						$nik = $this->input->post('k_nik');
						$npwp = $this->input->post('k_npwp');
						$alamat = $this->input->post('k_alamat');
						$agama = $this->input->post('k_agama');
						if (!empty($nik)) $si['no_nik'] = @$data['cells'][$i][$nik];
						if (!empty($npwp)) $si['no_npwp'] = @$data['cells'][$i][$npwp];
						if (!empty($alamat)) $si['alamat'] = @$data['cells'][$i][$alamat];
						if (!empty($agama)) $si['agama'] = @$data['cells'][$i][$agama];
						
						$this->general_model->save_data('temp_pegawai',$si); 	
						$total += 1;
					
					}
					} else {
						$errors = 'File excel tersebut tak dapat terbaca ...<br>harus File dengan ektensi <b>xls</b> atau format Ms.Excel 2003/2007';
					}
				
				unlink(FCPATH.'uploads/'.$data_up['file_name']);
				}
		
			
			}
		
		if (!empty($errors)) $this->session->set_flashdata('fail','Terjadi kesalahan<br>'.$errors);
		else $this->session->set_flashdata('ok','Impor <b>'.@$total.' pegawai</b> berhasil disimpan di tabel temporer');
	
		redirect('inti/impor/impor_next');
	
	}
	
	function impor_next() {

		$sm = $this->general_model->datagrab(array('tabel' => 'temp_pegawai','limit' => 5, 'offset' => 0));
		
		if ($sm->num_rows() > 0) {
		$this->table->set_template(array(
			'table_open'=>'
				<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-nonfluid">',
			'table_close' => '</table></div>'));
		$this->table->set_heading(
			array('data'=>'No','style'=>'width:20px;text-align:center'),
			'NIP',
			'NIP Lama',
			'Nama',
			'Gelar Depan',
			'Gelar Belakang',
			'Tempat Lahir',
			'Tanggal Lahir',
			'Jenis Kelamin',
			'MKG Tahun',
			'MKG Bulan',
			'TMT CPNS',
			'TMT PNS',
			'Jabatan',
			'TMT Jabatan',
			'Eselon',
			'Jenis Jabatan',
			'Golru/Pangkat',
			'TMT Golru/Pangkat',
			'Unit Organisasi',
			'Unit Kerja',
			'Unit Kerja Asal',
			'Alamat',
			'NIK',
			'NPWP',
			'Agama',
			'Jenjang',
			'Jurusan',
			'Tahun Lulus');
		$no = 1;
		
		$jns = array(
			1 => 'Struktural',
			2 => 'Fungsional Tertentu',
			3 => 'Fungsional Umum'
		);
		
		foreach($sm->result() as $s) {
			
			$this->table->add_row(
				$no,
				$s->nip,
				$s->nip_lama,
				$s->nama,
				$s->gelar_depan,
				$s->gelar_belakang,
				$s->tempat_lahir,
				tanggal($s->tanggal_lahir),
				$s->jenis_kelamin,
				$s->mkg_bulan,
				$s->mkg_tahun,
				tanggal($s->tmt_cpns),
				tanggal($s->tmt_pns),
				$s->jabatan,
				tanggal($s->tmt_jabatan),
				$s->eselon,
				@$jns[$s->jenis_jabatan],
				$s->golru,
				tanggal($s->tmt_golru),
				$s->bidang,
				$s->unit,
				$s->unit_asal,
				$s->alamat,
				$s->no_nik,
				$s->no_npwp,
				$s->agama,
				$s->jenjang,
				$s->jurusan,
				$s->lulus
			);
			$no += 1;
		}
	
		$data['title'] = 'Sampel Impor dari Excel';
		$data['script'] = "
			function proses(e) {
				var e = (e)?e:'';
				
				$.ajax({	
					url: '".site_url('inti/impor/push_data')."/'+e,
					cache: false,
					  dataType: 'json',
					  success: function(msg) {
						if (parseInt(msg.sign) == 1) {
							proses(msg.t);
							$('.progress-bar-sr').html(msg.persen+'% Komplit');
							$('.progress-bar-total').attr('aria-valuenow',msg.persen).attr('style','width: '+msg.persen+'%');
							$('.txt_data').html(msg.jml);
							$('.txt_total').html(msg.total);
							$('.txt_persen').html(msg.persen);
							$('.progress-view').show();
						} else {
							$('.progress-view p.txt_komplit').html('Proses Selesai!');	
							$('.btn-save').removeAttr('disabled').removeClass('btn-danger').addClass('btn-default').html('<i class=\"fa fa-arrow-left fa-btn\"></i> Proses Selesai, Kembali').attr('href','".site_url('inti/impor')."');
							
						}						  
						
					  },error:function(error){
						show_error(error);
			
					}
				});
			}
			$(document).ready(function() {
				$('.btn-save').click(function() {
					$('.btn-save').attr('disabled','disabled').html('<i class=\"fa fa-spin fa-spinner fa-btn\"></i> Proses Data ...');
					proses();
					return false;
				});
			});";
			
		$data['tabel'] = $this->table->generate();
		
		} else {
			$data['tabel'] = '<div class="alert">Tidak ada data pegawai siap di-upload</div>'; }
		
		$fail = $this->session->flashdata('fail');
		$btn_push =  (!empty($fail)) ? null : anchor('#','<i class="fa fa-btn fa-save"></i> Proses!','class="btn btn-danger btn-save btn-proses pull-right"');
		$data['box_footer'] = '
			<div class="progress-view on-hide">
			<div class="progress active">
			   <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning progress-bar-striped progress-bar-total">
			     <span class="sr-only progress-bar-sr">0% Komplit</span>
			   </div>
			      </div>
			<p>Proses : <span class="txt_data"></span> dari <span class="txt_total"></span> ( <span class="txt_persen"></span> % Komplit )</p>
			<p class="txt_komplit"></p>
			</div><br>'.
		
			anchor('inti/impor/kembali','<i class="fa fa-arrow-left fa-btn"></i> Batalkan dan kembali','class="btn btn-default"').' '.
			anchor('inti/impor/analisa/','<i class="fa fa-btn fa-database"></i> Analisa Data','class="btn btn-success"').
			$btn_push.'<div class="clear"></div>
		
			
			';
			
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
	
	function analisa($search = null,$offset = null) {
		
		$offset = !empty($offset)?$offset:null;
		
		$to_url = array();
		$search_key = $this->input->post('key');
		if (!empty($search_key)) {
			$to_url = array('text' => $search_key);	
		} else if ($search) {
			$to_url=un_de($search);
		}
		
		$search_text = !empty($to_url['text']) ? array('nip' => $to_url['text'],'nip_lama' => $to_url['text'],'nama' => $to_url['text']) : null;

		$config['base_url']	= site_url('inti/impor/analisa/'.in_de($to_url));
		$config['total_rows'] = $this->general_model->datagrab(array(
			'tabel' => 'temp_pegawai',
			'search' => $search_text,
			'select' => 'count(*) as jml'))->row()->jml;
		$config['per_page']	= '10';
		$config['uri_segment'] = '5';
		$this->pagination->initialize($config);
		
		$data['total']	= $config['total_rows'];
		$data['links']	= $this->pagination->create_links();

		$sm = $this->general_model->datagrab(
			array('tabel' => 'temp_pegawai','limit' => $config['per_page'], 'offset' => $offset,'search' =>  $search_text));
		
		if ($sm->num_rows() > 0) {
		$this->table->set_template(array(
			'table_open'=>'
				<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-nonfluid">',
			'table_close' => '</table></div>'));
		$this->table->set_heading('',
			array('data'=>'No','style'=>'width:20px;text-align:center'),
			'NIP',
			'NIP Lama',
			'Nama',
			'Gelar Depan',
			'Gelar Belakang',
			'Tempat Lahir',
			'Tanggal Lahir',
			'Jenis Kelamin',
			'MKG Tahun',
			'MKG Bulan',
			'TMT CPNS',
			'TMT PNS',
			'Jabatan',
			'TMT Jabatan',
			'Eselon',
			'Jenis Jabatan',
			'Golru/Pangkat',
			'TMT Golru/Pangkat',
			'Unit Organisasi',
			'Unit Kerja',
			'Unit Kerja Asal',
			'Alamat',
			'NIK',
			'NPWP',
			'Agama',
			'Jenjang',
			'Jurusan',
			'Tahun Lulus');
			
		$no = 1 + $offset;
		
		$jns = array(
			1 => 'Struktural',
			2 => 'Fungsional Tertentu',
			3 => 'Fungsional Umum'
		);
		
		foreach($sm->result() as $s) {
			
			$this->table->add_row(
				anchor('inti/impor/hapus/'.$s->id_temp.'/'.in_de($to_url).'/'.$offset,'
					<i class="fa fa-trash"></i>','
					class="btn btn-xs btn-danger btn-delete"
					msg="Apakah data temporer ini akan dihapus ...?"
					title="Hapus data temporer..."'),
				$no,
				$s->nip,
				$s->nip_lama,
				$s->nama,
				$s->gelar_depan,
				$s->gelar_belakang,
				$s->tempat_lahir,
				tanggal($s->tanggal_lahir),
				$s->jenis_kelamin,
				$s->mkg_bulan,
				$s->mkg_tahun,
				tanggal($s->tmt_cpns),
				tanggal($s->tmt_pns),
				$s->jabatan,
				tanggal($s->tmt_jabatan),
				$s->eselon,
				@$jns[$s->jenis_jabatan],
				$s->golru,
				tanggal($s->tmt_golru),
				$s->bidang,
				$s->unit,
				$s->unit_asal,
				$s->alamat,
				$s->no_nik,
				$s->no_npwp,
				$s->agama,
				$s->jenjang,
				$s->jurusan,
				$s->lulus
			);
			$no += 1;
		}
	
		$data['title'] = 'Analisis Data hasil Impor';
			
		$data['tabel'] = $this->table->generate();
		
		} else {
			$data['tabel'] = '<div class="alert">Tidak ada data pegawai siap di-upload</div>';
		}
		
		$data['tombol'] = 
			anchor('inti/impor/impor_next','<i class="fa fa-arrow-left fa-btn"></i> Kembali','class="btn btn-default"');
			
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
		
	}
		
	function hapus($id,$url,$offset) {
		
		$this->general_model->delete_data('temp_pegawai','id_temp',$id);
		$this->session->set_flashdata('ok','Data temporer berhasil dihapus ...');
		
		redirect('inti/impor/analisa/'.$url.'/'.$offset);
		
	}	
		
	function jumlah() {
		
		$jml =$this->general_model->datagrab(array(
			'tabel' => 'peg_pegawai',
			'select' => 'count(id_pegawai) as jml'
		))->row();
		
		die($jml->jml);
		
	}
	
	function total_temp() {
		
		$jml = $this->general_model->datagrab(array(
				'tabel' => 'temp_pegawai',
			'select' => 'count(id_temp) as jml'
		))->row();
		$total = $this->general_model->get_param('impor_total');
		die(json_encode(array(
			'jml' => $jml->jml,
			'persen' => ($total > 0) ? number_format($jml->jml/$total*100,0,',','.') : null,
			'total' => $total
		)));
	}
	
	function kembali() {
		
		$this->general_model->dataempty(array('temp_pegawai'));
		$this->session->set_flashdata('ok','Impor Excel berhasil dibatalkan ...');
		redirect('inti/impor');
		
	}
	
	function push_data($t = null) {
		
		$e = $this->general_model->get_param('impor_total');
		
		$total = (!empty($t)?$t:0);
		$sm = $this->general_model->datagrab(array('tabel' => 'temp_pegawai','limit' => 100, 'offset' => $total));
		
		foreach($sm->result() as $dat) {
			$nipp = str_replace(array(" "),array(""),$dat->nip);

			if (!empty($nipp) and !empty($dat->nama)) {		
					
					$c_nip = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => array('nip' => $nipp),'select' => 'count(nip) as jml,id_pegawai'))->row();
			
					// -- Tempat Lahir -- 
					if (!empty($dat->tempat_lahir)) {
						$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $dat->tempat_lahir),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
						if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $dat->tempat_lahir));
						else $id_tmpt = $c_tempat->id_lokasi;
					}
					if (!empty($dat->agama)) {
						/* -- Agama -- */
						$c_agama = $this->general_model->datagrab(array('tabel' => 'ref_agama','where' => array('agama' => $dat->agama),'select' => 'count(id_agama) as jml,id_agama'))->row();
						if (empty($c_agama->jml)) $id_agama = $this->general_model->save_data('ref_agama', array('agama' => $dat->agama));	
						else $id_agama = $c_agama->id_agama;
					}
					
					$nip_simpan = !empty($nipp) ? $nipp : $dat->nip_lama;
					$gnd = !empty($dat->jenis_kelamin) ? ($dat->jenis_kelamin == "L"?"1":"2") : "1";
					$s_peg = array(
						'username' => $nip_simpan,
						'password' => md5($nip_simpan),//md5('qwerty'),
						'id_tipe_pegawai' => 1,
						'nip_lama' => $dat->nip_lama,
						'nip' => $nipp,
						//'foto' => $nipp.'.jpg',
						'nama' => $dat->nama,
						'gelar_depan' => !empty($dat->gelar_depan)?$dat->gelar_depan:null,
						'gelar_belakang' => !empty($dat->gelar_belakang)?$dat->gelar_belakang:null,
						'id_jeniskelamin' => $gnd,
						'id_tempat_lahir' => !empty($id_tmpt)?$id_tmpt:0,
						'id_agama' => !empty($id_agama)?$id_agama:0,
						'tanggal_lahir' => !empty($dat->tanggal_lahir) ? $dat->tanggal_lahir : null,
						'mkg_bulan' => !empty($dat->mkg_bulan)?$dat->mkg_bulan:null,
						'mkg_tahun' => !empty($dat->mkg_tahun)?$dat->mkg_tahun:null,
						'no_nik' => !empty($dat->nik)?$dat->nik:null,
						'no_npwp' => !empty($dat->npwp)?$dat->npwp:null,
						'alamat' => !empty($dat->alamat)?$dat->alamat:null
					);
					if (!empty($dat->tmp_cpns)) $s_peg['cpns_tmt'] = $dat->tmt_cpns;
	
				if (empty($c_nip->jml)) {
					$id_peg = $this->general_model->save_data('peg_pegawai',$s_peg);
				} else {
					$this->general_model->save_data('peg_pegawai',$s_peg,'id_pegawai',$c_nip->id_pegawai);
					$id_peg = $c_nip->id_pegawai;
				}
				
				// Unit Asal / Unit Atasan
				$id_unit_asal = null;
				if ($dat->unit_asal != NULL) {
					$c_unit_asal = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('UPPER(unit)' => strtoupper($dat->unit_asal)),'select' => 'count(id_unit) as jml,id_unit'))->row();
					if ($c_unit_asal->jml != NULL) $id_unit_asal = $c_unit_asal->id_unit;
				}
				
				// Unit
				$c_unit = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('UPPER(unit)' => strtoupper($dat->unit)),'select' => 'count(id_unit) as jml,id_unit'))->row();
				if (empty($c_unit->jml)) {
					$simpan_unit = array('unit' => $dat->unit,'aktif' => 1);
					if ($id_unit_asal != NULL) $simpan_unit['id_par_unit'] = $id_unit_asal;
					$id_unit = $this->general_model->save_data('ref_unit', $simpan_unit);
				} else {
					$id_unit = $c_unit->id_unit;
				}
				// Bidang
				
				$c_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('UPPER(nama_bidang)' => strtoupper($dat->bidang),'id_unit' => $id_unit),'select' => 'count(id_bidang) as jml,id_bidang'))->row();
				
				$ur_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $id_unit),'select' => 'MAX(urut) as urutan'))->row();
				
				if (empty($c_bid->jml)) {
					$s_bid = array(
						'id_unit' => $id_unit,
						'nama_bidang' => $dat->bidang,
						'urut' => $ur_bid->urutan+1	
					);
					$id_bidang = $this->general_model->save_data('ref_bidang',$s_bid);
				} else {
					$id_bidang = $c_bid->id_bidang;
				}
				
				// Jabatan
				
							
				$ess_data = array(
						'11' => 'I-A',	
						'12' => 'I-B',
						'21' => 'II-A',
						'22' => 'II-B',
						'31' => 'III-A',
						'32' => 'III-B',
						'41' => 'IV-A',
						'42' => 'IV-B',
						'51' => 'V-A',
						'52' => 'V-B',
						'I.A' => 'I-A',	
						'I.B' => 'I-B',
						'II.A' => 'II-A',
						'II.B' => 'II-B',
						'III.A' => 'III-A',
						'III.B' => 'III-B',
						'IV.A' => 'IV-A',
						'IV.B' => 'IV-B',
						'V.A' => 'V-A',
						'V.B' => 'V-B');
				
				$ess = null;
				
				$ess_non_ess = (isset($ess_data[strtoupper($dat->eselon)])?$ess_data[strtoupper($dat->eselon)]:'Non Eselon');
				
				$c_ess = $this->general_model->datagrab(array(
					'tabel' => 'ref_eselon',
					'where' => array('eselon' => $ess_non_ess),
					'select' => 'count(id_eselon) as jml,id_eselon'))->row();
				$ess = $c_ess->id_eselon;
					
				$c_jab = $this->general_model->datagrab(array(
					'tabel' => 'ref_jabatan',
					'where' => array(
						'nama_jabatan' => $dat->jabatan,
						'id_bidang' => $id_bidang),
					'select' => 'count(id_jabatan) as jml,id_jabatan'))->row();
				if (empty($c_jab->jml)) {
					$s_jab = array(
						'id_eselon' => $ess,
						'id_jab_jenis' => $dat->jenis_jabatan,
						'id_bidang' => $id_bidang,
						'nama_jabatan' => $dat->jabatan,
						'bup' => !empty($dat->bup)?$dat->bup:58	
					);
					$id_jab = $this->general_model->save_data('ref_jabatan',$s_jab);
				} else {
					$id_jab = $c_jab->id_jabatan;
				}
				
				}
				
				
				if (!empty($id_jab) and !empty($dat->tmt_jabatan)) {
				/* -- Simpan Jabatan -- */
			
				$where_jab = array(
					'id_pegawai' => $id_peg,
					'id_jabatan' => $id_jab,
					'id_unit' => $id_unit,
					'id_bidang' => $id_bidang,
					'tmt_jabatan' => $dat->tmt_jabatan);
				$cek_jab = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where' => $where_jab));
			
				if ($cek_jab->num_rows() == 0) {
				
				$this->general_model->save_data('peg_jabatan',array('status' => 0),'id_pegawai',$id_peg);
				
				$simpan_jabatan = array(
					'id_pegawai' => $id_peg,
					'id_jabatan' => $id_jab,
					'id_unit' => $id_unit,
					'id_bidang' => $id_bidang,
					'tmt_jabatan' => $dat->tmt_jabatan,
					'id_status_pegawai' => '2',
					'status' => '1'
				); $this->general_model->save_data('peg_jabatan',$simpan_jabatan);
				
				}
				}
			
				
				/* -- Simpan Golru -- */
				
				$id_golru = null;
				if ($dat->golru != null) {
					
					$gol_data = $this->general_model->datagrab(array(
					'tabel' => 'ref_golru',
					'where' => array('golongan' => $dat->golru),
					'select' => 'count(id_golru) as jml,id_golru'))->row();
					$id_golru = $gol_data->id_golru;
				}
				
				if ($id_golru != null) {
				$where_golru = array(
					'id_pegawai' => $id_peg,
					'id_golru_jenis' => '1',
					'id_golru' => $id_golru,
					'tmt_pangkat' => $dat->tmt_golru);
				$cek_golru = $this->general_model->datagrab(array('tabel' => 'peg_pangkat','where' => $where_golru));
	
				if ($cek_golru->num_rows() == 0) {
				
				$this->general_model->save_data('peg_pangkat',array('status' => 0),'id_pegawai',$id_peg);
				
				$simpan_golru = array(
					'id_pegawai' => $id_peg,
					'id_golru_jenis' => '1',
					'id_golru' => $id_golru,
					'tmt_pangkat' => $dat->tmt_golru,
					'status' => '1'
				); $this->general_model->save_data('peg_pangkat',$simpan_golru);
				
				}
				}
				
				/* -- Pendidikan -- */
				
				if (!empty($dat->jenjang) and !empty($dat->jurusan)) {
				
				/* ---- Lembaga ---- */
				if (!empty($dat->lembaga)) {
				$c_lembaga = $this->general_model->datagrab(array(
					'tabel' => 'ref_lembaga',
					'where' => array('UPPER(lembaga_pendidikan)' => strtoupper($dat->lembaga)),
					'select' => 'count(*) as jml,id_lembaga'
				))->row();
				if ($c_lembaga->jml > 0) $id_lembaga = $c_lembaga->id_lembaga;
				else $id_lembaga = $this->general_model->save_data('ref_lembaga',array('lembaga_pendidikan' => strtoupper($dat->lembaga)));
				}
				
				/* ---- Jenjang ---- */
				$c_jenjang = $this->general_model->datagrab(array(
					'tabel' => 'ref_bentuk_pendidikan',
					'where' => array('singkatan_pendidikan' => strtoupper($dat->jenjang)),
					'select' => 'count(*) as jml,id_bentuk_pendidikan'))->row();
				if ($c_jenjang->jml > 0) $id_jenjang = $c_jenjang->id_bentuk_pendidikan;
				else $id_jenjang = $this->general_model->save_data('ref_bentuk_pendidikan',array('singkatan_pendidikan' => $dat->jenjang));
				
				/* ---- Jurusan ---- */
				$c_jurusan = $this->general_model->datagrab(array(
					'tabel' => 'ref_jurusan',
					'where' => array('UPPER(jurusan)' => strtoupper($dat->jurusan)),
					'select' => 'count(*) as jml,id_jurusan'
				))->row();
				if ($c_jurusan->jml > 0) $id_jurusan = $c_jurusan->id_jurusan;
				else $id_jurusan = $this->general_model->save_data('ref_jurusan',array('jurusan' => strtoupper($dat->jurusan)));
				
				$where_pendidikan = array(
					'id_pegawai' => $id_peg,
					'id_bentuk_pendidikan' => $id_jenjang,
					'id_jurusan' => $id_jurusan);
				$cek_pendidikan = $this->general_model->datagrab(array('tabel' => 'peg_formal','where' => $where_pendidikan));
	
				if ($cek_pendidikan->num_rows() == 0) {
				
				$this->general_model->save_data('peg_formal',array('status' => 0),'id_pegawai',$id_peg);
				
				$s_formal = array(
					'id_pegawai' => $id_peg,
					'id_bentuk_pendidikan' => $id_jenjang,
					'id_jurusan' => $id_jurusan,
					'status' => '1'
				); 
				
				if(!empty($dat->lulus)) $s_formal['tahun_selesai'] = $dat->lulus;
				if(!empty($dat->lembaga)) $s_formal['id_lembaga'] = $id_lembaga;
				
				
				$this->general_model->save_data('peg_formal',$s_formal);
				}
			}
			
			$total += 1;
		}
			
		$pend = null;	
			
		if ($sm->num_rows() > 0) {	
			die(json_encode(array(
			't' => $total,
			'jml' => $total,
			'persen' => ($e > 0) ? number_format($total/$e*100,0,',','.') : null,
			'total' => $e,
			'sign' => 1
			)));
			
		} else {
			die(json_encode(array(
			'jml' => $total,
			'persen' => ($e > 0) ? number_format($e/$total*100,0,',','.') : null,
			'total' => $e,
			'sign' => 2
			)));	
		}
	}
	
	function balik_tanggal($t) {
		
		if (!empty($t)) {
			$t = str_replace(' ','',$t);
			$t = explode('-',$t);
			if (!empty($t[2]) and !empty($t[2])) return $t[2].'-'.$t[1].'-'.$t[0];
		}
		
		
	} 

}