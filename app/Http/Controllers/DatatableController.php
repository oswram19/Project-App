<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;    

class DatatableController extends Controller
{
    //aqui se rescatan todos los datos de los usuarios para el datatable ajax
    public function user()
    {
        //
        $users=User::select('id','name','email','created_at')->get();
        return datatables()->of($users)->toJson();
    }
}
