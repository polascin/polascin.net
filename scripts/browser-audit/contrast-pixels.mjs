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
  readAxeSource,
} from "./lib.mjs";

// Kontrast z reálnych pixelov pre uzly, ktoré axe nevie posúdiť (pseudoContent,
// gradient, čiastočné prekrytie). Pre každý uzol sa spraví snímka s textom a
// snímka s priehľadným textom; maska textu je rozdiel medzi nimi, pozadie
// pod písmenami sa berie zo snímky bez textu, farba textu z vypočítaného štýlu.
const axeSource = readAxeSource();
const langs = (process.env.LANGS || "sk").split(",");
const themes = (process.env.THEMES || "light,dark").split(",");
const states = (process.env.STATES || "banner,clean").split(",");
const viewportName = process.env.VIEWPORT || "desktop";
const viewport =
  viewportName === "mobile"
    ? { width: 390, height: 844, isMobile: true, hasTouch: true }
    : { width: 1280, height: 800 };
const allPages = {
  home: "/",
  articles: "/articles.php",
  article: "/article.php?slug=odporucanie-nie-je-povolenie",
  article2: "/article.php?slug=mensia-suma-nie-je-zlava",
  article3: "/article.php?slug=tri-ponuky-za-tyzden-nikto-necital",
  library: "/library.php",
  privacy: "/privacy.php",
  terms: "/terms.php",
  contact: "/contact.php",
  newsletter: "/newsletter.php",
  login: "/login.php",
};
const wanted = (process.env.PAGES || "home,article,contact").split(",");
const fixedFractions = [0, 0.25, 0.5, 0.75, 1];

const hideCss = `
*, *::before, *::after { color: transparent !important; -webkit-text-fill-color: transparent !important; text-shadow: none !important; caret-color: transparent !important; transition: none !important; }
[data-px-hide] { background: none !important; }
`;

const analyzeInPage = async (payload) => {
  const { a64, b64, rect, fg, fillTransparent, opacity } = payload;
  const decode = async (data) => {
    const bin = atob(data);
    const bytes = new Uint8Array(bin.length);
    for (let i = 0; i < bin.length; i += 1) bytes[i] = bin.charCodeAt(i);
    const bitmap = await createImageBitmap(
      new Blob([bytes], { type: "image/png" }),
    );
    const canvas = new OffscreenCanvas(bitmap.width, bitmap.height);
    const context = canvas.getContext("2d", { willReadFrequently: true });
    context.drawImage(bitmap, 0, 0);
    return {
      image: context.getImageData(0, 0, bitmap.width, bitmap.height),
      width: bitmap.width,
      height: bitmap.height,
    };
  };
  const A = await decode(a64);
  const B = await decode(b64);
  const x0 = Math.max(0, Math.floor(rect.left));
  const y0 = Math.max(0, Math.floor(rect.top));
  const x1 = Math.min(A.width, Math.ceil(rect.right));
  const y1 = Math.min(A.height, Math.ceil(rect.bottom));
  if (x1 <= x0 || y1 <= y0) return { error: "mimo okna" };
  const lum = (r, g, b) => {
    const f = (c) => {
      const s = c / 255;
      return s <= 0.03928 ? s / 12.92 : ((s + 0.055) / 1.055) ** 2.4;
    };
    return 0.2126 * f(r) + 0.7152 * f(g) + 0.0722 * f(b);
  };
  const ratio = (l1, l2) =>
    (Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05);
  const a = A.image.data;
  const b = B.image.data;
  let maxDiff = 0;
  for (let y = y0; y < y1; y += 1) {
    for (let x = x0; x < x1; x += 1) {
      const i = (y * A.width + x) * 4;
      const diff = Math.max(
        Math.abs(a[i] - b[i]),
        Math.abs(a[i + 1] - b[i + 1]),
        Math.abs(a[i + 2] - b[i + 2]),
      );
      if (diff > maxDiff) maxDiff = diff;
    }
  }
  const alpha = Math.max(0, Math.min(1, fg.a * opacity));
  let bgMinL = 9;
  let bgMinRgb = null;
  for (let y = y0; y < y1; y += 1) {
    for (let x = x0; x < x1; x += 1) {
      const i = (y * A.width + x) * 4;
      const l = lum(b[i], b[i + 1], b[i + 2]);
      if (l < bgMinL) {
        bgMinL = l;
        bgMinRgb = [b[i], b[i + 1], b[i + 2]];
      }
    }
  }
  const coreThreshold = Math.max(20, (fillTransparent ? 0.9 : 0.6) * maxDiff);
  const ratios = [];
  let worstPixel = null;
  if (maxDiff >= 20) {
    for (let y = y0; y < y1; y += 1) {
      for (let x = x0; x < x1; x += 1) {
        const i = (y * A.width + x) * 4;
        const diff = Math.max(
          Math.abs(a[i] - b[i]),
          Math.abs(a[i + 1] - b[i + 1]),
          Math.abs(a[i + 2] - b[i + 2]),
        );
        if (diff < coreThreshold) continue;
        const bgL = lum(b[i], b[i + 1], b[i + 2]);
        let fgL;
        if (fillTransparent) {
          fgL = lum(a[i], a[i + 1], a[i + 2]);
        } else {
          fgL = lum(
            fg.r * alpha + b[i] * (1 - alpha),
            fg.g * alpha + b[i + 1] * (1 - alpha),
            fg.b * alpha + b[i + 2] * (1 - alpha),
          );
        }
        const pixelRatio = ratio(fgL, bgL);
        if (!worstPixel || pixelRatio < worstPixel.ratio) {
          worstPixel = {
            ratio: pixelRatio,
            x,
            y,
            a: [a[i], a[i + 1], a[i + 2]],
            b: [b[i], b[i + 1], b[i + 2]],
            fgL,
            bgL,
            diff,
          };
        }
        ratios.push(pixelRatio);
      }
    }
  }
  if (ratios.length === 0) {
    // text sa nevykreslil rozlíšiteľne: porovnaj vypočítanú farbu s mediánom pozadia
    const reds = [];
    for (let y = y0; y < y1; y += 2) {
      for (let x = x0; x < x1; x += 2) {
        const i = (y * B.width + x) * 4;
        reds.push(lum(b[i], b[i + 1], b[i + 2]));
      }
    }
    reds.sort((p, q) => p - q);
    const bgL = reds[Math.floor(reds.length / 2)];
    const fgL = lum(fg.r, fg.g, fg.b);
    return { n: 0, maxDiff, noMask: ratio(fgL, bgL), bgMinRgb };
  }
  ratios.sort((p, q) => p - q);
  return {
    n: ratios.length,
    maxDiff,
    bgMinRgb,
    worstPixel,
    coreThreshold,
    alpha,
    min: ratios[0],
    p5: ratios[Math.floor(0.05 * (ratios.length - 1))],
    median: ratios[Math.floor(0.5 * (ratios.length - 1))],
  };
};

