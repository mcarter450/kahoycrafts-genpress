<?php /* Template Name: GalleryPage */ ?>
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Custom Gallery Block
add_filter( 'render_block_core/gallery', function( $block_content, $block ) {
	
	$block_content = preg_replace_callback('/<a href=\"([^\"]+)/i', function( $matches ) {
		
		$img_path = ABSPATH . ltrim( parse_url( $matches[1], PHP_URL_PATH ), '/' );

		list($width, $height, $type, $attr) = getimagesize($img_path);
		
		$href = sprintf('<a href="%s" data-pswp-width="%s" data-pswp-height="%s', $matches[1], $width, $height);

		return $href;

	}, $block_content);

	return $block_content;

}, 10, 2 );

wp_enqueue_script_module('gallery', get_stylesheet_directory_uri() . '/assets/js/gallery.min.js', [], wp_get_theme()->get( 'Version' ) );
wp_enqueue_style( 'gallery', get_stylesheet_directory_uri() . '/assets/css/gallery.min.css', [], wp_get_theme()->get( 'Version' ) );

get_header(); ?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				while ( have_posts() ) :

					the_post();

					generate_do_template_part( 'page' );

				endwhile;
			}

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();
