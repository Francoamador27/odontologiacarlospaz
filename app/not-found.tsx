import Link from "next/link";

export default function NotFound() {
  return (
    <section className="container-x py-28 text-center">
      <p className="eyebrow justify-center">Error 404</p>
      <h1 className="mt-6 text-5xl">No encontramos esta página</h1>
      <p className="mx-auto mt-4 max-w-md text-lg text-cocoa">Puede que se haya movido. Probá desde el inicio o mirá nuestros tratamientos.</p>
      <div className="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
        <Link href="/" className="btn-primary">
          Ir al inicio
        </Link>
        <Link href="/tratamientos" className="btn-outline">
          Ver tratamientos
        </Link>
      </div>
    </section>
  );
}
