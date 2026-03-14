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
    // Cookie Consent Logic (Google Consent Mode v2)
    const cookieContainer = document.getElementById('cookie-consent-container');
    const storageKey = 'privacy_consent';
    const gaMeasurementId = 'G-9EMD3BVXCJ';

    // 3. Load the Google Analytics script (it will respect the 'denied' state)
    const script = document.createElement('script');
    script.src = `https://www.googletagmanager.com/gtag/js?id=${gaMeasurementId}`;
    script.async = true;
    document.head.appendChild(script);

    // 4. Configure GA
    gtag('js', new Date());
    gtag('config', gaMeasurementId);

    function updateConsent(granted) {
        const status = granted ? 'granted' : 'denied';
        gtag('consent', 'update', {
            'ad_storage': status,
            'ad_user_data': status,
            'ad_personalization': status,
            'analytics_storage': status
        });
        localStorage.setItem(storageKey, granted ? 'accepted' : 'rejected');
    }

    function showCookieBanner() {
        if (!cookieContainer) return;

        const banner = document.createElement('div');
        banner.className = 'cookie-banner';
        banner.innerHTML = `
            <div class="cookie-content">
                <div class="cookie-text">
                    <p>We use cookies to analyze our traffic. By clicking "Accept", you consent to our use of tracking cookies (Google Analytics 4). You can also decline to continue without tracking. See our <a href="privacy.html" style="text-decoration: underline;">Privacy Policy</a>.</p>
                </div>
                <div class="cookie-buttons">
                    <button id="cookieDecline" class="btn-cookie-decline">Decline</button>
                    <button id="cookieAccept" class="btn-cookie-accept">Accept</button>
                </div>
            </div>
        `;

        cookieContainer.appendChild(banner);

        document.getElementById('cookieAccept').addEventListener('click', () => {
            updateConsent(true);
            banner.remove();
        });

        document.getElementById('cookieDecline').addEventListener('click', () => {
            updateConsent(false);
            banner.remove();
        });
    }

    // Check existing consent
    const storedConsent = localStorage.getItem(storageKey);
    if (storedConsent === 'accepted') {
        updateConsent(true);
    } else if (storedConsent === 'rejected') {
        updateConsent(false);
    } else {
        // Show banner if no choice has been made
        setTimeout(showCookieBanner, 1000);
    }

    // Dynamic Current Year
    const yearSpan = document.getElementById('current-year');
    if (yearSpan) {
        yearSpan.textContent = new Date().getFullYear();
    }
});
