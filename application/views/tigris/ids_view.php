<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title ?></title>

    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/admin-lte.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/skins.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/general.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/app.min.js'?>"></script>

	<script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>

	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/highchart/highcharts.js' ?>"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		/*body{ background: rgba(255, 106, 0, 0.26); color: #fff !important;}*/
		body{ background: url('<?php echo base_url().'assets/images/splash_white.png'?>') center center no-repeat #ecf0f5; color: #fff !important;}
		.logo { z-index: 999; }
		.logo_app h2 { color: #fff; letter-spacing: -1px; font-size: 1.6em; font-weight: 600; text-align: left; 
			line-height: 0.9em; margin-top: 13px; text-transform: uppercase}
		.logo_app img { float: left; max-height: 40px; margin: 5px 8px 15px 12px}
		.col-sm-6, .col-sm-5 { position: relative; }
		.marquee-box { background: #000; color: #fff; position: fixed; bottom: 0; padding-top: 2px; letter-spacing: 2px; z-index: 999; right: 80px; left: 80px; height: 40px;}
		.marquee-box ul li { list-style: none; margin-left: 80px; float: left;}
		.marquee-box ul li i { margin: 0 0px 0 0; font-size: 1.3em; margin-top:-10px; padding:0px;}
		.marquee-box img{ height:35px; }
		.jam{ background: #f8c300;position:fixed;left:0px;bottom:0;font-size: 16px;height:40px;width:80px;margin-bottom: 0px;padding: 10px;font-weight: bold;}
		.tanggal{ background: url(<?php echo base_url()?>uploads/logo/tanggal.png) no-repeat left top; position:fixed;right:0px;bottom:0;font-size: 16px;height:40px;width:115px;margin-bottom: 0px;padding: 13px 10px 10px 15px;font-weight: bold;z-index: 999999999;color:#fff;}
		.logo img { float: left;margin: 4px;max-height: 40px; }
		.logo h2, .logo h1 { padding: 0; margin:0; color: #fff;padding-left:10px; /*text-transform: uppercase; text-shadow: 1px 1px 2px #fff*/ }
		.logo h2 { font-size: 1em;  letter-spacing: 3px; text-transform: uppercase; }
		.logo h1 { font-size: 13px; margin: 0; font-weight: bold }
		.kiri .konten { margin : 10px; color: #444}
		.kiri .konten .judul { padding: 10px; font-size: 1.4em; letter-spacing: 3px; 
				text-transform: uppercase; border: 1px dashed #444; font-weight: 600;margin-bottom:0px;font-weight:bold;text-align:center;background:#000;color:#f8c300}
		.kanan .konten { margin : 0px 10px 0px 10px; color: #fff; text-align: right;margin-right: 0px; padding-right: 10px;}
		.kanan .konten .judul { padding : 10px; margin-bottom:0px;font-weight:bold;text-align:center;background:#000;color:#f8c300}
		.jud-ext { border-radius: 0 !important }
		/*.drop-bg { position: absolute; width: 100%; top: 0; left: 0; overflow: hidden; z-index: 100 }*/
		.drop-bg img { max-width: 100%; }
		.box-image-konten img {max-width: 100%;    border: 3px solid #ccc;height:auto; }
		.no_kiri { position: absolute; left: 20px; bottom: 75px; padding: 10px 0 10px 0; opacity: 0.5;
			text-align: center; min-width: 40px; height: 40px; font: 1.4em Arial; font-weight: bold; color: #fff; background: #222;}
		.no_kanan { position: absolute; right: 20px; bottom: 75px; padding: 10px 0 10px 0; opacity: 0.5;
			text-align: center; min-width: 40px; height: 40px; font: 1.4em Arial; font-weight: bold; color: #fff; background: #ddd;}
		.unit { display: none; }
		
		.news-title { font-size: 1.2em; text-align: left; padding: 4px 0 8px 0; margin-bottom: 10px; border-bottom: 1px dashed #f8c300 }
		.news-title-sub {font-size: 0.9em; line-height: 1em; text-align: right}
		.news-content p{ line-height: 160%;height:145px;}
		/*.news-content p{ line-height: 20px;}*/
		/*#box-image { margin-left: -5px; }*/
		.foto { text-align: center !important; position: relative; overflow: hidden}
		.foto-title {  background: #000; top: 0; left: 0; padding: 3px 10px; 
				color: #fff; opacity: 0.7; font-size: 160%; letter-spacing: 1px; font-size: 14px;}

		.foto-content {  position: absolute; background: #000; padding: 3px 10px; left: 0; bottom: 15px; color: #fff; opacity: 0.4; width: 100%; display: none; }
		.info-box {
		  margin-bottom: 5px;
		}
		.box {
    		/*background: url('<?php echo base_url().'assets/images/splash_white.png'?>') center center no-repeat #4686c9;*/
		}
		.box-header.with-border {
    		background: url('<?php echo base_url().'assets/images/splash_white.png'?>') center center no-repeat #2b4a82;
    		color: #fff !important;
		}
		.box-header {
		    color: #ffffff;
		}
		.box.box-default{
			border: none;
		}
		.box-body{
			
		}
		.box-body h5{
			text-align: left;
		    margin-left: 15px;
		    font-weight: bold;
		}
		.box{
			box-shadow: 0px 2px 3px rgba(0,0,0,0.3);
			/*background: rgb(247, 247, 247);*/
		}
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
   
    border-top: 1px solid rgba(221, 221, 221, 0.19);
}
	</style>
</head>
  
<body class="skin-blue sidebar-mini">

	<div class="row">
		<div class="col-lg-12" style="background: url(<?php echo base_url().'assets/images/splash_white.png'?>) center center no-repeat #2b4a82;  height: 50px;    box-shadow: 0px 2px 3px rgba(0,0,0,0.3);">			
			<div class="logo pull-left" style="margin-left: 15px;">
					<?php $ava = file_exists('./logo/'.$par['pemerintah_logo']) ? base_url().'logo/'.$par['pemerintah_logo'] : base_url().'assets/logo/brand.png'; ?>
					<img src="<?php echo $ava ?>"><div class="pull-left" style="    padding-top: 10px;">
						<h2><?php echo $par['pemerintah'] ?></h2>
						<h1><?php echo $par['instansi'] ?></h1>
					</div>
					<div class="clear"></div>
				</div>
			
			<div class="logo_app pull-right" style="margin-right: 15px;">
			<div class="pull-left">

						<h2><?php echo str_replace(' ',' ',$app) ?></h2>
					</div>
					<?php $ava = file_exists('./assets/logo/'.$folder.'.png') ? base_url().'assets/logo/'.$folder.'.png' : base_url().'assets/logo/logo.png'; ?>
					<img src="<?php echo $ava ?>">
					<div class="clear"></div>
				</div>
			<div class="clear"></div>
		</div>
	</div>

	
	<div class="row drop-bg" style="background:rgba(255, 255, 255, 0.31)">
		<section class="content">
			<div class="col-lg-12">
            <!-- Left col -->
            <div class="col-md-12 no-padding">
              <div class="box">
                <div class="box-header ui-sortable-handle with-border" style="text-align:center !important;">
                  <h3 style=" padding: 0; margin: 0;color:#FFF;font-weight:600">BERJALAN</h3>

                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="row">
                    <div class="col-md-12 col-sm-12">
                      <div class="table-responsive" style="height:350px; overflow: auto;background:#2b4a82;    font-weight: 100;">
                    <?php echo $data_job;?>
                  </div>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->


			</div>
            
            
			<div class="col-lg-12 no-padding"><!-- Left col -->
            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border" style="text-align:center !important;">
                  <h3 class="box-title">RENCANA</h3>

                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="row">
                    <div class="col-md- col-sm-12">
                      <div class="table-responsive" style="height: 230px;overflow: auto; background:#fff;color:black;">
                    <?php echo $data_rencana;?>
                  </div>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-6">
            	<div class="box">
	                <div class="box-header with-border">
	                  <h3 class="box-title">SELESAI</h3>
	                </div><!-- /.box-header -->
	                <div class="box-body no-padding">
	                  <div class="col-md-12" style="padding: 0;">
	                	<div class="table-responsive" style="height: 230px;overflow: auto;color:black;">
	                  		<?php echo $data_job_selesai;?>
						</div>
	                    </div>
	                </div>
              	</div><!-- /.box -->
             </div>
			</div>
         

        </section>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(function(){
		    }, 2000);
			
			var h_image = ($(window).height()-$('.marquee-box').height())*0.3;
			
			$('#box-image').height(h_image+80);
			$('.col-sm-4, .col-sm-8,.drop-bg').height($(window).height());
			$('#konten-pengumuman').height($(window).height()-$('.marquee-box').height()-h_image-150);
			
			
		});
		
		function data_reload(){
	  		$.ajax({
	  			url: "<?php echo site_url('kepegawaian_tv/home/ajax_pengumuman/'.$jml_awl) ?>",
	  			dataType:'JSON',
	  			success:function(data){
	  				$.each(data, function(k, v){
	  					$('#box-pengumuman').html(v.no_antrian);
	  					$('#loket_sekarang').html(v.loket);
		  				$.each(v.data_kiri, function(k_i, k_v){
		  					$('#' + k_v.id_antri).html(k_v.data_antri);
		  				});
	  				});
	  			}
	  		});
	  	}
		
		function teks_bergerak() {
			
			$.ajax({
				url: '<?php echo site_url('kepegawaian_tv/home/teksbergerak') ?>',
				cache: false,
				success: function(msg) {
					$('.box-marquee').html(msg); 
				},error:function(error){
					show_error('ERROR : '+error).show();
				}
			});
			
			
		}
		
		<?php if ($kiri->num_rows() > 1) { ?>
		
		var lf = 2;
		var max_lf = <?php echo $kiri->num_rows() ?>;
		setInterval(
		function() {
			
			if (parseInt(lf) == 1) $('#lf'+max_lf).hide();
			else $('#lf'+parseInt(lf-1)).hide();
			
			$('.no_kiri').html(lf).show();
			$('#lf'+lf).fadeIn();
			
			if (parseInt(lf) == max_lf) lf = 1;
			else lf+=1;		
		},parseFloat(<?php echo (!empty($det)) ? currencyToNumber($det) : 0.05 ?>)*6000000);
		$('#lf1').fadeIn();
		$('.no_kiri').html(1).show();
		<?php 
		} else {
			
		echo "$('#lf1').fadeIn();";
	
		}
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
			
			
		/* Foto */	
			if ($foto->num_rows > 0) {
		if ($foto->num_rows > 1) {
			$j = 0; $ist = null;$sblm = 0; $id_sblm = null; $jeda = 0;
		?>
			function show_foto(e) {
				var t = (e) ? e : 0; 
				<?php foreach($foto->result() as $n) { ?>
					
					setTimeout(function() {
						$('.foto-<?php echo $n->id_foto ?>').fadeIn();
						
					},
					(parseFloat(<?php echo currencyToNumber($n->jeda)+$sblm?>)*60000)-parseFloat(t))
					<?php if (!empty($id_sblm)) { ?>
					setTimeout(function() {
						$('.foto-<?php echo $id_sblm ?>').fadeOut();
						}, (parseFloat(<?php echo currencyToNumber($n->jeda)+$sblm?>)*60000)-parseFloat(t)-300);
					<?php } ?>
					
					var ii = <?php echo $n->id_foto ?>;
					$('.foto-'+ii).css({'max-width':$('.foto-'+ii).width(),'max-height': $('.foto-'+ii).height()});
				<?php 
					$jeda = $n->jeda;
					$id_sblm = $n->id_foto;
					$sblm += currencyToNumber($n->jeda);
					if ($j < 1) $ist = $n->jeda;
					
					$j+=1; } 
					
					if (!empty($id_sblm)) { ?>
					setTimeout(function() {
						$('.foto-<?php echo $id_sblm ?>').fadeOut();
						}, (parseFloat(<?php echo currencyToNumber($jeda)+$sblm?>)*60000)-parseFloat(t)-300);
						
					<?php } ?>
					setTimeout(function() {
						show_foto(parseFloat(<?php echo currencyToNumber($ist)?>)*60000)
					}, (parseFloat(<?php echo currencyToNumber($jeda)+$sblm?>)*60000)-parseFloat(t));
				
				
			}
			
			show_foto(parseFloat(<?php echo currencyToNumber($ist)?>)*60000)
			
		<?php } else { ?>
		
			var ii = <?php echo $foto->row()->id_foto ?>;
			$('.foto-'+ii).css({'max-width':$('.foto-'+ii).width(),'max-height': $('.foto-'+ii).height()});
			$('.foto-<?php echo $foto->row()->id_foto ?>').fadeIn();
			
		<?php }
		} 
		?>

		teks_bergerak();
	</script>
	<div style="display: none;">
		<div id="audio0">
			<audio preload autoplay id="audio1" controls="controls">Your browser does not support HTML5 Audio!</audio>
		</div>
		<?php
			$no=1;
			$tracks = array();
			foreach ($musik->result() as $mus) {
				$tracks[] = '{"track":"'.$no.'","name":"'.str_replace('.mp3', '', $mus->judul).'","lenght":"01:00","file":"'.str_replace('.mp3', '', $mus->judul).'"}';
				$no+=1;
			}
		?>
	</div>
	<script type="text/javascript">
		var b = document.documentElement;
		b.setAttribute('data-useragent', navigator.userAgent);
		b.setAttribute('data-platform', navigator.platform);

		jQuery(function ($) {
		    var supportsAudio = !!document.createElement('audio').canPlayType;
		    if (supportsAudio) {
		        var index = 0,
		            playing = false,
		            mediaPath = '<?php echo base_url("media") ?>/',
		            extension = '',
		            tracks = [<?php echo implode(",", $tracks);?>],
		            trackCount = tracks.length,
		            npAction = $('#npAction'),
		            npTitle = $('#npTitle'),

		            audio = $('#audio1').bind('play', function () {
		                playing = true;
		                npAction.text('Now Playing...');

		            }).bind('pause', function () {
		                playing = false;
		                npAction.text('Paused...');
		            }).bind('ended', function () {
		                npAction.text('Paused...');
		                if ((index + 1) < trackCount) {
		                    index++;
		                    loadTrack(index);
		                    audio.play();
		                } else {
		                    audio.pause();
		                    index = 0;
		                    loadTrack(index);
		                }
		            }).get(0),
		            btnPrev = $('#btnPrev').click(function () {
		                if ((index - 1) > -1) {
		                    index--;
		                    loadTrack(index);
		                    if (playing) {
		                        audio.play();
		                    }
		                } else {
		                    audio.pause();
		                    index = 0;
		                    loadTrack(index);
		                }
		            }),
		            btnNext = $('#btnNext').click(function () {
		                if ((index + 1) < trackCount) {
		                    index++;
		                    loadTrack(index);
		                    if (playing) {
		                        audio.play();
		                    }
		                } else {
		                    audio.pause();
		                    index = 0;
		                    loadTrack(index);
		                }
		            }),
		            li = $('#plList li').click(function () {
		                var id = parseInt($(this).index());
		                if (id !== index) {
		                    playTrack(id);
		                }
		            }),
		            loadTrack = function (id) {
		                $('.plSel').removeClass('plSel');
		                $('#plList li:eq(' + id + ')').addClass('plSel');
		                npTitle.text(tracks[id].name);
		                index = id;
		                audio.src = mediaPath + tracks[id].file + extension;
		            },
		            playTrack = function (id) {
		                loadTrack(id);
		                audio.play();
		            };
		        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
		        loadTrack(index);
		    }
		});
	</script>
</body>
</html>