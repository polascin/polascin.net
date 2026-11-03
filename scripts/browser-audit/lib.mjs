import puppeteer from "puppeteer-core";
import fs from "node:fs";
import os from "node:os";
import path from "node:path";
import { fileURLToPath } from "node:url";

const here = path.dirname(fileURLToPath(import.meta.url));

const chromeCandidates = [
  process.env.CHROME_PATH,
  "C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe",
  "C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe",
  process.env.LOCALAPPDATA &&
    path.join(
      process.env.LOCALAPPDATA,
      "Google",
      "Chrome",
      "Application",
      "chrome.exe",
    ),
  "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome",
  "/usr/bin/google-chrome",
  "/usr/bin/chromium",
].filter(Boolean);

export const CHROME = chromeCandidates.find((candidate) =>
  fs.existsSync(candidate),
);
if (!CHROME)
  throw new Error(
    "Chrome sa nenašiel. Nastav CHROME_PATH na chrome.exe alebo na Google Chrome.",
  );

export const BASE = (process.env.BASE_URL || "https://polascin.net").replace(
  /\/$/,
  "",
);
export const LANGS = [
  "sk",
  "en",
  "cs",
  "de",
  "fr",
  "es",
  "pl",
  "hu",
  "it",
  "uk",
];
// Výstupy (JSON, snímky) idú mimo repozitára.
export const OUT =
  process.env.AUDIT_OUT || path.join(os.tmpdir(), "polascin-browser-audit");
fs.mkdirSync(OUT, { recursive: true });

export const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

export const readAxeSource = () =>
  fs.readFileSync(
    path.join(here, "node_modules", "axe-core", "axe.min.js"),
    "utf8",
  );

// LOCAL_ROOT: koreň pracovného stromu; css/styles.css a js/main.js sa potom
// pri načítaní z produkcie nahradia lokálnymi súbormi (test pred nasadením).
// SCROLLBARS=1: klasické posuvníky, aby sa šírka rozloženia líšila od šírky
// media query tak ako u návštevníkov na Windows.
export const LOCAL_ROOT = process.env.LOCAL_ROOT || "";
const LOCAL_FILES = {
  "/css/styles.css": "text/css; charset=utf-8",
  "/js/main.js": "application/javascript; charset=utf-8",
};

export async function launch() {
  const args = [
    "--no-first-run",
    "--no-default-browser-check",
    "--disable-extensions",
    "--lang=sk-SK",
  ];
  if (process.env.SCROLLBARS !== "1") args.push("--hide-scrollbars");
  // Puppeteer v headless režime pridáva --hide-scrollbars sám.
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: true,
    args,
    ignoreDefaultArgs:
      process.env.SCROLLBARS === "1" ? ["--hide-scrollbars"] : [],
  });
  const ua = (await browser.userAgent()).replace("HeadlessChrome", "Chrome");
  return { browser, ua };
}

export function newLog() {
  return {
    console: [],
    pageerror: [],
    failed: [],
    bad: [],
    requests: [],
    csp: [],
    thirdparty: [],
  };
}

// Tretie strany (Clarity, GA) sa nikdy nedotknú siete: skript dostane prázdnu
// náhradu a zber 204, aby audit nezapisoval do reálnej analytiky majiteľa.
async function stubThirdParty(page, log) {
  const client = await page.createCDPSession();
  const patterns = [
    { urlPattern: "*clarity.ms*" },
    { urlPattern: "*googletagmanager.com*" },
    { urlPattern: "*google-analytics.com*" },
    { urlPattern: "*analytics.google.com*" },
    { urlPattern: "*doubleclick.net*" },
  ];
  if (LOCAL_ROOT) {
    for (const route of Object.keys(LOCAL_FILES))
      patterns.push({ urlPattern: `${BASE}${route}*` });
  }
  await client.send("Fetch.enable", { patterns });
  client.on("Fetch.requestPaused", async (event) => {
    const url = event.request.url;
    const localRoute = LOCAL_ROOT
      ? Object.keys(LOCAL_FILES).find((route) =>
          url.startsWith(`${BASE}${route}`),
        )
      : undefined;
    if (localRoute) {
      try {
        await client.send("Fetch.fulfillRequest", {
          requestId: event.requestId,
          responseCode: 200,
          responseHeaders: [
            { name: "Content-Type", value: LOCAL_FILES[localRoute] },
            { name: "Cache-Control", value: "no-store" },
          ],
          body: fs
            .readFileSync(path.join(LOCAL_ROOT, localRoute))
            .toString("base64"),
        });
      } catch {
        // stránka sa už zavrela
      }
      return;
    }
    log.thirdparty.push({
      method: event.request.method,
      url,
      type: event.resourceType,
    });
    try {
      if (event.resourceType === "Script") {
        await client.send("Fetch.fulfillRequest", {
          requestId: event.requestId,
          responseCode: 200,
          responseHeaders: [
            { name: "Content-Type", value: "application/javascript" },
            { name: "Access-Control-Allow-Origin", value: "*" },
          ],
          body: Buffer.from("/* audit stub */").toString("base64"),
        });
      } else {
        await client.send("Fetch.fulfillRequest", {
          requestId: event.requestId,
          responseCode: 204,
          responseHeaders: [
            { name: "Access-Control-Allow-Origin", value: "*" },
          ],
        });
      }
    } catch {
      // stránka sa už zavrela
    }
  });
  return client;
}

