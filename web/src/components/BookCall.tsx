"use client";

import { useSiteContent } from "@/context/SiteContentProvider";
import { defaultSiteContent } from "@/lib/siteContent";

function embedUrl(raw: string) {
  const base = raw.trim();
  if (!base) return "https://calendly.com/thepulselyft/30min?embed=true";
  return base.includes("embed=true") ? base : `${base}${base.includes("?") ? "&" : "?"}embed=true`;
}

export function BookCall() {
  const { content } = useSiteContent();
  const b = content.bookCall ?? defaultSiteContent().bookCall;
  const envUrl = process.env.NEXT_PUBLIC_CALENDLY_URL?.trim();
  const url = embedUrl(envUrl || b.calendlyUrl);

  return (
    <section id="book-call" className="scroll-mt-24 border-y border-zinc-200/90 bg-paper py-24 sm:py-32">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <div className="grid gap-12 lg:grid-cols-12 lg:items-start">
          <div className="lg:col-span-4">
            <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">{b.kicker}</p>
            <h2 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl text-balance">
              {b.title}
            </h2>
            <p className="mt-5 text-zinc-600 leading-relaxed">{b.sub}</p>
            <ul className="mt-8 space-y-3 text-sm text-zinc-600">
              <li className="flex items-center gap-3">
                <span className="h-1.5 w-1.5 rounded-full bg-lift-bright ring-2 ring-lift-soft" />
                30-minute intro — no pitch deck required
              </li>
              <li className="flex items-center gap-3">
                <span className="h-1.5 w-1.5 rounded-full bg-lift-bright ring-2 ring-lift-soft" />
                Pick a time that works in your timezone
              </li>
            </ul>
          </div>
          <div className="overflow-hidden rounded-2xl border border-zinc-200/90 bg-page shadow-card lg:col-span-8">
            <iframe
              title="Book a call with PulseLift"
              src={url}
              className="min-h-[680px] w-full border-0 bg-white"
              loading="lazy"
            />
          </div>
        </div>
      </div>
    </section>
  );
}
