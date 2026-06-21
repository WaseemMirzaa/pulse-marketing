<?php
/**
 * Metrics — evidence stat grid.
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'metrics.kicker' );
$title  = pulselyft_get( 'metrics.title' );
$body   = pulselyft_get( 'metrics.body' );
$stats  = pulselyft_get( 'metrics.stats' );
if ( ! is_array( $stats ) ) {
	return;
}
?>
<section class="pl-metrics" aria-labelledby="pl-metrics-title">
	<div class="pl-metrics__mesh" aria-hidden="true"></div>
	<div class="pl-container">
		<div class="pl-metrics__grid">
			<div class="pl-metrics__intro pl-reveal">
				<p class="pl-kicker"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-metrics-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1.25rem;"><?php echo esc_html( $body ); ?></p>
			</div>
			<div class="pl-metrics__cards">
				<?php foreach ( $stats as $stat ) : ?>
					<div class="pl-metric pl-reveal">
						<p class="pl-metric__value"><?php echo esc_html( $stat['value'] ); ?></p>
						<p class="pl-metric__label"><?php echo esc_html( $stat['label'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
