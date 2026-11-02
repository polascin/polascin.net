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
} from "./lib.mjs";

// Najhorší prípad pre kontrast textu v „sklenenej“ navigácii: pod lištu sa
// vloží jednofarebný pevný blok (čierny, biely, sýta fialová, svetlomodrá) a
// zmeria sa kontrast každého textu v lište z reálnych pixelov (snímka s textom
// a snímka s priehľadným textom). OPACITIES prepíše krytie pozadia lišty.
const themes = (process.env.THEMES || "light,dark").split(",");
const langs = (process.env.LANGS || "sk").split(",");
const backdrops = (
  process.env.BACKDROPS || "#000000,#ffffff,#5049cc,#7bade2,#808080"
).split(",");
const opacities = (process.env.OPACITIES || "css").split(",");
const viewportName = process.env.VIEWPORT || "desktop";
const viewport =
  viewportName === "mobile"
    ? { width: 390, height: 844, isMobile: true, hasTouch: true }
    : { width: 1280, height: 800 };

const hideCss = `
*, *::before, *::after { color: transparent !important; -webkit-text-fill-color: transparent !important; text-shadow: none !important; caret-color: transparent !important; transition: none !important; }
`;

const analyzeInPage = async (payload) => {
  const { a64, b64, rect, fg } = payload;
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
    };
  };
  const A = await decode(a64);
  const B = await decode(b64);
  const x0 = Math.max(0, Math.floor(rect.left));
  const y0 = Math.max(0, Math.floor(rect.top));
  const x1 = Math.min(A.width, Math.ceil(rect.right));
  const y1 = Math.ceil(rect.bottom);
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
  const coreThreshold = Math.max(20, 0.6 * maxDiff);
  const ratios = [];
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
        ratios.push(
          ratio(lum(fg.r, fg.g, fg.b), lum(b[i], b[i + 1], b[i + 2])),
        );
      }
    }
  }
  if (ratios.length === 0) {
    const values = [];
    for (let y = y0; y < y1; y += 2) {
      for (let x = x0; x < x1; x += 2) {
        const i = (y * B.width + x) * 4;
        values.push(lum(b[i], b[i + 1], b[i + 2]));
      }
    }
    values.sort((p, q) => p - q);
    return {
      n: 0,
      p5: ratio(lum(fg.r, fg.g, fg.b), values[Math.floor(values.length / 2)]),
    };
  }
  ratios.sort((p, q) => p - q);
  return {
    n: ratios.length,
    p5: ratios[Math.floor(0.05 * (ratios.length - 1))],
    min: ratios[0],
  };
};

const collectInPage = () => {
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
  const out = [];
  const navbar = document.querySelector("nav.navbar");
  for (const el of navbar.querySelectorAll("*")) {
    const own = Array.from(el.childNodes).some(
      (n) => n.nodeType === 3 && n.textContent.trim().length > 0,
    );
    if (!own || el.getClientRects().length === 0) continue;
    const details = el.closest("details");
    if (details && !details.open && !el.closest("summary")) continue;
    const style = getComputedStyle(el);
    if (style.visibility === "hidden" || parseFloat(style.opacity) === 0)
      continue;
    const fill = parse(style.webkitTextFillColor) || parse(style.color);
    const r = el.getBoundingClientRect();
    out.push({
      label: `${el.tagName.toLowerCase()}${el.id ? "#" + el.id : ""}${el.className && typeof el.className === "string" ? "." + el.className.trim().split(/\s+/).join(".") : ""}`,
      text: el.textContent.replace(/\s+/g, " ").trim().slice(0, 22),
      fontSize: parseFloat(style.fontSize),
      fontWeight: parseInt(style.fontWeight, 10) || 400,
      fg: fill,
      rect: { left: r.left, top: r.top, right: r.right, bottom: r.bottom },
    });
  }
  return out;
};

