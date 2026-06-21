<?php
/**
 * Block patterns — let editors build/edit every page and section in the
 * WordPress block editor with on-brand, fully-editable content.
 *
 * Each homepage section is available as a pattern (Inserter → Patterns →
 * "PulseLyft"), plus a "Full homepage" composite. Patterns use core blocks +
 * the theme's classes, so text, links, images, and colours are all editable.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The block pattern map (slug => [title, content]). Reused by registration and
 * by homepage/page seeding.
 *
 * @return array
 */
function pulselyft_patterns() {
	$hero = '
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
<!-- wp:group {"className":"pl-hero__stats","layout":{"type":"default"}} -->
<div class="wp-block-group pl-hero__stats">
<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:heading {"level":3,"className":"pl-stat__value"} --><h3 class="wp-block-heading pl-stat__value">3.1×</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-stat__label"} --><p class="pl-stat__label">ROAS</p><!-- /wp:paragraph --></div><!-- /wp:group -->
<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:heading {"level":3,"className":"pl-stat__value"} --><h3 class="wp-block-heading pl-stat__value">97%</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-stat__label"} --><p class="pl-stat__label">Retention</p><!-- /wp:paragraph --></div><!-- /wp:group -->
<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:heading {"level":3,"className":"pl-stat__value"} --><h3 class="wp-block-heading pl-stat__value">$48M</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-stat__label"} --><p class="pl-stat__label">Managed</p><!-- /wp:paragraph --></div><!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->';

	$logos = '
<!-- wp:group {"className":"pl-logos","layout":{"type":"default"}} -->
<div class="wp-block-group pl-logos">
<!-- wp:html --><div class="pl-logos__fade pl-logos__fade--l" aria-hidden="true"></div><div class="pl-logos__fade pl-logos__fade--r" aria-hidden="true"></div><!-- /wp:html -->
<!-- wp:paragraph {"align":"center","className":"pl-logos__line"} --><p class="has-text-align-center pl-logos__line">Trusted by teams shipping at scale</p><!-- /wp:paragraph -->
<!-- wp:group {"className":"pl-logos__viewport","layout":{"type":"default"}} -->
<div class="wp-block-group pl-logos__viewport">
<!-- wp:group {"className":"pl-logos__track","layout":{"type":"default"}} -->
<div class="wp-block-group pl-logos__track">
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Nimbus</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Vertex</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Lumen</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Northline</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Helio</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Signal</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Aperture</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"pl-logos__item"} --><p class="pl-logos__item">Craft</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->';

	// One interactive capability row (numbered, hover-revealed thumb + arrow).
	$cap_row = function ( $no, $title, $desc, $img ) {
		return '
<!-- wp:group {"className":"pl-cap","layout":{"type":"default"}} -->
<div class="wp-block-group pl-cap">
<!-- wp:paragraph {"className":"pl-cap__no"} --><p class="pl-cap__no">' . $no . '</p><!-- /wp:paragraph -->
<!-- wp:group {"className":"pl-cap__main","layout":{"type":"default"}} -->
<div class="wp-block-group pl-cap__main">
<!-- wp:heading {"level":3,"className":"pl-cap__title"} --><h3 class="wp-block-heading pl-cap__title">' . $title . '</h3><!-- /wp:heading -->
<!-- wp:paragraph {"className":"pl-cap__desc"} --><p class="pl-cap__desc">' . $desc . '</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:image {"className":"pl-cap__thumb","sizeSlug":"large"} --><figure class="wp-block-image pl-cap__thumb"><img src="' . $img . '" alt=""/></figure><!-- /wp:image -->
<!-- wp:html --><span class="pl-cap__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round"/></svg></span><!-- /wp:html -->
</div>
<!-- /wp:group -->';
	};

	$caps = '
