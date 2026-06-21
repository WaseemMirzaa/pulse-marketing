<?php
/**
 * One-time site provisioning + navigation helpers for the PulseLyft theme.
 *
 * On theme activation this creates the standard marketing pages (About,
 * Services, Pricing, Contact, Privacy, Terms) and a Home/Blog structure, then
 * wires up the primary and footer menus — so the site is a complete, multi-page
 * website out of the box. Everything is idempotent and runs once.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve a published page ID by slug (cached in an option map).
 *
 * @param string $slug Page slug.
 * @return int Page ID, or 0 if not found.
 */
function pulselyft_get_page_id( $slug ) {
	$map = get_option( 'pulselyft_pages', array() );
	if ( is_array( $map ) && ! empty( $map[ $slug ] ) && get_post_status( $map[ $slug ] ) === 'publish' ) {
		return (int) $map[ $slug ];
	}
	$page = get_page_by_path( $slug );
	return $page ? (int) $page->ID : 0;
}

/**
 * Permalink for a provisioned page, or '' if it does not exist.
 *
 * @param string $slug Page slug.
 * @return string
 */
function pulselyft_page_url( $slug ) {
	$id = pulselyft_get_page_id( $slug );
	return $id ? get_permalink( $id ) : '';
}

/**
 * Resolve a section anchor to a URL that also works from sub-pages.
 *
 * @param string $anchor Anchor id (without #).
 * @return string
 */
function pulselyft_anchor_url( $anchor ) {
	return is_front_page() ? '#' . $anchor : home_url( '/#' . $anchor );
}

/**
 * Primary navigation items used by the header fallback (when no WP menu is
 * assigned). Pages fall back to a section anchor if they have not been created.
 *
 * @return array List of [ 'label' => string, 'url' => string ].
 */
function pulselyft_primary_nav() {
	$nav = array();

	$services = pulselyft_page_url( 'services' );
	$nav[] = array( 'label' => __( 'Services', 'pulselyft' ), 'url' => $services ? $services : pulselyft_anchor_url( 'services' ) );

	$pricing = pulselyft_page_url( 'pricing' );
	if ( $pricing ) {
		$nav[] = array( 'label' => __( 'Pricing', 'pulselyft' ), 'url' => $pricing );
	}

	$nav[] = array( 'label' => __( 'Work', 'pulselyft' ), 'url' => pulselyft_anchor_url( 'work' ) );

	$about = pulselyft_page_url( 'about' );
	if ( $about ) {
		$nav[] = array( 'label' => __( 'About', 'pulselyft' ), 'url' => $about );
	}

	$posts_page = get_option( 'page_for_posts' );
	$blog = $posts_page ? get_permalink( $posts_page ) : pulselyft_page_url( 'blog' );
	$nav[] = array( 'label' => __( 'Blog', 'pulselyft' ), 'url' => $blog ? $blog : pulselyft_anchor_url( 'blog' ) );

	$contact = pulselyft_page_url( 'contact' );
	$nav[] = array( 'label' => __( 'Contact', 'pulselyft' ), 'url' => $contact ? $contact : pulselyft_anchor_url( 'contact' ) );

	return $nav;
}

/**
 * Footer "Company" column links.
 *
 * @return array
 */
function pulselyft_footer_nav() {
	$out = array();
	foreach ( array(
		'about'          => __( 'About', 'pulselyft' ),
		'services'       => __( 'Services', 'pulselyft' ),
		'pricing'        => __( 'Pricing', 'pulselyft' ),
		'contact'        => __( 'Contact', 'pulselyft' ),
		'privacy-policy' => __( 'Privacy', 'pulselyft' ),
		'terms'          => __( 'Terms', 'pulselyft' ),
	) as $slug => $label ) {
		$url = pulselyft_page_url( $slug );
		if ( $url ) {
			$out[] = array( 'label' => $label, 'url' => $url );
		}
	}
	return $out;
}

/**
 * Render a sub-page hero band (kicker + title + optional sub).
 *
 * @param string $kicker Eyebrow text.
 * @param string $title  Page title.
 * @param string $sub    Optional sub-headline.
 */
