// Pôvod posunov rozloženia (CLS) pri studenom načítaní.
//
// Každý beh má nový profil bez cache, takže meria prvú návštevu. Pre každý
// záznam `layout-shift` vypíše hodnotu, čas a zdroje (selektor prvku,
// pôvodný a nový obdĺžnik). LOCAL_ROOT podsunie lokálny css/styles.css
// a js/main.js, takže opravu možno overiť pred nasadením.
//
// Premenné: LANGS (predvolene uk), VIEWPORTS (desktop,mobile), PAGES (home),
// RUNS (1). Požiadavky idú postupne s prestávkou, kvôli limitu hostingu.

import { BASE, launch, newLog, newPage, gotoWithRetry, sleep } from "./lib.mjs";

const VIEWPORTS = {
  desktop: { width: 1280, height: 800 },
  mobile: { width: 390, height: 844, isMobile: true, hasTouch: true },
};
const PAGES = { home: "/", articles: "/articles.php", privacy: "/privacy.php" };
const UA_DESKTOP =
  "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36";
const UA_MOBILE =
  "Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Mobile Safari/537.36";

const pick = (name, fallback) =>
  (process.env[name] || fallback)
    .split(",")
    .map((value) => value.trim())
    .filter(Boolean);

const langs = pick("LANGS", "uk");
const viewports = pick("VIEWPORTS", "desktop,mobile");
const pages = pick("PAGES", "home");
const runs = Number(process.env.RUNS || 1);
const PAUSE_MS = Number(process.env.PAUSE_MS || 15000);

const { browser } = await launch();
let worst = 0;
let invalid = 0;
let valid = 0;
let first = true;

try {
  for (const pageName of pages) {
    for (const lang of langs) {
      for (const viewportName of viewports) {
        for (let run = 1; run <= runs; run += 1) {
          if (!first) await sleep(PAUSE_MS);
          first = false;
          const context = await browser.createBrowserContext();
          const log = newLog();
          const viewport = VIEWPORTS[viewportName];
          // newPage() patrí prehliadaču; studený profil dá nový kontext.
          const page = await newPage(
            { newPage: () => context.newPage() },
            viewport.isMobile ? UA_MOBILE : UA_DESKTOP,
            log,
            viewport,
          );
          await page.setCacheEnabled(false);
          await page.evaluateOnNewDocument(() => {
            window.__shifts = [];
            const describe = (node) => {
              if (!node || !node.tagName) return String(node && node.nodeName);
              let text = node.tagName.toLowerCase();
              if (node.id) text += `#${node.id}`;
              if (node.classList && node.classList.length)
                text += `.${[...node.classList].slice(0, 3).join(".")}`;
              return text;
            };
            const rect = (r) =>
              r ? `${Math.round(r.y)}+${Math.round(r.height)}` : "";
            new PerformanceObserver((list) => {
              for (const entry of list.getEntries()) {
                if (entry.hadRecentInput) continue;
                window.__shifts.push({
                  value: Number(entry.value.toFixed(4)),
                  t: Math.round(entry.startTime),
                  sources: (entry.sources || []).map((source) => ({
                    node: describe(source.node),
                    from: rect(source.previousRect),
                    to: rect(source.currentRect),
                  })),
                });
              }
            }).observe({ type: "layout-shift", buffered: true });
          });
          const url = `${BASE}${PAGES[pageName] || pageName}${
            (PAGES[pageName] || pageName).includes("?") ? "&" : "?"
          }lang=${lang}`;
          await gotoWithRetry(page, url);
          await sleep(1500);
          const shifts = await page.evaluate(() => window.__shifts);
          const total = shifts.reduce((sum, entry) => sum + entry.value, 0);
          // 429 alebo 503 na štýl či skript (limit hostingu) vykreslí stránku
          // bez CSS a nameraný posun nehovorí nič o webe (Beh #69).
          const limited = log.bad.filter((entry) =>
            [429, 503].includes(entry.status),
          );
          if (limited.length) {
            invalid += 1;
            console.log(
              `${pageName} ${lang} ${viewportName} beh ${run}: NEPLATNÉ, ${limited
                .map(
                  (entry) => `${entry.status} ${new URL(entry.url).pathname}`,
                )
                .join(", ")} (CLS ${total.toFixed(4)} sa nezapočítava)`,
            );
            await context.close();
            continue;
          }
          valid += 1;
          worst = Math.max(worst, total);
          console.log(
            `${pageName} ${lang} ${viewportName} beh ${run}: CLS ${total.toFixed(4)} (${shifts.length} posunov)`,
          );
          for (const entry of shifts) {
            const sources = entry.sources
              .map((source) => `${source.node} ${source.from}->${source.to}`)
              .join("; ");
            console.log(`  ${entry.t} ms  ${entry.value}  ${sources}`);
          }
          await context.close();
        }
      }
    }
  }
} finally {
  await browser.close();
}

if (invalid) console.log(`Neplatných behov (limit hostingu): ${invalid}`);
if (worst > 0.1) {
  console.log(`CLS NÁLEZY (najhorší ${worst.toFixed(4)})`);
  process.exitCode = 1;
} else if (valid === 0) {
  console.log("CLS NEOVERENÉ (žiadny platný beh)");
  process.exitCode = 2;
} else {
  console.log(`CLS OK (${valid} platných behov)`);
  process.exitCode = invalid ? 2 : 0;
}
