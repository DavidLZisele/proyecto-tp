@extends('layouts.head')

@section('funciones')
<?php
$usuario = Auth::user();
?>
@endsection

@section('content')
<style>
  body{
    background: #333;
  }
</style>
    <div class="container col-12 contenedor-datousuario">
        <div class="accordion col-8 col-md-6 col-xl-4" id="accordionExample">
        <a href="{{route('categoria.index')}}" class="volver">
          <i class="fa fa-sign-out" aria-hidden="true" style="transform:rotateY(180deg);font-size:20px"></i>
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
      <form action="{{route('datos.cambiarDatos', $usuario)}}" method = "POST" id="form-cambiarDatos">
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
                 <p class="p-provincias-ciudades">
                    <select name="provincias" id="provincias" class="col-6">

                    </select>
                    <select name="ciudades" id="ciudades" class="col-5">

                    </select>
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
      <form action="{{route('datos.cambiarPassword', $usuario)}}" method = "POST" id="form-cambiarPass">
        @csrf 
        @method('PUT')
            <div>
                <p>
                <input type="password" name="password1" id="password1" value="" placeholder ="Contraseña actual">
                </p>
                 <p>
                 <input type="password" name="password2" id="password1" value="" placeholder ="Contraseña nueva">
                 </p>
                 <p>
                 <input type="password" name="password3" id="password1" value="" placeholder ="Confirmar contraseña">
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
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
      <form action="{{route('usuario.destroy',$usuario)}}" method="POST" class="form-eliminar-usuario">
          @csrf
          @method('delete') 
          <button type="submit" style="background-color:#607d8b !important;border:0;color:white;padding-left:15px;font-size:14px;">
            Eliminar cuenta
          </button>  
        </form>
      </h2>
    </div>
    </div>
  </div>
</div>
    </div>
    <script>
      function cargarProvincias()
      {
        fetch("http://localhost:3000/ciudades")
        .then(response=>response.json())
        .then(data =>{
            let select = document.querySelector('#provincias');
            let array = [];
            for(let prov of data )
            {
                array.push(prov.provincia);
            }
            array = array.sort();
            for(let prov of array)
            {
              let opt = document.createElement('option');
              opt.append(document.createTextNode(prov))
              opt.value = prov;
              select.append(opt);
            }
        });
      }
      window.onload = function()
      {
        cargarProvincias();
        document.querySelector('#provincias').onchange = function()
        {
          let select = document.querySelector('#ciudades');
          select.innerHTML = "";
          fetch("http://localhost:3000/ciudades")
          .then(response=>response.json())
          .then(data => 
          {
              let provincia = "";
              data = data.sort();
              for(let prov of data)
              {
                if(prov.provincia == this.options[this.selectedIndex].value)
                {
                  provincia = prov;
                  break;
                }
              }
              select = document.querySelector('#ciudades');
              let array = [];
              for(let ciud of  provincia.localidad)
              {
                array.push(ciud);
              }
              array = array.sort();
              for(let ciu of array)
              {
                let opt = document.createElement('option');
                opt.append(document.createTextNode(ciu))
                opt.value = ciu;
                select.append(opt);
              }
          }
          )
        }
        document.getElementById('form-cambiarDatos').onsubmit = function(event)
        {
          let inputs = Array.from(this.elements);
          inputs.pop();
          inputs.shift();
          let validarCiudad = /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;
          let resp1 = false;
          let resp2= false;
            for(let input of inputs)
              {
                if(input.getAttribute('name')=="universidad" || input.getAttribute('name')=="escuela" || input.getAttribute('name')=="ciudad")
                  {
                      if(input.value == "")
                    {
                      resp1 = true;
                      break;
                    } if(input.getAttribute('name')=="ciudad")
                       {
                          if(!validarCiudad.test(input.value))
                          {
                            resp2 = true;
                          }
                       }
                  }
              }
             if(resp1)
                 {

                } else if(resp2)
                {
                    event.preventDefault();
                    toastr.error('Ciudad no permite numeros');
                    this.value = "";
                }
        }
        document.getElementById('form-cambiarPass').onsubmit = function(event)
        {
          let inputs = Array.from(this.elements);
          inputs.pop();
          inputs.shift();
          let resp1 = false;
          let resp2 = false;
            for(let input of inputs)
              {
                if(input.getAttribute('name')=="password1" || input.getAttribute('name')=="password2" || input.getAttribute('name') == "password3")
                  {
                      if(input.value == "")
                    {
                      resp1 = true;
                      break;
                    } else if(input.value.length < 6)
                    {
                      resp2 = true;
                    }
                  }
              }
             if(resp1)
                 {
                    event.preventDefault();
                    toastr.error('Campo vacio');
                }
            if(resp2){
                    event.preventDefault();
                    toastr.error('Password solo acepta mas de 6 caracteres');
            }
        }
        document.querySelector('[name=universidad]').onblur= function()
           {
               this.value = this.value.trim();
               this.value = this.value[0].toUpperCase() + this.value.slice(1);
               let uni = "";
               for(let i = 0; i< this.value.length;i++)
               {
                 if(this.value[i] != " ")
                 {
                    uni += this.value[i];
                 } else
                 {
                    uni += " " + this.value[i+1].toUpperCase();
                    i++;
                 }
               }
               this.value = uni;
           }
           document.querySelector('[name=escuela]').onblur= function()
           {
            this.value = this.value.trim();
               this.value = this.value[0].toUpperCase() + this.value.slice(1);
               let esc = "";
               for(let i = 0; i< this.value.length;i++)
               {
                 if(this.value[i] != " ")
                 {
                    esc += this.value[i];
                 } else
                 {
                    esc += " " + this.value[i+1].toUpperCase();
                    i++;
                 }
               }
               this.value = esc;
           }
           document.querySelector('.form-eliminar-usuario').onsubmit = function(e)
           {
             if(!confirm('Estas seguro de eliminar tu cuenta?'))
             {
               e.preventDefault();
             }
           }
      }
    </script>
@endsection