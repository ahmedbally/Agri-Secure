/*--------------------------------------------------------*/
/* TABLE OF CONTENTS: */
/*--------------------------------------------------------*/
/* 01 - VARIABLES */
/* 02 - page calculations */
/* 03 - function on document ready */
/* 04 - function on page load */
/* 05 - function on page resize */
/* 06 - function on page scroll */
/* 07 - swiper sliders */
/* 08 - buttons, clicks, hovers */
/*-------------------------------------------------------------------------------------------------------------------------------*/

$(function() {


    "use strict";

    /*================*/
    /* 01 - VARIABLES */
    /*================*/
    var swipers = [], winW, winH, _isresponsive, xsPoint = 767, smPoint = 991, mdPoint = 1199, enableScroll = 0;
    var isSafari = /constructor/i.test(window.HTMLElement);
    if(isSafari) $('body').addClass('safari');


    /*========================*/
    /* 02 - page calculations */
    /*========================*/
    function pageCalculations(){
        winW = $(window).width();
        winH = $(window).height();
        if($('.mob-icon').is(':visible')) _isresponsive = true;
        else _isresponsive = false;
        $('.block.type-2 .col-md-6.col-md-push-6').height($('.block.type-2 .col-md-4.col-md-pull-6').height());

        if(winH<700 && $('.bottom-fixed-control-class').length) $('header').removeClass('bottom-fixed-control-class bottom-fixed');
        $('.teaser-container').css({'height':winH});
    }


    /*=================================*/
    /* 03 - function on document ready */
    /*=================================*/
    pageCalculations();

    //center all images inside containers
    $('.center-image').each(function(){
        var bgSrc = $(this).attr('src');
        $(this).parent().css({'background-image':'url('+bgSrc+')'});
        $(this).hide();
    });


    /*============================*/
    /* 04 - function on page load */
    /*============================*/
    $(window).on('load', function(){
        //$('body, html').animate({'scrollTop':'0'}, 0);

        //window.scrollTo(0, 0);
        $('#loader-wrapper').delay(300).fadeOut(300, function(){enableScroll = 1; scrollCall();});
        initSwiper();
        if(window.location.hash) {
            setTimeout(function(){
                $('body, html').animate({'scrollTop':$('.scroll-to-block[data-id="'+window.location.hash.substr(1)+'"]').offset().top - (($('.sidebar-menu-added').length)?0:$('header').height()) + 1}, 10);

                //window.scrollTo(0, $('.scroll-to-block').eq(index).offset().top - $('header').height() + 1);
            }, 100);
        }else{
            $('body, html').animate({'scrollTop':0}, 10);
        }

        $('body').addClass('loaded');
    });


    /*==============================*/
    /* 05 - function on page resize */
    /*==============================*/
    function resizeCall(){
        $('.opened').removeClass('opened');
        pageCalculations();
        $('.swiper-container.initialized[data-slides-per-view="responsive"]').each(function(){
            var thisSwiper = swipers['swiper-'+$(this).attr('id')], $t = $(this), slidesPerViewVar = updateSlidesPerView($t);
            thisSwiper.params.slidesPerView = slidesPerViewVar;
            thisSwiper.init();
            var paginationSpan = $t.find('.pagination span');
            paginationSpan.hide().slice(0,(paginationSpan.length+1-slidesPerViewVar)).show();
        });
    }
    $(window).resize(function(){
        resizeCall();
    });
    window.addEventListener("orientationchange", function() {
        resizeCall();
    }, false);


    /*==============================*/
    /* 06 - function on page scroll */
    /*==============================*/
    var _buffer = null;
    $(window).scroll(function(){
        scrollCall();
    });

    function scrollCall(){
        var winScroll = $(window).scrollTop();
        if(!_isresponsive && !$('header').hasClass('default-act') && !$('.sidebar-menu-added').length) {
            if($(window).scrollTop()>=25) $('header').addClass('act');
            else $('header').removeClass('act');
        }

        if($('header').hasClass('bottom-fixed-control-class')){
            if(winScroll>=(winH-75)) $('header').removeClass('bottom-fixed');
            else $('header').addClass('bottom-fixed');
        }

        /*if($('.scroll-to-block').length && enableScroll){
            var headerHeight = ($('.sidebar-menu-added').length)?0:75;
            $('.scroll-to-block').each(function( index, element ) {
               if($(element).offset().top<=(winScroll+headerHeight) && ($(element).offset().top+$(element).height()) > (winScroll+headerHeight) ){
                   $('.scroll-to-link.act').removeClass('act');
                   $('.scroll-to-link[href="#'+$(element).attr('data-id')+'"]').addClass('act');
                   if(window.location.hash!='#'+$(element).attr('data-id')) window.location.hash = '#'+$(element).attr('data-id');
                   return false;
               }
           });
       }*/

    }



    /*=====================*/
    /* 07 - swiper sliders */
    /*=====================*/
    function initSwiper(){
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            parallax: true,
        });
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            loop:true,
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            thumbs: {
              swiper: galleryThumbs
            }
        });





    }

    function updateSlidesPerView(swiperContainer){
        if(winW>mdPoint) return parseInt(swiperContainer.attr('data-lg-slides'), 10);
        else if(winW>smPoint) return parseInt(swiperContainer.attr('data-md-slides'), 10);
        else if(winW>xsPoint) return parseInt(swiperContainer.attr('data-sm-slides'), 10);
        else return parseInt(swiperContainer.attr('data-xs-slides'), 10);
    }

    //swiper arrows
    $('.swiper-arrow.left').on('click', function(){
        swipers['swiper-'+$(this).parent().attr('id')].swipePrev();
    });

    $('.swiper-arrow.right').on('click', function(){
        swipers['swiper-'+$(this).parent().attr('id')].swipeNext();
    });

    $('.swiper-arrow-gallery.left').on('click', function(){
        swipers['swiper-'+$(this).closest('.gallery-popup').find('.swiper-container').attr('id')].swipePrev();
    });

    $('.swiper-arrow-gallery.right').on('click', function(){
        swipers['swiper-'+$(this).closest('.gallery-popup').find('.swiper-container').attr('id')].swipeNext();
    });

    //swiper tabs
    $('.banner-tabs .entry, .thumbnails .entry').on('click', function(){
        if($(this).hasClass('active')) return false;
        var activeIndex = $(this).parent().find('.entry').index(this);
        swipers['swiper-'+$(this).closest('.swiper-container').attr('id')].swipeTo(activeIndex);
        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');
    });


    /*==============================*/
    /* 08 - buttons, clicks, hovers */
    /*==============================*/

    //menu click in responsive
    $('.mob-icon').on('click', function(){
        if($(this).hasClass('act')){
            $('.mob-icon').removeClass('act');
            $('header').removeClass('act-mob');
        }else{
            $('.mob-icon').addClass('act');
            $('header').addClass('act-mob');
        }
    });

    var obj;
    $('.play, .open-video-popup').on('click', function(){
        obj = $(this);
        $('.video-popup').addClass('act-act');
        $('.video-popup').addClass('act');
        setTimeout(function(){
            $('.video-popup iframe').attr('src',obj.attr('data-src'));
            setTimeout(function(){
                $('.video-popup iframe').addClass('act');
                $('.video-popup a').addClass('act');
            },350);
        },710);
        return false;
    });

    $('.video-popup a').on('click', function(){
        $('.video-popup iframe').removeClass('act');
        $('.video-popup a').removeClass('act');
        setTimeout(function(){
            $('.video-popup iframe').attr('src','');
            $('.video-popup').removeClass('act');
            setTimeout(function(){
                $('.video-popup').removeClass('act-act');
            },500);
        },500);
        return false;
    });


    //tabs
    var tabsFinish = 0;
    $('.tabs-switch').on('click', function(){
        if($(this).hasClass('active') || tabsFinish) return false;
        tabsFinish = 1;
        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');
        var tabIndex = $(this).parent().find('.tabs-switch').index(this);
        var tabsContainer = $(this).closest('.tabs-switch-container');
        tabsContainer.find('.tabs-entry:visible').fadeOut('fast', function(){
            tabsContainer.find('.tabs-entry').eq(tabIndex).fadeIn('fast', function(){tabsFinish = 0;});
        });
    });

    //accordeon
    $('.accordeon .entry .title').on('click', function(){
        $(this).parent().toggleClass('active');
        $(this).parent().find('.text').slideToggle('fast');
    });

    $('.categories-wrapper .entry.toggle').on('click', function(){
        $(this).toggleClass('active');
        $(this).next('.sub-wrapper').slideToggle('fast');
    });

    //gallery detail popup
    $('.sorting-item.open-popup').on('click', function(){
        $('.gallery-popup').addClass('active');
        var index = $(this).parent().find('.open-popup').index(this);
        swipers['swiper-'+$('.gallery-popup').find('.swiper-container').attr('id')].swipeTo(index, 0);
        $('body, html').toggleClass('overflow-hidden');
    });

    $('.gallery-popup .close-popup').on('click', function(){
        $('.gallery-popup').removeClass('active');
        $('body, html').toggleClass('overflow-hidden');
    });

    //open fullscreen preview popup
    $('.open-fullscreen').on('click', function(){
        $('.screen-preview-popup').addClass('active').find('.overflow img').attr('src', $(this).data('fullscreen'));
        $('body, html').toggleClass('overflow-hidden');
    });

    $('.screen-preview-popup .close-popup').on('click', function(){
        $('.screen-preview-popup').removeClass('active');
        $('body, html').toggleClass('overflow-hidden');
    });

    //checkbox
    $('.checkbox-entry.checkbox label').on('click', function(){
        $(this).parent().toggleClass('active');
        $(this).parent().find('input').click();
    });

    $('.checkbox-entry.radio label').on('click', function(){
        $(this).parent().find('input').click();
        if(!$(this).parent().hasClass('active')){
            var nameVar = $(this).parent().find('input').attr('name');
            $('.checkbox-entry.radio input[name="'+nameVar+'"]').parent().removeClass('active');
            $(this).parent().addClass('active');
        }
    });

    //responsive drop-down in gallery
    $('.responsive-filtration-title').on('click', function(){
        $(this).closest('.sorting-menu').toggleClass('active');
    });

    //mousehover on phone-icons block
    $('.phone-icons-description .entry').on('mouseover', function(){
        var thisWrapper = $(this).closest('.phone-icons-box'), val = thisWrapper.find('.phone-icons-description .entry').index(this)+1;
        thisWrapper.find('.phone-icons-image').eq(val).addClass('visible');
    });

    $('.phone-icons-description .entry').on('mouseleave', function(){
        $('.phone-icons-image').removeClass('visible');
    });


    /*==========================*/
    /* 09 - contact form submit */
    /*==========================*/
    var formPopupTimeout;
    $('.contact-form').on("submit", function(){
        clearTimeout(formPopupTimeout);

        $('.error-class').removeClass('error-class');
        var msg = 'The following fields should be filled:',
            error = 0,
            pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);


        if ($.trim($('.contact-form input[name="name"]').val()) === '') {error = 1; $('.contact-form input[name="name"]').addClass('error-class'); msg = msg +  '\n - Name';}
        if (!pattern.test($.trim($('.contact-form input[name="email"]').val()))) {error = 1; $('.contact-form input[name="email"]').addClass('error-class'); msg = msg +  '\n - Email';}
        if ($.trim($('.contact-form textarea[name="text"]').val()) === '') {error = 1; $('.contact-form textarea[name="text"]').addClass('error-class'); msg = msg +  '\n - Your Message';}

        if (error){
            $('.form-popup .text').text(msg);
            $('.form-popup').fadeIn(300);
            formPopupTimeout = setTimeout(function(){$('.form-popup').fadeOut(300);}, 3000);
        }else{
            var url = 'send_mail.php',
                name = $.trim($('.contact-form input[name="name"]').val()),
                email = $.trim($('.contact-form input[name="email"]').val()),
                subject = $.trim($('.contact-form input[name="subject"]').val()),
                department = $.trim($('.contact-form select[name="department"]').val()),
                text = $.trim($('.contact-form textarea[name="text"]').val()),
                mailto = $.trim($('.contact-form input[name="mailto"]').val());

            $.post(url,{'name':name,'email':email,'subject':subject,'department':department,'text':text,'mailto':mailto},function(data){
                $('.form-popup .text').text('Thank You for contacting us!');
                $('.form-popup').fadeIn(300);
                formPopupTimeout = setTimeout(function(){$('.form-popup').fadeOut(300);}, 3000);

                $('.contact-form').append('<input type="reset" class="reset-button"/>');
                $('.reset-button').click().remove();
            });
        }
        return false;
    });

    $(document).on('focus', '.error-class', function(){
        $(this).removeClass('error-class');
    });

    $('.form-popup-close-layer').on('click', function(){
        clearTimeout(formPopupTimeout);
        $('.form-popup').fadeOut(300);
    });

    $('.mouse-icon').on('click', function(){
        $('body, html').animate({'scroll-top':winH});
    });

    $('.back-to-top').on('click', function(){
        $('body, html').animate({'scroll-top':0});
    });


    /* eslam */
    $('a.submeny').on('click', function(){
        if($(this).hasClass('opened')){
            $('.opened').removeClass('opened');
        }else{
            $('.opened').removeClass('opened');
            $(this).addClass('opened');
        }
    });

});
