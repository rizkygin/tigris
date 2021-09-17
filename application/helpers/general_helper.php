<?php
if(!function_exists('_ci')) {
	function _ci() {
		$_ci = &get_instance();
		return $_ci;
	}
}


function login_check($session) {
	date_default_timezone_set('Asia/Jakarta');
	if (empty($session)) redirect('login/login'); 
}

function shrot_word($string, $word_limit)
	{
		$words = explode(" ",$string);
	    return implode(" ",array_splice($words,0,$word_limit));
	}
function notif($data) {
	echo "<div class='alert alert-success'>".$data."<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
}

function get_tahun($tahun) {
		$tahun_arr = array();
		for ($i = 0; $i < 10; $i++) {
			$tahun_arr[$tahun-$i] = $tahun-$i;
		}
		return $tahun_arr;
		
}

function get_bulan($bulan) {
	$bulan_arr = array('' => ' -- Pilih -- ', 1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	return $bulan_arr;
}
// -- Format Currency -- //

	/* kalender indonesia */
function date_indox($data,$format){
	if($data != '0000-00-00' && !empty($data)){
		$ex = explode('-',$data);
		
		/* some formats 
			1 -> dd/mm/yyyy
			2 -> dd month(sort) yyyy
			3 -> dd month (full) yyyy
		*/
		$tgl=null;
		if($format == 1){
			$tgl = $ex[2].'/'.$ex[1].'/'.$ex[0];
		}else if($format == 2){
			$bulan = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nop','12'=>'Des');
			$tgl = $ex[2].' '.$bulan[$ex[1]].' '.$ex[0];
		}else if($format == 3){
			$bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
			$tgl = $ex[2].' '.$bulan[$ex[1]].' '.$ex[0];
		}
		return $tgl;
	}
}
	
	
function rupiah($jumlah,$book=null) {
  //   if ($jumlah <> 0 or !empty($jumlah)) {
		// if ($jumlah < 0) {
		// 	$jumlah = substr($jumlah,1);
		// 	if (!empty($book) and $book == 1) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'> -".number_format($jumlah, 2, ",", ".").'</span>';
		// 	else if (!empty($book and $book == 2) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'>(-".number_format($jumlah, 2, ",", ".").')</span>';
		// 	else $return = "Rp -".number_format($jumlah, 2, ",", ".");
		// } else {
		// 	if (!empty($book) and $book == 1) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'> ".number_format($jumlah, 2, ",", ".").'</span>';
		// 	else if (!empty($book) and $book == 2) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'>(".number_format($jumlah, 2, ",", ".").')</span>';
		// 	else $return = "Rp ".number_format($jumlah, 2, ",", ".");   
		// }
  //   } else {
		// if (!empty($book)) $return = "<span class='pull-left'>Rp &nbsp;</span><span class='pull-right'>0,00</span>";
		// else $return = "Rp 0,00";
  //   }
    return $jumlah;
}

function numberToCurrency($a,$tipe = null) {
	if ($a != 0 or $a != 0.00) {

	if ($a < 0) {
	    $a = substr($a,1);
	    $col = '-'.number_format($a, 2, ",", ".");
	} else {
	    $col = number_format($a, 2, ",", ".");
	}
	if (!empty($tipe)) $col = '<span class="pull-right">'.$col.'</span>';
	return str_replace(',00','',$col);
	}
}

function currencyToNumber($a){
    $b=str_ireplace(".", "", $a);
    return str_replace(",",".",$b);
}

// -- Layout -- //

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


// -- Hitungan -- //

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
	date_default_timezone_set('Asia/Jakarta');
	if (!empty($data) and $data != "0000-00-00") return date("d/m/Y",strtotime($data));
	else return ' ';
}

function tanggal_php($data) {
	if (!empty($data)) {
		$ex = explode('/',$data);
		return $ex[2].'-'.$ex[1].'-'.$ex[0];
	}
}

function tanggal_jam_php($data) {
	date_default_timezone_set('Asia/Jakarta');
	if (!empty($data)) {
		$ex = explode('/',$data);
		return $ex[2].'-'.$ex[1].'-'.$ex[0].' '.date('H:i:s');
	}
}

function tanggal_indo($data=NULL){
	if ($data==NULL) {
		return 'Tidak tertanggal';
	}else{
		$ex_tgl = explode('-',$data);
			
		$bulan = array("01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September",
					   "10"=>"Oktober","11"=>"November","12"=>"Desember");
		if($ex_tgl[0] == '0000' || $ex_tgl[1] == '00' || $ex_tgl[2] == '00' || $ex_tgl[0] == NULL || $ex_tgl[1] == NULL || $ex_tgl[2] == NULL) {
			$tgl = 'Tidak tertanggal';
		}else {
			$tgl = $ex_tgl[2]." ".$bulan[$ex_tgl[1]]." ".$ex_tgl[0];
		}
		return $tgl;
	}
}

function tanggal_jam($data=NULL){
	if ($data==NULL) {
		return 'Tidak tertanggal';
	}else{
		$tgl_jam = explode(' ',$data);
		$tgl = explode('-', $tgl_jam[0]);
		$jam = $tgl_jam[1];
		$bulan = array("01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September",
					   "10"=>"Oktober","11"=>"November","12"=>"Desember");
		if($tgl[0] == '0000' || $tgl[1] == '00' || $tgl[2] == '00') $tanggal = 'Tidak tertanggal';			   
		else $tanggal = $tgl[2]." ".$bulan[$tgl[1]]." ".$tgl[0]."<br> Jam ".$jam;
		return $tanggal;
	}
}

