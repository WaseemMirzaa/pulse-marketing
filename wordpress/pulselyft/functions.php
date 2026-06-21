<?php
/**
 * PulseLyft theme functions and definitions.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'PULSELYFT_VERSION' ) ) {
	define( 'PULSELYFT_VERSION', '3.2.0' );
}

require_once get_template_directory() . '/inc/content.php';
require_once get_template_directory() . '/inc/nav-walker.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/patterns.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/seo.php';

/**
 * Theme setup.
 */
function pulselyft_setup() {
	load_theme_textdomain( 'pulselyft', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 40,
		'width'       => 40,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	// Make the block editor render content in the theme's look.
	add_editor_style( array(
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap',
		'style.css',
	) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'pulselyft' ),
		'footer'  => __( 'Footer Menu', 'pulselyft' ),
	) );

	// Default content width for embeds.
	if ( ! isset( $GLOBALS['content_width'] ) ) {
		$GLOBALS['content_width'] = 768;
	}
}
add_action( 'after_setup_theme', 'pulselyft_setup' );

/**
 * Enqueue styles and scripts.
 */
function pulselyft_assets() {
	// Google Fonts: Fraunces (display) + Outfit (sans) — matches the web app.
	wp_enqueue_style(
		'pulselyft-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'pulselyft-style',
		get_stylesheet_uri(),
		array( 'pulselyft-fonts' ),
		PULSELYFT_VERSION
	);

	wp_enqueue_script(
		'pulselyft-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		PULSELYFT_VERSION,
		true
	);

	// Expose chatbot config + REST nonce to the front-end script.
	wp_localize_script( 'pulselyft-main', 'PulseLyftCfg', array(
		'apiUrl'  => esc_url_raw( get_theme_mod( 'pulselyft_chat_api_url', '' ) ),
		'brand'   => pulselyft_brand()['full'],
		'restUrl' => esc_url_raw( rest_url( 'pulselyft/v1/chat' ) ),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pulselyft_assets' );

/**
 * Preconnect to font + image hosts for performance/SEO.
 */
function pulselyft_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$hints[] = 'https://images.unsplash.com';
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'pulselyft_resource_hints', 10, 2 );

/**
 * Helper: include a section template part.
 *
 * @param string $name Section slug under template-parts/sections/.
 */
function pulselyft_section( $name ) {
	get_template_part( 'template-parts/sections/' . $name );
}

/**
 * Register the chatbot REST endpoint (lightweight FAQ assistant).
 * Provides a self-contained fallback so the theme works without the Nest API.
 */
function pulselyft_register_rest() {
	register_rest_route( 'pulselyft/v1', '/chat', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'pulselyft_chat_reply',
		'args'                => array(
			'message' => array(
				'required'          => true,
				'sanitize_callback' => 'sanitize_text_field',
			),
		),
	) );
}
add_action( 'rest_api_init', 'pulselyft_register_rest' );

/**
 * Simple keyword-matched assistant reply.
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response
 */
function pulselyft_chat_reply( $request ) {
	$msg   = strtolower( (string) $request->get_param( 'message' ) );
	$email = pulselyft_get( 'brand.email', 'pulselyft_brand_email' );

	$rules = array(
		array( array( 'price', 'cost', 'budget', 'retainer', 'how much' ), 'Engagements start with a two-week discovery sprint, then a scoped monthly program with explicit milestones—no mystery retainers. Book a call and we will size it to your goals and ad budget.' ),
		array( array( 'meta', 'facebook', 'instagram', 'paid social', 'ads' ), 'On Meta we run structured creative testing, clean account structure, and CAPI-led measurement so scaling spend does not scale waste. Median client ROAS in our portfolio is around 3.1×.' ),
		array( array( 'seo', 'search', 'organic', 'content', 'keyword' ), 'Our SEO work pairs technical foundations with intent-led content clusters and internal linking that compound over quarters—built around revenue keywords, not vanity traffic.' ),
		array( array( 'process', 'how do you work', 'engagement', 'onboard' ), 'Three phases: (1) Diagnose & benchmark, (2) Ship the growth system, (3) Compound weekly. Senior operators, async-first rituals, and reporting your execs actually open.' ),
		array( array( 'analytics', 'attribution', 'tracking', 'data' ), 'We standardize event schemas across Meta CAPI, GA4, and your CRM, then build one weekly dashboard leadership trusts—spend, MER/ROAS, CAC, payback, and pipeline influenced.' ),
		array( array( 'contact', 'email', 'reach', 'talk', 'call', 'book' ), sprintf( 'Easiest path: book a 30-minute intro using the “Book a call” section, or email %s. We reply within one business day.', $email ) ),
	);

	$reply = sprintf( 'Thanks for reaching out! Ask me about Meta ads, SEO, pricing, our process, or measurement—or book a call and email %s for anything specific.', $email );

	foreach ( $rules as $rule ) {
		foreach ( $rule[0] as $needle ) {
			if ( false !== strpos( $msg, $needle ) ) {
				$reply = $rule[1];
				break 2;
			}
		}
	}

	return new WP_REST_Response( array( 'reply' => $reply ), 200 );
}

/**
 * Estimated read time for a post (used in blog cards / single).
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function pulselyft_read_time( $post = null ) {
	$post  = get_post( $post );
	$words = $post ? str_word_count( wp_strip_all_tags( $post->post_content ) ) : 0;
	$mins  = max( 1, (int) ceil( $words / 200 ) );
	/* translators: %d: number of minutes. */
	return sprintf( _n( '%d min read', '%d min read', $mins, 'pulselyft' ), $mins );
}

