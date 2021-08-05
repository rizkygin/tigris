<?php 

 $st = get_stationer();
 $s = $this->session->userdata('login_state');
 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $st['aplikasi_s'].' - '.$st['aplikasi'] ?></title>
<style type="text/css">
.by{
  vertical-align: bottom;
  height: 34px;
  border: 1px rgba(191, 191, 191, 0.6) solid;
}
</style>
<link href="<?php echo base_url('assets/plugins/gritter/css/jquery.gritter.css');?>" rel="stylesheet" />
  <link href="<?php echo base_url().'assets/plugins/timepicker/bootstrap-timepicker.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
  <link href="<?php echo base_url().'assets/css/admin-lte.css' ?>" rel="stylesheet">
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url().'assets/css/skins.css' ?>" rel="stylesheet">
  <link href="<?php echo base_url().'assets/css/general.css' ?>" rel="stylesheet">
  <link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
  <link href="<?php echo base_url().'assets/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker-bs3.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/plugins/select2/select2.css' ?>" rel="stylesheet" type="text/css" />
  <!-- <link href="<?php echo base_url().'assets/plugins/select2/select2.min.css' ?>" rel="stylesheet" type="text/css" /> -->

  <!-- Data Tables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>"/>

  <link href="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/js/app.min.js'?>"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/timepicker/bootstrap-timepicker.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/select2/select2.js' ?>"></script>
  
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.js' ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.date.extensions.js' ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.extensions.js' ?>" ></script>
  
  <script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>

  <script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>

  <!-- Data Tables -->
  <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script> 
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   <link href="<?php echo base_url().'assets/bootstrap/css/datetimepicker.css' ?>" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="<?php echo base_url('assets/plugins/daterangepicker/moment.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url('assets/plugins/tinymce/js/tinymce/tinymce.js'); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap-datetimepicker.js'); ?>"></script>

  <link href="<?php echo base_url().'assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css'?>" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="<?php echo base_url().'assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js' ?>"></script>

      <script type="text/javascript" src="<?php echo base_url().'assets/js/highcharts.js'?>"></script>
      <!-- <script type="text/javascript" src="<?php echo base_url().'assets/FusionChartsFree/JSClass/FusionCharts.js'?>"></script> -->
      
    <script src="<?php echo base_url('assets/plugins/gritter/js/jquery.gritter.js');?>"></script>

     <script type="text/javascript">
    $(function() {
      var x;
      setInterval(function() {
    
        if(x == 0) { 
          $('.blink').removeAttr('style'); x = 2;
        } else  {
          if (x = 2) { 
            $('.blink').css('visibility', 'hidden'); 
            x = 0; 
          }
        }
        
      }, 500);
    });
    </script>

    
  </head>
  
  
  <body class="skin-blue sidebar-mini <?php if (isset($collapse)) echo 'sidebar-collapse' ?>">
    <?php 

    $on = get_role($this->session->userdata("id_pegawai"));
    $dircut = !empty($dircut) ? $dircut : $this->uri->segment(1);
    $app = @$on['aplikasi'][$dircut];
  
    $username = $this->session->userdata('username');
    $nama = $this->session->userdata('nama');
    $id_operator = $this->session->userdata('id');

    ?>
    
    
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"></span>
      <?php
      $path_inst_logo = !empty($st['pemerintah_logo']) ? FCPATH.'logo/'.$st['pemerintah_logo'] : null;
      $logo_instansi = (file_exists($path_inst_logo) and !empty($st['pemerintah_logo'])) ? base_url().'logo/'.$st['pemerintah_logo'] : base_url().'assets/logo/brand.png';
      ?>
          <p class="brand-instansi">
      <img src="<?php echo $logo_instansi ?>" /></p>
          <span class="logo-lg"><?php echo $st['pemerintah'] ?></span>
          <p class="text-instansi"><b><?php echo $st['instansi'] ?></b></p>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
        <a class="logo-i">
          <?php 
            if (!empty($app)) {
              if (isset($st['aplikasi_logo_only']) and $st['aplikasi_logo_only'] == 1) {
              }else{
                $app_logo = !file_exists('./assets/logo/'.$app['direktori'].'.png') ? base_url().'assets/logo/logo.png' : base_url().'assets/logo/'.$app['direktori'].'.png'; ?>
                <img src="<?php echo $app_logo ?>"/>
        <?php } ?>
          <span class="logo-lg"><?php echo $app['nama_aplikasi'] ?></span>
      <?php } ?>
        </a><!-- Sidebar toggle button-->
      <?php
          $ava = $this->session->userdata('avatar');
          $ava = ($ava != NULL and file_exists('./uploads/kepegawaian/pasfoto/'.$ava))?base_url().'uploads/kepegawaian/pasfoto/'.$ava : base_url().'assets/images/avatar.gif'; 
          $nama = $this->session->userdata('nama');
      ?>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
        <?php if (@$s == "root") { ?>
         <a>
                  <img src="<?php echo $ava; ?>" class="user-image"/>
                  <span class="hidden-xs">Root</span>
                </a>
        <?php } else { ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <div class="user-image">
                  <img src="<?php echo $ava; ?>" alt="<?php echo $nama ?>"/>
                </div>
                  <span class="hidden-xs"><?php echo $nama?></span>
                  <span class="clear"></span>
                </a>
        <?php } ?>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                     <div class="img-circle">
                      <img src="<?php echo $ava ?>" alt="<?php echo $nama  ?>" />
                     </div>
                    <p><?php echo $nama ?></p>
                  </li>
                  <li class="user-body">
                    <div class="text-center">
                      <?php echo $this->session->userdata('nama_role');?>
                    </div>
                  </li>
        <?php if (isset($st['demo']) and $st['demo'] == 2) { ?>
                  <!-- Menu Body -->
            <li class="user-footer">
                      <?php echo anchor(
                        'home/akun',
              '<i class="fa fa-lock"></i> Akun &amp; Password',
              'class="btn btn-default btn-profil pull-left"'); ?>        
          </li>
        <?php } ?>
                </ul>
              </li>
  
              <!-- Control Sidebar Toggle Button -->
              <li>
        <?php 
        if (count($on['aplikasi']) == 1 or $s == "root") { ?>
        <a href="<?php echo site_url('login/process_logout') ?>" class="btn-off"><i class="fa fa-power-off"></i></a>
        <?php } else { ?>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-power-off"></i></a>
        <?php } ?>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar" >
        <div class="user-panel hidden-xs">
            <div class="pull-left image">
              <img src="<?php echo $logo_instansi ?>" alt="<?php echo $st['instansi'] ?>" />
            </div>
            <div class="pull-left info">
              <p><?php echo $st['instansi_code'] ?></p>
            </div>
          </div>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <ul class="sidebar-menu" style="margin-bottom:130px;">
      
      <?php
      
      if ($s == "root") {
        
        $this->load->view('umum/rootnav_view');
        
      } else { ?>

        <li><?php echo anchor($app['direktori'].'/home','<i class="fa fa-home"></i> <span>Beranda</span>') ?></li>
      <?php 
      $id_peg = $this->session->userdata('id_pegawai');
      if ($app['direktori'] == 'referensi') get_ref_nav($id_peg);
      else get_nav($id_peg,1,$app['id_aplikasi']);
      }
      ?></ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
                  <h1>
            <?php echo (!empty($title))?$title:null; ?>
            <?php echo (!empty($descript)) ? '<small>'.$descript.'</small>' : null; ?>
          </h1>
          
            <?php  
          $warning = $this->session->userdata('peringatan');
            if (!empty($warning) and count($warning) > 0) {
              echo '<div class="alert alert-danger alert-dismissable" style="margin-top: 10px">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-ban"></i> Peringatan! </h4>';
                    foreach($warning as $w) {
                      echo '<p>'.$w.'</p>';          
                    }
                    echo '</div>'; 
                } 
                
                $ok = $this->session->flashdata('ok');
                $fail = $this->session->flashdata('fail');
                $msg = array();
                if (!empty($ok)) {
                  $msg['head'] = 'Pesan';
                  $msg['box'] = 'alert-success';
                  $msg['icon'] = 'fa-check';
                  $msg['pesan'] = $ok;
                }
                
                if (!empty($fail)) {
                  $msg['head'] = 'Peringatan';
                  $msg['box'] = 'alert-danger';
                  $msg['icon'] = 'fa-ban';
                  $msg['pesan'] = $fail;
                }
                
                
                if (!empty($msg)) {
                ?>
                <div class="alert <?php echo $msg['box'] ?> alert-dismissable" style="margin-top: 10px">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa <?php echo $msg['icon'] ?>"></i> <?php echo $msg['head'] ?></h4><p><?php echo $msg['pesan'] ?></p></div> 
        <?php } ?>
          <ol class="breadcrumb">
                <?php
                if (isset($breadcrumb)) {
        if ($s != 'root') echo '<li>'.anchor('home','<i class="fa fa-dashboard"></i>Beranda</a>').'</li>';
        else echo '<li>'.anchor('','<i class="fa fa-dashboard"></i>').'</li>';
                foreach($breadcrumb as $bre => $val) {
                    echo "<li>".anchor($bre,$val)."</li>";
                }
                }       
                ?>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row on-hide" id="form-box">
            <div class="col-md-12">
              <div class="box box-warning">
            <div class="box-header with-border">
              <i class="fa fa-paint-brush fa-btn"></i><h3 class="box-title" id="form-title"> Judul Form</h3>
            </div>
              <div class="box-body">
              <div id="form-content"> <p> Memuat Konten dari Form ... </p></div>
              </div>
            <div class="overlay on-hide" id="form-overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
              </div>
            </div>
          </div>
           <?php if(@$content)$this->load->view($content);?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versi</b> 1.0
        </div>
        &copy; <?php echo $st['copyright'] ?> | <a href="http://www.mediamultikaryatama.id">CV. Media Multi Karyatama</a>.</strong>
      </footer>
      
      <!-- Control Sidebar -->      
      <aside class="control-sidebar control-sidebar-dark">                
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content"></div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->
    <!-- Modal -->
