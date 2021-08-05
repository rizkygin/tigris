//<![CDATA[
jQuery.noConflict();

if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style')
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    )
    document.querySelector('head').appendChild(msViewportStyle)
}

function fnjs_adams_flexslider(id, rtl, slideshow, animation, easing, direction, nested_slider) {

    var fin_slider = !nested_slider ? ('#' + id) : ('#' + id + ' .flexslider'),
        is_rtl = (rtl == 1) ? true : false;
    
    jQuery(fin_slider).flexslider({
        rtl: is_rtl,
        slideshow: slideshow,
        animation: animation,              //String: Select your animation type, "fade" or "slide"
        easing: easing,                 //{NEW} String: Determines the easing method used in $jqSlider transitions. $jqSlider easing plugin is supported!
        direction: direction,            // String: Select the sliding direction, "horizontal" or "vertical"
        
    });
}

function fnjs_adams_twitterTicker(ulTweetsList, slideSpeed, pauseInSeconds) {

    setTimeout(function () {
        var top = ulTweetsList.position().top;
        var h = ulTweetsList.height();
        var incr = (h / ulTweetsList.children().length);
        var newTop = top - incr;
        if (h + newTop <= 0)
            newTop = 0;
        ulTweetsList.animate({ top: newTop }, slideSpeed);

        fnjs_adams_twitterTicker(ulTweetsList, slideSpeed, pauseInSeconds);

    }, (pauseInSeconds * 1000));

}

