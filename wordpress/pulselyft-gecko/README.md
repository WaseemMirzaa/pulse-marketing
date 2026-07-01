# PulseLyft — Gecko + WPBakery drag-and-drop build

This is the **PulseLyft marketing site rebuilt on the Gecko theme** so every page
is editable with the **WPBakery Page Builder** drag-and-drop editor. It keeps the
PulseLyft "Editorial Studio" look (Fraunces + Inter + JetBrains Mono, the
violet → pink → amber *pulse* gradient, hairline grids, a type-forward hero) but
puts the whole site behind a visual builder so non-developers can rearrange,
edit, and add sections without touching code.

> This theme sits **alongside** the hand-coded `wordpress/pulselyft` theme (which
> is edited through the Customizer). Use **this** one when you want visual
> drag-and-drop editing; use the other when you want a zero-plugin classic theme.

## 100% PulseLyft, pixel for pixel

This build renders the **exact same front-end** as the hand-coded `wordpress/pulselyft`
theme — same markup, same classes, same interactions:

- `assets/css/pulselyft-skin.css` **is the real PulseLyft stylesheet** (the same
  766-line `style.css`), plus a short "WPBakery layout-neutralizer" appended at
  the end so builder wrappers don't disturb the section layouts.
- `assets/js/pulselyft-skin.js` **is the real PulseLyft `main.js`** — theme
  toggle (light/dark), sticky/shrinking header, scroll progress + scrollspy,
  scroll-reveals, animated stat counters, logo marquee, single-open FAQ, and the
  floating chat assistant.
- `header.php` / `footer.php` render the real PulseLyft chrome (fixed nav, logo,
  editorial footer, back-to-top, chat) — not Gecko's framework header/footer.
- Gecko's own front-end CSS/JS is **dequeued** so nothing competes with the
  PulseLyft look.

## What's in the box

```
pulselyft-gecko/
├── style.css                     ← theme header (Gecko base CSS retained but dequeued on front-end)
├── functions.php                 ← Gecko bootstrap + loads inc/pulselyft.php
├── header.php · footer.php       ← the real PulseLyft chrome (nav, footer, chat)
├── inc/pulselyft.php             ← PulseLyft brand layer (see below)
├── assets/css/pulselyft-skin.css ← the real PulseLyft stylesheet + WPBakery neutralizer
├── assets/js/pulselyft-skin.js   ← the real PulseLyft main.js (toggle, reveals, counters…)
├── pulselyft-pages/*.html        ← WPBakery content for each page (exact section markup)
│   ├── home.html  about.html  services.html  pricing.html  contact.html
└── core/ views/ assets/ …        ← the Gecko framework (kept for WPBakery + admin)
```

`inc/pulselyft.php` is the brand layer. It:

1. **Swaps Gecko's look for PulseLyft's** — dequeues `jas-gecko-style`,
   `jas-gecko-animated`, its Google font and `theme.js`, then enqueues the
   PulseLyft fonts, stylesheet and behaviour.
2. **Adds a flat nav-link walker** so the WordPress menu matches the PulseLyft
   header markup exactly.
3. **Registers no-plugin fallbacks** for the `vc_row` / `vc_column` /
   `vc_column_text` shortcodes the pages use — so the site renders correctly
   **even before the WPBakery plugin is installed**, and defers to the real
   plugin (and its drag-and-drop editor) once it's active.
4. **Auto-provisions the site** — creates Home, About, Services, Pricing and
   Contact from `pulselyft-pages/*.html`, sets Home as the static front page,
   builds the primary menu, and flags every page as a WPBakery page
   (`_wpb_vc_js_status = true`). Re-runs once per shipped **version** so content
   fixes land on upgrade; between versions it never touches your edits.

> **Heads-up on upgrades:** because provisioning re-runs when the theme version
> changes, bumping the version **refreshes the five pages from the shipped
> `.html` files**, overwriting edits to *those* pages. Duplicate a page (or work
> on new pages) if you need edits to survive a theme version bump.

## Install

1. Zip the theme (from the repo root):
   ```bash
   cd wordpress && ./build-theme.sh pulselyft-gecko   # or zip -r pulselyft-gecko.zip pulselyft-gecko
   ```
2. WordPress admin → **Appearance → Themes → Add New → Upload Theme** → activate.
3. When prompted (**Appearance → Install Plugins**), install & activate
   **WPBakery Page Builder** — Gecko bundles it as a required plugin. This is the
   drag-and-drop editor. (Optional: *JAS Addons* for extra Gecko elements.)
4. Done. Visit the site — Home, About, Services, Pricing and Contact are live and
   already skinned.

## Editing via drag-and-drop

- Open any page → **Edit with WPBakery Page Builder** → **Frontend editor** for a
  true what-you-see-is-what-you-get canvas.
- **Rows** are the section containers; drag them to reorder sections. **Columns**
  control layout. **Text blocks** hold the copy (double-click to edit inline).
- To keep the PulseLyft look on anything you add, set the element's
  **Extra class name** (the "Design Options" / advanced tab) to one of the
  brand classes — e.g. `pl-section`, `pl-hero`, `pl-card`, `pl-cap`, `pl-step`,
  `pl-quote`, `pl-cta`, `pl-kicker`, `pl-btn pl-btn--lift`. They're all documented
  in `assets/css/pulselyft-skin.css`.

## Design tokens

Mirrors `web/src` and `wordpress/pulselyft`:

| Token | Value |
|-------|-------|
| Display font | Fraunces |
| Sans font | Inter |
| Mono font | JetBrains Mono |
| Pulse gradient | `linear-gradient(100deg, #7c3aed, #db2777 52%, #f59e0b)` |
| Ink / Page / Paper | `#100e15` / `#f3f1ec` / `#ffffff` |
| Violet / Pink / Amber | `#6d28d9` / `#db2777` / `#f59e0b` |

## Notes

- **Text domain** stays `gecko` on purpose — the Gecko framework's translation
  calls depend on it. Only the visible theme name/description changed.
- The commercial **WPBakery** and **JAS Addons** plugins are *not committed* to the
  repo; install them from the theme's own **Install Plugins** screen.
- To restyle, edit `assets/css/pulselyft-skin.css` (or add CSS in
  **JanStudio → Theme Options**), **not** `style.css` — that keeps Gecko upgrades
  clean.
