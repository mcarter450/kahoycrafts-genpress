<?php
//* Code goes here
require(__DIR__ .'/custom-post-types/testimonial.php');
require(__DIR__ .'/classes/kahoycrafts_product_categories_widget.php');
require(__DIR__ .'/classes/kahoycrafts_cloudflare_turnstile.php');
require(__DIR__ .'/classes/kahoycrafts_big_mailer.php');

//    ------    ------------ ------------ --------    --------   ----    ---- ------------ 
//   ********   ************ ************ ********   **********  *****   **** ************ 
//  ----------  ---          ------------   ----    ----    ---- ------  ---- ----         
// ****    **** ***              ****       ****    ***      *** ************ ************ 
// ------------ ---              ----       ----    ---      --- ------------ ------------ 
// ************ ***              ****       ****    ****    **** ****  ******        ***** 
// ----    ---- ------------     ----     --------   ----------  ----   ----- ------------ 
// ****    **** ************     ****     ********    ********   ****    **** ************ 

add_action( 'widgets_init', function() {
	register_widget( 'kahoycrafts_product_categories_widget' );
} );

add_action( 'wp_enqueue_scripts', 'kahoy_crafts_styles', 11, 0 );

function kahoy_crafts_styles() {

	// Disable subscription styles
	wp_dequeue_style( 'wcs-checkout' );
	wp_dequeue_style( 'wc-blocks-integration' );
	
	wp_dequeue_script( 'wcs-single-product' );
	wp_dequeue_script( 'wcs-cart' );

	// Disable cart fragments - not used in generatepress theme
	wp_dequeue_script( 'wc-cart-fragments' );

	wp_dequeue_style( 'generate-child' );

	// Disable useless styles
	wp_dequeue_style( 'classic-theme-styles' );

	// Disable woo brands styles
	wp_deregister_style( 'brands-styles' );

	// Use native Html5 players
	wp_deregister_style( 'wp-mediaelement' );
	wp_deregister_script( 'wp-mediaelement' );
	wp_deregister_script( 'mediaelement-core' );
	wp_deregister_script( 'mediaelement-migrate' );
	wp_deregister_script( 'mediaelement-vimeo' );

	// Remove flexible shipping styles
	wp_deregister_style( 'flexible-shipping-free-shipping-notice-block-integration-blocks-integration-frontend' );
	wp_deregister_style( 'flexible-shipping-free-shipping-notice-block-integration-blocks-integration-editor' );
	wp_deregister_style( 'flexible-shipping-free-shipping' );

	// if we're not on a Woocommerce page, dequeue all of these scripts
	if ( function_exists( 'is_woocommerce' ) ) {
		if (! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) { 
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'jquery-cookie' );
			wp_dequeue_script( 'wc-cart-fragments' );
		}
	}

	if ( is_front_page() or 
		 is_page('contact') or 
		 is_page('owners-bio') or 
		 is_page('free-shipping-kit') or 
		 is_page('products-feed-generator') or
		 is_page('gallery') or 
		 is_blog() or ( function_exists( 'is_woocommerce' ) and is_woocommerce() ) ) {

		// Load partial wp and wc gutenberg block styles for performance
		wp_deregister_style( 'wp-block-library' );
		wp_deregister_style( 'wc-blocks-style' );

		// Remove yet more woo blocks style bloat
		wp_deregister_style( 'wc-blocks-style-mini-cart-contents' );
		wp_deregister_style( 'wc-blocks-style-add-to-cart-form' );
		wp_deregister_style( 'wc-blocks-style-active-filters' );
		wp_deregister_style( 'wc-blocks-packages-style' );
		wp_deregister_style( 'wc-blocks-style-all-products' );
		wp_deregister_style( 'wc-blocks-style-all-reviews' );
		wp_deregister_style( 'wc-blocks-style-attribute-filter' );
		wp_deregister_style( 'wc-blocks-style-breadcrumbs' );
		wp_deregister_style( 'wc-blocks-style-catalog-sorting' );
		wp_deregister_style( 'wc-blocks-style-customer-account' );
		wp_deregister_style( 'wc-blocks-style-featured-category' );
		wp_deregister_style( 'wc-blocks-style-featured-product' );
		wp_deregister_style( 'wc-blocks-style-mini-cart' );
		wp_deregister_style( 'wc-blocks-style-price-filter' );
		wp_deregister_style( 'wc-blocks-style-product-add-to-cart' );
		wp_deregister_style( 'wc-blocks-style-product-button' );
		wp_deregister_style( 'wc-blocks-style-product-categories' );
		wp_deregister_style( 'wc-blocks-style-product-image' );
		wp_deregister_style( 'wc-blocks-style-product-image-gallery' );
		wp_deregister_style( 'wc-blocks-style-product-query' );
		wp_deregister_style( 'wc-blocks-style-product-results-count' );
		wp_deregister_style( 'wc-blocks-style-product-reviews' );
		wp_deregister_style( 'wc-blocks-style-product-sale-badge' );
		wp_deregister_style( 'wc-blocks-style-product-search' );
		wp_deregister_style( 'wc-blocks-style-product-sku' );
		wp_deregister_style( 'wc-blocks-style-product-stock-indicator' );
		wp_deregister_style( 'wc-blocks-style-product-summary' );
		wp_deregister_style( 'wc-blocks-style-product-title' );
		wp_deregister_style( 'wc-blocks-style-rating-filter' );
		wp_deregister_style( 'wc-blocks-style-reviews-by-category' );
		wp_deregister_style( 'wc-blocks-style-reviews-by-product' );
		wp_deregister_style( 'wc-blocks-style-product-details' );
		wp_deregister_style( 'wc-blocks-style-single-product' );
		wp_deregister_style( 'wc-blocks-style-stock-filter' );
		wp_deregister_style( 'wc-blocks-style-cart' );
		wp_deregister_style( 'wc-blocks-style-checkout' );
		
		wp_register_style( 'purge-block-style', get_stylesheet_directory_uri() . '/assets/css/purge-block-style.min.css', [], wp_get_theme()->get( 'Version' ) );

		wp_enqueue_style( 'kahoy-crafts-style', get_stylesheet_directory_uri() . '/assets/css/purge-style.min.css', ['purge-block-style'], wp_get_theme()->get( 'Version' ) );

	} else {
		// Use full styles for sensitive pages
		wp_enqueue_style( 'kahoy-crafts-style', get_stylesheet_directory_uri() . '/assets/css/style.min.css', [], wp_get_theme()->get( 'Version' ) );
	}

}

