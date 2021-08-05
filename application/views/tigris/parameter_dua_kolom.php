<?php 
echo @$css_load;
echo @$include_script;

$box_cls = !empty($tabs)?'nav-tabs-custom':'box';
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.heading').parent().find('td').addClass('headings');
	});
	<?php echo  @$script ?>
</script>
<div class="<?php echo $box_cls ?>" id="box-main">
	<?php if (!empty($tabs)) { ?>
	<ul class="nav nav-tabs">
		<?php 
			foreach($tabs as $t) { 
				echo '<li'.(!empty($t['on'])?' class="active"':null).'>
					<a'.(!empty($t['url'])?' href="'.$t['url'].'"':null).'>'.$t['text'].'</a></li>';
			}
		?>
	</ul>
	<?php } ?>
	
	<?php if (!empty($tombol) or !empty($extra_tombol)) { ?>
    
    <div class="box-header with-border">
	    <div class="row">
			<div class="col-md-7" style="margin-bottom: 10px"><?php echo @$tombol?></div>
			<?php if (!empty($extra_tombol)) echo '<div class="col-md-5">'.$extra_tombol.'</div>'; ?>
	    </div>
    </div><!-- /.box-header -->
	<?php } ?>

    
	<div id="alert"></div>

<div class="row">
	<div class="col-lg-12">
<?php echo form_open('tigris/Parameter/simpan','role="form" id="form_parameter"'); ?>
<div class="box">
	<div class="box-body">
		<div class="col-lg-12">
			<div class="col-lg-6">
				<label>Tinggi Kolom Agenda Kegiatan</label>
				<p>
					<?php echo 
					form_hidden('keys[]','height_agenda_1').'<div class="input-group">'.
					form_input('vals[]',!empty($vals['height_agenda_1'])?$vals['height_agenda_1']:null,'
						class="form-control inp_menit" placeHolder="tinggi kolom agenda ... contoh : 500" onkeyup="return formatNumber(this)" required') ?>
						<span class="input-group-addon"><i class="fa fa-fw fa-arrows-v fa-btn"></i> px</span></div>
				</p>
			</div>
			<div class="col-lg-6">		
				<label>Tinggi Kolom Agenda Bulan Ini</label>
				<p><?php echo 
					form_hidden('keys[]','height_agenda_bulan_ini_1').'<div class="input-group">'.
					form_input('vals[]',!empty($vals['height_agenda_bulan_ini_1'])?$vals['height_agenda_bulan_ini_1']:null,'
						class="form-control inp_reload" placeHolder="tinggi kolom agenda bulan ini ... contoh : 230" required') ?>
						<span class="input-group-addon"><i class="fa fa-fw fa-arrows-v fa-btn"></i> px</span></div>
				</p>
			</div>
		</div>
		<div class="col-lg-12">
			<br>
			<br>
			<div class="col-lg-6 pull-right">		
				<label>Tinggi Kolom Agenda Bulan Depan</label>
				<p><?php echo 
					form_hidden('keys[]','height_agenda_bulan_depan_1').'<div class="input-group">'.
					form_input('vals[]',!empty($vals['height_agenda_bulan_depan_1'])?$vals['height_agenda_bulan_depan_1']:null,'
						class="form-control inp_reload" placeHolder="tinggi kolom agenda bulan depan... contoh : 230" required') ?>
						<span class="input-group-addon"><i class="fa fa-fw fa-arrows-v fa-btn"></i> px</span></div>
				</p>
			</div>
		</div>
		<div class="col-lg-12">
		<br>
		<br>
			<div class="col-lg-5">		
				<label>Tinggi Kolom Pengumuman</label>
				<p><?php echo 
					form_hidden('keys[]','height_pengumuman_1').'<div class="input-group">'.
					form_input('vals[]',!empty($vals['height_pengumuman_1'])?$vals['height_pengumuman_1']:null,'
						class="form-control inp_reload" placeHolder="tinggi kolom pengumuman...contoh : 230" required') ?>
						<span class="input-group-addon"><i class="fa fa-fw fa-arrows-v fa-btn"></i> px</span></div>
				</p>
			</div>
			<div class="col-lg-3">		
				<label>Tinggi Kolom Kalender Kegiatan</label>
				<p><?php echo 
					form_hidden('keys[]','height_kalender_1').'<div class="input-group">'.
					form_input('vals[]',!empty($vals['height_kalender_1'])?$vals['height_kalender_1']:null,'
						class="form-control inp_reload" placeHolder="tinggi kolom kalender ... contoh : 230" required') ?>
						<span class="input-group-addon"><i class="fa fa-fw fa-arrows-v fa-btn"></i> px</span></div>
				</p>
			</div>
			<div class="col-lg-4">		
				<label>Tinggi Kolom Galeri</label>
				<p><?php echo 
					form_hidden('keys[]','height_galeri_1').'<div class="input-group">'.
					form_input('vals[]',!empty($vals['height_galeri_1'])?$vals['height_galeri_1']:null,'
						class="form-control inp_reload" placeHolder="tinggi kolom galeri ... contoh : 230" required') ?>
						<span class="input-group-addon"><i class="fa fa-fw fa-arrows-v fa-btn"></i> px</span></div>
				</p>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<span class="btn btn-success btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan Pengaturan</span>
		
	</div>
<?php echo form_close(); ?>
	</div>
</div>
<!-- <iframe class="col-lg-12" style="height:500px;margin:0px auto;border:none" src="http://localhost/e-scheduling/schedul/ids_schedul"></iframe> -->
<script type="text/javascript">
	
	$(document).ready(function() {
		
		$('.btn-simpan').click(function() {
			$('#form_parameter').submit();
		});
		
		$('#form_parameter').submit(function() {
			
			if (!$('.inp_menit').val()) {
				$('#alert').addClass('alert alert-danger').html('Isian tidak boleh kosong!');
				return false;	
			}
			if (!$('.inp_reload').val()) {
					
				$('#alert').addClass('alert alert-danger').html('Durasi Refresh tidak boleh kosong !');
				return false;	
			}
			
		});
		
	});
	
</script>
	</div>
	<?php if (!empty($links) or !empty($total) or !empty($box_footer)) { ?>
	    
	    <div class="box-footer">
			<div class="stat-info">
	<?php if (!empty($links)) { ?><div class="pull-left" style="margin-right: 10px"><?php echo $links?></div><?php } ?>
	<?php if (!empty($total)) { ?><div class="pull-left"><ul class="pagination"><li><a>Total</a></li><li><a><strong><?php echo $total?></strong></a></li></ul></div><?php } ?>
	</div>
	<?php if (!empty($box_footer)) echo $box_footer; ?>
	<div class="clear"></div>
	<?php if (!empty($filter)) $this->load->view($filter); ?>
	
</div>
<?php } ?>
</div>
<?php if (!empty($load_view)) $this->load->view($load_view); ?>


