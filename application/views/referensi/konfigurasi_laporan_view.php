<script type="text/javascript">
	$(document).ready(function(){
		$('.heading').parent().find('td').addClass('headings');
		$('#btn-template').click(function() {
			$('#box-template').show();
		});
	});
</script>
<fieldset><legend><h3>Konfigurasi Laporan Keuangan</h3>
<div class="pull-right">
	<?php echo anchor('referensi/laporan_keuangan','<i class="icon icon-chevron-left"></i> Kembali','class="btn"').' '.
		anchor('#','<i class="fa fa-file"></i> Template Laporan','class="btn" id="btn-template"').' '.
		anchor('#','<i class="fa fa-plus"></i> Tambah Konfigurasi','class="btn btn-success btn-edit" act="'.site_url('referensi/laporan_keuangan/form_konfig/'.in_de(array('id_laporan' => $lap->id_laporan))).'"')?>
</div>
<div class="clear"></div>
</legend>
<?php
$ok = $this->session->flashdata('ok'); if (!empty($ok)) notif($ok); 
$fail = $this->session->flashdata('fail'); if (!empty($fail)) echo '<div class="alert alert-danger">'.$fail.'</div>'; 

?>
<h3><?php echo $lap->nama_laporan ?></h3>
<div class="alert alert-standard" id="box-template"><h3>Template Laporan</h3><?php echo
	form_open_multipart('referensi/laporan_keuangan/upload_template').
		'<input type="file" name="template">'.
	form_close(); ?>
</div>

<?php echo $tabel ?>
<div class="clear"></div>
</fieldset>



