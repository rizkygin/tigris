<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*  mr.febri@gmail.com
*  ci.213
*  v.01
*/

if ( ! function_exists('msg')):
function msg($kode){
    switch($kode){
        case "elogin":$msg="Silahkan login ulang. Data yang anda inputkan tidak terdaftar";break;
        case "datakurang":$msg="Silahkan lengkapi data di atas";break;
        case "hapusok":$msg="Data %s berhasil di hapus";break;
        case "hapusnotok":$msg="Data %s tidak berhasil di hapus";break;
        case "simpanok":$msg="Data telah berhasil di simpan";break;
        case "simpannotok":$msg="Data tidak berhasil di simpan";break;
        case "greeny":$msg="";break;//<div class=greeny >Data telah berhasil di simpan</div>
        case "rederr":$msg="<div class=rederr ></div>";break;
        case "404":$msg="Data tidak ada";break;
        default: $msg=""; 
    }
    return $msg;
}
endif;

if ( ! function_exists('show_loading')):
function show_loading(){
    return span(span(' .. Proses, Tunggu ..','style="font-size:8pt;color:#000;"').span(img('images/loading2.gif')), 'id="loading"');
}
endif;

if ( ! function_exists('ld_err')):
function ld_err($kode,$jenis='M',$nama='',$func='',$param=''){
    return "Terdapat kesalahan dengan kode ".($kode?$kode:$jenis.$nama.$func."-".$param).", Silahkan laporkan programmer yang bersangkutan";
}
endif;

if ( ! function_exists('icon_i')):
function icon_i($kode,$iswhite=0,$nobtn=''){
$clasbtn_h=($nobtn?'':'class="btn btn-mini"');
$clasbtn_m=($nobtn?'':'btn btn-mini');
$clasiswhite=($iswhite?' icon-white':'');
$i_ico1="<i class='icon";
$i_ico2="'></i>";

 $aicon_i=array(
    'eye' =>span($i_ico1.$clasiswhite." icon-eye-open".$i_ico2,$clasbtn_h),
    'book' =>span($i_ico1.$clasiswhite." icon-book".$i_ico2,$clasbtn_h),
    'rep' =>span($i_ico1.$clasiswhite." icon-repeat".$i_ico2,$clasbtn_h),
    'prn' =>span($i_ico1.$clasiswhite." icon-print".$i_ico2,$clasbtn_h),
    'pen' =>span($i_ico1.$clasiswhite." icon-pencil".$i_ico2,$clasbtn_h),
    'del' =>span($i_ico1.$clasiswhite." icon-trash".$i_ico2,($nobtn?'':'class="btn btn-mini btn-danger"')),
    'lst' =>span($i_ico1.$clasiswhite." icon-list-alt".$i_ico2,$clasbtn_h),
    'tag' =>span($i_ico1.$clasiswhite." icon-tag".$i_ico2,$clasbtn_h),
    'cek' =>span($i_ico1.$clasiswhite." icon-check".$i_ico2,$clasbtn_h),
    'shr' =>span($i_ico1.$clasiswhite." icon-share".$i_ico2,$clasbtn_h),
    'cmt' =>span($i_ico1.$clasiswhite." icon-comment".$i_ico2,$clasbtn_h),
    'up'  =>span($i_ico1.$clasiswhite." icon-upload".$i_ico2,$clasbtn_h),
    'dn'  =>span($i_ico1.$clasiswhite." icon-download".$i_ico2,$clasbtn_h),
    'num'  =>span($i_ico1.$clasiswhite." icon-picture".$i_ico2,$clasbtn_h),
    'file'  =>span($i_ico1.$clasiswhite." icon-file".$i_ico2,$clasbtn_h),
    'ok'  =>span($i_ico1.$clasiswhite." icon-ok".$i_ico2,($nobtn?'':'class="btn btn-mini btn-success"')),
    'banc'=>span($i_ico1.$clasiswhite." icon-ban-circle".$i_ico2,($nobtn?'':'class="btn btn-warning add-on"')),
    'rmv' =>span($i_ico1.$clasiswhite." icon-remove".$i_ico2,($nobtn?'':'class="btn btn-danger add-on"')),
 );
    return $aicon_i[$kode];}
endif;

