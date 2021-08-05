<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 250000) 
             window.location.reload(true);
         else 
             setTimeout(refresh, 10000);
     }

     setTimeout(refresh, 10000);
</script>
<div style="background: #fff">
	<div class="col-lg-9">
		<div class="box box-success box-solid">
			<div class="box-header with-border">
				<h3 class="box-title pull-left"><i class="fa fa-cube"></i> &nbsp; Aplikasi</h3>
				<h3 class="box-title pull-right"><span class="badge badge-green badge-header"><?php echo $jml_program?> APLIKASI </span></h3>
			</div>
			<div class="box-body no-padding"><?php echo $tabel; ?></div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><b>Tiket Pertanyaan</b></span>
              <span class="info-box-number" style="font-size: 40px; margin-top: 10px;"><?php echo $jml_tanya?></span>
                         </div><!-- /.info-box-content -->
          </div>
          
          <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-tags"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><b>Tiket Perbaikan</b></span>
              <span class="info-box-number" style="font-size: 40px; margin-top: 10px;"><?php echo $jml_perbaikan?></span>
                         </div><!-- /.info-box-content -->
          </div>
          
          <div class="box box-danger box-solid">
			<div class="box-header with-border">
				<h3 class="box-title pull-left"><i class="fa fa-cube"></i> &nbsp; Lain-Lain</h3>
				<h3 class="box-title pull-right"><span class="badge badge-lain badge-header"><?php echo $jml_lain?> Tiket </span></h3>
			</div>
			<div class="box-body no-padding">
				
				<table class="table table-striped">
						<tr>
							<th style="text-align:center;">Kegiatan</th>
							<th style="text-align:center;">Pekerjaan</th>
						</tr>
						<?php foreach($tiket_lain->result_array() as $tiket) { ?>
						<tr>
							<td style="line-height: 13px; font-size: 90%"><?php echo $tiket['judul'];?></td>
							<td style="line-height: 13px; font-size: 90%"><?php echo $tiket['pekerjaan'];?></td>

						</tr>
						<?php } ?>
					</table>

				
			</div>
		</div>

<?php /*
		<div class="small-box bg-red">
			<div class="small-box bg-red">
				<div class="inner">
					<h4>Tiket Lain-lain</h4>
										<a href="<?php echo site_url('manajemen/pengelola/list_tiket_lain')?>" class="btn btn-danger btn-flat">Lihat Semua <i class="fa fa-angle-double-right"></i></a>
				</div>
				<div class="icon">
					<i class="fa"><?php echo $jml_lain?></i>
				</div>
			</div>
		</div>
			<div class="small-box bg-aqua">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h4>Tiket Pertanyaan</h4>
					<table class="table table-bordered">
						<tr>
							<th style="text-align:center;">Pertanyaan</th>
							<th style="text-align:center;">Status Pertanyaan</th>
						</tr>
						<?php foreach($tiket_tanya->result_array() as $tiket) { ?>
						<tr>
							<td style="text-align:center;"><?php echo $tiket['judul'];?></td>
							<td style="text-align:center;"><?php echo $tiket['status'];?></td>
						</tr>
						<?php } ?>
					</table>
					<a href="<?php echo site_url('manajemen/pengelola/list_tiket_tanya')?>" class="btn btn-info btn-flat">Lihat Semua <i class="fa fa-angle-double-right"></i></a>
				</div>
				<div class="icon">
					<i class="fa"><?php echo ?></i>
				</div>
			</div>
		</div>
	</div>
	
	*/ ?>

	</div>
	<div class="clear"></div>
</div>