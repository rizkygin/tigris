<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>

<div class="box">
	<div class="box-body">
		<?php echo form_open_multipart('inti/impor/impor_init','id="form_excel" role="form"') ?>
		<div class="row"><div class="col-lg-4">
       		<p><?php echo form_label('Status Data') ?><br><label><input type="checkbox" name="on_reset" value="1" class="incheck"/>
	       		<span style="font-weight: lighter"> &nbsp; Kosongkan Data / Inisiasi</span></label></p>
       		<p><?php echo form_label('Mulai Baris Impor').form_input('baris',2,'class="form-control"  style="max-width: 100px" onkeyup="return formatNumber(this)"') ?></p>
       		<p><?php echo form_label('Pilih File Excel').form_upload('excel_impor','class="form-control"') ?></p> 
       		</div>
       		<div class="col-lg-8"><?php echo form_label('Nomor Kolom (dari kiri)') ?></div>
       		<div class="col-lg-4">
				<p><div class="input-group"><div class="input-group-addon">NIP</div><?php echo form_input('k_nip',2,'class="form-control" placeholder="2"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">NIP Lama</div><?php echo form_input('k_nip_lama',3,'class="form-control" placeholder="3"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Nama</div><?php echo form_input('k_nama',4,'class="form-control" placeholder="4"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Gelar Depan</div><?php echo form_input('k_gelar_depan',5,'class="form-control" placeholder="5"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Gelar Belakang</div><?php echo form_input('k_gelar_belakang',6,'class="form-control" placeholder="6"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Tempat Lahir</div><?php echo form_input('k_tempat_lahir',7,'class="form-control" placeholder="7"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Tanggal Lahir</div><?php echo form_input('k_tanggal_lahir',8,'class="form-control" placeholder="8"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">TMT CPNS</div><?php echo form_input('k_tmt_cpns',10,'class="form-control" placeholder="10"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">TMT PNS</div><?php echo form_input('k_tmt_pns',11,'class="form-control" placeholder="11"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Jenis Kelamin</div><?php echo form_input('k_jenis_kelamin',12,'class="form-control" placeholder="12"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Agama</div><?php echo form_input('k_agama',null,'class="form-control" placeholder="..."') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Alamat</div><?php echo form_input('k_alamat',null,'class="form-control" placeholder="..."') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">NIK/KTP</div><?php echo form_input('k_nik',null,'class="form-control" placeholder="..."') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">NPWP</div><?php echo form_input('k_npwp',null,'class="form-control" placeholder="..."') ?></div></p>
				</div>
			<div class="col-lg-4">
				<p><div class="input-group"><div class="input-group-addon">Golru/Pangkat</div><?php echo form_input('k_golru',13,'class="form-control" placeholder="13"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">TMT Golru/Pangkat</div><?php echo form_input('k_tmt_golru',14,'class="form-control" placeholder="14"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">MKG Tahun</div><?php echo form_input('k_mkg_tahun',15,'class="form-control" placeholder="15"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">MKG Bulan</div><?php echo form_input('k_mkg_bulan',16,'class="form-control" placeholder="16"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Eselon</div><?php echo form_input('k_eselon',17,'class="form-control" placeholder="17"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">TMT Jabatan Struktural</div><?php echo form_input('k_tmt_s',18,'class="form-control" placeholder="18"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Jabatan Struktural</div><?php echo form_input('k_s',19,'class="form-control" placeholder="19"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">TMT Jabatan Fungsional Tertentu</div><?php echo form_input('k_tmt_jft',20,'class="form-control" placeholder="20"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Jabatan Fungsional Tertentu</div><?php echo form_input('k_jft',21,'class="form-control" placeholder="21"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Jabatan Fungsional Umum</div><?php echo form_input('k_jfu',22,'class="form-control" placeholder="22"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Unit Organisasi</div><?php echo form_input('k_bidang',23,'class="form-control" placeholder="23"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Unit Kerja</div><?php echo form_input('k_unit',23,'class="form-control" placeholder="23"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Unit Kerja Asal</div><?php echo form_input('k_unit_asal',24,'class="form-control" placeholder="24"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Jenjang</div><?php echo form_input('k_jenjang',null,'class="form-control" placeholder="..."') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Jurusan</div><?php echo form_input('k_jurusan',25,'class="form-control" placeholder="25"') ?></div></p>
				<p><div class="input-group"><div class="input-group-addon">Tahun Lulus</div><?php echo form_input('k_lulus',26,'class="form-control" placeholder="26"') ?></div></p>
			</div>
		</div>
		
	</div>
	<div class="box-footer">
		<div class="progress-view on-hide">
		<div class="progress active">
	        <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning progress-bar-striped progress-bar-total">
	          <span class="sr-only progress-bar-sr">0% Komplit</span>
	        </div>
	     </div>
	     <p>Proses : <span class="txt_data"></span> dari <span class="txt_total"></span> ( <span class="txt_persen"></span> % Komplit )</p>
		</div>
	</div>
	<div class="box-footer">
		<?php echo 
			form_button('btn_process','<i class="fa fa-btn fa-file-excel-o"></i> Impor Excel','type="submit" class="btn btn-proses btn-success pull-left"').
			anchor('inti/impor/impor_next','<i class="fa fa-database fa-btn"></i> Tabel Temporer','class="btn btn-warning pull-right"') ?>
			
		<div class="clear"></div>
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {
		$('.btn-proses').click(function() {
			$('.btn-proses').html('<i class="fa fa-spin fa-spinner fa-btn"></i> Proses Impor ...').attr('disabled','disabled');
			$('#form_excel').submit();
			setInterval('menunggu()',2000);
		});			
		$('input[type="checkbox"].incheck').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
	});
	
	function menunggu() {
		$.ajax({
		  url: '<?php echo site_url('inti/impor/total_temp') ?>',
		  cache: false,
		  dataType: 'json',
		  success: function(msg) {
			$('.progress-bar-sr').html(msg.persen+'% Komplit');
			$('.progress-bar-total').attr('aria-valuenow',msg.persen).attr('style','width: '+msg.persen+'%');
			$('.txt_data').html(msg.jml);
			$('.txt_total').html(msg.total);
			$('.txt_persen').html(msg.persen);
			$('.progress-view').show();
		  },error:function(error){
			show_error(error);
		}
		});
	}
</script>