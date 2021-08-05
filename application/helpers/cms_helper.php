<?php
if(!function_exists('_ci')) {
	function _ci() {
		$_ci = &get_instance();
		return $_ci;
	}
}


if(!function_exists('get_user_online')){
	function get_user_online(){
		_ci()->load->database();
		_ci()->db->where('param','user_ol');
		$q = _ci()->db->get('parameter')->row();
		$arol = unserialize($q->val);
		return count($arol['sess'])-1;
	}
}	

if(!function_exists('get_today_hits')){
	function get_today_hits(){
		$today=date('Y-m-d');
		_ci()->load->database();
		_ci()->db->where('DATE_FORMAT(date_stat,"%Y-%m-%d")',$today);
		_ci()->db->where(array('title_page !='=>'','jenis_page !='=>''));
		$q = _ci()->db->get('cms_statistic');
		$today_hits  = $q->num_rows();
		return $today_hits;
	}
}


if(!function_exists('get_thismonth_hits')){
	function get_thismonth_hits(){
		$thismonth=date('m');
		_ci()->load->database();
		_ci()->db->where('DATE_FORMAT(date_stat,"%m")',$thismonth);
		_ci()->db->where(array('title_page !='=>'','jenis_page !='=>''));
		$q = _ci()->db->get('cms_statistic');
		$thismonth_hits  = $q->num_rows();
		return $thismonth_hits;
	}
}


if(!function_exists('get_total_hits')){
	function get_total_hits(){
		_ci()->load->database();
		_ci()->db->where('title_page !=','');
		_ci()->db->where('jenis_page !=','');
		$q = _ci()->db->get('cms_statistic');
		$total_hits  = $q->num_rows();
		
        $ipnya='<ul>';
		$n=1;
		foreach($q->result() as $ipr){
			$ipnya .= '<li>'.$ipr->ip.'</li>';
			$n++;
			if($n>10) break;			
		}
		$ipnya.='</ul>';
		$stat = array(
			'hits'=>$total_hits,
			'ip'=>$ipnya);
		return $stat;
	}
}


if(!function_exists('get_statpage')){
	function get_statpage(){
		_ci()->load->database();
		_ci()->db->where(array('title_page !='=>'','jenis_page !='=>''));
		_ci()->db->order_by('id_stat','DESC');
		$statpage = _ci()->db->get('cms_statistic');
        $pagenya='<ul>';
		$n=1;
		foreach($statpage->result() as $pager){
			$pagenya .= '<li>'.$pager->uri.'</li>';
			$n++;
			if($n>=10) break;
		}
		$pagenya.='</ul>';
		return $pagenya;
	}
}


if(!function_exists('get_pageview')){
	function get_pageview(){
		_ci()->load->database();
		_ci()->db->distinct();
		_ci()->db->select('title_page,count(title_page) as pgs');
		_ci()->db->limit(10);
		_ci()->db->where(array('title_page !='=>'','jenis_page !='=>'','title_page !='=>'home'));
		_ci()->db->where('title_page !=','kategori');
		_ci()->db->group_by('title_page');
		_ci()->db->order_by('pgs','DESC');
		$page = _ci()->db->get('cms_statistic');
				
		$pagenya = '<ul class="todo-list ui-sortable">';
		foreach($page->result() as $pg){
			$pagenya .= '<li>
			<span class="fa fa-twitch"> '.str_replace('-',' ',$pg->title_page).' </span>
			<small class="label label-warning pull-right" style="font-size: 15px"> '.get_pagecount($pg->title_page).'</small>
			</li>';
		}
		$pagenya .= '</ul>';
		return $pagenya;
	}
}


if(!function_exists('get_pagecount')){
	function get_pagecount($title_page){
		_ci()->load->database();
		_ci()->db->where('title_page',$title_page);
		$page = _ci()->db->get('cms_statistic');
		$page_count = $page->num_rows();
		return $page_count;			
	}
}


if(!function_exists('get_mozilla')){
	function get_mozilla(){
		_ci()->load->database();
		_ci()->db->like('user_agent','Firefox');
		$brow = _ci()->db->get('cms_statistic');
		$mozilla = $brow->num_rows();
		return $mozilla;			
	}
}

if(!function_exists('get_chrome')){
	function get_chrome(){
		_ci()->load->database();
		_ci()->db->like('user_agent','Chrome');
		$brow = _ci()->db->get('cms_statistic');
		$chrome = $brow->num_rows();
		return $chrome;			
	}
}

if(!function_exists('get_opera')){
	function get_opera(){
		_ci()->load->database();
		_ci()->db->like('user_agent','Opera');
		$brow = _ci()->db->get('cms_statistic');
		$opera = $brow->num_rows();
		return $opera;			
	}
}

if(!function_exists('get_ie')){
	function get_ie(){
		_ci()->load->database();
		_ci()->db->like('user_agent','MSIE');
		$brow = _ci()->db->get('cms_statistic');
		$ie = $brow->num_rows();
		return $ie;			
	}
}

if(!function_exists('get_safari')){
	function get_safari(){
		_ci()->load->database();
		_ci()->db->like('user_agent','Mac OS');
		$brow = _ci()->db->get('cms_statistic');
		$safari = $brow->num_rows();
		return $safari;			
	}
}

if(!function_exists('get_other')){
	function get_other(){
		_ci()->load->database();
		_ci()->db->not_like('user_agent','Firefox');
		_ci()->db->not_like('user_agent','Chrome');
		_ci()->db->not_like('user_agent','Opera');
		_ci()->db->not_like('user_agent','MSIE');
		_ci()->db->not_like('user_agent','Mac OS');
		$brow = _ci()->db->get('cms_statistic');
		$other = $brow->num_rows();
		return $other;			
	}
}



if(!function_exists('get_permonth_hits')){
	function get_permonth_hits($m){
		$y=date('Y');
		_ci()->load->database();
		_ci()->db->where('DATE_FORMAT(date_stat,"%m")',$m);
		_ci()->db->where('DATE_FORMAT(date_stat,"%Y")',$y);
		_ci()->db->where(array('title_page !='=>'','jenis_page !='=>''));
		$q = _ci()->db->get('cms_statistic');
		$permonth_hits  = $q->num_rows();
		return $permonth_hits;
	}
}

