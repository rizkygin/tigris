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
<div class="<?php echo $box_cls ?>" id="box-main">
	<?php if (!empty($tabs)) { ?>
	<ul class="nav nav-tabsx">
		<?php 
			foreach($tabs as $t) { 
				echo '<li'.(!empty($t['on'])?' class="active"':null).'>
					<a'.(!empty($t['url'])?' href="'.$t['url'].'"':null).'>'.$t['text'].'</a></li>';
			}
		?>
	</ul>
	<?php } ?>
  
    <div class="box-header with-border">
	    <div class="row">
			<div class="col-md-12" style="margin-bottom: 10px"><?php echo @$tombol_kiri?>
				<div class="box-body<?php if (!empty($overflow)) echo " over-width" ?>"> 
					<?php
						echo @$graph_area;
						echo $tabel_kiri;
					?>
				</div>
			</div><!-- 
			<div class="col-md-12"> -->
				<div class="col-md-12" style="margin-bottom: 10px"><?php echo @$tombol_kanan?>
					<div class="box-body<?php if (!empty($overflow)) echo " over-width" ?>"> 
						<?php
							echo @$graph_area;
							echo $tabel_kanan;
						?>
					</div>
				</div>

				<div class="col-md-12" style="margin-bottom: 10px"><?php echo @$tombol_bawah?>
					<div class="box-body<?php if (!empty($overflow)) echo " over-width" ?>"> 
						<?php
							echo @$graph_area;
							echo $tabel_bawah;
						?>
					</div>
				</div>
			<!-- </div> -->

	    </div>
    </div><!-- /.box-header -->
	

   
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


