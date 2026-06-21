<?php
/**
 * Portfolio grid.
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'portfolio.kicker' );
$title  = pulselyft_get( 'portfolio.title' );
$intro  = pulselyft_get( 'portfolio.intro' );
$cta    = pulselyft_get( 'portfolio.cta' );
$items  = pulselyft_get( 'portfolio.items' );
if ( ! is_array( $items ) ) {
	return;
}
?>
<section id="portfolio" class="pl-section pl-section--paper pl-section--bordered pl-scroll-anchor" aria-labelledby="pl-portfolio-title">
	<div class="pl-container">
		<div class="pl-sec-head pl-reveal" style="align-items:flex-end;">
			<div class="pl-sec-head__main">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-portfolio-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1rem;max-width:36rem;"><?php echo esc_html( $intro ); ?></p>
			</div>
			<a href="#book-call" class="pl-btn pl-btn--secondary pl-btn--sm"><?php echo esc_html( $cta ); ?> <span aria-hidden="true">→</span></a>
		</div>

		<ul class="pl-portfolio__grid">
			<?php foreach ( $items as $piece ) : ?>
				<li class="pl-reveal">
					<a href="<?php echo esc_url( ! empty( $piece['href'] ) ? $piece['href'] : '#contact' ); ?>" class="pl-pf">
						<div class="pl-pf__media">
							<img src="<?php echo esc_url( $piece['img'] ); ?>" alt="<?php echo esc_attr( $piece['title'] ); ?>" loading="lazy" decoding="async">
							<div class="pl-pf__caption">
								<p class="pl-pf__cat"><?php echo esc_html( $piece['category'] ); ?></p>
								<p class="pl-pf__title"><?php echo esc_html( $piece['title'] ); ?></p>
							</div>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
