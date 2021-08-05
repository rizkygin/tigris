<?php 
$app = $this->session->userdata('aplikasi'); 

?>

<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-purple"><i class="fa fa-desktop"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Aplikasi</span>
          <span class="info-box-number"><?php echo count($this->session->userdata('app_active')) ?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-shield"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Kewenangan</span>
          <span class="info-box-number"><?php echo $kewenangan ?>
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Operator</span>
          <span class="info-box-number"><?php echo $operator ?>
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    
  </div>

<div class="row">
	<div class="col-lg-4">
		<div class="box">
	        <div class="box-header">
	        <h3 class="box-title">Referensi Umum</h3>
	        </div><!-- /.box-header -->
	        <div class="box-body no-padding">
		      <?php 
			      $no = 1;
			    $this->table->set_template(array('table_open'=>'<table class="table table-condensed"'));
				$this->table->add_row(
					array('data' => $no,'width' => 20),
					'Pejabat Penetap',
					array('data' => '<span class="badge bg-green">'.$penetap.'</span>','width' => 40));
				$this->table->add_row($no+=1,'Propinsi','<span class="badge bg-green">'.$propinsi.'</span>');
				$this->table->add_row($no+=1,'Kabupaten','<span class="badge bg-green">'.$kabupaten.'</span>');
				$this->table->add_row($no+=1,'Kecamatan','<span class="badge bg-green">'.$kecamatan.'</span>');
				$this->table->add_row($no+=1,'Kelurahan','<span class="badge bg-green">'.$kelurahan.'</span>');
				echo $this->table->generate();
			   ?>
	        </div>
	      </div>
	</div>
	
	<div class="col-lg-4">
		<div class="box">
	        <div class="box-header">
	        <h3 class="box-title">Referensi Personal</h3>
	        </div><!-- /.box-header -->
	        <div class="box-body no-padding">
		      <?php 
			      $no = 1;
			    $this->table->set_template(array('table_open'=>'<table class="table table-condensed"'));
				$this->table->add_row(
					array('data' => $no,'width' => 20),
					'Jenis Kelamin',
					array('data' => '<span class="badge bg-blue">'.$jkel.'</span>','width' => 40));
				$this->table->add_row($no+=1,'Golongan Darah','<span class="badge bg-blue">'.$gol.'</span>');
				//$this->table->add_row($no+=1,'Keluarga','<span class="badge bg-blue">'.$kel.'</span>');
				//$this->table->add_row($no+=1,'Status Keluarga','<span class="badge bg-blue">'.$status_kel.'</span>');
				//$this->table->add_row($no+=1,'Status Anak','<span class="badge bg-blue">'.$status_anak.'</span>');
				//$this->table->add_row($no+=1,'Pekerjaan','<span class="badge bg-blue">'.$pekerjaan.'</span>');
				echo $this->table->generate();
			   ?>
	        </div>
	      </div>
	</div>
	
	
	<div class="col-lg-4">
		<div class="box">
	        <div class="box-header">
	        <h3 class="box-title">Referensi Formal</h3>
	        </div><!-- /.box-header -->
	        <div class="box-body no-padding">
		      <?php 
			      $no = 1;
			     $this->table->set_template(array('table_open'=>'<table class="table table-condensed"'));
				$this->table->add_row(
					array('data' => $no,'width' => 20),
					'Unit Kerja / SKPD',
					array('data' => '<span class="badge bg-red">'.$unit.'</span>','width' => 40));
				$this->table->add_row($no+=1,'Unit Organisasi / Bidang-Sub Bidang','<span class="badge bg-red">'.$bidang.'</span>');
				$this->table->add_row($no+=1,'Golongan Ruang / Pangkat','<span class="badge bg-red">'.$golru.'</span>');
				$this->table->add_row($no+=1,'Jabatan','<span class="badge bg-red">'.$jabatan.'</span>');			
echo $this->table->generate();
			   ?>
	        </div>
	      </div>
	</div>
</div>