export async function newPage(
  browser,
  ua,
  log,
  viewport = { width: 1280, height: 800 },
) {
  const page = await browser.newPage();
  await page.setUserAgent({ userAgent: ua });
  await page.setViewport(viewport);
  await stubThirdParty(page, log);
  page.on("console", (message) => {
    const location = message.location();
    log.console.push({
      type: message.type(),
      text: message.text(),
      url: location && location.url,
    });
  });
  page.on("pageerror", (error) =>
    log.pageerror.push(String((error && error.message) || error)),
  );
  page.on("requestfailed", (request) => {
    const failure = request.failure();
    log.failed.push({
      url: request.url(),
      error: failure && failure.errorText,
      type: request.resourceType(),
    });
  });
  page.on("response", (response) => {
    if (response.status() >= 400)
      log.bad.push({ url: response.url(), status: response.status() });
  });
  page.on("request", (request) =>
    log.requests.push({ url: request.url(), type: request.resourceType() }),
  );
  await page.exposeFunction("__auditCsp", (violation) =>
    log.csp.push(violation),
  );
  await page.evaluateOnNewDocument(() => {
    window.__cls = 0;
    window.__lcp = 0;
    document.addEventListener("securitypolicyviolation", (event) => {
      window.__auditCsp({
        directive: event.violatedDirective,
        blocked: event.blockedURI,
        source: event.sourceFile,
        line: event.lineNumber,
        sample: (event.sample || "").slice(0, 80),
      });
    });
    try {
      new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
          if (!entry.hadRecentInput) window.__cls += entry.value;
        }
      }).observe({ type: "layout-shift", buffered: true });
      new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) window.__lcp = entry.startTime;
      }).observe({ type: "largest-contentful-paint", buffered: true });
    } catch {
      // starší prehliadač bez týchto metrík
    }
  });
  return page;
}

export async function resetState(page) {
  const client = await page.createCDPSession();
  await client.send("Network.clearBrowserCookies");
  await client.send("Storage.clearDataForOrigin", {
    origin: new URL(BASE).origin,
    storageTypes: "local_storage,cookies,session_storage",
  });
  await client.detach();
}

export async function gotoWithRetry(page, url, tries = 5) {
  for (let attempt = 1; attempt <= tries; attempt += 1) {
    const response = await page.goto(url, {
      waitUntil: "networkidle2",
      timeout: 60000,
    });
    const status = response ? response.status() : 0;
    if (status !== 429 && status !== 503) return response;
    console.log(`  ${status} pre ${url}, čakám 45 s (pokus ${attempt})`);
    await sleep(45000);
  }
  throw new Error(`Vzdávam sa: ${url}`);
}

// Hláška prehliadača o 429 alebo 503 je limit hostingu na IP, nie chyba
// stránky (Beh #69, #72). Počíta sa zvlášť v `rateLimited`.
const RATE_LIMITED = /status of (429|503)\b/;

export function summarizeLog(log) {
  const interesting = (entry) =>
    (entry.type === "error" ||
      entry.type === "warning" ||
      entry.type === "assert") &&
    !RATE_LIMITED.test(entry.text || "");
  return {
    consoleIssues: log.console.filter(interesting),
    rateLimited:
      log.console.filter((entry) => RATE_LIMITED.test(entry.text || ""))
        .length +
      log.bad.filter((entry) => [429, 503].includes(entry.status)).length,
    pageerror: log.pageerror,
    failed: log.failed,
    bad: log.bad,
    csp: log.csp,
    thirdparty: log.thirdparty.map((entry) => `${entry.method} ${entry.url}`),
  };
}
