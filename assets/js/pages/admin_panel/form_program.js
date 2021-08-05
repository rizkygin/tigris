
$(document).ready(function() {
	addDataTable();
	$(function(){
		global_select('scan-input', {}, 'addDataTable', true);
	})
});


function addDataTable(){
	$('.scan-input').val(null).trigger('change');
	var tableDiv= $('#table-data');
	let scan= $('#scan-input');
	// if(typeof scan == 'object'){
		let define = isJson($('textarea[name=json_detail]').val()) ? JSON.parse($('textarea[name=json_detail]').val()) : false;
			// console.log(define);
		let pro;
		if(define) {
			pro = define;
		}
		if(isJson(scan.attr('data-select'))) pro = [JSON.parse(scan.attr('data-select'))];
		// console.log(pro)

		if(pro){
			$.map(pro, function(item, index) {
				if($('table > tbody > tr#'+item.id).length == 0) $(`
				<tr id="`+item.id+`">
				<td>
					<input type="hidden" name="prods[]" value="`+item.id+`">
					<button type="button" class="btn btn-sm btn-remove-produk"><i class="fa fa-trash text-danger"></i></button>
					</td>
					<td>`+item.produk+`</td>
					<td>`+item.variant+`</td>
				</tr>
				`).appendTo(tableDiv.find('tbody'));
			});
			

			$(function(){
				$('.btn-remove-produk').unbind('click').on('click', function(){
					$(this).parents('tr').remove();
				})
			})
		}
		
	// }

}


