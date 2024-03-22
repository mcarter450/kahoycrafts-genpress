(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {

		if ( $('.product.product-type-variable').length != 0 ) {
			// Variable product
			$(document).on( 'found_variation', 'form.cart', function( event, variation ) {
				let item_name = $('.product .summary .product_title.entry-title').text();

				if (variation.attributes) {

					item_name += ' - ';

					let attributes = [];

					for (let attribute in variation.attributes) {
						attributes.push(variation.attributes[attribute]);
					}

					item_name += attributes.join(', ');
				}

				gtag('event', 'view_item', {
					'value': variation.display_price,
					'currency': 'USD',
					'items': [{
						'item_id': String(variation.variation_id),
						'item_name': item_name
					}]
				});
			});
		}
		else {
			// Simple product
			const value = $('.product .summary .price .amount > bdi').text(),
			  	  item_id = $('form.cart button[type=submit]').val(), 
			  	  item_name = $('.product .summary .product_title.entry-title').text();

			gtag('event', 'view_item', {
				'value': Number(value.replace(/[^0-9.]+/g, '')),
				'currency': 'USD',
				'items': [{
					'item_id': item_id,
					'item_name': item_name
				}]
			});
		}
		
	});

})( jQuery );
