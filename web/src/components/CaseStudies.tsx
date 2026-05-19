"use client";

import Image from "next/image";
import { useSiteContent } from "@/context/SiteContentProvider";

export function CaseStudies() {
  const { content } = useSiteContent();
  const w = content.work;
  const cases = w.cases;

  return (
    <section id="work" className="scroll-mt-24 bg-page py-24 sm:py-32">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <div className="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
          <div>
            <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">{w.kicker}</p>
            <h2 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl text-balance">
              {w.title}
            </h2>
            <p className="mt-4 max-w-xl text-zinc-600 leading-relaxed">{w.intro}</p>
          </div>
          <a
            href="#book-call"
            className="inline-flex w-fit items-center gap-2 rounded-full border border-zinc-300 bg-paper px-6 py-3 text-sm font-semibold text-ink shadow-sm transition hover:border-lift/50 hover:text-lift"
          >
            {w.cta}
            <span aria-hidden>→</span>
          </a>
        </div>
        <div className="mt-16 grid gap-4 lg:grid-cols-2">
          {cases.map((c) =>
            c.featured ? (
              <article
                key={c.title}
                className="group relative overflow-hidden rounded-2xl border border-zinc-200/90 bg-paper shadow-card transition hover:border-zinc-300 hover:shadow-lg lg:col-span-2 lg:flex lg:min-h-[380px]"
              >
                <div className="relative min-h-[280px] flex-1 lg:min-h-0">
                  <Image
                    src={c.img}
                    alt=""
                    fill
                    className="object-cover transition duration-700 group-hover:scale-[1.02]"
                    sizes="(max-width: 1024px) 100vw, 66vw"
                    unoptimized
                  />
                  <div className="absolute inset-0 bg-gradient-to-r from-ink/50 via-ink/15 to-transparent lg:via-ink/5" />
                  <div className="absolute left-0 top-0 p-6 sm:p-8">
                    <span className="inline-flex rounded-full border border-white/25 bg-paper/90 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-lift shadow-sm backdrop-blur">
                      {c.tag}
                    </span>
                  </div>
                </div>
                <div className="flex flex-1 flex-col justify-center border-t border-zinc-200/90 bg-paper p-8 lg:max-w-md lg:border-l lg:border-t-0 lg:pl-10">
                  <h3 className="font-display text-3xl font-medium text-ink">{c.title}</h3>
                  <p className="mt-3 text-xl font-medium text-lift">{c.result}</p>
                  <p className="mt-4 text-sm leading-relaxed text-zinc-600">{w.caseBody}</p>
                </div>
              </article>
            ) : (
              <article
                key={c.title}
                className="group relative overflow-hidden rounded-2xl border border-zinc-200/90 bg-paper shadow-card transition hover:border-zinc-300 hover:shadow-lg"
              >
                <div className="relative aspect-[16/11] overflow-hidden">
                  <Image
                    src={c.img}
                    alt=""
                    fill
                    className="object-cover transition duration-700 group-hover:scale-[1.03]"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    unoptimized
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-ink/55 via-ink/20 to-transparent" />
                  <div className="absolute left-0 top-0 p-5 sm:p-6">
                    <span className="inline-flex rounded-full border border-white/25 bg-paper/90 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-lift shadow-sm backdrop-blur">
                      {c.tag}
                    </span>
                  </div>
                </div>
                <div className="relative p-6 sm:p-8">
                  <h3 className="font-display text-xl font-medium text-ink sm:text-2xl">{c.title}</h3>
                  <p className="mt-2 text-base font-medium text-zinc-700">{c.result}</p>
                </div>
              </article>
            ),
          )}
        </div>
      </div>
    </section>
  );
}
