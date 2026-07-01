<?php
/**
 * Front page — render the WPBakery page content full-width between the
 * PulseLyft header and footer. Deliberately skips Gecko's page-title banner,
 * container and sidebar so the homepage matches the PulseLyft design exactly.
 *
 * @package PulseLyft
 */

get_header();

while ( have_posts() ) :
	the_post();
	the_content();
endwhile;

get_footer();
