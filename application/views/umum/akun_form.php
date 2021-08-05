<style>
.pasfotos-border { width: 200px; height: 300px; margin: 0 auto; overflow: hidden; padding: 30px 0; }
.pasfotos img { max-width: 150px; padding: 0; }
</style>

<script type="text/JavaScript"> 
	$(document).ready(function(){
		$('#btn-simpan').click(function() {
			$('#form_akun').submit();
		});
		$("#form_akun").submit(function() {
			$('.loading').show();
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: "json",
				success: function(msg) {
					if (parseInt(msg.sign) == 404) {
						$("#box_message").html(msg.teks).addClass('alert alert-error').show();
					} else {
						$("#box_form, .btn-batal, .btn-simpan").hide();
						$(".btn-ok").show()
						$("#box_message").html(msg.teks).removeClass('alert alert-error').show();
					}
					$('.loading').hide();
				}
			});
			return false;
			
		});
		
		$('#btn-tutup-profil').click(function() {
			$('#modal-profil').modal('hide');
		});
		$('#frm_file').change(function() {
			$('#form_foto').submit();
		});
	});
</script>
<div class="modal-dialog">
    <div class="modal-content">


<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4><i class="fa fa-lock fa-btn"></i> Akun &amp; Password</h4>
		<div class="clear"></div>
	</div>
	<div class="modal-body no-padding"><?php if (!empty($row)) { ?>
		<div class="alert alert-confirm" style="display: none"> <i class="fa fa-refresh fa-spin"></i> Proses ...</div>	
		<div id="box_message" style="display: none"></div>
		<div class="nav-tabs-custom" id="box_form">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#password" data-toggle="tab">Password</a></li>
				<li><a href="#akun" data-toggle="tab">Akun</a></li>
				<li><a href="#foto" data-toggle="tab">Foto Profil</a></li>
			</ul>
			<div class="tab-content">
				
				<div class="tab-pane active" id="password">
					<?php echo form_open("home/update_akun",'id="form_akun"'); ?>
					<?php 
					echo form_hidden('id_pegawai',$row->id_pegawai);
					echo form_hidden('username_asli',$row->username); ?>
					<p><?php echo form_label('Password Lama').form_password('pwd_lama','','class="form-control"'); ?></p>
					<p><?php echo form_label('Password Baru').form_password('pwd_baru','','class="form-control"'); ?></p>
					<p><?php echo form_label('Ulang Pass Baru').form_password('pwd_baru2','','class="form-control"'); ?></p>
					<p><button href="#" class="btn btn-success btn-simpan"><i class="fa fa-lock"></i> &nbsp; Ubah Password</button></p>
					<?php echo form_close(); ?>
				</div>
				
				
				<div class="tab-pane" id="akun">
				<?php echo form_open("home/update_akun",'id="form_akun"'); ?>
				<?php
					echo form_hidden('id_pegawai',$row->id_pegawai);
					echo form_hidden('username_asli',$row->username);	 ?>
					<p><?php echo form_label('Akun').form_input('username',$row->username,'class="form-control"'); ?></p>
					<p><?php echo form_label('Password Lama').form_password('pwd_lama','','class="form-control"'); ?></p>
					<p><button href="#" class="btn btn-success btn-simpan"><i class="fa fa-user"></i> &nbsp; Ubah Akun</button></p>
				<?php echo form_close() ?>
				</div>
				
				<div class="tab-pane" id="foto">
				<?php echo 
				form_open_multipart($link_foto.'/save_foto','id="form_foto"').
					form_hidden('id_pegawai',$row->id_pegawai).
					form_hidden('link_base',$link_base);
					if (!empty($offs)) echo form_hidden('offs',$offs);
					$pasfoto = !empty($row->photo) ? base_url().'uploads/kepegawaian/pasfoto/'.$row->photo : base_url().'assets/images/avatar.gif'; ?>
					<div class="pasfotos-border"><div class="pasfotos"><img src="<?php echo $pasfoto ?>"/></div></div>
					<?php if (!empty($row->photo)) {
						echo form_hidden('foto_prev',$row->photo); $lbl = 'Ganti Foto'; } else { 
						$lbl = 'Unggah Foto'; } ?>
					<p>Unggah foto melalui tombol <i>browse</i><br>di bawah ini.</p>
					<div class="frm_upload"><label><?php echo $lbl ?></label>
						<input type="file" name="foto" id="frm_file"></div>
					<?php echo form_close(); ?>
				</div>
				
			</div>
			</div>
			<?php } else { ?>
			<div class="alert">Anda tidak memiliki kewenangan mengubah akun ...</div>
			<?php } ?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-default text-left" id="btn-tutup-profil"><i class="fa fa-remove"></i> Tutup</a>
	</div>
	
    </div>
</div>