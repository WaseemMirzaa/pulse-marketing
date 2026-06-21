import { defaultSiteContent, mergeFetchedContent, type SiteContent } from "./siteContent";

const apiBase = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:3001";

/**
 * Fetch the merged site content from the API for use in server components.
 * Falls back to the built-in defaults if the API is unreachable, so pages
 * never fail to render. Uses no-store so newly published posts appear at once.
 */
export async function fetchSiteContent(): Promise<SiteContent> {
  try {
    const res = await fetch(`${apiBase}/api/content`, { cache: "no-store" });
    if (!res.ok) throw new Error("bad response");
    return mergeFetchedContent(await res.json());
  } catch {
    return defaultSiteContent();
  }
}

/** Convenience: the blog posts, sorted newest-first by date. */
export async function fetchBlogPosts() {
  const content = await fetchSiteContent();
  return [...content.blog.posts].sort((a, b) => (a.date < b.date ? 1 : -1));
}
