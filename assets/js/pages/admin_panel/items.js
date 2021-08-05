// list
'use strict';
Cookies.set('id_kategori');

let ajaxProc= false;
let table = $('#list-ajax');

function list(params){
	params = params || {};
    let table = $('#list-ajax'); //kalo pakai variabel 'table' yang atas, pas update jadi blank;
    if(ajaxProc) return;
    ajaxProc = true;

    let page = params.page || 1;
    let q = $('input[name=q]').val();
    let listUrl = table.data('list');
    let param1 = table.data('param1');
    let useAttr = table.data('useattr');
    let addParam = params.addParam || null;

    // getdata attr and store to addParam:
    let dataSetting = table.data();

    let req = {page:page,q:q, param1:param1, add_param: addParam, data_setting: dataSetting};
    // let attrSet = table.data('attr-set');
    // let attr = table.data('attr-set');
    let thAttr = $('.th-attr');
    $.ajax({
    	url: table.data('url')+'/'+ (listUrl != undefined ? listUrl : 'listdata'),
    	method: "GET",
    	dataType: "JSON",
    	data: req,
    	beforeSend: function(){
    		table.find('tbody').children().remove();
    		$('.loading-table').removeClass('hide');
    	},
    	success: function(res){
    		let koloms;
    		$('.loading-table').addClass('hide');
    		table.find('tbody').children().remove();
    		if(res.status=='success'){
    			const {result,offset,total,limit} = res;
    			let {page} = res; 
    			let no=1+offset;
    			if(typeof res.koloms !== 'undefined') koloms = res.koloms;
    			else koloms  = table.data('kolom');
                // console.log(table.data('kolom'));
                // console.log(koloms);
                var rd;
                let dataIds = [], attrCode = table.data('attrcode');

                $.each(result,function(idx, item){
                        // console.log(item.child);
                        let par_aksi = {
                        	'id':item.id
                        };
                        let kolom =null;

                        $.map(koloms, function(kol, ind) {
                        	// console.log(kol) ;
                            // console.log(typeof kol);
                            if(typeof kol == 'object') kolom +=`<td class="data-`+item.id+` data-kolom `+(kol.class ? kol.class : '')+`">`+item[kol.field]+`</td>`;
                            else kolom +=`<td class="data-`+item.id+` data-kolom">`+item[kol]+`</td>`;
                        });

                        // attribut
                        let kolomAttr = null;
                        $.map(thAttr, function(th, ith) {
                            // return something;
                            kolomAttr += `<td id="attr-data-`+$(th).data('attr-set')+`-`+$(th).data('attr')+`-`+item.id+`"></td>`;
                        });
                        // ./attribut

                        // update & delete
                        
                        if(item.param){
                        	let encode_par = item.param;
                        	rd = `<td style="white-space:nowrap;" class="no-print">
                        	<a href="`+table.data('url')+`/form/`+encode_par+`" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                        	<a href="`+table.data('url')+`/remove/`+encode_par+`" data-act="hapus" class="btn btn-xs btn-danger" data-target="#modal-message" data-toggle="modal"><i class="fa fa-trash"></i></button>
                        	</td>`;
                        }
                        

                        table.find('tbody').append(`
                        	<tr id=`+item.id+`>
                        	<td>`+(item.child ? '' : '<input type="checkbox" value="'+item.id+'"/>')+`</td>
                        	<td>`+no+`</td>
                        	`+kolom+`
                        	`+kolomAttr+`
                        	`+rd+`
                        	</tr>
                        	`);
                        no++;

                        if(useAttr) dataIds.push(item.id);
                        if(item.child) subdata(item.id);
                    });

                if(useAttr) getAttrValues(dataIds, attrCode);
                let params = {
                	func:'list',
                	total:total,
                	limit:limit,
                	curr:page,
                	komp:$('#box-data'),
                	param:{
                		addParam: addParam
                	},

                }

                let pag = new Paginate(params);
                pag.init();
                    // let pag = new Pagination('list', total, limit, page);
				    // pag.init();

				}else if(res.status=='failed'){
					table.find('tbody').children().remove();
				}
				ajaxProc = false;
			}
		});

    $(function(){
    	$('input[name=q]').unbind('keyup').on('keyup', function(){
    		list({addParam: addParam});
    	});
    	// checked item
		$('input[type=checkbox]').unbind('click').on('click', function(){
			// alert('kliket');
		})
		// ./checked item
    })
}

