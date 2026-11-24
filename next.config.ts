import type { NextConfig } from "next";

// Exportación 100% estática: `next build` genera la carpeta `out/`,
// que Cloudflare Pages sirve directo desde su CDN (sin servidor).
const nextConfig: NextConfig = {
  output: "export",
  trailingSlash: false,
  images: { unoptimized: true }, // las imágenes ya se optimizan con `npm run images`
  experimental: {
    inlineCss: true, // CSS crítico dentro del HTML: sin petición que bloquee el render
  },
};

export default nextConfig;
