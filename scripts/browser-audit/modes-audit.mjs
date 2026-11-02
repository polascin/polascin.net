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

// Režimy, v ktorých návštevník vidí stránku inak než my: vynútené farby
// (Windows High Contrast), zníženie pohybu, WCAG 1.4.12 (rozostupy textu),
// zväčšený text a vypnutý JavaScript. Každý režim sa meria v reálnom
// prehliadači, nie hádaním z CSS.
//
//  forced   forced-colors: active. Text, ktorý je v bežnom režime viditeľný,
//           musí ostať viditeľný (priehľadná výplň gradientu, zmiznutý prvok),
//           kontrast voči systémovému plátnu, ovládací prvok musí mať hranicu
//           a každé zaostrenie viditeľný obrys.
//  motion   prefers-reduced-motion: reduce. Žiadna bežiaca animácia ani
//           prechod dlhší než 0,05 s, skrolovanie bez animácie a obsah .reveal
//           viditeľný hneď.
//  spacing  WCAG 1.4.12: riadkovanie 1,5, medzera medzi odsekmi 2 × písmo,
//           písmená 0,12 em, slová 0,16 em. Text sa nesmie orezať a stránka
//           nesmie pretiecť do šírky viac než pri bežnom zobrazení.
//  bigtext  koreňové písmo 200 % (WCAG 1.4.4), rovnaké kontroly orezania.
//  nojs     JavaScript vypnutý. Obsah nesmie ostať skrytý a každý cieľ
//           hlavnej navigácie musí byť dosiahnuteľný z viditeľného odkazu.
//
// Premenné: LANGS (sk), THEMES (light,dark), STATES (banner,clean),
// VIEWPORTS (desktop,mobile; k dispozícii aj wide 1440 × 900 a narrow
// 320 × 640), PAGES, MODES, SHOTS=1 (uložiť snímky do AUDIT_OUT), MAX_STOPS
// (150, počet zastavení Tab pri kontrole obrysu zaostrenia vo vynútených
// farbách).
const langs = (process.env.LANGS || "sk").split(",");
const themes = (process.env.THEMES || "light,dark").split(",");
const states = (process.env.STATES || "banner,clean").split(",");
const modes = (process.env.MODES || "forced,motion,spacing,bigtext,nojs").split(
  ",",
);
const SHOTS = process.env.SHOTS === "1";
const MAX_STOPS = Number(process.env.MAX_STOPS || 150);
const allViewports = {
  wide: { width: 1440, height: 900 },
  desktop: { width: 1280, height: 800 },
  mobile: { width: 390, height: 844 },
  narrow: { width: 320, height: 640 },
};
const viewportNames = (process.env.VIEWPORTS || "desktop,mobile").split(",");
const allPages = {
  home: "/",
  articles: "/articles.php",
  article: "/article.php?slug=odporucanie-nie-je-povolenie",
  library: "/library.php",
  privacy: "/privacy.php",
  terms: "/terms.php",
  contact: "/contact.php",
  newsletter: "/newsletter.php",
};
const wanted = (
  process.env.PAGES ||
  "home,articles,article,library,privacy,terms,contact,newsletter,login"
).split(",");

const findings = [];