jQuery(document).ready(function () {
    "use strict";
    
    // Tooltip
    jQuery("[data-toggle='tooltip']").tooltip();
    
    //Lighbox
    if (jQuery("a[rel^='prettyPhoto']").length > 0) {
        jQuery("a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'normal'
        });

        jQuery(".gallery-fancybox:first a[rel^='prettyPhoto']").prettyPhoto({ animation_speed: 'normal', slideshow: 3000, autoplay_slideshow: false });
        jQuery(".gallery-fancybox:gt(0) a[rel^='prettyPhoto']").prettyPhoto({ animation_speed: 'fast', slideshow: 10000, hideflash: true });
    }
    
    // Fit Post Videos
    jQuery(".article-container .article-content").fitVids();

    // Top Menu & Main Menu
    jQuery('#top_mmenu, #main_mmenu').dlmenu({
        animationClasses: { classin: 'dl-animate-in-2', classout: 'dl-animate-out-2' }
    });
    
    // Mega Menu
    jQuery('.navbar-nav > li.menu-item.mega-menu > .dropdown-menu > .dropdown-submenu').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });

    if ((jQuery('[data-megamenu]').length > 0) && (typeof jQuery('[data-megamenu]').data('megamenu-bgimg') !== 'undefined')) {
        jQuery('[data-megamenu]').each(function () {

            var megamenu_bgColor = jQuery(this).data('megamenu-bgcolor'),
                megamenu_bgImage = jQuery(this).data('megamenu-bgimg'),
                megamenu_bgPosx = jQuery(this).data('megamenu-bgposx'),
                megamenu_bgPosy = jQuery(this).data('megamenu-bgposy'),
                megamenu_bgRepeat = jQuery(this).data('megamenu-bgrepeat'),
                main_dropDownMenu = jQuery(this).find('> .dropdown-menu');

            var bg_image_url = megamenu_bgColor + ' ' + 'url(' + megamenu_bgImage + ')' + ' ' + megamenu_bgPosx + ' ' + megamenu_bgPosy + ' ' + megamenu_bgRepeat;

            main_dropDownMenu.css('background', bg_image_url);
        });

    }
    
    // Breaking News
    if ((jQuery('#js-news').length > 0)) {

        jQuery('#js-news').each(function () {

            var id = '#' + jQuery(this).attr('id'),
                direction = jQuery(this).data('direction'),
                writeSpeed = jQuery(this).data('writespeed'),
                pauseInSeconds = jQuery(this).data('pauseinseconds');

            breakingNewsTicker(id, direction, writeSpeed, pauseInSeconds);

        });

    }

    // Main Slider - Flexslider
    if ((jQuery('[data-homeslider]').length > 0)) {

        // data-nestedslider located in [post-func.php] for related box

        jQuery('[data-homeslider]').each(function () {



            var id = jQuery(this).attr('id'),
                has_carousel = jQuery(this).data('carousel'),

                rtl = jQuery(this).data('rtl'),
                animation_style = jQuery(this).data('animation'),

                animation_speed = jQuery(this).data('animation'),
                reverse_slides = jQuery(this).data('reverseslides'),

                auto_play = jQuery(this).data('autoplay'),
                animation_loop = true,
                pause_on_hover = true,
                transition_speed = 7000,

                easing = jQuery(this).data('easing'),
                direction = jQuery(this).data('direction');

            var is_auto_play = (auto_play == 1) ? true : false,
                is_rtl = (rtl == 1) ? true : false;

            if (is_auto_play) {

                animation_loop = (jQuery(this).data('animationloop') == 1) ? true : false;
                pause_on_hover = (jQuery(this).data('pauseonhover') == 1) ? true : false;
                transition_speed = jQuery(this).data('transitionspeed');

            }
                    
            if (has_carousel) {

                var carousel_slider = jQuery('#' + id).parent().find('.flexslider.carousel');

                // The slider being synced must be initialized first
                jQuery(carousel_slider).flexslider({

                    rtl: is_rtl,
                    useCSS: is_rtl,
                    slideshow: is_auto_play,      //both           //Boolean: Animate slider automatically

                    animationLoop: animation_loop, //both            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
                    pauseOnHover: pause_on_hover,  //both          //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    slideshowSpeed: transition_speed, //both          //Integer: Set the speed of the slideshow cycling, in milliseconds

                    animation: "slide",   //static
                    reverse: false,       //static          //{NEW} Boolean: Reverse the animation direction
                    animationSpeed: animation_speed,  //both          //Integer: Set the speed of animations, in milliseconds

                    easing: "swing",      //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
                    controlNav: false,
                    itemWidth: 97,
                    itemMargin: 5,
                    asNavFor: ('#' + id),

                    controlsContainer: jQuery(".flexslider.carousel .custom-navigation .custom-controls-container"),
                    customDirectionNav: jQuery(".flexslider.carousel .custom-navigation a")
                });

            }

            jQuery('#' + id).flexslider({
                rtl: is_rtl,
                useCSS: is_rtl,

                easing: "swing",      //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
                direction: direction,            // String: Select the sliding direction, "horizontal" or "vertical"

                slideshow: is_auto_play,
                animation: animation_style,              //String: Select your animation type, "fade" or "slide"

                animationLoop: animation_loop, //both            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
                pauseOnHover: pause_on_hover,  //both          //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                slideshowSpeed: transition_speed, //both          //Integer: Set the speed of the slideshow cycling, in milliseconds

                reverse: false,        //only here        //{NEW} Boolean: Reverse the animation direction
                animationSpeed: animation_speed,  //both          //Integer: Set the speed of animations, in milliseconds

                controlNav: false,

                controlsContainer: jQuery('#' + id + " .custom-navigation .custom-controls-container"),
                customDirectionNav: jQuery("#" + id + " .custom-navigation a"),
                
            });

        });

    }

    // Flexslider
    if ((jQuery('[data-flexsliderblock]').length > 0)) {

        // data-nestedslider located in [post-func.php] for related box

        jQuery('[data-flexsliderblock]').each(function () {

            var id = jQuery(this).attr('id'),
                is_rtl = jQuery(this).data('rtl'),
                animation = jQuery(this).data('animation'),
                easing = jQuery(this).data('easing'),
                direction = jQuery(this).data('direction'),
                nested_slider = jQuery(this).attr('data-nestedslider') ? true : false;

            fnjs_adams_flexslider(id, is_rtl, false, animation, easing, direction, nested_slider);

        });

    }

    //Scroll To top
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 200) {
            jQuery('#divGoToTop').css({ bottom: "20px" });
        } else {
            jQuery('#divGoToTop').css({ bottom: "-200px" });
        }
    });
    jQuery('#divGoToTop').click(function () {
        jQuery('html, body').animate({ scrollTop: '0px' }, 1000);
        return false;
    });

    if (is_touch_device()) {
        jQuery('body.pushy-active').css('overflow', 'auto');
    }

    // Footer Tweets
    
    if ((jQuery('[data-twitter-ticker]').length > 0)) {

        jQuery('[data-twitter-ticker]').each(function () {

            var slideSpeed = jQuery(this).data('slidespeed'),
                pauseInSeconds = jQuery(this).data('pauseinseconds');

            var ul = jQuery(this).find('.tweet_list');
            
            fnjs_adams_twitterTicker( ul, slideSpeed, pauseInSeconds );

        });

    }
    
});

