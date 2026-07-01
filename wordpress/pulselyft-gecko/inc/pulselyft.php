<?php
/**
 * PulseLyft brand layer for the Gecko theme.
 *
 * Delivers a pixel-identical copy of the hand-coded PulseLyft site on top of
 * the Gecko framework, while keeping every page editable in the WPBakery
 * Page Builder. Responsibilities:
 *
 *   1. Swap Gecko's front-end stylesheet/scripts for the real PulseLyft
 *      stylesheet + fonts + behaviour (so the look is 100% PulseLyft, not
 *      Gecko).
 *   2. Provide a flat nav-link walker so the WordPress menu matches the
 *      PulseLyft header markup exactly.
 *   3. Register no-plugin fallbacks for the handful of WPBakery shortcodes the
 *      provisioned pages use, so the site renders correctly even before the
 *      WPBakery plugin is installed (and defers to the real plugin once active).
 *   4. Auto-provision Home/About/Services/Pricing/Contact as WPBakery pages on
 *      first activation.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PULSELYFT_GECKO_VERSION', '1.1.0' );

/* =========================================================================
   1. Front-end assets — replace Gecko's look with PulseLyft's
   ========================================================================= */
/**
 * Dequeue Gecko's competing front-end CSS/JS and enqueue the PulseLyft
 * stylesheet, fonts and behaviour. Runs at priority 20 — after Gecko's own
 * enqueue (priority 10) — so the dequeues take effect.
 */
function pulselyft_gecko_enqueue() {
	// Drop Gecko's stylesheet + its inline custom CSS, animate.css and Google
	// font so only the PulseLyft design system paints the marketing pages.
	wp_dequeue_style( 'jas-gecko-style' );
	wp_dequeue_style( 'jas-gecko-animated' );
	wp_dequeue_style( 'jas-font-google' );
	// Gecko's theme.js expects Gecko markup we no longer render.
	wp_dequeue_script( 'jas-gecko-script' );

	// PulseLyft brand fonts: Fraunces (display), Inter (sans), JetBrains Mono.
	wp_enqueue_style(
		'pulselyft-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap',
		array(),
		PULSELYFT_GECKO_VERSION
	);

	// The complete PulseLyft stylesheet (same file as the hand-coded theme) +
	// a WPBakery layout-neutralizer appended at the end.
	wp_enqueue_style(
		'pulselyft-skin',
		get_template_directory_uri() . '/assets/css/pulselyft-skin.css',
		array( 'pulselyft-fonts' ),
		PULSELYFT_GECKO_VERSION
	);

	// The PulseLyft behaviour (theme toggle, sticky header, reveals, counters,
	// marquee, FAQ accordion, chat). Same file as the hand-coded theme.
	wp_enqueue_script(
		'pulselyft-skin',
		get_template_directory_uri() . '/assets/js/pulselyft-skin.js',
		array(),
		PULSELYFT_GECKO_VERSION,
		true
	);
	wp_localize_script( 'pulselyft-skin', 'PulseLyftCfg', array(
		'apiUrl' => esc_url_raw( get_theme_mod( 'pulselyft_chat_api', '' ) ),
	) );
}
add_action( 'wp_enqueue_scripts', 'pulselyft_gecko_enqueue', 20 );

/**
 * Add a scope class so the neutralizer/skin can raise specificity when needed.
 *
 * @param array $classes Body classes.
 * @return array
 */
function pulselyft_gecko_body_class( $classes ) {
	$classes[] = 'pl-scope';
	return $classes;
}
add_filter( 'body_class', 'pulselyft_gecko_body_class' );

/* =========================================================================
   2. Flat nav-link walker (matches PulseLyft header markup)
   ========================================================================= */
if ( ! class_exists( 'Pulselyft_Gecko_Link_Walker' ) ) {
	/**
	 * Renders plain <a> tags (no <ul>/<li>) so the WP menu matches the flat,
	 * flex-based PulseLyft header.
	 */
	class Pulselyft_Gecko_Link_Walker extends Walker_Nav_Menu {

		/** @var string CSS class applied to each anchor. */
		protected $link_class;

		/**
		 * @param string $link_class Anchor class. Defaults to the desktop nav link.
		 */
		public function __construct( $link_class = 'pl-nav__link' ) {
			$this->link_class = $link_class;
		}

		public function start_lvl( &$output, $depth = 0, $args = null ) {}
		public function end_lvl( &$output, $depth = 0, $args = null ) {}
		public function end_el( &$output, $item, $depth = 0, $args = null ) {}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$url   = ! empty( $item->url ) ? $item->url : '#';
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$output .= sprintf(
				'<a class="%1$s" href="%2$s">%3$s</a>',
				esc_attr( $this->link_class ),
				esc_url( $url ),
				esc_html( $title )
			);
		}
	}
}

