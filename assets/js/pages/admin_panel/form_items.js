let allPil = [];
let tbody;

$(document).ready(function() {
	$(function(){
		initDataVariant();
		initStockForm();
		$('#addVariBtn').on('click', function(){
			// alert('heloooo')
			// console.log($('.form-variant').length);
			if($('.form-variant').length > 2) {
				alert('Maksimal 3 variasi...');
				return false;
			}
			initFormVariant();
		})
	})
});

function initDataVariant(){
	let variants_data = $('textarea[name=variants_data]').val();
	let elemVariant = $('.form-variant');

	if(variants_data.length > 0){
		$.map(JSON.parse(variants_data), function(item, index) {
			// return something;
			// console.log(item)
			// console.log(elemVariant.length);
			let noElem = item.variant_id;
			let pil = '';
			let no = 0;
			$.map(item.pil, function(p, idP) {
				// return something;
				if(no == 0) pil += `
				<div class="col-md-10 input-group input-group-sm pil">
					<input name="pil_variant[`+noElem+`][`+idP+`]" data-index="`+idP+`" type="text" value="`+p+`" placeholder="Pilihan" class="pilihan-variant form-control form-control-sm"/>
					<div class="input-group-append"><button type="button" class="btn btn-xs text-warning btn-add-pil"> <i class="fa fa-plus"></i></button></div>
				</div>
				`;
				else pil += `
				<div class="offset-md-2 col-md-10 input-group input-group-sm pil">
					<input name="pil_variant[`+noElem+`][`+idP+`]" data-index="`+idP+`" type="text" value="`+p+`" placeholder="Pilihan" class="pilihan-variant form-control form-control-sm"/>
					<div class="input-group-append"><button type="button" class="btn btn-xs text-danger btn-rem-pil"> <i class="fa fa-times"></i></button></div>
				</div>
				`;
				no++;
			});
			let formHtml = `
			<div class="form-group row form-variant" id="variant_`+noElem+`" data-index="`+noElem+`">
				<label class="col-form-label col-md-2">Variasi `+noElem+`</label>
				<div class="col-md-8 bg-grey-transparent-2 p-5">
					<button type="button" class="btn btn-sm text-danger float-right mb-2 btn-rem-variant"><i class="fa fa-trash"></i></button>
					<div class="clearfix"></div>
					<div class="form-group row">
						<label class="col-form-label col-md-2">Nama Variasi</label>
						<div class="col-md-10">
							<input name="nama_variant[`+noElem+`]" type="text" value="`+item.nama_variant+`" placeholder="Nama" class="nama-variant form-control form-control-sm"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-md-2">Pilihan</label>
						`+pil+`
					</div>
				</div>
			</div>
			`;
			if($('#variant_'+noElem).length == 0) $('.variant-box .formulir').append(formHtml);
		});

		$(function(){
			$('button.btn-add-pil').unbind('click').on('click', function(){
				// alert('heloo')
				let indexPil = $(this).parents('.form-variant').find('.pilihan-variant').length + 1;
				// console.log(indexPil);

				$(`
					<div class="offset-md-2 col-md-10 input-group input-group-sm pil mt-2">
						<input name="pil_variant[`+$(this).parents('.form-variant').data('index')+`][`+indexPil+`]" data-index="`+indexPil+`" type="text" placeholder="Pilihan" class="pilihan-variant form-control form-control-sm"/>
						<div class="input-group-append"><button type="button" class="btn btn-xs text-danger btn-rem-pil"> <i class="fa fa-times"></i></button></div>
					</div>
					`).insertAfter($(this).parents('.form-variant').find('.pil').last());
				$(function(){
					$('button.btn-rem-pil').unbind('click').on('click', function(){
						$(this).parents('.pil').remove();
						initTableVariant();
					});
				});
				initTableVariant();
			});

			$('button.btn-rem-variant').unbind('click').on('click',function(){
				$(this).parents('.form-variant').remove();
				initTableVariant();
				if($('.form-variant').length == 0) $('.variant-box .data-table').html('');
				initStockForm();
			})
			initTableVariant();

			$('button.btn-rem-pil').unbind('click').on('click', function(){
						$(this).parents('.pil').remove();
						initTableVariant();
					});
			
			// $('input.nama-variant').unbind('keyup').on('keyup',function(){
			// 		initTableVariant();
			// 	})
		})
	}
};