function umur($tgl){
	$interval = date_diff(date_create(), date_create($tgl));
	$age = $interval->format('%Y Thn %M Bln');
	return $age;
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
	$data_on = base64_encode(serialize($data));
	return preg_replace('/\=+/', '-', $data_on);
}

function un_de($data) {
	$on_data = preg_replace('/\-+/', '=', $data);
	return unserialize(base64_decode($on_data));
}


function konversi_tanggal($format, $tanggal="now"){
 $en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb",
 "Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

 $id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
 "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September",
 "Oktober","November","Desember");

 return str_replace($en,$id,date($format,strtotime($tanggal)));
}
function numberToRoman($num)  
{ 
    // Be sure to convert the given parameter into an integer
    $n = intval($num);
    $result = ''; 
 
    // Declare a lookup array that we will use to traverse the number: 
    $lookup = array(
        'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
    ); 
 
    foreach ($lookup as $roman => $value)  
    {
        // Look for number of matches
        $matches = intval($n / $value); 
 
        // Concatenate characters
        $result .= str_repeat($roman, $matches); 
 
        // Substract that from the number 
        $n = $n % $value; 
    } 

    return $result; 
} 
function terbilang($x)
{
  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  if ($x < 12):
    return " " . $abil[$x];
  elseif ($x < 20):
    return terbilang($x - 10) . "Belas";
  elseif ($x < 100):
    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
  elseif ($x < 200):
    return " seratus" . terbilang($x - 100);
  elseif ($x < 1000):
    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
  elseif ($x < 2000):
    return " seribu" . terbilang($x - 1000);
  elseif ($x < 1000000):
    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000):
    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
  elseif ($x < 1000000000000):
    return terbilang($x / 1000000000) . " Milyar" . terbilang($x % 1000000000);
  elseif ($x < 1000000000000000):
    return terbilang($x / 1000000000000) . " Trilyun" . terbilang($x % 1000000000000);
  endif;
}

function suara($s, $lok=NULL, $kd=NULL)
{
	if($kd=='A'):
		$kode = '<audio onloadeddata="var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4200)"><source src="'.base_url('assets/sounds/a.mp3').'" type="audio/mp3"></audio>';
		elseif($kd=='B'):
			$kode = '<audio onloadeddata="var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4200)"><source src="'.base_url('assets/sounds/b.mp3').'" type="audio/mp3"></audio>';
			elseif($kd=='C'):
				$kode = '<audio onloadeddata="var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4200)"><source src="'.base_url('assets/sounds/c.mp3').'" type="audio/mp3"></audio>';
			else:
				$kode = '<audio onloadeddata="var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4200)"><source src="'.base_url('assets/sounds/d.mp3').'" type="audio/mp3"></audio>';
			endif;
  	$sua = array(
	  	"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4700)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
  	);
	
	$intro = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); })'><source src='".base_url('assets/sounds/intro.wav')."' type='audio/mpeg'></audio>";
	$urut = "<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 3000)'><source src='".base_url('assets/sounds/nomor/nomor-urut.wav')."' type='audio/mpeg'></audio>";
	$loket_satuan = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 5500)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	$loket_puluhan = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6200)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	$loket_duapuluhan = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6800)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	
	if ($s < 12) {
    	return $intro.$urut.$kode.$sua[$s].$loket_satuan.loket_satuan($lok);
	}elseif ($s < 20) {
    	return $intro.$urut.$kode.child_puluhan($s - 10) . "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 5300)'><source src='".base_url('assets/sounds/nomor/belas.wav')."' type='audio/mpeg'></audio>".$loket_puluhan.loket_puluhan($lok);
  	}elseif ($s < 100) {
    	return $intro.$urut.$kode.$sua[$s / 10] . "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 5300)'><source src='".base_url('assets/sounds/nomor/puluh.wav')."' type='audio/mpeg'></audio>" . child_ratusan($s % 10).$loket_duapuluhan.loket_duapuluhan($lok);
  	}elseif ($s < 200) {
  		$utama = $s-100;
  		if($utama < 12):
  			$time_lok = 7000;
  			$time = 8000;
  		elseif($utama < 20):
  			$time_lok = 7700;
  			$time = 8700;
  		elseif($utama == 20):
  			$time_lok = 8000;
  			$time = 9000;
  		elseif($utama < 100):
  			$time_lok = 8800;
  			$time = 9800;
  		endif;
    	return $intro.$urut.$kode.
    			"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4900)'>
    				<source src='".base_url('assets/sounds/nomor/seratus.wav')."' type='audio/mpeg'></audio>" . 
    			child_ratusan($s - 100, $lok).
    			loket_ratusan($lok, $time, $time_lok);
  	}elseif ($s < 1000){
  		$time_lok = NULL;
  		$time =NULL;
  		$utama = $s % 100;
  		if($utama < 1):
  			$time_lok = 6500;
  			$time = 7500;
  		elseif($utama < 12):
  			$time_lok = 6900;
  			$time = 7900;
  		elseif($utama == 20):
  			$time_lok = 7500;
  			$time = 8500;
  		elseif($utama == 40 or $utama == 50 or $utama == 60 or $utama == 70 or $utama == 80 or $utama == 90):
  			$time_lok = 8000;
  			$time = 9000;
  		elseif($utama < 100):
  			$time_lok = 8500;
  			$time = 9400;
  		endif;
    	return $intro.$urut.$sua[$s / 100].
    			"<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 5300)'>
    				<source src='".base_url('assets/sounds/nomor/ratus.wav')."' type='audio/mpeg'></audio>" . 
    			child_ribuan($s % 100).loket_ratusan($lok, $time, $time_lok);
  	}else{
  		return;
  	}
}

