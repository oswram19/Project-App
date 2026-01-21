<?php

namespace App\Http\Controllers;

use App\Mail\ContactanosMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactanosController extends Controller
{
    public function index()
    {
        return view('contactanos.index');
    }
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'mensaje' => 'required|string',
            'archivo' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif,txt,xlsx,xls',
        ]);
        
        // Manejar el archivo adjunto
        $archivoPath = null;
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoPath = $archivo->store('contactanos_attachments', 'public');
        }
        
        // Validar los datos del formulario
       Mail::to('oswaldo@ozmag.com')
            ->send(new ContactanosMailable($request->all(), $archivoPath));
       
            return redirect()->route('contactanos.index')->with('success', 'Tu mensaje ha sido enviado correctamente.');
       
 
    }
}
