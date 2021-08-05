<?php
//ver 0.4
  function tinymce0($simple_theme="",$id='',$skin='',$path_tiny='assets/tinymce'){ 
      $simple_theme=('1'==$simple_theme?"simple":(''==$simple_theme?"advanced":$simple_theme)); 
      $id=($id?$id:'tarea');
      $skin=($skin?$skin:'bootstrap');
      return "<!-- TinyMCE --><script type='text/javascript'> 
      tinyMCE.init({ 
        mode : 'textarea', 
        theme : '$simple_theme', "
      ."editor_selector : '$id', "
//  elements : '$id', textareas
//      ."skin : 'o2k7', 
      ."skin : '$skin', 
        plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups', 
        theme_advanced_buttons1 : 'undo,redo,|,cut,copy,paste,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,|,image,insertdate,inserttime,|,template,code,|,print,preview,|,fullscreen', 
        theme_advanced_buttons2 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,charmap,advhr', 
        theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,|,nonbreaking,pagebreak,insertlayer,moveforward,movebackward,absolute', 
        theme_advanced_toolbar_location : 'top', theme_advanced_toolbar_align : 'left', 
        theme_advanced_statusbar_location : 'bottom', theme_advanced_resizing : true,  
        content_css : '".base_url($path_tiny."/css/word.css")."',
        template_external_list_url : '".site_url("templ_js")."',
        external_link_list_url : '".base_url($path_tiny."/lists/link_list.js")."',
        external_image_list_url : '".base_url($path_tiny."/lists/image_list.js")."',
        media_external_list_url : '".base_url($path_tiny."/lists/media_list.js")."'}
        ); 

   /* \$(document).on(\'focusin\', function(e) {
        if (\$(e.target).closest(\".mce-window\").length) {
            e.stopImmediatePropagation();
        }
    });
       */ 
        </script> <!-- /TinyMCE -->"; 
  }
  
  function tiny_mce($simple_theme="",$id='',$skin='',$path_tiny='assets/tinymce'){ 
      echo tinymce($simple_theme,$id,$skin,$path_tiny);
  }
  
  function tinymce($path_tiny='assets/tinymce',$id='.textarea',$height="400",$skin=''){ 
      //ver 4
      return
  "tinymce.init({
  selector: '$id',
  height: $height,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
  ],
  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  content_css: '".base_url($path_tiny."/codepen.min.css")."'
});";
  }
?>
