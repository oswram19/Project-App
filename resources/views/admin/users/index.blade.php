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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
                        return `
                            <a href="/admin/users/${row.id}/edit-data" 
                               class="btn btn-sm btn-action btn-edit" 
                               data-toggle="tooltip" 
                               data-placement="top" 
                               title="Editar datos de ${row.name}"> 
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="/admin/users/${row.id}/edit" 
                               class="btn btn-sm btn-action btn-roles" 
                               data-toggle="tooltip" 
                               data-placement="top" 
                               title="Asignar roles a ${row.name}"> 
                                <i class="fas fa-user-tag"></i> Roles
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-action btn-delete" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Eliminar usuario ${row.name}"
                                    onclick="deleteUser(${row.id}, '${row.name}')">
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

        function deleteUser(userId, userName) {
            if (confirm(`¿Estás seguro de eliminar al usuario ${userName}?`)) {
                // Crear formulario dinámicamente
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}`;
                
                // Token CSRF
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Method DELETE
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
