{{-- Navbar darkmode widget with circular moon/sun button --}}

@php
    $isDark = (new \JeroenNoten\LaravelAdminLte\Http\Controllers\DarkModeController())->isEnabled();
    $toggleUrl = config('adminlte.disable_darkmode_routes', false)
        ? ''
        : route('adminlte.darkmode.toggle');
@endphp

<li class="nav-item">
    <button
        type="button"
        class="nav-link adminlte-darkmode-widget js-darkmode-toggle border-0 bg-transparent p-0 d-inline-flex align-items-center justify-content-center"
        data-toggle-url="{{ $toggleUrl }}"
        aria-label="{{ $isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro' }}"
        title="{{ $isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro' }}"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            class="darkmode-icon-sun text-warning {{ $isDark ? '' : 'd-none' }}"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
        >
            <circle cx="12" cy="12" r="4"></circle>
            <line x1="12" y1="2" x2="12" y2="4"></line>
            <line x1="12" y1="20" x2="12" y2="22"></line>
            <line x1="4.93" y1="4.93" x2="6.34" y2="6.34"></line>
            <line x1="17.66" y1="17.66" x2="19.07" y2="19.07"></line>
            <line x1="2" y1="12" x2="4" y2="12"></line>
            <line x1="20" y1="12" x2="22" y2="12"></line>
            <line x1="4.93" y1="19.07" x2="6.34" y2="17.66"></line>
            <line x1="17.66" y1="6.34" x2="19.07" y2="4.93"></line>
        </svg>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            class="darkmode-icon-moon {{ $isDark ? 'd-none' : '' }}"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
        >
            <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79z"></path>
        </svg>
    </button>
</li>
