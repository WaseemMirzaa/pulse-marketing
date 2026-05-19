import { Body, Controller, Put, UseGuards } from "@nestjs/common";
import { ContentService } from "./content.service";
import { AdminKeyGuard } from "./admin-key.guard";

@Controller("api/admin")
@UseGuards(AdminKeyGuard)
export class AdminContentController {
  constructor(private readonly content: ContentService) {}

  @Put("content")
  async save(@Body() body: unknown) {
    return this.content.saveContent(body);
  }
}
