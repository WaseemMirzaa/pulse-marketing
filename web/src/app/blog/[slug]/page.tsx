import Image from "next/image";
import Link from "next/link";
import { headers } from "next/headers";
import { notFound } from "next/navigation";
import { Header } from "@/components/Header";
import { Footer } from "@/components/Footer";
import { fetchSiteContent } from "@/lib/fetchSiteContent";
import type { BlogPost } from "@/lib/siteContent";

type Props = { params: Promise<{ slug: string }> };

function formatDate(date: string) {
  return new Date(date).toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
}

function initials(name: string) {
  return name
    .split(" ")
    .map((p) => p[0])
    .filter(Boolean)
    .slice(0, 2)
    .join("")
    .toUpperCase();
}

export async function generateMetadata({ params }: Props) {
  const { slug } = await params;
  const { blog } = await fetchSiteContent();
  const post = blog.posts.find((p) => p.slug === slug);
  if (!post) return { title: "Post not found — PulseLyft" };
  return {
    title: `${post.title} — PulseLyft`,
    description: post.excerpt,
    openGraph: {
      title: post.title,
      description: post.excerpt,
      type: "article",
      publishedTime: post.date,
      authors: [post.author],
      images: post.img ? [{ url: post.img }] : undefined,
    },
    twitter: {
      card: "summary_large_image",
      title: post.title,
      description: post.excerpt,
      images: post.img ? [post.img] : undefined,
    },
  };
}

/**
 * Render the body blocks. Each entry is a paragraph; an entry beginning with
 * "## " becomes a sub-heading, and an entry whose lines all start with "- "
 * becomes a bullet list. The first paragraph gets an editorial drop-cap.
 */
function ArticleBody({ body }: { body: string[] }) {
  let firstPara = true;
  return (
    <div className="mt-12 max-w-none space-y-6 text-[1.05rem] leading-[1.8] text-zinc-700">
      {body.map((raw, i) => {
        const text = raw.trim();
        if (!text) return null;

        if (text.startsWith("## ")) {
          return (
            <h2
              key={i}
              className="!mt-12 font-display text-2xl font-medium tracking-tight text-ink sm:text-3xl"
            >
              {text.slice(3)}
            </h2>
          );
        }

        const lines = text
          .split("\n")
          .map((l) => l.trim())
          .filter(Boolean);
        if (lines.length > 1 && lines.every((l) => l.startsWith("- "))) {
          return (
            <ul key={i} className="space-y-2 pl-5">
              {lines.map((l, j) => (
                <li key={j} className="list-disc marker:text-lift">
                  {l.slice(2)}
                </li>
              ))}
            </ul>
          );
        }

        const isFirst = firstPara;
        firstPara = false;
        return (
          <p
            key={i}
            className={
              isFirst
                ? "first-letter:float-left first-letter:mr-3 first-letter:font-display first-letter:text-6xl first-letter:font-medium first-letter:leading-[0.8] first-letter:text-ink"
                : undefined
            }
          >
            {text}
          </p>
        );
      })}
    </div>
  );
}

function RelatedCard({ post }: { post: BlogPost }) {
  return (
    <Link
      href={`/blog/${post.slug}`}
      className="group flex h-full flex-col overflow-hidden rounded-2xl border border-zinc-200/90 bg-paper shadow-card transition hover:border-zinc-300 hover:shadow-lg"
    >
      <div className="relative aspect-[16/10] overflow-hidden bg-zinc-100">
        <Image
          src={post.img}
          alt=""
          fill
          className="object-cover transition duration-500 group-hover:scale-105"
          sizes="(max-width: 768px) 100vw, 33vw"
          unoptimized
        />
      </div>
      <div className="flex flex-1 flex-col p-5">
        <div className="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-zinc-400">
          <span className="text-lift">{post.category}</span>
          <span>{post.readTime}</span>
        </div>
        <h3 className="mt-2 font-display text-lg font-medium leading-snug text-ink group-hover:text-lift">
          {post.title}
        </h3>
      </div>
    </Link>
  );
}

