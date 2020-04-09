<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    function index()
    {
        $categorias = Categoria::all();
        return view('perfil',compact("categorias"));
    }
}
