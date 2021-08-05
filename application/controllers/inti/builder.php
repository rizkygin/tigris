<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Builder extends CI_Controller {
	
	function __construct() {
	
		parent::__construct();
		//login_check($this->session->userdata('login_state'));

	}

	function process_db($app,$tabel,$nav) {
		
		$errors = array();
		
		$cek = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi',
			'where' => array('folder' => $app[4])
		));
		
		$app_plus = array(
			'kode_aplikasi' => $app[1],
			'nama_aplikasi' => $app[2],
			'deskripsi' => $app[3],
			'folder' => $app[4],
			'warna' => $app[5]
		);
		
		if ($cek->num_rows() > 0) {
			$id_app = $cek->row()->id_aplikasi;
			$this->general_model->save_data('ref_aplikasi',$app_plus,'id_aplikasi',$cek->row()->id_aplikasi);
			
		} else {
			
			$u = $this->general_model->datagrab(array(
				'tabel' => 'ref_aplikasi',
				'select' => 'max(urut) as urutan'
			))->row();
			$app_plus['urut'] = ($u->urutan+1);
			$id_app = $this->general_model->save_data('ref_aplikasi',$app_plus);
		}
		
		// Create Module Icon 

		$path_app = './application/controllers/'.$app[4].'/'.$app[4].'.png';
		$path_logo = './assets/logo/'.$app[4].'.png';
		if (file_exists($path_app)) {
			
			if (file_exists($path_logo)) unlink($path_logo);
			copy ( $path_app , $path_logo );
			
		}
		
		$this->load->dbforge();
		
		// Create Log Table
		
		if (!$this->db->table_exists('log_db')) {
			
			$fields = array(
				'id_log_db' => array(
					'type' => 'int',
					'auto_increment' => TRUE,
					'constraint' => 11,
					'null' => FALSE),
				'type' => array(
					'type' => 'int',
					'constraint' => 1),
				'moddate' => array(
					'type' => 'datetime'),
				'detail' => array(
					'type' => 'text')
				
			);
			
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id_log_db', TRUE);

			$this->dbforge->create_table('log_db');
			
		} 
		
		$total = 0;
		$done = 0;
		$column = 0;
		$donec = 0;
		foreach($tabel as $tab => $c_tab) {
			$total +=1;
			if (!$this->db->table_exists($tab)) {
				
				$fields = array();
				$ex_fields = array();
				foreach($c_tab as $col => $c_col) {
					
					if (in_array($c_col[1],array('timestamp','decimal'))) $ex_fields[] = $c_col;
					else {
					
					$fields[$c_col[0]] = array(
							'type' => $c_col[1],
							'null' => @$c_col[3]);
					if (!empty($c_col[4])) {
						$fields[$c_col[0]]['auto_increment'] = TRUE;
						$key = $c_col[0];
					}
					if (!empty($c_col[2])) $fields[$c_col[0]]['constraint'] = str_replace('.',',',$c_col[2]);
					if (!empty($c_col[5])) $fields[$c_col[0]]['default'] = $c_col[5];
					}
				}
					
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key($key, TRUE);

				$this->dbforge->create_table($tab);
				
				foreach($ex_fields as $c) {
					
					$this->db->query('ALTER TABLE '.$tab.' ADD '.$c[0].' '.$c[1].(!empty($c[2])?'('.str_replace('.',',',$c[2]).')':null).' '.(!empty($c[5])?'DEFAULT '.$c[5]:null));
					
				}				
				
				$si = array(
					'type' => 1,
					'moddate' => date('Y-m-d H:i:s'),
					'detail' => 'Tabel <strong>'.$tab.'</strong> ditambahkan'	
				);
				
				$this->general_model->save_data('log_db',$si);
				
			} else {
			
				$done+=1;
				$ex_fields = array();
				foreach($c_tab as $col => $c_col) {
					$column += 1;
					if (!$this->db->field_exists($c_col[0], $tab)) {
						if (in_array($c_col[1],array('timestamp','decimal'))) {
							$this->db->query('ALTER TABLE '.$tab.' ADD '.$c_col[0].' 
								'.$c_col[1].
								(!empty($c_colc[2])?'('.str_replace('.',',',$c_col[2]).')':null).' '.
								(!empty($c_colc[5])?'DEFAULT '.$c_col[5]:null));
						} else {
							
						$fields = array(
							$c_col[0] => array(
								'type' => $c_col[1],
								'null' => @$c_col[3]));
						if (!empty($c_col[2])) $fields[$c_col[0]]['constraint'] = $c_col[2];
						if (!empty($c_col[4])) $fields[$c_col[0]]['auto_increment'] = TRUE;
						if (!empty($c_col[5])) $fields[$c_col[0]]['default'] = $c_col[5];						
						
						$this->dbforge->add_column($tab, $fields);
						
						}
						
						$si = array(
							'type' => 1,
							'moddate' => date('Y-m-d H:i:s'),
							'detail' => 'Kolom <strong>'.$c_col[0].'</strong> pada <strong>'.$tab.'</strong> ditambahkan'	
						); $this->general_model->save_data('log_db',$si);

					} else {
						$donec += 1;
					}
				}
			
			}
		}
		
		$db_build = array(
			'total' => $total,
			'done' => $done,
			'kolom' => $column,
			'koldone' => $donec
		);
		
		$no = 0;
		foreach($nav as $dat) {
			
			$or_null = empty($dat[6])?" OR link IS NULL":null;
			$where_kode = array(
					'id_aplikasi' => $id_app,
					'ref' => $dat[1],
					'judul' => $dat[4],
					"(link = '".$dat[6]."'".$or_null.")" => null);
			if (!empty($dat[2])) $where_kode['kode'] = $dat[2];
			
			$cek = $this->general_model->datagrab(array(
				'tabel' => 'nav', 
				'where' => $where_kode,
				'select' => 'count(*) as jml'))->row();

			if ($cek->jml == 0) { 
				$id_par = null;
				if (!empty($dat[5])) {
					
					$cek_par = $this->general_model->datagrab(array(
						'tabel' => 'nav', 
						'where' => array(
							'id_aplikasi' => $id_app,
							'judul' => $dat[5],
							'ref' => $dat[1]),
						'select' => 'id_nav'))->row();
					if (isset($cek_par->id_nav)) $id_par = $cek_par->id_nav;
					else $errors[] = 'Nav '.$dat[4];
				}
				
				$max_num = $this->general_model->datagrab(array(
					'tabel' => 'nav','where' => array('id_aplikasi' => $id_app),
					'select' => 'MAX(urut) as max_num'
				))->row();
                $simpan = array(
                    'id_aplikasi' => $id_app,
                    'judul' => $dat[4],
                    'tipe' => $dat[3],
                    'ref' => $dat[1],
                    'kode' => $dat[2],
                    'urut' => $max_num->max_num+1,
                    'aktif' => 1
                );
                if(@$dat[6])$simpan['link'] = $dat[6];
                if(@$dat[7])$simpan['fa'] = $dat[7];
                				
				if (!empty($id_par)) $simpan['id_par_nav'] = $id_par;
		 
				$this->general_model->save_data('nav',$simpan);
				$no+=1;
				
				$si = array(
					'type' => 2,
					'moddate' => date('Y-m-d H:i:s'),
					'detail' => 'Modul <b>'.$dat[4].'</b> ditambahkan'	
				); $this->general_model->save_data('log_db',$si);
					
			}
		}
		
		$odie = json_encode(array(
			'sign' => 1,
			'text' => '
				Pemutakhiran Database berhasil dilakukan ...
				<p style="margin-top: 20px; text-align: center">'.anchor(
					'inti/builder/log_db',
					'<i class="fa fa-database fa-btn"></i> Detail Struktur',
					'class="btn btn-sm btn-default" target="_blank"').'</p>',
			'total' => $db_build['total'],
			'errors' => implode('<br>',$errors),
			'done' => $db_build['done'],
			'kolom' => $db_build['kolom'],
			'koldone' => $db_build['koldone'])
		);
		
		return $odie;
		
	}
	
	function data_db($db) {
		
		foreach($db as $k => $v) {
			
			foreach($v as $e => $val) {
				
			$smpn = array();
			foreach($val as $vv => $kk) {
				
				$smpn[$vv] = $kk;
			}
			
			$cek = $this->general_model->datagrab(array(
				'tabel' => $k,
				'where' => $smpn
			));
			if ($cek->num_rows() == 0) $this->general_model->save_data($k,$smpn);
			}
		}
		
	}
	
	function log_db() {
		
		$data['title'] = 'Catatan Pemutakhiran Database';
		
		//$tabel = $this->table->generate();
		
		$tabel = '<div class="alert"><i class="fa fa-database fa-btn"></i> Masa pembangunan ...</div>';
		
		$data['tabel'] = $tabel;
		
		$data['content'] = 'umum/standard_view';
		$this->load->view('home',$data);
		
	}
	
	function inisialisasi($par = null, $app = null) {
		
		if (!empty($par)) {
			switch($par) {
				
				case "db":
					
					if (!$this->general_model->check_tab('parameter')) {
					$this->general_model->data_query("
					CREATE TABLE parameter (
					  param varchar(32) NOT NULL,
					  val text NOT NULL,
					  PRIMARY KEY (param)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
					}
					
					if (!$this->general_model->check_tab('nav')) {
					$this->general_model->data_query("
					CREATE TABLE nav (
					  id_nav int(11) unsigned NOT NULL AUTO_INCREMENT,
					  id_par_nav int(11) DEFAULT NULL,
					  id_aplikasi int(1) DEFAULT NULL,
					  ref int(1) DEFAULT NULL,
					  kode varchar(5) DEFAULT NULL,
					  tipe int(1) DEFAULT NULL,
					  judul varchar(128) DEFAULT NULL,
					  link varchar(128) DEFAULT NULL,
					  fa varchar(50) DEFAULT NULL,
					  urut int(3) DEFAULT NULL,
					  aktif int(1) DEFAULT NULL,
					  PRIMARY KEY (id_nav)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					if (!$this->general_model->check_tab('peg_pegawai')) {
					$this->general_model->data_query("
					CREATE TABLE peg_pegawai (
					  id_pegawai int(11) NOT NULL AUTO_INCREMENT,
					  id_agama int(1) NOT NULL,
					  id_jeniskelamin int(1) NOT NULL,
					  id_gol_darah int(1) NOT NULL,
					  id_tempat_lahir int(11) NOT NULL,
					  id_statuskawin int(11) DEFAULT NULL,
					  id_suku int(11) DEFAULT NULL,
					  id_kelurahan int(11) NOT NULL,
					  id_tipe_pegawai int(1) DEFAULT NULL,
					  username varchar(32) NOT NULL,
					  password varchar(32) NOT NULL,
					  nip char(18) NOT NULL,
					  nip_lama varchar(18) DEFAULT NULL,
					  no_nik varchar(30) DEFAULT NULL,
					  no_npwp varchar(30) DEFAULT NULL,
					  nama varchar(50) NOT NULL,
					  gelar_depan varchar(20) DEFAULT NULL,
					  gelar_belakang varchar(20) DEFAULT NULL,
					  tanggal_lahir date DEFAULT NULL,
					  hobi varchar(100) DEFAULT NULL,
					  tinggi int(1) DEFAULT NULL,
					  berat int(1) DEFAULT NULL,
					  rambut varchar(100) DEFAULT NULL,
					  bentuk_muka varchar(100) DEFAULT NULL,
					  warna_kulit varchar(100) DEFAULT NULL,
					  ciri_khas varchar(100) DEFAULT NULL,
					  cacat varchar(100) DEFAULT NULL,
					  alamat varchar(150) DEFAULT NULL,
					  kodepos varchar(10) DEFAULT NULL,
					  telepon varchar(12) DEFAULT NULL,
					  email varchar(80) NOT NULL,
					  pin varchar(20) DEFAULT NULL,
					  website varchar(150) DEFAULT NULL,
					  photo varchar(150) DEFAULT NULL,
					  cpns_tmt date DEFAULT NULL,
					  cpns_no varchar(100) DEFAULT NULL,
					  cpns_tanggal date DEFAULT NULL,
					  cpns_berkas varchar(50) DEFAULT NULL,
					  mkg_tahun int(1) DEFAULT NULL,
					  mkg_bulan int(1) DEFAULT NULL,
					  last_login datetime DEFAULT NULL,
					  mn_jabatan varchar(255) DEFAULT NULL COMMENT 'Manual Jabatan',
					  mn_golru varchar(255) DEFAULT NULL COMMENT 'Manual Golongan',
					  status int(1) DEFAULT '1',
					  PRIMARY KEY (id_pegawai),
					  UNIQUE KEY username (username),
					  UNIQUE KEY nip (nip),
					  KEY id_jeniskelamin (id_jeniskelamin),
					  KEY id_agama (id_agama),
					  KEY id_gol_darah (id_gol_darah),
					  KEY id_kelurahan (id_kelurahan)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					if (!$this->general_model->check_tab('pegawai_role')) {
					$this->general_model->data_query("
					CREATE TABLE pegawai_role (
					  id_peg_role int(11) NOT NULL AUTO_INCREMENT,
					  id_pegawai int(11) NOT NULL,
					  id_role int(3) NOT NULL,
					  PRIMARY KEY (id_peg_role),
					  KEY id_pegawai (id_pegawai,id_role),
					  KEY id_role (id_role)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					if (!$this->general_model->check_tab('ref_aplikasi')) {
					$this->general_model->data_query("
					CREATE TABLE ref_aplikasi (
					  id_aplikasi int(1) NOT NULL AUTO_INCREMENT,
					  id_par_aplikasi int(1) DEFAULT NULL,
					  urut int(1) NOT NULL,
					  kode_aplikasi varchar(15) NOT NULL,
					  nama_aplikasi varchar(50) NOT NULL,
					  deskripsi varchar(80) DEFAULT NULL,
					  folder varchar(30) DEFAULT NULL,
					  warna varchar(7) DEFAULT NULL,
					  aktif int(11) NOT NULL,
					  PRIMARY KEY (id_aplikasi)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					if (!$this->general_model->check_tab('ref_role')) {
					$this->general_model->data_query("
					CREATE TABLE ref_role (
					  id_role int(3) NOT NULL AUTO_INCREMENT,
					  id_aplikasi int(1) NOT NULL,
					  nama_role varchar(80) NOT NULL,
					  PRIMARY KEY (id_role),
					  KEY id_aplikasi (id_aplikasi)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					if (!$this->general_model->check_tab('ref_role_unit')) {
					$this->general_model->data_query("
					CREATE TABLE ref_role_unit (
					  id_role_unit int(11) NOT NULL AUTO_INCREMENT,
					  id_role int(3) NOT NULL,
					  id_unit int(11) NOT NULL,
					  PRIMARY KEY (id_role_unit)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					if (!$this->general_model->check_tab('ref_role_nav')) {
					$this->general_model->data_query("
					CREATE TABLE ref_role_nav (
					  id_role_nav int(11) NOT NULL AUTO_INCREMENT,
					  id_role int(11) NOT NULL,
					  id_nav int(11) NOT NULL,
					  PRIMARY KEY (id_role_nav)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					
					if (!$this->general_model->check_tab('log_book')) {
					$this->general_model->data_query("
						CREATE TABLE `log_book` (
						  `id_log` int(11) NOT NULL AUTO_INCREMENT,
						  `kode` varchar(20) DEFAULT NULL,
						  `keterangan` varchar(100) DEFAULT NULL,
						  `op` int(11) DEFAULT NULL,
						  `date_act` datetime DEFAULT NULL,
						  `action` int(1) DEFAULT NULL,
						  `kait` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id_log`)
						) ENGINE=InnoDB AUTO_INCREMENT=659 DEFAULT CHARSET=utf8;");
					}
					
					
					
					die(json_encode(array('status' => 1)));
				break;
				
				case "set":
				
					$e = explode('-',$app);
					
					for ($i = 0; $i < count($e); $i++) {
						
						$this->general_model->save_data('ref_aplikasi',array('aktif' => 1),'folder',$e[$i]);
						
					}
					
					die(json_encode(array('status' => 1)));
				
				break;
				
				case "app":
					die(json_encode(array('status' => 1)));
				break;
				
			}
			
		} else {
		
		$this->load->helper('directory');
		$map = directory_map('./application/controllers/', 1);
		
		$app = array();
		foreach($map as $o) {
			if (!preg_match("/\./i", $o) and file_exists('./application/controllers/'.$o.'/db.php') and $o <> "referensi") $app[] = $o;
		}
		
		$data['app_mod'] = $app;
		$this->load->view('umum/setup_view',$data);
		
		}
		
	}
	
	

}
?>