// Beží v stránke. Vráti stav každého textového uzla (v poradí dokumentu, takže
// sa dá porovnať medzi režimami), ovládacie prvky a pretečenie.
const collectInPage = (cfg) => {
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
  const blend = (fg, bg) => ({
    r: fg.r * fg.a + bg.r * (1 - fg.a),
    g: fg.g * fg.a + bg.g * (1 - fg.a),
    b: fg.b * fg.a + bg.b * (1 - fg.a),
    a: 1,
  });
  const ratioOf = (a, b) => {
    const la = luminance(a);
    const lb = luminance(b);
    return (Math.max(la, lb) + 0.05) / (Math.min(la, lb) + 0.05);
  };
  const signature = (el) => {
    const classes = [...el.classList].slice(0, 2).join(".");
    const parent = el.parentElement;
    const via = parent
      ? parent.tagName.toLowerCase() +
        ([...parent.classList][0] ? "." + [...parent.classList][0] : "")
      : "";
    return `${via} > ${el.tagName.toLowerCase()}${classes ? "." + classes : ""}`;
  };
  const clipsAxis = (value) => value === "hidden" || value === "clip";

  // Plátno stránky: pri vynútených farbách systémová farba Canvas.
  const probe = document.createElement("div");
  probe.style.cssText =
    "position:fixed;left:-9999px;top:0;width:1px;height:1px;background-color:Canvas";
  document.body.appendChild(probe);
  const canvas = parse(getComputedStyle(probe).backgroundColor) || {
    r: 255,
    g: 255,
    b: 255,
    a: 1,
  };
  probe.remove();

  const out = { texts: [], controls: [], overflow: null, canvas };
  const viewportWidth = document.documentElement.clientWidth;
  const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
  while (walker.nextNode()) {
    const node = walker.currentNode;
    const text = node.nodeValue.replace(/\s+/g, " ").trim();
    if (!text) continue;
    const el = node.parentElement;
    if (!el || /^(SCRIPT|STYLE|NOSCRIPT|TEMPLATE|TITLE)$/.test(el.tagName))
      continue;
    const record = { sample: text.slice(0, 40), sig: signature(el) };
    out.texts.push(record);

    const range = document.createRange();
    range.selectNodeContents(node);
    const lines = Array.from(range.getClientRects()).filter(
      (r) => r.width >= 1 && r.height >= 1,
    );
    if (!lines.length) {
      record.state = "none";
      continue;
    }
    const box = range.getBoundingClientRect();
    let hidden = false;
    let opacity = 1;
    const clips = [];
    for (
      let up = el;
      up && up !== document.documentElement;
      up = up.parentElement
    ) {
      const style = getComputedStyle(up);
      if (style.display === "none" || style.visibility === "hidden") {
        hidden = true;
        break;
      }
      opacity *= Number(style.opacity);
      if (
        up !== document.body &&
        (clipsAxis(style.overflowX) || clipsAxis(style.overflowY))
      ) {
        const r = up.getBoundingClientRect();
        clips.push({
          left: r.left + up.clientLeft,
          top: r.top + up.clientTop,
          right: r.left + up.clientLeft + up.clientWidth,
          bottom: r.top + up.clientTop + up.clientHeight,
          x: clipsAxis(style.overflowX),
          y: clipsAxis(style.overflowY),
          sig: signature(up),
        });
      }
    }
    if (hidden) {
      record.state = "hidden";
      continue;
    }
    if (opacity < 0.1) {
      record.state = "opacity";
      continue;
    }
    // Skrytie pre čítače (.visually-hidden): orezaný box 1 × 1 px.
    if (box.width <= 2 || box.height <= 2) {
      record.state = "none";
      continue;
    }
    if (
      box.left >= viewportWidth ||
      box.right <= 0 ||
      box.bottom + scrollY <= 0
    ) {
      record.state = "offscreen";
      continue;
    }
    let worst = 1;
    let worstBy = "";
    for (const line of lines) {
      for (const clip of clips) {
        let fraction = 1;
        if (clip.x) {
          const overlap =
            Math.min(line.right, clip.right) - Math.max(line.left, clip.left);
          fraction *= Math.max(0, Math.min(1, overlap / line.width));
        }
        if (clip.y) {
          const overlap =
            Math.min(line.bottom, clip.bottom) - Math.max(line.top, clip.top);
          fraction *= Math.max(0, Math.min(1, overlap / line.height));
        }
        if (fraction < worst) {
          worst = fraction;
          worstBy = clip.sig;
        }
      }
    }
    if (worst < 0.1) {
      record.state = "clipped";
      record.by = worstBy;
      continue;
    }
    if (worst < 0.9) {
      record.state = "clip-part";
      record.by = worstBy;
      record.fraction = Math.round(worst * 100) / 100;
      continue;
    }
    const style = getComputedStyle(el);
    const colour = parse(style.color);
    const fillValue = parse(style.webkitTextFillColor);
    // Vo vynútených farbách vracia getComputedStyle pre -webkit-text-fill-color
    // pôvodnú farbu autora, hoci sa text vykreslí farbou systému. Kontrast sa
    // preto meria z color; priehľadná výplň sa hlási vždy.
    const fill = cfg.forced ? colour : fillValue || colour;
    if (!fill) {
      record.state = "ok";
      continue;
    }
    record.color = style.color;
    record.fill = style.webkitTextFillColor;
    if (fillValue && fillValue.a < 0.1) {
      record.state = "transparent";
      continue;
    }
    record.state = "ok";
    if (cfg.contrast) {
      let background = null;
      let image = false;
      for (let up = el; up; up = up.parentElement) {
        const s = getComputedStyle(up);
        if (s.backgroundImage !== "none") image = true;
        const bg = parse(s.backgroundColor);
        if (bg && bg.a >= 0.5) {
          background = blend(bg, out.canvas);
          break;
        }
      }
      background = background || out.canvas;
      const size = parseFloat(style.fontSize);
      const bold = Number(style.fontWeight) >= 700;
      const large = size >= 24 || (bold && size >= 18.66);
      const ratio = ratioOf(
        blend({ ...fill, a: fill.a * opacity }, background),
        background,
      );
      record.ratio = Math.round(ratio * 100) / 100;
      record.background = `rgb(${Math.round(background.r)}, ${Math.round(background.g)}, ${Math.round(background.b)})`;
      record.opacity = opacity;
      if (image) record.image = true;
      if (ratio < (large ? 3 : 4.5)) record.state = "lowcontrast";
    }
  }

  if (cfg.controls) {
    const selector =
      'a.btn, .btn, button, input:not([type="hidden"]), select, textarea, summary, [role="button"]';
    for (const el of document.querySelectorAll(selector)) {
      const style = getComputedStyle(el);
      if (style.display === "none" || style.visibility === "hidden") continue;
      const r = el.getBoundingClientRect();
      if (r.width < 2 || r.height < 2) continue;
      if (r.left >= viewportWidth || r.right <= 0) continue;
      const widths = ["Top", "Right", "Bottom", "Left"].map((side) =>
        style[`border${side}Style`] === "none"
          ? 0
          : parseFloat(style[`border${side}Width`]),
      );
      const borderColour = parse(style.borderTopColor);
      const fillColour = parse(style.backgroundColor);
      out.controls.push({
        sig: signature(el),
        sample: (
          el.innerText ||
          el.value ||
          el.getAttribute("aria-label") ||
          ""
        )
          .replace(/\s+/g, " ")
          .trim()
          .slice(0, 30),
        border: Math.max(...widths),
        // Ohraničenie alebo výplň, ktoré tvoria viditeľnú hranicu v bežnom režime.
        boxed:
          (Math.max(...widths) > 0 &&
            !!borderColour &&
            borderColour.a >= 0.1) ||
          (!!fillColour && fillColour.a >= 0.1),
      });
    }
  }

  const width = document.documentElement.scrollWidth;
  if (width > window.innerWidth + 1) {
    out.overflow = {
      scrollWidth: width,
      innerWidth: window.innerWidth,
      culprits: [],
    };
    // Vinníci: najhlbšie prvky, ktoré presahujú okno a nie sú ani pevné, ani
    // za predkom s orezaním či posúvaním (ten k scrollWidth neprispieva).
    const limit = viewportWidth + 1;
    const scrolls = (value) => /hidden|clip|auto|scroll/.test(value);
    const wide = new Set();
    for (const el of document.body.querySelectorAll("*")) {
      const style = getComputedStyle(el);
      if (style.position === "fixed" || style.display === "none") continue;
      const rect = el.getBoundingClientRect();
      if (rect.width === 0 || rect.right <= limit) continue;
      let hidden = false;
      for (
        let up = el.parentElement;
        up && up !== document.body && up !== document.documentElement;
        up = up.parentElement
      ) {
        const upStyle = getComputedStyle(up);
        if (upStyle.position === "fixed") {
          hidden = true;
          break;
        }
        if (
          (scrolls(upStyle.overflowX) || scrolls(upStyle.overflowY)) &&
          up.getBoundingClientRect().right <= limit
        ) {
          hidden = true;
          break;
        }
      }
      if (!hidden) wide.add(el);
    }
    for (const el of wide) {
      if ([...wide].some((other) => other !== el && el.contains(other)))
        continue;
      const rect = el.getBoundingClientRect();
      out.overflow.culprits.push({
        sig: signature(el),
        right: Math.round(rect.right),
        width: Math.round(rect.width),
        sample: (el.textContent || "").replace(/\s+/g, " ").trim().slice(0, 30),
      });
    }
    out.overflow.culprits.sort((a, b) => b.right - a.right);
    out.overflow.culprits = out.overflow.culprits.slice(0, 6);
  }
  return out;
};