function subdata(parent, page){
	page = page || 1;
	$.ajax({
		url: $('input[name=site_url]').val()+'/admin_panel/items/subdata',
		type: 'GET',
		dataType: 'json',
		data: {parent: parent, page: page},
		// async: false,
		success: function(res){
			// console.log(res);
			
			if(res.status == 'success'){
				let koloms;
				if(typeof res.koloms !== 'undefined') koloms = res.koloms;
    			else koloms  = table.data('kolom');
    			let no = 1 + res.offset;
				$.map(res.result, function(item) {
					let kolom = '<td><input type="checkbox" value="'+item.id+'"/></td>';
					// return something;
					$.map(koloms, function(kol, ind) {
						// console.log(kol);
						let colspan;
						if(ind == 0) colspan = 'colspan="2"';
						else if(ind == 1) colspan = 'colspan="4"';
						else if(ind == 10) colspan = 'colspan="2"';
						else colspan='';
						// if(typeof item[kol] !== 'undefined') {
							if(typeof kol == 'object' && item[kol.field] !== 'undefined') kolom +=`<td `+colspan+` class="data-`+item.id+` data-kolom `+(kol.class ? kol.class : '')+`">`+item[kol.field]+`</td>`;
						    else if(typeof item[kol] !== 'undefined') kolom +=`<td `+colspan+` class="data-`+item.id+` data-kolom">`+item[kol]+`</td>`;
						                      // }
					});

					let lastRecord = table.find('tr.variant-'+parent).last();
					if(lastRecord.length == 0) table.find('tr#'+parent).after('<tr class="variant-'+parent+'">'+kolom+'</tr>');
					else lastRecord.after('<tr class="variant-'+parent+'">'+kolom+'</tr>');
					no++;
				});

				if(res.more_page) subdata(parent, page + 1);
				
			}
		}
	})
		// return self;
		$(function(){
			// checked item
			$('input[type=checkbox]').unbind('click').on('click', function(){
				// alert('kliket');
			})
			// ./checked item
		})
};

	function getAttrValues(ids, code){
    // console.log(ids);
    $.ajax({
    	url: $('input[name=site_url]').val()+'ajax/request/attr_values',
    	type: 'GET',
    	dataType: 'json',
    	data: {data_ids: ids, code:code},
    })
    .done(function(res) {
        // console.log(res);
        if(res.status == 'success'){
        	const{result} = res;
            // let tdHtml = '';
            $.map(result, function(item, index) {
            	$('#attr-data-'+item.id_attr_set+'-'+item.id_attr+'-'+item.id_data).html( item.longval ? '<a title="klik untuk detail..." data-act="detail-kolom" data-toggle="modal" data-target="#modal-message" class="use-tooltip">'+item.longval+'...<textarea class="full-html" style="display:none;">'+item.values+'</textarea></a>' : item.values );
            });

        }
    });
    
}


// ./list



$(document).ready(function() {
	table.find('thead').after(`<tbody></tbody>`);
	table.addClass('table-sm');
	showFilter();
	if(Cookies && Cookies.get('id_kategori')) {
		if(Cookies.get('id_kategori') !== 'undefined') list({addParam:JSON.stringify({id_kategori: Cookies.get('id_kategori')})});
		// console.log('haii')
		$('#items-filter').addClass('show');
	}
	
	if(Cookies && Cookies.get('id_kategori')) console.log(Cookies.get('id_kategori'));
	$(function(){
		$('#cetak-barcode').on('click', function(){
			let ck = $('input[type=checkbox]:checked');
			// console.log(ck);
			let itemIds = [];
			if(ck.length > 0) $.map(ck, function(el) {
				// return something;
				// console.log($(el).val());
				itemIds.push($(el).val());
			});
				// console.log(itemIds);
			// alert('helooo');
			if(itemIds.length > 0) window.location.href = $('input[name=site_url]').val()+'admin_panel/items/generate_barcodes/'+itemIds.join(':');
		})
	})
});


