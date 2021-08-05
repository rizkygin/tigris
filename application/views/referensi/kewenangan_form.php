<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>

<?php echo  
form_open($link_save,'id="form_role"').
form_hidden('id_role',@$def->id_role);
?>

<p><?php echo form_label('Nama Kewenangan').form_input('nama_role',@$def->nama_role,'class="form-control" required'); ?></p>
<?php 
if (!empty($def))  {
	$sel = 'disabled="disabled"';
	echo form_hidden('id_aplikasi',$def->id_aplikasi);
} 
?>
<p>
	
<?php if (!empty($combo_aplikasi)) { ?>
	<label>Aplikasi</label><br><?php echo form_dropdown('id_aplikasi',$combo_aplikasi,@$def->id_aplikasi,'class="combo-box form-control" style="width: 100%" id="pilih" '.@$sel); ?></p>
<?php  } else { echo form_hidden('id_aplikasi',$aplikasi->row()->id_aplikasi); }

$codes = !empty($def->role) ? unserialize($def->role) : null; 

foreach($aplikasi->result() as $app) { 

if (!empty($app_data[$app->id_aplikasi])) {

if ($app->id_aplikasi == 1) {
?>

<div class="nav-tabs-custom <?php echo ((!empty($def) and $def->id_aplikasi == $app->id_aplikasi) or $aplikasi->num_rows() == 1) ? null : "hide" ?> roled" id="aplikasi<?php echo  $app->id_aplikasi ?>">
    <ul class="nav nav-tabs">
		<?php 
		$n = 1;
		foreach($app_data[1] as $k => $v) { ?>	
            <li <?php if ($n == 1) echo 'class="active"' ?>><a data-toggle="tab" href="#tab_<?php echo $n ?>" aria-expanded="false"><?php echo $k ?></a></li>    
		<?php 
		$n += 1;
		} ?>
	</ul>
    <div class="tab-content">
		<?php
		$m = 1;
		foreach($app_data[1] as $k => $v) { ?>	
        <div id="tab_<?php echo $m ?>" class="tab-pane <?php if ($m == 1) echo 'active' ?>">
        <?php echo $v; $m+=1;?>           
        </div><!-- /.tab-pane -->
		<?php } ?>
	</div><!-- /.tab-content -->
</div>

<?php } else { ?>
<div class="<?php echo ((!empty($def) and $def->id_aplikasi == $app->id_aplikasi) or $aplikasi->num_rows() == 1) ? null : "hide" ?> roled roled-box" id="aplikasi<?php echo  $app->id_aplikasi ?>">

<?php echo $app_data[$app->id_aplikasi]; ?>
</div>

<?php }}} ?>
<button class="btn btn-danger btn-md btn-form-cancel" type="button">Batal</button>
<button href="#" class="btn btn-success btn-md pull-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
<div class="clear"></div>
<?php echo  form_close()?>
	

<script type="text/javascript">
	$(document).ready(function(){
		$('select').select2();
		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html('');
		   $('#form-box').slideUp();
		   $('#box-main').show();
	   	});
	   	
	   	$('#pilih').change(function() {
			$('.roled').hide();
			$('#aplikasi'+$(this).val()).removeClass('hide').show();
			$('.incheck').each(function() {
				$(this).removeAttr('checked');
			});
		
		});
		
		$('input[type="checkbox"].incheck').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
			
		$('#form-title').html('<?php echo $title; ?>');
	});
</script>
