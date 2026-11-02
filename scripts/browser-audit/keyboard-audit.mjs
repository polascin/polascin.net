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
  readAxeSource,
} from "./lib.mjs";

// Ovládanie klávesnicou v reálnom prehliadači (len GET, formuláre sa nikdy
// neodosielajú; stláča sa iba Tab, a Enter, Space a Escape na vlastných
// ovládacích prvkoch webu).
//
// 1. Prechod Tabom cez stránku: každý stop sa zmeria. Kontroluje sa, či
//    zaostrený prvok nie je mimo okna, celý pod pevnou lištou alebo cookie
//    bannerom (WCAG 2.2 SC 2.4.11) a či má viditeľný ukazovateľ fokusu
//    (porovnanie snímky so zaostrením a bez zaostrenia, kontrast aspoň 3:1).
// 2. Správanie vlastných prvkov: skip link, prepínač jazyka (aj axe v otvorenom
//    stave), tlačidlo témy, mobilné menu (Enter, Space, Escape, pasca Tabu,
//    návrat fokusu), cookie banner, prefers-reduced-motion.
const langs = (process.env.LANGS || "sk,en").split(",");
const themes = (process.env.THEMES || "light,dark").split(",");
const states = (process.env.STATES || "banner,clean").split(",");
const viewportNames = (process.env.VIEWPORTS || "desktop,mobile").split(",");
const VIEWPORTS = {
  desktop: { width: 1280, height: 800 },
  compact: { width: 1100, height: 800 },
  mobile: {
    width: 390,
    height: 844,
    isMobile: true,
    hasTouch: true,
    deviceScaleFactor: 2,
  },
  narrow: {
    width: 320,
    height: 640,
    isMobile: true,
    hasTouch: true,
    deviceScaleFactor: 2,
  },
  tiny: {
    width: 320,
    height: 568,
    isMobile: true,
    hasTouch: true,
    deviceScaleFactor: 2,
  },
  landscape: {
    width: 667,
    height: 375,
    isMobile: true,
    hasTouch: true,
    deviceScaleFactor: 2,
  },
};
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
  "home,articles,article,library,privacy,contact,newsletter,login"
).split(",");
const MAX_STOPS = Number(process.env.MAX_STOPS || 140);
const TRAVERSAL = process.env.TRAVERSAL !== "0";
const BEHAVIOUR = process.env.BEHAVIOUR !== "0";
const PIXELS = process.env.PIXELS !== "0";
const AXE_OPEN = process.env.AXE_OPEN !== "0";
const axeSource = AXE_OPEN ? readAxeSource() : "";

const findings = [];
const checks = [];
const indicatorSeen = new Set();
const indicatorRows = [];

const addFinding = (where, severity, kind, detail) => {
  findings.push({ where, severity, kind, detail });
  console.log(
    `  ${severity === "fail" ? "CHYBA" : "POZOR"} ${kind}: ${detail}`,
  );
};
const addCheck = (where, name, ok, detail = "") => {
  checks.push({ where, name, ok, detail });
  if (!ok)
    findings.push({
      where,
      severity: "fail",
      kind: "správanie",
      detail: `${name}${detail ? " (" + detail + ")" : ""}`,
    });
  console.log(
    `  ${ok ? "OK   " : "CHYBA"} ${name}${detail ? "  " + detail : ""}`,
  );
};

const settleInPage = async () => {
  await new Promise((resolve) => {
    let last = "";
    let stable = 0;
    let ticks = 0;
    const tick = () => {
      const el = document.activeElement;
      const rect =
        el && el.getBoundingClientRect
          ? el.getBoundingClientRect()
          : { left: 0, top: 0 };
      const key = `${window.scrollX},${window.scrollY},${Math.round(rect.left)},${Math.round(rect.top)}`;
      if (key === last) stable += 1;
      else {
        stable = 0;
        last = key;
      }
      ticks += 1;
      if (stable >= 5 || ticks > 70) resolve();
      else setTimeout(tick, 40);
    };
    tick();
  });
};

const markSeenInPage = () => {
  const el = document.activeElement;
  if (!el || el === document.body || el === document.documentElement)
    return false;
  window.__kbSeen = window.__kbSeen || new WeakSet();
  const repeat = window.__kbSeen.has(el);
  window.__kbSeen.add(el);
  return repeat;
};

