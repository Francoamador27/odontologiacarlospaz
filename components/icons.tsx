// Íconos SVG inline (sin librerías: 0 KB extra de JS).
type P = { className?: string };

export const WhatsAppIcon = ({ className = "size-5" }: P) => (
  <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" className={className}>
    <path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.22 3.08.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35zM12.05 21.5h-.01a9.43 9.43 0 0 1-4.8-1.31l-.35-.2-3.57.93.95-3.48-.22-.36a9.4 9.4 0 0 1-1.44-5.02c0-5.2 4.24-9.44 9.45-9.44a9.38 9.38 0 0 1 6.68 2.77 9.38 9.38 0 0 1 2.76 6.68c0 5.2-4.24 9.44-9.45 9.44zm8.04-17.48A11.3 11.3 0 0 0 12.05.7C5.78.7.68 5.8.68 12.06c0 2 .52 3.96 1.52 5.68L.58 23.7l6.1-1.6a11.33 11.33 0 0 0 5.37 1.37h.01c6.26 0 11.36-5.1 11.36-11.36 0-3.04-1.18-5.89-3.33-8.04z" />
  </svg>
);

const stroke = { fill: "none", stroke: "currentColor", strokeWidth: 1.6, strokeLinecap: "round", strokeLinejoin: "round" } as const;

export const PhoneIcon = ({ className = "size-5" }: P) => (
  <svg viewBox="0 0 24 24" {...stroke} aria-hidden="true" className={className}>
    <path d="M5 4h3l2 5-2.5 1.5a11 11 0 0 0 6 6L15 14l5 2v3a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2" />
  </svg>
);
export const PinIcon = ({ className = "size-5" }: P) => (
  <svg viewBox="0 0 24 24" {...stroke} aria-hidden="true" className={className}>
    <path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z" />
    <circle cx="12" cy="9.5" r="2.5" />
  </svg>
);
export const ClockIcon = ({ className = "size-5" }: P) => (
  <svg viewBox="0 0 24 24" {...stroke} aria-hidden="true" className={className}>
    <circle cx="12" cy="12" r="9" />
    <path d="M12 7v5l3 2" />
  </svg>
);
export const MailIcon = ({ className = "size-5" }: P) => (
  <svg viewBox="0 0 24 24" {...stroke} aria-hidden="true" className={className}>
    <rect x="3" y="5" width="18" height="14" rx="2" />
    <path d="m3 7 9 6 9-6" />
  </svg>
);
export const ArrowIcon = ({ className = "size-4" }: P) => (
  <svg viewBox="0 0 24 24" {...stroke} aria-hidden="true" className={className}>
    <path d="M5 12h14M13 6l6 6-6 6" />
  </svg>
);
export const CheckIcon = ({ className = "size-4" }: P) => (
  <svg viewBox="0 0 24 24" {...stroke} strokeWidth={2} aria-hidden="true" className={className}>
    <path d="m5 12.5 4.5 4.5L19 7.5" />
  </svg>
);
export const SparkIcon = ({ className = "size-5" }: P) => (
  <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" className={className}>
    <path d="M12 2c.4 4.6 2.4 7.6 8 10-5.6 2.4-7.6 5.4-8 10-.4-4.6-2.4-7.6-8-10 5.6-2.4 7.6-5.4 8-10z" />
  </svg>
);
export const ToothMark = ({ className = "size-8" }: P) => (
  <svg viewBox="0 0 40 40" aria-hidden="true" className={className}>
    <path d="M8 13c0-5 4-7 7.5-6.2 2.2.5 3.2 1.4 4.5 1.4s2.3-.9 4.5-1.4C28 6 32 8 32 13" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" />
    <path d="M10 18c.5 7 2.2 15 5 15 2.4 0 2.2-7 5-7s2.6 7 5 7c2.8 0 4.5-8 5-15" fill="none" stroke="currentColor" strokeOpacity=".55" strokeWidth="3" strokeLinecap="round" />
    <path d="M28.5 4c.2 1.8 1 2.8 3 3.5-2 .7-2.8 1.7-3 3.5-.2-1.8-1-2.8-3-3.5 2-.7 2.8-1.7 3-3.5z" fill="var(--color-gold)" />
  </svg>
);
