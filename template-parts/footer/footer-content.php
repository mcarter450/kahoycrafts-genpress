<footer>
	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<div class="social-footer grid-container">
			<nav aria-label="<?php esc_attr_e( 'Footer menu', 'generatepress' ); ?>" class="footer-navigation">
				<ul class="footer-navigation-wrapper">
					<?php
					// SVG icons added by wordpress for links with certain domains
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
						)
					);
					?>
				</ul><!-- .footer-navigation-wrapper -->
		</nav><!-- .footer-navigation -->
		</div>
	<?php endif; ?>
	<div class="site-info grid-container">
		<div class="inner-site-info">
			<div class="site-name">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo"><?php the_custom_logo(); ?></div>
				<?php else : ?>
					<?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
						<?php if ( is_front_page() && ! is_paged() ) : ?>
							<?php bloginfo( 'name' ); ?>
						<?php else : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .site-name -->
			<div class="privacy">
				<a href="/privacy-policy/">Privacy Policy</a>
			</div><!-- .privacy -->
			<div class="terms">
				<a href="/terms-and-conditions/">Terms and Conditions</a>
			</div><!-- .privacy -->
			<div class="copyright">
				© <?php echo date('Y'); ?> Kahoy Crafts
			</div><!-- .copyright -->
			<div class="protected-by">
				<?php $image_attributes = wp_get_attachment_image_src(417, 'medium'); ?>
				<?php if($image_attributes): ?>
					Protected by <img class="cloudflare-logo" src="<?=$image_attributes[0]; ?>" width="150" height="50" alt="Cloudflare">
				<?php endif; ?>
			</div><!-- .protected-by -->
		</div>
	</div><!-- .site-info -->
</footer>
