<?php
/**
 * Site header: <head>, opening <body>, and the fixed navigation bar.
 *
 * @package PulseLyft
 */

$brand = pulselyft_brand();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="theme-color" content="#0f0f10">
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
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#pl-main"><?php esc_html_e( 'Skip to content', 'pulselyft' ); ?></a>

<div class="pl-progress" id="pl-progress" aria-hidden="true"></div>

<header class="pl-header" id="pl-header">
	<div class="pl-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pl-logo" rel="home" aria-label="<?php echo esc_attr( $brand['full'] ); ?>">
			<span class="pl-logo__mark">
				<?php if ( has_custom_logo() ) : ?>
					<?php
					$logo_id = get_theme_mod( 'custom_logo' );
					echo wp_get_attachment_image( $logo_id, 'full', false, array( 'alt' => $brand['full'] ) );
					?>
				<?php else : ?>
					<?php echo esc_html( mb_substr( $brand['prefix'], 0, 1 ) ); ?>
				<?php endif; ?>
			</span>
			<span class="pl-logo__text"><?php echo esc_html( $brand['prefix'] ); ?><span><?php echo esc_html( $brand['accent'] ); ?></span></span>
		</a>

		<nav class="pl-nav" aria-label="<?php esc_attr_e( 'Primary', 'pulselyft' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'link_before'    => '',
					'walker'         => new Pulselyft_Link_Walker(),
				) );
			} else {
				foreach ( pulselyft_primary_nav() as $item ) {
					printf( '<a class="pl-nav__link" href="%s">%s</a>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
				}
			}
			$book = is_front_page() ? '#book-call' : home_url( '/#book-call' );
			?>
			<button type="button" class="pl-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'pulselyft' ); ?>">
				<svg class="pl-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" stroke-linejoin="round"/></svg>
				<svg class="pl-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" stroke-linecap="round"/></svg>
			</button>
			<a href="<?php echo esc_url( $book ); ?>" class="pl-btn pl-btn--primary pl-btn--sm"><?php esc_html_e( 'Book a call', 'pulselyft' ); ?></a>
		</nav>

		<button type="button" class="pl-burger" id="pl-burger" aria-expanded="false" aria-controls="pl-mobile-nav" aria-label="<?php esc_attr_e( 'Menu', 'pulselyft' ); ?>">
			<span></span><span></span>
		</button>
	</div>

	<div class="pl-mobile-nav" id="pl-mobile-nav">
		<div class="pl-mobile-nav__list">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'walker'         => new Pulselyft_Link_Walker( 'pl-mobile-link' ),
				) );
			} else {
				foreach ( pulselyft_primary_nav() as $item ) {
					printf( '<a href="%s">%s</a>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
				}
			}
			?>
			<a href="<?php echo esc_url( $book ); ?>" class="pl-btn pl-btn--primary"><?php esc_html_e( 'Book a call', 'pulselyft' ); ?></a>
			<button type="button" class="pl-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'pulselyft' ); ?>" style="margin-top:0.5rem;">
				<svg class="pl-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" stroke-linejoin="round"/></svg>
				<svg class="pl-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" stroke-linecap="round"/></svg>
			</button>
		</div>
	</div>
</header>

<main id="pl-main">