const measureInPage = () => {
  const el = document.activeElement;
  if (!el || el === document.body || el === document.documentElement)
    return { body: true };
  const rect = el.getBoundingClientRect();
  const vw = window.innerWidth;
  const vh = window.innerHeight;
  // Zalomený odkaz má viac riadkových boxov, ich spoločný obdĺžnik by zasahoval
  // aj do susedných odkazov, preto sa vzorkuje každý riadkový box osobitne.
  const boxes = [...el.getClientRects()].filter(
    (r) => r.width > 0 && r.height > 0,
  );
  if (boxes.length === 0) boxes.push(rect);
  let inViewport = false;
  let covered = 0;
  let total = 0;
  const coveredBy = new Set();
  for (const box of boxes) {
    const left = Math.max(0, box.left);
    const right = Math.min(vw, box.right);
    const top = Math.max(0, box.top);
    const bottom = Math.min(vh, box.bottom);
    if (!(right > left && bottom > top)) continue;
    inViewport = true;
    for (const fx of [0.1, 0.5, 0.9]) {
      for (const fy of [0.1, 0.5, 0.9]) {
        const x = left + (right - left) * fx;
        const y = top + (bottom - top) * fy;
        const hit = document.elementFromPoint(x, y);
        total += 1;
        if (!hit || !(el.contains(hit) || hit.contains(el))) {
          covered += 1;
          const named = hit
            ? hit.closest(".cookie-banner, nav.navbar, footer, main, header")
            : null;
          coveredBy.add(
            named
              ? `${named.tagName.toLowerCase()}${named.className && typeof named.className === "string" ? "." + named.className.trim().split(/\s+/)[0] : ""}`
              : hit
                ? hit.tagName.toLowerCase()
                : "nič",
          );
        }
      }
    }
  }
  const tag = el.tagName.toLowerCase();
  const cls =
    typeof el.className === "string" && el.className.trim()
      ? "." + el.className.trim().split(/\s+/).join(".")
      : "";
  const labelledBy = el.getAttribute("aria-labelledby");
  const labelledText = labelledBy
    ? labelledBy
        .split(/\s+/)
        .map((id) => (document.getElementById(id) || {}).textContent || "")
        .join(" ")
    : "";
  const name = (
    el.getAttribute("aria-label") ||
    labelledText ||
    el.textContent ||
    el.getAttribute("value") ||
    el.getAttribute("title") ||
    (el.querySelector("img") && el.querySelector("img").getAttribute("alt")) ||
    ""
  )
    .replace(/\s+/g, " ")
    .trim();
  return {
    tag,
    id: el.id || "",
    cls,
    type: el.getAttribute("type") || "",
    text: name.slice(0, 30),
    unnamed:
      name.length === 0 && !["input", "select", "textarea"].includes(tag),
    signature: `${tag}${cls}${el.getAttribute("type") ? "[" + el.getAttribute("type") + "]" : ""}`,
    region: el.closest("#cookie-consent-container")
      ? "banner"
      : el.closest("nav")
        ? "nav"
        : el.closest("footer")
          ? "footer"
          : el.closest("main")
            ? "main"
            : "other",
    rect: {
      left: Math.round(rect.left),
      top: Math.round(rect.top),
      width: Math.round(rect.width),
      height: Math.round(rect.height),
    },
    scrollY: Math.round(window.scrollY),
    inViewport,
    tiny: rect.width < 2 || rect.height < 2,
    covered,
    total,
    coveredBy: [...coveredBy],
    tabindex: el.getAttribute("tabindex"),
  };
};