add_action( 'admin_enqueue_scripts', 'kahoy_crafts_admin_styles', 11, 1 );

function kahoy_crafts_admin_styles( $hook ) {

	wp_deregister_style( 'brands-admin-styles' ); // Useless styles

	wp_enqueue_style( 'kahoy-crafts-style', get_stylesheet_directory_uri() . '/assets/css/admin-style.min.css', [], wp_get_theme()->get( 'Version' ) );

	// Fix error with woo-pay tos.js
	if ($_SERVER['PHP_SELF'] == '/wp-admin/customize.php') {
		wp_dequeue_style( 'wcpay-admin-css' );
		wp_dequeue_style( 'WCPAY_TOS' );
		wp_dequeue_style( 'wc-blocks-checkout-style' );
		wp_deregister_script( 'WCPAY_TOS' );
		wp_deregister_script( 'WCPAY_MULTI_CURRENCY_ANALYTICS' );
	}

}

function is_blog() {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

add_action( 'init', function() {

	register_nav_menu( 'footer', __( 'Footer Menu' ) );
	remove_action( 'generate_footer', 'generate_construct_footer', 10 );

} );

/**
 * Build our footer.
 */
add_action( 'generate_before_footer_content', function() {
	get_template_part( 'template-parts/footer/footer-widgets' );
} );

add_action( 'generate_footer', function() {
	get_template_part( 'template-parts/footer/footer-content' );
} );

add_action( 'wp_enqueue_scripts', 'kahoy_crafts_scripts' );

/**
 * Enqueue scripts and styles.
 * 
 * @return void
 */
function kahoy_crafts_scripts() {

	if ( is_front_page() ) {
		wp_register_script(
			'owl-carousel',
			get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js',
			['jquery'],
			wp_get_theme()->get( 'Version' ),
			true
		);
		wp_enqueue_script(
			'kahoycrafts',
			get_stylesheet_directory_uri() . '/assets/js/kahoycrafts.min.js',
			['jquery', 'owl-carousel'],
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
	if (! is_page('contact') ) {
		wp_enqueue_script(
			'newsletter-popup',
			get_stylesheet_directory_uri() . '/assets/js/newsletter-popup.min.js',
			['jquery'],
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
	if ( is_product() ) {
		wp_enqueue_script(
			'view-product',
			get_stylesheet_directory_uri() . '/assets/js/view-product.min.js',
			['jquery'],
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
	wp_register_script(
		'cookie-consent-banner',
		get_stylesheet_directory_uri() . '/assets/js/cookie-consent-banner.min.js',
		[],
		null,
		true
	);
	wp_enqueue_script(
		'cookie-consent',
		get_stylesheet_directory_uri() . '/assets/js/cookie-consent.min.js',
		['cookie-consent-banner'],
		wp_get_theme()->get( 'Version' ),
		true
	);

}

/**
 * Post nav for jetpack testimonials
 */
add_action( 'generate_after_entry_content', function() {
    if ( is_singular( 'jetpack-testimonial' ) ) : ?>
        <footer class="entry-meta">
            <?php generate_content_nav( 'nav-below' ); ?>
        </footer><!-- .entry-meta -->
    <?php endif;
} );

add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

// Remove JQuery migrate
function remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		// Check whether the script has any dependencies
		if ( $script->deps ) { 
			$script->deps = array_diff( $script->deps, ['jquery-migrate'] );
		}
	}
}

add_action( 'woocommerce_after_order_notes', 'newsletter_checkout_field' );

function newsletter_checkout_field( $checkout ) {

	echo '<div class="newsletter-checkout-field">';

	$checked = $checkout->get_value( 'newsletter_optin' ) ? $checkout->get_value( 'newsletter_optin' ) : 0;

	woocommerce_form_field('newsletter_optin', 
		array(

			'type' => 'checkbox',

			'class' => array(

				'optin-field-class form-row-wide'

			),

			'required' => false,

			'label' => __('Keep me up to date on news and exclusive offers via email'),

		) ,

		$checked
	);

	echo '</div>';

}

add_action( 'woocommerce_checkout_update_order_meta', 'newsletter_checkout_field_update_order_meta' );

/**
 * Store newsletter optin choice
 */
function newsletter_checkout_field_update_order_meta( $order_id ) {

	$value = isset($_POST['newsletter_optin']) ? 'yes' : 'no';
	
	update_post_meta( $order_id, 'newsletter_optin', $value );

}

add_action( 'wpcf7_init', 'wpcf7_add_form_tag_kcprofilepicker' );

function wpcf7_add_form_tag_kcprofilepicker() {
    wpcf7_add_form_tag( [ 'kcprofilepicker', 'kcprofilepicker*' ],
        'wpcf7_kcprofilepicker_form_tag_handler', [ 'name-attr' => true ] );
}

function wpcf7_kcprofilepicker_form_tag_handler( $tag ) {

	$tag = new WPCF7_FormTag( $tag );

	if ( empty( $tag->name ) ) {
        return '';
    }

	$img_path = '/wp-content/themes/kahoycrafts-genpress/assets/images/profiles/';

	//ex. "L1:L-Shaped-Profile.png" "L2:Futurist-Profile.png" "L3:U-Turn-Profile.png" "L4:Deluxe-Profile.png" "L5:Wide-Profile.png" "T1:T-Shaped-Profile.png"

	$val = current($tag->values);
	$split = explode(':', $val);

	$img_profile = $img_path . $split[1];

	$template = '<div class="profile"><h5>%2$s</h5><label><input type="radio" name="%1$s" value="%2$s" %3$s><img src="%4$s" alt="%2$s"></label></div>';

	$html = sprintf($template, $tag->name, $split[0], 'checked', $img_profile);

	while ( $val = next($tag->values) ) {
		$split = explode(':', $val);
		$img_profile = $img_path . $split[1];
		$html .= sprintf($template, $tag->name, $split[0], '', $img_profile);
	}

    $atts = [];

    $class = wpcf7_form_controls_class( $tag->type );
    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();

    //$atts['name'] = $tag->name;
    $atts = wpcf7_format_atts( $atts );

    return sprintf( '<div %s>'. $html .'</div>', $atts );
}


// Create the new wordpress action hook before sending the email from CF7
add_action( 'wpcf7_before_send_mail', function( $form, &$abort, $object ) {

	$submission = WPCF7_Submission::get_instance();
	// these variables are examples of other things you may want to pass to your custom handler
	//$remote_ip = $submission->get_meta( 'remote_ip' );
	//$url = $submission->get_meta( 'url' );
	//$timestamp = gmdate("Y-m-d H:i:s", $submission->get_meta( 'timestamp' ));
	//$title = wpcf7_special_mail_tag( '', '_post_title', '' );
    
	// If you have checkboxes or other multi-select fields, make sure you convert the values to a string  
	// $mycheckbox1 = implode(", ", $posted_data["checkbox-465"]);
	// $mycheckbox2 = implode(", ", $posted_data["checkbox-466"]);

	if (! $submission ) {
		$abort = true;
    	$object->set_response("No data to capture.");
		return; // No data to capture
	}

	// Get the post data and other post meta values.
    $posted_data = $submission->get_posted_data();

	#honeypot spam filter
	if ( !empty($posted_data["website"]) ) {
		$abort = true;
		return;
	}

	// Validate contact form
	if ( preg_match('/contact-form/', $form->name()) ) {
		$token = $_POST['cf-turnstile-response'];
		$remote_addr = $_SERVER['REMOTE_ADDR'];

		if ( empty($token) ) {
			$object->set_response('Cloudflare Turnstile token not found.');
			$abort = true;
		}
		else {
			$response = kahoycrafts_cloudflare_turnstile::validate($token, $remote_addr);

			if ($response != 'Success') {
				$object->set_response($response);
				$abort = true;
			}
		}
	}
	elseif ( $form->name() == 'newsletter-signup' ) {
		$response = kahoycrafts_big_mailer::add_contact(
			$posted_data["your-email"], 
			$posted_data["your-name"]
		);
	 	
	    if ( $response != 'Success' ) {
	    	$object->set_response($response);
	    	$abort = true;
	    }
	}
        
    return;

}, 10, 3 );

/**
 *  Google Ads conversion tracking
 */
add_action('woocommerce_add_to_cart', 'add_to_cart_click', 10, 6);

function add_to_cart_click( $cart_id, $product_id, $request_quantity, $variation_id, $variation, $cart_item_data ) {

    $item_id = $variation_id ?: $product_id;

    $product = wc_get_product($item_id);
    $price = $product->get_price();
    $value = ($price * $request_quantity);
    $currency = get_woocommerce_currency();

    $items = [];

    $items[] = [
    	'item_id' => (string)$item_id,
		'item_name' => $product->get_name(),
		'quantity' => $request_quantity,
		'price' => (float)$price
    ];

    $json_items = json_encode($items);

    $code = "gtag('event', 'add_to_cart', {
		'value': {$value},
		'currency': '{$currency}',
		'items': {$json_items}
	});";

    wc_enqueue_js( $code );
}

add_action('woocommerce_review_order_after_cart_contents', 'after_cart_contents');

function after_cart_contents( $cart_items ) {

	$currency = get_woocommerce_currency();
	
	$cart_totals = WC()->session->get('cart_totals');
	$value = $cart_totals['cart_contents_total'] ?: 0;

	$coupons = WC()->session->get('applied_coupons');
	$coupons_list = $coupons ? implode(',', $coupons) : '';

	$items = [];

	foreach ( $cart_items as $item ) {
		$items[] = [
			'item_id' => (string)$item['data']->get_id(),
			'item_name' => $item['data']->get_name(),
			'quantity' => $item['quantity'],
			'price' => (float)$item['line_total']
		];
	}

	$json_items = json_encode($items);

	$code = "gtag('event', 'begin_checkout', {
		'value': {$value},
		'currency': '{$currency}',
		'coupon': '{$coupons_list}',
		'items': {$json_items}
	});";

    wc_enqueue_js( $code );
}

add_action( 'woocommerce_thankyou', function( $order_id ) {

	$order = wc_get_order( $order_id );

	$value = $order->get_total() ? $order->get_total() : 0;
	$currency = get_woocommerce_currency();

	// Array of WC_Order_Item_Product
	$cart_items = $order->get_items();

	$items = [];

	foreach ( $cart_items as &$item ) {
		$data = $item->get_data();
		$item_id = $data['variation_id'] ?: $data['product_id'];
		$items[] = [
			'item_id' => (string)$item_id,
			'item_name' => $data['name'],
			'quantity' => $data['quantity'],
			'price' => (float)$data['total']
		];
	}

	$json_items = json_encode($items);

	// GA4 event
	$code = "gtag('event', 'purchase', {
      'value': {$value},
      'currency': '{$currency}',
      'transaction_id': '{$order_id}',
	  'items': {$json_items}
  	});";

  	wc_enqueue_js( $code );
} );


