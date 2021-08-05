<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/ico" <?php
        $lgo=base_url('assets/logo/'.uri(1).'_th.png');
        echo "href=\"".(!file_exists($lgo) ?  $lgo: base_url('controller/'.uri(1).'/'.uri(1).'.png'))."\"";?> />
    <title><?php 
        echo (!empty($title) && (false===strpos( $title,'<'))?$title.' - ':"").$this->st['app']['nama_aplikasi'].' :: '.$this->st['aplikasi_s'].' - '.$this->st['aplikasi'] ?></title>
<style type="text/css">
.by{
  vertical-align: bottom;
  height: 34px;
  border: 1px rgba(191, 191, 191, 0.6) solid;
}
</style>
    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/admin-lte.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/skins.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/general.min.css' ?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/plugins/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/js/app.min.js'?>"></script>

    <?php
      
      function css_js($ar,$is_css=0) {
           $ret=array() ;
           if(!is_array($ar))$ar=(array)$ar;
           foreach ($ar as $r) $ret[]=($is_css?reqcss($r):reqjs($r));
           return implode("\n",$ret);
      }
      
      function uses_head($ar="all") {
          $heads_standard=array(
            'datepicker'=>array(
                'css'=>'assets/plugins/datepicker/datepicker3.css',
                'js'=>array(
                         'assets/plugins/daterangepicker/daterangepicker.js',
                         'assets/plugins/datepicker/bootstrap-datepicker.js',
                         'assets/plugins/datepicker/locales/bootstrap-datepicker.id.js',
                ),
            ),
            'daterangepicker'=>array(
                'css'=>'assets/plugins/daterangepicker/daterangepicker-bs3.css',
                'js'=>array(
                         'assets/plugins/daterangepicker/moment.min.js',
                         'assets/plugins/daterangepicker/daterangepicker.js',
                ),
            ),
            'wysihtml5'=>array(
                'css'=>'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
                'js'=>'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
            ),
            'select2'=>array(
                'css'=>'assets/plugins/select2/select2.css',
                'js'=>'assets/plugins/select2/select2.js',
            ),
            'inputmask'=>array(
                'js'=>array(
                     'assets/plugins/input-mask/jquery.inputmask.min.js',
                     'assets/plugins/input-mask/jquery.inputmask.date.extensions.js',
                     'assets/plugins/input-mask/jquery.inputmask.extensions.js',
                ),
            ),
            'fancybox'=>array(
                'css'=>'assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5',
                'js'=>array(
                    'assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js',
                    'assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5',
                ),
            ),
            
            'air'=>array(
                'css'=>'assets/plugins/air-datepicker/datepicker.min.css',
                'js'=>array(
                    'assets/plugins/air-datepicker/datepicker.min.js',
                    'assets/plugins/air-datepicker/datepicker.id.js',
                ),
            ),
            
          );
          $ret="\n";
          if("all"==$ar)$ar=array_keys($heads_standard);
          if(!is_array($ar))$ar=(array)$ar;
          foreach ($ar as $r) {
              if(@$heads_standard[$r]){
                if(@$heads_standard[$r]['css'])$ret.=css_js($heads_standard[$r]['css'],1)."\n";
                if(@$heads_standard[$r]['js'])$ret.=css_js($heads_standard[$r]['js'])."\n";
              }else{
                if($r['css'])$ret.=css_js($r['css'],1)."\n";  
                if($r['js']) $ret.=css_js($r['js'] )."\n";  
              }
              
           };
           # include assets/css/app/? dirname .css
           $this_css='assets/css/app/'.uri(1).'.css';
           if(file_exists($this_css))$ret.=reqcss($this_css)."\n";
           $this_css='assets/css/opd.css';
           if(file_exists($this_css))$ret.=reqcss($this_css)."\n";
           #$ret.=komen($this_css);
           
           return $ret;
        }
      if(!empty($heads)){  
          echo uses_head($heads);
      }else{
          echo uses_head();
      }
    ?>
    <script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>
    <!-- notif chat -->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
