@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Crear Nuevo Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}"
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
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-group">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        <div class="input-group-append">
                            <button type="button" class="btn" style="border: none; background: none; color: #6c757d;" id="togglePassword">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <div class="input-group">
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="form-control"
                               required>
                        <div class="input-group-append">
                            <button type="button" class="btn" style="border: none; background: none; color: #6c757d;" id="togglePasswordConfirmation">
                                <i class="fas fa-eye" id="eyeIconConfirmation"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Asignar Roles <span class="text-danger">*</span></label>
                    @error('roles')
                        <div class="alert alert-danger py-1 px-2 mb-2">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input type="checkbox" 
                                   name="roles[]" 
                                   value="{{ $role->id }}"
                                   class="form-check-input"
                                   id="role_{{ $role->id }}"
                                   {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-action btn-save">
                        <i class="fas fa-save"></i> Crear Usuario
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
        console.log("Formulario de creación de usuario cargado");

        // Función para alternar visibilidad de la contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Función para alternar visibilidad de la confirmación de contraseña
        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordConfirmationField = document.getElementById('password_confirmation');
            const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');
            
            if (passwordConfirmationField.type === 'password') {
                passwordConfirmationField.type = 'text';
                eyeIconConfirmation.classList.remove('fa-eye');
                eyeIconConfirmation.classList.add('fa-eye-slash');
            } else {
                passwordConfirmationField.type = 'password';
                eyeIconConfirmation.classList.remove('fa-eye-slash');
                eyeIconConfirmation.classList.add('fa-eye');
            }
        });
    </script>
@stop
