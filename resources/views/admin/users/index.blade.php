@extends('adminlte::page')

@section('title', 'usuario')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
@endsection
@section('content_header')
    <h1>lista de usuarios</h1>

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Usuarios</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.create') }}" class="btn btn-action btn-save btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-striped" id="usuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>correo</th>
                        <th>Incorporación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

            </table>

            <!-- Formulario oculto para eliminación -->
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            <!-- Modal de confirmación de eliminación -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de eliminar al usuario <span id="userNameSpan"></span>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop



@section('js')
    <script>
        console.log("AdminLTE cargado correctamente no se muestra en pantalla solo en consola del navegador");
    </script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.7/js/responsive.bootstrap4.js"></script>



    <script>
        $(document).ready(function() {
            // Inicializar tooltips de Bootstrap
            $('[data-toggle="tooltip"]').tooltip();
        });

        new DataTable('#usuarios', {
            ajax: '/datatable/users', //ruta creada en web.php
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'created_at'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // Escapar el nombre para evitar errores de sintaxis con comillas y caracteres especiales
                        const escapedName = row.name
                            .replace(/\\/g, '\\\\')
                            .replace(/'/g, "\\'")
                            .replace(/"/g, '\\"')
                            .replace(/\n/g, '\\n')
                            .replace(/\r/g, '\\r');
                        const htmlEscapedName = row.name
                            .replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(/"/g, '&quot;')
                            .replace(/'/g, '&#039;');
                        return `
                            <a href="/admin/users/${row.id}/edit-data" 
                               class="btn btn-sm btn-action btn-edit" 
                               data-toggle="tooltip" 
                               data-placement="top" 
                               title="Editar datos de ${htmlEscapedName}"> 
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="/admin/users/${row.id}/edit" 
                               class="btn btn-sm btn-action btn-roles" 
                               data-toggle="tooltip" 
                               data-placement="top" 
                               title="Asignar roles a ${htmlEscapedName}"> 
                                <i class="fas fa-user-tag"></i> Roles
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-action btn-delete" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Eliminar usuario ${htmlEscapedName}"
                                    data-user-id="${row.id}"
                                    data-user-name="${htmlEscapedName}">
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
                "zeroRecords": "No se encontro registro - Busca nuevamente",
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
                // Re-inicializar tooltips después de cada redibujado de la tabla
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        let userToDelete = { id: null, name: '' };

        function deleteUser(userId, userName) {
            userToDelete.id = userId;
            userToDelete.name = userName;
            document.getElementById('userNameSpan').textContent = userName;
            $('#deleteModal').modal('show');
        }

        // Event delegation para manejar clics en botones de eliminar
        $(document).on('click', '.btn-delete', function() {
            const userId = $(this).data('user-id');
            const userName = $(this).data('user-name');
            deleteUser(userId, userName);
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            const userId = userToDelete.id;
            const userName = userToDelete.name;
            $('#deleteModal').modal('hide');

            fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                // Mostrar toast con toastr - Rojo para eliminar
                if (data.success) {
                    toastr.error(data.message, '🗑️ ¡Eliminado!');
                    // Recargar la tabla después de un breve delay
                    setTimeout(() => {
                        $('#usuarios').DataTable().ajax.reload();
                    }, 500);
                } else {
                    toastr.error(data.message, '❌ ¡Error!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Error al procesar la solicitud.', '❌ ¡Error!');
            });
        });

        // ==================== CONFIGURACIÓN TOAST ====================
        $(document).ready(function() {
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

            // 🟢 CREAR - Verde
            @if(session('created'))
                toastr.success('{{ session('created') }}', '🆕 ¡Creado!');
            @endif

            // 🔵 EDITAR/ACTUALIZAR - Azul
            @if(session('updated'))
                toastr.info('{{ session('updated') }}', '✏️ ¡Actualizado!');
            @endif

            // 🔴 ELIMINAR - Rojo
            @if(session('deleted'))
                toastr.error('{{ session('deleted') }}', '🗑️ ¡Eliminado!');
            @endif

            // ⚠️ ADVERTENCIA - Amarillo
            @if(session('warning'))
                toastr.warning('{{ session('warning') }}', '⚠️ ¡Advertencia!');
            @endif

            // ❌ ERROR - Rojo oscuro
            @if(session('error'))
                toastr.error('{{ session('error') }}', '❌ ¡Error!');
            @endif

            // ✅ ÉXITO GENERAL - Verde
            @if(session('success'))
                toastr.success('{{ session('success') }}', '✅ ¡Éxito!');
            @endif
        });
        // ==============================================================
    </script>


@stop
