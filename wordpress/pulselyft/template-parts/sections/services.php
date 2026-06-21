<?php
/**
 * Services — bento grid.
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
				<li class="pl-service pl-reveal">
					<?php if ( ! empty( $item['img'] ) ) : ?>
						<div class="pl-service__img" aria-hidden="true">
							<img src="<?php echo esc_url( $item['img'] ); ?>" alt="" loading="lazy" decoding="async">
						</div>
					<?php endif; ?>
					<div class="pl-service__body">
						<span class="pl-service__num" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<span class="pl-service__rule" aria-hidden="true"></span>
						<h3 class="pl-service__title"><?php echo esc_html( $item['title'] ); ?></h3>
						<p class="pl-service__text"><?php echo esc_html( $item['body'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
