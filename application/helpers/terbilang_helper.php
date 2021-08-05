<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*  mr.febri@gmail.com
*  ci.213
*  v.01
*/
function terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12):
    return " " . $abil[$x];
  elseif ($x < 20):
    return terbilang($x - 10) . "belas";
  elseif ($x < 100):
    return terbilang($x / 10) . " puluh" . terbilang($x % 10);
  elseif ($x < 200):
    return " seratus" . terbilang($x - 100);
  elseif ($x < 1000):
    return terbilang($x / 100) . " ratus" . terbilang($x % 100);
  elseif ($x < 2000):
    return " seribu" . terbilang($x - 1000);
  elseif ($x < 1000000):
    return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000):
    return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
  elseif ($x < 1000000000000):
    return terbilang($x / 1000000000) . " milyar" . terbilang($x % 1000000000);
  elseif ($x < 1000000000000000):
    return terbilang($x / 1000000000000) . " trilyun" . terbilang($x % 1000000000000);
  endif;
}
?>
