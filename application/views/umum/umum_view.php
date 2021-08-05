<script type="text/javascript">
$(document).ready(function() {

	$('.combo-box').select2();
	$('#tanggal').datepicker({
		format  : 'dd/mm/yyyy',
		todayBtn: 'linked',
		language: 'id'
	}).on('changeDate', function(){ $('#tanggal').datepicker('hide') });
		
});
</script>

<div class="box" id="box-main">
	 <div class="box-header with-border">
	    Pengaturan Umum
    </div><!-- /.box-header -->
    <div class="box-body">

<ul class="nav nav-tabs" id="myTab">

		<?php 
		$no = 1;
		foreach($tab as $t) { 
		
		$act = ($no > 1) ? null : ' class="active"';
		
		echo '<li'.$act.'><a href="#tab'.$no.'" data-toggle="tab">'.$t['nama'].'</a></li>';
		
		
		$no += 1;
		} ?>
</ul>


<?php echo  form_open('inti/pengaturan/save_setting'); ?>

<div class="tab-content">
<?php

$no = 1;
foreach($tab as $t) { 
$path = FCPATH . APPPATH . 'views/'.$t['folder'].'/parameter_view.php';
if (file_exists($path)) {
$act = ($no > 1) ? null : ' active';
echo '<div class="tab-pane'.$act.'" id="tab'.$no.'">';
$this->load->view($t['folder'].'/parameter_view',$t);
echo '</div>';

}
$no += 1;
}	
echo "</div>";

	echo form_label('&nbsp;').form_submit('submit','Simpan Perubahan','class="btn btn-success"');
	echo form_close();
	?>
</div></div>