function pulselyft_page_hero( $kicker, $title, $sub = '' ) {
	?>
	<section class="pl-pagehead" aria-label="<?php echo esc_attr( $title ); ?>">
		<div class="pl-pagehead__bg" aria-hidden="true"></div>
		<div class="pl-container pl-pagehead__inner pl-reveal">
			<?php if ( $kicker ) : ?>
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
			<?php endif; ?>
			<h1 class="pl-pagehead__title pl-balance"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $sub ) : ?>
				<p class="pl-pagehead__sub"><?php echo esc_html( $sub ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Build legal page HTML from the content tree.
 *
 * @param string $which 'privacy' or 'terms'.
 * @return string
 */
function pulselyft_legal_content( $which ) {
	$data = pulselyft_get( 'legal.' . $which );
	if ( ! is_array( $data ) ) {
		return '';
	}
	$html = '';
	if ( ! empty( $data['intro'] ) ) {
		$html .= '<p><em>' . $data['intro'] . '</em></p>' . "\n";
	}
	if ( ! empty( $data['sections'] ) && is_array( $data['sections'] ) ) {
		foreach ( $data['sections'] as $sec ) {
			$html .= '<h2>' . $sec['h'] . '</h2>' . "\n<p>" . $sec['p'] . "</p>\n";
		}
	}
	$html .= '<p><small>Last updated: ' . gmdate( 'F Y' ) . '. This is starter copy—please review with legal counsel.</small></p>';
	return $html;
}

/**
 * Render the editable page body (the_content) inside a styled prose section,
 * if the current page has any content. Lets editors change copy from wp-admin.
 */
function pulselyft_editable_intro() {
	if ( trim( get_the_content() ) === '' ) {
		return;
	}
	echo '<section class="pl-section pl-section--paper" style="padding-block:4rem;"><div class="pl-container"><div class="pl-prose entry-content pl-reveal" style="max-width:48rem;margin-top:0;">';
	the_content();
	echo '</div></div></section>';
}

/**
 * Build the seed content (Gutenberg blocks) + excerpt for a templated page,
 * sourced from the content tree so the editor starts with real, editable copy.
 *
 * @param string $slug Page slug.
 * @return array{content:string,excerpt:string}
 */
function pulselyft_page_seed( $slug ) {
	$map = array(
		'about'    => array( 'pages.about.story', 'pages.about.sub' ),
		'services' => array( 'pages.services.body', 'pages.services.sub' ),
		'pricing'  => array( 'pages.pricing.body', 'pages.pricing.sub' ),
		'contact'  => array( 'pages.contact.body', 'pages.contact.sub' ),
	);
	if ( ! isset( $map[ $slug ] ) ) {
		return array( 'content' => '', 'excerpt' => '' );
	}
	$paras   = pulselyft_get( $map[ $slug ][0] );
	$excerpt = (string) pulselyft_get( $map[ $slug ][1] );
	$content = '';
	if ( is_array( $paras ) ) {
		foreach ( $paras as $p ) {
			$content .= "<!-- wp:paragraph -->\n<p>" . $p . "</p>\n<!-- /wp:paragraph -->\n\n";
		}
	}
	return array( 'content' => trim( $content ), 'excerpt' => $excerpt );
}

/**
 * Create a page if one with the slug does not already exist.
 *
 * @param string $slug    Slug.
 * @param string $title   Title.
 * @param string $content Optional content HTML.
 * @param string $excerpt Optional excerpt.
 * @return int Page ID.
 */
function pulselyft_ensure_page( $slug, $title, $content = '', $excerpt = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return (int) $existing->ID;
	}
	$id = wp_insert_post( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'post_title'     => $title,
		'post_name'      => $slug,
		'post_content'   => $content,
		'post_excerpt'   => $excerpt,
		'comment_status' => 'closed',
	) );
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Provision the full site on theme activation (runs once, idempotent).
 */
