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
    <style>
	    #box_message { margin-top: 20px; font-size: 130% }
	    .exlcm { margin-right: 10px; }
	</style>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
	<script type="text/JavaScript">
        $(document).ready(function(){
	        var excl=' <div class="pull-left exlcm"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></div> &nbsp; ';
	        $(".btn-login").click(function() {
		        $("#login_form").submit();
	        })
	        
            $('#email').focus();
            $('#btn-cancel').click(function(){
            	window.location = '<?php echo site_url() ?>login/process_logout';
            });
			$("#ubah_akun").submit(function() {
                if ($("#email").val()=="" || $("#password").val()=="" || $("#cpassword").val()==""){
                    $("#box_message").html(excl+'<div class="pull-left">&nbsp; Password & Konfirmasi Password harus diisi!</div><div class="clear"></div>').addClass('alert alert-danger');
                        $("#email").focus();
                    } else {
                        $('#loading').show();
                        $('.btn-lgn').attr('disabled','disabled').html('<span class="glyphicon glyphicon-cog fa-spin" aria-hidden="true"></span>&nbsp; Proses Autentifikasi ...');
						$.ajax({
							type: "POST",
							url: $(this).attr('action'),
							data: $(this).serialize(),
							dataType: "json",
							success: function(msg) {
                                $('#loading').hide();
								if (parseInt(msg.sign) == 404 || parseInt(msg.sign) == 3) {
									$("#box_message").html(excl+'<div class="pull-left">'+msg.teks+'</div><div class="clear"></div>').addClass('alert alert-danger').show();
									$('.btn-lgn').removeAttr('disabled').html('Login');
								} else if (parseInt(msg.sign) == 102)  window.location = '<?php echo site_url() ?>'+msg.aplikasi;
								else window.location = '<?php echo site_url() ?>'+msg.aplikasi;
                                
							},
                            error: function(x, t, m) {
                                 $('#loading').hide();
                                if(t==="timeout") {
                                    alert("Timeout");
                                } else {
                                    alert(t);
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
  $fail = $this->session->flashdata('fail')
  ?>
  
<body class="login-page" <?php if (!empty($st['main_color'])) echo 'style="background: '.$st['main_color'].'"'; ?>>
    <div class="login-wrapper">
    	<div class="login-drop">
	    	<!-- <img src ="<?php echo base_url().'assets/backdrop/backdrop.jpg'; ?>"/> -->
	    </div>
	         	 
    	<div class="center-block footer">
	    	<div class="login-box login-box-ex">
	 	<!-- login-instansi -->
       			<div class="login-instansi">
					<?php
					$path_inst_logo = !empty($st['pemerintah_logo']) ? FCPATH.'logo/'.$st['pemerintah_logo'] : null;
					$logo_instansi = (file_exists($path_inst_logo) and !empty($st['pemerintah_logo'])) ? base_url().'logo/'.$st['pemerintah_logo'] : base_url().'assets/logo/brand.png';
					?>
	        		<div class="logo-brand "><img src="<?php echo $logo_instansi ?>" /></p></div><p class="top-brand">
	        		<?php if (!empty($st['pemerintah'])) echo $st['pemerintah']; ?><br>
	        		<span><?php echo $st['instansi'] ?></span></p>      
      			</div>
      			<div class="login-box-body">
	     			<?php echo form_open('/login/update_login_akun', array('name' => 'ubah_akun ', 'id' => 'ubah_akun'))?>
		 			<div id="box_message"></div>
				 	<?php 
					if (!empty($ok)) echo '<div class="alert alert-success"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> &nbsp; '.$ok.'</div>';
					if (!empty($fail)) echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> &nbsp; '.$fail.'</div>';
					?>

                  <h5 class="box-title text-danger"><a class="fa fa-info-circle text-danger"></a> Anda Baru Pertama Kali Masuk, Silahkan Ubah Password Terlebih Dahulu !</h5>
             

		            <div class="form-group has-feedback">
		            	<?php echo form_label('Username :', 'l_username'); ?>
			           <?php echo form_input('username',$d_username,'readonly class="form-control" id="email"')?>
		            	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		          	</div>
			        <div class="form-group has-feedback">
		            	<?php echo form_label('Password Baru :', 'l_newpassword'); ?>
			            <?php echo form_password('password',null,'class="form-control" id="password"')?>
			            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			        </div>

			        <div class="form-group has-feedback">
		            	<?php echo form_label('Konfirmasi Password Baru :', 'l_con_newpassword'); ?>
			            <?php echo form_password('cpassword',null,'class="form-control" id="cpassword"')?>
			            <span class="fa fa-check-square form-control-feedback"></span>
			        </div>


		          	<div class="form-group has-feedback visible-lg visible-md visible-sm">
		              	<button type="button" id="btn-cancel" class="btn btn-flat btn-lgn ">Cancel</button>
		              	<button type="submit" class="btn btn-success btn-flat btn-lgn pull-right">Simpan</button>
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
							$logo = (file_exists(FCPATH.'logo/'.$st['aplikasi_logo'])) ? base_url().'assets/logo/'.$st['aplikasi_logo'] : base_url().'assets/logo/logo.png';
						} else {
							$logo = base_url().'assets/logo/logo.png';
						}
					?>
	        		<div class="logo-brand"><img src="<?php echo $logo ?>"/></div>
	        		<?php echo $st['aplikasi_s'] ?>
	        		<p style="line-height: 0.3em;margin-top: 6px;"><small><?php echo $st['aplikasi'] ?></small></p>
      			</div><!-- /.login-logo -->
    		</div><!-- /.login-box -->

    		 <!-- Horizontal Form -->
    		 

			<p class="text-center">&copy; <?php echo $st['copyright'].'. '.$st['aplikasi'].'<br>'.$st['instansi'].(!empty($st['pemerintah'])?', '.$st['pemerintah']:null) ?></p>
	    </div>
	</div>
</body>
</html>
<?php /*

     
*/ ?>