if(!function_exists('get_stathalaman')){
	function get_stathalaman(){
		_ci()->load->database();
		_ci()->db->distinct();
		_ci()->db->select('jenis_page');
		_ci()->db->where('jenis_page !=','');
		_ci()->db->limit(11);
		$q = _ci()->db->get('cms_statistic');
		
		$arrhal=array();
		foreach($q->result() as $row){
			_ci()->db->where('jenis_page',$row->jenis_page);
			$nr = _ci()->db->get('cms_statistic')->num_rows();
			$arrhal[$row->jenis_page] = (int) $nr;		
		}
		$kat_halaman=array();$jml_halaman=array();
		foreach($arrhal as $k=>$v){
			$kat_halaman[]=$k;
			$jml_halaman[]=$v;
		}
		//cek($jml_halaman);exit;
		$kat_halaman = array_filter($kat_halaman); //Menghapus array kosong
		$z = array_pop($jml_halaman);	 //Menghapus array terakhir
		$data_stathalaman = array(
			$kat=$kat_halaman,
			$jml=$jml_halaman
			);		
		return($data_stathalaman);
	}
}


if(!function_exists('get_list_berita')) {
	function get_list_berita($limit) { // Default konten sebanyak 5

		$content = null;
		_ci()->load->database();
		_ci()->db->from('cms_articles a');
		_ci()->db->join('peg_pegawai b','b.id_pegawai = a.id_operator');
		_ci()->db->where('code',1);
		_ci()->db->limit($limit);

		_ci()->db->order_by('a.date_start DESC');
		$q = _ci()->db->get();

		$last_id = _ci()->db->get('cms_articles')->row();

		$content = '<div class="row-fluid">
<div class="span8">
<div id="main-carousel" class="carousel slide">
<div class="carousel-inner">';

			foreach($q->result() as $art) {
				if($art->id_article == $last_id->id_article){
					$active = 'active';
				}else{

					$active = '';
				}
				$content .= '
				<div class="item '.$active.'">
<a href="'.site_url('Front/detail_berita/'.in_de(array('id_article'=>$art->id_article))).'">

</a>
<a href="'.site_url('Front/detail_berita/'.in_de(array('id_article'=>$art->id_article))).'">
<h4>'.$art->title.'</h4>
</a>
</div>
';
}
			

$content .= '

</div>
</div>
</div>';


$content .= '
<div class="span4">
<ul id="main-carousel-controllers">';
$no=0;
foreach($q->result() as $art) {
				if($art->id_article == $last_id->id_article){
					$active = 'active';
				}else{

					$active = '';
				}


$content .= '<li data-target="#main-carousel" data-slide-to="'.$no.'" class="'.$active.'">
<a href="#">'.$art->title.'</a>
</li>';
$no +=1;
	}
$content .= '
</ul>
</div>
</div>';

		return $content;
	}
}

if(!function_exists('get_list_berita_lainnya')) {
	function get_list_berita_lainnya($limit=NULL) { // Default konten sebanyak 5

		_ci()->load->database();
		_ci()->db->from('front_berita a');
		_ci()->db->join('ref_unit c','c.id_unit=a.id_unit');
		/*_ci()->db->where('a.id_berita >=',7);*/
		_ci()->db->limit($limit,7);
		_ci()->db->order_by('a.date_start DESC');
		
		$q = _ci()->db->get();	


		$content ='';
		
			foreach($q->result() as $art) {
			
				$content .= '
<div class="ns2-row-inner">
	
<div id="sp-main" class="span12">
<a href="'.site_url('Front/detail_berita/'.in_de(array('id_berita'=>$art->id_berita))).'">
<img class="ns2-image" style="float:left;margin:0 15px 0 0;width:280px;height:150px;" src="'.base_url().'uploads/file/berita/'.$art->berkas_file.'" alt="'.$art->title.'" title="'.$art->title.'">
</a>
<h4 class="ns2-title">
<a href="'.site_url('Front/detail_berita/'.in_de(array('id_berita'=>$art->id_berita))).'">'.$art->title.'</a>
</h4>
<div class="ns2-tools">
<div class="ns2-created">'.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").'<span style="color:blue;" class="pull-right">Oleh : '.$art->unit.'</span></div>
</div>
<p class="ns2-introtext">'.substr($art->content,0,180).' ...</p>


</div></div>
';
}
			

$content .= '<div style="clear:both"></div>
';

		return $content;
	}
}


if(!function_exists('get_video')){
	function get_video(){
		
		/*_ci()->load->database();
		_ci()->db->order_by('id_gallery DESC');
		_ci()->db->order_by('id_gallery DESC');
		_ci()->db->limit($num);
		$q = _ci()->db->get('cms_gallery');*/
	
		_ci()->load->database();
		_ci()->db->from('cms_video');
		$q = _ci()->db->get();
		/*cek($id_unit);*/
		/*cek($q->num_rows());
		die();*/
		$data_video = '
<div class="col-lg-8 pr-0">
                    <div class="tab-content clearfix">
		';


		$no = 1;		
		foreach($q->result() as $row){
			if($no == 1){
			$in_active = 'in active';
		}else{
			$in_active = ' ';
		}
              $data_video .=  '
                    <div class="tab-pane fade '.$in_active.'" id="video-tab-f8d7cd0-'.$no.'">
                                <div class="video-item" style="background-image: url(https://img.youtube.com/vi/'.$row->youtube_link.'/hqdefault.jpg)">
                                    <div class="post-video">
  <a href="https://www.youtube.com/watch?v='.$row->youtube_link.'" class="ts-play-btn">
    <i class="fa fa-play" aria-hidden="true"></i>
  </a>
</div>                                </div>
                            </div>
              ';
              $no +=1;
          }
          $data_video .= '
</div>
</div>
		';
          $data_video .= '

<div class="col-lg-4 pl-0">
                    <div class="video-tab-list bg-dark-item video-tab-scrollbar" id="video-tab-scrollbar">
                        <ul class="nav nav-pills post-tab-list">
		';


		$nox=1;
		foreach($q->result() as $row){

			if($nox == 1){
			$in_active = 'active';
		}else{
			$in_active = ' ';
		}
              $data_video .=  '

                           <li class="'.$nox.'">
                                <a href="#video-tab-f8d7cd0-'.$nox.'" data-toggle="tab">
                                    <div class="post-content media">
                                        <img class="d-flex sidebar-img" src="https://img.youtube.com/vi/'.$row->youtube_link.'/hqdefault.jpg" alt="'.$row->judul.'">
                                        <div class="media-body align-self-center">
                                        
                                            <h4 class="post-title">'.$row->judul.'</h4>

                                                                                    </div>
                                    </div>
                                </a>
                            </li>

                ';
              $nox +=1;
          }

          $data_video .= '</ul>
</div>
</div>';
    return $data_video;
	}
}


