/*
	Template Name: Vinkmag
	Author: Themewinter
	Author URI: https://themeforest.net/user/tripples
	Description: vinkmag
   Version: 1.0

   ================================
   table of content
   =================================
   1.   dropdown menu
   2.   breking news slider
   3.   featured post slider
   4.   Most populer slider
   5.   Gallery popup
   6.   video popup
   7.   video slider


*/


jQuery(document).ready(function ($) {
    "use strict";

    function DoPrevent(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    $('.ekit-menu-nav-link.has-submenu .sub-arrow').on('click', function(e){
        e.preventDefault();
    });

   /**-------------------------------------------------
     *Fixed HEader
     *----------------------------------------------------**/
    $(window).on('scroll', function () {

            /**Fixed header**/
            if ($(window).scrollTop() > 250) {
            $('.navbar-fixed').addClass('sticky fade_down_effect');
            } else {
            $('.navbar-fixed').removeClass('sticky fade_down_effect');
            }
    });


    $(window).on('load', function () {

        /*==========================================================
                    4. Preloader
        =======================================================================*/
        setTimeout(() => {
            $('#preloader').addClass('loaded');
        }, 1000);

        /* ----------------------------------------------------------- */
        /*  breking news slider
        /* ----------------------------------------------------------- */
        if ($('#breaking_slider1').length > 0) {
            $('#breaking_slider1').slick({
                dots: false,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                arrows: false,
                autoplay: true,
                autoplaySpeed: 3000,
                buttons: false
            });
        }
        /* ----------------------------------------------------------- */
        /*  breking news slider
        /* ----------------------------------------------------------- */
        if ($('#breaking_slider').length > 0) {
            $('#breaking_slider').owlCarousel({
                items: 1,
                loop: true,
                dots: false,
                autoplayHoverPause: true,
                mouseDrag: false,
                touchDrag: false,
                nav: true,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                autoplayTimeout: 5000,
                autoplay: false,
            })
        }

        if ($('.vinkmag-breaking-slider').length > 0) {
            $('.vinkmag-breaking-slider').owlCarousel({
                items: 1,
                loop: true,
                dots: false,
                autoplayHoverPause: true,
                mouseDrag: false,
                touchDrag: false,
                nav: true,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                autoplayTimeout: 5000,
                autoplay: false,
            })
        }

    });

    if ($('.vinkmag-featured-slider').length > 0) {
        $('.vinkmag-featured-slider').owlCarousel({
            margin: 10,
            dots: true,
            nav: false,
            items: 1,
            touchDrag:false,
            mouseDrag: false,
            animateOut: 'fadeOut',
            autoplay: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                1024: {
                    touchDrag:true,
                    mouseDrag: true,
                }
              }
        });
    }

    $('.preloader-cancel-btn').on('click', function (event) {
        event.preventDefault();
        if (!$('#preloader').hasClass('loaded')) {
            $('#preloader').addClass('loaded');
        }
    });

    /* ---------------------------------------------
                         Menu Toggle 
       ------------------------------------------------ */

    $('.dropdown > a').on('click', function (e) {
        var dropdown = $(this).parent('.dropdown');
        dropdown.find('>.dropdown-menu').slideToggle('show');
        $(this).toggleClass('opened');
        return false;
    });


    /* ----------------------------------------------------------- */
    /*  index search
    /* ----------------------------------------------------------- */
    $(".header-search-btn-toggle").on("click", function (e) {
        e.preventDefault();
        if ($('.navbar-container .vinkmag-serach').length > 0) {
            $('.navbar-container .vinkmag-serach').stop().fadeToggle(500);
            $('.navbar-container .vinkmag-serach').find('input').focus();
        }
    });

    function fix_menu() {
        var h = $('#right-menu-element').width();
        $('#navbar-main-container .navbar').css({
            'padding-right': h + 'px'
        });
    }
    fix_menu();

    $.fn.myOwl = function (options) {

        var settings = $.extend({
            items: 1,
            dots: false,
            loop: false,
            mouseDrag: true,
            touchDrag: true,
            nav: true,
            autoplay: true,
            navText: ['', ''],
            margin: 0,
            stagePadding: 0,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            navRewind: false,
            responsive: {}
        }, options);

        return this.owlCarousel({
            items: settings.items,
            loop: settings.loop,
            mouseDrag: settings.mouseDrag,
            touchDrag: settings.touchDrag,
            nav: settings.nav,
            navText: settings.navText,
            dots: settings.dots,
            margin: settings.margin,
            stagePadding: settings.stagePadding,
            autoplay: settings.autoplay,
            autoplayTimeout: settings.autoplayTimeout,
            autoplayHoverPause: settings.autoplayHoverPause,
            animateOut: settings.animateOut,
            animateIn: settings.animateIn,
            responsive: settings.responsive,
            navRewind: settings.navRewind,

        });
    };


    /* ----------------------------------------------------------- */
    /*  popular slider on single post
    /* ----------------------------------------------------------- */
    if ($('.popular-grid-slider').length > 0) {
        $('.popular-grid-slider').owlCarousel({
            items: 3,
            dots: false,
            loop: true,
            nav: true,
            margin: 30,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
                // breakpoint from 480 up
                480: {
                    items: 2,
                },
                // breakpoint from 768 up
                768: {
                    items: 2,
                },
                // breakpoint from 768 up
                1200: {
                    items: 3,
                }
            }
        })
    }


    /* ----------------------------------------------------------- */
    /*  marquee slider for crypto
    /* ----------------------------------------------------------- */
    if ($('.slick.marquee').length > 0) {
        $('.slick.marquee').slick({
            dots: false,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            arrows: false,
            autoplay: true,
            autoplaySpeed: 3000,
            buttons: false
        });
    }



    /* ----------------------------------------------------------- */
    /*  Popup
    /* ----------------------------------------------------------- */

    if ($('.gallery-popup').length > 0) {
        $('.gallery-popup').magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom',
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                opener: function (openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });
    }

    /* ----------------------------------------------------------- */
    /*  single post video
    /* ----------------------------------------------------------- */
    if ($('.ts-play-btn').length > 0) {
        $('.ts-play-btn').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-with-zoom',
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                opener: function (openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });
    }

    if ($('.ts-video-btn').length > 0) {
        $('.ts-video-btn').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-with-zoom',
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                opener: function (openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });

    }


    if ($('.ts-video-icon').length > 0) {
        $('.ts-video-icon').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-with-zoom',
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                opener: function (openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });

    }



    /*==========================================================
                    39. magnific modal popup
        ======================================================================*/
    if ($('.xs-modal-popup').length > 0) {
        $('.xs-modal-popup').magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: false,
            callbacks: {
                beforeOpen: function beforeOpen() {
                    this.st.mainClass = "my-mfp-slide-bottom xs-promo-popup";
                }
            }
        });
    }

    /*==========================================================
                    39. scroll bar
        ======================================================================*/

    if ($(".video-tab-scrollbar").length > 0) {
        $(".video-tab-scrollbar").mCustomScrollbar({
            mouseWheel: true,
            scrollButtons: {
                enable: true
            }
        });
    }

    $(window).on('resize', function () {
        if ($(window).width() <= 991) {
            $('.menu-item-has-children > a').on('click', DoPrevent);
        } else {
            $('.menu-item-has-children > a').off('click', DoPrevent);
        }
    })

    // instragra feed
    
    var access_token = $("#ins_access_token").data('token');
    var ins_userId = $("#ins_userId").data('user');
    var ins_limit = $("#ins_limit").data('limit');

    let accessToken = access_token,
        get = "user",
        userId = ins_userId,
        resolution = "standard_resolution",
        useHttp = "true",
        limit = ins_limit;

    if ($('#instafeed-gallery-feed').length > 0) {
        let galleryFeed = new Instafeed({
            get: get,
            userId: userId,
            accessToken: accessToken,
            resolution: resolution,
            useHttp: useHttp,
            limit: limit,
            target: "instafeed-gallery-feed",
        });
        galleryFeed.run();
    }