// attr kategori
function itemsAttr(page){
	// console.log(page)
	page = page || 1;
	let id_kategori = $('input[name=id_kategori_res]').val();
	if(id_kategori != undefined){
		let itemsAttrForm = '';
		// console.log(id_kategori);
		$.ajax({
			url: $('input[name=site_url]').val()+'ajax/items/items_attr_set_data',
			type: 'GET',
			dataType: 'json',
			data: {page:page, id_kategori: id_kategori},
		})
		.done(function(res) {
			const {status} = res;
			if(status== 'success'){
				const {pagination} = res;
				$.map(res.results, function(item, index) {
					itemsAttrForm += `
					<h5 class="m-t-25">`+item.attr_set+`: </h5>
					<div class="items-attr-set-`+item.id+`"></div>
					<input type="hidden" name="items_attr_set_ids[]" value="`+item.id+`">
					`;
					renderItemsAttr(item.id);
				});

				if($('.items-attr-form').length == 0) $('form.general-form .form-group:last').after('<div class="items-attr-form"></div>');
				if(page == 1) $('.items-attr-form').html('');
				$('.items-attr-form').append(itemsAttrForm);
				if(pagination.more) itemsAttr(page + 1);

			}
		})
	}else{
		$('.items-attr-form').remove();
	}
	
}


function renderItemsAttr(id_attr_set, page){
	let itemsAttrForm = '';
	page = page || 1;
	let id_kategori = $('input[name=id_kategori_res]').val();

	$.ajax({
		url: $('input[name=site_url]').val()+'ajax/items/items_attr_data',
		type: 'GET',
		dataType: 'json',
		data: {page:page, id_kategori: id_kategori, id_attr_set:id_attr_set, id_data:$('input[name=id]').val()},
	})
	.done(function(res) {
		const {status} = res;
		if(status== 'success'){
			const {pagination, data_values} = res;

			if(page == 1) $('.items-attr-set-'+id_attr_set).html('');
			// $('.items-attr-set-'+id_attr_set).append(itemsAttrForm);

			$.map(res.results, function(item, index) {
				dfVal = '';
				if(data_values !== null){
					$.map(data_values, function(df, idf) {
						if(df.id_attr_set == id_attr_set && df.id_attr == item.id) dfVal = df.values;
					});
				}
				switch (item.tipe) {
					case 1:
					itemsAttrForm += `
					<div class="form-group form-items-attr-`+id_attr_set+`-`+item.id+`">
					<label class="col-form-label">`+item.attr+`</label>
					<input type="hidden" name="items_attr`+id_attr_set+`_ids[]" value="`+item.id+`">
					<input type="text" value="`+dfVal+`" name="items_attr`+id_attr_set+`_`+item.id+`" class="form-control">
					</div>`;
					break;
					case 2:
					itemsAttrForm += `
					<div class="form-group form-items-attr-`+id_attr_set+`-`+item.id+`">
					<label class="col-form-label">`+item.attr+`</label>
					<input type="hidden" name="items_attr`+id_attr_set+`_ids[]" value="`+item.id+`">
					<textarea name="items_attr`+id_attr_set+`_`+item.id+`" class="form-control text-area">`+dfVal+`</textarea>
					</div>`;

					break;
					case 3:
					itemsAttrForm += `
					<div class="form-group form-items-attr-`+id_attr_set+`-`+item.id+`">
					<label class="col-form-label">`+item.attr+`</label>
					<input type="hidden" name="items_attr`+id_attr_set+`_ids[]" value="`+item.id+`">
					<input type="text" value="`+dfVal+`" name="items_attr`+id_attr_set+`_`+item.id+`" class="form-control datepicker">
					</div>`;
					break;
					case 4:
					let opts = '<option value="">-Pilih-</option>';
					if(isJson(item.isi)){
						let optsData = JSON.parse(item.isi);
						let selActive=null;
						$.map(optsData, function(op, iop) {
							if(dfVal==iop) selActive = 'selected';else selActive =null;
							opts += '<option value="'+iop+'" '+selActive+'>'+op+'</option>';
						});
					}

					itemsAttrForm += `
					<div class="form-group form-items-attr-`+id_attr_set+`-`+item.id+`">
					<label class="col-form-label">`+item.attr+`</label>
					<input type="hidden" name="items_attr`+id_attr_set+`_ids[]" value="`+item.id+`">
					<select name="items_attr`+id_attr_set+`_`+item.id+`" class="form-control" data-attr='{"id_attr_set":"`+id_attr_set+`", "id_attr":"`+item.id+`"}'>
					`+opts+`
					</select>
					</div>`;
					break;
					default:
					itemsAttrForm += `
					<div class="form-group form-items-attr-`+id_attr_set+`-`+item.id+`">
					<label class="col-form-label">`+item.attr+`</label>
					<input type="hidden" name="items_attr`+id_attr_set+`_ids[]" value="`+item.id+`">
					<input type="text" value="`+dfVal+`" name="items_attr`+id_attr_set+`_`+item.id+`" class="form-control" placeholder="default">
					</div>`;
					break;
				}

				// append to form:

			});

			$('.items-attr-set-'+id_attr_set).append(itemsAttrForm);
			
			initMce();
			if(pagination.more) renderItemsAttr(id_attr_set, page + 1);
			$(function(){
				$('.items-attr-form .datepicker').datepicker({
					todayHighlight: true,
					autoclose: true,
					dateFormat: 'dd/mm/yy'
				});

				// setAttrVariant();
			});

		}
	});
}
// ./attr kategori

