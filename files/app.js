document.addEventListener('DOMContentLoaded', function() {
    const smoothScrollLinks = document.querySelectorAll('a.nav-link[href^="#"], .scroll-down-arrow[href^="#"]');
    const offcanvasNavbar = document.getElementById('offcanvasNavbar');
    const offcanvasInstance = offcanvasNavbar ? new bootstrap.Offcanvas(offcanvasNavbar) : null;

    if (smoothScrollLinks.length > 0) {
        smoothScrollLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - (document.getElementById('main-navbar') ? document.getElementById('main-navbar').offsetHeight : 0),
                        behavior: 'smooth'
                    });

                    if (offcanvasNavbar && offcanvasNavbar.classList.contains('show')) {
                        offcanvasInstance.hide();
                    }
                }
            });
        });
    }

    const cookieConsentModal = document.getElementById('cookieConsentModal');
    const acceptAllCookiesBtn = document.getElementById('acceptAllCookiesBtn');
    const rejectCookiesBtn = document.getElementById('rejectCookiesBtn');
    const customizeCookiesBtn = document.getElementById('customizeCookiesBtn');
    const saveCustomCookiesBtn = document.getElementById('saveCustomCookiesBtn');
    const analyticsCookies = document.getElementById('analyticsCookies');
    const marketingCookies = document.getElementById('marketingCookies');

    function setCookie(name, value, days) {
        let expires = '';
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + (value || '') + expires + '; path=/';
    }

    function getCookie(name) {
        const nameEQ = name + '=';
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function showCookieConsent() {
        if (!getCookie('cookieConsent') && cookieConsentModal) {
            const modal = new bootstrap.Modal(cookieConsentModal);
            modal.show();
        }
    }

    if (cookieConsentModal) {
        cookieConsentModal.addEventListener('hidden.bs.modal', function () {
            if (acceptAllCookiesBtn) acceptAllCookiesBtn.classList.remove('d-none');
            if (rejectCookiesBtn) rejectCookiesBtn.classList.remove('d-none');
            if (customizeCookiesBtn) customizeCookiesBtn.classList.remove('d-none');
            if (saveCustomCookiesBtn) saveCustomCookiesBtn.classList.add('d-none');
        });
    }

    if (acceptAllCookiesBtn) {
        acceptAllCookiesBtn.addEventListener('click', function() {
            setCookie('cookieConsent', 'all', 365);
            if (analyticsCookies) analyticsCookies.checked = true;
            if (marketingCookies) marketingCookies.checked = true;
            const modal = bootstrap.Modal.getInstance(cookieConsentModal);
            if (modal) modal.hide();
        });
    }

    if (rejectCookiesBtn) {
        rejectCookiesBtn.addEventListener('click', function() {
            setCookie('cookieConsent', 'essential', 365);
            if (analyticsCookies) analyticsCookies.checked = false;
            if (marketingCookies) marketingCookies.checked = false;
            const modal = bootstrap.Modal.getInstance(cookieConsentModal);
            if (modal) modal.hide();
        });
    }

    if (customizeCookiesBtn) {
        customizeCookiesBtn.addEventListener('click', function() {
            if (acceptAllCookiesBtn) acceptAllCookiesBtn.classList.add('d-none');
            if (rejectCookiesBtn) rejectCookiesBtn.classList.add('d-none');
            if (customizeCookiesBtn) customizeCookiesBtn.classList.add('d-none');
            if (saveCustomCookiesBtn) saveCustomCookiesBtn.classList.remove('d-none');

            const consent = getCookie('cookieConsent');
            if (consent === 'all') {
                if (analyticsCookies) analyticsCookies.checked = true;
                if (marketingCookies) marketingCookies.checked = true;
            } else if (consent === 'essential') {
                if (analyticsCookies) analyticsCookies.checked = false;
                if (marketingCookies) marketingCookies.checked = false;
            } else if (consent) {
                try {
                    const settings = JSON.parse(consent);
                    if (analyticsCookies) analyticsCookies.checked = settings.analytics;
                    if (marketingCookies) marketingCookies.checked = settings.marketing;
                } catch (e) {
                    console.error('Error parsing cookie consent:', e);
                }
            }
        });
    }

    if (saveCustomCookiesBtn) {
        saveCustomCookiesBtn.addEventListener('click', function() {
            const settings = {
                essential: true,
                analytics: analyticsCookies ? analyticsCookies.checked : false,
                marketing: marketingCookies ? marketingCookies.checked : false
            };
            setCookie('cookieConsent', JSON.stringify(settings), 365);
            const modal = bootstrap.Modal.getInstance(cookieConsentModal);
            if (modal) modal.hide();
        });
    }

    showCookieConsent();
});