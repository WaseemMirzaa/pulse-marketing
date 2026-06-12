import { Injectable, NotFoundException, ConflictException } from "@nestjs/common";
import { readJson, writeJson, slug, newId } from "../shared/store";
import { CaseStudy } from "./portfolio.types";
import { CreateCaseDto, UpdateCaseDto } from "./portfolio.dto";

const FILE = "portfolio.json";

@Injectable()
export class PortfolioService {
  private async all(): Promise<CaseStudy[]> {
    return readJson<CaseStudy[]>(FILE, []);
  }

  private async save(items: CaseStudy[]): Promise<void> {
    await writeJson(FILE, items);
  }

  async listPublished(featuredFirst = true): Promise<CaseStudy[]> {
    const items = await this.all();
    const published = items.filter((c) => c.status === "published");
    if (featuredFirst) {
      return published.sort((a, b) => Number(b.featured) - Number(a.featured));
    }
    return published;
  }

  async listAll(): Promise<CaseStudy[]> {
    return this.all();
  }

  async getBySlug(caseSlug: string): Promise<CaseStudy> {
    const items = await this.all();
    const item = items.find((c) => c.slug === caseSlug);
    if (!item) throw new NotFoundException(`Case study "${caseSlug}" not found`);
    return item;
  }

  async create(dto: CreateCaseDto): Promise<CaseStudy> {
    const items = await this.all();
    const caseSlug = slug(dto.title);

    if (items.some((c) => c.slug === caseSlug)) {
      throw new ConflictException(`Slug "${caseSlug}" already exists`);
    }

    const now = new Date().toISOString();
    const item: CaseStudy = {
      id: newId("case"),
      slug: caseSlug,
      title: dto.title,
      client: dto.client,
      industry: dto.industry,
      services: dto.services ?? [],
      challenge: dto.challenge,
      solution: dto.solution,
      results: dto.results ?? [],
      coverImage: dto.coverImage,
      images: dto.images ?? [],
      tags: dto.tags ?? [],
      featured: dto.featured ?? false,
      status: dto.status ?? "draft",
      publishedAt: dto.status === "published" ? now : undefined,
      createdAt: now,
      updatedAt: now,
    };

    items.push(item);
    await this.save(items);
    return item;
  }

  async update(id: string, dto: UpdateCaseDto): Promise<CaseStudy> {
    const items = await this.all();
    const idx = items.findIndex((c) => c.id === id);
    if (idx === -1) throw new NotFoundException(`Case study "${id}" not found`);

    const existing = items[idx];
    const now = new Date().toISOString();

    const updated: CaseStudy = {
      ...existing,
      ...Object.fromEntries(
        Object.entries(dto).filter(([, v]) => v !== undefined),
      ),
      ...(dto.status === "published" && !existing.publishedAt && { publishedAt: now }),
      updatedAt: now,
    } as CaseStudy;

    items[idx] = updated;
    await this.save(items);
    return updated;
  }

  async remove(id: string): Promise<{ deleted: boolean }> {
    const items = await this.all();
    const filtered = items.filter((c) => c.id !== id);
    if (filtered.length === items.length) {
      throw new NotFoundException(`Case study "${id}" not found`);
    }
    await this.save(filtered);
    return { deleted: true };
  }
}
