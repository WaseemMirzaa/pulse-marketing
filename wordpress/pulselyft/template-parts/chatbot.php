<?php
/**
 * Floating chat assistant. Logic lives in assets/js/main.js and talks to the
 * theme's REST endpoint (or an external API set in the Customizer).
 *
 * @package PulseLyft
 */

$brand = pulselyft_brand()['full'];
?>
<div class="pl-chat" id="pl-chat">
	<div class="pl-chat__panel" id="pl-chat-panel" role="dialog" aria-label="<?php esc_attr_e( 'Chat assistant', 'pulselyft' ); ?>" aria-modal="false">
		<div class="pl-chat__head">
			<div>
				<h4><?php echo esc_html( sprintf( /* translators: %s: brand name. */ __( '%s assistant', 'pulselyft' ), $brand ) ); ?></h4>
				<p><?php esc_html_e( 'Answers common questions', 'pulselyft' ); ?></p>
			</div>
			<button type="button" class="pl-chat__close" id="pl-chat-close" aria-label="<?php esc_attr_e( 'Close chat', 'pulselyft' ); ?>">&times;</button>
		</div>
		<div class="pl-chat__log" id="pl-chat-log" aria-live="polite">
			<div class="pl-chat__msg pl-chat__msg--bot"><?php esc_html_e( 'Hi — ask about Meta ads, SEO, pricing, our process, or how to reach the team.', 'pulselyft' ); ?></div>
		</div>
		<form class="pl-chat__form" id="pl-chat-form">
			<label for="pl-chat-input" class="pl-sr-only"><?php esc_html_e( 'Message', 'pulselyft' ); ?></label>
			<input type="text" id="pl-chat-input" class="pl-chat__input" placeholder="<?php esc_attr_e( 'Type a question…', 'pulselyft' ); ?>" maxlength="2000" autocomplete="off">
			<button type="submit" class="pl-chat__send" id="pl-chat-send"><?php esc_html_e( 'Send', 'pulselyft' ); ?></button>
		</form>
	</div>
	<button type="button" class="pl-chat__launcher" id="pl-chat-launcher" aria-expanded="false" aria-controls="pl-chat-panel">
		<span class="pl-sr-only"><?php esc_html_e( 'Open chat', 'pulselyft' ); ?></span>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
			<path d="M12 3C7.03 3 3 6.58 3 11c0 1.78.64 3.45 1.76 4.9L3 21l5.38-1.62C9.62 20.45 10.78 20.75 12 20.75c4.97 0 9-3.58 9-8s-4.03-8-9-8Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
			<circle cx="9" cy="11" r="1" fill="currentColor"/>
			<circle cx="12" cy="11" r="1" fill="currentColor"/>
			<circle cx="15" cy="11" r="1" fill="currentColor"/>
		</svg>
	</button>
</div>
