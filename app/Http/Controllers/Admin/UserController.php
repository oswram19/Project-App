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
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente');
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
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', 'Error al eliminar el usuario');
        }
    }

    /**
     * Show the form for editing user data.
     */
    public function editData(User $user)
    {
        return view('admin.users.edit-data', compact('user'));
    }

    /**
     * Update user data in storage.
     */
    public function updateData(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Datos del usuario actualizados correctamente');
    }
}
