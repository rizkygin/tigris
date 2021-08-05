<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="<?php echo $par['all_reload']?>">

    <title><?php echo $title ?></title>

    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/admin-lte.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/skins.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/general.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style_cms.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/js/style.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/app.min.js'?>"></script>

	<script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>

	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link href="<?php echo base_url().'assets/css/AdminLTE.min.css' ?>" rel="stylesheet" type="text/css" />


	<link href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.css' ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.print.css' ?>" rel="stylesheet" type="text/css" media="print" />

    <script src="<?php echo base_url()?>assets/plugins/fullcalendar/moment.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fullcalendar/fullcalendar.js"></script>


	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery_cms.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/tasktimer/dist/tasktimer.min.js' ?>"></script>

	<style>
		body{ background: #b781cb;font-size: 14px !important;color:#000 !important;}
		.logo { z-index: 999; }
		.logo_app h2 { color: #fff; letter-spacing: -1px; font-size: 1.6em; font-weight: 600; text-align: left; 
			line-height: 0.9em; margin-top: 28px; text-transform: uppercase}
		.logo_app img { float: left; max-height: 65px; margin: 5px 8px 15px 12px}
		.logo img { float: left; margin: 10px 10px 10px 20px; max-height: 60px; }
		.logo h2, .logo h1 { padding: 0; margin: 20px 0 0 0; color: #fff;/*text-transform: uppercase; text-shadow: 1px 1px 2px #fff*/ }
		.logo h2 { font-size: 1em;  letter-spacing: 3px; text-transform: uppercase; }
		.logo h1 { font-size: 1.6em; margin-top: 0; font-weight: bold }

		.col-sm-6, .col-sm-5 { position: relative; }
		.marquee-box { background: #000; color: #fff; position: fixed; bottom: 0; padding-top: 5px; letter-spacing: 2px; z-index: 999; right: 80px; left: 80px; height: 40px;}
		.marquee-box ul li { list-style: none; margin-left: 80px; float: left;}
		.marquee-box ul li i { margin: 0 0px 0 0; font-size: 12px; margin-top:-10px; padding:0px;}
		.marquee-box img{ height:35px; }
		.jam{ background: #f8c300;color:#fff;font-size: 16px !important;position:fixed;left:0px;bottom:0;font-size: 12px;height:40px;width:80px;margin-bottom: 0px;padding: 10px;font-weight: bold;}
		.tanggal{ background: url(<?php echo base_url()?>uploads/logo/tanggal.png) no-repeat left top; position:fixed;right:0px;bottom:0;font-size: 16px;height:40px;width:115px;margin-bottom: 0px;padding: 13px 10px 10px 15px;font-weight: bold;z-index: 999999999;color:#fff;}
		
		.kiri .konten { margin : 10px; color: #444}
		.kiri .konten .judul { padding: 10px; font-size: 12px; letter-spacing: 3px; 
				text-transform: uppercase; border: 1px dashed #444; font-weight: 600}
		.kanan .konten { margin : 0px 10px 0px 10px; color: #fff; text-align: right;margin-right: 0px; padding-right: 10px;}
		.kanan .konten .judul { padding: 10px 20px; font-size: 12px; letter-spacing: -1px; 
				text-transform: uppercase; background: rgb(12, 94, 132);
				text-align: right; font-weight: 600; margin-left: -10px;    margin-right: -10px;}
		.jud-ext { border-radius: 0 !important }
		.drop-bg { position: absolute; width: 100%; top: 0; left: 0; overflow: hidden; z-index: 100 }
		.drop-bg img { max-width: 100%; }
		.box-image-konten img {max-width: 100%;    border: 3px solid #ccc;height:auto; }
		.no_kiri { position: absolute; left: 20px; bottom: 75px; padding: 10px 0 10px 0; opacity: 0.5;
			text-align: center; min-width: 40px; height: 40px; font: 1.4em Arial; font-weight: bold; color: #fff; background: #222;}
		.no_kanan { position: absolute; right: 20px; bottom: 75px; padding: 10px 0 10px 0; opacity: 0.5;
			text-align: center; min-width: 40px; height: 40px; font: 1.4em Arial; font-weight: bold; color: #fff; background: #ddd;}
		.unit { display: none; }
		
		.news-title { font-size: 12px; text-align: left; padding: 8px 0 0px 0; margin-bottom: 3px;}
		.news-title-sub {font-size: 12px; line-height: 1em; text-align: right}
		/*.news-content p{ line-height: 160%;height:145px;}*/
		.news-content{ height: 100px;}
		.news-content p{ text-align: justify;}
		/*#box-image { margin-left: -5px; }*/
		.foto { text-align: center !important; position: relative; overflow: hidden}
		.foto-title {  background: #000; top: 0; left: 0; padding: 3px 10px; 
				color: #fff; opacity: 0.7; font-size: 160%; letter-spacing: 1px; font-size: 12px;}

		.foto-content {  position: absolute; background: #000; padding: 3px 10px; left: 0; bottom: 15px; color: #fff; opacity: 0.4; width: 100%; display: none; }
		.info-box {
		  margin-bottom: 5px;
		}
		.box-header.with-border {		   
			background:<?php echo $par['sch_warna_judul']?>;
		}
		.box-header {
		    color: #f8c300;
		}
		.box.box-default{
			border: none;
		}
		.box-body h5{
			text-align: left;
		    margin-left: 15px;
		    font-weight: bold;
		}
		.box{
			    margin-bottom: 10px;
		}
		.h4, .h5, .h6, h4, h5, h6{
			margin:0px;
		}
		h5{
			margin-bottom:0px;
			font-weight:bold;
			text-align:center;
			color:<?php echo $par['sch_warna_teks_judul']?>;
			font-size: 20px;
		}
		.table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th{
			padding: 3px;
		}
		.pagination{
			display:none;
		}
		.badge{
			    background-color: rgba(119, 119, 119, 0.35);
		}
		li {
		    margin-left: -20px;
		}
		.striper_mingni { 
			overflow: hidden; 
			position: relative; 
			height: 25px; 
		} 
		.strip-mingni { 
			position:absolute; 
			left: 0;
			right:0;
			top: 0; 
		}
		.luar_mingni_kir { 
			overflow: hidden; 
			position: relative; 
			min-height: 150px; 
		} 
		.dalam-mingni_kir { 
			position:absolute; 
			left: 0;
			top: 0;
			padding: 5px;
		}
		.luar_mingni_kan { 
			overflow: hidden; 
			position: relative; 
			min-height: 150px; 
		} 
		.dalam-mingni_kan { 
			position:absolute; 
			left: 0;
			top: 0; 
		}
		.luar { 
			overflow: hidden; 
			position: relative; 
			min-height: 210px; 
			} 
		.dalam{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}
		.jns_prog { 
			overflow: hidden; 
			position: relative; 
			min-height: 210px; 
			} 
		.prog{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}
		.status_agenda{
		    z-index: 99999999999999;
		    position: absolute;
		    left: 0;
		    right: 0;
		    bottom: 0;
		}
		.coret {
		    text-decoration: line-through;
		}
		/*.jns_prog2 { 
			overflow: hidden; 
			position: relative; 
			min-height: 210px; 
			} 
		.prog2{ 
			position:absolute; 
			left: 0; 
			top: 0; 
		}*/
	</style>
	<script type="text/javascript">
	 window.onload = function() { jam(); }

	 function jam() {
	  var e = document.getElementById('jam'),
	  d = new Date(), h, m, s;
	  h = d.getHours();
	  m = set(d.getMinutes());
	  s = set(d.getSeconds());

	  e.innerHTML = h +':'+ m +':'+ s;

	  setTimeout('jam()', 1000);
	 }

	 function set(e) {
	  e = e < 10 ? '0'+ e : e;
	  return e;
	 }
	</script>

</head>
  
<body class="skin-blue sidebar-mini" style="background: <?php echo $par['sch_warna_latar']?>">
	<div class="row">
		<div class="col-lg-12" style="background: <?php echo $par['sch_warna_header']?>; height: 80px;">			
			<div class="logo pull-left" style="margin-left: 15px;">
					<?php $ava = file_exists('./logo/'.$par['pemerintah_logo']) ? base_url().'logo/'.$par['pemerintah_logo'] : base_url().'assets/logo/brand.png'; ?>
					<img src="<?php echo $ava ?>"><div class="pull-left">
						<h2 style="color: <?php echo $par['sch_warna_teks_header']?>"><?php echo $par['pemerintah'] ?></h2>
						<h1 style="color: <?php echo $par['sch_warna_teks_header']?>"><?php echo $par['instansi'] ?></h1>
					</div>
					<div class="clear"></div>
				</div>
			
			<div class="logo_app pull-right" style="margin-right: 15px;">
			<div class="pull-left">

						<h2 style="color: <?php echo $par['sch_warna_teks_header']?>"><?php echo str_replace(' ',' ',$app) ?></h2>
					</div>
					<?php $ava = file_exists('./assets/logo/'.$folder.'.png') ? base_url().'assets/logo/'.$folder.'.png' : base_url().'assets/logo/logo.png'; ?>
					<img src="<?php echo $ava ?>">
					<div class="clear"></div>
				</div>
			<div class="clear"></div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-5" style="font-family: Arial !important; padding-top: 10px;">
				<div class="box box-default" style="height:<?php echo $par['height_agenda_2']?>px;">
					<div class="box-header with-border box-agenda">
	                	<h5>RINCIAN AGENDA KEGIATAN</h5>
	              	</div>
              		<div class="col-md-12 no-padding">
					    <div class="box-body no-padding">
							<div class="postPST" id="postPST">
								<?php echo $data_kegiatan; ?>
								<?php echo $this->ajax_pagination->create_links(); ?>								
								<script>
							        function getData(){  
							        	
							        	var page = 0;
							            $.ajax({
							                method: "POST",
							                url: "<?php echo site_url('schedul/ids_schedul/ajaxPaginationData'); ?>/"+page,
							                data: { page: page },
							                beforeSend: function(){
							                    $('<?php echo 'loading'; ?>').slideDown();
							                },
							                 success: function(data){
							                	$('#postPST').html(data);								                    
							                }
							            });
							        }
							    </script>
							</div>
					  	</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 no-padding" style="padding-top:10px !important;">
				<div class="col-lg-12 no-padding">
					<div class="box box-default" style="height:<?php echo $par['height_kalender_2']?>px;">
						<div class="box-header with-border">
		                	<h5>KALENDER KEGIATAN</h5>
		              	</div>
		            	<div class="box-body" style="padding: 0px;">
			               
						<div id="box-pengumuman" style="min-height: 145px;">
						<?php
							function tanggal_sekarang($time=FALSE)
							{
							 //date_default_timezone_set('Asia/Jakarta');
							 $str_format='';
							 if($time==FALSE)
							 {
							 $str_format= date("Y-m-d");
							 }else{
							 $str_format= date("Y-m-d H:i:s");
							 }
							 return $str_format;
							}
							?>

							<script>
							$(document).ready(function() {
							 	$('#calendar').fullCalendar({						   
								    header: {
								        left: 'prev,next today',
								        center: 'title',
								        right: 'month,agendaWeek,agendaDay'
								      },

								    buttonText: {
								        today: 'today',
								        month: 'month',
								        week: 'week',
								        day: 'day'
								      },

								    events: {
							 			url : "<?php echo site_url('schedul/ids_schedul/jadwal_json'); ?>",
							            dataType : "JSON",
						              method : "POST",
						              success : function(data){
						                // console.log(data.table_kiri);
						                $('#table_kiri').html(data.table_kiri);
						                return data.calendar;

						              }
							 		},
							    });
							});
							</script>
							<?php 
							$from = array(
							      'sch_jadwal tj' => '',
							      'sch_ref_program td' => array('td.id_ref_program = tj.id_ref_program','left'),
							      'sch_ref_kegiatan ts' => array('ts.id_ref_kegiatan= tj.id_ref_kegiatan','left'),
							      'sch_color tx' => array('tx.id_color= tj.id_color','left')
							    );
							    $select = 'td.nama_program,ts.nama_kegiatan,tj.id_jadwal,tj.tgl_mulai,tj.tgl_selesai,tj.*,tx.color';
							    $jadwal= $this->general_model->datagrab(array('tabel'=>$from, 'order'=>'td.id_ref_program ASC','select'=>$select));
							    // cek($this->db->last_query()); die();
							    $store = array();
							      foreach ($jadwal->result() as $row) {
							       
							?>
						       
						 	<?php } ?>
								<style type="text/css">
								  .fc-row .fc-content-skeleton tbody td, .fc-row .fc-helper-skeleton tbody td{
								        position: relative;
								  }
								  .fc-day-grid-event>.fc-content{
								    text-align: left;
								  }
								  .fc-other-month.fc-day-content{display:none;}/*
								  .fc-toolbar, .fc-left{display:none;}*/

								  .fc .fc-button-group>:first-child {
								    margin-left: 0;
								    display: none;
								}
								.fc .fc-button-group>* {
								    float: left;
								    margin: 0 0 0 -1px;
								    display: none;
								}
								.fc-state-default.fc-corner-right {
								    border-top-right-radius: 4px;
								    border-bottom-right-radius: 4px;
								    display: none;
								}
								.fc-toolbar {
								    padding: 0px;
								    margin: 0;
								}
								.fc-toolbar h2 {
								    margin: 0;
								    font-size: 20px;
								}

								  .fc-scroller {
								  	height: 150px !important;
								     overflow-y: hidden; 
								     overflow-x: hidden; 
								}
								.fc-basic-view tbody .fc-row{
									 min-height: 0; 
								}
								.fc-ltr .fc-basic-view .fc-day-number{
									text-align: center;
								    font-size: 12px;
								}

								.fc-basic-view tbody .fc-row {
								    min-height: 0;
								    height: 20px !important;
								}
								</style>
							<div class="row">
								<div class="col-lg-12">
									<div id="calendar"></div>
								</div>
							</div>
						</div>
			    	</div><!-- /.box-body -->
            	</div>
            </div>
			<div class="col-lg-12 no-padding">
				<div class="box box-default" style="height:<?php echo $par['height_agenda_bulan_ini_2']?>px;">
					<div class="box-header with-border">
						<style>.blink_me {
						  animation: blinker 1s linear infinite;
							}

							@keyframes blinker {  
							  50% { opacity: 0.0; }
							}
						</style>
		             <span><h5 style="text-align:left;">AGENDA BULAN INI</h5></span>
		            </div>
		            <div class="box-body no-padding box-mingguini" style="margin-top:-2px;">			               
						<div id="box-pengumuman">					
							<div id="postGAL3">
								<?php 
								if (!empty($detail_kegiatan_mi)) {
									$nox=1;
									foreach($detail_kegiatan_mi->result() as $row){ ?>
										<div class="row">
											<div class="col-lg-12 no-padding" style="text-align:right;position:relative !important;">
											<?php if($theme->id_theme == 1) { ?>
												<div class="blink_me badge" style="color:#fff;margin-top:-38px; font-size:22px;position:absolute;left:28%;padding:5px;background: none !important;"> <?php echo $total_rows; ?> </div>
											<?php }else{ ?>
												<div class="blink_me badge" style="color:#fff;margin-top:-36px; font-size:20px;position:absolute;left:42%;padding:5px;background: none !important;"> <?php echo $total_rows; ?> </div>
											<?php } ?>
												<!-- <div class="badge" id="blinkx" style="background:#fff;margin-top:-33px;display: inline;font-size:14px;position:absolute;top:0px;right:20px; padding:5px;color:<?php echo $row->color; ?> !important;"> <?php echo tanggal($row->tgl_mulai).'  s.d '.tanggal($row->tgl_selesai); ?> </div>
												 -->
												 <div class="badge" id="blin" style="background:#fff;margin-top:-33px;display: block;font-size:14.5px;position:absolute;right:20px;padding:5px;color:<?php echo $row->color; ?> !important;"> <?php echo tanggal($row->tgl_mulai).'  s.d '.tanggal($row->tgl_selesai); ?> </div>
											</div>

											<div class="col-lg-12" style="font-size: 18px;">
												<div class="col-lg-1" style="background:<?php echo $row->color;?>; color:#fff;"><b><?php echo (@$page+1);?></b></div>
												<?php 
													if(strlen($row->nama_kegiatan) >= 35){ ?>
													<div class="col-lg-11 no-padding">
														<div class="striper_mingni">
															<div class="strip-mingni" style="width:<?php echo (strlen($row->nama_kegiatan)*8); ?>px">
																<?php echo $row->nama_kegiatan; ?>
															</div>
														</div>
													</div>
													<?php }else{ ?>
														 <div class="col-lg-11"><?php echo $row->nama_kegiatan;?></div>
													<?php } ?>
											</div>
										</div>
										<?php if($row->id_jenis_program == 1) { ?>
										<div class="luar_mingni_kir" style="min-height:123px;">
											<div class="col-lg-12 news-content" style="font-size: 12px;border-top: 1px solid <?php echo $row->color; ?>;">
												<div class="dalam-mingni_kir" style="<?php echo @$te ?>;">
													<?php echo $row->content; ?>				
													<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Lokasi</label>
													<p style="margin-bottom:2px;"><?php echo $row->lokasi; ?></p>
													<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Indikator</label>
													<p style="margin-bottom:2px;"><?php echo $row->indikator; ?></p>
													<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Sasaran</label>
													<p style="margin-bottom:2px;"><?php echo $row->sasaran; ?></p>
													<label style="margin-bottom:0px;border-bottom:1px solid <?php echo $row->color; ?>;">Pagu</label>
													<p style="margin-bottom:2px;"><?php echo rupiah($row->pagu); ?></p>
												</div>
											</div>
										</div>
										<?php }else{ ?>
											<div class="col-lg-12 news-content" style="font-size: 12px;border-top: 1px solid <?php echo $row->color; ?>;">
												<div class="luar_mingni_kir" style="min-height:120px;">
													<div class="dalam-mingni_kir" style="<?php echo @$te ?>;">
														<?php echo $row->content; ?>
													</div>
												</div>
											</div>
										<?php } ?>
									<div class="clear"></div>
									<?php if($row->status == 2) { ?>											
										<div class="status_agenda" style="background:<?php echo $row->color; ?>;">
											<div class="col-lg-12 no-padding">										
												<div class="col-lg-12 no-padding">
													<div class="col-lg-2 no-padding" style="padding-left:3px !important;text-align:center;">
														<label style="padding-top:3px;color:#fff;"> BATAL </label></div>
													<div class="col-lg-10" style="padding-right:3px !important;"> 
														<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
															<span>kegiatan tgl</span>
															<span><?php echo tanggal($row->tgl_mulai).' s.d '.tanggal($row->tgl_selesai); ?></span>
														</marquee>
													</div>
												</div>
											</div>
										</div>
									<?php }else{
									if($row->tgl_mulai_ubah != NULL and $row->tgl_selesai_ubah != NULL) { ?>
											<div class="status_agenda" style="background:<?php echo $row->color; ?>;">
												<div class="col-lg-12 no-padding">										
													<div class="col-lg-6 no-padding">
														<div class="col-lg-3 no-padding" style="padding-left:3px !important;">
															<label style="padding-top:3px;color:#fff;"> Perubahan </label></div>
														<div class="col-lg-9" style="padding-right:3px !important;"> 
															<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
																<span>tanggal mulai : </span>
																<span><?php echo tanggal($row->tgl_mulai_ubah); ?></span>
															</marquee>
														</div>
													</div>										
													<div class="col-lg-6 no-padding">
														<div class="col-lg-3 no-padding" style="padding-left:3px !important;text-align:right;">
															<label style="padding-top:3px;color:#fff;">Terlambat </label></div>
														<div class="col-lg-9" style="padding-right:3px !important;"> 
															<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
																<span>tanggal selesai : </span>
																<span><?php echo tanggal($row->tgl_selesai_ubah); ?></span>
															</marquee>
														</div>
													</div>
												</div>
											</div>
									<?php }elseif($row->tgl_mulai_ubah != NULL){ ?>
											<div class="status_agenda" style="background:<?php echo $row->color; ?>;">
												<div class="col-lg-12 no-padding">										
													<div class="col-lg-12 no-padding">
														<div class="col-lg-2 no-padding" style="padding-left:3px !important;">
															<label style="padding-top:3px;color:#fff;">Perubahan </label></div>
														<div class="col-lg-10" style="padding-right:3px !important;"> 
															<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
																<span>tanggal mulai : </span>
																<span><?php echo tanggal($row->tgl_mulai_ubah); ?></span>
															</marquee>
														</div>
													</div>
												</div>
											</div>

									<?php }elseif($row->tgl_selesai_ubah != NULL){ ?>
											<div class="status_agenda" style="background:<?php echo $row->color; ?>;">
												<div class="col-lg-12 no-padding">										
													<div class="col-lg-12 no-padding">
														<div class="col-lg-2 no-padding" style="padding-left:3px !important;">
															<label style="padding-top:3px;color:#fff;">Terlambat </label></div>
														<div class="col-lg-10" style="padding-right:3px !important;"> 
															<marquee style="background:#fff;margin-top:4px;" scrolldelay="200">
																<span>tanggal selesai : </span>
																<span><?php echo tanggal($row->tgl_selesai_ubah); ?></span>
															</marquee>
														</div>
													</div>
												</div>
											</div>
									<?php }else{ ?>
									<?php } ?>
								<?php $nox+=1; }
										
									}
								}else{
									echo " Tidak ada agenda bulan ini";
								} ?>
							<?php echo $this->ajax_pagination_gal3->create_links();?>	
	            				<script>
									$(document).ready(function() {
										$('.luar_mingni_kir').height($('.box-mingguini').height()-140);
										$('.dalam-mingni_kir').each(function() {
												set_peng($(this));
										});
										
										function set_peng(from) {
											setTimeout(function() {
												setInterval(function() {
													if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
														var posnow = $(from).css('top');
														if (parseInt(posnow) > (-1)*parseInt($(from).css('height'))) {
															$(from).css('top',(parseInt(posnow)-10)+'px')
														} else {
															$(from).animate({ 'top': 10});
														}
													}
												},1000);
											},1000);
										}
									});

									$(document).ready(function() {
										$('.striper_mingni').width($('.box-mingguini').width()-0);

										$('.strip-mingni').each(function() {
											
											set_move($(this));
											
										});
										
										function set_move(from) {
										setInterval(function() {
											var posnow = $(from).css('left');
											if (parseInt(posnow) > (-1)*parseInt($(from).css('width'))) {
												$(from).css('left',(parseInt(posnow)-10)+'px')
											} else {
												$(from).animate({ 'left': 30});
											}
										},200)
										}
									});

									function getData_gal3(){  

							        	// var page = $('#pageGAL1').val();
							        	var page = 0;
							            $.ajax({
							                method: "POST",
							                url: "<?php echo site_url().'schedul/ids_schedul/ajaxPaginationGAL3'?>/"+page,
							                data: { pageGAL4: page },
							                beforeSend: function(){
							                    $('<?php echo 'loading'; ?>').slideDown();
							                },
							                
							                success: function(data){
							                		$('#postGAL3').html(data);
							                    
							                    
							                }
							            });
							        }
								</script>
							</div>	
						</div>
					</div><!-- /.box-body -->
        		</div>
		</div>
	<div class="col-lg-12 no-padding">
		<div class="box box-default" style="height:<?php echo $par['height_agenda_bulan_depan_2']?>px;">
			<div class="box-header with-border">
            	<h5>AGENDA BULAN DEPAN</h5>
          	</div>
          	<div class="box-body no-padding">
          		<div class="col-lg-12 no-padding">		           		
					<div id="postGAL4">
						<?php 
						echo $minggu_depan;?>

            			<?php echo $this->ajax_pagination_gal4->create_links();?>
            			 <script>
					        function getData_gal4(){  

					        	// var page = $('#pageGAL1').val();
					        	var page = 0;
					            $.ajax({
					                method: "POST",
					                url: "<?php echo site_url().'schedul/ids_schedul/ajaxPaginationGAL4'?>/"+page,
					                data: { pageGAL4: page },
					                beforeSend: function(){
					                    $('<?php echo 'loading'; ?>').slideDown();
					                },
					                
					                success: function(data){
					                		$('#postGAL4').html(data);
					                    
					                    
					                }
					            });
					        }
					    </script>
					</div>	
		           </div>
		        </div>
		    </div>
		</div>
	</div>
	<div class="col-lg-3" style="padding-top:10px;">
		<div class="col-lg-12 no-padding" style="font-family: Arial !important;">
			<div class="box box-default" style="height:<?php echo $par['height_pengumuman_2']?>px; overflow: none;">
				<div class="box-header with-border">
					<span><h5>PENGUMUMAN</h5></span>
	          	</div>
	          	<div class="box-body no-padding" style="height:165px; overflow:hidden;">			               
					<div id="box-pengumuman" style="padding:0px 10px;">
	          			<div class="widget-pengumuman" id="postNews"></div>

					
	          		</div>
	             </div><!-- /.box-body -->
			</div>	
		</div>

	<div class="col-lg-12 no-padding" style="padding-right:10px">
		<div class="box box-default" style="height:<?php echo $par['height_galeri_2']?>px;">
			<div class="box-header with-border">
            	<h5>GALERI</h5>
          	</div>
          	<div class="box-body" style="padding:5px;">
		              		<!-- galeri -->
	           <div class="col-lg-12" style="margin:0px; padding:3px;">
	           		<!-- postGAL1 -->
					<div id="postGAL1">
						<?php
						if (count($foto) > 0) {
								$i = 0;
								foreach ($foto as $f) { 
									$i++;
									$id_gal = 'gal_kiri';
									$jml_kar = strlen($f->judul);?>
									<div id="<?php echo $id_gal; ?>">
										<?php
										if($jml_kar > 20){ ?>
											<div class="foto-title" style="padding-bottom: 0px;">
												<marquee direction="right"><?php echo $f->judul; ?></marquee>
											</div>
										<?php }else{ ?>
											<div class="foto-title" style="padding-bottom: 4px; text-align: justify;"><?php echo $f->judul; ?></div>
										<?php } ?>

										<img src="<?php echo base_url().'uploads/tvinfo/'.$f->foto; ?>" style="width:100%; height:118px;"/>
															<?php if (!empty($f->keterangan)) 
										echo '<div class="foto-content">'.$f->keterangan.'</div>'; ?>
									</div>
							<?php } 
								} else { echo '<div class="alert">Belum ada Foto ...</div>'; }									
							?>
							<?php echo $this->ajax_pagination_gal1->create_links();?>
							<script>
						        function getData_gal1(){
						        	// var page = $('#pageGAL1').val();
						        	var page = 0;
						            $.ajax({
						                method: "POST",
						                url: "<?php echo site_url().'schedul/ids_schedul/ajaxPaginationGAL1'?>/"+page,
						                data: { pageGAL1: page },
						                beforeSend: function(){
						                    $('<?php echo 'loading'; ?>').slideDown();
						                },
						                
						                success: function(data){
						                		$('#postGAL1').html(data);   
						                }
						            });
						        }
							</script>
						</div>		
						<!-- ./postGAL1 -->
		           </div>

		           <!-- KANAN -->
		           <div class="col-lg-12" style="margin:0px; padding:3px;">
		           		<!-- postGAL1 -->
					<div id="postGAL2">
						<?php
						if (count($foto_kanan) > 0) {
								$i = 0;
								foreach ($foto_kanan as $f) { 
									$i++;
									$id_gal = 'gal_kiri';
									$jml_kar = strlen($f->judul);?>
									<div id="<?php echo $id_gal; ?>">
										<?php
										if($jml_kar > 20){ ?>
											<div class="foto-title" style="padding-bottom: 0px;">
												<marquee direction="right"><?php echo $f->judul; ?></marquee>
											</div>
										<?php }else{ ?>
											<div class="foto-title" style="padding-bottom: 4px; text-align: justify;"><?php echo $f->judul; ?></div>
										<?php } ?>

					<img src="<?php echo base_url().'uploads/tvinfo/'.$f->foto; ?>" style="width:100%; height:118px;"/>
										<?php if (!empty($f->keterangan)) 
					echo '<div class="foto-content">'.$f->keterangan.'</div>'; ?>
									</div>
								<?php } 
									} else { echo '<div class="alert">Belum ada Foto ...</div>'; }
									
							?>

				<?php echo $this->ajax_pagination_gal2->create_links();?>
				<script>
				        function getData_gal2(){  

				        	var page = 0;
				            $.ajax({
				                method: "POST",
				                url: "<?php echo site_url('schedul/ids_schedul/ajaxPaginationGAL2'); ?>/"+page,
				                data: { page: page },
				                beforeSend: function(){
				                    $('<?php echo 'loading'; ?>').slideDown();
				                },
				                success: function(data){
				                	$( "#postGAL2" ).slideUp( "slow", function() {
				                		$('#postGAL2').html(data);
				                	});
				                    
				                    $( "#postGAL2" ).slideDown( "slow" );
				                    
				                }
				            });
				        }
				    </script>
					</div>
		           </div>
						</div>

					</div>
				</div>
				
	</div>
	</div>


	<script type="text/javascript">
	  $(document).ready(function() {

	  	// ajak pengumuman (ajax kayak kieee)
	  	$.ajax({
			url : "<?php echo site_url('schedul/ids_schedul/ajaxPengumuman');?>",
			// dataType : "JSON",
			success : function(data){
				$('.widget-pengumuman').html(data);
			}
		});
	  	// ./ajak pengumuman (ajax kayak kieee)
	  	
	    setInterval(function(){
	      tgl_reload();
	    }, 200000);
	  });

	  function tgl_reload(){
	    $.ajax({
	      url: "<?php echo site_url('schedul/ids_schedul/ajax_tgl') ?>",
	      dataType:'JSON',
	      success:function(data){
	        $.each(data, function(k, v){
	          $('#tgl_bawah').html(v.tgl);
	        });
	      }
	    });
	  }
	</script>
	<div class="row">
		<div class="col-lg-12">
			<h5 class="jam" id="jam"></h5>
				<div class="box-marquee" style="font-size: 120%;">	
				</div>
			<h5 class="tanggal" id="tgl_bawah">
				<?php echo date_indox(date('Y-m-d'),2);?>
			</h5>
	</div>

	<div id="durasi_sc">
		<script type="text/javascript">
			<?php 

		if ($kiri->num_rows() > 1) { ?>

		var st_data = <?php echo ($kiri->num_rows() > 1) ? 1 : 0; ?>;
		var durasi = 4;
		
		var lf = 2;
		var max_lf = <?php echo $kiri->num_rows() ?>;

		setInterval(
		function() {
			
			if (parseInt(lf) == 1) $('#lf'+max_lf).hide();
			else $('#lf'+parseInt(lf-1)).hide();
			
			$('.no_kiri').html(lf).show();
			$('#no_kiri').attr('value',lf);
			$('#lf'+lf).fadeIn();
			
			if (parseInt(lf) == max_lf) lf = 1;
			else lf+=1;		

			$.ajax({
				url: '<?php echo site_url("schedul/ids_schedul/get_durasi/") ?>/'+ lf,
				method: 'GET',
				dataType:"JSON",
				success: function(msg) {
					durasi = msg;
					store_int(durasi);

					get_durasi_sc(durasi, st_data, max_lf);

					console.log(durasi);
				},error:function(error){
					show_error('ERROR : '+error).show();
				}
			});
		},

		parseFloat(0.05)*60000);

		$('#lf1').fadeIn();
		$('.no_kiri').html(1).show();
		<?php 
		} else {
			
		echo "$('#lf1').fadeIn();";
	
		}
		?>
		</script>
		
	<script type="text/javascript">
		$(document).ready(function() {
			

			var nre = setInterval(checkit,  (<?php echo $par['durasi_agenda_kegiatan']?>*1000));
			function checkit() {
    				getData();
			    }

			    checkit();
			

			    // galeri

			var gal1 = setInterval(getgal1, (<?php echo $par['durasi_galeri_kiri']?>*1000));
			function getgal1() {
    				getData_gal1();
			    }
			 getgal1();

			var gal2 = setInterval(getgal2, (<?php echo $par['durasi_galeri_kanan']?>*1000));
			function getgal2() {
    				getData_gal2();
			    }
			 getgal2();
			
			var gal3 = setInterval(getgal3, (<?php echo $par['durasi_agenda_bulan_ini']?>*1000));
			function getgal3() {
    				getData_gal3();
			    }
			 getgal3();
			
			var gal4 = setInterval(getgal4, (<?php echo $par['durasi_agenda_bulan_depan']?>*1000));
			function getgal4() {
    				getData_gal4();
			    }
			 getgal4();
			
			var h_image = ($(window).height()-$('.marquee-box').height())*0.3;
			
			$('#box-image').height(h_image+10);
			$('.col-sm-5, .col-sm-7,.drop-bgx').height($(window).height());
			$('#konten-pengumuman').height($(window).height()-$('.marquee-box').height()-h_image-150);
			
			
		});

		function checkitgalkiri(){
			$.ajax({
		      url: "<?php echo site_url('schedul/ids_schedul/ajax_fotokiri') ?>",
		      dataType:'JSON',
		      success:function(data){
		        $('#fotokiri').html(data);
		      }
		    });
		}

		function get_durasi_sc(durasi, st_data, tot){
			$.ajax({
				url: '<?php echo site_url('schedul/ids_schedul/get_durasi_sc') ?>/'+durasi,
				dataType:"JSON",
				cache: false,
				success: function(data) {
					$('#durasi_sc').html(data); 
				},error:function(error){
					show_error('ERROR : '+error).show();
				}
			});
		}

		function store_int(id){
			$('#durasi').attr('value', id);
			
		}
		
		function get_int(id){
			console.log('kembali'+id);
			return id;
		}
		
		function teks_bergerak() {
			
			$.ajax({
				url: '<?php echo site_url('schedul/ids_schedul/teksbergerak') ?>',
				cache: false,
				success: function(msg) {
					$('.box-marquee').html(msg); 
				},error:function(error){
					show_error('ERROR : '+error).show();
				}
			});
			
			
		}

		// var i=1;
		// var intrv=2; // << control this variable

		// var refreshId = setInterval(function() {
		//   if(!(i%intrv)) {
		//     alert('run!');
		//   }
		//   else {
		//    //do nothing
		//   }
		//   i++;
		// }, 1000);

		

		<?php


		if ($kiri->num_rows > 0) {

		if ($kiri->num_rows > 1) {
			$j = 0; $ist = null;$sblm = 0; $id_sblm = null; $durasi = 0;
		?>
			function show_kiri(e) {
				var t = (e) ? e : 0; 
				<?php foreach($kiri->result() as $n) { ?>
					
					setTimeout(function() {
						$('.kiri-<?php echo $n->id_widget ?>').fadeIn();
						
					},
					(parseFloat(<?php echo currencyToNumber($n->durasi)+$sblm?>)*60000)-parseFloat(t))
					<?php if (!empty($id_sblm)) { ?>
					setTimeout(function() {
						$('.kiri-<?php echo $id_sblm ?>').fadeOut();
						}, (parseFloat(<?php echo currencyToNumber($n->durasi)+$sblm?>)*60000)-parseFloat(t)-300);
					<?php } ?>
					
				<?php 
					$durasi = $n->durasi;
					$id_sblm = $n->id_widget;
					$sblm += currencyToNumber($n->durasi);
					if ($j < 1) $ist = $n->durasi;
					$j+=1; } 
					
					if (!empty($id_sblm)) { ?>
					setTimeout(function() {
						$('.kiri-<?php echo $id_sblm ?>').fadeOut();
						}, (parseFloat(<?php echo currencyToNumber($durasi)+$sblm?>)*60000)-parseFloat(t)-300);
						
					<?php } ?>
					setTimeout(function() {
						show_news(parseFloat(<?php echo currencyToNumber($ist)?>)*60000)
					}, (parseFloat(<?php echo currencyToNumber($durasi)+$sblm?>)*60000)-parseFloat(t));
				
				
			}
			
			show_news(parseFloat(<?php echo currencyToNumber($ist)?>)*60000)
			
		<?php } else { ?>
			
			$('.kiri-<?php echo $kiri->row()->id_widget ?>').fadeIn();
			
		<?php } }





		if ($news->num_rows > 0) {

		if ($news->num_rows > 1) {
			$j = 0; $ist = null;$sblm = 0; $id_sblm = null; $jeda = 0;
		?>
			function show_news(e) {
				var t = (e) ? e : 0; 
				<?php foreach($news->result() as $n) { ?>
					
					setTimeout(function() {
						$('.news-<?php echo $n->id_news ?>').fadeIn();
						
					},
					(parseFloat(<?php echo currencyToNumber($n->jeda)+$sblm?>)*60000)-parseFloat(t))
					<?php if (!empty($id_sblm)) { ?>
					setTimeout(function() {
						$('.news-<?php echo $id_sblm ?>').fadeOut();
						}, (parseFloat(<?php echo currencyToNumber($n->jeda)+$sblm?>)*60000)-parseFloat(t)-300);
					<?php } ?>
					
				<?php 
					$jeda = $n->jeda;
					$id_sblm = $n->id_news;
					$sblm += currencyToNumber($n->jeda);
					if ($j < 1) $ist = $n->jeda;
					$j+=1; } 
					
					if (!empty($id_sblm)) { ?>
					setTimeout(function() {
						$('.news-<?php echo $id_sblm ?>').fadeOut();
						}, (parseFloat(<?php echo currencyToNumber($jeda)+$sblm?>)*60000)-parseFloat(t)-300);
						
					<?php } ?>
					setTimeout(function() {
						show_news(parseFloat(<?php echo currencyToNumber($ist)?>)*60000)
					}, (parseFloat(<?php echo currencyToNumber($jeda)+$sblm?>)*60000)-parseFloat(t));
				
				
			}
			
			show_news(parseFloat(<?php echo currencyToNumber($ist)?>)*60000)
			
		<?php } else { ?>
			
			$('.news-<?php echo $news->row()->id_news ?>').fadeIn();
			
		<?php } }
			
			
		?>

		teks_bergerak();
	</script>
	
</body>
</html>