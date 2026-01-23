@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Categorías</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Categorías</h3>
            <div class="card-tools">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-action btn-save btn-sm">
                    <i class="fas fa-plus"></i> Nueva Categoría
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="categories">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/responsive.bootstrap4.js"></script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            // ==================== CONFIGURACIÓN TOAST MEJORADA ====================
            toastr.options = {
                "closeButton": true,              // Botón para cerrar
                "debug": false,
                "newestOnTop": true,              // Las nuevas aparecen arriba
                "progressBar": true,              // Barra de progreso
                "positionClass": "toast-bottom-right",  // Posición inferior derecha
                "preventDuplicates": true,        // Evitar duplicados
                "onclick": null,
                "showDuration": "400",            // Duración animación entrada
                "hideDuration": "1000",           // Duración animación salida
                "timeOut": "5000",                // Tiempo visible (5 segundos)
                "extendedTimeOut": "2000",        // Tiempo extra al pasar mouse
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Estilos personalizados para las notificaciones
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    /* Bordes redondeados */
                    #toast-container > div {
                        border-radius: 12px !important;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
                        padding: 15px 15px 15px 50px !important;
                    }
                    /* Estilo success */
                    #toast-container > .toast-success {
                        background-color: #28a745 !important;
                        opacity: 0.95 !important;
                    }
                    /* Estilo error */
                    #toast-container > .toast-error {
                        background-color: #dc3545 !important;
                        opacity: 0.95 !important;
                    }
                    /* Estilo warning */
                    #toast-container > .toast-warning {
                        background-color: #ffc107 !important;
                        color: #333 !important;
                        opacity: 0.95 !important;
                    }
                    /* Estilo info */
                    #toast-container > .toast-info {
                        background-color: #17a2b8 !important;
                        opacity: 0.95 !important;
                    }
                    /* Título más grande */
                    #toast-container > div .toast-title {
                        font-weight: bold;
                        font-size: 14px;
                    }
                    /* Mensaje */
                    #toast-container > div .toast-message {
                        font-size: 13px;
                    }
                    /* Barra de progreso */
                    #toast-container > div .toast-progress {
                        height: 4px;
                        border-radius: 0 0 12px 12px;
                        opacity: 0.7;
                    }
                `)
                .appendTo('head');

            @if(session('success'))
                toastr.success('{{ session('success') }}', '✅ ¡Éxito!');
            @endif

            @if(session('error'))
                toastr.error('{{ session('error') }}', '❌ ¡Error!');
            @endif

            @if(session('warning'))
                toastr.warning('{{ session('warning') }}', '⚠️ ¡Advertencia!');
            @endif

            @if(session('info'))
                toastr.info('{{ session('info') }}', 'ℹ️ Información');
            @endif
            // =====================================================================
        });

        new DataTable('#categories', {
            ajax: '/datatable/categories',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'description' },
                { data: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <a href="/admin/categories/${row.id}/edit" 
                               class="btn btn-sm btn-action btn-edit"
                               data-toggle="tooltip" 
                               data-placement="top" 
                               title="Editar categoría ${row.name}">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-action btn-delete"
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Eliminar categoría ${row.name}"
                                    onclick="deleteCategory(${row.id}, '${row.name}')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        `;
                    }
                }
            ],
            responsive: true,
            autoWidth: true,
            language: {
                "lengthMenu": "Mostrar" +
                    '<select class="custom-select custom-select-sm form-control form-control-sm">' +
                    '<option value="5">5</option>' +
                    '<option value="10">10</option>' +
                    '<option value="25">25</option>' +
                    '<option value="50">50</option>' +
                    '<option value="100">100</option>' +
                    '<option value="-1">todos</option>' +
                    '</select>' +
                    "registros por página",
                "zeroRecords": "No se encontró registro - Busca nuevamente",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                search: "Buscar:",
                paginate: {
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        function deleteCategory(categoryId, categoryName) {
            if (confirm(`¿Estás seguro de eliminar la categoría ${categoryName}?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/categories/${categoryId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@stop
