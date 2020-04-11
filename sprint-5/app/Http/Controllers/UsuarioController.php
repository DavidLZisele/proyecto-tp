<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Amigos;
use Illuminate\Support\Facades\Storage;
class UsuarioController extends Controller
{
    protected function updateDatos(User $usuario)
    {
        
        request()->validate([
            "universidad"=> 'string|required',
            "ciudad"=> 'string|required',
            "relacion"=> 'string|required',
            "escuela"=> 'string|required',
            "fecha_cumpleanios"=> 'date|required',
            "email"=> 'email|required|unique:users'
        ]);
        $usuario->email = request()->email;
        $usuario->universidad = request()->universidad;
        $usuario->escuela = request()->escuela;
        $usuario->relacion = request()->relacion;
        $usuario->ciudad = request()->ciudad;
        $usuario->fecha_cumpleanios = request()->fecha_cumpleanios;
        $usuario->update();
            return redirect()->route('categoria.index');
    }
    protected function updatePassword(User $usuario)
    {
       if(password_verify(request()->password1,$usuario->password) && request()->password2 == request()->password3 && strlen(request()->password2)>=8)
       {
        
        $usuario->password = password_hash(request()->password2,PASSWORD_DEFAULT);
        $usuario->update();
            return redirect()->route('categoria.index');
       } else 
       {
           return redirect()->route('datos.index')->with('status',"Error al cambiar la password");
       }       
    }
    protected function index()
    {
        return view('datosUsuario');
    }
    protected function updateFoto(User $usuario)
    {
           request()->validate([
            'cambiar-foto'=> 'mimes:rpg,jpg,jpeg|required'
        ]);
        Storage::delete('public/'.$usuario->photo);
        $usuario->update([
            'photo'=>basename(request()->file('cambiar-foto')->store('public'))
        ]);
        return redirect()->route('categoria.index');
    
       
    }
    protected function insertSolicitud(User $usuario)
    {
        $amigo = User::where("email","=",request()->amigo)->get();
        if($amigo->isNotEmpty())
        {
            $sol1 = Amigos::where('id_amigo',"=", $amigo->first()->id)->where('id_user',"=",$usuario->id)->get();
            $sol2 = Amigos::where('id_user',"=", $amigo->first()->id)->where('id_amigo',"=",$usuario->id)->get();
            if($sol1->isEmpty() && $sol2->isEmpty())
          {
             Amigos::create([
                 "id_user"=> $usuario->id,
                 "id_amigo"=>$amigo->first()->id,
                 "respuesta"=>3
             ]);
            return redirect()->route('categoria.index')->with('aceptado',"Se mando solicitud correctamente");
          } else 
          {
            return redirect()->route('categoria.index')->with('rechazado',"Error!, es amigo o solicitud en curso");
          }

        }else 
        {
            return redirect()->route('categoria.index')->with('rechazado',"No se encontro ese usuario");
        } 
    }
    protected function agregarAmigo(User $usuario)
    {

        if(isset(request()->aceptar))
        {
            $sol = Amigos::where('id_user',"=", request()->aceptar)->where('id_amigo',"=",$usuario->id)->get();
            
            $sol->first()->update([
                "respuesta"=>1
            ]);
            return redirect()->route('categoria.index')->with('aceptado','Se ha agregado correctamente');
        } else 
        {
            $sol = Amigos::where('id_user',"=", request()->rechazar)->where('id_amigo',"=",$usuario->id)->get();
            $sol->first()->delete();
            return redirect()->route('categoria.index')->with('rechazado','Se ha eliminado correctamente');
        }
        
    }
}
