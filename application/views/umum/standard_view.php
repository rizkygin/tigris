<?php 
echo @$css_load;
echo @$include_script;

$box_cls = !empty($tabs)?'nav-tabs-custom':'box';
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.heading').parent().find('td').addClass('headings');
	});
	<?php echo  @$script ?>
</script>
<style>
.blink_me {
	animation: blinker 1s linear infinite;
}

@keyframes blinker {  
	50% { opacity: 0.0; }
}
</style>
<div class="<?php echo $box_cls ?>" id="box-main">
	<?php if (!empty($tabs)) { ?>
	<ul class="nav nav-tabs">
		<?php 
			foreach($tabs as $t) { 
				echo '<li'.(!empty($t['on'])?' class="active"':null).'>
					<a'.(!empty($t['url'])?' href="'.$t['url'].'"':null).'>'.$t['text'].'</a></li>';
			}
		?>
	</ul>
	<?php } ?>
	
	<?php if (!empty($tombol) or !empty($extra_tombol)) { ?>
    
    <div class="box-header with-border">
	    <div class="row">
			<div class="col-md-7" style="margin-bottom: 10px"><?php echo @$tombol?></div>
			<?php if (!empty($extra_tombol)) echo '<div class="col-md-5">'.$extra_tombol.'</div>'; ?>
	    </div>
    </div><!-- /.box-header -->
	<?php } ?>

    <div class="box-body<?php if (!empty($overflow)) echo " over-width" ?>  table-responsive "> 
	
	<?php
		echo @$graph_area;
		echo @$tabel;
	?>
	</div>
	<?php if (!empty($links) or !empty($total) or !empty($box_footer)) { ?>
	    
	    <div class="box-footer">
			<div class="stat-info">
	<?php if (!empty($links)) { ?><div class="pull-left" style="margin-right: 10px"><?php echo $links?></div><?php } ?>
	<?php if (!empty($total)) { ?><div class="pull-left"><ul class="pagination"><li><a>Total</a></li><li><a><strong><?php echo $total?></strong></a></li></ul></div><?php } ?>
	</div>
	<?php if (!empty($box_footer)) echo $box_footer; ?>
	<div class="clear"></div>
	<?php if (!empty($filter)) $this->load->view($filter); ?>
	
</div>
<?php } ?>
</div>
<?php if (!empty($load_view)) $this->load->view($load_view); ?>


