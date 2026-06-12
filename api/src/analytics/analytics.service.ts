import { Injectable, Logger } from "@nestjs/common";
import { readJson, writeJson } from "../shared/store";
import { TrackEventDto, EventName } from "./analytics.dto";

interface Event {
  id: string;
  event: EventName;
  page?: string;
  props?: Record<string, unknown>;
  sessionId?: string;
  ip?: string;
  ts: string;
}

interface DailySummary {
  date: string;
  pageViews: number;
  uniqueSessions: number;
  events: Partial<Record<EventName, number>>;
}

const EVENTS_FILE = "analytics-events.json";
const SUMMARY_FILE = "analytics-summary.json";
const MAX_EVENTS = 50_000;

@Injectable()
export class AnalyticsService {
  private readonly logger = new Logger(AnalyticsService.name);

  async track(dto: TrackEventDto, ip?: string): Promise<{ ok: boolean }> {
    try {
      const events = await readJson<Event[]>(EVENTS_FILE, []);
      const ev: Event = {
        id: `ev_${Date.now()}_${Math.random().toString(36).slice(2, 5)}`,
        event: dto.event,
        page: dto.page,
        props: dto.props,
        sessionId: dto.sessionId,
        ip: ip ? this.hashIp(ip) : undefined,
        ts: new Date().toISOString(),
      };

      // Keep last MAX_EVENTS only
      const next = [...events.slice(-MAX_EVENTS + 1), ev];
      await writeJson(EVENTS_FILE, next);
      await this.updateSummary(ev);
    } catch (err) {
      this.logger.warn(`Analytics write failed: ${(err as Error).message}`);
    }
    return { ok: true };
  }

  async getSummary(days = 30): Promise<DailySummary[]> {
    const summary = await readJson<DailySummary[]>(SUMMARY_FILE, []);
    const cutoff = new Date();
    cutoff.setDate(cutoff.getDate() - days);
    return summary
      .filter((s) => new Date(s.date) >= cutoff)
      .sort((a, b) => a.date.localeCompare(b.date));
  }

  async getRawEvents(limit = 500): Promise<Event[]> {
    const events = await readJson<Event[]>(EVENTS_FILE, []);
    return events.slice(-limit).reverse();
  }

  async getTotals(): Promise<Record<string, number>> {
    const summary = await readJson<DailySummary[]>(SUMMARY_FILE, []);
    const totals: Record<string, number> = { pageViews: 0 };
    for (const day of summary) {
      totals.pageViews += day.pageViews;
      for (const [ev, count] of Object.entries(day.events)) {
        totals[ev] = (totals[ev] ?? 0) + (count ?? 0);
      }
    }
    return totals;
  }

  private async updateSummary(ev: Event): Promise<void> {
    const summary = await readJson<DailySummary[]>(SUMMARY_FILE, []);
    const date = ev.ts.slice(0, 10);

    let day = summary.find((s) => s.date === date);
    if (!day) {
      day = { date, pageViews: 0, uniqueSessions: 0, events: {} };
      summary.push(day);
    }

    if (ev.event === "page_view") day.pageViews++;
    day.events[ev.event] = (day.events[ev.event] ?? 0) + 1;

    await writeJson(SUMMARY_FILE, summary);
  }

  private hashIp(ip: string): string {
    // One-way hash — not storing raw IPs
    let h = 0;
    for (let i = 0; i < ip.length; i++) {
      h = (Math.imul(31, h) + ip.charCodeAt(i)) | 0;
    }
    return Math.abs(h).toString(16);
  }
}
