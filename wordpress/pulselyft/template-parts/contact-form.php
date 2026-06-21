<?php
/**
 * Reusable native contact form (wp_mail-backed, nonce + honeypot).
 * Used by the contact section and the [pulselyft_contact_form] shortcode, so a
 * working form can be dropped into any block-built page.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pl_sent = isset( $_GET['pl_contact'] ) ? sanitize_key( wp_unslash( $_GET['pl_contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<div class="pl-formcard">
	<p class="pl-formcard__title"><?php esc_html_e( 'Send us a message', 'pulselyft' ); ?></p>
	<p class="pl-formcard__sub"><?php esc_html_e( 'Tell us a little about your goals and we will reply within one business day.', 'pulselyft' ); ?></p>

	<?php if ( 'sent' === $pl_sent ) : ?>
		<div class="pl-alert pl-alert--ok"><?php esc_html_e( 'Thanks — your message is on its way. We reply within one business day.', 'pulselyft' ); ?></div>
	<?php elseif ( 'error' === $pl_sent ) : ?>
		<div class="pl-alert pl-alert--err"><?php esc_html_e( 'Something went wrong. Please email us directly or try again.', 'pulselyft' ); ?></div>
	<?php endif; ?>

	<form class="pl-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
		<input type="hidden" name="action" value="pulselyft_contact">
		<?php wp_nonce_field( 'pulselyft_contact', 'pulselyft_contact_nonce' ); ?>
		<div style="position:absolute;left:-9999px;" aria-hidden="true">
			<label for="pl-website"><?php esc_html_e( 'Leave blank', 'pulselyft' ); ?></label>
			<input type="text" id="pl-website" name="pl_website" tabindex="-1" autocomplete="off">
		</div>
		<div class="pl-form__row">
			<div class="pl-field">
				<label for="pl-name"><?php esc_html_e( 'Name', 'pulselyft' ); ?></label>
				<input type="text" id="pl-name" name="pl_name" required>
			</div>
			<div class="pl-field">
				<label for="pl-email"><?php esc_html_e( 'Work email', 'pulselyft' ); ?></label>
				<input type="email" id="pl-email" name="pl_email" required>
			</div>
		</div>
		<div class="pl-form__row">
			<div class="pl-field">
				<label for="pl-company"><?php esc_html_e( 'Company / website', 'pulselyft' ); ?></label>
				<input type="text" id="pl-company" name="pl_company">
			</div>
			<div class="pl-field">
				<label for="pl-topic"><?php esc_html_e( 'I need help with', 'pulselyft' ); ?></label>
				<select id="pl-topic" name="pl_topic">
					<option><?php esc_html_e( 'Meta ads & paid social', 'pulselyft' ); ?></option>
					<option><?php esc_html_e( 'SEO & content', 'pulselyft' ); ?></option>
					<option><?php esc_html_e( 'Analytics & attribution', 'pulselyft' ); ?></option>
					<option><?php esc_html_e( 'Full-funnel program', 'pulselyft' ); ?></option>
					<option><?php esc_html_e( 'Something else', 'pulselyft' ); ?></option>
				</select>
			</div>
		</div>
		<div class="pl-field">
			<label for="pl-message"><?php esc_html_e( 'What does winning look like?', 'pulselyft' ); ?></label>
			<textarea id="pl-message" name="pl_message" rows="5" required></textarea>
		</div>
		<button type="submit" class="pl-btn pl-btn--primary" style="justify-self:start;"><?php esc_html_e( 'Send message', 'pulselyft' ); ?></button>
		<p class="pl-form__note"><?php esc_html_e( 'We will only use your details to reply. No lists, no spam.', 'pulselyft' ); ?></p>
	</form>
</div>