// Pohyb: bežiace animácie a prechody, skrolovanie a stav .reveal.
const motionInPage = () => {
  const signature = (el) => {
    if (!el) return "";
    const classes = [...el.classList].slice(0, 2).join(".");
    return `${el.tagName.toLowerCase()}${classes ? "." + classes : ""}`;
  };
  const seconds = (value) =>
    Math.max(
      0,
      ...value.split(",").map((part) => {
        const n = parseFloat(part);
        return /ms\s*$/.test(part) ? n / 1000 : n;
      }),
    );
  const running = document
    .getAnimations()
    .map((animation) => {
      const timing = animation.effect
        ? animation.effect.getComputedTiming()
        : {};
      return {
        name: animation.animationName || animation.transitionProperty || "",
        target: signature(animation.effect && animation.effect.target),
        state: animation.playState,
        infinite: timing.iterations === Infinity,
        duration: Number(timing.duration) || 0,
      };
    })
    .filter(
      (item) =>
        item.state === "running" && (item.infinite || item.duration > 100),
    );
  const slow = new Map();
  for (const el of document.querySelectorAll("*")) {
    for (const pseudo of [null, "::before", "::after"]) {
      const style = getComputedStyle(el, pseudo);
      if (pseudo && style.content === "none") continue;
      const transition = seconds(style.transitionDuration);
      const animation =
        style.animationName === "none" ? 0 : seconds(style.animationDuration);
      if (transition > 0.05 || animation > 0.05) {
        const key = `${signature(el)}${pseudo || ""}`;
        const entry = slow.get(key) || {
          sig: key,
          transition: 0,
          animation: 0,
          count: 0,
        };
        entry.transition = Math.max(entry.transition, transition);
        entry.animation = Math.max(entry.animation, animation);
        entry.count += 1;
        slow.set(key, entry);
      }
    }
  }
  const pending = [...document.querySelectorAll(".reveal")].filter(
    (el) => Number(getComputedStyle(el).opacity) < 0.99,
  );
  return {
    running,
    slow: [...slow.values()],
    scrollBehavior: getComputedStyle(document.documentElement).scrollBehavior,
    revealTotal: document.querySelectorAll(".reveal").length,
    revealHidden: pending.length,
  };
};

