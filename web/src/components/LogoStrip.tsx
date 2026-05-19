"use client";

import { useSiteContent } from "@/context/SiteContentProvider";

export function LogoStrip() {
  const { content } = useSiteContent();
  const brands = content.logos.brands;
  const track = [...brands, ...brands];

  return (
    <section
      className="relative border-y border-zinc-200/90 bg-paper py-8 shadow-[inset_0_1px_0_rgba(255,255,255,0.8)]"
      aria-label="Trusted by"
    >
      <div className="pointer-events-none absolute inset-y-0 left-0 z-10 w-24 bg-gradient-to-r from-paper to-transparent" />
      <div className="pointer-events-none absolute inset-y-0 right-0 z-10 w-24 bg-gradient-to-l from-paper to-transparent" />
      <p className="mb-6 text-center text-[11px] font-semibold uppercase tracking-[0.28em] text-zinc-400">
        {content.logos.line}
      </p>
      <div className="relative overflow-hidden">
        <div className="flex w-max animate-marquee items-center gap-16 pr-16">
          {track.map((b, i) => (
            <span
              key={`${b}-${i}`}
              className="whitespace-nowrap font-display text-xl font-semibold text-zinc-400 transition hover:text-zinc-600"
            >
              {b}
            </span>
          ))}
        </div>
      </div>
    </section>
  );
}
