import { Injectable } from "@nestjs/common";
import { BlogService } from "../blog/blog.service";
import { PortfolioService } from "../portfolio/portfolio.service";

@Injectable()
export class SitemapService {
  constructor(
    private readonly blog: BlogService,
    private readonly portfolio: PortfolioService,
  ) {}

  async generate(): Promise<string> {
    const base = process.env.SITE_URL ?? "https://pulselyft.com";

    const staticRoutes = [
      { loc: "/", priority: "1.0", changefreq: "weekly" },
      { loc: "/#services", priority: "0.8", changefreq: "monthly" },
      { loc: "/#work", priority: "0.8", changefreq: "monthly" },
      { loc: "/#process", priority: "0.7", changefreq: "monthly" },
      { loc: "/#testimonials", priority: "0.7", changefreq: "monthly" },
      { loc: "/#contact", priority: "0.9", changefreq: "monthly" },
      { loc: "/blog", priority: "0.8", changefreq: "daily" },
    ];

    const posts = await this.blog.listPublished();
    const cases = await this.portfolio.listPublished();

    const postRoutes = posts.map((p) => ({
      loc: `/blog/${p.slug}`,
      lastmod: p.updatedAt.slice(0, 10),
      priority: "0.7",
      changefreq: "monthly" as const,
    }));

    const caseRoutes = cases.map((c) => ({
      loc: `/case-studies/${c.slug}`,
      lastmod: c.updatedAt.slice(0, 10),
      priority: "0.8",
      changefreq: "monthly" as const,
    }));

    const allRoutes: Array<{ loc: string; lastmod?: string; priority: string; changefreq: string }> = [
      ...staticRoutes,
      ...postRoutes,
      ...caseRoutes,
    ];

    const urls = allRoutes
      .map((r) =>
        [
          "  <url>",
          `    <loc>${base}${r.loc}</loc>`,
          r.lastmod ? `    <lastmod>${r.lastmod}</lastmod>` : "",
          `    <changefreq>${r.changefreq}</changefreq>`,
          `    <priority>${r.priority}</priority>`,
          "  </url>",
        ]
          .filter(Boolean)
          .join("\n"),
      )
      .join("\n");

    return [
      '<?xml version="1.0" encoding="UTF-8"?>',
      '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
      urls,
      "</urlset>",
    ].join("\n");
  }
}
