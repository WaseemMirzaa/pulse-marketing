"use client";

import { useCallback, useEffect, useState } from "react";
import Link from "next/link";
import {
  defaultSiteContent,
  mergeFetchedContent,
  type PortfolioItem,
  type SiteContent,
  type Stat,
} from "@/lib/siteContent";

const SESSION_KEY = "pulselyft_admin_key";
const apiBase = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:3001";

function Field({
  label,
  value,
  onChange,
  multiline,
}: {
  label: string;
  value: string;
  onChange: (v: string) => void;
  multiline?: boolean;
}) {
  const cls =
    "mt-1 w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-lift focus:outline-none focus:ring-1 focus:ring-lift";
  return (
    <label className="block text-sm">
      <span className="font-medium text-zinc-700">{label}</span>
      {multiline ? (
        <textarea rows={3} className={cls} value={value} onChange={(e) => onChange(e.target.value)} />
      ) : (
        <input type="text" className={cls} value={value} onChange={(e) => onChange(e.target.value)} />
      )}
    </label>
  );
}

export default function AdminPage() {
  const [key, setKey] = useState("");
  const [authed, setAuthed] = useState(false);
  const [content, setContent] = useState<SiteContent>(() => defaultSiteContent());
  const [status, setStatus] = useState("");
  const [loading, setLoading] = useState(false);

  const load = useCallback(async () => {
    setLoading(true);
    try {
      const res = await fetch(`${apiBase}/api/content`, { cache: "no-store" });
      const raw = await res.json();
      setContent(mergeFetchedContent(raw));
      setStatus("");
    } catch {
      setStatus("Could not load content.");
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    const k = typeof window !== "undefined" ? sessionStorage.getItem(SESSION_KEY) : null;
    if (k) {
      setKey(k);
      setAuthed(true);
      void load();
    }
  }, [load]);

  function login(e: React.FormEvent) {
    e.preventDefault();
    sessionStorage.setItem(SESSION_KEY, key);
    setAuthed(true);
    void load();
  }

  function logout() {
    sessionStorage.removeItem(SESSION_KEY);
    setAuthed(false);
    setKey("");
  }

  async function save() {
    setStatus("Saving…");
    const adminKey = sessionStorage.getItem(SESSION_KEY) ?? key;
    try {
      const res = await fetch(`${apiBase}/api/admin/content`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          "x-admin-key": adminKey,
        },
        body: JSON.stringify(content),
      });
      if (res.status === 401) {
        setStatus("Unauthorized — check ADMIN_KEY on the API matches your key.");
        return;
      }
      if (!res.ok) throw new Error();
      const next = await res.json();
      setContent(mergeFetchedContent(next));
      setStatus("Saved.");
    } catch {
      setStatus("Save failed — is the API running?");
    }
  }

  function updatePortfolioItem(i: number, patch: Partial<PortfolioItem>) {
    setContent((c) => {
      const items = [...c.portfolio.items];
      items[i] = { ...items[i], ...patch };
      return { ...c, portfolio: { ...c.portfolio, items } };
    });
  }

  function addPortfolio() {
    setContent((c) => ({
      ...c,
      portfolio: {
        ...c.portfolio,
        items: [
          ...c.portfolio.items,
          { title: "New item", category: "Tag", img: "", href: "#contact" },
        ],
      },
    }));
  }

  function removePortfolio(i: number) {
    setContent((c) => ({
      ...c,
      portfolio: {
        ...c.portfolio,
        items: c.portfolio.items.filter((_, j) => j !== i),
      },
    }));
  }

  function setHeroStat(i: number, patch: Partial<Stat>) {
    setContent((c) => {
      const stats = [...c.hero.stats];
      stats[i] = { ...stats[i], ...patch };
      return { ...c, hero: { ...c.hero, stats } };
    });
  }

  if (!authed) {
    return (
      <div className="min-h-screen bg-zinc-100 px-4 py-16">
        <div className="mx-auto max-w-md rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm">
          <h1 className="font-display text-2xl text-zinc-900">Admin sign-in</h1>
          <p className="mt-2 text-sm text-zinc-600">
            Enter the same value as <code className="rounded bg-zinc-100 px-1">ADMIN_KEY</code> on the API
            (default <code className="rounded bg-zinc-100 px-1">dev-admin-change-me</code>).
          </p>
          <form onSubmit={login} className="mt-6 space-y-4">
            <label className="block text-sm font-medium text-zinc-700">Admin key</label>
            <input
              type="password"
              className="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm"
              value={key}
              onChange={(e) => setKey(e.target.value)}
              autoComplete="off"
            />
            <button
              type="submit"
              className="w-full rounded-lg bg-zinc-900 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800"
            >
              Continue
            </button>
          </form>
          <p className="mt-6 text-center text-sm">
            <Link href="/" className="text-lift underline">
              ← Back to site
            </Link>
          </p>
        </div>
      </div>
    );
  }

  const h = content.hero;
  const pf = content.portfolio;

  return (
    <div className="min-h-screen bg-zinc-100 pb-20 pt-8">
      <div className="mx-auto max-w-3xl px-4">
        <div className="mb-8 flex flex-wrap items-center justify-between gap-4">
          <div>
            <h1 className="font-display text-2xl text-zinc-900">Site content</h1>
            <p className="text-sm text-zinc-600">Edits save to the API as JSON (merged with defaults).</p>
          </div>
          <div className="flex gap-2">
            <Link href="/" className="rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium">
              View site
            </Link>
            <button type="button" onClick={logout} className="rounded-lg border border-zinc-300 px-4 py-2 text-sm">
              Sign out
            </button>
            <button
              type="button"
              onClick={() => void save()}
              className="rounded-lg bg-lift px-4 py-2 text-sm font-semibold text-zinc-900"
            >
              Save all
            </button>
          </div>
        </div>
        {loading && <p className="mb-4 text-sm text-zinc-500">Loading…</p>}
        {status && <p className="mb-4 text-sm text-zinc-700">{status}</p>}

        <div className="space-y-6">
          <details open className="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            <summary className="cursor-pointer font-semibold text-zinc-900">Hero &amp; image</summary>
            <div className="mt-4 grid gap-3 sm:grid-cols-2">
              <Field label="Badge" value={h.badge} onChange={(v) => setContent({ ...content, hero: { ...h, badge: v } })} />
              <Field label="Hero image URL" value={h.heroImage} onChange={(v) => setContent({ ...content, hero: { ...h, heroImage: v } })} />
              <Field label="Image alt" value={h.heroImageAlt} onChange={(v) => setContent({ ...content, hero: { ...h, heroImageAlt: v } })} />
              <Field label="Headline (before italic)" value={h.headlineBefore} onChange={(v) => setContent({ ...content, hero: { ...h, headlineBefore: v } })} />
              <Field label="Italic word" value={h.headlineItalic} onChange={(v) => setContent({ ...content, hero: { ...h, headlineItalic: v } })} />
              <Field label="Headline (after italic)" value={h.headlineAfter} onChange={(v) => setContent({ ...content, hero: { ...h, headlineAfter: v } })} />
              <div className="sm:col-span-2">
                <Field label="Subhead" value={h.sub} onChange={(v) => setContent({ ...content, hero: { ...h, sub: v } })} multiline />
              </div>
              <Field label="Primary CTA" value={h.primaryCta} onChange={(v) => setContent({ ...content, hero: { ...h, primaryCta: v } })} />
              <Field label="Secondary CTA" value={h.secondaryCta} onChange={(v) => setContent({ ...content, hero: { ...h, secondaryCta: v } })} />
              <Field label="Float card kicker" value={h.floatCard.kicker} onChange={(v) => setContent({ ...content, hero: { ...h, floatCard: { ...h.floatCard, kicker: v } } })} />
              <Field label="Float card title" value={h.floatCard.title} onChange={(v) => setContent({ ...content, hero: { ...h, floatCard: { ...h.floatCard, title: v } } })} />
              <div className="sm:col-span-2">
                <Field label="Float card body" value={h.floatCard.body} onChange={(v) => setContent({ ...content, hero: { ...h, floatCard: { ...h.floatCard, body: v } } })} multiline />
              </div>
            </div>
            <p className="mt-4 text-xs font-semibold text-zinc-500">Hero stats (3)</p>
            <div className="mt-2 grid gap-2 sm:grid-cols-3">
              {[0, 1, 2].map((i) => (
                <div key={i} className="flex gap-2">
                  <Field
                    label={`Stat ${i + 1} value`}
                    value={h.stats[i]?.value ?? ""}
                    onChange={(v) => setHeroStat(i, { value: v })}
                  />
                  <Field
                    label="Label"
                    value={h.stats[i]?.label ?? ""}
                    onChange={(v) => setHeroStat(i, { label: v })}
                  />
                </div>
              ))}
            </div>
          </details>

          <details className="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            <summary className="cursor-pointer font-semibold text-zinc-900">Logo strip</summary>
            <div className="mt-4 space-y-3">
              <Field label="Line above logos" value={content.logos.line} onChange={(v) => setContent({ ...content, logos: { ...content.logos, line: v } })} />
              <Field
                label="Brand names (comma-separated)"
                value={content.logos.brands.join(", ")}
                onChange={(v) =>
                  setContent({
                    ...content,
                    logos: { ...content.logos, brands: v.split(",").map((s) => s.trim()).filter(Boolean) },
                  })
                }
              />
            </div>
          </details>

          <details className="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            <summary className="cursor-pointer font-semibold text-zinc-900">Services (4 cards)</summary>
            <div className="mt-4 space-y-3">
              <Field label="Kicker" value={content.services.kicker} onChange={(v) => setContent({ ...content, services: { ...content.services, kicker: v } })} />
              <Field label="Title" value={content.services.title} onChange={(v) => setContent({ ...content, services: { ...content.services, title: v } })} />
              <Field label="Intro" value={content.services.intro} onChange={(v) => setContent({ ...content, services: { ...content.services, intro: v } })} multiline />
              {content.services.items.slice(0, 4).map((it, i) => (
                <div key={i} className="rounded-lg border border-zinc-100 p-3">
                  <p className="text-xs font-semibold text-zinc-500">Service {i + 1}</p>
                  <Field label="Title" value={it.title} onChange={(v) => {
                    const items = [...content.services.items];
                    items[i] = { ...items[i], title: v };
                    setContent({ ...content, services: { ...content.services, items } });
                  }} />
                  <Field label="Body" value={it.body} onChange={(v) => {
                    const items = [...content.services.items];
                    items[i] = { ...items[i], body: v };
                    setContent({ ...content, services: { ...content.services, items } });
                  }} multiline />
                  <Field label="Image URL" value={it.img ?? ""} onChange={(v) => {
                    const items = [...content.services.items];
                    items[i] = { ...items[i], img: v };
                    setContent({ ...content, services: { ...content.services, items } });
                  }} />
                </div>
              ))}
            </div>
          </details>

          <details className="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            <summary className="cursor-pointer font-semibold text-zinc-900">Work / case studies</summary>
            <div className="mt-4 space-y-3">
              <Field label="Kicker" value={content.work.kicker} onChange={(v) => setContent({ ...content, work: { ...content.work, kicker: v } })} />
              <Field label="Title" value={content.work.title} onChange={(v) => setContent({ ...content, work: { ...content.work, title: v } })} />
              <Field label="Intro" value={content.work.intro} onChange={(v) => setContent({ ...content, work: { ...content.work, intro: v } })} multiline />
              <Field label="CTA label" value={content.work.cta} onChange={(v) => setContent({ ...content, work: { ...content.work, cta: v } })} />
              <Field label="Featured block body" value={content.work.caseBody} onChange={(v) => setContent({ ...content, work: { ...content.work, caseBody: v } })} multiline />
              {content.work.cases.map((cs, i) => (
                <div key={i} className="rounded-lg border border-zinc-100 p-3">
                  <p className="text-xs font-semibold text-zinc-500">Case {i + 1}</p>
                  <label className="mt-2 flex items-center gap-2 text-sm">
                    <input
                      type="checkbox"
                      checked={cs.featured}
                      onChange={(e) => {
                        let cases = content.work.cases.map((c, j) => ({
                          ...c,
                          featured: e.target.checked ? j === i : j === i ? false : c.featured,
                        }));
                        if (!cases.some((c) => c.featured)) {
                          cases = cases.map((c, j) => ({ ...c, featured: j === 0 }));
                        }
                        setContent({ ...content, work: { ...content.work, cases } });
                      }}
                    />
                    Featured (large row)
                  </label>
                  <Field label="Title" value={cs.title} onChange={(v) => {
                    const cases = [...content.work.cases];
                    cases[i] = { ...cases[i], title: v };
                    setContent({ ...content, work: { ...content.work, cases } });
                  }} />
                  <Field label="Tag" value={cs.tag} onChange={(v) => {
                    const cases = [...content.work.cases];
                    cases[i] = { ...cases[i], tag: v };
                    setContent({ ...content, work: { ...content.work, cases } });
                  }} />
                  <Field label="Result line" value={cs.result} onChange={(v) => {
                    const cases = [...content.work.cases];
                    cases[i] = { ...cases[i], result: v };
                    setContent({ ...content, work: { ...content.work, cases } });
                  }} />
                  <Field label="Image URL" value={cs.img} onChange={(v) => {
                    const cases = [...content.work.cases];
                    cases[i] = { ...cases[i], img: v };
                    setContent({ ...content, work: { ...content.work, cases } });
                  }} />
                </div>
              ))}
            </div>
          </details>

          <details open className="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            <summary className="cursor-pointer font-semibold text-zinc-900">Portfolio</summary>
            <div className="mt-4 space-y-3">
              <Field label="Kicker" value={pf.kicker} onChange={(v) => setContent({ ...content, portfolio: { ...pf, kicker: v } })} />
              <Field label="Title" value={pf.title} onChange={(v) => setContent({ ...content, portfolio: { ...pf, title: v } })} />
              <Field label="Intro" value={pf.intro} onChange={(v) => setContent({ ...content, portfolio: { ...pf, intro: v } })} multiline />
              <Field label="CTA label" value={pf.cta} onChange={(v) => setContent({ ...content, portfolio: { ...pf, cta: v } })} />
              <div className="flex justify-end">
                <button type="button" onClick={addPortfolio} className="text-sm font-semibold text-lift underline">
                  + Add portfolio item
                </button>
              </div>
              {pf.items.map((it, i) => (
                <div key={i} className="rounded-lg border border-zinc-200 p-3">
                  <div className="mb-2 flex justify-between">
                    <span className="text-xs font-semibold text-zinc-500">Item {i + 1}</span>
                    <button type="button" className="text-xs text-red-600" onClick={() => removePortfolio(i)}>
                      Remove
                    </button>
                  </div>
                  <Field label="Title" value={it.title} onChange={(v) => updatePortfolioItem(i, { title: v })} />
                  <Field label="Category" value={it.category} onChange={(v) => updatePortfolioItem(i, { category: v })} />
                  <Field label="Image URL" value={it.img} onChange={(v) => updatePortfolioItem(i, { img: v })} />
                  <Field label="Link (href)" value={it.href} onChange={(v) => updatePortfolioItem(i, { href: v })} />
                </div>
              ))}
            </div>
          </details>

          <details className="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            <summary className="cursor-pointer font-semibold text-zinc-900">Metrics, Process, Testimonials, CTA</summary>
            <div className="mt-4 space-y-4">
              <Field label="Metrics kicker" value={content.metrics.kicker} onChange={(v) => setContent({ ...content, metrics: { ...content.metrics, kicker: v } })} />
              <Field label="Metrics title" value={content.metrics.title} onChange={(v) => setContent({ ...content, metrics: { ...content.metrics, title: v } })} />
              <Field label="Metrics body" value={content.metrics.body} onChange={(v) => setContent({ ...content, metrics: { ...content.metrics, body: v } })} multiline />
              {content.metrics.stats.map((st, i) => (
                <div key={i} className="flex gap-2">
                  <Field
                    label={`Stat ${i + 1} value`}
                    value={st.value}
                    onChange={(v) => {
                      const stats = [...content.metrics.stats];
                      stats[i] = { ...stats[i], value: v };
                      setContent({ ...content, metrics: { ...content.metrics, stats } });
                    }}
                  />
                  <Field
                    label="Label"
                    value={st.label}
                    onChange={(v) => {
                      const stats = [...content.metrics.stats];
                      stats[i] = { ...stats[i], label: v };
                      setContent({ ...content, metrics: { ...content.metrics, stats } });
                    }}
                  />
                </div>
              ))}
              <hr className="border-zinc-100" />
              <Field label="Process kicker" value={content.process.kicker} onChange={(v) => setContent({ ...content, process: { ...content.process, kicker: v } })} />
              <Field label="Process title" value={content.process.title} onChange={(v) => setContent({ ...content, process: { ...content.process, title: v } })} />
              <Field label="Process intro" value={content.process.intro} onChange={(v) => setContent({ ...content, process: { ...content.process, intro: v } })} multiline />
              {content.process.steps.map((st, i) => (
                <div key={st.n} className="rounded border border-zinc-100 p-2">
                  <Field label={`Step ${i + 1} title`} value={st.title} onChange={(v) => {
                    const steps = [...content.process.steps];
                    steps[i] = { ...steps[i], title: v };
                    setContent({ ...content, process: { ...content.process, steps } });
                  }} />
                  <Field label="Body" value={st.body} onChange={(v) => {
                    const steps = [...content.process.steps];
                    steps[i] = { ...steps[i], body: v };
                    setContent({ ...content, process: { ...content.process, steps } });
                  }} multiline />
                </div>
              ))}
              <hr className="border-zinc-100" />
              <Field label="Testimonials kicker" value={content.testimonials.kicker} onChange={(v) => setContent({ ...content, testimonials: { ...content.testimonials, kicker: v } })} />
              <Field label="Testimonials title" value={content.testimonials.title} onChange={(v) => setContent({ ...content, testimonials: { ...content.testimonials, title: v } })} />
              {[0, 1].map((i) => (
                <div key={i} className="rounded border border-zinc-100 p-2">
                  <p className="text-xs text-zinc-500">Quote {i + 1}</p>
                  <Field label="Quote" value={content.testimonials.quotes[i]?.quote ?? ""} onChange={(v) => {
                    const quotes = [...content.testimonials.quotes];
                    quotes[i] = { ...quotes[i], quote: v, name: quotes[i]?.name ?? "", role: quotes[i]?.role ?? "" };
                    setContent({ ...content, testimonials: { ...content.testimonials, quotes } });
                  }} multiline />
                  <Field label="Name" value={content.testimonials.quotes[i]?.name ?? ""} onChange={(v) => {
                    const quotes = [...content.testimonials.quotes];
                    quotes[i] = { ...quotes[i]!, name: v };
                    setContent({ ...content, testimonials: { ...content.testimonials, quotes } });
                  }} />
                  <Field label="Role" value={content.testimonials.quotes[i]?.role ?? ""} onChange={(v) => {
                    const quotes = [...content.testimonials.quotes];
                    quotes[i] = { ...quotes[i]!, role: v };
                    setContent({ ...content, testimonials: { ...content.testimonials, quotes } });
                  }} />
                  <Field label="Avatar URL" value={content.testimonials.quotes[i]?.avatar ?? ""} onChange={(v) => {
                    const quotes = [...content.testimonials.quotes];
                    quotes[i] = { ...quotes[i]!, avatar: v };
                    setContent({ ...content, testimonials: { ...content.testimonials, quotes } });
                  }} />
                </div>
              ))}
              <hr className="border-zinc-100" />
              <p className="text-xs font-semibold uppercase tracking-wider text-zinc-500">Book a call</p>
              <Field label="Kicker" value={content.bookCall?.kicker ?? ""} onChange={(v) => setContent({ ...content, bookCall: { ...(content.bookCall ?? defaultSiteContent().bookCall), kicker: v } })} />
              <Field label="Title" value={content.bookCall?.title ?? ""} onChange={(v) => setContent({ ...content, bookCall: { ...(content.bookCall ?? defaultSiteContent().bookCall), title: v } })} />
              <Field label="Sub" value={content.bookCall?.sub ?? ""} onChange={(v) => setContent({ ...content, bookCall: { ...(content.bookCall ?? defaultSiteContent().bookCall), sub: v } })} multiline />
              <Field label="Calendly URL" value={content.bookCall?.calendlyUrl ?? ""} onChange={(v) => setContent({ ...content, bookCall: { ...(content.bookCall ?? defaultSiteContent().bookCall), calendlyUrl: v } })} />
              <hr className="border-zinc-100" />
              <Field label="CTA kicker" value={content.cta.kicker} onChange={(v) => setContent({ ...content, cta: { ...content.cta, kicker: v } })} />
              <Field label="CTA title" value={content.cta.title} onChange={(v) => setContent({ ...content, cta: { ...content.cta, title: v } })} />
              <Field label="CTA sub" value={content.cta.sub} onChange={(v) => setContent({ ...content, cta: { ...content.cta, sub: v } })} multiline />
              <Field label="CTA button" value={content.cta.button} onChange={(v) => setContent({ ...content, cta: { ...content.cta, button: v } })} />
            </div>
          </details>
        </div>
      </div>
    </div>
  );
}
