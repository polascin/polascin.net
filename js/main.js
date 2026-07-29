(() => {
  "use strict";

  const themeStorageKey = "theme";
  const consentStorageKey = "privacy_consent";
  const gaMeasurementId = "G-9EMD3BVXCJ";
  const mobileNavigationQuery = window.matchMedia("(max-width: 1024px)");
  const reducedMotionQuery = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  );
  const colorSchemeQuery = window.matchMedia("(prefers-color-scheme: dark)");

  function readStorage(key) {
    try {
      return window.localStorage.getItem(key);
    } catch {
      return null;
    }
  }

  function writeStorage(key, value) {
    try {
      window.localStorage.setItem(key, value);
      return true;
    } catch {
      return false;
    }
  }

  function addMediaQueryListener(query, listener) {
    if (typeof query.addEventListener === "function") {
      query.addEventListener("change", listener);
    } else if (typeof query.addListener === "function") {
      query.addListener(listener);
    }
  }

  let explicitTheme = readStorage(themeStorageKey);
  if (explicitTheme !== "dark" && explicitTheme !== "light") {
    explicitTheme = null;
  }

  // Popisy prichádzajú preložené zo servera cez data atribúty. Bez nich by
  // stránka v cudzom jazyku ohlásila tlačidlá po slovensky, pretože JavaScript
  // prepisuje `aria-label` vykreslený PHP šablónou.
  function elementLabel(element, datasetKey, fallback) {
    const value = element ? element.dataset[datasetKey] : "";
    return value || fallback;
  }

  function updateThemeControls(theme) {
    const themeToggle = document.getElementById("themeToggle");
    const themeIcon = themeToggle ? themeToggle.querySelector("i") : null;
    const isDark = theme === "dark";

    if (themeToggle) {
      const label = isDark
        ? elementLabel(themeToggle, "labelLight", "Prepnúť na svetlý režim")
        : elementLabel(themeToggle, "labelDark", "Prepnúť na tmavý režim");
      themeToggle.setAttribute("aria-label", label);
      themeToggle.setAttribute("aria-pressed", String(isDark));
      themeToggle.setAttribute("title", label);
    }

    if (themeIcon) {
      themeIcon.classList.remove("fa-moon", "fa-sun");
      themeIcon.classList.add(isDark ? "fa-sun" : "fa-moon");
    }

    const themeColor = document.querySelector('meta[name="theme-color"]');
    if (themeColor) {
      themeColor.setAttribute("content", isDark ? "#1a202c" : "#ffffff");
    }
  }

  function applyTheme(theme, persist = false) {
    const normalizedTheme = theme === "dark" ? "dark" : "light";
    document.documentElement.setAttribute("data-theme", normalizedTheme);

    if (persist) {
      explicitTheme = normalizedTheme;
      writeStorage(themeStorageKey, normalizedTheme);
    }

    updateThemeControls(normalizedTheme);
  }

  applyTheme(
    explicitTheme || (colorSchemeQuery.matches ? "dark" : "light"),
    false,
  );

  document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector(".navbar");
    const navToggle = document.getElementById("navToggle");
    const navMenu = document.getElementById("navMenu");
    const themeToggle = document.getElementById("themeToggle");
    const navLinks = navMenu
      ? Array.from(navMenu.querySelectorAll(".nav-link"))
      : [];
    const originalNavTabIndexes = new Map();

    function navMenuItems() {
      if (!navMenu) return [];
      return Array.from(
        navMenu.querySelectorAll("a[href], button:not([disabled]), [tabindex]"),
      );
    }

    function setNavMenuTabOrder(enabled) {
      navMenuItems().forEach((item) => {
        if (!originalNavTabIndexes.has(item)) {
          originalNavTabIndexes.set(item, item.getAttribute("tabindex"));
        }

        if (enabled) {
          const originalTabIndex = originalNavTabIndexes.get(item);
          if (originalTabIndex === null) {
            item.removeAttribute("tabindex");
          } else {
            item.setAttribute("tabindex", originalTabIndex);
          }
        } else {
          item.setAttribute("tabindex", "-1");
        }
      });
    }

    function isMobileMenuOpen() {
      return Boolean(
        navMenu &&
        mobileNavigationQuery.matches &&
        navMenu.classList.contains("active"),
      );
    }

    function syncNavigationState() {
      if (!navToggle || !navMenu) return;

      const isMobile = mobileNavigationQuery.matches;
      const isOpen = isMobile && navMenu.classList.contains("active");

      navToggle.classList.toggle("active", isOpen);
      navToggle.setAttribute("aria-expanded", String(isOpen));
      navToggle.setAttribute(
        "aria-label",
        isOpen
          ? elementLabel(navToggle, "labelClose", "Zavrieť navigáciu")
          : elementLabel(navToggle, "labelOpen", "Otvoriť navigáciu"),
      );

      if (isMobile) {
        navMenu.setAttribute("aria-hidden", String(!isOpen));
        navMenu.inert = !isOpen;
        setNavMenuTabOrder(isOpen);
      } else {
        navMenu.classList.remove("active");
        navMenu.removeAttribute("aria-hidden");
        navMenu.inert = false;
        setNavMenuTabOrder(true);
      }

      document.body.classList.toggle("nav-open", isOpen);
    }

    function openMobileMenu() {
      if (!navToggle || !navMenu || !mobileNavigationQuery.matches) return;

      navMenu.classList.add("active");
      syncNavigationState();

      const firstMenuItem = navMenuItems()[0];
      if (firstMenuItem) {
        window.requestAnimationFrame(() => firstMenuItem.focus());
      }
    }

    function closeMobileMenu(returnFocus = false) {
      if (!navToggle || !navMenu) return;

      navMenu.classList.remove("active");
      syncNavigationState();

      if (returnFocus && mobileNavigationQuery.matches) {
        navToggle.focus();
      }
    }

    if (navToggle && navMenu) {
      syncNavigationState();

      navToggle.addEventListener("click", () => {
        if (isMobileMenuOpen()) {
          closeMobileMenu(true);
        } else {
          openMobileMenu();
        }
      });

      navLinks.forEach((link) => {
        link.addEventListener("click", () => closeMobileMenu(false));
      });

      document.addEventListener("keydown", (event) => {
        if (!isMobileMenuOpen()) return;

        if (event.key === "Escape") {
          event.preventDefault();
          closeMobileMenu(true);
          return;
        }

        if (event.key !== "Tab" || !navbar) return;

        const focusableItems = Array.from(
          navbar.querySelectorAll(
            'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])',
          ),
        ).filter((item) => {
          const styles = window.getComputedStyle(item);
          return styles.display !== "none" && styles.visibility !== "hidden";
        });

        if (focusableItems.length === 0) return;

        const firstItem = focusableItems[0];
        const lastItem = focusableItems[focusableItems.length - 1];

        if (event.shiftKey && document.activeElement === firstItem) {
          event.preventDefault();
          lastItem.focus();
        } else if (!event.shiftKey && document.activeElement === lastItem) {
          event.preventDefault();
          firstItem.focus();
        }
      });

      addMediaQueryListener(mobileNavigationQuery, () => {
        closeMobileMenu(false);
        syncNavigationState();
      });
    }

    // Natívny <details> nemá „light dismiss“: bez tohto by ponuka jazykov
    // zostala otvorená aj po kliknutí inam a Escape by ju nezavrel, takže by
    // trvalo prekrývala obsah pod navigáciou.
    const langSwitcher = document.querySelector(".lang-switcher");
    if (langSwitcher) {
      const closeLangSwitcher = (returnFocus) => {
        if (!langSwitcher.open) return;
        langSwitcher.open = false;
        if (returnFocus) {
          const summary = langSwitcher.querySelector("summary");
          if (summary) {
            summary.focus();
          }
        }
      };

      document.addEventListener("click", (event) => {
        if (!langSwitcher.contains(event.target)) {
          closeLangSwitcher(false);
        }
      });

      document.addEventListener("focusin", (event) => {
        if (!langSwitcher.contains(event.target)) {
          closeLangSwitcher(false);
        }
      });

      document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
          closeLangSwitcher(true);
        }
      });
    }

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", (event) => {
        const hash = anchor.getAttribute("href");
        if (!hash || hash === "#") return;

        let targetId;
        try {
          targetId = decodeURIComponent(hash.slice(1));
        } catch {
          targetId = hash.slice(1);
        }

        const target = document.getElementById(targetId);
        if (!target) return;

        event.preventDefault();

        const focusTarget =
          target.matches("main, [tabindex]") ||
          !target.querySelector("h1, h2, h3, h4, h5, h6")
            ? target
            : target.querySelector("h1, h2, h3, h4, h5, h6");
        const hadTabIndex = focusTarget.hasAttribute("tabindex");

        if (!hadTabIndex) {
          focusTarget.setAttribute("tabindex", "-1");
          focusTarget.addEventListener(
            "blur",
            () => focusTarget.removeAttribute("tabindex"),
            { once: true },
          );
        }

        if (window.location.hash !== hash) {
          try {
            window.history.pushState(null, "", hash);
          } catch {
            window.location.hash = hash;
          }
        }

        focusTarget.focus({ preventScroll: true });
        target.scrollIntoView({
          behavior: reducedMotionQuery.matches ? "auto" : "smooth",
          block: "start",
        });
      });
    });

    if (themeToggle) {
      updateThemeControls(
        document.documentElement.getAttribute("data-theme") || "light",
      );
      themeToggle.addEventListener("click", () => {
        const currentTheme =
          document.documentElement.getAttribute("data-theme") || "light";
        applyTheme(currentTheme === "dark" ? "light" : "dark", true);
      });
    }

    addMediaQueryListener(colorSchemeQuery, (event) => {
      if (explicitTheme === null) {
        applyTheme(event.matches ? "dark" : "light", false);
      }
    });

    const revealElements = Array.from(document.querySelectorAll(".reveal"));
    if (
      !reducedMotionQuery.matches &&
      typeof window.IntersectionObserver === "function"
    ) {
      const observer = new IntersectionObserver(
        (entries, observerInstance) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-visible");
              observerInstance.unobserve(entry.target);
            }
          });
        },
        { root: null, rootMargin: "0px", threshold: 0.1 },
      );

      revealElements.forEach((element) => {
        element.classList.add("reveal-pending");
        observer.observe(element);
      });
    } else {
      revealElements.forEach((element) => element.classList.add("is-visible"));
    }

    window.dataLayer = window.dataLayer || [];
    if (typeof window.gtag !== "function") {
      window.gtag = function gtag() {
        window.dataLayer.push(arguments);
      };
    }

    window.gtag("consent", "default", {
      ad_storage: "denied",
      ad_user_data: "denied",
      ad_personalization: "denied",
      analytics_storage: "denied",
      wait_for_update: 500,
    });

    const cookieContainer = document.getElementById("cookie-consent-container");
    let consentReturnFocus = null;

    function loadAnalytics() {
      if (document.getElementById("google-analytics-script")) return;

      window.gtag("js", new Date());
      window.gtag("config", gaMeasurementId, {
        allow_google_signals: false,
        allow_ad_personalization_signals: false,
      });

      const gaScript = document.createElement("script");
      gaScript.id = "google-analytics-script";
      gaScript.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(
        gaMeasurementId,
      )}`;
      gaScript.async = true;
      document.head.appendChild(gaScript);
    }

    function clearAnalyticsCookies() {
      try {
        const cookieNames = document.cookie
          .split(";")
          .map((cookie) => cookie.trim().split("=")[0])
          .filter((name) => /^_(?:ga(?:_|$)|gid$|gat(?:_|$))/.test(name));
        const hostname = window.location.hostname;
        const registrableHost = hostname.replace(/^www\./, "");
        const domains = Array.from(
          new Set([hostname, registrableHost, `.${registrableHost}`]),
        );

        cookieNames.forEach((name) => {
          document.cookie = `${name}=; Max-Age=0; Path=/; SameSite=Lax`;
          domains.forEach((domain) => {
            document.cookie = `${name}=; Max-Age=0; Path=/; Domain=${domain}; SameSite=Lax`;
          });
        });
      } catch {
        // Consent still changes to denied even when cookie access is blocked.
      }
    }

    function updateAnalyticsConsent(granted, persist = true) {
      window.gtag("consent", "update", {
        ad_storage: "denied",
        ad_user_data: "denied",
        ad_personalization: "denied",
        analytics_storage: granted ? "granted" : "denied",
      });

      if (persist) {
        writeStorage(consentStorageKey, granted ? "accepted" : "rejected");
      }

      if (granted) {
        loadAnalytics();
      } else {
        clearAnalyticsCookies();
      }
    }

    function closeCookieBanner() {
      const banner = cookieContainer
        ? cookieContainer.querySelector(".cookie-banner")
        : null;
      if (banner) {
        banner.remove();
      }

      if (
        consentReturnFocus instanceof HTMLElement &&
        document.contains(consentReturnFocus)
      ) {
        consentReturnFocus.focus();
      }
      consentReturnFocus = null;
    }

    function showCookieBanner(options = {}) {
      if (!cookieContainer) return;

      const existing = cookieContainer.querySelector(".cookie-banner");
      if (existing) {
        consentReturnFocus = options.returnFocus || consentReturnFocus;
        if (options.focus) {
          existing.querySelector("button")?.focus();
        }
        return;
      }

      consentReturnFocus = options.returnFocus || null;

      const banner = document.createElement("div");
      banner.className = "cookie-banner";
      banner.setAttribute("role", "dialog");
      banner.setAttribute("aria-modal", "false");
      banner.setAttribute("aria-labelledby", "cookie-consent-title");
      banner.setAttribute("aria-describedby", "cookie-consent-description");
      // Texty prichádzajú preložené zo servera cez data atribúty. Vkladajú sa
      // ako textContent, takže sa nikdy neinterpretujú ako HTML.
      const strings = {
        title: cookieContainer.dataset.cookieTitle || "Analytické cookies",
        description:
          cookieContainer.dataset.cookieDescription ||
          "S vaším súhlasom použijeme Google Analytics 4 na meranie návštevnosti. Reklamné úložisko a personalizácia zostávajú vypnuté. Odmietnutie neobmedzí používanie stránky. Podrobnosti nájdete v",
        privacyLabel:
          cookieContainer.dataset.cookiePrivacyLabel ||
          "zásadách ochrany súkromia",
        decline: cookieContainer.dataset.cookieDecline || "Odmietnuť",
        accept: cookieContainer.dataset.cookieAccept || "Súhlasím",
      };

      banner.innerHTML = `
        <div class="cookie-content">
          <div class="cookie-text">
            <h2 id="cookie-consent-title" class="cookie-title"></h2>
            <p id="cookie-consent-description"><span class="cookie-description-text"></span> <a class="cookie-link"></a>.</p>
          </div>
          <div class="cookie-buttons">
            <button type="button" class="btn-cookie-decline"></button>
            <button type="button" class="btn-cookie-accept"></button>
          </div>
        </div>
      `;

      banner.querySelector(".cookie-title").textContent = strings.title;
      banner.querySelector(".cookie-description-text").textContent =
        strings.description;
      banner.querySelector(".btn-cookie-decline").textContent = strings.decline;
      banner.querySelector(".btn-cookie-accept").textContent = strings.accept;

      const privacyLink = banner.querySelector(".cookie-link");
      if (privacyLink) {
        privacyLink.textContent = strings.privacyLabel;
        privacyLink.setAttribute(
          "href",
          cookieContainer.dataset.privacyUrl || "privacy.php",
        );
      }

      banner
        .querySelector(".btn-cookie-accept")
        ?.addEventListener("click", () => {
          updateAnalyticsConsent(true);
          closeCookieBanner();
        });

      banner
        .querySelector(".btn-cookie-decline")
        ?.addEventListener("click", () => {
          updateAnalyticsConsent(false);
          closeCookieBanner();
        });

      cookieContainer.appendChild(banner);

      if (options.focus) {
        banner.querySelector("button")?.focus();
      }
    }

    const storedConsent = readStorage(consentStorageKey);
    if (storedConsent === "accepted") {
      updateAnalyticsConsent(true, false);
    } else if (storedConsent === "rejected") {
      updateAnalyticsConsent(false, false);
    } else {
      showCookieBanner();
    }

    document.querySelectorAll(".cookie-settings-trigger").forEach((trigger) => {
      trigger.addEventListener("click", () => {
        showCookieBanner({ focus: true, returnFocus: trigger });
      });
    });

    const yearSpan = document.getElementById("current-year");
    if (yearSpan) {
      yearSpan.textContent = String(new Date().getFullYear());
    }

    document.querySelectorAll("form[data-confirm]").forEach((form) => {
      form.addEventListener("submit", (event) => {
        if (!window.confirm(form.dataset.confirm)) {
          event.preventDefault();
        }
      });
    });
  });
})();