// backto top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
             $('#back-to-top').fadeIn();
        } else {
             $('#back-to-top').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('#back-to-top').on('click', function () {
         $('#back-to-top').tooltip('hide');
         $('body,html').animate({
              scrollTop: 0
         }, 800);
         return false;
    });
    
    $('#back-to-top').tooltip('hide');


    
     // Post Loading
     $('#post-loading-button').on('click',function(event){
        event.preventDefault();
      
        var $that = $(this);
        if($that.hasClass('disable')){
            return false;
        }
   
        var contentwrap = $('.main-content-inner'), // item contentwrap
            postperpage = $that.data('post_per_page'), // post per page number
            showallposts = $that.data('show_total_posts'); // total posts count
  
        var items = contentwrap.find('.card'),
            totalpostnumber = items.length,
            paged = ( totalpostnumber / postperpage ) + 1; // paged number
         
        $.ajax({
            url: vinkmag_ajax.ajax_url,
            type: 'POST',
            data: {action: 'vinkmag_post_ajax_loading',postperpage: postperpage,paged:paged},
            beforeSend: function(){
                $that.addClass('disable');
                $('<i class="fa fa-spinner fa-spin" style="margin-left:10px"></i>').appendTo( "#post-loading-button" ).fadeIn(100);
            },
            complete:function(){
                $('#post-loading-button .fa-spinner ').remove();
            }
        })
  
        .done(function(data) {
            var newLenght  = contentwrap.find('.card').length;
            if(showallposts <= newLenght){
              $('.post-content-loading').fadeOut(300,function(){
                $('.post-content-loading').remove();
              });
            }
            $that.removeClass('disable');
  
            var $pstitems = $(data);
            console.log($pstitems.html());
            $('.main-content-inner').append( $pstitems );
        })
  
        .fail(function() {
            alert('Loading Failed');
        });
  
    });

         /*==========================================================
                   reading progressbar
        ======================================================================*/  
       
        window.onscroll = function() { reading_progressbar() };

         function reading_progressbar() {
               var vinkmag_winScroll = document.body.scrollTop || document.documentElement.scrollTop;
               var vinkmag_height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
               var vinkmag_scrolled = (vinkmag_winScroll / vinkmag_height) * 100;
               if (document.getElementById("readingProgressbar")) {
                document.getElementById("readingProgressbar").style.width = vinkmag_scrolled + "%";
            }
         }

         reading_progress_bar_post();
  
         function reading_progress_bar_post() {
           
            var progressWrap = $('.vinkmag_progress_container');
            
       
            if ( progressWrap.length > 0 ) {
                var didScroll = false,
                    windowWrap = $(window),

                    contentWrap = $('.entry-content'),
                    contentHeight = contentWrap.height(),
                    windowHeight = windowWrap.height() * .85;
      
                $(window).scroll(function() {
                    didScroll = true;
                });
      
                $(window).on('resize', function(){
                    windowHeight = windowWrap.height() * .85;
                    progressReading();
                });
      
                setInterval(function() {
                    if ( didScroll ) {
                        didScroll = false;
                        progressReading();
                    }
                }, 150);
      
                var progressReading = function() {
      
                    var windowScroll = windowWrap.scrollTop(),
                        contentOffset = contentWrap.offset().top,
                        contentScroll = ( windowHeight - contentOffset ) + windowScroll,
                        progress = 0;
      
                    if ( windowHeight > contentHeight + contentOffset ) {
                        progressWrap.find('.progress-bar').width(0);
                    } else {
                        if ( contentScroll > contentHeight ) {
                            progress = 100;
                        } else if ( contentScroll > 0 ) {
                            progress = ( contentScroll / contentHeight ) * 100 ;
                           
                        }
      
                        progressWrap.find('.progress-bar').width(progress + '%');
                    }
                }
            }
        }

});