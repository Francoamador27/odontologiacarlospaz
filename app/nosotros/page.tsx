import type { Metadata } from "next";
import Link from "next/link";
import PageHero from "@/components/PageHero";
import CtaBand from "@/components/CtaBand";
import { ArrowIcon } from "@/components/icons";

/* eslint-disable @next/next/no-img-element */

export const metadata: Metadata = {
  title: "Sobre nosotros — Clínica dental en Villa Carlos Paz",
  description:
    "Conocé nuestra clínica de odontología integral y estética en Villa Carlos Paz: atención personalizada, tecnología y resultados naturales.",
  alternates: { canonical: "/nosotros" },
};

const pillars = [
  { title: "Odontología integral", text: "Limpiezas, caries, endodoncia, implantes y ortopedia: cuidamos tu salud bucal completa." },
  { title: "Mirada estética", text: "Diseño de sonrisa, carillas y blanqueamiento con resultados que se ven naturales." },
  { title: "Trato cercano", text: "Te explicamos cada paso, respetamos tus tiempos y te acompañamos en el seguimiento." },
];

export default function Nosotros() {
  return (
    <>
      <PageHero
        eyebrow="Sobre nosotros"
        title="Una clínica pensada para que te sientas cómodo"
        intro="Somos una clínica odontológica en Villa Carlos Paz con un equipo especializado en distintas áreas de la odontología. Nos dedicamos a mejorar la salud y la estética de tu sonrisa con tratamientos personalizados y tecnología actual."
        crumbs={[{ href: "/nosotros", label: "Nosotros" }]}
      />

      <section className="container-x grid gap-12 py-16 sm:py-24 lg:grid-cols-2 lg:items-center">
        <img
          src="/img/hero.webp"
          alt="Odontóloga atendiendo a un paciente en la clínica"
          width={1600}
          height={900}
          fetchPriority="high"
          className="aspect-[4/3] w-full rounded-4xl object-cover"
        />
        <div>
          <h2 className="text-4xl leading-tight">Cuidado dental profesional en Villa Carlos Paz</h2>
          <p className="mt-5 text-lg leading-relaxed text-cocoa">
            Utilizamos equipos modernos y técnicas actuales para garantizar la mejor atención. Nuestro objetivo es que cada paciente se vaya con una sonrisa sana, linda y con la tranquilidad de haber sido bien atendido.
          </p>
          <Link href="/tratamientos" className="btn-outline mt-8">
            Ver tratamientos <ArrowIcon />
          </Link>
        </div>
      </section>

      <section className="bg-cream py-20">
        <ul className="container-x grid gap-6 md:grid-cols-3">
          {pillars.map((p, i) => (
            <li key={p.title} className="rounded-3xl bg-ivory p-8">
              <span className="font-serif text-5xl text-gold">0{i + 1}</span>
              <h2 className="mt-4 text-2xl">{p.title}</h2>
              <p className="mt-2 leading-relaxed text-cocoa">{p.text}</p>
            </li>
          ))}
        </ul>
      </section>

      <CtaBand />
    </>
  );
}
