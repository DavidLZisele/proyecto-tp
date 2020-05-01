@extends('layouts.head')
@section('funciones')
<?php
 $usuario = Auth::user();
 
 $amigos = [];
  foreach($usuario->amigosMiSolicitud as $amigo)
  {
    $amigos[] = $amigo;
  }
  foreach($usuario->amigosSuSolicitud as $amigo)
  {
    $amigos[] = $amigo;
  }
  $posteos = [];
  foreach ($amigos as $amigo) {
    foreach($amigo->posteos as $posteo)
    {
      $posteos[] = $posteo;
    }
  }
  foreach ($usuario->posteos as $posteo) {
    $posteos[] = $posteo;
  }
  $posteos = collect($posteos)->sortByDesc('updated_at');
  function buscarPosteoAmigo($posteo_id, $amigos)
  {
      foreach($amigos as $amigo)
      {
        if($amigo->id == $posteo_id)
        {
          return $amigo;
        }
      }
      return null;     
  }
  function buscarLike($posteo,$usuario)
  {
    foreach($posteo->likes as $like)
    {
      if($like->id_user == $usuario->id)
      {
        return $like;
      }
    }
    return null;
  }
?>
@endsection
@section('title')
Perfil
@endsection

@section('content')
  <div class="container col-12 contenedor-perfil">
    <header class = "header-perfil col-12">
      <ul class="nav nav-pills col-8">
        <li class="nav-item dropdown">  
            <a class="nav-link socialperfil" href="#" title="Noticias">Social</i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Noticias"><i class="fa fa-globe"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Configuracion"><i class="fa fa-user"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Mensajes"><i class="fa fa-envelope"></i></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
            aria-expanded="false" title="Notificaciones"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Estado: {{$usuario->strikes}} Strikes</a>
          </div>
        </li>
      </ul>
      <ul class="nav nav-pills col-4 justify-content-end">
        <li class="nav-item">
        <a class="nav-link" href="{{route('datos.index')}}" title="Configuracion cuenta"><i class="fa fa-cog"></i></a>
        </li>
        <li class="nav-item li-salir">
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        </li>
      </ul>
    </header>
     <section class="seccion-perfil col-12">
       <div class="col-lg-3">  
        <article class="informacion">
       
            <div class="bloke-imagen-perfil">
              <img src="/storage/{{$usuario->photo}}" alt="foto">
            </div>
            <div class="bloke-info col-12">
             <div class="datosusuario-bloque">
              @if(isset($usuario->escuela))
              <div class="col-12">
                    <a href="" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
          </a>
                    <p class="col-10">{{$usuario->escuela}}</p>
              </div>
              @else
                <div class="col-12">
                    <a href="" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
          </a>
                    <p class="col-10">Escuela</p>
              </div>
              @endif
              @if(isset($usuario->universidad))
                  <div class="col-12">
                    <a href="" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
          </a>
                      <p class="col-10">{{$usuario->universidad}}</p>
                  </div>
              @else
                <div class="col-12">
                    <a href="" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
          </a>
                    <p class="col-10">Universidad</p>
                  </div>
              @endif
              @if(isset($usuario->relacion))
                <div class="col-12">
                    <a href="" class="col-2 a-datosusuario"><i class="fa fa-heart" aria-hidden="true"></i>
          </a>
                    <p class="col-10">{{$usuario->relacion}}</p>
                 </div>
                @else
                  <div class="col-12">
                    <a href="" class="col-2 a-datosusuario"><i class="fa fa-heart" aria-hidden="true"></i>
          </a>
                    <p class="col-10">Relacion</p>
                 </div>
                 @endif
           </div>
           @if(isset($usuario->ciudad))
            <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-map-marker" aria-hidden="true"></i>
          </a>
              <p class="col-10">{{$usuario->ciudad}}</p>
            </div>
            @else
              <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-map-marker" aria-hidden="true"></i>
          </a>
              <p class="col-10">Ciudad</p>
            </div>
           @endif
            @if(isset($usuario->fecha_cumpleanios))
            <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-birthday-cake"></i></a>
              <p class="col-10">{{$usuario->fecha_cumpleanios}}</p>
            </div>
             @else
              <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-birthday-cake"></i></a>
              <p class="col-10">Cumpleaños</p>
            </div>
             @endif
            </div>
          </article>
        <article class="mis-perfil">
          <div class="rounded w3-card w3-round">
            <div class="w3-white">
              <button onclick="myFunction('Demo1')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Mis Grupos</button>
              <div id="Demo1" class="w3-hide w3-container">
                <p>...</p>
              </div>
              <button onclick="myFunction('Demo4')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> Mis Amigos</button>
              <div id="Demo4" class="w3-hide w3-container">
                @foreach($amigos as $amigo)
                <p class="p-amigo" class="col-12">
                <img src="/storage/{{$amigo->photo}}" alt="">
                  {{$amigo->name}} {{$amigo->surname}}
                </p>
                @endforeach
              </div>
              <button onclick="myFunction('Demo2')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> Mis Eventos</button>
              <div id="Demo2" class="w3-hide w3-container">
                <p>...</p>
              </div>
               <div id="Demo2" class="w3-hide w3-container">
                <p>...</p>
              </div>
              <button onclick="myFunction('Demo3')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-camera fa-fw w3-margin-right"></i> Mis Fotos</button>
              <div id="Demo3" class="w3-hide w3-container">
             <div class="w3-row-padding">
             <br>
               <div class="w3-half">
                 <img src="" style="width:100%" class="w3-margin-bottom">
               </div>
             </div>
              </div>
            </div>
              </div>
        </article>

       </div>
      <div class="col-lg-5">
        <article class="publicacion-perfil">
          @if($usuario->admin != 1)
        <form action="{{route('datos.insertPos',$usuario)}}" method ="post" enctype="multipart/form-data" id="form-insertPos">
             @csrf
              <input type="text" name="publicacion" class="publicacion form-control @error('publicacion') is-invalid @enderror" placeholder="Estado">
              @error('publicacion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
              @enderror
              <br>
              <br>
               <label for="tipopublicacion">Categoria</label>
               <select name="tipopublicacion" id="tipopublicacion">
                 @foreach($categorias as $cat)
                  <option value="{{$cat->id}}">
                      {{$cat->descripcion}}
                  </option>
                 @endforeach
               </select>
               <div class="div-subirfoto">
                  <span>
                  <i class="fa fa-camera" aria-hidden="true"></i> Subir imagen
                  </span>
                  <input type="file" name="fotopublic" id="fotopublic" class="form-control @error('fotopublic') is-invalid @enderror">
                  @error('fotopublic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                 @enderror
               </div>
              <br>
              <button type="submit" name ="subir-publicacion"> <i class="fa fa-pencil"></i> Publicar</button>
               @if(session('eliminada'))
                <span style="color:red;font-size:13px">
                  {{session('eliminada')}}
                </span>
                @endif
                @if(session('subida'))
                 <span style="color:green;font-size:13px">
                   {{session('categoria')}}
                 </span>
                 @endif
            </form>
            @else
            <form action="{{route('categoria.store')}}" method ="post">
              @csrf
               <input type="text" name="descripcion" class="publicacion form-control" placeholder="Categoria">
               <br>
               <button type="submit" name ="subircat">Subir</button>
               @if(session('subida'))
               <span style="color:green;font-size:13px">
                 {{session('subida')}}
               </span>
               @endif
               <br>
               <br>
            </form>
            <form action="{{route('categoria.destroy')}}" method = "post">
                @csrf
                @method("delete")
                <label for="tipopublicacion">Categoria</label>
                <select name="tipopublicacion" id="tipopublicacion">
                  @foreach($categorias as $cat)
                   <option value="{{$cat->id}}">
                       {{$cat->descripcion}}
                   </option>
                  @endforeach
                </select>
                <button type="submit" name ="eliminarcat">Eliminar</button>  
                <br>   
                @if(session('eliminada'))
                 <span style="color:red;font-size:13px">
                   {{session('eliminada')}}
                 </span>
                 @endif       
             </form>
            @endif
       </article>
       <article class="publicaciones-perfil"> 
         @if($usuario->admin != 1)
         @foreach($posteos as $posteo)
           @if($posteo->id_user == $usuario->id)
            <div class="pp col-12">
            <div class="user-public col-2 col-md-2 col-lg-3">
              <img src="/storage/{{$usuario->photo}}" alt="">
            </div>
            <p class="col-9 col-lg-6">
              {{$usuario->name}}
            </p>
          <form action="{{route('datos.deletePos')}}" method="post" class="col-1" id="form-eliminarPos">
              @csrf 
              @method('delete')
            <button type="submit" name ="borrarpublicacion" class="borrar-public" title="Borrar publicacion" value="{{$posteo->id}}">  <i class="fa fa-times" aria-hidden="true"></i></button>
            </form>
          </div>
           <p class="texto-publicacion">
            {{$posteo->descripcion}}
           </p>
           @if(strlen($posteo->foto)!=0)
           <div class="imagen-public">
           <img src="storage/{{$posteo->foto}}" alt="no se encontro la foto">
           </div>
           @endif
           <div class="interaccion-publicacion">
            @if(buscarLike($posteo,$usuario) == null)
            <form action="{{route('like.store')}}" method="POST" class="form-like-comentar">
             @csrf
                    <input type="hidden" name="iduser" value="{{$usuario->id}}">
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      <button type="submit" name ="crearlike" class="megusta" style="width: 25px"></button>
                    </div>
                     <div class="div-comentar">
                      <i class="fa fa-comment-o" aria-hidden="true"></i>
                      <button type="button" name="comentar" style="width: 25px"> </button>
                     </div>
                     
              </form>
              @else 
             <form action="{{route('like.destroy',buscarLike($posteo,$usuario))}}" method="POST" class="form-like-comentar">
               @csrf 
               @method('delete')
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <i class="fa fa-heart heart-red" aria-hidden="true" style="color:red"></i>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      <button type="submit" name ="crearlike" class="megusta" style="width: 25px"></button>
                    </div>
                    <div class="div-comentar">
                      <i class="fa fa-comment-o" aria-hidden="true"></i>
                      <button type="button" name="comentar" style="width: 25px"> </button>
                     </div>
              </form>
              @endif    
           </div>
           <form action="{{route('datos.editPos',$posteo)}}" method="GET" class="editar-publicacion-form">
            @csrf 
               <button type="submit" style="border:0;background-color:white"><i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
             </form> 
             <div class="separar">

             </div>
             @else
            <div class="pp col-12">
            <div class="user-public col-2 col-md-2 col-lg-3">
              <img src="storage/{{buscarPosteoAmigo($posteo->id_user,$amigos)->photo}}" alt="">
            </div>
            <p class="col-9 col-lg-6">
              {{buscarPosteoAmigo($posteo->id_user,$amigos)->name}}
          </p>
            <form action="perfil.php" method="post" class="col-1">
            </form>
          </div>
           <p class="texto-publicacion">
            {{$posteo->descripcion}}
           </p>
            @if(strlen($posteo->foto)!=0)
           <div class="imagen-public">
           <img src="storage/{{$posteo->foto}}" alt="no se encontro la foto">
           </div>
           @endif
           <div class="interaccion-publicacion separar">
            @if(buscarLike($posteo,$usuario) == null)
            <form action="{{route('like.store')}}" method="POST" class="form-like-comentar">
             @csrf
                    <input type="hidden" name="iduser" value="{{$usuario->id}}">
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      <button type="submit" name ="crearlike" class="megusta" style="width: 25px"></button>
                    </div>
                     <div class="div-comentar">
                      <i class="fa fa-comment-o" aria-hidden="true"></i>
                      <button type="button" name="comentar" style="width: 25px"> </button>
                     </div>
                     
              </form>
              @else 
             <form action="{{route('like.destroy',buscarLike($posteo,$usuario))}}" method="POST" class="form-like-comentar">
               @csrf 
               @method('delete')
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <i class="fa fa-heart heart-red" aria-hidden="true" style="color:red"></i>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      <button type="submit" name ="crearlike" class="megusta" style="width: 25px"></button>
                    </div>
                    <div class="div-comentar">
                      <i class="fa fa-comment-o" aria-hidden="true"></i>
                      <button type="button" name="comentar" style="width: 25px"> </button>
                     </div>
              </form>
              @endif       
           </div>
         @endif
       @endforeach
       @else 
       @foreach($posteosall as $posteo)
       <div class="pp col-12">
        <div class="user-public col-2 col-md-2 col-lg-3">
          <img src="/storage/{{$posteo->usuario->photo}}" alt="">
        </div>
        <p class="col-9 col-lg-6">
          {{$posteo->usuario->name}}
        </p>
      <form action="{{route('datos.deletePos')}}" method="post" class="col-1" id="form-eliminarPos">
          @csrf 
          @method('delete')
          <button type="submit" name ="borrarpublicacion" class="borrar-public" title="Borrar publicacion" value="{{$posteo->id}}">  <i class="fa fa-times" aria-hidden="true"></i></button>
        </form>
      </div>
       <p class="texto-publicacion">
        {{$posteo->descripcion}}
       </p>
       @if(strlen($posteo->foto)!=0)
       <div class="imagen-public">
       <img src="storage/{{$posteo->foto}}" alt="no se encontro la foto">
       </div>
       @endif
       <div class="interaccion-publicacion">
        @if(buscarLike($posteo,$usuario) == null)
        <form action="{{route('like.store')}}" method="POST" class="form-like-comentar">
         @csrf
                <input type="hidden" name="iduser" value="{{$usuario->id}}">
                <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                <div class="div-megusta">
                  <i class="fa fa-heart-o" aria-hidden="true"></i>
                  <span class="span-like">
                    {{$posteo->cant_likes}}
                  </span>                 
                  <button type="submit" name ="crearlike" class="megusta" style="width: 25px"></button>
                </div>
                 <div class="div-comentar">
                  <i class="fa fa-comment-o" aria-hidden="true"></i>
                  <button type="button" name="comentar" style="width: 25px"> </button>
                 </div>
                 
          </form>
          @else 
         <form action="{{route('like.destroy',buscarLike($posteo,$usuario))}}" method="POST" class="form-like-comentar">
           @csrf 
           @method('delete')
                <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                <div class="div-megusta">
                  <i class="fa fa-heart heart-red" aria-hidden="true" style="color:red"></i>
                  <span class="span-like">
                    {{$posteo->cant_likes}}
                  </span>                 
                  <button type="submit" name ="crearlike" class="megusta" style="width: 25px"></button>
                </div>
                <div class="div-comentar">
                  <i class="fa fa-comment-o" aria-hidden="true"></i>
                  <button type="button" name="comentar" style="width: 25px"> </button>
                 </div>
          </form>
          @endif     
       </div>
       <div class="separar">

      </div>
       @endforeach
       @endif
       </article>
       
      </div>
       
       <article class="solicitudes-amistad col-11 col-lg-3">
            <h3>
              Agregar amigos
            </h3>
            <div class="sa-2 col-12">
            <form action="{{route('datos.insertSolicitud',$usuario)}}" method="POST" id="form-buscar-amigos">
              @csrf
                <input type="email" name="amigo" id ="amigo" placeholder="Ingrese mail amigo" class="buscaramigo">
                <button type="submit" name="buscaramigo" class="buscaramigo">Buscar</button>
                @if(session('rechazado'))
                <p style="color:red;font-size:15px">
                  {{session('rechazado')}}
                </p>
                @endif
                @if(session('aceptado'))
                  <p style="color:green;font-size:15px">
                    {{session('aceptado')}}
                  </p>
                @endif
              </form>
            </div>
            <h3>
              Solicitudes de amistad
            </h3>
            @foreach($usuario->miSolicitudes as $sol)
            <div class="sa col-12">
              <div class="col-3 col-lg-4 col-xl-4 foto-solicitud">
              <img src="storage/{{$sol->photo}}" alt="">
              </div>
              <p class="col-6 col-lg-3 col-xl-3">
                {{$sol->name}}
              </p>
            <form action="{{route('datos.agregarAmigo',$usuario)}}" method="POST" class="col-3 col-lg-5 col-xl-5">
              @csrf 
              @method('PUT')
              <button type="submit" name="aceptar" class="col-6 check" value="{{$sol->id}}"> <i class="fa fa-check"></i></button>
              <button type="submit" name="rechazar" class="col-6 remove" value="{{$sol->id}}"> <i class="fa fa-remove"></i></button>
              @if(session('rechazado'))
              <p style="color:red;font-size:15px">
                {{session('rechazado')}}
              </p>
              @endif
              @if(session('aceptado'))
                <p style="color:green;font-size:15px">
                  {{session('aceptado')}}
                </p>
              @endif  
            </form>
            </div>
            @endforeach
       </article>
     </section>
  </div>
  <script>
   
   // Accordion
    function myFunction(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";

      } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
      }
    }
    
    // Used to toggle the menu on smaller screens when clicking on the menu button
    function openNav() {
      var x = document.getElementById("navDemo");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else { 
        x.className = x.className.replace(" w3-show", "");
      }
    }
    window.onload = function()
    {
    document.getElementById('form-insertPos').onsubmit = function(event)
    {
        let inputs = Array.from(this.elements);
        inputs.pop();
        inputs.shift();
        let resp = false;
        for(let input of inputs)
        {
          if(input.getAttribute('name')=="publicacion")
          {
            if(input.value == "")
            {
              resp = true;
              break;
            }
          }
        }
        if(resp)
        {
          event.preventDefault();
          alert('Campo vacio');
        }
    }
    document.getElementById('form-buscar-amigos').onsubmit = function(event)
    {
        let inputs = Array.from(this.elements);
        inputs.pop();
        inputs.shift();
        let resp = false;
        for(let input of inputs)
        {
          if(input.getAttribute('name')=="amigo")
          {
            if(input.value == "")
            {
              resp = true;
              break;
            }
          }
        }
        if(resp)
        {
          event.preventDefault();
          alert('Campo vacio');
        }
    }
    document.getElementById('form-eliminarPos').onsubmit = function(event)
    {
      if(!confirm('Desea eliminarlo'))
      {
        event.preventDefault();
      }
    }
  }
    </script>
    
@endsection