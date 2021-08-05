'use strict';
$(document).ready(function() {
	loadCatMenu();
});

function loadCatMenu(page){
	page = page || 1;

	$.ajax({
		url: $('input[name=site_url]').val()+'/ajax/request/items_kategori',
		type: 'GET',
		dataType: 'JSON',
		data: {page: page},
	})
	.done(function(res) {
		// console.log(res);
		let catUl = $('#cat_menu');
		if(res.status == 'success') $.map(res.results, function(item, index) {
			// return something;
			let hsClass;
			if(item.child == true) hsClass = 'class="hassubs"'; else hsClass = '';
			if($('#catmenu-'+item.id).length == 0) catUl.append(`
				<li id="catmenu-`+item.id+`" `+hsClass+`><a href="`+(!item.child ? $('input[name=site_url]').val()+'front/shop?kategori='+item.id : '#')+`">`+item.text+` <i class="fas fa-chevron-right ml-auto"></i></a></li>
				`);
			if(item.child == true) loadCatMenuSub(item.id);
		});
			if(res.pagination.more) loadCatMenu(page+1);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});
	
}

function loadCatMenuSub(parent, page){

	let catUl = $('#catmenu-'+parent+' > ul');
	if(catUl.length == 0) $('#catmenu-'+parent).append('<ul></ul>')

	page = page || 1;
	$.ajax({
		url: $('input[name=site_url]').val()+'/ajax/request/items_kategori',
		type: 'GET',
		dataType: 'JSON',
		data: {page: page, parent:parent},
		// async: false,
	})
	.done(function(res) {
		// console.log(res);
		
		if(res.status == 'success') $.map(res.results, function(item, index) {
			// return something;
			let hsClass;
			if(item.child == true) hsClass = 'class="hassubs"'; else hsClass = '';
			if($('#catmenu-'+item.id).length == 0) $('#catmenu-'+parent+' > ul').append(`
				<li id="catmenu-`+item.id+`" `+hsClass+`><a href="`+(!item.child ? $('input[name=site_url]').val()+'front/shop?kategori='+item.id : '#')+`">`+item.text+` <i class="fas fa-chevron-right ml-auto"></i></a></li>
				`);
			if(item.child == true) loadCatMenuSub(item.id);
		});
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});
	
}