$(function(){

	table.find('tbody').ready(function(){
		list();
		$('.btn-print').on('click', function(){
			printReport('cetak-area');
			return false;
		});
	});

	$('#modal-message').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var event = button.data('event') // Extract info from data-* attributes
	  var modal = $(this);
	  // console.log(event);
	  if(event == 'img-slider'){
	  	let images = button.data('images');
	  	let src = images.split(",");
	  	let imgDiv ='';
	  	let liDiv ='';
	  	$.map(src, function(item, index) {
	  		// return something;
	  		// console.log(item);
	  		liDiv += `
	  		<li data-target="#carouselExampleIndicators" data-slide-to="`+index+`" class="`+(index == 0 ? `active`: '')+`"></li>
	  		`;
	  		imgDiv += `<div class="carousel-item `+(index == 0 ? `active`: '')+`">
	  		<img class="h-75 d-block w-45 img-responsive mx-auto" src="`+$('input[name=base_url]').val()+`uploads/items/`+item+`" alt="`+index+` slide">
	  		</div>`;
	  	});
	  	modal.find('.modal-body').html(`
	  		<div id="carouselExampleIndicators" class="carousel slide bg-dark" data-ride="carousel">
	  		<ol class="carousel-indicators">
	  		`+liDiv+`
	  		</ol>
	  		<div class="carousel-inner">
	  		`+imgDiv+`			    
	  		</div>
	  		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	  		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	  		<span class="sr-only">Previous</span>
	  		</a>
	  		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	  		<span class="carousel-control-next-icon" aria-hidden="true"></span>
	  		<span class="sr-only">Next</span>
	  		</a>
	  		</div>
	  		`);
	  	modal.find('.modal-body').addClass('h-auto');
	  	modal.find('.modal-title').text('Photo Item Barang');
	  	// modal.find('.modal-body').html(riwayatHtml)
	  	modal.find('.modal-footer .submit-modal').addClass('d-none');
	  } else if(event == 'riwayat'){
	  	let url = button.attr('href');
	  	let idItems = button.data('id');
	  	let riwayatHtml = modal.find('.modal-body .riwayat-items');
	  	if(riwayatHtml.length == 0) modal.find('.modal-body').html(`
	  		<div class="riwayat-items">
	  		<table class="table table-sm table-bordered table-condensed">
	  		<thead>
	  		<tr>
	  		<th>#</th>
	  		<th>Tanggal</th>
	  		<th>+/- Stok</th>
	  		<th>Total Harga</th>
	  		<th>Keterangan</th>
	  		</tr>
	  		</thead>
	  		<tbody>

	  		</tbody>
	  		</table>

	  		<footer class="footer-content bg-silver">
	  		<div class="pull-left">
	  		<div class="text-inverse f-w-400 total-pagination"></div>
	  		</div>
	  		<div class="pull-right no-padding">
	  		<ul class="pagination pagination-sm m-t-0 m-b-0"></ul>
	  		</div>
	  		<div class="clearfix"></div>
	  		</footer>
	  		</div>
	  		`);

	  		getItemsRiw({url:url, id: idItems});

	  	modal.find('.modal-title').text('Riwayat Inventori Item barang')
	  	// modal.find('.modal-body').html(riwayatHtml)
	  	modal.find('.modal-footer .submit-modal').addClass('d-none');
	  }else if(event == 'items-detail'){
	  	modal.find('.modal-title').text('Detal Item Barang');
	  	// modal.find('.modal-body').html(riwayatHtml)
	  	modal.find('.modal-footer .submit-modal').addClass('d-none');

	  	let url = button.attr('href');
	  	let idItems = button.data('id');
	  	/*
	  	let contentHtml = modal.find('.modal-body .items-detail');
	  	if(contentHtml.length == 0) modal.find('.modal-body').html(`
	  		<div class="items-detail">
	  		
	  		</div>
	  		`);
	  		*/
	  		getItemsDetail(url,idItems);
	  	}else if(event == 'trans-masuk'){
	  		let url = button.attr('href');
	  		let idItems = button.data('id');
	  		let riwayatHtml = modal.find('.modal-body .trans-masuk');
	  		if(riwayatHtml.length == 0) modal.find('.modal-body').html(`
	  			<div class="trans-masuk">
	  			<table class="table table-sm table-bordered table-condensed">
	  			<thead>
	  			<tr>
	  			<th>#</th>
	  			<th>Tanggal</th>
	  			<th>Kode Transaksi</th>
	  			<th>Jumlah</th>
	  			<th>Harga Beli</th>
	  			<th>Pemasok</th>
	  			</thead>
	  			<tbody>

	  			</tbody>
	  			</table>

	  			<footer class="footer-content bg-silver">
	  			<div class="pull-left">
	  			<div class="text-inverse f-w-400 total-pagination"></div>
	  			</div>
	  			<div class="pull-right no-padding">
	  			<ul class="pagination pagination-sm m-t-0 m-b-0"></ul>
	  			</div>
	  			<div class="clearfix"></div>
	  			</footer>
	  			</div>
	  			`);
	  			modal.find('.modal-title').text('Riwayat Harga Penerimaan')
	  		// modal.find('.modal-body').html(riwayatHtml)
	  		modal.find('.modal-footer .submit-modal').addClass('d-none');
	  		getTransMasuk({url:url, id: idItems});
	  	}



	  })

$('#modal-message').on('hide.bs.modal', function (event) {
	var modal = $(this);
	modal.find('.modal-body').html('');
	modal.find('.modal-footer .submit-modal').removeClass('d-none');
})
})

