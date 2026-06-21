<?php
/**
 * CTA band — dark gradient call to action.
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'cta.kicker' );
$title  = pulselyft_get( 'cta.title', 'pulselyft_cta_title' );
$sub    = pulselyft_get( 'cta.sub', 'pulselyft_cta_sub' );
$button = pulselyft_get( 'cta.button', 'pulselyft_cta_button' );
?>
<section class="pl-cta" aria-labelledby="pl-cta-title">
	<div class="pl-container">
		<div class="pl-cta__panel pl-reveal">
			<div class="pl-cta__blob1" aria-hidden="true"></div>
			<div class="pl-cta__blob2" aria-hidden="true"></div>
			<p class="pl-cta__kicker"><?php echo esc_html( $kicker ); ?></p>
			<h2 id="pl-cta-title" class="pl-cta__title pl-balance"><?php echo esc_html( $title ); ?></h2>
			<p class="pl-cta__sub"><?php echo esc_html( $sub ); ?></p>
			<a href="#book-call" class="pl-btn pl-btn--lift"><?php echo esc_html( $button ); ?></a>
		</div>
	</div>
</section>
