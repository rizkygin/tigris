<script type="text/javascript">
	$(document).ready(function() { 
		$(".combobox").select2();
		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html('');
		   $('#form-box').slideUp();
		   $('#box-main').show();
	   	});
	});
</script>
	
<?php echo form_open('referensi/barang/save_barang_root','id="form_data" method="post"')?>
	<?php 
		if (isset($default)) $def = $default->row();
		echo form_hidden("id_brg", isset($def->id_brg) ? $def->id_brg : '');
		echo form_hidden("level", isset($def->level) ? $def->level : '1');
		echo form_hidden("is_child", isset($def->is_child) ? $def->is_child : '1');
		echo form_hidden("jenis", isset($def->jenis) ? $def->jenis : '1');
	?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4><?php echo $title;?> Referensi Barang</h4>
	</div>

	<div class="modal-body">		
		<p><label class="clear">Kode Barang</label>
			<?php echo form_input('kode_barang',@$def->kode_barang,'id="kode_barang" class="form-control" required');?></p>
		<p><label class="clear">Nama Barang</label>
			<?php echo form_input('nama_barang',@$def->nama_barang,'id="nama_barang" class="form-control" required');?></p>
	</div>

	<div class="modal-footer">
		<button class="btn btn-danger btn-md btn-flat btn-form-cancel pull-left" type="button">Batal</button>
		<button href="#" class="btn btn-success btn-flat btn-md pull-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
	</div>
<?php echo form_close()?>