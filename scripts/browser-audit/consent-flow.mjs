import {
  BASE,
  LOCAL_ROOT,
  launch,
  newLog,
  newPage,
  resetState,
  gotoWithRetry,
  sleep,
} from "./lib.mjs";

// Tok súhlasu so súkromím (Microsoft Clarity, Google Analytics): prvá návšteva
// bez tretích strán, súhlas, reload, stránky bez Clarity, odvolanie súhlasu a
// priame odmietnutie. Tretie strany sa nikdy nedotknú siete (lib.mjs ich
// nahradí prázdnou odpoveďou), počíta sa len, či by sa o ne stránka pokúsila.
// Identifikátor projektu Clarity v regulárnom výraze je verejný (je aj v HTML).
const LANG_LIST = (process.env.LANGS || "sk,en").split(",");
const STORAGE_KEY = "privacy_consent_clarity_v1";
const CLARITY = /clarity\.ms\/tag\/axxzsx2xlq/;
const GTAG = /googletagmanager\.com\/gtag\/js\?id=G-/;

let failures = 0;
const check = (name, ok, detail = "") => {
  if (!ok) failures += 1;
  console.log(
    `  ${ok ? "OK  " : "CHYBA"} ${name}${detail ? "  " + detail : ""}`,
  );
};
const clearLog = (log) => {
  for (const key of Object.keys(log)) log[key].length = 0;
};
const hits = (log, pattern) =>
  log.thirdparty.filter((entry) => pattern.test(entry.url)).length;
const issues = (log) =>
  log.console.filter(
    (entry) => entry.type === "error" || entry.type === "warning",
  ).length +
  log.pageerror.length +
  log.csp.length;

const state = (page) =>
  page.evaluate(
    (key) => ({
      stored: window.localStorage.getItem(key),
      banner: Boolean(
        document.querySelector("#cookie-consent-container .cookie-banner"),
      ),
      mask: document.body.getAttribute("data-clarity-mask"),
      clarityFn: typeof window.clarity,
      clarityScript: Boolean(
        document.querySelector('script[src*="clarity.ms/tag/"]'),
      ),
      gaScript: Boolean(document.getElementById("google-analytics-script")),
      settingsButton: Boolean(document.querySelector(".clarity-settings")),
      clarityCss: Boolean(
        document.querySelector('link[href*="clarity-consent.css"]'),
      ),
      layer: (window.dataLayer || []).map((item) =>
        Array.from(item).map((part) => (part instanceof Date ? "Date" : part)),
      ),
    }),
    STORAGE_KEY,
  );

const load = async (page, log, url, pause = 900) => {
  clearLog(log);
  await gotoWithRetry(page, `${BASE}${url}`);
  await sleep(pause);
  return state(page);
};

