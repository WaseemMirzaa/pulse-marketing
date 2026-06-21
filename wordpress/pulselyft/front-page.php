<?php
/**
 * Front page.
 *
 * Two modes (Appearance → Customize → Homepage):
 *  - "sections" (default): the designed, built-in landing layout.
 *  - "content": renders the Home page you build in the block editor with the
 *    PulseLyft block patterns — so the homepage is fully editable too.
 *
 * Section order mirrors web/src/app/home-page.tsx.
 *
 * @package PulseLyft
 */

get_header();

$source   = get_theme_mod( 'pulselyft_home_source', 'sections' );
$front_id = (int) get_option( 'page_on_front' );
$has_blocks = $front_id && '' !== trim( (string) get_post_field( 'post_content', $front_id ) );

if ( 'content' === $source && $has_blocks ) :
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
