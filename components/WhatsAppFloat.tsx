import { whatsappLink } from "@/lib/site";
import { WhatsAppIcon } from "./icons";

export default function WhatsAppFloat() {
  return (
    <a
      href={whatsappLink()}
      target="_blank"
      rel="noopener"
      className="fixed bottom-5 right-5 z-50 flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-3.5 text-sm font-semibold text-[#073b1e] shadow-lg shadow-ink/20 transition hover:scale-105 sm:bottom-7 sm:right-7"
    >
      <WhatsAppIcon className="size-6" />
      <span className="sr-only sm:not-sr-only">¿Consultas? Escribinos</span>
    </a>
  );
}
