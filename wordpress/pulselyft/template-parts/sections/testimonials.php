<?php
/**
 * Testimonials.
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'testimonials.kicker' );
$title  = pulselyft_get( 'testimonials.title' );
$quotes = pulselyft_get( 'testimonials.quotes' );
if ( ! is_array( $quotes ) || ! $quotes ) {
	return;
}
$q0 = $quotes[0];
$q1 = isset( $quotes[1] ) ? $quotes[1] : $quotes[0];
?>
<section class="pl-section pl-section--page pl-section--bordered" aria-labelledby="pl-tst-title">
	<div class="pl-container">
		<div class="pl-reveal">
			<p class="pl-kicker"><?php echo esc_html( $kicker ); ?></p>
			<h2 id="pl-tst-title" class="pl-h2"><?php echo esc_html( $title ); ?></h2>
		</div>

		<div class="pl-tst__grid">
			<blockquote class="pl-quote pl-quote--lg pl-reveal">
				<span class="pl-quote__mark" aria-hidden="true">&ldquo;</span>
				<p class="pl-quote__lg-text"><?php echo esc_html( $q0['quote'] ); ?></p>
				<footer class="pl-quote__foot">
					<?php if ( ! empty( $q0['avatar'] ) ) : ?>
						<span class="pl-quote__avatar"><img src="<?php echo esc_url( $q0['avatar'] ); ?>" alt="" loading="lazy" decoding="async"></span>
					<?php endif; ?>
					<cite class="pl-quote__cite">
						<span class="pl-quote__name"><?php echo esc_html( $q0['name'] ); ?></span>
						<span class="pl-quote__role"> — <?php echo esc_html( $q0['role'] ); ?></span>
					</cite>
				</footer>
			</blockquote>

			<blockquote class="pl-quote pl-quote--sm pl-reveal">
				<p class="pl-quote__sm-text">&ldquo;<?php echo esc_html( $q1['quote'] ); ?>&rdquo;</p>
				<footer class="pl-quote__foot">
					<?php if ( ! empty( $q1['avatar'] ) ) : ?>
						<span class="pl-quote__avatar"><img src="<?php echo esc_url( $q1['avatar'] ); ?>" alt="" loading="lazy" decoding="async"></span>
					<?php endif; ?>
					<cite class="pl-quote__cite">
						<span class="pl-quote__name"><?php echo esc_html( $q1['name'] ); ?></span>
						<span class="pl-quote__role"> — <?php echo esc_html( $q1['role'] ); ?></span>
					</cite>
				</footer>
			</blockquote>
		</div>
	</div>
</section>