if(!function_exists('get_galeri')){
	function get_galeri(){
		//cek($judul);
		_ci()->load->database();
		_ci()->db->select('p.*, c.*');
		_ci()->db->from('cms_uploads c');
		_ci()->db->join('cms_gallery p','p.id_gallery = c.id_gallery');
		//_ci()->db->where('p.title',$judul);
		_ci()->db->group_by('p.id_gallery');
		_ci()->db->order_by('p.id_gallery','desc');
		$q = _ci()->db->get();
		//cek($q->result());
/*
		_ci()->load->database();
		_ci()->db->order_by('id_gallery DESC');
		_ci()->db->limit($num);
		$q = _ci()->db->get('cms_gallery');
	*/

		echo '
		<script type="text/javascript">
		(function($){ 
		$(window).load(function(){ 
		$(".sb-retro-skin").showbizpro({
			dragAndScroll:"off",
			visibleElementsArray:[4,4,4,1],
			carousel:"off",
			entrySizeOffset:0,
			allEntryAtOnce:"off"
		});
		})
		})(jQuery);
		</script>
		<style type="text/css">
		.sb-retro-skin .showbiz-navigation i {
		    text-shadow: 0px 1px 0px rgba(0,0,0,0.4);
		    font-size: 20px;
		}
		.sb-retro-skin .showbiz-navigation i {
		    color: #333;
		}
		h2.title {
    color: #666;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    margin: 0 0 0 0;
    padding: 0;
    position: relative;
    margin-bottom: 15px;
    background: #e7e9e7;
    position: relative;
    width: 100%;
}
		</style>

		 <div class="container"> 
		
		<div class="clear"></div>
		<div class="showbiz-container whitebg sb-retro-skin"><div class="showbiz-navigation sb-nav-retro">
		<a class="showbiz_left_featuredgal sb-navigation-left"><i class="fa fa-angle-left"></i></a>
		<a class="showbiz_right_featuredgal sb-navigation-right"><i class="fa fa-angle-right"></i></a>
		<div class="sbclear"></div>
		</div>

		<div class="showbiz" data-left=".showbiz_left_featuredgal" data-right=".showbiz_right_featuredgal">

		<div class="overflowholder gal"><ul>';
		foreach($q->result() as $row){
			//cek($row);
			echo '

			<li class="sb-retro-skingal">
						<div class="mediaholder">
							<a class="link_title" href="'.site_url('Home/galeri/'.str_replace(' ','-',$row->title)).'/'.$row->id_gallery.'">
								<div class="mediaholder_image_box">
									<img src="'.base_url('uploads/gallery/'.$row->file_name).'" alt="'.$row->title.'" title="'.$row->title.'" />
								</div>
							</a>
						</div>
						
					<div class="detailholder">
					<div class="showbiz-title">
						<a class="link_title" href="'.site_url('Home/galeri/'.str_replace(' ','-',$row->title)).'/'.$row->id_gallery.'" title="'.$row->title.'">'.$row->title.'</a></div>
		            
	                </div></li>
	                ';
		}

			echo '</ul><div class="sbclear"></div>
	</div> 
	<div class="sbclear"></div>
	</div>
		</div></div>';
	}
}

if(!function_exists('get_list_galeri')){
	function get_list_galeri(){
		//cek($judul);
		_ci()->load->database();
		_ci()->db->select('p.*, c.*');
		_ci()->db->from('cms_uploads c');
		_ci()->db->join('cms_gallery p','p.id_gallery = c.id_gallery');
		//_ci()->db->where('p.title',$judul);
		_ci()->db->group_by('p.id_gallery');
		_ci()->db->order_by('p.id_gallery','desc');
		$q = _ci()->db->get();
		//cek($q->result());
/*
		_ci()->load->database();
		_ci()->db->order_by('id_gallery DESC');
		_ci()->db->limit($num);
		$q = _ci()->db->get('cms_gallery');
	*/

		foreach($q->result() as $row){
			//cek($row);
			echo '
<div class="owl-item">
                <div class="item">
                    <div class="iq-blog-box" style="height:185px;">
                        <div class="iq-blog-image clearfix">

	                <img src="'.base_url('uploads/gallery/'.$row->file_name).'" alt="'.$row->title.'" title="'.$row->title.'" class="img-fluid center-block" style="height:100px;">

					<div class="iq-blog-detail">
                                <div class="iq-blog-meta">
                                    <ul>
                                        <li class="list-inline-item">
                                            <span class="screen-reader-text">Posted on</span>
                                            <a href="'.site_url('galeri/'.str_replace(' ','-',$row->title)).'/'.$row->id_gallery.'" title="'.$row->title.'" rel="bookmark">
                                            </a>
                                        </li>
                                    </ul>
                                </div>

<div class="blog-title">
                                    <a href="'.site_url('galeri/'.str_replace(' ','-',$row->title)).'/'.$row->id_gallery.'">
                                        <h5 style="font-size:12px;">'.$row->title.'</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
	</div>
		</div></div>
	                ';
		}

	}
}

