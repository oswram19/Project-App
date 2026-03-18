{{-- Navbar darkmode widget --}}

<li class="nav-item adminlte-darkmode-widget">

    <a class="nav-link" href="#" role="button" title="Modo oscuro" style="cursor:help;">
        <i class="{{ $makeIconClass() }}"></i>
    </a>

</li>

{{-- Remove default AdminLTE darkmode click handler to avoid conflicts --}}
{{-- The admin-theme-sync.js handles all darkmode logic correctly --}}
