export type CaseStatus = "draft" | "published";

export interface CaseStudy {
  id: string;
  slug: string;
  title: string;
  client?: string;
  industry?: string;
  services: string[];
  challenge: string;
  solution: string;
  results: Metric[];
  coverImage?: string;
  images: string[];
  tags: string[];
  featured: boolean;
  status: CaseStatus;
  publishedAt?: string;
  createdAt: string;
  updatedAt: string;
}

export interface Metric {
  label: string;
  value: string;
  delta?: string;
}
