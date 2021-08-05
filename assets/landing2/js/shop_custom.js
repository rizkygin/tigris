/* JS Document */

/******************************

[Table of Contents]

1. Vars and Inits
2. Set Header
3. Init Custom Dropdown
4. Init Page Menu
5. Init Recently Viewed Slider
6. Init Brands Slider
7. Init Isotope
8. Init Price Slider
9. Init Favorites


******************************/
var menuActive = false;
var header = $('.header');
var isoActive = false;

$(document).ready(function()
{
	"use strict";

	/* 

	1. Vars and Inits

	*/
	$('html, body').animate({
	        scrollTop: $(".shop").offset().top
	    }, 1000);

	setHeader();
	initCustomDropdown();
	initPageMenu();
	initViewedSlider();
	products();
	initBrandsSlider();
	// initIsotope();
	initPriceSlider();
	// initFavs();

	showFilter();

	$(window).on('resize', function()
	{
		setHeader();
	});
});

	/* 

	2. Set Header

	*/

	function setHeader()
	{
		//To pin main nav to the top of the page when it's reached
		//uncomment the following

		// var controller = new ScrollMagic.Controller(
		// {
		// 	globalSceneOptions:
		// 	{
		// 		triggerHook: 'onLeave'
		// 	}
		// });

		// var pin = new ScrollMagic.Scene(
		// {
		// 	triggerElement: '.main_nav'
		// })
		// .setPin('.main_nav').addTo(controller);

		if(window.innerWidth > 991 && menuActive)
		{
			closeMenu();
		}
	}

	/* 

	3. Init Custom Dropdown

	*/

	function initCustomDropdown()
	{
		if($('.custom_dropdown_placeholder').length && $('.custom_list').length)
		{
			var placeholder = $('.custom_dropdown_placeholder');
			var list = $('.custom_list');
		}

		placeholder.on('click', function (ev)
		{
			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}

			$(document).one('click', function closeForm(e)
			{
				if($(e.target).hasClass('clc'))
				{
					$(document).one('click', closeForm);
				}
				else
				{
					list.removeClass('active');
				}
			});

		});

		$('.custom_list a').on('click', function (ev)
		{
			ev.preventDefault();
			var index = $(this).parent().index();

			placeholder.text( $(this).text() ).css('opacity', '1');

			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}
		});


		$('select').on('change', function (e)
		{
			placeholder.text(this.value);

			$(this).animate({width: placeholder.width() + 'px' });
		});
	}

	/* 

	4. Init Page Menu

	*/

	function initPageMenu()
	{
		if($('.page_menu').length && $('.page_menu_content').length)
		{
			var menu = $('.page_menu');
			var menuContent = $('.page_menu_content');
			var menuTrigger = $('.menu_trigger');

			//Open / close page menu
			menuTrigger.on('click', function()
			{
				if(!menuActive)
				{
					openMenu();
				}
				else
				{
					closeMenu();
				}
			});

			//Handle page menu
			if($('.page_menu_item').length)
			{
				var items = $('.page_menu_item');
				items.each(function()
				{
					var item = $(this);
					if(item.hasClass("has-children"))
					{
						item.on('click', function(evt)
						{
							evt.preventDefault();
							evt.stopPropagation();
							var subItem = item.find('> ul');
						    if(subItem.hasClass('active'))
						    {
						    	subItem.toggleClass('active');
								TweenMax.to(subItem, 0.3, {height:0});
						    }
						    else
						    {
						    	subItem.toggleClass('active');
						    	TweenMax.set(subItem, {height:"auto"});
								TweenMax.from(subItem, 0.3, {height:0});
						    }
						});
					}
				});
			}
		}
	}

	function openMenu()
	{
		var menu = $('.page_menu');
		var menuContent = $('.page_menu_content');
		TweenMax.set(menuContent, {height:"auto"});
		TweenMax.from(menuContent, 0.3, {height:0});
		menuActive = true;
	}

	function closeMenu()
	{
		var menu = $('.page_menu');
		var menuContent = $('.page_menu_content');
		TweenMax.to(menuContent, 0.3, {height:0});
		menuActive = false;
	}

	/* 

	5. Init Recently Viewed Slider

	*/

	function initViewedSlider()
	{
		if($('.viewed_slider').length)
		{
			var viewedSlider = $('.viewed_slider');

			viewedSlider.owlCarousel(
			{
				loop:true,
				margin:30,
				autoplay:true,
				autoplayTimeout:6000,
				nav:false,
				dots:false,
				responsive:
				{
					0:{items:1},
					575:{items:2},
					768:{items:3},
					991:{items:4},
					1199:{items:6}
				}
			});

			if($('.viewed_prev').length)
			{
				var prev = $('.viewed_prev');
				prev.on('click', function()
				{
					viewedSlider.trigger('prev.owl.carousel');
				});
			}

			if($('.viewed_next').length)
			{
				var next = $('.viewed_next');
				next.on('click', function()
				{
					viewedSlider.trigger('next.owl.carousel');
				});
			}
		}
	}

	/* 

	6. Init Brands Slider

	*/

	function initBrandsSlider()
	{
		if($('.brands_slider').length)
		{
			var brandsSlider = $('.brands_slider');

			brandsSlider.owlCarousel(
			{
				loop:true,
				autoplay:true,
				autoplayTimeout:5000,
				nav:false,
				dots:false,
				autoWidth:true,
				items:8,
				margin:42
			});

			if($('.brands_prev').length)
			{
				var prev = $('.brands_prev');
				prev.on('click', function()
				{
					brandsSlider.trigger('prev.owl.carousel');
				});
			}

			if($('.brands_next').length)
			{
				var next = $('.brands_next');
				next.on('click', function()
				{
					brandsSlider.trigger('next.owl.carousel');
				});
			}
		}
	}

	/* 

	7. Init Isotope

	*/

	function initIsotope()
	{

		if(isoActive) $('.product_grid').isotope('destroy');


		let sortingButtons = $('.shop_sorting_button');
		$('.product_grid').isotope({
			itemSelector: '.product_item',
			layoutMode: 'fitRows',
            getSortData: {
            	price: function(itemElement)
            	{
            		let priceEle = $(itemElement).find('.product_price').text().replace( 'Rp', '' );
            		return parseFloat(priceEle);
            	},
            	name: '.product_name div a'
            },
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
        isoActive =true;

        // Sort based on the value from the sorting_type dropdown
        sortingButtons.each(function()
        {
        	$(this).unbind('click').on('click', function()
        	{
        		$('.sorting_text').text($(this).text());
        		let option = $(this).attr('data-isotope-option');
        		option = JSON.parse(option);
				$('.product_grid').isotope(option);
        	});
        });

        

	}

	 /* 

	8. Init Price Slider

	*/

    function initPriceSlider()
    {
    	if($("#slider-range").length)
    	{
    		$("#slider-range").slider(
			{
				range: true,
				min: 0,
				max: 1000,
				values: [ 0, 580 ],
				slide: function( event, ui )
				{
					$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
				}
			});
				
			$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
			$('.ui-slider-handle').on('mouseup', function()
			{
				$('.product_grid').isotope({
		            filter: function()
		            {
		            	var priceRange = $('#amount').val();
			        	var priceMin = parseFloat(priceRange.split('-')[0].replace('$', ''));
			        	var priceMax = parseFloat(priceRange.split('-')[1].replace('$', ''));
			        	var itemPrice = $(this).find('.product_price').clone().children().remove().end().text().replace( '$', '' );

			        	return (itemPrice > priceMin) && (itemPrice < priceMax);
		            },
		            animationOptions: {
		                duration: 750,
		                easing: 'linear',
		                queue: false
		            }
		        });
			});
    	}	
    }

    /* 

	9. Init Favorites

	*/

	function initFavs()
	{
		// Handle Favorites
		var items = document.getElementsByClassName('product_fav');
		for(var x = 0; x < items.length; x++)
		{
			var item = items[x];
			item.addEventListener('click', function(fn)
			{
				fn.target.classList.toggle('active');
			});
		}
	}

	// 10. filter:
	function showFilter(par){
		par = par || {};
		let page = par.page || 1;
		let parent = par.parent || 0;
		let boxFilter = $('#shop-filter');
		if(boxFilter.length == 0) $(`
			<div id="shop-filter">
				<div id="jstree-default">
					<ul class="top">
					<li data-jstree='{ `+($('input[name=kategori_select]').val() == '' ? '"opened":true, "selected":true' : '')+` }'><a href="`+$('input[name=site_url]').val()+`front/shop?kategori=all" data-id="">Semua Kategori</a></li>
					</ul>
				</div>
			</div>
			`).appendTo($('.shop_sidebar .filter_kategori'));

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
					if(res.status == 'success') self = res;
				});
				return self
			}();

			if(Object.keys(ktgParents).length > 0){
				let {status, pagination} = ktgParents;
				let currPage = ktgParents.page;
				if(status == 'success'){
					$.map(ktgParents.results, function(item, index) {

						let dataTree = ``;
						let totalBadge = item.items;
						if(item.child) dataTree = `"disabled":true`;
						// if($('input[name=kategori_select]').val() !== ''){
							if( $('input[name=kategori_select]').val() ==item.id ) dataTree =`"opened":true, "selected":true`;
							else if(item.child) dataTree = `"disabled":true`;
						// }
						let ktgHtml = `<li id="ktg-`+item.id+`" data-jstree='{`+dataTree+`}' data-items="`+item.items+`" data-parent="`+item.parent+`" data-id="`+item.id+`"><a href="`+$('input[name=site_url]').val()+`front/shop?kategori=`+item.id+`" data-id="`+item.id+`" data-child="`+item.child+`">`+item.text+` <span class="total-bage-`+item.id+` badge bg-green">`+item.items+`</span></a>`+(item.child ? `<ul></ul>` : '')+`</li>
						`;
						if(item.parent > 0) $('li#ktg-'+parent+' > ul').append(ktgHtml); else $('div#jstree-default > ul.top').append(ktgHtml);
						if(item.child) showFilter({parent:item.id});
					});

					$(function(){
						$('#jstree-default').jstree({
							"core": {
								"themes": {
									"responsive": true
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

						$('#jstree-default').on("click","li.jstree-node a",function(){
							// console.log($(this).data('child'));
							// return false;
						    if(!$(this).data('child')) document.location.href = this;
						    else return false;
						});
						$('#jstree-default').jstree(true).refresh();
					})

					if(pagination.more) showFilter({page:currPage+1, parent: parent});
				}

			}
		}

	// 11. product list:
	function products(params){
		params = params || {};
			let html = $('.product_grid');
			let page = params.page || 1;
			let kategori = $('input[name=kategori_select]').val();
			$.ajax({
				url: $('input[name=site_url]').val()+'ajax/items/item_list',
				type: 'GET',
				dataType: 'json',
				data: {page: page, limit:20, add_param: params.addParam || JSON.stringify({id_kategori:kategori})},
				beforeSend: function(){
		    		$('.product_grid > .product_item').remove();
		    	},
			})
			.done(function(res) {
				// console.log(res);
				if(res.status == 'success') $.map(res.result, function(item, index) {
					// console.log(item);
					if($('.product_grid > #item-'+item.id).length == 0) html.append(`
						<div class="product_item" id="item-`+item.id+`">
							<div class="product_border"></div>
							<div class="product_image d-flex flex-column align-items-center justify-content-center">`+item.img+`</div>
							<div class="product_content">
								<div class="product_price">`+item.harga_jual+`</div>
								<div class="product_name"><div><a href="`+$('input[name=site_url]').val()+`front/product?id=`+item.id+`" tabindex="0">`+item.nama+`</a></div></div>
							</div>
							<div class="product_fav"><i class="fas fa-heart"></i></div>
							
						</div>
						`);
					// initIsotope();
				});

				initIsotope();
				// initPriceSlider();
				initFavs();

				if(res.status == 'success') {
					let pageParams = {
	                	func:'products',
	                	total:res.total,
	                	limit:20,
	                	curr:page,
	                	komp:$('.shop_page_nav'),
	                	param:{
	                		addParam: params.addParam || null
		                	},

	                }



	                let pag = new Paginate(pageParams);
	                pag.init();


				}

					
			})
			.fail(function() {
				// console.log("error");
			})
			.always(function() {
				// console.log("complete");
			});
			
		}
