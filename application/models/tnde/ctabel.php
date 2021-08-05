<?php
      class Ctabel extends CI_Model{
          var $d;var $atr;
      public function __construct()
      {
          parent::__construct();
          $this->d=array(
                1 =>'master_golru',//6`
                2 =>'master_eselon',//7`
                3 =>'master_jabatan',//8`
                4 =>'master_pegawai',//9`
                5 =>'master_pegawai_riwayat',//12`
                6 =>'t_user',//22`
                7 =>'def_instansi',//23`
                8 =>'ref_yt',//42`
                9 =>'ref_jenis_file_upload',//43
                10=>'ref_bidang',//47`
                11=>'ref_level_bid',//48`
                12=>'ref_skpd',//100`
                13=>'ref_agama',//102`
                14=>'ref_jkel',//103`
                15=>'ref_lev',//`
                16=>'master_tempat',//`
                17=>'ref_sudah_belum',//`
                18=>'ref_negeri_swasta',//`
                19=>'t_login',//`
                20=>'master_template_surat',
                21=>'t_surat',
                22=>'ref_t_surat_jenis',
                23=>'ref_sifat_surat',
                24=>'vi_user',
                25=>'meymo',
                26=>'ref_kode_posisi',
                27=>'ref_bagian',
                28=>'t_posisi_masuk',
                29=>'t_posisi_keluar',
                30=>'t_log_masuk',
                31=>'t_log_keluar',
                32=>'vi_bagian',
                33=>'vi_last_posisi_sm',
                34=>'vi_last_posisi_surat',
                35=>'vi_last_posisi_surat_group_bag',
                36=>'vi_walk_posisi_surat',
                37=>'t_disposisi',
                38=>'vi_posisi_sm',
                39=>'vi_walk_posisi_surat_group',
                40=>'vi_surat_keluar',
                41=>'vi_last_posisi_sk',
                42=>'vi_last_posisi_suratk',
                43=>'vi_last_posisi_suratk_group_bag',
                44=>'t_ruang',
                45=>'t_almari',
                46=>'vi_posisi_dispo_sm',
                47=>'t_disposisi_sk',
                48=>'vi_posisi_dispo_sk',
                49=>'ref_kode_surat',
                50=>'t_lampiran_surat',
                51=>'t_carbon_copy',
                

                211=>'vi_surat_masuk',
                214=>'t_surat_keluar',
            );
          $this->atr=array(
                3=>array(//8
                    'tf'=>'h,t,c',
                    'cm'=>' , ,2',
                ),
                4=>array(//9
                    'tf'=>'t,t,t,t,t,t,c ,d,c ,c,t',
                    'cm'=>' , , , , , ,16, ,13,14,',
                ),
                5=>array(//12
                    'tf'=>'h,c,c,d,c,d,c ,c,h,c',
                    'cm'=>' ,4,1, ,3, ,10,8, ,12',
                ),
                6=>array(//22
                    'tf'=>'c,t,l,c ,c,l',
                    'cm'=>'4, , ,32,8',
                ),
                7=>array(//23
                    'tf'=>'h,t,t,t,t,t,t,t,c,t,c,f',
                    'cm'=>' , , , , , , , ,16, ,4',
                ),
                10=>array(//47
                    'tf'=>'h,t,t,c,c ,c ,c',
                    'cm'=>' , , ,4,15,10,12',
                ),
                12=>array(//100
                    'tf'=>'h,t,t,t,c',
                    'cm'=>' , , , ,12',
                ),
                15=>array(//100
                    'tf'=>'h,t,c',
                    'cm'=>' , ,8',
                ),
                20=>array(
                    'tf'=>'h,t,t,a,l,c',
                    'cm'=>' , , , , ,8',
                ),
                21=>array(
                    'tf'=>'h,c ,t,t,d,t,t,c ,t,t,c ,f,h,t,h,c ,h',
                    'cm'=>' ,22, , , , , ,23, , ,10, , , , ,26, ',
                ),
                27=>array(
                    'tf'=>'h,c ,c',
                    'cm'=>' ,15,10',
                ),
                28=>array(
                    'tf'=>'h,c ,c ,a,c ,c,c',
                    'cm'=>' ,21,27, ,26,27,6',
                ),
                29=>array(
                    'tf'=>'h,c ,c ,a,c ,c',
                    'cm'=>' ,21,27, ,26,28',
                ),
                30=>array(
                    'tf'=>'h,c ,c ,t ,c,d',
                    'cm'=>' ,26,27,27,6,',
                ),
                31=>array(
                    'tf'=>'h,c ,c ,c ,c,d',
                    'cm'=>' ,26,27,29,6,',
                ),
                37=>array(
                    'tf'=>'h,c ,c ,c,d',
                    'cm'=>' ,28,28,6,',
                ),
                49=>array(
                    'tf'=>'h,t,t',
                ),
               
                
            );
      }

    function attr($nod,$atr=0){
        $attr=array();
        if(isset($this->atr[$nod])){
            foreach ($this->atr[$nod] as $x => $isi){
                $isi=preg_replace('/ /','',$isi);
                $attr[$x]=explode(',',$isi);
//              if('cm'==$x)foreach ($attr['cm'] as $xx => $isix) if($isix>0)$attr[$x][$xx]=$this->d[$isix];
            } 
        }else{
            $attr['tf']=array_fill(0,count($this->f($nod)),'t');
            $attr['tf'][0]='h';
        }
        if($atr){
            if(isset($attr[$atr])){
                return $attr[$atr];
            }else{
                return false;
            }
        }else{
            return $attr;
        }
    }

    function f($nod,$atr=0){
        $f=$this->showfield($nod);
        return ($atr?$f[$atr]:$f);
    }

    function fl($nod){
        return $this->f($nod,'f');
    }

    function showfield($nod){
        $this->load->database();
        $q=$this->db->query("SHOW FULL FIELDS FROM ".$this->d[$nod]);
        if($q){
            foreach ($q->result() as $r){
                $f['f'][]=$r->Field;
                if("PRI"==$r->Key)$f['k'][]=$r->Field;
                $f['n'][]=("NO"==$r->Null?1:0);
            }
        }else{
            echo ld_err("MCtelShld-".$nod."(".$this->d[$nod].") Tidak tersedia/bisa di akses");
            show_404();
        }
        if($f){
            return $f;
        }else{
            echo ld_err("MCtelShld-".$nod." Tidak dikenal");
            show_404();
        }
    }
    
    function tes_table(){
        foreach ($this->d as $x => $valu) 
            if($this->showfield($x))$r[$x]=$valu." is OK";
        return $r;
    }

}    
?>