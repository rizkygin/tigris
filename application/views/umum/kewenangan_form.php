<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<style>
	.pilih-semua { padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px dashed #ccc; }
	.akses-box { min-height: 500px; }
</style>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<?php echo  
form_open($link_save,'id="form_role"').
form_hidden('dir',@$param['dir']).
form_hidden('unit_active',$unit).
form_hidden('id_role',@$def->id_role); ?>
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
 ?>
 <div class="row">
	<div class="col-lg-12 akses-box">
 <?php
foreach($aplikasi->result() as $app) { 

if (!empty($app_data[$app->id_aplikasi])) {

if ($app->folder == "referensi") { ?>

<div class="nav-tabs-custom <?php echo ((!empty($def) and $def->id_aplikasi == $app->id_aplikasi) or $aplikasi->num_rows() == 1) ? null : "hide" ?> roled" id="aplikasi<?php echo  $app->id_aplikasi ?>">

	<ul class="nav nav-tabs">
		<?php 
		$n = 1;
		foreach($app_data[$app->id_aplikasi] as $k => $v) { 
			if ($v != NULL) {
		?>	
		
            <li <?php if ($n == 1) echo 'class="active"' ?>><a data-toggle="tab" href="#tab_<?php echo $n ?>" aria-expanded="false"><?php echo $k ?></a></li>    
		<?php 
			}
		$n += 1;
		} ?>
	</ul>
    <div class="tab-content">
		<?php
		$m = 1;
		foreach($app_data[$app->id_aplikasi] as $k => $v) { ?>	
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
</div>
<button class="btn btn-danger btn-md btn-form-cancel" type="button">Batal</button>
<button href="#" class="btn btn-success btn-md pull-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
<div class="clear"></div>

<div class="modal fade" id="modal-role-confirm" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog">
    <div class="modal-content">
	    <div class="modal-header">
        <button class="close" aria-label="Close" data-dismiss="modal" type="button">
		      <span aria-hidden="true">×</span>
		    </button>
		    <h4 class="modal-title form-title"><i class="fa fa-times-circle fa-btn"></i> Konfirmasi Keluar</h4>
      </div>
        <div class="modal-body">
			<p>Apakah ingin keluar dari form Kewenangan ini?</p>
		</div>
        <div class="modal-footer">
		<button class="btn btn-default btn-tutup pull-left" data-dismiss="modal" type="button">Batal</button>
		<span class="btn btn-danger pull-right btn-cancel"><i class="fa fa-times-circle fa-btn"></i> Keluar Kewenangan</span>
		<div class="clearfix"></div>
		</div>
    </div>
  </div>
</div>

<?php echo  form_close()?>
	

<script type="text/javascript">
	$(document).ready(function(){
		$('selectx').select2();
		$('.btn-form-cancel').click(function() {
			$('#modal-role-confirm').modal('show');
	   	});
		
		$('.btn-cancel').click(function() {
			$('#modal-role-confirm').modal('hide');
			$('.modal-backdrop').removeClass('in');
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
		
		$('.all-check-unit').on('ifChecked', function() { 
			$('.check-unit').iCheck('check');
		}).on('ifUnchecked', function() { 
			$('.check-unit').iCheck('uncheck');
		});
		
		setTimeout(function(){
			$('.unit-box').height($('.akses-box').height()-100)
		},800);
		
		$('input[type="checkbox"].incheck').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
			
		$('#form-title').html('<?php echo $title; ?>');
	});
</script>
