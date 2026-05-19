"use client";

const FOXFORM_URL = "https://forms.foxform.app/6sajits67zlv";
const formUrl =
  process.env.NEXT_PUBLIC_CONTACT_FORM_URL?.trim() ||
  `${FOXFORM_URL}?v=3`;

export function Contact() {
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
          <div className="overflow-hidden rounded-2xl border border-zinc-200/90 bg-paper shadow-card lg:col-span-7">
            <iframe
              src={formUrl}
              title="Contact PulseLift"
              width="100%"
              height={600}
              className="w-full border-0"
              style={{ border: "none" }}
              frameBorder={0}
              loading="lazy"
            />
          </div>
        </div>
      </div>
    </section>
  );
}
