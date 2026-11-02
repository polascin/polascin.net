import fs from "node:fs";
import path from "node:path";
import {
  launch,
  newLog,
  newPage,
  gotoWithRetry,
  sleep,
  BASE,
  OUT,
  summarizeLog,
} from "./lib.mjs";

// Tlač v reálnom prehliadači: emuluje sa médium print a stránka sa vytlačí do
// PDF s predvolenými nastaveniami prehliadača, teda BEZ tlače pozadí. Papier je
// preto biely a čitateľnosť musí držať samotná farba textu.
//
// Kontroly (každý text, ktorý sa na papieri vykreslí):
//  - pevný alebo lepkavý prvok sa v tlači opakuje na každej strane a prekrýva
//    obsah (navigácia, cookie lišta),
//  - text s priehľadnou výplňou (gradientový nadpis) alebo s nulovou
//    priehľadnosťou (.reveal-pending pred posunom) na papieri nie je,
//  - kontrast farby textu voči bielemu papieru (3:1 pre veľké písmo, inak 4,5:1),
//  - vodorovné pretečenie rozloženia pre šírku A4.
//
// Premenné: LANGS (sk), THEMES (light,dark), STATES (clean,banner), PAGES,
// SCROLL=1 (stránku pred tlačou prejsť, aby sa odkryli prvky .reveal),
// PDF=1 (uložiť PDF do AUDIT_OUT na ručnú kontrolu).
const langs = (process.env.LANGS || "sk").split(",");
const themes = (process.env.THEMES || "light,dark").split(",");
const states = (process.env.STATES || "clean,banner").split(",");
const SCROLL = process.env.SCROLL === "1";
const SAVE_PDF = process.env.PDF === "1";
const allPages = {
  home: "/",
  articles: "/articles.php",
  article: "/article.php?slug=odporucanie-nie-je-povolenie",
  library: "/library.php",
  privacy: "/privacy.php",
  terms: "/terms.php",
  contact: "/contact.php",
  newsletter: "/newsletter.php",
  login: "/login.php",
};
const wanted = (
  process.env.PAGES ||
  "home,articles,article,library,privacy,terms,contact,newsletter"
).split(",");
// A4 pri 96 dpi je 794 × 1123 px; po odpočítaní okrajov 10 mm (predvolené
// okraje prehliadača) dostane tlač rozloženie široké 718 px.
const MARGIN = "10mm";
const VIEWPORT = { width: 718, height: 1123 };

const findings = [];
const rows = [];

