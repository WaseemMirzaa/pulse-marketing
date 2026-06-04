import { Body, Controller, Get, Post, UseGuards } from "@nestjs/common";
import { Throttle } from "@nestjs/throttler";
import { LeadDto } from "./lead.dto";
import { LeadsService } from "./leads.service";
import { AdminKeyGuard } from "../content/admin-key.guard";

@Controller("api/leads")
export class LeadsController {
  constructor(private readonly leads: LeadsService) {}

  @Post()
  @Throttle({ short: { limit: 3, ttl: 60_000 }, medium: { limit: 10, ttl: 3_600_000 } })
  capture(@Body() dto: LeadDto) {
    return this.leads.capture(dto);
  }

  @Get()
  @UseGuards(AdminKeyGuard)
  async list(): Promise<unknown[]> {
    return this.leads.list();
  }
}