/* -- Teks Berjalan */
if(!function_exists('get_runingteks')){
	function get_runingteks(){
		
		_ci()->load->database();
		_ci()->db->order_by('id_runingtext','desc');
		$q = _ci()->db->where('status',1);
		$q = _ci()->db->get('front_runingtext');
		$pagenya ='<div id="sp-nh-items124" class="sp-nh-item">';

		foreach($q->result() as $row){
			$pagenya .= '<div class="sp-nh-item"><span class="sp-nh-title">'.$row->title.'</span>
</div>';
		}
		$pagenya .= '</div>';
		return $pagenya;
	}
}

/* -- Teks Berjalan */
if(!function_exists('get_slideshow')){
	function get_slideshow(){
	/*	
		_ci()->load->database();
		_ci()->db->order_by('id_article','desc');
		$q = _ci()->db->where('status',1);
		$q = _ci()->db->where('code',6);
		$q = _ci()->db->get('cms_articles');
		$qq = _ci()->db->get('cms_articles')->num_rows();
*/


		_ci()->load->database();
	_ci()->db->from('cms_articles n');
	_ci()->db->join('cms_uploads d','d.id_article = n.id_article');
	_ci()->db->where('n.status',1);
	_ci()->db->where('n.code','6');
	_ci()->db->order_by('n.id_article ASC');
	$q = _ci()->db->get();



		$pagenya ='';
		foreach($q->result() as $row){
			$pagenya .= '
				<div  class="featured-slider-item" style="background-image: url('.base_url('uploads/photos/'.$row->file_name).')">
                            <div class="featured-table">
                                <div class="table-cell">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="hero-content">
                                                 
                                                                                                        <a 
                                                        class="post-cat" 
                                                        href="#"
                                                        style="color:#ffffff; background-color:#d72924; border-left-color:#d72924"
                                                        >
                                                                                                            </a>
                                                                                              
                                                  
                                                </div>
                                            </div>
                                            <!-- col end-->
                                        </div>
                                        <!-- row end-->
                                    </div>
                                    <!-- container end-->
                                </div>
                            </div>
                        </div>
			';
		}
		
		return $pagenya;
	}
}

/* -- Galeri Foto */
if(!function_exists('get_galeri_foto')){
	function get_galeri_foto($jumlah){
		
		_ci()->load->database();
		_ci()->db->order_by('id_gallery','desc');
		_ci()->db->limit($jumlah);
		$q = _ci()->db->get('cms_gallery');
		echo "<div id='unitegallery_8_1' class='unite-gallery' style='margin:0px auto;'>";
		foreach($q->result() as $row){
				$xx = unserialize($row->id_cat);
				
						_ci()->load->database();
						_ci()->db->where('id_cat',$xx[0]);
						$cat = _ci()->db->get('cms_categories')->row();


				$dt_det = _ci()->general_model->datagrab(array(
			'tabel'=>array('cms_uploads a'=>'', 'cms_gallery b'=>'a.id_gallery=b.id_gallery'),
			'select'=>'a.*, b.title',
			'where'=>array('a.id_gallery'=>$row->id_gallery)

			))->row();

				echo '
				<a href="'.site_url()."home/detail_galeri/".$row->id_gallery.'"><img alt="'.$row->title.'" data-image="'.base_url('uploads/gallery/'.$dt_det->file_name).'"
						     data-thumb="'.base_url('uploads/gallery/'.$dt_det->file_name).'"
						     title="Kategori : '.$cat->category.'"
						     style="display:none" /></a>';
			
		}
		echo "</div>";
	}
}


/* -- Berita */
if(!function_exists('get_galeri_video')){
	function get_galeri_video($jumlah){
		
		_ci()->load->database();
		_ci()->db->order_by('id_video','desc');
		_ci()->db->limit($jumlah);
		$q = _ci()->db->get('cms_video');
		echo "<div id='unitegallery_12_1' class='unite-gallery' style='margin:0px auto;'>
				";
		foreach($q->result() as $row){

				echo '
				<img alt="'.$row->judul.'"
						    data-type="youtube" title="'.$row->judul.'"
						     data-videoid="'.$row->youtube_link.'" style="display:none">

				';
			
		}
		echo "</div>";
	}
}


/* -- Berita */
if(!function_exists('get_berita')){
	function get_berita($judul,$konten,$jumlah){
		
		_ci()->load->database();
		_ci()->db->order_by('id_berita','desc');
		_ci()->db->where('id_kategori',$konten);
		_ci()->db->limit($jumlah);
		$q = _ci()->db->get('front_berita');
		echo '
		<div class="module">
		<h3 class="header" style="text-align: left">
<span>'.$judul.'</span> </h3>
	</div>
		';
		echo "<ul  class='list-group'>";
		foreach($q->result() as $row){
				echo '
				<li class="list-pengumuman">  <div class="colordate">'.konversi_tanggal("D, j M Y",substr($row->date_start,0,10),"id").'</div>
                                <a href="'.site_url('Front/detail_berita/'.in_de(array('id_berita'=>$row->id_berita))).'">'.$row->title.'</a>
                               
                </li>';
			
		}
		echo "</ul>";
	}
}


