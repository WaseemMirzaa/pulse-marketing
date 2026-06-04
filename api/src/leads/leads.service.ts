import { Injectable, Logger } from "@nestjs/common";
import { promises as fs } from "fs";
import * as path from "path";
import { LeadDto } from "./lead.dto";

interface Lead {
  id: string;
  email: string;
  name?: string;
  company?: string;
  source?: string;
  createdAt: string;
}

@Injectable()
export class LeadsService {
  private readonly logger = new Logger(LeadsService.name);
  private readonly filePath = path.join(__dirname, "..", "..", "data", "leads.json");

  private id(): string {
    return `lead_${Date.now()}_${Math.random().toString(36).slice(2, 7)}`;
  }

  private async readAll(): Promise<Lead[]> {
    try {
      const raw = await fs.readFile(this.filePath, "utf8");
      return JSON.parse(raw) as Lead[];
    } catch {
      return [];
    }
  }

  async capture(dto: LeadDto): Promise<{ ok: boolean; id: string }> {
    const leads = await this.readAll();

    // Deduplicate by email
    const exists = leads.some((l) => l.email.toLowerCase() === dto.email.toLowerCase());
    if (exists) {
      this.logger.log(`Lead already exists: ${dto.email}`);
      const existing = leads.find((l) => l.email.toLowerCase() === dto.email.toLowerCase())!;
      return { ok: true, id: existing.id };
    }

    const lead: Lead = {
      id: this.id(),
      email: dto.email,
      name: dto.name,
      company: dto.company,
      source: dto.source ?? "website",
      createdAt: new Date().toISOString(),
    };

    leads.push(lead);
    await fs.mkdir(path.dirname(this.filePath), { recursive: true });
    await fs.writeFile(this.filePath, JSON.stringify(leads, null, 2), "utf8");
    this.logger.log(`New lead captured: ${lead.email} (${lead.id})`);

    // Optionally notify via email
    await this.notifyIfConfigured(lead);

    return { ok: true, id: lead.id };
  }

  async list(): Promise<Lead[]> {
    return this.readAll();
  }

  private async notifyIfConfigured(lead: Lead): Promise<void> {
    if (!process.env.SMTP_HOST || !process.env.CONTACT_TO_EMAIL) return;
    try {
      const nodemailer = await import("nodemailer");
      const port = Number(process.env.SMTP_PORT ?? 587);
      const secure = process.env.SMTP_SECURE === "true" || port === 465;
      const transporter = nodemailer.default.createTransport({
        host: process.env.SMTP_HOST,
        port,
        secure,
        auth: { user: process.env.SMTP_USER, pass: process.env.SMTP_PASS },
      });
      const from = process.env.CONTACT_FROM_EMAIL ?? process.env.SMTP_USER;
      const companyLine = lead.company ? `\nCompany: ${lead.company}` : "";
      await transporter.sendMail({
        from,
        to: process.env.CONTACT_TO_EMAIL,
        subject: `New lead — ${lead.email}`,
        text: `Email: ${lead.email}\nName: ${lead.name ?? "—"}${companyLine}\nSource: ${lead.source ?? "website"}\nTime: ${lead.createdAt}`,
      });
    } catch (err) {
      this.logger.warn(`Lead email notification failed: ${(err as Error).message}`);
    }
  }
}
