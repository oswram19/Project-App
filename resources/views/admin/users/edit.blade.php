@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Asignar un rol</h1>

@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p class ="h5">Nombre:</p>
            <p class ="form-control">{{ $user->name }}</p>

            <h2 class="h5">Asignar Roles:</h2>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                @foreach ($roles as $role)
                    <div>
                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                {{ $user->roles->contains($role->id) ? 'checked' : '' }} class="mr-1">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-action btn-save mt-3">
                    <i class="fas fa-save"></i> Asignar roles
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-action btn-cancel mt-3">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // ==================== CONFIGURACIÓN TOAST ====================
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "2000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if(session('created'))
                toastr.success('{{ session('created') }}', '🆕 ¡Creado!');
            @endif

            @if(session('updated'))
                toastr.info('{{ session('updated') }}', '✏️ ¡Actualizado!');
            @endif

            @if(session('deleted'))
                toastr.error('{{ session('deleted') }}', '🗑️ ¡Eliminado!');
            @endif

            @if(session('error'))
                toastr.error('{{ session('error') }}', '❌ ¡Error!');
            @endif

            @if(session('success'))
                toastr.success('{{ session('success') }}', '✅ ¡Éxito!');
            @endif
            // ==============================================================
        });
    </script>
@stop
