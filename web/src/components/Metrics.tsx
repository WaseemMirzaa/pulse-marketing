"use client";

import { useSiteContent } from "@/context/SiteContentProvider";

export function Metrics() {
  const { content } = useSiteContent();
  const m = content.metrics;

  return (
    <section className="relative overflow-hidden border-y border-zinc-200/90 bg-paper py-24 sm:py-28">
      <div className="pointer-events-none absolute inset-0 bg-mesh opacity-40" />
      <div className="relative mx-auto max-w-6xl px-4 sm:px-6">
        <div className="grid gap-16 lg:grid-cols-12 lg:items-end lg:gap-10">
          <div className="lg:col-span-5">
            <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-zinc-500">{m.kicker}</p>
            <h2 className="mt-4 font-display text-4xl font-medium leading-tight tracking-tight text-ink text-balance sm:text-5xl">
              {m.title}
            </h2>
            <p className="mt-5 text-zinc-600 leading-relaxed">{m.body}</p>
          </div>
          <div className="grid grid-cols-2 gap-6 sm:gap-8 lg:col-span-7 lg:grid-cols-2">
            {m.stats.map((st) => (
              <div
                key={st.label}
                className="rounded-2xl border border-zinc-200/90 bg-page/80 p-6 shadow-card backdrop-blur-sm sm:p-8"
              >
                <p className="font-display text-4xl font-medium tabular-nums text-lift sm:text-5xl">{st.value}</p>
                <p className="mt-2 text-[13px] font-medium uppercase tracking-wider text-zinc-500">{st.label}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
