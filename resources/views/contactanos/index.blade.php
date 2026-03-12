@extends('adminlte::page')

@section('title', 'Contactanos')

@section('content_header')
    <h1>Contáctanos, envianos un correo </h1>
    
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Envíanos un mensaje</h3>
        </div>
        <div class="card-body">
            <form id="contactForm" action="{{ route('contactanos.store') }}" method="POST" enctype="multipart/form-data">
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
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="habilitarArchivo">
                        <label class="custom-control-label" for="habilitarArchivo">
                            <i class="fas fa-paperclip"></i> ¿Deseas adjuntar un archivo?
                        </label>
                    </div>
                </div>
                
                <div class="form-group" id="archivoContainer" style="display: none;">
                    <label for="archivo"><i class="fas fa-file-upload"></i> Selecciona tu archivo:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.txt,.xlsx,.xls">
                        <label class="custom-file-label" for="archivo" id="archivoLabel">Seleccionar archivo...</label>
                    </div>
                    <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX, JPG, PNG, GIF, TXT, XLSX. Máximo 10MB.</small>
                </div>
                
                <button type="submit" id="submitBtn" class="btn btn-action btn-create">
                    <i class="fas fa-paper-plane"></i> <span id="btnText">Enviar</span>
                </button>
            </form>
        </div>
    </div>

    <div class="contactanos-splashed is-empty" id="contactanosSplashed">
        <div class="toast-panel">
            <div class="toast-item" id="contactToastItem">
                <div class="toast success" id="contactToastBox">
                    <label class="close" id="contactToastClose"></label>
                    <h3 id="contactToastTitle">Éxito</h3>
                    <p id="contactToastMessage">Tu mensaje ha sido enviado correctamente.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}?v={{ filemtime(public_path('css/admin-custom.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/contactanos.css') }}?v={{ filemtime(public_path('css/contactanos.css')) }}">
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastContainer = document.getElementById('contactanosSplashed');
            const toastBox = document.getElementById('contactToastBox');
            const toastTitle = document.getElementById('contactToastTitle');
            const toastMessage = document.getElementById('contactToastMessage');
            const toastClose = document.getElementById('contactToastClose');
            let toastTimer = null;

            const hideToast = () => {
                if (toastTimer) {
                    clearTimeout(toastTimer);
                    toastTimer = null;
                }

                if (toastContainer) {
                    toastContainer.classList.add('is-empty');
                }
            };

            const showToast = (type, title, message) => {
                if (!toastContainer || !toastBox) return;

                const normalizedType = ['success', 'warning', 'error', 'help', 'info'].includes(type) ? type : 'success';
                toastBox.classList.remove('help', 'info', 'success', 'warning', 'error');
                toastBox.classList.add(normalizedType);

                if (toastTitle) {
                    toastTitle.textContent = title || 'Notificación';
                }

                if (toastMessage) {
                    toastMessage.textContent = message || '';
                }

                if (toastTimer) {
                    clearTimeout(toastTimer);
                }

                toastContainer.classList.remove('is-empty');
                toastTimer = setTimeout(hideToast, 4500);
            };

            if (toastClose) {
                toastClose.addEventListener('click', function() {
                    hideToast();
                });
            }

            @if(session('success'))
                showToast('info', 'Enviado', @json(session('success')));
            @elseif(session('warning'))
                showToast('warning', 'Advertencia', @json(session('warning')));
            @elseif(session('error'))
                showToast('error', 'Error', @json(session('error')));
            @endif

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
            
            // Toggle para mostrar/ocultar sección de archivo adjunto
            const habilitarArchivo = document.getElementById('habilitarArchivo');
            const archivoContainer = document.getElementById('archivoContainer');
            const archivoInput = document.getElementById('archivo');
            const archivoLabel = document.getElementById('archivoLabel');
            
            habilitarArchivo.addEventListener('change', function() {
                if (this.checked) {
                    archivoContainer.style.display = 'block';
                    archivoContainer.style.animation = 'fadeIn 0.3s ease-out';
                } else {
                    archivoContainer.style.display = 'none';
                    // Limpiar el archivo seleccionado al deshabilitar
                    archivoInput.value = '';
                    archivoLabel.textContent = 'Seleccionar archivo...';
                }
            });
            
            // Mostrar nombre del archivo seleccionado
            archivoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
                    archivoLabel.textContent = fileName + ' (' + fileSize + ' MB)';
                    archivoLabel.classList.add('selected');
                } else {
                    archivoLabel.textContent = 'Seleccionar archivo...';
                    archivoLabel.classList.remove('selected');
                }
            });
            
            @if(session('success'))
                // Limpiar el formulario después de enviar con éxito
                document.getElementById('nombre').value = '';
                document.getElementById('correo').value = '';
                document.getElementById('mensaje').value = '';
                document.getElementById('archivo').value = '';
                document.getElementById('archivoLabel').textContent = 'Seleccionar archivo...';
                document.getElementById('habilitarArchivo').checked = false;
                document.getElementById('archivoContainer').style.display = 'none';
            @endif
        });
    </script>
@stop

