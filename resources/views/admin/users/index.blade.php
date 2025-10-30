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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
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
            responsive: true,
            autoWidth: true
        });
    </script>

    
@stop
