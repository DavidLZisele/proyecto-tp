<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Posteo;
use Illuminate\Support\Facades\Storage;
class PosteoController extends Controller
{
    protected function store(User $usuario)
    {
        request()->validate([
            'publicacion'=> 'required',
            'fotopublic'=> 'mimes:jpg,jpeg,png'
        ]);
        if(isset(request()->fotopublic))
        {
            Posteo::create([
                'descripcion'=>request()->publicacion,
                'foto'=>basename(request()->file('fotopublic')->store('public')),
                'id_categoria'=>request()->tipopublicacion,
                'id_user'=>$usuario->id
            ]);
        }
        Posteo::create([
            'descripcion'=>request()->publicacion,
            'id_categoria'=>request()->tipopublicacion,
            'id_user'=>$usuario->id,
            'foto'=>"",
        ]);
        return redirect()->route('categoria.index')->with('posteada',"Se ha registrado tu publicacion");
    }
    protected function destroy()
    {
        $pos = Posteo::find(request()->borrarpublicacion);
        $pos->delete();
        return redirect()->route('categoria.index')->with('eliminadoposteo',"Se ha eliminado la publicacion");
    }
    protected function edit(Posteo $posteo)
    {
        return view('datosPub', compact("posteo"));
    }
    protected function update(Posteo $posteo)
    {
   
    request()->validate([
        'contenido'=>'required',
        'fotopub'=> 'mimes:jpg,jpeg,png'
    ]);
       if(isset(request()->fotopub)){
        Storage::delete('public/'.$posteo->foto);
        $posteo->update([
            'descripcion'=>request()->contenido,
            'foto'=> basename(request()->file('fotopub')->store('public'))
          ]);
       }else 
       {
        $posteo->update([
            'descripcion'=>request()->contenido,
            'foto'=> ""
          ]);
       }
       return redirect()->route('categoria.index')->with('posact','Se ha actualizado la publicacion');
    }
}
