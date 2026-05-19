import { Body, Controller, Post } from "@nestjs/common";
import { ContactDto } from "./contact.dto";

@Controller("api/contact")
export class ContactController {
  @Post()
  submit(@Body() dto: ContactDto) {
    // Stub: log only; wire to email/CRM in production
    console.log("[contact]", dto.email, dto.name);
    return { received: true, id: `inq_${Date.now()}` };
  }
}
