import Link from "next/link";
import { site, whatsappLink } from "@/lib/site";
import { treatments } from "@/lib/treatments";
import CtaBand from "@/components/CtaBand";
import { ArrowIcon, CheckIcon, ClockIcon, PinIcon, SparkIcon, WhatsAppIcon } from "@/components/icons";

/* eslint-disable @next/next/no-img-element */

const featured = ["blanqueamiento", "carillas"];

const values = [
  { title: "Especialistas en estética", text: "Tratamientos pensados para que tu sonrisa se vea natural y armónica con tu rostro." },
  { title: "Resultados duraderos", text: "Materiales de calidad y controles posteriores para que el resultado se mantenga." },
  { title: "Atención personalizada", text: "Te escuchamos, evaluamos tu caso y te explicamos cada paso antes de empezar." },
  { title: "Precios accesibles", text: "Planes adaptados a cada paciente. Consultanos sin compromiso." },
];

const steps = [
  { n: "01", title: "Escribinos", text: "Por WhatsApp coordinamos día y horario en minutos." },
  { n: "02", title: "Evaluación", text: "Revisamos tu caso y te proponemos un plan claro, con tiempos y opciones." },
  { n: "03", title: "Tratamiento", text: "Avanzamos a tu ritmo, con controles y seguimiento en cada etapa." },
];

