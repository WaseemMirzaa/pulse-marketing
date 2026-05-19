import { Body, Controller, Post } from "@nestjs/common";
import { ContactDto } from "./contact.dto";
import { ContactService } from "./contact.service";

@Controller("api/contact")
export class ContactController {
  constructor(private readonly contact: ContactService) {}

  @Post()
  submit(@Body() dto: ContactDto) {
    return this.contact.submit(dto);
  }
}
