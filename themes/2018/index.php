<?php get_header();
if (isset($is_home)) { ?>
		<div class="inner_woo">
			<div id="main_content" class="home_page" style="background: #9bbf03	;">
				<div class="inner">
					<div class="wpb_column vc_column_container vc_col-sm-9">
						<div class="vc_column-inner no-padding">
							<div class="fws2" id="fws2-instance1">
							    <div class="slider_container">
									<?php echo get_slideshow1(10);?>
								</div>

		        				<div class="timers"></div>
			        			<div class="slidePrev"><span></span></div>
			        			<div class="slideNext"><span></span></div>
		        			</div>
		        		</div>
		    		</div>
					<div class="wpb_column vc_column_container vc_col-sm-3 no-padding">
						<div class="vc_column-innerx" style="padding-left: 15px;">
							<script type='text/javascript' src='http://royalwpthemes.com/newgen/skin/js/royal_jquery.modern-ticker.min.js'></script>
							<script type='text/javascript' src='http://royalwpthemes.com/newgen/skin/js/royal_jquery.totemticker.min.js'></script>
							
								<script type="text/javascript">
							        jQuery(document).ready(function($){  
							        $('#vertical-ticker').totemticker({
							        row_height  :   '95px',
							        speed       :   600,
							        interval    :   5000
							        });
							        });
							        </script>
								<ul id="vertical-ticker" style="overflow: hidden;">
						 			<?php echo get_list_link(); ?>
						     </ul>
						</div>	
					</div>
				</div>
				</div>

			<div id="main_content" class="home_page" style="background: #fff;">
					<div class="col-lg-12" style="float: inherit;margin: 0px;">
						<div class="vc_row wpb_row vc_row-fluidx"  style="border-bottom:1px solid #ccc;padding: 0px 0px 10px 0px;">
							<div class="wpb_column vc_column_container vc_col-sm-12">
								

								<div class="wpb_column vc_column_container vc_col-sm-3">
									<div class="vc_column-inner">
										<div id="home_masonry_posts">

		      						<div class="wpb_wrapper">
										<div class="home_posts_title Modern">
		      								<h2 style="margin: 0px;font-size: 20px;">
							      				<a href="" style="color: #feb501;">GOVERNMENT PUBLIC RELATIONS</a>
		      								</h2>
		      							</div>
		      							<div class="car_title_descr" style="border-color: #84d600;"><p></p></div>
										<div class="tab-content">
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
									</div>
										</div>
									</div>
								</div>
								<div class="wpb_column vc_column_container vc_col-sm-9">
									<div class="vc_column-inner">
										<div id="home_masonry_posts"><div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_animate_when_almost_visible wpb_bottom-to-top vc_align_left">
											<div class="home_posts_title Modern">
													<h4 class="block-title" style="color: #ff2323;"><span>Berita Terbaru</span></h4>
											</div> 
											<div class="clear"></div>

										</div>
									</div>
								</div>
											<div class="wpb_column vc_column_container vc_col-sm-6">

												<div class="vc_column-inner no-padding">
												<?php echo get_list_content('berita',3,null,'full')?>
												</div>
											</div>
											<div class="wpb_column vc_column_container vc_col-sm-6">
												<div class="vc_column-inner no-padding">
											



<link rel='stylesheet' id='taqyeem-style-css'  href='<?=base_url('themes/2018/css/pagination/jPages.css');?>' type='text/css' media='all' />

<script type="text/javascript" src="<?=base_url().'themes/2018/js/pagination/tabifier.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'themes/2018/js/pagination/jPages.js'?>"></script>




  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28718218-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  </script>

  <script>
  /* when document is ready */
  $(function(){

    /* initiate the plugin */
    $("div.holder").jPages({
      containerID  : "itemContainer",
      perPage      : 4,
      startPage    : 1,
      startRange   : 1,
      midRange     : 5,
      endRange     : 1
    });

  });
  </script>

  <style type="text/css">
  .holder {
    margin: 15px 0;
    display: inline-block;
    padding-left: 0;
    margin: 20px 0;
    border-radius: 4px;
  }

  .holder a {
        font-size: 12px;
    cursor: pointer;
    margin: 0 5px;
    color: #333;
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
  }

  .holder a:hover {
    background-color: #222;
    color: #fff;
  }

  .holder a.jp-previous {}
  .holder a.jp-next {}

  .holder a.jp-current, a.jp-current:hover {
    cursor: default;
    background: none;
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    background: #337ab7 !important;
    color: #fff;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
  }

  .holder a.jp-disabled, a.jp-disabled:hover {
    color: #bbb;
  }

  .holder a.jp-current, a.jp-current:hover,
  .holder a.jp-disabled, a.jp-disabled:hover {
    cursor: default;
    background: none;
  }

  .holder span { margin: 0 5px; }
  </style>

      <!-- navigation holder -->

      <!-- item container -->
    <!--   <div id="itemContainer">
        <div>1</div>
        <div>2</div>
        <div>3</div>
        <div>4</div>
        <div>5</div>
        <div>6</div>
        <div>7</div>
      </div>
 -->
<div id="itemContainer">
<?php echo get_list_content('berita',1000000,3,'full_kanan')?>
</div>

      <div class="holder"></div>
												</div>
												<div class="clear"></div>

		<link rel="stylesheet" type="text/css" href="<?=base_url().'themes/2018/pagination/pag.css'?>">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</div>
						</div>

			<div id="main_content" class="home_page" style="background: #f3f3f3;">
					<div class="wpb_column vc_column_container vc_col-sm-12">
						<div class="vc_column-inner ">
							<div class="wpb_wrapper">



								<div class="vc_row wpb_row vc_row-fluid">
										<div class="wpb_column vc_column_container vc_col-sm-8">
											<div class="wpb_column vc_column_container vc_col-sm-12" style="margin-bottom:20px;">
												<div class="vc_column-inner no-padding" style="    background: -webkit-linear-gradient(top,#ececec -22%,#f9f9f9 89%);">
													<div class="wpb_wrapper">
														<div class="f-widget-title"><h4>Tabel Harga</h4></div>
														<div class="vc_column-inner" style="padding:0px 15px;">
														<?php echo get_list_harga(); ?>
														</div>
													</div>
												</div>
											</div>

											
											<!-- <div class="wpb_column vc_column_container vc_col-sm-6" style="margin-bottom:20px;">
												<div class="vc_column-inner no-padding" style="    background: -webkit-linear-gradient(top,#ececec -22%,#f9f9f9 89%);">
													<div class="wpb_wrapper">
														<div class="f-widget-title"><h4>Komoditas Unggulan</h4></div>


													</div>
												</div>
											</div> -->
										</div>
										<div class="wpb_column vc_col-sm-4" style="margin-bottom:20px;">
														<div class="f-widget-title"><h4>Artikel</h4></div>
															<?php echo get_list_artikel('artikel',3,null,'judul')?>


													</div>
										<div class="wpb_column vc_column_container vc_col-sm-12">
											<div class="vc_column-inner">
												<div class="wpb_wrapper">
													<?php get_widget_sidebar_1(); ?>
												</div>
											</div>
										</div>
									</div>

											
											
								</div>
							</div>
						</div>
						</div>


			<div id="main_content" class="home_page" style="background: #9bbf03;">
					<!-- artikel atas -->
					<div class="wpb_column vc_column_container vc_col-sm-12">
						<div class="vc_column-inner ">
							<div class="wpb_wrapper">
								<div class="vc_row wpb_row vc_row-fluid">
														<?php get_widget_2(); ?>
								</div>
							</div>
						</div>
					</div>
					</div>

		</div>
	<?php }else{ ?>
<div class="inner_woo">
<div id="main_content" class="home_page">
<div class="inner">
									<div class="wpb_column vc_column_container vc_col-sm-9">
										<?php echo $content;?>
									</div>

									<div class="wpb_column vc_column_container vc_col-sm-3">
										<div class="vc_column-inner" style="padding-right: 0px;">
											<script type='text/javascript' src='http://royalwpthemes.com/newgen/skin/js/royal_jquery.modern-ticker.min.js'></script>
											<script type='text/javascript' src='http://royalwpthemes.com/newgen/skin/js/royal_jquery.totemticker.min.js'></script>
											
												<script type="text/javascript">
											        jQuery(document).ready(function($){  
											        $('#vertical-ticker').totemticker({
											        row_height  :   '95px',
											        speed       :   600,
											        interval    :   5000
											        });
											        });
											        </script>
												<ul id="vertical-ticker" style="overflow: hidden;">
										 			<?php echo get_list_link(); ?>
										     </ul>
										</div>	
									
										<?php get_widget_sidebar_kanan(); ?>
									</div>
									<div class="wpb_column vc_column_container vc_col-sm-12" style="border-top:1px solid #ccc;margin-top:20px;">
									<br>
										<?php get_widget_2(); ?>
									</div>
</div>
</div>
</div>
</div>
	<?php } ?>


<?php echo get_footer(); ?>