const diffInPage = async (payload) => {
  const { a64, b64, region, dpr, ring } = payload;
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
      data: context.getImageData(0, 0, bitmap.width, bitmap.height).data,
      width: bitmap.width,
      height: bitmap.height,
    };
  };
  const A = await decode(a64);
  const B = await decode(b64);
  const x0 = Math.max(0, Math.floor(region.left * dpr));
  const y0 = Math.max(0, Math.floor(region.top * dpr));
  const x1 = Math.min(A.width, Math.ceil(region.right * dpr));
  const y1 = Math.min(A.height, Math.ceil(region.bottom * dpr));
  const lum = (r, g, b) => {
    const f = (c) => {
      const s = c / 255;
      return s <= 0.03928 ? s / 12.92 : ((s + 0.055) / 1.055) ** 2.4;
    };
    return 0.2126 * f(r) + 0.7152 * f(g) + 0.0722 * f(b);
  };
  let changed = 0;
  let strong = 0;
  let maxRatio = 1;
  for (let y = y0; y < y1; y += 1) {
    for (let x = x0; x < x1; x += 1) {
      const i = (y * A.width + x) * 4;
      const diff = Math.max(
        Math.abs(A.data[i] - B.data[i]),
        Math.abs(A.data[i + 1] - B.data[i + 1]),
        Math.abs(A.data[i + 2] - B.data[i + 2]),
      );
      if (diff < 24) continue;
      changed += 1;
      const l1 = lum(A.data[i], A.data[i + 1], A.data[i + 2]);
      const l2 = lum(B.data[i], B.data[i + 1], B.data[i + 2]);
      const ratio = (Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05);
      if (ratio >= 3) strong += 1;
      if (ratio > maxRatio) maxRatio = ratio;
    }
  }

  // Obrys fokusu: pásmo medzi okrajom prvku posunutým o outline-offset a o
  // outline-offset + outline-width. V každom bode pásma sa porovná snímka so
  // zaostrením a bez neho, takže zmeny výplne, posun alebo tieň sa nezapočítajú.
  const ringFractions = { top: null, right: null, bottom: null, left: null };
  if (ring) {
    const near = ring.offset * dpr;
    const far = (ring.offset + ring.width) * dpr;
    const bandPixels = (from, to) => {
      const first = Math.ceil(from);
      const last = Math.floor(to) - 1;
      if (last >= first) return [first, last];
      const middle = Math.round((from + to) / 2 - 0.5);
      return [middle, middle];
    };
    const count = (xs, ys) => {
      let total = 0;
      let hits = 0;
      for (let y = ys[0]; y <= ys[1]; y += 1) {
        for (let x = xs[0]; x <= xs[1]; x += 1) {
          if (x < 0 || y < 0 || x >= A.width || y >= A.height) continue;
          const i = (y * A.width + x) * 4;
          const l1 = lum(A.data[i], A.data[i + 1], A.data[i + 2]);
          const l2 = lum(B.data[i], B.data[i + 1], B.data[i + 2]);
          total += 1;
          if ((Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05) >= 3)
            hits += 1;
        }
      }
      return total ? { total, hits } : null;
    };
    const merged = { top: [], right: [], bottom: [], left: [] };
    for (const box of ring.boxes) {
      const L = box.left * dpr;
      const T = box.top * dpr;
      const R = box.right * dpr;
      const D = box.bottom * dpr;
      const xs = [
        Math.ceil(L + (R - L) * 0.25),
        Math.floor(L + (R - L) * 0.75),
      ];
      const ys = [Math.ceil(T + (D - T) * 0.4), Math.floor(T + (D - T) * 0.6)];
      for (const side of box.sides) {
        if (side === "top")
          merged.top.push(count(xs, bandPixels(T - far, T - near)));
        if (side === "bottom")
          merged.bottom.push(count(xs, bandPixels(D + near, D + far)));
        if (side === "left")
          merged.left.push(count(bandPixels(L - far, L - near), ys));
        if (side === "right")
          merged.right.push(count(bandPixels(R + near, R + far), ys));
      }
    }
    for (const side of Object.keys(merged)) {
      const parts = merged[side].filter(Boolean);
      const total = parts.reduce((sum, part) => sum + part.total, 0);
      if (total)
        ringFractions[side] =
          Math.round(
            (parts.reduce((sum, part) => sum + part.hits, 0) / total) * 100,
          ) / 100;
    }
  }
  return {
    changed,
    strong,
    maxRatio: Math.round(maxRatio * 100) / 100,
    ring: ring ? ringFractions : null,
  };
};

async function focusIndicator(page) {
  await sleep(500);
  const geometry = await page.evaluate(() => {
    const el = document.activeElement;
    const r = el.getBoundingClientRect();
    const cs = getComputedStyle(el);
    const width = parseFloat(cs.outlineWidth) || 0;
    const drawn =
      cs.outlineStyle !== "none" && cs.outlineStyle !== "auto" && width > 0;
    const fragments = [...el.getClientRects()].filter(
      (f) => f.width > 0 && f.height > 0,
    );
    const box = (f, sides) => ({
      left: f.left,
      top: f.top,
      right: f.right,
      bottom: f.bottom,
      sides,
    });
    // Zalomený riadkový odkaz má viac obdĺžnikov: meria sa horný okraj prvého
    // a dolný okraj posledného riadku, bočné strany by nezodpovedali jednému
    // obdĺžniku.
    const boxes =
      fragments.length > 1
        ? [
            box(fragments[0], ["top"]),
            box(fragments[fragments.length - 1], ["bottom"]),
          ]
        : [box(r, ["top", "right", "bottom", "left"])];
    return {
      left: r.left - 10,
      top: r.top - 10,
      right: r.right + 10,
      bottom: r.bottom + 10,
      dpr: window.devicePixelRatio,
      perimeter: 2 * (r.width + r.height),
      outline: {
        color: cs.outlineColor,
        width,
        offset: parseFloat(cs.outlineOffset) || 0,
        drawn,
      },
      boxes,
    };
  });
  const a64 = await page.screenshot({ type: "png", encoding: "base64" });
  await page.evaluate(() => {
    window.__kbHold = document.activeElement;
    document.activeElement.blur();
  });
  await sleep(500);
  const b64 = await page.screenshot({ type: "png", encoding: "base64" });
  await page.evaluate(() => window.__kbHold.focus({ preventScroll: true }));
  await sleep(150);
  const result = await page.evaluate(diffInPage, {
    a64,
    b64,
    region: geometry,
    dpr: geometry.dpr,
    ring: geometry.outline.drawn
      ? {
          width: geometry.outline.width,
          offset: geometry.outline.offset,
          boxes: geometry.boxes,
        }
      : null,
  });
  return {
    ...result,
    outline: geometry.outline,
    perimeter: geometry.perimeter,
    dpr: geometry.dpr,
  };
}

const sideNames = {
  top: "hore",
  right: "vpravo",
  bottom: "dolu",
  left: "vľavo",
};

