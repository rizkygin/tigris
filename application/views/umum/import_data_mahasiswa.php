<script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/typeahead/typeahead.min.js' ?>"></script>
<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>

<div class="row" id="form-box">
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <i class="fa fa-paint-brush fa-btn"></i>
        <h3 class="box-title" id="form-title"> Import Data Untuk Mahasiswa</h3>
      </div>
      <div class="box-body">
        <div id="form-content">
          <div class="row">
            <div class="col-lg-6">
              <label>Format harus .xls</label>
              <div class="alert alert-confirm">
                <form method="post" enctype="multipart/form-data" action="<?php echo base_url().$form_link?>">
                  <p><label>⚠️ Sesuaikan Format dengan gambar disamping!</label></p>

                  <p><input type="file" name="db_impor" required="required"></p>
                  <p><label>Klik Tombol import ⬇️ untuk memulai proses.</label></p>
                  <p><button name="btn-simpan" type="submit" class="btn btn-import btn-success"><i
                        class="fa fa-cloud-download"></i> Import</button>
                  </p>
                </form>
              </div>
            </div>
            <div class="col-lg-6">
              <label>Contoh Format</label>
                <img src="<?php echo base_url().'assets/images/backdrop.png'?>" alt="contoh format" style="width:100%; height:100%">
            </div>
          </div>
          
        </div>
      </div>
      <div class="overlay on-hide" id="form-overlay">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


</script>