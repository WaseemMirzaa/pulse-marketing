<?php
/**
 * Hero section.
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
$image     = pulselyft_get( 'hero.heroImage', 'pulselyft_hero_image' );
$image_alt = pulselyft_get( 'hero.heroImageAlt', 'pulselyft_hero_image_alt' );
$stats     = pulselyft_get( 'hero.stats' );
$float     = pulselyft_get( 'hero.floatCard' );
?>
<section class="pl-hero" aria-label="<?php esc_attr_e( 'Introduction', 'pulselyft' ); ?>">
	<div class="pl-hero__bg-mesh" aria-hidden="true"></div>
	<div class="pl-hero__bg-grid" aria-hidden="true"></div>

	<div class="pl-hero__inner">
		<div class="pl-hero__copy">
			<p class="pl-badge pl-reveal">
				<span class="pl-badge__dot" aria-hidden="true"></span>
				<?php echo esc_html( $badge ); ?>
			</p>
			<h1 class="pl-hero__title pl-balance pl-reveal">
				<?php echo esc_html( $before ); ?>
				<em><?php echo esc_html( $italic ); ?></em>
				<?php echo esc_html( $after ); ?>
			</h1>
			<p class="pl-hero__sub pl-reveal"><?php echo esc_html( $sub ); ?></p>

			<div class="pl-hero__cta pl-reveal">
				<a href="#book-call" class="pl-btn pl-btn--primary"><?php echo esc_html( $primary ); ?></a>
				<a href="#work" class="pl-btn pl-btn--secondary">
					<?php echo esc_html( $secondary ); ?>
					<span class="pl-arrow" aria-hidden="true">→</span>
				</a>
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

		<div class="pl-hero__media pl-reveal">
			<div class="pl-hero__frame pl-animate-float">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" width="800" height="1000" loading="eager" fetchpriority="high" decoding="async">
				<?php if ( is_array( $float ) ) : ?>
					<div class="pl-floatcard">
						<div class="pl-floatcard__inner">
							<p class="pl-floatcard__kicker"><?php echo esc_html( $float['kicker'] ); ?></p>
							<p class="pl-floatcard__title"><?php echo esc_html( $float['title'] ); ?></p>
							<p class="pl-floatcard__body"><?php echo esc_html( $float['body'] ); ?></p>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="pl-hero__blob" aria-hidden="true"></div>
		</div>
	</div>
</section>
