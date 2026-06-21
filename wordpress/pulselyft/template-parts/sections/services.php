<?php
/**
 * Capabilities — interactive editorial list (v2, replaces the bento grid).
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'services.kicker' );
$title  = pulselyft_get( 'services.title' );
$intro  = pulselyft_get( 'services.intro' );
$items  = pulselyft_get( 'services.items' );
if ( ! is_array( $items ) ) {
	return;
}
$items = array_slice( $items, 0, 4 );
?>
<section id="services" class="pl-section pl-section--page pl-scroll-anchor" aria-labelledby="pl-services-title">
	<div class="pl-container">
		<div class="pl-sec-head pl-reveal">
			<div class="pl-sec-head__main">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-services-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
			</div>
			<p class="pl-sec-head__aside"><?php echo esc_html( $intro ); ?></p>
		</div>

		<ul class="pl-services__grid">
			<?php foreach ( $items as $i => $item ) : ?>
				<li class="pl-cap pl-reveal">
					<span class="pl-cap__no" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div class="pl-cap__main">
						<h3 class="pl-cap__title"><?php echo esc_html( $item['title'] ); ?></h3>
						<p class="pl-cap__desc"><?php echo esc_html( $item['body'] ); ?></p>
					</div>
					<?php if ( ! empty( $item['img'] ) ) : ?>
						<span class="pl-cap__thumb" aria-hidden="true"><img src="<?php echo esc_url( $item['img'] ); ?>" alt="" loading="lazy" decoding="async"></span>
					<?php endif; ?>
					<span class="pl-cap__arrow" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
