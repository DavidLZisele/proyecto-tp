<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Amigos;
use Illuminate\Support\Facades\Storage;
use App\UsuarioFoto;
use Auth;
class UsuarioController extends Controller
{
    protected function updateDatos(User $usuario)
    {
        
        isset(request()->universidad) ? $usuario->universidad = request()->universidad : $usuario->universidad = null;
        isset(request()->escuela) ? $usuario->escuela = request()->escuela: $usuario->escuela = null;
        isset(request()->relacion) ? $usuario->relacion = request()->relacion : $usuario->relacion = null;
        isset(request()->fecha_cumpleanios) ? $usuario->fecha_cumpleanios = request()->fecha_cumpleanios : $usuario->fecha_cumpleanios = null;
        $usuario->ciudad = request()->ciudades;
        $usuario->provincia = request()->provincias;
        $usuario->buscar = request()->buscar;
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
        $foto = "";
        if(!request()->foto_vieja)
        {
            request()->validate([
                'cambiar-foto'=> 'mimes:png,jpg,jpeg|required'
        ]);
        $foto = basename(request()->file('cambiar-foto')->store('public'));
            
        UsuarioFoto::create([
                    'id_user'=>$usuario->id,
                    'nombre_foto'=> $foto
        ]);
        } else 
        {
            $foto = request()->foto_vieja;
        }
       
        $usuario->update([
            'photo'=>$foto
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
            return redirect()->route('categoria.index')->with('rechazado',"Error!, es amigo o solicitud en curso o te bloqueo");
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
    public function enviarSolicitud(User $usuario)
    {
        Amigos::create([
            'respuesta' => 3,
            'id_user' => $usuario->id,
            'id_amigo'=> request()->idamigo
        ]);
        return redirect()->route('categoria.index')->with('aceptado',"Se mando solicitud correctamente");
    }
    public function eliminarAmigo()
    {
        $usuario = Auth::user();
        $amigos = Amigos::where('id_user',"=", request()->id_user)->where('id_amigo',"=",request()->id_amigo)->get();
            if($amigos->isEmpty())
            {
                $amigos= Amigos::where('id_amigo',"=", request()->id_user)->where('id_user',"=",request()->id_amigo)->get();
            }
            foreach($usuario->posteos as $posteo) 
            {
                foreach($posteo->comentarios as $comentario)
                {
                    if($comentario->id_user == $amigos->first()->id_user || $comentario->id_user == $amigos->first()->id_amigo)
                    {
                        $comentario->delete();
                    }
                }
               
            }
            if($amigos->first()->id_user == $usuario->id)
            {
                $amigo = User::find($amigos->first()->id_amigo);
            } else 
            {
                $amigo = User::find($amigos->first()->id_user);
            }
            foreach($amigo->posteos as $posteo) 
            {
                foreach($posteo->comentarios as $comentario)
                {
                    if($comentario->id_user == $amigos->first()->id_user || $comentario->id_user == $amigos->first()->id_amigo)
                    {      
                        $comentario->delete();
                    }
                }
               
            }
           
           
            $amigos->first()->delete();
        if(request()->btn_eliminar)
        {
            return redirect()->route('categoria.index')->with('aceptado',"Se elimino correctamente");
        } else 
        {
            return redirect()->route('categoria.index')->with('aceptado',"Se desbloqueo correctamente");
        }
      
    }
    public function bloquearAmigo()
    {
        $amigos = Amigos::where('id_user',"=", request()->id_user)->where('id_amigo',"=",request()->id_amigo)->get();
        if($amigos->isEmpty())
        {
            $amigos= Amigos::where('id_amigo',"=", request()->id_user)->where('id_user',"=",request()->id_amigo)->get();
        }
        $amigos->first()->update([
            'bloqueado'=> request()->id_amigo
        ]);
        return redirect()->route('categoria.index')->with('aceptado',"Se bloqueo correctamente");
    }
    public function destroy(User $usuario)
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
        foreach($usuario->fotos as $foto){
            $img = UsuarioFoto::where("id_user", "=", $usuario->id)->where("id","=", $foto->id)->get();
           $img->first()->delete();

        }
        $usuario->delete();
        return redirect()->route('home')->with('status',"Vuelva pronto, espero que haya sido grata su experiencia con nosotros");
    }
}
