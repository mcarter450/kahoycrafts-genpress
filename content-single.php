<?php
/**
 * The template for displaying single posts.
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

		if ( generate_show_entry_header() ) :
			?>
			<header <?php generate_do_attr( 'entry-header' ); ?>>
				<?php
				/**
				 * generate_before_entry_title hook.
				 *
				 * @since 0.1
				 */
				do_action( 'generate_before_entry_title' );

				if ( generate_show_title() ) {
					$params = generate_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				/**
				 * generate_after_entry_title hook.
				 *
				 * @since 0.1
				 *
				 * @hooked generate_post_meta - 10
				 */
				do_action( 'generate_after_entry_title' );
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

		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action( 'generate_before_content' );
		?>

		<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
					'after'  => '</div>',
				)
			);

			if ( get_post_type() != 'kc-testimonial' ): ?>
			<script>
			async function copyPostUrl() {
				const urlField = document.getElementById('url');
				const url = urlField.value;

				try {
					if (navigator.clipboard && window.isSecureContext) {
						await navigator.clipboard.writeText(url);
					} else {
						urlField.focus();
						urlField.select();
						urlField.setSelectionRange(0, urlField.value.length);

						if (!document.execCommand('copy')) {
							throw new Error('Copy failed');
						}
					}

					const button = document.getElementById('copy-url-button');
					const originalText = button.dataset.originalText || button.textContent;
					button.dataset.originalText = originalText;
					button.textContent = 'Copied!';

					setTimeout(() => {
						button.textContent = originalText;
					}, 2000);

				} catch (error) {
					urlField.focus();
					urlField.select();
					alert('Automatic copying failed. Please copy the selected URL manually.');
				}
			}
			</script>
			<?php
			$post_url = get_permalink();
			$post_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
			$post_description = wp_trim_words(
				wp_strip_all_tags(get_the_excerpt()),
				40,
				'...'
			);

			$pinterest_args = array(
				'url' => $post_url,
				'description' => $post_description,
			);

			if ($post_image) {
				$pinterest_args['media'] = $post_image;
			}

			$pinterest_url = add_query_arg(
				array_map('rawurlencode', $pinterest_args),
				'https://www.pinterest.com/pin/create/button/'
			);

			$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u='. rawurlencode( $post_url );
			?>
			<p class="share-links">
				<a class="pinterest" onclick="blur()" href="<?php echo $pinterest_url; ?>" target="_blank" rel="noopener noreferrer" aria-label="Save this post on Pinterest">
					<svg class="svg-icon" width="20" height="20" aria-hidden="true" role="img" focusable="false" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.289,2C6.617,2,3.606,5.648,3.606,9.622c0,1.846,1.025,4.146,2.666,4.878c0.25,0.111,0.381,0.063,0.439-0.169 c0.044-0.175,0.267-1.029,0.365-1.428c0.032-0.128,0.017-0.237-0.091-0.362C6.445,11.911,6.01,10.75,6.01,9.668 c0-2.777,2.194-5.464,5.933-5.464c3.23,0,5.49,2.108,5.49,5.122c0,3.407-1.794,5.768-4.13,5.768c-1.291,0-2.257-1.021-1.948-2.277 c0.372-1.495,1.089-3.112,1.089-4.191c0-0.967-0.542-1.775-1.663-1.775c-1.319,0-2.379,1.309-2.379,3.059 c0,1.115,0.394,1.869,0.394,1.869s-1.302,5.279-1.54,6.261c-0.405,1.666,0.053,4.368,0.094,4.604 c0.021,0.126,0.167,0.169,0.25,0.063c0.129-0.165,1.699-2.419,2.142-4.051c0.158-0.59,0.817-2.995,0.817-2.995 c0.43,0.784,1.681,1.446,3.013,1.446c3.963,0,6.822-3.494,6.822-7.833C20.394,5.112,16.849,2,12.289,2"/>
					</svg> Save</a> 

				<a class="facebook" onclick="blur()" href="<?php echo $facebook_url; ?>" target="_blank" rel="noopener noreferrer" aria-label="Share this post on Facebook">
	       			<svg class="svg-icon" width="20" height="20" aria-hidden="true" role="img" focusable="false" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg">
	       				<path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path>
	       			</svg> Share</a> 

				<button type="button" id="copy-url-button" onclick="copyPostUrl();">
					<svg class="svg-icon" width="20px" height="20px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
						<path d="M13.9,44a10,10,0,0,1-7-2.9,9.8,9.8,0,0,1,0-14l7.2-7.2a9.8,9.8,0,0,1,14,0,2,2,0,0,1-2.8,2.8,6,6,0,0,0-8.4,0L9.7,29.9a5.9,5.9,0,0,0,8.4,8.4l4.5-4.7a2,2,0,0,1,2.8,2.8l-4.5,4.7A10,10,0,0,1,13.9,44Z"/>
					     <path d="M26.9,31a10,10,0,0,1-7-2.9,2,2,0,0,1,2.8-2.8,6,6,0,0,0,8.4,0l7.2-7.2a5.9,5.9,0,0,0-8.4-8.4l-4.5,4.7a2,2,0,0,1-2.8-2.8l4.5-4.7a9.9,9.9,0,0,1,14,14l-7.2,7.2A10,10,0,0,1,26.9,31Z"/>
					</svg> Copy Url</button>

				<textarea id="url"
					readonly
					aria-label="Post URL"
					style="position:absolute; left:-9999px; width:1px; height:1px;"><?php echo esc_textarea($post_url); ?></textarea>
			</p>
			<?php endif; ?>
		</div>

		<?php
		/**
		 * generate_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_footer_meta - 10
		 */
		do_action( 'generate_after_entry_content' );

		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'generate_after_content' );
		?>
	</div>
</article>
