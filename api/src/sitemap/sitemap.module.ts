import { Module } from "@nestjs/common";
import { SitemapController } from "./sitemap.controller";
import { SitemapService } from "./sitemap.service";
import { BlogModule } from "../blog/blog.module";
import { PortfolioModule } from "../portfolio/portfolio.module";

@Module({
  imports: [BlogModule, PortfolioModule],
  controllers: [SitemapController],
  providers: [SitemapService],
})
export class SitemapModule {}
