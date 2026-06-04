import Link from "next/link";

export function Footer() {
  return (
    <footer className="border-t border-zinc-200/90 bg-paper pb-12 pt-16">
      <div className="mx-auto flex max-w-6xl flex-col gap-12 px-4 sm:px-6 lg:flex-row lg:items-start lg:justify-between">
        <div>
          <p className="flex items-center gap-2 font-display text-xl font-medium text-ink">
            <span className="flex h-8 w-8 items-center justify-center rounded-lg bg-lift-soft text-sm text-lift ring-1 ring-lift/25">
              P
            </span>
            Pulse<span className="text-lift">Lyft</span>
          </p>
          <p className="mt-4 max-w-sm text-sm leading-relaxed text-zinc-600">
            Performance marketing, Meta ads, and SEO for teams who measure twice and scale once.
          </p>
        </div>
        <div className="flex flex-wrap gap-16 text-sm">
          <div className="flex flex-col gap-3">
            <span className="text-[11px] font-semibold uppercase tracking-[0.2em] text-zinc-400">
              Navigate
            </span>
            <Link href="#services" className="text-zinc-600 transition hover:text-ink">
              Services
            </Link>
            <Link href="#work" className="text-zinc-600 transition hover:text-ink">
              Work
            </Link>
            <Link href="#portfolio" className="text-zinc-600 transition hover:text-ink">
              Portfolio
            </Link>
            <Link href="/admin" className="text-zinc-600 transition hover:text-ink">
              Admin
            </Link>
            <Link href="/blog" className="text-zinc-600 transition hover:text-ink">
              Blog
            </Link>
            <Link href="#contact" className="text-zinc-600 transition hover:text-ink">
              Contact
            </Link>
          </div>
          <div className="flex flex-col gap-3">
            <span className="text-[11px] font-semibold uppercase tracking-[0.2em] text-zinc-400">
              Legal
            </span>
            <span className="text-zinc-600">Privacy (stub)</span>
            <span className="text-zinc-600">Terms (stub)</span>
          </div>
        </div>
      </div>
      <p className="mt-14 text-center text-[11px] uppercase tracking-widest text-zinc-400">
        © {new Date().getFullYear()} PulseLyft — demo brand
      </p>
    </footer>
  );
}
