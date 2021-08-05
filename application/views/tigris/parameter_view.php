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
<link href="<?php echo base_url().'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css'?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js' ?>"></script>

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

    <div class="box-body table-responsive<?php if (!empty($overflow)) echo " over-width" ?>"> 
		<div id="alert"></div>

	<div class="row">
		<?php echo form_open('tigris/Parameter/simpan','role="form" id="form_parameter"'); ?>
			<div class="box">
				<div class="box-body">
					<div class="col-lg-12">		
						<!-- kolom kiri -->
						<div class="col-lg-6">
							<label>Lama Durasi Refresh Halaman</label>
							<p><?php echo 
								form_hidden('keys[]','all_reload').'<div class="input-group">'.
								form_input('vals[]',!empty($vals['all_reload'])?$vals['all_reload']:null,'
									class="form-control inp_reload" placeHolder="Detik ... contoh : 30" required') ?>
									<span class="input-group-addon"><i class="fa fa-clock-o fa-btn"></i> Detik</span></div>
							</p>
							<label>Lama Durasi Agenda Kegiatan (Dalam Detik)</label>
								<p>
								<?php echo 
								form_hidden('keys[]','durasi_agenda_kegiatan').'<div class="input-group">'.
								form_input('vals[]',!empty($vals['durasi_agenda_kegiatan'])?$vals['durasi_agenda_kegiatan']:null,'
									class="form-control inp_menit" placeHolder="Detik ... contoh: 50" onkeyup="return formatNumber(this)" required') ?>
									<span class="input-group-addon"><i class="fa fa-clock-o fa-btn"></i> Detik</span></div>
							</p><!-- 
							<label>Lama Durasi Agenda Bulan Ini (Dalam Detik)</label>
								<p>
								<?php echo 
								form_hidden('keys[]','durasi_agenda_bulan_ini').'<div class="input-group">'.
								form_input('vals[]',!empty($vals['durasi_agenda_bulan_ini'])?$vals['durasi_agenda_bulan_ini']:null,'
									class="form-control inp_menit" placeHolder="Detik ... contoh: 50" onkeyup="return formatNumber(this)" required') ?>
									<span class="input-group-addon"><i class="fa fa-clock-o fa-btn"></i> Detik</span></div>
							</p>
							<label>Lama Durasi Agenda Agenda Bulan Depan (Dalam Detik)</label>
								<p>
								<?php echo 
								form_hidden('keys[]','durasi_agenda_bulan_depan').'<div class="input-group">'.
								form_input('vals[]',!empty($vals['durasi_agenda_bulan_depan'])?$vals['durasi_agenda_bulan_depan']:null,'
									class="form-control inp_menit" placeHolder="Detik ... contoh: 50" onkeyup="return formatNumber(this)" required') ?>
									<span class="input-group-addon"><i class="fa fa-clock-o fa-btn"></i> Detik</span></div>
							</p>
							<label>Lama Durasi Galeri Kiri (Dalam Detik)</label>
								<p>
								<?php echo 
								form_hidden('keys[]','durasi_galeri_kiri').'<div class="input-group">'.
								form_input('vals[]',!empty($vals['durasi_galeri_kiri'])?$vals['durasi_galeri_kiri']:null,'
									class="form-control inp_menit" placeHolder="Detik ... contoh: 50" onkeyup="return formatNumber(this)" required') ?>
									<span class="input-group-addon"><i class="fa fa-clock-o fa-btn"></i> Detik</span></div>
							</p>
							<label>Lama Durasi Galeri Kanan (Dalam Detik)</label>
								<p>
								<?php echo 
								form_hidden('keys[]','durasi_galeri_kanan').'<div class="input-group">'.
								form_input('vals[]',!empty($vals['durasi_galeri_kanan'])?$vals['durasi_galeri_kanan']:null,'
									class="form-control inp_menit" placeHolder="Detik ... contoh: 50" onkeyup="return formatNumber(this)" required') ?>
									<span class="input-group-addon"><i class="fa fa-clock-o fa-btn"></i> Detik</span></div>
							</p> -->
						</div>		
						<!-- kolom kiri -->

						<!-- kolom kanan -->
						<div class="col-lg-6">

							<label>Warna Latar</label>
							<p>
								<?php echo 
								form_hidden('keys[]','sch_warna_latar').'<div class="input-group colorize">'.
								form_input('vals[]',!empty($vals['sch_warna_latar'])?$vals['sch_warna_latar']:null,'
									class="form-control inp_menit" placeHolder="#000000" required') ?>
									<span class="input-group-addon"><i></i></span></div>
							</p>
							
							<label>Warna Header</label>
							<p>
								<?php echo 
								form_hidden('keys[]','sch_warna_header').'<div class="input-group colorize">'.
								form_input('vals[]',!empty($vals['sch_warna_header'])?$vals['sch_warna_header']:null,'
									class="form-control inp_menit" placeHolder="#FFFFFF" required') ?>
									<span class="input-group-addon"><i></i></span></div>
							</p>
							<label>Warna Teks Header</label>
							<p>
								<?php echo 
								form_hidden('keys[]','sch_warna_teks_header').'<div class="input-group colorize">'.
								form_input('vals[]',!empty($vals['sch_warna_teks_header'])?$vals['sch_warna_teks_header']:null,'
									class="form-control inp_menit" placeHolder="#FFFFFF" required') ?>
									<span class="input-group-addon"><i></i></span></div>
							</p>
							
							<label>Warna Judul Kolom</label>
							<p>
								<?php echo 
								form_hidden('keys[]','sch_warna_judul').'<div class="input-group colorize">'.
								form_input('vals[]',!empty($vals['sch_warna_judul'])?$vals['sch_warna_judul']:null,'
									class="form-control inp_menit" placeHolder="#FFFFFF" required') ?>
									<span class="input-group-addon"><i></i></span></div>
							</p>
							
							
							<label>Warna Teks Judul Kolom</label>
							<p>
								<?php echo 
								form_hidden('keys[]','sch_warna_teks_judul').'<div class="input-group colorize">'.
								form_input('vals[]',!empty($vals['sch_warna_teks_judul'])?$vals['sch_warna_teks_judul']:null,'
									class="form-control inp_menit" placeHolder="#FFFFFF" required') ?>
									<span class="input-group-addon"><i></i></span></div>
							</p>
						</div>
						<!-- kolom kanan -->
					</div>

	<div class="col-lg-12 box-footer">
		<span class="btn btn-success btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan Pengaturan</span>
		
	</div>

			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {
		
        $(".colorize").colorpicker();  
		$('.btn-simpan').click(function() {
			$('#form_parameter').submit();
		});
		
		$('#form_parameter').submit(function() {
			
			/*if (!$('.inp_menit').val()) {
				$('#alert').addClass('alert alert-danger').html('Isian tidak boleh kosong!');
				return false;	
			}*/
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
