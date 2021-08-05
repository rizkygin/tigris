<?php
$code_ar = array(
'Hak Data' => array(
	'ADM01' => 'Tambah',
	'ADM02' => 'Ubah/Sunting',
	'ADM03' => 'Hapus'
),
'Khusus' => array(
	'RF01' => 'Aplikasi',
	'RF02' => 'Parameter',
	'RF03' => 'Operator',
	'RF04' => 'Kewenangan'),
'Umum' => array(
	'RF05' => 'Pejabat Penetap',
	'RF06' => 'Penandatangan',
	'RF07' => 'Kop Surat',
	'RF08' => 'Jenis Kelamin',
	'RF09' => 'Golongan Darah',
	'RF10' => 'Status Keluarga',
	'RF11' => 'Pekerjaan',
	'RF12' => 'Keluarga',
	'RF13' => 'Status Kawin',
	'RF14' => 'Agama',
	'RF15' => 'Gelar Akademik',
	'RF16' => 'Propinsi',
	'RF17' => 'Kabupaten',
	'RF18' => 'Kecamatan',
	'RF19' => 'Kelurahan',
	'RF20' => 'Suku',
	'RF21' => 'Kementerian',
	'RF22' => 'Unit',
	'RF23' => 'Subunit',
	'RF24' => 'Bidang'
));
	
	
foreach($code_ar as $v => $d) {
	echo '<p><strong>'.$v.'</strong></p>';
	foreach($d as $c => $e) {
		$check = (!empty($codes) and in_array($c,$codes)) ? 'checked' : null;
		echo '<p><input type="checkbox" class="incheck" name="code[]" value="'.$c.'" '.$check.' style="margin-top: -2px"> '.$e.'</p>';
	}
	echo '<br/>';
}
?>
