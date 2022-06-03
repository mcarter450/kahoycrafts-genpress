(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {

		$('.owl-carousel').owlCarousel({
			nav: true,
			loop: true,
			margin: 10,
			autoplay: true,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			lazyLoad: true,
			responsiveClass:true,
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 1
				},
				1000:{
					items: 1
				}
			}
		});

	});

})( jQuery );