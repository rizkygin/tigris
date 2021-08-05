<link href="<?php echo base_url().'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js'?>"></script>

<?php 
echo form_open_multipart($form_link,'id="form_data" role="form"');
	
 	echo $form_data; 
 	
 	if (!empty($tombol_form)) {
		echo $tombol_form;
	} else { 
	?>	
		<br><button class="btn btn-danger btn-md btn-form-cancel" type="button">Batal</button>
		<button href="#" class="btn btn-success btn-md pull-right">Simpan</button>
		<div class="clear"></div>
	<?php } ?>
<?php echo  form_close()?>
<script type="text/javascript">
	<?php echo  @$out_script; ?>
	$(document).ready(function(){
		$('select').select2();
		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html('');
		   $('#form-box').slideUp();
		   $('#box-main').show();
	   	});
	   	$(".colorize").colorpicker();
		$('#form-title').html('<?php echo $title; ?>');
		<?php echo  @$script; ?>
	});
</script>