<?php
/**
 * Contact — Jotform embed when an ID is configured, otherwise a native,
 * wp_mail-backed contact form.
 *
 * @package PulseLyft
 */

$kicker    = pulselyft_get( 'contact.kicker' );
$title     = pulselyft_get( 'contact.title', 'pulselyft_contact_title' );
$sub       = pulselyft_get( 'contact.sub', 'pulselyft_contact_sub' );
$points    = pulselyft_get( 'contact.points' );
$jotform   = trim( (string) get_theme_mod( 'pulselyft_contact_jotform', '' ) );
$sent      = isset( $_GET['pl_contact'] ) ? sanitize_key( wp_unslash( $_GET['pl_contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<section id="contact" class="pl-section pl-section--page pl-scroll-anchor" style="padding-top:1rem;" aria-labelledby="pl-contact-title">
	<div class="pl-container">
		<div class="pl-split">
			<div class="pl-split__aside--5 pl-reveal">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-contact-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1.25rem;"><?php echo esc_html( $sub ); ?></p>
				<?php if ( is_array( $points ) && $points ) : ?>
					<ul class="pl-checklist">
						<?php foreach ( $points as $point ) : ?>
							<li><span class="pl-checklist__dot" aria-hidden="true"></span><?php echo esc_html( $point ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<a href="#book-call" class="pl-btn pl-btn--secondary" style="margin-top:2rem;"><?php esc_html_e( 'Or book a call directly →', 'pulselyft' ); ?></a>
			</div>

			<div class="pl-split__main--7 pl-reveal">
				<?php if ( '' !== $jotform ) : ?>
					<div class="pl-embed" style="min-height:600px;">
						<iframe
							title="<?php esc_attr_e( 'Contact form', 'pulselyft' ); ?>"
							src="<?php echo esc_url( 'https://form.jotform.com/' . rawurlencode( $jotform ) ); ?>"
							style="min-height:640px;"
							loading="lazy"></iframe>
					</div>
				<?php else : ?>
					<div class="pl-card" style="padding:2rem;">
						<?php if ( 'sent' === $sent ) : ?>
							<div style="margin-bottom:1rem;border-radius:0.75rem;background:var(--lift-soft);padding:0.85rem 1rem;color:var(--ink);font-size:0.9rem;font-weight:600;">
								<?php esc_html_e( 'Thanks — your message is on its way. We reply within one business day.', 'pulselyft' ); ?>
							</div>
						<?php elseif ( 'error' === $sent ) : ?>
							<div style="margin-bottom:1rem;border-radius:0.75rem;background:#fee2e2;padding:0.85rem 1rem;color:#991b1b;font-size:0.9rem;font-weight:600;">
								<?php esc_html_e( 'Something went wrong. Please email us directly or try again.', 'pulselyft' ); ?>
							</div>
						<?php endif; ?>

						<form class="pl-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
							<input type="hidden" name="action" value="pulselyft_contact">
							<?php wp_nonce_field( 'pulselyft_contact', 'pulselyft_contact_nonce' ); ?>
							<!-- Honeypot -->
							<div style="position:absolute;left:-9999px;" aria-hidden="true">
								<label for="pl-website"><?php esc_html_e( 'Leave blank', 'pulselyft' ); ?></label>
								<input type="text" id="pl-website" name="pl_website" tabindex="-1" autocomplete="off">
							</div>
							<div class="pl-field">
								<label for="pl-name"><?php esc_html_e( 'Name', 'pulselyft' ); ?></label>
								<input type="text" id="pl-name" name="pl_name" required>
							</div>
							<div class="pl-field">
								<label for="pl-email"><?php esc_html_e( 'Work email', 'pulselyft' ); ?></label>
								<input type="email" id="pl-email" name="pl_email" required>
							</div>
							<div class="pl-field">
								<label for="pl-company"><?php esc_html_e( 'Company / website', 'pulselyft' ); ?></label>
								<input type="text" id="pl-company" name="pl_company">
							</div>
							<div class="pl-field">
								<label for="pl-message"><?php esc_html_e( 'What does winning look like?', 'pulselyft' ); ?></label>
								<textarea id="pl-message" name="pl_message" rows="5" required></textarea>
							</div>
							<button type="submit" class="pl-btn pl-btn--primary" style="justify-self:start;"><?php esc_html_e( 'Send message', 'pulselyft' ); ?></button>
							<p class="pl-form__note"><?php esc_html_e( 'We will only use your details to reply. No lists, no spam.', 'pulselyft' ); ?></p>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