const describeInPage = (selector) => {
  const el = document.querySelector(selector);
  if (!el) return null;
  const parse = (value) => {
    const m = value.match(/^(?:rgba?|color)\(\s*(?:srgb\s+)?([^)]+)\)$/);
    if (!m) return null;
    const parts = m[1]
      .replace("/", " ")
      .replace(/,/g, " ")
      .trim()
      .split(/\s+/)
      .map(Number);
    const scale = value.startsWith("color(") ? 255 : 1;
    return {
      r: parts[0] * scale,
      g: parts[1] * scale,
      b: parts[2] * scale,
      a: parts.length > 3 ? parts[3] : 1,
    };
  };
  const style = getComputedStyle(el);
  let opacity = 1;
  let fixed = false;
  for (let node = el; node && node.nodeType === 1; node = node.parentElement) {
    const s = getComputedStyle(node);
    opacity *= parseFloat(s.opacity);
    if (s.position === "fixed") fixed = true;
  }
  const fill = parse(style.webkitTextFillColor) || parse(style.color);
  const clipText =
    (style.webkitBackgroundClip || style.backgroundClip) === "text";
  return {
    fixed,
    inBanner: Boolean(el.closest("#cookie-consent-container")),
    opacity,
    fg: fill,
    fillTransparent: !fill || fill.a === 0,
    clipText,
    fontSize: parseFloat(style.fontSize),
    fontWeight: parseInt(style.fontWeight, 10) || 400,
    text: (el.textContent || "").replace(/\s+/g, " ").trim().slice(0, 36),
    visible: el.getClientRects().length > 0,
  };
};

const { browser, ua } = await launch();
const rows = [];
const problems = [];

async function shot(page) {
  return page.screenshot({ type: "png", encoding: "base64" });
}

async function settle(page, ms = 120) {
  await page.evaluate(
    () =>
      new Promise((resolve) =>
        requestAnimationFrame(() => requestAnimationFrame(resolve)),
      ),
  );
  await sleep(ms);
}