async function traverse(page, where, themeKey) {
  const pageName = where.split("/").pop();
  const stops = [];
  await page.evaluate(() => {
    window.__kbSeen = new WeakSet();
    if (document.activeElement && document.activeElement !== document.body)
      document.activeElement.blur();
    window.scrollTo(0, 0);
  });
  await sleep(250);
  for (let i = 0; i < MAX_STOPS; i += 1) {
    await page.keyboard.press("Tab");
    await page.evaluate(settleInPage);
    let stop = await page.evaluate(measureInPage);
    if (stop.body) {
      if (i > 0) break;
      continue;
    }
    if (await page.evaluate(markSeenInPage)) break;
    if (!stop.inViewport || stop.covered === stop.total) {
      await sleep(900);
      await page.evaluate(settleInPage);
      stop = await page.evaluate(measureInPage);
    }
    stops.push(stop);
    const label = `${stop.region} ${stop.signature} "${stop.text}"`;
    if (process.env.DUMP)
      console.log(
        `  #${stops.length} ${label} rect=${JSON.stringify(stop.rect)} scrollY=${stop.scrollY} prekrytie=${stop.covered}/${stop.total}`,
      );
    if (!stop.inViewport)
      addFinding(
        where,
        "fail",
        "mimo okna",
        `${label}: zaostrený prvok nie je vo viditeľnej časti okna`,
      );
    else if (stop.tiny)
      addFinding(
        where,
        "fail",
        "neviditeľný fokus",
        `${label}: fokusovateľný prvok má nulový rozmer (${stop.rect.width}x${stop.rect.height})`,
      );
    else if (stop.covered === stop.total)
      addFinding(
        where,
        "fail",
        "úplne prekrytý",
        `${label}: celý prekrytý (${stop.coveredBy.join(", ")}), y=${stop.rect.top}, scroll ${stop.scrollY}`,
      );
    else if (stop.covered / stop.total >= 0.5)
      addFinding(
        where,
        "warn",
        "čiastočne prekrytý",
        `${label}: ${stop.covered}/${stop.total} bodov prekrytých (${stop.coveredBy.join(", ")})`,
      );
    if (stop.unnamed)
      addFinding(
        where,
        "fail",
        "bez názvu",
        `${label}: ovládací prvok nemá prístupný názov`,
      );
    if (stop.tabindex && Number(stop.tabindex) > 0)
      addFinding(
        where,
        "fail",
        "kladný tabindex",
        `${label}: tabindex=${stop.tabindex}`,
      );
    // Prvky spoločné pre celý web (hlavička, pätička, banner) sa merajú raz,
    // obsah stránky raz na každú stránku, lebo pozadie okolo prvku sa líši.
    const chrome = ["nav", "footer", "banner"].includes(stop.region);
    const key = `${themeKey}|${chrome ? stop.region : pageName}|${stop.signature}`;
    if (
      PIXELS &&
      stop.inViewport &&
      !stop.tiny &&
      stop.covered === 0 &&
      !indicatorSeen.has(key)
    ) {
      indicatorSeen.add(key);
      const indicator = await focusIndicator(page);
      stop.indicator = indicator;
      indicatorRows.push({
        where,
        signature: stop.signature,
        text: stop.text,
        ...indicator,
      });
      const ringSides = indicator.ring
        ? Object.entries(indicator.ring).filter(([, value]) => value !== null)
        : [];
      const ringText = ringSides
        .map(
          ([side, value]) => `${sideNames[side]} ${Math.round(value * 100)} %`,
        )
        .join(", ");
      const minimumArea = Math.max(
        12,
        Math.round(indicator.perimeter * indicator.dpr * indicator.dpr),
      );
      if (indicator.changed === 0)
        addFinding(
          where,
          "fail",
          "bez ukazovateľa fokusu",
          `${label}: snímka so zaostrením a bez neho je rovnaká`,
        );
      else if (ringSides.length) {
        const shares = ringSides.map(([, value]) => value);
        if (Math.max(...shares) < 0.5)
          addFinding(
            where,
            "fail",
            "neviditeľný obrys fokusu",
            `${label}: obrys ${indicator.outline.width}px ${indicator.outline.color} má voči pozadiu kontrast pod 3:1 (podiel bodov s kontrastom aspoň 3:1: ${ringText})`,
          );
        else if (Math.min(...shares) < 0.5)
          addFinding(
            where,
            "warn",
            "orezaný obrys fokusu",
            `${label}: obrys je s dostatočným kontrastom len na niektorých stranách (${ringText})`,
          );
      } else if (indicator.strong < minimumArea)
        addFinding(
          where,
          "warn",
          "slabý ukazovateľ fokusu",
          `${label}: zmenených bodov ${indicator.changed}, s kontrastom aspoň 3:1 len ${indicator.strong} z potrebných ${minimumArea} (najvyšší ${indicator.maxRatio}:1)`,
        );
    }
  }
  return stops;
}

