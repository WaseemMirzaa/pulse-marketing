"use client";

import Image from "next/image";
import Link from "next/link";
import { useSiteContent } from "@/context/SiteContentProvider";

export function Blog() {
  const { content } = useSiteContent();
  const posts = [...content.blog.posts].sort((a, b) => (a.date < b.date ? 1 : -1)).slice(0, 3);

  if (posts.length === 0) return null;

  return (
    <section id="blog" className="scroll-mt-24 bg-page py-24 sm:py-32">
      <div className="mx-auto max-w-6xl px-4 sm:px-6">
        <div className="flex flex-col justify-between gap-8 sm:flex-row sm:items-end">
          <div>
            <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">{content.blog.kicker}</p>
            <h2 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl text-balance">
              {content.blog.title}
            </h2>
            <p className="mt-4 max-w-xl text-zinc-600 leading-relaxed">{content.blog.intro}</p>
          </div>
          <Link
            href="/blog"
            className="inline-flex w-fit items-center gap-2 rounded-full border border-zinc-300 bg-paper px-6 py-3 text-sm font-semibold text-ink shadow-sm transition hover:border-lift/50"
          >
            View all posts
            <span aria-hidden>→</span>
          </Link>
        </div>
        <ul className="mt-14 grid gap-6 md:grid-cols-3">
          {posts.map((post) => (
            <li key={post.slug}>
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
                <div className="flex flex-1 flex-col p-6">
                  <div className="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-zinc-400">
                    <span className="text-lift">{post.category}</span>
                    <span>{post.readTime}</span>
                  </div>
                  <h3 className="mt-3 font-display text-xl font-medium leading-snug text-ink group-hover:text-lift">
                    {post.title}
                  </h3>
                  <p className="mt-3 flex-1 text-sm leading-relaxed text-zinc-600">{post.excerpt}</p>
                  <span className="mt-5 text-sm font-semibold text-ink">Read article →</span>
                </div>
              </Link>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
