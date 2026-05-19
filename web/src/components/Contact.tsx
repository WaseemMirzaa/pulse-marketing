"use client";

import { useState } from "react";

const apiBase = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:3001";

export function Contact() {
  const [status, setStatus] = useState<"idle" | "loading" | "ok" | "err">("idle");
  const [message, setMessage] = useState("");

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setStatus("loading");
    const form = e.currentTarget;
    const data = {
      name: (form.elements.namedItem("name") as HTMLInputElement).value,
      email: (form.elements.namedItem("email") as HTMLInputElement).value,
      company: (form.elements.namedItem("company") as HTMLInputElement).value,
      message: (form.elements.namedItem("message") as HTMLTextAreaElement).value,
    };
    try {
      const res = await fetch(`${apiBase}/api/contact`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });
      if (!res.ok) throw new Error();
      setStatus("ok");
      setMessage("Thanks—we will reply within one business day.");
      form.reset();
    } catch {
      setStatus("err");
      setMessage("Something went wrong. Email hello@pulselift.example directly.");
    }
  }

  const field =
    "mt-2 w-full rounded-xl border border-zinc-200 bg-paper px-4 py-3 text-sm text-ink outline-none ring-0 transition placeholder:text-zinc-400 focus:border-lift/50 focus:ring-2 focus:ring-lift/20";

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
          </div>
          <form
            onSubmit={onSubmit}
            className="space-y-5 rounded-2xl border border-zinc-200/90 bg-paper p-8 shadow-card sm:p-10 lg:col-span-7"
          >
            <div className="grid gap-5 sm:grid-cols-2">
              <div className="sm:col-span-1">
                <label htmlFor="name" className="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                  Name
                </label>
                <input id="name" name="name" required placeholder="Alex Rivera" className={field} />
              </div>
              <div className="sm:col-span-1">
                <label htmlFor="email" className="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                  Work email
                </label>
                <input
                  id="email"
                  name="email"
                  type="email"
                  required
                  placeholder="you@company.com"
                  className={field}
                />
              </div>
            </div>
            <div>
              <label htmlFor="company" className="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                Company
              </label>
              <input id="company" name="company" placeholder="Optional" className={field} />
            </div>
            <div>
              <label htmlFor="message" className="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                What should we know?
              </label>
              <textarea
                id="message"
                name="message"
                rows={5}
                required
                placeholder="Goals, budget band, markets, links…"
                className={field}
              />
            </div>
            <button
              type="submit"
              disabled={status === "loading"}
              className="w-full rounded-full bg-ink py-3.5 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:opacity-50"
            >
              {status === "loading" ? "Sending…" : "Send message"}
            </button>
            {message && (
              <p className={`text-sm ${status === "err" ? "text-red-600" : "text-lift"}`}>{message}</p>
            )}
          </form>
        </div>
      </div>
    </section>
  );
}
