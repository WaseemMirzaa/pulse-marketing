<?php
/**
 * Case studies / selected work.
 *
 * @package PulseLyft
 */

$kicker    = pulselyft_get( 'work.kicker' );
$title     = pulselyft_get( 'work.title' );
$intro     = pulselyft_get( 'work.intro' );
$cta       = pulselyft_get( 'work.cta' );
$case_body = pulselyft_get( 'work.caseBody' );
$cases     = pulselyft_get( 'work.cases' );
if ( ! is_array( $cases ) ) {
	return;
}
?>
<section id="work" class="pl-section pl-section--page pl-scroll-anchor" aria-labelledby="pl-work-title">
	<div class="pl-container">
		<div class="pl-sec-head pl-reveal">
			<div class="pl-sec-head__main">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-work-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1rem;max-width:36rem;"><?php echo esc_html( $intro ); ?></p>
			</div>
			<a href="#book-call" class="pl-btn pl-btn--secondary pl-btn--sm"><?php echo esc_html( $cta ); ?> <span aria-hidden="true">→</span></a>
		</div>

		<div class="pl-work__grid">
			<?php foreach ( $cases as $case ) : ?>
				<?php $featured = ! empty( $case['featured'] ); ?>
				<article class="pl-case <?php echo $featured ? 'pl-case--featured' : ''; ?> pl-reveal">
					<div class="pl-case__media">
						<img src="<?php echo esc_url( $case['img'] ); ?>" alt="<?php echo esc_attr( $case['title'] ); ?>" loading="lazy" decoding="async">
						<span class="pl-case__tag"><?php echo esc_html( $case['tag'] ); ?></span>
					</div>
					<div class="pl-case__body">
						<h3 class="pl-case__title"><?php echo esc_html( $case['title'] ); ?></h3>
						<p class="pl-case__result"><?php echo esc_html( $case['result'] ); ?></p>
						<?php if ( $featured && $case_body ) : ?>
							<p class="pl-case__note"><?php echo esc_html( $case_body ); ?></p>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
