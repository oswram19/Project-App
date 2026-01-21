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

            <!-- Toast de notificación -->
            <div class="toast" id="deleteToast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 300px;" data-delay="4000">
                <div class="toast-header" id="toastHeader">
                    <i class="fas fa-check-circle mr-2" id="toastIcon"></i>
                    <strong class="mr-auto" id="toastTitle">Notificación</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body" id="toastMessage">
                    <!-- Mensaje dinámico -->
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
                // Mostrar toast con el mensaje y color
                showToast(data.message, data.success ? 'delete' : 'error');
                if (data.success) {
                    // Recargar la tabla después de un breve delay
                    setTimeout(() => {
                        $('#usuarios').DataTable().ajax.reload();
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error al procesar la solicitud.', 'error');
            });
        });

        function showToast(message, type) {
            const toastHeader = document.getElementById('toastHeader');
            const toastIcon = document.getElementById('toastIcon');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');
            
            // Limpiar clases anteriores
            toastHeader.classList.remove('bg-success', 'bg-danger', 'bg-primary', 'bg-info', 'text-white');
            toastIcon.classList.remove('fa-check-circle', 'fa-times-circle', 'fa-trash-alt', 'fa-user-plus');
            
            if (type === 'delete') {
                // Rojo para eliminar
                toastHeader.classList.add('bg-danger', 'text-white');
                toastIcon.classList.add('fa-trash-alt');
                toastTitle.textContent = 'Eliminado';
            } else if (type === 'create') {
                // Azul para agregar/crear
                toastHeader.classList.add('bg-primary', 'text-white');
                toastIcon.classList.add('fa-user-plus');
                toastTitle.textContent = '¡Usuario Creado!';
            } else if (type === 'success') {
                // Verde para éxito general
                toastHeader.classList.add('bg-success', 'text-white');
                toastIcon.classList.add('fa-check-circle');
                toastTitle.textContent = '¡Éxito!';
            } else {
                // Rojo para error
                toastHeader.classList.add('bg-danger', 'text-white');
                toastIcon.classList.add('fa-times-circle');
                toastTitle.textContent = 'Error';
            }
            
            toastMessage.textContent = message;
            $('#deleteToast').toast('show');
        }

        // Mostrar toast si hay mensaje de sesión al cargar la página
        $(document).ready(function() {
            @if(session('success'))
                showToast('{{ session('success') }}', 'create');
            @endif
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>


@stop
