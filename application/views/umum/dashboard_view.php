<div class="row">
	<?php if ($role==4) { ?>
		<!--div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php echo form_open('helpdesk/home/change_role', array('name' => 'role_form ', 'id' => 'role_form')); ?>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				<?php echo form_dropdown('role', $combo_kewenangan, null, 'class="form-control" required'); ?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				<button class="btn btn-info btn-flat" type="submit">Ganti</button>
			</div>
			<?php echo form_close(); ?>
		</div-->
	<?php } ?>
	<!--div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
		<nav style="margin-bottom: 0px;" class="navbar navbar-static-top" role="navigation">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Pesan Program Baru">
							<i class="fa fa-headphones"></i>
							<span class="label label-success"><?php echo $pesanproBaru->num_rows();?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">Kamu mempunyai <?php echo $pesanproBaru->num_rows();?> pesan ticketing program belum dibaca</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: scroll-x; width: 100%;">
									<ul style="overflow: scroll-x; width: 100%;"class="menu">	
										<?php foreach ($pesanproBaru->result() as $row) {
											 if(date('Y-m-d', strtotime($row->waktu))==date('Y-m-d')){
				                                $hari = 'Today';
				                              }else{
				                                $hari = date('d F', strtotime($row->waktu));
				                              }
				                              $foto = ($row->photo==null) ? base_url('uploads/helpdesk/avatar.gif') : base_url('uploads/kepegawaian/pasfoto/'.$row->photo);
										?>
										<li>
											<a href="<?php echo site_url('helpdesk/manajemen_pengelola/answere/'.$row->id_tiket.'/list_tiket_program')?>">
												<div class="pull-left">
													<img src="<?php echo $foto;?>" class="img-circle" alt="">
												</div>
												<h4>
													<?php echo $row->nama;?>
													<small>
														<i class="fa fa-clock-o"></i>
														<?php echo $hari; echo date(' - H:i:s', strtotime($row->waktu));?>
													</small>
												</h4>
												<p><?php echo shrot_word($row->deskripsi, 6);?></p>
											</a>
										</li>
										<?php } ?>
									</ul>
									<div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px; background: rgb(0, 0, 0);"></div>
									<div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div-->
	<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
		<nav style="margin-bottom: 0px;" class="navbar navbar-static-top" role="navigation">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Pesan Perbaikan Baru">
							<i class="fa fa-wrench"></i>
							<span class="label bg-maroon"><?php echo $pesanperBaru->num_rows();?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">Kamu mempunyai <?php echo $pesanperBaru->num_rows();?> pesan baru</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: scroll-x; width: 100%;">
									<ul style="overflow: scroll-x; width: 100%;"class="menu">	
										<?php foreach ($pesanperBaru->result() as $row) {
											 if(date('Y-m-d', strtotime($row->waktu))==date('Y-m-d')){
				                                $hari = 'Today';
				                              }else{
				                                $hari = date('d F', strtotime($row->waktu));
				                              }
				                              $foto = ($row->photo==null) ? base_url('uploads/helpdesk/avatar.gif') : base_url('uploads/kepegawaian/pasfoto/'.$row->photo);
										?>
										<li>
											<a href="<?php echo site_url('helpdesk/manajemen_pengelola/answere/'.$row->id_tiket.'/list_tiket_perbaikan')?>">
												<div class="pull-left">
													<img src="<?php echo $foto;?>" class="img-circle" alt="">
												</div>
												<h4>
													<?php echo $row->nama;?>
													<small>
														<i class="fa fa-clock-o"></i>
														<?php echo $hari; echo date(' - H:i:s', strtotime($row->waktu));?>
													</small>
												</h4>
												<p><?php echo shrot_word($row->deskripsi, 6);?></p>
											</a>
										</li>
										<?php } ?>
									</ul>
									<div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px; background: rgb(0, 0, 0);"></div>
									<div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
		<nav style="margin-bottom: 0px;" class="navbar navbar-static-top" role="navigation">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Pesan Lain-lain Baru">
							<img width="13" style="" src="<?php echo site_url('assets/images/etc.png')?>">
							<span class="label label-danger"><?php echo $pesan_lain_lain->num_rows();?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">Kamu mempunyai <?php echo $pesan_lain_lain->num_rows();?> pesan baru</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: scroll-x; width: 100%;">
									<ul style="overflow: scroll-x; width: 100%;"class="menu">	
										<?php foreach ($pesan_lain_lain->result() as $row) {
											 if(date('Y-m-d', strtotime($row->waktu))==date('Y-m-d')){
				                                $hari = 'Today';
				                              }else{
				                                $hari = date('d F', strtotime($row->waktu));
				                              }
				                              $foto = ($row->photo==null) ? base_url('uploads/helpdesk/avatar.gif') : base_url('uploads/kepegawaian/pasfoto/'.$row->photo);
										?>
										<li>
											<a href="<?php echo site_url('helpdesk/manajemen_pengelola/answere/'.$row->id_tiket.'/list_tiket_lain')?>">
												<div class="pull-left">
													<img src="<?php echo $foto;?>" class="img-circle" alt="">
												</div>
												<h4>
													<?php echo $row->nama;?>
													<small>
														<i class="fa fa-clock-o"></i>
														<?php echo $hari; echo date(' - H:i:s', strtotime($row->waktu));?>
													</small>
												</h4>
												<p><?php echo shrot_word($row->deskripsi, 6);?></p>
											</a>
										</li>
										<?php } ?>
									</ul>
									<div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px; background: rgb(0, 0, 0);"></div>
									<div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
		<nav style="margin-bottom: 0px;" class="navbar navbar-static-top" role="navigation">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Pesan Tanya Baru">
							<i class="fa fa-question-circle"></i>
							<span class="label bg-yellow"><?php echo $pesan_tanya->num_rows();?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">Kamu mempunyai <?php echo $pesan_tanya->num_rows();?> pesan baru</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: scroll-x; width: 100%;">
									<ul style="overflow: scroll-x; width: 100%;"class="menu">	
										<?php foreach ($pesan_tanya->result() as $row) {
											 if(date('Y-m-d', strtotime($row->waktu))==date('Y-m-d')){
				                                $hari = 'Today';
				                              }else{
				                                $hari = date('d F', strtotime($row->waktu));
				                              }
				                              $foto = ($row->photo==null) ? base_url('uploads/helpdesk/avatar.gif') : base_url('uploads/kepegawaian/pasfoto/'.$row->photo);
										?>
										<li>
											<a href="<?php echo site_url('helpdesk/manajemen_pengelola/answere/'.$row->id_tiket.'/list_tiket_tanya')?>">
												<div class="pull-left">
													<img src="<?php echo $foto;?>" class="img-circle" alt="">
												</div>
												<h4>
													<?php echo $row->nama;?>
													<small>
														<i class="fa fa-clock-o"></i>
														<?php echo $hari; echo date(' - H:i:s', strtotime($row->waktu));?>
													</small>
												</h4>
												<p><?php echo shrot_word($row->deskripsi, 6);?></p>
											</a>
										</li>
										<?php } ?>
									</ul>
									<div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px; background: rgb(0, 0, 0);"></div>
									<div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<?php if($role==1 or $role==2) { 
		if($pg==1) { ?>
	<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
		<nav style="margin-bottom: 0px;" class="navbar navbar-static-top" role="navigation">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Pengumuman">
							<i class="fa fa-bullhorn"></i>
							<span class="label bg-aqua"><?php if($role==1) { echo $jmlbalpeng->num_rows(); }elseif($role==2) { echo $jmlbalpeng->num_rows(); }?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">Kamu mempunyai <?php if($role==1) { echo $jmlbalpeng->num_rows(); }elseif($role==2) { echo $jmlbalpeng->num_rows(); }?> pesan baru</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: scroll-x; width: 100%;">
									<ul style="overflow: scroll-x; width: 100%;"class="menu">	
										<?php
										if($role==1) {
											foreach ($jmlbalpeng->result() as $row) {
												 if(date('Y-m-d', strtotime($row->waktu))==date('Y-m-d')){
					                                $hari = 'Today';
					                              }else{
					                                $hari = date('d F', strtotime($row->waktu));
					                              }
					                              $foto = ($row->photo==null) ? base_url('uploads/helpdesk/avatar.gif') : base_url('uploads/kepegawaian/pasfoto/'.$row->photo);
											?>
											<li>
												<a href="<?php echo site_url('helpdesk/pengumuman/percakapan/'.$row->id_tiket.'/'.$row->id_detail_tiket)?>">
													<div class="pull-left">
														<img src="<?php echo $foto;?>" class="img-circle" alt="">
													</div>
													<h4>
														<?php echo $row->nama;?>
														<small>
															<i class="fa fa-clock-o"></i>
															<?php echo $hari; echo date(' - H:i:s', strtotime($row->waktu));?>
														</small>
													</h4>
													<p><?php echo shrot_word($row->deskripsi, 6);?></p>
												</a>
											</li>
											<?php
											}
										}elseif($role==2) {
											foreach ($jmlbalpeng->result() as $row) {
												if(date('Y-m-d', strtotime($row->waktu))==date('Y-m-d')){
					                                $hari = 'Today';
					                              }else{
					                                $hari = date('d F', strtotime($row->waktu));
					                              }
					                              $foto = ($row->photo==null) ? base_url('uploads/helpdesk/avatar.gif') : base_url('uploads/kepegawaian/pasfoto/'.$row->photo);
												?>
												<li>
													<a href="<?php echo site_url('helpdesk/pengumuman/percakapan/'.$row->id_tiket.'/'.$row->id_detail_tiket)?>">
														<div class="pull-left">
															<img src="<?php echo $foto;?>" class="img-circle" alt="">
														</div>
														<h4>
															<?php echo $row->nama;?>
															<small>
																<i class="fa fa-clock-o"></i>
																<?php echo $hari; echo date(' - H:i:s', strtotime($row->waktu));?>
															</small>
														</h4>
														<p><?php echo shrot_word($row->deskripsi, 6);?></p>
													</a>
												</li>
											<?php
											}
										}?>
									</ul>
									<div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px; background: rgb(0, 0, 0);"></div>
									<div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<?php } }?>
