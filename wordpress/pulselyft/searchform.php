<?php
/**
 * Search form.
 *
 * @package PulseLyft
 */
?>
<form role="search" method="get" class="pl-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="grid-template-columns:1fr auto;align-items:end;gap:0.5rem;">
	<div class="pl-field">
		<label for="pl-search" class="pl-sr-only"><?php esc_html_e( 'Search for:', 'pulselyft' ); ?></label>
		<input type="search" id="pl-search" name="s" placeholder="<?php esc_attr_e( 'Search…', 'pulselyft' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
	</div>
	<button type="submit" class="pl-btn pl-btn--primary"><?php esc_html_e( 'Search', 'pulselyft' ); ?></button>
</form>
