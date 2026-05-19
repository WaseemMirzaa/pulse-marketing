"use client";

import Link from "next/link";
import { useState } from "react";

const links = [
  { href: "#services", label: "Services" },
  { href: "#work", label: "Work" },
  { href: "#portfolio", label: "Portfolio" },
  { href: "#process", label: "Process" },
  { href: "#contact", label: "Contact" },
];

export function Header() {
  const [open, setOpen] = useState(false);

  return (
    <header className="fixed inset-x-0 top-0 z-50 border-b border-zinc-200/80 bg-paper/85 backdrop-blur-xl">
      <div className="mx-auto flex h-[4.25rem] max-w-6xl items-center justify-between px-4 sm:px-6">
        <Link href="/" className="group flex items-center gap-2">
          <span className="flex h-9 w-9 items-center justify-center rounded-lg bg-lift-soft ring-1 ring-lift/25 transition group-hover:ring-lift/40">
            <span className="font-display text-sm font-semibold text-lift">P</span>
          </span>
          <span className="font-display text-lg font-semibold tracking-tight text-ink">
            Pulse<span className="text-lift">Lift</span>
          </span>
        </Link>
        <nav className="hidden items-center gap-10 md:flex" aria-label="Primary">
          {links.map((l) => (
            <Link
              key={l.href}
              href={l.href}
              className="text-[13px] font-medium uppercase tracking-[0.18em] text-zinc-500 transition hover:text-ink"
            >
              {l.label}
            </Link>
          ))}
          <Link
            href="#book-call"
            className="rounded-full bg-ink px-6 py-2.5 text-[13px] font-semibold uppercase tracking-wide text-white shadow-card transition hover:bg-zinc-800"
          >
            Book a call
          </Link>
        </nav>
        <button
          type="button"
          className="flex flex-col gap-1.5 rounded-lg p-2 md:hidden"
          aria-expanded={open}
          aria-label="Menu"
          onClick={() => setOpen(!open)}
        >
          <span className="block h-0.5 w-6 bg-ink" />
          <span className="block h-0.5 w-6 bg-zinc-400" />
        </button>
      </div>
      {open && (
        <div className="border-t border-zinc-200 bg-paper px-4 py-5 md:hidden">
          <div className="flex flex-col gap-4">
            {links.map((l) => (
              <Link
                key={l.href}
                href={l.href}
                className="text-sm font-medium uppercase tracking-widest text-zinc-600"
                onClick={() => setOpen(false)}
              >
                {l.label}
              </Link>
            ))}
            <Link
              href="#book-call"
              className="mt-2 rounded-full bg-ink py-3 text-center text-sm font-semibold text-white"
              onClick={() => setOpen(false)}
            >
              Book a call
            </Link>
          </div>
        </div>
      )}
    </header>
  );
}
