<?php
$a = $this->uri->segment(1);
$b = $this->uri->segment(2);
$c = $this->uri->segment(3);
$d = $this->uri->segment(4);
?>

<li <?php if ($c == "parameter")  echo 'class="active"' ?>><?php echo anchor('inti/pengaturan/parameter','<i class="fa fa-cube"></i> <span> Dasar</span>') ?></li>

<?php if ($this->config->config['root'] == 1) { ?>
<li <?php if ($c == "aplikasi") echo 'class="active"' ?>><?php echo anchor('inti/aplikasi/load_list','<i class="fa fa-plug"></i> <span> Aplikasi</span>') ?></li>
<li <?php if ($b == "kewenangan") echo 'class="active"' ?>><?php echo anchor('inti/kewenangan','<i class="fa fa-lock"></i> <span> Kewenangan</span>') ?></li>
<li <?php if ($b== "operator") echo 'class="active"' ?>><?php echo anchor('inti/operator','<i class="fa fa-key"></i> <span> Operator</span>') ?></li>
<li class="treeview <?php if ($b == "navi") echo 'active' ?>">
<a href="#"><i class="fa fa-gears"></i> <span>Modul</span> <i class="fa fa-angle-left pull-right"></i></a>
	<ul class="treeview-menu">
		<li <?php if ($b == "navi" and $d == in_de(array('ref' => 1))) echo 'class="active"' ?>><?php echo anchor('inti/navi/show_navi/'.in_de(array('ref' => 1)),'<i class="fa fa-tasks"></i> <span> Modul</span>') ?></li>
		<li <?php if ($b == "navi" and $d == in_de(array('ref' => 2))) echo 'class="active"' ?>><?php echo anchor('inti/navi/show_navi/'.in_de(array('ref' => 2)),'<i class="fa fa-tags"></i> <span> Referensi</span>') ?></li>
	</ul></li>
<?php } ?>