if ( ! function_exists('expload_memo_dispo')):
function expload_memo_dispo($data="",$outputform=1){
    $amsg=array(1=>'Koordinasikan','Buat','Arsipkan','Buat Telaahan Staf');
//    $klik=" onclick='$(\"#memo_dispo_box input[name=\'pilih[]\']\").val(this.value);console.log(\'pilih:\'+this.value);'";
    $klik=" onclick=\"$(this).closest('div').parent().find('.hide input[name=\'pilih[]\']').val(this.value);\"";//parent() console.log('pilih:'+this.value);$('#memo_dispo_box input[name=\'pilih[]\']').val(this.value);console.log('hasil:'+$(this).closest('div').parent().find('.hide input[name=\'pilih[]\']').val())
    $tampilan="";
    if(!$dt=@unserialize(html_entity_decode($data))){
        $dt=array(
            'pilih'=>0,
            'memo1'=>'',
            'memo2'=>'',
            'memo_dn'=>$data,
        );
    }
    if($outputform){
		$tampilan.='<div class="row-fluid offset3">';
        $tampilan.=rowf(form_label(form_radio('pilih',1,(@$kod_id?(1==$dt['pilih']):1),$klik)." $amsg[1] ")
                                    .form_input('memo1[]',tesnull($dt['memo1'])));
        $tampilan.=rowf(form_label(form_radio('pilih',2,(2==$dt['pilih']),$klik)." $amsg[2] ")
                                    .form_input('memo2[]',tesnull($dt['memo2'])));
        $tampilan.=rowf(form_label(form_radio('pilih',3,(3==$dt['pilih']),$klik)." $amsg[3] ".form_input('','','style="visibility: hidden"')));
        $tampilan.=rowf(form_label(form_radio('pilih',4,(4==$dt['pilih']),$klik)." $amsg[4] ".form_input('','','style="visibility: hidden"'))).'</div>';
        $tampilan.=div('<input type="hidden" name="pilih[]" value="'.(@$kod_id?$dt['pilih']:1).'" />','class="hide"');
        $tampilan.=div(form_label("Catatan: "),'class="span3"');
        $tampilan.=div(form_textarea('memo_dn[]',tesnull($dt['memo_dn']),'class="span11" style="max-height:90px;"'),'class="span12"');    
        $tampilan = rowf($tampilan,'label-left','id="memo_dispo_box"');
    }else{
        switch($dt['pilih']){
            case 1: $tampilan=$amsg[1].' dengan '.$dt['memo1'];break;
            case 2: $tampilan=$amsg[2].' dengan '.$dt['memo2'];break;
            case 3: $tampilan=$amsg[3];break;
            case 4: $tampilan=$amsg[4];break;
        }
        $tampilan.=($tampilan?"<br/>catatan : ":'').(tesnull($dt['memo_dn'])?$dt['memo_dn']:'-');
    }
//    $tes=implode_memo_dispo(array('pilih'=>1,'memo_dn'=>'itu'));
//    $xx=unserialize(html_entity_decode($tes));//unserialize(html_entity_decode('a:4:{s:5:"pilih";N;s:5:"memo1";s:0:"";s:5:"memo2";s:0:"";s:7:"memo_dn";s:0:"";}'));
    return $tampilan;//(1==$outputform?$tampilan:(substr($data,0,5)=='a:4:{'?print_r(unserialize(html_entity_decode($data))):$data));
}
endif;

if ( ! function_exists('implode_memo_dispo')):
function implode_memo_dispo($data){
    if(tesnull($data)&&is_array($data)){
        $save=htmlentities(serialize($data));
    }else{
        $save=$data;
    }
    return $save;
}
endif;

/*    function recur_menu($list, $keys) {
        foreach ($list as $key => $val)
        {
            if ( ! is_array($val))
            {
                return @array($keys[$key]=>$keys[$val]);
            }
            else
            {
                return @array($keys[$key]=>recur_menu($val,keys));
            }

        }
    
    }
*/

if ( ! function_exists('ul_me')) {
    function ul_me($list, $attributes = '') {
        return ul_list('ul', $list, $attributes,null,1);
    }
}

if ( ! function_exists('ul_list'))
{
    function ul_list($type = 'ul', $list, $attributes = '', $depth = 0,$lum = null)
    {
        // If an array wasn't submitted there's nothing to do...
        if ( ! is_array($list))
        {
            return $list;
        }

        // Set the indentation based on the depth
        $out = str_repeat(" ", $depth);

        // Were any attributes submitted?  If so generate a string
        $pake_class=0;
        if (is_array($attributes))
        {
            $atts = '';
            foreach ($attributes as $key => $val)
            {
                if(strtoupper($key)=='CLASS'){
                    if(0==$depth)$val.=' nav';   
                    if($depth > 0)$val.=' dropdown-menu';   
                    $pake_class=1;
                }
                $atts .= ' ' . $key . '="' . $val . '"';
            }
            $attributes = $atts;
        }
        elseif (is_string($attributes) AND strlen($attributes) > 0)
        {
            //todo:luweh kan dulu
            $attributes = ' '. $attributes;
        }

        // Write the opening list tag
        $inclass="";
        if(!$pake_class){
            if(0==$depth){
                $inclass=' class="nav"';      
            }else{
                $inclass=" class='dropdown-menu'";   
            }
        }
/*        if ($lum == "1") $inclass=" class='nav'";
        else if ($lum == "3") $inclass=" class='dropdown-menu off'";
        else $inclass=" class='dropdown-menu'";
*/        $out .= "<".$type.$attributes.$inclass." >\n";

        // Cycle through the list elements.  If an array is
        // encountered we will recursively call _list()

        static $_last_list_item = '';
        foreach ($list as $key => $val)
        {
            $_last_list_item = $key;

            $out .= str_repeat(" ", $depth + 2);
            $out .= "<li";

            if ( ! is_array($val))
            {
                $out .= ">".$val;
            }
            else
            {
                if ($lum > 1) $out .= " class='dropdown-submenu'>".$_last_list_item."\n";
                else $out .= " class='dropdown'>".$_last_list_item."\n";
                $out .= ul_list($type, $val, '', $depth + 4,$lum+1);
                $out .= str_repeat(" ", $depth + 2);
            }

            $out .= "</li>\n";
        }

        // Set the indentation for the closing tag
        $out .= str_repeat(" ", $depth);

        // Write the closing list tag
        $out .= "</".$type.">\n";

        return $out;
    }
}

