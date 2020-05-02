<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Posteo;
use Auth;
use App\User;
class CategoriaController extends Controller
{
    protected function index()
    {
        $usuario = Auth::user();
        $usuariosValidos = []; 
        if(Auth::user()->ciudad != "")
        {
                
            $usuarios = User::where("ciudad","=", $usuario->ciudad)->where("id","!=",$usuario->id)->get();
            foreach($usuarios as $user)
            {  
                    $resp1 = false;
                    $resp2 = false;
                    $resp3 = false;
                    $resp4 = false;
                    foreach($usuario->amigosMiSolicitud as $amigo)
                    {
                        
                    if($user->id == $amigo->id){
                        $resp1 = true;
                        break;
                        }
                    }
                foreach($usuario->amigosSuSolicitud as $amigo)
                    {
                        if($user->id == $amigo->id){
                        $resp2 = true;
                        break;
                        }
                    }
                foreach($usuario->miSolicitudes as $amigo)
                    {
                    if($user->id == $amigo->id){
                        $resp3 = true;
                        break;
                    }
                    }
                foreach($usuario->envioSolicitudes as $amigo)
                    {
                    if($user->id == $amigo->id){
                        $resp4 = true;
                        break;
                        }
                    }
                if(!$resp1 && !$resp2 && !$resp3 &&!$resp4)
                {
                    $usuariosValidos[] = $user;
                }
              }
            }  
        $usuarios = collect($usuariosValidos);
        $categorias = Categoria::all();
        if(Auth::user()->admin != 1)
        {   
            return view('perfil',compact(["categorias","usuarios"]));
        } else 
        {
            $posteosall = Posteo::all();
            $posteosall = $posteosall->sortByDesc('updated_at');
            return view('perfil',compact(["categorias", "posteosall", "usuarios"]));
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
