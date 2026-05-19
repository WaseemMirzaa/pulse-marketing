import Link from "next/link";
import { Header } from "@/components/Header";
import { Footer } from "@/components/Footer";

export default function ThankYouPage() {
  return (
    <>
      <Header />
      <main className="flex min-h-[calc(100svh-4.25rem)] flex-col items-center justify-center bg-page px-4 pb-20 pt-28">
        <div className="max-w-lg text-center">
          <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">Message received</p>
          <h1 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl">
            Thanks — we&apos;ll be in touch
          </h1>
          <p className="mt-5 text-zinc-600 leading-relaxed">
            We typically reply within one business day. Want to talk sooner?
          </p>
          <div className="mt-10 flex flex-wrap items-center justify-center gap-4">
            <Link
              href="/#book-call"
              className="rounded-full bg-ink px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-zinc-800"
            >
              Book a call
            </Link>
            <Link
              href="/"
              className="rounded-full border border-zinc-300 bg-paper px-8 py-3.5 text-sm font-semibold text-ink transition hover:border-lift/40"
            >
              Back to home
            </Link>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
