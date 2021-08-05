<?php 

	$RF05 = in_array('RF05',$role);
	$RF06 = in_array('RF06',$role);
	$RF07 = in_array('RF07',$role);
	$RF08 = in_array('RF08',$role);
	$RF09 = in_array('RF09',$role);
	$RF10 = in_array('RF10',$role);
	$RF11 = in_array('RF11',$role);
	$RF12 = in_array('RF12',$role);
	$RF13 = in_array('RF13',$role);
	$RF14 = in_array('RF14',$role);
	$RF15 = in_array('RF15',$role);
	$RF16 = in_array('RF16',$role);
	$RF17 = in_array('RF17',$role);
	$RF18 = in_array('RF18',$role);
	$RF19 = in_array('RF18',$role);
	$RF20 = in_array('RF18',$role);
	$RF21 = in_array('RF18',$role);
	$RF22 = in_array('RF18',$role);
	$RF23 = in_array('RF18',$role);
	$RF24 = in_array('RF18',$role);
	if (
		($RF05) or ($RF06) or ($RF07) or ($RF08) or ($RF09) or 
		($RF10) or ($RF11) or ($RF12) or ($RF13) or ($RF14) or
		($RF15) or ($RF16) or ($RF17) or ($RF18) or ($RF19) or
		($RF20) or ($RF21) or ($RF22) or ($RF23) or ($RF24)) { 
	
	?>
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Umum <b class="caret"></b></a>
		<ul class="dropdown-menu"><?php
			if ($RF05) echo '<li>'.anchor('referensi/penetap','Pejabat Penetap').'</li>';
			if ($RF06) echo '<li>'.anchor('referensi/penandatangan','Penandatangan Surat').'</li>';
			//if ($RF07) echo '<li>'.anchor('referensi/kop_surat','Kop Surat').'</li>';
			if ($RF08) echo '<li class="divider"></li>
			<li>'.anchor('referensi/jenis_kelamin','Jenis Kelamin').'</li>';
			if ($RF09) echo '<li>'.anchor('referensi/golongan_darah','Golongan Darah').'</li>';
			if ($RF10) echo '<li>'.anchor('referensi/keluarga_status','Status Keluarga').'</li>';
			if ($RF10) echo '<li>'.anchor('referensi/umum/ke/status_anak','Status Anak').'</li>';
			if ($RF11) echo '<li>'.anchor('referensi/pekerjaan','Pekerjaan').'</li>';
			if ($RF12) echo '<li>'.anchor('referensi/keluarga','Keluarga').'</li>';
			if ($RF13) echo '<li>'.anchor('referensi/kawin_status','Status Kawin').'</li>';
			if ($RF14) echo '<li>'.anchor('referensi/agama','Agama').'</li>';
			if ($RF15) echo '<li>'.anchor('referensi/gelar','Gelar Akademik').'</li>';
			if ($RF16) echo '<li class="divider"></li>
			<li>'.anchor('referensi/propinsi','Propinsi').'</li>';
			if ($RF17) echo '<li>'.anchor('referensi/kabupaten','Kabupaten').'</li>';
			if ($RF18) echo '<li>'.anchor('referensi/kecamatan','Kecamatan').'</li>';
			if ($RF19) echo '<li>'.anchor('referensi/kelurahan','Kelurahan').'</li>';
			if ($RF20) echo '<li>'.anchor('referensi/suku','Suku').'</li>';
			if ($RF21) echo '<li class="divider"></li>
			<li>'.anchor('referensi/kementerian','Kementerian').'</li>';
			if ($RF22) echo '<li>'.anchor('referensi/unit','Unit Kerja').'</li>';
			if ($RF23) echo '<li>'.anchor('referensi/subunit','Subunit Kerja').'</li>';
			if ($RF24) echo '<li>'.anchor('referensi/bidang','Bidang').'</li>';
			echo '<li class="divider"></li><li>'.anchor('referensi/umum/ke/ktj','KTJ').'</li>';
			echo '<li>'.anchor('referensi/umum/ke/satuan','Satuan').'</li>';

			?>
		</ul>
	</li>
	<?php } ?>