/*
function notif($data) {
    echo "<div class='alert alert-success'>".$data."<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
}

function get_tahun($tahun) {
        $tahun_arr = array();
        for ($i = 0; $i < 5; $i++) {
            $tahun_arr[$tahun-$i] = $tahun-$i;
        }
        return $tahun_arr;
        
}
*/// -- Format Currency -- //

/*function rupiah($jumlah,$book=null) {
    if ($jumlah <> 0 or !empty($jumlah)) {
        if ($jumlah < 0) {
            $jumlah = substr($jumlah,1);
            if (isset($book) and $book == 1) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'> -".number_format($jumlah, 2, ",", ".").'</span>';
            else if (isset($book) and $book == 2) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'>(-".number_format($jumlah, 2, ",", ".").')</span>';
            else $return = "Rp -".number_format($jumlah, 2, ",", ".");
        } else {
            if (isset($book) and $book == 1) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'> ".number_format($jumlah, 2, ",", ".").'</span>';
            else if (isset($book) and $book == 2) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'>(".number_format($jumlah, 2, ",", ".").')</span>';
            else $return = "Rp ".number_format($jumlah, 2, ",", ".");   
        }
    } else {
        if (isset($book)) $return = "<span class='pull-left'>Rp &nbsp;</span><span class='pull-right'>0,00</span>";
        else $return = "Rp 0,00";
    }
    return $return;
}
*/
/*function numberToCurrency($a,$tipe = null) {
    if ($a < 0) {
        $a = substr($a,1);
        $col = '-'.number_format($a, 2, ",", ".");
    } else {
        $col = number_format($a, 2, ",", ".");
    }
    if (!empty($tipe)) $col = '<p class="text-right">'.$col.'</p>';
    return $col;
}

function currencyToNumber($a){
    $b=str_ireplace(".", "", $a);
    return str_replace(",",".",$b);
}
*/
// -- Layout -- //
/*
function breadcrumbs($data) {
    $print= "<div class='breadcrumbs'><p>";
    $i=1;
    foreach ($data as $echo) {
        $print.= ($i>1) ? ' &raquo '. $echo : $echo;
        $i+=1;
    }
    $print.= "</p></div>";
    return $print;
}
*/

// -- Hitungan -- //
/*
function percentToID($data) {
    $datacent = $data/100;
    $percent = preg_replace('/[.]/', ',', $datacent);
    return $percent;
}

function percentToEN($data) {
    $percent = preg_replace('/[,]/', '.', $data);
    $datacent = $percent*100;
    return $datacent;
}

function cek($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function tanggal($data) {
    if (!empty($data) and $data != "0000-00-00") return date("d/m/Y",strtotime($data));
}

function tanggal_php($data) {
    $ex = explode('/',$data);
    return $ex[2].'-'.$ex[1].'-'.$ex[0];
}

function replaceBulan($data) {
    $data = preg_replace('/[0]/','', $data);
    $bulanArr=array('1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',);
    return $bulanArr[$data];
}

function eraseChar($data) {
    $hilangslash = preg_replace('/\/+/', '_', $data);
    return preg_replace('/\ +/', '-', $hilangslash);
}

function addChar($data) {
    $plus = preg_replace('/\_+/', '/', $data);
    return preg_replace('/\-+/', ' ', $plus);
}

function in_de($data) {
    return preg_replace('/\=+/', '-', $data);
}
function un_de($data) {
    return preg_replace('/\-+/', '=', $data);
}
  */
//edoc
function getArsip($id_jenisarsip){
    CI()->load->database();
    CI()->db->where('id_jenisarsip',$id_jenisarsip);
    $q = CI()->db->get('ref_arsip')->row();
    return ($q->jenis_arsip);
}

function CI(){
    $CI =& get_instance();
    return $CI;
}

function hitungArsip($id,$tahun=null){
    CI()->db->where('id_jenisarsip',$id);
    if(!empty($tahun)) CI()->db->where('YEAR(tgl_surat)',$tahun);
    $q = CI()->db->count_all_results('arsip');
    return $q;
}
// end edoc

?>
