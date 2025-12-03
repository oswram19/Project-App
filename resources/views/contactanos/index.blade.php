@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Contactos</h1>
    
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Contacto</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('contactanos.store') }}" method="POST">
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
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Enviar
                </button>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Estilos CSS adicionales si los necesitas --}}
@stop

@section('js')
    <script>
        console.log("AdminLTE cargado correctamente");
    </script>
@stop

