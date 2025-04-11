jQuery( document ).ready( function( $ ) {

	var doc = $( document ),
		win = $( window ),
		body = $( document.body );

	// body events and manipulation
	body.on( 'click', 'a[rel~="external"]', function( e ) {
		// rel="external" opens in new window
		e.preventDefault();
		window.open( this.href );
		return false;
	} );

	$( '.header-alert__close' ).on( 'click', function() {
		// Header alert close
		$( '.header-alert' ).slideUp( 400 );
		sessionStorage.setItem( 'travelWarning', 'closed' );
	} );

	if ($( '.hundred-years-accordion' ).length > 0) {
		$( '.accordion__row:first-of-type' ).toggleClass( "active" );
		$( '.accordion__row:first-of-type .accordion__content' ).slideDown();
	}


	// ======================================================================
	// Travel warning alert
	// ======================================================================

	if ('closed' != sessionStorage.getItem( 'travelWarning' )) {
		// has not closed the travel warning yet this session
		var header_alert = $( '.header-alert' );
		if (header_alert.length) {
			header_alert.slideDown( 300 );
		}
	}


	// ======================================================================
	// Navigation - Click based
	// ======================================================================
	function bedstoneNav() {
		var doc = ('undefined' === typeof (doc)) ? $( document ) : doc,
			win = ('undefined' === typeof (win)) ? $( window ) : win,
			body = ('undefined' === typeof (body)) ? $( document.body ) : body,
			nav_main = $( '.nav-main' ).first(),
			toplevels = nav_main.find( '.nav-main__item' ),
			submenus = nav_main.find( '.nav-main__submenu' ),
			winWidth = window.innerWidth,
			timeout_resize = null;

		function doResetNav() {
			if (winWidth != window.innerWidth) {
				body.removeClass( 'nav-main--active' );
				toplevels.removeClass( 'nav-main__item--active' );
				toplevels.children( 'a' ).attr( 'aria-expanded', false );
				submenus.css( 'display', '' );
				winWidth == window.innerWidth;
			}
		}

		doc.on( 'click', function( e ) {
			if (!$( e.target ).closest( toplevels ).length) {
				toplevels.removeClass( 'nav-main__item--active' );
				toplevels.children( 'a' ).attr( 'aria-expanded', false );
			}
		} );

		body
			.on( 'click', '.toggle-nav-main', function( e ) {
				e.preventDefault();
				body.toggleClass( 'nav-main--active' );
			} )
			.on( 'click', '.nav-main__item a', function( e ) {
				// e.preventDefault(); -- this is making links non-clickable
				var target = $( e.target );
				if (!target.closest( submenus ).length) {
					toplevel = target.closest( toplevels );
					if (toplevel.find( submenus ).length) {
						e.preventDefault();
						if (!body.hasClass( 'nav-main--active' )) {
							// mobile nav is not active or is desktop view
							toplevels.not( toplevel ).removeClass( 'nav-main__item--active' );
							toplevels.children( 'a' ).attr( 'aria-expanded', false );
						} else {
							// mobile nav is active
							toplevel.find( submenus ).slideToggle( 300 );
						}
						$( toplevel ).toggleClass( 'nav-main__item--active' );
						if (toplevel.hasClass( 'nav-main__item--active' )) {
							toplevel.children( 'a' ).attr( 'aria-expanded', true );
						} else {
							toplevel.children( 'a' ).attr( 'aria-expanded', false );
						}
					}
				}
			} );

		win.resize( function() {
			window.clearTimeout( timeout_resize );
			timeout_resize = window.setTimeout( doResetNav, 200 );
		} );

	}

	bedstoneNav();


	// ======================================================================
	// Mobile Nav - mmenu
	// ======================================================================

	if ($( '#mobile_menu' ).length > 0) {

		$( "button.toggle-mmenu" ).on( 'click', function() {
			if ($( this ).attr( 'aria-expanded' ) === 'true') {
				$( this ).attr( 'aria-expanded', 'false' );
			} else {
				$( this ).attr( 'aria-expanded', 'true' );
			}

			$( 'html' ).toggleClass( 'mobile_menu-open' );
			$( '.nav-mobile__wrap' ).slideToggle();
		} );

		$( 'li.menu-item-has-children' ).attr( 'aria-expanded', false );

		$( 'li.menu-item-has-children' ).on( 'click', function( e ) {
			// e.preventDefault(); -- same thing here
			$( this ).attr( 'aria-expanded', true );
			$( this ).toggleClass( 'menu_active' );
			$( this ).children( 'ul.sub-menu' ).slideToggle();
			$( this ).siblings().attr( 'aria-expanded', false );
			$( this ).siblings().removeClass( 'menu_active' );
			$( this ).siblings().children( 'ul.sub-menu' ).slideUp();
		} );

	}


	// ======================================================================
	// SelectBoxIt
	// ======================================================================

	// $('select').selectBoxIt({});


	// ======================================================================
	// Scroll to ID - scroll to target on trigger click
	// ======================================================================
	function scrollToId( triggerEl, targetEl ) {
		var $trigger = $( triggerEl );
		var $target = $( targetEl );

		if ($trigger && $target) {
			body.on( 'click', triggerEl, function( event ) {
				// event.preventDefault(); -- this causes the focus to not switch to #booking
				var theOffset = $target.offset();
				$( 'body,html' ).animate( {scrollTop: theOffset.top}, 500 );
				$( '#bookingIframe' ).focus(); // can't target the section id="booking" but the iframe works...?
			} );
		}
	}

	scrollToId( '.trigger-booking', '#booking' );


	// ======================================================================
	// Generate container for Google Maps embeds via wysiwyg
	// ======================================================================
	$( '.content iframe[src^="https://www.google.com/maps/embed"]' )
		.addClass( 'content__google-maps__frame' )
		.wrap( '<span />' )
		.parent()
		.addClass( 'content__google-maps__overlay' )
		.wrap( '<span />' )
		.parent()
		.addClass( 'content__google-maps' )
		.attr( {
			"role": "region",
			"aria-label": "map"
		} )
		.click( function() {
			// pointer events disabled by css, so enable them via class
			$( this ).find( '.content__google-maps__frame' ).addClass( 'content__google-maps__frame--active' );
		} );


	// ======================================================================
	// WD Modal WiFi popup
	// ======================================================================
	if ($( '#wd_modal_wifi' ).length) {

		if (localStorage.getItem( 'wifi-terms' ) == 'yes') {
			$( '.wd-modal__overlay' ).css( 'display', 'none' );
		} else {
			localStorage.setItem( 'wifi-terms', 'no' );
			$( '.wd-modal__overlay' ).fadeIn( 300 );
		}

		// Reveal Terms and Conditions
		$( '.toggle--wifi-terms' ).click( function() {
			$( '.target--wifi-terms' ).slideDown( 300 );
		} );

		// Form handling
		$( '#form-submit' ).click( function( e ) {
			e.preventDefault();
			var termsCheck = $( '#wifi-terms' ).attr( 'checked' );
			var signupCheck = $( '#wifi-signup' ).attr( 'checked' );
			var emailInput = $( '#wifi_email_input' ).val();

			// error if terms are not checked
			if (!termsCheck) {
				alert( 'Please agree to the Terms and Conditions' );
				return;
			}
			// error if signup is checked but no email given
			else if (signupCheck && !emailInput) {
				alert( 'Please enter your email to subscribe to our Newsletter.' );
				return;
			}
			// close modal if signup is not checked (and terms are checked)
			else if (termsCheck && !signupCheck) {
				localStorage.setItem( 'wifi-terms', 'yes' );
				$( '.wd-modal__overlay' ).fadeOut( 300 );
				return;
			} else {
				localStorage.setItem( 'wifi-terms', 'yes' );
				$( 'form' ).submit();
			}
		} );

		// Opt-out faux-link
		$( '#form_opt_out' ).click( function() {
			var termsCheck = $( '#wifi-terms' ).attr( 'checked' );
			var signupCheck = $( '#wifi-signup' ).attr( 'checked' );

			// error if terms are not checked
			if (!termsCheck) {
				alert( 'Please agree to the Terms and Conditions' );
				return;
			}
			// error if signup is checked
			else if (signupCheck) {
				alert( 'Please enter your email to subscribe to our Newsletter.' );
				return;
			} else {
				localStorage.setItem( 'wifi-terms', 'yes' );
				$( '.wd-modal__overlay' ).fadeOut( 300 );
				return;
			}
		} );

	}


	// ======================================================================
	// Testimonials slider
	// ======================================================================
	var charter_testimonials_unslider = $( '.charter-testimonials__unslider' );
	if (charter_testimonials_unslider.length) {
		charter_testimonials_unslider.unslider( {
			keys: false,
			nav: false,
			arrows: {
				prev: '<button type="button" class="charter-testimonials__arrow unslider-arrow prev"><i aria-hidden="true"  class="fa fa-angle-left" title="Previous Slide"></i><span class="screen-reader-text">Previous slide</span></button>',
				next: '<button type="button" class="charter-testimonials__arrow unslider-arrow next"><i aria-hidden="true" class="fa fa-angle-right" title="Next Slide"></i><span class="screen-reader-text">Next slide</span></button>',
			}
		} );
	}

	// ======================================================================
	var extra_testimonials_unslider = $( '.extra-testimonials__unslider' );
	if (extra_testimonials_unslider.length) {
		extra_testimonials_unslider.unslider( {
			keys: false,
			nav: false,
			arrows: {
				prev: '<button type="button" class="extra-testimonials__arrow unslider-arrow prev"><i aria-hidden="true" class="fa fa-angle-left" title="Previous Slide"></i><span class="screen-reader-text">Previous slide</span></button>',
				next: '<button type="button" class="extra-testimonials__arrow unslider-arrow next"><i aria-hidden="true" class="fa fa-angle-right" title="Next Slide"></i><span class="screen-reader-text">Next slide</span></button>',
			}
		} );
	}

	function sliderArrows() {
		var testimonialUnSliderWidth = $( '.extra-testimonials .unslider' ).width(),
			windowWidth = $( window ).width(),
			placementArrow = $( (windowWidth - testimonialUnSliderWidth) / 2 );

		$( '.extra-testimonials__arrow.prev' ).css( {
			'left': placementArrow
		} );
		$( '.extra-testimonials__arrow.next' ).css( {
			'right': placementArrow
		} );
	}

	function charterSliderArrows() {
		var charterTestimonialUnSliderWidth = $( '.charter-testimonials .unslider' ).width(),
			charterWindowWidth = $( window ).width(),
			charterPlacementArrow = $( (charterWindowWidth - charterTestimonialUnSliderWidth) / 2 );

		$( '.charter-testimonials__arrow.prev' ).css( {
			'left': charterPlacementArrow
		} );
		$( '.charter-testimonials__arrow.next' ).css( {
			'right': charterPlacementArrow
		} );
	}

	sliderArrows();
	charterSliderArrows();

	$( window ).resize( function() {
		sliderArrows();
		charterSliderArrows();
	} );

	/**
	 * Fancybox Functions
	 */

	$( '[data-fancybox]' ).fancybox( {
		buttons: [
			'slideShow',
			'thumbs',
			'close'
		],
		infobar: true,
		loop: true,
		protect: true,
		animationEffect: 'zoom',
		transitionEffect: 'circular',
		youtube: {
			controls: 0,
			showinfo: 0
		},
		vimeo: {
			color: '000'
		}
	} );

	/**
	 * Accordion
	 */
	if ($( '.hundred-years-accordion' ).length > 0) {

		$( '.accordion__title' ).click( function() {

			$( this ).parents( '.accordion__row' ).toggleClass( "active" );
			$( this ).siblings( '.accordion__content' ).slideToggle();

			$( this ).parents( '.accordion__row' ).siblings( '.accordion__row' ).removeClass( 'active' );
			$( this ).parents( '.accordion__row' ).siblings( '.accordion__row' ).children( '.accordion__content' ).slideUp();

		} );

	}

	if ($( '.counter' ).length > 0) {
		$( '.counter' ).counterUp( {
			delay: 15,
			time: 2000
		} );
	}


	// ======================================================================
	// Iframe load on resize
	// ======================================================================
	var timeout_iframe = null;
	var lazy_iframe = $( '.lazy-iframe' );
	doLoadIframe();
	win.resize( function() {
		window.clearTimeout( timeout_iframe );
		timeout_iframe = window.setTimeout( doLoadIframe, 200 );
	} );

	function doLoadIframe() {
		console.log( 'start doLoadIframe()' );
		if (lazy_iframe.length && !lazy_iframe.children( 'iframe' ).length) {
			var winWidth = window.innerWidth;
			lazy_iframe.each( function() {
				_this = $( this );
				// console.log('children: ' + _this.children('iframe').length);
				if (!_this.children( 'iframe' ).length) {
					var iframeWidth = _this.data( 'width' );
					console.log( 'iframeWidth = ' + iframeWidth );
					if (winWidth > iframeWidth) {
						// console.log(_this.data('id'));
						// console.log(_this.data('frameborder'));
						// console.log(_this.data('src'));
						var new_iframe = $( '<iframe />' )
							.attr( 'id', _this.data( 'id' ) )
							.attr( 'frameborder', _this.data( 'frameborder' ) )
							.attr( 'src', _this.data( 'src' ) )
							.attr( "title", "Ticket Booking Search Form" );
						_this.append( new_iframe );
					}
				}
			} );
		}
		console.log( 'end doLoadIframe()' );
	}

	if ($( '.wow' ).length > 0) {
		new WOW().init();
	}

	// ======================================================================
	// Iframe Resizer
	// ======================================================================
	// $('.iframe-wrapper iframe').iFrameResize({
	//     log: false,
	//     heightCalculationMethod: 'bodyOffset',
	//     checkOrigin: false,
	//     enablePublicMethods: true
	// });

	// ======================================================================
	// Add icon to post/page CTA links
	// ======================================================================
	// if ($('article.post').length > 0) {
	//     var callToAction = $('article.post p.call-to-action > a').not(':has(i)');;
	//     callToAction.each(function(i) {
	//         $(this).append(' <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>');
	//     });
	// }

	// if ($('article.page').length > 0) {
	//     var callToAction = $('article.page p.call-to-action > a').not(':has(i)');
	//     callToAction.each(function(i) {
	//         $(this).append(' <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>');
	//     });
	// }

	/**
	 * Fixed nav on scroll
	 */
	


} );
