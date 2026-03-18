(function () {
    function getDarkmodeButton() {
        return document.querySelector('.js-darkmode-toggle');
    }

    function getStoredTheme() {
        try {
            return window.localStorage.getItem('theme');
        } catch (error) {
            return null;
        }
    }

    function setStoredTheme(theme) {
        try {
            window.localStorage.setItem('theme', theme);
        } catch (error) {
            // Ignore storage errors (private mode or blocked storage).
        }
    }

    function syncIframeTheme(isDark) {
        var iframes = document.querySelectorAll('div.iframe-mode iframe');

        iframes.forEach(function (iframe) {
            try {
                var iframeBody = iframe.contentDocument && iframe.contentDocument.querySelector('body');

                if (iframeBody) {
                    iframeBody.classList.toggle('dark-mode', isDark);
                }
            } catch (error) {
                // Ignore cross-origin iframe access errors.
            }
        });
    }

    function syncDarkmodeIcon(isDark) {
        var button = getDarkmodeButton();
        var sunIcon = button ? button.querySelector('.darkmode-icon-sun') : null;
        var moonIcon = button ? button.querySelector('.darkmode-icon-moon') : null;
        var label;

        if (!button) {
            return;
        }

        label = isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro';

        if (sunIcon) {
            sunIcon.classList.toggle('d-none', !isDark);
        }

        if (moonIcon) {
            moonIcon.classList.toggle('d-none', isDark);
        }

        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
    }

    function notifyServerToggle() {
        var button = getDarkmodeButton();
        var toggleUrl = button ? button.getAttribute('data-toggle-url') : '';
        var csrfTokenMeta;
        var headers;

        if (!toggleUrl) {
            return;
        }

        csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        headers = {
            'X-Requested-With': 'XMLHttpRequest',
        };

        if (csrfTokenMeta) {
            headers['X-CSRF-TOKEN'] = csrfTokenMeta.getAttribute('content');
        }

        window.fetch(toggleUrl, {
            method: 'POST',
            headers: headers,
            credentials: 'same-origin',
        }).catch(function () {
            // Ignore notification failures; local preference still works.
        });
    }

    function applyTheme(isDark) {
        var body = document.body;
        var html = document.documentElement;

        if (!body || !html) {
            return;
        }

        body.classList.toggle('dark-mode', isDark);
        html.classList.toggle('dark', isDark);
        syncIframeTheme(isDark);
        setStoredTheme(isDark ? 'dark' : 'light');
        syncDarkmodeIcon(isDark);
    }

    function initializeThemeSync() {
        var body = document.body;
        var storedTheme = getStoredTheme();
        var button = getDarkmodeButton();

        if (!body) {
            return;
        }

        if (storedTheme === 'dark' || storedTheme === 'light') {
            applyTheme(storedTheme === 'dark');
        } else {
            applyTheme(body.classList.contains('dark-mode'));
        }

        if (button) {
            button.addEventListener('click', function (event) {
                var nextState;

                event.preventDefault();
                nextState = !document.body.classList.contains('dark-mode');
                applyTheme(nextState);
                notifyServerToggle();
            });
        }

        window.addEventListener('storage', function (event) {
            if (event.key !== 'theme') {
                return;
            }

            if (event.newValue === 'dark' || event.newValue === 'light') {
                applyTheme(event.newValue === 'dark');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeThemeSync);
    } else {
        initializeThemeSync();
    }
})();