function loket_ratusan($s, $time=NULL, $time_lok=NULL) {
	$time = !empty($time) ? $time : '8700';
	$time_lok = !empty($time_lok) ? $time_lok : '7700';
	$loket1 = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time_lok.")'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	$no_loket = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);
	if ($s < 12) {
    	return $loket1.$no_loket[$s];
	}elseif ($s < 20) {
		return loket_ratusan($s - 10, 8700, 7700);
	}
}

function child_ribuan($s, $time=NULL) {
	$time = !empty($time) ? $time : '6000';
	$child = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);
	if ($s < 12):
    	return $child[$s];
	elseif ($s < 20):
		return child_ribuan($s - 10)."<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7000)'><source src='".base_url('assets/sounds/nomor/belas.wav')."' type='audio/mpeg'></audio>";
	elseif ($s < 100):
		return child_ribuan($s / 10)."<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7000)'><source src='".base_url('assets/sounds/nomor/puluh.wav')."' type='audio/mpeg'></audio>".child_ribuan($s % 10, 7500);
	endif;
}

function child_ratusan($s,$lok=NULL) {
	$child = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);
	$child_ratusan = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6000)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
		);
	$child_persen = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
		);
	$loket_duapuluhan = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7800)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	
	if ($s < 12):
    	return $child[$s];
	elseif ($s < 20):
    	return $child_ratusan[$s - 10] . "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7000)'><source src='".base_url('assets/sounds/nomor/belas.wav')."' type='audio/mpeg'></audio>";
  	elseif ($s < 100):
    	return child_ratusan($s / 10) . " <audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7000)'><source src='".base_url('assets/sounds/nomor/puluh.wav')."' type='audio/mpeg'></audio>" . $child_persen[$s % 10];
  	elseif ($s < 200):
    	return "<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 1500)'><source src='".base_url('assets/sounds/nomor/seratus.wav')."' type='audio/mpeg'></audio>" . child_ratusan($s - 100).loket_ratusanduapuluhup($lok);
  	elseif ($s < 1000):
    	return child_ratusan($s / 100) . " <audio autoplay><source src='".base_url('assets/sounds/nomor/ratus.wav')."' type='audio/mpeg'></audio>" . child_ratusan($s % 100);
  	elseif ($s < 2000):
    	return " seribu" . child_ratusan($s - 1000);
  	elseif ($s < 1000000):
    	return child_ratusan($s / 1000) . " Ribu" . child_ratusan($s % 1000);
  	elseif ($s < 1000000000):
    	return child_ratusan($s / 1000000) . " Juta" . child_ratusan($s % 1000000);
  	elseif ($s < 1000000000000):
    	return child_ratusan($s / 1000000000) . " Milyar" . child_ratusan($s % 1000000000);
  	elseif ($s < 1000000000000000):
    	return child_ratusan($s / 1000000000000) . " Trilyun" . child_ratusan($s % 1000000000000);
  	endif;
}

function child_puluhan($s) {
	$child = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 4500)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);
	if ($s < 12):
    	return $child[$s];
	elseif ($s < 20):
    	return suara($s - 10) . "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 5400)'><source src='".base_url('assets/sounds/nomor/belas.wav')."' type='audio/mpeg'></audio>";
  	elseif ($s < 100):
    	return suara($s / 10) . " <audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 5300)'><source src='".base_url('assets/sounds/nomor/puluh.wav')."' type='audio/mpeg'></audio>" . child_no($s % 10);
  	elseif ($s < 200):
    	return "<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 1500)'><source src='".base_url('assets/sounds/nomor/seratus.wav')."' type='audio/mpeg'></audio>" . suara($s - 100);
  	elseif ($s < 1000):
    	return suara($s / 100) . " <audio autoplay><source src='".base_url('assets/sounds/nomor/ratus.wav')."' type='audio/mpeg'></audio>" . suara($s % 100);
  	elseif ($s < 2000):
    	return " seribu" . suara($s - 1000);
  	elseif ($s < 1000000):
    	return suara($s / 1000) . " Ribu" . suara($s % 1000);
  	elseif ($s < 1000000000):
    	return suara($s / 1000000) . " Juta" . suara($s % 1000000);
  	elseif ($s < 1000000000000):
    	return suara($s / 1000000000) . " Milyar" . suara($s % 1000000000);
  	elseif ($s < 1000000000000000):
    	return suara($s / 1000000000000) . " Trilyun" . suara($s % 1000000000000);
  	endif;
}
function loket_satuan($x) {
	$no_loket = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 6500)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);

	if ($x < 12):
	    return " " . $no_loket[$x];
	  elseif ($x < 20):
	    return terbilang($x - 10) . "Belas";
	  elseif ($x < 100):
	    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
	  elseif ($x < 200):
	    return " seratus" . terbilang($x - 100);
	  elseif ($x < 1000):
	    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
	  elseif ($x < 2000):
	    return " seribu" . terbilang($x - 1000);
	  elseif ($x < 1000000):
	    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
	  elseif ($x < 1000000000):
	    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
	  elseif ($x < 1000000000000):
	    return terbilang($x / 1000000000) . " Milyar" . terbilang($x % 1000000000);
	  elseif ($x < 1000000000000000):
	    return terbilang($x / 1000000000000) . " Trilyun" . terbilang($x % 1000000000000);
	  endif;
}
function loket_puluhan($x) {
	$no_loket = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7300)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);

	if ($x < 12):
	    return " " . $no_loket[$x];
	  elseif ($x < 20):
	    return terbilang($x - 10) . "Belas";
	  elseif ($x < 100):
	    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
	  elseif ($x < 200):
	    return " seratus" . terbilang($x - 100);
	  elseif ($x < 1000):
	    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
	  elseif ($x < 2000):
	    return " seribu" . terbilang($x - 1000);
	  elseif ($x < 1000000):
	    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
	  elseif ($x < 1000000000):
	    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
	  elseif ($x < 1000000000000):
	    return terbilang($x / 1000000000) . " Milyar" . terbilang($x % 1000000000);
	  elseif ($x < 1000000000000000):
	    return terbilang($x / 1000000000000) . " Trilyun" . terbilang($x % 1000000000000);
	  endif;
}