function initFormVariant(){
	let elemVariant = $('.form-variant');
	// console.log(elemVariant.length);
	noElem = elemVariant.length + 1;
	formHtml = `
	<div class="form-group row form-variant" id="variant_`+noElem+`" data-index="`+noElem+`">
		<label class="col-form-label col-md-2">Variasi `+noElem+`</label>
		<div class="col-md-8 bg-grey-transparent-2 p-5">
			<button type="button" class="btn btn-sm text-danger float-right mb-2 btn-rem-variant"><i class="fa fa-trash"></i></button>
			<div class="clearfix"></div>
			<div class="form-group row">
				<label class="col-form-label col-md-2">Nama Variasi</label>
				<div class="col-md-10">
					<input name="nama_variant[`+noElem+`]" type="text" placeholder="Nama" class="nama-variant form-control form-control-sm"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-md-2">Pilihan</label>
				<div class="col-md-10 input-group input-group-sm pil">
					<input name="pil_variant[`+noElem+`][1]" data-index="1" type="text" placeholder="Pilihan" class="pilihan-variant form-control form-control-sm"/>
					<div class="input-group-append"><button type="button" class="btn btn-xs text-warning btn-add-pil"> <i class="fa fa-plus"></i></button></div>
				</div>
			</div>
		</div>
	</div>
	`;
	if($('#variant_'+noElem).length == 0) $('.variant-box .formulir').append(formHtml);

	$(function(){
		$('button.btn-add-pil').unbind('click').on('click', function(){
			// alert('heloo')
			let indexPil = $(this).parents('.form-variant').find('.pilihan-variant').length + 1;
			// console.log(indexPil);
			$(`<div class="offset-md-2 col-md-10 input-group input-group-sm pil mt-2">
					<input name="pil_variant[`+$(this).parents('.form-variant').data('index')+`][`+indexPil+`]" data-index="`+indexPil+`" type="text" placeholder="Pilihan" class="pilihan-variant form-control form-control-sm"/>
					<div class="input-group-append"><button type="button" class="btn btn-xs text-danger btn-rem-pil"> <i class="fa fa-times"></i></button></div>
				</div>`).insertAfter($(this).parents('.form-variant').find('.pil').last());

			$(function(){
				$('button.btn-rem-pil').unbind('click').on('click', function(){
					$(this).parents('.pil').remove();
					initTableVariant();
				});
			});
			initTableVariant();
		});

		$('button.btn-rem-variant').unbind('click').on('click',function(){
			$(this).parents('.form-variant').remove();
			initTableVariant();
			if($('.form-variant').length == 0) $('.variant-box .data-table').html('');
			initStockForm();
		});


		initTableVariant();
		// $('input.nama-variant').unbind('keyup').on('keyup',function(){
		// 		initTableVariant();
		// 	})

		initStockForm();
	})

}

