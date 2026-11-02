import fs from "node:fs";
import path from "node:path";
import {
  BASE,
  LANGS,
  OUT,
  LOCAL_ROOT,
  launch,
  newLog,
  newPage,
  resetState,
  gotoWithRetry,
  sleep,
} from "./lib.mjs";

// Hlavná navigácia na desktope: jeden riadok, žiadne zalomené položky, odstup
// značky od prepínača jazyka, výška lišty a prepnutie do kompaktného režimu
// presne na hranici BREAKPOINT (1320 px, rovnaká hodnota v css/styles.css a
// js/main.js). ADMIN=1 doplní položky Administrácia a Odhlásiť sa.
const BREAKPOINT = Number(process.env.BREAKPOINT || 1320);
const ADMIN = process.env.ADMIN === "1";
const WIDTHS = (
  process.env.WIDTHS ||
  "1000,1100,1200,1280,1300,1319,1320,1321,1322,1330,1340,1350,1366,1400,1440,1441,1500,1536,1600,1680,1920,2560"
)
  .split(",")
  .map(Number);
const LANG_LIST = process.env.LANGS ? process.env.LANGS.split(",") : LANGS;
const MIN_SEPARATION = 12;

const ADMIN_LABELS = {
  sk: ["Administrácia", "Odhlásiť sa"],
  en: ["Administration", "Log out"],
  cs: ["Administrace", "Odhlásit se"],
  de: ["Administration", "Abmelden"],
  fr: ["Administration", "Se déconnecter"],
  es: ["Administración", "Cerrar sesión"],
  pl: ["Administracja", "Wyloguj się"],
  hu: ["Adminisztráció", "Kijelentkezés"],
  it: ["Amministrazione", "Esci"],
  uk: ["Адміністрування", "Вийти"],
};

const measure = () => {
  const container = document.querySelector(".nav-container");
  const navbar = document.querySelector(".navbar");
  const menu = document.getElementById("navMenu");
  const toggle = document.getElementById("navToggle");
  const group = container.querySelector(".nav-brand-group");
  const lang = container.querySelector(".lang-switcher");
  const theme = document.getElementById("themeToggle");
  const links = Array.from(menu.querySelectorAll(".nav-link"));
  const compact = getComputedStyle(toggle).display !== "none";
  const containerRect = container.getBoundingClientRect();
  const style = getComputedStyle(container);
  const contentLeft = containerRect.left + parseFloat(style.paddingLeft);
  const contentRight = containerRect.right - parseFloat(style.paddingRight);
  const result = {
    compact,
    layoutWidth: document.documentElement.clientWidth,
    height: Math.round(navbar.getBoundingClientRect().height * 10) / 10,
    cssHeight: getComputedStyle(document.documentElement)
      .getPropertyValue("--navbar-height")
      .trim(),
    bodyMargin: getComputedStyle(document.body).marginTop,
    brandLeft: Math.round(group.getBoundingClientRect().left),
    contentLeft: Math.round(contentLeft),
    contentRight: Math.round(contentRight),
    hscroll:
      document.documentElement.scrollWidth >
      document.documentElement.clientWidth,
  };
  if (compact) return result;
  const tops = new Set(
    Array.from(menu.children).map((item) =>
      Math.round(item.getBoundingClientRect().top),
    ),
  );
  const wrapped = links
    .filter(
      (link) =>
        link.getClientRects().length > 1 ||
        link.getBoundingClientRect().height > 40,
    )
    .map((link) => link.textContent.trim());
  const lastLink = links[links.length - 1].getBoundingClientRect();
  const menuRect = menu.getBoundingClientRect();
  result.rows = tops.size;
  result.wrapped = wrapped;
  result.overflow = Math.round(
    Math.max(menuRect.right, lastLink.right) - contentRight,
  );
  result.separation = Math.round(
    lang.getBoundingClientRect().left - group.getBoundingClientRect().right,
  );
  result.menuGap = Math.round(
    menuRect.left - theme.getBoundingClientRect().right,
  );
  result.linkSize = getComputedStyle(links[0]).fontSize;
  result.lastLinkRight = Math.round(lastLink.right);
  return result;
};

