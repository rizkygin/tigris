let autoCompStat =true;
let itemWeight =0;
$(document).ready(function() {
	initTipe();
	initStatus();
	let define_data = $('textarea[name=json_detail]').val();
	if(define_data !== undefined) {
		$.map(JSON.parse(define_data), function(det) {
			initTipe({define: det});
		});
	}
	
	$(function(){
		$('select[name=id_tipe]').unbind('change').on('change', function(){
			initTipe();
		})

		$('select[name=id_status]').unbind('change').on('change', function(){
			initStatus();
		})

		global_select('scan-input', {}, 'initTipe', true);
		global_select('scan-konsumen');

		if($('select[name=id_kecamatan]').val() != '') initCost($('select[name=id_kecamatan]').val());
	})
});

function initStatus(){
	let sta =$('select[name=id_status]').val();
	// console.log(sta);
	// if(sta == 3 || sta == 4) {
		// pending, proses, dikirim, selesai
		if(sta == 3 || sta == 4) {
			$('#scan-input').parents('.form-group').addClass('d-none');
			$('.btn-remove-item').addClass('d-none');
			$('.harga_jual, .jumlah').attr('readonly', 'readonly');
			formExpedisi();

		}else {
			$('#scan-input').parents('.form-group').removeClass('d-none');
			$('.btn-remove-item').removeClass('d-none');
			$('.harga_jual, .jumlah').removeAttr('readonly');
		// $('.box-expedisi > table').remove();
		// hitungTotalBayar();
		formExpedisi();
	}
	
}

function initTipe(items=''){
	addDataTable(items);
	validInputItems();
	let tipe = $('select[name=id_tipe]').val();
	// console.log(tipe);
	if(tipe == 1){
		$('#status-form').removeClass('d-none');
		$('#status-form > select').attr('data-parsley-required', 'true');
		formExpedisi();
	}else{
		$('#status-form > select').removeAttr('data-parsley-required');
		$('#status-form').addClass('d-none');
		$('.box-expedisi').html('');
		hitungTotalBayar();

	}
}

function initCost(subdistrictId){
	// console.log(subdistrictId)
	let dataExp = $('textarea[name=data_exp]').val();
	// console.log(dataExp);
	if(dataExp !== ""){
		dataExp = JSON.parse(dataExp);
	}
	console.log(dataExp);
		let table = $('.table-cost');
		$.ajax({
			url: $('input[name=site_url]').val()+'/ajax/raja_ongkir/cost_list',
			type: 'GET',
			dataType: 'json',
			data: {subdistrict_id: subdistrictId, weight:itemWeight, detail:$('input[name=set_detail]').val(), kodepos:$('input[name=set_kodepos]').val()},
			success:function(res){
				// self = res;
				let tr = '';
				let no = 1;
				if(res.results) $.map(res.results, function(item) {
					// return something;
					// console.log(item);
				$.map(item.costs, function(co) {
					// return something;
					// console.log(co.cost);
					let checked = '';
					if(dataExp !== "" && item.code== dataExp.code && co.service == dataExp.service) checked = 'checked';else checked = '';
					// console.log(checked);
					tr += `<tr>
						<td><input `+checked+` type="radio" value="`+item.code+`-`+co.service+`" data-values='{"code":"`+item.code+`","service":"`+co.service+`","cost":"`+co.cost[0].value+`", "etd":"`+co.cost[0].etd+`","note":"`+co.cost[0].note+`","origin_data":`+JSON.stringify(res.origin_data)+`,"destination_data":`+JSON.stringify(res.destination_data)+`}' name="courir"></td>
						<td>`+(no++)+`</td>
						<td>`+item.code.toUpperCase()+`</td>
						<td>`+co.service+`</td>
						<td>`+co.cost[0].value+`</td>
						<td>`+(co.cost[0].etd == '' ? 'TIDAK TERSEDIA' : co.cost[0].etd) +`</td>
						<td>`+co.cost[0].note+`</td>
					</tr>`;
				});
					
				});

				table.find('tbody').html(tr);
			}
		})
		
		
	
	// console.log(costData);
}

