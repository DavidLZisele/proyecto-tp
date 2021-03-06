@extends('layouts.head')
@section('usuario')
<?php
 $usuario = Auth::user();
?>
@endsection
@section('title')
Perfil
@endsection

@section('content')
    <style>
      body{
        background: rgb(75, 87, 100);
      }
    </style>
    <div class="container contenedor-modpub col-12 div-cerrar">
    </div>
  <div class="container col-12 contenedor-perfil">
    <header class = "header-perfil col-12">
      <ul class="nav nav-pills col-8">
        <li class="nav-item dropdown">  
            <a class="nav-link socialperfil" href="#" title="Social">Social</i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https:\\www.rosario3.com" title="Noticias"><i class="fa fa-globe"></i></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{route('datos.index')}}" title="Configuracion"><i class="fa fa-user"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Mensajes"><i class="fa fa-envelope"></i></a>
        </li>
        <li class="nav-item dropdown">
          @if($usuario->strikes == 0)
          <a class="nav-link" id="a-not-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
            aria-expanded="false" title="Sanciones"><i id="atencion" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            <span id="strike-info" ><i class="fa fa-question-circle" aria-hidden="true"></i>  </span>
          </a>
          <div class="dropdown-menu" style="background-color:transparent;border:0">
            <a class="dropdown-item a-strikes-mover" style="color:white;font-weight:bold;background-color:transparent" href="#">{{$usuario->strikes}}</a>        
          </div>
          @else 
              <a class="nav-link dropdown-toggle" id="a-not-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                  aria-expanded="false" title="Sanciones"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:red"></i>
             </a>
              <div class="dropdown-menu" style="background-color:transparent;border:0">
                  <a class="dropdown-item a-strikes-mover" style="color:red;font-weight:bold;background-color:transparent" href="#">{{$usuario->strikes}}</a>        
              </div>
          @endif
        </li>
      </ul>
      <ul class="nav nav-pills col-4 justify-content-end">
        <li class="nav-item">
        <a class="nav-link" href="{{route('datos.index')}}" title="Configuracion cuenta"><i class="fa fa-cog"></i></a>
        </li>
        <li class="nav-item li-salir">
          <li class="nav-item dropdown">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" id="sign-out">
                      <i class="fa fa-sign-out" aria-hidden="true" style="font-size:25px" title="Deslogearse"></i>
                    </button>
                </form>
        </li>
        </li>
      </ul>
    </header>
     <section class="seccion-perfil">
         <div class="contenido-informacion">


        <article class="informacion">
       
            <div class="bloke-imagen-perfil">
              <img src="/storage/{{$usuario->photo}}" alt="foto" class="foto-actual" style="height: 310px; width:250px">
              <form action="{{route('datos.cambiarFoto', $usuario)}}" method = "POST" enctype="multipart/form-data" class="form-btn-actualizar-foto form-cerrar">
                @csrf 
                @method('PUT')
                <input type="file" name="cambiar-foto" id="" required>
                <button class="btn-subir-foto-nueva"><i class="fa fa-camera" aria-hidden="true"></i>
                </button>
              </form>
            </div>
            <div class="bloke-info">
             
              @if(isset($usuario->escuela))
                    <p class="datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                      {{$usuario->escuela}}
                    </p>
              @else
                    <p class="datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                      Escuela
                    </p>
              @endif
              @if(isset($usuario->universidad))
              <p class="datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                {{$usuario->universidad}}
              </p>
              @else
                    <p class="datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                      Universidad
                    </p>
              @endif
              @if(isset($usuario->relacion))   
              <p class="datosusuario"><i class="fa fa-heart" aria-hidden="true"></i>
                {{$usuario->relacion}}
              </p>
                @else
                <p class="datosusuario"><i class="fa fa-heart" aria-hidden="true"></i>
                  Relacion
                </p>
                 @endif
           
           @if(isset($usuario->ciudad))
            
              <p class="datosusuario"><i class="fa fa-map-marker" aria-hidden="true"></i>
                {{$usuario->ciudad}}
              </p>
            
            @else
              
            <p class="datosusuario"><i class="fa fa-map-marker" aria-hidden="true"></i>
              Ciudad
            </p>
            
           @endif
            @if(isset($usuario->fecha_cumpleanios))
            
              <p class="datosusuario"><i class="fa fa-birthday-cake"></i> {{$usuario->fecha_cumpleanios}}</p>
            
             @else
             <p class="datosusuario"><i class="fa fa-birthday-cake" style="margin-right:6px"></i>Cumpleaños</p>
            
             @endif
             
            </div>
          </article>

        <article class="mis-perfil">
          <div class="rounded w3-card w3-round">
            <div class="w3-white">
              <button onclick="myFunction('Demo1')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Mis Grupos</button>
              <button onclick="myFunction('Demo4')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> Mis Amigos</button>
              <div id="Demo4" class="w3-hide w3-container">
                @foreach($usuario->amigos() as $amigo)
                <div class="div-amigo" class="col-12">
                  <div>
                    <img src="/storage/{{$amigo->photo}}" alt="" class="rounded-circle">
                    {{$amigo->name}} {{$amigo->surname[0]}}
                  </div>
                  <ul>
                    <i class="fa fa-ellipsis-h" aria-hidden="true" style="color:lightslategray;cursor:pointer;"></i>   
                    <li style="list-style-type:none;" class="li-cerrar">
                    <form action="{{route('datos.eliminarAmigo')}}" method="post">
                        @csrf 
                        @method('delete')
                      <input type="hidden" name="id_user" value="{{$usuario->id}}">
                      <input type="hidden" name="id_amigo" value="{{$amigo->id}}">
                      <button type="submit" style="border:0;background-color:white;" name="btn_eliminar" value="true">
                          <i class="fa fa-times" aria-hidden="true" style="color:lightslategray"> Eliminar</i>
                      </button>
                      </form>
                      <form action="{{route('datos.bloquearAmigo')}}" method="post">
                        @csrf 
                        @method('put')
                        <input type="hidden" name="id_user" value="{{$usuario->id}}">
                        <input type="hidden" name="id_amigo" value="{{$amigo->id}}">
                        <input type="hidden" name="bloqueado" value="{{$amigo->id}}">
                        <button type="submit" style="border:0;background-color:white">
                          <i class="fa fa-ban" aria-hidden="true" style="color:lightslategrey">Bloquear</i>
                        </button>
                      </form>
                    </li>
                  </ul>
                  </div>
                
                @endforeach
              </div>
              <button onclick="myFunction('Demo2')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-unlock fa-fw w3-margin-right"></i> Usuarios Bloqueados</button>
              <div id="Demo2" class="w3-hide w3-container">
                
                @foreach($usuario->bloqueados() as $amigo)
                <div class="div-amigo" class="col-12">
                  <div>
                    <img src="/storage/{{$amigo->photo}}" alt="" class="rounded-circle">
                    {{$amigo->name}} {{$amigo->surname[0]}}
                  </div>
                    <form action="{{route('datos.eliminarAmigo')}}" method="post">
                        @csrf 
                        @method('delete')
                      <input type="hidden" name="id_user" value="{{$usuario->id}}">
                      <input type="hidden" name="id_amigo" value="{{$amigo->id}}">
                      <button type="submit" style="border:0;background-color:white;color:lightslategrey" name="btn_desbloquear" value="true">
                         Desbloquear
                      </button>
                      </form>
                  </div>
                
                @endforeach
              </div>
              <button onclick="myFunction('Demo3')" class="w3-button w3-block -l1 w3-left-align"><i class="fa fa-camera fa-fw w3-margin-right"></i> Mis Fotos</button>
              <div id="Demo3" class="w3-hide w3-container" style="padding:0">
             <div class="w3-row-padding" style="padding:0">
             <br>
               <div class="w3-half div-fotos-flex" style="padding:0">    
                  @foreach($usuario->fotos as $foto)
               <form action="{{route('datos.cambiarFoto', $usuario)}}" method ="POST" class="col-3 col-lg-6 col-xl-4 form-cambiar-foto-a-vieja">
                    @csrf 
                    @method('put')
                    <i class="fa fa-camera i-cerrar i-camara" aria-hidden="true"></i>          
                    <button type="submit" class="btn-foto-usuario">
                    <input type="hidden" name="foto_vieja" value="{{$foto->nombre_foto}}">
                    <img src="/storage/{{$foto->nombre_foto}}" style="width:100%" class="w3-margin-bottom fotos-usuario">
                    </button>                        
               </form>
                 @endforeach
               </div>
             </div>
              </div>
            </div>
              </div>
        </article>

      </div>
        <div class="contenido-publicaciones">


        <article class="publicacion-perfil">
          @if($usuario->admin != 1)
        <form action="{{route('datos.insertPos',$usuario)}}" method ="post" enctype="multipart/form-data" id="form-insertPos">
             @csrf
              <div class="foto-estado">
                <figure class="user-public ">
                  <img src="/storage/{{$usuario->photo}}" alt="">
                </figure>
                <input type="text" name="publicacion" id="form-control-public" class="publicacion  form-control @error('publicacion') is-invalid @enderror" placeholder="Hola {{$usuario->name}}, comparte algo con tus amigos!" required>
                @error('publicacion')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="categ cat-disp-none">

                <label for="tipopublicacion" class="label-cat">Categoria</label>
                <select name="tipopublicacion" id="tipopublicacion">
                  @foreach($categorias as $cat)
                  <option value="{{$cat->id}}">
                    {{$cat->descripcion}}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="foto-publicar">

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
                <button type="submit" name ="subir-publicacion" disabled> <i class="fa fa-pencil"></i> Publicar</button>
                </form>
                <br>
                <br>
                @if(session('eliminada'))
                <span id="mensaje-post-ok" class="{{session('eliminada')}}">
                </span>
                @endif
                @if(session('subida'))
                 <span id="mensaje-post-ok" class="{{session('subida')}}">
                 </span>
                 @endif
              </div>

            @else

            <form action="{{route('categoria.store')}}" method ="post" id="categoria-post-subir">
              @csrf
               <input type="text" name="descripcion" class="publicacion form-control" placeholder="Categoria">

               <button type="submit" name="subircat">Subir</button>
               @if(session('subida'))
               <span style="color:green;font-size:13px">
                {{session('subida')}}
              </span>
              @endif

               <br>
            </form>
            <form action="{{route('categoria.destroy')}}" method = "post" id="categoria-post-eliminar">
                @csrf
                @method("delete")
                <div class="categoria-nombre">
                  <label for="tipopublicacion">Categoria</label>
                  <select name="tipopublicacion" id="tipopublicacion">
                    @foreach($categorias as $cat)
                    <option value="{{$cat->id}}">
                      {{$cat->descripcion}}
                    </option>
                    @endforeach
                  </select>
                </div>
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
         @foreach($usuario->posteosUsers() as $posteo)
           @if($posteo->id_user == $usuario->id)

            <div class="pp">
              <div class="foto-nombre">
                <figure class="user-public ">
                  <img src="/storage/{{$usuario->photo}}" alt="">
                </figure>
                <span class="nombre-usuario">
                  {{$usuario->name}} {{$usuario->surname}}
                </span>
                <span id="categoria-posteo">
                   {{$posteo->categoria->descripcion}}
                </span>
              </div>


              {{-- ACA VA EL DESPLEGABLE PARA EDITAR O BORRAR LA PUBLICACION --}}
              <div class="nav menu-dots">
                <a class="nav-link menu-mas" data-toggle="dropdown" href="#" role="button" 
                aria-expanded="false" title="Notificaciones">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                <ul class="dropdown-menu" id="desplegable">
                  <li class="item">
                    <form action="{{route('datos.deletePos')}}" method="post" class="" id="form-eliminarPos">
                      @csrf 
                      @method('delete')
                      <button type="submit" name ="borrarpublicacion" class="borrar-public" title="Borrar publicacion" value="{{$posteo->id}}">  
                        <i class="fa fa-times" aria-hidden="true"> Eliminar</i>
                      </button>
                    </form>
                  </li>
                  <li class="item">
                    <div class="editar-publicacion-form" style="padding-left:7px">
                     <i class="fa fa-pencil i-edit-post" aria-hidden="true" style="cursor: pointer"> Editar</i>
                    </div> 

                  </li>
                  
                </ul>
              </div>
              
              <div class="container contenedor-modpub col-12 div-cerrar">
                <div class="div-volver-perfil">
                    <a href="{{route('categoria.index')}}" class="volver">
                        <i class="fa fa-times cerrar-actpos" aria-hidden="true" style="font-size:20px;display:block;color:lightslategray;cursor: pointer;"></i>
                    </a>
                </div>
                <form action="{{route('datos.updatePos',$posteo)}}" method = "POST" enctype="multipart/form-data" class="col-8 col-md-6 col-lg-4 overlord" id="form-actPos"style="padding-top:30px">
                    @csrf 
                    @method('PUT') 
                     <div>
                        <input type="text" name="contenido" id="contenido" value="{{$posteo->descripcion}}" class="col-12 contenido-posteo">
                    </div>
                    <div class="div-foto-modificarpub">
                        <span>
                            FOTO
                        </span>
                        <input type="file" name="fotopub" id="foto-pub">
                    </div>
                    <button type="submit">Aceptar</button>
                </form>
            </div>
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
            @if($usuario->buscarLike($posteo) == null)
            <form action="{{route('like.store')}}" method="POST" class="form-like-comentar">
             @csrf
                    <input type="hidden" name="iduser" value="{{$usuario->id}}">
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <button type="submit" name ="crearlike" class="megusta" style="width:25px;border:0;background-color:white;">
                        <i class="fa fa-heart-o corazon" aria-hidden="true"></i>
                      </button>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      
                    </div>
                     <div class="div-comentar">
                      
                      <button type="button" name="comentar" style="width:25px;border:0;background-color:white;margin-left:5px"> 
                        <i class="fa fa-comment-o" aria-hidden="true"></i> 
                      </button>
                      <span class="span-like">
                        {{$posteo->comentarios->count()}}
                      </span> 
                     </div>                
              </form>
              
              <div class="col-12 div-comentarios-nuevos">
                
                @if($posteo->comentarios->count() >0)
                <hr style="margin-top: 5px">
                @endif
                @forelse($posteo->comentarios as $com)
                
                <div class="div-comentarios col-12" style="margin-bottom:10px;">
                  <div class="col-1 padding-top:8px">
                    <img src="/storage/{{$com->usuario->photo}}" alt="" class="foto-user-comentario rounded-circle">
                    </div>
                    <div class="col-10 div-comentario-user">
                      <div class="div-act-comentario"style="position: relative;left:5px;padding:7px;background-color:#f2f3f5;border-radius:20px">
                        <span class="span-abrir">
                           <b style="color:lightslategrey">{{$com->usuario->name}} {{$com->usuario->surname}}:</b>
                             {{$com->descripcion}} 
                           </span>
                          <form action="{{route('comentario.update', $com)}}" method="POST" class="form-cerrar form-act-comentario" style="position:relative">
                          @csrf 
                          @method('put')
                          <i class="fa fa-times" aria-hidden="true" style="cursor: pointer;color:lightslategrey;position:absolute;right:5%"></i>
                          <input maxlength="50" type="text" name="comentario" id=""style="padding-top:5px;padding-left:5px;background-color:#f2f3f5;border:0;width:100%" value="{{$com->descripcion}}" class="comentario-act">
                          <input type="hidden" name ="comentario-hidden" value="{{$com->descripcion}}">
                           <button style="visibility:hidden"></button>
                        </form>
                      </div>
                    </div>
                    @if($usuario->id == $com->id_user)
                    <div class="nav menu-dots col-1">
                      <a class="nav-link menu-mas" data-toggle="dropdown" href="#" role="button" 
                      aria-expanded="false" title="Notificaciones">
                      <i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                      <ul class="dropdown-menu" id="desplegable">
                        <li class="item">
                        <form action="{{route('comentario.destroy', $com)}}" method="post" id="commentDestroy">
                            @csrf 
                            @method('delete')
                            <button type="submit" name ="" id="borrar-comentario" title="Borrar comentario" value="" style="background-color:white;border:0;color:lightslategray;padding-left:6px;width:100%;text-align:left">  
                              <i class="fa fa-times" aria-hidden="true"> Eliminar</i>
                            </button>
                          </form>
                        </li>
                        <li class="item">
                          <div class="editar-comentario-form" style="padding-left:7px">
                           <i class="fa fa-pencil" aria-hidden="true" style="cursor: pointer"> Editar</i>
                           
                          </div> 
      
                        </li>
                        
                      </ul>
                    </div>
                    @else 
                    <div class="col-1" style="position:relative;">
                    <form action="{{route('comentario.destroy',$com)}}" method="post" id="commentDestroyedByUser">
                        @csrf
                        @method('delete')
                        <button type="submit" style="position: absolute;left:10px;border:0;background:white;width:18px"><i class="fa fa-times" aria-hidden="true" style="color:lightslategray"></i></button>
                      </form>
                    </div> 
                    @endif
                </div>
               
                @empty
                @endforelse
                <hr style="margin-top: 5px">
              <form action="{{route('comentario.store')}}" method="POST" class="form-comentarios">
                
                @csrf
                    <div class="col-1">
                      <img src="/storage/{{$usuario->photo}}" alt="" style="width:40px;height:40px" class="rounded-circle">
                    </div>
                     <div class="col-11" style="padding-top:4px">
                     <input type="hidden" name="id_posteo"value="{{$posteo->id}}">
                      <input type="hidden" name="id_user" value="{{$usuario->id}}">
                      <input maxlength="50" type="text" name="comentario" class="text-comentario" placeholder="Escribe un comentario...">
                      
                    </div>
                      
                      <button class="subir-comentario" style="visibility:hidden"></button>
                  </form>
              </div>
              @else 
             <form action="{{route('like.destroy',$usuario->buscarLike($posteo))}}" method="POST" class="form-like-comentar">
               @csrf 
               @method('delete')
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <button type="submit" name ="crearlike" class="megusta" style="width:25px;border:0;background-color:white;">
                      <i class="fa fa-heart heart-red" aria-hidden="true" style="color:red"></i>
                    </button>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      
                    </div>
                    <div class="div-comentar">
                      
                      <button type="button" name="comentar" style="width:25px;border:0;background-color:white;margin-left:5px"> 
                        <i class="fa fa-comment-o" aria-hidden="true"></i> 
                      </button>
                      <span class="span-like">
                        {{$posteo->comentarios->count()}}
                      </span> 
                     </div>  
              </form>
              <div class="col-12 div-comentarios-nuevos">
                
                @if(count($posteo->comentarios)>0)
                <hr style="margin-top: 5px">
                @endif
                @forelse($posteo->comentarios as $com)
                
                <div class="div-comentarios col-12" style="margin-bottom:10px;">
                  <div class="col-1 padding-top:8px">
                    <img src="/storage/{{$com->usuario->photo}}" alt="" class="foto-user-comentario rounded-circle">
                    </div>
                    <div class="col-10 div-comentario-user">
                      <div class="div-act-comentario" style="position: relative;left:5px;padding:7px;background-color:#f2f3f5;border-radius:20px">
                        <span class="span-abrir">
                           <b style="color:lightslategrey">{{$com->usuario->name}} {{$com->usuario->surname}}:</b>
                             {{$com->descripcion}} 
                           </span>
                          <form action="{{route('comentario.update', $com)}}" method="POST" class="form-cerrar form-act-comentario" style="position:relative">
                          @csrf 
                          @method('put')
                          <i class="fa fa-times" aria-hidden="true" style="cursor: pointer;color:lightslategrey;position:absolute;right:5%"></i>
                          <input maxlength="50" type="text" name="comentario" id=""style="padding-top:5px;padding-left:5px;background-color:#f2f3f5;border:0;width:100%" value="{{$com->descripcion}}" class="comentario-act">
                          <input type="hidden" name ="comentario-hidden" value="{{$com->descripcion}}">
                          <button style="visibility:hidden"></button>
                        </form>
                      </div>
                    </div>
                    @if($usuario->id == $com->id_user)
                    <div class="nav menu-dots col-1">
                      <a class="nav-link menu-mas" data-toggle="dropdown" href="#" role="button" 
                      aria-expanded="false" title="Notificaciones">
                      <i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                      <ul class="dropdown-menu" id="desplegable">
                        <li class="item">
                        <form action="{{route('comentario.destroy', $com)}}" method="post" id="commentDestroy">
                            @csrf 
                            @method('delete')
                            <button type="submit" name ="" class=""id="borrar-comentario" title="Borrar comentario" value="" style="background-color:white;border:0;color:lightslategray;padding-left:6px">  
                              <i class="fa fa-times" aria-hidden="true"> Eliminar</i>
                            </button>
                          </form>
                        </li>
                        <li class="item">
                          <div class="editar-comentario-form" style="padding-left:7px">
                           <i class="fa fa-pencil" aria-hidden="true" style="cursor: pointer"> Editar</i>
                           
                          </div> 
      
                        </li>
                        
                      </ul>
                    </div>
                    @else 
                    <div class="col-1" style="position:relative;">
                    <form action="{{route('comentario.destroy',$com)}}" method="post" id="commentDestroyedByUser">
                        @csrf
                        @method('delete')
                        <button type="submit" style="position: absolute;left:10px;border:0;background:white;width:18px"><i class="fa fa-times" aria-hidden="true" style="color:lightslategray"></i></button>
                      </form>
                    </div>
                    @endif
                </div>
               
                @empty
                @endforelse
               <hr style="margin-top: 5px">

              <form action="{{route('comentario.store')}}" method="POST" class="form-comentarios">
                @csrf
                    <div class="col-1">
                      <img src="/storage/{{$usuario->photo}}" alt="" style="width:40px;height:40px" class="rounded-circle">
                    </div>
                     <div class="col-11" style="padding-top:4px">
                     <input type="hidden" name="id_posteo"value="{{$posteo->id}}">
                      <input type="hidden" name="id_user" value="{{$usuario->id}}">
                      <input maxlength="50" type="text" name="comentario" class="text-comentario" placeholder="Escribe un comentario...">
                      
                    </div>
                      
                      <button class="subir-comentario" style="visibility:hidden"></button>
                  </form>
              </div>
              @endif    
           </div>

           
             <div class="separar">
             </div> 

             @else

             {{-- POSTEOS DE AMIGOS --}}


             
            <div class="pp">
              <div class="foto-nombre">
                <figure class="user-public">
                  <img src="/storage/{{$usuario->buscarPosteoAmigo($posteo->id_user)->photo}}" alt="">
                </figure>
                <span class="nombre-usuario">
                  {{$usuario->buscarPosteoAmigo($posteo->id_user)->name}} {{$usuario->buscarPosteoAmigo($posteo->id_user)->surname}}
                </span>
                <span id="categoria-posteo">
                   {{$posteo->categoria->descripcion}}
                </span>
              </div>

            <form action="perfil.php" method="post" class=""">
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
           <div class="interaccion-publicacion separar amigo">
            @if($usuario->buscarLike($posteo) == null)
            <form action="{{route('like.store')}}" method="POST" class="form-like-comentar">
             @csrf
                    <input type="hidden" name="iduser" value="{{$usuario->id}}">
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <button type="submit" name ="crearlike" class="megusta" style="width:25px;border:0;background-color:white;">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                      </button>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      
                    </div>
                    <div class="div-comentar">
                      
                      <button type="button" name="comentar" style="width:25px;border:0;background-color:white;margin-left:5px"> 
                        <i class="fa fa-comment-o" aria-hidden="true"></i> 
                      </button>
                      <span class="span-like">
                        {{$posteo->comentarios->count()}}
                      </span> 
                     </div>  
                     
              </form>
              <div class="col-12 div-comentarios-nuevos">
                
                @if(count($posteo->comentarios)>0)
                <hr style="margin-top: 5px">
                @endif
                @forelse($posteo->comentarios as $com)
               
                <div class="div-comentarios col-12" style="margin-bottom:10px;">
                  <div class="col-1 padding-top:8px">
                    <img src="/storage/{{$com->usuario->photo}}" alt="" class="foto-user-comentario rounded-circle">
                    </div>
                    <div class="col-10 div-comentario-user">
                      <div class="div-act-comentario" style="position: relative;left:5px;padding:7px;background-color:#f2f3f5;border-radius:20px">
                        <span class="span-abrir">
                           <b style="color:lightslategrey">{{$com->usuario->name}} {{$com->usuario->surname}}:</b>
                             {{$com->descripcion}} 
                           </span>
                          <form action="{{route('comentario.update', $com)}}" method="POST" class="form-cerrar form-act-comentario" style="position:relative">
                          @csrf 
                          @method('put')
                          <i class="fa fa-times" aria-hidden="true" style="cursor: pointer;color:lightslategrey;position:absolute;right:5%"></i>
                          <input maxlength="50" type="text" name="comentario" id=""style="padding-top:5px;padding-left:5px;background-color:#f2f3f5;border:0;width:100%" value="{{$com->descripcion}}" class="comentario-act">
                          <input type="hidden" name ="comentario-hidden" value="{{$com->descripcion}}">
                          <button style="visibility:hidden"></button>
                        </form>
                      </div>
                    </div>
                    @if($usuario->id == $com->id_user)
                    <div class="nav menu-dots col-1">
                      <a class="nav-link menu-mas" data-toggle="dropdown" href="#" role="button" 
                      aria-expanded="false" title="Notificaciones">
                      <i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                      <ul class="dropdown-menu" id="desplegable">
                        <li class="item">
                        <form action="{{route('comentario.destroy', $com)}}" method="post" id="commentDestroy">
                            @csrf 
                            @method('delete')
                            <button type="submit" name ="" class="" id="borrar-comentario" title="Borrar comentario" value="" style="background-color:white;border:0;color:lightslategray;padding-left:6px;width:100%;text-align:left">  
                              <i class="fa fa-times" aria-hidden="true"> Eliminar</i>
                            </button>
                          </form>
                        </li>
                        <li class="item">
                          <div class="editar-comentario-form" style="padding-left:7px">
                           <i class="fa fa-pencil" aria-hidden="true" style="cursor: pointer"> Editar</i>
                          
                          </div> 
      
                        </li>
                        
                      </ul>
                    </div>
                    
                    @endif
                </div>
               
                @empty
                @endforelse
               <hr style="margin-top: 5px">
              <form action="{{route('comentario.store')}}" method="POST" class="form-comentarios">
                @csrf
                    <div class="col-1">
                      <img src="/storage/{{$usuario->photo}}" alt="" style="width:40px;height:40px" class="rounded-circle">
                    </div>
                     <div class="col-11" style="padding-top:4px">
                     <input type="hidden" name="id_posteo"value="{{$posteo->id}}">
                      <input type="hidden" name="id_user" value="{{$usuario->id}}">
                      <input maxlength="50" type="text" name="comentario" class="text-comentario" placeholder="Escribe un comentario...">
                    </div>
                      
                      <button class="subir-comentario" style="visibility:hidden"></button>
                  </form>
              </div>
              @else 
             <form action="{{route('like.destroy',$usuario->buscarLike($posteo))}}" method="POST" class="form-like-comentar">
               @csrf 
               @method('delete')
                    <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                    <div class="div-megusta">
                      <button type="submit" name ="crearlike" class="megusta" style="width:25px;border:0;background-color:white;">
                          <i class="fa fa-heart heart-red" aria-hidden="true" style="color:red"></i>
                      </button>
                      <span class="span-like">
                        {{$posteo->cant_likes}}
                      </span>                 
                      
                    </div>
                    <div class="div-comentar">
                      
                      <button type="button" name="comentar" style="width:25px;border:0;background-color:white;margin-left:5px"> 
                        <i class="fa fa-comment-o" aria-hidden="true"></i> 
                      </button>
                      <span class="span-like">
                        {{$posteo->comentarios->count()}}
                      </span> 
                     </div>  
              </form>
              <div class="col-12 div-comentarios-nuevos">
                
                @if(count($posteo->comentarios)>0)
                <hr style="margin-top: 5px">
                @endif
                @forelse($posteo->comentarios as $com)
                
                <div class="div-comentarios col-12" style="margin-bottom:10px;">
                  <div class="col-1 padding-top:8px">
                    <img src="/storage/{{$com->usuario->photo}}" alt="" class="foto-user-comentario rounded-circle">
                    </div>
                    <div class="col-10 div-comentario-user">
                      <div class="div-act-comentario" style="position: relative;left:5px;padding:7px;background-color:#f2f3f5;border-radius:20px">
                        <span class="span-abrir">
                           <b style="color:lightslategrey">{{$com->usuario->name}} {{$com->usuario->surname}}:</b>
                             {{$com->descripcion}} 
                           </span>
                          <form action="{{route('comentario.update', $com)}}" method="POST" class="form-cerrar form-act-comentario" style="position:relative">
                          @csrf 
                          @method('put')
                          <i class="fa fa-times" aria-hidden="true" style="cursor: pointer;color:lightslategrey;position:absolute;right:5%"></i>
                          <input maxlength="50" type="text" name="comentario" id=""style="padding-top:5px;padding-left:5px;background-color:#f2f3f5;border:0;width:100%" value="{{$com->descripcion}}" class="comentario-act">                        
                          <input type="hidden" name ="comentario-hidden" value="{{$com->descripcion}}">
                          <button style="visibility:hidden"></button>
                        </form>
                      </div>
                    </div>
                    @if($usuario->id == $com->id_user)
                    <div class="nav menu-dots col-1">
                      <a class="nav-link menu-mas" data-toggle="dropdown" href="#" role="button" 
                      aria-expanded="false" title="Notificaciones">
                      <i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                      <ul class="dropdown-menu" id="desplegable">
                        <li class="item">
                        <form action="{{route('comentario.destroy', $com)}}" method="post" id="commentDestroy">
                            @csrf 
                            @method('delete')
                            <button type="submit" name ="" class="" id="borrar-comentario"  title="Borrar comentario" value="" style="background-color:white;border:0;color:lightslategray;padding-left:6px">  
                              <i class="fa fa-times" aria-hidden="true"> Eliminar</i>
                            </button>
                          </form>
                        </li>
                        <li class="item">
                          <div class="editar-comentario-form" style="padding-left:7px">
                           <i class="fa fa-pencil" aria-hidden="true" style="cursor: pointer;"> Editar</i>
                           
                          </div> 
      
                        </li>
                        
                      </ul>
                    </div>
                    
                    @endif
                </div>
             
                @empty
                @endforelse
               <hr style="margin-top: 5px">
              <form action="{{route('comentario.store')}}" method="POST" class="form-comentarios">
                @csrf
                    <div class="col-1">
                      <img src="/storage/{{$usuario->photo}}" alt="" style="width:40px;height:40px" class="rounded-circle">
                    </div>
                     <div class="col-11" style="padding-top:4px">
                     <input type="hidden" name="id_posteo"value="{{$posteo->id}}">
                      <input type="hidden" name="id_user" value="{{$usuario->id}}">
                      <input maxlength="50" type="text" name="comentario" class="text-comentario" placeholder="Escribe un comentario...">
                     
                    </div>
                      
                      <button class="subir-comentario" style="visibility:hidden"></button>
                  </form>
              </div>
              @endif       
           </div>
         @endif
       @endforeach
       @else 
       @foreach($posteosall as $posteo)

       <div class="pp">
         <div class="foto-nombre">
           <figure class="user-public">
             <img src="/storage/{{$posteo->usuario->photo}}" alt="">
            </figure>
            <span class="nombre-usuario">
              {{$posteo->usuario->name}} {{$posteo->usuario->surname}} 
            </span>
            <span id="categoria-posteo">
              {{$posteo->categoria->descripcion}}
            </span>
          </div>
            
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
        @if($usuario->buscarLike($posteo) == null)
        <form action="{{route('like.store')}}" method="POST" class="form-like-comentar">
         @csrf
                <input type="hidden" name="iduser" value="{{$usuario->id}}">
                <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                <div class="div-megusta">
                  <button type="submit" name ="crearlike" class="megusta" style="width:25px;border:0;background-color:white;">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                  </button>
                  <span class="span-like">
                    {{$posteo->cant_likes}}
                  </span>                 
                  
                </div>
                <div class="div-comentar">
                      
                  <button type="button" name="comentar" style="width:25px;border:0;background-color:white;margin-left:5px"> 
                    <i class="fa fa-comment-o" aria-hidden="true"></i> 
                  </button>
                  <span class="span-like">
                    {{$posteo->comentarios->count()}}
                  </span> 
                 </div>  
                 
          </form>
          <div class="col-12">
            
            @if(count($posteo->comentarios)>0)
            <hr style="margin-top: 5px">
            @endif
            @forelse($posteo->comentarios as $com)

            <div class="div-comentarios col-12" style="margin-bottom:10px;">
              <div class="col-1 padding-top:8px">
                <img src="/storage/{{$com->usuario->photo}}" alt="" class="foto-user-comentario rounded-circle">
                </div>
                <div class="col-10 div-comentario-user">
                  <div class="div-act-comentario" style="position: relative;left:5px;padding:7px;background-color:#f2f3f5;border-radius:20px">
                    <span class="span-abrir">
                       <b style="color:lightslategrey">{{$com->usuario->name}} {{$com->usuario->surname}}:</b>
                         {{$com->descripcion}} 
                       </span>
                      <form action="{{route('comentario.update', $com)}}" method="POST" class="form-cerrar form-act-comentario" style="position:relative">
                      @csrf 
                      @method('put')
                      <i class="fa fa-times" aria-hidden="true" style="cursor: pointer;color:lightslategrey;position:absolute;right:5%"></i>
                      <input maxlength="50" type="text" name="comentario" id=""style="padding-top:5px;padding-left:5px;background-color:#f2f3f5;border:0;width:100%" value="{{$com->descripcion}}" class="comentario-act">
                      <input type="hidden" name ="comentario-hidden" value="{{$com->descripcion}}">
                      <button style="visibility:hidden"></button>
                    </form>
                  </div>
                </div>
                <div class="col-1" style="position:relative;">
                <form action="{{route('comentario.destroy',$com)}}" method="post" id="commentDestroyedByUser">
                    @csrf
                    @method('delete')
                    <button type="submit" style="position: absolute;left:10px;border:0;background:white;width:18px"><i class="fa fa-times" aria-hidden="true" style="color:lightslategray"></i></button>
                  </form>
                </div>
            </div>
           
            @empty
            @endforelse
            
          </div>
          @else 
         <form action="{{route('like.destroy',$usuario->buscarLike($posteo))}}" method="POST" class="form-like-comentar">
           @csrf 
           @method('delete')
                <input type="hidden" name="idposteo" value="{{$posteo->id}}">
                <div class="div-megusta">
                  <button type="submit" name ="crearlike" class="megusta" style="width:25px;border:0;background-color:white;">
                  <i class="fa fa-heart heart-red" aria-hidden="true" style="color:red"></i>
                </button>
                  <span class="span-like">
                    {{$posteo->cant_likes}}
                  </span>                 
                  
                </div>
                <div class="div-comentar">
                      
                  <button type="button" name="comentar" style="width:25px;border:0;background-color:white;margin-left:5px"> 
                    <i class="fa fa-comment-o" aria-hidden="true"></i> 
                  </button>
                  <span class="span-like">
                    {{$posteo->comentarios->count()}}
                  </span> 
                 </div>  
          </form>
          <div class="col-12">  
            
            @if(count($posteo->comentarios)>0)
            <hr style="margin-top: 5px">
            @endif
            @forelse($posteo->comentarios as $com)
            
            <div class="div-comentarios col-12" style="margin-bottom:10px;">
              <div class="col-1 padding-top:8px">
                <img src="/storage/{{$com->usuario->photo}}" alt="" class="foto-user-comentario rounded-circle">
                </div>
                <div class="col-10 div-comentario-user">
                  <div class="div-act-comentario" style="position: relative;left:5px;padding:7px;background-color:#f2f3f5;border-radius:20px">
                    <span class="span-abrir">
                       <b style="color:lightslategrey">{{$com->usuario->name}} {{$com->usuario->surname}}:</b>
                         {{$com->descripcion}} 
                       </span>
                      <form action="{{route('comentario.update', $com)}}" method="POST" class="form-cerrar form-act-comentario" style="position:relative">
                      @csrf 
                      @method('put')
                      <i class="fa fa-times" aria-hidden="true" style="cursor: pointer;color:lightslategrey;position:absolute;right:5%"></i>
                      <input maxlength="50" type="text" name="comentario" id=""style="padding-top:5px;padding-left:5px;background-color:#f2f3f5;border:0;width:100%" value="{{$com->descripcion}}" class="comentario-act">
                      <input type="hidden" name ="comentario-hidden" value="{{$com->descripcion}}">
                      <button style="visibility:hidden"></button>
                    </form>
                  </div>
                </div>
                @if($usuario->id == $com->id_user)
                <div class="nav menu-dots col-1">
                  <a class="nav-link menu-mas" data-toggle="dropdown" href="#" role="button" 
                  aria-expanded="false" title="Notificaciones">
                  <i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                  <ul class="dropdown-menu" id="desplegable">
                    <li class="item">
                    <form action="{{route('comentario.destroy', $com)}}" method="post" id="commentDestroy">
                        @csrf 
                        @method('delete')
                        <button type="submit" name ="" class="" title="Borrar comentario" value="" style="background-color:white;border:0;color:lightslategray;padding-left:6px">  
                          <i class="fa fa-times" aria-hidden="true"> Eliminar</i>
                        </button>
                      </form>
                    </li>
                    <li class="item">
                      <div class="editar-comentario-form" style="padding-left:7px">
                       <i class="fa fa-pencil" aria-hidden="true" style="cursor: pointer"> Editar</i>
                       
                      </div> 
  
                    </li>
                    
                  </ul>
                </div>
                @endif
            </div>
            @empty
            @endforelse       
          </div>
          @endif     
       </div>
       <div class="separar">
       </div>
       @endforeach
       @endif

       </article>
      </div>
       <article class="solicitudes-amistad ">
            <h3>
              Agregar amigos
            </h3>
            <div class="buscador">
            <form action="{{route('datos.insertSolicitud',$usuario)}}" method="POST" id="form-buscar-amigos">
              @csrf
                <input type="email" name="amigo" id ="amigo" placeholder=" Ingrese mail amigo" class="buscaramigo" required>
                <button type="submit" name="buscaramigo" class="buscaramigo">Buscar</button>
                @if(session('rechazado'))
                <span id="mensaje-post-error" class="{{session('rechazado')}}">
                </span>
                @endif
                @if(session('aceptado'))
                <span id="mensaje-post-ok" class="{{session('aceptado')}}">
                </span>
                @endif
              </form>
            </div>
            <div class="usuario-solicitud-a">
              <button style="text-align:left"  type="button" class="btn-lista-usuario-sol"><i class="fa fa-plus" aria-hidden="true" title="Abrir lista"></i></button>
              @if($usuario->miSolicitudes->count() == 0)
            <h3 id="usuario-sol">Solicitudes de amistad</h3>
            @else
            <h3 id="usuario-sol">Solicitudes de amistad <strong id="cant-sol">{{$usuario->miSolicitudes->count()}}</strong></h3> 
            @endif
            </div>
            <div class="div-lista-solicitudes div-cerrar">
            @foreach($usuario->miSolicitudes as $sol)
            <div id="solicitud-a" class="sa ">
              <div class=" foto-solicitud">
              <img src="storage/{{$sol->photo}}" alt="">
              </div>
              <p class="">
                {{$sol->name}}  {{$sol->surname}}

              </p>
            <form action="{{route('datos.agregarAmigo',$usuario)}}" method="POST" class="form-sol">
              @csrf 
              @method('PUT')
              <button type="submit" name="aceptar" class=" check" value="{{$sol->id}}"> <i class="fa fa-check"></i></button>
              <button type="submit" name="rechazar" class=" remove" value="{{$sol->id}}"> <i class="fa fa-remove"></i></button>
            </form>
            </div>
            @endforeach
            </div>
            <div class="usuario-ciudad-a">
              <button style="text-align:left"  type="button" class="btn-lista-usuario"><i class="fa fa-plus" aria-hidden="true" title="Abrir lista"></i></button>
              <h3 id="usuario-ciudad">Usuarios de tu ciudad</h3>
            </div>

            <div class="div-lista-usuarios div-cerrar">
              @foreach($usuarios as $user)
              <div class="sa " id="sa-usuario-ciudad">
                <div class=" foto-solicitud">
                <img src="storage/{{$user->photo}}" alt="">
                </div>
                <p class="">
                  {{$user->name}} {{$user->surname}}
                </p>
              <form action="{{route('datos.enviarSolicitud',$usuario)}}" method="POST" class="">
                @csrf 
                <input type="hidden" name="idamigo" value="{{$user->id}}">
                <button type="submit" name="aceptar" class=" check" > <i class="fa fa-check"></i></button>
              </form>
              </div>
              @endforeach
            </div>
            
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
  </script>
  <script>
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
          toastr.error("Campo vacío");
          
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
          toastr.error("Campo vacío");
        }
    }
    document.querySelector('.btn-lista-usuario').onclick = function()
    { 
      let div =  document.querySelector('.div-lista-usuarios ');
      div.classList.toggle('div-abrir');
      div.classList.toggle('div-cerrar');
      if(div.classList.contains('div-cerrar'))
      {
        this.innerHTML = "<i class='fa fa-plus' aria-hidden='true0' title='Abrir'></i>"
      }else 
      {
        this.innerHTML = "<i class='fa fa-minus' aria-hidden='true' title='Cerrar'></i>"
      }
    }


    document.querySelector('.btn-lista-usuario-sol').onclick = function()
    { 
      let div =  document.querySelector('.div-lista-solicitudes');
      div.classList.toggle('div-abrir');
      div.classList.toggle('div-cerrar');
      if(div.classList.contains('div-cerrar'))
      {
        this.innerHTML = "<i class='fa fa-plus' aria-hidden='true0' title='Abrir'></i>"
      }else 
      {
        this.innerHTML = "<i class='fa fa-minus' aria-hidden='true' title='Cerrar'></i>"
      }
    }
    for(let form of Array.from(document.querySelectorAll('.form-cambiar-foto-a-vieja')))
    {
      let i =  form.querySelector('i');
      let img = form.querySelector('img');
      img.onmouseover = function()
      {
        i.classList.add('i-abrir');
        i.classList.remove('i-cerrar');
      }
      img.onmouseout = function()
      {
        
        i.classList.add('i-cerrar');
        i.classList.remove('i-abrir');
      }
      form.onsubmit = function(event)
      {
        if(!confirm('Desea cambiar la foto'))
        {
          event.preventDefault();
        }
      }  
    }
  document.querySelector('.foto-actual').onmouseover = function()
    {   
        let form =document.querySelector('.form-btn-actualizar-foto');
           form.classList.add('form-abrir');
           form.classList.remove('form-cerrar'); 
     
    }
    document.querySelector('.foto-actual').onmouseout = function()
    { 
      let form =document.querySelector('.form-btn-actualizar-foto');
           form.classList.remove('form-abrir');
           form.classList.add('form-cerrar');    

    }
   document.querySelector('[name=cambiar-foto]').onchange = function()
   {
    let btn = document.querySelector('.btn-subir-foto-nueva');
    btn.setAttribute('type', 'submit');
    btn.click();
    btn.removeAttribute('type');
   }


   for(let megusta of Array.from(document.querySelectorAll('.div-megusta'))){
     let i = megusta.querySelector('i');
     megusta.onmouseover = () => {
     i.classList.add('animacion-i');
    }
   }
   for(let megusta of Array.from(document.querySelectorAll('.div-megusta'))){
     let i = megusta.querySelector('i');
     megusta.onmouseout = () => {
     i.classList.remove('animacion-i');
    }
   }


   for(let comentar of Array.from(document.querySelectorAll('.div-comentar'))){
     let i = comentar.querySelector('i');
     comentar.onmouseover = () => {
     i.classList.add('animacion-i');
    }
   }
   for(let comentar of Array.from(document.querySelectorAll('.div-comentar'))){
     let i = comentar.querySelector('i');
     comentar.onmouseout = () => {
     i.classList.remove('animacion-i');
    }
   }
   for(let div of Array.from(document.querySelectorAll('.div-amigo'))) 
   {
     if(div.querySelector('i')!=null)
     {
      div.querySelector('i').onclick = function()
      {
        div.querySelector('li').classList.toggle('li-abrir');
        div.querySelector('li').classList.toggle('li-cerrar');
        div.querySelector('ul').classList.toggle('ul-position');
        this.classList.toggle('i-mover');
        div.querySelector('div').classList.toggle('div-mover');
      }
     }
      
   }
   document.querySelector('#a-not-user').onblur =function()
   {
      this.style.backgroundColor = "black";
   }
    document.getElementById('strike-info').onmouseover = () =>{
      toastr.options.progressBar = false;
      toastr.info('Si haces click sobre el icono de atención aparecerá la cantidad de strikes que posees. Si tienes un strike significa que un administrador ha borrado una de tus publicaciones por haber sido inapropiada. Si llegas al maximo de 3 strikes tu cuenta será eliminada automáticamente.'
      ,'Strikes');
      }
      if(document.getElementById('form-actPos')!=null)
      {
        document.getElementById('form-actPos').onsubmit = function(event)
            {
                let inputs = Array.from(this.elements);
                inputs.pop();
                inputs.shift();
                let resp = false;
            for(let input of inputs)
            {
                if(input.getAttribute('name')=="contenido")
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
                 toastr.error('Campo vacio');
             }
           }
      }
      

       document.onclick = (e) => {
          e = e || event;
          let target = e.target || e.srcElement;
          let elemento = document.querySelector('.publicacion-perfil');
          const categoria = document.querySelector('.categ');
          const public = document.querySelector('.publicaciones-perfil');
          const subirPublic = document.querySelector('[name=subir-publicacion]');
          do {
            if (elemento == target) {
              categoria.classList.add('cat-disp-block');
              categoria.classList.remove('cat-disp-none');
              subirPublic.style.opacity = 1;
              subirPublic.removeAttribute('disabled');
              subirPublic.style.cursor = 'pointer';
            return;
            }
            target = target.parentNode;
          } while (target)
              categoria.classList.add('cat-disp-none');
              categoria.classList.remove('cat-disp-block');
              subirPublic.setAttribute('disabled',"");
              subirPublic.style.opacity = .7;
              subirPublic.style.cursor = 'not-allowed';
          }
    
      for(let p of Array.from(document.querySelectorAll('.pp')))
      {
        if(p.querySelector('.i-edit-post')!=null)
        {     
        p.querySelector('.i-edit-post').onclick = function()
        {
          let cont = document.querySelector('.contenedor-modpub');
          cont.innerHTML = p.querySelector('.contenedor-modpub').innerHTML;
          cont.classList.remove('div-cerrar');
          document.querySelector('.contenedor-perfil').classList.add('overlay'); 
        }
       
      }
    }
      for(let i of Array.from(document.querySelectorAll('.cerrar-actpos')))
      {
        i.onclick = function()
        {
          document.querySelector('.contenedor-modpub').classList.add('div-cerrar');
          document.querySelector('.contenedor-modpub').innerHTML = "";
          document.querySelector('.contenedor-perfil').classList.remove('overlay');
        } 
       
      }
    if(document.getElementById('form-eliminarPos')!=null){
      document.getElementById('form-eliminarPos').onsubmit = function(event)
    {
      if(!confirm('Desea eliminarlo'))
      {
        event.preventDefault();
      }
    }
    } 
    const msjeOk = document.getElementById('mensaje-post-ok');
    if(msjeOk){
      const txt = msjeOk.getAttribute('class');
      toastr.success(txt);
    }
    const msjeError = document.getElementById('mensaje-post-error');
    if(msjeError){
      const txt = msjeError.getAttribute('class');
      toastr.error(txt);
    }
    for(let div of Array.from(document.querySelectorAll('.div-comentarios-nuevos')))
    {
      div.querySelector('.form-comentarios').onsubmit = function(event)
      {
        let inputs = Array.from(this.elements);
        inputs.pop();
        inputs.shift();
        let resp = false;
        for(let input of inputs)
        {
          if(input.getAttribute('name')=="comentario")
          {
           
            if(input.value == "")
            {
              resp = true;
              break;
            }
          }
        }
        if(resp){
          event.preventDefault();
          toastr.error('Campo vacio');
        }
      }
    }
    for(let form of Array.from(document.querySelectorAll('.div-act-comentario')))
    {
      if( form.querySelector('.text-comentario')!=null)
      {
        form.querySelector('.text-comentario').onkeydown = function(event)
        {
        if(event.key == "Enter")
          {
          let boton = form.querySelector('button');
          boton.setAttribute("type","submit");
          boton.click();
          boton.removeAttribute("type");
          }
        }
      }
      
    }
    for(let div of Array.from(document.querySelectorAll('.div-comentarios')))
    {
       let form = div.querySelector('.div-comentario-user .div-act-comentario form');
      form.onsubmit = function(event)
      { 
          let resp = false;
          let inputs = Array.from(this.elements);
          inputs.pop();
          inputs.shift();
          
          inputs = inputs.filter(input => {
            return input.value != "put" && input.getAttribute('name') != "comentario-hidden";
          });
          for(let input of inputs)
          {
            console.log(input);
          }
          for(let input of inputs)
          {
            if(input.getAttribute('name')=="comentario")
            {
            if(input.value == "")
              {
                input.value = this.querySelector("[name=comentario-hidden]").value;
                resp = true;
              } 
            }
          }
          if(resp){
            event.preventDefault();
          toastr.error('Campo vacio');
          
          } 
          
      }
          
    }
    for(let div of Array.from(document.querySelectorAll(".div-act-comentario"))){
      let form = div.querySelector("form");
      let input = form.querySelector('.comentario-act');
      if(input!=null)
      {
        input.onkeydown = function(event)
      {
        if(event.key == "Enter")
        {
          let boton = form.querySelector('button');
          boton.setAttribute("type","submit");
          boton.click();
          boton.removeAttribute("type");
        }
      }
      }
      
    }
    for(let div of Array.from(document.querySelectorAll('.div-comentarios')))
    {
      if( div.querySelector('.fa-pencil')!=null)
      {
        div.querySelector('.fa-pencil').onclick = function()
        {
          div.querySelector('span').classList.remove('span-abrir');
          div.querySelector('span').classList.add('span-cerrar');
          div.querySelector('.div-comentario-user div').style.padding = "0";
          div.querySelector('.div-comentario-user div').style.height= "35px";
          div.querySelector('.form-act-comentario').classList.add('form-abrir');
          div.querySelector('.form-act-comentario').classList.remove('form-cerrar');      
          
        }
      }
    }
    for(let div of Array.from(document.querySelectorAll('.div-comentarios')))
    {
    if(div.querySelector('.fa-times')!=null)
      {
        div.querySelector('.fa-times').onclick = function()
        {
          div.querySelector('span').classList.remove('span-cerrar');
          div.querySelector('span').classList.add('span-abrir');
          div.querySelector('.div-comentario-user div').style.padding = "7px";
          div.querySelector('.div-comentario-user div').style.height= " ";
          div.querySelector('.form-act-comentario').classList.remove('form-abrir');  
          div.querySelector('.form-act-comentario').classList.add('form-cerrar');
        }
      }
    }
    for(let form of Array.from(document.querySelectorAll("#commentDestroyedByUser")))
    {
      form.onsubmit = function(event)
      {
        if(!confirm('Desea eliminar el comentario?'))
        {
          event.preventDefault();
        } else 
        {
          toastr.success('Se elimino correctamente');
        }
      }
    }
    
    for(let form of Array.from(document.querySelectorAll("#commentDestroy")))
    {
      form.onsubmit = function(event)
      {
        if(!confirm('Desea eliminar el comentario?'))
        {
          event.preventDefault();
        } else 
        {
          toastr.success('Se elimino correctamente');
        }
      }
    }
    for(let form of Array.from(document.querySelectorAll(".form-comentarios")))
    {
        form.querySelector("[name=comentario]").onkeyup = function(event)
         { 
           if(this.value.length == 50)
          {
            toastr.info('Solo se permite 50 caracteres');
          }
        }
      }
}
</script>
@endsection