const analyseInPage = () => {
  const parse = (value) => {
    if (!value) return null;
    let match = value.match(/^rgba?\(([^)]+)\)$/);
    if (match) {
      const parts = match[1]
        .split(/[\s,/]+/)
        .filter(Boolean)
        .map(Number);
      return {
        r: parts[0],
        g: parts[1],
        b: parts[2],
        a: parts.length > 3 ? parts[3] : 1,
      };
    }
    match = value.match(/^color\(srgb ([^)]+)\)$/);
    if (match) {
      const parts = match[1]
        .split(/[\s/]+/)
        .filter(Boolean)
        .map(Number);
      return {
        r: parts[0] * 255,
        g: parts[1] * 255,
        b: parts[2] * 255,
        a: parts.length > 3 ? parts[3] : 1,
      };
    }
    return null;
  };
  const luminance = ({ r, g, b }) => {
    const f = (c) => {
      const s = c / 255;
      return s <= 0.03928 ? s / 12.92 : ((s + 0.055) / 1.055) ** 2.4;
    };
    return 0.2126 * f(r) + 0.7152 * f(g) + 0.0722 * f(b);
  };
  const onWhite = (c) => ({
    r: c.r * c.a + 255 * (1 - c.a),
    g: c.g * c.a + 255 * (1 - c.a),
    b: c.b * c.a + 255 * (1 - c.a),
  });
  const signature = (el) => {
    const classes = [...el.classList].slice(0, 2).join(".");
    const parent = el.parentElement;
    const via = parent
      ? parent.tagName.toLowerCase() +
        ([...parent.classList][0] ? "." + [...parent.classList][0] : "")
      : "";
    return `${via} > ${el.tagName.toLowerCase()}${classes ? "." + classes : ""}`;
  };

  const out = { fixed: [], text: [], overflow: null, images: [] };

  for (const el of document.querySelectorAll("*")) {
    const cs = getComputedStyle(el);
    if (cs.position !== "fixed" && cs.position !== "sticky") continue;
    const r = el.getBoundingClientRect();
    if (cs.display === "none" || cs.visibility === "hidden") continue;
    if (r.width < 2 || r.height < 2) continue;
    out.fixed.push({
      sig: signature(el),
      position: cs.position,
      width: Math.round(r.width),
      height: Math.round(r.height),
    });
  }

  const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
  const seen = new Map();
  while (walker.nextNode()) {
    const node = walker.currentNode;
    const text = node.nodeValue.replace(/\s+/g, " ").trim();
    if (!text) continue;
    const el = node.parentElement;
    if (!el || /^(SCRIPT|STYLE|NOSCRIPT|TEMPLATE|TITLE)$/.test(el.tagName))
      continue;
    const range = document.createRange();
    range.selectNodeContents(node);
    const rect = range.getBoundingClientRect();
    if (rect.width < 2 || rect.height < 2) continue;
    // Prvok mimo strany (skip-link nad hornou hranou, past na formulári
    // vľavo) sa nevytlačí.
    if (rect.bottom + window.scrollY <= 0 || rect.right + window.scrollX <= 0)
      continue;
    let hidden = false;
    let opacity = 1;
    for (let up = el; up; up = up.parentElement) {
      const style = getComputedStyle(up);
      if (style.display === "none" || style.visibility === "hidden") {
        hidden = true;
        break;
      }
      // Skrytie pre čítače (.visually-hidden): orezaný box 1 × 1 px.
      if (style.overflow !== "visible") {
        const box = up.getBoundingClientRect();
        if (box.width <= 2 || box.height <= 2) {
          hidden = true;
          break;
        }
      }
      opacity *= Number(style.opacity);
    }
    if (hidden) continue;
    const cs = getComputedStyle(el);
    const fill = parse(cs.webkitTextFillColor) || parse(cs.color);
    if (!fill) continue;
    const size = parseFloat(cs.fontSize);
    const bold = Number(cs.fontWeight) >= 700;
    const large = size >= 24 || (bold && size >= 18.66);
    const alpha = fill.a * opacity;
    let kind = "";
    let ratio = 21;
    if (opacity < 0.1) kind = "opacity";
    else if (fill.a < 0.1) kind = "priehľadná výplň";
    else {
      const paper = onWhite({ ...fill, a: alpha });
      ratio = 1.05 / (luminance(paper) + 0.05);
      const need = large ? 3 : 4.5;
      if (ratio < need) kind = ratio < 3 ? "kontrast" : "slabý kontrast";
    }
    if (!kind) continue;
    const key = `${kind}|${signature(el)}|${cs.color}|${opacity}`;
    const entry = seen.get(key) || {
      kind,
      sig: signature(el),
      color: cs.color,
      fill: cs.webkitTextFillColor,
      opacity: Math.round(opacity * 100) / 100,
      ratio: Math.round(ratio * 100) / 100,
      count: 0,
      sample: text.slice(0, 40),
    };
    entry.count += 1;
    seen.set(key, entry);
  }
  out.text = [...seen.values()];

  const width = document.documentElement.scrollWidth;
  if (width > window.innerWidth + 1)
    out.overflow = { scrollWidth: width, innerWidth: window.innerWidth };
  return out;
};

const scrollThrough = async (page) => {
  await page.evaluate(async () => {
    const step = Math.max(200, Math.floor(window.innerHeight * 0.8));
    const total = document.documentElement.scrollHeight;
    for (let y = 0; y <= total; y += step) {
      window.scrollTo(0, y);
      await new Promise((resolve) => setTimeout(resolve, 120));
    }
    window.scrollTo(0, 0);
    await new Promise((resolve) => setTimeout(resolve, 900));
  });
};

