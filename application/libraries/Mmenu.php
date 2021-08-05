<?php
  if (!defined('BASEPATH')) { exit('No direct script access allowed'); }
  class Mmenu{
    var $debug=0;
    private $CI;
    var $id_peg=0;
    var $no_home=0;
    var $folder;
    var $uri;
    var $mnu=array();
    var $is_ref=1;#non ref =1 ,ref=2
    var $def_pulldown='<i class="fa fa-angle-left pull-right"></i>';
    var $def_fa="circle-o";
    
    var $attr=array(
        'ul'=>'class="sidebar-menu" style="margin-bottom:130px;"',
        'ullia'=>'class="treeview active"',
        'ulli'=>'class="treeview"',
        'ulliul'=>'class="treeview-menu"',
        'lia'=>'class="active"',
        'li'=>"",
        'a'=>"",
    );
    
    public function __construct($params="")
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->helpers('url');
        if($params){
            $this->no_home=!empty($params['no_home']);
            if(!empty($params['is_ref']))$this->is_ref=$params['is_ref'];
            if(!empty($params['id_peg']))$this->id_peg=$params['id_peg'];
            if(!empty($params['folder']))$this->folder=$params['folder'];
            if(!empty($params['attr']))$this->folder=$params['attr'];
            if(!empty($params['uri']))$this->uri=$params['uri'];
            if(!empty($params['def_fa']))$this->def_fa=$params['def_fa'];
            #cek(array($params));
        }
        if(!$this->folder)$this->folder=$this->CI->uri->segment(1);
        if(!$this->uri)$this->uri=uri_string();
        $sesid_peg=$this->CI->session->userdata('id_pegawai');
        if(!$this->id_peg)$this->id_peg=(!empty($sesid_peg)?$sesid_peg:0);
        #cek(array($this->uri));
    }
    
    function getmenu($is_ref=0,$folder="",$id_peg="",$attr="") {
        $ref=($is_ref?$is_ref:$this->is_ref);
        if(!$folder)$folder=$this->folder;
        if(!$this->no_home)
        $this->mnu[]=(object)array(
            'id_nav'=>0,
            'id_par_nav'=>'',
            'judul'=>"Beranda",
            'link'=>$folder."/Home",
            'fa'=>"home",
        );
        if(!$id_peg)$id_peg=$this->id_peg;
        $sql="SELECT
                n.*
                FROM nav n
                JOIN ref_aplikasi ra ON ra.`id_aplikasi`=n.`id_aplikasi` AND ra.`folder`='$folder'
                JOIN ref_role_nav rn ON rn.`id_nav`=n.`id_nav`
                JOIN pegawai_role pr ON pr.`id_role`=rn.`id_role` AND pr.`id_pegawai`=$id_peg
                WHERE 
                n.`aktif`=1
                AND n.`ref`=$ref
                AND n.`tipe`=2
                GROUP BY n.`id_nav`
                ORDER BY n.`id_par_nav`,n.`urut`";
        
        $ng=$this->CI->db->query($sql);
        #cek($this->CI->db->last_query());
        $aktiv=0;
        if($ng)
        foreach ($ng->result() as $r) {
            $this->mnu[$r->id_nav]=$r;
            if(!$aktiv && $this->is_aktiv($r->link))$aktiv=$r->id_nav;
            if($r->id_par_nav>0)$this->mnu[$r->id_par_nav]->par[]=$r->id_nav;
        }
        if($aktiv>0){
            $p=$this->mnu[$aktiv];
            $this->mnu[$p->id_nav]->isaktif=1;
            while($p->id_par_nav) {
                $p=$this->mnu[$p->id_par_nav];
                $this->mnu[$p->id_nav]->isaktif=1;                
            }            
        }
        #cek(array($this->mnu,#$this->ranting()));
        return $this->ranting();
    }
    
    function is_aktiv($url) {
        $urn=explode('/',$url);
        return $urn===(array_slice(explode('/',$this->uri),0,count($urn)));
    }
    
    function ranting($id_nav=0) {
        $li="";
        $stel=($id_nav?$this->mnu[$id_nav]->par:$this->mnu);
        foreach ($stel as $idnav => $p){
            $dnav=(!$id_nav ? $p:$this->mnu[$p]);
            if(isset($dnav->id_nav) && (((!$id_nav)&&(!$dnav->id_par_nav))||($id_nav ))){
                $ada_anak=(isset($dnav->id_nav) && isset($dnav->par) );
                $arrowright=($ada_anak?" ".$this->def_pulldown:"");
                $anc=anchor($dnav->link,"<i class='fa fa-".($dnav->fa?$dnav->fa:$this->def_fa)."'></i><span>".$dnav->judul."</span>".$arrowright,$this->attr['a']);
                $lianak="";
                if($ada_anak)$lianak=$this->ranting($dnav->id_nav);
                $attr=($ada_anak ?( isset($dnav->isaktif)?'ullia':'ulli'):( isset($dnav->isaktif)?'lia':'li'));
                $att=$this->attr[$attr];
                $li.="<li $att>$anc $lianak</li>";
                
            }
        }
        #stop($li);
        $attrul=($id_nav?$this->attr['ulliul']:$this->attr['ul']);
        return "<ul $attrul>$li</ul>";    
    }
    
    /*function rantingx($id_nav=0) {
        $li="";
        if(!$id_nav){
            foreach ($this->mnu as $idnav => $dnav)
            if(!$dnav->id_par_nav){
                $ada_anak=isset($dnav->par);
                $arrowright=($ada_anak?" ".$this->def_pulldown:"");
                $li.=li(
                    anchor($dnav->link,"<i class='fa fa-".($dnav->fa?$dnav->fa:$this->def_fa)."'></i>".span($dnav->judul).$arrowright,$this->attr['a'])
                    .($ada_anak?$this->ranting($idnav):"")
                ,$ada_anak?$this->attr['ulli']:"");
            }
        }else{
            foreach ($this->mnu[$id_nav]->par as $p) {
                $dnav=$this->mnu[$p];
                $ada_anak=isset($dnav->par);
                $arrowright=($ada_anak?" ".$this->def_pulldown:"");
                $li.=li(
                    anchor($dnav->link,"<i class='fa fa-".($dnav->fa?$dnav->fa:$this->def_fa)."'></i>".span($dnav->judul).$arrowright,$this->attr['a'])
                    .($ada_anak?$this->ranting($idnav):"")
                ,$ada_anak?$this->attr['ulli']:"");
            }
        }
        return ul($li,($id_nav?$this->attr['ulliul']:$this->attr['ul']));    
    }*/
  }
?>
