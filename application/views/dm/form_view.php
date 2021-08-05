<?php 
#ver 2.2
if(!empty($css)){?>
    <style type="text/css">
    <?php echo $css;?>
    </style>
<?php }
echo  @$include;
$in_hidden=(!empty($hidden)?$hidden:null);
$att_form='id="form_data" role="form"';
echo (!empty($multi)
    ?form_open_multipart($form_link,$att_form,$in_hidden)
    :form_open($form_link,$att_form,$in_hidden)
    );
    
echo $form_data; 
 	
if (!empty($tombol_form)) {
		echo $tombol_form;
} else { 
	?>	
		<br><a class="btn btn-danger btn-md btn-form-cancel" type="button" <?php echo @$ret?'href="'.$ret.'"':''; ?>>Batal</a>
		<button href="#" class="btn btn-success btn-md btn-save-act pull-right">Simpan </button>
	<?php 
} ?>
<?php 
echo  form_close();?>
<script type="text/javascript">
	<?php echo  @$out_script; ?>
	$(document).ready(function(){
		//$('select2').select2();

		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html('');
           $('#form-box').slideUp('fast', function() {
           /*$('#form-box').slideToggle(400);*/
		        $('#box-main').slideDown();
           /*$('#box-main').show();*/
           });
           $('#datepickers-container').remove();
	   	});
		$('#form-title').html('<?php echo $title; ?>');
        
        $('#form_data').on('submit', function (e) {
            
        //$('#form_data').submit(function() {
            <?php if(!empty($script_submit)){
                echo $script_submit;
            }else{
                ?>
            $('.btn-save-act').attr('disabled','disabled').html('<i class="fa fa-spin fa-spinner fa-btn"></i> Proses ...');
            <?php
            }?>
        });
		<?php echo  @$script; ?>
	});
</script>