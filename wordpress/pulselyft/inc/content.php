<?php
/**
 * Default site content for the PulseLyft theme.
 *
 * Mirrors web/src/lib/siteContent.ts so the WordPress landing page ships with
 * the exact same services, copy, and imagery as the Next.js web app. Each value
 * is filterable, and the most important fields are also wired to the
 * Customizer (see inc/customizer.php) so the content is editable in wp-admin.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The full default content tree.
 *
 * @return array
 */
function pulselyft_default_content() {
	$content = array(
		'hero' => array(
			'badge'          => 'Performance marketing studio',
			'headlineBefore' => 'Revenue systems for brands that',
			'headlineItalic' => 'refuse',
			'headlineAfter'  => 'to guess.',
			'sub'            => 'Meta ads, performance creative, and SEO engineered around pipeline and profit—not slides that age in a week.',
			'primaryCta'     => 'Start a project',
			'secondaryCta'   => 'View outcomes',
			'heroImage'      => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=1200&q=85',
			'heroImageAlt'   => 'Marketing team reviewing campaign performance on screens',
			'stats'          => array(
				array( 'value' => '3.1×', 'label' => 'ROAS' ),
				array( 'value' => '97%', 'label' => 'Retention' ),
				array( 'value' => '$48M', 'label' => 'Managed' ),
			),
			'floatCard'      => array(
				'kicker' => 'Live program signal',
				'title'  => 'Scale-ready in weeks',
				'body'   => 'Measurement, creative, and search—one operating rhythm.',
			),
		),

		'logos' => array(
			'line'   => 'Trusted by teams shipping at scale',
			'brands' => array( 'Nimbus', 'Vertex', 'Lumen', 'Northline', 'Craft', 'Helio', 'Aperture', 'Signal' ),
		),

		'services' => array(
			'kicker' => 'Capabilities',
			'title'  => 'Full-funnel performance, orchestrated as one system',
			'intro'  => 'One senior squad across paid, creative, and search—aligned to CAC, payback, and LTV targets you already track.',
			'items'  => array(
				array(
					'title' => 'Meta ads & paid social',
					'body'  => 'Creative testing, account structure, and CAPI-led measurement so scaling spend does not scale waste.',
					'img'   => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=900&q=85',
				),
				array(
					'title' => 'Performance creative',
					'body'  => 'Hooks, angles, and UGC-style packs engineered for thumb-stopping relevance—not awards-show reels.',
					'img'   => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=900&q=85',
				),
				array(
					'title' => 'SEO & content systems',
					'body'  => 'Technical foundations, intent-led clusters, and internal linking that compound traffic over quarters.',
					'img'   => 'https://images.unsplash.com/photo-1432888498266-38ffec068eaf?w=900&q=85',
				),
				array(
					'title' => 'Analytics & attribution',
					'body'  => 'Clean event schemas, server-side tagging, and dashboards leadership actually uses in weekly reviews.',
					'img'   => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=900&q=85',
				),
			),
		),

		'metrics' => array(
			'kicker' => 'Evidence',
			'title'  => 'Numbers your CFO already asks for',
			'body'   => 'Benchmarks shift by category—we show ranges, not fairy tales. Portfolio blend across SaaS, DTC, and professional services.',
			'stats'  => array(
				array( 'value' => '$48M+', 'label' => 'Ad spend managed' ),
				array( 'value' => '142%', 'label' => 'Median organic lift YoY' ),
				array( 'value' => '4.2 wk', 'label' => 'Time to first scale test' ),
				array( 'value' => '97%', 'label' => 'Client retention (24 mo.)' ),
			),
		),

		'work' => array(
			'kicker'   => 'Selected work',
			'title'    => 'Outcomes, not mood boards',
			'intro'    => 'Representative engagements—anonymized where required. Every program pairs channel depth with ruthless prioritization.',
			'cta'      => 'Discuss a build',
			'caseBody' => 'Strategy, build, and weekly iteration—so wins compound instead of resetting each quarter.',
			'cases'    => array(
				array(
					'title'    => 'B2B SaaS pipeline rebuild',
					'tag'      => 'Meta + landing',
					'result'   => '61% lower CPL in 90 days',
					'img'      => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=85',
					'featured' => true,
				),
				array(
					'title'    => 'DTC omnichannel scale',
					'tag'      => 'Paid + lifecycle',
					'result'   => '2.4× MER at same spend',
					'img'      => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=900&q=85',
					'featured' => false,
				),
				array(
					'title'    => 'Category SEO takeover',
					'tag'      => 'Technical + content',
					'result'   => 'Top 3 for 38 money keywords',
					'img'      => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=900&q=85',
					'featured' => false,
				),
			),
		),

		'portfolio' => array(
			'kicker' => 'Portfolio',
			'title'  => 'Recent ships & experiments',
			'intro'  => 'A snapshot of programs across paid, lifecycle, CRO, and SEO. Every build is measured against pipeline, not applause.',
			'cta'    => 'Start a similar build',
			'items'  => array(
				array(
					'title'    => 'Lifecycle email redesign',
					'category' => 'CRM · retention',
					'img'      => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&q=85',
					'href'     => '#book-call',
				),
				array(
					'title'    => 'Paid social creative pack',
					'category' => 'Meta · performance creative',
					'img'      => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=800&q=85',
					'href'     => '#book-call',
				),
				array(
					'title'    => 'Enterprise landing system',
					'category' => 'CRO · landing',
					'img'      => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800&q=85',
					'href'     => '#book-call',
				),
				array(
					'title'    => 'Technical SEO migration',
					'category' => 'SEO · engineering',
					'img'      => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800&q=85',
					'href'     => '#book-call',
				),
			),
		),

		'process' => array(
			'kicker' => 'Engagement',
			'title'  => 'How we plug into your team',
			'intro'  => 'Senior operators, async-first rituals, and reporting your execs open without prompting.',
			'steps'  => array(
				array(
					'n'     => '01',
					'title' => 'Diagnose & benchmark',
					'body'  => 'Audit accounts, analytics, and SERP reality. Align on margin, payback, and guardrails before spend moves.',
				),
				array(
					'n'     => '02',
					'title' => 'Ship the growth system',
					'body'  => 'Launch structured tests, SEO fixes, and tracking—documented in a living roadmap the whole team can see.',
				),
				array(
					'n'     => '03',
					'title' => 'Compound weekly',
					'body'  => 'Creative velocity, query expansion, and bid/budget logic tuned in a tight feedback loop with your data.',
				),
			),
		),

		'testimonials' => array(
			'kicker' => 'Social proof',
			'title'  => 'Partners on the record',
			'quotes' => array(
				array(
					'quote'  => 'They replaced three vendors. Our Meta account finally talks to our CRM—and finance trusts the numbers.',
					'name'   => 'Jordan M.',
					'role'   => 'VP Growth, Series B SaaS',
					'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&q=85',
				),
				array(
					'quote'  => 'SEO was a black box. Now we ship clusters on a cadence and see compounding sessions every quarter.',
					'name'   => 'Priya K.',
					'role'   => 'CMO, DTC wellness',
					'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop&q=85',
				),
			),
		),

		'cta' => array(
			'kicker' => 'Next step',
			'title'  => 'Growth you can defend in a board meeting',
			'sub'    => 'Two-week discovery sprints, explicit milestones, and no mystery retainers.',
			'button' => 'Book a strategy call',
		),

		'bookCall' => array(
			'kicker'      => 'Book a call',
			'title'       => 'Pick a time that works for you',
			'sub'         => '30-minute intro to align on goals, stack, and whether PulseLyft is the right partner—no generic deck.',
			'calendlyUrl' => 'https://calendly.com/thepulselyft/30min',
		),

		'contact' => array(
			'kicker'   => 'Contact',
			'title'    => 'Tell us what winning looks like',
			'sub'      => 'Share goals, stack, and constraints. You will get a direct answer on fit—not a generic capabilities deck.',
			'jotformId' => '261392216292456',
			'points'   => array(
				'Response within one business day',
				'NDA-friendly intro calls',
			),
		),

		'blog' => array(
			'kicker' => 'Blog',
			'title'  => 'Playbooks for paid, search, and measurement',
			'intro'  => 'Practical notes from programs we run—no fluff, no recycled listicles.',
		),

		'faq' => array(
			'kicker' => 'FAQ',
			'title'  => 'Answers before you book',
			'intro'  => 'The questions prospective partners ask most. Still unsure? Start a chat or book a call—real answers, no sales theatre.',
			'items'  => array(
				array(
					'q' => 'How quickly can we launch?',
					'a' => 'Most programs go live within two to four weeks: a discovery sprint to audit accounts, analytics, and SERP reality, then the first structured tests and tracking ship together. Median time to first scale test across our portfolio is 4.2 weeks.',
				),
				array(
					'q' => 'What does an engagement cost?',
					'a' => 'Every engagement opens with a fixed-scope two-week discovery sprint, then a monthly program priced to your channels and ad budget—with explicit milestones and no mystery retainers. Book a call and we will size it precisely.',
				),
				array(
					'q' => 'Which channels do you run?',
					'a' => 'Meta ads and paid social, performance creative, SEO and content systems, plus analytics and attribution—orchestrated as one full-funnel system rather than disconnected point services.',
				),
				array(
					'q' => 'How do you report on performance?',
					'a' => 'One weekly dashboard your leadership actually opens: spend, MER/ROAS, CAC, payback window, and pipeline influenced—built on clean, server-side event schemas your finance team can trust.',
				),
				array(
					'q' => 'Do we keep ownership of our accounts and data?',
					'a' => 'Always. Ad accounts, analytics, pixels, and content remain yours. We operate inside your stack with documented access, so nothing is held hostage if we ever part ways.',
				),
				array(
					'q' => 'What if we already have an in-house team?',
					'a' => 'Great—most of our partners do. We plug in as senior operators with async-first rituals, augmenting your team on strategy, creative velocity, and measurement instead of replacing it.',
				),
			),
		),

		'pages' => array(
			'about' => array(
				'kicker'       => 'About',
				'title'        => 'A senior squad obsessed with profit, not vanity',
				'sub'          => 'PulseLyft is a performance marketing studio for teams who measure twice and scale once. We run paid, creative, and search as one accountable system—wired to pipeline, payback, and LTV.',
				'storyHeading' => 'Why we exist',
				'story'        => array(
					'Most growth programs stall because channels are run in isolation: an agency for ads, a freelancer for SEO, and a dashboard nobody trusts. The result is spend that scales faster than profit.',
					'We started PulseLyft to operate differently—one senior team across paid, creative, and search, aligned to the same revenue targets your finance team already tracks. No juniors learning on your budget, no vanity slides.',
					'The outcome is a growth system that compounds: clean measurement, a steady cadence of creative tests, and search that builds equity quarter over quarter.',
				),
				'values'       => array(
					array( 'title' => 'Profit over applause', 'body' => 'We optimize for payback and LTV, not impressions or award reels. If it does not move the model, we do not ship it.' ),
					array( 'title' => 'Evidence over opinion', 'body' => 'Every decision traces to clean data—server-side events, documented definitions, and one source of truth.' ),
					array( 'title' => 'Velocity over perfection', 'body' => 'We ship structured tests weekly and let the market vote. Momentum beats month-long deliberation.' ),
					array( 'title' => 'Ownership, always', 'body' => 'Your accounts, pixels, and content stay yours. We operate inside your stack with documented access—nothing held hostage.' ),
				),
			),
			'services' => array(
				'kicker'   => 'Services',
				'title'    => 'Full-funnel growth, run as one system',
				'sub'      => 'Paid, creative, search, and measurement—orchestrated by senior operators against the CAC, payback, and LTV targets you already track.',
				'body'     => array(
					'Great performance marketing is not a pile of disconnected tactics—it is one system where creative, media, and measurement reinforce each other. Below is what an engagement looks like and exactly what is included.',
				),
				'included' => array(
					array( 'title' => 'Strategy & benchmarking', 'body' => 'Account, analytics, and SERP audits with margin and payback guardrails before a dollar moves.' ),
					array( 'title' => 'Performance creative', 'body' => 'Hooks, angles, and UGC-style packs produced on a cadence and engineered for relevance.' ),
					array( 'title' => 'Media buying', 'body' => 'Disciplined account structure, bid/budget logic, and scaling tests across Meta and paid social.' ),
					array( 'title' => 'Technical & content SEO', 'body' => 'Crawl health, Core Web Vitals, intent-led clusters, and internal linking that compounds.' ),
					array( 'title' => 'Analytics & attribution', 'body' => 'Clean event schemas, CAPI, and server-side tagging your leadership can defend in a board meeting.' ),
					array( 'title' => 'Weekly reporting', 'body' => 'One dashboard—spend, MER/ROAS, CAC, payback, pipeline influenced—reviewed in a tight loop.' ),
				),
			),
			'pricing' => array(
				'kicker' => 'Pricing',
				'title'  => 'Plans that scale with your ambition',
				'sub'    => 'Every engagement opens with a fixed-scope, two-week discovery sprint. No mystery retainers—just scoped milestones you can defend.',
				'body'   => array(
					'Pricing should be obvious, not negotiated in the dark. Pick the plan that matches your stage—every engagement starts with a two-week discovery sprint, so we both agree on scope before committing.',
				),
				'note'   => 'All plans include a dedicated senior lead, weekly reporting, and full ownership of your accounts and data. Advertising spend is billed separately by the platforms.',
				'tiers'  => array(
					array(
						'name'     => 'Launch',
						'price'    => '$3.5k',
						'cadence'  => '/month',
						'blurb'    => 'For early-stage teams finding their first scalable channel.',
						'features' => array( 'One paid channel (Meta)', '4 creative concepts / month', 'Conversion tracking setup', 'Bi-weekly reporting' ),
						'cta'      => 'Start with Launch',
						'featured' => false,
					),
					array(
						'name'     => 'Scale',
						'price'    => '$7.5k',
						'cadence'  => '/month',
						'blurb'    => 'For teams ready to compound paid and search together.',
						'features' => array( 'Paid social + SEO program', '10 creative concepts / month', 'Server-side tracking & CAPI', 'Weekly reporting + live dashboard', 'Landing page CRO' ),
						'cta'      => 'Choose Scale',
						'featured' => true,
					),
					array(
						'name'     => 'Partner',
						'price'    => 'Custom',
						'cadence'  => '',
						'blurb'    => 'A full-funnel program for multi-channel scale.',
						'features' => array( 'Everything in Scale', 'Multi-channel media buying', 'Dedicated creative pod', 'Quarterly strategy offsites', 'Priority support & Slack' ),
						'cta'      => 'Talk to us',
						'featured' => false,
					),
				),
			),
			'contact' => array(
				'kicker'  => 'Contact',
				'title'   => 'Let us talk about your pipeline',
				'sub'     => 'Tell us your goals, stack, and constraints. You will get a direct, human answer on fit—usually within one business day.',
				'body'    => array(
					'Whether you are scaling paid, untangling attribution, or rebuilding your SEO foundation, we will give you a straight answer on fit. Reach out below and we will reply within one business day.',
				),
				'methods' => array(
					array( 'label' => 'Book a call', 'value' => '30-minute intro', 'href' => '#book-call' ),
					array( 'label' => 'Response time', 'value' => 'Within 1 business day', 'href' => '' ),
				),
			),
		),

		'legal' => array(
			'privacy' => array(
				'title' => 'Privacy Policy',
				'intro' => 'This Privacy Policy explains how we collect, use, and protect your information when you visit our website or engage our services. Replace this starter copy with policy reviewed by your legal counsel.',
				'sections' => array(
					array( 'h' => 'Information we collect', 'p' => 'We collect details you provide directly—such as your name, email, company, and message—when you submit a form or book a call. We also collect standard analytics data (pages viewed, device, and referrer) to improve the site.' ),
					array( 'h' => 'How we use information', 'p' => 'We use your information to respond to enquiries, deliver and improve our services, and—only with consent—send occasional updates. We do not sell your personal data.' ),
					array( 'h' => 'Cookies & analytics', 'p' => 'We may use cookies and privacy-respecting analytics to understand site usage. You can control cookies through your browser settings.' ),
					array( 'h' => 'Data retention & your rights', 'p' => 'We keep enquiry data only as long as needed to respond and meet legal obligations. You may request access, correction, or deletion of your data at any time by contacting us.' ),
					array( 'h' => 'Contact', 'p' => 'Questions about this policy? Email us using the address in the site footer and we will respond promptly.' ),
				),
			),
			'terms' => array(
				'title' => 'Terms of Service',
				'intro' => 'These Terms govern your use of this website and any services provided. Replace this starter copy with terms reviewed by your legal counsel.',
				'sections' => array(
					array( 'h' => 'Use of the site', 'p' => 'You agree to use this website lawfully and not to disrupt its operation or attempt unauthorized access.' ),
					array( 'h' => 'Engagements & scope', 'p' => 'Services are delivered under a separate, signed statement of work that defines scope, milestones, fees, and timelines. Nothing on this site constitutes a binding offer.' ),
					array( 'h' => 'Intellectual property', 'p' => 'Site content and branding are owned by us or our licensors. Deliverables produced during an engagement are governed by your statement of work.' ),
					array( 'h' => 'Disclaimers & liability', 'p' => 'The site is provided “as is.” To the fullest extent permitted by law, we are not liable for indirect or consequential damages arising from its use.' ),
					array( 'h' => 'Changes', 'p' => 'We may update these Terms from time to time. Continued use of the site constitutes acceptance of the revised Terms.' ),
				),
			),
		),

		'brand' => array(
			'namePrefix' => 'Pulse',
			'nameAccent' => 'Lyft',
			'tagline'    => 'Performance marketing, Meta ads, and SEO for teams who measure twice and scale once.',
			'email'      => 'hello@pulselyft.com',
			'metaDesc'   => 'Meta ads, paid acquisition, and search growth for brands that want measurable revenue—not vanity metrics.',
		),
	);

	/**
	 * Filter the entire default content tree.
	 *
	 * @param array $content Default content.
	 */
	return apply_filters( 'pulselyft_default_content', $content );
}