/* -- Agenda */
if(!function_exists('get_agenda')){
	function get_agenda($judul,$konten,$jumlah){
		
		_ci()->load->database();
		_ci()->db->order_by('id_agenda','desc');
		_ci()->db->where('id_kategori',$konten);
		_ci()->db->limit($jumlah);
		$q = _ci()->db->get('front_agenda');
		echo '
		<div class="module">
		<h3 class="header" style="text-align: left">
<span>'.$judul.'</span> </h3>
	</div>
		';
		echo "<ul  class='list-group'>";
		foreach($q->result() as $row){
				echo '
				<li class="list-pengumuman">  <div class="colordate">'.konversi_tanggal("D, j M Y",substr($row->date_start,0,10),"id").'</div>
                                <a href="'.site_url('Front/detail_agenda/'.in_de(array('id_agenda'=>$row->id_agenda))).'">'.$row->title.'</a>
                               
                </li>';
			
		}
		echo "</ul>";
	}
}
/* -- Pengumuman */
if(!function_exists('get_pengumuman')){
	function get_pengumuman($judul,$konten,$jumlah){
		
		_ci()->load->database();
		_ci()->db->order_by('id_pengumuman','desc');
		_ci()->db->where('id_kategori',$konten);
		_ci()->db->limit($jumlah);
		$q = _ci()->db->get('front_pengumuman');
		echo '
		<div class="module">
		<h3 class="header" style="text-align: left">
<span>'.$judul.'</span> </h3>
	</div>
		';
		echo "<ul  class='list-group'>";
		foreach($q->result() as $row){
				echo '
				<li class="list-pengumuman">  <div class="colordate">'.konversi_tanggal("D, j M Y",substr($row->date_start,0,10),"id").'</div>
                                <a href="'.site_url('Front/detail_pengumuman/'.in_de(array('id_pengumuman'=>$row->id_pengumuman))).'">'.$row->title.'</a>
                               
                </li>';
			
		}
		echo "</ul>";
	}
}

/* -- tautan */
if(!function_exists('get_link')){
	function get_link(){
		
		_ci()->load->database();
		_ci()->db->order_by('id_tautan','desc');
		_ci()->db->where('id_kategori_konten',2);
		$q = _ci()->db->get('front_tautan');
		echo '
		<div class="module  highlighted" style="margin-top:0px">
<div class="mod-wrapper clearfix">


<span class="sp-badge  highlighted"></span>
<div class="mod-content clearfix">
<div class="mod-inner clearfix">
<div class="sp-fixtures-wrapper  highlighted">';
		echo "<ul class='mod-sp-fixtures' id='vertical-ticker'>";
		foreach($q->result() as $row){
				echo '
				<li><div class="vertical_ticker_image">
                                <a href="'.$row->link.'" target="_blank"><img src="'.site_url()."uploads/file/".$row->berkas_file.'" style="width:100%;height:65px"/></a>
                                </div>
                                <h1>
                                <div class="clear"></div></h1>
                               
                </li>';
			
		}
		echo "</ul><div style='clear:both'></div></div> </div>
</div>
</div>
</div>";
	}
}
/* -- tautan */
if(!function_exists('get_tautan')){
	function get_tautan($judul,$konten,$jumlah){
		
		_ci()->load->database();
		_ci()->db->order_by('id_tautan','desc');
		_ci()->db->where('id_kategori_konten',$konten);
		_ci()->db->limit($jumlah);
		$q = _ci()->db->get('front_tautan');
		echo '
		<div class="module  highlighted">
<div class="mod-wrapper clearfix">
<div class="module">
		<h3 class="header" style="text-align: left">
<span>'.$judul.'</span> </h3>
	</div>

<span class="sp-badge  highlighted"></span>
<div class="mod-content clearfix">
<div class="mod-inner clearfix">
<div class="sp-fixtures-wrapper  highlighted">';
		echo "<ul class='mod-sp-fixtures' id='mod-fixtures'>";
		foreach($q->result() as $row){
				echo '
				<li><div class="sp-fixtures">
                                <a href="'.$row->link.'" target="_blank"><img src="'.site_url()."uploads/file/".$row->berkas_file.'" style="width:100%;height:auto"/></a>
                                </div>
                               
                </li>';
			
		}
		echo "</ul><div style='clear:both'></div></div> </div>
</div>
</div>
</div><br>";
	}
}

/* -- DOOWNLOAD */
if(!function_exists('get_unduhan')){
	function get_unduhan($judul,$konten,$jumlah){
		
		_ci()->load->database();
		_ci()->db->order_by('id_download','desc');
		_ci()->db->where('id_kategori_konten',$konten);
		_ci()->db->limit($jumlah);
		$q = _ci()->db->get('front_download');
	
		echo '
		<div class="module">
		<h3 class="header" style="text-align: left">
<span>'.$judul.'</span> </h3>
	</div>
		';
		echo "<ul  class='list-group'>";
		foreach($q->result() as $row){
				echo '
				<li class="list-pengumuman">  <div class="colordate">'.konversi_tanggal("D, j M Y",substr($row->date_start,0,10),"id").'</div>
                                <a href="'.site_url()."home/detail_download/".$row->id_download.'">'.$row->title.'</a>
                               
                </li>';
			
		}
		echo "</ul>";
	}
}

/* -- DOOWNLOAD */
if(!function_exists('get_teks')){
	function get_teks($judul,$konten,$jumlah){
		echo '
		<div class="module">
		<h3 class="header" style="text-align: left">
<span>'.$judul.'</span> </h3>
	</div>
		';
				echo '
				 <div class="colordate"></div>
                              '.$konten.'
                               
                ';
			
		echo "";
	}
}


/* -- WIDGET 1 (KIRI) -- */
if(!function_exists('get_widget_1')){
	function get_widget_1(){
		_ci()->load->database();
		_ci()->db->where('jenis','1');
		_ci()->db->order_by('no_urut','asc');
		
		$exc = _ci()->db->get('cms_widget');
		
	

		if($exc->num_rows() != '0'){
			foreach($exc->result() as $row){
			echo '

	<div class="module ">
	<div class="mod-wrapper clearfix">

		';
				if($row->widget == '1') get_berita(@$row->judul,@$row->konten,@$row->jumlah);
				
				else if($row->widget == '2') get_agenda(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '3') get_pengumuman(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '4') get_tautan(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '5') get_unduhan(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '6') get_teks(@$row->judul,@$row->konten,@$row->jumlah);	
				else get_berita($row->judul,$row->konten,@$row->jumlah);

echo '</div>
              </div>
			<div class="gap"></div>

              ';
			}
		}
		
	}
}


