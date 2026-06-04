# PulseLyft Marketing Website — Codebase Audit & Documentation

> Generated: 2026-06-03  
> Repository: `thepulselyft/pulse-marketing`

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Repository Structure](#2-repository-structure)
3. [Frontend (Next.js)](#3-frontend-nextjs)
   - [Pages & Routes](#31-pages--routes)
   - [Components](#32-components)
   - [Context & State](#33-context--state)
   - [Lib & Utilities](#34-lib--utilities)
   - [Styles & Theming](#35-styles--theming)
   - [Configuration](#36-configuration)
4. [Backend (NestJS API)](#4-backend-nestjs-api)
   - [API Endpoints](#41-api-endpoints)
   - [Modules](#42-modules)
   - [Guards & Auth](#43-guards--auth)
5. [Environment Variables](#5-environment-variables)
6. [Data Flow](#6-data-flow)
7. [Deployment](#7-deployment)
8. [What Exists](#8-what-exists)
9. [What Is Missing / Not Implemented](#9-what-is-missing--not-implemented)
10. [Known Issues & Gaps](#10-known-issues--gaps)

---

## 1. Project Overview

PulseLyft is a **performance marketing agency website** built as a monorepo with two separate applications:

| App | Stack | Port | Purpose |
|-----|-------|------|---------|
| `web/` | Next.js 15 + React 19 + TypeScript | 3000 | Public marketing site + admin CMS |
| `api/` | NestJS 10 + TypeScript | 3001 | REST API for content, contact, and chat |

The site is a single-page marketing layout with a built-in CMS: content is edited via an `/admin` panel, persisted to a JSON file on the API server, and served back to the frontend via API on every page load.

---

## 2. Repository Structure

```
pulse-marketing/
├── web/                            # Next.js 15 frontend
│   ├── src/
│   │   ├── app/
│   │   │   ├── page.tsx            # Route → renders HomePage
│   │   │   ├── home-page.tsx       # Assembles all page sections
│   │   │   ├── layout.tsx          # Root layout, fonts, metadata
│   │   │   ├── globals.css         # Tailwind base + custom utilities
│   │   │   ├── api/
│   │   │   │   └── contact/
│   │   │   │       └── route.ts    # Next.js API route: POST /api/contact
│   │   │   └── admin/
│   │   │       ├── page.tsx        # /admin CMS editor page
│   │   │       └── layout.tsx      # Admin layout
│   │   ├── components/
│   │   │   ├── Header.tsx
│   │   │   ├── Hero.tsx
│   │   │   ├── LogoStrip.tsx
│   │   │   ├── Services.tsx
│   │   │   ├── Metrics.tsx
│   │   │   ├── CaseStudies.tsx
│   │   │   ├── Portfolio.tsx
│   │   │   ├── Process.tsx
│   │   │   ├── Testimonials.tsx
│   │   │   ├── CtaBand.tsx
│   │   │   ├── BookCall.tsx
│   │   │   ├── Contact.tsx
│   │   │   ├── Footer.tsx
│   │   │   └── Chatbot.tsx
│   │   ├── context/
│   │   │   └── SiteContentProvider.tsx
│   │   └── lib/
│   │       ├── siteContent.ts
│   │       └── sendContactEmail.ts
│   ├── next.config.ts
│   ├── tailwind.config.ts
│   ├── tsconfig.json
│   ├── postcss.config.mjs
│   ├── package.json
│   ├── vercel.json
│   ├── .env.example
│   └── .eslintrc.json
│
├── api/                            # NestJS backend
│   ├── src/
│   │   ├── main.ts                 # Bootstrap, CORS, validation, port
│   │   ├── app.module.ts           # Root module
│   │   ├── health/
│   │   │   ├── health.module.ts
│   │   │   └── health.controller.ts
│   │   ├── contact/
│   │   │   ├── contact.module.ts
│   │   │   ├── contact.controller.ts
│   │   │   ├── contact.service.ts
│   │   │   └── contact.dto.ts
│   │   ├── chat/
│   │   │   ├── chat.module.ts
│   │   │   ├── chat.controller.ts
│   │   │   ├── chat.service.ts
│   │   │   └── chat.dto.ts
│   │   ├── offerings/
│   │   │   ├── offerings.module.ts
│   │   │   └── offerings.controller.ts
│   │   └── content/
│   │       ├── content.module.ts
│   │       ├── content.controller.ts
│   │       ├── admin-content.controller.ts
│   │       ├── content.service.ts
│   │       ├── admin-key.guard.ts
│   │       └── default-content.ts
│   ├── data/
│   │   ├── .gitkeep
│   │   └── site-content.json       # Runtime — admin edits persisted here
│   ├── nest-cli.json
│   ├── tsconfig.json
│   ├── package.json
│   └── .env.example
│
├── .gitignore
└── .vercelignore
```

---

## 3. Frontend (Next.js)

### 3.1 Pages & Routes

| Route | File | Visibility | Description |
|-------|------|------------|-------------|
| `/` | `app/page.tsx` → `home-page.tsx` | Public | Full marketing landing page |
| `/admin` | `app/admin/page.tsx` | Private (ADMIN_KEY) | CMS editor — edits all site text/images |
| `/api/contact` | `app/api/contact/route.ts` | Public POST | Contact form email handler (Next.js API route) |

**Home Page Sections** (in order, single scroll page):

| # | Anchor | Component | Section Name |
|---|--------|-----------|--------------|
| 1 | — | `Header` | Sticky navigation |
| 2 | `#hero` | `Hero` | Hero headline + stats + CTA |
| 3 | — | `LogoStrip` | Scrolling brand logos |
| 4 | `#services` | `Services` | 4 service cards |
| 5 | `#metrics` | `Metrics` | Evidence stats |
| 6 | `#work` | `CaseStudies` | Case study outcomes |
| 7 | `#portfolio` | `Portfolio` | Recent project grid |
| 8 | `#process` | `Process` | 3-step engagement flow |
| 9 | `#testimonials` | `Testimonials` | Customer quotes |
| 10 | — | `CtaBand` | Dark CTA banner |
| 11 | `#book-call` | `BookCall` | Calendly iframe |
| 12 | `#contact` | `Contact` | JotForm + contact details |
| 13 | — | `Footer` | Footer navigation |
| 14 | — | `Chatbot` | Floating chat widget |

---

### 3.2 Components

#### `Header.tsx`
- Fixed sticky navigation bar
- Logo on the left, nav links on the right
- Responsive: collapses to hamburger menu on mobile
- Nav links: Services, Work, Process, Testimonials, Contact
- CTA button: "Book a call" → scrolls to `#book-call`

#### `Hero.tsx`
- Reads content from `useSiteContent()` context
- Sections: badge, headline (supports italic spans), sub-headline, 2 CTA buttons
- Right side: hero image (from Unsplash) with floating stats card
- 3 stat items rendered below the image

#### `LogoStrip.tsx`
- Horizontally scrolling brand logo strip
- CSS `marquee` animation (infinite loop)
- Logo list editable via CMS

#### `Services.tsx`
- 4-card grid layout
- Each card: icon, title, short description
- Cards are data-driven (content from context)
- Services: Meta Ads, Performance Creative, SEO, Analytics

#### `Metrics.tsx`
- "Evidence" headline section
- 4 large stat numbers with labels
- Data from `useSiteContent()` context

#### `CaseStudies.tsx`
- Featured case (full-width 2-column layout with image)
- 2 standard case study cards
- Each: title, description, outcome metric, image

#### `Portfolio.tsx`
- 4-column grid of recent project thumbnails
- Hover effects
- Each item: image, title, category

#### `Process.tsx`
- 3 numbered steps: Diagnose → Ship → Compound
- Icon, step number, title, description per step
- Data-driven from context

#### `Testimonials.tsx`
- 2 testimonial quotes in an asymmetric layout
- Quote text, author name, role, avatar image

#### `CtaBand.tsx`
- Dark gradient background band
- Large headline + single CTA button
- Links to `#contact` or `#book-call`

#### `BookCall.tsx`
- Calendly iframe embed
- URL override via `NEXT_PUBLIC_CALENDLY_URL` env var or content
- Section heading editable via CMS

#### `Contact.tsx`
- JotForm iframe embed (form ID from `NEXT_PUBLIC_JOTFORM_ID`)
- Contact info block: email, phone, address

#### `Footer.tsx`
- Logo + tagline
- Navigation links (mirrors Header)
- Legal links: Privacy Policy, Terms of Service (stubs — no pages exist)
- Copyright line

#### `Chatbot.tsx`
- Floating chat icon (bottom-right corner)
- Toggle open/close panel
- Sends messages to `/api/chat` (NestJS backend)
- Renders assistant responses inline

---

### 3.3 Context & State

#### `SiteContentProvider.tsx`

```
Provider wraps entire app → fetches GET /api/content on mount
       ↓
Merges API response over hardcoded defaults (deepMerge)
       ↓
Exposes via useSiteContent() hook: { content, loaded, reload }
```

- All editable components consume `useSiteContent()`
- Falls back gracefully to defaults if API is unreachable
- `reload()` re-fetches content (used by admin panel after saves)

---

### 3.4 Lib & Utilities

#### `siteContent.ts`

Defines the complete shape of the site's content model:

**TypeScript interfaces:**

| Type | Fields |
|------|--------|
| `SiteContent` | hero, logoStrip, services, metrics, caseStudies, portfolio, process, testimonials, ctaBand, bookCall |
| `Hero` | badge, headline, subHead, primaryCta, secondaryCta, stats[], image |
| `Stat` | value, label |
| `ServiceItem` | icon, title, body |
| `CaseItem` | title, description, metric, image, featured |
| `PortfolioItem` | title, category, image |
| `ProcessStep` | icon, title, body |
| `Quote` | body, author, role, avatar |

**Functions:**

| Function | Purpose |
|----------|---------|
| `defaultSiteContent()` | Returns complete hardcoded default content |
| `mergeFetchedContent(raw)` | Deep merges API payload over defaults |
| `deepMerge(base, patch)` | Recursive plain-object merge |
| `isPlainObject(v)` | Type guard for plain objects |

#### `sendContactEmail.ts`

- Configures nodemailer transporter from SMTP env vars
- Sends HTML-formatted contact email
- Escapes HTML entities in user input
- Returns `{ sent: boolean, reason?: string }`
- Validates SMTP config is present before attempting

---

### 3.5 Styles & Theming

#### Tailwind Config (`tailwind.config.ts`)

**Custom Colors:**

| Token | Hex | Usage |
|-------|-----|-------|
| `page` | `#f5f4f0` | Page background (warm off-white) |
| `paper` | `#ffffff` | Card/component backgrounds |
| `ink` | `#0f0f10` | Primary text |
| `lift` | `#65a30d` | Primary brand green (lime-700) |
| `lift-bright` | `#84cc16` | Hover states |
| `lift-soft` | `#f7fee7` | Tinted backgrounds |

**Custom Animations:**

| Name | Description |
|------|-------------|
| `fade-up` | Opacity 0→1, translateY 24px→0, 0.5s ease |
| `marquee` | Infinite horizontal scroll for logo strip |
| `float` | Up-down bob (0→-12px→0), 3s ease-in-out |

**Custom Backgrounds:**

| Name | Description |
|------|-------------|
| `mesh` | Radial gradient blob background |
| `grid-fade` | Grid pattern that fades at edges |

**Custom Shadows:**

| Name | Description |
|------|-------------|
| `card` | Subtle drop shadow for cards |
| `lift` | Green glow shadow for brand elements |

**Fonts:**
- Display: `Fraunces` (variable weight, Google Fonts)
- Sans: `Outfit` (variable weight, Google Fonts)

#### Global Styles (`globals.css`)
- Tailwind `@base`, `@components`, `@utilities`
- `scroll-behavior: smooth` on `html`
- `text-balance` utility for heading wrapping
- Selection highlight color: `lift-soft` background

---

### 3.6 Configuration

#### `next.config.ts`
```ts
images: {
  remotePatterns: [{ hostname: "images.unsplash.com" }]
}
```
Only Unsplash is allowlisted for remote images.

#### `vercel.json`
- Configured for Vercel deployment (no special rewrites noted)

#### `tsconfig.json`
- `paths: { "@/*": ["./src/*"] }` — import alias
- Target: ES2017

---

## 4. Backend (NestJS API)

### 4.1 API Endpoints

| Method | Route | Auth Required | Description |
|--------|-------|---------------|-------------|
| `GET` | `/health` | No | Health check — returns `{ status: "ok" }` |
| `GET` | `/api/content` | No | Returns merged site content (JSON) |
| `PUT` | `/api/admin/content` | Yes (`x-admin-key`) | Overwrites site content in JSON file |
| `POST` | `/api/contact` | No | Sends contact email via SMTP |
| `POST` | `/api/chat` | No | Returns chatbot reply based on message |
| `GET` | `/api/services` | No | Returns hardcoded list of 4 services |

---

### 4.2 Modules

#### `health/`
- Single controller
- `GET /health` → returns `{ status: "ok", timestamp: <iso> }`

#### `content/`
- **ContentService**: reads `api/data/site-content.json`; if not present, returns defaults
- **ContentController**: `GET /api/content` → merges stored JSON over defaults, returns full object
- **AdminContentController**: `PUT /api/admin/content` → accepts body, writes to JSON file (creates if not exists)
- **default-content.ts**: Mirror of frontend `siteContent.ts` defaults (duplicated)

#### `contact/`
- **ContactDto**: Validates `name: string`, `email: string` (IsEmail), `message: string`
- **ContactService**: Sends email via nodemailer, returns `{ received: true, id: uuid }`
- **ContactController**: `POST /api/contact` → validates → sends email → responds

#### `chat/`
- **ChatDto**: Validates `message: string`
- **ChatService**: Regex pattern matching on lowercased input. Patterns include: greetings, meta/facebook, seo, pricing, portfolio, process, booking, contact, team size
- **ChatController**: `POST /api/chat` → returns `{ reply: string }`

#### `offerings/`
- **OfferingsController**: `GET /api/services` → returns array of 4 hardcoded service objects

---

### 4.3 Guards & Auth

#### `AdminKeyGuard`
- NestJS `CanActivate` guard
- Reads `x-admin-key` request header
- Compares to `process.env.ADMIN_KEY`
- Throws `UnauthorizedException` (401) if missing or mismatched
- Applied only to `PUT /api/admin/content`

---

## 5. Environment Variables

### Web (`web/.env`)

| Variable | Default | Required | Purpose |
|----------|---------|----------|---------|
| `NEXT_PUBLIC_API_URL` | `http://localhost:3001` | Yes | Base URL for NestJS API |
| `NEXT_PUBLIC_JOTFORM_ID` | — | Yes | JotForm form ID for contact section |
| `NEXT_PUBLIC_CALENDLY_URL` | — | No | Override Calendly embed URL |
| `SMTP_HOST` | — | For email | SMTP server hostname |
| `SMTP_PORT` | `587` | For email | SMTP port |
| `SMTP_SECURE` | `false` | For email | Use TLS (`true`/`false`) |
| `SMTP_USER` | — | For email | SMTP login username |
| `SMTP_PASS` | — | For email | SMTP password / app password |
| `CONTACT_TO_EMAIL` | — | For email | Recipient inbox |
| `CONTACT_FROM_EMAIL` | — | For email | From header on contact emails |

### API (`api/.env`)

| Variable | Default | Required | Purpose |
|----------|---------|----------|---------|
| `PORT` | `3001` | No | HTTP server port |
| `ADMIN_KEY` | `dev-admin-change-me` | Yes (prod) | Admin CMS auth token |
| `CORS_ORIGIN` | `http://localhost:3000` | Yes | Allowed CORS origin |
| `SMTP_HOST` | — | For email | SMTP server hostname |
| `SMTP_PORT` | `587` | For email | SMTP port |
| `SMTP_SECURE` | `false` | For email | Use TLS |
| `SMTP_USER` | — | For email | SMTP login username |
| `SMTP_PASS` | — | For email | SMTP password |
| `CONTACT_TO_EMAIL` | — | For email | Recipient inbox |
| `CONTACT_FROM_EMAIL` | — | For email | From header |

---

## 6. Data Flow

### Content Load (Page Visit)

```
Browser visits /
  → SiteContentProvider mounts
  → GET NEXT_PUBLIC_API_URL/api/content
  → ContentService reads api/data/site-content.json
  → Merges with defaults (patch over base)
  → Returns merged JSON
  → deepMerge() applied on frontend too
  → All components render with live content
```

### Admin Edit (CMS Save)

```
/admin page loads → fetches current content
Admin edits form fields
Clicks Save
  → PUT /api/admin/content (x-admin-key header)
  → AdminKeyGuard validates key
  → ContentService writes to api/data/site-content.json
  → 200 OK
  → SiteContentProvider.reload() called
  → UI reflects new content
```

### Contact Form Submission

```
User fills JotForm (iframe embed)
  → JotForm handles submission directly (external service)
  → OR: /api/contact route (Next.js or NestJS) called
  → ContactService validates DTO
  → nodemailer sends email to CONTACT_TO_EMAIL
  → { received: true, id } returned
```

### Chatbot Flow

```
User types message in Chatbot widget
  → POST /api/chat { message }
  → ChatService lowercases message
  → Regex pattern match
  → Returns matching hardcoded reply
  → Rendered in chat panel
```

---

## 7. Deployment

### Frontend (Vercel)

- `vercel.json` present, configured for Next.js
- Build: `cd web && npm run build`
- Set all `NEXT_PUBLIC_*` and SMTP env vars in Vercel dashboard
- Images served from Vercel CDN; Unsplash images proxied via Next.js Image

### Backend (API)

- No containerization (no Dockerfile)
- Intended for Node.js hosting (Railway, Render, EC2, etc.)
- Build: `cd api && npm run build`
- Start: `npm run start:prod`
- `api/data/` directory must be writable at runtime
- `site-content.json` is gitignored — created on first admin save

---

## 8. What Exists

### Features Fully Implemented

- [x] Full single-page marketing website (13 sections)
- [x] Responsive design (mobile hamburger menu, flexible grids)
- [x] Custom Tailwind theme (colors, fonts, animations)
- [x] Admin CMS panel at `/admin` (edit all site text + images)
- [x] Content persistence via JSON file on API
- [x] Deep merge: admin edits patch over defaults (no full overwrite risk)
- [x] Contact form via JotForm iframe embed
- [x] Alternative contact endpoint (`/api/contact`) via SMTP email
- [x] Calendly booking embed (`#book-call`)
- [x] Floating chatbot with regex-based responses
- [x] Brand logo strip with marquee animation
- [x] Case studies section (1 featured + 2 standard)
- [x] Portfolio grid (4 columns)
- [x] Process section (3 steps)
- [x] Testimonials (2 quotes)
- [x] CTA band
- [x] Stats/metrics section
- [x] Footer with navigation
- [x] Health check endpoint (`/health`)
- [x] Admin auth guard (`x-admin-key` header)
- [x] TypeScript throughout (frontend + backend)
- [x] Full type definitions for site content model
- [x] `.env.example` files for both apps

### Pages

- [x] `/` — Home (marketing landing page)
- [x] `/admin` — Content management editor

---

## 9. What Is Missing / Not Implemented

### Pages

- [ ] `/privacy` — Privacy Policy page (linked in Footer, no page exists)
- [ ] `/terms` — Terms of Service page (linked in Footer, no page exists)
- [ ] `/blog` or `/resources` — No content hub
- [ ] `/case-studies/[slug]` — Individual case study detail pages
- [ ] `/services/[slug]` — Individual service detail pages
- [ ] `404` custom error page
- [ ] `500` custom error page

### Features

- [ ] **Database** — Content stored in a flat JSON file; no real DB (PostgreSQL, MongoDB, etc.)
- [ ] **User authentication** — Admin access is a single shared static key; no user accounts, sessions, or JWT
- [ ] **Image upload** — Admin can only enter image URLs; no file upload to storage
- [ ] **Email queue / retry** — Emails sent synchronously; no queue, no retry on failure
- [ ] **Email verification** — No confirmation on contact form submissions
- [ ] **Dark mode** — No theme toggle implemented
- [ ] **Internationalization (i18n)** — English only, no i18n setup
- [ ] **Rate limiting** — No rate limiting on any API endpoint (contact, chat, admin)
- [ ] **API logging** — No request logging or monitoring middleware
- [ ] **Analytics** — No Google Analytics, Plausible, or similar
- [ ] **Sitemap / robots.txt** — Not generated
- [ ] **OpenGraph / social meta tags** — Basic metadata only; no og:image
- [ ] **Cookie consent banner** — Missing (required for GDPR in EU)
- [ ] **Error boundary** — No React error boundaries in the frontend
- [ ] **Loading states** — Content flashes on page load before API returns (no skeleton/placeholder)
- [ ] **Real AI chatbot** — Chatbot is regex-only; no LLM integration
- [ ] **Spam protection** — No reCAPTCHA or honeypot on any form
- [ ] **CI/CD pipeline** — No GitHub Actions workflows

### Infrastructure

- [ ] **Dockerfile / docker-compose** — No containerization
- [ ] **API rate limiting middleware** — Open to abuse
- [ ] **Helmet.js** — No HTTP security headers on NestJS
- [ ] **CORS tightening** — Single origin hardcoded; no multi-env handling
- [ ] **Secret rotation** — No mechanism for rotating ADMIN_KEY
- [ ] **Backup for site-content.json** — No automated backup of persisted content

---

## 10. Known Issues & Gaps

| Area | Issue | Severity |
|------|-------|----------|
| Security | `ADMIN_KEY` defaults to `dev-admin-change-me` — easily forgotten in prod | High |
| Security | No rate limiting on `/api/contact` — open to email spam | Medium |
| Security | No rate limiting on `/api/admin/content` — brute-forceable | Medium |
| Security | No HTTP security headers (Helmet not configured in NestJS) | Medium |
| Data | `site-content.json` lost if container/server restarts (no persistent volume) | High |
| Data | Default content is duplicated in both `web/src/lib/siteContent.ts` and `api/src/content/default-content.ts` — can drift | Medium |
| UX | Content flashes on load — no loading skeleton while API fetches | Low |
| UX | Footer links to `/privacy` and `/terms` that don't exist — broken links | Low |
| SEO | No `sitemap.xml` or `robots.txt` | Low |
| SEO | No `og:image` meta tag for social sharing previews | Low |
| Email | SMTP config duplicated across `web/.env` and `api/.env` | Low |
| Email | Next.js `/api/contact` and NestJS `/api/contact` serve same purpose — redundant | Low |
| Chat | Chatbot responses are hardcoded regex strings — not maintainable at scale | Low |
| Images | Only Unsplash allowed in next.config.ts — custom image hosting domains blocked | Low |
