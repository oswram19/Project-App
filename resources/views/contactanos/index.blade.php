@extends('adminlte::page')

@section('title', 'Contactanos')

@section('content_header')
    <h1>Contáctanos, envianos un correo </h1>
    
@stop

@section('content')
    @if(session('success'))
        <div id="success-message" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color: #cfe2ff; border: 1px solid #9ec5fe; color: #084298;" class="px-4 py-3 rounded" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Envíanos un mensaje</h3>
        </div>
        <div class="card-body">
            <form id="contactForm" action="{{ route('contactanos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="correo" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" class="form-control" rows="4" required></textarea>
                </div>
                
                <button type="submit" id="submitBtn" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> <span id="btnText">Enviar</span>
                </button>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        #success-message {
            animation: slideInRight 0.5s ease-out;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("AdminLTE cargado correctamente");
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            let formSubmitting = false;
            
            // Prevenir múltiples envíos
            form.addEventListener('submit', function(e) {
                if (formSubmitting) {
                    e.preventDefault();
                    return false;
                }
                formSubmitting = true;
                submitBtn.disabled = true;
                btnText.textContent = 'Enviando...';
            });
            
            @if(session('success'))
                // Limpiar el formulario después de enviar con éxito
                document.getElementById('nombre').value = '';
                document.getElementById('correo').value = '';
                document.getElementById('mensaje').value = '';
                
                // Ocultar el mensaje de éxito después de 2 segundos
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    setTimeout(function() {
                        successMessage.style.transition = 'opacity 0.5s';
                        successMessage.style.opacity = '0';
                        setTimeout(function() {
                            successMessage.remove();
                        }, 500);
                    }, 2000);
                }
            @endif
        });
    </script>
@stop