function getTransMasuk(params){
	// console.log(params);
	params = params || {};
	if(ajaxProc) return;
	ajaxProc = true;
	let page = params.page || 1;
	let idItems = params.id;
	let modal = $('#modal-message');
	let table = modal.find('.modal-body table');
	// let params = params;
	if(table.find('tbody').length == 0) table.append(`<tbody></tbody>`);
	$.ajax({
		// url: $('input[name=site_url]').val()+'/admin_panel/items/riwayat',
		url: params.url,
		method: "GET",
		dataType: "JSON",
		data: {page:page,id:idItems},
		beforeSend: function(){
			table.find('tbody').children().remove();
		},
		success: function(res){
			// console.log(res)
			table.find('tbody').children().remove();
			if(res.status=='success'){
				const {result,offset,total,limit} = res;
				let {page} = res; 
				let no=1+offset;
				$.each(result,function(idx, item){

					table.find('tbody').append(`
						<tr>
						<td>`+no+`</td>
						<td>`+item.record+`</td>
						<td>`+item.kode+`</td>
						<td>`+item.jumlah+`</td>
						<td>`+item.harga_pokok+`</td>
						<td>`+item.pemasok+`</td>
						</tr>
						`);
					no++;
				});

				let paramsPage = {
					func:'getTransMasuk',
					total:total,
					limit:limit,
					curr:page,
					komp:modal,
					param:{
						url:params.url,
						id:idItems
					}
				}
				let pag = new Paginate(paramsPage);
				pag.init();

			}else if(res.status=='failed'){
				table.find('tbody').children().remove();
			}
			ajaxProc = false;
		}
	});
	
}

function getItemsDetail(url,id){
	$.ajax({
		url: url,
		method: "GET",
		dataType: "JSON",
		data: {id:id},
	})
	.done(function(res) {
		// console.log(res);
		const{status} = res;
		if(status == 'success'){
			const {results} = res;
			// console.log(results);
			let htmlContent = '<ul class="list-group list-group-flush detail-items">';
			// $.map(results, function(item, index) {
				// return something;
				htmlContent += `<li class="list-group-item p-2"><span class="text-muted">Kode:</span> `+results.kode+`</li>`;
				htmlContent += `<li class="list-group-item p-2"><span class="text-muted">Nama:</span> `+results.nama+`</li>`;
				if(!results.child) htmlContent += `<li class="list-group-item p-2"><span class="text-muted">Harga Pokok:</span> `+results.harga_pokok+`</li>`;
				if(!results.child) htmlContent += `<li class="list-group-item p-2"><span class="text-muted">Harga Jual:</span> `+results.harga_jual+`</li>`;
				if(!results.child) htmlContent += `<li class="list-group-item p-2"><span class="text-muted">Stok:</span> `+results.stok+`</li>`;
				htmlContent += `<li class="list-group-item p-2"><span class="text-muted">Deskripsi</span> `+results.deskripsi+`</li>`;
			// });
			htmlContent += '</ul>';
			let modal = $('#modal-message');
			modal.find('.modal-body').html(htmlContent);

			let itemAttrData = results.json_items_attr;
				// let setHtml = '';
				if(itemAttrData !== null) $.map(itemAttrData, function(at, iat) {
					let setHtml = `<li class="list-group-item m-t-5 set-`+at.id_attr_set+`">
					`+at.attr_set+`
					<ul class="list-group list-group-flush"></ul>
					</li>`;
					if(modal.find('.modal-body ul.detail-items > li.set-'+at.id_attr_set).length == 0) modal.find('.modal-body > ul.detail-items').append(setHtml);
					let dataHtml = `<li class="list-group-item p-2 set-`+at.id_attr_set+`-data-`+at.id_values+`">
					<span class="text-muted">`+at.attr+`</span>: `+at.isi+`</li>`;
					if(modal.find('.modal-body ul.detail-items > li.set-'+at.id_attr_set+' > ul > li.set'+at.id_attr_set+'-data-'+at.id_values).length == 0) modal.find('.modal-body ul.detail-items > li.set-'+at.id_attr_set+' > ul').append(dataHtml);

				});
			}

		})
	
}

