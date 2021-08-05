'use strict';
$(document).ready(function(){
	initTipe();
});

function initTipe(){
	var tipe = $('select[name=tipe]').val();
	if(tipe == 4){
		let formIsi = $('#form-pilihan').html();
		// console.log(formIsi);
		if(formIsi == undefined) $('form .form-group:last').after(`
			<div id="form-pilihan" class="row m-b-10">
				<div class="col-12">
					<div class="form-group">
						<div class="opsi"></div>
						<button data-toggle="modal" data-target="#modal-pilihan" type="button" class="btn btn-xs btn-primary float-right m-b-5 m-r-15"><i class="fas fa-plus"></i> Pilihan</button>
					</div>
				</div>
			</div>
			`);
			let defineOpsi = $('textarea[name=isi]').val();
		// console.log(defineOpsi)
		if(IsJsonString(defineOpsi)){
			defineOpsi = $.parseJSON(defineOpsi);
			// console.log(defineOpsi);
			if(Object.keys(defineOpsi).length > 0){
				let listOpsi = '';
				$.map(defineOpsi, function(item, index) {
					listOpsi +=`<div class="offset-4 col-8 input-group input-group-sm ops-value">
						<input name=opsi[`+index+`] value="`+item+`" class="form-control form-control-sm m-b-5">
						</div>`;
				});
				$('.opsi').html(listOpsi);
				addingRemoveBtn();
			}
		}
		
	}else{
		$('#form-pilihan').remove();
	}
}

$(function(){
	const modal= $('#modal-pilihan');
	modal.find('.submit-modal').on('click',function(){
		// alert('submit');
		let ops = modal.find('#modal-ops').val();
		let opsNum = $('.ops-value').length+1;
		$('.opsi').append(`<div class="offset-4 col-8 input-group input-group-sm ops-value">
			<input name=opsi[`+opsNum+`] value="`+ops+`" class="form-control form-control-sm m-b-5">
			</div>`);
		addingRemoveBtn();
		modal.modal('hide');
		// console.log($('.ops-value'));

	});

	$('select[name=tipe]').on('change', function(){
		initTipe();
	});
	
})

function addingRemoveBtn(){
	$('.ops-value .input-group-append').remove();
	$('.ops-value:last').append(`
		<div class="input-group-append">
		<button class="btn btn-xs btn-danger remove-ops" type="button"><i class="fas fa-times"></i></button>
		</div>
		`);
	$('.ops-value .remove-ops').on('click',function(){
		// $(elm).remove();
		$(this).parents('.ops-value').remove();
		addingRemoveBtn();
	})
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
