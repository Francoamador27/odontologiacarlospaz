import type { Metadata, Viewport } from "next";
import { Fraunces, Manrope } from "next/font/google";
import "./globals.css";
import Header from "@/components/Header";
import Footer from "@/components/Footer";
import WhatsAppFloat from "@/components/WhatsAppFloat";
import Analytics from "@/components/Analytics";
import JsonLd from "@/components/JsonLd";
import { site } from "@/lib/site";
import { treatments } from "@/lib/treatments";

// Las fuentes se descargan al compilar y se sirven desde el mismo dominio
// (sin pedidos a Google Fonts en el navegador).
const fraunces = Fraunces({ subsets: ["latin"], variable: "--font-fraunces", weight: ["400", "500"], style: ["normal", "italic"], display: "swap" });
const manrope = Manrope({ subsets: ["latin"], variable: "--font-manrope", display: "swap" });

export const metadata: Metadata = {
  metadataBase: new URL(site.url),
  title: {
    default: "Clínica dental en Villa Carlos Paz | Odontología integral y estética",
    template: `%s | ${site.name}`,
  },
  description: site.description,
  alternates: { canonical: "/" },
  openGraph: {
    type: "website",
    locale: "es_AR",
    siteName: site.name,
    url: site.url,
    images: [{ url: "/img/hero.webp", width: 1600, height: 900, alt: "Atención odontológica en Villa Carlos Paz" }],
  },
  twitter: { card: "summary_large_image" },
  robots: { index: true, follow: true },
  formatDetection: { telephone: false },
};

export const viewport: Viewport = {
  themeColor: "#fbf8f3",
};

const dentistSchema = {
  "@context": "https://schema.org",
  "@type": "Dentist",
  "@id": `${site.url}/#clinica`,
  name: site.name,
  alternateName: site.legalName,
  description: site.description,
  url: site.url,
  image: `${site.url}/img/hero.webp`,
  logo: `${site.url}/img/logo.webp`,
  telephone: site.phoneE164,
  email: site.email,
  priceRange: "$$",
  address: {
    "@type": "PostalAddress",
    streetAddress: site.address.street,
    addressLocality: site.address.city,
    addressRegion: site.address.region,
    postalCode: site.address.postalCode,
    addressCountry: site.address.country,
  },
  geo: { "@type": "GeoCoordinates", latitude: site.geo.lat, longitude: site.geo.lng },
  hasMap: site.mapsUrl,
  areaServed: ["Villa Carlos Paz", "Punilla", "Córdoba"],
  openingHoursSpecification: site.hours.map((h) => ({
    "@type": "OpeningHoursSpecification",
    dayOfWeek: h.schema,
    opens: h.opens,
    closes: h.closes,
  })),
  availableService: treatments.map((t) => ({
    "@type": "MedicalProcedure",
    name: t.name,
    url: `${site.url}/tratamientos/${t.slug}`,
  })),
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="es-AR" className={`${fraunces.variable} ${manrope.variable}`}>
      <body>
        <a href="#contenido" className="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-full focus:bg-ink focus:px-4 focus:py-2 focus:text-cream">
          Saltar al contenido
        </a>
        <Header />
        <main id="contenido">{children}</main>
        <Footer />
        <WhatsAppFloat />
        <JsonLd data={dentistSchema} />
        <Analytics />
      </body>
    </html>
  );
}
