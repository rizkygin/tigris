<?php
class Creport extends CI_Model {
    var $report;
    public function __construct()
    {
        $this->load->database();
        $this->report=array(
            1=>array(
                'nama'=>"track_surat_masuk",
                'file'=>'view_surat_keluar_box',
                'dir'=>'page/rpt/',
            ),
            2=>array(
                'nama'=>"track_surat",
                'file'=>'track',
                'dir'=>'page/rpt/',
            ),
            3=>array(
                'nama'=>"track_surat",
                'file'=>'view_surat_keluar_box_paraf',
                'dir'=>'page/rpt/',
            ),
            4=>array(
                'nama'=>"Laporan Surat",
                'file'=>'laporanlist',
                'dir'=>'page/',
            ),
        );
    }
    
/*    id_level    nama_lev
1    Administrator
2    Kepala
3    Sekertaris
4    KaBid
5    Kasubag
6    KaSuBid
7    Agendaris
8    Staff
*/    
    function get_report($id) {
        return tesnull($this->report[$id],false);
    }
    
    function load_report($rpt,$ids,$sk=0){
        $this->load->model('tnde/mydata');
        if(!$ids) return false;
        $dt['c']=$this->report[$rpt];
         switch($rpt){
             case 1:
             case 2:
             case 3:

                 //surat_tugas
                $dt['dtc']['kop']=$this->mydata->get_ntable(7,'*',1);
                $dt['dtc']['bag']=$this->mydata->get_ntable(32,'*');
                $dt['dtc']['data']=$this->mydata->get_ntable(43,'*',array($ids));
                if(1==count($dt['dtc']['data']['td'])){
                    $dt['dtc']['track']=$this->mydata->get_ntable(48,'*',array(1=>$ids));
                }elseif($dt['dtc']['data']=$this->mydata->get_ntable(35,'*',array($ids))){
                    $dt['dtc']['track']=$this->mydata->get_ntable(46,'*',array(1=>$ids));    
                    $dt['dtc']['surat_masuk']=1;
                }
                $dt['dtc']['dg_kop']=1;

//                 $dt['cek']=$dt;
                 break;

         }
         return $dt;
//         setsesi('sql',$this->da['lap'][7]==$rpt);
    }     
    


}
?>