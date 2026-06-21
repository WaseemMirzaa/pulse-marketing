<?php
/**
 * Process — how we engage.
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'process.kicker' );
$title  = pulselyft_get( 'process.title' );
$intro  = pulselyft_get( 'process.intro' );
$steps  = pulselyft_get( 'process.steps' );
if ( ! is_array( $steps ) ) {
	return;
}
?>
<section id="process" class="pl-section pl-section--paper pl-scroll-anchor" aria-labelledby="pl-process-title">
	<div class="pl-container">
		<div class="pl-reveal">
			<p class="pl-kicker"><?php echo esc_html( $kicker ); ?></p>
			<h2 id="pl-process-title" class="pl-h2 pl-balance" style="max-width:48rem;"><?php echo esc_html( $title ); ?></h2>
			<p class="pl-lede" style="margin-top:1rem;max-width:42rem;"><?php echo esc_html( $intro ); ?></p>
		</div>

		<div class="pl-process__steps">
			<div class="pl-process__line" aria-hidden="true"></div>
			<ol class="pl-process__list">
				<?php foreach ( $steps as $step ) : ?>
					<li class="pl-step pl-reveal">
						<span class="pl-step__n"><?php echo esc_html( $step['n'] ); ?></span>
						<h3 class="pl-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
						<p class="pl-step__text"><?php echo esc_html( $step['body'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
