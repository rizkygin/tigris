
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
  
  
  
<body class="login-page" style="<?php echo $body_manipulate ?>">
<!-- <div id="preloader" class="enable-preloader"></div> -->

    <div class="login-wrapper">
    	<div class="login-drop" <?php if (isset($st['foto_latar_login']) and $st['foto_latar_login'] != NULL) echo 'style="background-image: url('.base_url().'uploads/backdrop/'.$st['foto_latar_login'].'); background-position: bottom right"' ?>>
	    </div>
	          
    	<div class="center-block footer">
	    	<div class="login-box login-box-ex">
	 	<!-- login-instansi -->
				
       			<div class="login-instansi"><?php 
					
						
					$path_inst_logo = !empty($st['pemerintah_logo']) ? FCPATH.'logo/'.$st['pemerintah_logo'] : null;
					$logo_instansi = (!empty($st['pemerintah_logo'])) ? base_url().'uploads/logo/'.$st['pemerintah_logo'] : base_url().'assets/logo/brand.png';
					?>
	        		<div class="logo-brand fit-logo"><img src="<?php echo $logo_instansi ?>" /></p></div><p class="top-brand">
	        		<?php if (!empty($st['pemerintah'])) echo $st['pemerintah']; ?><br>
	        		<span><?php echo $st['instansi'] ?></span></p>
					
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
		              	<button type="submit" class="btn btn-success btn-flat btn-lgn">Login</button>
		            </div>
		          	<div class="row visible-xs">
			         	<div class="col-md-10 col-md-offset-1">
		          		<button type="submit" class="btn btn-success btn-block btn-flat btn-lgn" style="margin-bottom: 20px">Login</button>
			         	</div>
		           	</div>
 					<?php echo form_close()?>
      			</div><!-- /.login-box-body -->
      			<div class="login-logo">
					<?php
						if (!empty($st['aplikasi_logo'])) {
							$logo = (file_exists(FCPATH.'logo/'.$st['aplikasi_logo'])) ? base_url().'logo/'.$st['aplikasi_logo'] : base_url().'assets/logo/logo.png';
						} else {
							$logo = base_url().'assets/logo/logo.png';
						}
						
					?>
	        		<div class="logo-brand 
					<?php if (isset($st['aplikasi_logo_only']) and $st['aplikasi_logo_only'] == 1) { } else { echo 'fit-logo'; } ?>">
					<img src="<?php echo $logo ?>"></div>
	        		<?php 
					if (isset($st['aplikasi_logo_only']) and $st['aplikasi_logo_only'] == 1) {
					} else {
					echo $st['aplikasi_s'] ?>
	        		<p style="line-height: 0.3em;margin-top: 6px;"><small><?php echo $st['aplikasi'] ?></small></p>
					<?php } ?>
      			</div><!-- /.login-logo -->
    		</div><!-- /.login-box -->
			<p class="text-center">&copy; <?php echo $st['copyright'].'. '.$st['aplikasi'].'<br>'.$st['instansi'].(!empty($st['pemerintah'])?', '.$st['pemerintah']:null) ?></p>
	    </div>
	</div>
</body>
</html>
<?php /*

     
*/ ?>