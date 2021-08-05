<html>
	<head><title>Print Out</title>
	<link href="<?php echo base_url() ?>assets/css/cetak.css" rel="stylesheet" type="text/css" />
    <style rel="stylesheet/css">
		
		body { font-family: 'arialnarrow',arial,tahoma; }
	
	</style>
	<?php
      if(isset($css))echo $css;//agsyogya@yahoo.co.id
    ?>
	</head>
	<body onLoad="self.print()">
	<?php 
	if (!empty($content)){ echo $title.$content;
	}elseif(@$viewload){ $this->load->view($viewload);}

	?>
    <?php
      if(!@$no_identification) echo "<div id='identification' style='font-size: x-small;margin: 15px 0 0 0;'>Url : ".implode("\n",str_split(site_url( uri_string()), 200))."</div>";
    ?>
	</body>
</html>
