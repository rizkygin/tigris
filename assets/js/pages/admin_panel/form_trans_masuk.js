
$(document).ready(function() {

	let define_data = $('textarea[name=json_detail]').val();
	if(define_data !== undefined) {
		$.map(JSON.parse(define_data), function(det) {
			initTipe({define: det});
		});
	}
	
	$(function(){
		$('select[name=id_tipe]').on('change', function(){
			initTipe();
		})

		global_select('scan-input', {}, 'initTipe', true);
		global_select('scan-pemasok');
	})
});

function initTipe(items=''){

	addDataTable(items);
	validInputItems();
	
}


function addDataTable(items){
	// if()
	typeof items == 'object' ?  console.log('object') : console.log('number');
	if(typeof items == 'object'){
		var item = items.define;
	}else if(typeof items == 'number'){
		var item = function(){
			let self = '';
			$.ajax({
				url: $('input[name=site_url]').val()+'ajax/items/single_item',
				type: 'GET',
				dataType: 'json',
				data: {id: items},
				async:false
			})
			.done(function(res) {
				self = res;
			})
			return self;
		}();
	}

	$('.scan-input').val(null).trigger('change');

	var tableId= $('#table-data');
	if(typeof item == 'object'){
		// let no = tableId.find('tbody > tr').length + 1;
		if($('table > tbody > tr#'+item.id_items).length == 0) $(`
			<tr id="`+item.id_items+`">
			<td>
			<input type="hidden" name="items[]" value="`+item.id_items+`">
			<button type="button" class="btn btn-sm btn-remove-item"><i class="fa fa-trash text-danger"></i></button>
			</td>
			<td>`+item.kode+`</td>
			<td>`+item.nama+`</td>
			<td><input class="harga_pokok" name="harga_pokok[]" type="text" value="`+formatRupiah(String(item.harga_pokok))+`" style="width:55px;"></td>
			<td><input title="harus angka !" data-parsley-type="number" data-parsley-required="1" class="jumlah" name="jumlah[]" type="text" style="width:55px;" value="`+(item.jumlah ? item.jumlah : '')+`"></td>
			<td>
			<input class="total_harga" name="total_harga[]" type="text" readonly="readonly" style="width:85px;" value="`+(item.total_harga ? formatRupiah(String(item.total_harga)) : '')+`">
			</td>
			</tr>
			`).appendTo(tableId.find('tbody'));

			// validInputItems();
		hitungTotalBayar();

		$(function(){
			validInputItems();

			$('.btn-remove-item').unbind('click').on('click', function(){
				$(this).parents('tr').remove();
				hitungTotalBayar();
			})
			$('.harga_pokok').unbind('keyup').on('keyup', function(){
				let total_hrg = 0;
				let hrg = $(this).val();
				let jml = $(this).parents('tr').children().find('.jumlah').val();
				total_hrg = parseFloat(jml.replace(/[$.]+/g,"") * hrg.replace(/[$.]+/g,""));
				// console.log(total_hrg);
				$(this).parents('tr').children().find('.total_harga').val(formatRupiah(String(total_hrg)));
				hitungTotalBayar();

				return $(this).val(formatRupiah(String(this.value)));
			})
			$('.jumlah').unbind('keyup').on('keyup', function(){
				let total_hrg = 0;

				let jml = $(this).val();
				let hrg = $(this).parents('tr').children().find('.harga_pokok').val();
				total_hrg = parseFloat(jml.replace(/[$.]+/g,"") * hrg.replace(/[$.]+/g,""));
				console.log(total_hrg);
				$(this).parents('tr').children().find('.total_harga').val(formatRupiah(String(total_hrg)));
				hitungTotalBayar();
			});


		})
	}

}

function validInputItems(){
	let id_tipe = $('select[name=id_tipe]').val();
	if($('.jumlah').length > 0){
			if(id_tipe == 1){//+
				$('.jumlah').attr('data-parsley-pattern', '^\\d*\\.?\\d+$');
				$('.jumlah').removeAttr('max');
				$('.jumlah').attr('min', '1');
			}else if(id_tipe == 2){ //-
				$('.jumlah').attr('data-parsley-pattern', '^-\\d*\\.?\\d+$');
				$('.jumlah').removeAttr('min');
				$('.jumlah').attr('max', '-1');
			}
		}

	}


	function hitungTotalBayar(){
		var tableId= $('#table-data');
		let total_bayar = 0;
		let trData = tableId.find('tbody > tr');
		$.map(trData, function(item, index) {
			total_bayar += isNaN(parseFloat($(item).children().find('.total_harga').val().replace(/[$.]+/g,""))) ? 0 : parseFloat($(item).children().find('.total_harga').val().replace(/[$.]+/g,""));
		});
		$('input[name=total_bayar]').val(formatRupiah(String(total_bayar)));
	}

