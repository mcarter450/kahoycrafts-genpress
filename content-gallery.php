<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action( 'generate_before_content' );

		if ( generate_show_entry_header() ) :
			?>

			<header <?php generate_do_attr( 'entry-header' ); ?>>
				<?php
				/**
				 * generate_before_page_title hook.
				 *
				 * @since 2.4
				 */
				do_action( 'generate_before_page_title' );

				if ( generate_show_title() ) {
					$params = generate_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				/**
				 * generate_after_page_title hook.
				 *
				 * @since 2.4
				 */
				do_action( 'generate_after_page_title' );
				?>
			</header>

			<?php
		endif;

		/**
		 * generate_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_post_image - 10
		 */
		do_action( 'generate_after_entry_header' );

		$itemprop = '';

		if ( 'microdata' === generate_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}
		?>

		<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
			<?php
			the_content();

			$images = [
				1205, 1278, 1209, 1207, 1218, 
				1208, 1210, 468, 1733, 1213, 
				1798, 1682, 1214, 1215, 1216, 
				1212, 829, 1211, 831, 207, 
				1810, 1696, 1874
			];

			print('<div class="pswp-gallery">');
			foreach ($images as $attachment_id) {
				$img_full_atts = wp_get_attachment_image_src( $attachment_id, 'large' );
				$img_thumb_atts = wp_get_attachment_image_src( $attachment_id, 'thumbnail');

				$caption = wp_get_attachment_caption( $attachment_id );

				if ($img_full_atts && $img_thumb_atts) {
					printf('<a href="%s" data-pswp-width="%s" data-pswp-height="%s" target="_blank">', $img_full_atts[0], $img_full_atts[1], $img_full_atts[2]);
					printf('<img src="%s" width="%s" height="%s" alt="%s"></a>', $img_thumb_atts[0], $img_thumb_atts[1], $img_thumb_atts[1], $caption);
				}
			}
			print('</div>');

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>

		<?php
		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'generate_after_content' );
		?>
	</div>
</article>
