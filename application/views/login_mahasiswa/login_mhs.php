
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Online Thesis Registrasion</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url('assets/css/AdminLTE.min.css');?>" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url('assets/css/all-skins.min.css');?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      .main-header>.navbar{
        min-height: 80px;
      }
     #navbar-collapse{
        margin-top: 12px;
      }
      .login-box-ex {
          margin: 10% auto 0 auto !important;
      }
    </style>


    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
  <link href="<?php echo base_url().'assets/css/login.css' ?>" rel="stylesheet">
  <link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <style>
      #box_message { margin-top: 20px; font-size: 130% }
      .exlcm { margin-right: 10px; }
      #preloader {
        background-image: url(<?php echo base_url().'assets/images/preloader.gif' ?>);
    }

    #preloader {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 99999;
        width: 100%;
        height: 100%;
        background-color: #fff;
        background-repeat: no-repeat;
        background-position: center center;
    }
  </style>
  <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
  <script type="text/JavaScript">
        $(document).ready(function(){
          var excl=' <div class="pull-left exlcm" style="width: 15px"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></div> &nbsp; ';
          $(".btn-login").click(function() {
            $("#login_form").submit();
          })
          
            $('#email').focus();
      $("#login_form").submit(function() {
                if ($("#email").val()=="" || $("#password").val()==""){
                    $("#box_message").html(excl+'<div class="pull-left">&nbsp; Email atau Password harus diisi!</div><div class="clear"></div>').addClass('alert alert-danger');
                        $("#email").focus();
                    } else {
                        $('#loading').show();
                        $('.btn-lgn').attr('disabled','disabled').html('<div id="preloader" class="enable-preloader"></div>&nbsp; Proses Autentifikasi ...');
            $.ajax({
              type: "POST",
              url: $(this).attr('action'),
              data: $(this).serialize(),
              dataType: "json",
              success: function(msg) {
                                $('#loading').hide();

                                if (parseInt(msg.sign) == 406) {
                                  $("#box_message").html('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> &nbsp;'+msg.text).addClass('alert alert-danger').show();
                  $("#ajaxcaptcha").empty('');
                  $("#ajaxcaptcha").append().html(msg.captcha);
                  $("#cicaptcha").val('');
                  $('.btn-lgn').removeAttr('disabled').html('Login');

                                } else if (parseInt(msg.sign) == 404 || parseInt(msg.sign) == 3) {
                  $("#box_message").html(excl+'<div class="pull-left">'+msg.teks+'</div><div class="clear"></div>').addClass('alert alert-danger').show();
                  $('.btn-lgn').removeAttr('disabled').html('Login');
                  if (msg.captcha !=null) {
                  $("#ajaxcaptcha").empty('');
                  $("#ajaxcaptcha").append().html(msg.captcha);
                  $("#cicaptcha").val('');
                  }
                } else if (parseInt(msg.sign) == 102)  window.location = '<?php echo site_url() ?>'+msg.aplikasi;
                else window.location = '<?php echo site_url() ?>'+msg.aplikasi;
                                
              },
                            error: function(x, t, m) {
                                 $('#loading').hide();
                                if(t==="timeout") {
                                    $("#box_message").html(excl+'<div class="pull-left">Timeout</div><div class="clear"></div>').addClass('alert alert-danger').show();
                                } else {
                                    $("#box_message").html(excl+'<div class="pull-left">'+t+'</div><div class="clear"></div>').addClass('alert alert-danger').show();
                                }
                            }
            });
      
        }
        return false;
        
      });

            $('#loading').hide();   
    });
        </script>


  </head>
  <?php 
  $ok = $this->session->flashdata('ok');
  $fail = $this->session->flashdata('fail');
  
  if (!empty($st['main_color'])) $body_manipulate ='background-color: '.$st['main_color'].';';
  //if ($st['foto_latar_login'] != NULL) $body_manipulate .= 'background-image: url('.base_url().'uploads/backdrop/'.$st['foto_latar_login'].'); background-position: bottom right';
  
  ?>
  
  
  


  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url()?>" class="navbar-brand"><img src="<?php echo base_url().'assets/images/Logo-Undip.png'?>"></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
              
              <!-- <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                </div>
              </form> -->                          
            </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper" style="background: #ccc">
        <div class="container" style="width:80%;background: #fff">

          <div class="login-wrapper">
     
            
      <div class="center-block footer">
        <div class="login-box login-box-ex">
    <!-- login-instansi -->
        
            <div class="login-instansi"><?php 
          
            
          $path_inst_logo = !empty($st['pemerintah_logo']) ? FCPATH.'logo/'.$st['pemerintah_logo'] : null;
          $logo_instansi = (!empty($st['pemerintah_logo'])) ? base_url().'logo/'.$st['pemerintah_logo'] : base_url().'assets/logo/brand.png';
          ?>
              <div class="logo-brand fit-logo">
              </p></div><p class="top-brand">
              Form Login<br>
              <span>Mahasiswa</span>
            </div>
        
            <div class="login-box-body">
            <?php echo form_open('/login/login_process', array('name' => 'login_form ', 'id' => 'login_form'))?>
          <div id="box_message"></div>
          <?php 
          if (!empty($ok)) echo '<div class="alert alert-success"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> &nbsp; '.$ok.'</div>';
          if (!empty($fail)) echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> &nbsp; '.$fail.'</div>';
          ?>
                <div class="form-group has-feedback">
                 <?php echo form_input('username',$this->session->flashdata('welcome'),'class="form-control" id="username"')?>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
              <div class="form-group has-feedback">
                  <?php echo form_password('password',null,'class="form-control" id="password"')?>
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
        <!-- IF CAPTCHA -->
          <?php
          if (!empty($captcha) && $captcha == 1) {
            ?>
              <div class="form-group has-feedback">
              <label>Bukan Robot? <span class="asterix">*</span></label>
                <div>
                 <div class="input-group input-group-lg">
                  <input id="cicaptcha" name="cicaptcha" type="text" class="form-control" placeholder="Masukkan Kode">
                  <span class="input-group-addon"><div id="ajaxcaptcha"><?php echo $cicaptcha_html;?></div></span>
                  </div>
                
                </div>
             </div>
            <?php
          }
           ?>
                      
        <!-- ./CAPTCHA -->

                <div class="form-group has-feedback visible-lg visible-md visible-sm">
               
                    <button type="submit" class="btn btn-success btn-flat btn-lgn pull-left">Login</button>
                    
                 <!--    <a href="<?php echo base_url('daftar_mahasiswa')?>" class="btn btn-danger btn-flat btn-lgn pull-right">Daftar</a> -->
                    <div class="clear"></div>
                    
                </div>
                <div class="row visible-xs">
                <div class="col-md-10 col-md-offset-1">
                  <button type="submit" class="btn btn-success btn-block btn-flat btn-lgn" style="margin-bottom: 20px">Login</button>
                </div>
                </div>
          <?php echo form_close()?>

                <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

                
            </div><!-- /.login-box-body -->
          
        </div><!-- /.login-box -->
      </div>
  </div>



        
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer"  style="background: #3c8dbc">
        <div class="container">
         <!--  <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
          </div> -->
          <strong>Copyright &copy; 2020 <a href="#">UNDIP</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url().'assets/js/lte/jQuery-2.1.4.min.js'?>"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url().'assets/js/lte/bootstrap.min.js'?>" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url().'assets/js/lte/jquery.slimscroll.min.js'?>" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo base_url().'assets/js/lte/fastclick.min.js'?>'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url().'assets/js/lte/app.min.js'?>" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url().'assets/js/lte/demo.js'?>" type="text/javascript"></script>
  </body>
</html>
