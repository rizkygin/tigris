<!--form-->
<?php echo !empty($load_script)?$load_script:null; ?>
<?php 
if (!empty($multi)) echo form_open_multipart($form_link,'id="form_data" role="form"');
else echo form_open($form_link,'id="form_data" role="form"');
	echo '<div id="alert-form"></div>';
 	echo $form_data; 
 	
 	if (!empty($tombol_form)) {
		echo $tombol_form;
	} else { 
	?>	
		<br><button class="btn btn-danger btn-md btn-flat btn-form-cancel" type="button"><i class="fa fa-arrow-left"></i> &nbsp; Batal</button>
		<button href="#" class="btn btn-success btn-md btn-flat pull-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
		<div class="clear"></div>
	<?php } ?>
<?php echo  form_close()?>

<!--view-->
<?php echo @$css_load; ?>
<?php echo @$include_script;?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.heading').parent().find('td').addClass('headings');
	});
	<?php echo  @$script ?>
</script>
<div class="box" id="box-main">
	<?php if (!empty($tombol) or !empty($extra_tombol)) { ?>
    <div class="box-header with-border">
	    <div class="row">
			<div class="col-md-7" style="margin-bottom: 10px"><?php echo @$tombol?></div>
			<?php if (!empty($extra_tombol)) echo '<div class="col-md-5">'.$extra_tombol.'</div>'; ?>
	    </div>
    </div><!-- /.box-header -->
	<?php } ?>
    <div class="box-body<?php if (!empty($overflow)) echo " over-width" ?>"> 
	
	<?php
		echo @$graph_area;
		echo $tabel;
	?>
	</div>
	<?php if (!empty($links) or !empty($total)) { ?>
	    
	    <div class="box-footer">
	<div class="stat-info">
	<?php if (!empty($links)) { ?><div class="pull-left" style="margin-right: 10px"><?php echo $links?></div><?php } ?>
	<?php if (!empty($total)) { ?><div class="pull-left"><ul class="pagination"><li><a>Total</a></li><li><a><strong><?php echo $total?></strong></a></li></ul></div><?php } ?>
	</div>
	<?php if (isset($box_footer)) echo $box_footer; ?>
	<div class="clear"></div>
	<?php if (!empty($filter)) $this->load->view($filter); ?>
	
</div>
<?php } ?>
</div>

<script type="text/javascript">
	<?php echo  @$out_script; ?>
	$(document).ready(function(){
		$('select').select2();
		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html('');
		   $('#form-box').slideUp();
		   $('#box-main').show();
	   	});
		$('#form-title').html('<?php echo $title; ?>');
		<?php echo @$script; ?>
	});
</script>