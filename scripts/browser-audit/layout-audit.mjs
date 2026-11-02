import fs from "node:fs";
import path from "node:path";
import {
  BASE,
  LANGS,
  OUT,
  launch,
  newLog,
  newPage,
  resetState,
  gotoWithRetry,
  sleep,
  summarizeLog,
} from "./lib.mjs";

// Rozloženie a základné kontroly stránky: vodorovné preťaženie, cookie banner
// (výška, tlačidlá, zalomenie), h1, duplicitné id, obrázky bez alt a rozmerov,
// `target="_blank"` bez noopener, konzola, CSP, CLS a LCP pre každý jazyk.
const VIEWPORTS = [
  { name: "d1280", width: 1280, height: 800 },
  { name: "t768", width: 768, height: 1024 },
  { name: "m375", width: 375, height: 812 },
  { name: "m320", width: 320, height: 640 },
];

const pageChecks = (expectedLang) => {
  const ids = Array.from(document.querySelectorAll("[id]")).map(
    (element) => element.id,
  );
  const nav = performance.getEntriesByType("navigation")[0];
  const viewportMeta = document.querySelector('meta[name="viewport"]');
  const canonical = document.querySelector('link[rel="canonical"]');
  return {
    htmlLang: document.documentElement.lang,
    langOk: document.documentElement.lang === expectedLang,
    title: document.title,
    h1: document.querySelectorAll("h1").length,
    viewportMeta: viewportMeta ? viewportMeta.content : null,
    canonical: canonical ? canonical.href : null,
    duplicateIds: ids.filter((id, index) => ids.indexOf(id) !== index),
    imagesNoAlt: Array.from(document.images)
      .filter((image) => !image.hasAttribute("alt"))
      .map((image) => image.src),
    imagesNoSize: Array.from(document.images)
      .filter(
        (image) =>
          !image.getAttribute("width") || !image.getAttribute("height"),
      )
      .map((image) => image.getAttribute("src")),
    imagesBroken: Array.from(document.images)
      .filter((image) => image.complete && image.naturalWidth === 0)
      .map((image) => image.getAttribute("src")),
    blankNoOpener: Array.from(document.querySelectorAll('a[target="_blank"]'))
      .filter((anchor) => !/noopener/.test(anchor.rel))
      .map((anchor) => anchor.href),
    nav: nav
      ? {
          ttfb: Math.round(nav.responseStart),
          dcl: Math.round(nav.domContentLoadedEventEnd),
          load: Math.round(nav.loadEventEnd),
          transfer: nav.transferSize,
        }
      : null,
    cls: Number((window.__cls || 0).toFixed(4)),
    lcp: Math.round(window.__lcp || 0),
  };
};

const measure = () => {
  const root = document.documentElement;
  const vw = window.innerWidth;
  const vh = window.innerHeight;
  const result = {
    vw,
    vh,
    scrollW: root.scrollWidth,
    clientW: root.clientWidth,
    hOverflow: root.scrollWidth > root.clientWidth + 1,
  };
  if (result.hOverflow) {
    result.offenders = Array.from(document.querySelectorAll("body *"))
      .map((element) => ({ element, rect: element.getBoundingClientRect() }))
      .filter(
        ({ rect }) => rect.width > 0 && (rect.right > vw + 1 || rect.left < -1),
      )
      .slice(0, 8)
      .map(({ element, rect }) => ({
        tag: element.tagName,
        id: element.id,
        cls: String(element.className).slice(0, 60),
        left: Math.round(rect.left),
        right: Math.round(rect.right),
      }));
  }
  const banner = document.querySelector(
    "#cookie-consent-container .cookie-banner",
  );
  if (banner) {
    const rect = banner.getBoundingClientRect();
    result.banner = {
      top: Math.round(rect.top),
      bottom: Math.round(rect.bottom),
      height: Math.round(rect.height),
      fraction: Number((rect.height / vh).toFixed(2)),
      inside:
        rect.left >= -1 &&
        rect.right <= vw + 1 &&
        rect.top >= -1 &&
        rect.bottom <= vh + 1,
      scrollable: banner.scrollHeight > banner.clientHeight + 1,
      overflowX: banner.scrollWidth > banner.clientWidth + 1,
    };
    result.buttons = Array.from(banner.querySelectorAll("button")).map(
      (button) => {
        const box = button.getBoundingClientRect();
        const style = getComputedStyle(button);
        const lineHeight =
          parseFloat(style.lineHeight) || parseFloat(style.fontSize) * 1.2;
        const padding =
          parseFloat(style.paddingTop) + parseFloat(style.paddingBottom);
        const top = document.elementFromPoint(
          box.left + box.width / 2,
          box.top + box.height / 2,
        );
        return {
          cls: button.className,
          text: button.textContent,
          w: Math.round(box.width),
          h: Math.round(box.height),
          lines: Math.max(
            1,
            Math.round((box.height - padding - 2) / lineHeight),
          ),
          clipped:
            button.scrollWidth > button.clientWidth + 1 ||
            button.scrollHeight > button.clientHeight + 1,
          reachable: top === button || button.contains(top),
        };
      },
    );
  }
  return result;
};

