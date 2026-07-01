<?php
/**
 * PulseLyft header for the Gecko build.
 *
 * Self-contained: renders the exact PulseLyft fixed nav bar (same markup and
 * classes as the hand-coded pulselyft theme) so the chrome is pixel-identical,
 * without depending on Gecko's framework header. Menu comes from the theme's
 * 'primary-menu' location (provisioned on activation) with a hard-coded
 * fallback.
 *
 * @package PulseLyft
 */

$pl_prefix   = 'Pulse';
$pl_accent   = 'Lyft';
$pl_book     = home_url( '/contact/' );
$pl_fallback = array(
	home_url( '/services/' ) => __( 'Services', 'gecko' ),
	home_url( '/pricing/' )  => __( 'Pricing', 'gecko' ),
	home_url( '/about/' )    => __( 'About', 'gecko' ),
	home_url( '/contact/' )  => __( 'Contact', 'gecko' ),
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="theme-color" content="#14111f">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script>
		/* Set the colour theme before paint to avoid a flash. */
		(function () {
			try {
				var stored = localStorage.getItem('pl-theme');
				var dark = stored ? stored === 'dark'
					: window.matchMedia('(prefers-color-scheme: dark)').matches;
				if (dark) { document.documentElement.setAttribute('data-theme', 'dark'); }
			} catch (e) {}
		})();
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>

<a class="screen-reader-text" href="#pl-main"><?php esc_html_e( 'Skip to content', 'gecko' ); ?></a>

<div class="pl-progress" id="pl-progress" aria-hidden="true"></div>

<header class="pl-header" id="pl-header">
	<div class="pl-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pl-logo" rel="home" aria-label="<?php echo esc_attr( $pl_prefix . $pl_accent ); ?>">
			<span class="pl-logo__mark">
				<?php if ( has_custom_logo() ) : ?>
					<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'alt' => $pl_prefix . $pl_accent ) ); ?>
				<?php else : ?>
					<?php echo esc_html( mb_substr( $pl_prefix, 0, 1 ) ); ?>
				<?php endif; ?>
			</span>
			<span class="pl-logo__text"><?php echo esc_html( $pl_prefix ); ?><span><?php echo esc_html( $pl_accent ); ?></span></span>
		</a>

		<nav class="pl-nav" aria-label="<?php esc_attr_e( 'Primary', 'gecko' ); ?>">
			<?php
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary-menu',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'walker'         => new Pulselyft_Gecko_Link_Walker(),
				) );
			} else {
				foreach ( $pl_fallback as $url => $label ) {
					printf( '<a class="pl-nav__link" href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
				}
			}
			?>
			<button type="button" class="pl-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'gecko' ); ?>">
				<svg class="pl-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" stroke-linejoin="round"/></svg>
				<svg class="pl-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" stroke-linecap="round"/></svg>
			</button>
			<a href="<?php echo esc_url( $pl_book ); ?>" class="pl-btn pl-btn--primary pl-btn--sm"><?php esc_html_e( 'Book a call', 'gecko' ); ?></a>
		</nav>

		<button type="button" class="pl-burger" id="pl-burger" aria-expanded="false" aria-controls="pl-mobile-nav" aria-label="<?php esc_attr_e( 'Menu', 'gecko' ); ?>">
			<span></span><span></span>
		</button>
	</div>

	<div class="pl-mobile-nav" id="pl-mobile-nav">
		<div class="pl-mobile-nav__list">
			<?php
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary-menu',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'walker'         => new Pulselyft_Gecko_Link_Walker( 'pl-mobile-link' ),
				) );
			} else {
				foreach ( $pl_fallback as $url => $label ) {
					printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
				}
			}
			?>
			<a href="<?php echo esc_url( $pl_book ); ?>" class="pl-btn pl-btn--primary"><?php esc_html_e( 'Book a call', 'gecko' ); ?></a>
			<button type="button" class="pl-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'gecko' ); ?>" style="margin-top:0.5rem;">
				<svg class="pl-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" stroke-linejoin="round"/></svg>
				<svg class="pl-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" stroke-linecap="round"/></svg>
			</button>
		</div>
	</div>
</header>

<main id="pl-main">
