<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactanosController extends Controller
{
    public function index()
    {
        return view('contactanos.index');
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string',
        ]);

        // Aquí puedes manejar el envío del correo electrónico o almacenar los datos en la base de datos
        // Por ejemplo, enviar un correo electrónico:
        // Mail::to('

     }
}
