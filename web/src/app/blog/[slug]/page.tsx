import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { Header } from "@/components/Header";
import { Footer } from "@/components/Footer";
import { blogPosts, getPost } from "@/lib/blogPosts";

type Props = { params: Promise<{ slug: string }> };

export async function generateStaticParams() {
  return blogPosts.map((p) => ({ slug: p.slug }));
}

export async function generateMetadata({ params }: Props) {
  const { slug } = await params;
  const post = getPost(slug);
  if (!post) return { title: "Post not found — PulseLyft" };
  return {
    title: `${post.title} — PulseLyft`,
    description: post.excerpt,
  };
}

export default async function BlogPostPage({ params }: Props) {
  const { slug } = await params;
  const post = getPost(slug);
  if (!post) notFound();

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
            <span>{new Date(post.date).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" })}</span>
            <span>{post.readTime}</span>
          </div>
          <h1 className="mt-6 font-display text-4xl font-medium leading-tight tracking-tight text-ink sm:text-5xl text-balance">
            {post.title}
          </h1>
          <p className="mt-6 text-lg leading-relaxed text-zinc-600">{post.excerpt}</p>
          <div className="relative mt-10 aspect-[16/9] overflow-hidden rounded-2xl border border-zinc-200/90 bg-zinc-100 shadow-card">
            <Image src={post.img} alt="" fill className="object-cover" sizes="768px" unoptimized />
          </div>
          <div className="prose prose-zinc mt-12 max-w-none space-y-6 text-base leading-relaxed text-zinc-700">
            {post.body.map((para) => (
              <p key={para.slice(0, 40)}>{para}</p>
            ))}
          </div>
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
      </article>
      <Footer />
    </main>
  );
}
