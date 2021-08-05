<?php 
/**
* v.2.53
*/
 $this->st = app_param();#get_stationer();
 $this->st['debug']=1;
 $path_inst_logo = !empty($this->st['pemerintah_logo']) ? FCPATH.'logo/'.$this->st['pemerintah_logo'] : null;
 $this->st['logo_instansi'] = (file_exists($path_inst_logo) and !empty($this->st['pemerintah_logo'])) ? base_url().'logo/'.$this->st['pemerintah_logo'] : base_url().'assets/logo/brand.png';
// cek($this->st);
 //$s = $this->session->userdata('login_state'); 
 $this->st['on'] = cget_role($this->session->userdata("id_pegawai"));
 $dircut = !empty($dircut) ? $dircut : $this->uri->segment(1);
 $this->st['app'] = @$this->st['on']['aplikasi'][$dircut];
?>
<!DOCTYPE html>
<html>
  <head>
  <?php 
    $this->load->view(isset($head_main)?$head_main:'dm/head_main');
    $this->load->view(isset($script_main)?$script_main:'dm/script_main');
  ?>
  </head>
  
  <body class="skin-blue sidebar-mini <?php if (isset($collapse)) echo 'sidebar-collapse'; echo $this->st['aplikasi_code'] ?>">
	  <?php if(isset($after_body))echo $after_body;?>
      
    <div class="wrapper">
      
      <?php
        $this->load->view(isset($header_main)?$header_main:'dm/header_main');
      ?>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar" >
        <div class="user-panel hidden-xs">
            <div class="pull-left image">
              <img src="<?php echo$this->st['logo_instansi'] ?>" alt="<?php echo $this->st['instansi'] ?>" />
            </div>
            <div class="pull-left info">
              <p><?php echo $this->st['instansi_code'] ?></p>
            </div>
          </div>
        <!-- sidebar: style can be found in sidebar.less -->
        <?php
          $this->load->view(isset($sidebar_main)?$sidebar_main:'dm/sidebar_main');
        ?>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <?php
            $this->load->view(isset($content_main)?$content_main:'dm/content_main');
        ?>
        
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <?php
          $this->load->view(isset($footer_main)?$footer_main:'dm/footer_main');
        ?>
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
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->
    <!-- Modal -->
<div class="modal fade" id="modal-profil" tabindex="-1" role="dialog" aria-hidden="true"></div>
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
  <form id="form_modal_dialog" action="">
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
      </form>
</div>


<?php 
#c_($this->st['app']);
#if (is_array($this->st['app']) &&  count($this->st['app']) > 1) { 
if(count($this->st['on']['aplikasi'])>1){ ?>
<aside class="control-sidebar control-sidebar-dark">                
        <!-- Create the tabs -->
        
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div id="control-sidebar-settings-tab" class="tab-pane active">
            <h3 class="control-sidebar-heading">
				<div class="logo-brand">
                <?php
                $in_f=this_folder();
                $dir=$in_f->folder;
                $aset_logo='assets/logo/'.$dir.'_th.png';
                $folder_logo='controller/'.$dir.'/'.$dir.'.png';
                $app_logo = (!file_exists(base_url($aset_logo)) ?  base_url($aset_logo) : base_url($folder_logo)); 
                ?>
				<img src="<?php echo $app_logo; ?>" width="50px"/>
	        		<?php echo $in_f->nama_aplikasi; ?>
	        		<p><small><?php echo $in_f->deskripsi; ?></small></p>
				</div>
			</h3>
            <p class="text-right">
            <a href="<?php echo site_url('Login/role_choice') ?>" class="btn btn-warning"><i class="fa fa-recycle fa-btn"></i> Aplikasi</a>&nbsp;
            <?php echo anchor('Login/process_logout','<i class="fa fa-power-off"></i> &nbsp; Logout','class="btn-off btn btn-danger"'); ?>
            </p>
            <?php 
            if ( function_exists('get_doc_app')&& $doc=get_doc_app($dir)){ ?>
			<p class="text-right">
            <a target="_blank" href="<?php echo base_url('uploads/doc/'.$doc) ?>" class="btn btn-default"><i class="fa fa-info fa-btn"></i> Modul Aplikasi</a>
            </p>
            <?php }else{ ?>
            <h5>Pindah Aplikasi</h5>
            <?php } ?>
            <ul class="control-sidebar-menu">
	          <?php 
              foreach($this->st['on']['aplikasi'] as $k => $v)
		      if ($v['direktori'] != $this->uri->segment(1)) {
	          ?>
              <li>

                <a href="<?php echo site_url('Home/aplikasi/'.$v['direktori']); ?>">
	              <div class="menu-icon" <?php echo 'style="background: '.$v['warna'].'"'; ?>>
		              
					  <?php $ava_app = (file_exists('./assets/logo/'.$v['direktori'].'_th.png')? $v['direktori'].'_th.png':'logo.png'); ?>
		              <img src="<?php echo base_url().'assets/logo/'.$ava_app ?>" style="width: 26px;"/>
	     
		              
	              </div>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading"><?php echo $v['nama_aplikasi'] ?></h4>
                    <p><?php echo $v['nama_role'] ?></p>
                  </div>
                </a>
              </li>
              <?php } ?>
           </ul><!-- /.control-sidebar-menu -->
          </div>
 
          
        </div>
      </aside>
<?php } 
    #if(function_exists('set_bc'))set_bc(uri_string(),$title);
?>

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
    
</body>
</html>
