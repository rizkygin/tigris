<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*  mr.febri@gmail.com
*  ci.213
*  v.0121
*/
//session
if ( ! function_exists('sesi')):
function sesi($ses){
    $CI =& get_instance();
    return $CI->session->userdata($ses);
}

function setsesi($ses,$valu=null){
    $CI =& get_instance();
    if(is_array($ses)){
        $CI->session->set_userdata($ses);    
    }else{
        $CI->session->set_userdata($ses,$valu);
    }
}

function unsesi($ses){
    $CI =& get_instance();
    return $CI->session->unset_userdata($ses);
}

function flashsesi($ses){
    $CI =& get_instance();
    return $CI->session->flashdata($ses);
}

function setflashsesi($ses,$valu){
    $CI =& get_instance();
    $CI->session->set_flashdata($ses,$valu);
}

function islogin(){return sesi('login');}

function is_login(){
    $CI =& get_instance();
    return sesi($CI->config->config['login']);
}

endif;

function not_login($uri){
    if(!is_login()){
        if(!sesi('redir_login'))setsesi('redir_login',$uri);
        return true;
    }else{
        setsesi('redir_login','');return false;
    }
}

//post-get
if ( ! function_exists('retpost')):
function retgetpost($dt,$xss=false){
    $CI =& get_instance();
    return $CI->input->get_post($dt, $xss);
}

function retget($dt,$xss=false){
    $CI =& get_instance();
    return $CI->input->get($dt, $xss);
}

function retpost($dt,$xss=false){
    $CI =& get_instance();
    return $CI->input->post($dt, $xss);
}
function getpost($dt,$xss=false){
    $CI =& get_instance();
    return $CI->input->get_post($dt, $xss);
}

function get($dt,$xss=false){
    $CI =& get_instance();
    return $CI->input->get($dt, $xss);
}

function post($dt,$xss=false){
    $CI =& get_instance();
    return $CI->input->post($dt, $xss);
}
endif;

//htm .82
function ctag($tag,$isi,$attr=""){return "<$tag".($attr?" ".$attr:"").">".$isi."</$tag>";}
function div($isi,$attr=""){return ctag('div',$isi,$attr);}
function span($isi,$attr=""){return ctag('span',$isi,$attr);}
function tr($isi,$attr=""){return ctag('tr',$isi,$attr);}
function th($isi,$attr=""){return ctag('th',$isi,$attr);}
function td($isi,$attr=""){return ctag('td',$isi,$attr);}
function table($isi,$attr=""){return ctag('table',$isi,$attr);}
function tag($tag,$isi,$attr=""){return ctag($tag,$isi,$attr);}
function a($tag,$isi,$attr=""){return ctag('a',$isi,$attr);}
// fmt
function tdf($isi,$attr=""){return ctag('td',($isi?number_format($isi):0),$attr);}
function tdf2($isi,$attr=""){return ctag('td',($isi?number_format($isi,2):0),$attr);}

//load .2
if ( ! function_exists('show_loading')):
function show_loading($assets='assets/images/loading2.gif',$id='loading'){
    return span(span(' Sedang Proses, Tunggu ..','style="font-size:8pt;color:#000;"').span(img($assets)), 'id="'.$id.'"');
}
endif;

//boots .1
function row($isi,$class="",$attr=''){return div($isi,'class="row '.$class.'" '.$attr);}
function rowf($isi,$class="",$attr=''){return div($isi,'class="row-fluid '.$class.'" '.$attr);}

//meta .2
function reqjs($jsname){return ctag('script','','type="text/javascript" src="'.base_url().$jsname.'"');}
function reqcss($cssname){return '<link href="'.base_url($cssname).'" rel="stylesheet" type="text/css" />';}

//data .3
function tesnull(&$dt,$ret=null){return (isset($dt)?$dt:$ret);}

