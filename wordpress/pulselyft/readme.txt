=== PulseLyft ===
Contributors: pulselyftstudio
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 3.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: marketing, business, landing-page, one-page, custom-colors, custom-logo, custom-menu, featured-images, blog, full-width-template, seo

A high-converting, SEO-first one-page landing theme for a performance marketing studio. WordPress port of the PulseLyft web app.

== Description ==

PulseLyft is a high-converting, SEO-first landing-page theme for a performance
marketing studio (Meta ads, performance creative, SEO & content, analytics & attribution).

It is a faithful WordPress port of the PulseLyft web app: Fraunces + Outfit type,
"lift" green accents over a warm paper background, a bento-style services grid,
case studies, portfolio, process, testimonials, a dark CTA band, a blog teaser,
Calendly booking, a contact form, and a built-in chat assistant.

The full landing page renders on your homepage automatically (via front-page.php).
All key content is editable in Appearance -> Customize -> "PulseLyft Landing Page".

== Features ==

* Complete multi-page website — Home, About, Services, Pricing, Contact, and Blog,
  plus Privacy & Terms — auto-created with menus on activation (idempotent, one time).
* One-page landing layout with 13 content sections (incl. an FAQ accordion).
* Light AND dark modes — system-aware, one-tap toggle, persisted, no flash of wrong theme.
* Agency-grade motion: staggered scroll-reveals, animated stat counters, glossy button
  sweeps, premium card lift, and a film-grain texture — all respect prefers-reduced-motion.
* Sticky shrinking header with scrollspy active-link, a scroll progress bar, and back-to-top.
* Faithful design system in hand-written CSS — no build step, no Tailwind runtime, no CDN.
* SEO out of the box: title tag, meta description, canonical, robots, Open Graph,
  Twitter cards, and JSON-LD (ProfessionalService + WebSite, FAQPage rich results,
  Article on posts). Automatically defers to Yoast / Rank Math / SEOPress / AIOSEO if active.
* WordPress Customizer controls for brand, hero, CTAs, booking URL, contact, chatbot, socials.
* Blog support: front-page teaser using your recent posts (with a built-in fallback),
  plus single, archive, search, and 404 templates.
* Native wp_mail contact form (nonce + honeypot) or an embedded Jotform.
* REST-backed FAQ chat assistant; optionally point it at an external API.
* theme.json palette + fonts for the block editor.
* Accessible: skip link, ARIA labels, landmarks, focus-visible styles, reduced-motion support.

== Installation ==

1. In your WordPress admin, go to Appearance -> Themes -> Add New -> Upload Theme.
2. Choose pulselyft.zip and click Install Now, then Activate.
   (Or copy the `pulselyft` folder into wp-content/themes/ and activate it.)
3. Recommended: Settings -> Reading -> set a static homepage, and create a "Blog"
   page set as the Posts page.
4. Edit content under Appearance -> Customize -> "PulseLyft Landing Page".

== Frequently Asked Questions ==

= Where do I change the services, stats, and testimonials? =
The high-traffic fields (brand, hero, CTAs, booking, contact) are in the
Customizer. Richer lists live in inc/content.php and can be overridden with the
`pulselyft_default_content` filter from a child theme or small plugin.

= Does it work with SEO plugins? =
Yes. If Yoast, Rank Math, SEOPress, or All in One SEO is active, the theme's own
meta/JSON-LD output steps aside so there are no duplicate tags.

= Where did the About/Services/Pricing/Contact pages come from? =
On first activation (or first admin load after an update) the theme creates them
— plus Privacy, Terms, Home, and Blog — assigns the matching page templates,
configures a static homepage + posts page, and builds the primary and footer
menus. It only does this once and never overrides settings you already configured.

= Can I edit pages in the block editor? =
Yes. Open any page in the block editor and use the inserter (+) → Patterns →
"PulseLyft" to drop in on-brand, fully-editable sections (hero, stats,
capabilities, pricing, testimonial, FAQ, CTA). Colours, the pulse gradient, and
fonts are exposed via theme.json. To build the homepage with blocks, set
Appearance → Customize → Homepage → "Page content (blocks)" and edit the Home page.

= How do I edit the pages? =
Go to wp-admin → Pages and open any page. On the templated pages (About,
Services, Pricing, Contact) the page Title becomes the hero heading, the Excerpt
becomes the hero sub-headline, and the page Content becomes the body copy.
Privacy and Terms are ordinary editable pages. Structured blocks (pricing tiers,
values, metrics, testimonials, FAQ) live in inc/content.php and the Customizer.

