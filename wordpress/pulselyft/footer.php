<?php
/**
 * Site footer + chatbot + closing tags.
 *
 * @package PulseLyft
 */

$brand    = pulselyft_brand();
$home     = home_url( '/' );
$on_front = is_front_page();
$nav      = array(
	'#services'  => __( 'Services', 'pulselyft' ),
	'#work'      => __( 'Work', 'pulselyft' ),
	'#portfolio' => __( 'Portfolio', 'pulselyft' ),
	'#process'   => __( 'Process', 'pulselyft' ),
	'#blog'      => __( 'Blog', 'pulselyft' ),
	'#contact'   => __( 'Contact', 'pulselyft' ),
);
$socials = array(
	'LinkedIn'  => get_theme_mod( 'pulselyft_social_linkedin', '' ),
	'X'         => get_theme_mod( 'pulselyft_social_x', '' ),
	'Instagram' => get_theme_mod( 'pulselyft_social_instagram', '' ),
);
$socials = array_filter( $socials );
?>
</main><!-- #pl-main -->

<footer class="pl-footer">
	<div class="pl-container pl-footer__inner">
		<div>
			<p class="pl-footer__brand">
				<span class="pl-footer__mark"><?php echo esc_html( mb_substr( $brand['prefix'], 0, 1 ) ); ?></span>
				<?php echo esc_html( $brand['prefix'] ); ?><span class="pl-footer__accent"><?php echo esc_html( $brand['accent'] ); ?></span>
			</p>
			<p class="pl-footer__tag"><?php echo esc_html( pulselyft_get( 'brand.tagline', 'pulselyft_brand_tagline' ) ); ?></p>
			<?php if ( $socials ) : ?>
				<div class="pl-footer__col" style="margin-top:1.5rem;flex-direction:row;gap:1rem;">
					<?php foreach ( $socials as $label => $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" rel="noopener noreferrer" target="_blank"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="pl-footer__cols">
			<div class="pl-footer__col">
				<span class="pl-footer__head"><?php esc_html_e( 'Navigate', 'pulselyft' ); ?></span>
				<?php
				foreach ( $nav as $href => $label ) {
					$url = $on_front ? $href : $home . $href;
					printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
				}
				?>
			</div>
			<div class="pl-footer__col">
				<span class="pl-footer__head"><?php esc_html_e( 'Company', 'pulselyft' ); ?></span>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'depth'          => 1,
						'walker'         => new Pulselyft_Link_Walker( '' ),
					) );
				} else {
					$email = pulselyft_get( 'brand.email', 'pulselyft_brand_email' );
					printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $email ) );
					echo '<span>' . esc_html__( 'Privacy', 'pulselyft' ) . '</span>';
					echo '<span>' . esc_html__( 'Terms', 'pulselyft' ) . '</span>';
				}
				?>
			</div>
		</div>
	</div>
	<p class="pl-footer__legal">
		<?php
		/* translators: 1: year, 2: brand name. */
		printf( esc_html__( '© %1$s %2$s — All rights reserved.', 'pulselyft' ), esc_html( gmdate( 'Y' ) ), esc_html( $brand['full'] ) );
		?>
	</p>
</footer>

<button type="button" class="pl-totop" id="pl-totop" aria-label="<?php esc_attr_e( 'Back to top', 'pulselyft' ); ?>">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
</button>

<?php get_template_part( 'template-parts/chatbot' ); ?>

<?php wp_footer(); ?>
</body>
</html>
