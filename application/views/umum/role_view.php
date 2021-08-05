<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $st['aplikasi_s'].' - '.$st['aplikasi'] ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/admin-lte.css' ?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/login.css' ?>" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet" type="text/css" />
    
	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>


  </head>
  <?php 
  $ok = $this->session->flashdata('ok');
  ?>
  
<body class="login-page" <?php if (!empty($st['main_color'])) echo 'style="background: '.$st['main_color'].'"'; ?>>
    <div class="login-wrapper">
    	<div class="login-drop">
	    	<!-- <img src ="<?php echo base_url().'assets/backdrop/backdrop.jpg'; ?>"/> -->
	    </div>
	         	 
    	<div class="center-block footer">
			<div class="row">
				
				<?php if (count($role) > 4 and count($role) <= 8 ) { ?>
					<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
				<?php } else if (count($role) > 8 ) { ?>
					<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
				<?php } else { ?>
					<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
				<?php } ?>
					<div class="login-instansi">
						<?php
						$path_inst_logo = !empty($st['pemerintah_logo']) ? FCPATH.'logo/'.$st['pemerintah_logo'] : null;
						$logo_instansi = (file_exists($path_inst_logo) and !empty($st['pemerintah_logo'])) ? base_url().'logo/'.$st['pemerintah_logo'] : base_url().'assets/logo/brand.png';
						?>
						<div class="logo-brand 
						<?php if (isset($st['aplikasi_logo_only']) and $st['aplikasi_logo_only'] == 1) { } else { echo 'fit-logo'; } ?>"><img src="<?php echo $logo_instansi ?>" /></p></div>
						<p class="top-brand"><?php echo $st['pemerintah'] ?><br>
						<span><?php echo $st['instansi'] ?></span></p>
					</div>
					
					<div class="row" style="background: #fff; padding: 1% 0">
						
						<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
						
						<?php 
						if (count($role) > 4) echo '<div class="row"><div class="row">';
						foreach($role as $v) { 
							$ava = !file_exists('./assets/logo/'.$v['dir'].'.png') ? base_url().'assets/logo/logo.png' : base_url().'assets/logo/'.$v['dir'].'.png'; ?>
							
							
							<?php 
							
							if (count($role) > 4 and count($role) <= 8 ) echo '<div class="col-lg-6 col-md-6">';
							else if (count($role) > 8) echo '<div class="col-lg-4 col-md-4">';
							?>
						
							
							<div class="row role-paging">
								<a href="<?php echo (isset($v['link']))?$v['link'] : site_url('home/aplikasi/'.$v['dir']) ?>">
									<div class="col-lg-3 col-sm-4 col-xs-4">
										<div style="background: <?php echo $v['warna'] ?>; border-radius: 0px;" class="role-iconic">
											<img src="<?php echo $ava ?>">
										</div>
										<div class="clear"></div>
									</div>
									<div class="col-lg-9 col-sm-8 col-xs-8">
									<p class="role-head">
										<?php echo $v['aplikasi'] ?><br>
										<small style="font-weight: 800;">
											<?php echo $v['role'] ?>
										</small></p>
									</div>
								</a>
							</div>
							
							<?php if (count($role) > 4) echo '</div>'; ?>
							
							<?php } 
							if (count($role) > 4) echo '</div></div>'; ?>
							
						</div>
	   
						<div class="clear text-center box-btn-keluar"><?php echo anchor('login/process_logout','<i class="fa fa-power-off"></i> &nbsp; Keluar Aplikasi','class="btn btn-danger btn-flat btn-lg"') ?></center>
						</div>
						</div>
      			</div>
			</div><!-- /.login-box-body -->
      			<div class="login-logo
				<?php if (isset($st['aplikasi_logo_only']) and $st['aplikasi_logo_only'] == 1) { } else { echo 'fit-logo'; } ?>">
	        			<?php
						if (!empty($st['aplikasi_logo'])) {
							$logo = (file_exists(FCPATH.'logo/'.$st['aplikasi_logo'])) ? base_url().'logo/'.$st['aplikasi_logo'] : base_url().'assets/logo/logo.png';
						} else {
							$logo = base_url().'assets/logo/logo.png';
						}
					?>
					<div class="logo-brand"><img src="<?php echo $logo ?>"/></div>
					<?php
	        		echo '<span style="line-height:35px;">'.$st['aplikasi_s'].'<span>' ?>
	        		<p style="line-height: 0.3em;margin-top: 6px;"><small><?php echo $st['aplikasi'] ?></small></p>
      			</div><!-- /.login-logo -->
    		</div><!-- /.login-box -->
			<p class="text-center">&copy; <?php echo $st['copyright'].'. '.$st['aplikasi'].'<br>'.$st['instansi'].', '.$st['pemerintah'] ?></p>
	    </div>

</body>
</html>
			
<style type="text/css">
<!--
.login-box-ex {
  margin: 1% auto 0;
  max-width: 98%;
  min-width: 320px;
  
  <?php echo $wd;?>;/*98%*/
}
.role-iconic {
    -webkit-border-radius: 5px;
    border-radius: 5px;
	float: right;
}

.role-paging {
    margin: 10px 0;
}
.role-head {
    color: #555;
    font-size: 2.4em;
    padding: 5px 5px 5px 15px;
    line-height: 0.8em;
    letter-spacing: -1px;
    float: left;
}
.kotakan{
    margin: 5px 0;
    min-width: 320px;
    float: left;
}

-->
</style>