function pulselyft_provision_site() {
	if ( get_option( 'pulselyft_setup_done' ) ) {
		return;
	}

	$pages = array(
		'about'          => __( 'About', 'pulselyft' ),
		'services'       => __( 'Services', 'pulselyft' ),
		'pricing'        => __( 'Pricing', 'pulselyft' ),
		'contact'        => __( 'Contact', 'pulselyft' ),
		'privacy-policy' => __( 'Privacy Policy', 'pulselyft' ),
		'terms'          => __( 'Terms of Service', 'pulselyft' ),
		'home'           => __( 'Home', 'pulselyft' ),
		'blog'           => __( 'Blog', 'pulselyft' ),
	);

	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$content = '';
		$excerpt = '';
		if ( 'privacy-policy' === $slug ) {
			$content = pulselyft_legal_content( 'privacy' );
		} elseif ( 'terms' === $slug ) {
			$content = pulselyft_legal_content( 'terms' );
		} elseif ( 'home' === $slug ) {
			$content = "<!-- wp:paragraph -->\n<p>This is your homepage. Its sections (hero, services, pricing teaser, testimonials, FAQ, and more) are managed in <strong>Appearance &rarr; Customize &rarr; PulseLyft Landing Page</strong>.</p>\n<!-- /wp:paragraph -->";
		} elseif ( in_array( $slug, array( 'about', 'services', 'pricing', 'contact' ), true ) ) {
			$seed    = pulselyft_page_seed( $slug );
			$content = $seed['content'];
			$excerpt = $seed['excerpt'];
		}
		$ids[ $slug ] = pulselyft_ensure_page( $slug, $title, $content, $excerpt );
	}
	update_option( 'pulselyft_pages', $ids );

	// Configure a static front page + posts page only on a still-default site.
	if ( 'posts' === get_option( 'show_on_front' ) && $ids['home'] && $ids['blog'] ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
		update_option( 'page_for_posts', $ids['blog'] );
	}

	pulselyft_build_menus( $ids );

	update_option( 'pulselyft_setup_done', PULSELYFT_VERSION );
}
add_action( 'after_switch_theme', 'pulselyft_provision_site' );
// Safety net: also provision on first admin load (covers in-place theme
// updates where the activation hook does not fire). Self-guards, so it
// only ever runs once.
add_action( 'admin_init', 'pulselyft_provision_site' );

/**
 * Create and assign primary + footer menus if those locations are empty.
 *
 * @param array $ids Map of slug => page ID.
 */
function pulselyft_build_menus( $ids ) {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}

	$add_item = function ( $menu_id, $title, $url ) {
		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'   => $title,
			'menu-item-url'     => $url,
			'menu-item-status'  => 'publish',
			'menu-item-type'    => 'custom',
		) );
	};

	// Primary.
	if ( empty( $locations['primary'] ) ) {
		$menu_name = __( 'Primary', 'pulselyft' );
		$menu = wp_get_nav_menu_object( $menu_name );
		$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
		if ( ! is_wp_error( $menu_id ) ) {
			$add_item( $menu_id, __( 'Services', 'pulselyft' ), get_permalink( $ids['services'] ) );
			$add_item( $menu_id, __( 'Pricing', 'pulselyft' ), get_permalink( $ids['pricing'] ) );
			$add_item( $menu_id, __( 'Work', 'pulselyft' ), home_url( '/#work' ) );
			$add_item( $menu_id, __( 'About', 'pulselyft' ), get_permalink( $ids['about'] ) );
			$add_item( $menu_id, __( 'Blog', 'pulselyft' ), get_permalink( $ids['blog'] ) );
			$add_item( $menu_id, __( 'Contact', 'pulselyft' ), get_permalink( $ids['contact'] ) );
			$locations['primary'] = $menu_id;
		}
	}

	// Footer.
	if ( empty( $locations['footer'] ) ) {
		$menu_name = __( 'Footer', 'pulselyft' );
		$menu = wp_get_nav_menu_object( $menu_name );
		$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
		if ( ! is_wp_error( $menu_id ) ) {
			$add_item( $menu_id, __( 'About', 'pulselyft' ), get_permalink( $ids['about'] ) );
			$add_item( $menu_id, __( 'Services', 'pulselyft' ), get_permalink( $ids['services'] ) );
			$add_item( $menu_id, __( 'Pricing', 'pulselyft' ), get_permalink( $ids['pricing'] ) );
			$add_item( $menu_id, __( 'Contact', 'pulselyft' ), get_permalink( $ids['contact'] ) );
			$add_item( $menu_id, __( 'Privacy', 'pulselyft' ), get_permalink( $ids['privacy-policy'] ) );
			$add_item( $menu_id, __( 'Terms', 'pulselyft' ), get_permalink( $ids['terms'] ) );
			$locations['footer'] = $menu_id;
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}
