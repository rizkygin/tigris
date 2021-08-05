<?php
  class Ctemplate extends CI_Model{
      var $field;
      public function __construct()
      {
          parent::__construct();
          $this->field=array(
            'kop'=>"kop_surat",
          );
      }

}    
?>
