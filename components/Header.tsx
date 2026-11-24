"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useEffect, useState } from "react";
import { site, whatsappLink } from "@/lib/site";
import { ToothMark, WhatsAppIcon } from "./icons";

const nav = [
  { href: "/tratamientos", label: "Tratamientos" },
  { href: "/tratamientos/blanqueamiento", label: "Blanqueamiento" },
  { href: "/tratamientos/carillas", label: "Carillas" },
  { href: "/nosotros", label: "Nosotros" },
  { href: "/contacto", label: "Contacto" },
];

export default function Header() {
  const [open, setOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const pathname = usePathname();

  useEffect(() => setOpen(false), [pathname]);
  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 12);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <header
      className={`sticky top-0 z-40 transition-colors duration-300 ${
        scrolled || open ? "bg-ivory/90 shadow-[0_1px_0_rgb(42_33_27/0.08)] backdrop-blur-md" : "bg-ivory"
      }`}
    >
      <div className="container-x flex h-18 items-center justify-between gap-6 py-3">
        <Link href="/" className="flex items-center gap-2.5 text-teal">
          <ToothMark className="size-9" />
          <span className="leading-none">
            <span className="block font-serif text-lg text-ink">Odontología</span>
            <span className="block text-[0.68rem] font-semibold uppercase tracking-[0.2em] text-cocoa">Villa Carlos Paz</span>
          </span>
        </Link>

        <nav aria-label="Principal" className="hidden lg:block">
          <ul className="flex items-center gap-8 text-sm font-medium">
            {nav.map((item) => {
              const active = pathname === item.href;
              return (
                <li key={item.href}>
                  <Link
                    href={item.href}
                    aria-current={active ? "page" : undefined}
                    className={`relative py-1 transition-colors hover:text-teal ${active ? "text-teal" : "text-ink/80"}`}
                  >
                    {item.label}
                  </Link>
                </li>
              );
            })}
          </ul>
        </nav>

        <div className="flex items-center gap-2">
          <a href={whatsappLink()} target="_blank" rel="noopener" className="btn-primary hidden !px-5 !py-2.5 sm:inline-flex">
            <WhatsAppIcon className="size-4" /> Pedir turno
          </a>
          <button
            type="button"
            className="grid size-11 place-items-center rounded-full border border-ink/15 lg:hidden"
            aria-expanded={open}
            aria-controls="menu-movil"
            aria-label={open ? "Cerrar menú" : "Abrir menú"}
            onClick={() => setOpen((v) => !v)}
          >
            <span className="relative block h-3 w-5">
              <span className={`absolute left-0 h-0.5 w-5 bg-ink transition ${open ? "top-1.5 rotate-45" : "top-0"}`} />
              <span className={`absolute left-0 h-0.5 w-5 bg-ink transition ${open ? "top-1.5 -rotate-45" : "top-3"}`} />
            </span>
          </button>
        </div>
      </div>

      <nav id="menu-movil" aria-label="Menú móvil" className={`lg:hidden ${open ? "block" : "hidden"}`}>
        <ul className="container-x flex flex-col gap-1 pb-6 pt-2">
          {nav.map((item) => (
            <li key={item.href}>
              <Link href={item.href} className="block rounded-xl px-3 py-3 font-serif text-2xl hover:bg-sand/60">
                {item.label}
              </Link>
            </li>
          ))}
          <li className="pt-3">
            <a href={whatsappLink()} target="_blank" rel="noopener" className="btn-primary w-full">
              <WhatsAppIcon className="size-4" /> Pedir turno por WhatsApp
            </a>
          </li>
        </ul>
      </nav>
    </header>
  );
}
