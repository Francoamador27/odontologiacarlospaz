import Link from "next/link";

export default function PageHero({
  eyebrow,
  title,
  intro,
  crumbs,
}: {
  eyebrow: string;
  title: string;
  intro?: string;
  crumbs: { href: string; label: string }[];
}) {
  return (
    <section className="bg-cream">
      <div className="container-x pb-14 pt-10 sm:pb-20 sm:pt-14">
        <nav aria-label="Ruta de navegación" className="text-sm text-cocoa">
          <ol className="flex flex-wrap items-center gap-2">
            <li>
              <Link href="/" className="hover:text-teal">
                Inicio
              </Link>
            </li>
            {crumbs.map((c, i) => (
              <li key={c.href} className="flex items-center gap-2">
                <span aria-hidden="true">/</span>
                {i === crumbs.length - 1 ? (
                  <span aria-current="page" className="text-ink">
                    {c.label}
                  </span>
                ) : (
                  <Link href={c.href} className="hover:text-teal">
                    {c.label}
                  </Link>
                )}
              </li>
            ))}
          </ol>
        </nav>
        <p className="eyebrow mt-10">{eyebrow}</p>
        <h1 className="mt-5 max-w-3xl text-4xl leading-[1.08] sm:text-6xl">{title}</h1>
        {intro && <p className="mt-6 max-w-2xl text-lg leading-relaxed text-cocoa">{intro}</p>}
      </div>
    </section>
  );
}
