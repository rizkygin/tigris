<link rel='stylesheet' type='text/css' href='<?php echo  base_url()."assets/css/bso.css"?>'/>
<script type="text/javascript">
$(document).ready(function() {

  var winwidth = $(window).width();

  $('#box-image').height($(window).height()-340);
  $('#onposition').click(function(e) {
  
    var offset = $(this).offset();
	
	var box = $('#boxpos').val();
	var boxfo = $('#boxfocus').val()
	
	if (!box) {
		$('#alertbox').addClass('alert alert-danger').html('Pilih salah satu obyek dahulu');
	} else {
		$('#alertbox').removeClass('alert-danger').addClass('alert alert-success').html('Obyek berhasil diletakkan');
		
		$(document).unbind('mousemove');
		$('#flowbox'+boxfo).css({ opacity: 1 });
		$('#xbox'+box).val(parseInt(e.clientX - offset.left+1));
		$('#ybox'+box).val(e.clientY - offset.top);
		
		$('.box-diagram').slideUp();
		$('#btn-open-bso').show();
		$('#btn-close-bso').hide();
	}
  });
  
  $('#btn-open-bso').click(function() {
		$(this).hide();
		$('#btn-close-bso').show();
		$(".box-diagram").slideDown();
		return false;
  });
  
  $('#btn-close-bso').click(function() {
		$(this).hide();
		$('#btn-open-bso').show();
		$(".box-diagram").slideUp();
		return false;
  }); 
  
  $('.boxon').click(function() {
  
	$('.content').animate({scrollTop: '0px'}, 800);
	var val = $(this).attr('id');

	$('.box-diagram').slideDown();
	
	$('#tabel_data tr').css('background','#fff');
	$('#boxfocus').val(val);
	
	setTimeout("$(this).parent().parent().css('background','#B7D5E8')",300);
	$(document).bind('mousemove', function(e){
		var offsets = $('#onimage').offset();
		$('#flowbox'+val).css({ 'left':  e.clientX - offsets.left, 'top':   e.clientY - offsets.top, 'opacity': '0.3', 'visibility' : 'visible'});
	});
	$('#boxpos').val(val);
	return false;
	});
  
});

</script>


<div class="btn-group pull-right" style="margin-left: 10px">
<?php echo anchor('referensi/bso','<span class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</span>'); ?>
</div>
<span class="btn btn-danger btn-medium pull-right"  style="display: none" id="btn-close-bso"><i class="fa fa-search-minus"></i> Tutup Bagan</span>
<span class="btn btn-default pull-right" id="btn-open-bso"><i class="fa fa-search-plus"></i> Buka Bagan</span>

<div class="clear"><p> &nbsp; </p></div>



<div class="row">
	<div class="col-lg-12">

		<div class="box box-diagram"  style="display: none">
		<div class="box-header with-border"><h4 class="title">Diagram Struktur Organisasi</h4></div>
		<div class="box-body">
			<input type="hidden" id="boxpos">
			<input type="hidden" id="boxfocus">
		<?php
		if ($unit->bso_image) {
		list($imgwidth, $imgheight, $type, $attr) = getimagesize(base_url().'uploads/kepegawaian/bso/'.$unit->bso_image); ?>
		<div id="box-image" style="overflow: auto; position: relative;">
			<div id="onimage" style="background: #000 url('<?php echo base_url().'uploads/kepegawaian/bso/'.$unit->bso_image ?>') no-repeat left top; position: absolute; top: 0; left: 0; width:<?php echo $imgwidth ?>px; height: <?php echo $imgheight ?>px" >&nbsp;</div>
			<?php if (!empty($unit->bso_uu)) { ?><div class="box-uu"><b><?php echo $unit->bso_uu?></b></div><?php } ?>
			<?php foreach($box->result() as $ro) {

				$visible = ((empty($ro->pos_x) or $ro->pos_x == '0') or (empty($ro->pos_y) or $ro->pos_y == '0')) ?"visibility: hidden" : null;
				
				echo "<div id='flowbox".$ro->id_bidang."' class='boxstandard' style='top: ".$ro->pos_y."px; left: ".$ro->pos_x."px; ".$visible."'>
					<div class='bsojudul'><b>".$ro->nama_bidang."</b></div>
					<div class='bsoimgbox'></div>
					<div class='".$ro->id_bidang."' id='boxcontent'></div>
					</div>"; ?>
				<script type="text/javascript">
				$(document).ready(function() {
					$.get('<?php echo site_url("referensi/bso/detail/".$ro->id_bidang)?>',function(data){ 
						$('.<?php echo $ro->id_bidang?>').html(data); 
					});
				});
				
				function hideImage() { $('.load_image').hide(); }
			
				setTimeout('hideImage()',4000);
				</script>
				<?php
				
			} ?>
			<div id="onposition" style="position: absolute;top: 0; left: 0;cursor: crosshair; width:<?php echo $imgwidth ?>px; height: <?php echo $imgheight ?>px">&nbsp;</div>
		</div>
		<?php } ?>
		</div>
		</div>
	</div>


	<div class="col-lg-7">
		<?php echo form_open('referensi/bso/update_box/','id="form_kotak"') ?>
		<div class="box">
			<div class="box-header with-border"><h4 class="title">Kotak Struktur</h4></div>
			<div class="box-body"><?php echo $tabel.form_hidden('id_unit',$unit->id_unit); ?></div>
			<div class="box-footer"><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button></div>
		</div>
		<?php echo form_close(); ?>
	</div>

	<div class="col-lg-5">
		<?php echo form_open('referensi/bso/save_uu','id="form_uu"'); ?>
		<div class="box">
			<div class="box-header with-border"><h4 class="title">Peraturan Perundang-undangan</h4></div>
			<div class="box-body">
			<?php echo form_hidden('id_unit',$unit->id_unit); ?>
			<textarea class="form-control" rows="3" name="bso_uu" placeHolder="Aturan Perundang-undangan yang berlaku ... "><?php echo !empty($unit->bso_uu) ? $unit->bso_uu : null; ?></textarea>
			</div>
			<div class="box-footer"><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button></div>
		</div>
		<?php echo form_close(); ?>
		
		<form method="post" enctype="multipart/form-data" action="<?php echo  site_url('referensi/bso/upload_bso')?>" id="form_fotoupload">
		<div class="box">
			<div class="box-header with-border"><h4 class="title"><?php echo (!empty($unit->bso_image)) ? 'Ganti Layar Belakang' : 'Unggah Layar Belakang'; ?></h4></div>
			<div class="box-body">
			<?php if (!empty($unit->bso_image)) { ?>
			<div class="img-circle bg-blue text-center" style="width: 100px; height: 100px; padding: 10px; margin: 0 auto"><h4 style="font-size: 4em;"><i class="fa fa-image"></i></h4></div>
			<input type="hidden" name="foto_past" value="<?php echo $unit->bso_image; ?>"/>
			<?php } else { ?>
			<div class="img-circle text-center" style="background: #ccc; width: 100px; height: 100px; padding: 10px; margin: 0 auto"><h4 style="font-size: 4em;"><i class="fa fa-image"></i></h4></div>
			<?php } ?>
			<input type="hidden" name="id_unit" value="<?php echo $unit->id_unit?>"/>
			<input name="bso" id="bso" type="file" onchange="$('#form_fotoupload').submit()" />
			</div>
		</div>
		</form>
	</div>
</div>

</div>
</div>
