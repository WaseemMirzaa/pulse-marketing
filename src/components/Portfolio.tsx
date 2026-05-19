"use client";

import Image from "next/image";
import Link from "next/link";
import { useSiteContent } from "@/context/SiteContentProvider";

export function Portfolio() {
  const { content } = useSiteContent();
  const p = content.portfolio;
  const items = p.items.length ? p.items : [];

  return (
    <section id="portfolio" className="scroll-mt-24 border-y border-zinc-200/90 bg-paper py-24 sm:py-32">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <div className="flex flex-col justify-between gap-8 sm:flex-row sm:items-end">
          <div>
            <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">{p.kicker}</p>
            <h2 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl text-balance">
              {p.title}
            </h2>
            <p className="mt-4 max-w-xl text-zinc-600 leading-relaxed">{p.intro}</p>
          </div>
          <Link
            href="#contact"
            className="inline-flex w-fit items-center gap-2 rounded-full border border-zinc-300 bg-page px-6 py-3 text-sm font-semibold text-ink shadow-sm transition hover:border-lift/50"
          >
            {p.cta}
            <span aria-hidden>→</span>
          </Link>
        </div>
        <ul className="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          {items.map((piece) => (
            <li key={piece.title}>
              <Link
                href={piece.href || "#contact"}
                className="group block overflow-hidden rounded-2xl border border-zinc-200/90 bg-page shadow-card transition hover:border-zinc-300 hover:shadow-lg"
              >
                <div className="relative aspect-[4/5] overflow-hidden bg-zinc-100">
                  <Image
                    src={piece.img}
                    alt=""
                    fill
                    className="object-cover transition duration-500 group-hover:scale-105"
                    sizes="(max-width: 640px) 100vw, 25vw"
                    unoptimized
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-ink/50 to-transparent opacity-80 transition group-hover:opacity-90" />
                  <div className="absolute bottom-0 left-0 right-0 p-4">
                    <p className="text-[10px] font-semibold uppercase tracking-[0.2em] text-lift-bright">
                      {piece.category}
                    </p>
                    <p className="mt-1 font-display text-lg font-medium text-white">{piece.title}</p>
                  </div>
                </div>
              </Link>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
