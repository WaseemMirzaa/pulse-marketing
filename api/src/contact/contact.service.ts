import { Injectable, ServiceUnavailableException } from "@nestjs/common";
import nodemailer from "nodemailer";
import { ContactDto } from "./contact.dto";

@Injectable()
export class ContactService {
  private smtpReady() {
    return Boolean(
      process.env.SMTP_HOST &&
        process.env.SMTP_USER &&
        process.env.SMTP_PASS &&
        process.env.CONTACT_TO_EMAIL,
    );
  }

  async submit(dto: ContactDto) {
    if (!this.smtpReady()) {
      console.warn("[contact] SMTP not configured");
      throw new ServiceUnavailableException(
        "Email is not configured. Set SMTP_HOST, SMTP_USER, SMTP_PASS, CONTACT_TO_EMAIL on the API.",
      );
    }

    const port = Number(process.env.SMTP_PORT ?? 587);
    const secure = process.env.SMTP_SECURE === "true" || port === 465;

    const transporter = nodemailer.createTransport({
      host: process.env.SMTP_HOST,
      port,
      secure,
      auth: { user: process.env.SMTP_USER, pass: process.env.SMTP_PASS },
    });

    const to = process.env.CONTACT_TO_EMAIL!;
    const from = process.env.CONTACT_FROM_EMAIL ?? process.env.SMTP_USER;
    const companyLine = dto.company ? `\nCompany: ${dto.company}` : "";

    await transporter.sendMail({
      from,
      to,
      replyTo: dto.email,
      subject: `PulseLyft inquiry — ${dto.name}`,
      text: `Name: ${dto.name}\nEmail: ${dto.email}${companyLine}\n\n${dto.message}`,
    });

    return { received: true, id: `inq_${Date.now()}` };
  }
}
