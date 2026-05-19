import { Injectable, BadRequestException } from "@nestjs/common";
import { promises as fs } from "fs";
import * as path from "path";
import { DEFAULT_SITE_CONTENT } from "./default-content";

function isPlainObject(v: unknown): v is Record<string, unknown> {
  return typeof v === "object" && v !== null && !Array.isArray(v);
}

function deepMerge<T extends Record<string, unknown>>(base: T, patch: unknown): T {
  if (!isPlainObject(patch)) return base;
  const out = { ...base } as Record<string, unknown>;
  for (const key of Object.keys(patch)) {
    const pv = patch[key];
    const bv = out[key];
    if (Array.isArray(pv)) {
      out[key] = pv;
    } else if (isPlainObject(pv) && isPlainObject(bv)) {
      out[key] = deepMerge(bv as Record<string, unknown>, pv);
    } else if (pv !== undefined) {
      out[key] = pv;
    }
  }
  return out as T;
}

@Injectable()
export class ContentService {
  private readonly filePath = path.join(__dirname, "..", "..", "data", "site-content.json");

  private asRecord(data: unknown): Record<string, unknown> {
    return JSON.parse(JSON.stringify(data)) as Record<string, unknown>;
  }

  getDefault() {
    return this.asRecord(DEFAULT_SITE_CONTENT);
  }

  async readMerged(): Promise<Record<string, unknown>> {
    const base = this.getDefault();
    try {
      const raw = await fs.readFile(this.filePath, "utf8");
      const parsed = JSON.parse(raw) as unknown;
      if (!isPlainObject(parsed)) return base;
      return deepMerge(base, parsed);
    } catch {
      return base;
    }
  }

  async saveContent(body: unknown): Promise<Record<string, unknown>> {
    if (!isPlainObject(body)) {
      throw new BadRequestException("Body must be a JSON object");
    }
    const merged = deepMerge(this.getDefault(), body);
    await fs.mkdir(path.dirname(this.filePath), { recursive: true });
    await fs.writeFile(this.filePath, JSON.stringify(merged, null, 2), "utf8");
    return merged;
  }
}
