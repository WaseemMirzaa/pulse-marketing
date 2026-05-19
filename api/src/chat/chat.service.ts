import { Injectable } from "@nestjs/common";

@Injectable()
export class ChatService {
  reply(userMessage: string): string {
    const m = userMessage.toLowerCase().trim();

    if (/hello|hi\b|hey\b|good (morning|afternoon|evening)/.test(m)) {
      return "Hi — I am the PulseLift assistant. Ask about Meta ads, SEO, pricing, or how to get in touch.";
    }
    if (/meta|facebook|instagram|paid social|ads\b/.test(m)) {
      return "We run Meta ads with structured creative testing, clean account architecture, and CAPI-friendly measurement. Want a fit call? Use the Contact section or say “contact”.";
    }
    if (/seo|search|organic|google/.test(m)) {
      return "Our SEO work covers technical foundations, intent-led content clusters, and internal linking so traffic compounds. Tell me your site type (B2B SaaS, DTC, etc.) for a sharper answer.";
    }
    if (/price|cost|budget|retainer|fee/.test(m)) {
      return "Engagements vary by scope—discovery sprints first, then milestone-based work. Share goals in the contact form and we will reply with a realistic range.";
    }
    if (/portfolio|work|case|client/.test(m)) {
      return "See the Work and Portfolio sections on this page for example outcomes. I can also summarize process—ask “how do you work?”.";
    }
    if (/process|how (do|you) work|engagement/.test(m)) {
      return "We diagnose, ship a growth system (paid + creative + SEO + tracking), then compound weekly with your data. Small senior squad, async-first.";
    }
    if (/book|call|calendly|schedule|meeting/.test(m)) {
      return "Use the Book a call section on the page to pick a time, or send a note via Contact—we typically reply within one business day.";
    }
    if (/contact|email|reach|form/.test(m)) {
      return "Use the Contact section to submit the form—we typically reply within one business day. You can also leave your question here and I will do my best.";
    }
    if (/who|about (you|pulselift)|team/.test(m)) {
      return "PulseLift is a performance marketing studio focused on measurable revenue—Meta ads, performance creative, and SEO.";
    }
    if (m.length < 4) {
      return "Could you add a bit more detail? For example: “Meta ads for B2B SaaS” or “SEO technical audit”.";
    }
    return (
      "Thanks for your message. For specifics on your stack, budgets, or timelines, the team answers fastest via the Contact form. " +
      "Meanwhile, try asking about Meta ads, SEO, pricing, or our process."
    );
  }
}
