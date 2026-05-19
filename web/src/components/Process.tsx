"use client";

import { useSiteContent } from "@/context/SiteContentProvider";

export function Process() {
  const { content } = useSiteContent();
  const p = content.process;

  return (
    <section id="process" className="scroll-mt-24 bg-paper py-24 sm:py-32">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-zinc-500">{p.kicker}</p>
        <h2 className="mt-4 max-w-3xl font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl text-balance">
          {p.title}
        </h2>
        <p className="mt-4 max-w-2xl text-zinc-600 leading-relaxed">{p.intro}</p>
        <div className="relative mt-20">
          <div
            className="pointer-events-none absolute left-0 right-0 top-8 hidden h-px bg-gradient-to-r from-transparent via-zinc-200 to-transparent md:block"
            aria-hidden
          />
          <ol className="grid gap-6 md:grid-cols-3 md:gap-8">
            {p.steps.map((s) => (
              <li
                key={s.n}
                className="relative rounded-2xl border border-zinc-200/90 bg-gradient-to-b from-zinc-50/80 to-paper p-8 pt-10 shadow-card"
              >
                <span className="absolute -top-3 left-8 flex h-7 w-7 items-center justify-center rounded-full border border-lift/30 bg-lift-soft text-xs font-bold text-lift">
                  {s.n}
                </span>
                <h3 className="mt-4 font-display text-xl font-medium text-ink">{s.title}</h3>
                <p className="mt-3 text-sm leading-relaxed text-zinc-600">{s.body}</p>
              </li>
            ))}
          </ol>
        </div>
      </div>
    </section>
  );
}
