@extends('adminlte::page')

@section('title', 'usuario')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}?v={{ filemtime(public_path('css/admin-custom.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/contactanos.css') }}?v={{ filemtime(public_path('css/contactanos.css')) }}">
    <style>
        #usuarios tbody tr { cursor: pointer; }
    </style>
@endsection
@section('content_header')
    <h1>lista de usuarios</h1>

@stop

@section('content')

    <!-- Panel de acciones externas -->
    <div class="card mb-2">
        <div class="card-body py-2">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <span class="mr-2 text-muted" id="selectedUserLabel"><i class="fas fa-user mr-1"></i> Ningún usuario seleccionado</span>
                <div class="ml-auto d-flex flex-wrap" style="gap:6px;">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-action btn-create btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </a>
                    <a id="btnEditar" href="#" class="btn btn-sm btn-action btn-edit disabled" aria-disabled="true">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a id="btnRoles" href="#" class="btn btn-sm btn-action btn-roles disabled" aria-disabled="true">
                        <i class="fas fa-user-tag"></i> Roles
                    </a>
                    <button id="btnEliminar" type="button" class="btn btn-sm btn-action btn-delete" disabled>
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Usuarios</h3>
        </div>
        <div class="card-body">

            <table class="table table-striped table-hover" id="usuarios">
                <thead>
                    <tr>
                        <th style="width:30px;"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>correo</th>
                        <th>Incorporación</th>
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

    <div class="contactanos-splashed is-empty" id="usersSplashed">
        <div class="toast-panel">
            <div class="toast-item" id="usersToastItem">
                <div class="toast success" id="usersToastBox">
                    <label class="close" id="usersToastClose"></label>
                    <h3 id="usersToastTitle">Éxito</h3>
                    <p id="usersToastMessage">Operación completada correctamente.</p>
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
        const usersToastContainer = document.getElementById('usersSplashed');
        const usersToastBox = document.getElementById('usersToastBox');
        const usersToastTitle = document.getElementById('usersToastTitle');
        const usersToastMessage = document.getElementById('usersToastMessage');
        const usersToastClose = document.getElementById('usersToastClose');
        let usersToastTimer = null;

        function hideUsersToast() {
            if (usersToastTimer) {
                clearTimeout(usersToastTimer);
                usersToastTimer = null;
            }

            if (usersToastContainer) {
                usersToastContainer.classList.add('is-empty');
            }
        }

        function showUsersToast(type, title, message) {
            if (!usersToastContainer || !usersToastBox) return;

            const normalizedType = ['success', 'warning', 'error', 'help', 'info'].includes(type) ? type : 'success';
            usersToastBox.classList.remove('help', 'info', 'success', 'warning', 'error');
            usersToastBox.classList.add(normalizedType);

            if (usersToastTitle) {
                usersToastTitle.textContent = title || 'Notificación';
            }

            if (usersToastMessage) {
                usersToastMessage.textContent = message || '';
            }

            if (usersToastTimer) {
                clearTimeout(usersToastTimer);
            }

            usersToastContainer.classList.remove('is-empty');
            usersToastTimer = setTimeout(hideUsersToast, 4500);
        }

        if (usersToastClose) {
            usersToastClose.addEventListener('click', function() {
                hideUsersToast();
            });
        }

        let selectedUser = { id: null, name: '' };

        function updateActionButtons() {
            const hasSelection = selectedUser.id !== null;
            const label = document.getElementById('selectedUserLabel');

            if (hasSelection) {
                label.innerHTML = `<i class="fas fa-user-check mr-1 text-success"></i> <strong>${selectedUser.name}</strong> seleccionado`;
                $('#btnEditar').removeClass('disabled').attr('aria-disabled', 'false')
                    .attr('href', `/admin/users/${selectedUser.id}/edit-data`);
                $('#btnRoles').removeClass('disabled').attr('aria-disabled', 'false')
                    .attr('href', `/admin/users/${selectedUser.id}/edit`);
                $('#btnEliminar').prop('disabled', false);
            } else {
                label.innerHTML = `<i class="fas fa-user mr-1"></i> Ningún usuario seleccionado`;
                $('#btnEditar').addClass('disabled').attr('aria-disabled', 'true').attr('href', '#');
                $('#btnRoles').addClass('disabled').attr('aria-disabled', 'true').attr('href', '#');
                $('#btnEliminar').prop('disabled', true);
            }
        }

        new DataTable('#usuarios', {
            ajax: '/datatable/users', //ruta creada en web.php
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="radio" name="userSelect" class="user-radio" value="${row.id}"
                                    data-name="${row.name.replace(/"/g, '&quot;')}" style="cursor:pointer;">`;
                    }
                },
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'created_at' }
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
                $('[data-toggle="tooltip"]').tooltip();
                // Restaurar selección visual si el usuario sigue en la página actual
                if (selectedUser.id !== null) {
                    $(`input.user-radio[value="${selectedUser.id}"]`).prop('checked', true)
                        .closest('tr').addClass('table-active');
                }
            }
        });

        // Seleccionar usuario al hacer clic en la fila o en el radio
        $(document).on('click', '#usuarios tbody tr', function() {
            const radio = $(this).find('input.user-radio');
            if (radio.length) {
                radio.prop('checked', true);
                $('#usuarios tbody tr').removeClass('table-active');
                $(this).addClass('table-active');
                selectedUser.id   = radio.val();
                selectedUser.name = radio.data('name');
                updateActionButtons();
            }
        });

        // Botón eliminar externo
        $('#btnEliminar').on('click', function() {
            if (!selectedUser.id) return;
            document.getElementById('userNameSpan').textContent = selectedUser.name;
            $('#deleteModal').modal('show');
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            const userId = selectedUser.id;
            const userName = selectedUser.name;
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
                if (data.success) {
                    showUsersToast('error', 'Eliminado', data.message);
                    selectedUser = { id: null, name: '' };
                    updateActionButtons();
                    // Recargar la tabla después de un breve delay
                    setTimeout(() => {
                        $('#usuarios').DataTable().ajax.reload();
                    }, 500);
                } else {
                    showUsersToast('error', 'Error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showUsersToast('error', 'Error', 'Error al procesar la solicitud.');
            });
        });

        $(document).ready(function() {
            // Inicializar tooltips de Bootstrap
            $('[data-toggle="tooltip"]').tooltip();

            updateActionButtons();

            @if(session('deleted'))
                showUsersToast('error', 'Eliminado', @json(session('deleted')));
            @elseif(session('created'))
                showUsersToast('success', 'Creado', @json(session('created')));
            @elseif(session('updated'))
                showUsersToast('info', 'Actualizado', @json(session('updated')));
            @elseif(session('warning'))
                showUsersToast('warning', 'Advertencia', @json(session('warning')));
            @elseif(session('error'))
                showUsersToast('error', 'Error', @json(session('error')));
            @elseif(session('success'))
                showUsersToast('success', 'Éxito', @json(session('success')));
            @endif
        });
    </script>


@stop
