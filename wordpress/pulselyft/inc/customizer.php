<?php
/**
 * PulseLyft Customizer options.
 *
 * Exposes the highest-impact landing-page content (brand, hero, CTAs,
 * booking, contact, chatbot) for editing in Appearance → Customize. Section
 * lists (services, metrics, work, etc.) ship with the same content as the web
 * app and can be edited via the `pulselyft_default_content` filter.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panels, sections, settings, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function pulselyft_customize_register( $wp_customize ) {
	$d = pulselyft_default_content();

	$wp_customize->add_panel( 'pulselyft_panel', array(
		'title'    => __( 'PulseLyft Landing Page', 'pulselyft' ),
		'priority' => 20,
	) );

	$add_text = function ( $id, $label, $default, $section, $type = 'text' ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'sanitize_callback' => ( 'url' === $type ) ? 'esc_url_raw' : 'wp_kses_post',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => $section,
			'type'    => ( 'textarea' === $type ) ? 'textarea' : ( ( 'url' === $type ) ? 'url' : 'text' ),
		) );
	};

	/* --------------------------------------------------------------- Homepage */
	$wp_customize->add_section( 'pulselyft_home', array(
		'title' => __( 'Homepage', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$wp_customize->add_setting( 'pulselyft_home_source', array(
		'default'           => 'sections',
		'sanitize_callback' => 'pulselyft_sanitize_home_source',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'pulselyft_home_source', array(
		'label'       => __( 'Homepage source', 'pulselyft' ),
		'description' => __( '“Designed sections” uses the built-in landing layout. “Page content (blocks)” renders the Home page you build in the block editor with the PulseLyft patterns.', 'pulselyft' ),
		'section'     => 'pulselyft_home',
		'type'        => 'radio',
		'choices'     => array(
			'sections' => __( 'Designed sections (default)', 'pulselyft' ),
			'content'  => __( 'Page content (blocks)', 'pulselyft' ),
		),
	) );

	/* ------------------------------------------------------------------ Brand */
	$wp_customize->add_section( 'pulselyft_brand', array(
		'title' => __( 'Brand & Identity', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$add_text( 'pulselyft_brand_prefix', __( 'Brand name (first part)', 'pulselyft' ), $d['brand']['namePrefix'], 'pulselyft_brand' );
	$add_text( 'pulselyft_brand_accent', __( 'Brand name (accent part)', 'pulselyft' ), $d['brand']['nameAccent'], 'pulselyft_brand' );
	$add_text( 'pulselyft_brand_tagline', __( 'Footer tagline', 'pulselyft' ), $d['brand']['tagline'], 'pulselyft_brand', 'textarea' );
	$add_text( 'pulselyft_brand_email', __( 'Contact email', 'pulselyft' ), $d['brand']['email'], 'pulselyft_brand' );
	$add_text( 'pulselyft_brand_metadesc', __( 'SEO meta description (home)', 'pulselyft' ), $d['brand']['metaDesc'], 'pulselyft_brand', 'textarea' );

	/* ------------------------------------------------------------------- Hero */
	$wp_customize->add_section( 'pulselyft_hero', array(
		'title' => __( 'Hero', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$add_text( 'pulselyft_hero_badge', __( 'Badge', 'pulselyft' ), $d['hero']['badge'], 'pulselyft_hero' );
	$add_text( 'pulselyft_hero_before', __( 'Headline — before italic', 'pulselyft' ), $d['hero']['headlineBefore'], 'pulselyft_hero' );
	$add_text( 'pulselyft_hero_italic', __( 'Headline — italic word', 'pulselyft' ), $d['hero']['headlineItalic'], 'pulselyft_hero' );
	$add_text( 'pulselyft_hero_after', __( 'Headline — after italic', 'pulselyft' ), $d['hero']['headlineAfter'], 'pulselyft_hero' );
	$add_text( 'pulselyft_hero_sub', __( 'Sub-headline', 'pulselyft' ), $d['hero']['sub'], 'pulselyft_hero', 'textarea' );
	$add_text( 'pulselyft_hero_primary', __( 'Primary CTA label', 'pulselyft' ), $d['hero']['primaryCta'], 'pulselyft_hero' );
	$add_text( 'pulselyft_hero_secondary', __( 'Secondary CTA label', 'pulselyft' ), $d['hero']['secondaryCta'], 'pulselyft_hero' );
	$add_text( 'pulselyft_hero_image', __( 'Hero image URL', 'pulselyft' ), $d['hero']['heroImage'], 'pulselyft_hero', 'url' );
	$add_text( 'pulselyft_hero_image_alt', __( 'Hero image alt text', 'pulselyft' ), $d['hero']['heroImageAlt'], 'pulselyft_hero' );

	/* -------------------------------------------------------------- CTA band */
	$wp_customize->add_section( 'pulselyft_cta', array(
		'title' => __( 'CTA Band', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$add_text( 'pulselyft_cta_title', __( 'Title', 'pulselyft' ), $d['cta']['title'], 'pulselyft_cta' );
	$add_text( 'pulselyft_cta_sub', __( 'Sub text', 'pulselyft' ), $d['cta']['sub'], 'pulselyft_cta', 'textarea' );
	$add_text( 'pulselyft_cta_button', __( 'Button label', 'pulselyft' ), $d['cta']['button'], 'pulselyft_cta' );

	/* ------------------------------------------------------------ Book a call */
	$wp_customize->add_section( 'pulselyft_book', array(
		'title' => __( 'Book a Call', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$add_text( 'pulselyft_book_title', __( 'Title', 'pulselyft' ), $d['bookCall']['title'], 'pulselyft_book' );
	$add_text( 'pulselyft_book_sub', __( 'Sub text', 'pulselyft' ), $d['bookCall']['sub'], 'pulselyft_book', 'textarea' );
	$add_text( 'pulselyft_book_calendly', __( 'Calendly URL', 'pulselyft' ), $d['bookCall']['calendlyUrl'], 'pulselyft_book', 'url' );

	/* --------------------------------------------------------------- Contact */
	$wp_customize->add_section( 'pulselyft_contact', array(
		'title' => __( 'Contact', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$add_text( 'pulselyft_contact_title', __( 'Title', 'pulselyft' ), $d['contact']['title'], 'pulselyft_contact' );
	$add_text( 'pulselyft_contact_sub', __( 'Sub text', 'pulselyft' ), $d['contact']['sub'], 'pulselyft_contact', 'textarea' );
	$add_text( 'pulselyft_contact_jotform', __( 'Jotform ID (optional — blank uses native form)', 'pulselyft' ), '', 'pulselyft_contact' );

	/* --------------------------------------------------------------- Chatbot */
	$wp_customize->add_section( 'pulselyft_chat', array(
		'title' => __( 'Chatbot', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$add_text( 'pulselyft_chat_api_url', __( 'External chat API base URL (optional)', 'pulselyft' ), '', 'pulselyft_chat', 'url' );

	/* --------------------------------------------------- Social (footer links) */
	$wp_customize->add_section( 'pulselyft_social', array(
		'title' => __( 'Social Links', 'pulselyft' ),
		'panel' => 'pulselyft_panel',
	) );
	$add_text( 'pulselyft_social_linkedin', __( 'LinkedIn URL', 'pulselyft' ), '', 'pulselyft_social', 'url' );
	$add_text( 'pulselyft_social_x', __( 'X / Twitter URL', 'pulselyft' ), '', 'pulselyft_social', 'url' );
	$add_text( 'pulselyft_social_instagram', __( 'Instagram URL', 'pulselyft' ), '', 'pulselyft_social', 'url' );

	// Enable live (no-reload) preview for clean, uniquely-targetable text fields.
	$live = array(
		'pulselyft_hero_sub',
		'pulselyft_cta_title',
		'pulselyft_cta_sub',
		'pulselyft_cta_button',
		'pulselyft_book_title',
		'pulselyft_contact_title',
	);
	foreach ( $live as $live_id ) {
		$setting = $wp_customize->get_setting( $live_id );
		if ( $setting ) {
			$setting->transport = 'postMessage';
		}
	}
}
add_action( 'customize_register', 'pulselyft_customize_register' );

/**
 * Sanitize the homepage source radio.
 *
 * @param string $value Raw value.
 * @return string
 */
function pulselyft_sanitize_home_source( $value ) {
	return in_array( $value, array( 'sections', 'content' ), true ) ? $value : 'sections';
}

/**
 * Live-preview JS for the title/description bindings.
 */
function pulselyft_customize_preview_js() {
	wp_enqueue_script(
		'pulselyft-customize-preview',
		get_template_directory_uri() . '/assets/js/customize-preview.js',
		array( 'customize-preview' ),
		PULSELYFT_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'pulselyft_customize_preview_js' );
