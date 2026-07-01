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

## What's in the box

```
pulselyft-gecko/
├── style.css                     ← rebranded Gecko header + Gecko base CSS
├── functions.php                 ← Gecko bootstrap + loads inc/pulselyft.php
├── inc/pulselyft.php             ← PulseLyft brand layer (see below)
├── assets/css/pulselyft-skin.css ← the PulseLyft skin (design tokens + components)
├── assets/js/pulselyft-skin.js   ← scroll-reveal progressive enhancement
├── pulselyft-pages/*.html        ← WPBakery content for each page
│   ├── home.html  about.html  services.html  pricing.html  contact.html
└── core/ views/ assets/ …        ← the unmodified Gecko framework
```

`inc/pulselyft.php` is the only PHP we add. It:

1. **Enqueues the skin** (fonts + `pulselyft-skin.css`) *after* Gecko's stylesheet
   so brand rules win the cascade — Gecko itself is left untouched and upgradeable.
2. **Adds a `pl-scope` body class** the skin hooks onto.
3. **Auto-provisions the site on first activation** — creates Home, About,
   Services, Pricing and Contact pages from `pulselyft-pages/*.html`, sets Home as
   the static front page, builds a primary menu, and flags every page as a
   WPBakery page (`_wpb_vc_js_status = true`) so it opens straight into the
   drag-and-drop editor. Guarded by an option, so re-activating never overwrites
   your edits.

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