function formExpedisi(){
	boxExp = $('.box-expedisi');
	// console.log(boxExp)
	// $(function(){
		if(boxExp.find('#btnAlamat').length == 0) boxExp.append(`
			<div class="row">
				<div class="col-md-12">
					<button type="button" id="btnAlamat" class="btn btn-xs btn-warning m-b-5"><i class="fa fa-plus"></i> Pilih Kurir</button>
				</div>
			</div>
			`);
		if(boxExp.find('table.table-kurir-selected').length == 0) boxExp.append(`
			<table class="table table-bordered table-nonfluid table-condensed table-sm text-center table-kurir-selected">
			<thead>
			<tr>
			<th>Nama Kurir</th>
			<th>Servis</th>
			<th>Tarif</th>
			<th>Estimasi</th>
			<th>Keterangan</th>
			</tr>
			</thead>
			<tbody>
			
			</tbody>
			</table>
			`);

			$(function(){
				// btn alamat act
				let modalAlamat = $('#modal-alamat');
				let total_weight = itemWeight;

				$('#btnAlamat').unbind('click').on('click', function(){

					// define expedisi
					
					// console.log(JSON.parse(dataExp));
					/*
					if(dataExp !== ""){
						let dataExp = $('textarea[name=data_exp]').val();
						// console.log(JSON.parse(dataExp));

						dataExp = JSON.parse(dataExp);
						$('input[name=set_kodepos]').val(dataExp.kodepos);
						$('input[name=set_detail]').val(dataExp.detail);
					}
					 */
					
					// ./define expedisi
					modalAlamat.find('input[name=set_weight]').val(itemWeight);
					modalAlamat.find('.berat-paket-capt').text(itemWeight+' Gram');
					modalAlamat.modal();
					global_select('id_provinsi');
			        global_select('id_kabupaten',[{key:'province_id',val:'id_provinsi'}]);
			        global_select('id_kecamatan',[{key:'city_id',val:'id_kabupaten'}], 'initCost', true);

			        modalAlamat.find('.submit-modal').unbind('click').on('click', function(){
			        	// alert('helloooo');
			        	// console.log(modalAlamat.find('input[name=courir]:checked').data('values'));
			        	let destination = modalAlamat.find('select[name=id_kecamatan]').val();
			        	let origin = modalAlamat.find('input[name=origin]').val();
			        	let kodepos = modalAlamat.find('input[name=set_kodepos]').val();
			        	let destination_detail = modalAlamat.find('input[name=set_detail]').val();

			        	let courirData = modalAlamat.find('input[name=courir]:checked').data('values');
			        	// courirData = courirData.results;
			        	console.log(courirData);
			        	let table = $('.table-kurir-selected');
			        	table.find('tbody').html(`
			        		<tr>
			        		<td>
			        		<textarea name="expedisi" class="d-none">`+JSON.stringify(courirData)+`</textarea>
			        		<input name="destination" type="hidden" value="`+destination+`">
			        		<input name="exp_tarif" type="hidden" value="`+courirData.cost+`">
			        		<input name="kodepos" type="hidden" value="`+kodepos+`">
			        		<input name="total_weight" type="hidden" value="`+total_weight+`">
			        		<input name="destination_detail" type="hidden" value="`+destination_detail+`">
			        		`+courirData.code.toUpperCase()+`</td>
			        		<td>`+courirData.service+`</td>
			        		<td>`+courirData.cost+`</td>
			        		<td>`+(courirData.etd == "" ? 'TIDAK TERSEDIA' : courirData.etd )+`</td>
			        		<td>`+courirData.note+`</td>
			        		</tr>
			        		`);
			        	modalAlamat.find('.close-modal').click();
			        	hitungTotalBayar();

			        	if(boxExp.find('.table-kurir-origin').length == 0) boxExp.append(`<div class="table-kurir-origin"></div>`);
			        	if(boxExp.find('.table-kurir-destination').length == 0) boxExp.append(`<div class="table-kurir-destination"></div>`);

			        	// show origin &destinat
			        	let originDiv = $('.table-kurir-origin');
			        	let destinationDiv = $('.table-kurir-destination');

			        	originDiv.html(`
			        		<h5>Dikirim Dari</h5>
			        		<p>`+$('textarea[name=origin_data]').val()+`</p>
			        		`);
			        	let subdistrict = function(){
			        		let self =false;
			        		$.ajax({
			        			url: $('input[name=site_url]').val()+'/ajax/request/subdistrict_data',
			        			type: 'GET',
			        			dataType: 'json',
			        			data: {subdistrict_id: $('select[name=id_kecamatan]').val()},
			        			success:function(res){
			        				self = res.kecamatan+', '+res.kabupaten+', '+res.provinsi;
			        			},
			        			async:false
			        		});

			        		return self;
			        		
			        	}();
			        	destinationDiv.html(`
			        		<h5>Tujuan</h5>
			        		<p>`+$('input[name=set_detail]').val()+`, kodepos: `+$('input[name=set_kodepos]').val()+`, `+subdistrict+`</p>
			        		`);

			        	// ./show origin &destinat
			        });

				})
				// ./btn alamat act
				let dataExp = $('textarea[name=data_exp]').val();
				// console.log(dataExp)
				if(dataExp !== undefined && isJson(dataExp)) {
					dataExp = JSON.parse(dataExp);
					let courirData = dataExp;
		        	let table = $('.table-kurir-selected');
		        	table.find('tbody').html(`
		        		<tr>
		        		
		        		<td>
		        		<textarea name="expedisi" class="d-none">`+JSON.stringify(courirData)+`</textarea>
		        		<input name="destination" type="hidden" value="`+courirData.destination+`">
		        		<input name="exp_tarif" type="hidden" value="`+courirData.cost+`">
		        		<input name="kodepos" type="hidden" value="`+courirData.kodepos+`">
		        		<input name="total_weight" type="hidden" value="`+courirData.total_weight+`">
		        		<input name="destination_detail" type="hidden" value="`+courirData.detail+`">
		        		`+courirData.code.toUpperCase()+`</td>
		        		<td>`+courirData.service+`</td>
		        		<td>`+courirData.cost+`</td>
		        		<td>`+(courirData.etd == "" ? 'TIDAK TERSEDIA' : courirData.etd )+`</td>
		        		<td>`+courirData.note+`</td>
		        		</tr>
		        		`);
			        hitungTotalBayar();
			        if(boxExp.find('.table-kurir-origin').length == 0) boxExp.append(`<div class="table-kurir-origin"></div>`);
			        if(boxExp.find('.table-kurir-destination').length == 0) boxExp.append(`<div class="table-kurir-destination"></div>`);

			        // show origin &destinat
			        	let originDiv = $('.table-kurir-origin');
			        	let destinationDiv = $('.table-kurir-destination');

			        	originDiv.html(`
			        		<h5>Dikirim Dari</h5>
			        		<p>`+courirData.origin_data+`</p>
			        		`);
			        	destinationDiv.html(`
			        		<h5>Tujuan</h5>
			        		<p>`+courirData.destination_data+`</p>
			        		`);
			        	// ./show origin &destinat

				}


			})


	
}

