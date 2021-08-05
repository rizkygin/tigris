<?php 

 $st = get_stationer();
 $s = $this->session->userdata('login_state');
 
?>
<!doctype html>
<html>
    <head>
        <title></title>
        <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<style>
p { margin: 0pt; }
table.items {
    border: 0.1mm solid #f4f4f4;
 
}
td { vertical-align: top;   padding:10px !important; }
.items td {
    border-left: 0.1mm solid #f4f4f4;
    border-right: 0.1mm solid #f4f4f4;
    padding:10px !important;
}
table thead td {
    text-align: center;
    border: 0.1mm solid #f4f4f4;
    /*font-variant: small-caps;*/
    padding:5px !important;
}
.items td.blanktotal {
    border: 0.1mm solid #f4f4f4;
    background-color: #FFFFFF;
    border: 0mm none #f4f4f4;
    border-top: 0.1mm solid #f4f4f4;
    border-right: 0.1mm solid #f4f4f4;
    padding:10px !important;
}
.items td.totals {
    text-align: right;
    border: 0.1mm solid #f4f4f4;
    padding:10px !important;
}
.items td.cost {
    text-align: "." center;
    padding:10px !important;
}
</style>
    </head>
    <body>

<?php
$logo_instansi = (!empty($st['pemerintah_logo'])) ? base_url().'assets/logo/'.$st['pemerintah_logo'] : base_url().'assets/logo/brand.png';
    echo '
<htmlpageheader name="header-gb">
<div class="col-lg-12 col-md-12" style="margin-left: -15px;margin-right: -15px;">
 <div class="col-lg-6 col-md-6" style="width:50%;padding: 10px 0px 0px 0px;float:left;position: relative;
    min-height: 1px;margin-top:-20px;">
    <img src="'.$logo_instansi.'" style="height: 45px;float:left;"/>

    <h5 style="margin-left:10px;float:left;color:#4271B7;margin-top:-10px;padding:0px;"><b style="font-size: 12px;float:left;margin-top:-15px;padding:0px;">
    '.$st['pemerintah'].'<br>'.$st['instansi'].'</b></h5>
                </div>
          
<div class="col-lg-6"  style="width:50%;padding: 10px 0px 0px 0px;float:left;position: relative;
    min-height: 1px;">

        <div style="text-align:right;color: #4271B7;margin-top:-25px;">
        <h6 style="font-size:10px;">Jl. Taman Siswa No. 89 Telp/Fax. (0274) 376 623 Yogyakarta 55151<br>
        Website : www.mediamultikaryatama.id<br>E-mail : info@mediamultikaryatama.id</h6></div>
         
   </div>
   <div class="col-lg-12 col-md-12" style="margin-left: -15px;
    margin-right: -15px;"><div style="border-bottom:8px solid #4271B7;margin-top: 10px;"></div></div>
</htmlpageheader>

';
?>





<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm;">
    <div>
    <div style="text-align: left; width: 80%;float:left;">
        <i><?php 
          
        echo $st['aplikasi_s'].' - '.$st['aplikasi'].'/cetak_laporan_hasil_penilaian/'.$no_uji?></i>
        </div>
    <!-- </div>
    <div style="text-align:right;"> -->
        <div style="text-align: right; width: 20%;float:left;">Halaman {PAGENO} dari {nb}</div>
    </div>
</div>
</htmlpagefooter>

<sethtmlpageheader name="header-gb" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
<!-- mpdf -->



<div class="col-lg-12 col-md-12"><div style="width:auto;margin-top: 10px;text-align: center;">
        <h4><u>Laporan Hasil Penilaian Kompetensi</u></h4>
        
        
</div>
<?php echo $tabel;?>


</body>
</html>