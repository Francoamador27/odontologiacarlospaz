import Link from "next/link";
import { site, whatsappLink } from "@/lib/site";
import { treatments } from "@/lib/treatments";
import { ClockIcon, MailIcon, PhoneIcon, PinIcon } from "./icons";

export default function Footer() {
  return (
    <footer className="bg-ink text-cream/80">
      <div className="container-x grid gap-12 py-16 md:grid-cols-[1.3fr_1fr_1fr]">
        <div>
          {/* eslint-disable-next-line @next/next/no-img-element */}
          <img src="/img/logo.webp" alt={site.legalName} width={160} height={120} loading="lazy" className="h-24 w-auto" />
          <p className="mt-5 max-w-sm text-sm leading-relaxed">
            Odontología integral y estética en el corazón de Villa Carlos Paz. Atención personalizada y resultados naturales.
          </p>
        </div>

        <div>
          <h2 className="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-gold-light">Tratamientos</h2>
          <ul className="mt-5 space-y-2.5 text-sm">
            {treatments.map((t) => (
              <li key={t.slug}>
                <Link href={`/tratamientos/${t.slug}`} className="hover:text-cream">
                  {t.name}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        <div>
          <h2 className="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-gold-light">Contacto</h2>
          <ul className="mt-5 space-y-3.5 text-sm">
            <li className="flex gap-3">
              <PinIcon className="mt-0.5 size-4 shrink-0 text-gold-light" />
              <a href={site.mapsUrl} target="_blank" rel="noopener" className="hover:text-cream">
                {site.address.street}, {site.address.city}, {site.address.region}
              </a>
            </li>
            <li className="flex gap-3">
              <PhoneIcon className="mt-0.5 size-4 shrink-0 text-gold-light" />
              <a href={whatsappLink()} target="_blank" rel="noopener" className="hover:text-cream">
                {site.phoneDisplay}
              </a>
            </li>
            <li className="flex gap-3">
              <MailIcon className="mt-0.5 size-4 shrink-0 text-gold-light" />
              <a href={`mailto:${site.email}`} className="hover:text-cream">
                {site.email}
              </a>
            </li>
            {site.hours.map((h) => (
              <li key={h.days} className="flex gap-3">
                <ClockIcon className="mt-0.5 size-4 shrink-0 text-gold-light" />
                <span>
                  {h.days}: {h.time}
                </span>
              </li>
            ))}
          </ul>
        </div>
      </div>
      <div className="border-t border-cream/10">
        <div className="container-x flex flex-col gap-2 py-6 text-xs text-cream/50 sm:flex-row sm:justify-between">
          <p>© {new Date().getFullYear()} {site.name}. Todos los derechos reservados.</p>
          <p>
            Diseño y desarrollo:{" "}
            <a href="https://greatweb.com.ar" target="_blank" rel="noopener" className="underline-offset-4 hover:text-cream hover:underline">
              GreatWeb
            </a>
          </p>
        </div>
      </div>
    </footer>
  );
}
