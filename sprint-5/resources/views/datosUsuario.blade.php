<?php
$usuario = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Montserrat:400,700&display=swap" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container col-12 contenedor-datousuario">
        <div class="accordion col-8 col-md-6 col-xl-4" id="accordionExample">
        <a href="{{route('categoria.index')}}" class="volver">
              Volver
        </a>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Cambiar datos personales
        </button>
      </h2>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
      <form action="{{route('datos.cambiarDatos', $usuario)}}" method = "POST">
        @csrf 
        @method('PUT')
            <div>
                 <p>
                  Dia de nacimiento
                  <br>
                 <input type="date" name="fecha_cumpleanios" id="fecha-cumple" value="{{$usuario->fecha_cumpleanios}}"  class="form-control @error('fecha_cumpleanios') is-invalid @enderror">
                 @error('fecha_cumpleanios')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                 @enderror
                 </p>
                 <p>
                 @if(isset($usuario->escuela))
                 <input type="text" name="escuela" id="escuela" value="{{$usuario->escuela}}" placeholder="Escuela"  class="form-control @error('escuela') is-invalid @enderror">
                 @else 
                  <input type="text" name="escuela" id="escuela" value="" placeholder="Escuela" class="form-control @error('escuela') is-invalid @enderror">
                 @endif
                 @error('escuela')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                 @enderror
                 </p>
                 <p>
                 @if(isset($usuario->universidad))
                 <input type="text" name="universidad" id="universidad" value="{{$usuario->universidad}}" placeholder="Universidad"  class="form-control @error('universidad') is-invalid @enderror">
                 @else
                  <input type="text" name="universidad" id="universidad" value="" placeholder="Universidad"  class="form-control @error('universidad') is-invalid @enderror">
                 @endif
                 @error('universidad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                  @enderror
                 </p>
                 <p>
                 @if(isset($usuario["ciudad"]))
                 <input type="text" name="ciudad" id="ciudad" value="{{$usuario->ciudad}}" placeholder="ciudad"  class="form-control @error('ciudad') is-invalid @enderror">
                 @else
                  <input type="text" name="ciudad" id="ciudad" value="" placeholder="ciudad"  class="form-control @error('ciudad') is-invalid @enderror">
                @endif
                @error('ciudad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
                 </p>
                 <p>
                 Situación sentimental
                 <br>
                 <select name="relacion" id="relacion" value ="{{$usuario->relacion}}" class="form-control">
                    <option value="Soltero">Soltero</option>
                    <option value="En pareja">En pareja</option>
                    <option value="Casado">Casado</option>
                    <option value="Divorciado">Divorciado</option>
                    </select>           
                 </p>
                 <p>
                     <button type="submit" name="cambiardatos" id="cambiardatos">Aceptar</button>
                 </p>        
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Cambiar contraseña
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
      <form action="{{route('datos.cambiarPassword', $usuario)}}" method = "POST">
        @csrf 
        @method('PUT')
            <div>
                <p>
                <input type="password" name="password1" id="" value="" placeholder ="Contraseña actual">
                </p>
                 <p>
                 <input type="password" name="password2" id="" value="" placeholder ="Contraseña nueva">
                 </p>
                 <p>
                 <input type="password" name="password3" id="" value="" placeholder ="Confirmar contraseña">
                 </p>
                 <p>
                     <button type="submit" name="cambiarcontraseña" id="cambiarcontraseña">Aceptar</button>
                     <br>
                   
                     @if(session('status'))
                     <p style="color:red">
                      {{session('status')}}
                     </p>
                    
                     @endif
                 </p>        
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Cambiar foto
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
      <form action="{{route('datos.cambiarFoto', $usuario)}}" method = "POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
            <div>
                <p class="cambiarfotoperfil">
                <i class="fa fa-camera" aria-hidden="true"></i>
                  <span>Cambiar foto</span>
                <input type="file" name="cambiar-foto" id="cambiar-foto" class="form-control @error('cambiar-foto') is-invalid @enderror">
                @error('cambiar-foto')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                    @enderror
                </p>
                 <p>
                     <button type="submit" name="cambiarfoto" id="cambiarfoto">Aceptar</button>              
                 </p>        
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
    </div>
</body>
</html>