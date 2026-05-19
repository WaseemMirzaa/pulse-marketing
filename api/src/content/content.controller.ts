import { Controller, Get } from "@nestjs/common";
import { ContentService } from "./content.service";

@Controller("api/content")
export class ContentController {
  constructor(private readonly content: ContentService) {}

  @Get()
  async get() {
    return this.content.readMerged();
  }
}
