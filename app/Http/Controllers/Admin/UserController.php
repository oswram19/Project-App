<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregar el uso del modelo Role
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $users = User::all();
        return view('admin.users.index', compact('users'));
        //return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        $roles=Role::all(); //se obtienen todos los roles disponibles en el sistema


        //la ruta que busca es resource/view/admin/users/edit.blade.php
        return view('admin/users/edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $user->roles()->sync($request->roles);//sincroniza los roles seleccionados en el formulario con los roles del usuario
        return redirect()->route('admin.users.edit', $user)->with('success', 'roles asignados correctamente');//redirecciona a la pagina de edicion con un mensaje de exito
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
