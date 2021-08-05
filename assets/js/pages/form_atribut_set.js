'use strict';
$(document).ready(function(){
	getAtribut();
	getAtributData();
	$( function() {
    // There's the attrset and the sumber
    var $attrset = $( "#attrset" ),
    $sumber = $( ".sumber" );
    $('.sync-attr').on('click', function(){
    	getAtribut();
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
		console.log($item);
		$item.fadeOut(function() {
			$item.find( ".remove-btn" ).remove();
			$item.find('.attr-values').remove();
			$item.removeAttr('style').removeClass("item").addClass("item-container");
			$item.appendTo( 'ul.sumber' ).fadeIn();
		});
	}


	function getAtribut(page){
		var html = $('.sumber');
		page = page || 1;
		$.ajax({
			url: $('input[name=site_url]').val()+'ajax/request/attr',
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
			$.map(res.results, function(item, index) {
				let konten = `
				<li id="attr-`+item.id+`" class="item-container ui-widget-content ui-corner-tr" data-values="`+item.id+`">
				<h5 class="ui-widget-header">`+item.attr+` [`+item.kode+`]</h5>
				</li>`;

				if($('#attr-'+item.id).length == 0) html.append(konten);
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
			url: $('input[name=site_url]').val()+'ajax/request/attr_data',
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