function wdt($dt,$ke,$r=0){
    $tx=".x.X.x.";
    if(is_numeric($ke)){
        return (tesnull($dt)&&tesnull($dt['td'][$r])&&tesnull($dt['th'][$ke])?$dt['td'][$r][$dt['th'][$ke]]:$tx);
    }else{
        return (tesnull($dt)&&tesnull($dt['td'][$r])?$dt['td'][$r][$ke]:$tx);
    }
}

function unser($dt,$parm=0) {
    $a=unserialize($dt);
    if($parm){
        return tesnull($a[$parm]);
    }else{
        return $a;
    }
}


//edit .4
function chg2($txt,$codetxt,$code2){return preg_replace($codetxt,$code2,$txt);}

function chg2_($dt){ return chg2($dt,'/_/',' ');}

function ucwlower($dt){return  ucwords(strtolower($dt));}

if ( ! function_exists('nfmt')){function nfmt($dt,$isdiv=0,$prepend=""){return ($isdiv? div($prepend.number_format($dt,0,',','.'),'align="right"'):$prepend.number_format($dt,0,',','.'));}}

//date .33
function set_time_id() { date_default_timezone_set('Asia/Jakarta');}

function tgl2id($dt=0,$ty=0){
    if(!$dt){
        $ret='00-00-00';
    }else{
    $blnl=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
    $td=explode('-',$dt);
    switch($ty){
        case 0: $ret=$td[2]."-".$td[1]."-".$td[0];break;
        case 1: $ret=intval($td[2])." ".$blnl[intval($td[1])]." ".$td[0];break;
        default:$ret=false;
    }
    }
    return $ret;
}

function xtgl($dt,$split,$d=1){
    $pard=array(array("%s/%s/%s","%s-%s-%s"),array("%d/%d/%d","%d-%d-%d"));
    $edt=explode($split,$dt);
    if(3==count($edt)){
      return sprintf(('-'==$split?$pard[$d][0]:$pard[$d][1]),$edt[2],$edt[1],$edt[0]);  
    }else{
      return $dt;  
    }
    
}

function tgl2sql($dt){
    $edt=explode('/',$dt);
    if(count($edt)<3)$edt=explode('-',$dt);
    if(3==count($edt)){
      return sprintf('%d-%02d-%02d',$edt[2],$edt[1],$edt[0]);  
    }else{
      return $dt;  
    }
    
}

function ztgl2sql($dt) {
    $bln=array('JAN'=>'01','FEB'=>'02','MAR'=>'03','APR'=>'04','MAY'=>'05','JUN'=>'06','JUL'=>'07','AUG'=>'08','SEP'=>'09','OCT'=>'10','NOV'=>'11','DEC'=>'12');
    $etmp=preg_split("/ /", $dt);
//    $edt=explode('-',$etmp[0]);
    $edt=preg_split("/-/",$etmp[0]);
    return $edt[2]."-".$bln[$edt[1]]."-".$edt[0];
}
//oth .11
function _cek($dt,$vd=0,$debug=1) {
    if($dt && $debug){
        echo "<pre>";
        if(!$vd){
            print_r($dt);
        }else{
            var_dump($dt);
        }
        echo "</pre>";
    }
}

function lz($dt,$num){
    return substr(repeater('0',$num).$dt,-$num);
}

function ada_file($filename) {
    $file_headers = get_headers($filename);
    return (strpos($file_headers[0], '404')!== false?false:true);
}

function _config($param=null){
    return $param ? CI()->config->config[$param]: CI()->config->config;
}

function komen($dt) {
    return "<!-- ".$dt." -->";
}

function stop($dt,$vd=0){
    exit(_cek($dt,$vd));
}

function load_lib($app,$controller, $method = 'index',$param1 = null,$param2 = null,$param3 = null) {
        $path = FCPATH . APPPATH . 'libraries/'. $controller . '.php';
        if (file_exists($path)) {
            require_once($path);
            $controller = new $controller();

        return $controller->$method($param1,$param2,$param3);
        }
}
?>