<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ], [
            'roles.required' => 'Debe asignar al menos un rol al usuario.',
            'roles.min' => 'Debe asignar al menos un rol al usuario.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->roles()->sync($request->roles);

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
            // Verificar que no se elimine a sí mismo
            if (auth()->id() === $user->id) {
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'No puedes eliminarte a ti mismo']);
                }
                return redirect()->route('admin.users.index')->with('error', 'No puedes eliminarte a ti mismo');
            }

            DB::beginTransaction();
            
            // Eliminar invitaciones de equipos del usuario
            DB::table('team_invitations')->where('email', $user->email)->delete();
            
            // Eliminar miembros de equipos que el usuario posee
            DB::table('team_user')->whereIn('team_id', function($query) use ($user) {
                $query->select('id')->from('teams')->where('user_id', $user->id);
            })->delete();
            
            // Eliminar equipos que el usuario posee (personal team)
            $user->ownedTeams()->delete();
            
            // Desvincular de equipos donde es miembro
            $user->teams()->detach();
            
            // Eliminar roles asignados
            $user->roles()->detach();
            
            // Eliminar permisos directos si existen
            $user->permissions()->detach();
            
            // Eliminar tokens de API
            $user->tokens()->delete();
            
            // Eliminar el usuario
            $user->delete();
            
            DB::commit();
            
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente']);
            }
            return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error al eliminar el usuario: ' . $e->getMessage()], 500);
            }
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
