'use strict';

$(document).ready(function() {

});


$(function(){
	$('#modal-message').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var event = button.data('event') // Extract info from data-* attributes
	  var modal = $(this);
	  // console.log(event);
	  if(event == 'detail'){
	  	let url = button.attr('href');
	  	let id = button.data('id');
	  	let riwayatHtml = modal.find('.modal-body .riwayat-items');
	  	if(riwayatHtml.length == 0) modal.find('.modal-body').html(`
	  		<div class="riwayat-items">
	  		<table class="table table-sm table-bordered table-condensed">
	  		<thead>
	  		<tr>
	  		<th>#</th>
	  		<th>produk</th>
	  		<th>Variant</th>
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

	  		getDetail({url:url, id: id});

	  	modal.find('.modal-title').text('Riwayat Inventori Item barang')
	  	// modal.find('.modal-body').html(riwayatHtml)
	  	modal.find('.modal-footer .submit-modal').addClass('d-none');
	  }

	})

	$('#modal-message').on('hide.bs.modal', function (event) {
		var modal = $(this);
		modal.find('.modal-body').html('');
		modal.find('.modal-footer .submit-modal').removeClass('d-none');
	})
})


function getDetail(params){
	// console.log(params);
	params = params || {};
	if(ajaxProc) return;
	ajaxProc = true;
	let page = params.page || 1;
	let id = params.id;
	let modal = $('#modal-message');
	let table = modal.find('.modal-body table');
	// let params = params;
	if(table.find('tbody').length == 0) table.append(`<tbody></tbody>`);
	$.ajax({
		// url: $('input[name=site_url]').val()+'/admin_panel/items/riwayat',
		url: params.url,
		method: "GET",
		dataType: "JSON",
		data: {page:page,id:id},
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
						<td>`+item.produk+`</td>
						<td>`+item.variant+`</td>
						</tr>
						`);
					no++;
				});

				let paramsPage = {
					func:'getDetail',
					total:total,
					limit:limit,
					curr:page,
					komp:modal,
					param:{
						url:params.url,
						id:id
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


