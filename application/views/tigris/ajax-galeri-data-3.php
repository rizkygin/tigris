<?php 
if (!empty($detail_kegiatan_mi)) {
	$nox=1;
	foreach($detail_kegiatan_mi->result() as $row){ ?>
		<div class="row">
			<div class="col-lg-12 no-padding" style="text-align:right;position:relative !important;">
				<div class="blink_me badge" style="color:#fff;margin-top:-38px; font-size:22px;position:absolute;left:28%;padding:5px;background: none !important;"> <?php echo $total_rows; ?> </div>
			
				<!-- <div class="badge" id="blinkx" style="background:#fff;margin-top:-33px;display: inline;font-size:14px;position:absolute;top:0px;right:20px; padding:5px;color:<?php echo $row->color; ?> !important;"> <?php echo tanggal($row->tgl_mulai).'  s.d '.tanggal($row->tgl_selesai); ?> </div>
				 -->
				 <div class="badge" id="blin" style="background:#fff;margin-top:-33px;display: block;font-size:14.5px;position:absolute;right:20px;padding:5px;color:blue !important;"> <?php echo tanggal($row->tanggal_ujian); ?> </div>
			</div>

			<div class="col-lg-12" style="font-size: 18px;">
				<div class="col-lg-1" style="background: blue; color:#fff;"><b><?php echo ($page+1);?></b></div>
				<?php 
					if(strlen($row->nama_judul) >= 40){ ?>
					<div class="col-lg-11 no-padding">
						<div class="striper_mingni" style="width:400px;">
							<div class="strip-mingni" style="width:<?php echo (strlen($row->nama_judul)*9); ?>px">
								<?php echo $row->nama_judul; ?>
							</div>
						</div>
					</div>
					<?php }else{ ?>
						 <div class="col-lg-11 no-padding"><?php echo $row->nama_judul;?></div>
					<?php } ?>
			</div>
		</div>
			<div class="col-lg-12 news-content" style="font-size: 12px;border-top: 1px solid blue;">
				<div class="luar_mingni_kir" style="min-height:120px;">
					<div class="dalam-mingni_kir" style="<?php echo @$te ?>;">
						<?php echo $row->nama_judul; ?>
					</div>
				</div>
			</div>
	<div class="clear"></div>
<?php $nox+=1; 
		
	}
}else{
	echo " Tidak ada agenda bulan ini";
} ?>
<?php echo $this->ajax_pagination_gal3->create_links();?>

	<script>					
		$(document).ready(function() {
			$('.luar_mingni_kir').height($('.box-mingguini').height()-140);
			$('.dalam-mingni_kir').each(function() {
					set_peng($(this));
			});
			
			function set_peng(from) {
				setTimeout(function() {
					setInterval(function() {
						if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
							var posnow = $(from).css('top');
							if (parseInt(posnow) > (-1)*parseInt($(from).css('height'))) {
								$(from).css('top',(parseInt(posnow)-18)+'px')
							} else {
								$(from).animate({ 'top': 10});
							}
						}
					},5000);
				},1500);
			}
		});

		$(document).ready(function() {
			$('.striper_mingni').width($('.box-mingguini'));
			$('.strip-mingni').each(function() {					
				set_movex($(this));					
			});					
		
			function set_movex(from) {
			setInterval(function() {
				var posnow = $(from).css('left');
				if ((parseInt(posnow)-parseInt($(from).css('width'))+150) > (-1)*parseInt($(from).css('width'))) {
					$(from).css('left',(parseInt(posnow)-10)+'px')
				} else {
					$(from).animate({ 'left': 30})
				}
			},800)
			}
		});
	</script>
