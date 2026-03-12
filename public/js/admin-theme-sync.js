(function () {
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

    function syncDarkmodeIcon(isDark) {
        var icon = document.querySelector('li.adminlte-darkmode-widget i');

        if (!icon) {
            return;
        }

        icon.classList.remove('far', 'fas', 'fa-moon', 'fa-sun');

        if (isDark) {
            icon.classList.add('fas', 'fa-sun');
        } else {
            icon.classList.add('far', 'fa-moon');
        }
    }

    function applyTheme(isDark) {
        var body = document.body;
        var html = document.documentElement;

        if (!body || !html) {
            return;
        }

        body.classList.toggle('dark-mode', isDark);
        html.classList.toggle('dark', isDark);
        setStoredTheme(isDark ? 'dark' : 'light');
        syncDarkmodeIcon(isDark);
    }

    function initializeThemeSync() {
        var body = document.body;
        var storedTheme = getStoredTheme();
        var widget = document.querySelector('li.adminlte-darkmode-widget');

        if (!body) {
            return;
        }

        if (storedTheme === 'dark' || storedTheme === 'light') {
            applyTheme(storedTheme === 'dark');
        } else {
            applyTheme(body.classList.contains('dark-mode'));
        }

        if (widget) {
            widget.addEventListener('click', function () {
                // Wait for AdminLTE widget to toggle classes first.
                window.setTimeout(function () {
                    applyTheme(document.body.classList.contains('dark-mode'));
                }, 0);
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
