@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Proyecto de Oswaldo R.</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bienvenido al Panel de Administración</h3>
        </div>
        <div class="card-body">
            <p>Panel de administración con AdminLTE</p>
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
