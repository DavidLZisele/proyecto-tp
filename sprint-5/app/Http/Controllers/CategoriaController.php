<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
class CategoriaController extends Controller
{
    protected function index()
    {
        $categorias = Categoria::all();
        return view('perfil',compact("categorias"));
    }
}