function _setTarif(){
	// console.log('helooo');
	let expData = $('input[name=id_expedisi_res]');
	// console.log(expData.attr('data-tarif'));
	$('input[name=exp_tarif]').val(formatRupiah(String(expData.attr('data-tarif'))));
	hitungTotalBayar();
}


function addDataTable(items){
	// if()
	// typeof items == 'object' ?  console.log('object') : console.log('number');
	if(typeof items == 'object'){
		var item = items.define;
	}else if(typeof items == 'number'){
		var item = function(){
			let self = '';
			$.ajax({
				url: $('input[name=site_url]').val()+'ajax/items/single_item',
				type: 'GET',
				dataType: 'json',
				data: {id: items, metode:'jual'},
				async:false
			})
			.done(function(res) {
				self = res;
			})
			return self;
		}();
	}

	// console.log(item);

	$('.scan-input').val(null).trigger('change');

	var tableId= $('#table-data');
	if(typeof item == 'object'){
		// let no = tableId.find('tbody > tr').length + 1;
		if($('table > tbody > tr#'+item.id_items).length == 0) $(`
			<tr id="`+item.id_items+`">
			<td>
			<input type="hidden" name="berat[]" value="`+item.berat+`" class="berat">
			<input type="hidden" name="total_berat[]" value="`+(item.total_berat ? item.total_berat : item.berat)+`" class="total-berat">
			<input type="hidden" name="items[]" value="`+item.id_items+`">
			<button type="button" class="btn btn-sm btn-remove-item"><i class="fa fa-trash text-danger"></i></button>
			</td>
			<td>`+item.kode+`</td>
			<td>`+item.nama+`</td>
			<td><input class="harga_jual" name="harga_jual[]" type="text" value="`+formatRupiah(String(item.harga_jual))+`" style="width:55px;"></td>
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
			$('.harga_jual').unbind('keyup').on('keyup', function(){
				let total_hrg = 0;
				let total_berat = 0;
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
				let hrg = $(this).parents('tr').children().find('.harga_jual').val();
				let berat = $(this).parents('tr').children().find('.berat').val();
				total_hrg = parseFloat(jml.replace(/[$.]+/g,"") * hrg.replace(/[$.]+/g,""));
				total_berat = parseFloat(jml.replace(/[$.]+/g,"") * berat.replace(/[$.]+/g,""));
				// console.log(total_hrg);
				$(this).parents('tr').children().find('.total_harga').val(formatRupiah(String(total_hrg)));
				$(this).parents('tr').children().find('.total-berat').val(total_berat);
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
		itemWeight = 0;
		$.map(trData, function(item, index) {
			total_bayar += isNaN(parseFloat($(item).children().find('.total_harga').val().replace(/[$.]+/g,""))) ? 0 : parseFloat($(item).children().find('.total_harga').val().replace(/[$.]+/g,""));
			itemWeight += parseFloat($(item).children().find('.total-berat').val());
		});
		if($('input[name=exp_tarif]').val() > 0) total_bayar += parseFloat($('input[name=exp_tarif]').val().replace(/[$.]+/g,""));
		$('input[name=total_bayar]').val(formatRupiah(String(total_bayar)));
		// console.log(itemWeight);
	}

