(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {
	
		var distance  = 950;               // Scroll distance in pixel.
		var expireKey = 'newsletter';      // Name of the localStorage timestamp.
		var popupId   = '#newsletter-popup'; // ID of the popup to display.

		var $popup = $('#newsletter-popup')
		if ($popup.length === 0) {
			return;
		}

		$popup.find('.close').on('click', function() {
			$popup.hide()
		})

		function maybeShowPopup() {
			// Check if the user scrolled far enough.
			if ( $(window).scrollTop() < distance ) {
				return;
			}

			// Remove the custom scroll event, to avoid displaying the popup multiple times.
			$( window ).off( 'scroll.popup_' + expireKey );

			// Check, if the popup was displayed already today.
			if ( window.localStorage ) {
				var nextPopup = localStorage.getItem( expireKey );

				if (nextPopup > new Date()) {
					return;
				}

				var expires = new Date();
				expires = expires.setHours(expires.getHours() + 24);
				localStorage.setItem( expireKey, expires );
			}

			$popup.addClass('expand')
		}

		// Attach the scroll listener to the window.
		$(window).on( 'scroll.popup_' + expireKey, maybeShowPopup );
	
	});

})( jQuery );