function loket_duapuluhan($x) {
	$no_loket = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);

	if ($x < 12):
	    return " " . $no_loket[$x];
	  elseif ($x < 20):
	    return terbilang($x - 10) . "Belas";
	  elseif ($x < 100):
	    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
	  elseif ($x < 200):
	    return " seratus" . terbilang($x - 100);
	  elseif ($x < 1000):
	    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
	  elseif ($x < 2000):
	    return " seribu" . terbilang($x - 1000);
	  elseif ($x < 1000000):
	    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
	  elseif ($x < 1000000000):
	    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
	  elseif ($x < 1000000000000):
	    return terbilang($x / 1000000000) . " Milyar" . terbilang($x % 1000000000);
	  elseif ($x < 1000000000000000):
	    return terbilang($x / 1000000000000) . " Trilyun" . terbilang($x % 1000000000000);
	  endif;
}

function loket_belasan($x) {
	$no_loket = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);

	if ($x < 12):
	    return " " . $no_loket[$x];
	  elseif ($x < 20):
	    return terbilang($x - 10) . "Belas";
	  elseif ($x < 100):
	    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
	  elseif ($x < 200):
	    return " seratus" . terbilang($x - 100);
	  elseif ($x < 1000):
	    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
	  elseif ($x < 2000):
	    return " seribu" . terbilang($x - 1000);
	  elseif ($x < 1000000):
	    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
	  elseif ($x < 1000000000):
	    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
	  elseif ($x < 1000000000000):
	    return terbilang($x / 1000000000) . " Milyar" . terbilang($x % 1000000000);
	  elseif ($x < 1000000000000000):
	    return terbilang($x / 1000000000000) . " Trilyun" . terbilang($x % 1000000000000);
	  endif;
}

function loket_ratusanduapuluhup($x) {
	$no_loket = array(
		"", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 10000)'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);
	$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";

	if ($x < 12):
	    return $loket_ratusanduapuluhup . $no_loket[$x];
	  elseif ($x < 20):
	    return terbilang($x - 10) . "Belas";
	  elseif ($x < 100):
	    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
	  elseif ($x < 200):
	    return " seratus" . terbilang($x - 100);
	  elseif ($x < 1000):
	    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
	  elseif ($x < 2000):
	    return " seribu" . terbilang($x - 1000);
	  elseif ($x < 1000000):
	    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
	  elseif ($x < 1000000000):
	    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
	  elseif ($x < 1000000000000):
	    return terbilang($x / 1000000000) . " Milyar" . terbilang($x % 1000000000);
	  elseif ($x < 1000000000000000):
	    return terbilang($x / 1000000000000) . " Trilyun" . terbilang($x % 1000000000000);
	  endif;
}

function loketduaratusan($x, $sbl){
	if ($sbl < 12) {
		$time = 8500;
		$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	}elseif($sbl < 20){
		$time = 8500;
		$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 9000)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	}elseif ($sbl < 100) {
		$time = 8500;
		$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 11000)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	}elseif ($sbl < 200) {
		$time = 8500;
		$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7500)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	}elseif ($sbl < 212) {
		$time = 8000;
		$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7000)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	}elseif ($sbl < 220) {
		$time = 8500;
		$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 7500)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	}elseif ($sbl < 1000) {
		$time = 9000;
		$loket_ratusanduapuluhup = "<audio onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 8000)'><source src='".base_url('assets/sounds/nomor/loket.wav')."' type='audio/mpeg'></audio>";
	}
	$no_loket = array(
		"",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/satu.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/dua.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/tiga.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/empat.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/lima.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/enam.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/tujuh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/delapan.wav')."' type='audio/mpeg'></audio>",
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sembilan.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sepuluh.wav')."' type='audio/mpeg'></audio>", 
	  	"<audio  onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, ".$time.")'><source src='".base_url('assets/sounds/nomor/sebelas.wav')."' type='audio/mpeg'></audio>"
	);
	
	if ($x < 12):
		return " " . 
		$loket_ratusanduapuluhup.
		$no_loket[$x];
	elseif ($x < 20):
		return ;
	endif;
}

