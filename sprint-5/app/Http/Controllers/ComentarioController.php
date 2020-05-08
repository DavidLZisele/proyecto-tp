<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comentario;
class ComentarioController extends Controller
{
    protected function store()
    {
        request()->validate([
            'comentario'=> 'required'
        ]);
        Comentario::create([
            'descripcion'=>request()->comentario,
            'id_posteo'=>request()->id_posteo,
            'id_user'=>request()->id_user
        ]);
        return redirect()->route('categoria.index');
    }
    protected function destroy(Comentario $comentario)
    {
        $comentario->delete();
        return redirect()->route('categoria.index');
    }
    protected function update(Comentario $comentario)
    {
        request()->validate([
            'comentario'=> 'required'
        ]);
        $comentario->update([
            'descripcion'=>request()->comentario,
        ]);
        return redirect()->route('categoria.index');
    }
}