/**
 * Pull recent published posts for the homepage Blog section, falling back to
 * the default editorial set (mirrors the web app) when none exist yet.
 *
 * @param int $count Number of posts.
 * @return array List of normalized post arrays.
 */
function pulselyft_recent_posts( $count = 3 ) {
	$query = new WP_Query( array(
		'post_type'           => 'post',
		'posts_per_page'      => $count,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );

	$out = array();
	if ( $query->have_posts() ) {
		foreach ( $query->posts as $p ) {
			$cats = get_the_category( $p->ID );
			$out[] = array(
				'title'    => get_the_title( $p ),
				'excerpt'  => wp_trim_words( has_excerpt( $p ) ? get_the_excerpt( $p ) : wp_strip_all_tags( $p->post_content ), 26 ),
				'category' => ! empty( $cats ) ? $cats[0]->name : __( 'Insights', 'pulselyft' ),
				'readTime' => pulselyft_read_time( $p ),
				'img'      => get_the_post_thumbnail_url( $p, 'large' ),
				'href'     => get_permalink( $p ),
				'fallback' => false,
			);
		}
		wp_reset_postdata();
		return $out;
	}

	// Fallback: ship with the same articles as the web app.
	foreach ( array_slice( pulselyft_default_posts(), 0, $count ) as $p ) {
		$out[] = array(
			'title'    => $p['title'],
			'excerpt'  => $p['excerpt'],
			'category' => $p['category'],
			'readTime' => $p['readTime'],
			'img'      => $p['img'],
			'href'     => '#contact',
			'fallback' => true,
		);
	}
	return $out;
}

/**
 * Build a Calendly embed URL.
 *
 * @param string $raw Base URL.
 * @return string
 */
function pulselyft_calendly_embed( $raw ) {
	$base = trim( $raw );
	if ( '' === $base ) {
		return 'https://calendly.com/thepulselyft/30min?embed_domain=' . wp_parse_url( home_url(), PHP_URL_HOST ) . '&embed_type=Inline';
	}
	if ( false !== strpos( $base, 'embed' ) ) {
		return $base;
	}
	$glue = ( false !== strpos( $base, '?' ) ) ? '&' : '?';
	return $base . $glue . 'embed_domain=' . wp_parse_url( home_url(), PHP_URL_HOST ) . '&embed_type=Inline';
}

/**
 * Handle the native contact form (admin-post).
 * Sends an email to the configured brand address via wp_mail().
 */
function pulselyft_handle_contact() {
	$referer  = wp_get_referer();
	$redirect = $referer ? $referer : home_url( '/' );

	// Nonce + honeypot validation.
	if (
		! isset( $_POST['pulselyft_contact_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pulselyft_contact_nonce'] ) ), 'pulselyft_contact' )
		|| ! empty( $_POST['pl_website'] )
	) {
		wp_safe_redirect( add_query_arg( 'pl_contact', 'error', $redirect ) . '#contact' );
		exit;
	}

	$name    = isset( $_POST['pl_name'] ) ? sanitize_text_field( wp_unslash( $_POST['pl_name'] ) ) : '';
	$email   = isset( $_POST['pl_email'] ) ? sanitize_email( wp_unslash( $_POST['pl_email'] ) ) : '';
	$company = isset( $_POST['pl_company'] ) ? sanitize_text_field( wp_unslash( $_POST['pl_company'] ) ) : '';
	$topic   = isset( $_POST['pl_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['pl_topic'] ) ) : '';
	$message = isset( $_POST['pl_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pl_message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		wp_safe_redirect( add_query_arg( 'pl_contact', 'error', $redirect ) . '#contact' );
		exit;
	}

	$to      = pulselyft_get( 'brand.email', 'pulselyft_brand_email' );
	$to      = is_email( $to ) ? $to : get_option( 'admin_email' );
	$subject = sprintf( /* translators: %s: sender name. */ __( 'New enquiry from %s', 'pulselyft' ), $name );
	$body    = sprintf(
		"Name: %s\nEmail: %s\nCompany: %s\nTopic: %s\n\nMessage:\n%s\n",
		$name,
		$email,
		$company,
		$topic,
		$message
	);
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'pl_contact', $sent ? 'sent' : 'error', $redirect ) . '#contact' );
	exit;
}
add_action( 'admin_post_nopriv_pulselyft_contact', 'pulselyft_handle_contact' );
add_action( 'admin_post_pulselyft_contact', 'pulselyft_handle_contact' );

/**
 * [pulselyft_contact_form] — renders the native contact form so it can be
 * placed in any block-built page or post.
 *
 * @return string
 */
function pulselyft_contact_form_shortcode() {
	ob_start();
	get_template_part( 'template-parts/contact-form' );
	return ob_get_clean();
}
add_shortcode( 'pulselyft_contact_form', 'pulselyft_contact_form_shortcode' );

/**
 * Excerpt tweaks.
 */
function pulselyft_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'pulselyft_excerpt_more' );

/**
 * Add body classes for styling hooks.
 *
 * @param array $classes Body classes.
 * @return array
 */
function pulselyft_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'pl-front';
	}
	return $classes;
}
add_filter( 'body_class', 'pulselyft_body_classes' );
