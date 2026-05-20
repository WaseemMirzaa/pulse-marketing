"use client";

import { useEffect, useRef } from "react";

const JOTFORM_ID = process.env.NEXT_PUBLIC_JOTFORM_ID ?? "261392216292456";
const JOTFORM_SCRIPT = `https://form.jotform.com/jsform/${JOTFORM_ID}`;

export function Contact() {
  const formRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const container = formRef.current;
    if (!container || container.querySelector("script[data-jotform]")) return;

    const script = document.createElement("script");
    script.type = "text/javascript";
    script.src = JOTFORM_SCRIPT;
    script.async = true;
    script.dataset.jotform = JOTFORM_ID;

    container.appendChild(script);

    return () => {
      script.remove();
      container.replaceChildren();
    };
  }, []);

  return (
    <section id="contact" className="scroll-mt-24 bg-page pb-28 pt-4">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <div className="grid gap-16 lg:grid-cols-12 lg:gap-12">
          <div className="lg:col-span-5">
            <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">Contact</p>
            <h2 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl text-balance">
              Tell us what winning looks like
            </h2>
            <p className="mt-5 text-zinc-600 leading-relaxed">
              Share goals, stack, and constraints. You will get a direct answer on fit—not a generic
              capabilities deck.
            </p>
            <ul className="mt-10 space-y-4 text-sm text-zinc-600">
              <li className="flex items-center gap-3">
                <span className="h-1.5 w-1.5 rounded-full bg-lift-bright ring-2 ring-lift-soft" />
                Response within one business day
              </li>
              <li className="flex items-center gap-3">
                <span className="h-1.5 w-1.5 rounded-full bg-lift-bright ring-2 ring-lift-soft" />
                NDA-friendly intro calls
              </li>
            </ul>
            <a
              href="#book-call"
              className="mt-8 inline-flex rounded-full border border-zinc-300 bg-paper px-6 py-3 text-sm font-semibold text-ink shadow-sm transition hover:border-lift/40 hover:bg-lift-soft/50"
            >
              Or book a call directly →
            </a>
          </div>
          <div
            ref={formRef}
            className="min-h-[600px] overflow-hidden rounded-2xl border border-zinc-200/90 bg-paper p-4 shadow-card sm:p-6 lg:col-span-7 [&_iframe]:w-full"
          />
        </div>
      </div>
    </section>
  );
}