const { browser, ua } = await launch();
const report = {};
try {
  for (const lang of LANGS) {
    const log = newLog();
    const page = await newPage(browser, ua, log);
    await resetState(page);
    const response = await gotoWithRetry(page, `${BASE}/?lang=${lang}`);
    await page.waitForSelector("#cookie-consent-container .cookie-banner", {
      timeout: 10000,
    });
    await sleep(900);
    const entry = {
      status: response.status(),
      checks: await page.evaluate(pageChecks, lang),
      views: {},
    };
    if (lang === "sk") entry.headers = response.headers();
    for (const viewport of VIEWPORTS) {
      await page.setViewport({
        width: viewport.width,
        height: viewport.height,
      });
      await sleep(350);
      entry.views[viewport.name] = await page.evaluate(measure);
      await page.screenshot({
        path: path.join(OUT, `layout-${lang}-${viewport.name}.png`),
      });
    }
    entry.log = summarizeLog(log);
    report[lang] = entry;
    await page.close();
    await sleep(2500);
  }
} finally {
  await browser.close();
}
fs.writeFileSync(
  path.join(OUT, "layout.json"),
  JSON.stringify(report, null, 2),
);

let problems = 0;
for (const lang of LANGS) {
  const entry = report[lang];
  const parts = Object.entries(entry.views).map(([name, view]) => {
    const flags = [];
    if (view.hOverflow) flags.push("H-OVERFLOW");
    if (view.banner && !view.banner.inside) flags.push("OUTSIDE");
    if (view.banner && view.banner.scrollable) flags.push("SCROLL");
    if (view.banner && view.banner.overflowX) flags.push("BANNER-X");
    for (const button of view.buttons || []) {
      if (button.clipped) flags.push(`CLIP:${button.cls}`);
      if (!button.reachable) flags.push(`COVERED:${button.cls}`);
      if (button.h < 44) flags.push(`SMALL:${button.cls}:${button.h}`);
    }
    problems += flags.length;
    const frac = view.banner
      ? `${Math.round(view.banner.fraction * 100)}%`
      : "-";
    const btn = (view.buttons || [])
      .map((button) => `${button.w}x${button.h}/${button.lines}l`)
      .join(",");
    return `${name}[${frac} ${btn}${flags.length ? " " + flags.join(" ") : ""}]`;
  });
  const c = entry.checks;
  const issues = [];
  if (!c.langOk) issues.push(`lang=${c.htmlLang}`);
  if (c.h1 !== 1) issues.push(`h1=${c.h1}`);
  if (c.duplicateIds.length) issues.push(`dupIds=${c.duplicateIds.join("|")}`);
  if (c.imagesNoAlt.length) issues.push(`noAlt=${c.imagesNoAlt.length}`);
  if (c.imagesNoSize.length) issues.push(`noSize=${c.imagesNoSize.length}`);
  if (c.imagesBroken.length) issues.push(`broken=${c.imagesBroken.length}`);
  if (c.blankNoOpener.length) issues.push(`noopener=${c.blankNoOpener.length}`);
  const l = entry.log;
  const logFlags = [];
  if (l.consoleIssues.length)
    logFlags.push(`console=${l.consoleIssues.length}`);
  if (l.pageerror.length) logFlags.push(`pageerror=${l.pageerror.length}`);
  if (l.failed.length) logFlags.push(`failed=${l.failed.length}`);
  if (l.bad.length) logFlags.push(`bad=${l.bad.length}`);
  if (l.csp.length) logFlags.push(`csp=${l.csp.length}`);
  if (l.thirdparty.length) logFlags.push(`3rd=${l.thirdparty.length}`);
  problems +=
    issues.length + logFlags.filter((flag) => !flag.startsWith("3rd=")).length;
  console.log(
    `${lang} ${entry.status} cls=${c.cls} lcp=${c.lcp} ttfb=${c.nav && c.nav.ttfb} ${issues.join(" ")} ${logFlags.join(" ")}`,
  );
  console.log(`   ${parts.join("  ")}`);
}
console.log(
  problems === 0 ? "ROZLOŽENIE OK" : `ROZLOŽENIE NÁLEZY: ${problems}`,
);
process.exit(problems === 0 ? 0 : 1);
