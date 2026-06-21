<?php
/**
 * Lightweight, self-contained SEO output for the PulseLyft theme.
 *
 * Plays nicely with dedicated SEO plugins: if Yoast / Rank Math / SEOPress is
 * active, the theme defers all meta/OG/schema output to the plugin to avoid
 * duplicate tags.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Detect a popular SEO plugin so we don't double up on meta tags.
 *
 * @return bool
 */
function pulselyft_has_seo_plugin() {
	return (
		defined( 'WPSEO_VERSION' )            // Yoast.
		|| class_exists( 'RankMath' )         // Rank Math.
		|| defined( 'SEOPRESS_VERSION' )      // SEOPress.
		|| function_exists( 'aioseo' )        // All in One SEO.
	);
}

/**
 * The page's SEO description.
 *
 * @return string
 */
function pulselyft_meta_description() {
	if ( is_front_page() ) {
		return wp_strip_all_tags( pulselyft_get( 'brand.metaDesc', 'pulselyft_brand_metadesc' ) );
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post && has_excerpt( $post ) ) {
			return wp_strip_all_tags( get_the_excerpt( $post ) );
		}
		if ( $post ) {
			return wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '…' );
		}
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$desc = term_description();
		if ( $desc ) {
			return wp_trim_words( wp_strip_all_tags( $desc ), 30, '…' );
		}
	}
	return wp_strip_all_tags( get_bloginfo( 'description' ) );
}

/**
 * Best available share image.
 *
 * @return string
 */
function pulselyft_share_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		if ( $src ) {
			return $src[0];
		}
	}
	if ( is_front_page() ) {
		return pulselyft_get( 'hero.heroImage', 'pulselyft_hero_image' );
	}
	$custom = get_theme_mod( 'pulselyft_hero_image', '' );
	return $custom ? $custom : pulselyft_get( 'hero.heroImage' );
}

/**
 * Output meta description, canonical, Open Graph, and Twitter Card tags.
 */
function pulselyft_head_meta() {
	if ( pulselyft_has_seo_plugin() ) {
		return;
	}

	$desc  = pulselyft_meta_description();
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
	$image = pulselyft_share_image();
	$type  = is_singular() && ! is_front_page() ? 'article' : 'website';

	echo "\n\t<!-- PulseLyft SEO -->\n";
	printf( "\t<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "\t<link rel=\"canonical\" href=\"%s\">\n", esc_url( $url ) );
	echo "\t<meta name=\"robots\" content=\"index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1\">\n";

	// Open Graph.
	printf( "\t<meta property=\"og:type\" content=\"%s\">\n", esc_attr( $type ) );
	printf( "\t<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
	printf( "\t<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "\t<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
	printf( "\t<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( "\t<meta property=\"og:locale\" content=\"%s\">\n", esc_attr( get_locale() ) );
	if ( $image ) {
		printf( "\t<meta property=\"og:image\" content=\"%s\">\n", esc_url( $image ) );
		echo "\t<meta property=\"og:image:alt\" content=\"" . esc_attr( $title ) . "\">\n";
	}

	// Twitter.
	echo "\t<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
	printf( "\t<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr( $title ) );
	printf( "\t<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr( $desc ) );
	if ( $image ) {
		printf( "\t<meta name=\"twitter:image\" content=\"%s\">\n", esc_url( $image ) );
	}
}
add_action( 'wp_head', 'pulselyft_head_meta', 1 );

/**
 * Output JSON-LD structured data (ProfessionalService + WebSite, or Article).
 */
function pulselyft_json_ld() {
	if ( pulselyft_has_seo_plugin() ) {
		return;
	}

	$brand = pulselyft_brand()['full'];
	$nodes = array();

	if ( is_front_page() ) {
		$services = pulselyft_get( 'services.items' );
		$catalog  = array();
		if ( is_array( $services ) ) {
			foreach ( $services as $s ) {
				$catalog[] = array(
					'@type'       => 'Offer',
					'itemOffered' => array(
						'@type'       => 'Service',
						'name'        => $s['title'],
						'description' => $s['body'],
					),
				);
			}
		}

		$nodes[] = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'ProfessionalService',
			'@id'         => home_url( '/#organization' ),
			'name'        => $brand,
			'description' => pulselyft_meta_description(),
			'url'         => home_url( '/' ),
			'email'       => pulselyft_get( 'brand.email', 'pulselyft_brand_email' ),
			'image'       => pulselyft_share_image(),
			'priceRange'  => '$$$',
			'areaServed'  => 'Worldwide',
			'serviceType' => array( 'Meta ads', 'Performance creative', 'SEO', 'Analytics & attribution' ),
			'sameAs'      => array_values( array_filter( array(
				get_theme_mod( 'pulselyft_social_linkedin', '' ),
				get_theme_mod( 'pulselyft_social_x', '' ),
				get_theme_mod( 'pulselyft_social_instagram', '' ),
			) ) ),
			'hasOfferCatalog' => array(
				'@type'           => 'OfferCatalog',
				'name'            => pulselyft_get( 'services.title' ),
				'itemListElement' => $catalog,
			),
		);

		$nodes[] = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => $brand,
			'publisher'       => array( '@id' => home_url( '/#organization' ) ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => array(
					'@type'       => 'EntryPoint',
					'urlTemplate' => home_url( '/?s={search_term_string}' ),
				),
				'query-input' => 'required name=search_term_string',
			),
		);

		// FAQPage rich-result schema.
		$faqs = pulselyft_get( 'faq.items' );
		if ( is_array( $faqs ) && $faqs ) {
			$entities = array();
			foreach ( $faqs as $faq ) {
				$entities[] = array(
					'@type'          => 'Question',
					'name'           => $faq['q'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => $faq['a'],
					),
				);
			}
			$nodes[] = array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $entities,
			);
		}
	} elseif ( is_singular( 'post' ) ) {
		$post = get_queried_object();
		$nodes[] = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'Article',
			'headline'         => get_the_title( $post ),
			'description'      => pulselyft_meta_description(),
			'datePublished'    => get_the_date( 'c', $post ),
			'dateModified'     => get_the_modified_date( 'c', $post ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', $post->post_author ),
			),
			'publisher'        => array(
				'@type' => 'Organization',
				'name'  => $brand,
			),
			'mainEntityOfPage' => get_permalink( $post ),
			'image'            => pulselyft_share_image(),
		);
	}

	if ( empty( $nodes ) ) {
		return;
	}

	$payload = ( 1 === count( $nodes ) ) ? $nodes[0] : $nodes;
	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}
add_action( 'wp_head', 'pulselyft_json_ld', 5 );
