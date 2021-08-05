<?php
class Cdata extends CI_Model {
    var $upload_dir;
    var $mycontrol;
    var $d;
    var $menu;
//    var $atr;
//    var $report;
    var $listr;
    public function __construct()
    {
        $this->mycontrol='tnde/';
        $this->load->helper(array('cmd','msg'));
        $this->upload_dir=upload_folder();
        $this->load->model('tnde/ctabel');
        $this->d=& $this->ctabel->d;
//        $this->atr=& $this->ctabel->atr;
        $this->load->model('tnde/cmenu');
        $this->menu=& $this->cmenu->menu;

/*        $this->report=array(
            1=>'rpt_spt',
            2=>'rpt_sppd',
            3=>'rpt_rincian_biaya_person',
            4=>'rpt_daftar_tanda_terima',
            5=>'rpt_kwitansi_belanja',
            7=>'rpt_list',
            8=>'rpt_sisa',
            9=>'rpt_spt_usulan',
            10=>'rpt_personil',
            11=>'rpt_kwitansi_panjar',
        );
*/        
        $inputsur="SELECT id_surat, no_agenda, nomor_surat, tgl_surat, perihal, subjek, nama_sifat sifat, dari, alamat ";
        $inputsur_laporan="SELECT id_surat, tgl_surat tanggal_surat, perihal, nomor_surat, no_agenda, subjek, nama_sifat sifat, dari, alamat ";

        $dir_file=", nama_dir, nama_file,id_posisi,ringkasan,id_bag ";

        $inputsurk="SELECT id_surat, nomor_surat, tgl_surat, perihal, subjek, nama_sifat sifat, kepada, alamat ";
        
        $kodisi=", concat(kodisi,' di ',next_nama_level_bagian,' ',next_nama_bidang_bagian ) Posisi";
        $kondisism=", concat(kondisi_sm, if(kode=5 or kode=4,concat(' pada ',nama_level_bagian,'(',nama_bidang_bagian,')'),concat(' di ',next_nama_level_bagian,'(',next_nama_bidang_bagian,')') )) Posisi";
        $dir_filesk=$kodisi.", id_posisi ";

        $syarat_nama_posisi=" (NOT ISNULL(nama_file)) AND (kode_posisi=1) ";
        $syarat_proses=" (kode=1)  ";
        $syarat_arsip=" (kode=4 or kode=5)  ";//" (NOT ISNULL(nama_file))  ";

        $syarat_sk_posisi=" (kode_posisi=1) ";

        $kondisi=", if(kode=4 or kode =5,concat(kodisi,' oleh ',nama_level_bagian,'(',nama_bidang_bagian,')'),concat(kodisi,' di ',next_nama_level_bagian,'(',next_nama_bidang_bagian,')')) status";
        
        $kondisisk=", if(kode=4 or kode =5 or kode =9,concat(kondisi_sk,' oleh ',nama_level_bagian,'(',nama_bidang_bagian,')'),concat(kondisi_sk,' di ',next_nama_level_bagian,'(',next_nama_bidang_bagian,')')) status";

        $arsipp="SELECT id_surat, no_agenda, nomor_surat, tgl_surat, perihal, subjek, nama_sifat sifat, dari, alamat, kodisi status , nama_file ,nama_dir,id_posisi,lev_user FROM ".$this->d[39].' ';
/*
            0=>array(
                't'=>1,
                'h2'=>$this->menu[1],
                'breadcrumb' => array('' => $this->menu[902], $this->mycontrol.'lister/1' =>$this->menu[1]),
                'ql'=>"SELECT * FROM master  ",
                'ff'=>array(1=>'Golongan'),
                'lty'=>array(1=>'1','d'),
                'noadd'=>1,
                'maxql'=>8,
                'lplus'=>array(
//                    'link'=>site_url('surat_keluar').'/0/&me/&sbg',
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="window.location.replace(\''.site_url($this->mycontrol.'surat_keluar').'/0/&me/&sbg\')"',
                    ),
                'laksi'=>array(
                    'e2'=>'e2',
                    'd'=>'d',
                    'pn2'=>'pn2',
//                    'xw'=>'xw',
                    'trk'=>'trk',
                    'rp1'=>'rp1',
                    ),
            ),
*/        
        $this->listr=array(
            1=>array(//7
                't'=>1,
                'h2'=>$this->menu[1],
                'breadcrumb' => array('' => $this->menu[902], $this->mycontrol.'lister/1' =>$this->menu[1]),
                'ql'=>"SELECT id_golru,nama_golru `Golongan Ruang`,pangkat FROM (`master_golru`)  ",
                'ff'=>array(1=>'Golongan'),
                'noadd'=>1,
                'laksi'=>array(),
            ),
            2=>array(//8
                't'=>2,
                'h2'=>$this->menu[2],
                'ql'=>"SELECT id_eselon,nama Eselon FROM (`master_eselon`) ",
                'ff'=>array(1=>'Eselon'),
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/2' => $this->menu[2]),
                'noadd'=>1,
                'laksi'=>array(),
            ),
            3=>array(//9
                't'=>3,
                'h2'=>$this->menu[3],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/3' => $this->menu[3]),
                'ql'=>"SELECT `a`.`id_jabatan`, `a`.`nama_jabatan`, `a2`.`nama` Eselon FROM (`master_jabatan` a) LEFT JOIN `master_eselon` a2 ON `a`.`id_eselon`=`a2`.`id_eselon` ",
                'ff'=>array(2=>'Eselon'),
                'noadd'=>1,
                'laksi'=>array(),

                ),
            4=>array(//10
                't'=>4,
                'h2'=>$this->menu[4],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/4' => $this->menu[4]),
                'ql'=>"SELECT 
        a.nip,concat(ifnull(a.gelar_depan,''),' ', a.nama_pegawai,' ',ifnull(a.gelar_belakang,'')) nama_pegawai, a.nip_lama, a.alamat
        , a4.nama_wilayah tempat_lahir, DATE_FORMAT(a.tanggal_lahir,'%d/%m/%Y')  tanggal_lahir, a6.agama
        , a7.jenis_kelamin, a.email `e-mail`, if(ifnull(a8.nip,'')='','Belum Ada','Sudah Ada') Riwayat 
    FROM (master_pegawai a)
    LEFT JOIN master_tempat a4 ON a.id_tempat_lahir=a4.id_tempat
    LEFT JOIN ref_agama a6 ON a.id_agama=a6.id_agama
    LEFT JOIN ref_jkel a7 ON a.id_jenis_kelamin=a7.id_jenis_kelamin"
    ." LEFT JOIN vi_pegawai_aktif a8 ON a.nip=a8.nip",
                'ff'=>array(6=>'Tempat Lahir',8=>'Agama','Jenis Kelamin'),
                'mustshow'=>1,
                'noadd'=>1,
                'laksi'=>array(),
                ),
            5=>array(//13
                't'=>5,
                'h2'=>$this->menu[5],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/5' => $this->menu[5]),
                'ql'=>"SELECT a.id_riwayat, a.nip, a1.nama_pegawai nama, a2.nama_golru Golru, a4.nama_jabatan Jabatan,  a6.nama_bidang Bidang
FROM (master_pegawai_riwayat a)
LEFT JOIN master_pegawai a1 ON a.nip=a1.nip
LEFT JOIN master_golru a2 ON a.id_golru=a2.id_golru
LEFT JOIN master_jabatan a4 ON a.id_jabatan=a4.id_jabatan
LEFT JOIN ref_bidang a6 ON a.id_bidang=a6.id_bidang
LEFT JOIN ref_yt a7 ON a.aktif=a7.id_yt
order by a.id_jabatan
",
                'ff'=>array(1=>'Nama','golongan','TMT golongan','jabatan','TMT jabatan','Unit kerja/Sub','riwayat terakhir',9=>'SKPD'),
                'noadd'=>1,
'laksi'=>array(
                ),/*'qf'=>array('Nama'=>'a1.nama_pegawai',),*/
            ),
            6=>array(//1
                't'=>6,
                'h2'=>$this->menu[6],
                'breadcrumb' => array('' => 'Pengaturan', $this->mycontrol.'lister/6' => $this->menu[6]),
//                'f'=>'101','i'=>1,
                'ql'=>"SELECT nip ,user username, nama_pegawai nama, nama_level tingkatan, nama_bidang unit from vi_user ",
//                'ff'=>array('nama','password','tingkatan'),
                'mustshow'=>1,
                ),     
            7=>array(//23
                't'=>7,'h2'=>$this->menu[7],
                'breadcrumb' => array('' => 'Pengaturan', $this->mycontrol.'lister/7' => $this->menu[7]),
                'ql'=>"SELECT a.id_ref, a.nama pejabat, a.judul_1  Pemerintahan, a.judul_2 `Instansi/SKPD`, a.alamat_1 alamat, a.alamat_2 kota, a.alamat_email, a.nama_kepala pejabat_penetap, a11.nama_wilayah tempat, a.nama_kabupaten Kabupaten, a10.nama_pegawai nama_kepala, if(ifnull(a.logo,'')='','belum ada','ada') logo
FROM (def_instansi a)
LEFT JOIN master_pegawai a10 ON a.kepala=a10.nip "
."LEFT JOIN master_tempat a11 ON a.tempat=a11.id_tempat"
,
                'ff'=>array(1=>'pejabat','Pemerintahan','Instansi / SKPD','alamat','kota','alamat email','pejabat penetap','tempat','Nama Kabupaten','pejabat','logo'),
                'noadd'=>true,
            ),
            9=>array(//43
                't'=>9,
                'h2'=>$this->menu[19],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/9' => $this->menu[19])
            ),
            10=>array(//47
                't'=>10,
                'h2'=>$this->menu[10],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/10' => $this->menu[10]),
                'ql'=>"SELECT a.id_bidang, a.kode_bidang Kode, a.nama_bidang Nama, a3.nama_pegawai PA, a5.nama_Lev Tingkat, a6.nama_bidang Unit_atas
FROM ref_bidang a
LEFT JOIN master_pegawai a3 ON a.pa=a3.nip
LEFT JOIN ref_lev a5 ON a.level=a5.id_level
LEFT JOIN ref_bidang a6 ON a.id_par_bidang=a6.id_bidang
 JOIN ref_skpd a7 ON a.id_subunit=a7.id_skpd 
order by a.level
",
                'ff'=>array(2=>'Nama Unit',5=>"Unit di atasnya",'SKPD'),
                'noadd'=>true,
                'laksi'=>array(),
            ),
            11=>array(//43
                't'=>16,
                'h2'=>$this->menu[11],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/11' => $this->menu[11])
            ),
            12=>array(//100
                't'=>12,
                'h2'=>$this->menu[12],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/12' => $this->menu[12]),                    
                'ql'=>'select id_skpd,nama_skpd SKPD,alamat_kantor,telp_kantor Telepon from '.$this->d[12],
                'ff'=>array(1=>"Nama SKPD",'Alamat','Telepon','SKPD Diatasnya'),
                ),
            15=>array(
                't'=>15,
                'h2'=>$this->menu[15],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/15' => $this->menu[15]),
                'ff'=>array(1=>'Tingkatan','sebagai admin'),
//                'noadd'=>true,
                'nofilter'=>true,
                ),
            20=>array(//13
                't'=>20,
                'h2'=>$this->menu[920],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/20' => $this->menu[920]),
                'ql'=>'select a.id_temlate, a.nama, a.deskripsi, b.pilihan Menggunakan_KOP from '.$this->d[20]
                .' a left join '.$this->d[8].' b on a.kop=b.id_yt '
                ,
                'ff'=>array(5=>'Menggunakan KOP'),
                ),
/*            21=>array(
                't'=>21,
                'h2'=>$this->menu[921],
                'breadcrumb' => array('' => 'Referensi', 'lister/21' => $this->menu[921]),                    
                ),
*/            
            44=>array(
                't'=>44,
                'h2'=>$this->menu[44],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/44' => $this->menu[44]),                    
                ),
            45=>array(
                't'=>45,
                'h2'=>$this->menu[45],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/45' => $this->menu[45]),                    
                'ff'=>array(1=>'Ruang'),
                ),
            49=>array(
                't'=>49,
                'h2'=>$this->menu[49],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/49' => $this->menu[49]),                    
//                'ff'=>array(1=>'Ruang'),
                ),
    //input                
    
    
//admin
            211011=>array(
                't'=>21,
                'h2'=>$this->menu[121],
                'breadcrumb' => array('' => $this->menu[904], 'list_surat/211011' => $this->menu[121]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$inputsur.", concat(kondisi_sm,' di ',next_nama_level_bagian,'-',next_nama_bidang_bagian) posisi".$dir_file.",next_id_bag FROM ".$this->d[35].' WHERE '.$syarat_nama_posisi.' and (kode=1) ',
                'laksi'=>array(
                    'p0'=>'p0',
                    'c0'=>'c0',
                    'e1'=>'e1',
                    'd'=>'d',
                    ),
                  'lplus'=>array(
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="loadmodal(\''.site_url($this->mycontrol.'surat_masukbox').'/0/&me/&sbg\',\'#form_modal\')"',
//                    'link'=>site_url('surat_masuk').'/0/&nparam',
                    ),
                'litem'=>array(
                    array(
                        'th'=>'File',
                        'td'=>'<a class="fancybox fancybox.iframe" href="'.base_url($this->upload_dir).'/&nama_dir/&nama_file">'.icon_i('file').'</a>',
                    ),
                ),
                'maxql'=>9,
//                'noadd'=>1,
                ),
//arsip
            2110111=>array(
                't'=>21,
                'h2'=>$this->menu[123],
                'breadcrumb' => array('' => $this->menu[904], 'list_surat/2110111' => $this->menu[123]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$inputsur.$kondisism.$dir_file.",next_id_bag FROM ".$this->d[35].' WHERE '.$syarat_arsip.' order by id_surat desc',
//                'ql'=>$arsipp,
                'laksi'=>array(
                    'p0'=>'p0',
                    'c'=>'c',
                    'u0'=>'u0',
                    'tr'=>'tr',
                    'e4'=>'e4',
                    ),
                'maxql'=>9,
//                'noadd'=>1,
                ),
            723=>array(
                't'=>21,
                'h2'=>$this->menu[723],
                'breadcrumb' => array('' => $this->menu[723], 'list_surat/723' => $this->menu[723]),
                'lty'=>array(1=>'d','1','1'),
                'ql'=>$inputsur_laporan.$kondisism.$dir_file.",next_id_bag FROM ".$this->d[35].' WHERE '.$syarat_arsip.' order by id_surat desc',
//                'ql'=>$arsipp,
/*                'laksi'=>array(
                    'p0'=>'p0',
                    'c'=>'c',
                    'u0'=>'u0',
                    'tr'=>'tr',
                    'e4'=>'e4',
                    ),
*/                'maxql'=>9,
                'laksi'=>array(),                
                'noadd'=>1,
                ),
                //sk
            214011=>array(
                't'=>21,
                'h2'=>$this->menu[126],
                'breadcrumb' => array('' => $this->menu[903], 'list_surat/214011' => $this->menu[126]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk.$kondisi.",id_bag,next_id_bag,id_posisi FROM ".$this->d[43].' WHERE '.$syarat_sk_posisi." AND (IFNULL(nomor_surat,'')='') ",
                'laksi'=>array(
                    'e2'=>'e2',
                    'd'=>'d',
                    'pn2'=>'pn2',
//                    'xw'=>'xw',
                    'trk'=>'trk',
                    'rp1'=>'rp1',
                    ),
                'lplus'=>array(
//                    'link'=>site_url('surat_keluar').'/0/&me/&sbg',
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="window.location.replace(\''.site_url($this->mycontrol.'surat_keluar').'/0/&me/&sbg\')"',
                    ),
                'maxql'=>8,
//                'noadd'=>(sesiaturan('sk')?0:1),
                ),

            //arsip    
            2140111=>array(
                't'=>21,
                'h2'=>$this->menu[124],
                'breadcrumb' => array('' => $this->menu[903], $this->mycontrol.'lister/21' => $this->menu[124]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk." ,id_bag,id_posisi FROM ".$this->d[43]." WHERE (next_id_bag<>".sesi('id_bag').") and (kode=9)",
                'laksi'=>array(
                    'trk'=>'trk',
                    'u0'=>'u0',
                    'xw'=>'xw',
                    'rp1'=>'rp1',
                    ),
                'noadd'=>1,
                'maxql'=>7,
                ),
                
                
//3sekretaris
            211031=>array(
                't'=>21,
                'h2'=>$this->menu[121],
                'breadcrumb' => array('' => 'Referensi', 'list_surat/211031' => $this->menu[122]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$inputsur.$dir_file.",next_id_bag FROM ".$this->d[35].' WHERE '.$syarat_nama_posisi.' AND (kode=1) and (next_id_bag='.sesi('id_bag').')',//'( next_id_bidang='.sesi('id_bid').')',
                'laksi'=>array(
                    'p0'=>'p0',
                    'c'=>'c',
                    'c1'=>'c1',
                    'e1'=>'e1',
                    ),
                'maxql'=>8,
                'noadd'=>1,
                ),
                //arsip
            2110310=>array(
                't'=>21,
                'h2'=>$this->menu[122],
                'breadcrumb' => array('' => 'Referensi', 'list_surat/2110310' => $this->menu[123]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$inputsur.$kondisism.$dir_file." FROM ".$this->d[35].' WHERE '.$syarat_arsip.' AND (kode=1) and (id_bag='.sesi('id_bag').')',
//                'ql'=>$arsipp,
                'laksi'=>array(
                    'p0'=>'p0',
                    'c'=>'c',
                    'u0'=>'u0',
                    'tr'=>'tr',
                    ),
                'maxql'=>9,
                'noadd'=>1,
                ),
            2110311=>array(
                't'=>21,
                'h2'=>$this->menu[123],
                'breadcrumb' => array('' => 'Referensi', 'list_surat/2110311' => $this->menu[123]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$inputsur.$kondisism.$dir_file." FROM ".$this->d[35].' WHERE '.$syarat_arsip.'  and (id_bag='.sesi('id_bag').')',
//                'ql'=>$arsipp,
                'laksi'=>array(
                    'p0'=>'p0',
                    'c'=>'c',
                    'u0'=>'u0',
                    'tr'=>'tr',
                    'e4'=>'e4',
                    ),
                'maxql'=>9,
                'noadd'=>1,
                ),
/*            214032=>array(
                't'=>21,
                'h2'=>$this->menu[122],
                'breadcrumb' => array('' => 'Referensi', 'lister/21' => $this->menu[121]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk." FROM ".$this->d[43].' WHERE '.$syarat_sk_posisi.' AND ((next_lev_user ='.(1==islogin()?8:islogin()).") or (lev_user =".(1==islogin()?8:islogin())."))".(1==islogin()?'':" and (next_id_bidang=".sesi('id_bid').") "),
                'laksi'=>array(
                    anchor('surat_keluar/%s/&nparam',icon_i('pen'),' %s title="Edit"').'',
                    'd'=>'d',
                    ),
                'lplus'=>array(
                    'link'=>site_url('surat_keluar').'/0/&nparam',
                    ),
                'maxql'=>8,
                ),
                //arsip
            2140320=>array(
                't'=>21,
                'h2'=>$this->menu[122],
                'breadcrumb' => array('' => 'Referensi', 'lister/21' => $this->menu[121]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk.$dir_filesk." FROM ".$this->d[43].' WHERE '.$syarat_sk_posisi.' AND (next_lev_user ='.(1==islogin()?8:islogin()).")".(1==islogin()?'':" and (next_id_bidang=".sesi('id_bid').") "),
                'laksi'=>array(
                    'u0'=>'u0',
                    ),
                'noadd'=>1,
                'maxql'=>8,
                ),
*/                
//7agend
            211071=>array(
                't'=>21,
                'h2'=>$this->menu[122],
                'breadcrumb' => array('' => $this->menu[904], $this->mycontrol.'lister/21' => $this->menu[122]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$inputsur.", if(ifnull(nama_file,'')='','belum ada','ada') `File` ".", ringkasan, nama_dir,nama_file FROM ".$this->d[35]
                ." WHERE ((id_bag=".sesi('id_bag')."))",
                'maxql'=>9,
                'laksi'=>array(
                    'p0'=>'p0',
                     ctag("a",icon_i('pen'),'href="#" title="edit" onclick="return loadmodal(\''.site_url($this->mycontrol.'surat_masukbox').'/%s/&me\',\'#form_modal\')"'),
//                    anchor('surat_masuk/%s/&nparam',icon_i('pen'),' %s title="Edit"').'',
                    'c'=>'c',
                    'd'=>'d',
                    ),
                'lplus'=>array(
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="loadmodal(\''.site_url($this->mycontrol.'surat_masukbox').'/0/&me\',\'#form_modal\')"',
//                    'link'=>site_url('surat_masuk').'/0/&nparam',
                    ),
                ),
                //arsip
            2110710=>array(
                't'=>21,
                'h2'=>$this->menu[123],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/2110710' => $this->menu[123]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$arsipp,
                'maxql'=>9,
                'laksi'=>array(
                //todo -o me:buat klik info tentang pembatalan ato arsip
//                    'c'=>'c',
                ),
                'litem'=>array(
                    array(
                        'th'=>'File',
                        'td'=>'<a class="fancybox fancybox.iframe" href="'.base_url($this->upload_dir).'/&nama_dir/&nama_file">'.icon_i('eye').'</a>',
                    ),
                ),
                'noadd'=>1,
                ),
            214072=>array(
                't'=>21,
                'h2'=>$this->menu[126],
                'breadcrumb' => array('' => $this->menu[903], $this->mycontrol.'lister/214072' => $this->menu[126]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk." FROM ".$this->d[43].' WHERE '.$syarat_sk_posisi." AND (IFNULL(nomor_surat,'')='') and (next_id_bag=".sesi('id_bag').") ",
                'laksi'=>array(
                     ctag("a",icon_i('lst'),'href="#" title="edit" onclick="return loadmodal(\''.site_url($this->mycontrol.'penomoran_sk').'/%s/&me\',\'#form_modal\')"'),
                    'xw'=>'xw',
                    ),
                'lplus'=>array(
                    'link'=>site_url($this->mycontrol.'penomoran_sk').'/0/&nparam',
                    ),
                'noadd'=>1,
                'maxql'=>8,
                ),
                //arsip
            2140720=>array(
                't'=>21,
                'h2'=>$this->menu[124],
                'breadcrumb' => array('' => $this->menu[903], $this->mycontrol.'lister/2140720' => $this->menu[124]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk.$kondisi." ,id_bag, id_posisi FROM ".$this->d[43]." WHERE (next_id_bag<>".sesi('id_bag').") ",
                'laksi'=>array(
                    'u1'=>'u1',
                    'xw'=>'xw',
                    ),
                'noadd'=>1,
                'maxql'=>8,
                ),
//8staff                
            214082=>array(
                't'=>21,
                'h2'=>$this->menu[126],
                'breadcrumb' => array('' => $this->menu[903], $this->mycontrol.'lister/214082' => $this->menu[126]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk." FROM ".$this->d[43].' WHERE '.$syarat_sk_posisi." AND (IFNULL(nomor_surat,'')='') AND ".(sesiaturan('vsk')?'(next_id_bag='.sesi('id_bag').') ':'(id_bag='.sesi('id_bag').') '),
                'laksi'=>array(
//                     ctag("a",icon_i('pen'),'href="#" title="edit" onclick="return loadmodal(\''.site_url('surat_keluarbox').'/%s/&me\',\'#form_modal\')"'),
                     anchor('surat_keluar/%s/&me',icon_i('pen'),'title="edit" '),
                    'd'=>'d',
                    'xw'=>'xw',
                    ),
                'lplus'=>array(
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="loadmodal(\''.site_url($this->mycontrol.'surat_keluarbox').'/0/&me\',\'#form_modal\')"',
                    ),
                'maxql'=>8,
                'noadd'=>(sesiaturan('sk')?0:1),
                ),
            //arsip    
            2140820=>array(
                't'=>21,
                'h2'=>$this->menu[124],
                'breadcrumb' => array('' => $this->menu[903], $this->mycontrol.'lister/2140820' => $this->menu[124]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk.$kondisisk." ,id_bag, id_posisi FROM ".$this->d[43]." WHERE (next_id_bag<>".sesi('id_bag').") ",
                'laksi'=>array(
                    'trk'=>'trk',
                    'u0'=>'u0',
                    'xw'=>'xw',
                    'rp1'=>'rp1',
                    ),
                'noadd'=>1,
                'maxql'=>8,
                ),
            //todo -o me:next_numbered 
            2140821=>array(
                't'=>21,
                'h2'=>$this->menu[127],
                'breadcrumb' => array('' => $this->menu[903], $this->mycontrol.'lister/21' => $this->menu[127]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk." FROM ".$this->d[43].' WHERE '.$syarat_sk_posisi.' AND (lev_user ='.(1==islogin()?8:islogin()).")".(1==islogin()?'':" and (id_bidang=".sesi('id_bid').") "),
                'laksi'=>array(
                     ctag("a",icon_i('pen'),'href="#" title="edit" onclick="return loadmodal(\''.site_url($this->mycontrol.'surat_keluarbox').'/%s/&me\',\'#form_modal\')"'),
                
                    'd'=>'d',
                    ),
                'lplus'=>array(
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="loadmodal(\''.site_url($this->mycontrol.'surat_keluarbox').'/0/&me\',\'#form_modal\')"',
                    ),
                'maxql'=>8,
                ),
            724=>array(
                't'=>21,
                'h2'=>$this->menu[724],
                'breadcrumb' => array('' => $this->menu[724], $this->mycontrol.'lister/724' => $this->menu[724]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk.$kondisi.",id_bag,next_id_bag,id_posisi FROM ".$this->d[43]." WHERE (kode_posisi=9) AND (IFNULL(nomor_surat,'')<>'') ",
                'laksi'=>array(
                    ),
/*                'lplus'=>array(
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="loadmodal(\''.site_url('surat_keluarbox').'/0/&me\',\'#form_modal\')"',
                    ),
*/                'maxql'=>8,
                'noadd'=>1,
                ),
//bos
            25=>array(//43
                't'=>25,
                'h2'=>$this->menu[125],
//                'breadcrumb' => array('' => 'Referensi', 'lister/43' => $this->menu[19]),
                'ql'=>"select id, pesan ,date_format(tgl_simpan,'%d/%m/%Y %T') tanggal_pesan, `replay` tanggapan from ".$this->d[25]." where id_person='".sesi('nama')."' order by id desc",
                'laksi'=>array(
                    ctag('a',icon_i('pen'),'class="btn_edit" href="#" act="'.site_url($this->mycontrol.'bos_note').'/%s"'),
                    'd'=>'d',
                    ),
                'lplus'=>array(
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="loadmodal(\''.site_url($this->mycontrol.'bos_note').'\',\'#form_modal\')"',
                    ),
            ),
//----Referensi Bidang dan Pengaturan Alur Surat            
            27=>array(//100
                't'=>27,
                'h2'=>$this->menu[27],
                'breadcrumb' => array('' => 'Referensi', $this->mycontrol.'lister/27' => $this->menu[27]),
                'ql'=>'SELECT id_bag, nama_lev tingkat, nama_bidang bidang FROM '.$this->d[32].' order by urutan',
                'laksi'=>array(
                    'n1'=>'n1',
                    'n2'=>'n2',
                    ctag("a",icon_i('pen'),'href="#" title="edit" onclick="return loadmodal(\''.site_url($this->mycontrol.'user_level').'/%s/&me\',\'#form_modal\')"'),
                    'd'=>'d',
                    ),
                'lplus'=>array(
                    'link'=>'#',
                    'attr'=>'title="Tambah" onclick="loadmodal(\''.site_url($this->mycontrol.'user_level').'/0/&me\',\'#form_modal\')"',
                    ),

                ),
                
            /*9999=>array(
                't'=>'no_tabel',
                'ql'=>'query pada list',
                'ff'=>'pengganti label list dan form',
                'maxql'=>'max',
                'noadd'=>'tanpa tombol tambah',
                'nofilter'=>'tanpa filter',
                'lty'=>array('d'=>'tanggal ind','c'=>'rupiah'),
                ),
            */
        );

    }
    
    function showfield($nod){
        return $this->ctabel->showfield($nod);
    }

    function f($nod,$atr=0){
        return $this->ctabel->f($nod,$atr);
    }

    function fl($nod){
        return $this->ctabel->fl($nod);
    }

    function attr($nod,$key=0){
        return $this->ctabel->attr($nod,$key);
    }

    public function get_da($fda=0,$index=0){
        $cmb=array(
            32=>'111',
            10=>'1011',            
        );

        $da=array(
            'cmb'   =>& $cmb,
            'Bulan' =>array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'),
            'Hari'      =>array(1=>'SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU'),
            'listr' =>& $this->listr,
        );

        return ($index?tesnull($da[$fda][$index]):$da[$fda]);
    }

    function filtf($nod,$kode="*"){
        $h=$this->fl($nod);//$this->db->list_fields($tname);
        if("*"==$kode){
            return $h;
        }elseif("-"==$kode){
            array_shift($h);
            return $h;
        }else{
            $h0=str_split($kode);
            foreach ($h0 as $x =>$isi)if($isi==1)$h1[]=$h[$x];
            return $h1;
        }
    }

}
/*            2140110=>array(
                't'=>21,
                'h2'=>$this->menu[124],
                'breadcrumb' => array('' => $this->menu[903], $this->mycontrol.'lister/21' => $this->menu[124]),
                'lty'=>array(1=>'1','d'),
                'ql'=>$inputsurk.$kondisi." ,id_bag,id_posisi FROM ".$this->d[43]." WHERE (next_id_bag<>".sesi('id_bag').") and (kode<>9)",
                'laksi'=>array(
                    'e3'=>'e3',
                    'trk'=>'trk',
                    'u0'=>'u0',
                    'xw'=>'xw',
                    'rp1'=>'rp1',
                    ),
                'noadd'=>1,
                'maxql'=>8,
                ),
*/
//arsip prosess
/*            2110110=>array(
                't'=>21,
                'h2'=>$this->menu[122],
                'breadcrumb' => array('' => $this->menu[904], 'list_surat/2110110' => $this->menu[123]),
                'lty'=>array(1=>'1','1','d'),
                'ql'=>$inputsur.$kondisism.$dir_file.",next_id_bag FROM ".$this->d[35].' WHERE '.$syarat_proses.' ',
                'ql'=>$arsipp,
                'laksi'=>array(
                    'p0'=>'p0',
                    'c'=>'c',
                    'c0'=>'c0',
                    'u0'=>'u0',
                    'tr'=>'tr',
                    ),
                'maxql'=>9,
                'noadd'=>1,
                ),
*/

?>