= Do I need the contact form plugin? =
No. A native, wp_mail-backed form is built in. You can instead paste a Jotform ID
in the Customizer to embed the same form used by the web app.

== Changelog ==

= 3.0.0 =
* Full block (FSE) theme: every template and the header/footer are now editable
  in the Site Editor (Appearance → Editor). Added templates/ (front-page, index,
  page, single, archive, search, 404) and parts/ (header, footer); registered
  template parts in theme.json.
* Pages are seeded with editable section blocks (the homepage uses the Full
  Homepage pattern; About/Services/Pricing/Contact use their section patterns),
  so 100% of content is edited in the WordPress block editor.
* Site chrome (colour-theme bootstrap, skip link, scroll progress, back-to-top,
  chat assistant) moved to PHP hooks so it works across all block templates.

= 2.1.1 =
* Complete the block-pattern library so every homepage section is available and
  editable in the block editor: added Logo row, Case studies, Process, Contact,
  and a one-click "Full homepage" composite (alongside Hero, Capabilities, Stat
  band, Pricing, Testimonial, FAQ, CTA).
* Added a [pulselyft_contact_form] shortcode so the working contact form can be
  dropped into any block-built page or post.

= 2.1.0 =
* Block-editor editing: editor styles so the block editor matches the front end,
  expanded theme.json (palette, pulse gradient, fonts, spacing), and a set of
  on-brand block patterns (Hero, Stat band, Capabilities, Pricing, Testimonial,
  FAQ, CTA) under a "PulseLyft" category — every word, link, and colour editable.
* New "Homepage source" option (Appearance -> Customize -> Homepage): keep the
  designed sections, or build the homepage in the block editor with the patterns.
* Hero alignment refinement: a meta row (eyebrow + live "pulse" status) and a
  precise spec-bar foot with hairline dividers between the stats.

= 2.0.0 =
* "Editorial Studio" redesign — a complete frontend overhaul:
  - New type system: Fraunces (display) + Inter (UI) + JetBrains Mono (labels).
  - Signature violet → pink → amber "pulse" gradient used across accents.
  - Restructured, type-forward hero (oversized headline, gradient word, stat row).
  - Capabilities replace the bento grid with an interactive numbered list.
  - Bold dark Impact band, editorial case studies, numbered process, restyled
    testimonials (large dark quote), full-bleed gradient CTA, and a big footer.
  - Hairline editorial grid, mono eyebrows, refined cards and buttons.
* Carried forward across every page (blog, contact, about, services, pricing).

= 1.3.0 =
* Redesign: new modern "Iris" violet palette (indigo + rose accents) replacing
  the green scheme, in both light and dark modes.
* Fix a long-standing bug where the border tokens were self-referential, which
  made borders render as harsh dark lines.
* Blog redesign: hero band, featured lead post, category chips, author bylines,
  dates, share buttons, and a "Keep reading" related-posts block.
* Contact redesign: info cards (email / book a call / response time), social
  links, and a richer two-column form with a topic selector.

= 1.2.1 =
* Pages are now fully editable from wp-admin → Pages: the page Title drives the
  hero heading, the Excerpt drives the hero sub, and the Content (the editor)
  drives the body copy. Templates seed real starter content on creation.
* Provisioning now also runs on first admin load, so pages appear even after an
  in-place theme update (still idempotent — runs once, never overrides settings).

= 1.2.0 =
* Add a complete multi-page site: About, Services, Pricing, and Contact page
  templates (auto-applied by slug), plus Privacy Policy and Terms.
* Auto-provision pages, a Home/Blog structure, and primary + footer menus on
  activation (idempotent; never overrides existing settings).
* Add pricing tiers, values, feature checklist, contact methods, and sub-page hero styles.
* Header/footer navigation now includes the new pages and adapts on sub-pages.

= 1.1.0 =
* Add light/dark colour modes (system-aware, persisted, no-flash) with a header toggle.
* Add premium motion: staggered scroll-reveals, animated counters, glossy buttons, card lift, grain texture.
* Add sticky shrinking header with scrollspy, scroll progress bar, and back-to-top.
* Add an FAQ accordion section with FAQPage rich-result schema.
* Refactor colours to semantic design tokens for consistent theming.

= 1.0.0 =
* Initial release. WordPress port of the PulseLyft landing page.

== Credits ==

* Fonts: Fraunces and Outfit (Google Fonts, SIL Open Font License).
* Default demo imagery: Unsplash (replace with your own before launch).
