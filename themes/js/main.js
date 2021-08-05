/**
*
* -----------------------------------------------------------------------------
*
* Template : Brickx  - Construction & Building HTML Template 
* Author : rs-theme
* Author URI : http://www.rstheme.com/
*
* -----------------------------------------------------------------------------
*
**/

(function($) {
    "use strict";

    // sticky menu
    var header = $('.menu-sticky');
    var win = $(window);
    win.on('scroll', function() {
       var scroll = win.scrollTop();
       if (scroll < 1) {
           header.removeClass("sticky");
       } else {
           header.addClass("sticky");
       }
    });
	
	// Home one menu
    var header1 = $('.menu-sticky1');
    var win = $(window);
    win.on('scroll', function() {
       var scroll = win.scrollTop();
       if (scroll < 550) {
           header1.removeClass("sticky1");
       } else {
           header1.addClass("sticky1");
       }
    });
		
	// home 5 and home 4
    var header4 = $('.menu-sticky4');
    var win = $(window);
    win.on('scroll', function() {
       var scroll = win.scrollTop();
       if (scroll < 150) {
           header4.removeClass("sticky4");
       } else {
           header4.addClass("sticky4");
       }
    });
	
 	//window load
	$(window).on( 'load', function() {
		//rs menu
		if($(window).width() < 992) {
		  $('.rs-menu').css('height', '0');
		  $('.rs-menu').css('opacity', '0');
		  $('.rs-menu-toggle').on( 'click', function(){
			 $('.rs-menu').css('opacity', '1');
		 });
		}
	})
	
	//Slider js 
	function doAnimations( elems ) {
		var animEndEv = 'webkitAnimationEnd animationend';
		elems.each(function () {
			var $this = $(this),
				$animationType = $this.data('animation');
			$this.addClass($animationType).one(animEndEv, function () {
				$this.removeClass($animationType);
			});
		});
	}
	
	var $myCarousel = $('#carousel-example-generic'),
	$firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
	$myCarousel.carousel();
	doAnimations($firstAnimatingElems);
	$myCarousel.carousel('pause');
	
	$myCarousel.on('slide.bs.carousel', function (e) {
		var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
		doAnimations($animatingElems);
	}); 
	
    $('#carousel-example-generic').carousel({
        interval:400,
        pause: "false",
        pauseOnHover: false
    });

	//about tabs
		$('.collapse.in').prev('.panel-heading').addClass('active');
		$('#accordion, #bs-collapse, #accordion1')
			.on('show.bs.collapse', function (a) {
				$(a.target).prev('.panel-heading').addClass('active');
			})
			.on('hide.bs.collapse', function (a) {
				$(a.target).prev('.panel-heading').removeClass('active');
			});
	
	/*-------------------------------------
    OwlCarousel
    -------------------------------------*/
	$('.rs-carousel').each(function() {
		var owlCarousel = $(this),
		loop = owlCarousel.data('loop'),
		items = owlCarousel.data('items'),
		margin = owlCarousel.data('margin'),
		stagePadding = owlCarousel.data('stage-padding'),
		autoplay = owlCarousel.data('autoplay'),
		autoplayTimeout = owlCarousel.data('autoplay-timeout'),
		smartSpeed = owlCarousel.data('smart-speed'),
		dots = owlCarousel.data('dots'),
		nav = owlCarousel.data('nav'),
		navSpeed = owlCarousel.data('nav-speed'),
		xsDevice = owlCarousel.data('mobile-device'),
		xsDeviceNav = owlCarousel.data('mobile-device-nav'),
		xsDeviceDots = owlCarousel.data('mobile-device-dots'),
		smDevice = owlCarousel.data('ipad-device'),
		smDeviceNav = owlCarousel.data('ipad-device-nav'),
		smDeviceDots = owlCarousel.data('ipad-device-dots'),
		mdDevice = owlCarousel.data('md-device'),
		mdDeviceNav = owlCarousel.data('md-device-nav'),
		mdDeviceDots = owlCarousel.data('md-device-dots');

		owlCarousel.owlCarousel({
			loop: (loop ? true : false),
			items: (items ? items : 3),
			lazyLoad: true,
			margin: (margin ? margin : 0),
			//stagePadding: (stagePadding ? stagePadding : 0),
			autoplay: (autoplay ? true : false),
			autoplayTimeout: (autoplayTimeout ? autoplayTimeout : 1000),
			smartSpeed: (smartSpeed ? smartSpeed : 250),
			dots: (dots ? true : false),
			nav: (nav ? true : false),
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
			navSpeed: (navSpeed ? true : false),
			responsiveClass: true,
			responsive: {
				0: {
					items: (xsDevice ? xsDevice : 1),
					nav: (xsDeviceNav ? true : false),
					dots: (xsDeviceDots ? true : false)
				},
				768: {
					items: (smDevice ? smDevice : 3),
					nav: (smDeviceNav ? true : false),
					dots: (smDeviceDots ? true : false)
				},
				992: {
					items: (mdDevice ? mdDevice : 3),
					nav: (mdDeviceNav ? true : false),
					dots: (mdDeviceDots ? true : false)
				}
			}
		});

	});

	// Skill bar 2
	if ($('#skills').length) {
		var skillsDiv = $('#skills');

		$(window).on('scroll', function(){
			var winT = $(window).scrollTop(),
		  	winH = $(window).height(),
		  	skillsT = skillsDiv.offset().top;
		  if(winT + winH  > skillsT){
		  	$('.skillbar').each(function(){
		      $(this).find('.skillbar-bar').animate({
		        width:$(this).attr('data-percent')
		      },2000);
		    });
		  }
		});
	}

    // onepage nav
    $(".navbar li").on("click", function () {
        if ($(".showhide").is(":visible")) {
            $(".showhide").trigger("click");
        }
    });
    if ($.fn.onePageNav) {
        $(".navbar").onePageNav({
            currentClass: "active"
        });
    }

    // collapse hidden
    $(function(){ 
         var navMain = $(".navbar-collapse"); // avoid dependency on #id
         // "a:not([data-toggle])" - to avoid issues caused
         // when you have dropdown inside navbar
         navMain.on("click", "a:not([data-toggle])", null, function () {
             navMain.collapse('hide');
         });
    });
	 
	// video 
    if ($('.player').length) {
        $(".player").YTPlayer();
    }

    // wow init
    new WOW().init();
    
    // image loaded portfolio init
	var gridfilter = $('.grid');
		if(gridfilter.length){
		$('.grid').imagesLoaded(function() {
			$('.project-filter').on('click', 'button', function() {
				var filterValue = $(this).attr('data-filter');
				$grid.isotope({
					filter: filterValue
				});
			});
			var $grid = $('.grid').isotope({
				itemSelector: '.grid-item',
				percentPosition: true,
				masonry: {
					columnWidth: '.grid-item',
				}
			});
		});
	}	
        
    // project Filter
	var projectfiler = $('.project-filter button');
		if(projectfiler.length){
		$('.project-filter button').on('click', function(event) {
			$(this).siblings('.active').removeClass('active');
			$(this).addClass('active');
			event.preventDefault();
		});
	}

    // image popup
	var imaggepoppup = $('.image-popup');
	if(imaggepoppup.length){
		$('.image-popup').magnificPopup({
			type: 'image',
			callbacks: {
				beforeOpen: function() {
				   this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure animated zoomInDown');
				}
			},
			gallery: {
				enabled: true
			}
		});
	}
    
	// video popup
	var popupyoutube = $('.popup-youtube');
	if(popupyoutube.length){
		$('.popup-youtube').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false								
		});	
	}
	
    // Blog slick Sllider
    $('.blog-list').slick({
	  centerMode: true,
	  centerPadding: '0',
	  slidesToShow: 3,
	  dots: false,
	  loop: true,
	  infinite: true,
	  autoplay: true,
	  arrows: true,
	  touchMove: true,
	  nextArrow: '<i class="fa fa-angle-right"></i>',
	  prevArrow: '<i class="fa fa-angle-left"></i>',
	  responsive: [
		{
		  breakpoint: 992,
		  settings: {
			arrows: true,
			centerMode: true,
			slidesToShow: 2
		  }
		},
		{
		  breakpoint: 767,
		  settings: {
			arrows: false,
			centerMode: true,
			slidesToShow: 1
		  }
		}
	  ]
	});

    // testimonial 2
	$('.center').slick({
	  centerMode: true,
	  infinite: true,
	  centerPadding: '0px',
	  slidesToShow: 5,
	  speed: 500,
	  variableWidth: false,
	});
	$('.center').on('beforeChange', function(event, slick, currentSlide, nextSlide){
	  console.log('beforeChange', currentSlide, nextSlide);
	});
	$('.center').on('afterChange', function(event, slick, currentSlide){
	  console.log('afterChange', currentSlide);
	});

    // testimonial init
	var testicarousel = $('.testi-carousel');
	if(testicarousel.length){
		testicarousel.slick({
			centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1,
	        slidesToScroll: 1,
	        focusOnSelect: true,
	        arrows: true,
	        dots: false,
	        autoplay: true,
	        autoplaySpeed: 4000,
	        pauseOnFocus: true,
	        pauseOnHover: true,
	        pauseOnDotsHover: false
		});
	}
	var owl = $('.fillter-item').owlCarousel({
		loop	:true,
		margin	:20,
		nav		:false,
		dots	:true,
		autoplay:true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			1100:{
				items:3
			},
			1300:{
				items:4
			}
		}
	})

	// welcome section init
	var testicarousel = $('.wlc-item');
	if(testicarousel.length){
		testicarousel.slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 2000,
		});
	}
    // Skill bar
    var skillbar = $('.skillbar');
    if(skillbar.length){	
		$('.skillbar').skillBars({	
			from: 0,	
			speed: 4000, 	
			interval: 100,	
			decimals: 0,	
		});
	}
	var owl = $('.fillter-item').owlCarousel({
		loop	:true,
		margin	:20,
		nav		:false,
		dots	:true,
		autoplay:true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			1100:{
				items:3
			},
			1300:{
				items:4
			}
		}
	})
	/* animate filter */
	var owlAnimateFilter = function(even) {
		$(this)
		.addClass('__loading')
		.delay(70 * $(this).parent().index())
		.queue(function() {
			$(this).dequeue().removeClass('__loading')
		})
	}
	$('.btn-filter-wrap').on('click', '.btn-filter', function(e) {
		var filter_data = $(this).data('filter');
		/* return if current */
		if($(this).hasClass('btn-active')) return;

		/* active current */
		$(this).addClass('btn-active').siblings().removeClass('btn-active');

		/* Filter */
		owl.owlFilter(filter_data, function(_owl) { 
			$(_owl).find('.item').each(owlAnimateFilter); 
		});
	})
    // Google Map
    if ($('#googleMap').length) {
        var initialize = function() {
            var mapOptions = {
                zoom: 10,
                scrollwheel: false,
                center: new google.maps.LatLng(40.837936, -73.412551),
                styles: [{
                    stylers: [{
                        saturation: -100
                    }]
                }]
            };
            var map = new google.maps.Map(document.getElementById("googleMap"),
                mapOptions);
            var marker = new google.maps.Marker({
                position: map.getCenter(),
                animation: google.maps.Animation.BOUNCE,
                icon: 'images/map-marker.png',
                map: map
            });
        }
        // Add the map initialize function to the window load function
        google.maps.event.addDomListener(window, "load", initialize);
    }

    //Home Two slider

    $("#about-slider").owlCarousel({
	    items : 1,
	    loop:true,
	    autoplay:true,
	})

	/*-------------------------------------
	Preloder Js here
	---------------------------------------*/
	//preloader
	$(window).on( 'load', function() {
		$(".preloader").delay(2000).fadeOut(500);
		$(".sk-cube-grid").on('click', function() {
		$(".preloader").fadeOut(500);
		})
	})
		
    // Counter Up
    if($('.rs-counter').length){	
		$('.rs-counter').counterUp({
			delay: 20,
			time: 1500
		});
	}
    // scrollTop init
    var totop = $('#scrollUp'); 
    if(totop.length){	
		win.on('scroll', function() {
			if (win.scrollTop() > 150) {
				totop.fadeIn();
			} else {
				totop.fadeOut();
			}
		});
		totop.on('click', function() {
			$("html,body").animate({
				scrollTop: 0
			}, 500)
		});
	}

	// partner init
	var partnercarousel = $('.partner-carousel');
    if(partnercarousel.length){
		$(".partner-carousel").owlCarousel({
			margin:0,
			loop:true,
			items:4,
			dots: false,
			autoplay:true,
			autoplayTimeout:1200,
			autoplayHoverPause:true,
			responsiveClass:true,
			responsive:{
				0:{
					items:1
				},
				400:{
					items:2
				},
				750:{
					items:2
				},
				1120:{
					items:4
				}
			}
		});
	}

	// Project Portfolio init
    $('.grid').imagesLoaded(function() {
        $('.portfolio-filter').on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });
        var $grid = $('.grid').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                columnWidth: '.grid-item',
            }
        });
    });        
        
    // Project portfolio Filter
    $('.portfolio-filter button').on('click', function(event) {
		$(this).siblings('.active').removeClass('active');
		$(this).addClass('active');
		event.preventDefault();
	});

	//CountDown Timer
    var CountTimer = $('.CountDownTimer');
    if(CountTimer.length){ 
        $(".CountDownTimer").TimeCircles({
            fg_width: 0.030,
            bg_width: 0.8,
            circle_bg_color: "#ffffff",
            circle_fg_color: "#ffffff",
            time: {
                Days:{
                    color: "#fff"
                },
                Hours:{
                    color: "#fff"
                },
                Minutes:{
                    color: "#fff"
                },
                Seconds:{
                    color: "#fff"
                }
            }
        }); 
    }

     //Testimonial Slider
	var rststslider = $('.rs-tst-slider');
    if(rststslider.length){ 	
		$(".rs-tst-slider").slick({
			infinite: true,
			centerMode: true,
			centerPadding: '60px',
			autoplay: true,
            arrows: true,
			autoplaySpeed: 2000,
			slidesToShow: 5,
			slidesToScroll: 1,
			variableWidth: true,
		});
	}
    
    $(".header-contact-info .search-btn").on('click', function(){
        $(".header-contact-info #searchword").slideToggle();
    });
    
	
})(jQuery);