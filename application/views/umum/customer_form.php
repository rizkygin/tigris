<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<style>
.pasfotos-border { width: 200px; height: 300px; margin: 0 auto; overflow: hidden; padding: 30px 0; }
.pasfotos img { max-width: 150px; padding: 0; }
.input-btn { margin: 10px -10px 0 -10px; padding: 10px 10px 0 10px; border-top: 1px solid #eee; }
</style>
<?php if (!empty($row)) { ?>
	<div class="row">
		<div class="col-lg-6">
	<?php
	} 
	echo form_open($link_save,'id="form_operator"');
	if (!empty($offs)) echo form_hidden('offs',$offs); 
	if (!empty($indie) and $indie == TRUE) {
		echo
		'<p>'. 
		form_label('Nama Operator').
		form_input('nama',!empty($row)?$row->nama:null,'class="form-control" placeHolder="Nama ..." required').'</p><p>'. 
		form_label('NIP/ID Operator').
		form_input('nip',!empty($row)?$row->nip:null,'class="form-control" placeHolder="Nomor Pegawai/ID ..." required').'</p>'; 
	} else {
	$nm = !empty($row->nama)?'readonly':null;
	echo
		'<p>'. 
		form_label('Nama Operator').
		form_input('nama',!empty($row)?$row->nama:null,'class="form-control" placeHolder="Nama ..." '.$nm.' required').'</p>'; 
	}
	?>
	<p><?php echo 
		form_label('Username').'<br>'.
		form_input('username',!empty($row)?$row->username:null,'placeholder="Username ... " class="form-control" required');?>
	</p>
	<?php if (!empty($indie) and !empty($unit)) {
			if ($indie and $unit) { 
		
				$cb_bid = !empty($cb_bidang)?$cb_bidang:array('' => ' -- Pilih Unit Organisasi --');
		
	?>
	<p><?php echo 
	form_hidden('id_peg_jabatan',@$row->id_peg_jabatan).	
	form_label('Unit Kerja').
	form_dropdown('id_unit',$cb_unit,@$row->id_unit,'class="combo-box form-control" id="id_unit" style="width: 100%"'); ?></p>
<p><?php echo form_label('Unit Organisasi').
	form_dropdown('id_bidang',$cb_bid,@$row->id_bidang,'class="combo-box form-control" id="id_bidang" style="width: 100%"'); ?></p>
	
	<?php } } ?>
	<b>Alamat</b></span><div class="clear" style="height: 10px">&nbsp;</div>
	
	<b>No. Telpon</b></span><div class="clear" style="height: 10px">&nbsp;</div>
	
	<?php if (!empty($row)) { 
	echo form_close();
	?>
	</div>
	<div class="col-lg-6">
		<?php if (!empty($row->id_pegawai)) { 
				
		echo 
		form_open_multipart($link_foto.'/save_foto','id="form_foto"').
		form_hidden('id_pegawai',$row->id_pegawai);
		if (!empty($offs)) echo form_hidden('offs',$offs);
		$pasfoto = !empty($row->photo) ? base_url().'uploads/kepegawaian/pasfoto/'.$row->photo : base_url().'assets/images/avatar.gif'; ?>
		<div class="pasfotos-border"><div class="pasfotos"><img src="<?php echo $pasfoto ?>"/></div></div>
		<?php if (!empty($row->photo)) {
			echo form_hidden('foto_prev',$row->photo); $lbl = 'Ganti Foto'; } else { 
			$lbl = 'Unggah Foto'; } ?>
		
		<div class="frm_upload"><label><?php echo $lbl ?></label>
			<input type="file" name="foto" id="frm_file"></div>
		<?php echo form_close();
		} ?>
	</div>
	</div>
	<?php } else {
	echo form_close();
	}
	?>
	<div class="input-btn">
	<button class="btn btn-danger btn-md btn-form-cancel" type="button">Batal</button>
		<button href="#" class="btn btn-success btn-save-all pull-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
		<div class="clear"></div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('select').select2();
		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html('');
		   $('#form-box').slideUp();
		   $('#box-main').show();
		
	   	});
		$('#form-title').html('<?php echo $title; ?>');
		
		$('input[type="checkbox"].incheck').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
		$('#frm_file').change(function() {
			$('#form_foto').submit();
		});
		$('.btn-save-all').click(function() {
			$('#form_operator').submit();
		});
		<?php 
			if (!empty($indie) and !empty($unit)) { 
				if ($indie and $unit) {
			
		?>
		$('#id_unit').change(function(){
	   		if ($(this).val()) {
			$.ajax({
				type 	: 'GET', 
				url  	: '<?php echo $link_unit ?>/'+$(this).val(),
				success	: function(data){
					$('#id_bidang').select2('val',null);
					$('#id_bidang').html(data);
				}
			});
			} else {
				$('#id_bidang').select2('val',null);
				$('#id_bidang').html('<option value=""> -- Pilih Unit Organisasi -- </option>');
			}
		});
		
		
		<?php } } ?>
		
		
	});
</script>