// ------------ --------  ----         ------------ ------------ -----------  ------------ 
// ************ ********  ****         ************ ************ ***********  ************ 
// ----           ----    ----         ------------ ----         ----    ---  ----         
// ************   ****    ****             ****     ************ *********    ************ 
// ------------   ----    ----             ----     ------------ ---------    ------------ 
// ****           ****    ************     ****     ****         ****  ****          ***** 
// ----         --------  ------------     ----     ------------ ----   ----  ------------ 
// ****         ********  ************     ****     ************ ****    **** ************ 

// Remove useless auto size filter
add_filter('wp_img_tag_add_auto_sizes', '__return_false');

add_filter( 'style_loader_src', function( $src, $handle ) {

	if ( is_front_page() or 
			is_page('contact') or 
			is_page('owners-bio') or 
			is_page('free-shipping-kit') or 
			is_page('products-feed-generator') or
			is_page('custom-quote-drawer-pulls') or 
			is_page('planter-boxes') or 
			is_page('gallery') or 
			is_blog() or ( function_exists( 'is_woocommerce' ) and is_woocommerce() ) ) {

		switch ($handle) {
			case 'woocommerce-layout': 
			case 'woocommerce-smallscreen':
				$src = preg_replace('/^(.*)\?(.*)$/', get_stylesheet_directory_uri() . '/assets/src/purge-css/'. $handle .'.css?$2', $src);
				break;
			case 'woocommerce-general':
				$src = preg_replace('/^(.*)\?(.*)$/', get_stylesheet_directory_uri() . '/assets/src/purge-css/woocommerce.css?$2', $src);
				break;
		}
	    
	}

    return $src;

}, 10, 2 );

