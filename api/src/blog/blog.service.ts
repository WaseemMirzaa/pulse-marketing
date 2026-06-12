import { Injectable, NotFoundException, ConflictException } from "@nestjs/common";
import { readJson, writeJson, slug, newId } from "../shared/store";
import { Post } from "./blog.types";
import { CreatePostDto, UpdatePostDto } from "./blog.dto";

const FILE = "blog.json";

@Injectable()
export class BlogService {
  private async all(): Promise<Post[]> {
    return readJson<Post[]>(FILE, []);
  }

  private async save(posts: Post[]): Promise<void> {
    await writeJson(FILE, posts);
  }

  async listPublished(): Promise<Post[]> {
    const posts = await this.all();
    return posts
      .filter((p) => p.status === "published")
      .sort((a, b) => (b.publishedAt ?? b.createdAt).localeCompare(a.publishedAt ?? a.createdAt));
  }

  async listAll(): Promise<Post[]> {
    const posts = await this.all();
    return posts.sort((a, b) => b.createdAt.localeCompare(a.createdAt));
  }

  async getBySlug(postSlug: string): Promise<Post> {
    const posts = await this.all();
    const post = posts.find((p) => p.slug === postSlug);
    if (!post) throw new NotFoundException(`Post "${postSlug}" not found`);
    return post;
  }

  async getById(id: string): Promise<Post> {
    const posts = await this.all();
    const post = posts.find((p) => p.id === id);
    if (!post) throw new NotFoundException(`Post "${id}" not found`);
    return post;
  }

  async create(dto: CreatePostDto): Promise<Post> {
    const posts = await this.all();
    const postSlug = dto.customSlug ? slug(dto.customSlug) : slug(dto.title);

    if (posts.some((p) => p.slug === postSlug)) {
      throw new ConflictException(`Slug "${postSlug}" already exists`);
    }

    const now = new Date().toISOString();
    const post: Post = {
      id: newId("post"),
      slug: postSlug,
      title: dto.title,
      excerpt: dto.excerpt,
      body: dto.body,
      coverImage: dto.coverImage,
      tags: dto.tags ?? [],
      author: dto.author ?? "PulseLyft",
      status: dto.status ?? "draft",
      publishedAt: dto.status === "published" ? now : undefined,
      createdAt: now,
      updatedAt: now,
    };

    posts.push(post);
    await this.save(posts);
    return post;
  }

  async update(id: string, dto: UpdatePostDto): Promise<Post> {
    const posts = await this.all();
    const idx = posts.findIndex((p) => p.id === id);
    if (idx === -1) throw new NotFoundException(`Post "${id}" not found`);

    const existing = posts[idx];
    const now = new Date().toISOString();

    const updated: Post = {
      ...existing,
      ...(dto.title !== undefined && { title: dto.title }),
      ...(dto.excerpt !== undefined && { excerpt: dto.excerpt }),
      ...(dto.body !== undefined && { body: dto.body }),
      ...(dto.coverImage !== undefined && { coverImage: dto.coverImage }),
      ...(dto.tags !== undefined && { tags: dto.tags }),
      ...(dto.author !== undefined && { author: dto.author }),
      ...(dto.status !== undefined && { status: dto.status }),
      ...(dto.status === "published" && !existing.publishedAt && { publishedAt: now }),
      updatedAt: now,
    };

    posts[idx] = updated;
    await this.save(posts);
    return updated;
  }

  async remove(id: string): Promise<{ deleted: boolean }> {
    const posts = await this.all();
    const filtered = posts.filter((p) => p.id !== id);
    if (filtered.length === posts.length) throw new NotFoundException(`Post "${id}" not found`);
    await this.save(filtered);
    return { deleted: true };
  }

  async listByTag(tag: string): Promise<Post[]> {
    const posts = await this.listPublished();
    return posts.filter((p) => p.tags.map((t) => t.toLowerCase()).includes(tag.toLowerCase()));
  }

  async allTags(): Promise<string[]> {
    const posts = await this.listPublished();
    const tags = new Set(posts.flatMap((p) => p.tags));
    return Array.from(tags).sort();
  }
}
