jQuery(document).ready(function( $ ) {
	'use strict';

    // Passive Touch
    $.event.special.touchstart = {
        setup: function( _, ns, handle ) {
            this.addEventListener('touchstart', handle, { passive: !ns.includes('noPreventDefault') });
        }
    };

    // Dark Switch
    $('#fl-darkmode').change(function() {
        var theme = 'light';
        if ( $(this).is(':checked') ) {
            document.documentElement.setAttribute('data-theme', 'dark');
            theme = 'dark';
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }
        document.cookie = 'buzzmag_color_theme=' + theme + '; path=/; SameSite=None; Secure';
    });

	// Overlay Search
	$('#fl-topsearch').click(function () {
		if ( $('#fl-topsearch .fa-times').css('display') == 'none' ) {

            $.when( $('#fl-topsearch .fa-search').fadeOut(100) ).done(function() {
                $('#fl-topsearch .fa-times').fadeIn(200);
                $('#fl-search-overlay').fadeIn(200);
                $('.overlay-search .searchform input[type="text"]').focus();
            });

            $('.push-overlay').removeClass('open');
            $('#fl-drawer').removeClass('open');
            $('#fl-drawer-icon').removeClass('active');
        } else {
            $.when( $('#fl-topsearch .fa-times').fadeOut(100) ).done(function() {
                $('#fl-search-overlay').fadeOut(200);
                $('#fl-topsearch .fa-search').fadeIn(200);
                $('.overlay-search .searchform input[type="text"]').blur(); 

                $('body').css('overflow-y', 'auto');
            });
        }
	});
    $('#fl-search-overlay').click(function (e){
        var container = $('.overlay-search');
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('#fl-topsearch .fa-times').fadeOut(100);
            $('#fl-search-overlay').fadeOut(100);
            $('#fl-topsearch .fa-search').delay(100).fadeIn(100);
            $('.overlay-search .searchform input[type="text"]').blur();

            $('body').css('overflow-y', 'auto');
        }
    });

    // Drawer
	$('#fl-drawer-icon').click(function() {
        if( $('#fl-drawer-icon').is('.active') ) {
            $('.push-overlay').removeClass('open');
            $('#fl-drawer').removeClass('open');
            $('#fl-drawer-icon').removeClass('active');

            $('body').css('overflow-y', 'auto');

        } else {            
            setTimeout(function(){
                $('.push-overlay').addClass('open');
                $('#fl-drawer').addClass('open');
            }, 200);
            
            $('#fl-drawer-icon').addClass('active');

            $('#fl-topsearch .fa-times').fadeOut(100);
            $('#fl-search-overlay').fadeOut(200);
            $('#fl-topsearch .fa-search').delay(100).fadeIn(200);            
            $('.overlay-search .searchform input[type="text"]').blur();

            $('body').css('overflow-y', 'hidden');
        }
	});

	$('.push-overlay').click(function() {
		$('.push-overlay').removeClass('open');
		$('#fl-drawer').removeClass('open');
        $('#fl-drawer-icon').removeClass('active');

        $('body').css('overflow-y', 'auto');
	});

	// FitVids
    $('.fl-media-wrap').fitVids();

	// Widget Menu Toogle
    $('.fl-widget .menu .menu-item-has-children .arrow').click(function () {
        $(this).parent().children('.sub-menu').slideToggle(200);
        $(this).toggleClass('open');
    });

    // Header Offset -> Used in Multiple Events
    var headerOffset = 0;
    if ( $('#fl-header').css('position') === 'fixed' ) {
        headerOffset = $('#fl-header').height();
    }
    // Case Login
    if ( $('#wpadminbar').css('position') === 'fixed' ) {
        headerOffset = headerOffset + $('#wpadminbar').outerHeight();
    }

    // Loop Tabs sticky position
    if ( $('.fl-loop-tabs').css('position') === 'sticky' ) {
        $('.fl-loop-tabs').css('top', headerOffset + 'px');
    }

    // Sticky Sideabr
    $('.fl-sticky-sidebar').theiaStickySidebar({
        additionalMarginTop: headerOffset,
    });

    // Scroll To Top
    var offset = 250; 
    $( window ).scroll(function() {     
        if ( $(this).scrollTop() > offset ) {         
            $( '#fl-top' ).animate( { bottom:'8px' }, 0 );
        } else {     
            $( '#fl-top' ).animate( { bottom:'-48px' }, 0 );
        }
    }); 
    $( document ).on( 'click', '#fl-top, .fl-back-to-top', function(event) { 
        event.preventDefault(); 
        $( 'html, body' ).stop().animate( { scrollTop: 0 }, 500 ); 
        return false; 
    });
    

    // RTL Check
    var rtlVal = false;
    if ( $('body').hasClass('rtl') ) {
        rtlVal = true;
    }

    // Gallery Post Slider
    $('.fl-gallery').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        rtl: rtlVal,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
    });

    if ( $('#fl-sidebar').hasClass('fl-left') ) {
        $('.owl-carousel .owl-nav').css('left', '0');
        $('.owl-carousel .owl-nav').css('right', 'auto');
    }

    if ( $('#fl-sidebar').hasClass('fl-right') ) {
        $('.owl-carousel .owl-nav').css('right', '0');
        $('.owl-carousel .owl-nav').css('left', 'auto');
    }


    // Comments
    $('.fl-comments-toggle').click(function(event) {
        event.preventDefault();
        var toggleWidth = $(this).width() > 240 ? '240px' : '100%';
        $(this).animate({ width: toggleWidth }, 200);
        $('.fl-comments').slideToggle(200);
    });

    $('.fl-meta a.comments').click(function(event) {
        event.preventDefault();
        $.when( $('html,body').animate( { scrollTop: $('.fl-comments-toggle').offset().top - headerOffset }, 500 ) ).done(function() {
            $('.fl-comments-toggle').animate({ width: '100%' }, 200);
            $('.fl-comments').slideDown(200);
        });
    });


    // Masonry
    function masonryLayout() {
        if ( $('.fl-masonry').length > 0 ) {
            $('.fl-masonry .fl-loop-posts').each( function() {
                var masonry = new Masonry(this, {
                    itemSelector: '.fl-post',
                    horizontalOrder: true,
                    transitionDuration: '0.2s',
                });
            });
        }
    }
    masonryLayout();


