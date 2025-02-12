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

get_header(); ?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>
			<script type="module">
			import PhotoSwipeLightbox from '/wp-content/themes/kahoycrafts-genpress/assets/js/photoswipe-lightbox.esm.min.js';
			const lightbox = new PhotoSwipeLightbox({
				gallery: '.pswp-gallery',
				children: 'a',
				pswpModule: () => import('/wp-content/themes/kahoycrafts-genpress/assets/js/photoswipe.esm.min.js')
			});
			lightbox.on('uiRegister', function() {
				lightbox.pswp.ui.registerElement({
					name: 'custom-caption',
					order: 9,
					isButton: false,
					appendTo: 'root',
					html: 'Caption text',
					onInit: (el, pswp) => {
						lightbox.pswp.on('change', () => {
							const currSlideElement = lightbox.pswp.currSlide.data.element;
							let captionHTML = '';
							if (currSlideElement) {
								const hiddenCaption = currSlideElement.querySelector('.hidden-caption-content');
								if (hiddenCaption) {
									// get caption from element with class hidden-caption-content
									captionHTML = hiddenCaption.innerHTML;
								} else {
									// get caption from alt attribute
									captionHTML = currSlideElement.querySelector('img').getAttribute('alt');
								}
							}
							el.innerHTML = captionHTML || '';
						});
					}
				});
			});
			lightbox.init();
			</script>
			<link rel="stylesheet" href="/wp-content/themes/kahoycrafts-genpress/assets/css/photoswipe.css">
			<style>
			.pswp-gallery {
			  display: grid;
			  grid-template-columns: repeat(7, 1fr);
			  column-gap: 5px;
  			  row-gap: 5px;
			}

			.pswp-gallery img {
			  display: block;
			  width: 100%;
			  height: auto;
			}

			.pswp-gallery a {
			  display: inline-block;
			}

			.pswp__custom-caption {
			  background: rgba(75, 150, 75, 0.75);
			  font-size: 16px;
			  color: #fff;
			  width: calc(100% - 32px);
			  max-width: 400px;
			  padding: 2px 8px;
			  border-radius: 4px;
			  position: absolute;
			  left: 50%;
			  bottom: 16px;
			  transform: translateX(-50%);
			}

			.pswp__custom-caption a {
			  color: #fff;
			  text-decoration: underline;
			}

			.hidden-caption-content {
			  display: none;
			}

			@media (max-width: 1024px)
			{
			  .pswp-gallery {
			  	grid-template-columns: repeat(6, 1fr);
			  }
			}

			@media (max-width: 820px)
			{
			  .pswp-gallery {
			  	grid-template-columns: repeat(5, 1fr);
			  }
			}

			@media (max-width: 480px)
			{
			  .pswp-gallery {
			  	grid-template-columns: repeat(3, 1fr);
			  }
			}
			</style>
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

			$images = [
				1205, 1278, 1209, 1207, 1218, 
				1208, 1210, 468, 1213, 1733, 
				1436, 1682, 1214, 1215, 1216, 
				1212, 829, 1211, 831, 207, 
				1696, 1204, 1874
			];

			print('<div class="pswp-gallery">');
			foreach ($images as $attachment_id) {
				$img_full_atts = wp_get_attachment_image_src( $attachment_id, 'large');
				$img_thumb_atts = wp_get_attachment_image_src( $attachment_id, 'thumbnail');

				$caption = wp_get_attachment_caption( $attachment_id );

				if ($img_full_atts && $img_thumb_atts) {
					printf('<a href="%s" data-pswp-width="%s" data-pswp-height="%s" target="_blank">', $img_full_atts[0], $img_full_atts[1], $img_full_atts[2]);
					printf('<img src="%s" alt="%s"></a>', $img_thumb_atts[0], $caption);
				}
			}
			print('</div>');

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