/**
 * Default blog posts used as a fallback when WordPress has no published posts.
 * Mirrors web/src/lib/blogPosts.ts.
 *
 * @return array
 */
function pulselyft_default_posts() {
	return array(
		array(
			'slug'     => 'meta-ads-creative-testing-framework',
			'title'    => 'A creative testing framework that actually scales Meta spend',
			'excerpt'  => 'Most teams burn budget on random creative swaps. Here is a simple structure for hooks, angles, and kill rules that keeps CAC honest.',
			'category' => 'Meta ads',
			'date'     => '2026-05-12',
			'readTime' => '6 min read',
			'img'      => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&q=85',
		),
		array(
			'slug'     => 'seo-clusters-for-revenue-keywords',
			'title'    => 'SEO clusters built for revenue keywords—not vanity traffic',
			'excerpt'  => 'Intent-led content systems compound when technical foundations and internal linking work together. A practical cadence for B2B and DTC teams.',
			'category' => 'SEO',
			'date'     => '2026-04-28',
			'readTime' => '5 min read',
			'img'      => 'https://images.unsplash.com/photo-1432888498266-38ffec068eaf?w=1200&q=85',
		),
		array(
			'slug'     => 'attribution-leaders-trust',
			'title'    => 'Attribution your leadership team will actually trust',
			'excerpt'  => 'Server-side events, clean UTMs, and a single weekly dashboard beat twelve conflicting reports every time.',
			'category' => 'Analytics',
			'date'     => '2026-04-10',
			'readTime' => '4 min read',
			'img'      => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=85',
		),
	);
}

