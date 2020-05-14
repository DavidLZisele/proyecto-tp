@extends('layouts.head')
    @section('title')
    LogIn
    @endsection
@section('content')
    <div class="container col-12 contenedor-login">
            <main>
                <div class="col-2">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user"
                        class="svg-inline--fa fa-user fa-w-14 " role="img" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512">
                        <path fill="currentColor"
                            d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z">
                        </path>
                    </svg>
                </div>

                <form id="form-login" action="{{route('login')}}" method="POST">
                    @csrf

                        <label for="email" class="label-login">Usuario</label>
                        <input id="input-login" type="text" name="email" id="email" class=" form-control @error('email') is-invalid @enderror" value="{{old('email')}}" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="password" class="label-login">Contraseña</label>
                        <input id="input-login2" type="password" name="password" id="password" class=" form-control @error('password') is-invalid @enderror" value="{{old('password')}}" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert" style="margin-bottom:20px">
                                     <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    
                            <input type="checkbox" name="remember"  value="true" class="recordarme-login"> 
                            <span class="recordarme-login">
                             Recordarme?
                            </span>  
                            
                    <button id="boton-login" type="submit" >Ingresar</button>          
                </form>
            </main>

        <footer id="footer-login" class="col-12 col-lg-12">
            <div class="bloque-footer col-12">
                 <div class="col-3">
                    <a class="col-12" href="{{route('home')}}">Inicio</a>
                </div>
                <div class="col-3">
                    <a class="col-12" href="{{route('register')}}">Registro</a>
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
            document.getElementById('form-login').onsubmit = function(event)
            {
                let resp1 = false;
                let resp2 = false;
                let validar = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;
                inputs = Array.from(this.elements);
                inputs.pop();
                inputs.shift();
                for(let input of inputs)
                {
                    console.log(input);
                    if(input.value == "")
                    {
                        resp1 = true;
                        break;
                    } else if(input.getAttribute('name')== "email")
                    {
                        if(!validar.test(input.value))
                         {
                             resp2 = true;
                             break;
                        }
                    }                
                }
                if(resp1)
                {
                    event.preventDefault();
                    toastr.error('Campos vacios');
                }
                if(resp2)
                {
                    event.preventDefault();
                    toastr.error('No es un mail valido');
                
                }
            }
        }
    </script>
    
@endsection