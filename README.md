# Odontología Carlos Paz — sitio web

Sitio de la clínica, hecho con **Next.js 16** (exportación estática) + **Tailwind CSS 4**, desplegado en **Cloudflare Pages**.

## Estructura

```
app/                 Páginas (App Router)
  page.tsx           Inicio
  tratamientos/      Listado + una página por tratamiento ([slug])
  nosotros/ contacto/
  sitemap.ts robots.ts
components/          Header, Footer, CTA, íconos, analytics, JSON-LD
lib/site.ts          ← Datos de la clínica (teléfono, dirección, horarios, IDs de Google)
lib/treatments.ts    ← Textos de cada tratamiento (agregar uno = nueva página)
public/img/          Imágenes optimizadas (WebP)
public/_redirects    Redirecciones 301 desde las URLs viejas (.html)
public/_headers      Caché y cabeceras de seguridad
scripts/             Optimización de imágenes y post-build
legacy/              Sitio anterior (HTML/Bootstrap), solo como referencia
portal2/             Portal de turnos (PHP) — se despliega aparte, en su subdominio
```

## Desarrollo

```bash
npm install
npm run dev        # http://localhost:3000
npm run build      # genera /out
npm start          # sirve /out localmente
npm run images     # regenera public/img desde legacy/img
```

## Deploy en Cloudflare Pages

En el proyecto de Pages → **Settings → Builds & deployments**:

| Campo                  | Valor           |
|------------------------|-----------------|
| Framework preset       | `None`          |
| Build command          | `npm run build` |
| Build output directory | `out`           |
| Root directory         | *(vacío)*       |
| Variable `NODE_VERSION`| `22`            |

Cada push a la rama de producción despliega automáticamente; las otras ramas generan una URL de preview.
