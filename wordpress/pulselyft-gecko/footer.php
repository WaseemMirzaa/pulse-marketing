<?php
/**
 * PulseLyft footer for the Gecko build — editorial footer, back-to-top, and
 * the floating chat assistant. Self-contained (no Gecko framework footer).
 *
 * @package PulseLyft
 */

$pl_prefix  = 'Pulse';
$pl_accent  = 'Lyft';
$pl_tagline = __( 'Performance marketing, Meta ads, and SEO for teams who measure twice and scale once.', 'gecko' );
$pl_email   = 'hello@pulselyft.com';
$pl_home    = home_url( '/' );
$pl_nav     = array(
	home_url( '/services/' ) => __( 'Services', 'gecko' ),
	home_url( '/pricing/' )  => __( 'Pricing', 'gecko' ),
	home_url( '/about/' )    => __( 'About', 'gecko' ),
	home_url( '/contact/' )  => __( 'Contact', 'gecko' ),
);
$pl_socials = array_filter( array(
	'LinkedIn'  => get_theme_mod( 'pulselyft_social_linkedin', '' ),
	'X'         => get_theme_mod( 'pulselyft_social_x', '' ),
	'Instagram' => get_theme_mod( 'pulselyft_social_instagram', '' ),
) );
?>
</main><!-- #pl-main -->

<footer class="pl-footer">
	<div class="pl-container pl-footer__inner">
		<div>
			<p class="pl-footer__brand">
				<span class="pl-footer__mark"><?php echo esc_html( mb_substr( $pl_prefix, 0, 1 ) ); ?></span>
				<?php echo esc_html( $pl_prefix ); ?><span class="pl-footer__accent"><?php echo esc_html( $pl_accent ); ?></span>
			</p>
			<p class="pl-footer__tag"><?php echo esc_html( $pl_tagline ); ?></p>
			<?php if ( $pl_socials ) : ?>
				<div class="pl-footer__col" style="margin-top:1.5rem;flex-direction:row;gap:1rem;">
					<?php foreach ( $pl_socials as $label => $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" rel="noopener noreferrer" target="_blank"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="pl-footer__cols">
			<div class="pl-footer__col">
				<span class="pl-footer__head"><?php esc_html_e( 'Navigate', 'gecko' ); ?></span>
				<?php foreach ( $pl_nav as $url => $label ) {
					printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
				} ?>
			</div>
			<div class="pl-footer__col">
				<span class="pl-footer__head"><?php esc_html_e( 'Company', 'gecko' ); ?></span>
				<?php printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $pl_email ) ); ?>
				<a href="<?php echo esc_url( $pl_home ); ?>"><?php esc_html_e( 'Home', 'gecko' ); ?></a>
			</div>
		</div>
	</div>
	<p class="pl-footer__legal">
		<?php
		/* translators: 1: year, 2: brand name. */
		printf( esc_html__( '© %1$s %2$s — All rights reserved.', 'gecko' ), esc_html( gmdate( 'Y' ) ), esc_html( $pl_prefix . $pl_accent ) );
		?>
	</p>
</footer>

<button type="button" class="pl-totop" id="pl-totop" aria-label="<?php esc_attr_e( 'Back to top', 'gecko' ); ?>">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
</button>

<div class="pl-chat" id="pl-chat">
	<div class="pl-chat__panel" id="pl-chat-panel" role="dialog" aria-label="<?php esc_attr_e( 'Chat assistant', 'gecko' ); ?>" aria-modal="false">
		<div class="pl-chat__head">
			<div>
				<h4><?php echo esc_html( $pl_prefix . $pl_accent . ' ' . __( 'assistant', 'gecko' ) ); ?></h4>
				<p><?php esc_html_e( 'Answers common questions', 'gecko' ); ?></p>
			</div>
			<button type="button" class="pl-chat__close" id="pl-chat-close" aria-label="<?php esc_attr_e( 'Close chat', 'gecko' ); ?>">&times;</button>
		</div>
		<div class="pl-chat__log" id="pl-chat-log" aria-live="polite">
			<div class="pl-chat__msg pl-chat__msg--bot"><?php esc_html_e( 'Hi — ask about Meta ads, SEO, pricing, our process, or how to reach the team.', 'gecko' ); ?></div>
		</div>
		<form class="pl-chat__form" id="pl-chat-form">
			<label for="pl-chat-input" class="pl-sr-only"><?php esc_html_e( 'Message', 'gecko' ); ?></label>
			<input type="text" id="pl-chat-input" class="pl-chat__input" placeholder="<?php esc_attr_e( 'Type a question…', 'gecko' ); ?>" maxlength="2000" autocomplete="off">
			<button type="submit" class="pl-chat__send" id="pl-chat-send"><?php esc_html_e( 'Send', 'gecko' ); ?></button>
		</form>
	</div>
	<button type="button" class="pl-chat__launcher" id="pl-chat-launcher" aria-expanded="false" aria-controls="pl-chat-panel">
		<span class="pl-sr-only"><?php esc_html_e( 'Open chat', 'gecko' ); ?></span>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
			<path d="M12 3C7.03 3 3 6.58 3 11c0 1.78.64 3.45 1.76 4.9L3 21l5.38-1.62C9.62 20.45 10.78 20.75 12 20.75c4.97 0 9-3.58 9-8s-4.03-8-9-8Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
			<circle cx="9" cy="11" r="1" fill="currentColor"/>
			<circle cx="12" cy="11" r="1" fill="currentColor"/>
			<circle cx="15" cy="11" r="1" fill="currentColor"/>
		</svg>
	</button>
</div>

<?php wp_footer(); ?>
</body>
</html>
