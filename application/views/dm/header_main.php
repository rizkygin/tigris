<header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"></span>
          
          <p class="brand-instansi">
          <img src="<?php echo $this->st['logo_instansi'] ; ?>" /></p>
          <span class="logo-lg"><?php echo $this->st['pemerintah'] ?></span>
          <p class="text-instansi"><b><?php echo $this->st['instansi'] ?></b></p>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <a class="logo-i">
          <?php 
            if (!empty($this->st['app'])) {
              if (isset($this->st['aplikasi_logo_only']) and $this->st['aplikasi_logo_only'] == 1) {
              }else{
                  $dir=$this->st['app']['direktori'];
                $app_logo = (!file_exists(base_url('assets/logo/'.$dir.'_th.png')) ?  base_url('assets/logo/'.$dir.'_th.png') : base_url('controller/'.$dir.'/'.$dir.'.png')); 
                ?>
                
                <img src="<?php echo $app_logo ?>"/>
        <?php } ?>
          <span class="logo-lg"><?php echo $this->st['app']['nama_aplikasi'] ?></span>
            <?php } ?>
          </a><!-- Sidebar toggle button-->
            <?php
            $ava = $this->session->userdata('avatar');
          $ava = ($ava != NULL and file_exists('./uploads/kepegawaian/pasfoto/'.$ava))?base_url().'uploads/kepegawaian/pasfoto/'.$ava : base_url().'assets/images/avatar.gif'; 
          $nama = $this->session->userdata('nama');
            ?>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php
                  if(isset($menu_header_kanan))echo $menu_header_kanan;
                  if(!isset($no_user_info))
                  if($this->session->userdata('login_state')){
                ?>
              <li class="dropdown user user-menu">
                <?php if ($this->session->userdata('login_state') == "root") { ?>
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
                <?php if (@$this->st['demo'] == 2) { ?>
                  <!-- Menu Body -->
                      <li class="user-footer">
                      <?php echo anchor(
                            'Home/akun',
                            '<i class="fa fa-lock"></i> Akun &amp; Password',
                            'class="btn btn-default btn-profil pull-left"'); ?>                 
                    </li>
                <?php } ?>
                </ul>
              </li>
                <?php
                  }
                ?>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <?php 
                    /*'<a href="#" data-toggle="control-sidebar"><i class="fa fa-power-off"></i></a>
                    <a href="<?php echo site_url('login/process_logout') ?>" class="btn-off"><i class="fa fa-power-off"></i></a>'*/
                    if (count($this->st['on']['aplikasi']) == 1 or $this->session->userdata('login_state') == "root") { ?>
                        <a href="<?php echo site_url('login/process_logout') ?>" class="btn-off"><i class="fa fa-power-off"></i></a>
                <?php } else { ?>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-power-off"></i></a>
                <?php }  ?>
              </li>
            </ul>
          </div>
        </nav>
      </header>