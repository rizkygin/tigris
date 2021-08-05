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
					listOpsi +=`<div class="offset-6 col-6 input-group input-group-sm ops-value index-`+index+`">
					<input name=opsi[`+index+`] value="`+item+`" class="form-control form-control-sm m-b-5">
					</div>`;
				});
				$('.opsi').html(listOpsi);
				addingRemoveBtn();
				// btnSubHandler();
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
		$('.opsi').append(`<div class="offset-6 col-6 input-group input-group-sm ops-value index-`+opsNum+`">
			<input name=opsi[`+opsNum+`] value="`+ops+`" class="form-control form-control-sm m-b-5">
			</div>`);
		addingRemoveBtn();
		// btnSubHandler();
		modal.modal('hide');
		// console.log($('.ops-value'));

	});

	$('select[name=tipe]').on('change', function(){
		initTipe();
	});
	
})

function addingRemoveBtn(){
	// console.log($('.ops-value .input-group-append > button > i.fas.fa-times'));
	$('.ops-value .input-group-append > button > i.fas.fa-times').parent().remove();
	$('.ops-value:last').append(`
		<div class="input-group-append">
		<button type="button" class="btn btn-xs remove-ops text-danger" type="button"><i class="fas fa-times"></i></button>
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

function btnSubHandler(){
	$(function(){
		$('.btn-sub').unbind('click').on('click', function(res){
			// console.log('helooo');
			let btn = $(this);
			let numb = $('.input-sub-'+btn.data('tingkat')+'-'+btn.data('index')).length + 1;

			if($('ul.elem-sub-'+btn.data('tingkat')+'-'+btn.data('index')).length == 0) $(`<ul class="elem-sub-`+btn.data('tingkat')+`-`+btn.data('index')+`" style="margin-left:`+(btn.data('tingkat')+5)+`"></ul>`).insertAfter(btn.parents('.input-group')).last();
			$('ul.elem-sub-'+btn.data('tingkat')+'-'+btn.data('index')).append(`
				<li input-sub-`+btn.data('tingkat')+`-`+numb+`>
					<div class=input-group input-group-sm">
					<input name=sub[] class="form-control form-control-sm m-b-5">
						<span class="input-group-append"><button data-index="`+numb+`" data-tingkat=`+(btn.data('tingkat')+1)+` type="button" class="btn-sub btn btn-xs"><i class="fa fa-plus"></i> Sub</button></span>
					</div>
				</li>
				`);
			btnSubHandler();
		})
	})
}