function generateRM(){
	$no_urut = '000000';
	$sql="SELECT max( CAST( no_rm AS UNSIGNED ) ) no_rm
FROM (
`rs_pasien`
)
ORDER BY `no_rm` DESC ";
	_ci()->load->database();
//	_ci()->db->order_by('no_rm','desc');
//    _ci()->db->limit(1);
//    _ci()->db->select('max(CAST(no_rm  as UNSIGNED))no_rm ');
//	_ci()->db->select_max('no_rm');
    
//    $q         = _ci()->db->get('rs_data_penduduk')->row();
	$q 		= _ci()->db->query($sql)->row(); 
//    cek($q);
//    cek(_ci()->db->last_query());
//    $lastrm = (int) $q->no_rm;
	$lastrm = $q->no_rm;
	
	if($lastrm == null || $lastrm == '') $lastrm = 0;
//	$potong = strlen($no_urut) - strlen((string) $lastrm);
	$lastrm	= $lastrm + 1;
	$newrm 	= substr($no_urut.$lastrm,strlen($no_urut.$lastrm)-6,6);
//    ,-(int) $potong).(string) $lastrm;
		
	return $newrm;
}
function combo_option($sel) {
	$dis = null;
	foreach($sel as $v => $a) $dis .= '<option value="'.$v.'">'.$a.'</option>';
	return $dis;
}

function watermark($text,$configArray=array(),$filepath='uploads'){
    if(trim($text) == "")
        return "";
    $conf = array();
    $conf['background-color'] = !empty($configArray['background-color']) ? $configArray['background-color'] : '#000000';
    $conf['color']            = !empty($configArray['color'])            ? $configArray['color'] : '#ffffff';
    $conf['font-size']        = !empty($configArray['font-size'])        ? $configArray['font-size'] : '14';
    $conf['font-file']        = !empty($configArray['font-file'])        ? $configArray['font-file'] : 'bootstrap/css/bebas.otf';
    $conf['params']           = !empty($configArray['params'])           ? $configArray['params'] : '';
    
    // calculate a hash out of the configuration array-> image is only generated if its not found in the filepath
    $str = $text;
    foreach($conf as $key => $val){
        $str .= $key."=".$val;
    }
    $hash = md5($str);
    $imagepath = $filepath.'/'.$hash.'.gif';
    if(!file_exists($imagepath)){
        $data = imagettfbbox($conf['font-size'], -0.2, $conf['font-file'], $text);
        $x = 0 - $data[6];
        $y = 0 - $data[7]-$data[3];
        //print_r($data);
        
        $y *= 1.1;  //dunno why - but without this line the area will be a bit too small in hight
        //echo $y;
        $res = imagecreate($data[2]*1.04, 2*$data[3] + $y);
        $r = hexdec(substr($conf['background-color'],1,2));
        $g = hexdec(substr($conf['background-color'],3,2));
        $b = hexdec(substr($conf['background-color'],5,2));
        $backgroundcolor = imagecolorallocate($res,$r,$g, $b);
        $r = hexdec(substr($conf['color'],1,2));
        $g = hexdec(substr($conf['color'],3,2));
        $b = hexdec(substr($conf['color'],5,2));
        
        $textcolor = imagecolorallocate($res,$r, $g, $b);
        imagettftext($res, $conf['font-size'], 0, 3, $conf['font-size'], $textcolor, $conf['font-file'], $text);
        
        imagegif($res, $imagepath);
    }
    return '<img src="'.base_url().$imagepath.'" border="0"/>';
    
}

/* kalender indonesia */
	function date_indo($data,$format){
		if($data != '0000-00-00' && !empty($data)){
			$ex = explode('-',$data);
			
			/* some formats 
				1 -> dd/mm/yyyy
				2 -> dd month(sort) yyyy
				3 -> dd month (full) yyyy
			*/
			
			if($format == 1){
				$tgl = $ex[2].'/'.$ex[1].'/'.$ex[0];
			}else if($format == 2){
				$bulan = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nop','12'=>'Des');
				$tgl = $ex[2].' '.$bulan[$ex[1]].' '.$ex[0];
			}else if($format == 3){
				$bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
				$tgl = $ex[2].' '.$bulan[$ex[1]].' '.$ex[0];
			}
			return $tgl;
		}
	}
	
	function date_indo2($data,$format){
		if($data != '00-00-0000' && !empty($data)){
			$ex = explode('/',$data);
			
			/* some formats 
				1 -> dd/mm/yyyy
				2 -> dd month(sort) yyyy
				3 -> dd month (full) yyyy
			*/
			
			if($format == 1){
				$tgl = $ex[0].'/'.$ex[1].'/'.$ex[2];
			}else if($format == 2){
				$bulan = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nop','12'=>'Des');
				$tgl = $ex[0].' '.$bulan[$ex[1]].' '.$ex[2];
			}else if($format == 3){
				$bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
				$tgl = $ex[0].' '.$bulan[$ex[1]].' '.$ex[2];
			}
			return $tgl;
		}
	}

	function load_controller($app,$controller, $method = 'index',$param1 = null,$param2 = null,$param3 = null) {
		
		$path = FCPATH . APPPATH . 'controllers/'.$app.'/'. $controller . '.php';
		
		if (file_exists($path)) {
			require_once($path);
			$controller = new $controller();

		return $controller->$method($param1,$param2,$param3);
		}
    }
	
