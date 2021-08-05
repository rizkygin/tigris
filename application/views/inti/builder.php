<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Builder extends CI_Controller {
	
	function __construct() {
	
		parent::__construct();
		//login_check($this->session->userdata('login_state'));

	}

	function process_db($app,$tabel,$nav) {
		
		$cek = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi',
			'where' => array('id_aplikasi' => $app[0])
		));
		
		$app_plus = array(
			'id_aplikasi' => $app[0],
			'kode_aplikasi' => $app[1],
			'nama_aplikasi' => $app[2],
			'deskripsi' => $app[3],
			'folder' => $app[4],
			'warna' => $app[5],
			'aktif' => 0
		);
		
		if ($cek->num_rows() > 0) {
			
			$this->general_model->save_data('ref_aplikasi',$app_plus,'id_aplikasi',$cek->row()->id_aplikasi);
			
		} else {
			$u = $this->general_model->datagrab(array(
				'tabel' => 'ref_aplikasi',
				'select' => 'max(urut) as urutan'
			))->row();
			$app_plus['urut'] = ($u->urutan+1);
			$this->general_model->save_data('ref_aplikasi',$app_plus);
		}
		
		$db_plus = array();
		$this->load->dbforge();
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
				
				//$db_plus[] = 'Tabel <strong>'.$tab.'</strong> (BARU)';
			} else {
				//$db_plus[] = 'Tabel <strong>'.$tab.'</strong> (ADA)';
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
						
						$db_plus[] = 'Kolom <strong>'.$c_col[0].'</strong> pada <strong>'.$tab.'</strong> ditambahkan';
					} else {
						$donec += 1;
					}
				}
			
			}
		}
		
		$db_build = array(
			'text' => $db_plus,
			'total' => $total,
			'done' => $done,
			'kolom' => $column,
			'koldone' => $donec
		);
		
		$nav_plus = array();
		$no = 0;
		foreach($nav as $dat) {
			
			$or_null = empty($dat[6])?" OR link IS NULL":null;
			
			
			$where_kode = array(
					'id_aplikasi' => $dat[0],
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
							'id_aplikasi' => $dat[0],
							'judul' => $dat[5],
							'ref' => $dat[1]),
						'select' => 'id_nav'))->row();
					$id_par = $cek_par->id_nav;
				}
				
				$max_num = $this->general_model->datagrab(array(
					'tabel' => 'nav','where' => array('id_aplikasi' => $dat[0]),
					'select' => 'MAX(urut) as max_num'
				))->row();
				$simpan = array(
					'id_aplikasi' => $dat[0],
					'judul' => $dat[4],
					'tipe' => $dat[3],
					'ref' => $dat[1],
					'kode' => $dat[2],
					'link' => $dat[6],
					'fa' => $dat[7],
					'urut' => $max_num->max_num+1,
					'separator' => 0,
					'aktif' => 1
				);
				
				if (!empty($id_par)) $simpan['id_par_nav'] = $id_par;
		 
				$this->general_model->save_data('nav',$simpan);
				$no+=1;
				$nav_plus[] = $no.'. Menu <b>'.$dat[4].'</b> ditambahkan ...';
					
			}
		}
		$teks = null;
		if (count($nav_plus) > 0) $teks.= '<p><strong>Navigasi :</strong><br/><p style="overflow: auto; height: 100px;">'.implode('<br>',$nav_plus).'</p>';
		if (count($db_build['text']) > 0) $teks.= '<p><strong>Pemuthakhiran Tabel</strong></p><p style="overflow: auto; height: 100px;">Data terkini :<br>'.implode('<br>',$db_build['text']).'</p>';
		$odie = json_encode(array(
			'sign' => 1,
			'text' => 'Pemutakhiran Database berhasil dilakukan ...'.$teks,
			'total' => $db_build['total'],
			'done' => $db_build['done'],
			'kolom' => $db_build['kolom'],
			'koldone' => $db_build['koldone'])
		);
		
		return $odie;
		
	}

}