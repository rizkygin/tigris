<?php

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$file_name);

?>
<html><head>

</head>
<body>
<?php echo $tabel; ?>
</body>
</html>