const { browser, ua } = await launch();
const report = {};
try {
  for (const lang of LANG_LIST) {
    const log = newLog();
    const page = await newPage(browser, ua, log);
    await resetState(page);
    await gotoWithRetry(page, `${BASE}/?lang=${lang}`);
    await sleep(700);
    await page.evaluate(() => document.fonts.ready);
    report.__fonts = report.__fonts || {};
    report.__fonts[lang] = await page.evaluate(
      () =>
        Array.from(document.fonts).filter((font) => font.status === "loaded")
          .length,
    );
    if (ADMIN) {
      const [adminLabel, logoutLabel] = ADMIN_LABELS[lang];
      await page.evaluate(
        (admin, logout) => {
          const menu = document.getElementById("navMenu");
          const last = menu.lastElementChild;
          last.innerHTML = `<a href="#" class="nav-link">${admin}</a>`;
          const item = document.createElement("li");
          item.innerHTML = `<form action="logout.php" method="post" class="nav-logout-form"><button type="submit" class="nav-link nav-logout-btn">${logout}</button></form>`;
          menu.appendChild(item);
        },
        adminLabel,
        logoutLabel,
      );
    }
    report[lang] = {};
    for (const width of WIDTHS) {
      await page.setViewport({ width, height: 800 });
      await sleep(180);
      report[lang][width] = await page.evaluate(measure);
    }
    report[lang].__console = log.console.filter(
      (entry) => entry.type === "error" || entry.type === "warning",
    ).length;
    report[lang].__csp = log.csp.length;
    await page.close();
    await sleep(2200);
  }
} finally {
  await browser.close();
}
const outFile = path.join(
  OUT,
  `nav-verify${ADMIN ? "-admin" : ""}${process.env.SCROLLBARS === "1" ? "-sb" : ""}.json`,
);
fs.writeFileSync(outFile, JSON.stringify(report, null, 2));

console.log(
  `LOCAL_ROOT=${LOCAL_ROOT || "(produkcia)"} ADMIN=${ADMIN} SCROLLBARS=${process.env.SCROLLBARS === "1"} BREAKPOINT=${BREAKPOINT}`,
);
let problems = 0;
for (const lang of LANG_LIST) {
  const failing = [];
  let minDesktop = Infinity;
  let minSeparation = Infinity;
  for (const width of WIDTHS) {
    const entry = report[lang][width];
    const expectCompact = width <= BREAKPOINT;
    if (entry.compact !== expectCompact) {
      failing.push(
        `${width}: režim ${entry.compact ? "kompaktný" : "desktop"}, očakávaný ${expectCompact ? "kompaktný" : "desktop"}`,
      );
      continue;
    }
    if (entry.hscroll) failing.push(`${width}: vodorovné posúvanie`);
    if (entry.compact) {
      if (entry.height > 80)
        failing.push(
          `${width}: výška lišty ${entry.height} px v kompaktnom režime`,
        );
      continue;
    }
    minDesktop = Math.min(minDesktop, width);
    minSeparation = Math.min(minSeparation, entry.separation);
    if (entry.wrapped.length)
      failing.push(`${width}: zalomené ${entry.wrapped.join(", ")}`);
    if (entry.rows !== 1) failing.push(`${width}: ${entry.rows} riadky`);
    if (entry.overflow > 1)
      failing.push(`${width}: preteká o ${entry.overflow} px`);
    if (entry.separation < MIN_SEPARATION)
      failing.push(`${width}: odstup značky od jazyka ${entry.separation} px`);
    if (Math.abs(entry.height - 77) > 1.5)
      failing.push(`${width}: výška lišty ${entry.height} px`);
  }
  problems += failing.length;
  console.log(
    `${lang}  desktop od ${minDesktop}  min. odstup značka/jazyk ${minSeparation} px  fonty ${report.__fonts[lang]}  konzola ${report[lang].__console}  CSP ${report[lang].__csp}  ${failing.length ? "PROBLÉMY: " + failing.join(" | ") : "OK"}`,
  );
}
console.log(problems === 0 ? "VŠETKO OK" : `${problems} problémov`);
process.exit(problems === 0 ? 0 : 1);
