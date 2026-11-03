// Koľko okna zakrýva cookie banner pri prvej návšteve.
//
// Pre každý jazyk a okno vypíše výšku banneru v px a v percentách výšky okna
// a či sú obe tlačidlá celé v okne. LOCAL_ROOT podsunie lokálny CSS a JS,
// takže zmenu možno porovnať s produkciou pred nasadením. Jeden prehliadač
// s cache, takže po prvom načítaní idú na server takmer iba HTML požiadavky.
//
// Premenné: LANGS (sk,hu), VIEWPORTS (desktop,mobile,narrow,tiny,landscape),
// LIMIT (percento, nad ktorým je beh nález; predvolene 50).

import {
  BASE,
  launch,
  newLog,
  newPage,
  resetState,
  gotoWithRetry,
  sleep,
} from "./lib.mjs";

const VIEWPORTS = {
  desktop: { width: 1280, height: 800 },
  mobile: { width: 390, height: 844, isMobile: true, hasTouch: true },
  narrow: { width: 320, height: 640, isMobile: true, hasTouch: true },
  tiny: { width: 320, height: 568, isMobile: true, hasTouch: true },
  landscape: { width: 667, height: 375, isMobile: true, hasTouch: true },
};
const pick = (name, fallback) =>
  (process.env[name] || fallback)
    .split(",")
    .map((value) => value.trim())
    .filter(Boolean);

const langs = pick("LANGS", "sk,hu");
const viewports = pick("VIEWPORTS", "desktop,mobile,narrow,tiny,landscape");
const LIMIT = Number(process.env.LIMIT || 50);

const { browser, ua } = await launch();
let findings = 0;
let invalid = 0;

try {
  for (const lang of langs) {
    for (const name of viewports) {
      const log = newLog();
      const page = await newPage(browser, ua, log, VIEWPORTS[name]);
      await resetState(page);
      await gotoWithRetry(page, `${BASE}/?lang=${lang}`);
      await sleep(900);
      const m = await page.evaluate(() => {
        const banner = document.querySelector(".cookie-banner");
        if (!banner || getComputedStyle(banner).display === "none") return null;
        const r = banner.getBoundingClientRect();
        const inView = (el) => {
          const b = el.getBoundingClientRect();
          return b.top >= 0 && b.bottom <= innerHeight + 0.5;
        };
        const buttons = [...banner.querySelectorAll("button")];
        return {
          height: Math.round(r.height),
          share: Math.round((r.height / innerHeight) * 100),
          buttons: buttons.length,
          buttonsInView: buttons.filter(inView).length,
          scrolls: banner.scrollHeight > banner.clientHeight + 1,
        };
      });
      // Rozmer banneru ovplyvní iba 429 na stránku, štýly, skripty a písma;
      // chýbajúci obrázok alebo ikona ho nezmení.
      const limited = log.bad.filter(
        (entry) =>
          [429, 503].includes(entry.status) &&
          /(\.(css|js|woff2)(\?|$))|(\/(\?|$))|(\.php(\?|$))/.test(
            new URL(entry.url).pathname + new URL(entry.url).search,
          ),
      ).length;
      await page.close();
      const where = `${lang} ${name} ${VIEWPORTS[name].width}×${VIEWPORTS[name].height}`;
      if (limited) {
        invalid += 1;
        console.log(`${where}: NEPLATNÉ (${limited}× 429/503)`);
      } else if (!m) {
        findings += 1;
        console.log(`${where}: banner sa nezobrazil`);
      } else {
        const bad = m.share > LIMIT || m.buttonsInView < m.buttons;
        if (bad) findings += 1;
        console.log(
          `${where}: ${m.height} px = ${m.share} % okna, tlačidlá v okne ${m.buttonsInView}/${m.buttons}${m.scrolls ? ", banner sa posúva" : ""}${bad ? "  NÁLEZ" : ""}`,
        );
      }
      await sleep(2500);
    }
  }
} finally {
  await browser.close();
}

if (invalid) console.log(`Neplatných behov (limit hostingu): ${invalid}`);
console.log(findings ? `BANNER NÁLEZY (${findings})` : "BANNER OK");
process.exitCode = findings ? 1 : invalid ? 2 : 0;
