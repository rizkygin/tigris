<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kewenangan extends CI_Controller {


	/* 
	 * Keterangan Variabel Global
	 * $app
	 *		1 = Aplikasi Tunggal
	 *		0 = Seluruh Aplikasi
	 * $dir	
	 		Pengguna Aplikasi / Folder Aplikasi
	 */

	var $app = 0; 
	var $dir = 'tigris';
	var $unit = TRUE;

	function __construct() {
	
		parent::__construct();
		login_check($this->session->userdata('login_state'));
		
		$app_std = $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => array('folder' => $this->uri->segment(1))
		))->row();
		$this->in_app = !empty($app_std->nama_aplikasi) ? $app_std->nama_aplikasi : 'Root';
	}

	function get_app($dir) {
		
		$active = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi', 'where' => array('aktif' => 1)));
		
		if ($active->num_rows() > 0) {
			$app_active = array();
			foreach($active->result() as $a) $app_active[] = $a->id_aplikasi;
		}
		
		$where = ($dir != "tigris") ? 
			array('folder' => $dir) :
			array('id_aplikasi IN ('.implode(',',$app_active).')' => null);
		return $this->general_model->datagrab(array(
			'tabel' => 'ref_aplikasi','where' => $where,'order' => 'urut'));

	}
	public function index() {
		$this->list_kewenangan();
	}
	
	function list_kewenangan($offset = null) {
	
	
		$data['breadcrumb'] = array('' => $this->in_app, $this->dir.'/Kewenangan' => 'Kewenangan');
		
		$active = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi', 'where' => array('aktif' => 1)));
		if ($active->num_rows() == 0) {
			$data['tombol'] = '<h4 class="title"> <i class="fa fa-cube fa-btn"></i> Aplikasi Kosong</h4>';
			$tabel = '<div class="alert">Tidak ada aplikasi aktif ...</div>';
		} else {
		
		$app_active = array();
		foreach($active->result() as $a) $app_active[] = $a->id_aplikasi;
		
		$offset = !empty($offset) ? $offset : null;
		$from = array('ref_role r' => '','ref_aplikasi a' => 'a.id_aplikasi = r.id_aplikasi');
		$where = ($this->app == 1) ? 
			array('a.folder' => $this->dir) : 
			array('a.id_aplikasi IN ('.implode(',',$app_active).')' => null);
		$config['base_url']		= site_url($this->dir.'/Kewenangan/list_kewenangan');
		$config['total_rows']	= $this->general_model->datagrab(array('tabel' => $from,'where' => $where,'select' => 'count(r.id_role) as jml'))->row()->jml;
		$config['per_page']		= '10';
		$config['uri_segment']	= '4';
		
		$this->pagination->initialize($config);
		
		$data['total']	= $config['total_rows'];
		$data['links']	= $this->pagination->create_links();
		
		$dtkewenangan	= $this->general_model->datagrab(array('tabel' => $from,'where' => $where,'limit' => $config['per_page'], 'offset' => $offset, 'order'=>'id_role'));
		if ($dtkewenangan->num_rows() != 0) {
		
			$this->table->set_template(array('table_open'=>'<table class="table table-striped table-bordered table-condensed table-nonfluid">'));
			$this->table->set_heading('No','Kewenangan',array('data' => 'Aksi','colspan' => 3));
			
			$no = 1+$offset;
			$opt_set = '
				msg="Apakah ingin pasang kewenangan ke seluruh operator?"
				t_icn="fa fa-sign-in"
				t_text="Pasang Kewenangan"
				title="Pasang Kewenangan ke seluruh operator ..."';
			
			$opt_unset = '
				msg="Apakah ingin cabut kewenangan seluruh operator?" 
				t_icn="fa fa-sign-out"
				t_text="Cabut Kewenangan"
				title="Cabut Kewenangan seluruh operator ..."';
			
			foreach($dtkewenangan->result() as $row){
				$link1 = anchor('#','<i class="fa fa-pencil"></i>','class="btn btn-xs btn-warning btn-edit" act="'.site_url($this->dir.'/Kewenangan/add_kewenangan/'.$row->id_role).'"');
				$link2 = anchor($this->dir.'/Kewenangan/delete_kewenangan/'.$row->id_role,'<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger btn-delete" msg="Apakah Anda ingin menghapus kewenangan <b>'.$row->nama_role.'</b>?"');
				
				$conf = '<div class="btn-group">
						<a class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right">						
						<li>'.anchor($this->dir.'/Kewenangan/set_kewenangan/'.in_de(array('set' => 1,'id' => $row->id_role)),'<i class="fa fa-sign-in fa-btn"></i> Set Semua Kewenangan ke Operator','class="btn-delete" '.$opt_set).'</li>
						<li>'.anchor($this->dir.'/Kewenangan/set_kewenangan/'.in_de(array('set' => 2,'id' => $row->id_role)),'<i class="fa fa-sign-out fa-btn"></i> Cabut Semua Kewenangan ke Operator','class="btn-delete" '.$opt_unset).'</li></ul>
						</div>';
				
				$this->table->add_row(
					array('data'=>$no,'style'=>'text-align:center'),
					$row->nama_role,
					$link1,
					$link2,
				);
				$no++;
			}
			$tabel = $this->table->generate();
		}else{
			$tabel = '<div class="alert">Belum ada kewenangan ...</div>';
		}
		
		$data['tombol'] = anchor('#','
			<i class="fa fa-plus-square"></i> &nbsp; Tambah Kewenangan','
			class="btn-edit btn btn-success btn-flat" act="'.site_url($this->dir.'/Kewenangan/add_kewenangan').'"');
		}
		
		
		$data['tabel']	= $tabel;
		$data['title'] 	= 'Kewenangan';
		$data['content'] = "umum/standard_view";
		$this->load->view('home', $data);
	}
	
	function set_kewenangan($par) {
		
		$o = un_de($par);
		
		if ($o['set'] == 1) {
			
			$peg = $this->general_model->datagrab(array('tabel' => 'peg_pegawai p'));
			
			foreach($peg->result() as $p) {
				$c = $this->general_model->datagrab(array('tabel' => 'pegawai_role','where' => array('id_pegawai' => $p->id_pegawai,'id_role' => $o['id']),'select' => 'count(id_pegawai) as jml'))->row();
				if ($c->jml == 0) $this->general_model->save_data('pegawai_role',array('id_pegawai' => $p->id_pegawai,'id_role' => $o['id']));
			}
			
		} else {
			$this->general_model->delete_data(array(
				'tabel' => 'pegawai_role',
				'where' => array(
					'id_role' => $o['id'],'id_pegawai <>' => $this->session->userdata('id_pegawai'))));
		}

		$txt = ($o['set'] == 1) ? 'Set Kewenangan seluruh pegawai berhasil dilakukan ...' : 'Pencabutan Kewenangan seluruh pegawai berhasil dilakukan ...';
		$this->session->set_flashdata('ok',$txt);
		redirect($o['dir'].'/Kewenangan');
	}
	
	function role_sub($ref,$app,$id = null) {
		
		$where_is = (!empty($id)) ? 'id_par_nav = '.$id : '(id_par_nav IS NULL OR id_par_nav=0)';
		
		$dat = $this->general_model->datagrab(array(
			'tabel' => 'nav',
			'where' => array($where_is.' AND ref = '.$ref.' AND id_aplikasi = '.$app .' AND aktif = 1'=> null),
			'order' => 'urut'
		)); return $dat;
		
	}
	function get_codes($id) {
		
		$c = array();
		$dat =	$this->general_model->datagrab(array(
			'tabel' => 'ref_role_nav',
			'where' => array('id_role' => $id)
		)); 
		
		foreach($dat->result() as $d) {
			
			$c[] = $d->id_nav;
			
		}
		
		return $c;
		
		
	}
	function add_kewenangan($id_role = null){
		
		$active = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi', 'where' => array('aktif' => 1)));
	
		$data['breadcrumb'] = array('' => $this->in_app, $this->dir.'/Kewenangan/add_kewenangan/'.$id_role => 'Kewenangan');
		
		$where = ($this->app == 1) ? array('folder' => $this->dir) : array('(id_par_aplikasi IS NULL OR id_par_aplikasi=0)' => NULL);
		
		if ($active->num_rows() > 0) {
			$app_ac = array();
			foreach($active->result() as $a) $app_ac[] = $a->id_aplikasi;
			$where = array_merge_recursive($where,array('id_aplikasi IN ('.implode(',',$app_ac).')' => null));
		}
		
		$data['aplikasi'] = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => $where,'order' => 'urut'));
		$data['param'] = @$d;
		$data['combo_aplikasi'] = ($data['aplikasi']->num_rows() > 1) ? $this->general_model->combo_box(array('tabel' => 'ref_aplikasi','key' => 'id_aplikasi','val' => array('nama_aplikasi'),'where' => $where,'order' => 'urut')) : null;
		$data['unit'] = $this->unit;
		
		$t_unit = $this->general_model->check_tab('ref_unit');
		
		if (isset($this->unit) and $this->unit == TRUE and $t_unit) {
			
			if ($this->general_model->check_tab('ref_role_unit')) {

			$data['unit_data'] = $this->general_model->datagrab(array(
				'tabel' => 'ref_unit',
				'where' => array('aktif' => 1),
				'order' => 'urut,unit'
			));
			
			if ($id_role != null) {
				$e = array();
				$unit_exist = $this->general_model->datagrab(array('tabel' => 'ref_role_unit','where' => array('id_role' => $id_role),'select' => 'id_unit'));
				foreach($unit_exist->result() as $u) { $e[] = $u->id_unit; }
				$data['exst_unit'] = $e;
			}
			
			}
		}
		
		$codes = $this->get_codes($id_role);
		$app = $this->get_app($this->dir);
		$app_data = array();
		$nav = array();
		
		foreach($app->result() as $ap) {
			
			$data_nav = null;
			
			/* -- Untuk Referensi -- */
			
			if ($ap->folder == 'referensi') {
				$data_nav = array();
			
				foreach($app->result() as $apr) {
					$data_refnav = null;
					$n1 = $this->role_sub(2,$apr->id_aplikasi);

					foreach($n1->result() as $ne1) {
						$check_sub = (!empty($codes) and in_array($ne1->id_nav,$codes)) ? 'checked' : null;
						$jud = ($ne1->tipe == 1) ? ' &nbsp;<strong class="text-orange"> <i class="fa fa-star fa-btn"></i> '.$ne1->judul.'</strong>' : $ne1->judul;
						$data_refnav .= '<p><input type="checkbox" class="incheck" name="code[]" value="'.$ne1->id_nav.'" '.$check_sub.' style="margin: -2px 0 0 15px"> '.$jud.'</p>';

						$n2 = $this->role_sub(2,$apr->id_aplikasi,$ne1->id_nav);
						foreach($n2->result() as $ne2) {
							$check_sub = (!empty($codes) and in_array($ne2->id_nav,$codes)) ? 'checked' : null;
							$jud = ($ne2->tipe == 1) ? ' &nbsp;<strong class="text-orange"> <i class="fa fa-star fa-btn"></i> '.$ne2->judul.'</strong>' : $ne2->judul;
							$data_refnav .= '<p style="padding-left: 30px"><input type="checkbox" class="incheck" name="code[]" value="'.$ne2->id_nav.'" '.$check_sub.' style="margin: -2px 0 0 15px"> '.$jud.'</p>';
							
							$n3 = $this->role_sub(2,$apr->id_aplikasi,$ne2->id_nav);
							foreach($n3->result() as $ne3) {
								$check_sub = (!empty($codes) and in_array($ne3->id_nav,$codes)) ? 'checked' : null;
								$jud = ($ne3->tipe == 1) ? ' &nbsp;<strong class="text-orange"> <i class="fa fa-star fa-btn"></i> '.$ne3->judul.'</strong>' : $ne3->judul;
								$data_refnav .= '<p style="padding-left: 60px"><input type="checkbox" class="incheck" name="code[]" value="'.$ne3->id_nav.'" '.$check_sub.' style="margin: -2px 0 0 15px"> '.$jud.'</p>';
								
							}
							
						}
						
					}
					$data_nav[$apr->nama_aplikasi] = $data_refnav;
				}
			} else {
			
			$n1 = $this->role_sub(1,$ap->id_aplikasi);

			foreach($n1->result() as $ne1) {
				$check_sub = (!empty($codes) and in_array($ne1->id_nav,$codes)) ? 'checked' : null;
				$jud = ($ne1->tipe == 1) ? ' &nbsp;<strong class="text-orange"><i class="fa fa-star fa-btn"></i> '.$ne1->judul.'</strong>' : $ne1->judul;
				$data_nav .= '<p><input type="checkbox" class="incheck" name="code[]" value="'.$ne1->id_nav.'" '.$check_sub.' style="margin: -2px 0 0 15px"> '.$jud.'</p>';

				$n2 = $this->role_sub(1,$ap->id_aplikasi,$ne1->id_nav);
				foreach($n2->result() as $ne2) {
					$check_sub = (!empty($codes) and in_array($ne2->id_nav,$codes)) ? 'checked' : null;
					$jud = ($ne2->tipe == 1) ? ' &nbsp;<strong class="text-orange"><i class="fa fa-star fa-btn"></i> '.$ne2->judul.'</strong>' : $ne2->judul;
					$data_nav .= '<p style="padding-left: 30px"><input type="checkbox" class="incheck" name="code[]" value="'.$ne2->id_nav.'" '.$check_sub.' style="margin: -2px 0 0 15px"> '.$jud.'</p>';
					
					$n3 = $this->role_sub(1,$ap->id_aplikasi,$ne2->id_nav);
					foreach($n3->result() as $ne3) {
						$check_sub = (!empty($codes) and in_array($ne3->id_nav,$codes)) ? 'checked' : null;
						$jud = ($ne3->tipe == 1) ? ' &nbsp;<strong class="text-orange"><i class="fa fa-star fa-btn"></i> '.$ne3->judul.'</strong>' : $ne3->judul;
						$data_nav .= '<p style="padding-left: 60px"><input type="checkbox" class="incheck" name="code[]" value="'.$ne3->id_nav.'" '.$check_sub.' style="margin: -2px 0 0 15px"> '.$jud.'</p>';
						
					}
					
				}
				
			}
			}
			
			$app_data[$ap->id_aplikasi] = $data_nav;
			
		}
		$data['link_save'] = 'tigris/Kewenangan/save_kewenangan';
		$data['app_data'] = $app_data;
		$data['title']	= !empty($id_role) ? 'Ubah':'Tambah';
		$data['def']	= !empty($id_role) ? $this->general_model->datagrab(array('tabel' => 'ref_role','where' => array('id_role' => $id_role)))->row() : null;
		
		$this->load->view('umum/Kewenangan_form', $data);
	}
	
	function delete_kewenangan($id_role){
		
		$this->general_model->delete_data('ref_role_nav','id_role',$id_role);
		$this->general_model->delete_data('ref_role','id_role',$id_role);
		$this->session->set_flashdata('ok','Data kewenangan berhasil dihapus...');
		redirect($dir.'/Kewenangan/');
		
	}
	
	function save_kewenangan() {
	
		$id_role = $this->input->post('id_role');
		$code = $this->input->post('code');
		/*cek($id_role);
		die();*/
		$simpan = array(
			'nama_role' => $this->input->post('nama_role'),
			'id_aplikasi' => $this->input->post('id_aplikasi'),
		); 
		
		$this->general_model->save_data('ref_role',$simpan,'id_role',$id_role);
		
		if (!empty($id_role)) {
			
			$this->general_model->delete_data('ref_role_nav','id_role',$id_role);
			$id = $id_role;
			
		} else {
			
			$id = $this->db->insert_id();
		
		}
		
		for ($i = 0; $i < count($code); $i++) {
			
			if ($code[$i] != null) $this->general_model->save_data('ref_role_nav',array('id_role' => $id,'id_nav' => $code[$i]));		
		
		}
		
		if ($this->input->post('unit_active') != null and $this->input->post('unit_active') == TRUE and $this->general_model->check_tab('ref_role_unit')) {
			
			$unit = $this->input->post('unit');
			
			if ($unit != null and count($unit) > 0) {
				
				$this->general_model->delete_data(array('tabel' => 'ref_role_unit','where' => array('id_unit NOT IN ('.implode(',',$unit).')' => null)));
				
			}
			
			$e = array();
			$unit_exist = $this->general_model->datagrab(array('tabel' => 'ref_role_unit','where' => array('id_role' => $id),'select' => 'id_unit'));
			foreach($unit_exist->result() as $u) { $e[] = $u->id_unit; }
			
			foreach($unit as $u) {
				if (!in_array($u,$e)) $this->general_model->save_data('ref_role_unit',array('id_unit' => $u,'id_role' => $id));
			}
						
		}
		
		$this->session->set_flashdata('ok','Data kewenangan berhasil disimpan...');

		redirect($this->dir.'/Kewenangan');
	}
}
