import type { MetadataRoute } from "next";
import { site } from "@/lib/site";
import { treatments } from "@/lib/treatments";

export const dynamic = "force-static";

export default function sitemap(): MetadataRoute.Sitemap {
  const now = new Date();
  const pages = ["", "/tratamientos", "/nosotros", "/contacto"].map((p) => ({
    url: `${site.url}${p}`,
    lastModified: now,
    priority: p === "" ? 1 : 0.8,
  }));
  const tx = treatments.map((t) => ({
    url: `${site.url}/tratamientos/${t.slug}`,
    lastModified: now,
    priority: 0.9,
  }));
  return [...pages, ...tx];
}
