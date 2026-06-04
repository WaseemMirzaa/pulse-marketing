import { Body, Controller, Post } from "@nestjs/common";
import { Throttle } from "@nestjs/throttler";
import { ContactDto } from "./contact.dto";
import { ContactService } from "./contact.service";

@Controller("api/contact")
export class ContactController {
  constructor(private readonly contact: ContactService) {}

  @Post()
  @Throttle({ short: { limit: 2, ttl: 60_000 }, medium: { limit: 5, ttl: 3_600_000 } })
  submit(@Body() dto: ContactDto) {
    return this.contact.submit(dto);
  }
}
