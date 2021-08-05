<html>
	<head><title>Print Out</title>
	<link href="<?php echo base_url() ?>assets/css/cetak.css" rel="stylesheet" type="text/css" />
    <style rel="stylesheet/css">
		
		body { font-family: 'arialnarrow',arial,tahoma; }
	
	</style>
	
	</head>
	<body onLoad="self.print()">
	<?php 
	
	if (!empty($content)) echo $title.$content;
	else $this->load->view($viewload);

	?>
	</body>
</html>
