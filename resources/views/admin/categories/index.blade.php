@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Categorías</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-sm btn-action btn-edit"
                                   data-toggle="tooltip" 
                                   data-placement="top" 
                                   title="Editar categoría {{ $category->name }}">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-action btn-delete"
                                            data-toggle="tooltip" 
                                            data-placement="top" 
                                            title="Eliminar categoría {{ $category->name }}"
                                            onclick="return confirm('¿Seguro de eliminar esta categoría?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay categorías disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        console.log("AdminLTE cargado correctamente");
    </script>
@stop
