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

// Prístupnosť cez axe-core (WCAG 2.0/2.1/2.2 A a AA plus best-practice).
// STATES: banner = prvá návšteva so zobrazeným cookie bannerom,
//         clean  = súhlas už uložený (banner skrytý).
const axeSource = readAxeSource();
const langs = (process.env.LANGS || "sk,en").split(",");
const themes = (process.env.THEMES || "light,dark").split(",");
const states = (process.env.STATES || "banner,clean").split(",");
const viewportName = process.env.VIEWPORT || "desktop";
const viewport =
  viewportName === "mobile"
    ? {
        width: 390,
        height: 844,
        isMobile: true,
        hasTouch: true,
        deviceScaleFactor: 2,
      }
    : { width: 1280, height: 800 };
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
  libraryWork: "/library.php?slug=sk-nefro-belegt-wahrscheinlich-offen",
  notFound: "/neexistujuca-stranka/",
};
const bannerPages = ["home", "article", "privacy", "contact"];
const wanted = (process.env.PAGES || Object.keys(allPages).join(",")).split(
  ",",
);
const tags = [
  "wcag2a",
  "wcag2aa",
  "wcag21a",
  "wcag21aa",
  "wcag22aa",
  "best-practice",
];

const { browser, ua } = await launch();
const problems = [];
const grouped = new Map();

function addGroup(rule, impact, state, lang, theme, pageName, node) {
  const key = `${rule}|${node.target.join(" ")}`;
  const entry = grouped.get(key) || {
    rule,
    impact,
    target: node.target.join(" "),
    html: node.html.slice(0, 140),
    where: [],
  };
  entry.where.push(`${state}/${lang}/${theme}/${pageName}`);
  grouped.set(key, entry);
}

try {
  for (const state of states) {
    for (const theme of themes) {
      for (const lang of langs) {
        const log = newLog();
        const page = await newPage(browser, ua, log, viewport);
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
          (name) =>
            allPages[name] && (state === "clean" || bannerPages.includes(name)),
        );
        for (const name of names) {
          // Log patrí jednej stránke; inak by sa nálezy predchádzajúcej
          // stránky pripísali aj ďalším (Beh #116).
          for (const entries of Object.values(log)) {
            if (Array.isArray(entries)) entries.length = 0;
          }
          const url = `${BASE}${allPages[name]}${allPages[name].includes("?") ? "&" : "?"}lang=${lang}`;
          const response = await gotoWithRetry(page, url);
          const status = response ? response.status() : 0;
          await page.evaluate(() => document.fonts.ready.then(() => true));
          await sleep(600);
          const banner = await page.evaluate(() => {
            const element = document.querySelector(
              "#cookie-consent-container .cookie-banner",
            );
            return Boolean(
              element &&
              element.getClientRects().length > 0 &&
              getComputedStyle(element).visibility !== "hidden",
            );
          });
          let results;
          try {
            await page.evaluate(axeSource);
            results = await page.evaluate(async (runTags) => {
              const output = await window.axe.run(document, {
                runOnly: { type: "tag", values: runTags },
                resultTypes: ["violations", "incomplete"],
              });
              const pick = (items) =>
                items.map((item) => ({
                  id: item.id,
                  impact: item.impact,
                  help: item.help,
                  tags: item.tags.filter((tag) => /^wcag|^best/.test(tag)),
                  nodes: item.nodes.map((node) => ({
                    target: node.target,
                    html: node.html,
                    summary: node.failureSummary,
                    data: node.any
                      .concat(node.all, node.none)
                      .map((check) => check.data)
                      .filter(Boolean)
                      .slice(0, 2),
                  })),
                }));
              return {
                violations: pick(output.violations),
                incomplete: pick(output.incomplete),
                version: window.axe.version,
              };
            }, tags);
          } catch (error) {
            problems.push(
              `${state}/${lang}/${theme}/${name}: axe zlyhal: ${error.message}`,
            );
            continue;
          }
          fs.writeFileSync(
            path.join(
              OUT,
              `axe-${viewportName}-${state}-${lang}-${theme}-${name}.json`,
            ),
            JSON.stringify(results, null, 1),
          );
          const total = results.violations.reduce(
            (sum, rule) => sum + rule.nodes.length,
            0,
          );
          console.log(
            `${total === 0 ? "OK  " : "FAIL"} ${viewportName} ${state} ${lang} ${theme} ${name} stav ${status} banner ${banner ? "áno" : "nie"} porušení ${results.violations.length} (uzlov ${total}), na kontrolu ${results.incomplete.length}`,
          );
          if (state === "banner" && !banner)
            problems.push(
              `${state}/${lang}/${theme}/${name}: banner sa nezobrazil`,
            );
          if (state === "clean" && banner)
            problems.push(
              `${state}/${lang}/${theme}/${name}: banner je zobrazený napriek uloženému súhlasu`,
            );
          for (const rule of results.violations) {
            for (const node of rule.nodes)
              addGroup(rule.id, rule.impact, state, lang, theme, name, node);
          }
          const issues = summarizeLog(log);
          // Stránka 404 vracia 404 zámerne; prehliadač to zapíše ako chybu.
          if (name === "notFound" && status === 404) {
            issues.consoleIssues = issues.consoleIssues.filter(
              (entry) =>
                !(
                  String(entry.text || "").includes("status of 404") &&
                  String(entry.url || "").startsWith(url)
                ),
            );
          }
          if (
            issues.consoleIssues.length ||
            issues.pageerror.length ||
            issues.csp.length
          ) {
            problems.push(
              `${state}/${lang}/${theme}/${name}: konzola/CSP ${JSON.stringify([issues.consoleIssues, issues.pageerror, issues.csp]).slice(0, 300)}`,
            );
          }
          await sleep(2500);
        }
        await page.close();
      }
    }
  }
} finally {
  await browser.close();
}

console.log("\n=== Zoskupené porušenia (pravidlo, cieľ, kde)");
const rows = [...grouped.values()].sort(
  (a, b) => b.where.length - a.where.length,
);
for (const row of rows) {
  const sample = row.where.slice(0, 3).join(", ");
  console.log(
    `- [${row.impact}] ${row.rule} ${row.target}  x${row.where.length}  (${sample}${row.where.length > 3 ? ", ..." : ""})\n    ${row.html.replace(/\s+/g, " ")}`,
  );
}
console.log(`\nSkupín: ${rows.length}`);
if (problems.length) {
  console.log("\n=== Ďalšie problémy");
  for (const problem of problems) console.log(`- ${problem}`);
}
console.log(
  rows.length === 0 && problems.length === 0 ? "AXE OK" : "AXE NÁLEZY",
);
process.exit(rows.length === 0 && problems.length === 0 ? 0 : 1);
