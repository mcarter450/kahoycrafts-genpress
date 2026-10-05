<?php
// Carousel cpt
function kc_carousel_cpt() {

	$labels = array(
		'name'               => _x( 'Carousels', 'post type general name' ),
		'singular_name'      => _x( 'Carousel', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'carousel' ),
		'add_new_item'       => __( 'Add New Carousel' ),
		'edit_item'          => __( 'Edit Carousel' ),
		'new_item'           => __( 'New Carousel' ),
		'all_items'          => __( 'All Carousels' ),
		'view_item'          => __( 'View Carousel' ),
		'search_items'       => __( 'Search Carousels' ),
		'not_found'          => __( 'No carousels found' ),
		'not_found_in_trash' => __( 'No carousels found in the Trash' ), 
		'parent_item_colon'  => 'Parent Carousel:',
		'menu_name'          => 'KC Carousels',
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'A carousel can change your life.',
		'public'        => true,
		'hierarchical' => true, // allows parent/child items
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'has_archive'   => true,
	);

	register_post_type( 'kc-carousel', $args );
}

add_action( 'init', 'kc_carousel_cpt' );

// Shortcode
function kc_carousel($atts) {

	$default = array(
		'parent' => 'homepage-carousel',
		'class' => 'creative-process',
	);

	$a = shortcode_atts($default, $atts);

	$parent_slug = trim($a['parent']);
	$class = trim($a['class']);

	$parent = get_page_by_path($parent_slug, OBJECT, 'kc-carousel');

	$html = '';

	if ($parent) {
		$html = '<div class="owl-carousel owl-theme '. $class .'">';

		$children = new WP_Query(array(
			'post_type'   => 'kc-carousel',
			'post_parent' => $parent->ID,
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
		));

		if ($children and $children->post_count) {
			foreach ($children->posts as $post) {
				$html .= '<div class="item">'. $post->post_content .'</div>';
			}
		}

		$html .= '</div>';
	}

	return $html;
}

add_shortcode('kc_carousel', 'kc_carousel');
