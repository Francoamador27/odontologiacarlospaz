import type { Metadata } from "next";
import { site, whatsappLink } from "@/lib/site";
import PageHero from "@/components/PageHero";
import { ClockIcon, MailIcon, PhoneIcon, PinIcon, WhatsAppIcon } from "@/components/icons";

export const metadata: Metadata = {
  title: "Contacto y turnos — Dentista en Villa Carlos Paz",
  description: `Pedí tu turno por WhatsApp al ${site.phoneDisplay}. Estamos en ${site.address.street}, Villa Carlos Paz. Lunes a viernes 8 a 19 h, sábados 8 a 13 h.`,
  alternates: { canonical: "/contacto" },
};

export default function Contacto() {
  const items = [
    { icon: WhatsAppIcon, label: "WhatsApp", value: site.phoneDisplay, href: whatsappLink(), external: true },
    { icon: PhoneIcon, label: "Teléfono", value: site.phoneDisplay, href: `tel:${site.phoneE164}` },
    { icon: MailIcon, label: "Email", value: site.email, href: `mailto:${site.email}` },
    { icon: PinIcon, label: "Dirección", value: `${site.address.street}, ${site.address.city}`, href: site.mapsUrl, external: true },
  ];

  return (
    <>
      <PageHero
        eyebrow="Contacto"
        title="Pedí tu turno"
        intro="La forma más rápida es por WhatsApp: te respondemos y coordinamos el día y horario que mejor te quede."
        crumbs={[{ href: "/contacto", label: "Contacto" }]}
      />

      <section className="container-x grid gap-10 py-16 sm:py-20 lg:grid-cols-[1fr_1.2fr]">
        <div>
          <a href={whatsappLink()} target="_blank" rel="noopener" className="btn-primary w-full !py-5 text-base sm:w-auto">
            <WhatsAppIcon /> Escribinos por WhatsApp
          </a>

          <ul className="mt-10 divide-y divide-ink/10 border-y border-ink/10">
            {items.map(({ icon: Icon, label, value, href, external }) => (
              <li key={label}>
                <a
                  href={href}
                  {...(external ? { target: "_blank", rel: "noopener" } : {})}
                  className="flex items-center gap-4 py-5 hover:text-teal"
                >
                  <span className="grid size-11 shrink-0 place-items-center rounded-full bg-teal-soft text-teal">
                    <Icon />
                  </span>
                  <span>
                    <span className="block text-xs font-semibold uppercase tracking-[0.18em] text-cocoa">{label}</span>
                    <span className="text-lg">{value}</span>
                  </span>
                </a>
              </li>
            ))}
          </ul>

          <div className="mt-10 rounded-3xl bg-cream p-6">
            <h2 className="flex items-center gap-2 font-sans text-base font-semibold">
              <ClockIcon className="size-5 text-gold" /> Horarios de atención
            </h2>
            <dl className="mt-4 space-y-2">
              {site.hours.map((h) => (
                <div key={h.days} className="flex justify-between">
                  <dt>{h.days}</dt>
                  <dd className="text-cocoa">{h.time}</dd>
                </div>
              ))}
              <div className="flex justify-between">
                <dt>Domingos</dt>
                <dd className="text-cocoa">Cerrado</dd>
              </div>
            </dl>
          </div>
        </div>

        <div className="min-h-[24rem] overflow-hidden rounded-4xl bg-sand">
          <iframe
            src={site.mapsEmbed}
            title={`Mapa: ${site.address.street}, ${site.address.city}`}
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
            className="size-full min-h-[24rem] border-0"
          />
        </div>
      </section>
    </>
  );
}
