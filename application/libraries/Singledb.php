<?php 

class Singledb {

    function proses_db($app,$tabel,$nav, $rem_nav=false) {
		$ci =& get_instance();
		$ci->load->library('general_model');
		$ci->load->dbforge();

		$errors = array();
		// proses app
		if (is_array($app)) {
			$cek = $ci->general_model->datagrabs(array(
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
				$ci->general_model->save_data('ref_aplikasi',$app_plus,'id_aplikasi',$cek->row()->id_aplikasi);
				
			} else {
				
				$u = $ci->general_model->datagrabs(array(
					'tabel' => 'ref_aplikasi',
					'select' => 'max(urut) as urutan'
				))->row();
				$app_plus['urut'] = ($u->urutan+1);
				$id_app = $ci->general_model->save_data('ref_aplikasi',$app_plus);
			}
			
			// Create Module Icon 

			$path_app = './application/controllers/'.$app[4].'/'.$app[4].'.png';
			$path_logo = './assets/logo/'.$app[4].'.png';
			if (file_exists($path_app)) {
				
				if (file_exists($path_logo)) unlink($path_logo);
				copy ( $path_app , $path_logo );
				
			}
		}
		// ./proses app
				 
		$total = 0;
		$done = 0;
		$column = 0;
		$donec = 0;
		foreach($tabel as $tab => $c_tab) {
			$total +=1;
			if (!$ci->db->table_exists($tab)) {
				
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
					
				$ci->dbforge->add_field($fields);
				$ci->dbforge->add_key($key, TRUE);

				$ci->dbforge->create_table($tab);
				
				foreach($ex_fields as $c) {
					
					$ci->db->query('ALTER TABLE '.$tab.' ADD '.$c[0].' '.$c[1].(!empty($c[2])?'('.str_replace('.',',',$c[2]).')':null).' '.(!empty($c[5])?'DEFAULT '.$c[5]:null));
					
				}				
				
				// $si = array(
				// 	'type' => 1,
				// 	'moddate' => date('Y-m-d H:i:s'),
				// 	'detail' => 'Tabel <strong>'.$tab.'</strong> ditambahkan'	
				// );
				
				// $ci->general_model->save_data('log_db',$si);
				
			} else {
			
				$done+=1;
				$ex_fields = array();
				foreach($c_tab as $col => $c_col) {
					$column += 1;
					if (!$ci->db->field_exists($c_col[0], $tab)) {
						if (in_array($c_col[1],array('timestamp','decimal'))) {
							$ci->db->query('ALTER TABLE '.$tab.' ADD '.$c_col[0].' 
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
						
						$ci->dbforge->add_column($tab, $fields);
						
						}
						
						// $si = array(
						// 	'type' => 1,
						// 	'moddate' => date('Y-m-d H:i:s'),
						// 	'detail' => 'Kolom <strong>'.$c_col[0].'</strong> pada <strong>'.$tab.'</strong> ditambahkan'	
						// ); 
						// $ci->general_model->save_data('log_db',$si);

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

		// navigasi
		$no = 0;
		if (count($nav) > 0) {
			if($rem_nav){
				$ci->general_model->delete_data('nav','id_aplikasi',$id_app);
			}
			foreach($nav as $dat) {
				$or_null = empty($dat[6])?" OR link IS NULL":null;
				$where_kode = array(
						'id_aplikasi' => $id_app,
						'ref' => $dat[1],
						'judul' => $dat[4],
						"(link = '".$dat[6]."'".$or_null.")" => null);
				if (!empty($dat[2])) $where_kode['kode'] = $dat[2];
				
				$cek = $ci->general_model->datagrabs(array(
					'tabel' => 'nav', 
					'where' => $where_kode,
					'select' => 'count(*) as jml'))->row();

				if ($cek->jml == 0) { 
					$id_par = null;
					if (!empty($dat[5])) {
						
						$cek_par = $ci->general_model->datagrabs(array(
							'tabel' => 'nav', 
							'where' => array(
								'id_aplikasi' => $id_app,
								'judul' => $dat[5],
								'ref' => $dat[1]),
							'select' => 'id_nav'))->row();
						if (isset($cek_par->id_nav)) $id_par = $cek_par->id_nav;
						else $errors[] = 'Nav '.$dat[4];
					}
					
					$max_num = $ci->general_model->datagrabs(array(
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
			 
					$ci->general_model->save_data('nav',$simpan);
					$no+=1;
					
					// $si = array(
					// 	'type' => 2,
					// 	'moddate' => date('Y-m-d H:i:s'),
					// 	'detail' => 'Modul <b>'.$dat[4].'</b> ditambahkan'	
					// ); 
					// $ci->general_model->save_data('log_db',$si);
						
				}
			}
		}
		// ./navigasi
		
		
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
		$ci =& get_instance();
		$ci->load->library('general_model');

		if(count($db) > 0)foreach($db as $k => $v) {
			
			foreach($v as $e => $val) {
				
			$smpn = array();
			foreach($val as $vv => $kk) {
				
				if ($vv != "urut") $smpn[$vv] = $kk;
			}
			
			$cek = $ci->general_model->datagrabs(array(
				'tabel' => $k,
				'where' => $smpn
			));
			if ($cek->num_rows() == 0) $ci->general_model->save_data($k,$smpn);
			}
		}
		
	}
}