//----------------------------------------------------------
// AJAX VIEWS COUNTER
//---------------------------------------------------------
    // Set Posts Views Ajax
    if ( $('body').hasClass('single-post') ) {
        var postID = $('.fl-article').attr('post-id');
        $.ajax({
            type: 'POST',
            url: buzzmag.ajaxurl,
            data: {
                'postID': postID,
                'action': 'buzzmag_setpostviews'
            },
            success: function (result) {},
            error: function(result) {
                console.log('result');
            }
        });
    }


//----------------------------------------------------------
// AJAX MEGA MENU
//---------------------------------------------------------
    // Mega Menu Tabs
    $('.fl-megamenu .cats-list .cat-link').click(function() {
        var tab = $(this).parent('.cats-list').parent('.megamenu'),
            height = tab.find('.megamenu-list').first().outerHeight(true),
            megaMenu = $($(this).attr('href')),
            termID = $(this).attr('cat-id');

        tab.css('min-height', height+40);
        tab.find('.megamenu-list').hide();
        tab.find('.fl-loading, .fl-error').remove();

        $(this).addClass('active').siblings().removeClass('active');

        if ( !megaMenu.hasClass('ajax-loaded') ) {

            megaMenu.addClass('ajax-loaded');

            tab.append('<div class="fl-loading animate-loading">...</div>');
            tab.find('.fl-loading').css('line-height', height+'px');

            $.ajax({
                type: 'POST',
                url: buzzmag.ajaxurl,
                data: {
                    'term_id': termID,
                    'action': 'buzzmag_megamenu_posts_ajax'
                },
                success: function (result) {
                    megaMenu.append(result);
                    $.when( tab.find('.fl-loading').fadeOut() ).done(function() {
                        megaMenu.fadeIn();
                    });           
                },
                error: function(result) {
                    megaMenu.removeClass('ajax-loaded');
                    $.when(tab.find('.fl-loading').fadeOut()).done(function() {                            
                        tab.append('<div class="fl-error">Error! Cannot retrive category posts.</div>');
                        tab.find('.fl-error').css('line-height', height+'px');
                    });
                }
            });
        } else {
            megaMenu.fadeIn();
        }          
        return false;
    });


