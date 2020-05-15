@extends('layouts.head')
   @section('title')
   Registro
   @endsection
@section('content')
<style>
    body{
        background: white;
    }
</style>
    <div class="container col-12 col-md-12 col-lg-12 col-xl-12 contenedor-registro">
        <div class="fondo col-lg-12 mb-5 mb-xl-0 col-xl-7">

        </div>
        <section class="col-lg-12 col-xl-5 section-registro">
        <form action="{{route('register')}}" method="POST" enctype ="multipart/form-data" class="form-registro">
                @csrf
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="email">Email</label>
                    <input class="col-6 form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{old('email')}}" required>
                    
                        @error('email') 
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="password">Contraseña</label>
                <input class="col-6 form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{old('password')}}" required>
                    
                        @error('password')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="name">Nombre</label>
                <input class="col-6 form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{old('name')}}" required>
                    
                        @error('name')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror 
                   
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="surname">Apellido</label>
                <input class="col-6 form-control @error('surname') is-invalid @enderror" type="text" name="surname" id="surname" value="{{old('surname')}}" required>  
                
                        @error('surname')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror 
                   
                    
                </div>
                <div class="col-8 col-md-6 col-xl-8 bloque-foto-perfil">   
                    <div class="bloque-foto col-6">
                        <input class="col-12 foto_perfil form-control @error('photo') is-invalid @enderror" type="file" name="photo" id="foto-perfil-registro" required> 
                        <i class="fa fa-upload imagen-upload" aria-hidden="true"></i>
                         <p >
                            Foto
                         </p>  
                    </div>
                        @error('photo')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>El campo Foto es obligatorio</strong>
                        </span>
                        @enderror
    
                </div>
                
                <div class="col-12 col-md-6 col-xl-12 recordar-registro">
                        <input type="checkbox" name="recordar" id="recordar" value="true"> 
                        <span>
                         Recordarme?
                        </span>
                </div>
                <div class="col-12 col-md-6 col-xl-12 bloque-boton-registro">
                    <button class="col-6" type="submit">Registrarte</button>
                </div> 
    </form>
    </section>

    <footer id="footer-registro" class="col-12 col-lg-12 mt-auto">
            <div class="bloque-footer col-12">
                 <div class="col-3">
                    <a class="col-12" href="{{route('home')}}">Inicio</a>
                </div>
                <div class="col-3">
                    <a class="col-12" href="{{route('login')}}">Iniciar Sesion</a>
                </div>
                <div class="col-3">
                    <a href="{{route("faq.create")}}" class="col-12">F.A.Q</a>
                </div>
                <div class="col-3">
                    <p>
                        © 2019 Social.
                    </p>
                </div>
            </div>

    </footer>

    </div>
    <script>
        window.onload = function()
       {
           document.querySelector('.form-registro').onsubmit = function(event)
           {
               let resp1 = false;
               let resp2 = false;
               let resp3 = false;
               let resp4 = false;
               let validarEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;
               let validarUsuario = /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;
               inputs = Array.from(this.elements);
               inputs.pop();
               inputs.shift();
               for(let input of inputs)
               {
                   if(input.getAttribute('name') != "photo")
                   {
                       if(input.value == "")
                       {
                            resp1 = true;                         
                       } else
                        if(input.getAttribute('name')=="name" || input.getAttribute('name')=="surname")
                        {
                            if(!validarUsuario.test(input.value))
                            {
                                 resp3 = true; 
                            }
                        } else if(input.getAttribute('name')=="email")
                        {
                            if(!validarEmail.test(input.value))
                            {
                                 resp2 = true;
                            }
                        } else if(input.getAttribute('name')=="password")
                        {
                            if(input.value.length < 6)
                            {
                                resp4 = true;
                                input.value = "";
                            }
                        }
                   }
               }
               if(resp1 || resp2 || resp3 || resp4)
               {
                   if(resp1)
                   {
                    toastr.error('Campos vacios');
                   }
                   if(resp2)
                   {
                    toastr.error('No es un mail valido');
                   }
                   if(resp3)
                   {
                    toastr.error('Nombre y apellido no aceptan numeros, ni caracteres especiales');
                   }
                   if(resp4)
                   {
                    toastr.error('Password demasiado corta, mas de 6 caracteres');
                   }
                   event.preventDefault();
               }
           }
           document.querySelector('[name=name]').onblur= function()
           {
               this.value = this.value.trim();
               this.value = this.value.toLowerCase();
               this.value = this.value[0].toUpperCase() + this.value.slice(1);
               let nom = "";
               for(let i = 0; i< this.value.length;i++)
               {
                 if(this.value[i] != " ")
                 {
                    nom += this.value[i];
                 } else
                 {
                    nom += " " + this.value[i+1].toUpperCase();
                    i++;
                 }
               }
               this.value = nom;
           }
           document.querySelector('[name=surname]').onblur= function()
           {
               this.value = this.value.trim();
               this.value = this.value.toLowerCase();
               this.value = this.value[0].toUpperCase() + this.value.slice(1);
               let ape = "";
               for(let i = 0; i< this.value.length;i++)
               {
                 if(this.value[i] != " ")
                 {
                    ape += this.value[i];
                 } else
                 {
                    ape += " " + this.value[i+1].toUpperCase();
                    i++;
                 }
               }
               this.value = ape;
           }
           document.querySelector('[name=email]').onblur= function()
           {
            this.value = this.value.trim();
           }
       }
   </script>
@endsection