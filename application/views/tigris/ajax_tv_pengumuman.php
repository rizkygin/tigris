<?php 
	if ($news->num_rows() > 0) {
	foreach ($news->result() as $n) {
		if ($n->huruf == 11) $te = 'font-size: 10px';
		else if ($n->huruf == 14) $te = 'font-size: 12px';
		else if ($n->huruf == 24)$te = 'font-size: 14px'; ?>
		<div class="news news-<?php echo $n->id_news ?>">
			<div class="news-title" style="border-bottom: 1px dashed #f8c300;">
				<div class="row">
					<div class="col-lg-7" style="<?php echo $te ?>;"><?php echo $n->judul ?></div>
					<div class="col-lg-5 news-title-sub" style="font-size: 12px;"><?php echo tanggal($n->tanggal) ?><br/>
						<?php echo '<i>Oleh : '.$n->oleh.'</i>' ?>
					</div>
				</div>
			</div>
			<div class="luar" style="min-height:155px;">
				<div class="dalam" style="<?php echo $te ?>;">
					<?php echo $n->konten; ?>
				</div>
			</div>
			
		</div>
	<?php
	echo $paging;
	 }
	} else {
		echo '<div class="alert">Belum ada Pengumuman ...</div>';
		echo $paging;
	} ?>

	<script>
			$(document).ready(function() {
				$('.luar').height($('.box-peng').height()-175);
				$('.dalam').each(function() {
						set_peng($(this));
				});
				
				function set_peng(from) {
					setTimeout(function() {
						setInterval(function() {
							if (parseInt($(from).parent().css('height')) < parseInt($(from).css('height'))) {
								var posnow = $(from).css('top');
								if (parseInt(posnow) > (-1)*parseInt($(from).css('height'))) {
									$(from).css('top',(parseInt(posnow)-10)+'px')
								} else {
									$(from).animate({ 'top': 10});
								}
							}
						},1000);
					},1000);
				}
			});
		</script>