<div class="pull-right hidden-xs">
          <b>Versi</b> <?php echo (!empty($this->st['ver'])? $this->st['ver']:"3.01");
                       ?>
</div> &copy; <?php echo $this->st['copyright'] ?> | <?php echo (!empty($this->st['app_cr'])
    ? $this->st['app_cr']
    : '<a href="http://www.mediamultikaryatama.id">CV. Media Multi Karyatama</a>');

    $this->benchmark->mark('endzz');
    if($this->st['debug'])echo komen(
        'mU:'.$this->benchmark->memory_usage()
        .' Al:'.$this->benchmark->elapsed_time('awalzz','endzz')
    );?>