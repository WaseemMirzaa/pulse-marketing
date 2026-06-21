<?php
/**
 * Hero — editorial, type-forward composition (v2).
 *
 * @package PulseLyft
 */

$badge     = pulselyft_get( 'hero.badge', 'pulselyft_hero_badge' );
$before    = pulselyft_get( 'hero.headlineBefore', 'pulselyft_hero_before' );
$italic    = pulselyft_get( 'hero.headlineItalic', 'pulselyft_hero_italic' );
$after     = pulselyft_get( 'hero.headlineAfter', 'pulselyft_hero_after' );
$sub       = pulselyft_get( 'hero.sub', 'pulselyft_hero_sub' );
$primary   = pulselyft_get( 'hero.primaryCta', 'pulselyft_hero_primary' );
$secondary = pulselyft_get( 'hero.secondaryCta', 'pulselyft_hero_secondary' );
$stats     = pulselyft_get( 'hero.stats' );
?>
<section class="pl-hero" aria-label="<?php esc_attr_e( 'Introduction', 'pulselyft' ); ?>">
	<div class="pl-hero__bg" aria-hidden="true"></div>
	<div class="pl-hero__grid" aria-hidden="true"></div>

	<div class="pl-container pl-hero__inner">
		<p class="pl-kicker pl-kicker--lift pl-hero__eyebrow pl-reveal"><?php echo esc_html( $badge ); ?></p>

		<h1 class="pl-hero__title pl-balance pl-reveal">
			<?php echo esc_html( $before ); ?>
			<span class="pl-grad"><?php echo esc_html( $italic ); ?></span>
			<?php echo esc_html( $after ); ?>
		</h1>

		<div class="pl-hero__foot">
			<div class="pl-reveal">
				<p class="pl-hero__sub"><?php echo esc_html( $sub ); ?></p>
				<div class="pl-hero__cta">
					<a href="#book-call" class="pl-btn pl-btn--lift"><?php echo esc_html( $primary ); ?></a>
					<a href="#work" class="pl-btn pl-btn--secondary">
						<?php echo esc_html( $secondary ); ?>
						<span class="pl-arrow" aria-hidden="true">→</span>
					</a>
				</div>
			</div>

			<?php if ( is_array( $stats ) && $stats ) : ?>
				<dl class="pl-hero__stats pl-reveal">
					<?php foreach ( array_slice( $stats, 0, 3 ) as $stat ) : ?>
						<div>
							<dt class="pl-sr-only"><?php echo esc_html( $stat['label'] ); ?></dt>
							<dd class="pl-stat__value"><?php echo esc_html( $stat['value'] ); ?></dd>
							<dd class="pl-stat__label"><?php echo esc_html( $stat['label'] ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			<?php endif; ?>
		</div>
	</div>
</section>
