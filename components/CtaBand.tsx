import { site, whatsappLink } from "@/lib/site";
import { PhoneIcon, WhatsAppIcon } from "./icons";

export default function CtaBand({
  title = "Tu nueva sonrisa empieza con una consulta",
  text = "Escribinos por WhatsApp y coordinamos el día y horario que mejor te quede.",
  message,
}: {
  title?: string;
  text?: string;
  message?: string;
}) {
  return (
    <section className="container-x py-20">
      <div className="relative overflow-hidden rounded-4xl bg-teal px-6 py-14 text-cream sm:px-14 sm:py-16">
        <div aria-hidden="true" className="absolute -right-24 -top-24 size-80 rounded-full bg-cream/10" />
        <div aria-hidden="true" className="absolute -bottom-32 right-24 size-64 rounded-full bg-gold/25" />
        <div className="relative max-w-2xl">
          <h2 className="text-3xl leading-tight sm:text-5xl">{title}</h2>
          <p className="mt-4 text-lg text-cream">{text}</p>
          <div className="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href={whatsappLink(message)} target="_blank" rel="noopener" className="btn-light">
              <WhatsAppIcon className="size-4" /> Pedir turno por WhatsApp
            </a>
            <a href={`tel:${site.phoneE164}`} className="btn border border-cream/40 text-cream hover:bg-cream/10">
              <PhoneIcon className="size-4" /> Llamar al {site.phoneDisplay}
            </a>
          </div>
        </div>
      </div>
    </section>
  );
}