// Bez JavaScriptu: odkazy hlavnej navigácie a ich dosiahnuteľnosť.
const noJsInPage = () => {
  const here = location.origin;
  const viewportWidth = document.documentElement.clientWidth;
  const destination = (a) => {
    try {
      const url = new URL(a.getAttribute("href"), location.href);
      if (url.origin !== here) return null;
      return url.pathname + url.search;
    } catch {
      return null;
    }
  };
  const visible = (el) => {
    const r = el.getBoundingClientRect();
    if (r.width < 2 || r.height < 2) return false;
    if (r.left >= viewportWidth || r.right <= 0 || r.bottom + scrollY <= 0)
      return false;
    if (el.closest("[inert], [aria-hidden='true']")) return false;
    for (
      let up = el;
      up && up !== document.documentElement;
      up = up.parentElement
    ) {
      const style = getComputedStyle(up);
      if (style.display === "none" || style.visibility === "hidden")
        return false;
      if (Number(style.opacity) < 0.1) return false;
    }
    return true;
  };
  const strip = (value) => value.replace(/[?&]lang=[a-z]{2}/, "");
  const navLinks = [...document.querySelectorAll(".nav-menu a[href]")]
    .map((a) => ({ a, to: destination(a) }))
    .filter((item) => item.to && !item.to.startsWith("#"));
  const reachable = new Set();
  for (const a of document.querySelectorAll("a[href]")) {
    const to = destination(a);
    if (to && visible(a)) reachable.add(strip(to));
  }
  const navTargets = [...new Set(navLinks.map((item) => strip(item.to)))];
  return {
    navTotal: navLinks.length,
    navVisible: navLinks.filter((item) => visible(item.a)).length,
    missing: navTargets.filter((to) => !reachable.has(to)),
    textLength: document.body.innerText.length,
  };
};

