// Tratamientos. Cada uno genera su propia página en /tratamientos/<slug>
// con título, descripción y datos estructurados propios (mejor SEO).
//
// Blanqueamiento y Carillas conservan el texto del sitio anterior.
// El resto es texto base: revisalo con el/la odontólogo/a antes de publicar.

export type Treatment = {
  slug: string;
  name: string;
  short: string;
  seoTitle: string;
  seoDescription: string;
  image: string;
  imageAlt: string;
  highlights: string[];
  intro: string;
  sections: { title: string; body?: string; items?: string[] }[];
  faq?: { q: string; a: string }[];
  gallery?: { src: string; alt: string }[];
};

export const treatments: Treatment[] = [
  {
    slug: "blanqueamiento",
    name: "Blanqueamiento dental",
    short: "Una sonrisa varios tonos más luminosa, en consultorio o en casa, siempre con supervisión profesional.",
    seoTitle: "Blanqueamiento dental en Villa Carlos Paz",
    seoDescription:
      "Blanqueamiento dental profesional en Villa Carlos Paz: en consultorio o ambulatorio, resultados visibles y seguros. Pedí tu turno por WhatsApp.",
    image: "/img/blanqueamiento-1.webp",
    imageAlt: "Comparación antes y después de un blanqueamiento dental",
    highlights: ["Resultados desde la primera sesión", "Opciones para dientes sensibles", "Supervisado por profesionales"],
    intro:
      "El blanqueamiento dental es un procedimiento estético que mejora la apariencia de los dientes. Existen dos técnicas principales: el blanqueamiento en consultorio y el ambulatorio. Ambas ofrecen resultados efectivos y se adaptan a las necesidades y preferencias de cada paciente.",
    sections: [
      {
        title: "Técnicas de blanqueamiento",
        items: [
          "En consultorio: se realiza bajo la supervisión del odontólogo con agentes blanqueadores más concentrados. Suele requerir una sola sesión y los resultados son inmediatos.",
          "Ambulatorio: te entregamos un kit personalizado para usar en casa. Los resultados llegan de forma más gradual, con mayor comodidad y control.",
        ],
      },
      {
        title: "Cuidados posteriores",
        items: [
          "Evitar alimentos y bebidas que manchan, como café, té, vino tinto y colorantes, sobre todo las primeras semanas.",
          "Cepillarse al menos dos veces al día y usar hilo dental.",
          "Hacer controles periódicos para mantener el resultado.",
        ],
      },
      {
        title: "Antes de empezar",
        body:
          "Te recomendamos una consulta previa para confirmar que el tratamiento es adecuado para vos. Algunas personas sienten una sensibilidad temporal después del blanqueamiento; suele ser leve y pasa rápido.",
      },
    ],
    faq: [
      {
        q: "¿El café mancha los dientes después del blanqueamiento?",
        a: "Con buena higiene, el café no debería manchar tus dientes. Igualmente, conviene moderar su consumo las primeras semanas.",
      },
      {
        q: "¿Cuánto dura el blanqueamiento?",
        a: "Depende de tus hábitos de alimentación e higiene, pero en general los resultados duran entre 6 meses y 2 años.",
      },
      {
        q: "¿Es seguro?",
        a: "Sí. Realizado bajo supervisión profesional, el blanqueamiento es seguro. Es fundamental seguir las indicaciones del odontólogo.",
      },
      {
        q: "¿Puedo hacerlo si tengo dientes sensibles?",
        a: "Consultanos. Existen opciones de blanqueamiento pensadas para personas con sensibilidad dental.",
      },
    ],
    gallery: [
      { src: "/img/blanqueamiento-1.webp", alt: "Antes y después de blanqueamiento dental" },
      { src: "/img/blanqueamiento-3.webp", alt: "Sonrisa luego de un blanqueamiento dental" },
    ],
  },
  {
    slug: "carillas",
    name: "Carillas estéticas",
    short: "Láminas finas de resina que corrigen color, forma y pequeñas imperfecciones en una sola visita.",
    seoTitle: "Carillas de resina en Villa Carlos Paz",
    seoDescription:
      "Carillas de resina en Villa Carlos Paz: corregí manchas, desgastes y forma de tus dientes con un resultado natural. Consultá por WhatsApp.",
    image: "/img/carillas-1.webp",
    imageAlt: "Dientes con carillas de resina de aspecto natural",
    highlights: ["Aspecto natural", "Generalmente en una sola visita", "Mínimamente invasivas"],
    intro:
      "Las carillas de resina son finas capas de material compuesto que se adhieren a la cara frontal de los dientes para corregir imperfecciones como manchas, desgastes o desalineaciones. Son una solución no invasiva que brinda resultados inmediatos y una sonrisa más armónica.",
    sections: [
      {
        title: "Ventajas",
        items: [
          "Aspecto natural: se personalizan para que coincidan con el color de tus dientes.",
          "Procedimiento rápido: generalmente se completa en una sola visita.",
          "Menos invasivas: requieren menos preparación que las carillas de porcelana.",
        ],
      },
      {
        title: "Cuidados y mantenimiento",
        body:
          "Para que tus carillas se mantengan como el primer día: buena higiene bucal, controles regulares y moderar los alimentos que pueden manchar la resina.",
      },
      {
        title: "¿Son para vos?",
        body:
          "Si querés mejorar la estética de tu sonrisa, las carillas pueden ser una excelente opción. En la consulta evaluamos tu caso y te contamos si son adecuadas para vos.",
      },
    ],
    gallery: [
      { src: "/img/carillas-1.webp", alt: "Resultado de carillas de resina" },
      { src: "/img/carillas-2.webp", alt: "Sonrisa con carillas estéticas" },
    ],
  },
  {
    slug: "diseno-de-sonrisa",
    name: "Diseño de sonrisa",
    short: "Un plan estético integral que combina tratamientos para lograr una sonrisa armónica con tu rostro.",
    seoTitle: "Diseño de sonrisa y estética dental en Villa Carlos Paz",
    seoDescription:
      "Diseño de sonrisa en Villa Carlos Paz: planificamos tu sonrisa combinando blanqueamiento, carillas y estética dental. Pedí tu evaluación.",
    image: "/img/estetica.webp",
    imageAlt: "Odontóloga realizando un tratamiento de estética dental",
    highlights: ["Plan personalizado", "Resultados armónicos", "Combina varios tratamientos"],
    intro:
      "El diseño de sonrisa es una planificación estética integral. Analizamos la forma, el color y la proporción de tus dientes en relación con tu rostro para proponerte un plan a medida.",
    sections: [
      {
        title: "Cómo trabajamos",
        items: [
          "Evaluación inicial y fotografías de tu sonrisa.",
          "Propuesta de tratamiento: puede incluir blanqueamiento, carillas, contorneado o restauraciones.",
          "Ejecución por etapas, con controles en cada paso.",
        ],
      },
    ],
  },
  {
    slug: "implantes",
    name: "Implantes dentales",
    short: "Reemplazá piezas perdidas con una solución fija, duradera y de aspecto natural.",
    seoTitle: "Implantes dentales en Villa Carlos Paz",
    seoDescription:
      "Implantes dentales en Villa Carlos Paz: recuperá la función y la estética de tu sonrisa con una solución fija y duradera. Consultá tu caso.",
    image: "/img/implantes.webp",
    imageAlt: "Tratamiento de implantes dentales",
    highlights: ["Solución duradera", "Mejora estética", "Función masticatoria restaurada"],
    intro:
      "Un implante dental reemplaza la raíz de una pieza perdida y sostiene una corona fija. Devuelve la función al masticar y la estética de la sonrisa, sin afectar a los dientes vecinos.",
    sections: [
      {
        title: "Beneficios",
        items: [
          "Se ven y se sienten como dientes naturales.",
          "Ayudan a preservar el hueso de la zona.",
          "No requieren desgastar los dientes vecinos.",
        ],
      },
      {
        title: "El proceso",
        body:
          "Comienza con una evaluación clínica y radiográfica para planificar el tratamiento. Los tiempos dependen de cada caso; en la consulta te explicamos cada etapa.",
      },
    ],
  },
  {
    slug: "endodoncia",
    name: "Tratamiento de conducto",
    short: "Aliviamos el dolor y conservamos tu diente natural, evitando extracciones.",
    seoTitle: "Tratamiento de conducto (endodoncia) en Villa Carlos Paz",
    seoDescription:
      "Endodoncia en Villa Carlos Paz: aliviá el dolor dental y conservá tu pieza natural con un tratamiento de conducto. Turnos por WhatsApp.",
    image: "/img/endodoncia.webp",
    imageAlt: "Tratamiento de conducto en consultorio",
    highlights: ["Alivio del dolor", "Previene extracciones", "Restauración completa"],
    intro:
      "La endodoncia o tratamiento de conducto trata el interior del diente cuando el nervio está inflamado o infectado. Permite eliminar el dolor y conservar la pieza natural.",
    sections: [
      {
        title: "¿Cuándo se necesita?",
        items: [
          "Dolor intenso o persistente en una pieza.",
          "Sensibilidad prolongada al frío o al calor.",
          "Caries profundas o golpes que afectaron el nervio.",
        ],
      },
    ],
  },
  {
    slug: "odontologia-general",
    name: "Odontología general",
    short: "Limpiezas, controles y tratamiento de caries para mantener tu boca sana todo el año.",
    seoTitle: "Odontología general y limpiezas dentales en Villa Carlos Paz",
    seoDescription:
      "Odontología general en Villa Carlos Paz: limpiezas, controles, tratamiento de caries y prevención para toda la familia.",
    image: "/img/limpieza.webp",
    imageAlt: "Control odontológico de rutina",
    highlights: ["Limpiezas profesionales", "Tratamiento de caries", "Prevención para toda la familia"],
    intro:
      "La base de una sonrisa linda es una boca sana. Hacemos controles, limpiezas y tratamientos de caries para prevenir problemas y detectarlos a tiempo.",
    sections: [
      {
        title: "Incluye",
        items: [
          "Limpieza dental profesional y remoción de sarro.",
          "Tratamiento de caries y restauraciones.",
          "Controles periódicos y consejos de higiene.",
        ],
      },
    ],
  },
];

export function getTreatment(slug: string) {
  return treatments.find((t) => t.slug === slug);
}