// -- B: HELPER MILIK SIMAS --	
function getItemMutasi($id_ba){
	$CI =& get_instance();
	$CI->load->database();
	$CI->db->where('id_ba_mutasi',$id_ba);
	return $CI->db->get('simas_mutasi_item');
}

function getItemPenghapusan($id_penghapusan){
	$CI =& get_instance();
	$CI->load->database();
	$CI->db->where('id_penghapusan',$id_penghapusan);
	return $CI->db->get('simas_penghapusan_item');
}

function getNamaKib($kib){
	switch ($kib){
		case 'a':$kib='KIB A. Tanah';break;
		case 'b':$kib='KIB B. Peralatan Mesin';break;
		case 'c':$kib='KIB C. Gedung Bangunan';break;
		case 'd':$kib='KIB D. Jalan Irigasi Jaringan';break;
		case 'e':$kib='KIB E. Aset Tetap Lainnya';break;
		case 'f':$kib='KIB F. Konstruksi Dalam Pengerjaan';break;
	}
	return $kib;
}

function getDropTahun(){
	$thn = date('Y');
	$cbTahun = array(''=>'-- Pilih Tahun --');
	for($thn;$thn>=2000;$thn--){
		$cbTahun[$thn] = $thn;
	}
	return $cbTahun;
}

function getNamaSKPD($id=null){
	$CI =& get_instance();
	$CI->load->database();
	$CI->db->where('id_unit',$id);
	$sk = $CI->db->get('ref_unit')->row();
	return @$sk->unit;
}

function getNamaLokasi($id=null){
	$CI =& get_instance();
	$CI->load->database();
	$CI->db->where('id_bidang',$id);
	$lokasi = $CI->db->get('ref_bidang')->row();
	return @$lokasi->nama_bidang;
}

function getNamaKepala($id=null){
	$CI =& get_instance();
	$CI->load->database();
	$CI->db->select('*');
	$CI->db->from('ref_unit a');
	$CI->db->join('peg_pegawai b', 'a.id_kepala = b.id_pegawai');
	$CI->db->where('a.id_unit',$id);
	$sk = $CI->db->get()->row();
	return @$sk->nama;
}

function getNipKepala($id=null){
	$CI =& get_instance();
	$CI->load->database();
	$CI->db->select('*');
	$CI->db->from('ref_unit a');
	$CI->db->join('peg_pegawai b', 'a.id_kepala = b.id_pegawai');
	$CI->db->where('a.id_unit',$id);
	$sk = $CI->db->get()->row();
	return @$sk->nip;
}

	function reg($x){
		$format = '0000';
		$potong = strlen($format) - strlen($x);
		$reg = substr($format,0,$potong).$x;
		return $reg;	
	}
	
	function getSatker($id_lokasi=null){
		$CI = & get_instance();
		$CI->load->database();
		$CI->db->where('id_lokasi',$id_lokasi);
		$q = $CI->db->get('ref_lokasi_aset')->row();
		$lok = @$q->nama_unker;
		return $lok;
	}
	
	function getRuang($id_lokasi=null){
		$CI = & get_instance();
		$CI->load->database();
		$CI->db->where('id_lokasi',$id_lokasi);
		$q = $CI->db->get('ref_lokasi_aset')->row();
		$ruang = @$q->nama_ruang;
		return $ruang;
	}
	
	function getKodeLokasi($id_unit=null){
		$CI = & get_instance();
		$CI->load->database();
		$CI->db->from('ref_unit a');
		$CI->db->join('ref_lokasi_aset b','a.id_unit=b.id_unit','left');
		$CI->db->where('a.id_unit',$id_unit);
		$q = $CI->db->get()->row();
		$kodelokasi = $q->kode_skpd.'.'.$q->kode_unker.'.'.$q->kode_ruang;
		return $kodelokasi;
	}
