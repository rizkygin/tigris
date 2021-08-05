'use strict';
$(document).ready(function(){
	getKategori();
	getAtribut();
	getAtributData();
	$( function() {
    // There's the attrset and the sumber
    var $attrset = $( "#attrset" ),
    $sumber = $( ".sumber" );
    $('.sync-attr').on('click', function(){
    	getAtribut();
    })
    $('.sync-kategori').on('click', function(){
    	getKategori();
    })

    // drop and sort:
    $('#attrset, .sumber').sortable();

    $('#attrset, .sumber').droppable({
    	accept: ".item-container",
    	drop: function (e, ui) {
    		var dropped = ui.draggable;
    		var droppedOn = $(this);
    		if(dropped.find('.remove-btn').length == 0) dropped = dropped.append('<a href="#" class="remove-btn btn btn-xs ui-icon ui-icon-trash"></a>');
    		dropped = dropped.append('<input type="hidden" name="attr[]" class="attr-values" value='+dropped.data('values')+'>');
    		$(this).append(dropped.clone().removeAttr('style').removeClass("item-container").addClass("item"));
    		dropped.remove();
    		$( "ul.attrset > li" ).unbind('click').on( "click", function( event ) {
    			var $item = $( this ),
    			$target = $( event.target );
    			// console.log(item);
    			if ( $target.is( "a.remove-btn" ) ) {
			        // deleteImage( $item );
			        // console.log('removed')
			        restoreAttr($item);
			    }

			    return false;
			});
    		
    	}
    });

    $('.sumber').droppable({
    	accept: ".item",
    	drop: function (e, ui) {
    		let dropped = ui.draggable;
    		var droppedOn = $(this);
    		dropped.find('.remove-btn').remove();
    		dropped.find('.attr-values').remove();
    		$(this).append(dropped.clone().removeAttr('style').removeClass("item").addClass("item-container"));
    		dropped.remove();
    	}
    });

    
} );


	function restoreAttr( $item ) {
		// console.log($item);
		$item.fadeOut(function() {
			$item.find( ".remove-btn" ).remove();
			$item.find('.attr-values').remove();
			$item.removeAttr('style').removeClass("item").addClass("item-container");
			$item.appendTo( 'ul.sumber' ).fadeIn();
		});
	}


	function getKategori(page){
		var html = $('.attr-for');
		page = page || 1;
		// if(page ==1) html.find('div.checkbox').remove();
		$.ajax({
			url: $('input[name=site_url]').val()+'ajax/items/items_kategori',
			type: 'GET',
			dataType: 'json',
			data: {page: page},
			beforeSend:function(){
				$('.sync-kategori > i.fa').addClass('fa-spin');
			}
		})
		.done(function(res) {
			$('.sync-kategori > i.fa').removeClass('fa-spin');
			const{status} = res;
		// console.log(res);
		if(status == 'success'){
			const {pagination} = res;
			// let konten = '';
			let katIds = [];
			// console.log($('textarea[name=kat_ids]'))
			if($('textarea[name=kat_ids]').length > 0 && $('textarea[name=kat_ids]').val() !== '') katIds = $('textarea[name=kat_ids]').val().replace("/(<([^>]+)>)/ig", "").split(",");
			// console.log(katIds);
			// console.log(html.length);
			if(html.find('ul.top').length == 0) $('.attr-for').append('<ul style="margin-left:0px;" class="list-unstyled top"></ul>');

			$.map(res.results, function(item, index) {
				// console.log(item.id);
				let ck = '';
				if( $.inArray(item.id, katIds) >= 0 ) ck = 'checked';
				let ckBox = '-';
				if(!item.child) ckBox = `<input type="checkbox" name="kategori[]" value="`+item.id+`" id="ck-kategori-`+item.id+`" `+ck+`/>`;
				let konten = `
				<li id="kat-`+item.id+`">
				<div class="checkbox checkbox-css checkbox-inline">
				`+ckBox+`
				<label for="ck-kategori-`+item.id+`">`+item.kategori+`</label>
				</div>
				</li>
				`;
				// console.log(konten);
				if($('#kat-'+item.id).length == 0) html.find('ul.top').append(konten);
				if(item.child) sub({parent:item.id});

			});
			if(pagination.more) getKategori(page + 1);
		}
	})
		.fail(function() {
		// console.log("error");
	})
		.always(function() {
		// console.log("complete");
	});

	}

	function sub(par){
		let page = par.page || 1;
		let level = par.level || 1;
		let parent = par.parent;
		let htmlSub = $('li#kat-'+par.parent);
		$.ajax({
			url: $('input[name=site_url]').val()+'ajax/items/items_kategori',
			type: 'GET',
			dataType: 'json',
			data: {page: page, child:'1', parent:parent},
			beforeSend:function(){
				$('.sync-kategori > i.fa').addClass('fa-spin');
			}
		})
		.done(function(res) {
			$('.sync-kategori > i.fa').removeClass('fa-spin');
			const{status} = res;
		// console.log(res);
		if(status == 'success'){
			const {pagination} = res;
			// let konten = '';
			let katIds = [];
			// console.log($('textarea[name=kat_ids]'))
			if($('textarea[name=kat_ids]').length > 0 && $('textarea[name=kat_ids]').val() !== '') katIds = $('textarea[name=kat_ids]').val().replace("/(<([^>]+)>)/ig", "").split(",");
			// console.log(htmlSub);
			if(htmlSub.find('ul.for-'+par.parent).length == 0) $('li#kat-'+par.parent).append('<ul style="margin-left:'+(20+level)+'px;" class="list-unstyled for-'+par.parent+'"></ul>');

			$.map(res.results, function(item, index) {
				// console.log(item.id);
				let ck = '';
				if( $.inArray(item.id, katIds) >= 0 ) ck = 'checked';
				let ckBox = '-';
				if(!item.child) ckBox = `<input type="checkbox" name="kategori[]" value="`+item.id+`" id="ck-kategori-`+item.id+`" `+ck+`/>`;
				let kontenSub = `
				<li id="kat-`+item.id+`">
				<div class="checkbox checkbox-css checkbox-inline">
				`+ckBox+`
				<label for="ck-kategori-`+item.id+`">`+item.kategori+`</label>
				</div>
				</li>
				`;

				if($('#kat-'+item.id).length == 0) htmlSub.find('ul.for-'+par.parent).append(kontenSub);
				// console.log(item);
				if(item.child) sub({parent:item.id, level:level+1});
			});
			
			if(pagination.more) sub({parent:par.parent, page:page + 1, level:level});
		}
	})
	}

	function checkHandler(){
		$(function () {
			$('input:checkbox.main-checkbox').click(function () {
				var array = [];
				var parent = $(this).closest('.main-parent');
        //check or uncheck sub-checkbox
        $(parent).find('.sub-checkbox').prop("checked", $(this).prop("checked"))
        //push checked sub-checkbox value to array
        $(parent).find('.sub-checkbox:checked').each(function () {
        	array.push($(this).val());
        })
    });
		})
	}

	function getAtribut(page){
		var html = $('.sumber');

		page = page || 1;
		// console.log(page);
		if(page ==1) html.find('li.item-container').remove();

		$.ajax({
			url: $('input[name=site_url]').val()+'ajax/items/items_attr',
			type: 'GET',
			dataType: 'json',
			data: {page: page, id_attr_set:$('input[name=id]').val()},
			beforeSend:function(){
				$('.sync-attr > i.fa').addClass('fa-spin');
			}
		})
		.done(function(res) {
			$('.sync-attr > i.fa').removeClass('fa-spin');

			const{status} = res;
		// console.log(res);
		if(status == 'success'){
			const {pagination} = res;
			// let konten = '';
			$.map(res.results, function(item, index) {
				let konten = `
				<li id="attr-`+item.id+`" class="item-container ui-widget-content ui-corner-tr" data-values="`+item.id+`">
				<h5 class="ui-widget-header">`+item.attr+` [`+item.kode+`]</h5>
				</li>`;
				if($('#attr-'+item.id).length == 0) html.append(konten);
				// console.log($('#attr-'+item.id).length);
			});
			
			if(pagination.more) getAtribut(page + 1);
		}
	})
		.fail(function() {
		// console.log("error");
	})
		.always(function() {
		// console.log("complete");
	});

	}
	function getAtributData(page){
		var html = $('.attrset');
		page = page || 1;
		$.ajax({
			url: $('input[name=site_url]').val()+'ajax/items/items_attr_data',
			type: 'GET',
			dataType: 'json',
			data: {page: page,id_attr_set:$('input[name=id]').val()},
		})
		.done(function(res) {
			const{status} = res;
		// console.log(res);
		if(status == 'success'){
			const {pagination} = res;
			let konten = '';
			$.map(res.results, function(item, index) {
				konten += `
				<li id="attr-`+item.id+`" class="item ui-widget-content ui-corner-tr" data-values="`+item.id+`">
				<h5 class="ui-widget-header">`+item.attr+` [`+item.kode+`]</h5>
				<input type="hidden" name="attr[]" class="attr-values" value=`+item.id+`>
				<a href="#" class="remove-btn btn btn-xs ui-icon ui-icon-trash"></a>
				</li>`;
				// $('ul.sumber > li#attr-'+item.id).remove();
			});
			html.append(konten);
			if(pagination.more) getAtributData(page + 1);
		}

		$( "ul.attrset > li" ).unbind('click').on( "click", function( event ) {
			var $item = $( this ),
			$target = $( event.target );
    			// console.log(item);
    			if ( $target.is( "a.remove-btn" ) ) {
			        // deleteImage( $item );
			        // console.log('removed')
			        restoreAttr($item);
			    }

			    return false;
			});
	})
		.fail(function() {
		// console.log("error");
	})
		.always(function() {
		// console.log("complete");
	});

	}



	

	
});



