export type BlogPost = {
  slug: string;
  title: string;
  excerpt: string;
  category: string;
  date: string;
  readTime: string;
  img: string;
  body: string[];
};

export const blogPosts: BlogPost[] = [
  {
    slug: "meta-ads-creative-testing-framework",
    title: "A creative testing framework that actually scales Meta spend",
    excerpt:
      "Most teams burn budget on random creative swaps. Here is a simple structure for hooks, angles, and kill rules that keeps CAC honest.",
    category: "Meta ads",
    date: "2026-05-12",
    readTime: "6 min read",
    img: "https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&q=85",
    body: [
      "Scaling Meta is rarely a bidding problem first—it is a creative throughput problem. When every new ad is a one-off, you cannot tell what actually moved CPL or MER.",
      "Start with three layers: hook (first 2 seconds), angle (promise + proof), and format (static, UGC, carousel). Test one layer at a time. Change the hook while holding angle and format constant for at least 48 hours of stable delivery.",
      "Set kill rules before launch: if CPA is 2× target after 1,000 impressions with no purchase signal, pause. If it wins, graduate to a scaling ad set with capped daily increases—never duplicate winners across five ad sets on day one.",
      "Document every test in a shared sheet: hypothesis, asset link, result, next action. That log becomes your creative playbook and cuts rework by half within a quarter.",
    ],
  },
  {
    slug: "seo-clusters-for-revenue-keywords",
    title: "SEO clusters built for revenue keywords—not vanity traffic",
    excerpt:
      "Intent-led content systems compound when technical foundations and internal linking work together. A practical cadence for B2B and DTC teams.",
    category: "SEO",
    date: "2026-04-28",
    readTime: "5 min read",
    img: "https://images.unsplash.com/photo-1432888498266-38ffec068eaf?w=1200&q=85",
    body: [
      "Traffic that does not map to pipeline is expensive decoration. Before writing, map money keywords to buyer stages: problem-aware, solution-aware, and vendor comparison.",
      "Build clusters around one pillar page per core offer. Each supporting article should answer a specific long-tail query and link back with descriptive anchor text—not “click here.”",
      "Ship technical fixes in the same sprint as content: crawl budget, canonicals, Core Web Vitals on templates, and schema on FAQs. Google rewards sites that feel maintained, not just published.",
      "Review rankings monthly but judge success on assisted conversions and demo requests from organic—not position alone.",
    ],
  },
  {
    slug: "attribution-leaders-trust",
    title: "Attribution your leadership team will actually trust",
    excerpt:
      "Server-side events, clean UTMs, and a single weekly dashboard beat twelve conflicting reports every time.",
    category: "Analytics",
    date: "2026-04-10",
    readTime: "4 min read",
    img: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=85",
    body: [
      "When finance and marketing disagree on numbers, growth stalls. The fix is not another tool—it is one source of truth with documented definitions.",
      "Standardize event names across Meta CAPI, GA4, and your CRM. Match on email hash or order ID where possible. Document what “lead” and “qualified lead” mean in writing.",
      "Build one weekly dashboard: spend, MER or ROAS, CAC, payback window, and pipeline influenced. Remove metrics that nobody acts on.",
      "Run a 30-minute review every Monday. Decisions beat dashboards when the same five people look at the same five numbers.",
    ],
  },
];

export function getPost(slug: string) {
  return blogPosts.find((p) => p.slug === slug);
}
