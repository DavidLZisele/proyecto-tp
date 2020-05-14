@extends('layouts.head')
@section('title')
    FAQ
@endsection 
@section('content')
        <div class="container col-12 contenedor-faq">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <header class="header-faq col-12">
                <img src="img/road-to-the-social.jpg" alt="foto">
            </header>
            <section class="section-faq ">
                <article class="article-faq col-lg-10 col-xl-6">
                    <h1 class="">
                         Preguntas frecuentes
                    </h1>
                    <div class="preguntas">

                        <div class="col-12 ">
                            <h2 class="col-6">
                                ¿Cómo funciona Social?
                            </h2>
                            <p class="col-6">
                                Muy sencillo, registrate, te logeas y empezas a disfrutar
                                de todo lo que te ofrecemos.
                            </p>
                        </div>
                        <div class="col-12">
                            <h2 class="col-6">
                                ¿Es pago?
                            </h2>
                            <p class="col-6">
                                Es gratis, y lo seguira siendo.
                            </p>
                        </div>
                        <div class="col-12 ">
                            <h2 class="col-6">
                                ¿Puedes eliminar tu cuenta?
                            </h2>
                            <p class="col-6">
                                Puedes hacerlo en cualquier momento que lo desees.
                            </p>
                        </div>
                        <div class="col-12">
                            <h2 class="col-6">
                                ¿Alguien te molesta?
                            </h2>
                            <p class="col-6">
                                Puedes bloquearlo y reportarlo, nuestros administradores
                                se haran cargo del problema.
                            </p>
                        </div>
                    </div>
                    </article>
                    
            <article class="article-faq-form col-12 col-lg-10 col-xl-5" >
            <h2>   
                 Envianos tus dudas
            </h2>

            <form class="form-faq col-lg-6" action="{{route("faq.store")}}" method="post">
                @csrf
                <label for="email">Email</label>
                <input class="col-10" type="email" name="email" id="email" value="{{old('email')}}" 
                class="form-control @error('email') is-invalid @enderror" @error('email') placeholder="{{ $message }}"@enderror required>

            <label for="mensaje">Mensaje</label>
            <textarea class="col-10" name="mensaje" id="mensaje" value="{{old('mensaje')}}" cols="30" rows="7" class="form-control @error('mensaje') is-invalid @enderror"
            @error('mensaje') placeholder="{{ $message }}"@enderror required></textarea>
                <br>
                <button class=" col-10" type="submit">Enviar</button>
 

            </form>
            </article>

        </section>
        <footer id="footer-index" class="col-12 col-lg-12">
            <div class="bloque-footer col-12">
                <div class="col-3">
                    <a class="col-12" href="{{route("home")}}">Inicio</a>
                </div>
                <div class="col-3">
                        <a class="col-12" href="{{route("login")}}">Iniciar Sesion</a>
                    </div>
                <div class="col-3">
                    <a href="{{route("register")}}" class="col-12">Registro</a>
                </div>
                <div class="col-3">
                    <p class="col-12">
                        © 2019 Social.
                    </p>
                </div>
            </div>

        </footer>
    </div>
    <script>
        window.onload = function()
        {
            document.querySelector('form').onsubmit = function(event)
            {
                let inputs = Array.from(this.elements);
                inputs.pop();
                inputs.shift();
                console.log(inputs);
                let resp = false;
                for(let input of inputs)
                {
                    if(input.getAttribute('name')== "email" || input.getAttribute('name')== "mensaje")
                    {
                        input.value = input.value.trim();
                        if(input.value == "")
                        {
                            resp = true;
                            break;
                        }
                    }
                }
                if(resp){
                    toastr.error('Campos vacios');
                    event.preventDefault();
                }
            }
        }
    </script>
@endsection
