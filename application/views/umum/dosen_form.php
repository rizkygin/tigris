<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<?php echo form_open($link_save,'id="form_operator"'); ?>
	<?php 
	if ($indie) {
		echo
		'<p>'. 
		form_label('Nama Dosen').
		form_input('nama',!empty($row)?$row->nama:null,'class="form-control" placeHolder="Nama Dosen..." required').'</p><p>'. 
		form_label('NIP Dosen').
		form_input('nip',!empty($row)?$row->nip:null,'class="form-control" placeHolder="Nomor Induk Dosen ..." required').'</p>'; 
	} else {
	$nm = !empty($row->nama)?'readonly':null;
	echo
		'<p>'. 
		form_label('Nama Mahasiswa').
		form_input('nama',!empty($row)?$row->nama:null,'class="form-control" placeHolder="Nama ..." '.$nm.' required').'</p>'; 
	}
	?>
	
	<?php $cb_bid = !empty($cb_bidang)?$cb_bidang:array('' => ' -- Pilih Unit Organisasi --');
		
	?>
<p><?php echo form_label('Status Dosen').
	form_dropdown('id_ref_tipe_dosen',$cb_tipe_dosen,@$row->id_ref_tipe_dosen,'class="combo-box form-control" id="id_ref_tipe_dosen" style="width: 100%"'); ?></p>
	<p><?php echo 
	form_hidden('id_peg_jabatan',@$row->id_peg_jabatan).	
	form_hidden('id_pegawai',@$row->id_pegawai); ?></p>
	
	

	
	
	<br><button class="btn btn-danger btn-md btn-form-cancel" type="button">Batal</button>
		<button href="#" class="btn btn-success pull-right"><i class="fa fa-save"></i> &nbsp; Simpan</button>
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
		$('#form-title').html('<?php echo $title; ?>');
		
		$('input[type="checkbox"].incheck').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
		
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
		
		
	});
</script>