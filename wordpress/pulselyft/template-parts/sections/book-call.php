<?php
/**
 * Book a call — Calendly inline embed.
 *
 * @package PulseLyft
 */

$kicker   = pulselyft_get( 'bookCall.kicker' );
$title    = pulselyft_get( 'bookCall.title', 'pulselyft_book_title' );
$sub      = pulselyft_get( 'bookCall.sub', 'pulselyft_book_sub' );
$calendly = pulselyft_get( 'bookCall.calendlyUrl', 'pulselyft_book_calendly' );
$embed    = pulselyft_calendly_embed( $calendly );
$brand    = pulselyft_brand()['full'];
?>
<section id="book-call" class="pl-section pl-section--paper pl-section--bordered pl-scroll-anchor" aria-labelledby="pl-book-title">
	<div class="pl-container">
		<div class="pl-split">
			<div class="pl-split__aside--4 pl-reveal">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-book-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1.25rem;"><?php echo esc_html( $sub ); ?></p>
				<ul class="pl-checklist">
					<li><span class="pl-checklist__dot" aria-hidden="true"></span><?php esc_html_e( '30-minute intro — no pitch deck required', 'pulselyft' ); ?></li>
					<li><span class="pl-checklist__dot" aria-hidden="true"></span><?php esc_html_e( 'Pick a time that works in your timezone', 'pulselyft' ); ?></li>
				</ul>
			</div>
			<div class="pl-split__main--8 pl-reveal">
				<div class="pl-embed">
					<iframe
						title="<?php echo esc_attr( sprintf( /* translators: %s: brand name. */ __( 'Book a call with %s', 'pulselyft' ), $brand ) ); ?>"
						src="<?php echo esc_url( $embed ); ?>"
						loading="lazy"></iframe>
				</div>
			</div>
		</div>
	</div>
</section>
