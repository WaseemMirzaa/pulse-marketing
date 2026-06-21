=== PulseLyft ===
Contributors: pulselyftstudio
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0.0
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

* One-page landing layout with 12 content sections.
* Faithful design system in hand-written CSS — no build step, no Tailwind runtime, no CDN.
* SEO out of the box: title tag, meta description, canonical, robots, Open Graph,
  Twitter cards, and JSON-LD (ProfessionalService + WebSite, Article on posts).
  Automatically defers to Yoast / Rank Math / SEOPress / All in One SEO if active.
* WordPress Customizer controls for brand, hero, CTAs, booking URL, contact, chatbot, socials.
* Blog support: front-page teaser using your recent posts (with a built-in fallback),
  plus single, archive, search, and 404 templates.
* Native wp_mail contact form (nonce + honeypot) or an embedded Jotform.
* REST-backed FAQ chat assistant; optionally point it at an external API.
* theme.json palette + fonts for the block editor.
* Accessible: skip link, ARIA labels, landmarks, reduced-motion support.

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

= Do I need the contact form plugin? =
No. A native, wp_mail-backed form is built in. You can instead paste a Jotform ID
in the Customizer to embed the same form used by the web app.

== Changelog ==

= 1.0.0 =
* Initial release. WordPress port of the PulseLyft landing page.

== Credits ==

* Fonts: Fraunces and Outfit (Google Fonts, SIL Open Font License).
* Default demo imagery: Unsplash (replace with your own before launch).
