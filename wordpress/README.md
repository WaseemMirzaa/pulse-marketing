# PulseLyft — WordPress landing page (PHP)

This directory is the **PHP / WordPress** counterpart to the Next.js web app in
[`/web`](../web) and the NestJS API in [`/api`](../api).

It contains a self-contained, production-ready **WordPress theme** that
reproduces the PulseLyft marketing site so it can be hosted and managed on any
standard WordPress install — same design language, same sections, same services
and copy, with SEO baked in.

```
wordpress/
└── pulselyft/        ← the WordPress theme (install this)
```

## Quick start

```bash
# From the repo root, zip the theme for upload via wp-admin:
cd wordpress
zip -r pulselyft.zip pulselyft

# …or copy it straight into a WordPress install:
cp -r pulselyft /path/to/wp-content/themes/
```

Then in WordPress: **Appearance → Themes → Activate “PulseLyft”**.

See [`pulselyft/README.md`](pulselyft/README.md) for full installation,
configuration, design-parity notes, and the file map.

## How it relates to the rest of the repo

| App | Stack | Role |
|-----|-------|------|
| `web/` | Next.js + Tailwind | The canonical web app / design source of truth |
| `api/` | NestJS | Backend (CMS content, chat, contact email) |
| `wordpress/` | **PHP / WordPress theme** | The same landing page, hostable on WordPress |

The theme is independent — it needs **only WordPress** to run. Optionally it can
reuse the NestJS chat backend in `/api` by setting the **Chat API URL** in
*Appearance → Customize → PulseLyft Landing Page → Chatbot*.