export default async function BlogPostPage({ params }: Props) {
  const { slug } = await params;
  const { blog } = await fetchSiteContent();
  const post = blog.posts.find((p) => p.slug === slug);
  if (!post) notFound();

  // Absolute URL for share links (page is dynamic, so headers are available).
  const h = await headers();
  const host = h.get("x-forwarded-host") ?? h.get("host") ?? "";
  const proto = h.get("x-forwarded-proto") ?? (host.startsWith("localhost") ? "http" : "https");
  const url = host ? `${proto}://${host}/blog/${post.slug}` : `/blog/${post.slug}`;
  const shareText = encodeURIComponent(post.title);
  const shareUrl = encodeURIComponent(url);

  // "Keep reading" — same category first, then most-recent fillers.
  const related = [...blog.posts]
    .filter((p) => p.slug !== post.slug)
    .sort((a, b) => {
      const ac = a.category === post.category ? 0 : 1;
      const bc = b.category === post.category ? 0 : 1;
      if (ac !== bc) return ac - bc;
      return a.date < b.date ? 1 : -1;
    })
    .slice(0, 3);

  return (
    <main className="min-h-screen bg-page">
      <Header />
      <article className="pt-[4.25rem]">
        <div className="mx-auto max-w-3xl px-4 py-16 sm:px-6 sm:py-24">
          <Link href="/blog" className="text-sm font-semibold text-lift transition hover:text-ink">
            ← Back to blog
          </Link>
          <div className="mt-8 flex flex-wrap items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-zinc-400">
            <span className="text-lift">{post.category}</span>
            <span>{formatDate(post.date)}</span>
            <span>{post.readTime}</span>
          </div>
          <h1 className="mt-6 font-display text-4xl font-medium leading-tight tracking-tight text-ink sm:text-5xl text-balance">
            {post.title}
          </h1>
          <p className="mt-6 text-lg leading-relaxed text-zinc-600">{post.excerpt}</p>

          <div className="mt-8 flex items-center justify-between gap-4 border-y border-zinc-200/80 py-4">
            <div className="flex items-center gap-3">
              <span className="grid h-10 w-10 place-items-center rounded-full bg-ink text-xs font-semibold text-white">
                {initials(post.author)}
              </span>
              <div className="text-sm">
                <p className="font-semibold text-ink">{post.author}</p>
                <p className="text-zinc-500">PulseLyft Studio</p>
              </div>
            </div>
            <div className="flex items-center gap-2">
              <span className="hidden text-xs font-semibold uppercase tracking-wider text-zinc-400 sm:inline">
                Share
              </span>
              <a
                aria-label="Share on X"
                href={`https://twitter.com/intent/tweet?url=${shareUrl}&text=${shareText}`}
                target="_blank"
                rel="noopener noreferrer"
                className="grid h-9 w-9 place-items-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-lift/50 hover:text-ink"
              >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden>
                  <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.66l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
                </svg>
              </a>
              <a
                aria-label="Share on LinkedIn"
                href={`https://www.linkedin.com/sharing/share-offsite/?url=${shareUrl}`}
                target="_blank"
                rel="noopener noreferrer"
                className="grid h-9 w-9 place-items-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-lift/50 hover:text-ink"
              >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden>
                  <path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.13 1.44-2.13 2.94v5.67H9.35V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.61 0 4.28 2.38 4.28 5.47v6.27zM5.34 7.43a2.07 2.07 0 1 1 0-4.14 2.07 2.07 0 0 1 0 4.14zM7.12 20.45H3.55V9h3.57v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z" />
                </svg>
              </a>
              <a
                aria-label="Share by email"
                href={`mailto:?subject=${shareText}&body=${shareUrl}`}
                className="grid h-9 w-9 place-items-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-lift/50 hover:text-ink"
              >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" aria-hidden>
                  <rect x="3" y="5" width="18" height="14" rx="2" />
                  <path d="m3 7 9 6 9-6" />
                </svg>
              </a>
            </div>
          </div>

          <div className="relative mt-10 aspect-[16/9] overflow-hidden rounded-2xl border border-zinc-200/90 bg-zinc-100 shadow-card">
            <Image src={post.img} alt="" fill className="object-cover" sizes="768px" unoptimized />
          </div>

          <ArticleBody body={post.body} />

          <div className="mt-14 rounded-2xl border border-zinc-200/90 bg-paper p-8 text-center shadow-card">
            <p className="font-display text-2xl font-medium text-ink">Want help running this in your stack?</p>
            <p className="mt-3 text-zinc-600">Book a call or send a note—we reply within one business day.</p>
            <div className="mt-6 flex flex-wrap justify-center gap-4">
              <Link
                href="/#book-call"
                className="rounded-full bg-ink px-8 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800"
              >
                Book a call
              </Link>
              <Link
                href="/#contact"
                className="rounded-full border border-zinc-300 bg-page px-8 py-3 text-sm font-semibold text-ink transition hover:border-lift/40"
              >
                Contact
              </Link>
            </div>
          </div>
        </div>

        {related.length > 0 && (
          <div className="border-t border-zinc-200/80 bg-paper/40">
            <div className="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
              <div className="flex items-end justify-between gap-4">
                <h2 className="font-display text-2xl font-medium tracking-tight text-ink sm:text-3xl">
                  Keep reading
                </h2>
                <Link href="/blog" className="text-sm font-semibold text-lift transition hover:text-ink">
                  All posts →
                </Link>
              </div>
              <ul className="mt-8 grid gap-6 md:grid-cols-3">
                {related.map((p) => (
                  <li key={p.slug}>
                    <RelatedCard post={p} />
                  </li>
                ))}
              </ul>
            </div>
          </div>
        )}
      </article>
      <Footer />
    </main>
  );
}
