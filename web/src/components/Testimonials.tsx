"use client";

import Image from "next/image";
import { useSiteContent } from "@/context/SiteContentProvider";

const FALLBACK_AVATAR =
  "https://images.unsplash.com/photo-1535711925020-d1d0cf377fde?w=150&h=150&fit=crop&q=85";

export function Testimonials() {
  const { content } = useSiteContent();
  const t = content.testimonials;
  const q0 = t.quotes[0];
  const q1 = t.quotes[1] ?? t.quotes[0];

  return (
    <section className="border-y border-zinc-200/90 bg-page py-24 sm:py-32">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-zinc-500">{t.kicker}</p>
        <h2 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl">{t.title}</h2>
        <div className="mt-16 grid gap-6 lg:grid-cols-5">
          <blockquote className="relative flex flex-col justify-between overflow-hidden rounded-2xl border border-zinc-200/90 bg-paper p-8 shadow-card sm:p-10 lg:col-span-3">
            <span
              className="font-display text-[120px] font-medium leading-none text-zinc-200 sm:text-[160px]"
              aria-hidden
            >
              “
            </span>
            <p className="-mt-16 font-display text-2xl font-normal leading-snug text-zinc-800 sm:text-3xl lg:-mt-20">
              {q0.quote}
            </p>
            <footer className="mt-10 flex items-center gap-4 border-t border-zinc-200/90 pt-6">
              <div className="relative h-12 w-12 shrink-0 overflow-hidden rounded-full ring-2 ring-lift-soft">
                <Image
                  src={q0.avatar || FALLBACK_AVATAR}
                  alt=""
                  fill
                  className="object-cover"
                  sizes="48px"
                  unoptimized
                />
              </div>
              <cite className="not-italic">
                <span className="font-semibold text-ink">{q0.name}</span>
                <span className="text-zinc-500"> — {q0.role}</span>
              </cite>
            </footer>
          </blockquote>
          <blockquote className="flex flex-col justify-between rounded-2xl border border-zinc-200/90 bg-gradient-to-br from-lift-soft/90 to-paper p-8 shadow-card sm:p-10 lg:col-span-2">
            <p className="text-lg leading-relaxed text-zinc-700">&ldquo;{q1.quote}&rdquo;</p>
            <footer className="mt-8 flex items-center gap-4">
              <div className="relative h-11 w-11 shrink-0 overflow-hidden rounded-full ring-2 ring-white/80">
                <Image
                  src={q1.avatar || FALLBACK_AVATAR}
                  alt=""
                  fill
                  className="object-cover"
                  sizes="44px"
                  unoptimized
                />
              </div>
              <cite className="not-italic">
                <span className="font-semibold text-ink">{q1.name}</span>
                <span className="text-zinc-500"> — {q1.role}</span>
              </cite>
            </footer>
          </blockquote>
        </div>
      </div>
    </section>
  );
}
