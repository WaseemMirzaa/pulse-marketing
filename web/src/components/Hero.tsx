"use client";

import Image from "next/image";
import Link from "next/link";
import { useSiteContent } from "@/context/SiteContentProvider";

export function Hero() {
  const { content } = useSiteContent();
  const h = content.hero;

  return (
    <section className="relative min-h-[100svh] pt-[4.25rem]">
      <div className="pointer-events-none absolute inset-0 bg-mesh" />
      <div
        className="pointer-events-none absolute inset-0 opacity-50 bg-grid-fade bg-[length:64px_64px]"
        style={{ backgroundPosition: "center top" }}
      />
      <div className="relative mx-auto flex max-w-6xl flex-col gap-14 px-4 pb-20 pt-12 sm:px-6 sm:pt-16 lg:min-h-[calc(100svh-4.25rem)] lg:flex-row lg:items-center lg:gap-16 lg:pb-24">
        <div className="max-w-xl flex-1 lg:max-w-none lg:pr-8">
          <p className="animate-fade-up opacity-0 mb-6 inline-flex items-center gap-2 rounded-full border border-zinc-200/90 bg-paper/90 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-zinc-500 shadow-sm [animation-delay:0.05s]">
            <span className="h-1.5 w-1.5 rounded-full bg-lift-bright shadow-lift" aria-hidden />
            {h.badge}
          </p>
          <h1 className="animate-fade-up opacity-0 font-display text-[2.65rem] font-medium leading-[1.02] tracking-tight text-ink text-balance sm:text-5xl lg:text-[3.5rem] xl:text-[3.85rem] [animation-delay:0.12s]">
            {h.headlineBefore}{" "}
            <span className="italic text-zinc-600">{h.headlineItalic}</span> {h.headlineAfter}
          </h1>
          <p className="animate-fade-up opacity-0 mt-6 max-w-lg text-lg leading-relaxed text-zinc-600 [animation-delay:0.2s]">
            {h.sub}
          </p>
          <div className="animate-fade-up opacity-0 mt-10 flex flex-wrap items-center gap-4 [animation-delay:0.28s]">
            <Link
              href="#book-call"
              className="inline-flex items-center justify-center rounded-full bg-ink px-8 py-3.5 text-sm font-semibold text-white shadow-card transition hover:bg-zinc-800"
            >
              {h.primaryCta}
            </Link>
            <Link
              href="#work"
              className="inline-flex items-center gap-2 rounded-full border border-zinc-300 bg-paper px-8 py-3.5 text-sm font-semibold text-ink shadow-sm transition hover:border-zinc-400 hover:bg-zinc-50"
            >
              {h.secondaryCta}
              <span aria-hidden className="text-lift">
                →
              </span>
            </Link>
          </div>
          <dl className="animate-fade-up opacity-0 mt-14 grid grid-cols-3 gap-6 border-t border-zinc-200/90 pt-10 [animation-delay:0.36s]">
            {h.stats.slice(0, 3).map((s) => (
              <div key={s.label}>
                <dt className="sr-only">{s.label}</dt>
                <dd className="font-display text-2xl font-medium text-ink sm:text-3xl">{s.value}</dd>
                <dd className="mt-1 text-[11px] uppercase tracking-wider text-zinc-500">{s.label}</dd>
              </div>
            ))}
          </dl>
        </div>
        <div className="relative w-full flex-1 lg:max-w-xl xl:max-w-none">
          <div className="animate-float relative aspect-[4/5] overflow-hidden rounded-[1.75rem] border border-zinc-200/90 bg-zinc-100 shadow-card ring-1 ring-black/[0.03] sm:aspect-[5/6] lg:ml-auto lg:aspect-[3/4] lg:max-w-md xl:max-w-lg">
            <Image
              src={h.heroImage}
              alt={h.heroImageAlt}
              fill
              className="object-cover"
              sizes="(max-width: 1024px) 100vw, 40vw"
              priority
              unoptimized
            />
            <div className="absolute inset-0 bg-gradient-to-t from-ink/55 via-ink/5 to-transparent" />
            <div className="absolute inset-0 bg-gradient-to-br from-lift-soft/30 via-transparent to-indigo-500/10" />
            <div className="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
              <div className="rounded-2xl border border-white/20 bg-paper/95 p-5 shadow-card backdrop-blur-md">
                <p className="text-[11px] font-semibold uppercase tracking-[0.2em] text-zinc-500">
                  {h.floatCard.kicker}
                </p>
                <p className="mt-2 font-display text-2xl text-ink">{h.floatCard.title}</p>
                <p className="mt-1 text-sm text-zinc-600">{h.floatCard.body}</p>
              </div>
            </div>
          </div>
          <div className="pointer-events-none absolute -right-4 -top-4 hidden h-24 w-24 rounded-2xl border border-lift/25 bg-lift-soft/40 blur-sm lg:block" />
        </div>
      </div>
    </section>
  );
}
