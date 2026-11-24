// Convierte las imágenes originales de legacy/img a WebP optimizado en public/img.
// Uso: npm run images
import sharp from "sharp";
import { readdir, mkdir } from "node:fs/promises";
import path from "node:path";

const SRC = "legacy/img";
const OUT = "public/img";

// [archivo origen, nombre destino, ancho máximo]
const jobs = [
  ["carousel-1.jpg", "hero.webp", 1600],
  ["carousel-2.jpg", "clinica.webp", 1400],
  ["odo.jpg", "consulta.webp", 1200],
  ["about.jpg", "nosotros.webp", 1000],
  ["service-1.jpg", "estetica.webp", 900],
  ["service-2.jpg", "implantes.webp", 900],
  ["service-3.jpg", "limpieza.webp", 900],
  ["service-4.jpg", "blanqueamiento.webp", 900],
  ["price-3.jpg", "endodoncia.webp", 900],
  ["carillas/carilla1.png", "carillas-1.webp", 1000],
  ["carillas/carillas2.png", "carillas-2.webp", 1000],
  ["blanqueamiento/1.jpg", "blanqueamiento-1.webp", 1000],
  ["blanqueamiento/2.jpg", "blanqueamiento-2.webp", 1000],
  ["blanqueamiento/3.webp", "blanqueamiento-3.webp", 1000],
  ["blanqueamiento/4.jpg", "blanqueamiento-4.webp", 1000],
];

await mkdir(OUT, { recursive: true });
for (const [src, dest, width] of jobs) {
  const info = await sharp(path.join(SRC, src))
    .resize({ width, withoutEnlargement: true })
    .webp({ quality: 74 })
    .toFile(path.join(OUT, dest));
  console.log(`${dest.padEnd(26)} ${info.width}x${info.height}  ${(info.size / 1024).toFixed(1)} KB`);
}

// Logo: versión blanca (fondos oscuros) + favicon/ícono
await sharp(path.join(SRC, "logo.png")).resize({ width: 320 }).webp({ quality: 90 }).toFile(path.join(OUT, "logo.webp"));
await sharp(path.join(SRC, "logo.png")).resize(512, 512, { fit: "contain", background: { r: 247, g: 241, b: 232, alpha: 1 } }).png().toFile("app/icon.png");
await sharp(path.join(SRC, "logo.png")).resize(180, 180, { fit: "contain", background: { r: 247, g: 241, b: 232, alpha: 1 } }).png().toFile("app/apple-icon.png");
console.log("logo + íconos listos");
