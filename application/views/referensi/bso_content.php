
<?php if (count($pegawai) > 0) { 

$img =  (file_exists('./uploads/kepegawaian/pasfoto/'.$pegawai->photo)) ? "<img src='".base_url().'uploads/kepegawaian/pasfoto/'.$pegawai->photo."' class='bsoimg'>" : "<img src='".base_url()."assets/images/avatar.gif' class='bsoimg' style='margin: -5px -5px'/>";

?>
<div class='bsoimgbox'><?php if (!empty($pegawai->photo)) echo $img; ?></div>

<?php $orr = (strlen($pegawai->nama_pegawai) > 25) ? 'style="top: 53px; padding-top: 2px"' : null ?>

<div class="bsotext" <?php echo $orr ?>>
<?php echo $pegawai->nama_pegawai?><br/>
<?php echo $pegawai->nip.'<br>'.$pegawai->golongan.' - '.$pegawai->pangkat?>
</div>
<div class="bsojudul-on"><?php echo $pegawai->nama_jabatan ?></div>
<?php } ?>

