<?php
      class Mix extends CI_Model{
        var $menu;
        var $menu_surat;
      public function __construct()
      {
        parent::__construct();
        $this->load->model('tnde/mydata');
        $this->load->model('tnde/cmenu');
        $this->menu= $this->cmenu->get_menu(islogin());
        if($this->menu_surat= $this->cmenu->get_navsurat(islogin())){
            $this->menu_surat[10]=(tesnull($this->menu_surat[0])?$this->mydata->get_info_ql($this->menu_surat[0]):0);
            $this->menu_surat[11]=(tesnull($this->menu_surat[1])?$this->mydata->get_info_ql($this->menu_surat[1]):0);
        }
      }
      function load_menu() {return array($this->menu,$this->menu_surat);}
}    
?>