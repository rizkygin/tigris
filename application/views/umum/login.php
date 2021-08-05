<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/fontawesome/5.0/css/fontawesome-all.min.css');?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/adminlte.min.css');?>">
    <!-- custom css: -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">


    <!-- notif -->
    <link href="<?php echo base_url('assets/plugins/gritter/css/jquery.gritter.css');?>" rel="stylesheet" />

    <!-- script -->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
    <script src="<?php echo base_url('assets/dist/js/adminlte.min.js');?>"></script>
    
    <!-- notifications -->
    <script src="<?php echo base_url('assets/plugins/gritter/js/jquery.gritter.js');?>"></script>
    <script src="<?php echo base_url('assets/js/general/ui-modal-notification.demo.js');?>"></script>
    <script src="<?php echo site_url('assets/js/pages/login.js?_='.rand(10,10));?>"></script>
    <!-- ================== END BASE JS ================== -->

</head>
<body class="hold-transition login-page">

    <?php echo form_hidden('base_url', base_url()); ?>
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <div class="login-logo-css m-b-15">
        <div class="login-logo-css-container d-flex align-content-center justify-content-center align-items-center">
            <div class="login-logo-css-text">
                <a><b>PION</b>S</a>
            </div>
            <div class="login-logo-css-circle1">
            </div>
            <div class="login-logo-css-circle2">
            </div>
        </div>
    </div>

    <div class="login-box">
        <div class="card">
            <div class="card-header text-center">
                <i class="fa fa-lock"></i> Login Admin Panel
            </div>
            <div class="card-body login-card-body">
                <form action="<?php echo site_url('login/login_proses');?>" method="POST" class="margin-bottom-0" id="form-login">
                    <div class="form-group m-b-20">
                        <input name="username" type="text" class="form-control form-control-sm" placeholder="Username" required />
                    </div>
                    <div class="form-group m-b-20">
                        <input name="password" type="password" class="form-control form-control-sm" placeholder="Password" required />
                    </div>

                    <div class="login-buttons">
                        <button type="submit" class="btn btn-warning btn-block btn-md">Login</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div class="text-center" style="font-size: 2.1rem;color: #495057;font-weight: 300">
        <span>PROFESIONAL <b>INVENTORY ONLINE STORE</b></span>
    </div>
    <script type="text/javascript">


    </script>
</body>
</html>
