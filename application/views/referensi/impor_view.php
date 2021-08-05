<script type="text/javascript">
	$(document).ready(function() {
		$('#load').show();
		  $.ajax({
		      url: '<?php echo $tujuan.'/'.$se.'/'.$offs; ?>',
		      cache: false,
		      success: function(msg) {
		         $('#box_impor').html(msg);
				 $('#load').hide();
				 $('#btn_confirm').show();
		      },error:function(error){
				$('#load').hide();
				$('#load-error').html('<i class="fa fa-error"></i> ERROR : '+error).show();
				}
		   });
		   
		$('#btn_confirm').click(function() {
			$('#modal-konfirm-impor').modal('show');
		});
		
		$('#btn_proses').click(function() {
			$('#form_importing').submit();
			$('#modal-konfirm-impor').modal('hide');
		});
		
	});
</script>
<div class="box" id="box-main">
	 <div class="box-header with-border">
	    <h4 class="title pull-left">
			Impor Data Pegawai
	    </h4>
	    <?php echo anchor('inti/pengaturan/impor','<i class="fa fa-arrow-left"></i> Kembali','class="btn btn-default pull-right"'); ?>
	    <div class="clear"></div>
    </div>
    <div class="box-body">
	    <div class="alert alert-confirm" id="load" style="display: none"> 
              <i class="fa fa-refresh fa-spin"></i> &nbsp;  Memuat ... 
        </div>
	    <div class="alert alert-danger" id="load-error" style="display: none"></div>
	    <?php echo form_open('inti/pengaturan/importing/','id="form_importing"') ?>
	    <div id="box_impor"></div>
	    <span class="btn btn-success btn-confirm" id="btn_confirm" style="display: none">
	    	<i class="fa fa-database"></i>&nbsp;  Proses!
	    </span>
	    <?php echo 
		    form_hidden('se',$se).
		    form_hidden('offs',$offs).
			form_hidden('tujuan',$tujuan).
			form_close(); ?>
    </div>
</div>


<div class="modal fade" id="modal-konfirm-impor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	    <div class="modal-header"><button class="close" aria-label="Close" data-dismiss="modal" type="button">
		<span aria-hidden="true">×</span>
		</button>
		<h4 class="modal-title form-title"><i class="fa fa-database"></i> &nbsp; Konfirmasi Proses Impor</h4></div>
        <div class="modal-body">
	        	Apakah akan melaksanakan impor data untuk baris terpilih,<br>
	        	untuk baris yang duplikat pada database, akan dilakukan pembaharuan</div>
        <div class="modal-footer">
		<button class="btn btn-default pull-left" data-dismiss="modal" type="button">Batal</button>
		<a class="form-delete-url">
			<button class="btn btn-danger" id="btn_proses" type="button">
			<i class="fa fa-database"></i> &nbsp; Proses!
			</button></a>
		</div>
    </div>
  </div>
</div>