<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<?php echo form_open($link_save,'id="form_operator"'); ?>
	<?php 
	if ($indie) {
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
	<?php $cb_bid = !empty($cb_bidang)?$cb_bidang:array('' => ' -- Pilih Unit Organisasi --');
		
	?>
	<p><?php echo 
	form_hidden('id_peg_jabatan',@$row->id_peg_jabatan).	
	form_label('Prodi').
	form_dropdown('id_unit',$cb_unit,@$row->id_unit,'class="combo-box form-control" id="id_unit" style="width: 100%"'); ?></p>
<p><?php echo form_label('Bidang').
	form_dropdown('id_bidang',$cb_bid,@$row->id_bidang,'class="combo-box form-control" id="id_bidang" style="width: 100%"'); ?></p>
	
	

	<b>Kewenangan</b></span><div class="clear" style="height: 10px">&nbsp;</div>
	<?php echo form_hidden('id_pegawai',!empty($row)?$row->id_pegawai:null); 

		foreach($role->result() as $rol) {
		if(!empty($pegawai_role)) in_array($rol->id_role,$pegawai_role) ? $chk = "checked" : $chk = null;
		else $chk = null; ?>
		
		<p><input type="checkbox" name="role[]" class="incheck" style="margin-top: -2px" value="<?php echo  $rol->id_role?>" <?php echo  $chk?>> &nbsp; <?php echo  $rol->nama_role.' ('.$rol->nama_aplikasi.')' ?></p>
		<?php 				
		}
		?>
	
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