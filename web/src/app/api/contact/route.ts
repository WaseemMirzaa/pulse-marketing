import { NextResponse } from "next/server";
import { sendContactEmail } from "@/lib/sendContactEmail";

export async function POST(req: Request) {
  let body: unknown;
  try {
    body = await req.json();
  } catch {
    return NextResponse.json({ error: "Invalid JSON" }, { status: 400 });
  }

  const { name, email, company, message } = body as Record<string, string>;
  if (!name?.trim() || !email?.trim() || !message?.trim()) {
    return NextResponse.json({ error: "Name, email, and message are required" }, { status: 400 });
  }

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    return NextResponse.json({ error: "Invalid email" }, { status: 400 });
  }

  const result = await sendContactEmail({
    name: name.trim().slice(0, 120),
    email: email.trim().slice(0, 200),
    company: company?.trim().slice(0, 120),
    message: message.trim().slice(0, 4000),
  });

  if (!result.sent) {
    return NextResponse.json(
      {
        error:
          "Email is not configured on the server. Set SMTP_HOST, SMTP_USER, SMTP_PASS, and CONTACT_TO_EMAIL.",
      },
      { status: 503 },
    );
  }

  return NextResponse.json({ received: true, id: `inq_${Date.now()}` });
}
