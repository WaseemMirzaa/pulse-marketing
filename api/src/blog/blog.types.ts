export type PostStatus = "draft" | "published";

export interface Post {
  id: string;
  slug: string;
  title: string;
  excerpt: string;
  body: string;
  coverImage?: string;
  tags: string[];
  author: string;
  status: PostStatus;
  publishedAt?: string;
  createdAt: string;
  updatedAt: string;
}