/**
 * Resolve a content value, preferring a Customizer/theme-mod override and
 * falling back to the default content tree.
 *
 * Dot-path lookups are supported, e.g. pulselyft_get( 'hero.sub' ).
 * Customizer overrides use underscore keys, e.g. theme mod 'pulselyft_hero_sub'.
 *
 * @param string $path    Dot path into the default content array.
 * @param string $mod_key Optional theme-mod key to check first.
 * @return mixed
 */
function pulselyft_get( $path, $mod_key = '' ) {
	if ( $mod_key ) {
		$override = get_theme_mod( $mod_key, null );
		if ( null !== $override && '' !== $override ) {
			return $override;
		}
	}

	$content = pulselyft_default_content();
	$segments = explode( '.', $path );
	$node = $content;
	foreach ( $segments as $seg ) {
		if ( is_array( $node ) && array_key_exists( $seg, $node ) ) {
			$node = $node[ $seg ];
		} else {
			return '';
		}
	}
	return $node;
}

/**
 * Convenience: brand name pieces and computed full name.
 *
 * @return array{prefix:string,accent:string,full:string}
 */
function pulselyft_brand() {
	$prefix = pulselyft_get( 'brand.namePrefix', 'pulselyft_brand_prefix' );
	$accent = pulselyft_get( 'brand.nameAccent', 'pulselyft_brand_accent' );
	return array(
		'prefix' => $prefix,
		'accent' => $accent,
		'full'   => trim( $prefix . $accent ),
	);
}
