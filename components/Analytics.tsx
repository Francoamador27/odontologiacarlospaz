import Script from "next/script";
import { site } from "@/lib/site";

// Google Tag Manager + GA4 + Google Ads, con los mismos IDs del sitio anterior.
//
// Estos scripts pesan ~650 KB y bloquean el navegador más de 1 segundo en
// celulares. Para no castigar la velocidad (ni el SEO), se cargan recién con la
// primera interacción del usuario: scroll, toque, click o tecla.
// La conversión de Google Ads se registra igual, apenas cargan.
export default function Analytics() {
  const { gtm, ga4, googleAds, adsConversion } = site.analytics;
  const code = `
(function(){
  var loaded=false, ev=['scroll','pointerdown','touchstart','keydown','mousemove'];
  function load(){
    if(loaded) return; loaded=true;
    ev.forEach(function(e){removeEventListener(e,load,{passive:true})});
    window.dataLayer=window.dataLayer||[];
    window.gtag=function(){dataLayer.push(arguments)};
    dataLayer.push({'gtm.start':Date.now(),event:'gtm.js'});
    gtag('js',new Date());
    gtag('config','${ga4}');
    gtag('config','${googleAds}');
    gtag('event','conversion',{send_to:'${adsConversion}'});
    ['https://www.googletagmanager.com/gtm.js?id=${gtm}','https://www.googletagmanager.com/gtag/js?id=${ga4}'].forEach(function(src){
      var s=document.createElement('script'); s.async=true; s.src=src; document.head.appendChild(s);
    });
  }
  ev.forEach(function(e){addEventListener(e,load,{passive:true,once:true})});
})();`;
  return (
    <Script id="analytics-on-interaction" strategy="afterInteractive">
      {code}
    </Script>
  );
}
