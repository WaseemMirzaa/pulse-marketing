# PulseLyft — WordPress Theme

A high-converting, SEO-first landing-page theme for the **PulseLyft** performance
marketing studio. It is a pixel-faithful WordPress port of the Next.js web app in
[`/web`](../../web) — same brand, type system, colours, sections, services and copy
— so the marketing site can be hosted and edited on any standard WordPress install.

---

## Why a theme (not a plugin or static HTML)?

> *"It should be hostable on WordPress … UI according to the current web app … all
> services according to the web app."*

A classic PHP **theme** is the WordPress-native way to ship a full landing page:
drop it in, activate it, and the homepage renders. Content editors get the
WordPress Customizer; the design is faithfully reproduced in hand-written CSS (no
build step, no Tailwind runtime, no CDN dependency).

---

## Design parity with the web app

| Token | Value | Source |
|------|-------|--------|
| Display font | **Fraunces** | `web/src/app/layout.tsx` |
| Sans font | **Outfit** | `web/src/app/layout.tsx` |
| Ink | `#0f0f10` | `tailwind.config.ts` |
| Page (bg) | `#f5f4f0` | `tailwind.config.ts` |
| Lift / bright / soft | `#65a30d` / `#84cc16` / `#ecfccb` | `tailwind.config.ts` |
| Shadows, mesh gradient, grid-fade, float & marquee animations | reproduced 1:1 | `tailwind.config.ts` |

**Sections** (mirrors `web/src/app/home-page.tsx`, plus an FAQ):
Hero → Logo strip → Services → Metrics → Case studies → Portfolio → Process →
Testimonials → **FAQ** → CTA band → Blog → Book a call → Contact → Footer → Chat assistant.

### Agency-grade polish (v1.1)

This goes beyond a straight port — the extras that separate a premium theme:

- **Light & dark modes** — system-aware, one-tap toggle in the header, persisted to
  `localStorage`, with a no-flash inline script. Built on semantic CSS design tokens.
- **Motion design** — staggered scroll-reveals, animated stat counters, glossy button
  sweeps, premium card lift, and a subtle film-grain texture. Everything honours
  `prefers-reduced-motion`.
- **Smart chrome** — sticky shrinking header, **scrollspy** active-link highlighting, a
  top **scroll-progress** bar, and a **back-to-top** button.
- **FAQ accordion** with `FAQPage` JSON-LD for Google rich results.
- **Custom scrollbar** + refined `:focus-visible` states.

**Services** (identical to `web/src/lib/siteContent.ts`):
Meta ads & paid social · Performance creative · SEO & content systems ·
Analytics & attribution.

All default copy, stats, testimonials and imagery are mirrored in
[`inc/content.php`](inc/content.php).

---

## Installation

### Option A — Upload through wp-admin
1. Zip the **`pulselyft`** folder: `zip -r pulselyft.zip pulselyft`
2. WordPress admin → **Appearance → Themes → Add New → Upload Theme**.
3. Choose `pulselyft.zip`, **Install**, then **Activate**.

### Option B — Copy into the themes directory
```bash
cp -r wordpress/pulselyft /path/to/wordpress/wp-content/themes/
```
Then activate **PulseLyft** under Appearance → Themes.

### Recommended one-time setup
1. **Settings → Reading →** *Your homepage displays* → **A static page**.
   Create a blank page named e.g. *Home*, set it as **Homepage**, and create a
   page named *Blog* set as **Posts page**. (The theme's `front-page.php`
   automatically renders the landing page on the homepage either way.)
2. **Appearance → Menus →** assign a menu to *Primary Menu* (optional — the
   theme falls back to the standard section anchors).
3. **Appearance → Customize → PulseLyft Landing Page →** edit brand, hero, CTAs,
   booking URL, contact details, social links.

---

## Editing content

Most-used fields are in **Appearance → Customize → PulseLyft Landing Page**:

- **Brand & Identity** — name, tagline, contact email, SEO meta description
- **Hero** — badge, headline (3 parts incl. italic word), sub, CTAs, image + alt
- **CTA Band**, **Book a Call** (Calendly URL), **Contact** (Jotform ID optional)
- **Chatbot** — optional external API URL
- **Social Links** — LinkedIn / X / Instagram

Richer lists (services, metrics, work, portfolio, process, testimonials) live in
`inc/content.php`. Edit that array directly, or override it without touching the
theme via the filter:

```php
add_filter( 'pulselyft_default_content', function ( $content ) {
    $content['services']['items'][0]['title'] = 'My custom service';
    return $content;
} );
```

---

## Features

- **Light & dark modes** — system-aware, persisted header toggle, no-flash, token-based.
- **Premium motion** — staggered reveals, animated counters, scrollspy header, scroll
  progress, back-to-top, glossy buttons, grain texture (all reduced-motion aware).
- **SEO out of the box** (`inc/seo.php`): `<title>` tag support, meta description,
  canonical, robots, Open Graph, Twitter cards, and JSON-LD
  (`ProfessionalService` + `WebSite` + **`FAQPage`** on the homepage, `Article` on posts).
  Automatically **defers to Yoast / Rank Math / SEOPress / AIOSEO** if installed.
- **Accessible & semantic** — skip link, ARIA labels, landmark elements, reduced-motion support.
- **Performance** — no jQuery dependency on the front end, lazy-loaded imagery,
  `fetchpriority` on the hero, font + image preconnects, scroll-reveal via
  `IntersectionObserver`.
- **Blog** — `front-page.php` shows the 3 most recent posts; if none exist yet it
  falls back to the same three articles as the web app. Full single/archive/search/404 templates included.
- **Native contact form** — `wp_mail`-backed with nonce + honeypot, or paste a
  **Jotform ID** to embed the same form as the web app.
- **Chat assistant** — self-contained FAQ bot via a theme REST endpoint
  (`/wp-json/pulselyft/v1/chat`); point it at the NestJS API in [`/api`](../../api)
  by setting the Customizer *Chat API URL* to reuse the live backend.
- **Block editor ready** — `theme.json` exposes the brand palette and fonts.

---

## File map

```
pulselyft/
├── style.css                 Theme header + complete design system (CSS)
├── theme.json                Block-editor palette & typography
├── functions.php             Setup, enqueue, REST chat, contact handler, helpers
├── front-page.php            The landing page (assembles all sections)
├── header.php / footer.php   Fixed nav + footer + chatbot include
├── index.php archive.php single.php page.php 404.php searchform.php
├── inc/
│   ├── content.php           Default content (mirrors siteContent.ts) + getters
│   ├── customizer.php        Appearance → Customize options
│   ├── seo.php               Meta tags + JSON-LD (plugin-aware)
│   └── nav-walker.php        Flat anchor nav walker
├── template-parts/
│   ├── chatbot.php
│   ├── post-card.php
│   └── sections/             hero, logos, services, metrics, case-studies,
│                             portfolio, process, testimonials, faq, cta-band,
│                             blog, book-call, contact
└── assets/js/
    ├── main.js               Theme toggle, header/scrollspy/progress, reveals,
    │                         counters, FAQ accordion, mobile nav, chatbot
    └── customize-preview.js  Live Customizer preview
```

---

## Requirements
- WordPress **6.0+**
- PHP **7.4+**

## License
GPL-2.0-or-later, matching WordPress.