try {
  for (const state of states) {
    for (const theme of themes) {
      for (const lang of langs) {
        const log = newLog();
        const page = await newPage(browser, ua, log, viewport);
        await page.setBypassCSP(true);
        await page.evaluateOnNewDocument(
          (selectedTheme, hideBanner) => {
            try {
              window.localStorage.setItem("theme", selectedTheme);
              if (hideBanner)
                window.localStorage.setItem(
                  "privacy_consent_clarity_v1",
                  "rejected",
                );
            } catch {
              // úložisko nedostupné
            }
          },
          theme,
          state === "clean",
        );
        const names = wanted.filter(
          (name) => allPages[name] && (state === "clean" || name === "home"),
        );
        for (const name of names) {
          const url = `${BASE}${allPages[name]}${allPages[name].includes("?") ? "&" : "?"}lang=${lang}`;
          await gotoWithRetry(page, url);
          await page.evaluate(() => document.fonts.ready.then(() => true));
          await sleep(1600);
          await page.evaluate(axeSource);
          const incomplete = await page.evaluate(async () => {
            const output = await window.axe.run(document, {
              runOnly: { type: "rule", values: ["color-contrast"] },
              resultTypes: ["incomplete"],
            });
            const nodes = [];
            for (const rule of output.incomplete) {
              for (const node of rule.nodes) {
                const data =
                  node.any
                    .concat(node.all, node.none)
                    .map((check) => check.data)
                    .find(Boolean) || {};
                nodes.push({
                  selector: node.target[0],
                  key: data.messageKey || "",
                });
              }
            }
            return nodes;
          });
          const styleHandle = await page.addStyleTag({ content: hideCss });
          await page.evaluate((handle) => {
            handle.disabled = true;
          }, styleHandle);
          // `a { transition: color 0.3s }`: po vypnutí skrývacieho štýlu farba 300 ms
          // dobieha z priehľadnej; prvý uzol (#beatClock) by sa inak čítal napoly.
          await sleep(700);
          console.log(
            `--- ${viewportName} ${state} ${lang} ${theme} ${name}: uzlov na kontrolu ${incomplete.length}`,
          );
          for (const node of incomplete) {
            if (process.env.ONLY && !node.selector.includes(process.env.ONLY))
              continue;
            const info = await page.evaluate(describeInPage, node.selector);
            if (process.env.DIAG && info) {
              await sleep(900);
              const later = await page.evaluate(describeInPage, node.selector);
              console.log(
                "DIAG",
                node.selector,
                JSON.stringify({
                  prvy: {
                    fg: info.fg,
                    opacity: info.opacity,
                    fillTransparent: info.fillTransparent,
                  },
                  neskor: {
                    fg: later.fg,
                    opacity: later.opacity,
                    fillTransparent: later.fillTransparent,
                  },
                }),
              );
            }
            if (!info || !info.visible) {
              rows.push({
                where: `${state}/${lang}/${theme}/${name}`,
                selector: node.selector,
                status: "SKIP",
                note: "neviditeľný",
              });
              continue;
            }
            if (state === "banner" && !info.inBanner) continue;
            const large =
              info.fontSize >= 24 ||
              (info.fontSize >= 18.66 && info.fontWeight >= 700);
            const threshold = large ? 3 : 4.5;
            const positions = info.fixed ? fixedFractions : [null];
            let worst = null;
            for (const fraction of positions) {
              if (fraction === null) {
                await page.evaluate(
                  (selector) =>
                    document.querySelector(selector).scrollIntoView({
                      block: "center",
                      inline: "nearest",
                      behavior: "instant",
                    }),
                  node.selector,
                );
                await settle(page, 400);
              } else {
                await page.evaluate(
                  (f) =>
                    window.scrollTo({
                      top:
                        f *
                        (document.documentElement.scrollHeight -
                          window.innerHeight),
                      left: 0,
                      behavior: "instant",
                    }),
                  fraction,
                );
                await settle(page, 400);
              }
              const readRect = () =>
                page.evaluate((selector) => {
                  const r = document
                    .querySelector(selector)
                    .getBoundingClientRect();
                  return {
                    left: r.left,
                    top: r.top,
                    right: r.right,
                    bottom: r.bottom,
                  };
                }, node.selector);
              const rect = await readRect();
              await page.evaluate(
                (selector, hide) => {
                  const el = document.querySelector(selector);
                  if (hide) el.setAttribute("data-px-hide", "1");
                },
                node.selector,
                info.clipText,
              );
              const a64 = await shot(page);
              await page.evaluate((handle) => {
                handle.disabled = false;
              }, styleHandle);
              await settle(page, 200);
              const b64 = await shot(page);
              const rectAfter = await readRect();
              await page.evaluate((handle) => {
                handle.disabled = true;
              }, styleHandle);
              if (
                Math.abs(rectAfter.top - rect.top) > 0.5 ||
                Math.abs(rectAfter.left - rect.left) > 0.5
              ) {
                problems.push(
                  `${state}/${lang}/${theme}/${name} ${node.selector}: poloha sa počas snímania zmenila (${rect.top} na ${rectAfter.top})`,
                );
              }
              if (process.env.DUMP) {
                fs.writeFileSync(
                  path.join(OUT, "dump-a.png"),
                  Buffer.from(a64, "base64"),
                );
                fs.writeFileSync(
                  path.join(OUT, "dump-b.png"),
                  Buffer.from(b64, "base64"),
                );
                console.log("DUMP", JSON.stringify({ rect, info }));
              }
              await page.evaluate(
                (selector) =>
                  document
                    .querySelector(selector)
                    .removeAttribute("data-px-hide"),
                node.selector,
              );
              await sleep(350);
              const result = await page.evaluate(analyzeInPage, {
                a64,
                b64,
                rect,
                fg: info.fg || { r: 0, g: 0, b: 0, a: 1 },
                fillTransparent: info.fillTransparent,
                opacity: info.opacity,
              });
              if (result.error) continue;
              const navBg = await page.evaluate(() => {
                const nav = document.querySelector("nav.navbar");
                return nav ? getComputedStyle(nav).backgroundColor : "-";
              });
              const measured = result.n === 0 ? result.noMask : result.p5;
              if (!worst || measured < worst.measured)
                worst = { measured, result, fraction, navBg };
            }
            if (!worst) {
              rows.push({
                where: `${state}/${lang}/${theme}/${name}`,
                selector: node.selector,
                status: "SKIP",
                note: "mimo okna",
              });
              continue;
            }
            const pass = worst.measured >= threshold;
            rows.push({
              where: `${state}/${lang}/${theme}/${name}`,
              selector: node.selector,
              text: info.text,
              key: node.key,
              size: `${info.fontSize}px/${info.fontWeight}`,
              threshold,
              p5: worst.measured,
              min: worst.result.min,
              median: worst.result.median,
              n: worst.result.n,
              at: worst.fraction,
              status: pass ? "PASS" : "FAIL",
              note: worst.result.n === 0 ? "bez masky textu" : "",
            });
            const flag = pass ? "ok  " : "FAIL";
            const extra =
              pass && !(worst.result.min < threshold)
                ? ""
                : `  [pozadie min ${worst.result.bgMinRgb}, lišta ${worst.navBg}, maxDiff ${worst.result.maxDiff}, prah ${worst.result.coreThreshold}, alfa ${worst.result.alpha}, najhorší pixel ${JSON.stringify(worst.result.worstPixel)}]`;
            console.log(
              `${flag} ${node.selector.slice(0, 60).padEnd(60)} ${String(worst.measured.toFixed(2)).padStart(6)} (min ${worst.result.min === undefined ? "-" : worst.result.min.toFixed(2)}) potreba ${threshold} ${info.size || ""} ${worst.fraction === null ? "" : "scroll " + worst.fraction}${extra}`,
            );
          }
          await page.evaluate(() =>
            window.scrollTo({ top: 0, left: 0, behavior: "instant" }),
          );
          await sleep(2500);
        }
        await page.close();
      }
    }
  }
} finally {
  await browser.close();
}

fs.writeFileSync(
  path.join(OUT, `contrast-pixels-${viewportName}.json`),
  JSON.stringify(rows, null, 1),
);
const checked = rows.filter((row) => row.status !== "SKIP");
const failed = rows.filter((row) => row.status === "FAIL");
console.log(
  `\nSkontrolovaných uzlov: ${checked.length}, zlyhaní: ${failed.length}, preskočených: ${rows.length - checked.length}`,
);
const lowest = [...checked]
  .sort((x, y) => x.p5 / x.threshold - y.p5 / y.threshold)
  .slice(0, 12);
console.log("Najnižšia rezerva (p5 / potreba):");
for (const row of lowest)
  console.log(
    `  ${row.where} ${row.selector.slice(0, 50)} ${row.p5.toFixed(2)} / ${row.threshold} (${row.text})`,
  );
if (problems.length)
  for (const problem of problems) console.log(`- ${problem}`);
console.log(
  failed.length === 0 ? "KONTRAST PIXELY OK" : "KONTRAST PIXELY NÁLEZY",
);
process.exit(failed.length === 0 ? 0 : 1);