</div>
<?php
if ($role == 3) { ?>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="small-box bg-green">
			<div class="inner">
				<h4><?php echo $new_help;?></h4>
				<p>Helpdesk Baru</p>
			</div>
			<div class="icon">
				<i class="fa fa-headphones"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/transaksi_helpdesk');?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<!--div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="small-box bg-green">
			<div class="inner">
				<h4><?php echo $proBaru;?></h4>
				<p>Ticketing Program</p>
			</div>
			<div class="icon">
				<i class="fa fa-headphones"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_program');?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="small-box bg-maroon">
			<div class="inner">
				<h4><?php echo $perBaru;?></h4>
				<p>Ticketing Perbaikan Program</p>
			</div>
			<div class="icon">
				<i class="fa fa-wrench"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_perbaikan')?>">Lihat Seluruhnya <i class="fa fa-angle-double-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="small-box bg-red">
			<div class="inner">
				<h4><?php echo $lain_lain;?></h4>
				<p>Ticketing Lain - lain</p>
			</div>
			<div class="icon">
				<img width="85" style="opacity: 0.6;" src="<?php echo site_url('assets/images/etc.png')?>">
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_lain')?>">Lihat Seluruhnya <i class="fa fa-angle-double-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="small-box bg-yellow">
			<div class="inner">
				<h4><?php echo $pertanyaan;?></h4>
				<p>Ticketing Pertanyaan</p>
			</div>
			<div class="icon">
				<i class="fa fa-question-circle"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_tanya')?>">Lihat Seluruhnya <i class="fa fa-angle-double-right"></i></a>
		</div>
	</div-->
</div>
<?php }
if ($role == 1) { ?>
<div class="row">
	<div class="col-lg-4 col-xs-12">
		<div class="small-box bg-maroon">
			<div class="inner">
				<h3><?php echo $jmlPengBaru; ?></h3>
				<p>Pengumuman Baru</p>
			</div>
			<div class="icon">
				<i class="fa fa-bullhorn"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/pengumuman');?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div>
		<div class="small-box bg-orange">
			<div class="inner">
				<h3><?php echo $jmlBaru; ?></h3>
				<p>Helpdesk Baru</p>
			</div>
			<div class="icon">
				<img src="<?php echo site_url('assets/images/new.png')?>" width="120" style="opacity: 0.6;">
			</div>
			<!--a class="small-box-footer" href="<?php //echo site_url('helpdesk/transaksi_helpdesk');?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a-->
		</div>
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3><?php echo $jmlproses; ?></h3>
				<p>Helpdesk Proses</p>
			</div>
			<div class="icon">
				<i class="fa fa-gears"></i>
			</div>
		</div>
		<div class="small-box bg-green">
			<div class="inner">
				<h3><?php echo $jmlselesai; ?></h3>
				<p>Helpdesk Selesai</p>
			</div>
			<div class="icon">
				<i class="fa fa-flag"></i>
			</div>
		</div>
		<div class="small-box bg-red">
			<div class="inner">
				<h3><?php echo $jmlditolak; ?></h3>
				<p>Helpdesk Di Tolak</p>
			</div>
			<div class="icon">
				<i class="fa fa-minus-circle"></i>
			</div>
		</div>
		<div class="small-box bg-maroon">
			<div class="inner">
				<h3><?php echo $jmldihapus; ?></h3>
				<p>Helpdesk Di Hapus</p>
			</div>
			<div class="icon">
				<i class="fa fa-trash"></i>
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-xs-12">
		<div class="box box-primary direct-chat direct-chat-primary">
	        <div class="box-header with-border">
	        	<i class="fa fa-question-circle"></i><h3 class="box-title">Pertanyaan Yang Sering Muncul (FAQ)</h3>
	        </div>
        	<div class="box-body">
          		<div class="direct-chat-messages">
          			<?php if ($faq->num_rows()==NULL) { ?>
          				<div class="alert alert-info"></div>
          			<?php } else { ?>
          			<ol>
	          			<?php
	          			foreach ($faq->result_array() as $row) { ?>
	          				<a href="<?php echo site_url('helpdesk/faq/det/'.in_de(array('id_faq'=>$row['id_faq'])) ); ?>">
	          					<li><?php echo $row['pertanyaan_faq']?></li>
	          				</a>
	          			<?php } ?>
          			</ol>
          			<?php }?>
          		</div>
        	</div>
      	</div>

		<!--div class="box box-primary direct-chat direct-chat-primary">
	        <div class="box-header with-border">
	        	<i class="fa fa-bookmark"></i><h3 class="box-title">Daftar Helpdesk Anda</h3>
	        </div><!-- /.box-header -->
        	<!--div class="box-body">
          	<!-- Conversations are loaded here -->
          		<!--div class="direct-chat-messages">
          			<?php if ($helpdesk->num_rows()==NULL) { ?>
          				<div class="alert alert-info">
          					<h4>Belum ada helpdesk yang anda buat</h4>
          				</div>
          			<?php } else {?>
          			<table class="table">
          				<tr>
          					<td>No</td>
          					<td>Judul</td>
          					<td>Tanggal</td>
          					<td></td>
          				</tr>
          			<?php $no=1;
          			foreach ($helpdesk->result_array() as $row) { ?>
          				<tr>
          					<td><?php echo $no++?></td>
          					<td><?php echo $row['judul']?></td>
          					<td><?php echo tanggal_jam($row['jam_tanggal'])?></td>
          					<td><a href="<?php echo site_url('helpdesk/transaksi_helpdesk/detail/'.$row['id_tiket'])?>">Lihat</a></td>
          				</tr>
          			<?php } ?>
          			</table>
          			<?php }?>
          		</div><!--/.direct-chat-messages-->
        	<!--/div><!-- /.box-body -->
      	<!--/div><!--/.direct-chat -->

      	<script type="text/javascript">
			function ganti(pilih) { 
				if ('3'==pilih.value) {
					console.log(pilih.value);
					$('#ts').show();
				}
				else {
					$('#ts').hide();
				}
			}
			$(document).ready(function(){
				$('select').select2();
				$('.btn-form-cancel').click(function() {
				   $('#form-content,#form-title').html('');
				   $('#form-box').slideUp();
				   $('#box-main').show();
			   	});
				$('#form-title').html('<?php echo $title; ?>');
				$('#ts').hide();
			});
		</script>

		<div class="row">
			<div class="col-lg-12 col-xs-12"></div>
			<div class="col-lg-12 col-xs-12">
				<div class="box box-info">
					<div style="cursor: move;" class="box-header ui-sortable-handle">
						<i class="fa fa-bookmark-o"></i>
						<h3 class="box-title">Kirim Helpdesk</h3>
					</div>
					<div class="box-body">
						<form action="<?php echo site_url('helpdesk/transaksi_helpdesk/save_data')?>" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
							<div class="form-group">
								<label><b style="color:red;">*</b>Aplikasi</label>
								<?php
								$id_unit =$this->session->userdata('id_unit');
								$option = $this->general_model->combo_box(array(
												'tabel'=>array('ht_ref_aplikasi a'=>'',
																'ref_unit b'=>'a.id_unit=b.id_unit'),
												'key'=>'id_ref_aplikasi',
												'val'=>array('nama_aplikasi'),
												/*'where'=>array('a.status'=>3),*/
												'order'=>'a.id_ref_aplikasi'
											));
								echo form_dropdown('id_ref_aplikasi', $option, @$dttiket->id_ref_aplikasi,'class="form-control combo-box" required id="aplikasi"');
								?>
							</div>
							<div class="form-group">
								<label><b style="color:red;">*</b>Judul Pertanyaan</label>
								<input class="form-control" name="judul" placeholder="Judul Helpdesk" type="text" required>
		                    </div>
							<div class="form-group">
								<label><b style="color:red;">*</b>Operator Bidang</label>
								<?php
									$combo_tc = $this->general_model->combo_box(array(
										'tabel'=>array('peg_pegawai a'=>'',
														'pegawai_role b'=>'a.id_pegawai=b.id_pegawai',
														'ref_role_nav c'=>'b.id_role=c.id_role',
														'nav d'=>'c.id_nav=d.id_nav',
														'peg_jabatan e'=>'a.id_pegawai=e.id_pegawai',
														'ref_unit f'=>'e.id_unit=f.id_unit',
														'ref_bidang g'=>'e.id_bidang=g.id_bidang'
														),
										'key'=>'id_pegawai', 'val'=>array('nama'),
										'where'=> array('d.kode'=>'HT03'),
										'order'=>'a.nama'
										));
								$option2 = array(''=>'-- Pilih --');
								echo form_dropdown('id_pengguna_teknis',$combo_tc,NULL,'class="form-control combo-box" id="bidang"');
								?>
		                    </div>
							<!--div class="form-group" id="ts">
								<label>Technical Support (Boleh Kosong)</label>
								<?php
								$id_unit = $this->session->userdata('id_unit');
								$option3 = $this->general_model->combo_box(array(
										'tabel'=>array('peg_pegawai a'=>'',
														'pegawai_role b'=>'a.id_pegawai=b.id_pegawai',
														'ref_role_nav c'=>'b.id_role=c.id_role',
														'nav d'=>'c.id_nav=d.id_nav',
														'peg_jabatan e'=>'a.id_pegawai=e.id_pegawai',
														'ref_unit f'=>'e.id_unit=f.id_unit',
														'ref_bidang g'=>'e.id_bidang=g.id_bidang'
														),
										'key'=>'id_pegawai', 'val'=>array('nama','nama_bidang'),
										'where'=>array_merge(array('d.kode'=>'HT03')),
										'order'=>'a.nama'
											));
								echo form_dropdown('id_pengguna_teknis',$option3,NULL,'class="form-control combo-box" style="width: 100%;"');
								?>
		                    </div-->
							<div class="form-group">
								<label><b style="color:red;">*</b>Pertanyaan</label>
								<textarea name="pertanyaan" placeholder="Pertanyaan" class="textarea" style="width: 100%; height: 125px; padding: 10px;" reqired></textarea>
		                   	</div>
							<div class="form-group">
								<label>Upload Berkas</label>
								<input name="berkas" type="file">
		                    </div>
		                    <div class="form-group">
		                    	<textarea name="ket_berkas" placeholder="Keterangan Berkas" class="textarea" style="width: 100%; height: 125px; padding: 10px;"></textarea>
		                    </div>
		                   	<div class="form-group">
								<button class="btn btn-success btn-flat" type="submit">Send <i class="fa fa-arrow-circle-right"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php }