function getItemsRiw(params){
	// console.log(params);
	params = params || {};
	if(ajaxProc) return;
	ajaxProc = true;
	let page = params.page || 1;
	let idItems = params.id;
	let modal = $('#modal-message');
	let table = modal.find('.modal-body table');
	// let params = params;
	if(table.find('tbody').length == 0) table.append(`<tbody></tbody>`);
	$.ajax({
		// url: $('input[name=site_url]').val()+'/admin_panel/items/riwayat',
		url: params.url,
		method: "GET",
		dataType: "JSON",
		data: {page:page,id:idItems},
		beforeSend: function(){
			table.find('tbody').children().remove();
		},
		success: function(res){

			table.find('tbody').children().remove();
			if(res.status=='success'){
				const {result,offset,total,limit} = res;
				let {page} = res; 
				let no=1+offset;
				$.each(result,function(idx, item){

					table.find('tbody').append(`
						<tr>
						<td>`+no+`</td>
						<td>`+item.record+`</td>
						<td>`+item.new_stok+`</td>
						<td>`+item.total_harga+`</td>
						<td>`+item.keterangan+`</td>
						</tr>
						`);
					no++;
				});

				let paramsPage = {
					func:'getItemsRiw',
					total:total,
					limit:limit,
					curr:page,
					komp:modal,
					param:{
						url:params.url,
						id:idItems
					}
				}
				let pag = new Paginate(paramsPage);
				pag.init();

			}else if(res.status=='failed'){
				table.find('tbody').children().remove();
			}
			ajaxProc = false;
		}
	});

}


function showFilter(par){
	par = par || {};
	let page = par.page || 1;
	let parent = par.parent || 0;
	let boxFilter = $('#items-filter');
	if(boxFilter.length == 0) $(`
		<div id="items-filter" class="collapse">
		<div id="jstree-default">
		<ul class="top">
		<li data-jstree='{ `+(Cookies && Cookies.get('id_kategori') == 'undefined' ? '"opened":true, "selected":true' : '')+` }'><a href="#" data-id="">Semua Kategori</a></li>
		</ul>
		</div>
		</div>
		`).appendTo($('.card-header')[0]);

		var ktgParents = function(){
			let self = {status: 'failed'};
			$.ajax({
				url: $('input[name=site_url]').val()+'ajax/request/items_kategori',
				type: 'GET',
				dataType: 'json',
				data: {parent:parent, page:page, limit:5},
				async:false
			})
			.done(function(res) {
			// console.log(res);
			if(res.status == 'success') self = res;
		});
			return self
		}();

		if(Object.keys(ktgParents).length > 0){
			let {status, pagination} = ktgParents;
			let currPage = ktgParents.page;
		// console.log(ktgParents.status);
		// console.log(status);
		if(status == 'success'){
			$.map(ktgParents.results, function(item, index) {
				// return something;
				// console.log(item);

				let dataTree = ``;
				let totalBadge = item.items;
				if(item.child) dataTree = `"disabled":true`;
				if(Cookies && Cookies.get('id_kategori')){
					if(Cookies.get('id_kategori')==item.id) dataTree =`"opened":true, "selected":true`;
				}
				let ktgHtml = `<li id="ktg-`+item.id+`" data-jstree='{`+dataTree+`}' data-items="`+item.items+`" data-parent="`+item.parent+`" data-id="`+item.id+`"><a href="#" data-id="`+item.id+`">`+item.text+` <span class="total-bage-`+item.id+` badge bg-green">`+item.items+`</span></a>`+(item.child ? `<ul></ul>` : '')+`</li>
				`;
				// console.log(parseInt(item.parent));
				if(item.parent > 0) $('li#ktg-'+parent+' > ul').append(ktgHtml); else $('div#jstree-default > ul.top').append(ktgHtml);
				// console.log(innerToBd);
				
				if(item.child) showFilter({parent:item.id});
			});

		// TreeView.init();

		$(function(){
			$('#jstree-default').jstree({
				"core": {
					"themes": {
						"responsive": false
					}            
				},
				"types": {
					"default": {
						"icon": "fa fa-tags text-warning fa-lg"
					},
					"file": {
						"icon": "fa fa-file text-inverse fa-lg"
					}
				},
				"plugins": ["types"]
			});
			
			$('#jstree-default').unbind('select_node.jstree').on('select_node.jstree', function(e,data) { 
				// console.log(e);
				// console.log(data);
				var link = $('#' + data.selected).find('a');
				let idSelected = link.data("id");
						// console.log(idSelected);
						Cookies.set('id_kategori', idSelected);

						list({addParam:JSON.stringify({id_kategori: idSelected})});
						return false;
					});

			$('#jstree-default').jstree(true).refresh();
			// $('li#ktg-'+Cookies.get('id_kategori')).find('a').click();
		})
		
		if(pagination.more) showFilter({page:currPage+1, parent: parent});
		// console.log(currPage+1);
	}

}
	// if(ktgParents)
	// console.log(ktgParents);
	// pushFilterData();
	// TreeView.init();
}

