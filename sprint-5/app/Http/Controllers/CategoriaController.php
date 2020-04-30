<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Posteo;
use Auth;
class CategoriaController extends Controller
{
    protected function index()
    {
        $categorias = Categoria::all();
        if(Auth::user()->admin != 1)
        {   
            return view('perfil',compact("categorias"));
        } else 
        {
            $posteosall = Posteo::all();
            $posteosall = $posteosall->sortByDesc('updated_at');
            return view('perfil',compact(["categorias", "posteosall"]));
        }
      
    }
    protected function store()
    {
            $cat = Categoria::create([
                'descripcion' => request()->descripcion
            ]);
            return redirect()->route('categoria.index')->with('subida', "Se registro la categoria ".$cat->descripcion);  
    }
    protected function destroy()
    {
        $cat = Categoria::find(request()->tipopublicacion);
        $cat->delete();
        return redirect()->route('categoria.index')->with('eliminada', "Se elimino la categoria ".$cat->descripcion);
    }
}