/* -- WIDGET 2 (Kanan) -- */
if(!function_exists('get_widget_2')){
	function get_widget_2(){
		_ci()->load->database();
		_ci()->db->where('jenis','2');
		_ci()->db->order_by('no_urut','asc');
		
		$exc = _ci()->db->get('cms_widget');
		
	

		if($exc->num_rows() != '0'){
			foreach($exc->result() as $row){
			echo '

	<div class="module ">
	<div class="mod-wrapper clearfix">

		';
				if($row->widget == '1') get_berita(@$row->judul,@$row->konten,@$row->jumlah);
				
				else if($row->widget == '2') get_agenda(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '3') get_pengumuman(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '4') get_tautan(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '5') get_unduhan(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '6') get_teks(@$row->judul,@$row->konten,@$row->jumlah);	
				else get_berita($row->judul,$row->konten,@$row->jumlah);

echo '</div>
              </div>
			<div class="gap"></div>

              ';
			}
		}
		
	}
}


/* -- WIDGET 2 (Kanan) -- */
if(!function_exists('get_widget_3')){
	function get_widget_3(){
		_ci()->load->database();
		_ci()->db->where('jenis','3');
		_ci()->db->order_by('no_urut','asc');
		
		$exc = _ci()->db->get('cms_widget');
		
	

		if($exc->num_rows() != '0'){
			foreach($exc->result() as $row){
			echo '
<div id="sp-bottom5" class="span4"> <div class="module ">
<div class="mod-wrapper-flat clearfix">
<div class="custom">
		';
				if($row->widget == '1') get_berita(@$row->judul,@$row->konten,@$row->jumlah);
				
				else if($row->widget == '2') get_agenda(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '3') get_pengumuman(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '4') get_tautan(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '5') get_unduhan(@$row->judul,@$row->konten,@$row->jumlah);	
				else if($row->widget == '6') get_teks(@$row->judul,@$row->konten,@$row->jumlah);	
				else get_berita($row->judul,$row->konten,@$row->jumlah);

echo '</div>
              </div>
              </div>
              </div>
			<div class="gap"></div>

              ';
			}
		}
		
	}
}


// utama
//get on param
function get_on_param($par) {
	_ci()->load->database();
	_ci()->db->where('param',$par);
	return _ci()->db->get('parameter')->row();
}
function load_menu($id_main,$par = null, $id = null) {
	/*echo $id_main;
	echo $par;
	echo $id;*/
	_ci()->load->database();
	_ci()->db->from('cms_navi n');
	_ci()->db->join('cms_navi_detail d','d.id_navmain = n.id_navmain');
	_ci()->db->where('n.id_navmain',$id_main);
	_ci()->db->where('d.aktif','1');
	_ci()->db->order_by('d.urut ASC');
	if (!empty($par)) _ci()->db->where('d.id_nav_parent',$par);
	else _ci()->db->where('d.id_nav_parent',null);
	if (!empty($id)) _ci()->db->where('d.id_nav',$id);
	return _ci()->db->get();
}

function get_menu_child($lum,$id_par,$num) {
		$id = get_on_param('nav')->val;
		
		if (load_menu($id,$id_par)->num_rows() > 0) {
				$d_menu = load_menu($id,$id_par);
				$menu = ' <ul class="dropdown-menu">
';
				foreach($d_menu->result() as $d) {
					
					$menu_data = array(
					'1' => 'Halaman',
					'2' => 'Galeri',
					'3' => 'Berita',
					'4' => 'Artikel',
					'5' => 'Agenda',
					'6' => 'Pengumuman',
					'7' => 'Lowongan Kerja',
					'8' => 'Personel',
					'9' => 'Download',
					'10' => 'Tautan',
					'11' => 'Buku Tamu',
					'12' => 'Forum',
					'13' => 'Jurnal',
					'14' => 'Hubungi Kami'
					);
					
					if (!empty($d->menu_label)) $menu_label = $d->menu_label;
					else $menu_label = $menu_data[$d->menu_jenis];
					
					$mn = unserialize($d->content);
					$link_menu = "#";
					switch($d->menu_jenis) {
						case "1" : $link_menu = site_url('halaman/'.$mn['judul']); break;
						case "2" : $link_menu = site_url('galeri/kategori'); break;
						case "3" : $link_menu = site_url('berita/kategori/'.$mn['judul']); break;
						case "4" : $link_menu = site_url('artikel/kategori/'.$mn['judul']); break;
						case "5" : $link_menu = site_url('agenda/kategori/'.$mn['judul']); break;
						case "6" : $link_menu = site_url('pengumuman/kategori/'.$mn['judul']); break;
						case "7" : $link_menu = site_url('loker/kategori/'.$mn['judul']); break;
						case "8" : $link_menu = site_url('personel/kategori/'.$mn['judul']); break;
						case "9" : $link_menu = site_url('download/kategori/'.$mn['judul']); break;
						case "10" : $link_menu = $mn['url']; break;
						case "11" : $link_menu = site_url('home/add_guestbook'); break;
						case "12" : $link_menu = site_url('forum/'.$mn['judul']); break;
						case "13" : $link_menu = site_url('jurnal/kategori/'.$mn['judul']); break;
						case "14" : $link_menu = site_url('hub_kami/'.$mn['judul']); break;
					}
					$lmenu = load_menu($id,$d->id_nav)->num_rows();
					$submenu = ($lmenu > 0) ? '': null;
					$menu.="<li ".$submenu." class='nav-item'><a href='".$link_menu."' class='isubmenu'>".$menu_label."</a>";
					
					if ($lmenu > 0) $menu.= get_menu_child($lum+1,$d->id_nav,$num+1);
					$menu.="</li>";
				}
				$menu.= '</ul>';				
				return $menu;
		}

	}



