<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }
  class Bc{
    var $debug=0;
    var $ver='1';
    var $CI;
    var $uri;
    
    public function __construct ($param="") {
        $this->uri=uri_string();
        if($param && !empty($param['uri']))$this->uri=$param['uri'];
        $this->CI =& get_instance();
    #    $this->CI->load->model('general_model');
    }  
    
    function ret_bc() {
        return $this->bc($this->uri);
    }
    
    /** v:1.0
    * link address
    */
    function bc($link) {
        $bc=array();
        if(
        $d=$this->CI->general_model->datagrab(array(
            'tabel'=>array(
                'nav n0'=>'',
                'nav n1'=>array('n1.id_nav=n0.id_par_nav','left'),
                'nav n2'=>array('n2.id_nav=n1.id_par_nav','left'),
                'nav n3'=>array('n3.id_nav=n2.id_par_nav','left'),
            ),
            'where'=>array('n0.link'=>$link),
            'select'=>'n0.*,n1.judul judul1,n1.link link1
                ,n2.judul judul2,n2.link link2
                ,n3.judul judul3,n3.link link3',
           ))->row()){
               if($d->judul3 >'')if($d->link3){$bc[$d->link3]=$d->judul3;}else{$bc[]=$d->judul3;}
               if($d->judul2 >'')if($d->link2){$bc[$d->link2]=$d->judul2;}else{$bc[]=$d->judul2;}
               if($d->judul1 >'')if($d->link1){$bc[$d->link1]=$d->judul1;}else{$bc[]=$d->judul1;}
               if($d->judul >'') $bc[$d->link]=$d->judul;
           }       
        return $bc;
    }
  }
?>
