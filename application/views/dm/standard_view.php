<?php echo @$css_load;?>
<style  type="text/css">
<!--
<?php if (!empty($css))echo $css;?>
-->
</style>

<?php if (!empty($include)) echo $include;?>
<?php if (!empty($include_script)) echo $include_script;?>
<script type="text/javascript">
<?php if (!empty($out_script)) echo $out_script; ?>
$(document).ready(function(){
	$('#myModal').on('hide.bs.modal', function(){
		$('#myModal').removeData();
	})
    $('.heading').parent().find('td').addClass('headings');
    <?php if (!empty($script)) echo $script; ?>
}); 
</script>
<?php
  $box_cls = !empty($tabs)?'nav-tabs-custom':'box';
?>
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
			<div class="<?php echo (@$col_tombol?$col_tombol[0]:'col-md-6');?>"><?php echo @$tombol.@$tombol_tambah?></div>
			<?php if (!empty($extra_tombol)) echo '<div class="'.(@$col_tombol?$col_tombol[1]:'col-md-6').'">'.$extra_tombol.'</div>'; ?>
	    </div>
    </div><!-- /.box-header -->
    <?php } ?>
    <div class="box-body<?php if (!empty($overflow)) echo " over-width" ?>">

<?php
if(isset($graph_area))echo $graph_area;
if(isset($tabel))echo $tabel;
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



