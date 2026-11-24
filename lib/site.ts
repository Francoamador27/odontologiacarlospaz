// Datos centrales de la clínica. Cambiá acá y se actualiza todo el sitio
// (header, footer, contacto, datos estructurados para Google, etc.).

export const site = {
  name: "Odontología Carlos Paz",
  legalName: "Odontología Integral y Estética — Villa Carlos Paz",
  url: "https://odontologiacarlospaz.com.ar",
  description:
    "Clínica odontológica en Villa Carlos Paz especializada en estética dental: blanqueamiento, carillas, implantes, diseño de sonrisa y odontología general.",
  email: "odcapellan@gmail.com",
  phoneDisplay: "351 807-8727",
  phoneE164: "+543518078727",
  whatsapp: "5493518078727",
  address: {
    street: "Carlos Pellegrini 464",
    city: "Villa Carlos Paz",
    region: "Córdoba",
    postalCode: "X5152",
    country: "AR",
  },
  geo: { lat: -31.4161344, lng: -64.5009265 },
  mapsUrl:
    "https://www.google.com/maps/place/Carlos+Pellegrini+464,+X5152+Villa+Carlos+Paz,+C%C3%B3rdoba/@-31.4161344,-64.5035068,17z",
  mapsEmbed:
    "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3404.927106123145!2d-64.50350678881348!3d-31.416134374154527!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x942d6640277f2339%3A0x7d7530f4f8b4d18!2sCarlos%20Pellegrini%20464%2C%20X5152%20Villa%20Carlos%20Paz%2C%20C%C3%B3rdoba!5e0!3m2!1ses-419!2sar!4v1727832047584!5m2!1ses-419!2sar",
  hours: [
    { days: "Lunes a viernes", time: "8:00 – 19:00", schema: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"], opens: "08:00", closes: "19:00" },
    { days: "Sábados", time: "8:00 – 13:00", schema: ["Saturday"], opens: "08:00", closes: "13:00" },
  ],
  analytics: {
    gtm: "GTM-MX226SRQ",
    ga4: "G-5GM93J9EFN",
    googleAds: "AW-386281090",
    adsConversion: "AW-386281090/tA4wCOiXlbsYEILdmLgB",
  },
} as const;

export function whatsappLink(message = "Hola, buen día. Quisiera agendar un turno.") {
  return `https://wa.me/${site.whatsapp}?text=${encodeURIComponent(message)}`;
}
