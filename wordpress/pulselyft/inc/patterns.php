<?php
/**
 * Block patterns — let editors build/edit pages in the WordPress block editor
 * with on-brand, fully-editable sections (text, images, buttons, colours).
 *
 * Patterns reuse the theme's component classes so they render on-brand, and use
 * only core blocks so every word, link, and image is editable in Gutenberg.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the pattern category + patterns.
 */
function pulselyft_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category( 'pulselyft', array( 'label' => __( 'PulseLyft', 'pulselyft' ) ) );
	}

	$patterns = array(

		/* ----------------------------------------------------------- Hero */
		'hero' => array(
			'title'   => __( 'PulseLyft: Hero', 'pulselyft' ),
			'content' => '
<!-- wp:group {"className":"pl-section pl-section--page","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--page">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">Performance marketing studio</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"className":"pl-hero__title"} --><h1 class="wp-block-heading pl-hero__title">Revenue systems for brands that <em class="pl-grad">refuse</em> to guess.</h1><!-- /wp:heading -->
<!-- wp:paragraph {"className":"pl-hero__sub"} --><p class="pl-hero__sub">Meta ads, performance creative, and SEO engineered around pipeline and profit—not slides that age in a week.</p><!-- /wp:paragraph -->
<!-- wp:buttons {"className":"pl-hero__cta"} -->
<div class="wp-block-buttons pl-hero__cta">
<!-- wp:button {"className":"pl-btn-grad"} --><div class="wp-block-button pl-btn-grad"><a class="wp-block-button__link wp-element-button" href="#book-call">Start a project</a></div><!-- /wp:button -->
<!-- wp:button {"className":"pl-btn-outline"} --><div class="wp-block-button pl-btn-outline"><a class="wp-block-button__link wp-element-button" href="#work">View outcomes</a></div><!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		),

		/* ------------------------------------------------------- Stat band */
		'stats' => array(
			'title'   => __( 'PulseLyft: Stat band (dark)', 'pulselyft' ),
			'content' => '
<!-- wp:group {"className":"pl-metrics","layout":{"type":"default"}} -->
<div class="wp-block-group pl-metrics">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"className":"pl-metric__value"} --><h3 class="wp-block-heading pl-metric__value">$48M+</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-metric__label"} --><p class="pl-metric__label">Ad spend managed</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"className":"pl-metric__value"} --><h3 class="wp-block-heading pl-metric__value">142%</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-metric__label"} --><p class="pl-metric__label">Median organic lift</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"className":"pl-metric__value"} --><h3 class="wp-block-heading pl-metric__value">4.2 wk</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-metric__label"} --><p class="pl-metric__label">Time to first scale test</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"className":"pl-metric__value"} --><h3 class="wp-block-heading pl-metric__value">97%</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-metric__label"} --><p class="pl-metric__label">Client retention</p><!-- /wp:paragraph --></div><!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		),

		/* ---------------------------------------------------- Capabilities */
		'capabilities' => array(
			'title'   => __( 'PulseLyft: Capabilities (3 columns)', 'pulselyft' ),
			'content' => '
<!-- wp:group {"className":"pl-section pl-section--paper","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--paper">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">Capabilities</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"pl-h2"} --><h2 class="wp-block-heading pl-h2">Full-funnel performance, one system</h2><!-- /wp:heading -->
<!-- wp:columns {"className":"pl-pat-cards"} -->
<div class="wp-block-columns pl-pat-cards">
<!-- wp:column {"className":"pl-pat-card"} --><div class="wp-block-column pl-pat-card"><!-- wp:heading {"level":3,"className":"pl-pat-card__title"} --><h3 class="wp-block-heading pl-pat-card__title">Meta ads &amp; paid social</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Creative testing, account structure, and CAPI-led measurement so scaling spend does not scale waste.</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column {"className":"pl-pat-card"} --><div class="wp-block-column pl-pat-card"><!-- wp:heading {"level":3,"className":"pl-pat-card__title"} --><h3 class="wp-block-heading pl-pat-card__title">SEO &amp; content</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Technical foundations, intent-led clusters, and internal linking that compound traffic over quarters.</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column {"className":"pl-pat-card"} --><div class="wp-block-column pl-pat-card"><!-- wp:heading {"level":3,"className":"pl-pat-card__title"} --><h3 class="wp-block-heading pl-pat-card__title">Analytics &amp; attribution</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Clean event schemas, server-side tagging, and dashboards leadership actually uses in weekly reviews.</p><!-- /wp:paragraph --></div><!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		),

		/* --------------------------------------------------------- Pricing */
		'pricing' => array(
			'title'   => __( 'PulseLyft: Pricing (3 tiers)', 'pulselyft' ),
			'content' => '
<!-- wp:group {"className":"pl-section pl-section--page","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--page">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">Pricing</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"pl-h2"} --><h2 class="wp-block-heading pl-h2">Plans that scale with your ambition</h2><!-- /wp:heading -->
<!-- wp:columns {"className":"pl-pat-cards"} -->
<div class="wp-block-columns pl-pat-cards">
<!-- wp:column {"className":"pl-pat-card"} --><div class="wp-block-column pl-pat-card"><!-- wp:heading {"level":3,"className":"pl-pat-card__title"} --><h3 class="wp-block-heading pl-pat-card__title">Launch</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-pat-price"} --><p class="pl-pat-price">$3.5k<span>/mo</span></p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>One paid channel</li><li>4 creative concepts / mo</li><li>Conversion tracking</li><li>Bi-weekly reporting</li></ul><!-- /wp:list --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"pl-btn-outline"} --><div class="wp-block-button pl-btn-outline"><a class="wp-block-button__link wp-element-button" href="#contact">Start with Launch</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column -->
<!-- wp:column {"className":"pl-pat-card pl-pat-card--featured"} --><div class="wp-block-column pl-pat-card pl-pat-card--featured"><!-- wp:heading {"level":3,"className":"pl-pat-card__title"} --><h3 class="wp-block-heading pl-pat-card__title">Scale</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-pat-price"} --><p class="pl-pat-price">$7.5k<span>/mo</span></p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Paid social + SEO</li><li>10 creative concepts / mo</li><li>Server-side tracking &amp; CAPI</li><li>Weekly dashboard</li><li>Landing page CRO</li></ul><!-- /wp:list --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"pl-btn-grad"} --><div class="wp-block-button pl-btn-grad"><a class="wp-block-button__link wp-element-button" href="#contact">Choose Scale</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column -->
<!-- wp:column {"className":"pl-pat-card"} --><div class="wp-block-column pl-pat-card"><!-- wp:heading {"level":3,"className":"pl-pat-card__title"} --><h3 class="wp-block-heading pl-pat-card__title">Partner</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-pat-price"} --><p class="pl-pat-price">Custom</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Everything in Scale</li><li>Multi-channel media</li><li>Dedicated creative pod</li><li>Quarterly offsites</li></ul><!-- /wp:list --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"pl-btn-outline"} --><div class="wp-block-button pl-btn-outline"><a class="wp-block-button__link wp-element-button" href="#contact">Talk to us</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		),

		/* ----------------------------------------------------- Testimonial */
		'testimonial' => array(
			'title'   => __( 'PulseLyft: Testimonial (dark quote)', 'pulselyft' ),
			'content' => '
<!-- wp:group {"className":"pl-section pl-section--page","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--page">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:group {"className":"pl-quote pl-quote--lg","layout":{"type":"default"}} -->
<div class="wp-block-group pl-quote pl-quote--lg">
<!-- wp:paragraph {"className":"pl-quote__lg-text"} --><p class="pl-quote__lg-text">They replaced three vendors. Our Meta account finally talks to our CRM—and finance trusts the numbers.</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-quote__cite"} --><p class="pl-quote__cite"><strong class="pl-quote__name">Jordan M.</strong> <span class="pl-quote__role">— VP Growth, Series B SaaS</span></p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		),

		/* ------------------------------------------------------------- FAQ */
		'faq' => array(
			'title'   => __( 'PulseLyft: FAQ (accordion)', 'pulselyft' ),
			'content' => '
<!-- wp:group {"className":"pl-section pl-section--paper","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--paper">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">FAQ</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"pl-h2"} --><h2 class="wp-block-heading pl-h2">Answers before you book</h2><!-- /wp:heading -->
<!-- wp:details {"className":"pl-faq__item"} --><details class="wp-block-details pl-faq__item"><summary>How quickly can we launch?</summary><!-- wp:paragraph --><p>Most programs go live within two to four weeks: a discovery sprint, then the first structured tests and tracking ship together.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
<!-- wp:details {"className":"pl-faq__item"} --><details class="wp-block-details pl-faq__item"><summary>What does an engagement cost?</summary><!-- wp:paragraph --><p>Every engagement opens with a fixed-scope, two-week discovery sprint, then a monthly program with explicit milestones.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
<!-- wp:details {"className":"pl-faq__item"} --><details class="wp-block-details pl-faq__item"><summary>Do we keep ownership of our accounts?</summary><!-- wp:paragraph --><p>Always. Ad accounts, analytics, pixels, and content remain yours.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		),

		/* ------------------------------------------------------------- CTA */
		'cta' => array(
			'title'   => __( 'PulseLyft: CTA band (gradient)', 'pulselyft' ),
			'content' => '
<!-- wp:group {"className":"pl-cta","layout":{"type":"default"}} -->
<div class="wp-block-group pl-cta">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:group {"className":"pl-cta__panel","layout":{"type":"default"}} -->
<div class="wp-block-group pl-cta__panel">
<!-- wp:heading {"textAlign":"center","className":"pl-cta__title"} --><h2 class="wp-block-heading has-text-align-center pl-cta__title">Growth you can defend in a board meeting</h2><!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","className":"pl-cta__sub"} --><p class="has-text-align-center pl-cta__sub">Two-week discovery sprints, explicit milestones, and no mystery retainers.</p><!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons"><!-- wp:button {"className":"pl-btn-light"} --><div class="wp-block-button pl-btn-light"><a class="wp-block-button__link wp-element-button" href="#book-call">Book a strategy call</a></div><!-- /wp:button --></div><!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		),
	);

	foreach ( $patterns as $slug => $pattern ) {
		register_block_pattern( 'pulselyft/' . $slug, array(
			'title'      => $pattern['title'],
			'categories' => array( 'pulselyft' ),
			'content'    => $pattern['content'],
		) );
	}
}
add_action( 'init', 'pulselyft_register_patterns' );