/* =========================================================================
   3. No-plugin fallbacks for the WPBakery shortcodes used on provisioned pages
   -------------------------------------------------------------------------
   The provisioned pages wrap each PulseLyft section in
   [vc_row][vc_column][vc_column_text]…[/vc_column_text][/vc_column][/vc_row].
   When the real WPBakery plugin is active it owns these shortcodes (and the
   drag-and-drop editor). When it is NOT yet installed, these lightweight
   fallbacks make the pages render correctly instead of printing raw [vc_row]
   tags. The section markup inside is self-contained PulseLyft HTML, so the
   fallbacks only need to emit the inner content.
   ========================================================================= */
/**
 * Extract an attribute (e.g. el_class) from a shortcode attribute array.
 *
 * @param array|string $atts Shortcode atts.
 * @param string       $key  Attribute name.
 * @return string
 */
function pulselyft_gecko_sc_attr( $atts, $key ) {
	return ( is_array( $atts ) && ! empty( $atts[ $key ] ) ) ? (string) $atts[ $key ] : '';
}

function pulselyft_gecko_register_fallback_shortcodes() {
	// If the real WPBakery plugin is active, do nothing — it registers these.
	if ( defined( 'WPB_VC_VERSION' ) || shortcode_exists( 'vc_row' ) ) {
		return;
	}

	add_shortcode( 'vc_row', function ( $atts, $content = '' ) {
		$cls = trim( 'pl-vc-row ' . pulselyft_gecko_sc_attr( $atts, 'el_class' ) );
		$id  = pulselyft_gecko_sc_attr( $atts, 'el_id' );
		$id  = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		return '<div class="' . esc_attr( $cls ) . '"' . $id . '>' . do_shortcode( $content ) . '</div>';
	} );

	add_shortcode( 'vc_column', function ( $atts, $content = '' ) {
		return '<div class="pl-vc-col">' . do_shortcode( $content ) . '</div>';
	} );

	add_shortcode( 'vc_column_text', function ( $atts, $content = '' ) {
		$cls = trim( 'wpb_text_column ' . pulselyft_gecko_sc_attr( $atts, 'el_class' ) );
		// Content is already HTML; WPBakery stores it lightly encoded — decode
		// the couple of entities it uses so raw markup renders.
		$html = str_replace( array( '&#91;', '&#93;' ), array( '[', ']' ), (string) $content );
		return '<div class="' . esc_attr( $cls ) . '">' . do_shortcode( $html ) . '</div>';
	} );
}
add_action( 'init', 'pulselyft_gecko_register_fallback_shortcodes', 20 );

/* =========================================================================
   4. First-run provisioning of the WPBakery pages
   ========================================================================= */
/**
 * Read a WPBakery page template shipped with the theme.
 *
 * @param string $slug File slug in /pulselyft-pages (without extension).
 * @return string
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
		update_post_meta( $page_id, '_wpb_vc_js_status', 'true' );
		update_post_meta( $page_id, '_custom_page_options', array( 'page-layout' => 'no-sidebar' ) );
		return (int) $page_id;
	}

	return 0;
}

/**
 * Provision the full PulseLyft site.
 *
 * Runs on first activation, and again whenever the shipped theme version
 * changes (so content updates land) — but only once per version, so it never
 * fights routine editing. Hooked on both theme switch and admin_init to cover
 * plain file updates that don't re-fire after_switch_theme.
 */
function pulselyft_gecko_provision() {
	if ( get_option( 'pulselyft_gecko_provisioned' ) === PULSELYFT_GECKO_VERSION ) {
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

	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	pulselyft_gecko_build_menu( $ids );

	update_option( 'pulselyft_gecko_provisioned', PULSELYFT_GECKO_VERSION );
}
add_action( 'after_switch_theme', 'pulselyft_gecko_provision' );
add_action( 'admin_init', 'pulselyft_gecko_provision' );

/**
 * Build a primary menu from the provisioned pages and assign it to Gecko's
 * menu locations.
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

	if ( ! wp_get_nav_menu_items( $menu_id ) ) {
		$order = array( 'services', 'pricing', 'about', 'contact' );
		$i     = 1;
		foreach ( $order as $slug ) {
			if ( empty( $ids[ $slug ] ) ) {
				continue;
			}
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-object-id' => $ids[ $slug ],
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $i++,
			) );
		}
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	$locations['primary-menu'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Admin nudge: if WPBakery Page Builder is not active, explain how to enable
 * the drag-and-drop editor (Gecko bundles it via Appearance → Install Plugins).
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
	echo esc_html__( 'The site is live and styled. Install & activate "WPBakery Page Builder" (Appearance → Install Plugins) to edit every page with the drag-and-drop editor.', 'gecko' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'pulselyft_gecko_admin_notice' );