function get_rating_stars($rating) {
	$i = 0;
	$n = floor($rating);
	$html = '';

	while ( $i < $n ) {
		$html .= '<i class="rating__star fas fa-star"></i>';
		$i++;
	}
	while ( $i < 5 ) {
		$html .= '<i class="rating__star far fa-star"></i>';
		$i++;
	}

	return $html;
}

add_filter( 'woocommerce_product_get_rating_html', function( $html, $rating, $count ) {
	if ($rating) {
		return '<span class="stars">'. get_rating_stars($rating) .'</span>';
	}
}, 10, 3 );

// Delay non-critical stylesheets 
add_filter( 'style_loader_tag', function( $tag, $handle ) {

	if ( is_admin() ) {
		return $tag;
	}

	if ( is_front_page() or 
			 is_page('contact') or 
			 is_page('owners-bio') or 
			 is_page('free-shipping-kit') or 
			 is_page('products-feed-generator') or
			 is_page('gallery') or 
			 is_blog() ) {

		switch ($handle) {
			case 'woocommerce-layout':
			case 'woocommerce-smallscreen':
			case 'woocommerce-general':
			case 'generate-google-fonts':
			case 'wc-blocks-checkout-style':
				$tag = str_replace('rel=\'stylesheet\'', 'rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'"', $tag);
				break;
		}
	}

	if ( function_exists( 'is_woocommerce' ) and is_woocommerce() ) {

		switch ($handle) {
			case 'generate-google-fonts':
			case 'wc-blocks-checkout-style':
				$tag = str_replace('rel=\'stylesheet\'', 'rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'"', $tag);
				break;
		}

	}

	return $tag;

}, 10, 2);

/**
 * Defer or async scripts
 */
add_filter( 'script_loader_tag', function ( $tag, $handle ) {

	if ( is_admin() ) {
		return $tag;
	}
	
	if ( $handle == 'wpforms-validation' || 
		 $handle == 'wpforms-mailcheck' || 
		 $handle == 'wpforms-punycode' || 
		 $handle == 'wpforms-recaptcha' ||
		 $handle == 'generate-menu' || 
		 $handle == 'cookie-consent' ||
		 $handle == 'cookie-consent-banner' ) {
		
		return str_replace( ' src', ' async src', $tag );
	}

	if ($handle == 'wc-single-product') {
		$tag = "<script src='/wp-content/themes/kahoycrafts-genpress/assets/js/woo/single-product.min.js' id='wc-single-product-js'></script>";
	}

	if ($handle == 'flexslider') {
		$tag = "<script src='/wp-content/themes/kahoycrafts-genpress/assets/js/woo/jquery.flexslider.min.js' id='wc-single-product-js'></script>";
	}

	return $tag;

}, 10, 2 );

/**
 * @param array $defaults The default array of items
 * @return array 	Modified array
 */
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {

	$defaults['home'] = 'Shop';
	return $defaults;

} );

/**
 * Change the breadcrumb home link URL from / to /shop.
 * 
 * @return string 	Home url
 */
add_filter( 'woocommerce_breadcrumb_home_url', function() {

	return '/shop/';

} );

add_filter( 'wp_sitemaps_posts_query_args', 'kahoycrafts_disable_sitemap_specific_page', 10, 2 );

/**
 * Exclude woocommerce pages from sitemap.xml
 *
 * @param array $args
 * @param string $post_type
 * @return array Array of args
 */
function kahoycrafts_disable_sitemap_specific_page( $args, $post_type ) {

	if ('page' !== $post_type) return $args;
	
	$args['post__not_in'] = isset($args['post__not_in']) ? $args['post__not_in'] : [];

	$args['post__not_in'][] = 70;
	$args['post__not_in'][] = 71;
	$args['post__not_in'][] = 72; // exclude page with ID = 72
	
	return $args;

}

/**
 * Remove lazy loading for image above the fold
 */
add_filter( 'woocommerce_product_get_image', function( $image, $obj, $size, $attr, $placeholder ) {
	if ( $obj->get_menu_order() == -1 ) {
		$image = str_replace('loading="lazy"', '', $image);
	}

	return $image;
}, 10, 5);

// Override video tag
add_filter( 'wp_video_shortcode_override', 'video_shortcode_override', 10, 4 );

function video_shortcode_override( $markup, $attr, $content, $id ) {
	
	$default_types = wp_get_video_extensions();
	$type = '';

	foreach ( $default_types as $type ) {
		if ( isset( $attr[$type] ) ) {
			break;
		}
	}

	if ($type) {

		$markup .= '
<div class="wp-video">
	<video class="wp-video-shortcode" id="video-'. $id .'" width="'. $attr['width'] .'" height="'. $attr['height'] .'" preload="'. $attr['preload'] .'" controls="controls">
		<source type="video/'. $type .'" src="'. $attr[$type] .'">
		<a href="'. $attr[$type] .'">'. $attr[$type] .'</a>
	</video>
</div>';

	}

	return $markup;

}
