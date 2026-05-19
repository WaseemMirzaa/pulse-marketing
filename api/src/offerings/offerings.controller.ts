import { Controller, Get } from "@nestjs/common";

const SERVICES = [
  {
    slug: "meta-ads",
    title: "Meta ads & paid social",
    summary: "Creative testing, account structure, and CAPI-led measurement.",
  },
  {
    slug: "performance-creative",
    title: "Performance creative",
    summary: "Hooks and angles built for conversion, not vanity awards.",
  },
  {
    slug: "seo",
    title: "SEO & content systems",
    summary: "Technical SEO, intent clusters, and compounding organic demand.",
  },
  {
    slug: "analytics",
    title: "Analytics & attribution",
    summary: "Event schemas, server-side tagging, and exec-ready reporting.",
  },
];

@Controller("api/services")
export class OfferingsController {
  @Get()
  list() {
    return { services: SERVICES };
  }
}
