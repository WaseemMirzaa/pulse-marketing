<?php
/**
 * 404 template.
 *
 * @package PulseLyft
 */

get_header();
?>
<div class="pl-page-wrap">
	<div class="pl-article" style="text-align:center;">
		<p class="pl-kicker pl-kicker--lift" style="text-align:center;"><?php esc_html_e( 'Error 404', 'pulselyft' ); ?></p>
		<h1 class="pl-article__title pl-balance" style="margin-top:1rem;"><?php esc_html_e( 'This page took a different growth path.', 'pulselyft' ); ?></h1>
		<p class="pl-hero__sub" style="margin:1.5rem auto 0;"><?php esc_html_e( 'The page you were looking for is not here. Head back home or get in touch.', 'pulselyft' ); ?></p>
		<div class="pl-postcta__row" style="margin-top:2rem;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pl-btn pl-btn--primary"><?php esc_html_e( 'Back home', 'pulselyft' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="pl-btn pl-btn--secondary"><?php esc_html_e( 'Contact', 'pulselyft' ); ?></a>
		</div>
		<div style="margin-top:3rem;max-width:28rem;margin-inline:auto;">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>
<?php
get_footer();
