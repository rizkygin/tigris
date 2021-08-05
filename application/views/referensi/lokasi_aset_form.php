<script>
$(document).ready(function(){
		//$('#form_data').validate();
	$('.cbox').select2();	
  
	$("#id_skpd").change(function(){
		var id_skpd = $('#id_skpd').val();
		$.ajax({
			url:'<?php echo site_url('referensi/lokasi/getSKPD');?>/'+id_skpd,
			success:function(result){
				console.log(result);
				$('#kode_skpd').val(result);
				},
		});
	});
});
</script>
<?php echo  form_open('referensi/lokasi_aset/save_data', 'method="post" id="form_data"'); ?>
	<?php 
		if (isset($query)) $def = $query->row();
		echo form_hidden("id", isset($def->id_lokasi) ? $def->id_lokasi : '');
	?>	

	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4><?php echo $title?> Referensi Lokasi</h4>
	</div>

	<div class="modal-body">	
	
		<p><label class="clear">SKPD</label>  
		<?php echo form_dropdown('id_unit',$combo_skpd,@$def->id_unit,'id="id_skpd" class="required input-xlarge cbox"');?></p>
		
		<p><label class="clear">Kode Lokasi</label>
		<?php echo form_input('kode_skpd',@$def->kode_skpd,'id="kode_skpd" class="uneditable-input input-small" readonly="true"');?>
		<?php echo form_input('kode_unker',@$def->kode_unker,'id="kode_subunit" class="required input-mini" placeholder="Unker"');?>
		<?php echo form_input('kode_ruang',@$def->kode_ruang,'id="kode_ruang" class="required input-mini" placeholder="Ruang"');?> </p>
				
		<p><label class="clear">Unit Kerja</label>  
		<?php echo form_input('nama_unker',@$def->nama_unker,'id="nama_unker" class="required input-xlarge"');?></p>
		
		<p><label class="clear">UPB/Ruang</label>  
		<?php echo form_input('nama_ruang',@$def->nama_ruang,'id="nama_ruang" class="required input-xlarge"');?></p>
		
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-primary" onclick= "$('#form_data').submit()"><i class="icon-white icon-ok"></i> Simpan</button>
		<button type="button" class="btn btn-danger" onclick = "$('#form_modal').modal('hide');"><i class="icon-white icon-remove"></i> Batal</button>
	</div>

<?php  echo form_close(); ?>
