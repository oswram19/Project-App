@extends('adminlte::page')

@section('title', 'usuario')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap4.css">
@endsection
@section('content_header')
    <h1>lista de usuarios</h1>

@stop

@section('content')
    <div class="car">
        <div class="card body">

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
        new DataTable('#usuarios', {
            ajax: '/datatable/users', //ruta creada en web.php
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <a href="/admin/users/${row.id}/edit" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>    
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
            }
        });
    </script>


@stop
