<!-- Content Header (Page header) -->
        <section class="content-header">
                    <h1>
            <?php echo ((!empty($first_title))?$first_title:null).((!empty($b4_title))?$b4_title:null).((!empty($title))?$title:null).((!empty($after_title))?$after_title:null); ?>
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
                    /*if ($this->session->userdata('login_state') != 'root'){
                        echo '<li>'.anchor('home','<i class="fa fa-dashboard"></i>Beranda</a>').'</li>';    
                    }else{
                        echo '<li>'.anchor('','<i class="fa fa-dashboard"></i>').'</li>';
                    } */
                    echo '<li>'.anchor('',
                                '<i class="fa fa-dashboard"> '
                                    .($this->session->userdata('login_state') != 'root'?'Beranda':"")
                            .'</i>').'</li>';
                    foreach($breadcrumb as $bre => $val) 
                        echo "<li>".anchor($bre,$val)."</li>";
                }       
                ?>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row on-hide" id="form-box">
                <div class="col-md-10">
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
           <?php $this->load->view((isset($content)?$content:'dm/standard_view'));?>
        </section>
        <!-- /.content -->