const describeState = (state) =>
  ({
    none: "bez rozmerov",
    hidden: "skrytý",
    opacity: "nulová priehľadnosť",
    offscreen: "mimo obrazovky",
    clipped: "celý orezaný",
    "clip-part": "čiastočne orezaný",
    transparent: "priehľadná výplň",
    lowcontrast: "slabý kontrast",
    ok: "v poriadku",
  })[state] || state;

const describeCulprits = (overflow) =>
  overflow.culprits && overflow.culprits.length
    ? `; presahujú: ${overflow.culprits
        .map(
          (c) =>
            `${c.sig} (pravý okraj ${c.right} px, šírka ${c.width} px${c.sample ? `, „${c.sample}“` : ""})`,
        )
        .join(", ")}`
    : "";

async function focusPass(page, add) {
  const seen = new Set();
  let stops = 0;
  await page.evaluate(() => {
    window.scrollTo(0, 0);
    if (document.activeElement && document.activeElement.blur)
      document.activeElement.blur();
  });
  for (let i = 0; i < MAX_STOPS; i += 1) {
    await page.keyboard.press("Tab");
    const info = await page.evaluate(() => {
      const el = document.activeElement;
      if (!el || el === document.body) return null;
      const style = getComputedStyle(el);
      const classes = [...el.classList].slice(0, 2).join(".");
      const r = el.getBoundingClientRect();
      return {
        sig: `${el.tagName.toLowerCase()}${classes ? "." + classes : ""}`,
        sample: (
          el.innerText ||
          el.value ||
          el.getAttribute("aria-label") ||
          ""
        )
          .replace(/\s+/g, " ")
          .trim()
          .slice(0, 30),
        style: style.outlineStyle,
        width: parseFloat(style.outlineWidth) || 0,
        color: style.outlineColor,
        focusVisible: el.matches(":focus-visible"),
        key: `${el.tagName}|${Math.round(r.left)}|${Math.round(r.top + scrollY)}`,
      };
    });
    if (!info) break;
    if (seen.has(info.key)) break;
    seen.add(info.key);
    stops += 1;
    const transparent = /rgba\(\s*\d+,\s*\d+,\s*\d+,\s*0\s*\)/.test(info.color);
    if (info.style === "none" || info.width < 2 || transparent)
      add(
        "fail",
        "zaostrenie bez viditeľného obrysu",
        `${info.sig} „${info.sample}“: obrys ${info.style} ${info.width} px ${info.color}`,
      );
  }
  return stops;
}

async function openPage(browser, ua, spec) {
  const { lang, theme, state, pathName, viewport, mode } = spec;
  const log = newLog();
  const page = await newPage(browser, ua, log, viewport);
  if (mode === "nojs") await page.setJavaScriptEnabled(false);
  if (mode === "spacing" || mode === "bigtext") await page.setBypassCSP(true);
  if (mode === "motion")
    await page.emulateMediaFeatures([
      { name: "prefers-reduced-motion", value: "reduce" },
    ]);
  if (mode === "nojs")
    await page.emulateMediaFeatures([
      { name: "prefers-color-scheme", value: theme },
    ]);
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
  if (mode !== "nojs")
    await page.evaluate(() => document.fonts.ready.then(() => true));
  await sleep(mode === "motion" ? 1500 : 900);
  return { page, log };
}

