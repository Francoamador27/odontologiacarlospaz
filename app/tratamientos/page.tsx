import type { Metadata } from "next";
import Link from "next/link";
import { treatments } from "@/lib/treatments";
import PageHero from "@/components/PageHero";
import CtaBand from "@/components/CtaBand";
import { ArrowIcon } from "@/components/icons";

/* eslint-disable @next/next/no-img-element */

export const metadata: Metadata = {
  title: "Tratamientos odontológicos en Villa Carlos Paz",
  description:
    "Blanqueamiento, carillas, diseño de sonrisa, implantes, endodoncia y odontología general en Villa Carlos Paz. Conocé cada tratamiento.",
  alternates: { canonical: "/tratamientos" },
};

export default function Tratamientos() {
  return (
    <>
      <PageHero
        eyebrow="Tratamientos"
        title="Todo lo que tu sonrisa necesita, en un solo lugar"
        intro="Desde controles y limpiezas hasta estética dental avanzada. Elegí un tratamiento para conocer cómo es, cuánto dura y qué cuidados requiere."
        crumbs={[{ href: "/tratamientos", label: "Tratamientos" }]}
      />
      <section className="container-x py-16 sm:py-24">
        <ul className="grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
          {treatments.map((t) => (
            <li key={t.slug}>
              <Link href={`/tratamientos/${t.slug}`} className="group block">
                <div className="aspect-[5/4] overflow-hidden rounded-3xl bg-sand">
                  <img
                    src={t.image}
                    alt={t.imageAlt}
                    width={800}
                    height={640}
                    loading="lazy"
                    className="size-full object-cover transition duration-700 group-hover:scale-105"
                  />
                </div>
                <h2 className="mt-5 text-2xl group-hover:text-teal">{t.name}</h2>
                <p className="mt-2 leading-relaxed text-cocoa">{t.short}</p>
                <span className="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-teal transition-all group-hover:gap-3">
                  Ver tratamiento <ArrowIcon />
                </span>
              </Link>
            </li>
          ))}
        </ul>
      </section>
      <CtaBand title="¿No sabés qué tratamiento necesitás?" text="Contanos qué te gustaría mejorar y te orientamos en la consulta." />
    </>
  );
}