// Fixed Navigation Menu
jQuery(window).load(function () {
    
    /* ==================================== Match Height ============================================ */
    jQuery('.bootstrap-row.main-site-container > .bootstrap-row-inner > [data-matchheight]').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });

    /* ==================================== Sticky Sidebar ============================================ */
    // apply stick columns
    var sidebarStickyOffset = 0;
    if (jQuery('body.admin-bar').length > 0) {
        sidebarStickyOffset += 32;
    }
    if (jQuery('.navbar-main.enable-fixed').length > 0) {
        sidebarStickyOffset += jQuery('.navbar-main.enable-fixed').height();
        sidebarStickyOffset -= 32;
    }

    if (!isMobileDevice()) {
        jQuery('[data-stickywrapper]').stick_in_parent({
            parent: '.bootstrap-row-inner',
            offset_top: sidebarStickyOffset,
            inner_scrolling: true,
        }).on('sticky_kit:bottom', function (e) {
            jQuery(this).parent().css('position', 'static');
        }).on('sticky_kit:unbottom', function (e) {
            jQuery(this).parent().css('position', 'relative');
        });
    }


    var theme_skin = jQuery('body').data('themeskin');
    
    if (jQuery('.navbar-main').length > 0) {
        "use strict";

        var headerHeight = jQuery('.navbar-main').offset().top;
        var main = jQuery('.enable-fixed');

        jQuery(window).scroll(function () {
            scrollToTop();
        });
        jQuery(window).load(function () {
            scrollToTop();
        });

        function scrollToTop() {
            var scrollY = jQuery(window).scrollTop();
            if (main.length > 0) {
                if (scrollY > headerHeight + 75) {
                    main.stop().addClass('navbar-fixed-top');
                } else if (scrollY < headerHeight + 75) {
                    main.removeClass('navbar-fixed-top');
                }
            }
        }
    }

    


    // SlimScroll
    //if (!isMobileDevice()) {
    //    var scrollPosition = 'right';
    //    if (jQuery('body.rtl').length > 0) {
    //        scrollPosition = 'left';
    //    }
    //    jQuery('.cat-review .review .criterias-list').slimScroll({
    //        height: '150px',
    //        size: '5px',
    //        position: scrollPosition,
    //        color: (theme_skin == 'light') ? '#9c9c9c' : '#222',
    //        opacity: 1.0,
    //        borderRadius: '0px',
    //        alwaysVisible: true,
    //        distance: '0px',
    //        railVisible: true,
    //        railColor: (theme_skin == 'light') ? '#e6e6e6' : '#333',
    //        railOpacity: 1.0,

    //        railBorderRadius: '0px',
    //        wheelStep: 10,
    //        allowPageScroll: false,
    //        disableFadeOut: false
    //    });
    //}

});

/* ==================================== isMobile ============================================ */
function isMobileDevice() {
    var isMobile = false;

    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }

    return isMobile;
}


function is_touch_device() {
    return 'ontouchstart' in window        // works on most browsers 
      || navigator.maxTouchPoints;       // works on IE10/11 and Surface
};

/* Breaking News Ticker */
function breakingNewsTicker(divID, direction, writeSpeed, pauseInSeconds){
    "use strict";
    jQuery(divID).bticker({
        speed: writeSpeed / 100,
        ajaxFeed: false,
        feedUrl: '',
        feedType: 'xml',
        displayType: 'reveal',
        htmlFeed: true,
        debugMode: true,
        controls: false,
        titleText: '',
        direction: direction,
        pauseOnItems: pauseInSeconds * 1000,
        fadeInSpeed: 600,
        fadeOutSpeed: 300
    });
};

//]]>