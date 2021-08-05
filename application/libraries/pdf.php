<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf {
    
    function Pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($options=null)
    {
        include_once APPPATH.'/third_party/mpdf60/mpdf.php';
           if (!empty($options)) {
               $parameters=$options;
           }else{
           $parameters= array(
                'mode' => 'en-AU',
                'format' => 'A4',    // A4-L for portrait
                'default_font_size' => '12',
                'default_font' => 'Helvetica',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 40,
                'margin_bottom' => 15,
                'margin_header' => 5,
                'margin_footer' => 10,
                'orientation' => 'P' // For some reason setting orientation to "L" alone doesn't work (it should), you need to also set format to "A4-L" for landscape
            );
   }
            
        
        return new mPDF($parameters['mode'], $parameters['format'],
                         $parameters['default_font_size'], $parameters['default_font'],
                         $parameters['margin_left'], $parameters['margin_right'],
                         $parameters['margin_top'], $parameters['margin_bottom'],
                         $parameters['margin_header'], $parameters['margin_footer'],
                         $parameters['orientation']);
    }
}


