<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }
  class Defa{
    var $debug=array(
        'list'=>1,
        'form'=>0,
        'save'=>0,
    );
    var $opt=array();
    var $ver='1.117';
    var $CI;
    var $fold="dm";
    var $head_aksi_list="Aksi";
    var $allowed_type_upload='jpg|jpeg|png|gif|pdf|word|doc|docx|xls|xlsx|ppt|pptx';

    public function __construct () {
        $this->CI =& get_instance();
        $this->CI->load->config('cmd');
        $this->CI->load->helper('cmd');
        $this->CI->load->model('general_model');
    }  
    
    function add_search($search,$add) {
        $sc=un_de($search);
        return array_merge($sc,$add);
    }
    
    function btn_edit($id,$act,$uriret,$btn="",$param_search="") {
        $addmodex=array(
            'modex' => 'form_mode',
            'form_id' => $id,
            'ret_save'=>$uriret,
        );
        if($param_search)
            $addmodex=$this->add_search($param_search,$addmodex);
        return 
            anchor('#',($btn?$btn:'<i class="fa fa-pencil"></i>'),
                'class="btn btn-warning btn-edit btn-xs" 
                 act="'.site_url($act.(substr($act,-1)=='/'?'':'/').in_de($addmodex)).'"');
    }
    
    function _is_row_det($kode='',$row) {
        $ret="";
        if($kode)
        if(!empty($kode['row'])){
            $koderow=$kode['row'];
            $ret=$row->$koderow;
        }else{
            $ret=$kode;
        }
        return $ret;
    }
    
    function e_detail_row($row,$det) {
        $ret="";
        if($det[0]==1){
          $ret=load_cnt($det[1],$det[2],$det[3]
            ,$this->_is_row_det(@$det[4],$row)
            ,$this->_is_row_det(@$det[5],$row)
            ,$this->_is_row_det(@$det[6],$row)
            ,$this->_is_row_det(@$det[7],$row)
            ,$this->_is_row_det(@$det[8],$row)
            ,$this->_is_row_det(@$det[9],$row)            
            );
        }else{
            $ret="xx";
        }
        return $ret;
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
               if($d->judul  >'') $bc[$d->link]=$d->judul;
           }       
    
        return $bc;
    }
    
    private function aksi($aksi,$data,$title='') {
        $ret='';
        list($tipe,$dt)=$aksi;
        switch($tipe){
            case 0:$ret=$dt;break;
            case 1:
                switch($dt){
                    case 1:
                        if($data->aktif=='*'){
                            $ret='<a ><i class="fa fa-toggle-on"></i></a>';
                        }else{
                            $ret=anchor('#','<i class="fa fa-toggle-off"></i>','act="'.site_url('baperjakat/baperjakat/set_aktif/'.$data->id_bap.'" title="Set Aktif"'));
                        }
                    break;
                }
                break;
            case 2 :
            switch($dt[0]){
                case 1:
                    if($this->compareit($data->$dt[1],$dt[2],$dt[3]))
                        $ret=anchor(
                            $dt[4]=='#'?'#':$dt[4].$data->$dt[5]
                            ,$dt[6]
                            ,$dt[4]=='#'?'act="'.site_url($dt[7].$data->$dt[5]).'"':""
                            .$this->explode_alt($dt[8])." title='$title' alt='$title'");
                    else $ret=$dt[9];
                break;
            }
            break;
        }
        return $ret;
    }
    
    private function is_cetak_excel() {
        $cetak_excel=array();
        if(!isset($this->opt['cetak_off']))$cetak_excel['cetak']='cetak';
        if(!isset($this->opt['excel_off']))$cetak_excel['excel']='excel';
        $offset=(is_numeric($this->opt['offset']));
        return array(
            'is_cetak_excel'=>(!$offset && in_array($this->opt['offset'],$cetak_excel)),
            'cetak_excel'=>$cetak_excel,
            'ofs'=>$offset,
        );        
    }
    
    public function list_data($o,$offset=null){
        date_default_timezone_set($this->CI->config->item('waktu_server'));
        $this->opt =& $o;
        $this->opt['offset']=$offset;
        $id=$this->opt['id'];
        $tanpa_aksi=(
            ((@$this->opt['noaksi']))||
            (
            ((@$this->opt['can'])&&(count($this->opt['can'])==0))
                &&((@$this->opt['tombol_aksi'])&&(count($this->opt['tombol_aksi'])==0))) ?1:0
                );
        
        $this->CI->benchmark->mark('awalz');        
        $data['breadcrumb'] = $this->bc(uri_string());// array('' => 'Referensi',$o['module'].$o['inti'] => $o['title']);
        if (!empty($this->opt['bc'])){
            $data['breadcrumb'] = $this->bc($this->opt['bc']);
            $data['uri_menu']= $this->opt['bc'];
        }
        if (!empty($this->opt['breadcrumb'])) $data['breadcrumb'] = array_merge($data['breadcrumb'],$this->opt['breadcrumb']);
        
        /*$offset = !empty($offset) ? $offset : null;*/
        
        $search = null;
        $se = in_de(array('search' =>(!empty($this->opt['search']) ?  $this->opt['search']:  null)));
        if (!empty($this->opt['search'])) {
            $search = array();
            $se=$this->opt['search'];
            if (!empty($this->opt['kolom_cari'])) {
                foreach($this->opt['kolom_cari'] as $ks) { $search[$ks] = $this->opt['search']; } 
            } else {
                foreach($this->opt['kolom_tampil'] as $ks) { $search[$ks] = $this->opt['search']; } 

            }
        }
        
        if(!empty($this->opt['param_search']))$se=$this->opt['param_search'];
        
        $pakai_search=(is_array($search)?count($search)>0:0);
        
        #$select_tabel=array_intersect_key($this->opt,array('tabel','order','search','where','group_by'));
        #_cek($select_tabel);
        $select_tabel=array(
            'tabel' => $this->opt['tabel'],
            'search' => $search,
            'where' => @$this->opt['where'],
            'group_by' => @$this->opt['group_by'],
        );
        if(!empty($this->opt['in']))$select_tabel['in']=$this->opt['in'];
        if(!empty($this->opt['not_in']))$select_tabel['not_in']=$this->opt['not_in'];
        #cek($o['tabel']);
        if($pakai_search){
            $select_tabel['select'] = @$this->opt['select'];
            $total_row=$this->CI->general_model->datagrabse($select_tabel)->num_rows();
        }else{
            $select_tabel['select'] = 'count(*) jm';
            $total_row=$this->CI->general_model->datagrabe($select_tabel)->row('jm');
            $select_tabel['select'] = @$this->opt['select'];
        }
        if(!empty($this->opt['order']))$select_tabel['order'] = @$this->opt['order'];
            
        #-------------------paging
        extract($this->is_cetak_excel());
        extract($cetak_excel);
        
        
        $base_url=site_url(
                    $this->opt['module'].$this->opt['inti'].'/'
                    .(!empty($this->opt['pageplus'])?$this->opt['pageplus'].'/':'')
                    .$se);
        
        if(empty($this->opt['no_page'])){
        
            $config=array(
                'base_url'      => $base_url,
                'total_rows'    => $total_row,
                'per_page'      => (!empty($this->opt['pageper'])?$this->opt['pageper']:'10'),
                'uri_segment'   => (!empty($this->opt['pageuri'])?$this->opt['pageuri']:'6'),
            );
            
            $this->CI->pagination->initialize($config);
            
            $data['links']    = $this->CI->pagination->create_links();

            if(!$is_cetak_excel){
                $select_tabel['offset'] = $offset;
                $select_tabel['limit'] =$config['per_page'] ;
            } 
            
            $data['total'] = $config['total_rows'];
        
        }
        #------------------e-paging
        
        $this->CI->db->query("set lc_time_names = 'id_ID'");
        if($pakai_search){
            $query = $this->CI->general_model->datagrabse($select_tabel);
            if(!empty($this->opt['debug_list']))$select_tabel_test= $this->CI->general_model->datagrabse($select_tabel,1);
        }else{
            $query = $this->CI->general_model->datagrabe($select_tabel);
            if(!empty($this->opt['debug_list']))$select_tabel_test= $this->CI->general_model->datagrabe($select_tabel,1);
        }
        #$select_tabel_testx= $this->CI->db->last_query();
        #$ceksql=$this->CI->db->last_query();
        
        $ada_aksi=(
            (empty($this->opt['no_aksi']))
            ||(!$is_cetak_excel)
            ||(count(@$this->opt['can'])+count(@$this->opt['tombol_aksi'])>0)
            );
        
        #-----posisi aksi
        $aksidikiri=!empty($this->opt['aksidikiri']);
        
        /*if( (!$is_cetak_excel)
            &&(count(@$this->opt['can'])+count(@$this->opt['tombol_aksi'])>0)
            )$ada_aksi=1;*/
        
        $tabel="";
        if(!empty($this->opt['list_head']))$tabel.=$this->opt['list_head'];

        if ($query->num_rows() > 0) {
        //s-tabel
            $classy = ($is_cetak_excel ? 'class="tabel_print" border=1' : 'class="table table-striped table-bordered table-condensed table-nonfluid"');
            $this->CI->table->set_template(array('table_open'=>'<table '.$classy.'>'));
            
            $heads =array();
            if(empty($this->opt['no_no']))$heads[] ='No.';
            if($ada_aksi && $aksidikiri)$heads[]= $this->head_aksi_list;
            $heads = array_merge_recursive($heads,$this->opt['kolom']);
            if($ada_aksi && !$aksidikiri)$heads[]=$this->head_aksi_list;
            $this->CI->table->set_heading($heads);
            $no = (is_numeric($offset)? ($offset+ 1):1);
            foreach($query->result() as $row){
                $rows = array();
                
                $tabel_del = is_array($this->opt['tabel'])&&isset($this->opt['tabel_save'])?$this->opt['tabel_save']:$this->opt['tabel'];

                $btn_link = array();
                /*$edit_btn=$this->btn_edit($row->$id,$this->opt['module'].$this->opt['inti'].'/',uri_string())
                anchor('#','%s',
                                'class="btn btn-warning btn-edit btn-xs" act="'.site_url($this->opt['module'].$this->opt['inti'].'/'.in_de(array(
                                'modex' => 'form_mode',
                                'form_id' => $row->$id,
                                'ret_save'=>uri_string(),
                                ))).'"');*/
                $del_btn=anchor('#','<i class="fa fa-trash"></i>'
                                ,'class="btn btn-danger btn-delete btn-xs" act="'.site_url(
                                    'dm/Def/general_delete/'
                                    .in_de(array('id' => $row->$id,
                                                'redirect' => uri_string() ,#$this->opt['module'].$this->opt['inti'],
                                                'tabel' => $tabel_del,
                                                'kolom' => $this->opt['id'])))
                                    .'" msg="Apakah Anda ingin menghapus data ini?"');
                
                if(@$this->opt['can']){
                    if (in_array('edit',$this->opt['can'])) 
                        $btn_link[] = $this->btn_edit($row->$id,$this->opt['module'].$this->opt['inti'].'/',uri_string(),'',(!empty($this->opt['param_search'])?$this->opt['param_search']:""));
                    if (array_key_exists('edit',$this->opt['can'])) 
                        $btn_link[] = $this->btn_edit($row->$id,$this->opt['module'].$this->opt['inti'].'/',uri_string(),$this->opt['can']['edit'],(!empty($this->opt['param_search'])?$this->opt['param_search']:""));
                    if (in_array('delete',$this->opt['can'])) $btn_link[] = $del_btn;
                }
                if(@$this->opt['tombol_aksi']){
                    foreach ($this->opt['tombol_aksi'] as $key => $isi){
                        $isi1=$isi[1];
                            
                    switch($isi[0]){
                            #paramaksi
                        case 0:
                            $btn_link[] =$this->aksi($isi[1],$row,$key);
                        break;
                        case 1:
                            #with act
                            $btn_link[] =a($isi[2],'href="#" '.$isi[3].' title="'.$key.'"'.' act="'.site_url($isi[1].'/'.$row->$id).'"');
                            #anchor("#",$isi[2],$isi[3].' title="'.$key.'"'.' act="'.site_url($isi[1].'/'.$row->$id).'"');
                        break;
                        case 2:
                            $btn_link[] =anchor(
                                $isi[1].'/'.$row->$id.(@$isi[4]?$isi[4]:''),
                                $isi[2],
                                $isi[3].' title="'.$key.'"'.' ');
                        break;
                        case 3:
                            #campare and change field to rows
                            $btn_link[] =($row->$isi1?replaceto($isi[2],$row):($isi[3]?replaceto($isi[3],$row):''));
                        break;
                        case 4:
                            #edit_if 
                            if(!empty($row->$isi1))$btn_link[] =$this->btn_edit($row->$id,$this->opt['module'].$this->opt['inti'],uri_string(),(!empty($isi[2])?$isi[2]:''));
                        break;
                        case 5:
                            #del_if 
                            if(!empty($row->$isi1))$btn_link[] =$del_btn;
                        break;
                    }
                    } 
                }
                
                $row_aksi= implode('&nbsp;',$btn_link);
                
                if(empty($this->opt['no_no']))$rows[] =$no;
                
                if ($ada_aksi && $aksidikiri) $rows[] =$row_aksi;
                #cexxx if($no==1)cek(array($ada_aksi ,$aksidikiri,$rows,$row_aksi,$this->opt['can'],$btn_link,));
                
                foreach($this->opt['kolom_tampil'] as $kol) {
                    if(!empty($this->opt['detail_row'][$kol])){
                        $rows[] = $this->e_detail_row($row,$this->opt['detail_row'][$kol]);
                    }else{
                        if((($offset === "excel"))&&(strtoupper( $kol)=='NIP')){
                            $rows[] = chr(31).$row->$kol;
                        }else{
                            $rows[] = $row->$kol;
                        }
                        
                    }
                    
                }
                if ($ada_aksi&& !$aksidikiri) $rows[] =$row_aksi;
                
                    $this->CI->table->add_row($rows);
                
                $no++;
            }
            if(!empty($this->opt['list_foot'])){
                if(is_array($this->opt['list_foot'][0])){
                    foreach ($this->opt['list_foot'] as $list_foot) 
                        $this->CI->table->add_row($list_foot);
                }else{
                    $this->CI->table->add_row($this->opt['list_foot']);
                }
                
            }
            $tabel .= $this->CI->table->generate();
        }else{
            $tabel .= '<div class="alert alert-confirm">Tidak ada data</div>';
        }
        #$tabel.=($this->debug?komen($ceksql).'('.$tanpa_aksi.')':'');
        //e-tabel
        #----------------- button cetak
        $btn_cetak_excel=(@$this->opt['cetakexcel']?@$this->opt['cetakexcel']:array());
        if(@$cetak)$btn_cetak_excel[]='<li>'.anchor($this->opt['module'].$this->opt['inti'].'/'.(isset($this->opt['pageplus'])?$this->opt['pageplus'].'/':'').$se.'/cetak','<i class="fa fa-print"></i> Cetak','target="_blank"').'</li>';
        if(@$excel)$btn_cetak_excel[]='<li>'.anchor($this->opt['module'].$this->opt['inti'].'/'.(isset($this->opt['pageplus'])?$this->opt['pageplus'].'/':'').$se.'/excel','<i class="fa fa-file-excel-o"></i> Ekspor Excel','target="_blank"').'</li>';
        
        $btn_cetak = (($query->num_rows() > 0)&&(count($btn_cetak_excel)) ?
            '<div class="btn-group"  style="margin-left: 5px;">
            <a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#" style="margin: 0 0 0 5px">
            <i class="fa fa-print"></i> <span class="caret"></span>
            </a>'
            .'<ul class="dropdown-menu pull-right">'
            .implode('',$btn_cetak_excel)
            .'</ul>'
            
            .'</div>' : null);
        
        #----------------e- button cetak
        
        #----------------- tombol Tambah
        $tombol = array(); 
        if(@$this->opt['tombol'] && is_array($this->opt['tombol'] ))
        foreach($this->opt['tombol'] as $t) {
            switch($t[0]){
                case 0:
                case 1:
                    $c_btn = null;
                    if($t[0]==1){
                        $c_btn = "btn-success"; 
                    }else{
                        if(!empty($t[2]))$c_btn = $t[2]; 
                    }
                    $icn = '<i class="fa fa-plus"></i>';
                    $param_form=array(
                            'modex' => 'form_mode',
                            'new'=>1,
                            'ret_save'=>uri_string(),
                    );
                    if(!empty($this->opt['param_search']))
                        $param_form=$this->add_search($this->opt['param_search'],$param_form);
                    
                    #    $param_form=$this->add_search($this->opt['param_search'],$param_form);
                    
                    if(!empty($this->opt['tambah_hidden']))$param_form['tambah_hidden']=$this->opt['tambah_hidden'];
                    $tombol[] = anchor('#',$icn.' &nbsp; '.$t[1],
                        'class="btn-edit btn '.$c_btn.'" 
                        act="'.site_url($this->opt['module'].$this->opt['inti'])
                            .'/'.in_de($param_form).'"'
                        );
                break;
                
                case 2:
                    $tombol[] = anchor($t[1],$t[2],$t[3]);
                break;
                
                case 3:
                    $tombol[] = tag('a',$t[2],
                        (@$t[4]?$t[4]:'class="btn-edit btn btn-success" ')
                        .'act="'.site_url($t[1]).'" '
                        .(@$t[3]?$t[3]:''));
                break;
            }
            
        }
        
        $data['tombol'] = implode(' ',$tombol).' '.$btn_cetak;
        #----------------e- tombol Tambah
        
        #----------------- Extra tombol 
        $data['extra_tombol'] = (empty($this->opt['no_search'])?
        form_open($base_url,'id="form_search"').
            '<div class="input-group">
                <input name="search" type="text" placeholder="Pencarian ..." class="form-control pull-right" value="'.@$this->opt['search'].'">
                  <div class="input-group-btn">
                    <button class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>'
                .form_close():"");
        #----------------e- Extra tombol 
        
        $data['tabel']    = $tabel;
        if(!@$this->opt['title'])$this->opt['title']=end($data['breadcrumb']);
        if($is_cetak_excel){
            if($offset === "cetak") {
                $data['title'] = '<h3>'.$this->opt['title'].'</h3>';
                $cetak=$tabel;
                if(!empty($this->opt['kop'])){
                    $cetak=table(tr(td($this->opt['kop'])).tr(td($tabel)));
                }
                $data['content'] = $cetak;
                if(@$this->opt['return_object']){
                    return $data;
                }else{
                    $this->CI->load->view('dm/print',$data);
                }
            } else if ($offset === "excel") {
                $data['file_name'] = ($this->opt['title']?str_replace(" ","_",strtolower($this->opt['title'])):$this->opt['inti']).'.xls';
                $data['title'] = '<h3>'.$this->opt['title'].'</h3>';
                $data['tabel'] = $tabel;
                if(@$this->opt['return_object']){
                    return $data;
                }else{
                    $this->CI->load->view('dm/excel',$data);
                }
            }
        } else {
            if(@$this->opt['tabs'])$data['tabs']=$this->opt['tabs'];
            if(@$this->opt['list_script'])$data['script']=$this->opt['list_script'];
            $data['tabel'] = div($tabel,'class="box-body table-responsive no-padding"');
            if(!empty($this->opt['first_title']))$data['b4_title']=$this->opt['first_title'];
            if(!empty(@$this->opt['b4_title']))$data['b4_title']=$this->opt['b4_title'];
            
            if(!empty($this->opt['include_script']))$data['include_script']=$this->opt['include_script'];
            if(!empty($data['include_script']) && is_array($data['include_script']))$data['include_script']=implode("\n",$data['include_script']);
            if(!empty($this->opt['include']))$data['include']=$this->opt['include'];
            if(!empty($data['include']) && is_array($data['include']))$data['include']=implode("\n",$data['include']);
            if(!empty($this->opt['css_list']))$data['include'].='<style type="text/css"><!-- '.$this->opt['css_list'].' --> </style>';
                
            $data['title'] = $this->opt['title'];
            if( !empty($this->opt['last_title']))$data['after_title'] = $this->opt['last_title'];
            if(!empty(@$this->opt['after_title']))$data['after_title']=$this->opt['after_title'];
            $data['tombol_tambah'] = @$this->opt['tombol_tambah'];
            $data['extra_tombol'] .= @$this->opt['extra_tombol'];
            $this->CI->benchmark->mark('akhirzz');
            if($this->debug['list']) $data['tabel'].=div("<!-- ".$this->CI->benchmark->elapsed_time('awalz','akhirzz')." -->",'style="display:none;"');
            if(@$this->opt['heads'])$data['heads']=$this->opt['heads'];
            
            if(@$this->opt['debug_list']>0)$data['tabel'].=div( 
                ($this->opt['debug_list']==1
                    ?enkrip( $select_tabel_test,1) 
                    :$select_tabel_test)
                ,'style="display: none;"');
            if(!empty($this->opt['col_tombol']))$data['col_tombol']=$this->opt['col_tombol'];
            
            if(@$this->opt['return_object']){
                return $data;
            }elseif(@$this->opt['return_view']){
                $this->CI->load->view($this->fold."/standard_view", $data);
            }else{
                $data['content'] = $this->fold."/standard_view";
                $this->CI->load->view($this->fold.'/home', $data);
            }                
        }
    }
    
    function save_data($o = null) {
        date_default_timezone_set($this->CI->config->item('waktu_server'));
        
        if($_POST){
            $data=post(null);
            if(!empty($data['formENC']))$data=array_merge($data,un_de($data['formENC']));
            if(@$data['o'])$o=un_de($data['o']);
            $id = post(@$o['id']);
        }elseif($o['data']){
            $data=$o['data'];
            $id = $data[$o['id']];
        }else{
            redirect($o['module'].$o['inti']);
        }
        #stop($_POST);
        #--------new struct 171004
        if(@$o['kolom_data'] && is_array($o['kolom_data']))$simpan=array_intersect_key($data,array_flip($o['kolom_data']));
        if(@$o['form'] && is_array($o['form']))
        foreach($o['form'] as $kol) {
            //$tmp = !empty($_FILES[$kol[3]]) ? $_FILES[$kol[3]]['tmp_name'] : null;
            switch($kol[0]) {
                case  1:
                    switch(@$kol[5]) {
                        case "timepicker": $simpan[$kol[3]] = date("H:i:s", strtotime($simpan[$kol[3]]) ); break;
                        case "datepicker":$simpan[$kol[3]] = date("Y-m-d", strtotime($simpan[$kol[3]]) ); break;
                        case "airdatepicker": $simpan[$kol[3]] =tgl2sql($simpan[$kol[3]]); break;
                        case "formatnumber": $simpan[$kol[3]] = currencyToNumber($simpan[$kol[3]]); break;
                        case "airdatetimepicker": 
                            $simpan[$kol[3]] =tgl2sql($data[$kol[3]."_tgl"])." ".$data[$kol[3]."_jam"]; 
                        break;
                    }
                break;
                case 7:
                    if ( !empty($_FILES[$kol[3]]) ) {
                        $path = './uploads/'.($kol[5]?$kol[5].'/':'dm/');
                        if (!is_dir($path)) mkdir($path,0777,TRUE);
                        if(!empty($kol[6]))$this->allowed_type_upload=$kol[6];
                        $this->CI->load->library('upload');
                        $this->CI->upload->initialize(array(
                            'upload_path' => $path,
                            'allowed_types' => $this->allowed_type_upload,
                        ));
                        $this->CI->upload->do_upload($kol[3]);
                        $data_upload = $this->CI->upload->data();
                        
                        if ($onerror = $this->CI->upload->display_errors('&nbsp','&nbsp')){
                            if($data_upload['file_name'])$this->CI->session->set_flashdata('fail',"<b>Gagal Upload File</b> : ".$data_upload['file_name'].', '.$onerror);
                        }else {
                            if(@$o['kolom_data'][$kol[3]]){
                                $simpan[$kol[3]] = $data_upload['file_name'];
                            }else{
                                $files[$kol[3]] = $data_upload['file_name'];
                            }
                        }
                    }
                break;
                case 3:
                    if(!empty($simpan[$kol[3]]))
                    $simpan[$kol[3]] = htmlentities( $simpan[$kol[3]]);
                break;
                case 4:
                    if(!isset($data[$kol[3]]))
                    $simpan[$kol[3]] = (!empty($kol[5])?$kol[5]:0);
                break;
                case 53:
                    if(!$id){
                        $simpan[$kol[4]] = htmlentities( $simpan[$kol[4]]);
                    }else{
                        
                    }
                break;
            }
        }
        #-------E-new struct
        
            
        $tbl = $o['tabel'];
        if(is_array($o['tabel'])){
            if(@$o['tabel_save']){
                $tbl=$o['tabel_save'];
            }else{
                $tkey=array_keys($tbl);
                $tbl=substr($tkey[0],0,strpos($tkey[0],' '));
            }                    
        }
        if(strpos($tbl,' ')>0)$tbl=substr($tbl,0,strpos($tbl,' '));
        
        #--------------------cek
        if($o['inti']=='baperjakat/kop/daftar')stop(
            array($tbl,$simpan,$o,$data,/*$sukses_id,*/$o['id'],$id))
        ;
        if(@$data['new'])$o['new']=1;
        #stop(array($_POST,$data,$tbl,'s'=>$simpan,@$o['new'],@$o['id'],$id,$o));
        if($sukses_id=$this->CI->general_model->save_data($tbl,$simpan,$o['id'],(@$o['new']?null:$id)))
            $this->CI->session->set_flashdata('ok','Data berhasil disimpan');
        $sql_query=$this->CI->db->last_query();    
        if($this->debug['save']==1 || !empty($data['debug_save']))cek(array($tbl,$simpan,$o,$data,$sql_query));
        #stop($sql_query);
        #new return_save=1
        if(empty($o['return_save'])){
            if(@$o['ret']){
                $o['data']=$data;
                $enkrip=array(
                    'sukses_id'=>$sukses_id,
                    'id'=>$id,
                    'o'=>$o,
                    'simpan'=>$simpan,
                    'tabel_save'=>$tbl,
                    'sql'=>$sql_query,
                    'files'=>$files,
                );
                redirect($o['ret']['fold'].'/'.$o['ret']['def'].'/'.$o['ret']['func'].'/'.enkrip($enkrip,1));
                /*load_controller($o['ret']['fold'],$o['ret']['def'],$o['ret']['func'],in_de(array(
                    'sukses_id'=>$sukses_id,
                    'id'=>$id,
                    'o'=>$o,
                    'simpan'=>$simpan,
                    'sql'=>$sql_query,
                    )
                ));*/
            }elseif(@$data['ret_save']){
                redirect($data['ret_save']);
            }else{
                redirect($o['module'].$o['inti']);
            }
        }else{
            return  $sukses_id;
        }
            
    }

    function general_delete($par) {
        
    
        login_check($this->CI->session->userdata('login_state'));
    
        $p = extract(un_de($par));
        $tmp_eid=$tabel;           
        if(is_array($tabel)) $tmp_eid=current(array_keys($tabel));
        $tmp_eid=explode(' ',$tmp_eid);
        $tabel=$tmp_eid[0]; 
        
        $this->CI->general_model->delete_data($tabel,$kolom,$id);
        $this->CI->session->set_flashdata('ok','Data berhasil dihapus');
    
        if(!empty($redirect))redirect($redirect);
        if (!empty($offset))redirect($p['redirect'].'/'.$search.'/'.$offset);
    }

  function form_data($o,$id = null) {
    $this->CI->benchmark->mark('awalz');        
        #$this->load->helper('tinymce');
    date_default_timezone_set($this->CI->config->item('waktu_server'));
    $this->opt=$o;
    
    $data['title'] = (empty($id) ? 
        (isset($this->opt['title_ft'])?$this->opt['title_ft']:'Tambah ') : 
        (isset($this->opt['title_fu'])?$this->opt['title_fu']:'Ubah '))
                    .(isset($this->opt['title'])?$this->opt['title']:'');
    $data['form_link'] = (@$this->opt['save_to']
        ?$this->opt['save_to']
        :trim(@$this->opt['module'],'/').'/'.@$this->opt['inti'].'/'.in_de(array('modex' => 'save_mode','new'=>(@$this->opt['new']?1:0)))
        );
    
    if(!@$this->opt['eid']){
        if(is_array(@$this->opt['tabel'])){
            $tmp_eid=explode(' ',current(array_keys($this->opt['tabel'])));
            $this->opt['eid']=$tmp_eid[1].".".$this->opt['id'];
        }else{
            $this->opt['eid']=@$this->opt['id'];
        }
    }
    $ambil_tabel=array(
        'tabel'=>$this->opt['tabel'],
        'select' => @$this->opt['select'],
        'where'=>array(),
    );
    
    if(!empty(@$this->opt['where_id']))
        $ambil_tabel['where']=$this->opt['where_id'];
    if(!empty($id))
        $ambil_tabel['where']=array_merge(
            array($this->opt['eid']=>$id),
            $ambil_tabel['where']);
    
    if(!empty(@$this->opt['where']))
        $ambil_tabel['where']=array_merge(
            $this->opt['where'],
            $ambil_tabel['where']);
    
    #cek($ambil_tabel);
    
    $def=null;
    if(!empty($id)){
        $def = $this->CI->general_model->datagrabe($ambil_tabel)->row();
    }elseif(!empty($this->opt['def'])){
        $def=(object)$this->opt['def'];
    }
    #revisi 90219
    
    /*if(!@$this->opt['def']){
        $def = !empty($id) ? $this->CI->general_model->datagrabe(
            $ambil_tabel
            )->row(): null;
        $sql_cek=$this->CI->db->last_query();
        #------------cek
        if(1==2)stop(array('id'=>$id,'last'=>$sql_cek,'def'=>$def));
    }else{
        $def=(object)$this->opt['def'];
    }*/
    
    #new 180804
    if(!empty($this->opt['tambah_hidden']) && (empty($id) ))
        $key_hidden=array_keys( $this->opt['tambah_hidden']);
    
    $data['form_data'] = form_hidden(@$this->opt['id'],@$id)//$def->$this->opt['id']
                        .(@$this->opt['save_to']?form_hidden('o',in_de($this->opt)):'')
                        .(empty($id)?form_hidden('new',1):'')
                        .(!empty($this->opt['ret_save'])?form_hidden('ret_save',$this->opt['ret_save']):'')
                        .(!empty($key_hidden)?$this->frm_hidden($this->opt['tambah_hidden']):"")
                        ;
    
    $data['out_script'] = 
    $data['script'] = 
    $data['include'] = null;
    
    /*$to_datepicker = $to_timepicker = $to_typeahead = $to_subtypeahead = array();*/
    $ada_typea=
    /*$ada_dataselect=*/
    $ada_ui=false;
    
    foreach($this->opt['form'] as $fo) {
        if(!empty($key_hidden)&& in_array($fo[3],$key_hidden))continue;
        
        //   0         1     2      3    
        $form_data = $fo[]=$fo[]=''; # agar apa 4&5 tak perlu di isi
        
        if(count($fo)<6){
            $fo[]="";$fo[]="";$fo[]="";$fo[]="";$fo[]="";$fo[]="";
        }
        list($tipeform0,$requ1,$label2,$nama3,$apa4,$apa5)=$fo;
        
        #$extra_form = null;
        //$req = ($requ1  ? 'required' : '');

        switch($tipeform0){
            #def
            case -4:
                $fr=$def->$requ1;
            break;
            #html
            case -3:
                $fr=$requ1;
            break;
            #load_cnt
            case -2:
                $fr=$this->form_div($fo,$def);
            break;
            
            #label
            case -1:
            
            $fr = form_label($label2);
            break;
            
            #hidden
            case 0 :
            #use nama3->name,apa4->default_value  // new apa5
            $fr = form_hidden($nama3,($label2=='-'?$apa4:(!empty($def->$nama3)?$def->$nama3:(!empty($def->$apa5)?$def->$apa5:$apa4))));
            break;
            
            #text
            case 1 : 
                list($fr,$data)=$this->inp1($fo,@$def,$data);
            break;
            
            #form_dropdown
            case 2 : 
                list($fr,$data)=$this->inp2_dropd($fo,@$def,$data);
            break;
            
            #form_textarea
            case 3 :
                list($fr,$data)=$this->inp3_textarea($fo,@$def,$data); 
                    /*$fr = '<p>'.form_label($label2)
                    .form_textarea($nama3,html_entity_decode(@$def->$nama3),'class="'.$fo[4].' textarea form-control" style="height: 75px" '.($requ1  ? 'required' : '')).'</p>'; 
                    if(!$apa5)$ada_textarea=true; */
            break;
               
            case 4 : //checkbox
                
                $cek = (!empty($def->$nama3) && (@$def->$nama3== $apa4)? 'checked' : null);
                $fr = div(
                            form_label(
                                form_checkbox($nama3,$apa4,(@$def->$nama3== 1),'class="incheck"')
                                .$label2
                            )
                        ,'class="checkbox"')
                    /*.'<div class="checkbox">
                    <label>
                      <input type="checkbox" class="incheck" name="'.$nama3.'" value="'.@$def->$nama3.'" '.$cek.'> '.$label2.'
                    </label>
                  </div>'*/; 
            break;
                  
            case 5:
                $fr = '';
                foreach ($apa4 as $x=>$y){ 
                    $fr .= form_label(
                        form_radio($nama3,$x,(@$def && @$def->$nama3 ?($x==$def->$nama3):(@$apa5?($apa5==$x):"")),'class="incheck'.(@$fo[6]?' '.$fo[6]:'').'"'.@$fo[7]).$y);
                }
                $fr = 
                    "<p>"
                    .form_label($label2)
                    .div($fr,"class='checkbox'")
                    ."</p>";
            break;
            
            //INPUT HIDDEN
            case 6 : 
               // $valhid= !empty(@$def->$nama3)?$def->$nama3;
                $valtext= (@$def->$nama3)? 'text'  : 'hidden';
                $vallabel= (@$def->$nama3)? 'class=""' : 'class="label hidden"';
                $isi =  @$def->$nama3?$def->$nama3:@$fo[7]; // !empty(@$def->$fo[4])? @$def->$fo[5] : 
               // $subval = !empty(@$fo[5])? form_hidden(@$fo[5], @$def->$fo[5]) : null;

                    $fr = '<p><div class="'.@$fo[6].'">'
                    //.$subval
                    
                    .'<label '.$vallabel.' id="label'.$nama3.'">'.$label2.'</label>'
                    .'<input '.($requ1  ? 'required' : '').' name="'.$nama3.'" type="'.$valtext.'" value="'.$isi.'" id="'.$nama3.'" class=" '.@$fo[4].'" '.@$fo[5].' />'
                    .'</p>'
                    .'</div>'; 
                break;
                
           #------- upload ke 5 di isi folder upload tnde/sm
           case 7:
                    $fr = '<p class="form-group">'
                        .form_label($fo[2]).'<br>'.@$def->$fo[3]
                        .form_hidden(array('files[]'=>$fo[3],'files_path[]'=>$fo[5]))
                        .form_upload($fo[3],@$def->$fo[3],'class="'.$fo[4].'" '.($requ1  ? 'required' : ''))
                        .'</p>'; 
                    $data['multi']=1;
                    break;

           #---typeahead         
           case 8 : 
                list($fr,$data)=$this->inp8_typeahead($fo,@$def,$data);
           break;

           #---select2
           case 9 : 
                list($fr,$data)=$this->inp9_select2($fo,@$def,$data);
           break;
                
           #dropdown
           case 10 : 
                    $fr = '<p>'
                    .form_label($label2)
                    .form_dropdown($nama3,$apa4,(@$def?$def->$nama3:(@$fo[6]?$fo[6]:0)),'class="'.$apa5.' form-control " id="'.$nama3.'" style="width: 100%" '.($requ1  ? 'required' : ''))
                    .'</p>';
           break;
                
           #dropdown select2
           case 11 : 
                list($fr,$data)=$this->inp11_select2($fo,@$def,$data);
           break;
           
           case 12 : 
                    $fr = '<p>'
                    .form_label($label2)
                    .form_dropdown($nama3,$this->CI->general_model->combo_box($apa4),(@$def?$def->$nama3:(@$fo[6]?$fo[6]:0)),'class="'.$apa5.' form-control " id="'.$nama3.'" style="width: 100%" '.($requ1  ? 'required' : ''))
                    .'</p>';
           break;
           
           #same as 3 with save no htmlentities
           case 13 :
                list($fr,$data)=$this->inp3_textarea($fo,@$def,$data); 
           break;
           
           #---select2_with if par1 then par2 else select2_par3
           case 49 : 
                if($fo[1]){
                    $fr=$fo[2];
                }else{
                    array_shift($fo);
                    array_shift($fo);
                    list($fr,$data)=$this->inp9_select2($fo,@$def,$data);
                }
           break;
           
           #---- if par1 then conv:par1::def else_if par2 then par2 else_if par3 and def then par3 else_if par4 then if new par4[0] else par4[1]
           case 50:
                if($requ1){
                    $fr=$this->changeto( $requ1,@$def);
                }elseif($label2){
                    $fr=$label2;
                }elseif($nama3&&@$def){
                    $fr=$this->changeto( $nama3,@$def);
                }elseif($apa4){
                    $fr=$apa4[(!$id?0:1)];
                }
           break;
           
           #----- universal command
           case 51 : 
                #jika posisi tambah
                if(is_array($requ1))
                if(!$id){
                    list($fr,$data)=$this->inp3_textarea($fo,@$def,$data);
                }else{
                    array_shift($fo);
                    list($fr,$data)=$this->inp3_textarea($fo,@$def,$data);
                }
           break;
           
           #---- text area if tambah then par1 else inp3_textarea
           case 53 : 
                #jika posisi tambah
                if(!$id){
                    $fr=$requ1;
                }else{
                    array_shift($fo);
                    list($fr,$data)=$this->inp3_textarea($fo,@$def,$data);
                }
           break;
           
        }
            
            $data['form_data'].= $fr;
            
        }
        
        if($this->debug['form'] || !empty($this->opt['debug_form'])){
                $data['form_data'].= $this->CI->general_model->datagrabe($ambil_tabel,1);
                cek(array('fr'=>$fr,'def'=>$def,'form_data'=>$data['form_data']));
        }
        
        #if($ada_typea)$data['include']['typeahead']=reqjs('assets/plugins/typeahead/typeahead.min.js');
        #temp inp1
        #if(count($to_timepicker)>0)$data['include']['timepick']=reqcss('assets/plugins/timepicker/bootstrap-timepicker.min.css').reqjs('assets/plugins/timepicker/bootstrap-timepicker.min.js');
             /*'<link rel="stylesheet" href="'.base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css').'">'
            .'<script type="text/javascript" src="'.base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js').'"></script>';*/
        /*if($ada_dataselect)$data['include'].=reqcss('assets/plugins/select2/select2.css').reqjs('assets/plugins/select2/select2.js');*/
            /*'<link href="'.base_url('assets/plugins/select2/select2.css').'" rel="stylesheet" type="text/css" />'
            .'<script type="text/javascript" src="'.base_url('assets/plugins/select2/select2.js').'"></script>';*/
        
        if (!empty($this->opt['form_script'])) $data['script'] .= $this->opt['form_script'];
        if (!empty($this->opt['out_script'])) $data['out_script'] .= $this->opt['out_script'];
        if(is_array($data['include']))$data['include']=implode("\n",$data['include']);
        if(!empty($this->opt['heads']))$data['heads']=$this->opt['heads'];
        if(!empty($this->opt['ret_list']))$data['ret']=site_url($this->opt['ret_list']);
        #if(!empty($this->opt['ret_save']))$data['form_data'].=form_hidden('ret_save',$this->opt['ret_save']);
        if(!empty($this->opt['css_form']))$data['include'].='<style type="text/css"><!-- '.$this->opt['css_form'].' --> </style>';
        if(!empty($this->opt['script_submit']))$data['script_submit']=$this->opt['script_submit'];
        if(!empty($this->opt['form_button']))$data['tombol_form']=$this->opt['form_button'];
        $this->CI->benchmark->mark('akhirzz');
        $data['form_data'].=div("<!-- ".$this->CI->benchmark->elapsed_time('awalz','akhirzz').":". $this->CI->benchmark->memory_usage()." -->",'style="display:none;"');
        
        if(!empty($this->opt['return_object'])){
            return $data;
        }elseif(!empty($this->opt['return_view'])){
            $data['content'] = "dm/form_view";
            $this->CI->load->view('dm/home', $data);
        }else{
            $this->CI->load->view('dm/form_view',$data);
        }                
    }
    
  
  /** v 15
  * 1regu, 2label, 3nama 4url_complete 5css 6fiels_name_on_Def 
  * 7function_onchange 
  * 8array('id,'data)
  * 9array(
  *     param_data=>,data:??   -> (new send post with parameter on form) 
  *     param_process          ->      on process data
  * )  
  * 10_Other_attr
  *  ret:: fr, data[include. script]
  * 
  */
  function inp9_select2($fo,$def='',$data=array()) {
      $param_data=$param_process=$before_script=$return_plus="";
      list(,$requ1,$label2,$nama3,$apa4,$apa5)=$fo;
      if(@$fo[9])extract($fo[9]);
      if(empty($data)){
          $data=array();$data['include']=array();
      }
      if(empty($data['include']))$data['include']=array();
      if(empty($data['include']['select2']))
          $data['include']['select2']=reqcss('assets/plugins/select2/select2.css').reqjs('assets/plugins/select2/select2.js');
      
        
      
      if(!$fo6=@$fo[6])die($label2.' param ke 6 wajib di isi!!');
      $f7=@$fo[7];
      $data9=(@$def?array(@$def->$nama3=>@$def->$fo6,):array());
      if(!@$data['script'])$data['script']='';
      
        /*if($this->debug)cek(array($data9));*/
      $f8_=array('id'=>'id','data'=>'data');
      if(($f8=@$fo[8])&&(is_array($f8)))$f8_=$f8;
      
      $faram=array(
        'url'=>"'".site_url($apa4)."'",
        'dataType'=> "'json'",
        'type'=> "'POST'",
        'delay'=> "250",
        'cache'=> "true",
      );
      if(!empty($faram_set))foreach ($faram_set as $fkx => $fval) $faram[$fkx]=$fval;
      
      $faram_x=$this->explode_parm($faram);
      $fr = '<p>'
        .form_label($label2)
        .form_dropdown($nama3,$data9,@$def->$nama3,'class="'.$apa5.' form-control" id="'.$nama3.'" '.@$fo[10].' style="width: 100%" '.($requ1  ? 'required' : ''))
        .'</p>';
        $data['script'].="
        $before_script
        \$('#".$nama3."').select2({
            val:'".(@$def->$nama3?$def->$nama3:'null')."',
            ajax: {
                $faram_x
                ,data: function (params) {
                      return {
                        q: params.term, // search term
                        page: params.page$param_data
                      };
                    },
                processResults: function (data, params) {
                      params.page = params.page || 1;
                      return {
                        results: $.map(data, function (item) {
                            $param_process
                            return {
                                text: item.$f8_[data],
                                id: item.$f8_[id]$return_plus
                            }
                        })
                      };
                }
            }
        })"
        #.(!empty($f7)?";\$('#".$nama3."').on('change', function (e) { ".$f7."  })":'')#/* e.currentTarget.value */
        .(!empty($f7)?".on('change', function (e) { ".$f7."  })":'')#/* e.currentTarget.value */
        .(!empty($onplus)?$onplus:"")
        .";\n";
      return array($fr,$data);
  }
  
  function inp11_select2($fo,$def='',$data) {
      list(,$requ1,$label2,$nama3,$apa4,$apa5)=$fo;
      
      if(!@$data['include']['select2'])
        $data['include']['select2']=reqcss('assets/plugins/select2/select2.css').reqjs('assets/plugins/select2/select2.js');
      if(!@$data['script'])$data['script']='';
      
      $fr = '<p>'
            .form_label($label2)
            .form_dropdown($nama3,$apa4,@$def->$nama3,'class="'.$fo[5].' form-control " id="'.$nama3.'" style="width: 100%" '.($requ1  ? 'required' : ''))
            .'</p>';
            $data['script'].="\$(document).ready(function(){
                    \$('#$nama3').select2({
                            minimumInputLength: 2,
                            multiple:true,
                            delay: 250,
                            ajax: {
                    url: '".site_url($fo[6])."',
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    cache: true,
                    data: function (params) {
                            console.log(params);
                          return {
                            q: params.term, // search term
                            page: params.page
                          };
                        },
                    processResults: function (data, params) {
                          params.page = params.page || 1;
                          return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.data,
                                    id: item.id
                                }
                            })
                          };
                    }
                }
                    })
                    });";
            /*$ada_dataselect=true;*/
      return array($fr,$data);
  }
  
  function inp8_typeahead($fo,$def='',$data) {
      //list(,$requ1,$label2,$nama3,$apa4,$apa5)=$fo;
      
      if(!@$data['include']['typeahead'])
        $data['include']['typeahead']=reqjs('assets/plugins/typeahead/typeahead.min.js');
      if(!@$data['script'])$data['script']='';
      
      $fr = '<p class="form-group">'
            .form_label($fo[2])
            .form_input($fo[3],@$def->$fo[3],'id="'.$fo[3].'" autocomplete="off" class="typeahead '.$fo[5].'" '.($requ1  ? 'required' : ''))
            .'</p>'; 
       
      $data['script'].="
            function display".$fo[3]."(item) {
                \$('#".$fo[3]."').removeAttr('value');
                \$('#".$fo[3]."').attr('value', item.value);                    
                \$('#".$fo[3]."').val(item.value);
            }
            \$('#".$fo[3]."').typeahead({
                ajax: '".site_url('tnde/autocomplete/'.$fo[4])."',
                displayField: 'data',
                limit: 10,
                valueField: '".$fo[3]."',
                onSelect: display".$fo[3]."
            });
      ";
      if(!@$data['include']['typeahead'])
        $data['include']['typeahead']=reqjs('assets/plugins/typeahead/typeahead.min.js');
      
      return array($fr,$data);
  }
  
  function inp3_textarea($fo,$def='',$data) {
      $this->CI->load->helper('tinymce');
      list(,$requ1,$label2,$nama3,$apa4,$apa5)=$fo;
      $style=(@$fo[6]?$fo[6]:'height: 75px');
      $fr = '<p>'.form_label($label2)
              .form_textarea($nama3,html_entity_decode(@$def->$nama3),'class="'.$apa4.' textarea form-control" style="'.$style.'" '.($requ1  ? 'required' : '')).'</p>';               
      if(!$apa5){
        $data['include']['tinymce']=reqjs('assets/tinymce/tinymce.min.js');
        $data['script'].=tinymce();
    }
      return array($fr,$data);
  }
  
  function inp1($fo,$def='',$data) {
    
    date_default_timezone_set($this->CI->config->item('waktu_server'));
    $extra_form =$form_data= null;
        
      list(,$requ1,$label2,$nama3,$apa4,$apa5)=$fo;
      
      if ($apa5){
        switch ($apa5) {

            case "formatnumber":
                if($def)$form_data = !empty($def->$nama3)?numberToCurrency($def->$nama3):null;
                $extra_form = ' onkeyup="formatNumber(this)"';
            break;

            case "datepicker":
                if($def)$form_data = (isset($def->$nama3)?date("d-m-Y",strtotime($def->$nama3)):null);//$def->$nama3;//
                $extra_form ='autocomplete="off"';  
                $data['script'].="
                    $('#".$nama3."').datepicker({
                        format: 'dd-mm-yyyy',
                  todayBtn: 'linked',
                  clearBtn: true,
                  language: 'id',
                  autoclose: true,
                  todayHighlight: true});

                  $('#".$nama3."').change(function(){
                    $('#".$nama3."').removeAttr('value');
                  });
                ";
            break;

            case "yearpicker":
                if($def)$form_data = !empty($def->$nama3)?date("Y",strtotime($def->$nama3)):null;
                $data['script'].="
                  \$('#".$nama3."').datepicker({
                        format: 'yyyy',
                        viewMode: 'years', 
                        minViewMode: 'years',
                      //todayBtn: 'linked',
                      clearBtn: true,
                      language: 'id',
                      autoclose: true,
                      //todayHighlight: true
                  });

                  \$('#".$nama3."').change(function(){
                    \$('#".$nama3."').removeAttr('value');
                  });
                ";
            break; 

            case "timepicker":
                if($def)$form_data = $def->$nama3;
                $addclass= 'bootstrap-timepicker';
                  $data['script'].="
                        $('#".$nama3."').timepicker({
                          showInputs: false,
                          minuteStep: 1,
                          showSeconds: true,
                          secondStep: 1,
                          showMeridian: false
                        });\n";
                  $data['include']['timepick']=reqcss('assets/plugins/timepicker/bootstrap-timepicker.min.css').reqjs('assets/plugins/timepicker/bootstrap-timepicker.min.js');
            break;

            case "airdatepicker":
                if($def)
                    $form_data =(!empty($def->$nama3)? ($def->$nama3=='00/00/0000'?date("d-m-Y"):date("d-m-Y",strtotime($def->$nama3))):null);//$def->$nama3;//
                $extra_form ='class="datepicker-here" data-language="id" autocomplete="off"';  
                $data['script'].="
                    var apa='".@$def->$nama3."';
                    var current".$nama3."Date = new Date();
                    $('#".$nama3."').datepicker().data('datepicker').selectDate(
                        new Date("
                        .($def
                        ?
                        (!empty($def->$nama3)?$def->$nama3=='00/00/0000'?date("Y-m-d"):
                        date("Y",strtotime($def->$nama3)).','.(date("m",strtotime($def->$nama3))-1).','.date("d",strtotime($def->$nama3))
                        :"")
                        :"current".$nama3."Date.getFullYear(), 
                        current".$nama3."Date.getMonth(), current".$nama3."Date.getDate()")
                        .")
                    );
                ";
                $data['include']['airdatepicker']=
                    reqcss('assets/plugins/air-datepicker/datepicker.min.css')."\n"
                    .reqjs('assets/plugins/air-datepicker/datepicker.min.js')."\n"
                    .reqjs('assets/plugins/air-datepicker/datepicker.id.js')."\n"
                    ;
            break;
            
            case "airdatetimepicker":
                if($def)
                    $form_data = (isset($def->$nama3)?date("d-m-Y",strtotime($def->$nama3)):null);//$def->$nama3;//
                $extra_form ='class="datepicker-here" data-language="id" autocomplete="off"';  
                $data['script'].="
                    var apa$nama3='".@$def->$nama3."';
                    var current".$nama3."_tgl"."Date = new Date();
                    $('#".$nama3."_tgl"."').datepicker().data('datepicker').selectDate(
                        new Date("
                        .($def
                        ?date("Y",strtotime($def->$nama3)).','.(date("m",strtotime($def->$nama3))-1).','.date("d",strtotime($def->$nama3))
                        :"current".$nama3."_tgl"."Date.getFullYear(), 
                        current".$nama3."_tgl"."Date.getMonth(), current".$nama3."_tgl"."Date.getDate()")
                        .")
                    );
                    $('#".$nama3."_jam"."').timepicker({
                          showInputs: false,
                          minuteStep: 1,
                          showSeconds: true,
                          secondStep: 1,
                          showMeridian: false
                        });\n
                ";
                $data['include']['airdatepicker']=
                    reqcss('assets/plugins/air-datepicker/datepicker.min.css')."\n"
                    .reqjs('assets/plugins/air-datepicker/datepicker.min.js')."\n"
                    .reqjs('assets/plugins/air-datepicker/datepicker.id.js')."\n"
                    .reqcss('assets/plugins/timepicker/bootstrap-timepicker.min.css')."\n"
                    .reqjs('assets/plugins/timepicker/bootstrap-timepicker.min.js')."\n"
                    ;
            break;
            
            case "colorpicker":
                if($def)$form_data = (isset($def->$nama3)?$def->$nama3:null);//$def->$nama3;//
                $extra_form ='autocomplete="off"';  
                $data['script'].=" $('.".$nama3."_pc').colorpicker();\n";
                $data['include']['colorpicker']=
                    reqcss("assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css")
                    .reqjs('assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js');
            break;
            
        }
        
      } else {
        $form_data = @$def->$nama3;
      }
      
      
      if (!empty($fo[6])) 
        $extra_form = $fo[6];
      if($apa5==='airdatetimepicker'){
          $fr = div(div('<div class="'.@$addclass.'"><p>'
                .form_label("Tanggal ".$label2)
                .form_input($nama3."_tgl",date("d/m/Y",strtotime($form_data)),' class="'.@$apa4.' form-control" id="'.$nama3."_tgl".'" '.($requ1  ? 'required' : '').' '.$extra_form)
                .'</p></div>','class="col-md-6"')
                .div('<div class="bootstrap-timepicker"><p>'
                .form_label("Jam ".$label2)
                .form_input($nama3."_jam",substr(@$def->$nama3,-8),' class="'.@$apa4.' form-control" id="'.$nama3."_jam".'" '.($requ1  ? 'required' : ''))
            .'</p></div>','class="col-md-6"'),'class="row"');
      }elseif($apa5==='colorpicker'){
          $fr =
            form_label($label2)
            .div(
            form_input($nama3,$form_data,' class="'.@$apa4.' form-control" id="'.$nama3.'" '.($requ1  ? 'required' : '').' '.$extra_form)
            .div('<i style="background-color: rgb(105, 71, 71);"></i>','class="input-group-addon"')
            ,'class="input-group '.$nama3.'_pc colorpicker-element"');
      }else{
          $fr = '<div class="'.@$addclass.'"><p>'
                .form_label($label2)
                .form_input($nama3,$form_data,' class="'.@$apa4.' form-control" id="'.$nama3.'" '.($requ1  ? 'required' : '').' '.$extra_form)
            .'</p></div>'
      ;
      }
      
      if (!empty($fo[7])) 
        $data['script'].="
            \$('#".$nama3."').change(function() {
                    var id = $(this).val();
                    \$('#".$fo[8]."').attr('type', 'hidden');

                console.log(id);
               
                \$.ajax({
                    url: '".site_url($fo[7])."',
                    async: false,
                    type: 'POST',
                    data: 'id='+id,
                    dataType: 'json',
                    success: function(data) {
                     $('#".$fo[8]."').attr('value', data);
                     $('#".$fo[8]."').attr('type', 'text');
                     $('#label".$fo[8]."').removeAttr('class');
                    }
                })
            });
        ";
      
            
      return array($fr,$data);
  }
  
  function inp2_dropd($fo,$def='',$data) {
      list(,$requ1,$label2,$nama3,$apa4,$apa5)=$fo;
      
      if(!@$data['script'])$data['script']='';
      
      if (@$fo[6]) {
            # code...
            $data['script'].="
                \$('#".$fo[7]."').ready(function(){
                    var item = \$('#".$fo[7]."');
                    item.empty();
                    var data = '".@$def->$fo[7]."';
                    if (data != null){
                    var idjenis = '".@$def->$nama3."';  

                    \$.ajax({
                    url: '".site_url($fo[6])."',
                    async: false,
                    type: 'POST',
                    data: 'id='+idjenis,
                    dataType: 'json',

                    success: function(data) {
                       // var obj = [];
                        \$('#".$fo[7]."').append('<option value=".@$def->$fo[7]." selected=selected>--PILIH--</option>');  
                    $.each(data, function(key, val){
                   // obj.push(val.item);
                    console.log(val.item);
                  
                        \$('#".$fo[7]."').append('<option value='+val.id+'>'+val.item+'</option>');  
                            })
                            //end each
                            }
                        })
                        }
                });

                \$('#".$nama3."').change(function() {
                    var id = $(this).val();
                   
                    \$('#".$fo[7]."').empty();
                    console.log(id);
                   
                    \$.ajax({
                        url: '".site_url($fo[6])."',
                        async: false,
                        type: 'GET',
                        data: 'id='+id,
                        dataType: 'json',

                        success: function(data) {
                           // var obj = [];
                            \$('#".$fo[7]."').append('<option value=>--PILIH--</option>');  
                        $.each(data, function(key, val){
                           // obj.push(val.item);
                            console.log(val.item);
                          
                          \$('#".$fo[7]."').append('<option value='+val.id+'>'+val.item+'</option>');  
                        })
                        //end each
                           
                        }
                    })

                });
            "; 
      }

      $fr = '<p>'.form_label($label2).form_dropdown($nama3,$apa4,@$def->$nama3,'class="'.$apa5.' " id="'.$nama3.'" style="width: 100%" '.($requ1  ? 'required' : '')).'</p>'; 
      return array($fr,$data);
  }
  
  function upload_file($param) {
        extract($param);
        $upath = './uploads/'.(@$path?$path:'');
        if (!is_dir($upath)) mkdir($upath,0777,TRUE);
            
        $this->CI->load->library('upload');
        
        $this->CI->upload->initialize(array(
            'upload_path' => $upath,
            'allowed_types' => (@$type?$type:'jpg|jpeg|png|gif|pdf|word|doc|docx|xls|xlsx'),
        ));
        $this->CI->upload->do_upload($nama_file);
        $data_upload = $this->CI->upload->data();
        
        if ($onerror = $this->CI->upload->display_errors('&nbsp','&nbsp')){
            return false;
        }else {
            return $data_upload['file_name'];
        };
  }
  
  function cr($e) {
        return $this->CI->general_model->check_role(sesi('id_pegawai'),$e);
  }
  
   
    /**
    *  text, ar &&apa&=>menjadi
    */
    function changeto($text,$r) {
        if(is_object($r))$r=json_decode(json_encode($r),1);
        if(is_array($r)){
            foreach ($r as $x=>$y){
                $pat[]='/&&'.$x.'&/';
                $rep[]=$y;
            } 
            return preg_replace($pat,$rep,$text);
        }else{
            return $text.implode_array($r)."xx".$text;
        }
    }
    
    /**
    *  x y =
    */
    function compareit($x,$y,$op) {
        $ret=false;
        switch($op){
            case '=':$ret=$x==$y;break;
            case '>':$ret=$x>$y;break;
            case '>=':$ret=$x>=$y;break;
            case '<':$ret=$x<$y;break;
            case '<=':$ret=$x<=$y;break;
        }
        return $ret;
    }
    
    function explode_alt($p) {
        $ret='';
        foreach ($p as $x => $v) 
          $ret.=' '.$x.'="'.$v.'"';
        return $ret;
    }
     
    function frm_hidden($dt) {
        $form="";
        foreach ($dt as $x => $v) 
            $form .= '<input type="hidden" id="'.$x.'" name="'.$x.'" value="'.form_prep($v, $x).'" />'."\n";
        return $form;
    } 
    
    /**
    * present ref open $id_hari $id_ref
    * -2 array(array(4,'id_hari'),(5,'id_ref')) preset ref open
    */
    function form_div($fo,$def) {
        foreach ($fo[1] as $x) $fo[$x[0]+1]=($def? $def->$x[1]:"");
        return load_cnt($fo[2],$fo[3],$fo[4],$fo[5],$fo[6]);
    }
    
    function explode_parm($parm) {
        $text="";
        if(is_array($parm)){
            $k=array();
            foreach ($parm as $p => $isip) $k[]=$p.": ".$isip;
            $text=implode(",\n",$k);
        }
        return $text;
    }
  }
?>
