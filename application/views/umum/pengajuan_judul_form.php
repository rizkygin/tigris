
  <script type="text/javascript" src="<?php echo base_url().'assets/js/general.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/typeahead/typeahead.min.js' ?>"></script>
<link href="<?php echo base_url().'assets/plugins/iCheck/all.css' ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>

          <div class="row" id="form-box">
            <div class="col-md-12">
              <div class="box box-warning">
            <div class="box-header with-border">
              <i class="fa fa-paint-brush fa-btn"></i><h3 class="box-title" id="form-title"> Judul Form</h3>
            </div>
              <div class="box-body">
              <div id="form-content"> <p> 
<?php echo !empty($load_script)?$load_script:null; 
if (!empty($multi)) echo form_open_multipart($form_link,'id="form_data" role="form"');
else echo form_open($form_link,'id="form_data" role="form"');
	echo '<div id="alert-form"></div>';
 	echo $form_data; 
 	
 	if (!empty($tombol_form)) {
		echo $tombol_form;
	} else { 
	?>	

		<br><button class="btn btn-danger btn-md btn-flat btn-form-cancel" type="button"><a href="<?php echo $dir;?>"><i class="fa fa-arrow-left"></i> &nbsp; Batal</a></button>
		<button href="#" class="btn btn-success btn-md btn-flat btn-save-act pull-right" ><i class="fa fa-save"></i> &nbsp; Simpan</button>
		<div class="clear"></div>
	<?php } ?>
<?php echo  form_close()?>
</p></div>
              </div>
            <div class="overlay on-hide" id="form-overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
              </div>
            </div>
          </div>

<script type="text/javascript">
	
	<?php echo  @$out_script; ?>
	let similiar_percen = 0;
	let judul_mirip = new Array();
	let text = "";
	let id_pengajuan_judul;
	function check_similiarity(judul,page = null){
		// console.log(judul);
		$('#similiar_hidden').val(0);
		
		similiar_percen = 0;

		page = page || 1;
		// $('#similiar').text(' '+ judul);
		if(page == 1){
			similiar = [];
			$('.progress .progress-bar').css('width','0%');
					$('.progress .progress-bar').attr('aria-valuenow',0);
					$('.progress .progress-bar').text('0%');
		}
		let grab = function (){
			ret = false;
			$.ajax({
			url : "<?php echo base_url().'tigris/Pengajuan_judul/similiarity';?>",
			type: 'GET',
			dataType: 'json',
			data: {
				title: judul,
				page : page,
			},
			async:false,
			success: function(res){
				// console.log(res);
				if(res.status){
					// similiar = push(res.result);
					ret = res;	
					$('.progress .progress-bar').css('width',res.progress + '%');
					$('.progress .progress-bar').attr('aria-valuenow',res.progress);
					$('.progress .progress-bar').text(res.progress + '%');
					
				}
			}
			
			});
			return ret;
		}();
		if(grab && grab.status){
			$.map(grab.result,function(e){
				similiar.push(e);
			});
			if(grab.more){
				check_similiarity($('#judul_tesis').val(),page+1);
			}else{
				console.log(similiar);
				judul_mirip = new Array();
				
				$.map(similiar,function(e){
					if(e.persen > similiar_percen){
						similiar_percen = e.persen
						$('#similiar').text(' ' + similiar_percen.toFixed(2) + '%');
						$('#status_progress').text('Complete');
						
						$('#similiar_hidden').val(similiar_percen.toFixed(2));
						// $('#check').attr('disabled', true);
					}
					if(e.persen > 50){
						judul_mirip.push(e);
						text = "Mirip Dengan";
						
					}
				});


				$.map(judul_mirip,function(e){
					text += "</br> " + e.judul + " : " + e.persen.toFixed(2) +"%";

				});
				// console.log(judul_mirip.length);
				if(judul_mirip.length == 1 ){
					console.log('yeay');
					console.log(judul_mirip[0]);
				}
				$('#judul_mirip').html(text);
			}
		}
		return similiar_percen;
	}
	$(document).ready(function(){

		<?php 
		if(@$edit_data_sendiri){
			?>
			$('#ngecek').css('display','none');

			$('#similiar_hidden').val(0);
			
			$('#tampil_cek').on('click',(event) => {
				$('#ngecek').css('display','block');
				$('#tampil_cek').css('display','none');
				$('#similiar_hidden').val(100);

				})
			<?php
		} 
		?>		
		$('.combo-box').select2(); // Yang merasa punya select dicek lagi, ubah ke DOM combo-box
		$('.datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
		$('input[type="checkbox"].incheck, input[type="radio"].incheck').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass: 'iradio_minimal-blue'
			});
		$('.btn-form-cancel').click(function() {
		   $('#form-content,#form-title').html(null);
		   $('#form-box').slideUp();
		   $('#box-main').show();
	   	});
		   
		
		$('#form_data').submit(function() {
			$('.btn-save-act').attr('disabled','disabled').html('<i class="fa fa-spin fa-spinner fa-btn"></i> Proses ...');
		});
		$('#form-title').html('<?php echo $title; ?>');
		$('#judul_tesis').on('input', (event) => {
			judul_mirip = new Array();
			text = "";
			console.log("percen: "+ similiar_percen);

			$('.progress .progress-bar').css('width','0%');
					$('.progress .progress-bar').attr('aria-valuenow',0);
					$('.progress .progress-bar').text('0%');
					$('#status_progress').text('Processing . . .');
					$('#judul_mirip').html('');
				$('#similiar_hidden').val(100);

		});
		$('#check').on('click',(event) => check_similiarity($('#judul_tesis').val()));
		<?php echo @$script; ?>
	});

</script>