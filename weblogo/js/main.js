document.addEventListener('DOMContentLoaded', () => {
    // Navigation Toggle for Mobile
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const navLinks = document.querySelectorAll('.nav-link');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');

            // Accessibility
            const isExpanded = navToggle.classList.contains('active');
            navToggle.setAttribute('aria-expanded', isExpanded);
        });
    }

    // Close mobile menu when a link is clicked
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });
    });

    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                // Offset for fixed header
                const headerOffset = 80;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle.querySelector('i');

    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);

        // Update Icon
        if (theme === 'dark') {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    }

    // Check for saved theme or system preference
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme) {
        setTheme(savedTheme);
    } else if (systemPrefersDark) {
        setTheme('dark');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });
    }

    // Listen for system changes (optional dynamic update)
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        if (!localStorage.getItem('theme')) {
            setTheme(event.matches ? 'dark' : 'light');
        }
    });

    // Simple Intersection Observer for Fade-in Animation on Scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Apply animation styles to cards and section titles initially
    const animatedElements = document.querySelectorAll('.card, .section-title, .about-text');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(el);
    });
    const cookieContainer = document.getElementById('cookie-consent-container');
    const storageKey = 'privacy_consent';
    const gaMeasurementId = 'G-9EMD3BVXCJ';

    function loadAnalytics() {
        if (!cookieContainer || document.getElementById('google-analytics-script')) return;

        gtag('js', new Date());
        gtag('config', gaMeasurementId, {
            allow_google_signals: false,
            allow_ad_personalization_signals: false
        });

        const script = document.createElement('script');
        script.id = 'google-analytics-script';
        script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(gaMeasurementId)}`;
        script.async = true;
        document.head.appendChild(script);
    }

    function clearAnalyticsCookies() {
        const names = document.cookie
            .split(';')
            .map(cookie => cookie.trim().split('=')[0])
            .filter(name => /^_(?:ga(?:_|$)|gid$|gat(?:_|$))/.test(name));
        const hostname = window.location.hostname;
        const registrableHost = hostname.replace(/^www\./, '');
        const domains = [...new Set([hostname, registrableHost, `.${registrableHost}`])];

        names.forEach(name => {
            document.cookie = `${name}=; Max-Age=0; Path=/; SameSite=Lax`;
            domains.forEach(domain => {
                document.cookie = `${name}=; Max-Age=0; Path=/; Domain=${domain}; SameSite=Lax`;
            });
        });
    }

    function updateConsent(granted, persist = true) {
        const analyticsWasLoaded = Boolean(document.getElementById('google-analytics-script'));
        gtag('consent', 'update', {
            ad_storage: 'denied',
            ad_user_data: 'denied',
            ad_personalization: 'denied',
            analytics_storage: granted ? 'granted' : 'denied'
        });

        if (persist) {
            localStorage.setItem(storageKey, granted ? 'accepted' : 'rejected');
        }

        if (granted) {
            loadAnalytics();
        } else {
            clearAnalyticsCookies();
            if (persist && analyticsWasLoaded) {
                window.location.reload();
            }
        }
    }

    function showCookieBanner() {
        if (!cookieContainer || cookieContainer.querySelector('.cookie-banner')) return;

        const banner = document.createElement('div');
        banner.className = 'cookie-banner';
        banner.setAttribute('role', 'dialog');
        banner.setAttribute('aria-modal', 'false');
        banner.setAttribute('aria-label', 'Cookie settings');
        banner.innerHTML = `
            <div class="cookie-content">
                <div class="cookie-text">
                    <p>Google Analytics 4 loads only if you choose to allow analytics. Advertising features remain disabled. See our <a href="privacy.html" style="text-decoration: underline;">Privacy Policy</a>.</p>
                </div>
                <div class="cookie-buttons">
                    <button type="button" class="btn-cookie-decline">Decline</button>
                    <button type="button" class="btn-cookie-accept">Allow analytics</button>
                </div>
            </div>
        `;

        banner.querySelector('.btn-cookie-accept').addEventListener('click', () => {
            updateConsent(true);
            banner.remove();
        });
        banner.querySelector('.btn-cookie-decline').addEventListener('click', () => {
            updateConsent(false);
            banner.remove();
        });
        cookieContainer.appendChild(banner);
    }

    const storedConsent = localStorage.getItem(storageKey);
    if (storedConsent === 'accepted') {
        updateConsent(true, false);
    } else if (storedConsent === 'rejected') {
        updateConsent(false, false);
    } else {
        showCookieBanner();
    }

    document.querySelectorAll('.cookie-settings-trigger').forEach(trigger => {
        trigger.addEventListener('click', showCookieBanner);
    });

    // Dynamic Current Year
    const yearSpan = document.getElementById('current-year');
    if (yearSpan) {
        yearSpan.textContent = new Date().getFullYear();
    }
});
