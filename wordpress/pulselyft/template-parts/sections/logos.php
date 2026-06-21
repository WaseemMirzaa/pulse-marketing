<?php
/**
 * Logo strip (infinite marquee).
 *
 * @package PulseLyft
 */

$line   = pulselyft_get( 'logos.line' );
$brands = pulselyft_get( 'logos.brands' );
if ( ! is_array( $brands ) || ! $brands ) {
	return;
}
$track = array_merge( $brands, $brands ); // Duplicate for a seamless loop.
?>
<section class="pl-logos" aria-label="<?php esc_attr_e( 'Trusted by', 'pulselyft' ); ?>">
	<div class="pl-logos__fade pl-logos__fade--l" aria-hidden="true"></div>
	<div class="pl-logos__fade pl-logos__fade--r" aria-hidden="true"></div>
	<p class="pl-logos__line"><?php echo esc_html( $line ); ?></p>
	<div class="pl-logos__viewport">
		<div class="pl-logos__track">
			<?php foreach ( $track as $i => $brand ) : ?>
				<span class="pl-logos__item" <?php echo ( $i >= count( $brands ) ) ? 'aria-hidden="true"' : ''; ?>><?php echo esc_html( $brand ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</section>