<!-- wp:group {"className":"pl-section pl-section--paper","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--paper">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:group {"className":"pl-sec-head","layout":{"type":"default"}} -->
<div class="wp-block-group pl-sec-head">
<!-- wp:group {"className":"pl-sec-head__main","layout":{"type":"default"}} -->
<div class="wp-block-group pl-sec-head__main">
<!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">Capabilities</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"pl-h2"} --><h2 class="wp-block-heading pl-h2">Full-funnel performance, one system</h2><!-- /wp:heading -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph {"className":"pl-sec-head__aside"} --><p class="pl-sec-head__aside">One team across paid, organic, and measurement—so the numbers in your board deck actually reconcile.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"pl-services__grid","layout":{"type":"default"}} -->
<div class="wp-block-group pl-services__grid">'
	. $cap_row( '01', 'Meta ads &amp; paid social', 'Creative testing, account structure, and CAPI-led measurement so scaling spend does not scale waste.', 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=480&amp;q=80' )
	. $cap_row( '02', 'SEO &amp; content', 'Technical foundations, intent-led clusters, and internal linking that compound traffic over quarters.', 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=480&amp;q=80' )
	. $cap_row( '03', 'Analytics &amp; attribution', 'Clean event schemas, server-side tagging, and dashboards leadership actually uses in weekly reviews.', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=480&amp;q=80' )
	. $cap_row( '04', 'Landing pages &amp; CRO', 'Fast, on-brand pages and structured experiments that turn the traffic you already pay for into pipeline.', 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=480&amp;q=80' )
	. '</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->';

	$stats = '
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
<!-- /wp:group -->';

	$work = '
<!-- wp:group {"className":"pl-section pl-section--page","anchor":"work","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--page" id="work">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">Selected work</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"pl-h2"} --><h2 class="wp-block-heading pl-h2">Outcomes, not mood boards</h2><!-- /wp:heading -->
<!-- wp:columns {"className":"pl-pat-cards"} -->
<div class="wp-block-columns pl-pat-cards">
<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"pl-case","layout":{"type":"default"}} --><div class="wp-block-group pl-case"><!-- wp:image {"sizeSlug":"large"} --><figure class="wp-block-image size-large"><img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&amp;q=85" alt=""/></figure><!-- /wp:image --><!-- wp:group {"className":"pl-case__body","layout":{"type":"default"}} --><div class="wp-block-group pl-case__body"><!-- wp:heading {"level":3,"className":"pl-case__title"} --><h3 class="wp-block-heading pl-case__title">B2B SaaS pipeline rebuild</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-case__result"} --><p class="pl-case__result">61% lower CPL in 90 days</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"pl-case","layout":{"type":"default"}} --><div class="wp-block-group pl-case"><!-- wp:image {"sizeSlug":"large"} --><figure class="wp-block-image size-large"><img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200&amp;q=85" alt=""/></figure><!-- /wp:image --><!-- wp:group {"className":"pl-case__body","layout":{"type":"default"}} --><div class="wp-block-group pl-case__body"><!-- wp:heading {"level":3,"className":"pl-case__title"} --><h3 class="wp-block-heading pl-case__title">DTC omnichannel scale</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-case__result"} --><p class="pl-case__result">2.4× MER at same spend</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->';

	$process = '
<!-- wp:group {"className":"pl-section pl-section--paper","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--paper">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">Engagement</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"pl-h2"} --><h2 class="wp-block-heading pl-h2">How we plug into your team</h2><!-- /wp:heading -->
<!-- wp:columns {"className":"pl-pat-cards"} -->
<div class="wp-block-columns pl-pat-cards">
<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"pl-step","layout":{"type":"default"}} --><div class="wp-block-group pl-step"><!-- wp:paragraph {"className":"pl-step__n"} --><p class="pl-step__n">01</p><!-- /wp:paragraph --><!-- wp:heading {"level":3,"className":"pl-step__title"} --><h3 class="wp-block-heading pl-step__title">Diagnose &amp; benchmark</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-step__text"} --><p class="pl-step__text">Audit accounts, analytics, and SERP reality. Align on margin, payback, and guardrails before spend moves.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"pl-step","layout":{"type":"default"}} --><div class="wp-block-group pl-step"><!-- wp:paragraph {"className":"pl-step__n"} --><p class="pl-step__n">02</p><!-- /wp:paragraph --><!-- wp:heading {"level":3,"className":"pl-step__title"} --><h3 class="wp-block-heading pl-step__title">Ship the growth system</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-step__text"} --><p class="pl-step__text">Launch structured tests, SEO fixes, and tracking—documented in a living roadmap the whole team can see.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"pl-step","layout":{"type":"default"}} --><div class="wp-block-group pl-step"><!-- wp:paragraph {"className":"pl-step__n"} --><p class="pl-step__n">03</p><!-- /wp:paragraph --><!-- wp:heading {"level":3,"className":"pl-step__title"} --><h3 class="wp-block-heading pl-step__title">Compound weekly</h3><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-step__text"} --><p class="pl-step__text">Creative velocity, query expansion, and bid/budget logic tuned in a tight feedback loop with your data.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->';

	$tst = '
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
<!-- /wp:group -->';

	$pricing = '
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
<!-- /wp:group -->';

	$faq = '
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
<!-- /wp:group -->';

	$contact = '
