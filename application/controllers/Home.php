<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	var $link = 'front/templates';
	var $folder = 'front';
    var $dir= 'user';
    var $ctrl = 'Cart';
	function __construct() {
	
		parent::__construct();
		//getTheme();
		//$this->load->library('cfpdf');
		//$this->load->library('word');
		//set_statistik();
		//$xuri = $this->uri->uri_string(); 
		//set_pageview($xuri);


		
	}
	public function index() {
		$this->landing();
	}
	
	function landing() {






		$from = array(
			'ref_pengajuan_judul a' => '',
			'ref_tipe_field b' => array('a.id_ref_tipe_field = b.id_ref_tipe_field','left'),
			'ref_bidang c' => array('a.id_bidang = c.id_bidang','left')
		);

		$select= 'a.*,a.status as stat,b.id_ref_tipe_field,b.nama_tipe_field,c.nama_bidang,c.id_bidang';
		

		$dtjnsoutput = $this->general_model->datagrabs(array('tabel'=>$from, 'order'=>'a.urut ASC','select'=>$select));


		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'ref_pengajuan_judul',
			'order' => 'urut',
		));
		

		$awal = array();
		$urutkan = array();

		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_ref_pengajuan_judul,$rowx->urut);
		}
		


		if ($dtjnsoutput->num_rows() > 0) {
			$heads = array('No','Nama Syarat Pengajuan Judul','Keterangan','di Tujukan ke','Tipe Field');
			
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1;
			foreach ($dtjnsoutput->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/Ref_pengajuan_judul/on/'.in_de(array('id_ref_pengajuan_judul' => $row->id_ref_pengajuan_judul,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/Ref_pengajuan_judul/on/'.in_de(array('id_ref_pengajuan_judul' => $row->id_ref_pengajuan_judul,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_ref_pengajuan_judul);
				$btn_down = ($m+1 < $nav->num_rows()) ? anchor('tigris/Ref_pengajuan_judul/urut/'.in_de(array('id1' => $row->id_ref_pengajuan_judul,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('tigris/Ref_pengajuan_judul/urut/'.in_de(array('id2' => $row->id_ref_pengajuan_judul,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_ref_pengajuan_judul,$row->urut);


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Syarat Pengajuan Judul;*/
				$rows[] = 	$row->nama_syarat;
				$rows[] = 	$row->keterangan_pengajuan_judul;
				$rows[] = 	array('data'=>$row->nama_bidang,'style'=>'width:100px');
				$rows[] = 	array('data'=>$row->nama_tipe_field,'style'=>'width:90px');

				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tab_1 = $this->table->generate();
		}else{
			$tab_1 = '<div class="alert">Data masih kosong ...</div>';
		}


		$data['tab_1'] = $tab_1;




		$from_2 = array(
			'ref_proposal_tesis a' => '',
			'ref_tipe_field b' => array('a.id_ref_tipe_field = b.id_ref_tipe_field','left'),
			'ref_bidang c' => array('a.id_bidang = c.id_bidang','left')
		);

		$select= 'a.*,a.status as stat,b.id_ref_tipe_field,b.nama_tipe_field,c.nama_bidang,c.id_bidang';
		

		$dt_proposal_tesis = $this->general_model->datagrabs(array('tabel'=>$from_2, 'order'=>'a.urut ASC','select'=>$select));


		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'ref_proposal_tesis',
			'order' => 'urut',
		));
		

		$awal = array();
		$urutkan = array();
		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_ref_proposal_tesis,$rowx->urut);
		}
		

		if ($dt_proposal_tesis->num_rows() > 0) {
			$heads = array('No','Nama Syarat Proposal Tesis','Keterangan','di Tujukan ke','Tipe Field');
			
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1;
			foreach ($dt_proposal_tesis->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/Ref_proposal_tesis/on/'.in_de(array('id_ref_proposal_tesis' => $row->id_ref_proposal_tesis,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/Ref_proposal_tesis/on/'.in_de(array('id_ref_proposal_tesis' => $row->id_ref_proposal_tesis,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_ref_proposal_tesis);
				$btn_down = ($m+1 < $nav->num_rows()) ? anchor('tigris/Ref_proposal_tesis/urut/'.in_de(array('id1' => $row->id_ref_proposal_tesis,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('tigris/Ref_proposal_tesis/urut/'.in_de(array('id2' => $row->id_ref_proposal_tesis,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_ref_proposal_tesis,$row->urut);


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Syarat Pengajuan Judul;*/
				$rows[] = 	$row->nama_syarat;
				$rows[] = 	$row->keterangan_proposal_tesis;
				$rows[] = 	array('data'=>$row->nama_bidang,'style'=>'width:100px');
				$rows[] = 	array('data'=>$row->nama_tipe_field,'style'=>'width:90px');

				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tab_2 = $this->table->generate();
		}else{
			$tab_2 = '<div class="alert">Data masih kosong ...</div>';
		}


		$data['tab_2'] = $tab_2;



		$from_3 = array(
			'ref_seminar_hp a' => '',
			'ref_tipe_field b' => array('a.id_ref_tipe_field = b.id_ref_tipe_field','left'),
			'ref_bidang c' => array('a.id_bidang = c.id_bidang','left')
		);

		$select= 'a.*,a.status as stat,b.id_ref_tipe_field,b.nama_tipe_field,c.nama_bidang,c.id_bidang';
		

		$dt_seminar_hp = $this->general_model->datagrabs(array('tabel'=>$from_3, 'order'=>'a.urut ASC','select'=>$select));


		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'ref_seminar_hp',
			'order' => 'urut',
		));
		

		$awal = array();
		$urutkan = array();

		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_ref_seminar_hp,$rowx->urut);
		}
		


		if ($dt_seminar_hp->num_rows() > 0) {
			$heads = array('No','Nama Syarat Seminar Hasil Penelitian','Keterangan','di Tujukan ke','Tipe Field');
			
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1;
			foreach ($dt_seminar_hp->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/Ref_seminar_hp/on/'.in_de(array('id_ref_seminar_hp' => $row->id_ref_seminar_hp,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/Ref_seminar_hp/on/'.in_de(array('id_ref_seminar_hp' => $row->id_ref_seminar_hp,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_ref_seminar_hp);
				$btn_down = ($m+1 < $nav->num_rows()) ? anchor('tigris/Ref_seminar_hp/urut/'.in_de(array('id1' => $row->id_ref_seminar_hp,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('tigris/Ref_seminar_hp/urut/'.in_de(array('id2' => $row->id_ref_seminar_hp,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_ref_seminar_hp,$row->urut);


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Syarat Pengajuan Judul;*/
				$rows[] = 	$row->nama_syarat;
				$rows[] = 	$row->keterangan_seminar_hp;
				$rows[] = 	array('data'=>$row->nama_bidang,'style'=>'width:100px');
				$rows[] = 	array('data'=>$row->nama_tipe_field,'style'=>'width:90px');

				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tab_3 = $this->table->generate();
		}else{
			$tab_3 = '<div class="alert">Data masih kosong ...</div>';
		}


		$data['tab_3'] = $tab_3;




		$from_4 = array(
			'ref_tesis a' => '',
			'ref_tipe_field b' => array('a.id_ref_tipe_field = b.id_ref_tipe_field','left'),
			'ref_bidang c' => array('a.id_bidang = c.id_bidang','left')
		);

		$select= 'a.*,a.status as stat,b.id_ref_tipe_field,b.nama_tipe_field,c.nama_bidang,c.id_bidang';
		

		$dt_tesis = $this->general_model->datagrabs(array('tabel'=>$from_4, 'order'=>'a.urut ASC','select'=>$select));


		$nav = $this->general_model->datagrab(array(
			'tabel'=> 'ref_tesis',
			'order' => 'urut',
		));
		

		$awal = array();
		$urutkan = array();

		foreach ($nav->result() as $rowx) {
			$awal[] = array($rowx->id_ref_tesis,$rowx->urut);
		}
		


		if ($dt_tesis->num_rows() > 0) {
			$heads = array('No','Nama Syarat Tesis','Keterangan','di Tujukan ke','Tipe Field');
			
			$classy = 'class="table table-striped table-bordered table-condensed table-nonfluid"';
			$this->table->set_template(array('table_open'=>'<table '.$classy.'>'));
			$this->table->set_heading($heads);

			$m = 0;
			$no = 1;
			foreach ($dt_tesis->result() as $row) {
				$rows = array();
				if($row->status == 1){
					$status = anchor('tigris/Ref_tesis/on/'.in_de(array('id_ref_tesis' => $row->id_ref_tesis,'status' =>0)),'<i class="fa fa-fw fa-toggle-on text-aqua" style="font-size:20px;"></i>');
				}else{
					$status = anchor('tigris/Ref_tesis/on/'.in_de(array('id_ref_tesis' => $row->id_ref_tesis,'status' =>1)),'<i class="fa fa-fw fa-toggle-off text-default" style="font-size:20px;"></i>');

				}
				//cek($row->id_ref_tesis);
				$btn_down = ($m+1 < $nav->num_rows()) ? anchor('tigris/Ref_tesis/urut/'.in_de(array('id1' => $row->id_ref_tesis,'no1' => $row->urut,'id2' => $awal[$m+1][0],'no2' =>  $awal[$m+1][1])),'<i class="fa fa-arrow-down"></i>') : ' &nbsp; ';
					$btn_up = ($m > 0) ? anchor('tigris/Ref_tesis/urut/'.in_de(array('id2' => $row->id_ref_tesis,'no2' => $row->urut,'id1' =>  !empty($urutkan[0])?$urutkan[0]:@$awal[0],'no1' => !empty($urutkan[1])?$urutkan[1]:@$awal[1])),'<i class="fa fa-arrow-up"></i>') : ' &nbsp; ';
					$urutkan = array($row->id_ref_tesis,$row->urut);


				$rows[] = 	array('data'=>$no,'style'=>'text-align:center');
				/*$rows[] = 	$row->kode_Syarat Pengajuan Judul;*/
				$rows[] = 	$row->nama_syarat;
				$rows[] = 	$row->keterangan_tesis;
				$rows[] = 	array('data'=>$row->nama_bidang,'style'=>'width:100px');
				$rows[] = 	array('data'=>$row->nama_tipe_field,'style'=>'width:90px');

				$this->table->add_row($rows);
				$no++;
				$m += 1;
			}
			$tab_4 = $this->table->generate();
		}else{
			$tab_4 = '<div class="alert">Data masih kosong ...</div>';
		}


		$data['tab_4'] = $tab_4;



		$this->load->view('landing', $data);
	}
	function aplikasi($dir) {
		redirect($dir.'/home');
	}
	function get_single($article){
		$data['content'] = get_single($article);
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}

	function article($id) {
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function add_guestbook(){
		$data['content'] = get_guestbook();
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	function produk(){
		
        $data['id_konsumen']=$this->session->userdata('users_state');
    	$id_konsumen = $this->session->userdata('id_konsumen');
        $dt = $this->general_model->datagrab(array('tabel'=>'ref_kategori_paket', 'order'=>'kategori_paket ASC'));


        if($dt->num_rows() > 0){
        	$content = '


        	<div class="card card-primary card-outline" style="width:100%">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Produk Kami
            </h3>
          </div>
          <div class="card-body">
            <h4>Kategori</h4>
            <div class="row">
              <div class="col-3 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  
                ';
        $no=1;
        foreach ($dt->result() as $row) {

        		if($no==1){
        			$active = 'active';
        		}else{
        			$active = '';

        		}

        		$content .= '<a class="nav-link '.$active.'" id="vert-tabs-'.$no.'-tab" data-toggle="pill" href="#vert-tabs-'.$no.'" role="tab" aria-controls="vert-tabs-'.$no.'" aria-selected="true">'.$row->kategori_paket.'</a>';
		$no+=1;
        }

        $content .='</div></div>
        <div class="col-9 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">';
                
       	 	
          $no=1;       
 		foreach ($dt->result() as $row) {
 			if($no==1){
        			$actives = 'tab-pane fade show active';
        		}else{
        			$actives = 'tab-pane fade';

        		}

			$content .='<div class="'.$actives.'" id="vert-tabs-'.$no.'" role="tabpanel" aria-labelledby="vert-tabs-'.$no.'-tab">';
 			$from2 = array(
	            'produk a'=>'',
	            'ref_kategori_paket b'=>'b.id_ref_kategori_paket=a.id_ref_kategori_paket',
	            'ref_paket c'=>'c.id_ref_paket=a.id_ref_paket'
	        );
       	 	$dt2 = $this->general_model->datagrab(array('tabel'=>$from2,'where'=>array('a.id_ref_kategori_paket'=>$row->id_ref_kategori_paket),'order'=>'a.id_produk ASC'));

       	 	
			/*foreach ($dt2->result() as $row2) {
				if($dt2->num_rows() > 0){
					$content .= '
        			
                     '.$row2->paket.'  Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque
        		';
				}else{
					$content .= '
        			
                     KOSONG Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque
        		';
				}
        		
	        }*/

	        	$isi = '<style>.single-pricing::before{
	        		    top: 5px !important;
	        		}

	        		.table td, .table th{
	        			padding:6px !important;
	        			font-size: 13px;
	        			}

	        			</style><div class="row"><div class="col-lg-12 col-md-12"><h2>Paket '.$row->kategori_paket.'</h2><hr></div>';
	        	if($dt2->num_rows() > 0) 
	        		foreach ($dt2->result() as $row2) {
	        			$isi.='
	        			
	        				<div class="col-lg-6 col-md-6">
            <div class="single-pricing">
              <div class="pricing-top-heading">
                <br>
                
                <h3>'.$row2->paket.'</h3>
                <p><br></p>
              </div>
              <span>'.rupiah($row2->harga).'</span>';

              $jur = $this->general_model->datagrabs(array(
						'tabel'=>array(
							'paket_field a'=>'',
							'ref_field_paket b'=>'b.id_ref_field_paket=a.id_ref_field_paket'),
						'where'=>array('a.id_produk'=>$row2->id_produk),
						'select'=>'b.field_paket,a.nilai',
						'order'=>'a.id_ref_field_paket asc'
				));

              $bc=array();
				foreach($jur->result() as $b){
					$bc[]= '<td style="
    width: 30%;
">'.$b->field_paket.'</td><td style="
    width: 1%;
"> : </td><td> '.$b->nilai.'</td>';
				}
              $isi.=

(count($bc) > 0) ? '<table class="table table-striped table-bordered table-condensed"  style="color:#000;">'.implode('<tr>',$bc).'</tr></table>':null;

              ;
              $isi.='<a href="'.site_url('detail_paket/'.$row2->id_produk).'">
             Order
              </a>
            </div>
          </div>
	        			';
	        		}
	        	else $isi.='

	        	<div class="col-lg-3 col-md-6">
            <h5>belum ada paket</h5>
          </div>';
 				$content.= $isi;
 				$content .='</div>';
 				$content .='</div>';
	        $no+=1;
		}
	    $content.=' </div>
              </div>
            </div>
            
            
          </div>
        </div>';
	    }
		$data['content'] =  $content;
		
		$this->load->view('front/templates/detail',$data);
	}
	
	function detail_paket($id_produk=NULL){


		$from = array(
            'produk a'=>'',
            'ref_kategori_paket b'=>'b.id_ref_kategori_paket=a.id_ref_kategori_paket',
            'ref_paket c'=>'c.id_ref_paket=a.id_ref_paket'
        );

        $dt_x = $this->general_model->datagrab(array('tabel'=>$from,'where'=>array('a.id_produk'=>$id_produk)));
        

    	if($dt_x->num_rows() == 0){
				redirect('produk');
    	}else{
	        $dt = $this->general_model->datagrab(array('tabel'=>$from,'where'=>array('a.id_produk'=>$id_produk), 'order'=>'a.id_produk DESC'))->row();
	        /*cek($id_produk);
	        cek($dt->harga);
	        die();*/
	        $jur = $this->general_model->datagrabs(array(
							'tabel'=>array(
								'paket_field a'=>'',
								'ref_field_paket b'=>'b.id_ref_field_paket=a.id_ref_field_paket'),
							'where'=>array('a.id_produk'=>$id_produk),
							'select'=>'b.field_paket,a.nilai',
							'order'=>'a.id_ref_field_paket asc'
					));
					$bc=array();
					foreach($jur->result() as $b){
						$bc[]= '<td>'.$b->field_paket.'</td><td>'.$b->nilai.'</td>';
					}
			$data['cb_jangka']= $this->general_model->datagrabs(array(
	            'tabel' => 'ref_jangka_waktu','select'=>'
	            CONCAT(jangka_waktu," ",keterangan," (",'.$dt->harga.'*jangka_waktu,")") as jangka,id_jangka_waktu'));


			$data['cb_jangka_waktu'] = $this->general_model->combo_box(array(
	            'tabel' => 'ref_jangka_waktu','select'=>'
	            CONCAT(jangka_waktu," ",keterangan," (",'.$dt->harga.'*jangka_waktu,")") as jangka,id_jangka_waktu','key' => 'id_jangka_waktu','val' => array('jangka')));

			$data['variant'] = $this->general_model->datagrabs(array(
	    			'tabel'=>'ref_jangka_waktu'
	    		));


	    	$data['product'] = $dt;
	    	$data['bc'] = $bc;
			$data['content'] = 'landing/pages/product';
	    	$this->load->view('landing/home', $data);
    	}


	}
	function order(){
		$data['content'] =  'halaman order';
		$this->load->view('front/templates/detail',$data);
	}
	function save_guestbook(){
		$nama	= $_POST['nama'];
		$email	= $_POST['email'];
		$isi	= $_POST['isi'];
		$date	= date('Y-m-d H:i:s');
		
		$data = array('tanggal'=>$date,'nama'=>$nama,'email'=>$email,'isi'=>$isi,'status'=> 0);
		
		$save = $this->general_model->save_gb($data);
		$this->session->set_flashdata('ok','Terimakasih pesan Anda menunggu approve dari Administrator');
		redirect('home/add_guestbook');
	}

	function list_guestbook(){
		$dt_gb 				= $this->general_model->list_gb();
		$data['content'] 	= guestbook_view($dt_gb);
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);		
	}
	function add_polling(){
		$data['content'] = get_polling();
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function save_polling(){
		$date	= date('Y-m-d H:i:s');
		$ip	= $_SERVER['REMOTE_ADDR'];
		$id_ref_opsi	= $_POST['id_ref_opsi'];
		$saran	= $_POST['saran'];
		
		$data_ip = $this->general_model->datagrab(array('tabel'=>'cms_polling','where'=>array('ip'=>$ip)));
		if($data_ip->num_rows() > 0){
			$this->session->set_flashdata('fail','polling anda gagal disimpan, anda sudah memilih');
		}else{
			$data = array('tabel'=>'cms_polling',
					'data'=>array('tanggal'=>$date,'ip'=>$ip,'id_ref_opsi'=>$id_ref_opsi,'saran'=>$saran)
					);
			$save = $this->general_model->simpan_data($data);
			$this->session->set_flashdata('ok','polling anda berhasil disimpan');
		}
		redirect();
	}
	
	function list_polling(){
		$dt_pl 				= $this->general_model->list_polling();
		$data['content'] 	= polling_view($dt_pl);
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);		
	}

	function page($title) {
		$cont = null;
		$content = $this->general_model->get_page($title);
		if ($content->num_rows() > 0) {
			$c = $content->row();
			$cont.= '<h2>'.$c->title.'</h2>';
			$cont.= '<p>'.$c->content.'</p>';
		} else {
			$cont.= 'Tidak ditemukan halaman';
		}
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);
	}
	
	
	function search(){
		@$key = $_POST['key'];
		
		$result_art = $this->general_model->datagrab(array('tabel'=>'cms_articles','search'=>array('title'=>$key)));
		$result_down = $this->general_model->datagrab(array('tabel'=>'cms_downloads','search'=>array('judul'=>$key)));
		$result_page = $this->general_model->datagrab(array('tabel'=>'cms_pages','search'=>array('title'=>$key)));
		$result_person = $this->general_model->datagrab(array('tabel'=>'cms_personel','search'=>array('nama'=>$key)));

		
		
		$data['content']= search_view($key,$result_art,$result_down,$result_page,$result_person);
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);
	}
	
	
	function search_full($jenis,$key,$offset = null){
		!empty($offset) ? $offset : '0';

		$config['base_url'] 	= site_url('search_full/'.$jenis.'/'.$key);
		$config['per_page']		= '10';
		$config['uri_segment']	= '5';
		
		if($jenis == '1'){
			$config['total_rows'] = $this->general_model->datagrab(array('tabel'=>'cms_articles','where'=>array('title'=>$key)))->num_rows();
			$result = $this->general_model->datagrab(array('tabel'=>'cms_articles','limit'=>$config['per_page'],'offset'=>$offset,'where'=>array('title'=>$key)));
		}else if($jenis == '2'){
			$config['total_rows'] = $this->general_model->datagrab(array('tabel'=>'cms_downloads','where'=>array('judul'=>$key)))->num_rows();
			$result = $this->general_model->datagrab(array('tabel'=>'cms_articles','limit'=>$config['per_page'],'offset'=>$offset,'where'=>array('judul'=>$key)));
		}else if($jenis == '3'){
			$config['total_rows'] = $this->general_model->datagrab(array('tabel'=>'cms_pages','where'=>array('title'=>$key)))->num_rows();
			$result = $this->general_model->datagrab(array('tabel'=>'cms_articles','limit'=>$config['per_page'],'offset'=>$offset,'where'=>array('title'=>$key)));
		}else{
			$config['total_rows'] = $this->general_model->datagrab(array('tabel'=>'cms_articles','where'=>array('nama'=>$key)))->num_rows();
			$result = $this->general_model->datagrab(array('tabel'=>'cms_articles','limit'=>$config['per_page'],'offset'=>$offset,'where'=>array('nama'=>$key)));
		}
		
		$this->pagination->initialize($config);

		$links	= $this->pagination->create_links();
		
		$total	= $config['total_rows'];
		$data['content'] = search_lanjut_view($jenis,$key,$result,$links,$total);
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);
	}
	
	function download_file($name){
		$lokasi_file = './uploads/download/'.$name;
		if(file_exists($lokasi_file)){
			$file = file_get_contents($lokasi_file);
			force_download($name,$file);
		}else{
			$data['content'] = not_exists_file($name);
			$this->theme->set_theme(THEME);
			
		$this->theme->render('cms/home',$data);
		}
	}
	
	function detail_download($id){

		/*cek($id);
		die();*/
		$detail = $this->general_model->datagrab(array('tabel'=>'cms_downloads','where'=>array('id_download'=>$id)));
		//$detail = $this->general_model->detail_download($id);
		$data['content'] = detail_download($detail); 
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function export_pdf($id){
		/*cek($id);*/

		$pdf = new FPDF();
    	$pdf->AddPage('P','Legal');
    	$pdf->SetMargins('20', '5');
    	$pdf->SetFont('Arial','B',14);
    	$lebar = 180;

		//$dt_article = $this->general_model->get_article($id);

		$dt_article = $this->general_model->datagrab(array('tabel' =>'cms_articles','where' =>array('id_article' => $id)));
		$row = $dt_article->row();
		
		$pdf->ln(10);
		$pdf->MultiCell($lebar,5,$row->title,0,'C');
		$pdf->ln(10);
		$pdf->SetFont('Arial','',10);
		$html = str_get_html($row->content);
		// Find all images
		$gambar = '';
		$paragraph = explode("</p>",$row->content);
		//var_dump($paragraph);
		//die();
		//cek($row->content);
		foreach($paragraph as $key => $bebas){
		    //echo 'paragrap ke :'.$key;
		    //echo '<br>paragrap gambar : ';
		    //cek(strrpos($bebas, "src"));
		    if(strpos($bebas, "src") >= 1){
		        //echo 'ada gambar :';
		        //cek($bebas->src);
		        $gbr = str_get_html($bebas);
		        $a = $gbr->find('img');
		        //cek($a[0]->src);
		        $gambar = str_replace(' ','%20',$a[0]->src);
		        //cek($gambar);
		        $pdf->image($gambar,65,null,70);
		        $pdf->ln(4);
		    } else if(!empty($bebas)) {
		        $par = str_get_html($bebas);
		        //echo 'key :'.$key.'<br>';
		        //cek($bebas);
		        $prg = strip_tags($par->innertext);
		        //cek($prg);
		        //$paragraph = strip_tags($bebas,'<p>');
		        //cek($paragraph);*/
		        $pdf->MultiCell($lebar, 5, str_replace('&nbsp;','',$prg), 0);
		        $pdf->ln(4);
		    }
		   
		}
		//$urlnya = base_url().$this->uri->uri_string;
		//atur posisi 1.5 cm dari bawah
		$pdf->SetY(-25);
		//buat garis horizontal
		$pdf->Line(10,$pdf->GetY(),200,$pdf->GetY());
		//Arial italic 9
		$pdf->SetFont('Arial','I',9);
		//nomor halaman
		$pdf->ln(4);
		$pdf->Cell(0,0,base_url().$this->uri->uri_string,0,0,'L');
		$pdf->Cell(0,0,'Halaman '.$pdf->PageNo(),0,0,'R');
		$pdf->Output('articles-'.time().'-'.date('Y-m-d').'.pdf','I');    
        /*die();
		$gbr=array();
		foreach($html->find('img') as $elgbr) 
       			$gbr[] = str_replace(' ','%20',$elgbr->src);


        
       	$par = array();
       	foreach($html->find('p') as $elpar) 
       			$paragraph[] = strip_tags($elpar->innertext,'<p>');
        
            
       $konten = str_replace('&nbsp;','',$paragraph[0]);    
       $pdf->MultiCell($lebar, 5,$konten, 0);
        
       	$pdf->ln(4);
       	count($gbr)>0?$pdf->image($gbr[0],65,null,70):null;
  
       	foreach($paragraph as $k=>$v){
       		if($k>0) 
       		$pdf->MultiCell($lebar, 5,str_replace('&nbsp;','',$v), 0);
       		$pdf->ln(3);
       	}

		$pdf->Output('articles-'.time().'-'.date('Y-m-d').'.pdf','I'); */   
    	
	}
	
	function export_word($id){
	      $row = $this->general_model->datagrab(array('tabel' =>'cms_articles','where' =>array('id_article' => $id)))->row();
	    $filename=$row->title.' - articles-'.time().'-'.date('Y-m-d');
	    header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename='".$filename.".doc'");
	  
	 
	    $data['tabel'] = $row->title.'<br>'.str_get_html($row->content);
	    /*$konten = str_get_html($row->content);*/
	    $this->load->view('umum/standard_view', $data);
	    
	    
	    
        /*cek($row);*/
		/*//$row = $this->general_model->get_article($id)->row(); 
		//our docx will have 'lanscape' paper orientation
		$section = $this->word->createSection(array('orientation'=>null));
		
		$html = str_get_html($row->content);
		// Find all images 
		$gbr=array();
		foreach($html->find('img') as $elgbr){
       			$gbr[] = str_replace(' ','%20',$elgbr->src);

       		}

       	$paragraph = array();
       	foreach($html->find('p') as $elpar) 
       			$paragraph[] = $elpar->innertext;*/

		//$this->word->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
		//$this->word->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));

		// Add text elements
		/*$section->addText($row->title,array('bold'=>true, 'italic'=>true, 'size'=>16));
		$section->addTextBreak(1);
		
		//$section->addImage($gbr[0], array('width'=>210, 'height'=>210, 'align'=>'center'));
		$section->addTextBreak(1);

		$section->addText(strip_tags($paragraph[0],'<p>'));
		$section->addTextBreak(1);

		foreach($paragraph as $k=>$v){
       		if($k>0) 
       		$section->addText(strip_tags($v,'<p>'));
       		$section->addTextBreak(1);
       	}
       
		$filename='articles-'.time().'-'.date('Y-m-d').'.docx';*/ //save our document as this file name
		/*header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache*/
 	/*	header("Content-Type: application/vnd.ms-word");
        header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
        header("Content-disposition: attachment; filename='".$filename."'");*/
	/*	$objWriter = PHPWord_IOFactory::createWriter($this->word, 'Word2007');
		$objWriter->save('php://output');*/
		
	}
	
	function register_member(){
		$data['content'] = register_view($msg = null);
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function save_member(){
		$username	= $_POST['username'];
		$password	= md5($_POST['password']);
		$nama		= $_POST['nama'];
		$email		= $_POST['email'];
		$alamat		= $_POST['alamat'];
		
		$data = array('username'=>$username,'password'=>$password,'id_role'=>'2','nama'=>$nama,'email'=>$email,'alamat'=>$alamat);
		
		$save = $this->general_model->save_member($data);
		if($save) $msg = 'Data berhasil disimpan.';
		$data['content'] = register_view($msg);
		$this->theme->set_theme(THEME);		
		
		$this->theme->render('cms/home',$data);
	}
	
	function lost_password(){
		$msg = $this->session->flashdata('msg');
		if(!empty($msg)) $msg = $msg; else $msg = "";
		
		$frm  = "<p>".$msg."</p>";
		$frm .= form_open('home/reset_password');
		$frm .= "<label>Username</label>".form_input(array('name'=>'username','style'=>'width:200px'))."<br>";
		$frm .= "<label>Email</label>".form_input(array('name'=>'email','style'=>'width:250px'))."<br>";
		$frm .= "<label></label>".form_submit('submit','Reset Password','class=button_save');
		$frm .= form_close();
		
		$data['content'] = $frm;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function reset_password(){
		$username	= $_POST['username'];
		$email		= $_POST['email'];
		
		$cek = $this->general_model->cek_account($username, $email);
		
		if($cek->num_rows() == 1){
			$this->load->library('phpmailer');
			$emailFrom = 'nurrhariyadi@gmail.com';
			$namaFrom = 'Hariyadi';
			$toEmail = 'nurrhariyadi@yahoo.com';
			$toName = 'Nur';
			$subjectMsg = 'Coba EMAIL';
			 
			$msg ="ISI EMAIL DISINI";
			 
			$kirim = send_email_smtp($emailFrom,$namaFrom,$toEmail,$toName,$subjectMsg,$msg);
			
			if($kirim == true) $this->session->set_flashdata('msg','Password berhasil di reset.');
			else $this->session->set_flashdata('msg','Password gagal di reset.');
		} 
		
		redirect('home/lost_password');
	}
	
	function halaman($title) {
		
		$cont = null; 

		//$data_content = $this->universal_model->data_list('cms_pages',null,null,array('permalink'=>$title));
		$data_content = $this->general_model->datagrab(array('tabel' => 'cms_pages', 'where'=>array('permalink'=>$title)));
		//cek($data_content->num_rows());

		if ($data_content->num_rows() > 0) {
			$content = $data_content->row();
			 $cont = "<h1>".$content->title."</h1>";
			$cont .= "<p>".$content->content."</p>";
			if(@$content->id_cat!=0){
				$dt_news = $this->general_model->datagrab(array('tabel'=>'cms_articles', 'where'=>array('code'=>'1') ));
					

				/*$cont .= '<div class="col-lg-12">';
					$cont .= '<h3 style="border-bottom:2px solid #26597b">Berita</h3>';
						$cont .= '<ol>';
							$no=1;
							foreach ($dt_news->result() as $ber) {
								$in = unserialize($ber->id_cat);
								if (in_array($content->id_cat,$in)) {
									$cont .= '<li style="padding:10px;border-bottom:1px solid #f9f9f9"><a href="'.site_url('berita/'.$ber->permalink).'" style="color: #f14d4d;">'.$ber->title.'</a></li>';
									$no+=1;
								}
							}
						$cont .= '</ol>';
				$cont .= '</div>';*/
			}
		} else {
			$cont.="<p>Halaman Tidak Ditemukan</p>";
		}
	
		$data['content'] = $cont;
		$data['judul'] = @$content->title;
		$data['id'] = @$content->id_page_parent;
		$data['id_page'] = @$content->id_page;
		$this->load->view($this->link.'/detail', $data);
		/*$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);*/
	}

// ARSIP
	function arsip($tb=0) {
		/*cek($title);
		die();*/

		// INDEX ARSIP

			$data['dir'] = '';
			if ($this->session->userdata('login_state')==2) {

				// jika pemohon sudah login: 
				// redirect($this->folder.'/beranda_pemohon');
			// data tab
				
				$arr_tab = array(
					array('on' => 1,'text' => '<b>BERANDA</b>'),
					array('url' => site_url('arsip-portal/arsip_list'),'text' => 'DATA ARSIP'),
					array('url' => site_url('arsip-portal/table_list'),'text' => 'DATA TABEL'),
					array('url' => site_url('arsip-portal/permohonan_online'),'text' => 'PERMOHONAN')
					);
					
				$data['tabs'] = $arr_tab;
			// ./data tab
				$tabel = '<div class="row">
							<div class="col-lg-6">
								<h4><i class="fa fa-archive fa-btn"></i>Pencarian Arsip</h4>
								<form action="" method="POST">
									<div class="input-group input-group-md">
										<input name="arsip" class="form-control" type="text" value="'.$this->input->post('arsip').'">
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="submit"><i class="fa fa-search"></i></button>
										</span>
									</div>
								</form>
							</div>
							
						</div>
						<hr/>
						';
			if($this->input->post('arsip')){
				$data['p'] = $this->input->post('arsip');
				$fcari = null;
				$search_key = $this->input->post('arsip');
				if (!empty($search_key)) {
					$fcari = array(
						'arsip' 		=> $search_key,
					);
					$data['for_search'] = $fcari['arsip'];
				} else if ($search) {
					$fcari=un_de($search);
					$data['for_search'] = $fcari['arsip'];
				}
				$from = array(	'srk_arsip a'=>'',
								'srk_jns_arsip b'=>array('a.id_jns_arsip=b.id_jns_arsip','left') );
				$where = array();

				$dt_arsip = $this->general_model->datagrab(array(
				'tabel'=> $from,
				'limit'=>10, 'offset'=>0,
				'search'=>$fcari,
				'where'=>$where));

				if($dt_arsip->num_rows() > 0){
					$tabel .= '<table class="table table-bordered">';
						$tabel .= '<tr><th>No</th><th>Jenis Arsip</th><th>Judul</th><th>Arsip</th><th>Aksi</th></tr>';
						$no=1;
						foreach ($dt_arsip->result() as $row) {
							$dt_arsip_berkas = $this->general_model->datagrab(array('tabel'=>'srk_arsip_berkas', 'where'=>array('id_arsip'=>$row->id_arsip) ));
							$bk = '';
							foreach ($dt_arsip_berkas->result() as $bks) {
								$bk .= '<span class="fa fa-arrow-right fa-btn"></span>';
								$bk .= '&nbsp;&nbsp;<a href="'.base_url('uploads/arsip/'.@$row->direktori.'/'.$bks->berkas).'" class="fancybox link-normal" title="'.$bks->berkas.'">'.substr($bks->berkas,0 , 10).'</a>';
								$bk .= '<br>';
							}
							$tabel .= '<tr>';
								$tabel .= '<td align="center">'.$no.'</td>';
								$tabel .= '<td>'.$row->jns_arsip.'</td>';
								$tabel .= '<td>'.$row->arsip.'</td>';
								$tabel .= '<td>'.$bk.'</td>';
								// $ajk = anchor('#', '<i class="fa fa-upload"></i>','class="btn btn-warning btn-flat btn-xs" title="Ajukan Permohonan."');
								$ajk = anchor(site_url('arsip-portal/arsip_list/req_data/'.in_de(array('id_arsip'=>$row->id_arsip, 'id_tipe_data_permohonan'=>1)) ), '<i class="fa fa-hand-o-up"></i>', ' class="btn btn-sm btn-primary btn-edit btn-flat" title="Klik untuk pengajuan permohonan data"');

								$tabel .= '<td align="center">'.$ajk.'</td>';
							$tabel .= '</tr>';
						}
					$tabel .= '</table>';
					$tabel .= "
						<script>
							$('.fancybox').fancybox();
						</script>
					";
				}else{
					$tabel .= '<div class="alert">Data tidak ditemukan...</div>';
				}
			}
				$data['tabel'] = $tabel;
				$data['content_view'] = 'umum/standard_view';

			}else{
				$this->form_validation->set_message('required','<label style="background: #fff; padding: 5px; margin-top: 2px;"><b class="text-red">%s Tidak boleh kosong</b></label>');
				$this->form_validation->set_rules('name', 'Email / Username','required');
				$this->form_validation->set_rules('sandi', 'Password','required');

				if($this->form_validation->run()==FALSE){
					$title = "Beranda Portal Arsip";

					// $this->load->view($this->folder.'/choose_login', $data);
					$data['content_view'] = 'arsip-portal/choose_login';

				}else{
					$in = $this->input->post();
					$cek = $this->general_model->datagrab(array('tabel'=>'spo_pemohon', 'where'=>array('(username="'.$in['name'].'" OR email="'.$in['name'].'")'=>NULL, 'password'=>md5($in['sandi'])) ));
					if ($cek->num_rows() > 0) {
						$dt_pemohon = $cek->row();
						$sesi = array('id_pemohon'=>$dt_pemohon->id_pemohon,
								'nama_pemohon'=>$dt_pemohon->nama_pemohon,
								'email'=>$dt_pemohon->email,
								'username'=>$dt_pemohon->username,
								'pass'=>$dt_pemohon->password,
								'login_state'=>'2');
						$this->session->set_userdata($sesi);
						// jika login sukses:
						

						redirect('arsip');
					}else{
						$this->session->set_flashdata('fail','Kombinasi Username dan Password Salah!!!');
						redirect(site_url('arsip'));
					}
				}
			}
		
		// ./INDEX ARSIP
	
		// $data['content'] = 'tes';
		
		$this->theme->set_theme(THEME);
		
		$this->theme->render('cms/home',$data);
	}

	public function register_arsip(){
		$this->form_validation->set_message('required','<label style="background: #fff; padding: 5px; margin-top: 2px;"><b class="text-red">%s Tidak boleh kosong</b></label>');
		$this->form_validation->set_message('valid_email','<label style="background: #fff; padding: 5px; margin-top: 2px;"><b class="text-red">%s Tidak valid</b></label>');
		$this->form_validation->set_message('is_unique','<label style="background: #fff; padding: 5px; margin-top: 2px;"><b class="text-red">%s Sudah Terpakai/Terdaftar</b></label>');
		$this->form_validation->set_message('matches','<label style="background: #fff; padding: 5px; margin-top: 2px;"><b class="text-red">%s Harus Sama dengan Password</b></label>');

		$this->form_validation->set_rules('nama_pemohon', 'Nama Lengkap','required');
		$this->form_validation->set_rules('alamat', 'Alamat Lengkap','required');
		$this->form_validation->set_rules('telp', 'No Telepon/HP','max_length[14]');
		$this->form_validation->set_rules('email', 'Email','required|valid_email|is_unique[spo_pemohon.email]');
		$this->form_validation->set_rules('username', 'Username','required|is_unique[spo_pemohon.username]');
		$this->form_validation->set_rules('password', 'Password','required');
		$this->form_validation->set_rules('repassword', 'Ulang Password','required|matches[password]');
		if($this->form_validation->run()==FALSE){

			// $this->load->view($this->folder.'/register');
			$data['content_view'] = 'arsip-portal/register'; 

		}else{
			// cek($_POST);
			$in = $this->input->post();
			$par = array('nama_pemohon'=>$in['nama_pemohon'],
							'alamat'=>$in['alamat'],
							'telp'=>$in['telp'],
							'email'=>$in['email'],
							'username'=>$in['username'],
							'password'=>md5($in['password']));
			$create_user = $this->general_model->save_data('spo_pemohon',$par,'id_pemohon',NULL);
			if($create_user > 0){
				$sesi = array('id_pemohon'=>$create_user,
								'nama_pemohon'=>$in['nama_pemohon'],
								'email'=>$in['email'],
								'username'=>$in['username'],
								'pass'=>$in['password'],
								'login_state'=>'2');
				$this->session->set_userdata($sesi);
				$this->session->set_flashdata('ok','Pendaftaran Berhasil. Silahkan login menggunakan Email/Username dan Password');
				redirect(site_url('welcome-arsip'));
			}else{
				$this->session->set_flashdata('fail','Pendaftaran gagal karena kesalahan sistem!!!');
				redirect(site_url('register-arsip'));
			}
		}

		$this->theme->set_theme(THEME);
		
		$this->theme->render('cms/home',$data);
	}

	function welcome_arsip(){
		$data['content_view'] = 'arsip-portal/welcome';
		$this->theme->set_theme(THEME);
		
		$this->theme->render('cms/home',$data);
	}

	public function process_logout() {
        $this->session->sess_destroy();
        redirect(site_url('arsip'), 'refresh');
    }
// ./ARSIP
	
	
	function artikel($code,$title,$title2 = null,$title3 = null) {
		/*cek($code);
		cek($title);
		cek($title2);
		cek($title3);
		die();*/
	
		$art = array(
			'1' => 'berita',
			'2' => 'artikel',
			'3' => 'agenda',
			'4' => 'pengumuman'
		);
	
		//$hal = $this->route_model->get_param('hal')->value;
		$halaman =  $this->general_model->datagrab(array('tabel'=>'parameter','where'=>array('param'=>'hal')))->row();
		$hal = $halaman->val;
		/*cek($hal);
			die();*/
		$cont = null;
		if ($title == "kategori") {
			$offset = !empty($title3) ? $title3 : "0";
			$title = str_replace('-', ' ', $title);
			/*cek($title2);
			die();*/
			//$cat = $this->route_model->get_category($code,$title2)->row();
			$cat = $this->general_model->datagrab(array('tabel'=>'cms_categories','where'=>array('code'=>$code,'category'=>$title2)))->row();
			
			if (!empty($cat)) {
				
				$config['base_url'] = site_url($art[$code].'/'.$title.'/'.$title2);
				//$config['total_rows'] = $this->route_model->get_article($code)->num_rows();
				$config['total_rows'] = $this->general_model->datagrab(array('tabel'=>'cms_articles','where'=>array('code'=>$code)))->num_rows();
			
				
				$config['per_page'] = $hal;
				$config['uri_segment']	= '4';
				$this->pagination->initialize($config);
				$links = $this->pagination->create_links();
				
				$from_artikel = array(
					'cms_articles a' => '',
					'cms_uploads b' => array('a.id_article = b.id_article','left')
				);

				$data_content = $this->general_model->datagrab(array(
					'tabel'=>$from_artikel,
						'where'=>array('a.code'=>$code),
						'limit'=>$hal,
						'order'=>'a.date_start DESC',
						'offset'=>$offset));
				//$data_content = $this->route_model->get_article($code,null,$hal,$offset);
				
				/*cek($code);
				die();*/
				if ($data_content->num_rows() > 0) {
					foreach($data_content->result() as $r) {				
						$in = unserialize($r->id_cat);
						/*cek($in);*/
						if (in_array($cat->id_cat,$in)) {
						$cont.= '<h2 style="border-bottom: 1px solid #e2e200;padding: 0px;line-height: 45px;">'.$r->title.'</h2><div class="small">'.konversi_tanggal('D, j M Y',substr($r->date_start,0,10)).'</div><div class="clear"></div>';;
						$cont.= '<p>'.$r->content.'</p>';
						$cont.= '<hr><div class="irawan"><p>Simpan sebagai : <a href="'.site_url('home/export_pdf/'.$r->id_article).'" title="PDF"><img src="'.base_url('assets/images/pdf.png').'"></a> <a href="'.site_url('home/export_word/'.$r->id_article).'" title="Ms. Word"><img src="'.base_url('assets/images/word.png').'"></a></a></p></div>';
						}
						
					}
					$cont.=$links;
				} else {
					$cont.="<p>Halaman Tidak Ditemukan oi</p>";
				}
			} else {
				$cont.="<p>Kategori Tidak Ditemukan</p>";
			}
			
		} else {
				$from_x = array(
					'cms_articles b' => '',
					'cms_uploads a' => array('a.id_article = b.id_article','left')
				);
			$data_content = $this->general_model->datagrab(array(
					'tabel'=>$from_x,
					'select'=>'a.*,b.date_end,b.id_article as id_art, b.permalink,b.code,b.content,b.title,b.date_start,b.id_cat',
					'where'=>array('b.code'=>$code,'b.permalink'=>$title)));
			
			/*cek($code);
			cek($title);
			cek($data_content->id_art);
*/
			
			if ($data_content->num_rows() > 0) {
			

				$content = $data_content->row();
				$cont.= '<h2 style="border-bottom: 1px solid #e2e200;padding: 0px;line-height: 45px;">'.$content->title.'</h2>
				<div class="small date_time" style="width: 100%;  padding: 2px;  text-align: left; color: #000;margin-bottom:20px;">'.konversi_tanggal('D, j M Y',substr($content->date_start,0,10)).'</div><div class="clear"></div>';
				
				
				if($content->code == 3){
					$cont.= 'Tanggal Agenda<p>'.konversi_tanggal('D, j M Y',substr($content->date_start,0,10)).' s/d '.konversi_tanggal('D, j M Y',substr($content->date_end,0,10)).'</p>';
				}

				$cont.= '<br><p>'.$content->content.'</p>';
				
				$cont.= '<hr><div class="irawan"><p>Simpan sebagai : <a href="'.site_url('home/export_pdf/'.$content->id_art).'" title="PDF" target="_blank"><img src="'.base_url('assets/images/pdf.png').'" style="display: inherit;"></a> <a href="'.site_url('home/export_word/'.$content->id_art).'" title="Ms. Word"><img src="'.base_url('assets/images/word.png').'" style="display: inherit;"></a></div>';

			/*$html = str_get_html($content->content);
			$data['script'] = '';
			foreach($html->find('img') as $elgbr) {
       		
				$img_id = $elgbr->id;

				$data['script'] .= '
					
						$("#'.$img_id.'").after("<div style=\'text-align:center;font-size:10px;\'><i>'.$elgbr->alt.'</i></div><br>");

					';
				
			}*/

				
				if($content->file_name != ''){
					$cont .= '<p>Download lampiran : <a href="'.site_url('home/download_file/'.$content->file_name).'" title="Lampiran"><img src="'.base_url('assets/images/lampiran.jpg').'"></a>';
				}else{
					$cont .= '';
				} 
				$cont .= '</p>';
				
				$unseri = unserialize($content->id_cat);
				$linked = $this->general_model->datagrab(array(
					'tabel'=>'cms_articles',
						'order'=>'date_start DESC'));
				//$linked = $this->universal_model->data_list('cms_articles',null,null,null,array('date_start' => 'desc'));

				$cont .= '<h3  style="border-bottom: 1px solid #e2e200;padding: 0px;line-height: 45px;">Berita terkait : </h3>';
				$cont .= '<ul>

				';
				
					//$hasil = $this->universal_model->data_query($q);
					$hasil = $this->general_model->datagrab(array(
					'tabel'=>'cms_articles',
						'where'=>array('permalink !='=>$title,'code'=>$code),'order'=>'date_start DESC','limit'=>'5'));
					foreach($hasil->result() as $has){
						if($content->id_article!=$has->id_article){
						$cont .= '<li style="list-style-type: disc;margin-left: 15px;border-bottom:1px solid #eaeaea"><a href="'.site_url('berita/'.$has->permalink).'">'.$has->title.'</a></li>';
						}
					}
				$cont .= '</ul>';	

				/*$cont .= '<h2>Berita Terbaru</h2><ul>';  
				$q = $this->universal_model->data_list('cms_articles','5',null,array('code'=>'1'),array('date_start'=>'desc'));
				foreach($q->result() as $row){
					$cont .= '<li><a href="'.site_url('berita/'.$row->permalink).'">'.$row->title.'</a></li>';
				}
				$cont .= '</ul>';*/
			}else {
				$cont.="<p>Halaman Tidak Ditemukan</p>";
			}
			
		}

		$data['content'] = $cont;
		$this->load->view($this->link.'/detail', $data);
	}
	function manajemen($code,$title,$title2 = null,$title3 = null) {
		/*cek($title);
		die();*/
	
		$art = array(
			'1' => 'hotel',
			'2' => 'biro_pariwisata',
			'3' => 'rumah_makan',
			'4' => 'obyek_wisata'
		);
	
		//$hal = $this->route_model->get_param('hal')->value;
		$halaman =  $this->general_model->datagrab(array('tabel'=>'parameter','where'=>array('param'=>'hal')))->row();
		$hal = $halaman->val;
		$cont = null;
		if ($title == "kategori") {
			$offset = !empty($title3) ? $title3 : "0";
			//$cat = $this->route_model->get_category($code,$title2)->row();
			$cat = $this->general_model->datagrab(array('tabel'=>'cms_jenis_destinasi','where'=>array('code'=>$code,'title'=>$title)))->row();
			if (!empty($cat)) {
				
				$config['base_url'] = site_url($art[$code].'/'.$title.'/'.$title2);
				$config['total_rows'] = $this->route_model->get_article($code)->num_rows();
				
				$config['per_page'] = $hal;
				$config['uri_segment']	= '4';
				$this->pagination->initialize($config);
				$links = $this->pagination->create_links();
				
				$from_artikel = array(
					'cms_uploads a' => '',
					'cms_destinasi b' => array('a.id_destinasi = b.id_destinasi','left')
				);

				$data_content = $this->general_model->datagrab(array(
					'tabel'=>$from_artikel,
						'where'=>array('b.code'=>$code)));
				//$data_content = $this->route_model->get_article($code,null,$hal,$offset);
				
				if ($data_content->num_rows() > 0) {
					foreach($data_content->result() as $r) {				
						$in = unserialize($r->id_cat);
						//cek($in);
						if (in_array($cat->id_cat,$in)) {
						$cont.= '<h2>'.$r->title.'</h2><div class="small">'.konversi_tanggal('D, j M Y',substr($r->date_start,0,10)).'</div><div class="clear"></div>';;
						$cont.= '<p>'.$r->content.'</p>';
						/*$cont.= '<p>Simpan sebagai : <a href="'.site_url('home/export_pdf/'.$r->id_destinasi).'" title="PDF"><img src="'.base_url('assets/images/pdf.png').'"></a> <a href="'.site_url('home/export_word/'.$r->id_destinasi).'" title="Ms. Word"><img src="'.base_url('assets/images/word.png').'"></a></a></p>';
					*/	}
						
					}
					$cont.=$links;
				} else {
					$cont.="<p>Halaman Tidak Ditemukan oi</p>";
				}
			} else {
				$cont.="<p>Kategori Tidak Ditemukan</p>";
			}
			
		} else {
				$from_x = array(
					'cms_destinasi b' => '',
					'cms_uploads a' => array('a.id_destinasi = b.id_destinasi','left')
				);
			$data_content = $this->general_model->datagrab(array(
					'tabel'=>$from_x,
					'select'=>'*',
					'where'=>array('b.code'=>$code,'b.permalink'=>$title)));

			
			if ($data_content->num_rows() > 0) {
			

				$content = $data_content->row();
				$cont.= '<h2>'.$content->title.'</h2><div class="small">'.konversi_tanggal('D, j M Y',substr($content->date_start,0,10)).'</div><div class="clear"></div>';
				$cont.= '<p>'.$content->content.'</p>';


					$cek_id_destinasi = $this->general_model->datagrab(array(
						'tabel'=>'cms_destinasi',
						'where'=>array('permalink'=>$title)))->row();

				
					$from_album = array(
						'cms_kamar b' => '',
						'cms_destinasi a' => array('a.id_destinasi = b.id_destinasi','left')/*,
						'cms_gbr_kamar c' => 'c.id_kamar = b.id_kamar'*/
					);
					$data_album = $this->general_model->datagrab(array(
						'tabel'=>$from_album,
						'select'=>'a.*,b.title as tit,b.content as kontent,b.harga as harg,b.jumlah_kamar as jum,b.id_kamar as id_kam',
						'where'=>array('a.id_destinasi'=>$cek_id_destinasi->id_destinasi)));

					$xxx = '<div col-lg-12><ul>';

					$xxx .='';
					$no = 1;
					foreach($data_album->result() as $gbr){
							$arrfas = $gbr->id_kam;
							/*cek($gbr->id_kam);
							*/
							// cek($arrfas);
							// cek($gbr);
							$fls = $this->general_model->datagrab(array('tabel'=>'cms_gbr_kamar','where'=>array('id_kamar'=>$arrfas)));
									/*cek($fls->num_rows());
									*/
							$fasilitas=array();
							
								foreach($fls->result() as $xx){
									$fas = '<div class="galeri" style="width:30%;float:left;    border: 5px solid #ecf0f1;margin:10px;"><a href="'.base_url('uploads/kamar/'.$xx->berkas).'" class="fancybox"><img src="'.base_url('uploads/kamar/'.$xx->berkas).'" class="img-responsive" style="width:100% !important;height:125px;"></a></div>';
									$fasilitas[] = $fas;
									// cek($xx->berkas);
								}
								$fas=@implode($fasilitas);
						$xxx .= '<li  style="list-style-type: none !important;"><h3><span>'.$gbr->tit.'</span> <span><i class="fa fa-calendar"> Harga :  '.rupiah($gbr->harg).'</i></span> <span><i class="fa fa-home"> Jumlah : '.$gbr->jum.'</i></span></h3>
						<div><h5>PHOTO</h5></div><div class="col-lg-12" style="margin-bottom:20px;">
						'.$fas.'</div></li><br><br>';
					     $no++;
					  }
					  $xxx .= '</ul></div>';

					    $cont.= '<br><br> Data : ';
					  $cont.= '<div class="col-lg-12 no-padding">'.$xxx.'</div>';

				$cont.= '<div class="pull-right">


				<div class="fb-share-button" data-href="'.site_url('berita/'.$this->uri->segment(3)).'" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2FServeryes.ddns.net/cms_inspektorat_ppu%2F&amp;src=sdkpreparse">Bagikan</a></div> </div><br>';

				$cont .="<br><br>";

				/*$cont.= '<p>Simpan sebagai : <a href="'.site_url('home/export_pdf/'.$content->id_destinasi).'" title="PDF"><img src="'.base_url('assets/images/pdf.png').'"></a> <a href="'.site_url('home/export_word/'.$content->id_destinasi).'" title="Ms. Word"><img src="'.base_url('assets/images/word.png').'"></a>';
*/



			$html = str_get_html($content->content);
			$data['script'] = '';
			foreach($html->find('img') as $elgbr) {
       		
				$img_id = $elgbr->id;

				$data['script'] .= '
					
						$("#'.$img_id.'").after("<div style=\'text-align:center;font-size:10px;\'><i>'.$elgbr->alt.'</i></div><br>");

					';
				
			}

				
				if($content->file_name != ''){
					$cont .= '<p>Download lampiran : <a href="'.site_url('home/download_file/'.$content->file_name).'" title="Lampiran"><img src="'.base_url('assets/images/lampiran.jpg').'"></a>';
				}else{
					$cont .= '';
				} 
				$cont .= '</p>';
				
				@$unseri = unserialize(@$content->id_jenis_destinasi);
				$linked = $this->general_model->datagrab(array(
					'tabel'=>'cms_destinasi',
						'order'=>'date_start DESC'));
				//$linked = $this->universal_model->data_list('cms_destinasi',null,null,null,array('date_start' => 'desc'));

				$cont .= '<br><br><h3>Artikel  terkait : </h3>';
				$cont .= '<ul>

				';
				
				foreach(@$unseri as $uns){
					$q = 'SELECT * FROM cms_destinasi WHERE id_jenis_destinasi REGEXP \'.*;s:[0-9]+:"'.$uns.'".*\' limit 3';
					//$hasil = $this->universal_model->data_query($q);
					$hasil = $this->general_model->datagrab(array(
					'tabel'=>'cms_destinasi',
						'where'=>array('permalink'=>$title)));
					foreach($hasil->result() as $has){
						if($content->id_destinasi!=$has->id_destinasi){
						$cont .= '<li><a href="'.site_url('berita/'.$has->permalink).'">'.$has->title.'</a></li>';
						}
					}
				}
				$cont .= '</ul>';	

				/*$cont .= '<h2>Berita Terbaru</h2><ul>';  
				$q = $this->universal_model->data_list('cms_articles','5',null,array('code'=>'1'),array('date_start'=>'desc'));
				foreach($q->result() as $row){
					$cont .= '<li><a href="'.site_url('berita/'.$row->permalink).'">'.$row->title.'</a></li>';
				}
				$cont .= '</ul>';*/
			}else {
				$cont.="<p>Halaman Tidak Ditemukan</p>";
			}
			
		}

		$data['content'] = $cont;
		
		$this->theme->set_theme(THEME);
		
		$this->theme->render('cms/home',$data);
	}
	
	function download($title = null,$title2 = null) {
		$cont = "";
		
		if(!empty($title2)) $title2 = $title2;
		else $title2 = @$_POST['catdown'];
		
		if(!empty($title)){
			if ($title == "kategori") {
				$combo_catdown = array();
				$combo_catdown[''] = 'Silakan Pilih';
				$combo_kategori = $this->general_model->combo_box(array('tabel' => 'cms_categories','where'=>array('code'=>'8'),'select'=>'category,id_cat','key' => 'id_cat','val' => array('category')));


				foreach($this->route_model->get_category(8,null)->result() as $r_cat){
					$uri_catdown = url_title($r_cat->category);
					$combo_catdown[$uri_catdown] = $r_cat->category;
				}
				
				if(!empty($title2)){ 
					$cat_name = str_replace('-',' ', $title2);
					/*$cont .= "<p>".form_open('home/download/kategori/')."Kategori : ".form_dropdown('catdown',$combo_kategori)." ".form_submit('submit','Tampilkan','class=button_save');*/
					$cont .= " atau <a href='".site_url('home/download/kategori')."'>Semua Daftar Download</a>".form_close()."</p>";
					$cont .= "<p>Daftar file download untuk kategori '<u>".$cat_name."</u>' : </p>";
					$cont .= "<table border='1' style='width:100%;border-collapse:collapse;border-color:#ccc;'>
							<tr>
								<th width='20'>No</th>
								<th width='250'>Judul</th>
								<th width='80'>Detail</th>
							</tr>";
				}else{
					/*$cont .= "<p>".form_open('home/download/kategori/')."Kategori : ".form_dropdown('catdown',$combo_kategori)." ".form_submit('submit','Tampilkan','class=button_save')." ".form_close()."</p>";*/
					$cont .= "<p>Daftar file download :</p>";
					$cont .= "<table border='1' style='width:100%;border-collapse:collapse;border-color:#ccc;'>
							<tr>
								<th width='20'>No</th>
								<th width='250'>Judul</th>
								<th width='200'>Kategori</th>
								<th width='80'>Detail</th>
							</tr>";
				}
				
				
				$cat = $this->route_model->get_category(8,$title2)->row(); //mendapatkan kategori 
				if (!empty($cat) and !empty($title2)) {
					$data_content = $this->route_model->get_download();
					
					$no = 1;
					$jml = 0;
					foreach($data_content->result() as $r) {				
						$in = @unserialize($r->id_cat);
						if (in_array($cat->id_cat,$in)) {
							$jml = $jml+1;
							$cont .= "<tr>
										<td align='center'>".$no."</td>
										<td>".$r->judul."</td>
										<td align='center'><a href='".site_url('home/download/'.url_title($r->judul))."'>[Detail]</a></td>
										 </tr>";
							$no++;
						}
					}
					
					if($jml == 0) $cont.="<tr><td colspan='3'>Tidak ditemukan data</td></tr>";
					$cont .= "</table>";
					$cont .= "<p>Total : ".$jml."<p>";

				} else { 
					
					$data_content = $this->route_model->get_download();
					if ($data_content->num_rows() > 0) {
						$no = 1;
						foreach($data_content->result() as $r) {				
							$in = @unserialize($r->id_cat);
								$t = "";
								$i = 1;
								foreach($in as $on){
									$c = $this->route_model->get_catname($on)->row();
									if($i < count($in)) $t .= $c->category.", ";
									else $t .= @$c->category;
									$i++;
								}
								$cont .= "<tr>
											<td align='center'>".$no."</td>
											<td>".$r->judul."</td>
											<td>".$t."</td>
											<td align='center'><a href='".site_url('home/download/'.url_title($r->judul))."'>[Detail]</a></td>
										  </tr>";
							
							$no++;
						}
						$cont .= "</table>";
						$cont .= "<p>Total : ".$data_content->num_rows()."<p>";
					} else {
						$cont.="<tr><td colspan='4'>Halaman Tidak Ditemukan</td></tr>";
					}
				}
				
			} else { //untuk single atau detail download
				$data_content = $this->route_model->get_download($title);
				
				if ($data_content->num_rows() > 0) {
					$content = $data_content->row();
					$ex_ket  = @explode('|', $content->keterangan);
					
					$user = _ci()->session->userdata('username');
					if($content->privasi == '2'){
						if(!empty($user )) $link = "<a href='".site_url('home/download_file/'.$content->file_name)."'>Klik di sini...</a>";
						else $link = "Anda harus login terlebih dahulu... <a href='".site_url('home/login')."'>[Login]</a>";
					}else{
						$link = "<a href='".site_url('home/download_file/'.$content->file_name)."'>Klik di sini...</a>";
					}
					
					$cont .= "<table>
								<tr>
									<td width='100'>Nama File</td>
									<td width='10'>:</td>
									<td>".@$content->file_name."</td>
								</tr>
								<tr>
									<td>Pengunggah</td>
									<td>:</td>
									<td>".@$content->pengunggah."</td>
								</tr>
								<tr>
									<td>Resensi</td>
									<td>:</td>
									<td>".@$content->resensi."</td>
								</tr>
								<tr>
									<td>Tipe</td>
									<td>:</td>
									<td>".@$ex_ket[0]."</td>
								</tr>
								<tr>
									<td>Ukuran</td>
									<td>:</td>
									<td>".@$ex_ket[1]."</td>
								</tr>
								<tr>
									<td>Download</td>
									<td>:</td>
									<td>".@$link."</td>
								</tr>
								</table>
								";

				} else {
					$cont .="<p>Halaman Tidak Ditemukan</p>";
				}
			}
		}else{
			$cont .="<p>Halaman Tidak Ditemukan</p>";
		}

		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);
	}
	
	function personel($title = null, $title2 = null, $title3 = null){
		$cont = null;
		
		if(!empty($title2)) $title2 = $title2;
		else $title2 = @$_POST['catperson'];
		
		if ($title == "kategori") {
			$combo_catperson = array();
			$combo_catperson[''] = 'Silakan Pilih';
			foreach($this->route_model->get_category(7,null)->result() as $r_cat){
				$url_catperson = url_title($r_cat->category);
				$combo_catperson[$url_catperson] = $r_cat->category;
			}
		 
			if (!empty($title2)) {
			
				$cat_name = str_replace('-',' ', $title2);
				$cont .= "<p>".form_open('home/personel/kategori/')."Kategori : ".form_dropdown('catperson',$combo_catperson)." ".form_submit('submit','Tampilkan','class=button_save');
				$cont .= " atau <a href='".site_url('home/personel/kategori')."'>Semua Daftar Personel</a>".form_close()."</p>";
				$cont .= "<p>Daftar personel untuk kategori '<u>".$cat_name."</u>' : </p>";
				$id_catperson = $this->route_model->get_category(null,$title2)->row();
				
				$data_content = $this->route_model->get_personel($id_catperson->id_cat);
				if ($data_content->num_rows() > 0) {
				
				$kolom_tambahan = null;
				$extend = !empty($id_catperson) ? unserialize($id_catperson->extends_cat) : null;
				if (!empty($extend)) {
					$opsi_kolom = array('1'=>'NIP','2'=>'Jabatan','3'=>'Golongan','4'=>'Uraian Tugas');
					foreach($extend as $ex) { 
						$kolom_tambahan .= '<th>'.$opsi_kolom[$ex].'</th>';
					}
				}
				$cont .= "<table border='1' style='width:100%;border-collapse:collapse;border-color:#ccc;'>
						<tr>
							<th width='20'>No</th>
							<th width='250'>Nama</th>".$kolom_tambahan."
							<th width='80'>Detail</th></tr>";
					$no = 1;
					foreach($data_content->result() as $r) {
						
						$opsi_kolom = array('1'=>'nip','2'=>'jabatan','3'=>'golongan','4'=>'uraian_tugas');
						$kolom_isi = null;
						
						if (!empty($extend)) {
							$kolom_isi .= !empty($r->nip) ? '<td>'.$r->nip.'</td>' : null;
							$kolom_isi .= !empty($r->jabatan) ? '<td>'.$r->jabatan.'</td>' : null;
							$kolom_isi .= !empty($r->golongan) ? '<td>'.$r->golongan.'</td>' : null;
							$kolom_isi .= !empty($r->uraian_tugas) ? '<td>'.$r->uraian_tugas.'</td>' : null;
						}
						
						$cont .= "<tr>
									<td align='center'>".$no."</td>
									<td>".$r->nama."</td>".$kolom_isi."
									<td align='center'><a href='".site_url('home/personel/'.to_url($r->nama))."'>Detail &raquo;</a></td>
								</tr>";
						$no++;
					}
					
					$cont .= "</table>";
					$cont .= "<p>Total : ".$data_content->num_rows()."<p>";
				} else {
					$cont.="<div class='journal-info'>Halaman Tidak Ditemukan</div>";
				}
			} else { 
				
				$cont .= "<p>".form_open('home/personel/kategori/')."Kategori : ".form_dropdown('catperson',$combo_catperson)." ".form_submit('submit','Tampilkan','class=button_save')." ".form_close()."</p>";
				$cont .= "<p>Daftar personel untuk semua kategori :</p>";
				$cont .= "<table border='1' style='width:100%;border-collapse:collapse;border-color:#ccc;'>
						<tr>
							<th width='20'>No</th>
							<th width='250'>Nama</th>
							<th width='250'>Alamat</th>
							<th width='200'>Status</th>
							<th width='80'>Detail</th>
						</tr>";
				
				$data_content = $this->route_model->get_personel(null);
				if ($data_content->num_rows() > 0) {
					$no = 1;
					foreach($data_content->result() as $r) {				
							$cont .= "<tr>
										<td align='center'>".$no."</td>
										<td>".$r->nama."</td>
										<td>".$r->alamat."</td>
										<td>".$r->category."</td>
										<td align='center'><a href='".site_url('home/personel/'.to_url($r->nama))."'>Detail &raquo;</a></td>
									  </tr>";
							$no++;
					}
					$cont .= "</table>";
					$cont .= "<p>Total : ".$data_content->num_rows()."<p>";
				} else {
					$cont.="<tr><td colspan='5'>Halaman Tidak Ditemukan</td></tr>";
				}
			} 
		}else { //untuk single atau detail personel
			$nmperson = from_url($title);
			$data_content = $this->route_model->get_personel(null,$nmperson);
			
			if ($data_content->num_rows() > 0) {
				$gender = array('L'=>'Pria','P'=>'Wanita');
				$content = $data_content->row();
				$cont .= "<table>
							<tr>
								<td width='150'>Nama</td>
								<td width='10'>:</td>
								<td>".$content->nama."</td>
								<td>&nbsp;</td>
								<td rowspan='8'><img src='".base_url('uploads/photos/'.$content->foto)."' width='150' height='150' class='img-border'></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td>".$content->alamat."</td>
							</tr>
							<tr>
								<td>Tempat, Tanggal Lahir</td>
								<td>:</td>
								<td>".$content->tempat_lahir.", ".$content->tanggal_lahir."</td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td>".$gender[$content->gender]."</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>:</td>
								<td>".$content->email."</td>
							</tr>
							<tr>
								<td>No. Telpon</td>
								<td>:</td>
								<td>".$content->no_telepon."</td>
							</tr>
							<tr>
								<td>Pekerjaan</td>
								<td>:</td>
								<td>".$content->pekerjaan."</td>
							</tr>
							<tr>
								<td>Lain-lain</td>
								<td>:</td>
								<td>".$content->keterangan."</td>
							</tr>
							</table>
							";
					$cont .= "<p><a href='".site_url('personel/kategori')."'>&laquo Ke Daftar Personel</a></p>";

			} else {
				$cont.="<p>Halaman Tidak Ditemukan</p>";
			}
		}
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	/* -- HALAMAN LOWONGAN KERJA -- */
	function loker($title = null, $title2 = null){
		$cont = "";
		
		if(!empty($title2)) $title2 = $title2;
		else $title2 = @$_POST['catloker'];
		
		if ($title == "kategori") {
			$combo_catloker = array();
			$combo_catloker[''] = 'Silakan Pilih';
			foreach($this->route_model->get_category(14,null)->result() as $r_cat){
				$url_catperson = url_title($r_cat->category);
				$combo_catloker[$url_catperson] = $r_cat->category;
			}
			
			if(!empty($title2)){ 
				$cat_name = str_replace('-',' ', $title2);
				$cont .= "<p>".form_open('home/loker/kategori/')."Kategori : ".form_dropdown('catloker',$combo_catloker)." ".form_submit('submit','Tampilkan','class=button_save');
				$cont .= " atau <a href='".site_url('home/loker/kategori')."'>Semua Daftar Lowongan Kerja</a>".form_close()."</p>";
				$cont .= "<p>Daftar lowongan kerja untuk kategori '<u>".$cat_name."</u>' : </p>";
				$cont .= "<table border='1' style='width:100%;border-collapse:collapse;border-color:#ccc;'>
						<tr>
							<th width='20'>No</th>
							<th width='250'>Lowongan Kerja</th>
							<th width='80'>Detail</th>
						</tr>";
			}else{
				$cont .= "<p>".form_open('home/loker/kategori/')."Kategori : ".form_dropdown('catloker',$combo_catloker)." ".form_submit('submit','Tampilkan','class=button_save')." ".form_close()."</p>";
				$cont .= "<p>Daftar lowongan kerja untuk semua kategori :</p>";
				$cont .= "<table border='1' style='width:100%;border-collapse:collapse;border-color:#ccc;'>
						<tr>
							<th width='20'>No</th>
							<th width='250'>Lowongan Kerja</th>
							<th width='250'>Kategori</th>
							<th width='80'>Detail</th>
						</tr>";
			}
			
			$cat = $this->route_model->get_category(14,$title2)->row(); //mendapatkan kategori 
				if (!empty($cat) and !empty($title2)) {
					$data_content = $this->route_model->get_article(14);
					if ($data_content->num_rows() > 0) {
						$no = 1;
						$jml = 0;
						foreach($data_content->result() as $r) {				
							$in = @unserialize($r->id_cat);
							if (in_array($cat->id_cat,$in)) {
								$jml = $jml+1;
								$cont .= "<tr>
											<td align='center'>".$no."</td>
											<td>".$r->title."</td>
											<td align='center'><a href='".site_url('home/loker/'.to_url($r->title))."'>[Detail]</a></td>
										  </tr>";
								$no++;
							}
						}
						$cont .= "</table>";
						$cont .= "<p>Total : ".$jml."<p>";
					} else {
						$cont.="<tr><td colspan='3'>Halaman Tidak Ditemukan cuy</td></tr>";
					}
				} else { 
					
					$data_content = $this->route_model->get_article(14,null);
					if ($data_content->num_rows() > 0) {
						$no = 1;
						foreach($data_content->result() as $r) {				
							$in = @unserialize($r->id_cat);
								$t = "";
								$i = 1;
								foreach($in as $on){
									$c = $this->route_model->get_catname($on)->row();
									if($i < count($in)) $t .= $c->category.", ";
									else $t .= $c->category;
									$i++;
								}
								$cont .= "<tr>
											<td align='center'>".$no."</td>
											<td>".$r->title."</td>
											<td>".$t."</td>
											<td align='center'><a href='".site_url('home/loker/'.to_url($r->title))."'>[Detail]</a></td>
										  </tr>";
							
							$no++;
						}
						$cont .= "</table>";
						$cont .= "<p>Total : ".$data_content->num_rows()."<p>";
					} else {
						$cont.="<tr><td colspan='4'>Halaman Tidak Ditemukan cuy</td></tr>";
					}
				}
		} else { //untuk single atau detail loker
			
			$title = from_url($title);echo $title;
			$data_content = $this->route_model->get_article(null,$title);
				
			if ($data_content->num_rows() > 0) {
				$content = $data_content->row();
				$cont .= "<p><h1>".$content->title."</h1></p>";
				$cont .= "<p>".$content->content."</p>";

			} else {
				$cont .="<p>Halaman Tidak Ditemukan</p>";
			}
		}
	

		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	/*
	function contact(){
		$msg = $this->session->flashdata('msg');
		if(!empty($msg)) $msg = $msg;
		else $msg = '';
		
			
		$form  = '<form method="post" action="'.site_url('home/save_contact').'">';
		$form .= '<div class="contact">';
		$form .= '<p><label>Nama</label><input type="text" name="nama"></p>';
		$form .= '<p><label>Email</label><input type="text" name="email"></p>';
		$form .= '<p><label>Alamat</label><textarea name="alamat"></textarea></p>';
		$form .= '<p><label>Tentang</label><input type="text" name="judul"></p>';
		$form .= '<p><label>Isi</label><textarea name="isi"></textarea></p>';
		$form .= '<p><label></label><input type="submit" value="Kirim" class="button_save"></p>';
		$form .= '</div>';
		$form .= '</form>';
		
		
		$data['content'] = $form;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	
	function save_contact(){
		$nama	= $_POST['nama'];
		$email	= $_POST['email'];
		$alamat	= $_POST['alamat'];
		$judul	= $_POST['judul'];
		$isi	= $_POST['isi'];
		
		$data 	= array('nama'=>$nama,'email'=>$email,'alamat'=>$alamat,'judul'=>$judul,'isi'=>$isi);
		
		$simpan	= $this->general_model->save_contact($data);
		
		if($simpan) $this->session->set_flashdata('msg','Kontak berhasil dikirim...');
		else $this->session->set_flashdata('msg','Kontak gagal dikirim...');
		
		redirect('home/contact/');
	}
	*/
	
		
	function daftar_harga(){
		
		$tgs =_ci()->general_model->datagrab(array(
			'tabel' => 'cms_komoditi_produsen'));
		

		$detail_cek_aplikasix =_ci()->general_model->datagrabs(array('tabel'=>'cms_table_produsen'
					 ));
				$data['detail_cek_aplikasix']=$detail_cek_aplikasix;

			$tgl_1=_ci()->general_model->datagrabs(array('tabel'=>'cms_table_produsen','select'=>'tgl_1,id_table_produsen','where'=>array('id_table_produsen'=>'1')))->row();

			$tgl_2=_ci()->general_model->datagrabs(array('tabel'=>'cms_table_produsen','select'=>'tgl_2,id_table_produsen','where'=>array('id_table_produsen'=>'1')))->row();



$the_article ='


<div class="judul-harga" style="font-size:16px;font-weight:bold;">Rata-Rata Harga di Tingkat Produsen Kecamatan</div>
<table class="table table-bordered table-condensed" style="font-size:12px;">
	<tbody>
		<tr>
			<td style="background:#f9f9f9;" rowspan="2" colspan="1">No</td>
			<td style="background:#f9f9f9;" rowspan="2" colspan="1">Jenis Komoditi</td>
			<td style="background:#f9f9f9;text-align:center;" colspan="2">Harga (Rp)</td>
			<td style="background:#f9f9f9;text-align:center;" colspan="1">Perubahan</td>
		</tr>
';
			
			$nox = 1;
			foreach ($detail_cek_aplikasix->result() as $x) {
				$the_article .='
		<tr>
				<td style="background:#f9f9f9;text-align:center;">'.tanggal_indo($x->tgl_1).'</td>
				<td style="background:#f9f9f9;text-align:center;">'.tanggal_indo($x->tgl_2).'</td>

			<td style="background:#f9f9f9;text-align:center;">Rp</td>
		</tr>';
			}		 
		


			$no = 1;
			foreach ($tgs->result() as $row) { 
$the_article .='
		<tr>
				<td>'.$no.'</td>
				<td>'.$row->nama_komoditi_produsen.'</td>
				
';

				
				$nox = 1;
				$harga_1 = _ci()->general_model->datagrabs(array('tabel'=>'cms_table_produsen','where'=>array('id_table_produsen'=>1)));
			

				$from_harga_1= array(
					'cms_tanggal_harga a' => '',
					'cms_komoditi_produsen b' => array('a.id_komoditi_produsen = b.id_komoditi_produsen','left'),
					'cms_survei_produsen c' => array('a.id_survei_produsen = c.id_survei_produsen','left')
				);


					$yy = _ci()->general_model->datagrabs(array('tabel'=>$from_harga_1,
					 'where'=>array('a.id_komoditi_produsen'=>$row->id_komoditi_produsen,'c.tanggal_survei'=>$tgl_1->tgl_1),
					 ));
					 foreach ($yy->result() as $y) {
					$the_article .='

						<td style="text-align:center;">'.numberToCurrency($y->harga).'</td>';
			}
				 


				 if($yy->num_rows() == 0) $the_article .='<td style="text-align:center;">-</td>';


				 
				$from_harga_2= array(
					'cms_tanggal_harga a' => '',
					'cms_komoditi_produsen b' => array('a.id_komoditi_produsen = b.id_komoditi_produsen','left'),
					'cms_survei_produsen c' => array('a.id_survei_produsen = c.id_survei_produsen','left')
				);


					$xx =_ci()->general_model->datagrabs(array('tabel'=>$from_harga_2,
					 'where'=>array('a.id_komoditi_produsen'=>$row->id_komoditi_produsen,'c.tanggal_survei'=>$tgl_2->tgl_2),
					 ));
					 foreach ($xx->result() as $x) {
				 $the_article .='
				<td style="text-align:center;">'.numberToCurrency($x->harga).'</td>
				<td style="text-align:center;">'
				.(($y->harga < $x->harga) ? 
					'<span class="pull-left"><img src="'.base_url('themes/new/images/naik.png').'"  style="width: 15px;height: 15px !important;"></span>'
					.(numberToCurrency($x->harga-$y->harga)) : (($y->harga == $x->harga) ? ' - ': (($y->harga > $x->harga)? '<span class="pull-left"><img src="'.base_url("themes/new/images/turun.png").'"  style="width: 15px;height: 15px !important;"></span> '.(numberToCurrency($y->harga-$x->harga)) : '')))



				.'</td>';

			}








		$the_article .='</tr>';
		$no++;
		}
		$the_article .='
</tbody>
</table>';





//pasar induk


			$tgs2 = _ci()->general_model->datagrab(array(
			'tabel' => 'cms_komoditi_pasarinduk'));

		$detail_cek_aplikasiy =_ci()->general_model->datagrabs(array('tabel'=>'cms_table_pasarinduk'
					 ));
				$data['detail_cek_aplikasiy']=$detail_cek_aplikasiy;

			$tgl_3=_ci()->general_model->datagrabs(array('tabel'=>'cms_table_pasarinduk','select'=>'tgl_1,id_table_pasarinduk','where'=>array('id_table_pasarinduk'=>'1')))->row();

			$tgl_4=_ci()->general_model->datagrabs(array('tabel'=>'cms_table_pasarinduk','select'=>'tgl_2,id_table_pasarinduk','where'=>array('id_table_pasarinduk'=>'1')))->row();





			$the_article2 ='



			<div class="judul-harga" style="font-size:16px;font-weight:bold;">Harga Konsumen di Pasar Induk Purwodadi</div>
			<table class="table table-bordered table-condensed"  style="font-size:12px;">
				<tbody>
					<tr>
						<td style="background:#f9f9f9;" rowspan="2" colspan="1">No</td>
						<td style="background:#f9f9f9;" rowspan="2" colspan="1">Jenis Komoditi</td>
						<td style="background:#f9f9f9;text-align:center;" colspan="2">Harga (Rp)</td>
						<td style="background:#f9f9f9;text-align:center;" colspan="1">Perubahan</td>
					</tr>
			';
			
			$nox = 1;
			foreach ($detail_cek_aplikasiy->result() as $x) {
				$the_article2 .='
		<tr>
				<td style="background:#f9f9f9;text-align:center;">'.tanggal_indo($x->tgl_1).'</td>
				<td style="background:#f9f9f9;text-align:center;">'.tanggal_indo($x->tgl_2).'</td>

			<td style="background:#f9f9f9;text-align:center;">Rp</td>
		</tr>';
			}		 
		


			$no = 1;
			foreach ($tgs2->result() as $row) { 
			$the_article2 .='
				<tr>
						<td>'.$no.'</td>
						<td>'.$row->nama_komoditi_pasarinduk.'</td>
						
				';

				
				$nox = 1;
				$harga_1 = _ci()->general_model->datagrabs(array('tabel'=>'cms_table_produsen','where'=>array('id_table_produsen'=>1)));
			
				$from_harga_1= array(
					'cms_pasar_induk a' => '',
					'cms_komoditi_pasarinduk b' => array('a.id_komoditi_pasarinduk = b.id_komoditi_pasarinduk','left'),
					'cms_survei_pasarinduk c' => array('a.id_survei_pasarinduk = c.id_survei_pasarinduk','left')
				);


					$yy = _ci()->general_model->datagrabs(array('tabel'=>$from_harga_1,
					 'where'=>array('a.id_komoditi_pasarinduk'=>$row->id_komoditi_pasarinduk,'c.tanggal_survei'=>$tgl_3->tgl_1),
					 ));
					 foreach ($yy->result() as $y) {
					$the_article2 .='

						<td style="text-align:center;">'.numberToCurrency($y->harga).'</td>';
			}
				 


				 if($yy->num_rows() == 0) $the_article2 .='<td style="text-align:center;">-</td>';


				 
				$from_harga_2= array(
					'cms_pasar_induk a' => '',
					'cms_komoditi_pasarinduk b' => array('a.id_komoditi_pasarinduk = b.id_komoditi_pasarinduk','left'),
					'cms_survei_pasarinduk c' => array('a.id_survei_pasarinduk = c.id_survei_pasarinduk','left')
				);


					$xx =_ci()->general_model->datagrabs(array('tabel'=>$from_harga_2,
					 'where'=>array('a.id_komoditi_pasarinduk'=>$row->id_komoditi_pasarinduk,'c.tanggal_survei'=>$tgl_4->tgl_2),
					 ));
					 foreach ($xx->result() as $x) {
				 $the_article2 .='
				<td style="text-align:center;">'.numberToCurrency($x->harga).'</td>
				<td style="text-align:center;font-weight:bold">'
				.(($y->harga < $x->harga) ? 
					'<span class="pull-left"><img src="'.base_url('themes/new/images/naik.png').'"  style="width: 15px;height: 15px !important;"></span>'
					.(numberToCurrency($x->harga-$y->harga)) : (($y->harga == $x->harga) ? ' - ': (($y->harga > $x->harga)? '<span class="pull-left"><img src="'.base_url("themes/new/images/turun.png").'"  style="width: 15px;height: 15px !important;"></span> '.(numberToCurrency($y->harga-$x->harga)) : '')))



				.'</td>';

			}








		$the_article2 .='</tr>';
		$no++;
		}
		$the_article2 .='
</tbody>
</table>';



		//return $the_article;



		$data['content'] = '<h1 style="border-bottom:2px solid #2e7d32">Update Harga</h1><br><br>'.$the_article.'<br><br>'.$the_article2;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	function contact(){
		$msg = $this->session->flashdata('msg');
		if(!empty($msg)) $msg = $msg;
		else $msg = '';

		$dtform = $this->general_model->datagrab(array('tabel'=>'cms_form_contact','where'=>array('status'=>1),'order'=>'urutan asc'));
		$form  = '';
		$form .= $msg;
		$form .= '<form method="post" action="'.site_url('home/save_contact').'">';
		$form .= '<div class="contact" style="width: 30%;">';
		foreach ($dtform->result() as $row) {
			$form .= '<p>'.$row->label.$row->tag.'</p>';
			$form .= '<p>'.form_error('nama').'</p>';
		}
		$form .= '</div>';
		$form .= '</form>';
		
		$data['content'] = $form;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}

	function save_contact(){
			$nama		= $this->input->post('nama');
			$email		= $this->input->post('email');
			$instansi	= $this->input->post('instansi');
			$alamat		= $this->input->post('alamat');
			$judul		= $this->input->post('judul');
			$isi		= $this->input->post('isi');
			
			$data 	= array('nama'=>$nama,'email'=>$email,'instansi'=>$instansi,'alamat'=>$alamat,'judul'=>$judul,'isi'=>$isi,'status'=>1);
			
			$simpan	= $this->general_model->save_contact($data);
			
			if($simpan) $this->session->set_flashdata('msg','Kontak berhasil dikirim...');
			else $this->session->set_flashdata('msg','Kontak gagal dikirim...');
			redirect('home/contact/');
	}
	
	function press_release($id = '0', $down = '0', $offset = null){
		$down = empty($down) ? '0' : $down;
		if($id == '0' and  $down == '0'){
			!empty($offset) ? $offset : '0';
			
			$config['base_url']		= site_url('home/press_release/'.$id.'/'.$down);
			$config['total_rows']	= $this->universal_model->data_list('cms_press_release')->num_rows();
			$config['per_page']		= '10';
			$config['uri_segment']	= '6';
			
			$this->pagination->initialize($config);
			$link = $this->pagination->create_links();
			$total= $config['total_rows'];
			
			$query = $this->universal_model->data_list('cms_press_release',$config['per_page'],$offset);
			$str = '';
			if($query->num_rows() != 0){
				$str  .= '<div class="press_release">';
				foreach($query->result() as $row){
					$download = 'tidak ada lampiran'; if(!empty($row->lampiran)) $download = '<a href="'.site_url('press_release/0/'.base64_encode($row->lampiran)).'" target="_blank" title="Dowload Press Release"><img src="'.base_url('assets/images/lampiran.jpg').'"></a>';
					$str .= '<h1>'.$row->judul_press.'</h1>';
					$str .= '<h3>Oleh : '.$row->pengunggah.'</h3>';
					$str .= '<p>'.truncate($row->isi_press,400).'</p>';
					$str .= '<p>Download versi lengkap : '.$download.'</p>'; 
					$str .= '<p><a class="link_next" href="'.site_url('press_release/'.$row->id_press).'">Selengkapnya</a></p>';
				}
				$str .= '</div>';
				$str .= '<div class="clear"></div>';
				$str .= '<div class="pag-count"><div class="pull-left">'.$link.'</div><div class="pull-right text-right">Total : '.$total.'</div></div>';
			}else{
				$str .= 'Data tidak ditemukan';
			}
		}else if($down != '0'){
			$down = base64_decode($down);
			$lokasi_file = './uploads/press_release/'.$down;
			if(file_exists($lokasi_file)){
				$file = file_get_contents($lokasi_file);
				force_download($down,$file);
			}else{
				$data['content'] = not_exists_file($down);
				$this->theme->set_theme(THEME);
				
		
		$this->theme->render('cms/home',$data);
			}
		}else{
			$row  = $this->universal_model->data_list('cms_press_release',null,null,array('id_press' => $id))->row();
			$download = 'tidak ada lampiran'; if(!empty($row->lampiran)) $download = '<a href="'.site_url('press_release/0/'.base64_encode($row->lampiran)).'" target="_blank" title="Dowload Press Release"><img src="'.base_url('assets/images/lampiran.jpg').'"></a>';
			
			$str  = '<div class="press_release">';
			$str .= '<h1>'.$row->judul_press.'</h1>';
			$str .= '<h3>Oleh : '.$row->pengunggah.'</h3>';
			$str .= '<p class="cover"><img src="'.base_url('uploads/press_release/'.$row->sampul).'"></p>';
			$str .= '<p>'.$row->isi_press.'</p>';
			$str .= '<p><strong>Kontak :</strong> <br>'.$row->kontak.'</p>';
			$str .= '<p>Download versi lengkap : '.$download.'</p>';
			$str .= '</div>';
		}

		$data['content'] = $str;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function transparansi($kat, $offset = null){
		$kat = str_replace('-', ' ', $kat);
		/*cek($kat);*/
		$cont ='
		<div class="col-md-12 col-sm-6">
			<div class="popular-videos" >
				<div class="text-box" style="border:none; padding: 0px;">
					<ul>';
		$cnt = 0;
		$id_kat = $this->route_model->get_category($kat)->row();
		$data_content = $this->route_model->get_article(22,null,null);
		/*cek($id_kat);*/
		foreach($data_content->result() as $r) {
			@$in = unserialize(@$r->id_cat);
			if (@in_array($id_kat->id_cat,$in)) {
				$title = str_replace(' ', '_', $r->title);
			
					$dl = $this->general_model->datagrabs(array(
						'tabel'=>'cms_uploads',
						'where'=>array('code'=>'22', 'id_article'=>$r->id_article)
					))->row();

					$cont .='
						<li style="padding: 5px 0;">
							<div class="text-col" style="padding:0px">
								<h4 style="margin:0px;">
									'.$r->title.'
								</h4>
								<div class="btm-row" style="padding:0px; margin:0px;">
									<ul>
										<li><a href="#"><i class="fa fa-calendar" aria-hidden="true"></i>'.konversi_tanggal('D, j M Y',substr($r->date_start,0,10)).'</a></li>
										<li><a target="_blank" href="'.site_url('uploads/transparansi/'.$dl->file_name).'"><i class="fa fa-download" aria-hidden="true"></i>'.$dl->file_name.'</a></li>
									</ul>
								</div>
							</div>
						</li>';
					$cnt=1;				
			}
		}
		$cont .= '
					</ul>
				</div>
			</div>
		</div>';
		$cont .= '
		<link rel="stylesheet"  href="'.base_url().'themes/cms_2/pagination/pag.css"/>
		<div class="pagination" style="margin:20px 0 50px;width:100%"></div>';


        if($cnt==0) $cont .= '<em style="font:italic 400 16px/14px \'Lato\',sans-serif;display:block;color:#555;padding:20px">Tidak ditemukan data yang sesuai</em>';

        $q = $this->general_model->datagrab(array(
        	'tabel'=>'cms_categories',
        	'where'=>array('code'=>1),
        	'order'=>'category'
        ));
    
		$data['content'] = $cont;
		$data['judul'] = rawurldecode($kat);
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);

		/*if($download == 'semua'){
			!empty($offset) ? $offset : '0';
			
			$config['base_url']		= site_url('home/tranparansi/'.$download);
			$config['total_rows']	= $this->universal_model->data_list('cms_articles',null,null,array('code' => '22'))->num_rows();
			$config['per_page']		= '10';
			$config['uri_segment']	= '6';
			
			$this->pagination->initialize($config);
			$link = $this->pagination->create_links();
			$total= $config['total_rows'];
			
			$query = $this->universal_model->data_list('cms_articles',$config['per_page'],$offset,array('code' => '22'));
			$str = '';
			if($query->num_rows() != 0){
				$str .= 'Berikut daftar transparansi penggunaan anggaran daerah :<br> <ul>';
				foreach($query->result() as $row){
					$explode = explode(' ',$row->date_start);
					$str .= '<li>'.$row->title.' <span class="text-tanggal">('.date_html($explode[0]).')</span><a target="_blank" href="'.site_url('transparansi/'.$row->content).'" class="text-download">Download</a></li>'; 
				}
				$str .= '</ul>';
				$str .= '<div class="pag-count"><div class="pull-left">'.$link.'</div><div class="pull-right text-right">Total : '.$total.'</div></div>';
			}else{
				$str .= 'Data tidak ditemukan';
			}
			
			$data['content'] = $str;
			$this->theme->set_theme(THEME);
			
		
		$this->theme->render('cms/home',$data);
		}else{
			$lokasi_file = './uploads/transparansi/'.$download;
			if(file_exists($lokasi_file)){
				$file = file_get_contents($lokasi_file);
				force_download($download,$file);
			}else{
				$data['content'] = not_exists_file($download);
				$this->theme->set_theme(THEME);
				
		
		$this->theme->render('cms/home',$data);
			}
		}*/
	}
	function forum($title = null){
		

		$cont = "";
		
		if(!empty($title)) $title = $title;
		else $title = @$_POST['catforum'];
		
		$combo_category = array();
		$combo_category[''] = 'Silakan Pilih';
		foreach($this->route_model->get_categori('15',null)->result() as $row){
			$combo_category[url_title($row->category)] = $row->category;
		}
		
		$forum	  = $this->route_model->get_forum();
		
		if(!empty($title)){
			//$cont .= "<form method='post' action='".site_url('home/forum')."'>Kategori : ".form_dropdown('catforum',$combo_category)."".form_submit('submit','Tampilkan','class=button_save')."".form_close();
			
			$category = $this->route_model->get_categori('15',$title)->row();
			$cont .= "<span class='entry-title' itemprop='headline'><b>".str_replace('-', ' ', $title)."</b></span>";
			
			
			$jml = 0;
			
			$id_cat = array();
			$cont .= "<table class='table table-striped table-bordered table-condensed table-nonfluid'>";
			foreach($forum->result() as $row){
				$id_cat[$row->id_cat] = $row->id_cat;
				if(@in_array($category->id_cat, $id_cat)){
					$jml = $jml + 1;
					$cont .= "<tr>
								
								<td>".$row->isi." <span class='small'>(".$row->nama.")</span></td>
								<td align='center'><a href='".site_url('home/forum/'.$row->id_forum.'/'.$row->isi)."'>Lihat</a> | <a rel='nofollow' href='".site_url('home/forum_reply_member/'.$row->id_forum.'/'.$row->isi)."' class='btn btn-blue btn-sm btn-icon'> Post Reply </a>
							
							  </tr>";
				}
			}
			
			if($jml == 0) $cont .= "<tr><td colspan='2'>Belum ada pendapat</td></tr>";
			
			$cont .= "</table>";
			$cont .= "<p>Total Data : ".$jml."</p>";
		}else{
			//$cont .= "<form method='post' action='".site_url('home/forum')."'>Kategori : ".form_dropdown('catforum',$combo_category)."".form_submit('submit','Tampilkan','class=button_save')."".form_close();
			
			$cont .= "<br><table  class='table table-striped table-bordered table-condensed table-nonfluid'>";
			/*$cont .= "			<tr>
							<th width='20'>No</th>
							<th width='200'>Kategori</th>
							<th width='40'>Pendapat</th>
							<th align='center'>Aksi</th>
						</tr>";*/
			$category = $this->route_model->get_categori('15',null);
			$no = 1;
			foreach($category->result() as $row){
				$num_comment = $this->route_model->get_forum($row->id_cat)->num_rows();
				$cont .= "<tr>
							<td>".$no."</td>
							<td><a href='".site_url('home/forum_view/'.$row->id_cat.'/'.$row->slug)."'>".$row->category."<span>  (".$num_comment.")</span></a></td>
							
							<td align='center'><a rel='nofollow' href='".site_url('home/forum_reply/'.$row->id_cat.'/'.$row->category)."' class='btn btn-blue btn-sm btn-icon'> Post Reply </a>
							</td>
						  </tr>";
				$no++;
			}
			
			$cont .= "</table>";
			$cont .= "<p>Total Data : ".$category->num_rows()."</p>";
		}
		
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	
	function forum_view($id_cat,$slug){

		$frm = "";
		$jml = 0;
		
		$user = $this->session->userdata('id');
		
			$frm .= "<h1>".str_replace('-', ' ', $slug)."</h1>";
			$forum = $this->route_model->get_forum_view($id_cat);
			$frm .= "<table class='table table-striped table-bordered table-condensed table-nonfluid'>";
			
					foreach($forum->result() as $row){

						$num_comment = $this->route_model->get_thread_view($row->id_forum)->num_rows();
						$jml = $jml + 1;
						if($num_comment==TRUE){
						$frm .= "<tr>
									<td><i class='icon icon-user'></i> <span class='small'>(".$row->nama." -- ".tanggal($row->waktu).")</span> | <a href='".site_url('home/thread_view/'.$row->id_forum)."'>".$row->isi."</a><span>  (".$num_comment.")</span></td>
									<td align='center'><a rel='nofollow' href='".site_url('home/forum_reply_member/'.$row->id_forum)."' class='btn btn-blue btn-sm btn-icon'> Post Reply </a>
								</tr>";
						}else{
							$frm .= "<tr>
									<td> <span class='small'>(".$row->nama." -- ".tanggal($row->waktu).")</span> | ".$row->isi."</a> (".$num_comment.")</span></td>
									<td align='center'><a rel='nofollow' href='".site_url('home/forum_reply_member/'.$row->id_forum)."' class='btn btn-blue btn-sm btn-icon'> Post Reply </a>
								</tr>";
						}


						
						
					}
		
			
			if($jml == 0) $frm .= "<tr><td colspan='2'>Belum ada pendapat</td></tr>";
			
			$frm .= "</table>";
			$frm .= "<p>Total Data : ".$jml."</p>";

		
		$data['content'] = $frm;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}

	function thread_view($id_forum){
		$frm = "";
		$jml = 0;
		$frm .= "<table class='table table-striped table-bordered table-condensed table-nonfluid'>";

		//$frm .= "<h1>".$isi."</h1>";
		$user = $this->session->userdata('id');
		
			//$frm .= "".from_url($category)."";
			$thread = $this->route_model->get_thread_view($id_forum);
			if(($thread->row('isi') !=NULL)){
				$frm .= "<br><i>".$thread->row('isi')."<i><br><br>";
			}else{
				'';
			}
			//echo $this->db->last_query();

					foreach($thread->result() as $row){

						$jml = $jml + 1;
						$frm .= "<tr>
								<td><i class='icon icon-user'></i> <span class='small'><i>(".$row->nama.")</i></span><br> ".tanggal($row->waktu)."</td>

								<td>".$row->keterangan."</td>
							  </tr>";
						
					}
		
			
			if($jml == 0) $frm .= "<tr><td colspan='2'>Belum ada pendapat</td></tr>";
			$frm .= "</table>";




		$data['content'] = $frm;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	

	function forum_reply_member($id_forum){
		$msg = $this->session->flashdata('msg');
		if(!empty($msg)) $msg = $msg;
		else $msg = '';
		
		$frm = "";
		
		$frm .="<p class='lighting-text'>".$msg."</p>";
		$frm .= "<form method='post' action='".site_url('home/forum_reply_member_save')."'>";
		
		$user = $this->session->userdata('id');
		if(!empty($user)){
			$frm .= "<input type='hidden' name='id_operator' value='".$user."'>
					<input type='hidden' name='id_forum' value='".$id_forum."'>
					
					<table>
						<tr valign='top'>
							<td style='padding-right:20px;'>Pendapat/Isi </td>
							<td><textarea name='keterangan' cols='40' rows='5'></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input type='submit' value='Kirim' class='button_save'></td>
						</tr>
					</table>
					";
		}else{
			$frm .= "Anda harus login terlebih dahulu.";
		}
		
		$frm .= "</form>";
		
		$data['content'] = $frm;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function forum_reply_member_save($id_cat){
		$id_operator = $_POST['id_operator'];
		$id_forum 	 = $_POST['id_forum'];
		$keterangan		 = $_POST['keterangan'];
		
		$data = array('id_forum'=>$id_forum,'id_operator'=>$id_operator,'keterangan'=>$keterangan,'status'=>'1');
		
		$simpan = $this->general_model->save_forum_member($data);
		
		if($simpan) $this->session->set_flashdata('msg','Data berhasil dikirim. Tunggu konfirmasi dari Admin!');
		else $this->session->set_flashdata('msg','Data gagal dikirim.');
		
		redirect('home/thread_view/'.$id_forum);
	}


	function forum_reply($id_cat, $category){
		$msg = $this->session->flashdata('msg');
		if(!empty($msg)) $msg = $msg;
		else $msg = '';
		
		$frm = "";
		
		$frm .="<p class='lighting-text'>".$msg."</p>";
		$frm .= "<form method='post' action='".site_url('home/forum_reply_save')."'>";
		
		$user = $this->session->userdata('id');
		if(!empty($user)){
			$frm .= "<input type='hidden' name='id_operator' value='".$user."'>
					<input type='hidden' name='id_cat' value='".$id_cat."'>
					<input type='hidden' name='cat' value='".$category."'>
					<table>
						<tr>
							<td width='100'>Kategori</td>
							<td><input type='text' name='kategori' value='".from_url($category)."' disabled></td>
						</tr>
						<tr valign='top'>
							<td>Pendapat/Isi</td>
							<td><textarea name='isi' cols='40' rows='5'></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input type='submit' value='Kirim' class='button_save'></td>
						</tr>
					</table>
					";
				
			$frm .= "</table>";
			}else{
				$frm .= "Anda harus <a href='".site_url()."'>login</a> terlebih dahulu.";

			}
		
		$frm .= "</form>";
		
		$data['content'] = $frm;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function forum_reply_save(){
		$id_operator = $_POST['id_operator'];
		$id_cat 	 = $_POST['id_cat'];
		$cat 	 	 = $_POST['cat'];
		$isi		 = $_POST['isi'];
		
		$data = array('id_cat'=>$id_cat,'id_operator'=>$id_operator,'isi'=>$isi,'status'=>'2');
		
		$simpan = $this->general_model->save_forum($data);
		
		if($simpan) $this->session->set_flashdata('msg','Data berhasil disimpan');
		else $this->session->set_flashdata('msg','Data gagal dikirim.');
		
		redirect('home/forum_view/'.$id_cat.'/'.$cat);
	}

	function jurnal($title = null, $title2 = null, $title3 = null){
	
		$hlm = $this->route_model->get_param('hal')->value;
	
		$cont = null;
		
		if(!empty($title2)) $title2 = $title2;
		else $title2 = @$_POST['catjurnal'];
		
		if ($title == "kategori") {
			$offset = !empty($title3) ? $title3 : "0";
			$combo_catjurnal = array();
			$combo_catjurnal[''] = 'Silakan Pilih';
			foreach($this->route_model->get_category(16,null)->result() as $r_cat){
				$url_catjurnal = url_title($r_cat->category);
				$combo_catjurnal[$url_catjurnal] = $r_cat->category;
			}
			
			$config['base_url'] = site_url($title.'/'.$title2);
			$config['total_rows'] = $this->route_model->get_jurnal()->num_rows();
			
			$config['per_page'] = $hlm;
			$config['uri_segment']	= '4';
			$this->pagination->initialize($config);
			$links = $this->pagination->create_links();
			
			$cat = $this->route_model->get_category(16,$title2)->row();
				
				if (!empty($cat) and !empty($title2)) {
					$data_content = $this->route_model->get_jurnal(null,$hlm,$offset);
					
					$no = 1;
					$jml = 0;
					
					foreach($data_content->result() as $r) {
						$in = @unserialize($r->id_cat);
						if (in_array($cat->id_cat,$in)) {
							$jml = $jml+1;
							
							$cont .= "<tr>
										<td align='center'>".$no."</td>
										<td>".$r->judul."</td>- 
										<td>".$r->penulis."</td>
										<td align='center'><a href='".site_url('home/jurnal/'.url_title($r->judul))."'>Detail</a></td>
										</tr>";
							$no++;
						}
					}
					
					if($jml == 0){
						$cont .="<tr><td colspan='4'>Halaman Tidak Ditemukan</td></tr>";
					}
					
					$cont .= "</table>";
					$cont .= "<p>Total : ".$jml."<p>";
					$cont .= $links;
				}else{
					$offset = !empty($title2) ? $title2 : "0";
					$config['base_url'] = site_url('jurnal/kategori');
					$config['total_rows'] = $this->route_model->get_jurnal()->num_rows();
					$config['per_page'] = $hlm;
					$config['uri_segment']	= 3;
					$this->pagination->initialize($config);
					$links = $this->pagination->create_links();
					
					$data_content = $this->route_model->get_jurnal(null,$hlm,$offset);
					
					if ($data_content->num_rows() != 0) {
						$no = 1;
						
						foreach($data_content->result() as $r) {				
							$in = @unserialize($r->id_cat);
								$t = "";
								$i = 1;
								foreach($in as $on){
									$c = $this->route_model->get_catname($on)->row();
									if($i < count($in)) $t .= $c->category.", ";
									else $t .= $c->category;
									$i++;
								}
								
								$vol = !empty($r->volume)? 'Vol: '.$r->volume.' ':null;
								$nomor = !empty($r->nomor)? 'No: '.$r->nomor.' ':null;
								$hal = !empty($r->halaman)? 'Halaman: '.$r->halaman.' ':null;
								
								$cont .= '
								<div class="journal"><h3>'.anchor(site_url('home/jurnal/'.url_title($r->judul)),$r->judul).'</h3><img src="'.base_url('uploads/jurnals/'.$r->cover).'"/>
									<p><i>by '.$r->penulis.'<br/>'.$vol.$nomor.$hal.'<br></i><br/>'.$r->resensi.'</p>
									<a href="'.site_url('home/jurnal/'.url_title($r->judul)).'">Lihat Jurnal</a>
									<div class="clear"></div>
								</div>';
								
							$no++;
						}
					} else {
						$cont .="<tr><td colspan='5'>Halaman Tidak Ditemukan</td></tr>";
					}
					$cont .= "</table>";
					$cont .= "<p>Total : ".$data_content->num_rows()."<p>";
					$cont .= $links;
				}
		}else{
			$data_content 	= $this->route_model->get_jurnal(from_url($title));
			$content 		= $data_content->row();
			
			$user = $this->session->userdata('username');
			if($content->privasi == '2'){
					if(!empty($user )) $link = "<a href='".site_url('home/jurnal_download/'.$content->file_name)."'><span class='journal-download'>Unduh Jurnal</span></a>";
					else $link = "<span class='journal-info'>Untuk mengunduh jurnal, Anda harus login terlebih dahulu...</span>";
			}else{
				$link = "<a href='".site_url('home/jurnal_download/'.$content->file_name)."'><span class='journal-download'>Unduh Jurnal</span></a>";
			}
			
			$vol = !empty($r->volume)? 'Vol: '.$r->volume.' ':null;
			$nomor = !empty($r->nomor)? 'No: '.$r->nomor.' ':null;
			$hal = !empty($r->halaman)? 'Halaman: '.$r->halaman.' ':null;
			
			$issue = !empty($r->issue)? '<h3>Issue</h3><p>'.$r->issue.'</p>':null;
			
			$cont .= "
			<div class='journal-single'>
			<h3>".$content->judul."</h3><p>
			<img src='".base_url('uploads/jurnals/'.$content->cover)."'>
			<p>Penulis : ".$content->penulis."<br/><i>".$vol.$nomor.$hal."</i></p><p>".$content->resensi."</p>".$issue.$link;
			$cont .= '<p><br>'.anchor('jurnal/kategori','&laquo; Kembali ke Daftar Jurnal').'</p>';
		}
		
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	
	function jurnal_download($name){
		$lokasi_file = './uploads/jurnals/'.$name;
		if(file_exists($lokasi_file)){
			$file = file_get_contents($lokasi_file);
			force_download($name,$file);
		}else{
			$data['content'] = not_exists_file($name);
			$this->theme->set_theme(THEME);
			
		
		$this->theme->render('cms/home',$data);
		}
	}
/*
	function kategori($kat){
		$cont = '<h2>Arsip Kategori '.rawurldecode($kat).'</h2>';
		$cnt = 0;
		$id_kat = $this->route_model->get_category('2',$kat)->row();
		$data_content = $this->route_model->get_article(null,null,null);
		foreach($data_content->result() as $r) {				
			$in = unserialize($r->id_cat);
			if (@in_array($id_kat->id_cat,$in)) {
				$content = explode('.',strip_tags($r->content));
				$title = str_replace(' ', '-', $r->title);
				$cont.= "<h1><a href='".site_url('artikel/'.$title)."'>".$r->title."</a></h1>";
				$cont.= "<p>".$content[0]."</p>";
				$cont.= "<div style='clear:both;'></div>";
				$cnt=1;				
			}
		}
        if($cnt==0) $cont .= '<h3>Tidak ditemukan data yang sesuai</h3>';
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}
	*/
	
	function kategori($kat){
		$kat = str_replace('-', ' ', $kat);
		//cek($kat);
		$cont = '
		
					<div class="col-md-8 col-sm-7">
						<section class="news-section" >
							<div class="heading-style-1">
								<h2>Arsip Kategori <span>'.rawurldecode($kat).'</span></h2>
							</div>
							<div class="row">';
		$cnt = 0;
		$id_kat = $this->route_model->get_category($kat)->row();
		$data_content = $this->route_model->get_article(1,null,null);
		foreach($data_content->result() as $r) {
			@$in = unserialize(@$r->id_cat);
			if (@in_array($id_kat->id_cat,$in)) {
				$foto = null;
				$html = str_get_html($r->content);
				foreach(@$html->find('img') as $elgbr) {
					$foto = $elgbr->src;
				}
				$forimg = strip_tags($r->content,"<img>");
				$foto = !empty($foto) ? $foto : '';	
				$content = explode('.',strip_tags($r->content));
				$title = str_replace(' ', '_', $r->title);
								$cont .='
								<div class="col-md-4 col-sm-6 post">
									<div class="post-box" style="margin-bottom: 30px;">
										<div class="frame"> 
											<img src="'.$foto.'" alt="'.$r->title.'" style="height:150px;"  >
											<strong class="date" style="font-size:12px;width: 80px;height:53px">'.konversi_tanggal("j",substr($r->date_start,0,10),"id").
												'<span>'.konversi_tanggal("M",substr($r->date_start,0,10),"id").'</span>
												<span>'.konversi_tanggal("Y",substr($r->date_start,0,10),"id").'</span>
											</strong> 
										</div>
										<div class="text-box" style="height: 100px;">
											<div class="top-section"> 
												<a href="'.site_url('berita/'.$r->permalink).'" target="_blank" style="text-decoration:none;"></a> 
											</div>
											<a  href="'.site_url('berita/'.$r->permalink).'" title="'.$r->title.'" target="_blank" style="text-decoration:none;"><b>'.$r->title.'</b></a>
										</div>
									</div>
								</div>
								';
				$cnt=1;				
			}
		}
		$cont .= '
		<link rel="stylesheet"  href="'.base_url().'themes/cms_2/pagination/pag.css"/>
		<div class="pagination" style="width: 100%"></div>';


        if($cnt==0) $cont .= '<em style="font:italic 400 16px/14px \'Lato\',sans-serif;display:block;color:#555;padding:20px">Tidak ditemukan data yang sesuai</em>';

        $q = $this->general_model->datagrab(array(
        	'tabel'=>'cms_categories',
        	'where'=>array('code'=>1),
        	'order'=>'category'
        ));
        
        
		$cont.='</div></section></div>

		';
		
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);
	}
	function artikels($kat){
		/*cek($kat);
		die();*/
		$kat = str_replace('-', ' ', $kat);
		//cek($kat);
		$cont = '
		
					<div class="col-md-12 col-sm-12">
						<section class="news-section" >
							<div class="heading-style-1">
								<h2 style="border-bottom:2px solid #2e7d32;margin-bottom:10px;">Artikel <span>'.rawurldecode($kat).'</span></h2>
							</div>
							<div class="row">';
		$cnt = 0;
		$id_kat = $this->route_model->get_category($kat)->row();
		$data_content = $this->route_model->get_article(2,null,null);
		foreach($data_content->result() as $r) {
			@$in = unserialize(@$r->id_cat);
			if (@in_array($id_kat->id_cat,$in)) {
				$foto = null;
				$html = str_get_html($r->content);
				foreach(@$html->find('img') as $elgbr) {
					$foto = $elgbr->src;
				}
				$forimg = strip_tags($r->content,"<img>");

				$foto = !empty($foto) ? '<img src="'.$foto.'" alt="'.$r->title.'" style="height:150px;"  >' : '';	
				$content = explode('.',strip_tags($r->content));
				$title = str_replace(' ', '_', $r->title);
								$cont .='
								<div class="col-lg-6 col-sm-6">
									<div class="post-box" style="margin-bottom: 30px;">
										<div class="frame"> 
											'.$foto.'
										</div>
										<div class="text-box" style="">
											<div class="top-section"> 
												<a href="'.site_url('artikel/'.$r->permalink).'" target="_blank" style="text-decoration:none;"></a> 
											</div>
											<a  href="'.site_url('artikel/'.$r->permalink).'" title="'.$r->title.'" target="_blank" style="text-decoration:none;"><b>'.$r->title.'</b></a>
										</div>
									</div>
								</div>
								';
				$cnt=1;				
			}
		}


        if($cnt==0) $cont .= '<em style="font:italic 400 16px/14px \'Lato\',sans-serif;display:block;color:#555;padding:20px">Tidak ditemukan data yang sesuai</em>';

        $q = $this->general_model->datagrab(array(
        	'tabel'=>'cms_categories',
        	'where'=>array('code'=>2),
        	'order'=>'category'
        ));
        
        
		$cont.='</div></section></div>

		';
		
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		$this->theme->render('cms/home',$data);
	}
	/*
	function galeri($title1,$title2){
		$cont ="";
		if(!empty($title1) && empty($title2)){
			if($title1=='kategori'){
				$dt = $this->route_model->get_galbycode('10');
				$cont .= "<h2>Daftar Kategori Galeri</h2><hr/>";
				$cont .= "<div>";
				foreach($dt->result() as $kat){
					$img = unserialize($kat->file_name);
					$cont .= "<div><a href='".site_url('galeri/'.str_replace(' ','-',$kat->title))."'>".$kat->title."</a><br/>";
					$cont .= "<img src='".base_url('uploads/gallery/'.$img[0])."' width='80' align='left' hspace='5' vspace='5'>";
					$cont .= substr($kat->content,0,250);				
					$cont .= "</div><div style='clear:both;'></div>";				
				}
				$cont .= "</div>";
			}else{				
					$dtgal = $this->route_model->get_galeri($title1);
				if($dtgal->num_rows()==0){
					//cari gallery berdasarkan kategori
					$cont = "Judul kategori yang anda pilih tidak ditemukan";
				}else{
					$dtgaleri = $this->route_model->get_galeri($title1)->row();
					$title = $dtgaleri->title;
					$cont = "<h2>".$title."</h2><hr/>";
					$dt = $dtgal->row();
					$fln = unserialize($dt->file_name);
					$ttl = unserialize($dt->img_title);
				
					$cont .= "<table border='0' cellpadding='4' cellspacing='2' width='100%'>";
					$cont .= "<tr>";
					$col=1;
					foreach($fln as $k=>$v){
						$cont .= "<td align='center' class='galeri'>
							<a href='".base_url('uploads/gallery/'.$v)."' title='".@$ttl[$k] ."' rel='galeri1'>
							<img src='".base_url('uploads/gallery/'.$v)."' width='150' height='140' alt='".@$ttl[$k]."'></a><br/>".
							@$ttl[$k] 
							."</td>";
						$col++;
						if($col==4) $cont .= '</tr><tr>';
					}
					$cont .= "</tr></table>";
				}
			}	
		}else if(!empty($title1) && !empty($title2)){
			$cont = "Tampilkan kategori spesifik";
		}else{
			$cont = "<h1>404 Halaman tidak ditemukan</h1>";
		}
				
		$data['content'] = $cont;
		$this->theme->set_theme(THEME);
		
		
		$this->theme->render('cms/home',$data);
	}*/
	function galeri($title1,$id){
		/*cek($title1);
		cek($id);
		die();*/
		$cont ="";
		if(!empty($title1) && empty($title2)){
			
		$dtgal= $this->general_model->datagrab(array('tabel' => 'cms_gallery','where'=>array('id_gallery'=>$id)))->row();		
		$dtupl= $this->general_model->datagrab(array('tabel' => 'cms_uploads','where'=>array('id_gallery'=>$id)));
		//cek($dtupl->num_rows());
					//$dtgal = $this->route_model->get_galeri($title1);
				
					$cont = "<div class='row'>";
					$col=1;
					foreach($dtupl->result() as $row){
						$cont .= "<div class='col-lg-4' class='galeri'>
							<a href='".base_url('uploads/gallery/'.$row->file_name)."' title='".@$row->file_name."' rel='galeri1' class='fancybox'><center>".@$row->nama_file."</center><p>
							<img src='".base_url('uploads/gallery/'.$row->file_name)."' style='width:250px;height:140px;' alt='".@$row->file_name."'></a><br/>".
							@$ttl[$k] 
							."</div>";
						$col++;
					}
					$cont .= "</div>";
		}else if(!empty($title1) && !empty($title2)){
			$cont = "Tampilkan kategori spesifik";
		}else{
			$cont = "<h1>404 Halaman tidak ditemukan</h1>";
		}
				
		$data['content'] = $cont;
		$this->load->view($this->link.'/detail', $data);
	}
}