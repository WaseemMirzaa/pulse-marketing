<?php
/**
 * PulseLyft brand layer for the Gecko theme.
 *
 * Keeps all PulseLyft-specific behaviour in one file so the underlying Gecko
 * framework stays untouched (and upgradeable):
 *
 *   1. Enqueues the PulseLyft skin (fonts + assets/css/pulselyft-skin.css)
 *      AFTER Gecko's own stylesheet so the brand rules win the cascade.
 *   2. Adds a `pl-scope` body class the skin can hook onto.
 *   3. Auto-provisions the marketing site as WPBakery-editable pages on first
 *      activation — Home, About, Services, Pricing, Contact — reading the
 *      shortcode content from /pulselyft-pages/*.html. Every page is flagged as
 *      a WPBakery page (`_wpb_vc_js_status = true`) so it opens straight into
 *      the drag-and-drop editor.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PULSELYFT_GECKO_VERSION', '1.0.0' );

/**
 * Enqueue the PulseLyft fonts + skin after Gecko's styles.
 *
 * Priority 20 runs after Gecko's enqueue (priority 10), so `pulselyft-skin.css`
 * is printed last and overrides the base theme.
 */
function pulselyft_gecko_enqueue() {
	// Brand fonts: Fraunces (display), Inter (sans), JetBrains Mono (mono).
	wp_enqueue_style(
		'pulselyft-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap',
		array(),
		PULSELYFT_GECKO_VERSION
	);

	// The skin — depends on Gecko's main stylesheet handle so it always loads after it.
	$deps = wp_style_is( 'jas-gecko-style', 'registered' ) ? array( 'jas-gecko-style' ) : array();
	wp_enqueue_style(
		'pulselyft-skin',
		get_template_directory_uri() . '/assets/css/pulselyft-skin.css',
		$deps,
		PULSELYFT_GECKO_VERSION
	);

	wp_enqueue_script(
		'pulselyft-skin',
		get_template_directory_uri() . '/assets/js/pulselyft-skin.js',
		array(),
		PULSELYFT_GECKO_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'pulselyft_gecko_enqueue', 20 );

/**
 * Add a scope class so skin rules can raise specificity without !important.
 *
 * @param array $classes Body classes.
 * @return array
 */
function pulselyft_gecko_body_class( $classes ) {
	$classes[] = 'pl-scope';
	return $classes;
}
add_filter( 'body_class', 'pulselyft_gecko_body_class' );

/**
 * Read a WPBakery page template shipped with the theme.
 *
 * @param string $slug File slug in /pulselyft-pages (without extension).
 * @return string Shortcode content, or '' when the file is missing.
 */
function pulselyft_gecko_page_template( $slug ) {
	$file = get_template_directory() . '/pulselyft-pages/' . sanitize_file_name( $slug ) . '.html';
	if ( ! is_readable( $file ) ) {
		return '';
	}
	return (string) file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
}

/**
 * Create (or refresh) a single WPBakery-editable page.
 *
 * @param string $slug  Page slug.
 * @param string $title Page title.
 * @return int Page ID (0 on failure).
 */
function pulselyft_gecko_upsert_page( $slug, $title ) {
	$content = pulselyft_gecko_page_template( $slug );
	if ( '' === $content ) {
		return 0;
	}

	$existing = get_page_by_path( $slug );
	$args     = array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	);

	if ( $existing instanceof WP_Post ) {
		$args['ID'] = $existing->ID;
		$page_id    = wp_update_post( $args );
	} else {
		$page_id = wp_insert_post( $args );
	}

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		// Tell WPBakery this page is built with the page builder → opens in the
		// drag-and-drop editor, and Gecko renders it full-width (no sidebar wrap).
		update_post_meta( $page_id, '_wpb_vc_js_status', 'true' );
		update_post_meta( $page_id, '_custom_page_options', array( 'page-layout' => 'no-sidebar' ) );
		return (int) $page_id;
	}

	return 0;
}

/**
 * Provision the full PulseLyft site once, on first activation.
 *
 * Creates the pages, sets a static Home front page, and builds a primary menu.
 * Guarded by an option so re-activating never clobbers edited content.
 */
function pulselyft_gecko_provision() {
	if ( get_option( 'pulselyft_gecko_provisioned' ) ) {
		return;
	}

	$pages = array(
		'home'     => __( 'Home', 'gecko' ),
		'about'    => __( 'About', 'gecko' ),
		'services' => __( 'Services', 'gecko' ),
		'pricing'  => __( 'Pricing', 'gecko' ),
		'contact'  => __( 'Contact', 'gecko' ),
	);

	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$id = pulselyft_gecko_upsert_page( $slug, $title );
		if ( $id ) {
			$ids[ $slug ] = $id;
		}
	}

	// Static front page = Home.
	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	// Primary navigation menu wired to the theme's 'primary' location.
	pulselyft_gecko_build_menu( $ids );

	update_option( 'pulselyft_gecko_provisioned', 1 );
}
add_action( 'after_switch_theme', 'pulselyft_gecko_provision' );

/**
 * Build a primary menu from the provisioned pages and assign it to Gecko's
 * 'primary' menu location.
 *
 * @param array $ids Map of slug => page ID.
 */
function pulselyft_gecko_build_menu( $ids ) {
	$menu_name = 'PulseLyft Primary';
	$menu      = wp_get_nav_menu_object( $menu_name );
	$menu_id   = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $menu_name );

	if ( ! $menu_id || is_wp_error( $menu_id ) ) {
		return;
	}

	// Only populate an empty menu so we never duplicate items on re-runs.
	if ( ! wp_get_nav_menu_items( $menu_id ) ) {
		$order = array( 'home', 'services', 'pricing', 'about', 'contact' );
		$i     = 1;
		foreach ( $order as $slug ) {
			if ( empty( $ids[ $slug ] ) ) {
				continue;
			}
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-object-id' => $ids[ $slug ],
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $i++,
				)
			);
		}
	}

	// Assign to the menu locations Gecko registers ('primary-menu' is the header).
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	$locations['primary-menu'] = $menu_id;
	$locations['footer-menu']  = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Admin nudge: if WPBakery Page Builder is not active, tell the user how to get
 * the drag-and-drop editor working. Gecko bundles it via TGMPA
 * (Appearance → Install Plugins).
 */
function pulselyft_gecko_admin_notice() {
	if ( defined( 'WPB_VC_VERSION' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'themes' !== $screen->id && 'dashboard' !== $screen->id ) {
		return;
	}
	echo '<div class="notice notice-info"><p><strong>PulseLyft:</strong> ';
	echo esc_html__( 'Install & activate the "WPBakery Page Builder" plugin (Appearance → Install Plugins) to edit every page with the drag-and-drop editor.', 'gecko' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'pulselyft_gecko_admin_notice' );