function initStockForm(){
	let formVariant = $('.form-variant');
	if(formVariant.length == 0){
		let deval = $('textarea[name=parents_stok_data]').val();
		deval = JSON.parse(deval);
		formStok = `
		<div class="form-group row init-parent-stock">
			<label class="col-form-label col-md-2">Harga Pokok</label>
			<div class="col-md-10">
				<input value="`+deval.harga_pokok+`" type="text" name="harga_pokok" class="form-control">
			</div>
		</div>
		<div class="form-group row init-parent-stock">
			<label class="col-form-label col-md-2">Harga Jual</label>
			<div class="col-md-10">
				<input value="`+deval.harga_jual+`" type="text" name="harga_jual" class="form-control">
			</div>
		</div>
		<div class="form-group row init-parent-stock">
			<label class="col-form-label col-md-2">Stok</label>
			<div class="col-md-10">
				<input value="`+deval.stok+`" type="text" name="stok" class="form-control">
			</div>
		</div>
		`;
		if($('.init-parent-stock').length == 0) $(formStok).insertBefore($('button#addVariBtn').parents('.form-group'));
	}else if(formVariant.length > 0){
		$('.init-parent-stock').remove();
	}
};


function initTableVariant(){
	allPil = [];
	tbody = [];
	let th = [];

	let elemTable = $('.variant-box > .data-table > table#variant-table');
	
	let formVariant = $('.form-variant');
	// console.log(formVariant);
	if(formVariant.length > 0) $.map(formVariant, function(item, index) {
		// table header:
		let values = $(item).find('input.nama-variant').val();
		if(values.length == 0) values = 'Variasi';
		th.push('<th class="t-c-v-'+$(item).attr('data-index')+'">'+values+'</th>');

		// table body:
		let pils  = $(item).find('input.pilihan-variant');
		let pilArr = [];
		if(pils.length > 0) $.map(pils, function(pil) {
			// return something;
			pilArr.push({id:$(pil).attr('data-index'), value:$(pil).val()});
		});

		tbody.push( {id:$(item).attr('data-index'), value: values, pil: pilArr})
		
	});
	// $('textarea[name=variants_data]').val(JSON.stringify(tbody));
	// console.log(tbody);
	
	let thCapt = '';
	let bodyCapt = '';
	if(th.length > 0) th.forEach( function(element, index) {
		// statements
		// console.log(element.length)
		thCapt += element;
		
	});
	
	if(tbody.length > 0){
			let len_tbody = tbody.length;

			if(len_tbody > 0 ) bodyCapt = generateVariant();
			
		}

	
	thCapt += '<th>Harga Pokok</th><th>Harga Jual</th><th>Stok</th><th>Kode Variasi</th>';

	if(elemTable.length == 0) $(`
		<h4 class="text-md text-bold">Daftar Variasi</h4>
		<table id="variant-table" class="table btale-sm table-bordered table-condensed">
			<thead>
				<tr></tr>
			</thead>
			<tbody>
				<tr><td rowspan=3>test</td></tr>
				<tr><td>test1</td></tr>
				<tr><td>test2</td></tr>
			</tbody>
		</table>
		`).appendTo('.variant-box .data-table');

	$('table#variant-table > thead > tr').html(thCapt);
	$('table#variant-table > tbody').html(bodyCapt);
	

	$('input.nama-variant').unbind('keyup').on('keyup',function(){
		$('table#variant-table > thead > tr > th.t-c-v-'+$(this).parents('.form-variant').data('index')).text($(this).val())
	})
	$('input.pilihan-variant').unbind('keyup').on('keyup',function(){
		$('table#variant-table > tbody > tr > td.pil-'+$(this).parents('.form-variant').data('index')+'-'+$(this).data('index')).text($(this).val())
	})
}


// for table variant
// ./for table variant
function generateVariant(){
	let bodyCapt;
	let ge = new genVariant(tbody,0);
	let len = tbody.length;
	// console.log(ge.curr);
	let res = ge.curr.results;
	// console.log(res);
	let curIndex = 0;
	let def = $('textarea[name=variants_define]').val();
	let defParse;
	if(def.length > 0) defParse = JSON.parse(def);

	$.map(res, function(item, index) {
		let pil = item.rows
		$.map(pil, function(p) {
			join_pil = p.id;
			let addTd;

			let defal;
			let defal_data;
			if(typeof defParse !== 'undefined') defal = defParse.find(el => el.pil === join_pil.replace(/\+|\-/ig, ','));
			if(typeof defal !== 'undefined') {
				// console.log( typeof defal);
				if(typeof defal.data !== 'undefined') defal_data = defal.data
			};

			if(0 == len-1) addTd = `
				<td>
					<textarea class="d-none" name="join_pil[]">`+join_pil+`</textarea>
					<input value="`+(typeof defal_data !== 'undefined' ? defal_data.harga_pokok : ``)+`" name="harga_pokok[]" type="text" data-parsley-required="true" placeholder="Rp.0">
				</td>
				<td><input value="`+(typeof defal_data !== 'undefined' ? defal_data.harga_jual : ``)+`" name="harga_jual[]" type="text" data-parsley-required="true" placeholder="Rp.0"></td>
				<td><input value="`+(typeof defal_data !== 'undefined' ? defal_data.stok : ``)+`" name="stok[]" type="text" data-parsley-required="true" placeholder="0"></td>
				<td><input value="`+(typeof defal_data !== 'undefined' ? defal_data.kode : ``)+`" name="kode_variasi[]" type="text" data-parsley-required="true" placeholder="Masukkan kode"></td>
			`;

			bodyCapt += `<tr class="`+join_pil+`"><td `+(item.rowspan > 1 ? `rowspan="`+(item.rowspan)+`"` : '')+` class="pil-`+item.id+`-`+p.id+`">`+p.value+`</td>`+(typeof addTd != 'undefined' ? addTd : '')+`</tr>`;
			if(curIndex + 1 < len) bodyCapt += next(curIndex + 1, join_pil);
		})
	});

	return bodyCapt;
}


