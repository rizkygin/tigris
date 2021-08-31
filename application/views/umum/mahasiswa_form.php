<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<?php echo form_open($link_save,'id="form_operator"'); ?>
	<?php 
	if ($indie) {
		echo
		'<p>'. 
		form_label('Nama Mahasiswa').
		form_input('nama',!empty($row)?$row->nama:null,'class="form-control" placeHolder="Nama Mahasiswa..." required').'</p><p>'. 
		form_label('NIM Mahasiswa').
		form_input('nip',!empty($row)?$row->nip:null,'class="form-control" placeHolder="11000117410xxx" required').'</p>'; 
	} else {
	$nm = !empty($row->nama)?'readonly':null;
	echo
		'<p>'. 
		form_label('Nama Mahasiswa').
		form_input('nama',!empty($row)?$row->nama:null,'class="form-control" placeHolder="Nama ..." '.$nm.' required').'</p>'; 
	}
	?>
	<p><?php echo 
		form_label('Username').'<br>'.
		form_input('username',!empty($row)?$row->username:null,'placeholder="11000117410xxx" class="form-control" required');?>
	</p>
	<?php $cb_bid = !empty($cb_bidang)?$cb_bidang:array('' => ' -- Pilih Unit Organisasi --');
		
	?>
	<p>
	<?php 
	echo 
	form_label('Program Studi').
	form_dropdown('id_ref_prodi',$cb_program_studi,@$row->id_ref_prodi,'class="combo-box form-control" id="id_ref_program_konsentrasi" style="width: 100%" required');
	?>
	</p>
<p><?php echo 
	form_label('Tahun').
	form_dropdown('id_ref_tahun',$cb_tahun,@$row->id_ref_tahun,'class="combo-box form-control" id="id_ref_tahun" style="width: 100%" required'); ?></p>
	
<p><?php echo form_label('Semester').
	form_dropdown('id_ref_semester',$cb_semester,@$row->id_ref_semester,'class="combo-box form-control" id="id_ref_tahun" style="width: 100%" required'); ?></p>
	<p><?php echo 
	form_hidden('id_peg_jabatan',@$row->id_peg_jabatan).	
	form_hidden('id_pegawai',@$row->id_pegawai).	
	form_label('Program Konsentrasi').
	form_dropdown('id_ref_program_konsentrasi',$cb_program_konsentrasi,@$row->id_konsentrasi,'class="combo-box form-control" id="id_ref_program_konsentrasi" style="width: 100%" required'); ?></p>
	
	

	
	
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