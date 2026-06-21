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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#pl-main"><?php esc_html_e( 'Skip to content', 'pulselyft' ); ?></a>

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
				$home = home_url( '/' );
				$links = array(
					'#services'  => __( 'Services', 'pulselyft' ),
					'#work'      => __( 'Work', 'pulselyft' ),
					'#portfolio' => __( 'Portfolio', 'pulselyft' ),
					'#process'   => __( 'Process', 'pulselyft' ),
					'#blog'      => __( 'Blog', 'pulselyft' ),
					'#contact'   => __( 'Contact', 'pulselyft' ),
				);
				foreach ( $links as $href => $label ) {
					$url = is_front_page() ? $href : $home . $href;
					printf( '<a class="pl-nav__link" href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
				}
			}
			$book = is_front_page() ? '#book-call' : home_url( '/#book-call' );
			?>
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
				$home = home_url( '/' );
				foreach ( $links as $href => $label ) {
					$url = is_front_page() ? $href : $home . $href;
					printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
				}
			}
			?>
			<a href="<?php echo esc_url( $book ); ?>" class="pl-btn pl-btn--primary"><?php esc_html_e( 'Book a call', 'pulselyft' ); ?></a>
		</div>
	</div>
</header>

<main id="pl-main">
