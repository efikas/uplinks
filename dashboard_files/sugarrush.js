jQuery(document).ready(function() {

    jQuery('.btn-show-chat, .close-multi-panel').click(function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('collapsed-alertbar');
        jQuery(window).resize();
    });

    jQuery('.show-hide-sidebar').click(function(e) {
        e.preventDefault();
        jQuery('body').toggleClass('collapsed-sidebar');

        if (jQuery('body').hasClass('collapsed-sidebar')) {
            jQuery('#sidebar .nav-submenu').css('display', 'none');
        }
        else {
            jQuery('#sidebar .active').parent().find('.nav-submenu').css('display', 'block');
        }
    });

    /////////////////////////////////
    // CHECKBOXES AND RADIOS ////////
    /////////////////////////////////
    jQuery(':checkbox, :radio').labelauty({ label: false });

    /////////////////////
    // FILESTYLE ////////
    /////////////////////
    if (jQuery.fn.filestyle) {
        jQuery(":file").filestyle({icon: false});
    }

    /////////////////////
    // ANIMSITION ///////
    /////////////////////
    if (jQuery.fn.animsition) {
        jQuery('.animsition').animsition({
            inClass               :   'fade-in',
            outClass              :   'fade-out',
            inDuration            :    1500,
            outDuration           :    500,
            linkElement           :   'a:not([href^="#"]):not([target="_self"]):not([target="_blank"])',
            loading               :    true,
            loadingParentElement  :   'body', //animsition wrapper element
            loadingClass          :   'animsition-loading',
            unSupportCss          : [ 'animsition', '-webkit-animation-duration', '-o-animation-duration'],
            overlay               :   false,      
            overlayClass          :   'animsition-overlay-slide',
            overlayParentElement  :   'body'
        });
    }

    /////////////////////
    // SLIMSCROLL ///////
    /////////////////////
    if (jQuery.fn.slimScroll) {
        jQuery('#sidebar .sidebar_scroll').slimScroll({
            width: '250px',
            height: 'auto'
        });
        jQuery(window).resize(function() {
            jQuery('#sidebar .sidebar_scroll').slimScroll({
                width: '250px',
                height: 'auto'
            });
        });
        jQuery('.message-widget .mailscroll').slimScroll({
            height: '340px'
        });
        jQuery('.server-noti-scroll').slimScroll({
            height: '218px'
        });

        jQuery('#multi-panel .slimscroll').slimScroll({
            height: '100%'
        });
    }

    //////////////////////////
    // PANEL ANIMATION ///////
    //////////////////////////
    
    jQuery('div[class|="col"]').each(function() {
        var _t = jQuery(this);

        _t.addClass('animateme').addClass('scrollme');

        _t.attr('data-when', 'enter');
        _t.attr('data-from', '0.2');
        _t.attr('data-to', '0');
        _t.attr('data-crop', 'false');
        _t.attr('data-opacity', '0');
        _t.attr('data-scale', '0.5');
    });
    

    ////////////////////////////
    // PANEL SAME HEIGHT ///////
    ////////////////////////////
    var s_width = jQuery( window ).width();
    if (s_width >= 480) {
        jQuery('.row.same-height').each(function() {
            var _t = jQuery(this);
            var _h = _t.height();

            _t.find('> div[class|="col"]').each(function() {
                var _col = jQuery(this);
                _col.height(_h);

                _col.find('.panel').each(function() {
                    var _panel = jQuery(this);
                    _panel.css({
                        'position': 'absolute',
                        'bottom' : '0px',
                        'top' : '0px',
                        'left' : '10px',
                        'right' : '10px'
                    });
                });

            });
        });
    }

    //////////////////////////////
    // PANEL HEADING ICONS ///////
    //////////////////////////////
    jQuery('.panel-heading-icons .panel-close').on('click', function(e) {
        e.preventDefault();
        var _t = jQuery(this);
        _t.closest('.panel').fadeOut(300, function() {
            jQuery(this).remove();
        });
    });

    jQuery('.panel-heading-icons .panel-toggle').on('click', function(e) {
        e.preventDefault();
        var _t = jQuery(this);
        _t.closest('.panel').find('.panel-body').slideToggle();
    });

	//////////////////////////
    // SIDEBAR SUBMENU ///////
    //////////////////////////
	jQuery('#sidebar .nav#main-nav > li > ul').each(function() {
		var _t = jQuery(this);
		var _li = _t.parent();
		var _a = _li.find('> a');

		_a.click(function(e) {
			e.preventDefault();

            var s_width = jQuery( window ).width();
            if ((s_width >= 768) && (!jQuery('body').hasClass('collapsed-sidebar')) ) {
                if (!_a.hasClass('active')) {
                    jQuery('#sidebar .nav a.active').removeClass('active').parent().find('> ul').slideToggle();
                }

    			_a.toggleClass('active');
    			_t.slideToggle();
            }
		})

        if (_t.find('.active_submenu').length > 0) {
            _a.click();
        }
	});
    
    ////////////////////////
    // FIX ON SCROLL ///////
    ////////////////////////
    var s_width = jQuery( window ).width();
    if (s_width >= 990) {
        jQuery('.fix-on-scroll').each(function () {
            var _t = jQuery(this);
            var _treshhold = _t.offset().top-80;

            jQuery(window).scroll(function () {
                        
                if (jQuery(window).scrollTop() > _treshhold) {
                    var _dif = jQuery(window).scrollTop() - _treshhold;
                    _t.css('margin-top', _dif);
                }
                else {
                    _t.css('margin-top', '0px');
                }

            });
        });
    }

    ////////////////////////
    // Go To TOP ///////////
    ////////////////////////
    var _treshhold_goto = (jQuery(window).height()/2);

    jQuery(window).scroll(function () {
                
        if (jQuery(window).scrollTop() > _treshhold_goto) {
            jQuery('.scroll-top').fadeIn();
        }
        else {
            jQuery('.scroll-top').fadeOut();
        }

    });
    

    ////////////////////////////////
    // TOOLTIPS AND POPOVERS ///////
    ////////////////////////////////
    jQuery('[data-toggle="tooltip"]').tooltip();
    jQuery('.example-popover').popover();


    // ScrollTOP
    jQuery('.scroll-top').click(function() {
        jQuery(document).scrollTo(0, 300);
    });


    // Search field
    jQuery('.navbar-search-block .search-field').focus(function(e) {
        e.preventDefault();
        var pos = jQuery('.navbar-search-block').offset();
        pos.top -= jQuery(window).scrollTop();
        pos.bottom -= jQuery(window).scrollTop();

        if (!jQuery('.navbar-search-block').attr('data-top')) {
            jQuery('.navbar-search-block').attr('data-top', pos.top);
            jQuery('.navbar-search-block').attr('data-left', pos.left);
            jQuery('.navbar-search-block').attr('data-width', jQuery('.navbar-search-block').width()+30);
            jQuery('.navbar-search-block').attr('data-height', jQuery('.navbar-search-block').height());
        }
        jQuery('.navbar-search-block').css({
            position: 'fixed',
            top: (pos.top-10)+'px',
            left: pos.left+'px',
            bottom: pos.bottom+'px',
            right: pos.right+'px',
            'z-index': 9999
        }).animate({
            top: '0px',
            left: '0px',
            right: '0px',
            bottom: '0px',
            width: '100%',
            height: '100%',
            margin: '0px'
        }, 300, function() {
            jQuery('.navbar-search-block:not(.open-search) .search-field').focus();
            jQuery('.navbar-search-block .search-container, .navbar-search-block .search-close').fadeIn(300);

        }).addClass('open-search');
    });
    jQuery('.navbar-search-block .search-close').click(function(e) {
        e.preventDefault();
        jQuery('.navbar-search-block .search-close').fadeOut(200);
        jQuery('.navbar-search-block .search-container').fadeOut(200, function() {
            jQuery('.navbar-search-block').animate({
                top: jQuery('.navbar-search-block').attr('data-top'),
                left: jQuery('.navbar-search-block').attr('data-left'),
                width: jQuery('.navbar-search-block').attr('data-width'),
                height: jQuery('.navbar-search-block').attr('data-height')
            }, 300, function() {
                jQuery('.navbar-search-block').css({
                    position: 'relative',
                    left: '5px',
                    top: '8px',
                    margin: '0px 15px 0px 5px'
                });
            }).removeClass('open-search');
        });
    });

});