if ($role == 2 or $role == 4) { ?>
<div class="row">
	<div class="col-lg-3 col-xs-12">
		<div class="small-box bg-green">
			<div class="inner">
				<h3><?php echo $jmlbaru;?></h3>
				<p>Helpdesk Baru</p>
			</div>
			<div class="icon">
				<i class="fa fa-headphones"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/transaksi_helpdesk')?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	
		<!--div class="small-box bg-aqua">
			<div class="inner">
				<h3><?php echo $jmlprogram;?></h3>
				<p>Ticketing Program</p>
			</div>
			<div class="icon">
				<i class="fa fa-building"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_program')?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div-->
	
		<!--div class="small-box bg-maroon">
			<div class="inner">
				<h3><?php echo $jmlperbaikan;?></h3>
				<p>Ticketing Perbaikan</p>
			</div>
			<div class="icon">
				<i class="fa fa-wrench"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_perbaikan')?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	
		<div class="small-box bg-red">
			<div class="inner">
				<h3><?php echo $jmllain;?></h3>
				<p>Ticketing Lain-lain</p>
			</div>
			<div class="icon">
				<img src="<?php echo site_url('assets/images/etc.png')?>" width="85" style="opacity: 0.6;">
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_lain')?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	
		<div class="small-box bg-yellow">
			<div class="inner">
				<h3><?php echo $jmltanya;?></h3>
				<p>Ticketing Pertanyaan</p>
			</div>
			<div class="icon">
				<i class="fa fa-question-circle"></i>
			</div>
			<a class="small-box-footer" href="<?php echo site_url('helpdesk/manajemen_pengelola/list_tiket_tanya')?>">Lihat Seluruhnya <i class="fa fa-arrow-circle-right"></i></a>
		</div-->
	</div>
	<div class="col-lg-9 col-xs-12">
		<div class="box" id="box-main">
			<div class="box-header"><h4>Daftar Helpdesk</h4></div>
			<div class="box-body">
				<table class="table no-fluid" style="border: 1px solid #000;">
					<tr style="background: #bfbfbf;">
						<th style="border: 1px solid #000;">No</th>
						<th style="border: 1px solid #000;">Judul</th>
						<!--th style="border: 1px solid #000;">Tipe / Jenis</th-->
						<th style="border: 1px solid #000;">Status</th>
						<th style="border: 1px solid #000;">Tanggal</th>
						<th style="border: 1px solid #000;" colspan="2">Pembuat</th>
					</tr>
					<?php
					$no=1+$offset;
					foreach ($dttiket->result() as $row) {
						if ($row->id_ref_tipe_tiket==1) {
							$tipe='list_tiket_program';
						}elseif($row->id_ref_tipe_tiket==2 and $row->id_ref_aplikasi!=0) {
							$tipe='list_tiket_perbaikan';
						}elseif ($row->id_ref_tipe_tiket==3) {
							$tipe='list_tiket_lain';
						}elseif ($row->id_ref_tipe_tiket==2 and $row->id_ref_aplikasi==0) {
							$tipe='list_tiket_tanya';
						}
					?>
					<tr>
						<td style="border: 1px solid #000;"><?php echo $no;?></td>
						<td style="border: 1px solid #000;"><?php echo $row->judul;?></td>
						<!--td style="border: 1px solid #000;"><?php echo ($row->id_ref_aplikasi==0 and $row->id_ref_tipe_tiket==2) ? 'Pertanyaan' : $row->tipe_tiket;?></td-->
						<td style="border: 1px solid #000;"><label class="label label-<?php echo $row->profil;?>"><?php echo $row->status;?></label></td>
						<td style="border: 1px solid #000;" align="center"><?php echo tanggal_jam($row->jam_tanggal);?></td>
						<td style="border: 1px solid #000;" align="center"><?php echo $row->nama; echo "<br>"; echo $row->unit;?></td>
						<td style="border: 1px solid #000;">
							<a href="<?php echo site_url('helpdesk/manajemen_pengelola/detail/'.$row->id_tiket.'/'.$tipe)?>" class="btn btn-xs btn-info btn-flat" title="Detail">&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;</a>
						</td>
					</tr>
					<?php
					$no+=1;
					}?>
				</table>
			</div>
			<div class="box-footer">
				<?php echo $links;?>
			</div>
		</div>
	</div>
</div>
<?php }
  ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2();
		$('#aplikasi').change(function(){
			var id_aplikasi = $('#aplikasi').val();
			$.ajax({
				type 	: 'POST',
				cache: false,
				url  	: '<?php echo site_url('helpdesk/transaksi_helpdesk/getbidang/');?>',
				data 	: 'id_aplikasi='+id_aplikasi,
				success	: function(msg){
					$('#bidang').html(msg);
				}
			});
		});
	});
</script>