async function auditOne(browser, ua, spec) {
  const { lang, theme, state, name, viewportName, mode } = spec;
  const where = `${lang} ${theme} ${state} ${viewportName} ${name} [${mode}]`;
  console.log(`\n== ${where}`);
  const { page, log } = await openPage(browser, ua, spec);

  const add = (severity, kind, detail) => {
    findings.push({ where, severity, kind, detail });
    console.log(
      `  ${severity === "fail" ? "CHYBA" : "POZOR"} ${kind}: ${detail}`,
    );
  };
  const shot = async () => {
    if (!SHOTS) return;
    const file = path.join(
      OUT,
      `rezim-${lang}-${theme}-${state}-${viewportName}-${name}-${mode}.png`,
    );
    await page.screenshot({ path: file, fullPage: true });
    console.log(`  snímka ${file}`);
  };
  const group = (items, keyOf) => {
    const map = new Map();
    for (const item of items) {
      const key = keyOf(item);
      const entry = map.get(key) || { ...item, count: 0 };
      entry.count += 1;
      map.set(key, entry);
    }
    return [...map.values()];
  };

  if (mode === "forced") {
    const before = await page.evaluate(collectInPage, {
      contrast: false,
      controls: true,
    });
    await page.emulateMediaFeatures([
      { name: "forced-colors", value: "active" },
    ]);
    await sleep(900);
    const after = await page.evaluate(collectInPage, {
      contrast: true,
      controls: true,
      forced: true,
    });
    const lost = [];
    const weak = [];
    after.texts.forEach((item, index) => {
      const base = before.texts[index];
      if (base && base.state === "ok" && item.state !== "ok") {
        if (item.state === "lowcontrast") weak.push(item);
        else lost.push({ ...item, was: base.state });
      } else if (item.state === "lowcontrast") weak.push(item);
    });
    for (const item of group(lost, (x) => `${x.sig}|${x.state}`))
      add(
        "fail",
        "text zmizol pri vynútených farbách",
        `${item.sig}: ${item.count}× „${item.sample}“ (${describeState(item.state)}${
          item.fill ? `, výplň ${item.fill}` : ""
        })`,
      );
    for (const item of group(weak, (x) => `${x.sig}|${x.color}`))
      add(
        "fail",
        "slabý kontrast pri vynútených farbách",
        `${item.sig}: ${item.count}× „${item.sample}“, farba ${item.color}${
          item.fill !== item.color ? `, výplň ${item.fill}` : ""
        } na ${item.background}, kontrast ${item.ratio}:1${
          item.opacity < 1 ? `, priehľadnosť ${item.opacity}` : ""
        }${item.image ? ", pod obrázkom na pozadí" : ""}`,
      );
    // Prvok, ktorého hranicu tvorila výplň alebo ohraničenie, a po vynútení
    // farieb mu zostala nulová šírka okraja: výplň sa nahradí plátnom.
    const boxLost = [];
    after.controls.forEach((item, index) => {
      const base = before.controls[index];
      if (base && base.sig === item.sig && base.boxed && item.border === 0)
        boxLost.push(item);
    });
    for (const item of group(boxLost, (x) => x.sig))
      add(
        "fail",
        "ovládací prvok stratil hranicu pri vynútených farbách",
        `${item.sig}: ${item.count}× „${item.sample}“ (bez okraja, výplň sa nahradí plátnom)`,
      );
    const stops = await focusPass(page, add);
    console.log(
      `  zastavení Tab: ${stops}, plátno ${JSON.stringify(after.canvas)}`,
    );
    if (after.overflow)
      add(
        "warn",
        "vodorovné pretečenie",
        `scrollWidth ${after.overflow.scrollWidth} px pri šírke ${after.overflow.innerWidth} px${describeCulprits(after.overflow)}`,
      );
    await shot();
  } else if (mode === "motion") {
    const result = await page.evaluate(motionInPage);
    for (const item of result.running)
      add(
        "fail",
        "beží animácia pri znížení pohybu",
        `${item.name || "(bez názvu)"} na ${item.target}, ${item.infinite ? "nekonečná" : `${item.duration} ms`}`,
      );
    for (const item of result.slow)
      add(
        "fail",
        "prechod alebo animácia dlhšia než 0,05 s pri znížení pohybu",
        `${item.sig}: ${item.count}×, prechod ${item.transition} s, animácia ${item.animation} s`,
      );
    if (result.scrollBehavior !== "auto")
      add(
        "fail",
        "plynulé skrolovanie pri znížení pohybu",
        `scroll-behavior: ${result.scrollBehavior}`,
      );
    if (result.revealHidden)
      add(
        "fail",
        "obsah .reveal nie je viditeľný hneď",
        `${result.revealHidden} z ${result.revealTotal}`,
      );
    console.log(
      `  .reveal ${result.revealTotal}, beží ${result.running.length}, pomalých ${result.slow.length}`,
    );
    await shot();
  } else if (mode === "spacing" || mode === "bigtext") {
    const before = await page.evaluate(collectInPage, {});
    const css =
      mode === "spacing"
        ? "* { line-height: 1.5 !important; letter-spacing: 0.12em !important; word-spacing: 0.16em !important; } p { margin-bottom: 2em !important; }"
        : "html { font-size: 200% !important; }";
    await page.addStyleTag({ content: css });
    await sleep(900);
    const after = await page.evaluate(collectInPage, {});
    const lost = [];
    after.texts.forEach((item, index) => {
      const base = before.texts[index];
      const bad = (x) =>
        x && (x.state === "clipped" || x.state === "clip-part");
      if (bad(item) && !(bad(base) && base.by === item.by))
        lost.push({ ...item, was: base && base.state });
    });
    for (const item of group(lost, (x) => `${x.sig}|${x.by}|${x.state}`))
      add(
        "fail",
        "text sa orezal",
        `${item.sig}: ${item.count}× „${item.sample}“, ${describeState(item.state)} prvkom ${item.by}${
          item.fraction ? ` (viditeľných ${item.fraction * 100} %)` : ""
        }`,
      );
    const grew =
      after.overflow &&
      (!before.overflow ||
        after.overflow.scrollWidth > before.overflow.scrollWidth + 1);
    if (grew)
      add(
        "warn",
        "vodorovné pretečenie",
        `scrollWidth ${after.overflow.scrollWidth} px pri šírke ${after.overflow.innerWidth} px${
          before.overflow ? `, predtým ${before.overflow.scrollWidth} px` : ""
        }${describeCulprits(after.overflow)}`,
      );
    await shot();
  } else if (mode === "nojs") {
    const base = await page.evaluate(collectInPage, {});
    const reach = await page.evaluate(noJsInPage);
    for (const item of group(
      base.texts.filter((t) => t.state === "opacity" || t.state === "hidden"),
      (x) => `${x.sig}|${x.state}`,
    ))
      if (item.state === "opacity")
        add(
          "fail",
          "text ostal skrytý bez JavaScriptu",
          `${item.sig}: ${item.count}× „${item.sample}“`,
        );
    for (const to of reach.missing)
      add(
        "fail",
        "cieľ navigácie je bez JavaScriptu nedosiahnuteľný",
        `${to}: žiaden viditeľný odkaz`,
      );
    if (reach.navTotal && !reach.navVisible)
      add(
        "warn",
        "hlavné menu je bez JavaScriptu mimo obrazovky",
        `${reach.navTotal} odkazov, ciele sú dosiahnuteľné ${reach.missing.length ? "len čiastočne" : "z iných odkazov"}`,
      );
    console.log(
      `  navigácia ${reach.navVisible}/${reach.navTotal} viditeľných, text ${reach.textLength} znakov`,
    );
    await shot();
  }

  const summary = summarizeLog(log);
  const noise = [...summary.pageerror, ...summary.csp];
  if (noise.length && mode !== "nojs")
    add("fail", "chyba stránky", JSON.stringify(noise).slice(0, 200));
  await page.close();
}

const { browser, ua } = await launch();
try {
  for (const lang of langs)
    for (const theme of themes)
      for (const state of states)
        for (const viewportName of viewportNames)
          for (const name of wanted)
            for (const mode of modes) {
              if (!allPages[name]) throw new Error(`Neznáma stránka: ${name}`);
              if (!allViewports[viewportName])
                throw new Error(`Neznáma veľkosť okna: ${viewportName}`);
              await auditOne(browser, ua, {
                lang,
                theme,
                state,
                name,
                pathName: allPages[name],
                viewportName,
                viewport: allViewports[viewportName],
                mode,
              });
              await sleep(2000);
            }
} finally {
  await browser.close();
}

const failures = findings.filter((entry) => entry.severity === "fail");
const warnings = findings.filter((entry) => entry.severity === "warn");
console.log("\n##### SÚHRN");
console.log(`Chyby: ${failures.length}, upozornenia: ${warnings.length}`);
fs.writeFileSync(
  path.join(OUT, "modes-audit.json"),
  JSON.stringify({ findings }, null, 2),
);
if (failures.length) {
  console.log("REŽIMY NÁLEZY");
  process.exit(1);
}
console.log("REŽIMY OK");
