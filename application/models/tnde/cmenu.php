<?php
class Cmenu extends CI_Model {
    var $mycontrol;
    var $menu;
    var $menuitem;
    var $mymenu;
    var $smasuk;
    var $skeluar;
//    var $navsurat;
    public function __construct()
    {
        $this->mycontrol='tnde/';
        $this->menu=array(
             1 => "Referensi Golongan",
             2 => "Referensi Eselon",
             3 => "Referensi Jabatan",
             4 => "Referensi Pegawai",
             5 => "Referensi Riwayat Pegawai",
             6 => "Pengaturan Pengguna",//"Operator",
             7 => "Pengaturan Kop Surat",
            10 => "Referensi Bidang",
            11 => "Referensi Tempat",
            12 => "Referensi SKPD",
            15 => "Referensi Tingkatan Pengguna",
            19 => "Referensi Jenis Arsip",
            44 => "Referensi Ruang",
            45 => "Referensi Almari",
            49 => "Referensi Kode Surat",
            
            27 => "Referensi Bidang dan Pengaturan Alur Surat",
            
            120=> "Referensi Template surat",

            121=> "Input Surat Masuk ",
            122=> "Proses Surat Masuk ",
            123=> "Arsip Surat Masuk ",

            124=> "Arsip Surat Keluar ",
            125=> "Catatan ",
            126=> "Input Surat Keluar ",
            127=> "Arsip Surat Keluar Bernomor",
            
            301=> 'Arsip dan dokumen',
            
            701=> "Laporan",
            723=> "Laporan Surat Masuk",
            724=> "Laporan Surat Keluar",
            
            901=> "Pengaturan",
            902=> "Referensi",
            903=> "Surat Keluar",
            904=> "Surat Masuk",
            905=> "Pengarsipan",
            906=> "Laporan",
            907=> "Agendaris",
            908=> "Staf",
            909=> "Subag Umum",
            910=> "Sekretaris",
            911=> "Kepala",
            912=> "Bidang",
            913=> "Sub Bidang",
            914=> "Referensi Pegawai",
            920=> "Referensi Pengguna",
            921=> "Referensi Surat",
            
        );
        
        $this->menuitem=array(
            1   =>$this->c_link($this->menu[1],'lister/1'),
            2   =>$this->c_link($this->menu[2],'lister/2'),
            3   =>$this->c_link($this->menu[3],'lister/3'),
            4   =>$this->c_link($this->menu[4],'lister/4'),
            5   =>$this->c_link($this->menu[5],'lister/5'),
            6   =>$this->c_link($this->menu[6],'lister/6'),
            7   =>$this->c_link($this->menu[7],'lister/7'),
            10  =>$this->c_link($this->menu[10],'lister/10'),
            11  =>$this->c_link($this->menu[11],'lister/11'),
            12  =>$this->c_link($this->menu[12],'lister/12'),
            15  =>$this->c_link($this->menu[15],'lister/15'),
            27  =>$this->c_link($this->menu[27],'lister/27'),
            44  =>$this->c_link($this->menu[44],'lister/44'),
            45  =>$this->c_link($this->menu[45],'lister/45'),
            49  =>$this->c_link($this->menu[49],'lister/49'),
            120 =>$this->c_link($this->menu[120],'lister/20'),
            127 =>$this->c_link($this->menu[127],'lister/2140821'),
            121 =>$this->c_link($this->menu[121],'lister/211071'),
            122 =>$this->c_link($this->menu[122],'lister/2110710'),
            123 =>$this->c_link($this->menu[123],'lister/2110710'),
            
            701=>$this->c_link('<div class="icon-print"></div>'." ".$this->menu[701]),
            723 =>$this->c_link($this->menu[723],'list_mod/723'),
            724 =>$this->c_link($this->menu[724],'list_mod/724'),
            
            921=>$this->c_link($this->menu[921]),
            901=>$this->c_link('<div class="icon-cog"></div>'." ".$this->menu[901]),
            902=>$this->c_link('<div class="icon-th-list"></div>'." ".$this->menu[902]),
            904=>$this->c_link('<div class="icon-file"></div>'." ".$this->menu[904]),
            903=>$this->c_link('<div class="icon-envelope"></div>'." ".$this->menu[903]),
            907=>$this->c_link($this->menu[907]),
            908=>$this->c_link($this->menu[908]),
            909=>$this->c_link($this->menu[909]),
            910=>$this->c_link($this->menu[910]),
            911=>$this->c_link($this->menu[911]),
            912=>$this->c_link($this->menu[912]),
            913=>$this->c_link($this->menu[913]),
            914=>$this->c_link($this->menu[914]),
            920=>$this->c_link($this->menu[920]),

            //            
            221031   =>$this->c_link($this->menu[121],'list_surat/211031'),
            2210310  =>$this->c_link($this->menu[122],'list_surat/2110310'),
            2210311  =>$this->c_link($this->menu[123],'list_surat/2110311'),

            214072  =>$this->c_link($this->menu[122],'list_surat/214072'),
            2140720 =>$this->c_link($this->menu[123],'list_surat/2140720'),
            214082  =>$this->c_link($this->menu[122],'list_surat/214082'),
            2140820 =>$this->c_link($this->menu[123],'list_surat/2140820'),
/*            12231   =>$this->c_link($this->menu[122],'lister/211031'),
            122310  =>$this->c_link($this->menu[123],'lister/2110310'),

            214072  =>$this->c_link($this->menu[122],'lister/214072'),
            2140720 =>$this->c_link($this->menu[123],'lister/2140720'),
            214082  =>$this->c_link($this->menu[122],'lister/214082'),
            2140820 =>$this->c_link($this->menu[123],'lister/2140820'),
*/            
            211011 =>$this->c_link($this->menu[121],'list_surat/211011'),
            2110110 =>$this->c_link($this->menu[122],'list_surat/2110110'),
            2110111 =>$this->c_link($this->menu[123],'list_surat/2110111'),
            
            214011 =>$this->c_link($this->menu[126],'list_surat/214011'),
            2140110 =>$this->c_link($this->menu[124],'list_surat/2140110'),
            2140111 =>$this->c_link($this->menu[127],'list_surat/2140111'),

            211911 =>$this->c_link($this->menu[121],'list_surat/211011/&sbg'),
            2119110 =>$this->c_link($this->menu[122],'list_surat/211011'),
            2119111 =>$this->c_link($this->menu[123],'list_surat/2110111/&sbg'),
            
            214911 =>$this->c_link($this->menu[126],'list_surat/214011/&sbg'),
            2149110 =>$this->c_link($this->menu[124],'list_surat/214011'),
            2149111 =>$this->c_link($this->menu[127],'list_surat/2140111/&sbg'),
            
            /*12251   =>$this->c_link($this->menu[122],'lister/211051'),
            122510  =>$this->c_link($this->menu[123],'lister/2110510'),
            12221   =>$this->c_link($this->menu[122],'lister/211021'),
            122210  =>$this->c_link($this->menu[123],'lister/2110210'),
            12241   =>$this->c_link($this->menu[122],'lister/211041'),
            122410  =>$this->c_link($this->menu[123],'lister/2110410'),
            12261   =>$this->c_link($this->menu[122],'lister/211061'),
            122610  =>$this->c_link($this->menu[123],'lister/2110610'),*/
            
            /*214022  =>$this->c_link($this->menu[122],'lister/214022'),
            2140220 =>$this->c_link($this->menu[123],'lister/2140220'),
            214032  =>$this->c_link($this->menu[122],'lister/214032'),
            2140320 =>$this->c_link($this->menu[123],'lister/2140320'),
            214042  =>$this->c_link($this->menu[122],'lister/214042'),
            2140420 =>$this->c_link($this->menu[123],'lister/2140420'),
            214052  =>$this->c_link($this->menu[122],'lister/214052'),
            2140520 =>$this->c_link($this->menu[123],'lister/2140520'),
            214062  =>$this->c_link($this->menu[122],'lister/214062'),
            2140620 =>$this->c_link($this->menu[123],'lister/2140620'),*/
            
        );
        
        $this->smasuk=array(
            0=>array(
                    $this->menuitem[211011],
                    $this->menuitem[2110111],
            ),
            1=>array(
                    $this->menuitem[211911],
                    $this->menuitem[2119110],
                    $this->menuitem[2119111],
            ),
        );
            
        $this->skeluar=array(
            0=>array(
                    $this->menuitem[214011],
                    $this->menuitem[2140111],
            ),
            1=>array(
                    $this->menuitem[214911],
                    $this->menuitem[2149110],
                    $this->menuitem[2149111],
            ),
        );
        
        $this->mymenu=array(
        //admin
            1=>array(
                $this->menuitem[902]=>array(
                    $this->menuitem[914]=>array(
                        $this->menuitem[12],
                        $this->menuitem[10],
                        $this->menuitem[1],
                        $this->menuitem[2],
                        $this->menuitem[3],
                        $this->menuitem[4],
                        $this->menuitem[5],
                    ),
                    $this->menuitem[921]=>array(
                        $this->menuitem[11],
                        $this->menuitem[44],
                        $this->menuitem[45],
                        $this->menuitem[120],
                        $this->menuitem[49],
                    ),
                    $this->menuitem[920]=>array(
                        $this->menuitem[15],
                        $this->menuitem[27],
                    ),
                ),
                $this->menuitem[901]=>array(
                    $this->menuitem[6],
                    $this->menuitem[7],
                ),
                $this->menuitem[904]=>$this->smasuk[0]
                ,
                $this->menuitem[903]=>$this->skeluar[0]
                ,
                $this->menuitem[701]=>array(
                    $this->menuitem[723],
                    $this->menuitem[724],
                ),
               ),
            // Kepala   
 /*           2=>array(
                $this->menuitem[904]=>array(
//                    $this->menuitem[12221],
//                    $this->menuitem[122210],
                    $this->menuitem[12231],
                    $this->menuitem[122310],
                ),
                $this->menuitem[903]=>array(
                    $this->menuitem[214022],
                    $this->menuitem[2140220],
                ),
            ),
            //Sekertaris
            3=>array(
                $this->menuitem[904]=>array(
                    $this->menuitem[12231],
                    $this->menuitem[122310],
//                    $this->menuitem[12231],
//                    $this->menuitem[122310],
                ),
                $this->menuitem[903]=>array(
                    $this->menuitem[214032],
                    $this->menuitem[2140320],
                ),
            ),
            //KaBid
            4=>array(
                $this->menuitem[904]=>array(
//                    $this->menuitem[12241],
//                    $this->menuitem[122410],
                    $this->menuitem[12231],
                    $this->menuitem[122310],
                ),
                $this->menuitem[903]=>array(
                    $this->menuitem[214042],
                    $this->menuitem[2140420],
                ),
            ),
            //Kasubag
            5=>array(
                $this->menuitem[904]=>array(
//                    $this->menuitem[12251],
//                    $this->menuitem[122510],
                    $this->menuitem[12231],
                    $this->menuitem[122310],
                ),
                $this->menuitem[903]=>array(
                    $this->menuitem[214052],
                    $this->menuitem[2140520],
                ),
            ),
            //KaSuBid
            6=>array(
                $this->menuitem[904]=>array(
//                    $this->menuitem[12261],
//                    $this->menuitem[122610],
                    $this->menuitem[12231],
                    $this->menuitem[122310],
                ),
                $this->menuitem[903]=>array(
                    $this->menuitem[214062],
                    $this->menuitem[2140620],
                ),
            ),
            //Agendaris
            7=>array(
                $this->menuitem[904]=>array(
                    $this->menuitem[122],
                    $this->menuitem[123],
                ),
                $this->menuitem[903]=>array(
                    $this->menuitem[214072],
                    $this->menuitem[2140720],
                ),
            ),
            //Staff
            8=>array(
                $this->menuitem[903]=>array(
                    $this->menuitem[214082],
                    $this->menuitem[2140820],
                ),
            ),*/
        );
        /*
        $this->navsurat=array(
            1=>array(),
            
//2    kepala
            2=>array(
                '211031',
//                '211021',
                '214022',
            ),
//3    Sekertaris
            3=>array(
                '211031',
//                '211031',
                '214032',
            ),
//4    Kabid
            4=>array(
                '211031',
//                '211041',
                '214042',
            ),
//5    Kasubag
            5=>array(
                '211031',
//                '211051',
                '214052',
            ),
//6    Kasubid
            6=>array(
                '211031',
//                '211061',
                '214062',
            ),
//7    Agendaris
            7=>array(
                '211071',
                '214072',
            ),
//8    staf
            8=>array(
                1=>
                '214082',
            )
        );*/

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
//    load di system menu
    function get_menu($id) {
        /*$a_ism=array(
            'sm'=>array(121,122,123),
            'sm1'=>array(221031,2210310,2210311),
            'nsk'=>array(214072,214082),
            'nsk1'=>array(2140720,2140820),
        );
        $s_sbg=array_fill(0,3,'/$sbg/');                    
        $a_sbg=array_fill(0,3,sesi('id_bag'));                    */
        foreach ($this->smasuk[1] as $x => $valu) $smasuk_sbg[$x]=preg_replace('/&sbg/',sesi('id_bag'),$valu);
        foreach ($this->skeluar[1] as $x => $valu) $skeluar_sbg[$x]=preg_replace('/&sbg/',sesi('id_bag'),$valu);
        if($id){
            if(1==$id){
                // admin
                return $this->mymenu[1];
            }else{
                $s_masuk=array();
                //jika di beri kewenangan
                if($sm=count(sesiaturan('dn'))+count(sesiaturan('up'))){
/*                    $_s_masuk=array();
                    foreach ($a_ism[(sesiaturan('sm')?'sm':'sm1')] as $va)$_s_masuk[]= $this->menuitem[$va];*/
                    $s_masuk=array(
                        $this->menuitem[904]=>$smasuk_sbg,
//                        $_s_masuk,
                    /*array(
                        (sesiaturan('sm')?$this->menuitem[121]:$this->menuitem[221031]),
                        (sesiaturan('sm')?$this->menuitem[122]:$this->menuitem[2210310]),
                        (sesiaturan('sm')?$this->menuitem[123]:$this->menuitem[2210311]),
                    ),*/
                    );
                }
                $s_keluar=array();
                if($sk=count(sesiaturan('dnk'))+count(sesiaturan('upk'))+sesiaturan('nsk')){
//                    $_s_keluar=array();
//                    foreach ($a_ism[(sesiaturan('nsk')?'nsk':'nsk1')] as $va)$_s_keluar[]= $this->menuitem[$va];
                    $s_keluar=array(
//                    $this->menuitem[903]=>$_s_keluar,
                        $this->menuitem[903]=>$skeluar_sbg,
/*                    array(
                        (sesiaturan('nsk')?$this->menuitem[214072]:$this->menuitem[214082]),
                        (sesiaturan('nsk')?$this->menuitem[2140720]:$this->menuitem[2140820]),
                    ),
*/                    );

                }
                return $s_masuk+$s_keluar;
            }
        }else{
            return array();
        }
        
    }

//    load di system menu
    function get_navsurat($id) {
        if($id){
            $s_masuk='';
            if($sm=count(sesiaturan('dn'))+count(sesiaturan('up'))){
                $s_masuk=(sesiaturan('sm')?'211071':'211031');//agend:sekret
            }
            $s_keluar='';
            if($sk=count(sesiaturan('dnk'))+count(sesiaturan('upk'))+sesiaturan('nsk')){
                $s_keluar=(sesiaturan('nsk')?'214072':'214082');//agend:staf
            }
            return array($s_masuk,$s_keluar);
        }else{
            return array();
        }
    }
    
    public function get_da($def_da=0){
        $def_da['menu']=& $this->menu;
        return $def_da;
    }
    
    function c_link($menu,$link='',$outside=0){
        if($link){
            return anchor(($outside?'':$this->mycontrol).$link,$menu);
        }else{
            return anchor('#',$menu,'class="dropdown-toggle" data-toggle="dropdown"');
        }
    }

}
?>