export default function Home() {
  const main = treatments.filter((t) => featured.includes(t.slug));
  const rest = treatments.filter((t) => !featured.includes(t.slug));

  return (
    <>
      {/* HERO */}
      <section className="relative overflow-hidden">
        <div className="container-x grid items-center gap-12 pb-16 pt-10 lg:grid-cols-[1.05fr_1fr] lg:pb-24 lg:pt-16">
          <div>
            <p className="eyebrow reveal">Odontología integral y estética</p>
            <h1 className="reveal reveal-2 mt-6 text-[2.6rem] leading-[1.05] sm:text-6xl lg:text-[4.4rem]">
              Clínica dental en <em className="text-teal">Villa Carlos Paz</em>
            </h1>
            <p className="reveal reveal-3 mt-6 max-w-xl text-lg leading-relaxed text-cocoa">
              Blanqueamiento, carillas, implantes y odontología general con atención cercana y resultados naturales. Tu sonrisa, en buenas manos.
            </p>
            <div className="reveal reveal-3 mt-9 flex flex-col gap-3 sm:flex-row">
              <a href={whatsappLink()} target="_blank" rel="noopener" className="btn-primary">
                <WhatsAppIcon className="size-4" /> Pedir turno por WhatsApp
              </a>
              <Link href="/tratamientos" className="btn-outline">
                Ver tratamientos <ArrowIcon />
              </Link>
            </div>
            <ul className="mt-12 grid max-w-lg grid-cols-1 gap-5 border-t border-ink/10 pt-8 text-sm sm:grid-cols-2">
              <li className="flex gap-3">
                <PinIcon className="size-5 shrink-0 text-gold" />
                <p>
                  <span className="block font-semibold">Dirección</span>
                  <span className="text-cocoa">{site.address.street}, Villa Carlos Paz</span>
                </p>
              </li>
              <li className="flex gap-3">
                <ClockIcon className="size-5 shrink-0 text-gold" />
                <p>
                  <span className="block font-semibold">Horarios</span>
                  <span className="text-cocoa">Lun a vie 8 a 19 h · Sáb 8 a 13 h</span>
                </p>
              </li>
            </ul>
          </div>

          <div className="relative">
            <div className="relative aspect-[4/5] overflow-hidden rounded-t-[12rem] rounded-b-4xl bg-sand sm:aspect-[5/5] lg:aspect-[4/5]">
              <img
                src="/img/consulta.webp"
                alt="Paciente durante un control odontológico en nuestra clínica de Villa Carlos Paz"
                width={1200}
                height={667}
                fetchPriority="high"
                className="size-full object-cover object-[60%_50%]"
              />
            </div>
            <div className="absolute -bottom-6 left-4 flex items-center gap-3 rounded-2xl bg-ivory/95 px-5 py-4 shadow-xl shadow-ink/10 backdrop-blur sm:-left-8">
              <span className="grid size-11 place-items-center rounded-full bg-teal-soft text-teal">
                <SparkIcon />
              </span>
              <p className="text-sm leading-tight">
                <span className="block font-semibold">Estética dental</span>
                <span className="text-cocoa">Resultados naturales</span>
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* DESTACADOS */}
      <section className="bg-cream py-20 sm:py-28" aria-labelledby="destacados">
        <div className="container-x">
          <div className="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
            <div>
              <p className="eyebrow">Lo más elegido</p>
              <h2 id="destacados" className="mt-4 max-w-xl text-4xl leading-tight sm:text-5xl">
                Estética dental que se nota, sin que se note
              </h2>
            </div>
            <Link href="/tratamientos" className="inline-flex items-center gap-2 text-sm font-semibold text-teal hover:gap-3 transition-all">
              Todos los tratamientos <ArrowIcon />
            </Link>
          </div>

          <div className="mt-12 grid gap-6 md:grid-cols-2">
            {main.map((t) => (
              <Link
                key={t.slug}
                href={`/tratamientos/${t.slug}`}
                className="group relative flex min-h-[28rem] flex-col justify-end overflow-hidden rounded-4xl bg-ink p-8 text-cream sm:min-h-[32rem] sm:p-10"
              >
                <img
                  src={t.image}
                  alt={t.imageAlt}
                  width={1000}
                  height={560}
                  loading="lazy"
                  className="absolute inset-0 size-full object-cover opacity-80 transition duration-700 group-hover:scale-105"
                />
                <div aria-hidden="true" className="absolute inset-0 bg-gradient-to-t from-ink via-ink/50 to-transparent" />
                <div className="relative">
                  <h3 className="text-3xl sm:text-4xl">{t.name}</h3>
                  <p className="mt-3 max-w-md text-cream/80">{t.short}</p>
                  <ul className="mt-5 flex flex-wrap gap-2">
                    {t.highlights.map((h) => (
                      <li key={h} className="rounded-full border border-cream/25 px-3 py-1 text-xs">
                        {h}
                      </li>
                    ))}
                  </ul>
                  <span className="mt-7 inline-flex items-center gap-2 text-sm font-semibold text-gold-light transition-all group-hover:gap-3">
                    Conocer más <ArrowIcon />
                  </span>
                </div>
              </Link>
            ))}
          </div>

          <ul className="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {rest.map((t) => (
              <li key={t.slug}>
                <Link
                  href={`/tratamientos/${t.slug}`}
                  className="group flex h-full flex-col rounded-3xl border border-ink/10 bg-ivory p-6 transition hover:-translate-y-1 hover:border-teal/40 hover:shadow-lg hover:shadow-ink/5"
                >
                  <h3 className="text-xl">{t.name}</h3>
                  <p className="mt-2 flex-1 text-sm leading-relaxed text-cocoa">{t.short}</p>
                  <span className="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-teal">
                    Ver más <ArrowIcon />
                  </span>
                </Link>
              </li>
            ))}
          </ul>
        </div>
      </section>

      {/* POR QUÉ ELEGIRNOS */}
      <section className="py-20 sm:py-28" aria-labelledby="nosotros">
        <div className="container-x grid gap-14 lg:grid-cols-2 lg:items-center">
          <div className="relative">
            <img
              src="/img/blanqueamiento-3.webp"
              alt="Sonrisa luminosa luego de un tratamiento estético"
              width={1000}
              height={667}
              loading="lazy"
              className="aspect-[4/3] w-full rounded-4xl object-cover"
            />
            <div className="absolute -bottom-8 right-4 hidden max-w-60 rounded-3xl bg-ink p-6 text-cream sm:block">
              <p className="font-serif text-2xl leading-snug">“Una sonrisa sana también es una sonrisa linda.”</p>
            </div>
          </div>
          <div>
            <p className="eyebrow">Por qué elegirnos</p>
            <h2 id="nosotros" className="mt-4 text-4xl leading-tight sm:text-5xl">
              Cuidado integral, con mirada estética
            </h2>
            <p className="mt-5 text-lg leading-relaxed text-cocoa">
              Nos especializamos en el cuidado completo de tu salud bucal: limpiezas, tratamiento de caries, estética dental, diseño de sonrisa, carillas, implantes y ortopedia.
            </p>
            <ul className="mt-9 grid gap-6 sm:grid-cols-2">
              {values.map((v) => (
                <li key={v.title} className="flex gap-3">
                  <span className="mt-0.5 grid size-7 shrink-0 place-items-center rounded-full bg-teal-soft text-teal">
                    <CheckIcon />
                  </span>
                  <div>
                    <h3 className="font-sans text-base font-semibold">{v.title}</h3>
                    <p className="mt-1 text-sm leading-relaxed text-cocoa">{v.text}</p>
                  </div>
                </li>
              ))}
            </ul>
            <Link href="/nosotros" className="btn-outline mt-10">
              Conocé la clínica <ArrowIcon />
            </Link>
          </div>
        </div>
      </section>

      {/* CÓMO ES TU PRIMERA CONSULTA */}
      <section className="bg-sand/50 py-20 sm:py-24" aria-labelledby="pasos">
        <div className="container-x">
          <p className="eyebrow">Simple y sin vueltas</p>
          <h2 id="pasos" className="mt-4 max-w-2xl text-4xl leading-tight sm:text-5xl">
            Cómo es tu primera visita
          </h2>
          <ol className="mt-12 grid gap-6 md:grid-cols-3">
            {steps.map((s) => (
              <li key={s.n} className="rounded-3xl bg-ivory p-8">
                <span className="font-serif text-5xl text-gold">{s.n}</span>
                <h3 className="mt-4 text-2xl">{s.title}</h3>
                <p className="mt-2 leading-relaxed text-cocoa">{s.text}</p>
              </li>
            ))}
          </ol>
        </div>
      </section>

      {/* UBICACIÓN */}
      <section className="py-20 sm:py-24" aria-labelledby="ubicacion">
        <div className="container-x grid gap-10 rounded-4xl border border-ink/10 bg-cream p-8 sm:p-12 md:grid-cols-2 md:items-center">
          <div>
            <p className="eyebrow">Dónde estamos</p>
            <h2 id="ubicacion" className="mt-4 text-4xl leading-tight">
              En el centro de Villa Carlos Paz
            </h2>
            <p className="mt-4 text-lg text-cocoa">
              {site.address.street}, {site.address.city}, {site.address.region}.
            </p>
            <a href={site.mapsUrl} target="_blank" rel="noopener" className="btn-primary mt-8">
              <PinIcon className="size-4" /> Cómo llegar
            </a>
          </div>
          <dl className="divide-y divide-ink/10 rounded-3xl bg-ivory px-6">
            {site.hours.map((h) => (
              <div key={h.days} className="flex justify-between gap-4 py-5">
                <dt className="font-semibold">{h.days}</dt>
                <dd className="text-cocoa">{h.time}</dd>
              </div>
            ))}
            <div className="flex justify-between gap-4 py-5">
              <dt className="font-semibold">Domingos</dt>
              <dd className="text-cocoa">Cerrado</dd>
            </div>
          </dl>
        </div>
      </section>

      <CtaBand />
    </>
  );
}
