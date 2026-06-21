<?php
/**
 * FAQ accordion — native <details> for accessibility, JS-enhanced.
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'faq.kicker' );
$title  = pulselyft_get( 'faq.title' );
$intro  = pulselyft_get( 'faq.intro' );
$items  = pulselyft_get( 'faq.items' );
if ( ! is_array( $items ) || ! $items ) {
	return;
}
?>
<section id="faq" class="pl-section pl-section--page pl-section--bordered pl-scroll-anchor" aria-labelledby="pl-faq-title">
	<div class="pl-container">
		<div class="pl-faq__layout">
			<div class="pl-faq__intro pl-reveal">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-faq-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1.25rem;"><?php echo esc_html( $intro ); ?></p>
				<a href="#book-call" class="pl-btn pl-btn--secondary" style="margin-top:2rem;"><?php esc_html_e( 'Book a call', 'pulselyft' ); ?> <span aria-hidden="true">→</span></a>
			</div>

			<div class="pl-faq__list" id="pl-faq">
				<?php foreach ( $items as $i => $item ) : ?>
					<details class="pl-faq__item pl-reveal" <?php echo 0 === $i ? 'open' : ''; ?>>
						<summary class="pl-faq__q">
							<span><?php echo esc_html( $item['q'] ); ?></span>
							<span class="pl-faq__icon" aria-hidden="true"></span>
						</summary>
						<div class="pl-faq__a"><?php echo esc_html( $item['a'] ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
