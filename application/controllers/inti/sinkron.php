<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Sinkron extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
	}
	
	public function index() {
		
	
	}
	
	function dasar($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		
		for ($i = 0; $i < count($data); $i++) {
			
			$nipp = substr(str_replace(array(" "),array(""),$data[$i]['nip']),0,18);
			
			// -- Cek Ada Nama & NIP -- //
			if (!empty($nipp) and !empty($data[$i]['nama'])) {
				
				$c_nip = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => array('nip' => $nipp),'select' => 'count(nip) as jml,id_pegawai'))->row();
		
				// -- Tempat Lahir -- 
				if (!empty($data[$i]['tempat_lahir'])) {
					$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $data[$i]['tempat_lahir']),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
					if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $data[$i]['tempat_lahir']));
					else $id_tmpt = $c_tempat->id_lokasi;
				}
				if (!empty($data[$i]['agama'])) {
					/* -- Agama -- */
					$c_agama = $this->general_model->datagrab(array('tabel' => 'ref_agama','where' => array('agama' => $data[$i]['agama']),'select' => 'count(id_agama) as jml,id_agama'))->row();
					if (empty($c_agama->jml)) $id_agama = $this->general_model->save_data('ref_agama', array('agama' => $data[$i]['agama']));	
					else $id_agama = $c_agama->id_agama;
				}
				
				$nip_simpan = !empty($nipp) ? $nipp : $data[$i]['nip_lama'];
				
				$s_peg = array(
					'id_tipe_pegawai' => 1,
					'nip_lama' => $data[$i]['nip_lama'],
					'nip' => $nipp,
					'nama' => $data[$i]['nama']);
					
					if (!empty($data[$i]['gelar_depan'])) $s_peg['gelar_depan'] = $data[$i]['gelar_depan'];
					if (!empty($data[$i]['gelar_belakang'])) $s_peg['gelar_belakang'] = $data[$i]['gelar_belakang'];
					if (!empty($data[$i]['gender'])) $s_peg['id_jeniskelamin'] = ($data[$i]['gender'] == "L"?"1":"2");
					if (!empty($data[$i]['tempat_lahir'])) $s_peg['id_tempat_lahir'] = $id_tmpt;
					if (!empty($data[$i]['agama'])) $s_peg['id_agama'] = $id_agama;
					if (!empty($data[$i]['tgl_lahir']))	$s_peg['tanggal_lahir'] = $data[$i]['tgl_lahir'];
					if (!empty($data[$i]['mkg_bulan']))	$s_peg['mkg_bulan'] = $data[$i]['mkg_bulan'];
					if (!empty($data[$i]['mkg'])) $s_peg['mkg_tahun'] = $data[$i]['mkg'];
					if (!empty($data[$i]['npwp'])) $s_peg['no_npwp'] = $data[$i]['npwp'];
					if (!empty($data[$i]['alamat'])) $s_peg['alamat'] = $data[$i]['alamat'];
					if (!empty($data[$i]['tinggi'])) $s_peg['tinggi'] = $data[$i]['tinggi'];
					if (!empty($data[$i]['berat'])) $s_peg['berat'] = $data[$i]['berat'];
					if (!empty($data[$i]['rambut'])) $s_peg['rambut'] = $data[$i]['rambut'];
					if (!empty($data[$i]['bentuk_muka'])) $s_peg['bentuk_muka'] = $data[$i]['bentuk_muka'];
					if (!empty($data[$i]['warna_kulit'])) $s_peg['warna_kulit'] = $data[$i]['warna_kulit'];
					if (!empty($data[$i]['ciri_khas'])) $s_peg['ciri_khas'] = $data[$i]['ciri_khas'];
					if (!empty($data[$i]['cacat'])) $s_peg['cacat'] = $data[$i]['cacat'];
					if (!empty($data[$i]['hobi'])) $s_peg['hobi'] = $data[$i]['hobi'];
					if (!empty($data[$i]['telepon'])) $s_peg['telepon'] = $data[$i]['telepon'];
					if (!empty($data[$i]['kodepos'])) $s_peg['kodepos'] = $data[$i]['kodepos'];
					if (!empty($data[$i]['foto'])) $s_peg['photo'] = $data[$i]['foto'];
					if (!empty($data[$i]['tmt_cpns'])) $s_peg['cpns_tmt'] = $data[$i]['tmt_cpns'];
					
				if ($c_nip->jml > 0) {

					$this->general_model->save_data('peg_pegawai',$s_peg,'id_pegawai',$c_nip->id_pegawai);
					$id_peg = $c_nip->id_pegawai;
				} else {
					
					$s_peg['username'] =  $nip_simpan;
					$s_peg['password'] = md5($nip_simpan);
					$id_peg = $this->general_model->save_data('peg_pegawai',$s_peg);
					
				}
					
				
			} // -- Akhir Ada Cek Nama & NIP -- //
			$upd_total+=1;
			
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
		
	}
	
	function dasar_sapk($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		
		for ($i = 0; $i < count($data); $i++) {
			
			$nipp = substr(str_replace(array(" "),array(""),$data[$i]['nip']),0,18);
			
			// -- Cek Ada Nama & NIP -- //
			if (!empty($nipp) and !empty($data[$i]['nama'])) {
				
				$c_nip = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => array('nip' => $nipp),'select' => 'count(nip) as jml,id_pegawai'))->row();
		
				// -- Tempat Lahir -- 
				if (!empty($data[$i]['tempat_lahir'])) {
					$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $data[$i]['tempat_lahir']),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
					if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $data[$i]['tempat_lahir']));
					else $id_tmpt = $c_tempat->id_lokasi;
				}
				if (!empty($data[$i]['agama'])) {
					/* -- Agama -- */
					$c_agama = $this->general_model->datagrab(array('tabel' => 'ref_agama','where' => array('agama' => $data[$i]['agama']),'select' => 'count(id_agama) as jml,id_agama'))->row();
					if (empty($c_agama->jml)) $id_agama = $this->general_model->save_data('ref_agama', array('agama' => $data[$i]['agama']));	
					else $id_agama = $c_agama->id_agama;
				}
				
				$nip_simpan = !empty($nipp) ? $nipp : $data[$i]['nip_lama'];
				
				$s_peg = array(
					'id_tipe_pegawai' => 1,
					'nip_lama' => $data[$i]['nip_lama'],
					'nip' => $nipp,
					'nama' => $data[$i]['nama']);
					
					if (!empty($data[$i]['gelar_depan'])) $s_peg['gelar_depan'] = $data[$i]['gelar_depan'];
					if (!empty($data[$i]['gelar_belakang'])) $s_peg['gelar_belakang'] = $data[$i]['gelar_belakang'];
					if (!empty($data[$i]['gender'])) $s_peg['id_jeniskelamin'] = ($data[$i]['gender'] == "L"?"1":"2");
					if (!empty($data[$i]['tempat_lahir'])) $s_peg['id_tempat_lahir'] = $id_tmpt;
					if (!empty($data[$i]['agama'])) $s_peg['id_agama'] = $id_agama;
					if (!empty($data[$i]['tgl_lahir']))	$s_peg['tanggal_lahir'] = $data[$i]['tgl_lahir'];
					if (!empty($data[$i]['mkg_bulan']))	$s_peg['mkg_bulan'] = $data[$i]['mkg_bulan'];
					if (!empty($data[$i]['mkg'])) $s_peg['mkg_tahun'] = $data[$i]['mkg_tahun'];
					if (!empty($data[$i]['npwp'])) $s_peg['no_npwp'] = $data[$i]['npwp'];
					if (!empty($data[$i]['alamat'])) $s_peg['alamat'] = $data[$i]['alamat'];
					if (!empty($data[$i]['tinggi'])) $s_peg['tinggi'] = $data[$i]['tinggi'];
					if (!empty($data[$i]['berat'])) $s_peg['berat'] = $data[$i]['berat'];
					if (!empty($data[$i]['rambut'])) $s_peg['rambut'] = $data[$i]['rambut'];
					if (!empty($data[$i]['bentuk_muka'])) $s_peg['bentuk_muka'] = $data[$i]['bentuk_muka'];
					if (!empty($data[$i]['warna_kulit'])) $s_peg['warna_kulit'] = $data[$i]['warna_kulit'];
					if (!empty($data[$i]['ciri_khas'])) $s_peg['ciri_khas'] = $data[$i]['ciri_khas'];
					if (!empty($data[$i]['cacat'])) $s_peg['cacat'] = $data[$i]['cacat'];
					if (!empty($data[$i]['hobi'])) $s_peg['hobi'] = $data[$i]['hobi'];
					if (!empty($data[$i]['telepon'])) $s_peg['telepon'] = $data[$i]['telepon'];
					if (!empty($data[$i]['kodepos'])) $s_peg['kodepos'] = $data[$i]['kodepos'];
					if (!empty($data[$i]['foto'])) $s_peg['photo'] = $data[$i]['foto'];
					if (!empty($data[$i]['tmt_cpns'])) $s_peg['cpns_tmt'] = $data[$i]['tmt_cpns'];
					
				if ($c_nip->jml > 0) {

					$this->general_model->save_data('peg_pegawai',$s_peg,'id_pegawai',$c_nip->id_pegawai);
					$id_peg = $c_nip->id_pegawai;
				} else {
					
					$s_peg['username'] =  $nip_simpan;
					$s_peg['password'] = md5($nip_simpan);
					$id_peg = $this->general_model->save_data('peg_pegawai',$s_peg);
					
				}
					
				// Unit
				$c_unit = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('unit' => $data[$i]['nama_unker']),'select' => 'count(id_unit) as jml,id_unit'))->row();
				if (empty($c_unit->jml)) {
					
					$ur = $this->general_model->datagrab(array('tabel' => 'ref_unit','select' => 'MAX(urut) as urut'))->row();
					$simpan_unit = array(
						'unit' => $data[$i]['nama_unker'],
						'aktif' => 1,
						'urut' => (!empty($ur->urut)?$ur->urut+1:1));
					$id_unit = $this->general_model->save_data('ref_unit',$simpan_unit);
				} else {
					$id_unit = $c_unit->id_unit;
				}
				
				// Bidang
				
				$c_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('nama_bidang' => $data[$i]['nama_subunit'],'id_unit' => $id_unit),'select' => 'count(id_bidang) as jml,id_bidang'))->row();
				
				if (empty($c_bid->jml)) {
					
					$ur_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $id_unit),'select' => 'MAX(urut) as urutan'))->row();
					$s_bid = array(
						'id_unit' => $id_unit,
						'nama_bidang' => $data[$i]['nama_subunit'],
						'urut' => $ur_bid->urutan+1);
					$id_bidang = $this->general_model->save_data('ref_bidang',$s_bid);
				} else {
					$id_bidang = $c_bid->id_bidang;
				}	
				
				// Jabatan
				
				 $jft = $data[$i]['fungsional_tertentu'];
				 $tmt_jft = $data[$i]['tmt_fungsional_tertentu'];
				 $struktural = $data[$i]['struktural'];
				 $tmt_s = $data[$i]['tmt_struktural'];
				 
				 $tmt_p = $data[$i]['tmt_pns'];
				 $tmt_cp = $data[$i]['tmt_cpns'];
				 
				 if (!empty($jft)) {
					$jns = 2;
					$jab = $jft;
					$tmt_jab = (!empty($tmt_jft)?$tmt_jft:(!empty($tmt_p)?$tmt_p:$tmt_cp)); 
				 } else if (!empty($struktural)) {
					$jns = 1;
					$jab = $struktural;
					$tmt_jab = (!empty($tmt_s)?$tmt_s:(!empty($tmt_p)?$tmt_p:$tmt_cp)); 
				 } else {
					$jns = 3;
					$jab = $data[$i]['fungsional_umum'];
					$tmt_jab = (!empty($tmt_p)?$tmt_p:$tmt_cp);
				 } 	
				
				// -- Cek Eselon
				
				$c_ess = $this->general_model->datagrab(array(
					'tabel' => 'ref_eselon',
					'where' => array('eselon' => $data[$i]['eselon']),
					'select' => 'count(id_eselon) as jml,id_eselon'))->row();
					
				$non_ess = $this->general_model->datagrab(array(
					'tabel' => 'ref_eselon',
					'search' => array('eselon' => 'Non Eselon'),
					'select' => 'count(id_eselon) as jml,id_eselon'))->row();
				if ($non_ess->jml > 0) {
					$id_non = $non_ess->id_eselon;
				} else {
					$ur_ess = $this->general_model->datagrab(array(
						'tabel' => 'ref_eselon',
						'select' => 'MAX(urut) as urut'))->row();
					$ur_ess = !empty($ur_ess->urut) ? $ur_ess->urut+1:1;
					$id_non = $this->general_model->save_data('ref_eselon',array('eselon' => 'Non Eselon','urut' => $ur_ess));
				}
				
				$c_jab = $this->general_model->datagrab(array(
					'tabel' => 'ref_jabatan',
					'where' => array(
						'nama_jabatan' => $jab,
						'id_bidang' => $id_bidang),
					'select' => 'count(id_jabatan) as jml,id_jabatan'))->row();
				if (
					(!empty($c_ess->id_eselon) and !empty($data[$i]['struktural'])) or 
					(empty($c_ess->id_eselon) and !empty($data[$i]['fungsional_tertentu'])) or
					(empty($c_ess->id_eselon) and !empty($data[$i]['fungsional_umum']))
					) {
				if (empty($c_jab->jml)) {
					
					if (!empty($c_ess->id_eselon) and !empty($data[$i]['struktural'])) $id_eselon_save = $c_ess->id_eselon;
					else $id_eselon_save = $id_non;
				
					$s_jab = array(
						'id_eselon' => $id_eselon_save,
						'id_jab_jenis' => $jns,
						'id_bidang' => $id_bidang,
						'nama_jabatan' => $jab,
						'stat_jab' => 1,
						'bup' => 58	
					);
					
					$id_jab = $this->general_model->save_data('ref_jabatan',$s_jab);
				} else {
					$id_jab = $c_jab->id_jabatan;
				}
				}
				
				/* -- Simpan Jabatan -- */
				
				if (!empty($jab) and !empty($tmt_jab)) {
			
				$where_jab = array(
					'id_pegawai' => $id_peg,
					'id_jabatan' => $id_jab,
					'id_unit' => $id_unit,
					'id_bidang' => $id_bidang,
					'tmt_jabatan' => $tmt_jab);
				$cek_jab = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where' => $where_jab));
			
				if ($cek_jab->num_rows() == 0) {
				
				$this->general_model->save_data('peg_jabatan',array('status' => 0),'id_pegawai',$id_peg);
				
				$simpan_jabatan = array(
					'id_pegawai' => $id_peg,
					'id_jabatan' => $id_jab,
					'id_unit' => $id_unit,
					'id_bidang' => $id_bidang,
					'tmt_jabatan' => $tmt_jab,
					'id_status_pegawai' => ($data[$i]['status_pns'] == "PNS"?2:1)
				); $this->general_model->save_data('peg_jabatan',$simpan_jabatan);
				
				}
				
				$this->urutan(array('id_peg' => $id_peg,'tabel' => 'peg_jabatan','kol' => 'id_peg_jabatan','order' => 'tmt_jabatan desc'));
				
				}
			
				
				/* -- Simpan Golru -- */
				
				$gol_data = $this->general_model->datagrab(array(
					'tabel' => 'ref_golru',
					'where' => array('golongan' => $data[$i]['gol_akhir']),
					'select' => 'count(id_golru) as jml,id_golru'))->row();
				
				if (!empty($gol_data->id_golru)) {

					$where_golru = array(
						'id_pegawai' => $id_peg,
						'id_golru_jenis' => '1',
						'id_golru' => $gol_data->id_golru,
						'tmt_pangkat' => $data[$i]['tmt_gol_akhir']);
					$cek_golru = $this->general_model->datagrab(array('tabel' => 'peg_pangkat','where' => $where_golru));
		
					if ($cek_golru->num_rows() == 0) {
					
					$this->general_model->save_data('peg_pangkat',array('status' => 0),'id_pegawai',$id_peg);
					
					$simpan_golru = array(
						'id_pegawai' => $id_peg,
						'id_golru_jenis' => '1',
						'id_golru' => $gol_data->id_golru,
						'tmt_pangkat' => $data[$i]['tmt_gol_akhir']); 
					$this->general_model->save_data('peg_pangkat',$simpan_golru);
					
					}
					
					$this->urutan(array('id_peg' => $id_peg,'tabel' => 'peg_pangkat','kol' => 'id_peg_pangkat','order' => 'tmt_pangkat desc'));
					
				}
				
			} // -- Akhir Ada Cek Nama & NIP -- //
			$upd_total+=1;
			
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function formal($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				$id_lembaga = null;
				if (!empty($data[$i]['instansi_nama'])) {
					$c_lembaga = $this->general_model->datagrab(array('tabel' => 'ref_lembaga','where' => array('lembaga_pendidikan' => $data[$i]['instansi_nama']),'select' => 'count(id_lembaga) as jml,id_lembaga'))->row();
					if (empty($c_lembaga->jml)) $id_lembaga = $this->general_model->save_data('ref_lembaga', array('lembaga_pendidikan' => $data[$i]['instansi_nama']));
					else $id_lembaga = $c_lembaga->id_lembaga;
				}
				$id_jurusan = null;
				if (!empty($data[$i]['nama_jurusan'])) {
					$c_jurusan = $this->general_model->datagrab(array('tabel' => 'ref_jurusan','where' => array('jurusan' => $data[$i]['nama_jurusan']),'select' => 'count(id_jurusan) as jml,id_jurusan'))->row();
					if (empty($c_jurusan->jml)) $id_jurusan = $this->general_model->save_data('ref_jurusan', array('jurusan' => $data[$i]['nama_jurusan']));	
					else $id_jurusan = $c_jurusan->id_jurusan;
				}
				$id_jenjang = null;
				if (!empty($data[$i]['jenjang'])) {
					$c_jenjang = $this->general_model->datagrab(array('tabel' => 'ref_bentuk_pendidikan','where' => array('singkatan_pendidikan' => $data[$i]['jenjang']),'select' => 'count(id_bentuk_pendidikan) as jml,id_bentuk_pendidikan'))->row();
					if (empty($c_jenjang->jml)) $id_jenjang = $this->general_model->save_data('ref_bentuk_pendidikan', array('singkatan_pendidikan' => $data[$i]['jenjang']));	
					else $id_jenjang = $c_jenjang->id_bentuk_pendidikan;
				}
				$id_fakultas = null;
				if (!empty($data[$i]['fakultas'])) {
					$c_fakultas = $this->general_model->datagrab(array('tabel' => 'ref_fakultas','where' => array('fakultas' => $data[$i]['fakultas']),'select' => 'count(id_fakultas) as jml,id_fakultas'))->row();
					if (empty($c_fakultas->jml)) $id_fakultas = $this->general_model->save_data('ref_fakultas', array('fakultas' => $data[$i]['fakultas']));	
					else $id_fakultas = $c_fakultas->id_fakultas;
				}
				
				
				$s_formal = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_bentuk_pendidikan' => $id_jenjang,
					'lokasi' => $data[$i]['instansi_lokasi'],
					'tahun_mulai' => $data[$i]['tahun_masuk'],
					'tahun_selesai' => $data[$i]['tahun_lulus'],
					'no_ijazah' => $data[$i]['no_ijazah'],
					'tanggal_ijazah' => $data[$i]['tgl_ijazah'],
					'nama_kepala' => $data[$i]['instansi_kepala'],
					'no_sk' => $data[$i]['no_sk'],
					'tanggal_sk' => $data[$i]['tgl_sk'],
					'tipe' => $data[$i]['tipe']
				);
				
				if (!empty($data[$i]['instansi_nama'])) $s_formal['id_lembaga'] = $id_lembaga;
				if (!empty($data[$i]['fakultas'])) $s_formal['id_fakultas'] = $id_fakultas;
				if (!empty($data[$i]['nama_jurusan'])) $s_formal['id_jurusan'] = $id_jurusan;
				
				$where_cek = array();
				if (!empty($data[$i]['jenjang'])) $where_cek['id_bentuk_pendidikan'] = $id_jenjang;
				if (!empty($data[$i]['instansi_nama'])) $where_cek['id_lembaga'] = $id_lembaga;
				if (!empty($data[$i]['nama_jurusan'])) $where_cek['id_jurusan'] = $id_jurusan;
				if (!empty($data[$i]['tahun_masuk'])) $where_cek['tahun_mulai'] = $data[$i]['tahun_masuk'];
				
				$c_cek = $this->general_model->datagrab(array(
					'tabel' => 'peg_formal',
					'where' => $where_cek,
					'select' => 'count(id_peg_formal) as jml,id_peg_formal'))->row();
				if ($c_cek->jml > 0) {
					$this->general_model->save_data('peg_formal',$s_formal,'id_peg_formal',$c_cek->id_peg_formal);
				} else {
					$this->general_model->save_data('peg_formal',$s_formal);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_formal','kol' => 'id_peg_formal','order' => 'tahun_selesai desc'));

			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function informal($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
			if ($c_nip->jml > 0) {
				
				if (!empty($data[$i]['nama_instansi'])) {
				
				$s_informal = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'lembaga' => $data[$i]['nama_instansi'],
					'tempat' => $data[$i]['tempat'],
					'kelompok' => $data[$i]['kelompok'],
					'jenis' => $data[$i]['jenis'],
					'lokasi' => $data[$i]['lokasi'],
					'tanggal_mulai' => $data[$i]['tgl_mulai'],
					'tanggal_selesai' => $data[$i]['tgl_selesai'],
					'penyelenggara' => $data[$i]['penyelenggara'],
					'no_sttpl' => $data[$i]['no_sttpl'],
					'tanggal_sttpl' => $data[$i]['tgl_sttpl'],
					'angkatan' => $data[$i]['angkatan'],
					'tahun' => $data[$i]['tahun'],
					'jam' => $data[$i]['jumlah_jam'],
				);
				
				$c_cek = $this->general_model->datagrab(array(
					'tabel' => 'peg_informal',
					'where' => array(
						'lembaga' => $data[$i]['nama_instansi'],
						'tahun' => $data[$i]['tahun']),
					'select' => 'count(id_peg_informal) as jml,id_peg_informal'))->row();
				if ($c_cek->jml > 0) {
					$this->general_model->save_data('peg_informal',$s_informal,'id_peg_informal',$c_cek->id_peg_informal);
				} else {
					$this->general_model->save_data('peg_informal',$s_informal);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_informal','kol' => 'id_peg_informal','order' => 'tanggal_selesai desc'));
				
				}
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function jabatan($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		//$nip = null;
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			$counter = 'awal';
			if ($c_nip->jml > 0) {
				
				//if ($data[$i]['nip'] != $nip) $upd_total+=1;
				
				$c_penetap = $this->general_model->datagrab(array('tabel' => 'ref_penetap','where' => array('penetap' => $data[$i]['nama_penetap']),'select' => 'count(id_penetap) as jml,id_penetap'))->row();
				if ($c_penetap->jml == 0) {
					$id_penetap = $this->general_model->save_data('ref_penetap', array('penetap' => $data[$i]['nama_penetap']));
				} else {
					$id_penetap = $c_penetap->id_penetap;
				}
				
				$c_status_peg = $this->general_model->datagrab(array('tabel' => 'ref_status_pegawai','where' => array('nama_status' => $data[$i]['status_pegawai']),'select' => 'count(id_status_pegawai) as jml,id_status_pegawai'))->row();
				if ($c_status_peg->jml == 0) {
					$id_status = $this->general_model->save_data('ref_status_pegawai', array('nama_status' => $data[$i]['status_pegawai'],'tipe' => 1));
				} else {
					$id_status = $c_status_peg->id_status_pegawai;
				}
				
				if ($data[$i]['nama_unker'] == NULL) {
					$nama = 'Belum Ada Unit Kerja';
					$akt = 0;
				} else {
					$nama = $data[$i]['nama_unker'];
					$akt = 1;
				}
				
				$c_unit = $this->general_model->datagrab(array('tabel' => 'ref_unit','where' => array('unit' => $nama),'select' => 'count(id_unit) as jml,id_unit'))->row();
				if (empty($c_unit->jml)) {
					
					$ur = $this->general_model->datagrab(array('tabel' => 'ref_unit','select' => 'MAX(urut) as urut'))->row();
					$simpan_unit = array(
						'unit' => $nama,
						'aktif' => $akt,
						'urut' => (!empty($ur->urut)?$ur->urut+1:1));
					$id_unit = $this->general_model->save_data('ref_unit',$simpan_unit);
				} else {
					$id_unit = $c_unit->id_unit;
				}
				
				// Bidang
				
				if (preg_match("/^sekretaris/", strtolower(str_replace(' ','',$data[$i]['nama_jabatan']))) and !preg_match("/^sekretariat/", strtolower(str_replace(' ','',$data[$i]['nama_unker'])))) {
					if (preg_match("/^sekretariat/", strtolower(str_replace(' ','',$data[$i]['nama_bidang'])))) {
						$nama = $data[$i]['nama_bidang'];
					} else {
						$nama = 'Sekretariat';
					} 
					
					$akt = 1;
				} else if ($data[$i]['nama_bidang'] == NULL) {
					$nama = 'Belum Ada Unit Organisasi';
					$akt = 0;
				} else {
					$nama = $data[$i]['nama_bidang'];
					$akt = 1;
				}
				
				$c_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('nama_bidang' => $nama,'id_unit' => $id_unit),'select' => 'count(id_bidang) as jml,id_bidang'))->row();
				
				if ($c_bid->jml == 0 or $c_bid->jml == NULL) {
					
					$ur_bid = $this->general_model->datagrab(array('tabel' => 'ref_bidang','where' => array('id_unit' => $id_unit),'select' => 'MAX(urut) as urutan'))->row();
					$s_bid = array(
						'id_unit' => $id_unit,
						'nama_bidang' => $nama,
						'aktif' => $akt,
						'urut' => $ur_bid->urutan+1);
					$id_bidang = $this->general_model->save_data('ref_bidang',$s_bid);
				} else {
					
					$id_bidang = $c_bid->id_bidang;
				}	
				
				
				$c_ess = $this->general_model->datagrab(array(
					'tabel' => 'ref_eselon',
					'where' => array('eselon' => $data[$i]['eselon']),
					'select' => 'count(id_eselon) as jml,id_eselon'))->row();
					
				$non_ess = $this->general_model->datagrab(array(
					'tabel' => 'ref_eselon',
					'search' => array('UPPER(eselon)' => 'NON'),
					'select' => 'count(id_eselon) as jml,id_eselon'))->row();
				if ($non_ess->jml > 0) {
					$id_non = $non_ess->id_eselon;
				} else {
					$ur_ess = $this->general_model->datagrab(array(
						'tabel' => 'ref_eselon',
						'select' => 'MAX(urut) as urut'))->row();
					$ur_ess = !empty($ur_ess->urut) ? $ur_ess->urut+1:1;
					$id_non = $this->general_model->save_data('ref_eselon',array('eselon' => 'Non Eselon','urut' => $ur_ess));
				}
				
				$c_jab = $this->general_model->datagrab(array(
					'tabel' => 'ref_jabatan',
					'where' => array(
						'nama_jabatan' => $data[$i]['nama_jabatan'],
						'id_bidang' => $id_bidang),
					'select' => 'count(id_jabatan) as jml,id_jabatan'))->row();
				
				if ($c_jab->jml == 0) {

					if ($data[$i]['nama_jenis_jabatan'] == "Jabatan Struktural") $id_eselon_save = $c_ess->id_eselon;
					else $id_eselon_save = $id_non;
					
					if (empty($id_eselon_save)) {
						$ur_ess = $this->general_model->datagrab(array(
						'tabel' => 'ref_eselon',
						'select' => 'MAX(urut) as urut'))->row();
						$ur_ess = !empty($ur_ess->urut) ? $ur_ess->urut+1:1;
						$id_eselon_save = $this->general_model->save_data('ref_eselon',array('eselon' => $data[$i]['eselon'],'urut' => $ur_ess));
					}
					
					$s_jab = array(
						'id_eselon' => $id_eselon_save,
						'id_jab_jenis' => $data[$i]['id_jenis_jabatan'],
						'id_bidang' => $id_bidang,
						'nama_jabatan' => $data[$i]['nama_jabatan'],
						'stat_jab' => 1,
						'bup' => 58	
					);

					$id_jab = $this->general_model->save_data('ref_jabatan',$s_jab);
				} else {
					$id_jab = $c_jab->id_jabatan;
				}
				
				
				/* -- Simpan Jabatan -- */
				
				if (!empty($data[$i]['nama_jabatan']) and !empty($data[$i]['tmt_jabatan_alias'])) {
			
				$where_jab = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_jabatan' => $id_jab,
					'id_unit' => $id_unit,
					'id_bidang' => $id_bidang,
					'tmt_jabatan' => $data[$i]['tmt_jabatan_alias']);
				$cek_jab = $this->general_model->datagrab(array('tabel' => 'peg_jabatan','where' => $where_jab));

				$simpan_jabatan = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_jabatan' => $id_jab,
					'id_unit' => $id_unit,
					'id_bidang' => $id_bidang,
					//'perpanjangan' => $data[$i]['perpanjangan'],
					'tmt_jabatan' => $data[$i]['tmt_jabatan_alias'],
					'selesai_jabatan' => $data[$i]['tgl_selesai'],
					'no_sk' => $data[$i]['no_sk'],
					'tanggal_sk' => $data[$i]['tgl_sk'],
					//'jabatan_manual' => $data[$i]['jabatan_manual'],
					//'eselon_manual' => $data[$i]['eselon_manual'],
					'id_penetap' => $id_penetap,
					'id_status_pegawai' => $id_status
				); 
				
				if ($cek_jab->num_rows() == 0) {
					
					$this->general_model->save_data('peg_jabatan',$simpan_jabatan);
				
				} else {
					
					$this->general_model->save_data('peg_jabatan',$simpan_jabatan,'id_peg_jabatan',$cek_jab->row()->id_peg_jabatan);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_jabatan','kol' => 'id_peg_jabatan','order' => 'tmt_jabatan desc'));
				
				
				}
				
				if ($counter != $data[$i]['counter']) $upd_total+=1;
				$counter = $data[$i]['counter'];
				//$nip = $data[$i]['nip'];
			} 

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function pangkat($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$c_penetap = $this->general_model->datagrab(array('tabel' => 'ref_penetap','where' => array('penetap' => $data[$i]['penetap']),'select' => 'count(id_penetap) as jml,id_penetap'))->row();
				if ($c_penetap->jml == 0) {
					$id_penetap = $this->general_model->save_data('ref_penetap', array('penetap' => $data[$i]['penetap']));
				} else {
					$id_penetap = $c_penetap->id_penetap;
				}

				$id_golru = $this->general_model->datagrab(array('tabel' => 'ref_golru','where' => array('golongan' => $data[$i]['golru'])))->row();
				if (!empty($id_golru->id_golru) and !empty($data[$i]['tmt_pangkat'])) {
	
				$s_pangkat = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'tmt_pangkat' => $data[$i]['tmt_pangkat'],
					'no_sk' => $data[$i]['no_sk'],
					'tgl_sk' => $data[$i]['tgl_sk'],
					'kredit' => $data[$i]['kredit'],
					'nota_persetujuan_nomor' => $data[$i]['nota_persetujuan_nomor'],
					'nota_persetujuan_tanggal' => $data[$i]['nota_persetujuan_tanggal'],
					'kredit' => $data[$i]['kredit'],
					'penetap' => $id_penetap,
					//jenis_kenaikan_pangkat
					'id_golru' => $id_golru->id_golru
				);
				
				/* -- Simpan Pangkat -- */
				
			
				$where_pangkat = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_golru' => $id_golru->id_golru,
					'tmt_pangkat' => $data[$i]['tmt_pangkat']);
				$cek_pkt = $this->general_model->datagrab(array('tabel' => 'peg_pangkat','where' => $where_pangkat));
				
				if ($cek_pkt->num_rows() == 0) {
					$this->general_model->save_data('peg_pangkat',$s_pangkat);
				} else {
					$this->general_model->save_data('peg_pangkat',$s_pangkat,'id_peg_pangkat',$cek_pkt->row()->id_peg_pangkat);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_pangkat','kol' => 'id_peg_pangkat','order' => 'tmt_pangkat desc'));
				
				}

			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function kgb($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$c_penetap = $this->general_model->datagrab(array('tabel' => 'ref_penetap','where' => array('penetap' => $data[$i]['nama_penetap']),'select' => 'count(id_penetap) as jml,id_penetap'))->row();
				if ($c_penetap->jml == 0) {
					$id_penetap = $this->general_model->save_data('ref_penetap', array('penetap' => $data[$i]['nama_penetap']));
				} else {
					$id_penetap = $c_penetap->id_penetap;
				}
				
				$id_golru = $this->general_model->datagrab(array('tabel' => 'ref_golru','where' => array('golongan' => $data[$i]['golongan'])))->row();
				if (!empty($id_golru->id_golru) and !empty($data[$i]['tmt_kgb'])) {
	
				$s_kgb = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'tmt_kgb' => $data[$i]['tmt_kgb'],
					'no_sk' => $data[$i]['no_sk'],
					'tanggal_sk' => $data[$i]['tgl_sk'],
					'gaji' => $data[$i]['gaji_pokok_baru'],
					'gaji_sebelum' => $data[$i]['gaji_pokok_lama'],
					'id_penetap' => $id_penetap,
					'id_golru' => $id_golru->id_golru
				);
				
				/* -- Simpan Pangkat -- */
				
				$this->general_model->save_data('peg_kgb',array('status' => 0),'id_pegawai',$c_nip->id_pegawai);
				
				$where_kgb = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'gaji' => $data[$i]['gaji_pokok_baru'],
					'tmt_kgb' => $data[$i]['tmt_kgb']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_kgb','where' => $where_kgb));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_kgb',$s_kgb);
				} else {
					$this->general_model->save_data('peg_kgb',$s_kgb,'id_peg_kgb',$cek_p->row()->id_peg_kgb);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_kgb','kol' => 'id_peg_kgb','order' => 'tmt_kgb desc'));
				
				}
				
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function diklatpim($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				if (!empty($data[$i]['penyelenggara'])) {
				
				$c_diklatpim = $this->general_model->datagrab(array('tabel' => 'ref_diklatpim','where' => array('diklatpim' => $data[$i]['nama_diklat']),'select' => 'count(id_diklatpim) as jml,id_diklatpim'))->row();
				if ($c_diklatpim->jml == 0) {
					$id_diklatpim = $this->general_model->save_data('ref_diklatpim', array('diklatpim' => $data[$i]['nama_diklat']));
				} else {
					$id_diklatpim = $c_diklatpim->id_diklatpim;
				}
				
				if (!empty($data[$i]['penyelenggara'])) {
					$c_lembaga = $this->general_model->datagrab(array('tabel' => 'ref_lembaga','where' => array('lembaga_pendidikan' => $data[$i]['penyelenggara']),'select' => 'count(id_lembaga) as jml,id_lembaga'))->row();
					if (empty($c_lembaga->jml)) $id_lembaga = $this->general_model->save_data('ref_lembaga', array('lembaga_pendidikan' => $data[$i]['penyelenggara']));
					else $id_lembaga = $c_lembaga->id_lembaga;
				}
				
				
				$s_diklatpim = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'tanggal_mulai' => $data[$i]['tgl_mulai'],
					'tanggal_selesai' => $data[$i]['tgl_selesai'],
					'id_lembaga' => $id_lembaga,
					'id_diklatpim' => $id_diklatpim,
					'angkatan' => $data[$i]['angkatan'],
					'jam' => $data[$i]['jumlah_jam'],
					'no_sttpl' => $data[$i]['no_sttpl'],
					'tanggal_sttpl' => $data[$i]['tgl_sttpl'],
					'predikat' => $data[$i]['predikat'],
					'lokasi' => $data[$i]['lokasi'],
					'tahun' => $data[$i]['tahun'],
				);
				
				/* -- Simpan Diklatpim -- */
				
				$where_diklatpim = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_lembaga' => $id_lembaga,
					'id_diklatpim' => $id_diklatpim,
					'tanggal_sttpl' => $data[$i]['tgl_sttpl']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_diklatpim','where' => $where_diklatpim));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_diklatpim',$s_diklatpim);
				} else {
					$this->general_model->save_data('peg_diklatpim',$s_diklatpim,'id_peg_diklatpim',$cek_p->row()->id_peg_diklatpim);
				}
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_diklatpim','kol' => 'id_peg_diklatpim','order' => 'tanggal_selesai desc'));
				}
			} 
			
			$upd_total+=1;

		}
		
		}
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => (count($data) > 0)?1:0,
			'total' => $total
		)));
	
	}
	
	function belajar($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		

		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				if (!empty($data[$i]['nama_jurusan'])) {
					$c_jurusan = $this->general_model->datagrab(array('tabel' => 'ref_jurusan','where' => array('jurusan' => $data[$i]['nama_jurusan']),'select' => 'count(id_jurusan) as jml,id_jurusan'))->row();
					if (empty($c_jurusan->jml)) $id_jurusan = $this->general_model->save_data('ref_jurusan', array('jurusan' => $data[$i]['nama_jurusan']));	
					else $id_jurusan = $c_jurusan->id_jurusan;
				}
				if (!empty($data[$i]['nama_pendidikan'])) {
					$c_jenjang = $this->general_model->datagrab(array('tabel' => 'ref_bentuk_pendidikan','where' => array('singkatan_pendidikan' => $data[$i]['nama_pendidikan']),'select' => 'count(id_bentuk_pendidikan) as jml,id_bentuk_pendidikan'))->row();
					if (empty($c_jenjang->jml)) $id_jenjang = $this->general_model->save_data('ref_bentuk_pendidikan', array('singkatan_pendidikan' => $data[$i]['nama_pendidikan']));	
					else $id_jenjang = $c_jenjang->id_bentuk_pendidikan;
				}
				if (!empty($data[$i]['nama_pendidikan_terakhir'])) {
					$c_jenjang_terakhir = $this->general_model->datagrab(array('tabel' => 'ref_bentuk_pendidikan','where' => array('singkatan_pendidikan' => $data[$i]['nama_pendidikan_terakhir']),'select' => 'count(id_bentuk_pendidikan) as jml,id_bentuk_pendidikan'))->row();
					if (empty($c_jenjang_terakhir->jml)) $id_jenjang_terakhir = $this->general_model->save_data('ref_bentuk_pendidikan', array('singkatan_pendidikan' => $data[$i]['nama_pendidikan_terakhir']));	
					else $id_jenjang_terakhir = $c_jenjang_terakhir->id_bentuk_pendidikan;
				}
				if (!empty($data[$i]['fakultas'])) {
					$c_fakultas = $this->general_model->datagrab(array('tabel' => 'ref_fakultas','where' => array('fakultas' => $data[$i]['fakultas']),'select' => 'count(id_fakultas) as jml,id_fakultas'))->row();
					if (empty($c_fakultas->jml)) $id_fakultas = $this->general_model->save_data('ref_fakultas', array('fakultas' => $data[$i]['fakultas']));	
					else $id_fakultas = $c_fakultas->id_fakultas;
				}
				
				$s_belajar = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_pendidikan' => $id_jenjang,
					'nama_instansi' => $data[$i]['nama_instansi'],
					'alamat_instansi' => $data[$i]['alamat_instansi'],
					'status_instansi' => $data[$i]['status_instansi'],
					'id_fakultas' => $id_fakultas,
					'id_jurusan' => $id_jurusan,
					'tanggal_mulai' => $data[$i]['tmt_belajar'],
					'tanggal_selesai' => $data[$i]['tmt_selesai'],
					'tanggal_sk' => $data[$i]['tgl_sk'],
					'no_sk' => $data[$i]['no_sk'],
					'tanggal_ijazah' => $data[$i]['tgl_ijazah'],
					'no_ijazah' => $data[$i]['no_ijazah'],
					'tipe' => $data[$i]['tipe'],
					'anggaran' => $data[$i]['anggaran']
				);
				
				if (!empty($id_jenjang_terakhir)) $s_belajar['id_pendidikan_terakhir'] = $id_jenjang_terakhir;
				
				/* -- Simpan Belajar -- */
			
				$where_belajar = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'nama_instansi' => $data[$i]['nama_instansi'],
					'id_jurusan' => $id_jurusan);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_ijintugas_belajar','where' => $where_belajar));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_ijintugas_belajar',$s_belajar);
				} else {
					$this->general_model->save_data('peg_ijintugas_belajar',$s_belajar,'id_belajar',$cek_p->row()->id_belajar);
				}
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_ijintugas_belajar','kol' => 'id_belajar','order' => 'tanggal_sk desc'));
	
			} 
			
			$upd_total+=1;

		}
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function cuti($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
			if ($c_nip->jml > 0) {
				
				$c_penetap = $this->general_model->datagrab(array('tabel' => 'ref_penetap','where' => array('penetap' => $data[$i]['nama_penetap']),'select' => 'count(id_penetap) as jml,id_penetap'))->row();
				if ($c_penetap->jml == 0) {
					$id_penetap = $this->general_model->save_data('ref_penetap', array('penetap' => $data[$i]['nama_penetap']));
				} else {
					$id_penetap = $c_penetap->id_penetap;
				}
				
				$c_cuti = $this->general_model->datagrab(array('tabel' => 'ref_cuti','where' => array('cuti' => $data[$i]['nama_cuti']),'select' => 'count(id_cuti) as jml,id_cuti'))->row();
				if ($c_cuti->jml == 0) {
					$id_cuti = $this->general_model->save_data('ref_cuti', array('cuti' => $data[$i]['nama_cuti']));
				} else {
					$id_cuti = $c_cuti->id_cuti;
				}
				
				$s_cuti = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_cuti' => $id_cuti,
					'tanggal_mulai' => $data[$i]['tgl_mulai'],
					'tanggal_selesai' => $data[$i]['tgl_selesai'],
					'jumlah' => $data[$i]['jml'],
					'no_sk' => $data[$i]['surat_no'],
					'tanggal_sk' => $data[$i]['tgl_cetak'],
					'penetap' => $id_penetap
				);
				
				/* -- Simpan Belajar -- */
				
				$this->general_model->save_data('peg_cuti',array('status' => 0),'id_pegawai',$c_nip->id_pegawai);
				
				$where_cuti = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_cuti' => $id_cuti,
					'tanggal_mulai' => $data[$i]['tgl_mulai']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_cuti','where' => $where_cuti));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_cuti',$s_cuti);
				} else {
					$this->general_model->save_data('peg_cuti',$s_cuti,'id_peg_cuti',$cek_p->row()->id_peg_cuti);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_cuti','kol' => 'id_peg_cuti','order' => 'tanggal_sk desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function penghargaan($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$c_penetap = $this->general_model->datagrab(array('tabel' => 'ref_penetap','where' => array('penetap' => $data[$i]['nama_penetap']),'select' => 'count(id_penetap) as jml,id_penetap'))->row();
				if ($c_penetap->jml == 0) {
					$id_penetap = $this->general_model->save_data('ref_penetap', array('penetap' => $data[$i]['nama_penetap']));
				} else {
					$id_penetap = $c_penetap->id_penetap;
				}
				
				$c_penghargaan = $this->general_model->datagrab(array('tabel' => 'ref_penghargaan','where' => array('penghargaan' => $data[$i]['nama_penghargaan']),'select' => 'count(id_penghargaan) as jml,id_penghargaan'))->row();
				if ($c_penghargaan->jml == 0) {
					$id_penghargaan = $this->general_model->save_data('ref_penghargaan', array('penghargaan' => $data[$i]['nama_penghargaan']));
				} else {
					$id_penghargaan = $c_penghargaan->id_penghargaan;
				}
				
				$s_penghargaan = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_penghargaan' => $id_penghargaan,
					'tanggal_peroleh' => $data[$i]['tgl_diperoleh'],
					//'no_sk' => $data[$i]['surat_no'],
					'tanggal_sk' => $data[$i]['tgl_diperoleh'],
					'id_penetap' => $id_penetap,
					'tgl_usulan' => $data[$i]['tgl_usulan'],
					'tgl_undangan' => $data[$i]['tgl_undangan'],
					'no_undangan' => $data[$i]['no_undangan'],
				);
				
				/* -- Simpan Belajar -- */
				
				$where_penghargaan = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_penghargaan' => $id_penghargaan,
					'tanggal_peroleh' => $data[$i]['tgl_diperoleh']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_penghargaan','where' => $where_penghargaan));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_penghargaan',$s_penghargaan);
				} else {
					$this->general_model->save_data('peg_penghargaan',$s_penghargaan,'id_peg_penghargaan',$cek_p->row()->id_peg_penghargaan);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_penghargaan','kol' => 'id_peg_penghargaan','order' => 'tanggal_sk desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function karpeg($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {

				$s_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_kartu' => 1,
					'tanggal_berlaku' => $data[$i]['tgl_berlaku'],
					'no_kartu' => $data[$i]['no_karpeg']
				);
				
				/* -- Simpan Karpeg -- */
				
				$where_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'no_kartu' => $data[$i]['no_karpeg'],
					'tanggal_berlaku' => $data[$i]['tgl_berlaku']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_kartu','where' => $where_kartu));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_kartu',$s_kartu);
				} else {
					$this->general_model->save_data('peg_kartu',$s_kartu,'id_peg_kartu',$cek_p->row()->id_peg_kartu);
				}
			} 
			
			$upd_total+=1;

		}
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function karsu($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$s_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_kartu' => 2,
					'tanggal_berlaku' => $data[$i]['tgl_berlaku'],
					'no_kartu' => $data[$i]['no_karsu']
				);
				
				/* -- Simpan Karpeg -- */
				
				$where_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'no_kartu' => $data[$i]['no_karsu'],
					'tanggal_berlaku' => $data[$i]['tgl_berlaku']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_kartu','where' => $where_kartu));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_kartu',$s_kartu);
				} else {
					$this->general_model->save_data('peg_kartu',$s_kartu,'id_peg_kartu',$cek_p->row()->id_peg_kartu);
				}
				
			} 
			
			$upd_total+=1;

		}
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function taspen($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$s_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'no_taspen' => $data[$i]['no_taspen'],
					'tgl_berlaku' => $data[$i]['tgl_berlaku'],
					'gaji_terakhir' => $data[$i]['gaji_terakhir'],
					'tunjangan_suami_istri' => $data[$i]['tunjangan_suami_istri'],
					'tunjangan_anak' => $data[$i]['tunjangan_anak']
				);
				
				/* -- Simpan Karpeg -- */
				
				$where_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'no_taspen' => $data[$i]['no_taspen'],
					'tgl_berlaku' => $data[$i]['tgl_berlaku']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_taspen','where' => $where_kartu));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_taspen',$s_kartu);
				} else {
					$this->general_model->save_data('peg_taspen',$s_kartu,'id_peg_taspen',$cek_p->row()->id_peg_taspen);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_taspen','kol' => 'id_peg_taspen','order' => 'tgl_berlaku desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function askes($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$s_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_kartu' => 3,
					'tanggal_berlaku' => $data[$i]['tgl_berlaku'],
					'no_kartu' => $data[$i]['no_askes']
				);
				
				/* -- Simpan Askes -- */
				
				$where_kartu = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'no_kartu' => $data[$i]['no_askes'],
					'tanggal_berlaku' => $data[$i]['tgl_berlaku']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_kartu','where' => $where_kartu));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_kartu',$s_kartu);
				} else {
					$this->general_model->save_data('peg_kartu',$s_kartu,'id_peg_kartu',$cek_p->row()->id_peg_kartu);
				}
				
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function hukdis($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
			if ($c_nip->jml > 0) {
				
				$c_penetap = $this->general_model->datagrab(array('tabel' => 'ref_penetap','where' => array('penetap' => $data[$i]['penetap']),'select' => 'count(id_penetap) as jml,id_penetap'))->row();
				if ($c_penetap->jml == 0) {
					$id_penetap = $this->general_model->save_data('ref_penetap', array('penetap' => $data[$i]['penetap']));
				} else {
					$id_penetap = $c_penetap->id_penetap;
				}
				
				$c_hukdis = $this->general_model->datagrab(array(
					'tabel' => 'ref_hukdis',
					'where' => array('hukdis' => $data[$i]['nama_hukdis']),
					'select' => 'count(id_hukdis) as jml,id_hukdis'))->row();
				if ($c_hukdis->jml == 0) {
					
					$st_berhenti = (preg_match("/^berhenti/", strtolower(str_replace(' ','',$data[$i]['nama_hukdis'])))) ? 1 : null;
					
					$id_hukdis = $this->general_model->save_data('ref_hukdis',
						array(
							'hukdis' => $data[$i]['nama_hukdis'],
							'id_hukdis_level' => $data[$i]['tingkat'],
							'kondisi' => $st_berhenti));
				} else {
					$id_hukdis = $c_hukdis->id_hukdis;
				}
				
				
				if (preg_match("/^berhenti/", strtolower(str_replace(' ','',$data[$i]['nama_hukdis'])))) {
					
					// -- Jabatan di berhentikan -- //
				
					$cek_berhenti = $this->general_model->datagrab(array(
						'tabel' => array(
							'peg_jabatan p' => '',
							'ref_status_pegawai j' => 'j.id_status_pegawai = p.id_status_pegawai'),
						'select' => 'count(p.id_peg_jabatan) as jml,p.id_peg_jabatan',
						'where' => array('p.id_pegawai' => $c_nip->id_pegawai,"UPPER(nama_status) LIKE '%BERHENTI%'" => NULL)
					))->row();
					
					if ($cek_berhenti->jml == 0) {
						
						$sv_berhenti = $this->general_model->datagrab(array(
							'tabel' => 'peg_jabatan',
							'where' => array('id_pegawai = '.$c_nip->id_pegawai.' AND status = 1' => null)
						));
						
						if ($sv_berhenti->num_rows() > 0) {
				
							$sp = $sv_berhenti->row();
							
							$sts_berhenti = $this->general_model->datagrab(array('tabel' => 'ref_status_pegawai', 'where' => array("UPPER(nama_status) LIKE '%BERHENTI%'" => NULL)))->row();
							
							if ($sts_berhenti->nama_status != NULL) {
							$simpan_pemberhentian = array(
								'id_pegawai' => $sp->id_pegawai,
								'id_unit' => $sp->id_unit,
								'id_jabatan' => $sp->id_jabatan,
								'id_bidang' => $sp->id_bidang,
								'id_atasan' => $sp->id_atasan,
								'id_atasan_atasan' => $sp->id_atasan_atasan,
								'id_penetap' => $id_penetap,
								'id_status_pegawai' => $sts_berhenti->id_status_pegawai,
								'no_sk' => $data[$i]['no_sk'],
								'tanggal_sk' => $data[$i]['tgl_sk'],
								'tmt_jabatan' => $data[$i]['tmt_sk'],
								'selesai_jabatan' => $sp->selesai_jabatan,
								'id_golru' => $sp->id_golru,
							);
							
							$for_jab = $this->general_model->save_data('peg_jabatan',$simpan_pemberhentian);

							$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_jabatan','kol' => 'id_peg_jabatan','order' => 'tmt_jabatan desc'));

							}
							
						} 
						
					} 
					
				}

				$s_hukdis = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_hukdis' => $id_hukdis,
					'id_hukdis_level' => $data[$i]['tingkat'],
					'kasus' => $data[$i]['kasus'],
					'tanggal_laporan' => $data[$i]['tgl_laporan'],
					'tanggal_kasus' => $data[$i]['tgl_kasus'],
					'tanggal_periksa' => $data[$i]['tgl_periksa'],
					'no_sk' => $data[$i]['no_sk'],
					'tanggal_sk' => $data[$i]['tgl_sk'],
					'tmt_hukdis' => $data[$i]['tmt_sk'],
					'selesai' => $data[$i]['tgl_selesai'],
					'id_penetap' => $id_penetap,
				);
				
				/* -- Simpan Hukdis -- */
				
				$this->general_model->save_data('peg_hukdis',array('status' => 0),'id_pegawai',$c_nip->id_pegawai);
				
				$where_hukdis = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_hukdis' => $id_hukdis,
					'tmt_hukdis' => $data[$i]['tmt_sk']);
				$cek_hukdis = $this->general_model->datagrab(array('tabel' => 'peg_hukdis','where' => $where_hukdis));
				
				if ($cek_hukdis->num_rows() == 0) {
					$this->general_model->save_data('peg_hukdis',$s_hukdis);
				} else {
					$this->general_model->save_data('peg_hukdis',$s_hukdis,'id_peg_hukdis',$cek_hukdis->row()->id_peg_hukdis);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_hukdis','kol' => 'id_peg_hukdis','order' => 'tmt_hukdis desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function pensiun($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$nip_takada = 0;
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$c_penetap = $this->general_model->datagrab(array('tabel' => 'ref_penetap','where' => array('penetap' => $data[$i]['penetap']),'select' => 'count(id_penetap) as jml,id_penetap'))->row();
				if ($c_penetap->jml == 0) {
					$id_penetap = $this->general_model->save_data('ref_penetap', array('penetap' => $data[$i]['penetap']));
				} else {
					$id_penetap = $c_penetap->id_penetap;
				}
				
				$c_pensiun = $this->general_model->datagrab(array(
					'tabel' => 'ref_pensiun',
					'where' => array('nama_pensiun' => $data[$i]['kode_pensiun']),'select' => 'count(id_pensiun) as jml,id_pensiun'))->row();
				if ($c_pensiun->jml == 0) {
					$id_pensiun = $this->general_model->save_data('ref_pensiun', array('nama_pensiun' => $data[$i]['kode_pensiun']));
				} else {
					$id_pensiun = $c_pensiun->id_pensiun;
				}
				
				// -- Jabatan di pensiunkan -- //
				
				$cek_pensiun = $this->general_model->datagrab(array(
					'tabel' => array(
						'peg_jabatan p' => '',
						'ref_status_pegawai j' => 'j.id_status_pegawai = p.id_status_pegawai'),
					'select' => 'count(p.id_peg_jabatan) as jml,p.id_peg_jabatan',
					'where' => array('p.id_pegawai' => $c_nip->id_pegawai,"UPPER(nama_status) LIKE '%PENSIUN%'" => NULL)
				))->row();
				
				if ($cek_pensiun->jml == 0) {
					
					$sv_pensiun = $this->general_model->datagrab(array(
						'tabel' => 'peg_jabatan',
						'where' => array('id_pegawai = '.$c_nip->id_pegawai.' AND status = 1' => null)
					));
					
					if ($sv_pensiun->num_rows() > 0) {
			
						$sp = $sv_pensiun->row();
						
						$sts_pensiun = $this->general_model->datagrab(array('tabel' => 'ref_status_pegawai', 'where' => array("UPPER(nama_status) LIKE '%PENSIUN%'" => NULL)))->row();
						
						if ($sts_pensiun->nama_status != NULL) {
						$simpan_pensiun = array(
							'id_pegawai' => $sp->id_pegawai,
							'id_unit' => $sp->id_unit,
							'id_jabatan' => $sp->id_jabatan,
							'id_bidang' => $sp->id_bidang,
							'id_atasan' => $sp->id_atasan,
							'id_atasan_atasan' => $sp->id_atasan_atasan,
							'id_penetap' => $id_penetap,
							'id_status_pegawai' => $sts_pensiun->id_status_pegawai,
							'no_sk' => $data[$i]['no_sk'],
							'tanggal_sk' => $data[$i]['tgl_sk'],
							'tmt_jabatan' => $data[$i]['tmt_sk'],
							'selesai_jabatan' => $sp->selesai_jabatan,
							'id_golru' => $sp->id_golru,
						);
						
						$for_jab = $this->general_model->save_data('peg_jabatan',$simpan_pensiun);

						$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_jabatan','kol' => 'id_peg_jabatan','order' => 'tmt_jabatan desc'));

						}
						
					} 
					
				} else {
					$for_jab = $cek_pensiun->id_peg_jabatan;
				}

				if (isset($for_jab)) {
				
				$s_pensiun = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_peg_jabatan' => $for_jab,
					'id_pensiun' => $id_pensiun,
					'id_penetap' => $id_penetap,
					'tmt_sk' => $data[$i]['tmt_sk'],
					'tgl_sk' => $data[$i]['tgl_sk'],
					'no_sk' => $data[$i]['no_sk'],
					'keterangan' => $data[$i]['keterangan']				
				);
				
				$where_pensiun = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_pensiun' => $id_pensiun);
				$cek_pns = $this->general_model->datagrab(array('tabel' => 'peg_pensiun','where' => $where_pensiun));
				
				if ($cek_pns->num_rows() == 0) {
					$this->general_model->save_data('peg_pensiun',$s_pensiun);
				} else {
					$this->general_model->save_data('peg_pensiun',$s_pensiun,'id_peg_pensiun',$cek_pns->row()->id_peg_pensiun);
				}
				}
				
			} else {
				
				$nip_takada +=1;
				
			}
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'nip_no' => $nip_takada,
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function dp3($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$id_penilai = NULL;
				$penetap = $data[$i]['penetap'];
				if (!empty($data[$i]['nip_penilai'])) {
					$c_penilai = $this->general_model->datagrab(array('tabel' => 'peg_pegawai','where' => array('nip' => $data[$i]['nip_penilai']),'select' => 'count(id_pegawai) as jml,id_pegawai'))->row();
					if (isset($c_penilai->jml)) $id_penilai = $c_penilai->id_pegawai;
					else $penetap = $data[$i]['nip_penilai'];
				}
				
				$s_nilai = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_penilai' => $id_penilai,
					'tanggal' => '31-12-'.$data[$i]['tahun'],
					'nilai1' => $data[$i]['nilai_kesetiaan'],
					'nilai2' => $data[$i]['nilai_prestasi'],
					'nilai3' => $data[$i]['nilai_tanggung_jawab'],
					'nilai4' => $data[$i]['nilai_ketaatan'],
					'nilai5' => $data[$i]['nilai_kejujuran'],
					'nilai6' => $data[$i]['nilai_kerjasama'],
					'nilai7' => $data[$i]['nilai_prakarsa'],
					'nilai8' => $data[$i]['nilai_kepemimpinan'],
					'jumlah' => $data[$i]['nilai_total'],
					'penilai_manual' => $penetap
				);
				
				$where_nilai = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'YEAR(tanggal)' => $data[$i]['tahun']);
				$cek_pkt = $this->general_model->datagrab(array('tabel' => 'peg_nilai','where' => $where_nilai));
				
				if ($cek_pkt->num_rows() == 0) {
					$this->general_model->save_data('peg_nilai',$s_nilai);
				} else {
					$this->general_model->save_data('peg_nilai',$s_nilai,'id_peg_nilai',$cek_pkt->row()->id_peg_nilai);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_nilai','kol' => 'id_peg_nilai','order' => 'tanggal desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function organisasi($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0) {
				
				$s_nilai = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'periode' => $data[$i]['periode'],
					'nama_organisasi' => $data[$i]['nama_organisasi'],
					'kedudukan_di_organisasi' => $data[$i]['nama_organisasi'],
					'thn_mulai' => $data[$i]['thn_mulai'],
					'thn_selesai' => $data[$i]['thn_selesai'],
					'tempat' => $data[$i]['tempat'],
					'nama_pimpinan' => $data[$i]['nama_pimpinan']
				);
				
				$where_organisasi = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'periode' => $data[$i]['periode'],
					'nama_organisasi' => $data[$i]['nama_organisasi'],);
				$cek_data = $this->general_model->datagrab(array('tabel' => 'peg_organisasi','where' => $where_organisasi));
				
				if ($cek_data->num_rows() == 0) {
					$this->general_model->save_data('peg_organisasi',$s_nilai);
				} else {
					$this->general_model->save_data('peg_organisasi',$s_nilai,'id_peg_organisasi',$cek_data->row()->id_peg_organisasi);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_organisasi','kol' => 'id_peg_organisasi','order' => 'thn_mulai desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function kawin($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
				
			if ($c_nip->jml > 0 and !empty($data[$i]['nama_istri_suami'])) {
				
				$id_pekerjaan = null;
				$id_tmpt = null;
				
				if (!empty($data[$i]['tempat_lahir'])) {
					$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $data[$i]['tempat_lahir']),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
					if (!isset($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $data[$i]['tempat_lahir']));
					else $id_tmpt = $c_tempat->id_lokasi;
				}
				
				if (!empty($data[$i]['nama_pendidikan'])) {
					$c_jenjang = $this->general_model->datagrab(array('tabel' => 'ref_bentuk_pendidikan','where' => array('singkatan_pendidikan' => $data[$i]['nama_pendidikan']),'select' => 'count(id_bentuk_pendidikan) as jml,id_bentuk_pendidikan'))->row();
					if (!isset($c_jenjang->jml)) $id_jenjang = $this->general_model->save_data('ref_bentuk_pendidikan', array('singkatan_pendidikan' => $data[$i]['nama_pendidikan']));	
					else $id_jenjang = $c_jenjang->id_bentuk_pendidikan;
				}
				
				if (!empty($data[$i]['nama_pekerjaan'])) {
					$c_pekerjaan = $this->general_model->datagrab(array('tabel' => 'ref_pekerjaan','where' => array('pekerjaan' => $data[$i]['nama_pekerjaan']),'select' => 'count(id_pekerjaan) as jml,id_pekerjaan'))->row();
					if (!isset($c_pekerjaan->jml)) $id_pekerjaan = $this->general_model->save_data('ref_pekerjaan', array('pekerjaan' => $data[$i]['nama_pekerjaan']));	
					else $id_pekerjaan = $c_pekerjaan->id_pekerjaan;
				}
				
				$s_kawin = array(
					'id_pegawai' => $c_nip->id_pegawai,
					//'id_statuskawin' => $data[$i]['periode'],
					'id_bentuk_pendidikan' => $id_jenjang,
					'id_pekerjaan' => $id_pekerjaan,
					'nama_istri_suami' => $data[$i]['nama_istri_suami'],
					'tanggal_kawin' => $data[$i]['tgl_nikah'],
					'ke' => $data[$i]['kawin_ke'],
					'tanggal_lahir' => $data[$i]['tgl_lahir'],
					'jenis' => $data[$i]['jenis'],
					'id_tempat_lahir' => $id_tmpt,
				);
				
				$where_kawin = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'nama_istri_suami' => $data[$i]['nama_istri_suami']);
				$cek_data = $this->general_model->datagrab(array('tabel' => 'peg_perkawinan','where' => $where_kawin));
				
				if ($cek_data->num_rows() == 0) {
					$this->general_model->save_data('peg_perkawinan',$s_kawin);
				} else {
					$this->general_model->save_data('peg_perkawinan',$s_kawin,'id_perkawinan',$cek_data->row()->id_perkawinan);
				}
				
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function anak($offs = null) {

		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
			
			if ($c_nip->jml > 0) {
				$id_jenjang = null;
				if (!empty($data[$i]['nama_pendidikan'])) {
					$c_jenjang = $this->general_model->datagrab(array('tabel' => 'ref_bentuk_pendidikan','where' => array('singkatan_pendidikan' => $data[$i]['nama_pendidikan']),'select' => 'count(id_bentuk_pendidikan) as jml,id_bentuk_pendidikan'))->row();
					if (empty($c_jenjang->jml)) $id_jenjang = $this->general_model->save_data('ref_bentuk_pendidikan', array('singkatan_pendidikan' => $data[$i]['nama_pendidikan']));	
					else $id_jenjang = $c_jenjang->id_bentuk_pendidikan;
				}
				$id_pekerjaan = null;
				if (!empty($data[$i]['nama_pekerjaan'])) {
					$c_pekerjaan = $this->general_model->datagrab(array('tabel' => 'ref_pekerjaan','where' => array('pekerjaan' => $data[$i]['nama_pekerjaan']),'select' => 'count(id_pekerjaan) as jml,id_pekerjaan'))->row();
					if (empty($c_pekerjaan->jml)) $id_pekerjaan = $this->general_model->save_data('ref_pekerjaan', array('pekerjaan' => $data[$i]['nama_pekerjaan']));	
					else $id_pekerjaan = $c_pekerjaan->id_pekerjaan;
				}
				$id_tmpt = null;
				if (!empty($data[$i]['tempat_lahir'])) {
					$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $data[$i]['tempat_lahir']),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
					if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $data[$i]['tempat_lahir']));
					else $id_tmpt = $c_tempat->id_lokasi;
				}
				
				$s_anak = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_jeniskelamin' => $data[$i]['id_jeniskelamin'],
					'id_statusanak' => $data[$i]['status_anak'],
					'id_bentuk_pendidikan' => $id_jenjang,
					'id_tempat_lahir' => $id_tmpt,
					'nama' => $data[$i]['nama'],
					'tgl_lahir' => $data[$i]['tgl_lahir'],
					'anak_ke' => $data[$i]['anak_ke'],
					'id_pekerjaan' => $id_pekerjaan
				);
				
				/* -- Simpan Anak -- */
				
				$where_anak = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'nama' => $data[$i]['nama']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_anak','where' => $where_anak));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_anak',$s_anak);
				} else {
					$this->general_model->save_data('peg_anak',$s_anak,'id_anak',$cek_p->row()->id_anak);
				}
				$this->general_model->save_data('peg_anak',array('status' => 0),'id_pegawai',$c_nip->id_pegawai);
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_anak','kol' => 'id_anak','order' => 'tgl_lahir desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function keluarga($offs = null) {
		
		$data = $this->input->post('data');
		$total = $this->input->post('total');
		
		$upd_total = $offs;
		if (!empty($data)) {
		for ($i = 0; $i < count($data); $i++) {
			
			$c_nip = $this->general_model->datagrab(array(
				'tabel' => 'peg_pegawai',
				'where' => array('nip' => $data[$i]['nip']),
				'select' => 'count(nip) as jml,id_pegawai'))->row();
				
			if ($c_nip->jml > 0) {
				$id_pekerjaan = null;
				if (!empty($data[$i]['nama_pekerjaan'])) {
					$c_pekerjaan = $this->general_model->datagrab(array('tabel' => 'ref_pekerjaan','where' => array('pekerjaan' => $data[$i]['nama_pekerjaan']),'select' => 'count(id_pekerjaan) as jml,id_pekerjaan'))->row();
					if (empty($c_pekerjaan->jml)) $id_pekerjaan = $this->general_model->save_data('ref_pekerjaan', array('pekerjaan' => $data[$i]['nama_pekerjaan']));	
					else $id_pekerjaan = $c_pekerjaan->id_pekerjaan;
				}
				$id_keluarga = null;
				if (!empty($data[$i]['v_hubungan'])) {
					$c_keluarga = $this->general_model->datagrab(array('tabel' => 'ref_keluarga','where' => array('keluarga' => $data[$i]['v_hubungan']),'select' => 'count(id_keluarga) as jml,id_keluarga'))->row();
					if (empty($c_keluarga->jml)) $id_keluarga = $this->general_model->save_data('ref_keluarga', array('keluarga' => $data[$i]['v_hubungan']));	
					else $id_keluarga = $c_keluarga->id_keluarga;
				}
				
				$id_tmpt = null;
				if (!empty($data[$i]['tempat_lahir'])) {
					$c_tempat = $this->general_model->datagrab(array('tabel' => 'ref_lokasi','where' => array('lokasi' => $data[$i]['tempat_lahir']),'select' => 'count(id_lokasi) as jml,id_lokasi'))->row();
					if (empty($c_tempat->jml)) $id_tmpt = $this->general_model->save_data('ref_lokasi', array('lokasi' => $data[$i]['tempat_lahir']));
					else $id_tmpt = $c_tempat->id_lokasi;
				}
				
				$id_statuskeluarga = 1;
				
				$s_keluarga = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'id_keluarga' => $id_keluarga,
					'id_statuskeluarga' => $id_statuskeluarga,
					'id_pekerjaan' => $id_pekerjaan,
					'id_tempat_lahir' => $id_tmpt,
					'nama' => $data[$i]['nama'],
					'tgl_lahir' => $data[$i]['tgl_lahir'],
					'keterangan' => $data[$i]['keterangan']
				);
				
				if (!empty($data[$i]['gender'])) $s_keluarga['id_jeniskelamin'] = ($data[$i]['gender'] == "L"?"1":"2");
				
				/* -- Simpan Keluarga -- */
				
				$where_keluarga = array(
					'id_pegawai' => $c_nip->id_pegawai,
					'nama' => $data[$i]['nama']);
				$cek_p = $this->general_model->datagrab(array('tabel' => 'peg_keluarga','where' => $where_keluarga));
				
				if ($cek_p->num_rows() == 0) {
					$this->general_model->save_data('peg_keluarga',$s_keluarga);
				} else {
					$this->general_model->save_data('peg_keluarga',$s_keluarga,'id_peg_keluarga',$cek_p->row()->id_peg_keluarga);
				}
				
				$this->urutan(array('id_peg' => $c_nip->id_pegawai,'tabel' => 'peg_keluarga','kol' => 'id_peg_keluarga','order' => 'tgl_lahir desc'));
				
			} 
			
			$upd_total+=1;

		}
		}
		
		die(json_encode(array(
			'jml' => $upd_total,
			'persen' => ($total > 0) ? number_format($upd_total/$total*100,0,',','.') : null,
			'status' => ($upd_total < $total)?1:0,
			'total' => $total
		)));
	
	}
	
	function urutan($par) {

		$last = $this->general_model->datagrab(array(
			'tabel'=> $par['tabel'],
			'where'=> array('id_pegawai'=>$par['id_peg']),
			'order'=> $par['order'],
			'select'=> $par['kol'],
			'limit' => 1,
			'offset' => 0))->row();
		
		if (!empty($last)) {
		$this->general_model->save_data($par['tabel'],array('status'=>'0'),'id_pegawai',$par['id_peg']);
		$this->general_model->save_data($par['tabel'],array('status'=>'1'),$par['kol'],$last->$par['kol']);
		}
		
	}
}