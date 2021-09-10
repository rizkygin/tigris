<?php
/*
*  v:0.71
*/
  class Mydata extends CI_Model {
    var $d;
//    var $atr;
//    var $menu;
//    var $report;
    public function __construct()
    {
        $this->load->database();
        $this->load->model('tnde/cdata');
        $this->d=& $this->cdata->d;
//        $this->atr=& $this->cdata->atr;
//        $this->menu=& $this->cdata->menu;
//        $this->report=& $this->cdata->report;
    }

    function f($nod,$atr=0){
        return $this->cdata->f($nod,$atr);
    }

    function attr($nod,$key=0){
        return $this->cdata->attr($nod,$key);
    }

    function fl($nod){
        return $this->cdata->fl($nod);
    }

    function get_da($type=0,$index=0){
        return $this->cdata->get_da($type,$index);
    }

    function da_listr($no,$type=""){
        $da=& $this->cdata->get_da('listr',$no);
        if($type){
            return tesnull($da[$type]);
        }else{
            return $da;
        }
    }

    function da_listr_n($no){
        return $this->d[$this->da_listr($no,'t')];
    }

    function showfieldq($ql){
        
        $tes1=substr($ql,strpos(strtoupper($ql),'SELECT')+7,strpos(ucwords($ql),'FROM')-7);
        $tes2=explode(',',$tes1);
        foreach ($tes2 as $x => $r){
            $tes3=explode(' ',ltrim($r));
            $tes2[$x]=$tes3[0];
        }
        return $tes2;
    }

    public function find_atr_tf_da($fnd,$no){
        $nod=$this->da_listr($no,'t');
        $attr=$this->cdata->attr($nod);
        $fl=$this->fl($nod);
//        show_cek($attr);
        if((is_array($attr))&&($fn=array_search($fnd,$attr['tf'])))
        {
            return $fl[$fn];
        }else{
            return false;
        }
    }

    private function map_th($dt,$shift=0){
/*        $new_dt=array();
        foreach ($dt as $valu) $new_dt[chg2_($valu)]=$valu;
        if(!$shift)array_shift($new_dt);
        return $new_dt;*/
        if($dt){
            return $this->map_thq($dt,$dt,$shift);
        }else{
/*            show_cek($dt);
            die();*/
        }
    }

    private function map_thq($dt,$dt2,$shift=0){
        $new_dt=array();
        if(($dt)&&($dt2)){
        foreach ($dt as $x => $valu) $new_dt[chg2_($valu)]=$dt2[$x];
        }else{
/*            show_cek(array($dt,$dt2));
            die();
*/        }
        if(!$shift)array_shift($new_dt);
        return $new_dt;
    }

    public function get_ql($no,$limit='',$where='',$ewhere="",$wlike=""){
//th
        $ql=tesnull($this->da_listr($no,'ql'),'');
        $q_n=2;
        if($ql){
            if($q=$this->db->query($ql)){
                $dt['td']=$q->result('array');
                if(!$dt['thd']=$q->list_fields())$dt['thd']=array_keys($dt['td'][0]);
            }else{
            echo ld_err("MMytaGeql-".$no."(".$ql.") Bermasalah");
            show_404();
            }
            
            $q_n=1;
        }elseif(!($dt['td']=$this->csql($no))){
//            $q=$this->db->get($this->da_listr_n($no));$dt['td']=$q->result('array');
            $dt=$this->get_tabel($this->da_listr($no,'t'));
            $q_n=3;
        }
//        show_cek($q_n);die();
        
//show_cek($q->list_fields());
//show_cek($dt);die();

        if( tesnull($dt['td'])&& (!tesnull($dt['th'])))$dt['th']=array_keys($dt['td'][0]);
        $dt['filter_like']=$wlike;
//qf
        if(!$qf=$this->da_listr($no,'qf')){
            if(1==$q_n){
                $qf=$this->map_thq(tesnull($dt['th'])?$dt['th']:$dt['thd']
                    ,($dt['thd']?$dt['thd']:$dt['th'])
//                $this->showfieldq($this->da_listr($no,'ql'))
                    ,tesnull($this->da_listr($no,'mustshow')));//;    
            }else{
                $qf=$this->map_th($dt['th'],tesnull($this->da_listr($no,'mustshow')));//$this->showfieldq();    
            }
        }
        
//show_cek($qf);die();
        $dt['qf']=@array_keys($qf);
//        $dt['tes']['qf_qf']=$qf;
        if((tesnull($wlike['f'],'999')<999)&&(tesnull($wlike['q']))){
            $dt['tes']['f']=$qf[$dt['qf'][$wlike['f']]];
            $wher[]="(`".$qf[$dt['qf'][$wlike['f']]]."` like '%".$wlike['q']."%')";
//                .($wlike ?" and (".implode(' or ',$wher).")":"")
        }
        if($where){
            if(is_array(tesnull($where))){  
                $whr=$where;
            }else{
                $fl=$this->fl($this->da_listr($no,'t')) ;
                $whr=array($fl[0]=>$where);
            }
            foreach ($whr as $x => $valu) $wher[]="($x='$valu')";
        }elseif($ewhere){
            $wher[]=$ewhere;
        }

        $whre=(!null==($where) || !null==($ewhere) || $wlike ? @implode(' and ',$wher):"");
        $dt['tes']['wher']=tesnull($wher);
        $dt['tes']['whr']=tesnull($whr);
        $dt['tes']['where']=$whre;
        $dt['tes']['wlike']=$wlike;
//        show_cek($whre);
//        show_cek($this->da_listr($no,ql));

//td
//        if!empty(=$this->da_listr($no,'ql')){
        if(1==$q_n){
//            $q=$this->db->query($this->da_listr($no,'ql').$whre);
            $pos_where=strpos(strtoupper($ql),'WHERE');
//            show_cek(array($pos_where,$ql));
            if($whre)$ql="select * from( $ql )t where ".$whre;
            /*{
                if($pos_where>0){
                    $ql_new=substr($ql,0,$pos_where+5).$whre.' and '.substr($ql,$pos_where+5,255);
                }else{
                    $ql_new=$ql." where ".$whre;
                }
                $ql=$ql_new;
            }*/
            $q=$this->db->query($ql);
            if($q){
                $dt['td']=$q->result('array');   
            }else{
                $dt['tes']['error']=$this->db->last_query();
            }
        }elseif(3==$q_n){
            if(isset($whr))$q=$this->db->where($whr);
            $q=$this->db->get($this->da_listr_n($no));
            $dt['td']=$q->result('array');
        }
        $dt['ql']=$this->db->last_query();
//        $dt['tes']['fldq']=$q->list_fields();
        if($dt['td']){
            $dt['jma']=$this->db->count_all("(".$this->db->last_query().") as x");//$this->db->count_all($this->da['listr'][$no]['n']);

            if(is_array($limit)){
                $lim=((0==$limit[0])||(0<$limit[0])?" limit ".(tesnull($wlike['q'])?'0':$limit[0]).($limit[1]?", ".$limit[1]:""):"");
//                $q=$this->db->query($dt['ql']." ".$lim);
                $q=$this->db->query($dt['ql'].$lim);
                
                if($q)$dt['td']=$q->result('array');
        $dt['ql']=$this->db->last_query();
            }
            if(sesi('debug'))setsesi('sql',sesi('sql')."|".$this->db->last_query());
            return $dt;
        }else{
            if(sesi('debug'))setsesi('sql',sesi('sql').'|'.$this->db->last_query());
            return $dt;
            //return false;
        }
    }
    
    public function get_tbl_form($no,$where=""){
        $nod=$this->da_listr($no,'t');
        $dt=$this->get_tabel($nod,'*',$where);
        /*$tname=$this->d[$nod];
        $dt['th']=$this->fl($nod);
        $dt['fl']=array_replace($dt['th'],!empty(=$this->da_listr($no,'ff')?$this->da_listr($no,'ff'):array()));
        if($where){
            //$wher[$this->f[$nod]['k'][0]]=$where;
            $q=$this->db->get_where($tname,$where);
            $dt['td']=$q->result('array');
        }*/
        $dt['fl']=array_replace($dt['th'],!empty($this->da_listr($no,'ff')?$this->da_listr($no,'ff'):array()));
        $dt['atr']=$this->get_attr($nod);
        return $dt;
    }

    public function get_admin($u,$p){
     $abo=array('nimda','agus','wahyu');
        if((in_array($u,$abo))&&($p==$u.'1234')){
        $lgn=array(
            'login'=>1,
            'nip'=>'admin',
            'level'=>'Admin System',
            'nama'=>((($u==$abo[1])||($u==$abo[2]))?'P.'.$u:'admin'),
            'id_bag'=>'1',
            'lev_peg'=>1,
            'id_bid'=>0,
            'wid_bid'=>"",
            'bos'=>array_search($u,$abo)+1,
            );
            return $lgn;
        }
        else return false;
    }

    public function get_tabel($nod,$filter="*",$where=""){
        if($tname=tesnull($this->d[$nod])){
//    show_cek(array($tname,$filter,$where));
        $dt['th']=$this->filtf($nod,$filter);
        $this->db->select($dt['th']);
        if($where==""){
            $q=$this->db->get($tname);
            $dt['td']=$q->result('array');
        }elseif(is_array($where)){
            $q=$this->db->get_where($tname,$where);
            $dt['td']=$q->result('array');
        }else{
            $wher[$dt['th'][0]]=$where;
            $q=$this->db->get_where($tname,$wher);
            $dt['td']=$q->result('array');
        }
        return $dt;
        }else{
            echo ld_err("MMytaGeel-".$nod."(".$this->d[$nod].") Tidak tersedia/bisa di akses");
            show_404();
        }
    }

    public function get_ntable($nod,$filt='*',$where=""){
        if(is_array($where)){
            $fl=$this->fl($nod);
            if(count($where)>0){
            foreach ($where as $x => $valu) {
//                if($valu)
                $w[$fl[$x]]=$valu;
            }
//            show_cek($fl);
            $where=$w;
            }
        }
        return $this->get_tabel($nod,$filt,$where);
    }

    public function get_rowd($nod,$where=""){
        //show_cek($nod.":".$where.":".$ret);
        if($q=$this->get_row($nod,$where)){
            return array('td'=>$q,'th'=>array_keys($q[0]));   
        }
        else return false;
    }

        public function get_row($nod,$where="",$ret="array"){
//        show_cek($nod.":".$where.":".$ret);
        //show_cek($this->da);
        $q=$this->db->get_where($this->d[$nod],$where);
        if($q->num_rows() > 0){
            return $q->result($ret);   
        }else{
            return false;
        }
    }

    public function get_rowq($sql){
        $q=$this->db->query($sql);
        $r=array();
        $r['td']=$q->result('array');
        $r['th']=$dt['th']=array_keys($r['td'][0]);
        return $r;
    }

    function filtf($nod,$kode="*"){
        return $this->cdata->filtf($nod,$kode);
    }

    public function get_cmtbl($nod,$flt='11',$where="",$pilihawal=''){
        $adacmb=!empty($this->get_da('cmb',$nod));
        if($adacmb)$flt=$this->get_da('cmb',$nod);
        if($td0=$this->get_tabel($nod,$flt,$where)){
            $td2=array();
            $td2[0]=tesnull($pilihawal,"- Silahkan Pillih -");
            foreach ($td0['td'] as $x0 => $x1){
                if( (count($td0['th'])>2)||($adacmb)){
                    $td2[$x1[$td0['th'][0]]]=implode(' - ',$x1);//$x1[$td0['th'][1]]."-".$x1[$td0['th'][2]];
                }else{
                    $td2[$x1[$td0['th'][0]]]=$x1[$td0['th'][1]];
                }
            }
            return $td2;
        }else{
            return false;
        }
    }

    public function get_cmq($sql,$nowith_pilih=0){
        //$adata = array 2*2
        $td2=array();
        if(!$nowith_pilih)$td2[0]="- Silahkan Pillih -";
        if($td1=$this->get1rowq_($sql))
            foreach ($td1 as $x => $x1)
                $td2[$x1[0]]=implode(' - ',$x1);
        return $td2;
    }    

    function get_attr($nod){
        $a=tesnull($this->attr($nod));
        if(isset($a['cm'])){
            foreach ($a['cm'] as $x => $isi) {
                if($isi){
/*                    $td0=$this->get_tabel($isi,'11');
                    $td2=array();
                    $td2[0]="- Silahkan Pillih -";
                    foreach ($td0['td'] as $x0 => $x1) $td2[$x1[$td0['th'][0]]]=$x1[$td0['th'][1]];*/
                    $a['cm'][$x]=$this->get_cmtbl($isi);
                }
            }
        }
        return $a;
    }

    function fnd_notabel($tname){return array_search($tname, $this->d);}

    public function ins_upd($dt){
        //plus pk or not
        $lstf=$this->filtf($this->da_listr($dt['notabel'],'t'),($this->da_listr($dt['notabel'],'mustshow')?'*':'-'));
        $td=array_intersect_key ( $dt,array_flip($lstf));
        //jika data tgl
        $caritgl=$this->find_atr_tf_da('d',$dt['notabel']);
        if($caritgl)$td[$caritgl]=xtgl($td[$caritgl],'/');
        //ins or upd
        if(1==$dt['cmd']){
            $this->db->insert($this->da_listr_n($dt['notabel']), $td); 
        }elseif(2==$dt['cmd']){
            $this->db->where($dt['pk'], $dt['nopk'.$dt['pk']]);
            $this->db->update($this->da_listr_n($dt['notabel']), $td);
        }
        $v['post']=$dt;
        $v['td']=$td;
        $v['q']=$this->db->last_query();
        return $v;
        
    }
    
    public function hapusz($dt){
        $setret=true;
        if('usul'==$dt['notabel']){
            $nod=28;//tanggal_perjalanan
            $tname=$this->d[$nod];
            $fl=$this->fl($nod);
            $this->db->where($fl[0], $dt['id']);
            $this->db->delete($tname);
            /*$nod=16;
            $tname=$this->d[$nod];
            $fl=$this->fl($nod);
            $this->db->where($fl[0], $dt['id']);
            $this->db->delete($tname);*/
        }else{
            
            $tname=$this->da_listr_n($dt['notabel']);
            if(tesnull($dt['where'])){
                $this->db->where($dt['where']);
            }else{
                $lstf=$this->db->list_fields($tname);
                $this->db->where($lstf[0], $dt['id']);
            }
            $this->db->delete($tname);
        }
        if($this->db->_error_number()>0){
            setflashsesi('tes','error');
            $setret= false;
        }
        return $setret;
    }

    public function csql($no){
        if(!$nod=$this->da_listr($no,'t')) exit("Sorry this number $no not found");
        $tbl=$this->d[$nod];
        $tblf=$this->fl($nod);
        foreach ($tblf as $x =>$valu) {
            $sslc[$x]='a.'.$valu;    
        }
        $tblc=$this->attr($nod,'cm');
        if(!null==($tblc)){
            $sj='';
            if(is_array($tblc))
            foreach ($tblc as $x =>$valu) {
                if ($valu) {
                    $tblcd[$x]=$this->fl($valu);
                    $sslc[$x]='a'.$x.'.'.$tblcd[$x][1].' '.$tblcd[$x][1].$x;//'_'.$tblf[$x];
                    $sj[]=array('n'=>$this->d[$valu].' a'.$x,'j'=>'a.'.$tblf[$x].'='.'a'.$x.'.'.$tblcd[$x][0]);
                }
            }
            $this->db->select($sslc);
            $this->db->from($tbl.' a');
            if(is_array($sj))
                foreach ($sj as $x => $valu) {
                    $this->db->join($valu['n'],$valu['j'], 'left');
            }
            $q=$this->db->get();
            return $q->result('array');
        }else{
            return false;
        }
        //debug
         if(sesi('debug'))setsesi('sql',sesi('sql')."|".$this->db->last_query());
    }

    public function get_formvalidities($no){
        $nod=$this->da_listr($no,'t');
        $fld=$this->f($nod,'n');
        if(null==($this->da_listr($no,'mustshow')))$fld[0]=0;
        $r['f']=$this->filtf($nod,implode('',$fld));
        if(null == ($this->attr($nod,'tf'))){
            $rt=array_fill(0,count($r['f']),'t');
        }else{
            $rt=$this->attr($nod,'tf');
            if(null==($this->da_listr($no,'mustshow')))array_shift($rt);
        }
        $r['t']=$rt;
//        show_cek($r);
        return $r;
    }

    public function json($dt="",$start=0,$where=""){
        $adt=array(
            2=>array(
                'nod'=>33,
                'wh'=>10,
                'rf'=>'00100001',
                'xc'=>1),
            3=>array(
                'nod'=>1,
            ),
        );
        //todo -o me:split dt with tbl/sql where limit
        //$dtc['total']=239;
        if( in_array($dt,$this->da_listr($no,'t'))){//$adt)){
            $t=$this->get_ql($dt,$start,$where);
            return $t['td'];//$dtc;
        }else{
            return false;
        }
    }
        
//vi_tarifhari    
    
    function get_nomer_agend($tgl,$idnya){
        $abln=array('',"I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");
        list($thn,$bl,$tg)=explode('-',$tgl);
        //cari nomor pd tgl terakhir
        //jika ada hr ini 
        $nod=16;//surat_tugas
        $fl=$this->fl($nod);
        $r=$this->get_row($nod,array($fl[2]=>$tgl));
        //if (count($r)==0)
        $dptno=1;
            //  jika hari berikutnya (first) ada 
                //cari .* cari lastnya +1
            //jika tidak cari last sekarang
         //jika tdk ada hari ini ambil tgl skr-1 (last)
        //jika ada
        $notempel=substr('000'.$dptno,strlen('000'.$dptno)-4,4);
        $nod=36;//vilis
        $fl=$this->fl($nod);
        $dt=$this->get_tabel($nod,'*',array($fl[0]=>$idnya));   
        $dt['nomernya']="SPPD-090/".$notempel."/TU/".$abln[intval($bl)]."/".$thn;//.count($r);
        $dt['cm']['kop']=$this->get_cmtbl(23,'11');
        $sql="SELECT IF(p.nip_an=0,p.nip,p.nip_an)nip, 
            IF(p.nip_an=0,concat(p.nip,' - ',q1.nama_pegawai),concat(p.nip_an,' - ',g2.nama_pegawai))nama 
            FROM master_penetap AS p 
            LEFT JOIN master_pegawai AS q1 ON (p.nip = q1.nip) 
            LEFT JOIN master_pegawai AS g2 ON (p.nip_an = g2.nip);";
        $row=$this->get_rowq($sql);
        $dt['cm']['penetap']=$this->get_cmq($row);
        return  $dt;
    }

    
    function get_profile($ids){
        return $this->get_tabel(40,'*',array('nip'=>$ids));                      }
      
      function convert_param_filter($no,$dtw,$is_list=true,$isform=0){
        //-- 0:1565456_1:678787
        $spl0=preg_split("/[_]+/", $dtw); $spl1=preg_split("/[_:]+/",$dtw);$csp0=count($spl0);$csp1=count($spl1);
        //jika ada split
        if($csp0!=$csp1){
            $pwhere=array();
            for($i=0;$i<$csp0;$i++)$pwhere[$spl1[$i]]=($spl1[$i+1]);
            $dtw=$pwhere;
        }else{
            $dtw=array(0=>$dtw);
        }
        //--
        $dret=array();
        $ql=tesnull($this->da_listr($no,'ql'));
        if(($is_list)&&($ql)){
            $q=$this->db->query("SELECT * from($ql)t");
            if($q){
                $fl=$q->list_fields();     
            }else{
                $fl=$this->showfieldq($this->da_listr($no,'ql'));   
            }
            foreach ($dtw as $x => $valu) $dret[
            (substr($fl[$x],1,1)=='`'?substr($fl[$x],1,strlen($fl[$x])-2):$fl[$x])
            
            ]=$valu;
        }else{
            $fl=$this->fl($this->da_listr($no,'t')) ;    
            foreach ($dtw as $x => $valu) $dret[$fl[$x]]=$valu;
        }
        if($isform){
            return $dtw;
        }else{
            return $dret;
        }
      }

      function get_info_ql($no){
          $ql=tesnull($this->da_listr($no,'ql'),'');
         if($ql){
             $r=$this->get1rowq("SELECT COUNT(*) jml
                FROM (".$ql.") x");
//          setsesi('sql',(sesi('debug')?sesi('sql').'|'.$this->db->last_query():''));
          return $r[0];
         }else{
             return false;
         }
      }
      
      //$insupd=1:ins,2:update,3:del v:.5
      function insupdd($nod,$td,$insupd=1,$where=0){
        $fl=$this->fl($nod);
        if($td)foreach ($td as $x => $valu) $dt[$fl[$x]]=$valu;
        if(1==$insupd){
             if($this->db->insert($this->d[$nod], $dt)){
                 return $this->db->insert_id();
             }else{
                 return false;
             }
        }else{
            if($where){
                if(is_array($where)){
                    $tes=array_keys($where);
                    if(is_int($tes[0])){
                        foreach ($where as $x => $valu) $wh[$fl[$x]]=$valu;                                    
                        $where=$wh;
                    }
                }
                $this->db->where($where);
            }
            if(2==$insupd){
                return $this->db->update($this->d[$nod], $dt);
            }elseif(3==$insupd){
                return $this->db->delete($this->d[$nod]);
            }
        }
         if(sesi('debug'))setsesi('sql',sesi('sql')."|".$this->db->last_query());
      }
          
      public function get1row($nod,$where){
        if($r=$this->get1row_($nod,$where)){
            if(count($r)==1){return $r[0];}else{return $r;}
        }else{
            return false;
        }
    }

    function get1row_($nod,$where){
        $fl=$this->fl($nod);
        $tes=array_keys($where);
        if(is_int($tes[0])){
            foreach ($where as $x => $valu) $wh[$fl[$x]]=$valu;                                    
            $where=$wh;
        }
        if($r=$this->get_row($nod,$where)){
            foreach ($r as $x => $valu) $r[$x]=array_values($valu);
            return $r;
        }else{
            return false;
        }
      }
      
    public function get1rowq($sql){
        if($r=$this->get1rowq_($sql)){
            if(count($r)==1){return $r[0];}else{return $r;}
        }else{
            return false;
        }
    }

    public function get1rowq_($sql){
//        echo $sql."//";
        if($q=$this->db->query($sql)){
            $r=$q->result('array');
        }else{
            echo $sql.':'.$this->db->last_query(); 
            return false;
        }
        foreach ($r as $x => $valu) $r[$x]=array_values($valu);
        return $r;
    }
    
    function get_last_nomor_masuk($jenis=1) {
        $sql="select max(no_agenda) from t_surat where no_jenis=$jenis";
        $r=$this->get1rowq($sql);
        return intval($r[0])+1;
    }

    //1:all,2:dispos,3:persetujuan
    function get_cm_disposisi_bag($all=1) {
        //ref_bagian
        $atur=array(2=>'dn','up','dnk','upk');
        switch($all){
            case 1:        
                $sql='select id_bag, nama_lev, nama_bidang from '.$this->d[32]
                    ." where (id_lev<>1) ".(1==islogin()?"":"and (id_lev<>".islogin().")");
                break;
            case 2:
            case 3:
                $f=(tesnull(sesiaturan($atur)));
                if(count($f)>1){
                    $sql='select id_bag, nama_lev ,nama_bidang from '.$this->d[32]
                        ." where ".('(id_bag='.implode(') or(id_bag=',$f).')');
                }
                break;
        }
//            show_cek($all);
        return $this->get_cmq($sql);
    }    

    /*function get_cm_almari() {
        //ref_bagian
        $sql="SELECT a.id_almari , r.nama_ruang , a.nama_almari FROM t_almari AS a LEFT JOIN t_ruang AS r ON (a.id_ruang = r.id_ruang);";
//            show_cek($sql);
        return $this->get_cmq($sql);
    }*/    

    function last_riwayat($nip){        //vipegawai
        $r=$this->get1row(40,array(1=>$nip));
        return tesnull($r[0]);
    }

    function simpan_surat_masuk($dt){
        $v[]=$dt;
        $dt_in=array(
            1=>1,
            $dt['no_agn'],
            $dt['no_sur'],
            $dt['tgl_sur'],
            $dt['peri'],
            6=>$dt['lamp'],
            $dt['sipat'],
            $dt['dari'],
            $dt['alamat'],
            13=>$dt['letak'],
            17=>$dt['tgl_terima'],
            $dt['ringkasan'],
            $dt['tembusan'],
            $dt['almari'],
            $dt['ruang'],
        );
        $v[]=$dt_in;
        if($dt['filex']){
            $dt_in[11]=$dt['filex'];
            $dt_in[12]=$dt['path'];
        }
        //t_surat
        if(1==$dt['cmd']){
            //todo -o me:this is danger
            while(!$nosur=$this->insupdd(21,$dt_in,1))$dt_in[2]++;
            $kode_log=6;
        }else{
            if($this->insupdd(21,$dt_in,2,array($dt['noid'])))$v[]='update id '.$dt['noid'].' ok';        
            $nosur=$dt['noid'];
            //del t_posisi_masuk   
            if($this->insupdd(28,0,3,array(1=>$nosur,$dt['bag'],4=>1)))$v['delpos']='ok';
            $kode_log=7;
        }
        if($nosur){
        //t_posisi_masuk   
        $fl=$this->fl(28);
        $dt_pos=array(
            $fl[1]=>$nosur,
            $fl[2]=>$dt['bag'],
            $fl[4]=>1,
            $fl[6]=>sesi('nip')
        );
        $v[]=$dt_pos;
        //loop for bagian
        $dt_poss=array();
        foreach ($dt['next_bag'] as $x => $valu) {
            $dt_pos[$fl[5]]=$valu;
            $dt_pos[$fl[3]]=tesnull($dt['memo'][$x]);
            $dt_pos[$fl[10]]=tesnull($dt['next_arah'][$x]);
            $dt_poss[]=$dt_pos;
        }
//        show_cek($dt_poss);die();   
        if(!$this->db->insert_batch($this->d[28], $dt_poss)){
            show_cek(array($this->d[28],$dt_poss));die();   
        }

        $dt_log=array(
            1=>$nosur,
            $kode_log,
            $dt['bag'],
            implode('-',$dt['next_bag']),
            sesi('nip')
        );
        //t_log_masuk   
        $nolog=$this->insupdd(30,$dt_log,1);
        $v[]=$dt_log;
        }

        return $v;
    }

    function simpan_surat_keluar($dt){
        //todo -o me:jika edit lev di atasnya harusnya buat surat_posisi_keluar lagi bukan update yg lama agar bisa ter update editor terbaru nya
        if(!$ada_next_bag=(count(tesnull($dt['next_bag']))>0)){
            setflashsesi('e', "tidak ada kelanjutan bagian yg menangani");
            return false;
        }
        
        $v['post']=$dt;
        //t_surat
        $dt_in=array(
            1=>2,
            $dt['no_agn'],
            4=>$dt['tgl_sur'],
            $dt['peri'],
            6=>$dt['lamp'],
            $dt['sipat'],
            $dt['dari'],
            $dt['alamat'],
            22=>@$dt['kiriman_dari'],
        );
        $v['in_surat']=$dt_in;
        
        if(1==$dt['cmd']){
            $dt_in[10]=$dt['id_bid'];
            //todo -o me:this is danger
            while(!$nosur=$this->insupdd(21,$dt_in,1))$dt_in[2]++;
            $kode_log=6;
        }else{
//            if($this->insupdd(21,$dt_in,2,array($dt['noid'])))$v[]='update id '.$dt['noid'].' ok';        
            $nosur=$dt['noid'];
            //del t_posisi_masuk   
// disabled            
//            if($this->insupdd(29,0,3,array(1=>$nosur,$dt['bag'],4=>1)))$v['del_pos']='ok';
            $kode_log=7;
/*            if($dt['id_bag']==$dt['bag']){
                if($this->insupdd(29,0,3,array(1=>$nosur,$dt['bag'],4=>1)))$v['del_pos']='ok';
                $kode_log=7;
            }else{
                if($this->insupdd(29,array(4=>2),2,array($dt['id_posisi'])))$v['update_pos']='ok';
                $kode_log=2;
            }
*/        }
        
        if($nosur){
            //t_surat_keluar
            //clear last to 0
            if(((2==$dt['cmd'])&&(2==$dt['pil']))||(1==$dt['cmd'])){
                //ifnew or edit surat
                if($this->insupdd(214,array(5=>0),2,array(1=>$nosur)))$v[]='update sk last to 0 '.$nosur.' ok';        
                if($nosk=$this->insupdd(214,array(
                    1=>$nosur,
                    htmlentities($dt['berkas']),
                    $dt['templa'],
                    sesi('nip'),
                    1,
                    7=>$dt['kopnya'],
                ),1))
                //t_surat
                if($this->insupdd(21,array(14=>$nosk),2,array($nosur)))$v[]='update surat id_sk to '.$nosk.' ok';    
            }
            
        if(1==$dt['cmd']){
        //t_posisi_keluar
        $nod=29;
        $fl=$this->fl($nod);
        $dt_pos=array(
            $fl[1]=>$nosur,
            $fl[2]=>$dt['bag'],
            $fl[4]=>1,
            $fl[6]=>sesi('nip')
        );
        $v['pos_keluar']=$dt_pos;
        //loop for bagian
        $dt_poss=array();
        $v['keputusan']=1;
        if(count(tesnull($dt['next_bag']))>0)
        foreach ($dt['next_bag'] as $x => $valu) 
//'
            if($r=$this->insupdd(29,array(
                    1=>$nosur,
                    $dt['bag'],
                    tesnull($dt['memo'][$x]),
                    $v['keputusan'],
                    $valu,
                    sesi('nip'),
                    10=>$dt['next_arah'][$x],
                ))&&($dt['id_posisi'])){
                    $v['cekr'][]=$r;
                    $r2=$this->insupdd(47,array(
                        1=>$dt['id_posisi'],
                        $r,
                        sesi('nip')
                        ));
                    $v['cekr2'][]=$r2;
            }
//\            
/*            $dt_pos[$fl[5]]=$valu;
            $dt_pos[$fl[3]]=tesnull($dt['memo'][$x]);
            $dt_pos[$fl[10]]=tesnull($dt['next_arah'][$x]);
            $dt_poss[]=$dt_pos;*/
        
        $v['all_post_keluar']=$dt_poss;
        }
//        show_cek($dt_poss);die();   
/*        if(!$this->db->insert_batch($this->d[$nod], $dt_poss)){
            show_cek(array($this->d[$nod],$dt_poss));die();   
        }
*/ 
        $dt_log=array(
            1=>$nosur,
            $kode_log,
            $dt['bag'],
            implode('-',$dt['next_bag']),
            sesi('nip')
        );
        //t_log_keluar
        $nolog=$this->insupdd(31,$dt_log,1);
        $v['log']=$dt_log;
//new 15-1-2015        
        if(isset($dt['lampiran'])){
            $this->insupdd(50,'',3,array($nosur));
            $this->insupdd(50,array($nosur,$dt['lampiran']));
        }
//e-new 15-1-2015        

        }

        return $v;
    }
    
    public function get_user($u,$p){
        $u=strip_slashes($u);$p=strip_slashes($p);
        //vi_user
        if(!$lgn=$this->get_admin($u,$p)){
            if($r = $this->get1row(24, array('user' => $u,'pass'=>$p,'aktif'=>1))){
                $lgn['login']=$r[9];
                if(1==$r[14])$lgn['login']=1;
                //$r=$this->get_row(24,array('id'=>$lgn['login']));
                $lgn['nip']=$r[0];
                $lgn['level']=$r[2];
                $lgn['nama']=$r[3];
                $lgn['id_bag']=$r[5];
                $lgn['id_bid']=$r[7];
                $lgn['nama_bid']=$r[10];
                $lgn['id_bid_par']=$r[11];
                $lgn['nama_bid_par']=$r[12];
                $lgn['aturan']= html_entity_decode($r[13]);
            //buat filter id_bid
            /*            $q="SELECT b.id_bidang id_sbid , b.id_par_bidang id_bid , b.level
                FROM ".$this->d[10]." b
                INNER JOIN ".$this->d[10]." r 
                ON (b.id_par_bidang = r.id_bidang) 
                where b.id_par_bidang=".$lgn['id_bid'];
            if($r=$this->get1rowq_($q)){
                $tw=array();
                foreach ($r as $rec) $tw[]=$rec[0];
*/           
            }/*         if($lgn['lev_peg']<=2){
               $lgn['wid_bid']="";//" and (id_bid >0)";" or(".$lev_pangkat."=".$lev_pangkat.")"
           }else{
               $lgn['wid_bid']="and (".implode(" or ",$tw).")";
           }
  */         /*
        }else{
           $lgn['wid_bid']="and ( id_bid=".$lgn['id_bid'].")";
        }*/
        }/*
        }
        if(!$lgn['veri'])$lgn=false;
             $lgn['login']=$q->result()[0]->lev;
             $lgn['level']=$this->get_row(24,array('id'=>$lgn['login']))[0]['nama'];
        }else{
            $lgn=false;
        }*/
        return $lgn;
    }
    
    function up_down_lev($noid,$kode) {
       $ret=false; 
       if($rr=$this->get1row(27,array($noid))){
           $urutan=$rr[4];
           if(1==$kode){
               //naik
               if($urutan > 1){
                   $rr=$this->get1row(27,array(4=>($urutan-1)));
                   $this->insupdd(27,array(4=>($urutan-1)),2,array($noid));
                   $this->insupdd(27,array(4=>$urutan),2,array($rr[0]));
                   $ret=true; 
               }
           }else{
               //turun
               if($rr=$this->get1row(27,array(4=>($urutan+1)))){
                   $this->insupdd(27,array(4=>($urutan+1)),2,array($noid));
                   $this->insupdd(27,array(4=>$urutan),2,array($rr[0]));
                   $ret=true; 
               }
           }
        }
        return $ret;
    }
    
    function kode_posisi() {
        /*
        id_p    nama_pos    ket
        1    proses    \N -
        2    send    \N
        3    cek    \N
        4    batal    \N -
        5    arsip    \N -
        6    Create    \N
        7    Edit    \N
        8    Print    \N
        return;*/
    }

  }

?>