<div class="modal fade" id="modal-profil" tabindex="-1" role="dialog" aria-hidden="true"></div>
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" aria-label="Close" data-dismiss="modal" type="button">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title form-title"><i class="fa fa-trash"></i> &nbsp; Konfirmasi Hapus</h4>
      </div>
        <div class="modal-body"><span class="form-delete-msg"></span></div>
        <div class="modal-footer">
    <button class="btn btn-default pull-left" data-dismiss="modal" type="button">Batal</button>
    <a class="form-delete-url"><button class="btn btn-danger" type="button">Hapus</button></a>
    <a class="form-delete-btn" style="display: none"><button class="btn btn-danger" type="button">Hapus</button></a>
    </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="alert alert-system-switch alert-dismissable alert-dialog" style="margin: 0 auto;">
           <button class="close" aria-label="Close" data-dismiss="modal" type="button">
    <span aria-hidden="true">×</span>
    </button>
            <h4 class="alert-icon"></h4>
            <p class="alert-message"></p>
             <span aria-label="Close" data-dismiss="modal" id="modal-alert-btn" class="btn btn-success btn-outline btn-sm pull-right">
    &nbsp;&nbsp; OK &nbsp;&nbsp;</span>
    <div class="clear"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
  
  
    function varian(hex, lum) {

    // validate hex string
    hex = String(hex).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
      hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
    }
    lum = lum || 0;
  
    // convert to decimal and change luminosity
    var rgb = "#", c, i;
    for (i = 0; i < 3; i++) {
      c = parseInt(hex.substr(i*2,2), 16);
      c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
      rgb += ("00"+c).substr(c.length);
    }
  
    return rgb;
  }
  $(document).ready(function() {
    $('.skin-blue .sidebar-menu > li.active > a').css('border-left-color',varian('<?php echo $st['main_color'] ?>',0.2)); 
    $('.skin-blue .main-header .navbar').css('background-color','<?php echo $st['main_color'] ?>');
    $('.skin-blue .main-header .logo ').css('background-color',varian('<?php echo $st['main_color'] ?>',-0.3)); 
  });
  </script>
  
</body>
</html>
<script>
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1){
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
        if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function checkCookie(){
    waktuy=getCookie("waktux");
    if (waktuy!=null && waktuy!=""){
        waktu = waktuy;
    }else{
    waktu = waktunya;
    setCookie("waktux",waktunya,7);
    }
}
</script>