const { browser, ua } = await launch();
const rows = [];
try {
  for (const theme of themes) {
    for (const lang of langs) {
      const log = newLog();
      const page = await newPage(browser, ua, log, viewport);
      await page.setBypassCSP(true);
      await page.evaluateOnNewDocument((selectedTheme) => {
        try {
          window.localStorage.setItem("theme", selectedTheme);
          window.localStorage.setItem("privacy_consent_clarity_v1", "rejected");
        } catch {
          // úložisko nedostupné
        }
      }, theme);
      await gotoWithRetry(page, `${BASE}/?lang=${lang}`);
      await page.evaluate(() => document.fonts.ready.then(() => true));
      await sleep(1500);
      const hideHandle = await page.addStyleTag({ content: hideCss });
      await page.evaluate((h) => {
        h.disabled = true;
      }, hideHandle);
      for (const opacity of opacities) {
        let overrideHandle = null;
        if (opacity !== "css") {
          overrideHandle = await page.addStyleTag({
            content: `@supports (backdrop-filter: blur(1px)) { .navbar { background: color-mix(in srgb, var(--bg-card) ${opacity}%, transparent) !important; } }`,
          });
        }
        for (const color of backdrops) {
          await page.evaluate((c) => {
            let block = document.getElementById("px-backdrop");
            if (!block) {
              block = document.createElement("div");
              block.id = "px-backdrop";
              block.setAttribute(
                "style",
                "position:fixed;top:0;left:0;width:100%;height:160px;z-index:999;pointer-events:none;",
              );
              document.body.appendChild(block);
            }
            block.style.background = c;
          }, color);
          await page.evaluate(() =>
            window.scrollTo({ top: 0, left: 0, behavior: "instant" }),
          );
          // `a { transition: color 0.3s }`: po vypnutí skrývacieho štýlu farba 300 ms dobieha
          await sleep(700);
          const items = await page.evaluate(collectInPage);
          const a64 = await page.screenshot({
            type: "png",
            encoding: "base64",
          });
          await page.evaluate((h) => {
            h.disabled = false;
          }, hideHandle);
          await sleep(250);
          const b64 = await page.screenshot({
            type: "png",
            encoding: "base64",
          });
          await page.evaluate((h) => {
            h.disabled = true;
          }, hideHandle);
          for (const item of items) {
            const result = await page.evaluate(analyzeInPage, {
              a64,
              b64,
              rect: item.rect,
              fg: item.fg,
            });
            const large =
              item.fontSize >= 24 ||
              (item.fontSize >= 18.66 && item.fontWeight >= 700);
            rows.push({
              theme,
              lang,
              opacity,
              color,
              label: item.label,
              text: item.text,
              size: `${item.fontSize}/${item.fontWeight}`,
              need: large ? 3 : 4.5,
              p5: result.p5,
              n: result.n,
            });
          }
        }
        if (overrideHandle) {
          await page.evaluate((h) => {
            h.disabled = true;
          }, overrideHandle);
        }
      }
      await page.close();
    }
  }
} finally {
  await browser.close();
}

fs.writeFileSync(
  path.join(OUT, "nav-worstcase.json"),
  JSON.stringify(rows, null, 1),
);
const groups = new Map();
for (const row of rows) {
  const key = `${row.theme} ${row.lang} krytie=${row.opacity} podklad=${row.color}`;
  const worst = groups.get(key);
  const margin = row.p5 - row.need;
  if (!worst || margin < worst.margin) groups.set(key, { margin, row });
}
let failures = 0;
for (const [key, { margin, row }] of groups) {
  const flag = margin < 0 ? "FAIL" : "ok  ";
  if (margin < 0) failures += 1;
  console.log(
    `${flag} ${key}  najhorší: ${row.label} "${row.text}" ${row.size}px  ${row.p5.toFixed(2)} / ${row.need}  (rezerva ${margin.toFixed(2)})`,
  );
}
console.log(
  failures === 0 ? "NAJHORSÍ PRÍPAD OK" : `NAJHORSÍ PRÍPAD NÁLEZY: ${failures}`,
);
process.exit(failures === 0 ? 0 : 1);