//----------------------------------------------------------
// AJAX PAGINATION & Loop Tabs
//---------------------------------------------------------
    // Tabs Ajax
    $('.fl-loop-tabs a').click(function() {

        var tab = $(this),
            panel = $($(this).attr('href')),
            tabLoop = $(this).attr('tab-loop'),
            fixedTabsTop = $('#fl-post-container').offset().top - headerOffset,
            time = 100;

            if (  ( $(window).scrollTop() - fixedTabsTop ) > 300 || ($(window).scrollTop() - fixedTabsTop ) < -300 ) {
                time = 500;
            }

        $.when( $('html,body').animate( { scrollTop: $('#fl-post-container').offset().top - headerOffset  }, time ) ).done(function() {

            if ( tab.hasClass('active') ) {
                return false;
            }
                       
            $('.fl-loop-section').hide();
            tab.addClass('active').siblings().removeClass('active');

            panel.parent('div').find('.fl-loading, .fl-error').remove();
            panel.find('.fl-loading, .fl-error').remove();

            if ( !panel.hasClass('ajax-loaded') ) {

                panel.addClass('ajax-loaded');

                panel.parent('div').append('<div class="fl-loading animate-loading">...</div>');

                $.ajax({
                    type: 'POST',
                    url: buzzmag.ajaxurl,
                    data: {
                        'next': 1,
                        'loop': tabLoop,
                        'thumb_size': buzzmag.thumb_size,
                        'action': 'buzzmag_loops_ajax'
                    },
                    success: function (result) {
                        panel.append(result);
                        $.when( panel.parent('div').find('.fl-loading').fadeOut() ).done(function() {
                            panel.fadeIn();
                            masonryLayout();
                        });        
                    },
                    error: function(result) { 
                        panel.removeClass('ajax-loaded');                    
                        panel.append('<div class="fl-error">Error! Cannot retrive loop posts.</div>');
                        $.when(panel.parent('div').find('.fl-loading').fadeOut()).done(function() {
                            panel.fadeIn();
                        });
                    }
                });
            } else {
                panel.fadeIn();
                masonryLayout();
            }
        });

        return false;
    });



    // Ajax Pagination
    function ajax_pagination(element) {

        var current = parseInt( element.attr('current-page') ),
            max = parseInt( element.attr('max-pages') ),
            loop = element.attr('data-loop'),
            next = current+1,
            panel = $( element.parent('div') );

        element.hide();
        panel.find('.fl-loading, .fl-error').remove();
        panel.append('<div class="fl-loading animate-loading">...</div>');

        $.ajax({
            type: 'POST',
            url: buzzmag.ajaxurl,
            data: {
                'next': next,
                'loop': loop,
                'query_vars': buzzmag.query_vars,
                'thumb_size': buzzmag.thumb_size,
                'action': 'buzzmag_loops_ajax'
            },
            success: function (result) {
                $.when( panel.find('.fl-loading').fadeOut() ).done(function() {
                    panel.find('.fl-loop-posts').append(result);
                    masonryLayout();
                    element.attr('current-page', next);
                    if ( next < max ) {
                        element.show();
                    } else {
                        element.remove();
                        panel.append(buzzmag.ajax_end);
                    }
                });
            },
            error: function(result) { 
                $.when( panel.find('.fl-loading').fadeOut() ).done(function() {
                    panel.append('<div class="fl-error">Error! Cannot retrive loop posts.</div>');
                    element.show();
                });
            }
        });
    }

    // Click Load More
    $(document).on( 'click', '.fl-load-more', function(event) {  
        var element = $(this);
        ajax_pagination(element);
        event.preventDefault();
    });


    // Infintie Scroll Load More
    var latest = false,
        trending = false,
        audio = false,
        video = false,
        gallery = false;
    $(window).scroll( function(){
        var latestButton = $('#fl-latest-posts .fl-load-more.infinite'),
            trendingButton = $('#fl-trending-posts .fl-load-more.infinite'),
            audioButton = $('#fl-audio-posts .fl-load-more.infinite'),
            videoButton = $('#fl-video-posts .fl-load-more.infinite'),
            galleryButton = $('#fl-gallery-posts .fl-load-more.infinite');

        // Latest
        if ( latestButton.length ) {
            if ( ( $(window).scrollTop() - latestButton.offset().top ) > -500 ) {
                if ( latest == false ){
                    ajax_pagination(latestButton);
                    latest = true;
                }
            } else {
                latest = false;
            }
        }

        // Trending
        if ( trendingButton.length ) {
            if ( ( $(window).scrollTop() - trendingButton.offset().top ) > -500 ) {
                if ( trending == false ){
                    ajax_pagination(trendingButton);
                    trending = true;
                }
            } else {
                trending = false;
            }
        }

        // Audio
        if ( audioButton.length ) {
            if ( ( $(window).scrollTop() - audioButton.offset().top ) > -500 ) {
                if ( audio == false ){
                    ajax_pagination(audioButton);
                    audio = true;
                }
            } else {
                audio = false;
            }
        }

        // Video
        if ( videoButton.length ) {
            if ( ( $(window).scrollTop() - videoButton.offset().top ) > -500 ) {
                if ( video == false ){
                    ajax_pagination(videoButton);
                    video = true;
                }
            } else {
                video = false;
            }
        }

        // Gallery
        if ( galleryButton.length ) {
            if ( ( $(window).scrollTop() - galleryButton.offset().top ) > -500 ) {
                if ( gallery == false ){
                    ajax_pagination(galleryButton);
                    gallery = true;
                }
            } else {
                gallery = false;
            }
        }
    });

    // Channel-Wise Filter Tabs (legacy tab support if present)
    if ( $('.fl-channel-filter-tabs').length ) {
        $('.fl-channel-filter-tabs .fl-ch-tab').click(function(e) {
            e.preventDefault();
            var targetCh = $(this).attr('data-channel');
            $(this).addClass('active').siblings().removeClass('active');

            if ( targetCh === 'all' ) {
                $('.fl-channel-section-block').fadeIn(200);
            } else {
                $('.fl-channel-section-block').hide();
                $('.fl-channel-section-block.' + targetCh).fadeIn(200);
            }
        });
    }
    
});
