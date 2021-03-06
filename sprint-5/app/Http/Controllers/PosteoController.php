<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Posteo;
use App\Amigos;
use Auth;
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
        }else 
        {
            Posteo::create([
                'descripcion'=>request()->publicacion,
                'id_categoria'=>request()->tipopublicacion,
                'id_user'=>$usuario->id,
                'foto'=>"",
            ]);
        }
        
        return redirect()->route('categoria.index')->with('subida',"Se ha registrado tu publicacion");
    }
    protected function destroy()
    {
        $pos = Posteo::find(request()->borrarpublicacion);
        $pos->delete();
         if(Auth::user()->admin == 1)
         {
             $usuario = $pos->usuario;
             $usuario->update([
                 'strikes' => $usuario->strikes + 1
             ]);

             if($usuario->strikes >= 3)
             {
                 foreach($usuario->posteos as $posteo)
                 {
                    $posteo->delete();
                 }
                 foreach($usuario->amigosMiSolicitud as $amigo)
                 {
                    $amistad = Amigos::where("id_user", "=", $usuario->id)->where("id_amigo","=", $amigo->id)->get();
                    $amistad->first()->delete();
                 }
                 foreach($usuario->amigosSuSolicitud as $amigo)
                 {
                    $amistad = Amigos::where("id_user", "=", $amigo->id)->where("id_amigo","=", $usuario->id)->get();
                    $amistad->first()->delete();
                 }
                 foreach($usuario->miSolicitudes as $amigo)
                 {
                    $amistad = Amigos::where("id_user", "=", $amigo->id)->where("id_amigo","=", $usuario->id)->get();
                    $amistad->first()->delete();
                 }
                 foreach($usuario->envioSolicitudes as $amigo)
                 {
                    $amistad = Amigos::where("id_user", "=", $usuario->id)->where("id_amigo","=", $amigo->id)->get();
                    $amistad->first()->delete();
                 }
                 $usuario->delete();
             }
         }
        return redirect()->route('categoria.index')->with('eliminada',"Se ha eliminado la publicacion");
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
            'foto'=> $posteo->foto
          ]);
       }
       return redirect()->route('categoria.index')->with('posact','Se ha actualizado la publicacion');
    }
}
