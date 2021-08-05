<?php get_header();
if (isset($is_home)) { ?>
<section class="fullwidth-slider" style="padding-top:10px;">
  




    <div class="col-lg-12" style="padding-left:0px;">
      <div class="fws2" id="fws2-instance1">
        <div class="slider_container">
        <?php echo get_slideshow1(10);?>
      </div>

      <div class="timers"></div>
        <div class="slidePrev"><span></span></div>
        <div class="slideNext"><span></span></div>
      </div>
    </div>


    <div class="col-lg-12" style="padding-left:0px;">
      
        <?php echo get_list_banner(); ?>
    </div>


</section>


<div class="container-fluid"><div
class="bootstrap-row-inner clearfix">




<div class="bootstrap-column col-lg-9 col-sm-12 col-xs-12 main-content no-padding"><div class="bootstrap-column-inner clearfix" style="position: relative;">

    <div class="col-lg-12" style="">
       
        <img src="<?=base_url('themes/new/images/header_harga.jpg');?>" style="width:100%;"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <?php echo get_harga_produsen(10);?>
      </div>

      <div class="item">
        <?php echo get_harga_pasarinduk(10);?>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
    </a>
    </div>
    </div>



<section id="block-1" class="cat-widget h-cat-1"><div class="cat-widget-title"><h3>Berita Kegiatan</h3></div>
<div class="cat-widget-content"><div class="cat-horiz clearfix"><div class="related-posts clearfix">



  <div class="modern-items-list">
    <?php echo get_list_content('berita',4,null,'full','173')?>
  </div>




</div></div>



















</div>
<section id="block-1" class="cat-widget h-cat-1"><div class="cat-widget-title"><h3>Berita Teknologi</h3></div>
<div class="cat-widget-content"><div class="cat-horiz clearfix"><div class="related-posts clearfix">



  <div class="cat-widget-content">
    <div class="row cat-horiz-divided row-sm-margin">
      <article class="col-container col-sm-padding col-md-6 col-sm-4 col-xs-5 col-xxs-12 last-post clearfix">
        <?php echo get_list_content('berita',1,0,'full_tengah','177')?>
      </article>
      <div class="col-container col-sm-padding col-md-6 col-sm-8 col-xs-7 col-xxs-12">
        <?php echo get_list_content('berita',5,1,'full_kanan','177')?>
    </div>
  </div>




</div></div>



















</div>
</section>
</div></div>


<section
class="bootstrap-column col-md-300 col-lg-3 col-sm-12 col-xs-12"><h2 class="hidden">Wide Sidebar</h2><div
class="bootstrap-column-inner clearfix"><div
class="sidebar-300 sticky-wrapper">
<aside
id="id-widget-modern-posts-1" class="widget w-posts">

                            <?php get_widget_1(); ?>

</aside>


<aside
id="id-widget-modern-posts-1" class="widget w-posts">

             <div
class="bootstrap-column-inner clearfix"><div
class="sidebar-270 sticky-wrapper" data-stickywrapper>
<aside
id="id-widget-news-pics-1" class="widget w-pictures"><div
class="widget-content clearfix padding20"></div><div
class="widget-title"><h4>GOVERNMENT PUBLIC RELATIONS</h4></div><div
class="widget-content clearfix">



                       
                    <div class="tabx-content">
                      <script type="text/javascript" src="https://widget.kominfo.go.id/gpr-widget-kominfo.min.js"></script>
                      <div id="gpr-kominfo-widget-container" style="width: 100% !important;padding:0px !important;border:none !important;"></div>
                      <style type="text/css">
                        #gpr-kominfo-widget-header{
                          background-size: 100% 100%!important;
                            margin-bottom: -12px!important;
                            margin-left: 0px!important;
                            border-left: 5px solid #676767!important;
                            height: 70px!important;
                        }
                      </style>
                    </div>
                    <div class="clear"></div>
</div></aside>



</div></div>

</aside>



</div></div>
</section>



</div></div>


</div>

<aside class="widget w-posts">
<div class="container-fluid">
<div class="col-lg-12">

        <?php echo get_widget_2(); ?>
    
  </div>
</aside>
<aside class="widget w-posts">
<div class="container-fluid">
<div class="col-lg-12">
  <div class="widget-title"><h4>Link Terkait</h4></div>
    <div class="widget-content clearfix">

        <?php echo get_list_skpd(); ?>
    </div>
    </div>
  </div>
</aside>
<?php }else{ ?>

<div class="container-fluid">
<?php echo $content;?>
</div>



<?php } ?>


<?php echo get_footer(); ?>


