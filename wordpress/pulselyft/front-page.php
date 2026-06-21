<?php
/**
 * Front page.
 *
 * Renders the Home page's block content when it is substantial (so the homepage
 * sections are editable from the Pages editor) and ALWAYS falls back to the
 * designed sections otherwise — so the homepage can never render blank.
 *
 * Appearance → Customize → Homepage:
 *  - "auto" (default): page content if present, else the designed sections.
 *  - "content": always the Home page content (blocks).
 *  - "sections": always the designed sections.
 *
 * @package PulseLyft
 */

get_header();

$source      = get_theme_mod( 'pulselyft_home_source', 'auto' );
$front_id    = (int) get_option( 'page_on_front' );
$content     = $front_id ? (string) get_post_field( 'post_content', $front_id ) : '';
$substantial = strlen( trim( wp_strip_all_tags( $content ) ) ) > 400;
$use_content = ( 'content' === $source ) || ( 'auto' === $source && $substantial );

if ( $use_content && have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<div class="pl-page-wrap">
			<div class="entry-content"><?php the_content(); ?></div>
		</div>
		<?php
	endwhile;
else :
	pulselyft_section( 'hero' );
	pulselyft_section( 'logos' );
	pulselyft_section( 'services' );
	pulselyft_section( 'metrics' );
	pulselyft_section( 'case-studies' );
	pulselyft_section( 'portfolio' );
	pulselyft_section( 'process' );
	pulselyft_section( 'testimonials' );
	pulselyft_section( 'faq' );
	pulselyft_section( 'cta-band' );
	pulselyft_section( 'blog' );
	pulselyft_section( 'book-call' );
	pulselyft_section( 'contact' );
endif;

get_footer();
