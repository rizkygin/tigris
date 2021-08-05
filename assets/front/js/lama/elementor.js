( function ($, elementor) {
    "use strict";

    var Vinkmag = {

        init: function () {

            var widgets = {
                'vinazine-featured-post.default': Vinkmag.Vinkmag_Featured_Post_Widget,
                'vinazine-popular-post.default': Vinkmag.Vinkmag_Popular_Post_Widget,
                'vinazine-hot-post.default': Vinkmag.Vinkmag_Hot_Post_Widget,
                'vinazine-more-post.default': Vinkmag.Vinkmag_More_Post_Widget,
                'vinazine-video-post-slider.default': Vinkmag.Vinkmag_Video_Post_Slider_Widget,
                'vinazine-post-block-slider.default': Vinkmag.Vinkmag_Post_Block_Slider_Widget,
                'vinazine-trending-post.default': Vinkmag.Vinkmag_Trending_Post_Widget,
                'vinazine-home-featured-slider.default': Vinkmag.Vinkmag_Home_Featured_Slider_Widget,
                'vinazine-more-post2.default': Vinkmag.Vinkmag_More_Post2_Widget,
            };

            $.each(widgets, function (widget, callback) {
                elementor.hooks.addAction('frontend/element_ready/' + widget, callback);
            });

        },

        
        
        Vinkmag_Video_Post_Slider_Widget: function ($scope) {
            var s = $scope.find('.video-slider');
            if (s.length > 0) {
                 s.owlCarousel({
                    margin:0,
                    loop:true,
                    center: true,
                    touchDrag:true,
                    mouseDrag: false,
                    items:2,
                    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }

                 });
             }
           
        },

        Vinkmag_More_Post2_Widget: function ($scope) {
            var carousel = $scope.find('.vinazine-more-post2');
            if (carousel.length > 0) {
               var autoplay = (carousel.attr('data-autoplay') == 'yes') ? true : false;

                carousel.owlCarousel({
                    nav: false,
                    items: 3,
                    touchDrag:true,
                    mouseDrag: false,
                    margin: 30,
                    reponsiveClass: true,
                    dots: true,
                    autoplay: autoplay,
                    loop: false,
                    slideSpeed: 600,
                    autoplayHoverPause: true,
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
                            items: 4,
                            touchDrag:true,
                            mouseDrag: true,
                        }
                    }        
                });
            }
        },

        Vinkmag_Featured_Post_Widget: function ($scope) {
            var slider1 = $scope.find('.slider-grid-style1');
            if (slider1.length > 0) {
               var autoplay = (slider1.attr('data-autoplay') == 'yes') ? true : false;
                slider1.owlCarousel({
                    loop: false,
                    items: 1,
                    dots: false,
                    nav: true,
                    touchDrag:true,
                    mouseDrag: false,
                    autoplayHoverPause: true,
                    autoplayTimeout: 5000,
                    autoplay: autoplay,
                    animateOut: 'slideOutLeft',
                    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                    responsiveClass: true,
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }
                });
            }

            var slider2 = $scope.find('.slider-grid-style2');
            if (slider2.length > 0) {
               var autoplay = (slider2.attr('data-autoplay') == 'yes') ? true : false;
                slider2.owlCarousel({
                    items: 1,
                    dots: true,
                    nav: false,
                    animateOut: 'slideOutLeft',
                    autoplay: autoplay,
                    touchDrag:true,
                    mouseDrag: false,
                    responsiveClass: true,
                    autoplayHoverPause: true,
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }
                });
            }

            var slider3 = $scope.find('.slider-grid-style3');
            if (slider3.length > 0) {
               var autoplay = (slider3.attr('data-autoplay') == 'yes') ? true : false;
                slider3.owlCarousel({
                    items: 1,
                    dots: true,
                    nav: false,
                    touchDrag:true,
                    mouseDrag: false,
                    animateOut: 'slideOutLeft',
                    autoplay: autoplay,
                    responsiveClass: true,
                    autoplayHoverPause: true,
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }
                });
            }

            var slider4 = $scope.find('.slider-grid-style4');
            if (slider4.length > 0) {
               var autoplay = (slider4.attr('data-autoplay') == 'yes') ? true : false;
                slider4.owlCarousel({
                    items: 1,
                    dots: false,
                    nav: true,
                    touchDrag:true,
                    mouseDrag: false,
                    animateOut: 'slideOutLeft',
                    autoplay: autoplay,
                    responsiveClass: true,
                    autoplayHoverPause: true,
                    navText: ["<i class='icon-arrow-left'></i>", "<i class='icon-arrow-right'></i>"],
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }
                });
            }

        },


        Vinkmag_Post_Block_Slider_Widget: function ($scope) {
            var slider1 = $scope.find('.vinazine-slider-block-style1');
            if (slider1.length > 0) {
                slider1.owlCarousel({
                    margin: 10,
                    dots: false,
                    nav: true,
                    items: 1,
                    touchDrag:true,
                    mouseDrag: false,
                    animateOut: 'fadeOut',
                    autoplayHoverPause: true,
                    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }
                });
            }

            var slider1 = $scope.find('.vinazine-slider-block-style2');
            if (slider1.length > 0) {
                slider1.owlCarousel({
                    margin: 10,
                    loop: true,
                    dots: false,
                    nav: true,
                    touchDrag:true,
                    mouseDrag: false,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    items: 1,
                    animateOut: 'fadeOut',
                    autoplayHoverPause: true,
                    navText: ["<i class='icon-arrow-left'></i>", "<i class='icon-arrow-right'></i>"],
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }
                });
            }


        },


        Vinkmag_More_Post_Widget: function ($scope) {
            var carousel = $scope.find('.vinazine-more-post');
            if (carousel.length > 0) {
               var autoplay = (carousel.attr('data-autoplay') == 'yes') ? true : false;

                carousel.owlCarousel({
                    nav: false,
                    items: 3,
                    touchDrag:true,
                    mouseDrag: false,
                    margin: 30,
                    reponsiveClass: true,
                    dots: true,
                    autoplay: autoplay,
                    loop: true,
                    slideSpeed: 600,
                    autoplayHoverPause: true,
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
                            touchDrag:true,
                            mouseDrag: true,
                        }
                    }        
                });
            }
        },

        

    

        Vinkmag_Hot_Post_Widget: function ($scope) {
            var carousel = $scope.find('.hot-topics-slider');
            if (carousel.length > 0) {
               var autoplay = (carousel.attr('data-autoplay') == 'yes') ? true : false;
                carousel.owlCarousel({
                    nav: false,
                    items: 4,
                    margin: 30,
                    reponsiveClass: true,
                    loop: false,
                    touchDrag:true,
                    mouseDrag: false,
                    dots: true,
                    autoplay: autoplay,
                    autoplayHoverPause: true,
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
                            items: 4,
                            mouseDrag: true,
                            touchDrag: true,
                        }
                    }
                });
            }
        },
        Vinkmag_Home_Featured_Slider_Widget: function ($scope) {
            var carousel = $scope.find('.hero-slider');
            if (carousel.length > 0) {
               var autoplay = (carousel.attr('data-autoplay') == 'yes') ? true : false;

                carousel.owlCarousel({
                    margin: 10,
                    loop: true,
                    dots: true,
                    nav: true,
                    touchDrag:true,
                    mouseDrag: false,
                    autoplay: autoplay,
                    items: 1,
                    animateOut: 'slideOutLeft',
                    navText: ["<i class='icon-arrow-left'></i>", "<i class='icon-arrow-right'></i>"], 
                    responsive: {
                        1024: {
                            touchDrag:true,
                            mouseDrag: true,
                        }
                      }    
                });
                $('.hero-slider .owl-dots').wrap('<div class="container slider-dot-item"><div class="row"><div class="col-lg-9"></div></div></div>');
                $('.hero-slider .owl-nav').wrap('<div class="container slider-arrow-item"><div class="row"><div class="col-lg-9"></div></div></div>');
             }
        },


        Vinkmag_Popular_Post_Widget: function ($scope) {
            var carousel = $scope.find('.most-populers');
            if (carousel.length > 0) {
               var autoplay = (carousel.attr('data-autoplay') == 'yes') ? true : false;

                carousel.owlCarousel({
                    items: 3,
                    dots: false,
                    loop: true,
                    touchDrag:true,
                    mouseDrag: false,
                    nav: true,
                    autoplay: autoplay,
                    margin: 30,
                    autoplayHoverPause: true,
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
                        1025: {
                            items: 3,
                            mouseDrag: true,
                            touchDrag: true,
                        }
                    }
                });
            }
        },

        Vinkmag_Trending_Post_Widget: function ($scope) {
            var sync1 = $scope.find('.vinazine-trending-1');
            var sync2 = $scope.find('.vinazine-trending-2');
            var slidesPerPage = 2; 
            var syncedSecondary = true;

            if (sync1.length > 0 && sync2.length > 0) {
               sync1.owlCarousel({
                  items : 1,
                  slideSpeed : 2000,
                  nav: false,
                  touchDrag:true,
                  mouseDrag: false,
                  autoplay: true,
                  dots: false,
                  loop: true,
                  responsiveRefreshRate : 200,
                  autoplayHoverPause: true,
                 
                }).on('changed.owl.carousel', syncPosition);
              
                sync2
                  .on('initialized.owl.carousel', function () {
                    sync2.find(".owl-item").eq(0).addClass("current");
                  })
                  .owlCarousel({
                     items : slidesPerPage,
                     dots: false,
                     nav: true,
                     smartSpeed: 200,
                     slideSpeed : 500,
                     touchDrag:true,
                     mouseDrag: false,
                     slideBy: slidesPerPage, 
                     responsiveRefreshRate : 100,
                     autoplayHoverPause: true,
                     navText:["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                     responsive: {
                        // breakpoint from 0 up
                        0: {
                           items: 1,
                        },
                        // breakpoint from 480 up
                        480: {
                           items: 2,
                        }
                 }

                }).on('changed.owl.carousel', syncPosition2);
              
                function syncPosition(el) {
               
                  var count = el.item.count-1;
                  var current = Math.round(el.item.index - (el.item.count/2) - .5);
                  
                  if(current < 0) {
                    current = count;
                  }
                  if(current > count) {
                    current = 0;
                  }
                  
                  //end block
              
                  sync2
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(current)
                    .addClass("current");
                  var onscreen = sync2.find('.owl-item.active').length - 1;
                  var start = sync2.find('.owl-item.active').first().index();
                  var end = sync2.find('.owl-item.active').last().index();
                  
                  if (current > end) {
                    sync2.data('owl.carousel').to(current, 100, true);
                  }
                  if (current < start) {
                    sync2.data('owl.carousel').to(current - onscreen, 100, true);
                  }
                }
                
                function syncPosition2(el) {
                  if(syncedSecondary) {
                    var number = el.item.index;
                    sync1.data('owl.carousel').to(number, 100, true);
                  }
                }
                
                sync2.on("click", ".owl-item", function(e){
                  e.preventDefault();
                  var number = $(this).index();
                  sync1.data('owl.carousel').to(number, 300, true);
                });
            }
        },
    };

    $(window).on('elementor/frontend/init', Vinkmag.init);

}(jQuery, window.elementorFrontend) );