
<div class="<?php echo  (!empty($def) and $def->id_aplikasi == $apps->id_aplikasi) ? null : "hide" ?> roled" id="aplikasi<?php echo  $apps->id_aplikasi ?>">
<p><label>Referensi</label><div class="pull-left" style="padding: 3px 0">
<?php

foreach($aplikasi->result() as $app) {
	$path = './application/views/'.$app->folder.'/referensi_kewenangan_view.php';
	$appdata['codes'] = $codes;
	if (file_exists($path))	$this->load->view($app->folder.'/referensi_kewenangan_view',$appdata);
	
}
	
?>

</div>
<div class="clear"></div>
</p>
</div>