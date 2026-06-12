import { Controller, Get, Header, Res } from "@nestjs/common";
import { SkipThrottle } from "@nestjs/throttler";
import { Response } from "express";
import { SitemapService } from "./sitemap.service";

@Controller()
@SkipThrottle()
export class SitemapController {
  constructor(private readonly sitemap: SitemapService) {}

  @Get("sitemap.xml")
  @Header("Content-Type", "application/xml")
  async xml(@Res() res: Response) {
    const xml = await this.sitemap.generate();
    res.send(xml);
  }

  @Get("robots.txt")
  @Header("Content-Type", "text/plain")
  robots(@Res() res: Response) {
    const base = process.env.SITE_URL ?? "https://pulselyft.com";
    res.send(
      [
        "User-agent: *",
        "Allow: /",
        "",
        `Sitemap: ${base}/sitemap.xml`,
      ].join("\n"),
    );
  }
}
