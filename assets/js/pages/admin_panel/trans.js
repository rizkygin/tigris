'use strict';
ajaxProc = false;

'use strict';
Cookies.set('trans_tipe');

ajaxProc = false;
$(document).ready(function() {
	showFilter();
	if(Cookies && Cookies.get('trans_tipe')) {
		if(Cookies.get('trans_tipe') !== 'undefined') list({addParam:JSON.stringify({trans_tipe: Cookies.get('trans_tipe')})});
		// console.log('haii')
		$('#items-filter').addClass('show');
	}
	
	if(Cookies && Cookies.get('trans_tipe')) console.log(Cookies.get('trans_tipe'));
});


function showFilter(par){
	let table = $('#list-ajax');
	par = par || {};
	let page = par.page || 1;
	let parent = par.parent || 0;
	let boxFilter = $('#items-filter');
	if(boxFilter.length == 0) $(`
		<div id="items-filter" class="collapse">
		<div id="jstree-default">
		<ul class="top">
		<li data-jstree='{ `+(Cookies && Cookies.get('trans_tipe') == 'undefined' ? '"opened":true, "selected":true' : '')+` }'><a href="#" data-id="">Semua Tipe</a></li>
		</ul>
		</div>
		</div>
		`).appendTo($('.card-header')[0]);

		var ktgParents = function(){
			let self = {status: 'failed'};
			$.ajax({
				url: $('input[name=site_url]').val()+'ajax/request/trans_tipe',
				type: 'GET',
				dataType: 'json',
				data: {parent:parent, page:page, limit:5, menu: table.data('menu')},
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
				let totalBadge = item.trans;
				if(item.child) dataTree = `"disabled":true`;
				if(Cookies && Cookies.get('trans_tipe')){
					if(Cookies.get('trans_tipe')==item.id) dataTree =`"opened":true, "selected":true`;
				}
				let ktgHtml = `<li id="ktg-`+item.id+`" data-jstree='{`+dataTree+`}' data-trans="`+item.trans+`" data-id="`+item.id+`"><a href="#" data-id="`+item.id+`">`+item.text+` <span class="total-bage-`+item.id+` badge bg-green">`+item.trans+`</span></a>`+(item.child ? `<ul></ul>` : '')+`</li>
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
						Cookies.set('trans_tipe', idSelected);

						list({addParam:JSON.stringify({trans_tipe: idSelected})});
						return false;
					});

			$('#jstree-default').jstree(true).refresh();
			// $('li#ktg-'+Cookies.get('trans_tipe')).find('a').click();
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



$(function(){
	$('#modal-message').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var event = button.data('event') // Extract info from data-* attributes
	  var modal = $(this);
	  // console.log(event);
	  if(event == 'detail-item'){
	  	let url = button.attr('href');
	  	let idItems = button.data('id');
	  	let riwayatHtml = modal.find('.modal-body .riwayat-items');
	  	if(riwayatHtml.length == 0) modal.find('.modal-body').html(`
	  		<div class="riwayat-items">
	  		<table class="table table-sm table-bordered table-condensed">
	  		<thead>
	  		<tr>
	  		<th>#</th>
	  		<th>Kode Barang</th>
	  		<th>Item</th>
	  		<th>Harga</th>
	  		<th>Jumlah</th>
	  		<th>Total</th>
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
	  	// getItemsDetail(url,idItems);
	  }



	})

	$('#modal-message').on('hide.bs.modal', function (event) {
		var modal = $(this);
		modal.find('.modal-body').html('');
		modal.find('.modal-footer .submit-modal').removeClass('d-none');
	})
})

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
						<td>`+item.kode+`</td>
						<td>`+item.nama+`</td>
						<td>`+item.harga+`</td>
						<td>`+item.jumlah+`</td>
						<td>`+item.total_harga+`</td>
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