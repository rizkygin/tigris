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

	<link href="<?php echo base_url().'assets/css/AdminLTE.min.css' ?>" rel="stylesheet" type="text/css" />


	<link href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.css' ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.print.css' ?>" rel="stylesheet" type="text/css" media="print" />



	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url()?>assets/plugins/fullcalendar/moment.min.js" type="text/javascript"></script>
	
	<style>
		body{ background: #b781cb;font-size: 14px !important;}
		.logo { z-index: 999; }
		.logo_app h2 { color: #fff; letter-spacing: -1px; font-size: 1.6em; font-weight: 600; text-align: left; 
			line-height: 0.9em; margin-top: 28px; text-transform: uppercase}
		.logo_app img { float: left; max-height: 65px; margin: 5px 8px 15px 12px}
		.col-sm-6, .col-sm-5 { position: relative; }
		.marquee-box { background: #000; color: #fff; position: fixed; bottom: 0; padding-top: 5px; letter-spacing: 2px; z-index: 999; right: 80px; left: 80px; height: 40px;}
		.marquee-box ul li { list-style: none; margin-left: 80px; float: left;}
		.marquee-box ul li i { margin: 0 0px 0 0; font-size: 12px; margin-top:-10px; padding:0px;}
		.marquee-box img{ height:35px; }
		.jam{ background: #f8c300;color:#fff;font-size: 16px !important;position:fixed;left:0px;bottom:0;font-size: 12px;height:40px;width:80px;margin-bottom: 0px;padding: 10px;font-weight: bold;}
		.tanggal{ background: url(<?php echo base_url()?>uploads/logo/tanggal.png) no-repeat left top; position:fixed;right:0px;bottom:0;font-size: 16px;height:40px;width:115px;margin-bottom: 0px;padding: 13px 10px 10px 15px;font-weight: bold;z-index: 999999999;color:#fff;}
		.logo img { float: left; margin: 15px 10px 10px 20px; max-height: 50px; }
		.logo h2, .logo h1 { padding: 0; margin: 20px 0 0 0; color: #fff;/*text-transform: uppercase; text-shadow: 1px 1px 2px #fff*/ }
		.logo h2 { font-size: 1em;  letter-spacing: 3px; text-transform: uppercase; }
		.logo h1 { font-size: 1.6em; margin-top: 0; font-weight: bold }
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
		/*.news-content p{ line-height: 20px;}*/
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
		.badge{
			    background-color: rgba(119, 119, 119, 0.35);
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
		.luar_mingni_kir { 
			overflow: hidden; 
			position: relative; 
			min-height: 150px; 
		} 
		.dalam-mingni_kir { 
			position:absolute; 
			left: 0;
			top: 0;
			padding-left: 5px;
		}
		.luar_mingni_kan { 
			overflow: hidden; 
			position: relative; 
			min-height: 150px; 
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
			<div class="col-lg-12" style="font-family: Arial !important; padding-top: 10px;">
				<div class="box box-default" style="height:<?php echo $par['height_agenda_1']?>px;">
					<div class="box-header with-border box-agenda">
	                	<h5 style="text-align: left">RINCIAN JADWAL UJIAN</h5>
	              	</div>		<div class="blink_me badge" style="color:#fff;margin-top:-38px; font-size:22px;position:absolute;right:2%;padding:5px;background: none !important;"> <?php echo $total_rows; ?> </div>
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
							                url: "<?php echo site_url('tigris/Ids_mahasiswa/ajaxPaginationDatax'); ?>/"+page,
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
		
	</div>
	
		<div class="col-lg-12">
			<!-- <div class="col-lg-5" style="font-family: Arial !important;">
				<div class="box box-default" style="height:<?php echo $par['height_pengumuman_1']?>px;">
					<div class="box-header with-border">
			        <span><h5>PENGUMUMAN</h5></span>
			    </div>
			<div class="box-body no-padding" style="height:175px; overflow:hidden;">			               
				<div id="box-pengumuman" style="padding:0px 10px;">
	          			<div class="widget-pengumuman" id="postNews"></div>

					
	          		</div>
		    </div>
        </div>
	</div> -->

		
	<script type="text/javascript">
	  $(document).ready(function() {

	  	// ajak pengumuman (ajax kayak kieee)
	  	$.ajax({
			url : "<?php echo site_url('tigris/Ids_mahasiswa/ajaxPaginationDatax');?>",
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
	      url: "<?php echo site_url('tigris/Ids_mahasiswa/ajax_tgl') ?>",
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
		
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			

			var nre = setInterval(checkit,  (<?php echo $par['durasi_agenda_kegiatan']?>*1000));
			function checkit() {
    				getData();
			    }

			    checkit();
			

			
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

		function get_durasi_sc(durasi, st_data, tot){
			$.ajax({
				url: '<?php echo site_url('tigris/Ids_mahasiswa/get_durasi_sc') ?>/'+durasi,
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
				url: '<?php echo site_url('tigris/Ids_mahasiswa/teksbergerak') ?>',
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

	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/tasktimer/dist/tasktimer.min.js' ?>"></script>
	
	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fullcalendar/fullcalendar.js"></script>
</body>
</html>