// -- E: HELPER MILIK SIMAS --		

	
	function tata_jabatan($data) {
		
		$str_asli = array('Sub Bidang Sub Bidang','Sub Bagian Sub Bagian', 'Bidang Bidang','Seksi Seksi');
		$str_ganti = array('Sub Bidang','Sub Bagian','Bidang', 'Seksi');
		
		return str_replace($str_asli, $str_ganti, $data);
	}
	
	function get_role($id) {	
		
		
		
		$CI =& get_instance();
		$CI->load->database();	
			
		$CI->db->from('pegawai_role r');
		$CI->db->join('ref_role ro','ro.id_role = r.id_role','left');
		$CI->db->join('ref_aplikasi a','a.id_aplikasi = ro.id_aplikasi','left');
		$CI->db->where('r.id_pegawai',$id);
		$CI->db->where('a.aktif',1);
		$CI->db->order_by('a.urut');
		$roled = $CI->db->get();
		
		$role = array();
		$aplikasi = array();
		
		foreach($roled->result() as $r) {
			
			$CI->db->from('ref_aplikasi');
			$CI->db->where('id_par_aplikasi',$r->id_aplikasi);
			$an = $CI->db->get();
			
			$anak = array();
			foreach ($an->result() as $ap_a) {
				$app_anak[] = $ap_a->folder;
			}
			
			$aplikasi[$r->folder] = array(
				'id_role' => $r->id_role,
				'id_aplikasi' => $r->id_aplikasi,
				'aplikasi_anak' => $anak,
				'nama_role' => $r->nama_role,
				'nama_aplikasi' => $r->nama_aplikasi,
				'direktori' => $r->folder,
				'warna' => $r->warna);
			
		}
		
		$on = array(
		'aplikasi' => $aplikasi
		); return $on;

	}
	
	function get_stationer($id = null) {

		if (empty($id)) {
			$id = array(
			'aplikasi',
			'aplikasi_code',
			'aplikasi_s',
			'aplikasi_logo_ext',
			'aplikasi_logo_only',
			'aplikasi_logo',
			'ibukota',
			'alamat',
			'main_color',
			'pemerintah',
			'pemerintah_s',
			'pemerintah_logo',
			'pemerintah_logo_bw',
			'pemerintah_logo_ext',
			'instansi',
			'instansi_s',
			'instansi_code',
			'copyright',
			'foto_latar_login',
			'demo',
			'welcome_mutasi',
			'judul_situs',
			'nama_pilkada',
			'kabupaten_pilkada',
			'periode',
			'penyelenggara_pilkada');
		}
				
		$CI =& get_instance();
		$CI->load->database();	
			
		$CI->db->where("param IN ('".implode("','",$id)."')",null,false);	
		$data = $CI->db->get('parameter');
		$ret = array();
		foreach($data->result() as $d) { 
			$ret[$d->param]= $d->val;
		}
		
		if (!empty($CI->config->config['otonom']) and $CI->config->config['otonom'] == TRUE) {

			$ret = array_merge($ret,array(
			'aplikasi' => $CI->config->config['aplikasi'],
			'aplikasi_code' => $CI->config->config['aplikasi_code'],
			'aplikasi_s' => $CI->config->config['aplikasi_s'],
			'aplikasi_logo' => $CI->config->config['aplikasi_logo'],
			'pemerintah' => $CI->config->config['pemerintah'],
			'pemerintah_s' => $CI->config->config['pemerintah_s'],
			'instansi' => $CI->config->config['instansi'],
			'instansi_s' => $CI->config->config['instansi_s'],
			'instansi_code' => $CI->config->config['instansi_code'],
			'copyright' => $CI->config->config['copyright'],
			'main_color' => $CI->config->config['main_color']));
			
		} 
		
		return $ret;

	}
	
	function uris($link) {
		
		$CI =& get_instance();
		$CI->load->helpers('url');	

		$act = 1;

		$link = explode('/',$link);
		$ur = array();
		for($i = 0; $i < count($link); $i++) {
			$ur[] = $CI->uri->segment($i+1);
		}
		for($i = 0; $i < count($link); $i++) {
			
			if ($ur[$i] != $link[$i]) $act = 2;
			
		}
		return ($act == 1) ? 'active' : null;
	}
			
	function check_uris($id) {
		
		$on_active = null;
		
		$CI =& get_instance();
		$CI->load->database();	
		
		$CI->db->from('nav');
		$CI->db->where('id_par_nav', $id);
		
		$n = $CI->db->get();
		foreach($n->result() as $e) {
			
			$j = uris($e->link);
			if (!empty($j)) $on_active = 'active';
			else {
				
				$CI->db->from('nav');
				$CI->db->where('id_par_nav', $e->id_nav);
				
				$nn = $CI->db->get();
				foreach($nn->result() as $ee) {
			
					$jj = uris($ee->link);
					if (!empty($jj)) $on_active = 'active';
				}
				
				
			}
			
			
		}
		
		return $on_active;
		
	}
	
	function get_nav($id_peg,$ref,$app,$id_par = null) {
		
		$on_active = null;
		
		$CI =& get_instance();
		$CI->load->database();

		$CI->db->query('SET SESSION sql_mode = ""');

		// ONLY_FULL_GROUP_BY
		$CI->db->query('SET SESSION sql_mode =
		                  REPLACE(REPLACE(REPLACE(
		                  @@sql_mode,
		                  "ONLY_FULL_GROUP_BY,", ""),
		                  ",ONLY_FULL_GROUP_BY", ""),
		                  "ONLY_FULL_GROUP_BY", "")');

		
		$where = (!empty($id_par)) ? 'n.id_par_nav = '.$id_par : 'n.ref = '.$ref.' AND (id_par_nav IS NULL OR id_par_nav = 0) AND n.id_aplikasi = '.$app;
		
		$CI->db->from('nav n');
		$CI->db->join('ref_role_nav r','r.id_nav = n.id_nav');
		$CI->db->join('pegawai_role pr', 'pr.id_role = r.id_role');
		$CI->db->where($where, null);	
		$CI->db->where('pr.id_pegawai', $id_peg);
		$CI->db->where('n.tipe', 2);
		$CI->db->where('n.aktif', 1);
		$CI->db->group_by('n.id_nav');
		$CI->db->order_by('n.urut');
		
		$nav = $CI->db->get();

		foreach($nav->result() as $n) {
			
			$CI->db->from('nav n');
			$CI->db->where('id_par_nav', $n->id_nav);	
			$CI->db->where('tipe','2');
			$ch = $CI->db->get();
			
			$icon = (!empty($n->fa)) ? $n->fa :  'circle-o';
			if ($ch->num_rows() > 0) {
				$j = check_uris($n->id_nav);
			
				echo '<li class="treeview '.$j.'">
				<a href="#"><i class="fa fa-'.$icon.'"></i> <span>'.$n->judul.' </span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">';
				get_nav($id_peg,$ref,$app,$n->id_nav);
				echo '</ul>';
			} else {
				$j = uris($n->link);
				$j = !empty($j) ? 'class="active"':null;
				echo "<li ".$j.">".anchor($n->link,'<i class="fa fa-'.$icon.'"></i> <span>'.$n->judul.'</span>')."</li>";
			} 
			
		}
		
		
	}
	
	function get_ref_nav($id_peg) {
		
		$CI =& get_instance();
		$CI->load->database();	
		
		$CI->db->from('nav n');
		$CI->db->join('ref_aplikasi app','app.id_aplikasi = n.id_aplikasi');
		$CI->db->join('ref_role_nav r','r.id_nav = n.id_nav');
		$CI->db->join('pegawai_role pr', 'pr.id_role = r.id_role');
		$CI->db->where(array(
			'ref' => 2,
			'n.tipe' => 2,
			'n.aktif' => 1,
			'pr.id_pegawai' => $id_peg,
			'app.folder' => 'referensi',
			'(id_par_nav IS NULL OR id_par_nav = 0)' => null
		));
		$CI->db->order_by('n.urut');
		
		$nav = $CI->db->get();

		foreach($nav->result() as $n) {
			
			$CI->db->from('nav n');
			$CI->db->where('id_par_nav', $n->id_nav);	
			$CI->db->where('tipe','2');
			$CI->db->where('aktif','1');
			$ch = $CI->db->get();
			
			$icon = (!empty($n->fa)) ? $n->fa :  'circle-o';
			if ($ch->num_rows() > 0) {
				$j = check_uris($n->id_nav);
				echo '<li class="treeview '.$j.'">
				<a href="#"><i class="fa fa-'.$icon.'"></i> <span>'.$n->judul.' </span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">';
				get_nav($id_peg,2,1,$n->id_nav);
				echo '</ul>';
			} else {
				$j = uris($n->link);
				$j = !empty($j) ? ' class="active"':null;
				echo "<li".$j.">".anchor($n->link,'<i class="fa fa-'.$icon.'"></i> <span>'.$n->judul.'</span>')."</li>";
			} 
			
		}
		
		$ro = get_role($id_peg);
		foreach($ro['aplikasi']  as $k => $v) {
			if ($v['direktori'] != 'referensi') {

				$CI->db->from('nav n');
				$CI->db->join('ref_role_nav r','r.id_nav = n.id_nav');
				$CI->db->join('pegawai_role pr', 'pr.id_role = r.id_role');
				$CI->db->where('n.ref = 2 AND (id_par_nav IS NULL OR id_par_nav = 0) AND n.id_aplikasi = '.$v['id_aplikasi'], null);	
				$CI->db->where('pr.id_pegawai', $id_peg);
				$CI->db->where('n.tipe', 2);
				$CI->db->where('n.aktif', 1);
				$CI->db->group_by('n.id_nav');
		
				$cek = $CI->db->get();
		
				if ($cek->num_rows() > 0) {
				
		
				echo '<li class="treeview">
				<a href="#"><i class="fa fa-cog"></i> <span>'.$v['nama_aplikasi'].' </span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">';
				get_nav($id_peg,2,$v['id_aplikasi']);
				echo '</ul>';
				}
			}
		}
	}
	
	function merger($e,$b,$u) {
		
		$ub = ($u == $b) ? $u : $b.' '.$u;
		
		$e = explode(' ',strtoupper($e));
		$ue = explode(' ',strtoupper($ub));
		
		
		$ka = array();
		foreach($e as $ee) {
			if (!in_array(strtoupper($ee),$ue)) $ka = array_merge($ka,array(strtoupper($ee))); 
		}
		
		$ka = array_merge_recursive($ka,$ue);
		
		$kata = array();
		foreach($ka as $k) { $kata[] = substr(strtoupper($k),0,1).substr(strtolower($k),1); }
		return implode(' ',$kata);
		
	}
	
	function kalimat($e) {
		
		$e = explode(' ',strtoupper($e));
		$kata = array();
		foreach($e as $k) { $kata[] = substr(strtoupper($k),0,1).substr(strtolower($k),1); }
		return implode(' ',$kata);
	}

	function din_combo($params){ 

		$CI =& get_instance();
		$CI->load->database();

       // $params = json_decode($CI->input->post('params'));
        //$where = array();


            $CI->db->select($params['select'], FALSE);
            if (!empty($params['wheere'])) {
            	foreach ($params['where'] as $w_k => $w_v) {
            	 $CI->db->where($w_k, $w_v);
            }
            }
            
              if (is_array($params['table'])) {    
	            $n = 1;
	            foreach($params['table'] as $tab => $on) {
	    
	              if ($n > 1) {
	                    if (is_array($on)) $CI->db->join($tab,$on[0],$on[1]);
	                    else $CI->db->join($tab,$on);
	                } else { $CI->db->from($tab); }
	                $n+=1;
	            }
	        } else {
	        $CI->db->from($params['table']);
	        }
            $combo = $CI->db->get();

			// key & value dropdown
            $key = $params['key'];
            $val = $params['val'];
            
        if ($combo) {
           $results = array();
           $results[] = array('key'=>'', 'val'=>'--Pilih--');
            foreach ($combo->result() as $res) {
                $results[]= array('key'=>$res->$key, 'val'=>$res->$val);
            }

            // send to json
            die(json_encode($results));
        }
        
    }


	
	
?>