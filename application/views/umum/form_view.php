
  <script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/typeahead/typeahead.min.js' ?>"></script>
<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
<?php echo !empty($load_script)?$load_script:null; 
if (!empty($multi)) echo form_open_multipart($form_link,'id="form_data" role="form"');
else echo form_open($form_link,'id="form_data" role="form"');
	echo '<div id="alert-form"></div>';
 	echo $form_data; 
 	
 	if (!empty($tombol_form)) {
		echo $tombol_form;
	} else { 
	?>	
		<br><button class="btn btn-danger btn-md btn-flat btn-form-cancel" type="button"><i class="fa fa-arrow-left"></i> &nbsp; Batal</button>
		<button href="#" class="btn btn-success btn-md btn-flat btn-save-act pull-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
		<div class="clear"></div>
	<?php } ?>
<?php echo  form_close()?>
<script type="text/javascript">
	<?php echo  @$out_script; ?>
	$(document).ready(function(){
		$('.combo-box').select2(); // Yang merasa punya select dicek lagi, ubah ke DOM combo-box
		$('.datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
		$('input[type="checkbox"].incheck, input[type="radio"].incheck').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass: 'iradio_minimal-blue'
			});
		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html(null);
		   $('#form-box').slideUp();
		   $('#box-main').show();
	   	});
		
		$('#form_data').submit(function() {
			$('.btn-save-act').attr('disabled','disabled').html('<i class="fa fa-spin fa-spinner fa-btn"></i> Proses ...');
		});
		$('#form-title').html('<?php echo $title; ?>');
		<?php echo @$script; ?>
	});
</script>