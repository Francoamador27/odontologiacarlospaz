// Next 16 + `output: "export"`: el router pide los prefetch de segmentos como
// `__next.a.b.__PAGE__.txt`, pero el build los escribe anidados
// (`__next.a/b/__PAGE__.txt`). Copiamos cada archivo a su nombre "plano"
// para evitar 404 en Cloudflare Pages. Se ejecuta solo después de `next build`.
import { readdir, copyFile, stat } from "node:fs/promises";
import path from "node:path";

const OUT = "out";
let count = 0;

async function walk(dir) {
  for (const entry of await readdir(dir, { withFileTypes: true })) {
    const full = path.join(dir, entry.name);
    if (!entry.isDirectory()) continue;
    if (entry.name.startsWith("__next.")) await flatten(full, dir, [entry.name]);
    else await walk(full);
  }
}

async function flatten(dir, base, parts) {
  for (const entry of await readdir(dir, { withFileTypes: true })) {
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) await flatten(full, base, [...parts, entry.name]);
    else {
      const target = path.join(base, [...parts, entry.name].join("."));
      try { await stat(target); } catch { await copyFile(full, target); count++; }
    }
  }
}

await walk(OUT);
console.log(`flatten-rsc: ${count} archivos de prefetch copiados`);
