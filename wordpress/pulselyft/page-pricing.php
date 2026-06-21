<?php
/**
 * Template for the Pricing page (slug "pricing").
 *
 * @package PulseLyft
 */

get_header();

$p     = pulselyft_get( 'pages.pricing' );
$tiers = isset( $p['tiers'] ) ? $p['tiers'] : array();
$contact_url = pulselyft_page_url( 'contact' );
$cta_url     = $contact_url ? $contact_url : home_url( '/#book-call' );

pulselyft_page_hero( $p['kicker'], $p['title'], $p['sub'] );
?>

<section class="pl-section pl-section--page" aria-label="<?php esc_attr_e( 'Pricing plans', 'pulselyft' ); ?>">
	<div class="pl-container">
		<ul class="pl-pricing">
			<?php foreach ( $tiers as $tier ) : ?>
				<?php $featured = ! empty( $tier['featured'] ); ?>
				<li class="pl-price <?php echo $featured ? 'pl-price--featured' : ''; ?> pl-reveal">
					<?php if ( $featured ) : ?>
						<span class="pl-price__badge"><?php esc_html_e( 'Most popular', 'pulselyft' ); ?></span>
					<?php endif; ?>
					<h2 class="pl-price__name"><?php echo esc_html( $tier['name'] ); ?></h2>
					<p class="pl-price__amount">
						<span class="pl-price__value"><?php echo esc_html( $tier['price'] ); ?></span>
						<?php if ( ! empty( $tier['cadence'] ) ) : ?>
							<span class="pl-price__cadence"><?php echo esc_html( $tier['cadence'] ); ?></span>
						<?php endif; ?>
					</p>
					<p class="pl-price__blurb"><?php echo esc_html( $tier['blurb'] ); ?></p>
					<a href="<?php echo esc_url( $cta_url ); ?>" class="pl-btn <?php echo $featured ? 'pl-btn--primary' : 'pl-btn--secondary'; ?> pl-price__cta"><?php echo esc_html( $tier['cta'] ); ?></a>
					<ul class="pl-price__features">
						<?php foreach ( $tier['features'] as $feature ) : ?>
							<li>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
								<?php echo esc_html( $feature ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php if ( ! empty( $p['note'] ) ) : ?>
			<p class="pl-pricing__note pl-reveal"><?php echo esc_html( $p['note'] ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
pulselyft_section( 'faq' );
pulselyft_section( 'cta-band' );

get_footer();
