/** Mirrors web defaultSiteContent — merged on read/write. */
export const DEFAULT_SITE_CONTENT = {
  version: 1,
  hero: {
    badge: "Performance marketing studio",
    headlineBefore: "Revenue systems for brands that",
    headlineItalic: "refuse",
    headlineAfter: "to guess.",
    sub: "Meta ads, performance creative, and SEO engineered around pipeline and profit—not slides that age in a week.",
    primaryCta: "Start a project",
    secondaryCta: "View outcomes",
    heroImage: "https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1200&q=85",
    heroImageAlt: "Team collaborating in a modern studio",
    stats: [
      { value: "3.1×", label: "ROAS" },
      { value: "97%", label: "Retention" },
      { value: "$48M", label: "Managed" },
    ],
    floatCard: {
      kicker: "Live program signal",
      title: "Scale-ready in weeks",
      body: "Measurement, creative, and search—one operating rhythm.",
    },
  },
  logos: {
    line: "Trusted by teams shipping at scale",
    brands: ["Nimbus", "Vertex", "Lumen", "Northline", "Craft", "Helio", "Aperture", "Signal"],
  },
  services: {
    kicker: "Capabilities",
    title: "Full-funnel performance, orchestrated as one system",
    intro: "One senior squad across paid, creative, and search—aligned to CAC, payback, and LTV targets you already track.",
    items: [
      {
        title: "Meta ads & paid social",
        body: "Creative testing, account structure, and CAPI-led measurement so scaling spend does not scale waste.",
      },
      {
        title: "Performance creative",
        body: "Hooks, angles, and UGC-style packs engineered for thumb-stopping relevance—not awards-show reels.",
      },
      {
        title: "SEO & content systems",
        body: "Technical foundations, intent-led clusters, and internal linking that compound traffic over quarters.",
      },
      {
        title: "Analytics & attribution",
        body: "Clean event schemas, server-side tagging, and dashboards leadership actually uses in weekly reviews.",
      },
    ],
  },
  metrics: {
    kicker: "Evidence",
    title: "Numbers your CFO already asks for",
    body: "Benchmarks shift by category—we show ranges, not fairy tales. Portfolio blend across SaaS, DTC, and professional services.",
    stats: [
      { value: "$48M+", label: "Ad spend managed" },
      { value: "142%", label: "Median organic lift YoY" },
      { value: "4.2 wk", label: "Time to first scale test" },
      { value: "97%", label: "Client retention (24 mo.)" },
    ],
  },
  work: {
    kicker: "Selected work",
    title: "Outcomes, not mood boards",
    intro: "Representative engagements—anonymized where required. Every program pairs channel depth with ruthless prioritization.",
    cta: "Discuss a build",
    caseBody:
      "Strategy, build, and weekly iteration—so wins compound instead of resetting each quarter.",
    cases: [
      {
        title: "B2B SaaS pipeline rebuild",
        tag: "Meta + landing",
        result: "61% lower CPL in 90 days",
        img: "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&q=85",
        featured: true,
      },
      {
        title: "DTC omnichannel scale",
        tag: "Paid + lifecycle",
        result: "2.4× MER at same spend",
        img: "https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=900&q=85",
        featured: false,
      },
      {
        title: "Category SEO takeover",
        tag: "Technical + content",
        result: "Top 3 for 38 money keywords",
        img: "https://images.unsplash.com/photo-1432888498266-38ffec068eaf?w=900&q=85",
        featured: false,
      },
    ],
  },
  portfolio: {
    kicker: "Portfolio",
    title: "Recent ships & experiments",
    intro: "Swap images and copy here from the admin panel—use direct image URLs (e.g. Unsplash).",
    cta: "Start a similar build",
    items: [
      {
        title: "Lifecycle email redesign",
        category: "CRM · retention",
        img: "https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&q=85",
        href: "#contact",
      },
      {
        title: "Paid social creative pack",
        category: "Meta · performance creative",
        img: "https://images.unsplash.com/photo-1611162617474-5b21e879641f?w=800&q=85",
        href: "#contact",
      },
      {
        title: "Enterprise landing system",
        category: "CRO · landing",
        img: "https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800&q=85",
        href: "#contact",
      },
      {
        title: "Technical SEO migration",
        category: "SEO · engineering",
        img: "https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800&q=85",
        href: "#contact",
      },
    ],
  },
  process: {
    kicker: "Engagement",
    title: "How we plug into your team",
    intro: "Senior operators, async-first rituals, and reporting your execs open without prompting.",
    steps: [
      {
        n: "01",
        title: "Diagnose & benchmark",
        body: "Audit accounts, analytics, and SERP reality. Align on margin, payback, and guardrails before spend moves.",
      },
      {
        n: "02",
        title: "Ship the growth system",
        body: "Launch structured tests, SEO fixes, and tracking—documented in a living roadmap the whole team can see.",
      },
      {
        n: "03",
        title: "Compound weekly",
        body: "Creative velocity, query expansion, and bid/budget logic tuned in a tight feedback loop with your data.",
      },
    ],
  },
  testimonials: {
    kicker: "Social proof",
    title: "Partners on the record",
    quotes: [
      {
        quote:
          "They replaced three vendors. Our Meta account finally talks to our CRM—and finance trusts the numbers.",
        name: "Jordan M.",
        role: "VP Growth, Series B SaaS",
      },
      {
        quote:
          "SEO was a black box. Now we ship clusters on a cadence and see compounding sessions every quarter.",
        name: "Priya K.",
        role: "CMO, DTC wellness",
      },
    ],
  },
  cta: {
    kicker: "Next step",
    title: "Growth you can defend in a board meeting",
    sub: "Two-week discovery sprints, explicit milestones, and no mystery retainers.",
    button: "Book a strategy call",
  },
} as const;
