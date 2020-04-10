<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
        Storage::delete('public/'.$usuario->photo);
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
        $usuario->update([
            'photo'=>basename(request()->file('cambiar-foto')->store('public'))
        ]);
        return redirect()->route('categoria.index');
    
       
    }
}