async function auditOne(browser, ua, { lang, theme, state, name, pathName }) {
  const where = `${lang} ${theme} ${state} ${name}`;
  console.log(`\n== ${where}${SCROLL ? " (po posune)" : ""}`);
  const log = newLog();
  const page = await newPage(browser, ua, log, VIEWPORT);
  await page.evaluateOnNewDocument(
    (selectedTheme, hideBanner) => {
      try {
        window.localStorage.setItem("theme", selectedTheme);
        if (hideBanner)
          window.localStorage.setItem("privacy_consent_clarity_v1", "rejected");
        else window.localStorage.removeItem("privacy_consent_clarity_v1");
      } catch {
        // úložisko nedostupné
      }
    },
    theme,
    state === "clean",
  );
  const url = `${BASE}${pathName}${pathName.includes("?") ? "&" : "?"}lang=${lang}`;
  await gotoWithRetry(page, url);
  await page.evaluate(() => document.fonts.ready.then(() => true));
  await sleep(900);
  if (SCROLL) await scrollThrough(page);
  await page.emulateMediaType("print");
  await sleep(700);
  const result = await page.evaluate(analyseInPage);

  const add = (severity, kind, detail) => {
    findings.push({ where, severity, kind, detail });
    console.log(
      `  ${severity === "fail" ? "CHYBA" : "POZOR"} ${kind}: ${detail}`,
    );
  };
  for (const item of result.fixed)
    add(
      "fail",
      "pevný prvok v tlači",
      `${item.sig} (${item.position}, ${item.width} × ${item.height} px) sa vytlačí na každej strane`,
    );
  for (const item of result.text) {
    const detail = `${item.sig}: ${item.count}× „${item.sample}“, farba ${item.color}${
      item.fill !== item.color ? `, výplň ${item.fill}` : ""
    }${item.opacity < 1 ? `, priehľadnosť ${item.opacity}` : ""}${
      item.kind.includes("kontrast") ? `, kontrast ${item.ratio}:1` : ""
    }`;
    add(
      item.kind === "slabý kontrast" ? "warn" : "fail",
      item.kind === "opacity"
        ? "text s nulovou priehľadnosťou"
        : item.kind === "priehľadná výplň"
          ? "text s priehľadnou výplňou"
          : item.kind === "kontrast"
            ? "nečitateľný text na bielom papieri"
            : "slabý kontrast na bielom papieri",
      detail,
    );
  }
  if (result.overflow)
    add(
      "warn",
      "vodorovné pretečenie",
      `scrollWidth ${result.overflow.scrollWidth} px pri šírke ${result.overflow.innerWidth} px`,
    );

  const pdf = await page.pdf({
    format: "A4",
    printBackground: false,
    preferCSSPageSize: false,
    margin: { top: MARGIN, right: MARGIN, bottom: MARGIN, left: MARGIN },
  });
  const sheets = (
    Buffer.from(pdf)
      .toString("latin1")
      .match(/\/Type\s*\/Page[^s]/g) || []
  ).length;
  if (SAVE_PDF) {
    const file = path.join(
      OUT,
      `tlac-${lang}-${theme}-${state}-${name}${SCROLL ? "-posun" : ""}.pdf`,
    );
    fs.writeFileSync(file, pdf);
    console.log(`  PDF ${file}`);
  }
  rows.push({ where, sheets });
  console.log(`  strán A4: ${sheets}`);

  const summary = summarizeLog(log);
  const noise = [...summary.pageerror, ...summary.csp];
  if (noise.length)
    add("fail", "chyba stránky", JSON.stringify(noise).slice(0, 200));
  await page.close();
}

const { browser, ua } = await launch();
try {
  for (const lang of langs)
    for (const theme of themes)
      for (const state of states)
        for (const name of wanted) {
          if (!allPages[name]) throw new Error(`Neznáma stránka: ${name}`);
          await auditOne(browser, ua, {
            lang,
            theme,
            state,
            name,
            pathName: allPages[name],
          });
          await sleep(2000);
        }
} finally {
  await browser.close();
}

const failures = findings.filter((entry) => entry.severity === "fail");
const warnings = findings.filter((entry) => entry.severity === "warn");
console.log("\n##### SÚHRN");
for (const row of rows) console.log(`  ${row.where}: ${row.sheets} strán A4`);
console.log(`\nChyby: ${failures.length}, upozornenia: ${warnings.length}`);
fs.writeFileSync(
  path.join(OUT, "print-audit.json"),
  JSON.stringify({ findings, rows }, null, 2),
);
if (failures.length) {
  console.log("TLAČ NÁLEZY");
  process.exit(1);
}
console.log("TLAČ OK");