if(!function_exists('get_menu')){

	function get_menu() {		
		$menu = '<ul class="navbar-nav m-auto">';
		$menu .= '

		<li class="nav-item"><a href="'.site_url("/home").'" class="nav-link dropdown-toggle active">Beranda</a></li>
				';
		
		$id = get_on_param('nav');
		$d_menu = load_menu($id->val);
		
		foreach($d_menu->result() as $d) {
		
		$menu_data = array(
					'1' => 'Halaman',
					'2' => 'Galeri',
					'3' => 'Berita',
					'4' => 'Artikel',
					'5' => 'Agenda',
					'6' => 'Pengumuman',
					'7' => 'Lowongan Kerja',
					'8' => 'Personel',
					'9' => 'Download',
					'10' => 'Tautan',
					'11' => 'Buku Tamu',
					'12' => 'Forum',
					'13' => 'Jurnal',
					'14' => 'Hubungi Kami'
					);
					
					if (!empty($d->menu_label)) $menu_label = $d->menu_label;
					else $menu_label = $menu_data[$d->menu_jenis];
					
					$mn = unserialize($d->content);
					$link_menu = "#";
					switch($d->menu_jenis) {
						case "1" : $link_menu = site_url('halaman/'.$mn['judul']); break;
						case "2" : $link_menu = site_url('galeri/kategori'); break;
						case "3" : $link_menu = site_url('berita/kategori/'.$mn['judul']); break;
						case "4" : $link_menu = site_url('artikel/kategori/'.$mn['judul']); break;
						case "5" : $link_menu = site_url('agenda/kategori/'.$mn['judul']); break;
						case "6" : $link_menu = site_url('pengumuman/kategori/'.$mn['judul']); break;
						case "7" : $link_menu = site_url('loker/kategori/'.$mn['judul']); break;
						case "8" : $link_menu = site_url('personel/kategori/'.$mn['judul']); break;
						case "9" : $link_menu = site_url('download/kategori/'.$mn['judul']); break;
						case "10" : $link_menu = $mn['url']; break;
						case "11" : $link_menu = site_url('home/add_guestbook'); break;
						case "12" : $link_menu = site_url('forum/'.$mn['judul']); break;
						case "13" : $link_menu = site_url('jurnal/kategori/'.$mn['judul']); break;
						case "14" : $link_menu = site_url('hub_kami/'.$mn['judul']); break;
					}
			
			$exist = get_menu_child(1,$d->id_nav,1);
			$link_on = !empty($exist) ? 'href="#" class="nav-link dropdown-toggle"' : 'href="'.$link_menu.'"';
			$to_drop = !empty($exist) ? ' class="nav-item"':'class="nav-item"';
			$caret_on = !empty($exist) ? ' <i class="bx bx-chevron-down"></i>' : null;
			$menu.="<li ".$to_drop."><a ".$link_on.">".$d->menu_label." ".$caret_on."</a>";
			$menu.= $exist;
			$menu.="</li>";
		}
		$menu.= "</ul>";
		
		return $menu;
	}
}

// utama
	

	

//list berita tipe konten

