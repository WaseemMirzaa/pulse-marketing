"use client";

import Image from "next/image";
import { useSiteContent } from "@/context/SiteContentProvider";

const LAYOUT = [
  { span: "lg:col-span-2 lg:row-span-2", accent: "from-lift-soft/80 to-paper" },
  { span: "lg:col-span-1 lg:col-start-3 lg:row-start-1", accent: "from-indigo-50 to-paper" },
  { span: "lg:col-span-1 lg:col-start-3 lg:row-start-2", accent: "from-emerald-50 to-paper" },
  { span: "lg:col-span-3 lg:row-start-3", accent: "from-amber-50 to-paper" },
] as const;

const FALLBACK_IMG =
  "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=900&q=85";

export function Services() {
  const { content } = useSiteContent();
  const s = content.services;
  const items = s.items.slice(0, 4);

  return (
    <section id="services" className="scroll-mt-24 py-24 sm:py-32">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <div className="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
          <div className="max-w-2xl">
            <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">{s.kicker}</p>
            <h2 className="mt-4 font-display text-4xl font-medium leading-tight tracking-tight text-ink sm:text-5xl text-balance">
              {s.title}
            </h2>
          </div>
          <p className="max-w-md text-base leading-relaxed text-zinc-600 lg:text-right">{s.intro}</p>
        </div>
        <ul className="mt-16 grid auto-rows-fr gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:grid-rows-2">
          {items.map((item, idx) => {
            const layout = LAYOUT[idx] ?? LAYOUT[0];
            const img = item.img || FALLBACK_IMG;
            return (
              <li
                key={`${item.title}-${idx}`}
                className={`group relative overflow-hidden rounded-2xl border border-zinc-200/90 bg-gradient-to-br ${layout.accent} shadow-card transition hover:border-zinc-300 hover:shadow-lg ${layout.span}`}
              >
                <div className="absolute inset-0">
                  <Image
                    src={img}
                    alt=""
                    fill
                    className="object-cover opacity-[0.18] transition duration-500 group-hover:scale-105 group-hover:opacity-[0.28]"
                    sizes="(max-width: 1024px) 50vw, 33vw"
                    unoptimized
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-paper via-paper/92 to-paper/75" />
                </div>
                <div className="relative flex h-full min-h-[180px] flex-col justify-end p-8 sm:min-h-[200px] sm:p-9">
                  <span className="absolute right-6 top-6 font-display text-6xl font-medium leading-none text-zinc-900/[0.06] transition group-hover:text-zinc-900/[0.09]">
                    {String(idx + 1).padStart(2, "0")}
                  </span>
                  <div className="mb-5 h-px w-10 bg-gradient-to-r from-lift to-lift-bright/60 opacity-90" />
                  <h3 className="font-display text-xl font-medium text-ink sm:text-2xl">{item.title}</h3>
                  <p className="mt-3 max-w-prose text-sm leading-relaxed text-zinc-600">{item.body}</p>
                </div>
              </li>
            );
          })}
        </ul>
      </div>
    </section>
  );
}
