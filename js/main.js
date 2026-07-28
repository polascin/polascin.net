document.addEventListener("DOMContentLoaded", () => {
  const navToggle = document.getElementById("navToggle");
  const navMenu = document.getElementById("navMenu");
  const navLinks = document.querySelectorAll(".nav-link");

  // Navigation toggle for mobile
  if (navToggle && navMenu) {
    navToggle.addEventListener("click", () => {
      const isOpen = navMenu.classList.toggle("active");
      navToggle.classList.toggle("active", isOpen);
      navToggle.setAttribute("aria-expanded", String(isOpen));
    });
  }

  // Close mobile menu when a link is clicked
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      if (navMenu && navMenu.classList.contains("active")) {
        navMenu.classList.remove("active");
        navToggle.classList.remove("active");
        navToggle.setAttribute("aria-expanded", "false");
      }
    });
  });

  // Smooth scrolling for anchor links with fixed header offset
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (event) {
      const targetId = this.getAttribute("href");
      if (targetId === "#") return;

      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        event.preventDefault();
        const headerOffset = 80;
        const elementPosition = targetElement.getBoundingClientRect().top;
        const offsetPosition =
          elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: window.matchMedia("(prefers-reduced-motion: reduce)")
            .matches
            ? "auto"
            : "smooth",
        });
      }
    });
  });

  // Theme toggle
  const themeToggle = document.getElementById("themeToggle");
  const themeIcon = themeToggle ? themeToggle.querySelector("i") : null;

  function setTheme(theme) {
    document.documentElement.setAttribute("data-theme", theme);
    localStorage.setItem("theme", theme);

    if (themeIcon) {
      themeIcon.classList.remove("fa-moon", "fa-sun");
      themeIcon.classList.add(theme === "dark" ? "fa-sun" : "fa-moon");
    }
  }

  const savedTheme = localStorage.getItem("theme");
  const systemPrefersDark = window.matchMedia(
    "(prefers-color-scheme: dark)",
  ).matches;

  if (savedTheme) {
    setTheme(savedTheme);
  } else if (systemPrefersDark) {
    setTheme("dark");
  }

  if (themeToggle) {
    themeToggle.addEventListener("click", () => {
      const currentTheme = document.documentElement.getAttribute("data-theme");
      setTheme(currentTheme === "dark" ? "light" : "dark");
    });
  }

  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (event) => {
      if (!localStorage.getItem("theme")) {
        setTheme(event.matches ? "dark" : "light");
      }
    });

  // Scroll-driven fade-in animation (honors reduced motion)
  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

  if (!reducedMotion.matches) {
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

    document.querySelectorAll(".reveal").forEach((el) => {
      observer.observe(el);
    });
  }

  // Google Consent Mode v2 banner and analytics configuration
  const cookieContainer = document.getElementById("cookie-consent-container");
  const storageKey = "privacy_consent";
  const gaMeasurementId = "G-9EMD3BVXCJ";

  // consent-default.js already defines gtag with default 'denied'.
  // Ensure the helper exists if that script was cached/blocked.
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }

  // Load GA script and configure it (respects the default denied state)
  const gaScript = document.createElement("script");
  gaScript.src = `https://www.googletagmanager.com/gtag/js?id=${gaMeasurementId}`;
  gaScript.async = true;
  document.head.appendChild(gaScript);
  gtag("js", new Date());
  gtag("config", gaMeasurementId);

  function updateConsent(granted) {
    const status = granted ? "granted" : "denied";
    gtag("consent", "update", {
      ad_storage: status,
      ad_user_data: status,
      ad_personalization: status,
      analytics_storage: status,
    });
    localStorage.setItem(storageKey, granted ? "accepted" : "rejected");
  }

  function showCookieBanner() {
    if (!cookieContainer) return;

    const existing = cookieContainer.querySelector(".cookie-banner");
    if (existing) return;

    const banner = document.createElement("div");
    banner.className = "cookie-banner";
    banner.setAttribute("role", "dialog");
    banner.setAttribute("aria-label", "Cookie consent");
    banner.setAttribute("aria-live", "polite");
    banner.innerHTML = `
      <div class="cookie-content">
        <div class="cookie-text">
          <p>We use cookies to analyze our traffic. By clicking "Accept", you consent to our use of tracking cookies (Google Analytics 4). You can also decline to continue without tracking. See our <a href="privacy.php" class="cookie-link">Privacy Policy</a>.</p>
        </div>
        <div class="cookie-buttons">
          <button id="cookieDecline" class="btn-cookie-decline">Decline</button>
          <button id="cookieAccept" class="btn-cookie-accept">Accept</button>
        </div>
      </div>
    `;

    cookieContainer.appendChild(banner);

    document.getElementById("cookieAccept").addEventListener("click", () => {
      updateConsent(true);
      banner.remove();
    });

    document.getElementById("cookieDecline").addEventListener("click", () => {
      updateConsent(false);
      banner.remove();
    });
  }

  const storedConsent = localStorage.getItem(storageKey);
  if (storedConsent === "accepted") {
    updateConsent(true);
  } else if (storedConsent === "rejected") {
    updateConsent(false);
  } else {
    setTimeout(showCookieBanner, 1000);
  }

  document.querySelectorAll(".cookie-settings-trigger").forEach((trigger) => {
    trigger.addEventListener("click", (event) => {
      event.preventDefault();
      const existing =
        cookieContainer && cookieContainer.querySelector(".cookie-banner");
      if (existing) existing.remove();
      showCookieBanner();
    });
  });

  // Dynamic current year
  const yearSpan = document.getElementById("current-year");
  if (yearSpan) {
    yearSpan.textContent = String(new Date().getFullYear());
  }

  // Confirm before destructive form submissions
  document.querySelectorAll("form[data-confirm]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      if (!window.confirm(form.dataset.confirm)) {
        event.preventDefault();
      }
    });
  });
});