if(!function_exists('get_list_content_kiri')) {
	function get_list_content_kiri($code=null,$jumlah_halaman = 5,$mulai = 0, $tipe = null,$category = null) { // Default konten sebanyak 5

		$content = null;
		if (in_array($code,array('berita','artikel','agenda','pengumuman','loker'))) {
		$list_code = array(
			'berita' => '1',
			'artikel' => '2',
			'agenda' => '3',
			'pengumuman' => '4',
			'loker' => '14'
		);
         
		_ci()->load->database();
		_ci()->db->where('param','hal');
		$qhal = _ci()->db->get('parameter')->row();
		$jhal=$qhal->val;//mendapatkan jumlah berita yang akan di tampilkan di hal index
		if(!empty($jhal)) $jumlah = $jhal;
		/*

		_ci()->load->database();
		_ci()->db->where('code','1');
		_ci()->db->where('id_cat',3);
		$cati = _ci()->db->get('cms_categories')->row();	
		*/
		_ci()->load->database();
		_ci()->db->from('cms_articles a');
		_ci()->db->join('peg_pegawai b','b.id_pegawai = a.id_operator');
		_ci()->db->where(array('a.code' => $list_code[$code], 'a.status' => '1','a.id_cat NOT LIKE \'%"113";}\''=>'')); // code 2 hanya untuk berita
		_ci()->db->order_by('a.date_start DESC');
		_ci()->db->limit(!empty($jumlah_halaman)?$jumlah_halaman:$jumlah,$mulai);
		$q = _ci()->db->get();


		if ($tipe == "judul") {
			$content .= '<ul class="list_content_title">';
			foreach($q->result() as $art) {$content .= '<li><a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'</a></li>';}
			$content .= '</ul>';
			
		} else if ($tipe == "ringkas") {
		
			foreach($q->result() as $art){
				$foto = null;
				$html = str_get_html($art->content);
				foreach($html->find('img') as $elgbr) {
	       		
					$foto = $elgbr->src;
					
				}
				$forimg = strip_tags($art->content,"<img>");
			
				$content .= '<div class="list_content" style="height: 250px;">';
				$foto = !empty($foto) ? $foto : base_url().'uploads/photos/no_photo_front.jpg';
				$content .= '<h2><a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'<img class="img-responsive" src="'.$foto.'"/></a></h2><div class="small">'.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").' oleh: '.$art->nama.'</div><div class="clear"></div>';
				$content .= '<p style="text-align:justify">'.truncate(strip_tags($art->content,'<h1><h2><h3><p><b><i><u>'),'400').'</p>';
				$content .= '<a href="'.site_url($code.'/'.$art->permalink).'" class="link_next">Selanjutnya &raquo;</a>';
				$content .= '<div class="clear"></div></div>';
			}
		
		} else if ($tipe == "full") {			
				foreach($q->result() as $art){
					$content .= '


					<div class="item grid-md">
                                            <div class="ts-overlay-style post-190 post type-post status-publish format-standard has-post-thumbnail hentry category-cricket category-sketing category-sports tag-sports">
    <div class="item">
        <div class="ts-post-thumb">
             
                                <a class="post-cat" href="'.site_url($code.'/'.$art->permalink).'" style="color:#ffffff; background-color:#d72924; border-left-color:#d72924">
                    Kepegawaian             </a>
                        <a href="'.site_url($code.'/'.$art->permalink).'">
                <img src="'.base_url('uploads/file/berita/'.$art->berkas_file).'" alt="'.$art->title.'">

            </a>
       
        </div>
        <div class="overlay-post-content">
            <div class="post-content">
                <h3 class="post-title">
                    <a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'</a>
                </h3>
                 
                <ul class="post-meta-info">
                                                            <li>
                        <i class="fa fa-clock-o"></i>'.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").'                </li>
                              
               
                </ul>
            </div>
        </div>
    </div>
</div>                                        </div>


';
					
				}
			
			}else if ($tipe == "full_kanan") {	
				foreach($q->result() as $art){

					
					$content .= '
						<div class="post-content media">
                         <a href="'.site_url($code.'/'.$art->permalink).'">
                            <img class="d-flex sidebar-img" src="'.base_url('uploads/file/berita/'.$art->berkas_file).'" alt="'.$art->title.'">
                            <div class="media-body ">
                            <h4 class="post-title">
                                                    <a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'</a>
                                                 
                                                </h4>
                                                <span class="post-date-info">
                                                      <i class="fa fa-clock-o"></i> '.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").'</span>
                                                                                            
                                            </div>
                                        </div>
					';
						$content .= '';
					}	
				}
		
		}
		
		return $content;		
	}

}

//list berita tipe konten

if(!function_exists('get_list_content_kanan')) {
	function get_list_content_kanan($code=null,$jumlah_halaman = 5,$mulai = 0, $tipe = null,$category = null) { // Default konten sebanyak 5

		$content = null;
		if (in_array($code,array('berita','artikel','agenda','pengumuman','loker'))) {
		$list_code = array(
			'berita' => '1',
			'artikel' => '2',
			'agenda' => '3',
			'pengumuman' => '4',
			'loker' => '14'
		);
         
		_ci()->load->database();
		_ci()->db->where('param','hal');
		$qhal = _ci()->db->get('parameter')->row();
		$jhal=$qhal->val;//mendapatkan jumlah berita yang akan di tampilkan di hal index
		if(!empty($jhal)) $jumlah = $jhal;
		/*

		_ci()->load->database();
		_ci()->db->where('code','1');
		_ci()->db->where('id_cat',3);
		$cati = _ci()->db->get('cms_categories')->row();	
		*/
		_ci()->load->database();
		_ci()->db->from('cms_articles a');
		_ci()->db->join('peg_pegawai b','b.id_pegawai = a.id_operator');
		_ci()->db->where(array('a.code' => $list_code[$code], 'a.status' => '1','a.id_cat NOT LIKE \'%"113";}\''=>'')); // code 2 hanya untuk berita
		_ci()->db->order_by('a.date_start DESC');
		_ci()->db->limit(!empty($jumlah_halaman)?$jumlah_halaman:$jumlah,$mulai);
		$q = _ci()->db->get();


		if ($tipe == "judul") {
			$content .= '';
			foreach($q->result() as $art) {
				$content .= '<div class="post-content media">    
                            
                            <div class="media-body">
                                <span class="post-tag"  style="color:#d72924; font-size:10px;">'.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").'
                                </span>
                                <h4 class="post-title" style="font-size:12px;">
                                <a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'</a>
                                </h4>
                            </div>
                        </div>';
			}
			$content .= '';
			
		} else if ($tipe == "ringkas") {
		
			foreach($q->result() as $art){
				$foto = null;
				$html = str_get_html($art->content);
				foreach($html->find('img') as $elgbr) {
	       		
					$foto = $elgbr->src;
					
				}
				$forimg = strip_tags($art->content,"<img>");
			
				$content .= '<div class="list_content" style="height: 250px;">';
				$foto = !empty($foto) ? $foto : base_url().'uploads/photos/no_photo_front.jpg';
				$content .= '<h2><a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'<img class="img-responsive" src="'.$foto.'"/></a></h2><div class="small">'.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").' oleh: '.$art->nama.'</div><div class="clear"></div>';
				$content .= '<p style="text-align:justify">'.truncate(strip_tags($art->content,'<h1><h2><h3><p><b><i><u>'),'400').'</p>';
				$content .= '<a href="'.site_url($code.'/'.$art->permalink).'" class="link_next">Selanjutnya &raquo;</a>';
				$content .= '<div class="clear"></div></div>';
			}
		
		} else if ($tipe == "full") {			
				foreach($q->result() as $art){
					$content .= '


					<div class="item grid-md">
                                            <div class="ts-overlay-style post-190 post type-post status-publish format-standard has-post-thumbnail hentry category-cricket category-sketing category-sports tag-sports">
    <div class="item">
        <div class="ts-post-thumb">
             
                                <a class="post-cat" href="'.site_url($code.'/'.$art->permalink).'" style="color:#ffffff; background-color:#d72924; border-left-color:#d72924">
                    Kepegawaian             </a>
                        <a href="'.site_url($code.'/'.$art->permalink).'">
                <img src="'.base_url('uploads/file/berita/'.$art->berkas_file).'" alt="'.$art->title.'">

            </a>
       
        </div>
        <div class="overlay-post-content">
            <div class="post-content">
                <h3 class="post-title">
                    <a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'</a>
                </h3>
                 
                <ul class="post-meta-info">
                                                            <li>
                        <i class="fa fa-clock-o"></i>'.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").'                </li>
                              
               
                </ul>
            </div>
        </div>
    </div>
</div>                                        </div>


';
					
				}
			
			}else if ($tipe == "full_kanan") {	
				foreach($q->result() as $art){

					
					$content .= '
						<div class="post-content media">
                         <a href="'.site_url($code.'/'.$art->permalink).'">
                            <img class="d-flex sidebar-img" src="'.base_url('uploads/file/berita/'.$art->berkas_file).'" alt="'.$art->title.'">
                            <div class="media-body ">
                            <h4 class="post-title">
                                                    <a href="'.site_url($code.'/'.$art->permalink).'">'.$art->title.'</a>
                                                 
                                                </h4>
                                                <span class="post-date-info">
                                                      <i class="fa fa-clock-o"></i> '.konversi_tanggal("D, j M Y",substr($art->date_start,0,10),"id").'</span>
                                                                                            
                                            </div>
                                        </div>
					';
						$content .= '';
					}	
				}
		
		}
		
		return $content;		
	}

}
