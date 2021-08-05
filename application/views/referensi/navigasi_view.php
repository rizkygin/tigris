<?php $app = $this->session->userdata('app_active'); ?>
	
	<ul class="nav">
	
		<li><?php echo anchor('referensi','Beranda') ?></li>
		<?php if (in_array(1,$app)) { 
		$RF01 = in_array('RF01',$role);
		$RF02 = in_array('RF02',$role);
		$RF03 = in_array('RF03',$role);
		$RF04 = in_array('RF04',$role);
		if (($RF01) or ($RF02) or ($RF03)  or ($RF04)) { 
		?>
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Khusus <b class="caret"></b></a>
			<ul class="dropdown-menu"><?php
				if ($RF01) echo '<li>'.anchor('referensi/aplikasi','Aplikasi').'</li>';
				if ($RF02) echo '<li>'.anchor('referensi/pengaturan','Parameter').'</li>';
				if ($RF03) echo '<li>'.anchor('referensi/operator','Operator').'</li>';
				if ($RF04) echo '<li>'.anchor('referensi/kewenangan','Kewenangan').'</li>'; ?>
			</ul>
		</a>
		<?php }} ?>
		
		<?php
		
		$re = $this->general_model->datagrab(array('tabel' => 'ref_aplikasi','where' => array('id_aplikasi IN ('.implode(',',$app).')' => null)));
		
		foreach($re->result() as $app) {
			$path = './application/views/'.$app->folder.'/referensi_navigasi_view.php';
			$appdata['role'] = $role;
			if (file_exists($path))	$this->load->view($app->folder.'/referensi_navigasi_view',$appdata);
		}
		
		
		?>

	</ul>
	