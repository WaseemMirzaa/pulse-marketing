<?php
/**
 * Contact — info cards + social + a richer native form (or a Jotform embed
 * when an ID is configured).
 *
 * @package PulseLyft
 */

$kicker  = pulselyft_get( 'contact.kicker' );
$title   = pulselyft_get( 'contact.title', 'pulselyft_contact_title' );
$sub     = pulselyft_get( 'contact.sub', 'pulselyft_contact_sub' );
$email   = pulselyft_get( 'brand.email', 'pulselyft_brand_email' );
$jotform = trim( (string) get_theme_mod( 'pulselyft_contact_jotform', '' ) );
$sent    = isset( $_GET['pl_contact'] ) ? sanitize_key( wp_unslash( $_GET['pl_contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$book    = is_front_page() ? '#book-call' : ( pulselyft_page_url( 'contact' ) ? pulselyft_page_url( 'contact' ) . '#book-call' : home_url( '/#book-call' ) );

$socials = array(
	'LinkedIn'  => array( get_theme_mod( 'pulselyft_social_linkedin', '' ), '<path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3 9h4v12H3V9Zm6 0h3.8v1.64h.05c.53-.95 1.83-1.95 3.77-1.95 4.03 0 4.78 2.45 4.78 5.64V21H17.6v-5.3c0-1.26-.02-2.9-1.77-2.9-1.77 0-2.04 1.38-2.04 2.8V21H9V9Z"/>' ),
	'X'         => array( get_theme_mod( 'pulselyft_social_x', '' ), '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.66l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Z"/>' ),
	'Instagram' => array( get_theme_mod( 'pulselyft_social_instagram', '' ), '<rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/>' ),
);
$socials = array_filter( $socials, function ( $s ) { return ! empty( $s[0] ); } );
?>
<section id="contact" class="pl-section pl-section--page pl-scroll-anchor" aria-labelledby="pl-contact-title">
	<div class="pl-container">
		<div class="pl-contact-grid">
			<div class="pl-reveal">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-contact-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1.25rem;"><?php echo esc_html( $sub ); ?></p>

				<ul class="pl-cinfo">
					<li>
						<a class="pl-cinfo__item" href="<?php echo esc_url( 'mailto:' . $email ); ?>">
							<span class="pl-cinfo__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
							<span>
								<span class="pl-cinfo__label"><?php esc_html_e( 'Email us', 'pulselyft' ); ?></span>
								<span class="pl-cinfo__value"><?php echo esc_html( $email ); ?></span>
							</span>
						</a>
					</li>
					<li>
						<a class="pl-cinfo__item" href="<?php echo esc_url( $book ); ?>">
							<span class="pl-cinfo__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4" stroke-linecap="round"/></svg></span>
							<span>
								<span class="pl-cinfo__label"><?php esc_html_e( 'Book a call', 'pulselyft' ); ?></span>
								<span class="pl-cinfo__value"><?php esc_html_e( '30-minute intro', 'pulselyft' ); ?></span>
							</span>
						</a>
					</li>
					<li>
						<div class="pl-cinfo__item">
							<span class="pl-cinfo__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
							<span>
								<span class="pl-cinfo__label"><?php esc_html_e( 'Response time', 'pulselyft' ); ?></span>
								<span class="pl-cinfo__value"><?php esc_html_e( 'Within 1 business day', 'pulselyft' ); ?></span>
							</span>
						</div>
					</li>
				</ul>

				<?php if ( $socials ) : ?>
					<div class="pl-social">
						<?php foreach ( $socials as $label => $data ) : ?>
							<a class="pl-social__link" href="<?php echo esc_url( $data[0] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $label ); ?>">
								<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><?php echo $data[1]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG markup. ?></svg>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="pl-reveal">
				<?php if ( '' !== $jotform ) : ?>
					<div class="pl-embed" style="min-height:600px;">
						<iframe title="<?php esc_attr_e( 'Contact form', 'pulselyft' ); ?>" src="<?php echo esc_url( 'https://form.jotform.com/' . rawurlencode( $jotform ) ); ?>" style="min-height:640px;" loading="lazy"></iframe>
					</div>
				<?php else : ?>
					<div class="pl-formcard">
						<p class="pl-formcard__title"><?php esc_html_e( 'Send us a message', 'pulselyft' ); ?></p>
						<p class="pl-formcard__sub"><?php esc_html_e( 'Tell us a little about your goals and we will reply within one business day.', 'pulselyft' ); ?></p>

						<?php if ( 'sent' === $sent ) : ?>
							<div class="pl-alert pl-alert--ok"><?php esc_html_e( 'Thanks — your message is on its way. We reply within one business day.', 'pulselyft' ); ?></div>
						<?php elseif ( 'error' === $sent ) : ?>
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
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