function next(idx, par){
	// console.log(par)
	let bodyCapt;
	let ge = new genVariant(tbody,idx);
	let len = tbody.length;
	let res = ge.curr.results;
	// console.log(res);
	let curIndex = idx;

	let def = $('textarea[name=variants_define]').val();
	let defParse;
	if(def.length > 0) defParse = JSON.parse(def);

	$.map(res, function(item, index) {
		let pil = item.rows
		$.map(pil, function(p) {
			let join_pil = par+'-'+p.id;
			let addTd;
			let defal;
			let defal_data;
			if(typeof defParse !== 'undefined') defal = defParse.find(el => el.pil === join_pil.replace(/\+|\-/ig, ','));
			if(typeof defal !== 'undefined') {
				// console.log(defal.data);
				if(typeof defal.data !== 'undefined') defal_data = defal.data
			};
			// console.log(defal);
			if(idx == len-1) addTd = `
				<td>
					<textarea class="d-none" name="join_pil[]">`+join_pil+`</textarea>
					<input value="`+(typeof defal_data !== 'undefined' ? defal_data.harga_pokok : ``)+`" name="harga_pokok[]" type="text" data-parsley-required="true" placeholder="Rp.0">
				</td>
				<td><input value="`+(typeof defal_data !== 'undefined' ? defal_data.harga_jual : ``)+`" name="harga_jual[]" type="text" data-parsley-required="true" placeholder="Rp.0"></td>
				<td><input value="`+(typeof defal_data !== 'undefined' ? defal_data.stok : ``)+`" name="stok[]" type="text" data-parsley-required="true" placeholder="0"></td>
				<td><input value="`+(typeof defal_data !== 'undefined' ? defal_data.kode : ``)+`" name="kode_variasi[]" type="text" data-parsley-required="true" placeholder="Masukkan kode"></td>
			`;
			bodyCapt += `<tr class="`+join_pil+`"><td `+(item.rowspan > 1 ? `rowspan="`+(item.rowspan)+`"` : '')+` class="pil-`+item.id+`-`+p.id+`">`+p.value+`</td>`+(typeof addTd != 'undefined' ? addTd : '')+`</tr>`;
			if(curIndex + 1 < len) bodyCapt += next(curIndex + 1, join_pil);
		})
	});

	return bodyCapt;
}




class genVariant {
    constructor(data, idx) {
        this.data = data;
        this.idx = idx;
        this.res = data[idx];
        this.len = data.length;
        this.rowspan = 1;
        this.results = [];
        
    }

    get curr(){
    	if(this.idx + 1 < this.len ) this.rowspan += this.data[this.idx+1].pil.length;  // 3 level is ok
    	if(this.idx + 1 < this.len) this.getRows(this.idx + 1);
    	 	
    	this.results.push({
    		index : this.idx,
    		id : this.res.id,
    		rows : this.res.pil,
    		rowspan: this.rowspan
    	});    	

    	let self = {
    		results : this.results,
    	};

    	return self;
    }

    getRows(idx){
    	if(idx + 1 < this.len) this.rowspan += (this.data[idx + 1].pil.length * this.data[idx].pil.length); //3 level is ok
    	// if(idx > 0 && idx < this.len) this.rowspan += this.data[idx-1].pil.length;
    	if(idx + 1 < this.len) this.getRows(idx+1);
    	
    }
 
}


