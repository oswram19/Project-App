@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Datos del Usuario</h1>
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
            <form action="{{ route('admin.users.update-data', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}"
                           required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}"
                           required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-action btn-save">
                        <i class="fas fa-save"></i> Actualizar Datos
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-action btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
@stop

@section('js')
    <script>
        console.log("Edición de datos de usuario cargada");

        function showToast(message, type) {
            const toastHeader = document.getElementById('toastHeader');
            const toastIcon = document.getElementById('toastIcon');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');
            
            toastHeader.classList.remove('bg-success', 'bg-danger', 'bg-primary', 'bg-warning', 'bg-info', 'text-white', 'text-dark');
            toastIcon.classList.remove('fa-check-circle', 'fa-times-circle', 'fa-user-edit', 'fa-edit');
            
            if (type === 'edit') {
                toastHeader.classList.add('bg-info', 'text-white');
                toastIcon.classList.add('fa-user-edit');
                toastTitle.textContent = 'Datos Actualizados';
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
                showToast('{{ session('success') }}', 'edit');
            @endif
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>
@stop
