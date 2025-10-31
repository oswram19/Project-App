@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>asignar un rol.</h1>

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
        <div class="card-body">
            <p class ="h5">Nombre:</p>
            <p class ="form-control">{{ $user->name }}</p>

            <h2 class="h5">Asignar Roles:</h2>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                @foreach ($roles as $role)
                    <div>
                        <label>
                            <input type="checkbox" 
                                   name="roles[]" 
                                   value="{{ $role->id }}"
                                   {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                   class="mr-1">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary mt-3"  >Asignar roles</button>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Estilos CSS adicionales si los necesitas --}}
@stop

@section('js')
    <script>
        console.log("sin errores");
    </script>
@stop
