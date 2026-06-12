import { Body, Controller, Get, Ip, Post, Query, UseGuards } from "@nestjs/common";
import { SkipThrottle, Throttle } from "@nestjs/throttler";
import { AnalyticsService } from "./analytics.service";
import { TrackEventDto } from "./analytics.dto";
import { AdminKeyGuard } from "../content/admin-key.guard";

@Controller("api/analytics")
export class AnalyticsController {
  constructor(private readonly analytics: AnalyticsService) {}

  @Post("track")
  @Throttle({ short: { limit: 20, ttl: 10_000 }, medium: { limit: 200, ttl: 60_000 } })
  track(@Body() dto: TrackEventDto, @Ip() ip: string) {
    return this.analytics.track(dto, ip);
  }
}

@Controller("api/admin/analytics")
@UseGuards(AdminKeyGuard)
@SkipThrottle()
export class AdminAnalyticsController {
  constructor(private readonly analytics: AnalyticsService) {}

  @Get("summary")
  async summary(@Query("days") days?: string): Promise<unknown[]> {
    return this.analytics.getSummary(days ? Number(days) : 30);
  }

  @Get("totals")
  async totals(): Promise<Record<string, number>> {
    return this.analytics.getTotals();
  }

  @Get("events")
  async events(@Query("limit") limit?: string): Promise<unknown[]> {
    return this.analytics.getRawEvents(limit ? Number(limit) : 500);
  }
}
