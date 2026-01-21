@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Asignar un rol</h1>

@stop

@section('content')
    <!-- Toast de notificación -->
    <div class="toast" id="notificationToast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 300px;" data-delay="4000">
        <div class="toast-header" id="toastHeader">
            <i class="fas fa-check-circle mr-2" id="toastIcon"></i>
            <strong class="mr-auto" id="toastTitle">Notificación</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="toastMessage"></div>
    </div>

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
        console.log("sin errores");

        function showToast(message, type) {
            const toastHeader = document.getElementById('toastHeader');
            const toastIcon = document.getElementById('toastIcon');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');
            
            toastHeader.classList.remove('bg-success', 'bg-danger', 'bg-primary', 'bg-warning', 'bg-info', 'text-white', 'text-dark');
            toastIcon.classList.remove('fa-check-circle', 'fa-times-circle', 'fa-user-tag', 'fa-edit');
            
            if (type === 'roles') {
                toastHeader.classList.add('bg-warning', 'text-dark');
                toastIcon.classList.add('fa-user-tag');
                toastTitle.textContent = 'Roles Actualizados';
            } else if (type === 'error') {
                toastHeader.classList.add('bg-danger', 'text-white');
                toastIcon.classList.add('fa-times-circle');
                toastTitle.textContent = 'Error';
            } else {
                toastHeader.classList.add('bg-success', 'text-white');
                toastIcon.classList.add('fa-check-circle');
                toastTitle.textContent = '¡Éxito!';
            }
            
            toastMessage.textContent = message;
            $('#notificationToast').toast('show');
        }

        $(document).ready(function() {
            @if(session('success'))
                showToast('{{ session('success') }}', 'roles');
            @endif
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>
@stop
