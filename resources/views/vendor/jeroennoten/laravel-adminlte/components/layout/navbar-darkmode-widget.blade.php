{{-- Navbar darkmode widget - Dashboard style (circular with SVG icons) --}}

<li class="nav-item">
    <button 
        class="adminlte-darkmode-widget nav-link p-0 border-0 bg-transparent d-inline-flex align-items-center justify-content-center"
        type="button"
        title="Modo oscuro"
        style="cursor: pointer; width: 2.25rem; height: 2.25rem;"
    >
        <!-- Sol para modo oscuro activo -->
        <span id="darkmode-icon-sun" class="d-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-warning" style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4" />
                <line x1="12" y1="2" x2="12" y2="4" />
                <line x1="12" y1="20" x2="12" y2="22" />
                <line x1="4.93" y1="4.93" x2="6.34" y2="6.34" />
                <line x1="17.66" y1="17.66" x2="19.07" y2="19.07" />
                <line x1="2" y1="12" x2="4" y2="12" />
                <line x1="20" y1="12" x2="22" y2="12" />
                <line x1="4.93" y1="19.07" x2="6.34" y2="17.66" />
                <line x1="17.66" y1="6.34" x2="19.07" y2="4.93" />
            </svg>
        </span>

        <!-- Luna para modo claro activo -->
        <span id="darkmode-icon-moon" class="d-flex">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-dark" style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79z" />
            </svg>
        </span>
    </button>
</li>

{{-- Dark mode toggle script --}}
@once
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const widget = document.querySelector('.adminlte-darkmode-widget');
        const sunIcon = document.getElementById('darkmode-icon-sun');
        const moonIcon = document.getElementById('darkmode-icon-moon');

        if (!widget || !sunIcon || !moonIcon) return;

        function updateIconVisibility() {
            const isDarkMode = document.body.classList.contains('dark-mode');
            if (isDarkMode) {
                sunIcon.classList.remove('d-none');
                moonIcon.classList.add('d-none');
            } else {
                sunIcon.classList.add('d-none');
                moonIcon.classList.remove('d-none');
            }
        }

        // Update on initial load
        updateIconVisibility();

        // Update on click (AdminLTE will handle the toggle)
        widget.addEventListener('click', function() {
            setTimeout(updateIconVisibility, 50);
        });
    });
</script>
@endpush
@endonce
