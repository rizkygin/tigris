<?php echo @$include;?>
<?php echo @$include_script;?>
<script type="text/javascript">
<?php echo  @$out_script ?>
    $(document).ready(function(){
	    $('#myModal').on('hide.bs.modal', function(){
		    $('#myModal').removeData();
	    })
    });
	$(document).ready(function(){
		<?php echo  @$script ?>
	});
</script>

<?php
echo $tabel;
?>
<?php
    echo @$css_load;
    if (!empty($css))echo '<style type="text/css">
<!--
'.$css.'
-->
</style>';
?>