<!-- wp:group {"className":"pl-section pl-section--page","anchor":"contact","layout":{"type":"default"}} -->
<div class="wp-block-group pl-section pl-section--page" id="contact">
<!-- wp:group {"className":"pl-container","layout":{"type":"default"}} -->
<div class="wp-block-group pl-container">
<!-- wp:columns {"className":"pl-contact-grid"} -->
<div class="wp-block-columns pl-contact-grid">
<!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph {"className":"pl-kicker pl-kicker--lift"} --><p class="pl-kicker pl-kicker--lift">Contact</p><!-- /wp:paragraph --><!-- wp:heading {"className":"pl-h2"} --><h2 class="wp-block-heading pl-h2">Let us talk about your pipeline</h2><!-- /wp:heading --><!-- wp:paragraph {"className":"pl-lede"} --><p class="pl-lede">Tell us your goals, stack, and constraints. You will get a direct answer on fit—usually within one business day.</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:shortcode -->[pulselyft_contact_form]<!-- /wp:shortcode --></div><!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->';

	$cta = '
<!-- wp:group {"className":"pl-cta","anchor":"book-call","layout":{"type":"default"}} -->
<div class="wp-block-group pl-cta" id="book-call">
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
<!-- /wp:group -->';

	$patterns = array(
		'hero'         => array( __( 'PulseLyft: Hero', 'pulselyft' ), $hero ),
		'logos'        => array( __( 'PulseLyft: Logo row', 'pulselyft' ), $logos ),
		'capabilities' => array( __( 'PulseLyft: Capabilities (interactive list)', 'pulselyft' ), $caps ),
		'stats'        => array( __( 'PulseLyft: Stat band (dark)', 'pulselyft' ), $stats ),
		'work'         => array( __( 'PulseLyft: Case studies', 'pulselyft' ), $work ),
		'process'      => array( __( 'PulseLyft: Process (3 steps)', 'pulselyft' ), $process ),
		'testimonial'  => array( __( 'PulseLyft: Testimonial (dark quote)', 'pulselyft' ), $tst ),
		'pricing'      => array( __( 'PulseLyft: Pricing (3 tiers)', 'pulselyft' ), $pricing ),
		'faq'          => array( __( 'PulseLyft: FAQ (accordion)', 'pulselyft' ), $faq ),
		'contact'      => array( __( 'PulseLyft: Contact (form)', 'pulselyft' ), $contact ),
		'cta'          => array( __( 'PulseLyft: CTA band (gradient)', 'pulselyft' ), $cta ),
		'homepage'     => array( __( 'PulseLyft: Full homepage', 'pulselyft' ), $hero . $logos . $caps . $stats . $work . $process . $tst . $pricing . $faq . $cta ),
	);

	return $patterns;
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
	foreach ( pulselyft_patterns() as $slug => $data ) {
		register_block_pattern( 'pulselyft/' . $slug, array(
			'title'      => $data[0],
			'categories' => array( 'pulselyft' ),
			'content'    => $data[1],
		) );
	}
}
add_action( 'init', 'pulselyft_register_patterns' );
