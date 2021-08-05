
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
    </style>
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
              <ul class="nav navbar-nav"><!-- 
                <li><a href="#">Syarat Ijuan Tesis <span class="sr-only">(current)</span></a></li> -->
                <li class="active"><a href="<?php echo base_url('login_mahasiswa')?>" style="background:rgb(108 226 0);color:#000;border-radius: 12px;padding:10px">Login</a></li>
                <!-- <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li> -->
              </ul>
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
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
         <!--  <section class="content-header">
            <h1>
              Top Navigation
              <small>Example 2.0</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Dashboard</li>
            </ol>
          </section> -->

          <!-- Main content -->
          <section class="content">

            <div class="col-md-12">
              <!-- Custom Tabs (Pulled to the right) -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                  <li><a href="#tab_4" data-toggle="tab">Tesis</a></li>
                  <!-- <li><a href="#tab_3" data-toggle="tab">Seminar Hasil Penelitian</a></li> -->
                  <li><a href="#tab_2" data-toggle="tab">Proposal Tesis</a></li>
                  <li class="active"><a href="#tab_1" data-toggle="tab">Pengajuan Judul</a></li>
                  <li class="pull-left header"><i class="fa fa-th"></i> Syarat-syarat</li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <p><?php echo $tab_1;?></p>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    <p><?php echo $tab_2;?></p>
                  </div><!-- /.tab-pane -->
                  <!-- <div class="tab-pane" id="tab_3">
                    <p><?php// echo $tab_3;?></p>
                  </div>/.tab-pane -->
                  <div class="tab-pane" id="tab_4">
                    <p><?php echo $tab_4;?></p>
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div>

          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
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
