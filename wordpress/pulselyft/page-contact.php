<?php
/**
 * Template for the Contact page (slug "contact").
 *
 * Editable in wp-admin: Title → hero heading, Excerpt → hero sub, Content →
 * intro copy. The contact + booking blocks are reused from the homepage.
 *
 * @package PulseLyft
 */

get_header();

$c = pulselyft_get( 'pages.contact' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$sub = has_excerpt() ? get_the_excerpt() : $c['sub'];
		pulselyft_page_hero( $c['kicker'], get_the_title(), $sub );
		pulselyft_editable_intro();
	endwhile;
endif;

pulselyft_section( 'contact' );
pulselyft_section( 'book-call' );

get_footer();
