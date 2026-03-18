{{-- Navbar darkmode widget --}}

<li class="nav-item adminlte-darkmode-widget">

    <a class="nav-link" href="#" role="button" title="Modo oscuro" style="cursor:help;">
        <i class="{{ $makeIconClass() }}"></i>
    </a>

</li>

{{-- Sync icon classes with dark mode state --}}

@once
@push('js')
<script>
    $(() => {
        const widget = document.querySelector('li.adminlte-darkmode-widget');
        const icon = widget ? widget.querySelector('i') : null;

        if (!icon) return;

        // Icon classes to toggle
        const enabledClasses = @json($makeIconEnabledClass());
        const disabledClasses = @json($makeIconDisabledClass());

        // Sync icon when widget is clicked
        widget.addEventListener('click', () => {
            // Let AdminLTE handle the toggle, then sync our icon
            setTimeout(() => {
                const isDarkMode = document.body.classList.contains('dark-mode');
                updateIconClasses(isDarkMode);
            }, 0);
        });

        function updateIconClasses(isDarkMode) {
            // Remove all icon classes
            icon.className = '';

            // Add appropriate classes based on dark mode state
            const classes = isDarkMode ? enabledClasses : disabledClasses;
            classes.forEach(cls => icon.classList.add(cls));
        }
    });
</script>
@endpush
@endonce