async function openPage(
  browser,
  ua,
  { lang, theme, state, viewport, pathName, reduceMotion = false },
) {
  const log = newLog();
  const page = await newPage(browser, ua, log, viewport);
  await page.evaluateOnNewDocument(
    (selectedTheme, hideBanner) => {
      try {
        window.localStorage.setItem("theme", selectedTheme);
        // Stav „banner“ musí začínať bez uloženého súhlasu aj po predchádzajúcom
        // teste, ktorý kliknutím na „Odmietnuť“ voľbu uložil.
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
  if (reduceMotion)
    await page.emulateMediaFeatures([
      { name: "prefers-reduced-motion", value: "reduce" },
    ]);
  const url = `${BASE}${pathName}${pathName.includes("?") ? "&" : "?"}lang=${lang}`;
  await gotoWithRetry(page, url);
  await page.evaluate(() => document.fonts.ready.then(() => true));
  await sleep(900);
  return { page, log };
}

const menuState = () => {
  const toggle = document.getElementById("navToggle");
  const menu = document.getElementById("navMenu");
  const active = document.activeElement;
  return {
    toggleVisible: getComputedStyle(toggle).display !== "none",
    expanded: toggle.getAttribute("aria-expanded"),
    label: toggle.getAttribute("aria-label"),
    labelClose: toggle.dataset.labelClose,
    labelOpen: toggle.dataset.labelOpen,
    inert: menu.inert,
    ariaHidden: menu.getAttribute("aria-hidden"),
    focusInMenu: menu.contains(active),
    activeId: active ? active.id : "",
    inNavbar: Boolean(active && active.closest("nav.navbar")),
    activeText: active
      ? (active.textContent || "").replace(/\s+/g, " ").trim().slice(0, 24)
      : "",
  };
};

async function menuBehaviour(page, where) {
  const initial = await page.evaluate(menuState);
  if (!initial.toggleVisible) return false;
  addCheck(
    where,
    "menu zatvorené: aria-expanded=false, inert, aria-hidden=true",
    initial.expanded === "false" &&
      initial.inert === true &&
      initial.ariaHidden === "true",
    JSON.stringify({
      expanded: initial.expanded,
      inert: initial.inert,
      hidden: initial.ariaHidden,
    }),
  );

  await page.focus("#navToggle");
  let leaked = 0;
  for (let i = 0; i < 6; i += 1) {
    await page.keyboard.press("Tab");
    const inMenu = await page.evaluate(() =>
      Boolean(
        document.activeElement && document.activeElement.closest("#navMenu"),
      ),
    );
    if (inMenu) leaked += 1;
  }
  addCheck(
    where,
    "zatvorené menu: Tab nevstúpi do skrytých položiek",
    leaked === 0,
    `vstupov do menu: ${leaked}`,
  );

  await page.focus("#navToggle");
  await page.keyboard.press("Enter");
  await sleep(450);
  let state = await page.evaluate(menuState);
  addCheck(
    where,
    "Enter otvorí menu (aria-expanded=true, menu nie je inert)",
    state.expanded === "true" &&
      state.inert === false &&
      state.ariaHidden === "false",
    JSON.stringify({
      expanded: state.expanded,
      inert: state.inert,
      hidden: state.ariaHidden,
    }),
  );
  addCheck(
    where,
    "popis tlačidla sa po otvorení zmení na „zavrieť“",
    Boolean(state.labelClose) && state.label === state.labelClose,
    `popis: ${state.label}`,
  );
  addCheck(
    where,
    "po otvorení je fokus na prvej položke menu",
    state.focusInMenu,
    `fokus: ${state.activeText}`,
  );

  const count = await page.evaluate(
    () =>
      Array.from(
        document.querySelectorAll(
          "nav.navbar a[href], nav.navbar button:not([disabled]), nav.navbar summary",
        ),
      ).filter(
        (item) => item.getClientRects().length > 0 && !item.closest("[inert]"),
      ).length,
  );
  let escaped = 0;
  for (let i = 0; i < count + 3; i += 1) {
    await page.keyboard.press("Tab");
    if (
      !(await page.evaluate(() =>
        Boolean(
          document.activeElement &&
          document.activeElement.closest("nav.navbar"),
        ),
      ))
    )
      escaped += 1;
  }
  addCheck(
    where,
    "otvorené menu: Tab neopustí navigáciu (pasca)",
    escaped === 0,
    `únikov: ${escaped} z ${count + 3} stlačení, prvkov v navigácii ${count}`,
  );

  await page.focus(".nav-brand");
  await page.keyboard.down("Shift");
  await page.keyboard.press("Tab");
  await page.keyboard.up("Shift");
  state = await page.evaluate(menuState);
  addCheck(
    where,
    "otvorené menu: Shift+Tab z prvej položky ide na poslednú",
    state.focusInMenu && state.inNavbar,
    `fokus: ${state.activeText}`,
  );

  await page.keyboard.press("Escape");
  await sleep(300);
  state = await page.evaluate(menuState);
  addCheck(
    where,
    "Escape zavrie menu a vráti fokus na tlačidlo",
    state.expanded === "false" &&
      state.inert === true &&
      state.activeId === "navToggle",
    JSON.stringify({
      expanded: state.expanded,
      inert: state.inert,
      active: state.activeId,
    }),
  );

  await page.keyboard.press("Space");
  await sleep(450);
  state = await page.evaluate(menuState);
  addCheck(
    where,
    "Medzerník na tlačidle otvorí menu",
    state.expanded === "true" && state.focusInMenu,
    JSON.stringify({ expanded: state.expanded, inMenu: state.focusInMenu }),
  );
  await page.keyboard.press("Escape");
  await sleep(300);
  return true;
}

const langState = () => {
  const details = document.querySelector(".lang-switcher");
  const summary = details.querySelector("summary");
  const active = document.activeElement;
  return {
    open: details.open,
    onSummary: active === summary,
    onLink: Boolean(
      active &&
      active.classList &&
      active.classList.contains("lang-switcher-link"),
    ),
    activeText: active
      ? (active.textContent || "").replace(/\s+/g, " ").trim().slice(0, 20)
      : "",
    activeId: active ? active.id : "",
  };
};

const langGeometry = () => {
  const links = Array.from(document.querySelectorAll(".lang-switcher-link"));
  const vw = window.innerWidth;
  const vh = window.innerHeight;
  const problems = [];
  for (const link of links) {
    const r = link.getBoundingClientRect();
    if (
      r.left < -0.5 ||
      r.right > vw + 0.5 ||
      r.top < -0.5 ||
      r.bottom > vh + 0.5
    )
      problems.push(
        `${link.textContent.trim()} mimo okna (${Math.round(r.left)}..${Math.round(r.right)}, ${Math.round(r.top)}..${Math.round(r.bottom)})`,
      );
    const hit = document.elementFromPoint(
      r.left + r.width / 2,
      r.top + r.height / 2,
    );
    if (!hit || !(link.contains(hit) || hit.contains(link)))
      problems.push(
        `${link.textContent.trim()} prekrytý (${hit ? hit.tagName.toLowerCase() : "nič"})`,
      );
  }
  return { count: links.length, problems };
};

async function langBehaviour(page, where) {
  await page.focus(".lang-switcher-toggle");
  await page.keyboard.press("Enter");
  await sleep(350);
  let state = await page.evaluate(langState);
  addCheck(where, "prepínač jazyka: Enter otvorí ponuku", state.open);
  const geometry = await page.evaluate(langGeometry);
  addCheck(
    where,
    "ponuka jazykov: všetkých 10 odkazov je v okne a nie je prekrytých",
    geometry.count === 10 && geometry.problems.length === 0,
    geometry.problems.slice(0, 3).join("; ") || `odkazov ${geometry.count}`,
  );

  if (AXE_OPEN) {
    await page.evaluate(axeSource);
    const axe = await page.evaluate(async () => {
      const output = await window.axe.run(document, {
        runOnly: {
          type: "tag",
          values: [
            "wcag2a",
            "wcag2aa",
            "wcag21a",
            "wcag21aa",
            "wcag22aa",
            "best-practice",
          ],
        },
        resultTypes: ["violations"],
      });
      return output.violations.map(
        (rule) =>
          `${rule.id}: ${rule.nodes
            .map((node) => node.target.join(" "))
            .slice(0, 3)
            .join(", ")}`,
      );
    });
    addCheck(
      where,
      "axe pri otvorenej ponuke jazykov: žiadne porušenia",
      axe.length === 0,
      axe.join(" | "),
    );
  }

  await page.keyboard.press("Tab");
  state = await page.evaluate(langState);
  addCheck(
    where,
    "Tab zo súhrnu ide na prvý odkaz ponuky",
    state.onLink,
    `fokus: ${state.activeText}`,
  );
  let reached = 1;
  for (let i = 0; i < 9; i += 1) {
    await page.keyboard.press("Tab");
    if ((await page.evaluate(langState)).onLink) reached += 1;
  }
  addCheck(
    where,
    "Tab prejde všetkých 10 odkazov ponuky",
    reached === 10,
    `odkazov: ${reached}`,
  );
  await page.keyboard.press("Tab");
  await sleep(250);
  state = await page.evaluate(langState);
  addCheck(
    where,
    "po poslednom odkaze Tab ponuku zavrie a ide ďalej",
    state.open === false && state.activeId === "themeToggle",
    JSON.stringify({
      open: state.open,
      active: state.activeId || state.activeText,
    }),
  );

  await page.focus(".lang-switcher-toggle");
  await page.keyboard.press("Space");
  await sleep(300);
  state = await page.evaluate(langState);
  addCheck(where, "prepínač jazyka: Medzerník otvorí ponuku", state.open);
  await page.keyboard.press("Tab");
  await page.keyboard.press("Escape");
  await sleep(250);
  state = await page.evaluate(langState);
  addCheck(
    where,
    "Escape zavrie ponuku a vráti fokus na súhrn",
    state.open === false && state.onSummary,
    JSON.stringify({ open: state.open, onSummary: state.onSummary }),
  );
}

const themeState = () => {
  const toggle = document.getElementById("themeToggle");
  return {
    pressed: toggle.getAttribute("aria-pressed"),
    label: toggle.getAttribute("aria-label"),
    theme: document.documentElement.getAttribute("data-theme"),
    focused: document.activeElement === toggle,
  };
};

async function themeBehaviour(page, where) {
  await page.focus("#themeToggle");
  const before = await page.evaluate(themeState);
  await page.keyboard.press("Enter");
  await sleep(500);
  const after = await page.evaluate(themeState);
  addCheck(
    where,
    "tlačidlo témy: Enter prepne tému, aria-pressed aj popis",
    after.theme !== before.theme &&
      after.pressed !== before.pressed &&
      after.label !== before.label,
    JSON.stringify({ before, after }),
  );
  addCheck(where, "tlačidlo témy: fokus zostane na tlačidle", after.focused);
  await page.keyboard.press("Space");
  await sleep(500);
  const back = await page.evaluate(themeState);
  addCheck(
    where,
    "tlačidlo témy: Medzerník vráti pôvodnú tému",
    back.theme === before.theme &&
      back.pressed === before.pressed &&
      back.label === before.label,
  );
}

async function skipBehaviour(page, where) {
  await page.evaluate(() => {
    if (document.activeElement && document.activeElement !== document.body)
      document.activeElement.blur();
    window.scrollTo(0, 0);
  });
  await sleep(250);
  await page.keyboard.press("Tab");
  await sleep(450);
  const first = await page.evaluate(() => {
    const el = document.activeElement;
    const r = el.getBoundingClientRect();
    return {
      skip: el.classList.contains("skip-link"),
      visible:
        r.width > 8 &&
        r.height > 8 &&
        r.left >= 0 &&
        r.top >= 0 &&
        r.right <= window.innerWidth &&
        r.bottom <= window.innerHeight,
      text: (el.textContent || "").trim(),
    };
  });
  addCheck(
    where,
    "skip link je prvý stop klávesnice",
    first.skip,
    `prvý prvok: ${first.text}`,
  );
  addCheck(where, "skip link je po zaostrení celý viditeľný", first.visible);
  await page.keyboard.press("Enter");
  await sleep(700);
  const moved = await page.evaluate(() => ({
    hash: window.location.hash,
    active: document.activeElement ? document.activeElement.id : "",
  }));
  addCheck(
    where,
    "Enter na skip linku presunie fokus na hlavný obsah",
    moved.hash === "#main-content" && moved.active === "main-content",
    JSON.stringify(moved),
  );
  await page.keyboard.press("Tab");
  await sleep(300);
  const next = await page.evaluate(() => {
    const main = document.getElementById("main-content");
    return {
      inMain:
        main.contains(document.activeElement) &&
        document.activeElement !== main,
      tag: document.activeElement
        ? document.activeElement.tagName.toLowerCase()
        : "",
    };
  });
  addCheck(
    where,
    "po skip linku Tab pokračuje v hlavnom obsahu",
    next.inMain,
    `prvok: ${next.tag}`,
  );
}

async function bannerBehaviour(page, where, stops) {
  const dialog = await page.evaluate(() => {
    const banner = document.querySelector(
      "#cookie-consent-container .cookie-banner",
    );
    if (!banner) return null;
    const labelled = banner.getAttribute("aria-labelledby");
    return {
      role: banner.getAttribute("role"),
      modal: banner.getAttribute("aria-modal"),
      named: Boolean(
        labelled &&
        document.getElementById(labelled) &&
        document.getElementById(labelled).textContent.trim(),
      ),
    };
  });
  addCheck(
    where,
    "cookie banner je pomenovaný dialóg (role, aria-labelledby)",
    Boolean(dialog) && dialog.role === "dialog" && dialog.named,
    JSON.stringify(dialog),
  );
  const bannerStops = stops.filter((stop) => stop.region === "banner");
  const signatures = bannerStops.map((stop) => stop.signature);
  addCheck(
    where,
    "banner: Tab sa dostane na obe tlačidlá aj odkaz na zásady",
    signatures.some((s) => s.includes("btn-cookie-decline")) &&
      signatures.some((s) => s.includes("btn-cookie-accept")) &&
      signatures.some((s) => s.includes("cookie-link")),
    `stopy v bannere: ${signatures.join(", ")}`,
  );
  const lastRegion = stops.length ? stops[stops.length - 1].region : "";
  addCheck(
    where,
    "banner je v poradí Tabu až za pätou (po obsahu)",
    lastRegion === "banner",
    `posledný stop: ${lastRegion}`,
  );
  if (!(await page.$(".btn-cookie-decline"))) {
    addCheck(
      where,
      "banner má tlačidlo „Odmietnuť“",
      false,
      "tlačidlo sa nenašlo",
    );
    return;
  }
  await page.focus(".btn-cookie-decline");
  await page.keyboard.press("Enter");
  await sleep(600);
  const closed = await page.evaluate(() => ({
    banner: Boolean(
      document.querySelector("#cookie-consent-container .cookie-banner"),
    ),
    stored: window.localStorage.getItem("privacy_consent_clarity_v1"),
    active: document.activeElement
      ? document.activeElement.tagName.toLowerCase()
      : "",
  }));
  addCheck(
    where,
    "Enter na „Odmietnuť“ banner zavrie a uloží voľbu",
    closed.banner === false && closed.stored === "rejected",
    JSON.stringify(closed),
  );
}

async function motionBehaviour(browser, ua, ctx, where) {
  const { page } = await openPage(browser, ua, {
    ...ctx,
    state: "banner",
    pathName: "/",
    reduceMotion: true,
  });
  await sleep(900);
  const result = await page.evaluate(() => ({
    animations: document
      .getAnimations()
      .filter(
        (animation) =>
          animation.playState === "running" &&
          !(animation.effect && animation.effect.getTiming().duration <= 1),
      ).length,
    behavior: getComputedStyle(document.documentElement).scrollBehavior,
  }));
  addCheck(
    where,
    "prefers-reduced-motion: žiadna bežiaca animácia, scroll-behavior auto",
    result.animations === 0 && result.behavior === "auto",
    JSON.stringify(result),
  );
  await page.close();
}

const results = [];
const { browser, ua } = await launch();
try {
  for (const viewportName of viewportNames) {
    const viewport = VIEWPORTS[viewportName];
    if (!viewport) throw new Error(`Neznámy VIEWPORT: ${viewportName}`);
    for (const theme of themes) {
      for (const lang of langs) {
        if (TRAVERSAL) {
          for (const state of states) {
            for (const name of wanted.filter((item) => allPages[item])) {
              const where = `${viewportName}/${theme}/${lang}/${state}/${name}`;
              const { page, log } = await openPage(browser, ua, {
                lang,
                theme,
                state,
                viewport,
                pathName: allPages[name],
              });
              const stops = await traverse(
                page,
                where,
                `${theme}|${viewportName}`,
              );
              const regions = stops.reduce(
                (acc, stop) => ({
                  ...acc,
                  [stop.region]: (acc[stop.region] || 0) + 1,
                }),
                {},
              );
              console.log(
                `--- ${where}: ${stops.length} stopov ${JSON.stringify(regions)}`,
              );
              results.push({ where, stops: stops.length, regions });
              const issues = summarizeLog(log);
              if (
                issues.consoleIssues.length ||
                issues.pageerror.length ||
                issues.csp.length
              )
                addFinding(
                  where,
                  "fail",
                  "konzola/CSP",
                  JSON.stringify([
                    issues.consoleIssues,
                    issues.pageerror,
                    issues.csp,
                  ]).slice(0, 300),
                );
              if (BEHAVIOUR && state === "banner" && name === "home")
                await bannerBehaviour(page, where, stops);
              await page.close();
              await sleep(2200);
            }
          }
        }
        if (BEHAVIOUR) {
          const where = `${viewportName}/${theme}/${lang}/správanie`;
          console.log(`--- ${where}`);
          const ctx = { lang, theme, viewport };
          let session = await openPage(browser, ua, {
            ...ctx,
            state: "clean",
            pathName: "/",
          });
          await skipBehaviour(session.page, where);
          await session.page.close();
          await sleep(2200);
          session = await openPage(browser, ua, {
            ...ctx,
            state: "clean",
            pathName: "/",
          });
          const hasMenu = await menuBehaviour(session.page, where);
          if (!hasMenu)
            console.log(
              "  (mobilné menu sa v tomto okne nepoužíva, kontrola preskočená)",
            );
          await session.page.close();
          await sleep(2200);
          session = await openPage(browser, ua, {
            ...ctx,
            state: "clean",
            pathName: "/",
          });
          await langBehaviour(session.page, where);
          await themeBehaviour(session.page, where);
          await session.page.close();
          await sleep(2200);
          await motionBehaviour(browser, ua, ctx, where);
          await sleep(2200);
        }
      }
    }
  }
} finally {
  await browser.close();
}

fs.writeFileSync(
  path.join(OUT, "keyboard.json"),
  JSON.stringify(
    { results, findings, checks, indicators: indicatorRows },
    null,
    1,
  ),
);
const failures = findings.filter((finding) => finding.severity === "fail");
const warnings = findings.filter((finding) => finding.severity === "warn");
const grouped = new Map();
for (const finding of findings) {
  const key = `${finding.severity}|${finding.kind}|${finding.detail.replace(/y=-?\d+, scroll \d+/, "")}`;
  const entry = grouped.get(key) || { ...finding, where: [] };
  entry.where.push(finding.where);
  grouped.set(key, entry);
}
console.log(
  `\n=== Súhrn: kontrol správania ${checks.length}, z toho chýb ${checks.filter((check) => !check.ok).length}; nálezov ${failures.length} chýb, ${warnings.length} upozornení`,
);
for (const entry of grouped.values()) {
  console.log(
    `- [${entry.severity}] ${entry.kind}: ${entry.detail}  x${entry.where.length} (${entry.where.slice(0, 3).join(", ")}${entry.where.length > 3 ? ", ..." : ""})`,
  );
}
console.log(failures.length === 0 ? "KLÁVESNICA OK" : "KLÁVESNICA NÁLEZY");
process.exit(failures.length === 0 ? 0 : 1);
