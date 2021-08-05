<fieldset><legend><h3>Referensi Kode Barang</h3>
<?php echo  form_button('btn_tambah_barang','<i class="fa fa-plus"></i>  Barang','class="btn btn-flat btn-success btn-edit pull-right" act="'.site_url('referensi/barang/form_barang').'"')?>
<div class="clear"></div>
</legend>
<?php if (!empty($ok)) echo '<div class="alert alert-success">'.$ok.'</div>'; ?>
<div class="container-fluid">
<?php echo $tabel_reg?>
</div>
</fieldset>