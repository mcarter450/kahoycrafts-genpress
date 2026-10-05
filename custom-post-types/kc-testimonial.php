<?php
// Testimonial cpt
function kc_testimonial_cpt() {

	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'testimonial' ),
		'add_new_item'       => __( 'Add New Testimonial' ),
		'edit_item'          => __( 'Edit Testimonial' ),
		'new_item'           => __( 'New Testimonial' ),
		'all_items'          => __( 'All Testimonials' ),
		'view_item'          => __( 'View Testimonial' ),
		'search_items'       => __( 'Search Testimonials' ),
		'not_found'          => __( 'No testimonials found' ),
		'not_found_in_trash' => __( 'No testimonials found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'KC Testimonials',
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'A testimonial can change your life.',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'has_archive'   => true,
	);

	register_post_type( 'kc-testimonial', $args );
}

add_action( 'init', 'kc_testimonial_cpt' );

// Shortcode
function kc_testimonials($atts) {

	$children = new WP_Query(array(
		'post_type'   => 'kc-testimonial',
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
	));

	$html = '';

	if ($children and $children->post_count) {
		$html = '<div class="kc-testimonial-shortcode">';

		foreach ($children->posts as $post) {
			$image = get_the_post_thumbnail($post->ID, 'thumbnail');
			$post_url = get_post_permalink($post->ID);

$html .= <<<TEXT
<div class="item">
	<div class="testimonial-entry">
		<a class="testimonial-featured-image" href="$post_url">$image</a>
		<div class="testimonial-entry-content"><p>$post->post_excerpt</p></div>
		<span class="testimonial-entry-title">― <a href="$post_url">$post->post_title</a>
			<span class="stars">
				<i class="rating__star fas fa-star"></i>
				<i class="rating__star fas fa-star"></i>
				<i class="rating__star fas fa-star"></i>
				<i class="rating__star fas fa-star"></i>
				<i class="rating__star fas fa-star"></i>
			</span>
		</span>
	</div>
</div>
TEXT;
		}

		$html .= '</div>';
	}

	return $html;
}

add_shortcode('kc_testimonials', 'kc_testimonials');
