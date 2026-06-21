import Image from "next/image";
import Link from "next/link";
import { Header } from "@/components/Header";
import { Footer } from "@/components/Footer";
import { fetchSiteContent } from "@/lib/fetchSiteContent";

export const metadata = {
  title: "Blog — PulseLyft",
  description: "Performance marketing, Meta ads, SEO, and analytics playbooks from PulseLyft.",
};

export default async function BlogPage() {
  const { blog } = await fetchSiteContent();
  const posts = [...blog.posts].sort((a, b) => (a.date < b.date ? 1 : -1));

  return (
    <main className="min-h-screen bg-page">
      <Header />
      <section className="pt-[4.25rem]">
        <div className="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28">
          <p className="text-[11px] font-semibold uppercase tracking-[0.28em] text-lift">{blog.kicker}</p>
          <h1 className="mt-4 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl">
            {blog.title}
          </h1>
          <p className="mt-5 max-w-2xl text-zinc-600 leading-relaxed">{blog.intro}</p>
          {posts.length === 0 ? (
            <p className="mt-14 rounded-2xl border border-dashed border-zinc-300 bg-paper p-10 text-center text-zinc-500">
              No posts yet. Add your first article from the admin panel.
            </p>
          ) : (
            <ul className="mt-14 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
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
                      <div className="flex flex-wrap items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-zinc-400">
                        <span className="text-lift">{post.category}</span>
                        <span>{new Date(post.date).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" })}</span>
                        <span>{post.readTime}</span>
                      </div>
                      <h2 className="mt-3 font-display text-xl font-medium leading-snug text-ink group-hover:text-lift">
                        {post.title}
                      </h2>
                      <p className="mt-3 flex-1 text-sm leading-relaxed text-zinc-600">{post.excerpt}</p>
                      <span className="mt-5 text-sm font-semibold text-ink">Read article →</span>
                    </div>
                  </Link>
                </li>
              ))}
            </ul>
          )}
        </div>
      </section>
      <Footer />
    </main>
  );
}