const { browser, ua } = await launch();
console.log(`LOCAL_ROOT=${LOCAL_ROOT || "(produkcia)"}`);
try {
  for (const lang of LANG_LIST) {
    console.log(`=== ${lang}`);
    const log = newLog();
    const page = await newPage(browser, ua, log);
    let navigations = 0;
    page.on("framenavigated", (frame) => {
      if (frame === page.mainFrame()) navigations += 1;
    });
    await resetState(page);

    let s = await load(page, log, `/?lang=${lang}`);
    check("1 prvá návšteva: banner je zobrazený", s.banner);
    check(
      "1 bez súhlasu sa nenačíta Clarity ani GA",
      hits(log, CLARITY) === 0 &&
        hits(log, GTAG) === 0 &&
        log.thirdparty.length === 0,
      `požiadavky tretích strán: ${log.thirdparty.length}`,
    );
    check(
      "1 bez súhlasu: žiadny uložený súhlas, žiadna maska, žiadny skript",
      s.stored === null && s.mask === null && !s.clarityScript && !s.gaScript,
    );
    check(
      "1 externý režim: žiadne vlastné tlačidlo ani štýl Clarity",
      !s.settingsButton && !s.clarityCss,
    );
    check(
      "1 konzola, CSP bez problémov",
      issues(log) === 0,
      `problémy: ${issues(log)}`,
    );
    const defaultEntry = s.layer.find(
      (item) => item[0] === "consent" && item[1] === "default",
    );
    check(
      "1 predvolený súhlas je zamietnutý (analytika, reklama)",
      Boolean(defaultEntry) &&
        defaultEntry[2].analytics_storage === "denied" &&
        defaultEntry[2].ad_storage === "denied",
    );

    clearLog(log);
    await page.click("#cookie-consent-container .btn-cookie-accept");
    await sleep(1200);
    s = await state(page);
    check(
      '2 po súhlase: uložené "accepted", banner zmizol',
      s.stored === "accepted" && !s.banner,
    );
    check(
      "2 po súhlase: Clarity aj GA sa načítali presne raz",
      hits(log, CLARITY) === 1 && hits(log, GTAG) === 1,
      `Clarity ${hits(log, CLARITY)}, GA ${hits(log, GTAG)}`,
    );
    check(
      "2 po súhlase: text je maskovaný (data-clarity-mask)",
      s.mask === "true",
    );
    const update = s.layer.find(
      (item) => item[0] === "consent" && item[1] === "update",
    );
    check(
      "2 po súhlase: len analytika povolená, reklama zamietnutá",
      Boolean(update) &&
        update[2].analytics_storage === "granted" &&
        update[2].ad_storage === "denied" &&
        update[2].ad_user_data === "denied" &&
        update[2].ad_personalization === "denied",
    );
    const config = s.layer.find((item) => item[0] === "config");
    check(
      "2 GA config bez Google signálov a personalizácie",
      Boolean(config) &&
        config[2].allow_google_signals === false &&
        config[2].allow_ad_personalization_signals === false,
    );
    check(
      "2 konzola, CSP bez problémov",
      issues(log) === 0,
      `problémy: ${issues(log)}`,
    );
    await sleep(1800);

    s = await load(page, log, `/?lang=${lang}`);
    check(
      "3 po reloade: banner sa už neukáže, súhlas pretrváva",
      !s.banner && s.stored === "accepted",
    );
    check(
      "3 po reloade: Clarity aj GA sa načítali (uložený súhlas)",
      hits(log, CLARITY) === 1 && hits(log, GTAG) === 1,
      `Clarity ${hits(log, CLARITY)}, GA ${hits(log, GTAG)}`,
    );
    check("3 po reloade: maska je nastavená", s.mask === "true");
    check("3 po reloade: konzola, CSP bez problémov", issues(log) === 0);
    await sleep(1800);

    const paths = [
      ["/articles.php?lang=" + lang, true],
      ["/article.php?slug=odporucanie-nie-je-povolenie&lang=" + lang, true],
      ["/library.php?lang=" + lang, true],
      ["/privacy.php?lang=" + lang, true],
      ["/terms.php?lang=" + lang, true],
      ["/contact.php?lang=" + lang, false],
      ["/newsletter.php?lang=" + lang, false],
      ["/login.php?lang=" + lang, false],
      ["/?lang=" + lang + "&utm_source=test", false],
    ];
    for (const [url, allowed] of paths) {
      s = await load(page, log, url);
      const clarity = hits(log, CLARITY);
      check(
        `4 ${url}: Clarity ${allowed ? "sa načíta" : "sa nenačíta"}`,
        clarity === (allowed ? 1 : 0),
        `Clarity ${clarity}, GA ${hits(log, GTAG)}, maska ${s.mask}`,
      );
      if (!allowed)
        check(
          `4 ${url}: žiadna maska ani Clarity skript`,
          s.mask === null && !s.clarityScript,
        );
      check(
        `4 ${url}: banner neukázaný, konzola čistá`,
        !s.banner && issues(log) === 0,
      );
      await sleep(2000);
    }

    s = await load(page, log, `/?lang=${lang}`);
    await page.click(".cookie-settings-trigger");
    await sleep(500);
    const focusInfo = await page.evaluate(() => {
      const banner = document.querySelector(
        "#cookie-consent-container .cookie-banner",
      );
      return {
        banner: Boolean(banner),
        focusInBanner: Boolean(
          banner && banner.contains(document.activeElement),
        ),
        focusText: document.activeElement && document.activeElement.textContent,
      };
    });
    check(
      "5 nastavenia súkromia otvoria banner a presunú naň fokus",
      focusInfo.banner && focusInfo.focusInBanner,
      `fokus: ${focusInfo.focusText}`,
    );
    navigations = 0;
    clearLog(log);
    await Promise.all([
      page.waitForNavigation({ waitUntil: "networkidle2", timeout: 30000 }),
      page.click("#cookie-consent-container .btn-cookie-decline"),
    ]);
    await sleep(3500);
    s = await state(page);
    check(
      '5 odvolanie súhlasu: uložené "rejected", banner zmizol',
      s.stored === "rejected" && !s.banner,
    );
    check(
      "5 odvolanie súhlasu: po reloade sa nenačíta ani Clarity ani GA",
      hits(log, CLARITY) === 0 && hits(log, GTAG) === 0,
      `Clarity ${hits(log, CLARITY)}, GA ${hits(log, GTAG)}`,
    );
    check(
      "5 odvolanie súhlasu: žiadna maska, žiadny skript Clarity",
      s.mask === null && !s.clarityScript && !s.gaScript,
    );
    check(
      "5 jediný reload (žiadna slučka)",
      navigations === 1,
      `navigácie: ${navigations}`,
    );
    check(
      "5 konzola, CSP bez problémov",
      issues(log) === 0,
      `problémy: ${issues(log)}`,
    );
    await sleep(1800);

    s = await load(page, log, `/?lang=${lang}`);
    check(
      "6 po odvolaní a reloade: bez bannera, bez tretích strán",
      !s.banner && s.stored === "rejected" && log.thirdparty.length === 0,
      `požiadavky: ${log.thirdparty.length}`,
    );
    await sleep(1800);

    await resetState(page);
    s = await load(page, log, `/?lang=${lang}`);
    check(
      "7 čistý stav: banner sa opäť zobrazí",
      s.banner && s.stored === null,
    );
    navigations = 0;
    clearLog(log);
    await page.click("#cookie-consent-container .btn-cookie-decline");
    await sleep(2500);
    s = await state(page);
    check(
      '7 priame odmietnutie: uložené "rejected", bez reloadu, bez tretích strán',
      s.stored === "rejected" &&
        !s.banner &&
        navigations === 0 &&
        log.thirdparty.length === 0,
      `navigácie ${navigations}, požiadavky ${log.thirdparty.length}`,
    );
    const denied = s.layer.filter(
      (item) => item[0] === "consent" && item[1] === "update",
    );
    check(
      "7 priame odmietnutie: aktualizácia súhlasu zamieta analytiku",
      denied.length === 1 && denied[0][2].analytics_storage === "denied",
    );
    check("7 konzola, CSP bez problémov", issues(log) === 0);
    await page.close();
    await sleep(2500);
  }
} finally {
  await browser.close();
}
console.log(
  failures === 0 ? "TOK SÚHLASU OK" : `TOK SÚHLASU: ${failures} CHÝB`,
);
process.exit(failures === 0 ? 0 : 1);
