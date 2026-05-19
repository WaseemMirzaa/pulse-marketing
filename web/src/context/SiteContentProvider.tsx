"use client";

import { createContext, useCallback, useContext, useEffect, useMemo, useState } from "react";
import { defaultSiteContent, mergeFetchedContent, type SiteContent } from "@/lib/siteContent";

const apiBase = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:3001";

type Ctx = {
  content: SiteContent;
  loaded: boolean;
  reload: () => Promise<void>;
};

const SiteContentContext = createContext<Ctx | null>(null);

export function SiteContentProvider({ children }: { children: React.ReactNode }) {
  const [content, setContent] = useState<SiteContent>(() => defaultSiteContent());
  const [loaded, setLoaded] = useState(false);

  const reload = useCallback(async () => {
    try {
      const res = await fetch(`${apiBase}/api/content`, { cache: "no-store" });
      if (!res.ok) throw new Error();
      const raw = await res.json();
      setContent(mergeFetchedContent(raw));
    } catch {
      setContent(defaultSiteContent());
    } finally {
      setLoaded(true);
    }
  }, []);

  useEffect(() => {
    void reload();
  }, [reload]);

  const value = useMemo(() => ({ content, loaded, reload }), [content, loaded, reload]);

  return <SiteContentContext.Provider value={value}>{children}</SiteContentContext.Provider>;
}

export function useSiteContent() {
  const v = useContext(SiteContentContext);
  if (!v) throw new Error("useSiteContent must be used inside SiteContentProvider");
  return v;
}
