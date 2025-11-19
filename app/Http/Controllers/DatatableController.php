<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class DatatableController extends Controller
{
    //aqui se rescatan todos los datos de los usuarios para el datatable ajax
    public function user()
    {
        //
        $users=User::select('id','name','email','created_at')->get();
        return datatables()->of($users)->toJson();
    }

    //datos de categorías para datatable ajax
    public function category()
    {
        $categories = Category::select('id','name','description','created_at')->get();
        return datatables()->of($categories)->toJson();
    }
}
