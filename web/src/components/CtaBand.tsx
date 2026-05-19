"use client";

import Link from "next/link";
import { useSiteContent } from "@/context/SiteContentProvider";

export function CtaBand() {
  const { content } = useSiteContent();
  const c = content.cta;

  return (
    <section className="bg-paper py-20 sm:py-28">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <div className="relative overflow-hidden rounded-[2rem] border border-zinc-200/90 bg-gradient-to-br from-zinc-900 via-ink to-zinc-900 px-8 py-16 text-center shadow-card sm:px-16 sm:py-20">
          <div className="pointer-events-none absolute -left-20 top-0 h-64 w-64 rounded-full bg-lift-bright/25 blur-[100px]" />
          <div className="pointer-events-none absolute -right-16 bottom-0 h-56 w-56 rounded-full bg-indigo-400/20 blur-[90px]" />
          <p className="relative text-[11px] font-semibold uppercase tracking-[0.28em] text-lift-bright">{c.kicker}</p>
          <h2 className="relative mt-4 font-display text-3xl font-medium tracking-tight text-white text-balance sm:text-4xl lg:text-5xl">
            {c.title}
          </h2>
          <p className="relative mx-auto mt-5 max-w-lg text-zinc-300 leading-relaxed">{c.sub}</p>
          <Link
            href="#contact"
            className="relative mt-10 inline-flex rounded-full bg-lift-bright px-10 py-3.5 text-sm font-semibold text-ink shadow-lift transition hover:bg-white"
          >
            {c.button}
          </Link>
        </div>
      </div>
    </section>
  );
}
