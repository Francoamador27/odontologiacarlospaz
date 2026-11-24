import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { getTreatment, treatments } from "@/lib/treatments";
import { site, whatsappLink } from "@/lib/site";
import PageHero from "@/components/PageHero";
import CtaBand from "@/components/CtaBand";
import JsonLd from "@/components/JsonLd";
import { ArrowIcon, CheckIcon, WhatsAppIcon } from "@/components/icons";

/* eslint-disable @next/next/no-img-element */

type Props = { params: Promise<{ slug: string }> };

export const dynamicParams = false;

export function generateStaticParams() {
  return treatments.map((t) => ({ slug: t.slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const t = getTreatment((await params).slug);
  if (!t) return {};
  const path = `/tratamientos/${t.slug}`;
  return {
    title: t.seoTitle,
    description: t.seoDescription,
    alternates: { canonical: path },
    openGraph: { title: t.seoTitle, description: t.seoDescription, url: path, images: [{ url: t.image, alt: t.imageAlt }] },
  };
}

export default async function TreatmentPage({ params }: Props) {
  const t = getTreatment((await params).slug);
  if (!t) notFound();

  const url = `${site.url}/tratamientos/${t.slug}`;
  const message = `Hola, buen día. Quisiera consultar por ${t.name.toLowerCase()}.`;
  const others = treatments.filter((o) => o.slug !== t.slug).slice(0, 3);

  const schema: Record<string, unknown>[] = [
    {
      "@context": "https://schema.org",
      "@type": "MedicalWebPage",
      name: t.seoTitle,
      description: t.seoDescription,
      url,
      about: { "@type": "MedicalProcedure", name: t.name, description: t.intro },
      provider: { "@id": `${site.url}/#clinica` },
    },
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      itemListElement: [
        { "@type": "ListItem", position: 1, name: "Inicio", item: site.url },
        { "@type": "ListItem", position: 2, name: "Tratamientos", item: `${site.url}/tratamientos` },
        { "@type": "ListItem", position: 3, name: t.name, item: url },
      ],
    },
  ];
  if (t.faq) {
    schema.push({
      "@context": "https://schema.org",
      "@type": "FAQPage",
      mainEntity: t.faq.map((f) => ({ "@type": "Question", name: f.q, acceptedAnswer: { "@type": "Answer", text: f.a } })),
    });
  }

  return (
    <>
      <PageHero
        eyebrow="Tratamiento"
        title={`${t.name} en Villa Carlos Paz`}
        intro={t.short}
        crumbs={[
          { href: "/tratamientos", label: "Tratamientos" },
          { href: `/tratamientos/${t.slug}`, label: t.name },
        ]}
      />

      <section className="container-x grid gap-14 py-16 sm:py-20 lg:grid-cols-[1fr_22rem]">
        <article className="min-w-0">
          <img
            src={t.image}
            alt={t.imageAlt}
            width={1000}
            height={560}
            fetchPriority="high"
            className="aspect-[16/9] w-full rounded-4xl object-cover"
          />
          <p className="mt-10 text-xl leading-relaxed">{t.intro}</p>

          {t.sections.map((s) => (
            <section key={s.title} className="mt-12">
              <h2 className="text-3xl">{s.title}</h2>
              {s.body && <p className="mt-4 text-lg leading-relaxed text-cocoa">{s.body}</p>}
              {s.items && (
                <ul className="mt-5 space-y-4">
                  {s.items.map((item) => (
                    <li key={item} className="flex gap-3 text-lg leading-relaxed text-cocoa">
                      <span className="mt-1.5 grid size-6 shrink-0 place-items-center rounded-full bg-teal-soft text-teal">
                        <CheckIcon className="size-3.5" />
                      </span>
                      {item}
                    </li>
                  ))}
                </ul>
              )}
            </section>
          ))}

          {t.gallery && t.gallery.length > 1 && (
            <section className="mt-14">
              <h2 className="text-3xl">Resultados</h2>
              <div className="mt-6 grid gap-4 sm:grid-cols-2">
                {t.gallery.map((g) => (
                  <img key={g.src} src={g.src} alt={g.alt} width={1000} height={600} loading="lazy" className="aspect-[4/3] w-full rounded-3xl object-cover" />
                ))}
              </div>
            </section>
          )}

          {t.faq && (
            <section className="mt-14">
              <h2 className="text-3xl">Preguntas frecuentes</h2>
              <div className="mt-6 divide-y divide-ink/10 border-y border-ink/10">
                {t.faq.map((f) => (
                  <details key={f.q} className="group py-5">
                    <summary className="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-semibold">
                      {f.q}
                      <span aria-hidden="true" className="text-2xl font-light text-teal transition group-open:rotate-45">
                        +
                      </span>
                    </summary>
                    <p className="mt-3 leading-relaxed text-cocoa">{f.a}</p>
                  </details>
                ))}
              </div>
            </section>
          )}
        </article>

        <aside className="lg:sticky lg:top-28 lg:self-start">
          <div className="rounded-4xl bg-ink p-8 text-cream">
            <h2 className="text-2xl">Pedí tu turno</h2>
            <ul className="mt-5 space-y-3 text-sm text-cream/80">
              {t.highlights.map((h) => (
                <li key={h} className="flex gap-2.5">
                  <CheckIcon className="mt-0.5 size-4 shrink-0 text-gold-light" />
                  {h}
                </li>
              ))}
            </ul>
            <a href={whatsappLink(message)} target="_blank" rel="noopener" className="btn-light mt-8 w-full">
              <WhatsAppIcon className="size-4" /> Consultar por WhatsApp
            </a>
            <p className="mt-4 text-center text-xs text-cream/60">
              {site.hours[0].days} {site.hours[0].time} · {site.hours[1].days} {site.hours[1].time}
            </p>
          </div>
          <nav aria-label="Otros tratamientos" className="mt-8 rounded-4xl border border-ink/10 p-6">
            <h2 className="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-gold">Otros tratamientos</h2>
            <ul className="mt-4 divide-y divide-ink/10">
              {others.map((o) => (
                <li key={o.slug}>
                  <Link href={`/tratamientos/${o.slug}`} className="flex items-center justify-between py-3 hover:text-teal">
                    {o.name} <ArrowIcon />
                  </Link>
                </li>
              ))}
            </ul>
          </nav>
        </aside>
      </section>

      <CtaBand title={`¿Te interesa ${t.name.toLowerCase()}?`} message={message} />
      <JsonLd data={schema} />
    </>
  );
}
