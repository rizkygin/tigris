<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Installasi SIAP</title>
    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/admin-lte.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/skins.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/general.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/app.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/select2/select2.js' ?>"></script>
	
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.js' ?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.date.extensions.js' ?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.extensions.js' ?>" type="text/javascript"></script>
	
	<script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>

  <script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
		
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   
	<style>
		.navbar-brand { font-size: 1.6em; }
		.navbar-brand img { max-width: 38px; margin: -8px 10px 0 0; }
		.text-muted { font-style: italic; }
		.app-setup-content { position: relative; padding: 0 10px 0 110px; line-height: 0.9em; min-height: 80px; }
		.callout-muted { background: #ddd; border-left: 5px solid #aaa; color: #999}
		.callout { position: relative; padding-left: 110px; min-height: 110px; }
		.callout p { line-height: 1.2em; }
		.iconic { position: absolute; top: 12px; left: 15px; font-size: 5.8em; }
		.app-text { font-size: 16px; }
		.list-aplikasi { line-height: 1.6em !important}
	</style>
	</head>
  
  
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="#" class="navbar-brand"><img src="<?php echo base_url().'assets/logo/logo.png' ?>" align="left"><b>SIAP</b></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
          </div>
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>Modul Inisialisasi <small>Seri 1.0</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Inisialisasi</li>
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">
		  
			<div class="row">
			<div class="col-lg-6">
		  
			<div class="box box-default">
             
              <div class="box-body">
			  		<p>
					Dengan klik tombol di bawah ini, aplikasi akan diinisialisasi pada calon database kosong yang telah ada.
					Apakah ingin mulai melakukan inisialisasi?
					</p>
					<br><br>
					<p>
					<button class="btn btn-lg btn-primary btn-proses"><i class="fa fa-life-ring fa-btn"></i> Mulai Inisialisasi</button>
					<a href="<?php echo site_url() ?>" class="btn btn-success btn-lg on-hide btn-selesai" ><i class="fa fa-check-circle-o fa-btn"></i> Selesai !</a>
					</p>
              </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
		
			<div class="col-lg-6">
            <div class="callout callout-muted" id="proses-db">
				<div class="iconic"><i class="fa fa-database"></i></div>
              <h4>Database Dasar</h4>
              <p>Proses ini membangun database dasar untuk berdirinya aplikasi, terdiri dari referensi aplikasi, operator, kewenangan, dan basis navigasi.</p>
            </div>
			<?php if (count($app_mod) > 0) { ?>
			
			<div class="callout callout-muted" id="proses-app">
				<div class="iconic"><i class="fa fa-cube"></i></div>
              <h4>Inisialisasi Aplikasi</h4>
              <p>Memasukkan aplikasi terdaftar untuk pembangunan modul aplikasi.</p>
			  <p class="list-aplikasi">
			  <?php
		
			  foreach($app_mod as $u => $e) {
				  
				  echo '<span id="'.$e.'" class="app-text"><i class="fa fa-cube fa-btn"></i> '.kalimat($e).'<span><br>';
				  
			  } ?>
			  </p>
            </div>
			
			<?php } ?>
			<div class="callout callout-muted" id="proses-fin">
				<div class="iconic"><i class="fa fa-check-circle-o"></i></div>
              <h4>Selesai</h4>
              <p>Proses selesai dilakukan</p>
            </div>
			</div>
           </div>
            
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Modul Inisialisasi Seri </b> 1.0
          </div>
          Copyright &copy; 2016 | <strong><a href="http://mediamultikaryatama.id">CV MMK</a></strong>
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->	
    
    <div class="modal fade" id="modal-pasang" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-header"><button class="close" aria-label="Close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
			</button>
			<h4 class="modal-title form-title"><i class="fa fa-cube"></i> &nbsp; Konfirmasi Pemasangan</h4></div>
	        <div class="modal-body">Apakah akan memasang Aplikasi ini?</div>
	        <div class="modal-footer">
			<button class="btn btn-default pull-left" data-dismiss="modal" type="button">Batal</button>
			<a class="form-delete-url"><button class="btn btn-primary" type="button"><i class="fa fa-cube"></i> &nbsp; Pasang</button></a>
			</div>
	    </div>
	  </div>
	</div>

    
	<script type="text/JavaScript">
		$(document).ready(function(){
		$('.btn-proses').click(function() {
			$(this).attr('disabled','disabled').html('<i class="fa fa-btn fa-spin fa-spinner"></i> Proses Inisialisasi ...');
			set_database();
			return false;
		});
		});
		
		function set_database() {
		
			$(document).ready(function() {
				$.ajax({
					url: '<?php echo site_url('inti/builder/inisialisasi/db') ?>',
					dataType: "json",
					success: function(msg) {
						if (parseInt(msg.status) == 1) {
							$('#proses-db').removeClass('callout-muted').addClass('callout-warning');
							set_aplikasi();
						}
					}
				});
			
			});
			
		}
		
		
		
		function set_aplikasi() {
			
			$('#proses-app').removeClass('callout-muted').addClass('callout-danger');
			
			<?php if (count($app_mod) > 0) { ?>
			
			<?php echo 'set_'.$app_mod[0].'()' ?>;
			
		}
		
		<?php 
		$no = 0;
		foreach($app_mod as $u => $e) { ?>
		
		function set_<?php echo $e ?>() {
			
			$('#<?php echo $e ?>').find('i').removeClass('fa-cube').addClass('fa-spin fa-spinner');
			$(document).ready(function() {
				$.ajax({
					url: '<?php echo site_url($e.'/db') ?>',
					dataType: "json",
					success: function(msg) {
						if (parseInt(msg.sign) == 1) {
							$('#<?php echo $e ?>').find('i').removeClass('fa-spin fa-spinner').addClass('fa-check-circle-o');
							<?php 
							if ($e == $app_mod[count($app_mod)-1]) echo 'selesai();';
							else echo 'set_'.$app_mod[$no+1].'();' ?>
						}
					},error: function (data, status, e) {
						$('#<?php echo $e ?>').find('i').removeClass('fa-spin fa-spinner').addClass('fa-remove');
						<?php 
						if ($e == $app_mod[count($app_mod)-1]) echo 'selesai();';
						else echo 'set_'.$app_mod[$no+1].'();' ?>
					}
				});
			});
			
		}

		<?php 
		$no+=1;
		}
		?>

		function selesai() {
			
			$.ajax({
				url: '<?php echo site_url('inti/builder/inisialisasi/set/'.implode('-',$app_mod)); ?>',
				dataType: "json",
				success: function(msg) {
					if (parseInt(msg.status) == 1) {
						set_selesai();
					}
				},error: function (data, status, e) {
					set_selesai();
				}
			});

		}
		
		<?php } else { ?>
		
			set_selesai();
		
		}
		
		<?php } ?>
		
		
		function set_selesai() {
			
			 $(document).ready(function(){
				$('#proses-fin').removeClass('callout-muted').addClass('callout-success');
				$('.btn-proses').removeAttr('disabled').html('<i class="fa fa-check-circle-o fa-btn"></i> Selesai!').hide();
				$('.btn-selesai').show();
			});
			
		}
    </script>
</body>
</html>