<?php
/**
 * Template for the Contact page (slug "contact").
 *
 * Editable in wp-admin: Title → hero heading, Excerpt → hero sub, Content →
 * intro copy. Booking + form sections are reused from the homepage.
 *
 * @package PulseLyft
 */

get_header();

$c       = pulselyft_get( 'pages.contact' );
$methods = isset( $c['methods'] ) ? $c['methods'] : array();
$email   = pulselyft_get( 'brand.email', 'pulselyft_brand_email' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$sub = has_excerpt() ? get_the_excerpt() : $c['sub'];
		pulselyft_page_hero( $c['kicker'], get_the_title(), $sub );
		pulselyft_editable_intro();
	endwhile;
endif;
?>

<section class="pl-section pl-section--paper pl-section--bordered" aria-label="<?php esc_attr_e( 'Ways to reach us', 'pulselyft' ); ?>" style="padding-block:4rem;">
	<div class="pl-container">
		<ul class="pl-methods">
			<li class="pl-method pl-reveal">
				<p class="pl-method__label"><?php esc_html_e( 'Email us', 'pulselyft' ); ?></p>
				<a class="pl-method__value" href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
			</li>
			<?php foreach ( $methods as $m ) : ?>
				<li class="pl-method pl-reveal">
					<p class="pl-method__label"><?php echo esc_html( $m['label'] ); ?></p>
					<?php if ( ! empty( $m['href'] ) ) : ?>
						<a class="pl-method__value" href="<?php echo esc_url( $m['href'] ); ?>"><?php echo esc_html( $m['value'] ); ?></a>
					<?php else : ?>
						<span class="pl-method__value"><?php echo esc_html( $m['value'] ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
pulselyft_section( 'book-call' );
pulselyft_section( 'contact' );

get_footer();
