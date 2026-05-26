import nodemailer from "nodemailer";

export type ContactPayload = {
  name: string;
  email: string;
  company?: string;
  message: string;
};

function smtpConfigured() {
  return Boolean(
    process.env.SMTP_HOST &&
      process.env.SMTP_USER &&
      process.env.SMTP_PASS &&
      process.env.CONTACT_TO_EMAIL,
  );
}

export async function sendContactEmail(payload: ContactPayload): Promise<{ sent: boolean; reason?: string }> {
  if (!smtpConfigured()) {
    console.warn("[contact] SMTP not configured — set SMTP_HOST, SMTP_USER, SMTP_PASS, CONTACT_TO_EMAIL");
    return { sent: false, reason: "smtp_not_configured" };
  }

  const port = Number(process.env.SMTP_PORT ?? 587);
  const secure = process.env.SMTP_SECURE === "true" || port === 465;

  const transporter = nodemailer.createTransport({
    host: process.env.SMTP_HOST,
    port,
    secure,
    auth: {
      user: process.env.SMTP_USER,
      pass: process.env.SMTP_PASS,
    },
  });

  const to = process.env.CONTACT_TO_EMAIL!;
  const from =
    process.env.CONTACT_FROM_EMAIL ?? process.env.SMTP_USER ?? "noreply@pulselyft.com";

  const companyLine = payload.company ? `\nCompany: ${payload.company}` : "";

  await transporter.sendMail({
    from,
    to,
    replyTo: payload.email,
    subject: `PulseLyft inquiry — ${payload.name}`,
    text: `Name: ${payload.name}\nEmail: ${payload.email}${companyLine}\n\n${payload.message}`,
    html: `
      <p><strong>Name:</strong> ${escapeHtml(payload.name)}</p>
      <p><strong>Email:</strong> <a href="mailto:${escapeHtml(payload.email)}">${escapeHtml(payload.email)}</a></p>
      ${payload.company ? `<p><strong>Company:</strong> ${escapeHtml(payload.company)}</p>` : ""}
      <p><strong>Message:</strong></p>
      <p style="white-space:pre-wrap">${escapeHtml(payload.message)}</p>
    `,
  });

  return { sent: true };
}

function escapeHtml(s: string) {
  return s
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;");
}
