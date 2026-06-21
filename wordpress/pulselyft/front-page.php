<?php
/**
 * Front page — the PulseLyft landing page.
 *
 * Section order mirrors web/src/app/home-page.tsx:
 * Hero → Logos → Services → Metrics → Case Studies → Portfolio → Process →
 * Testimonials → CTA Band → Blog → Book a Call → Contact.
 *
 * @package PulseLyft
 */

get_header();

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

get_footer();
