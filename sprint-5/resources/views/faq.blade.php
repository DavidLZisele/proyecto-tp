<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Montserrat:400,700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>F.A.Q.</title>
</head>

<body>
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
            <article class="article-faq col-lg-6">
                <h1 class="">
                    Preguntas frecuentes
                </h1>
                <div class="col-lg-6 ">
                    <h2 class="col-6">
                        ¿Cómo funciona Social?
                    </h2>
                    <p class="col-6">
                        Muy sencillo, registrate, te logeas y empezas a disfrutar
                        de todo lo que te ofrecemos.
                    </p>
                </div>
                <div class="col-lg-6">
                    <h2 class="col-6">
                        ¿Es pago?
                    </h2>
                    <p class="col-6">
                        Es gratis, y lo seguira siendo.
                    </p>
                </div>
                <div class="col-lg-6 ">
                    <h2 class="col-6">
                        ¿Puedes eliminar tu cuenta?
                    </h2>
                    <p class="col-6">
                        Puedes hacerlo en cualquier momento que lo desees.
                    </p>
                </div>
                <div class="col-lg-6">
                    <h2 class="col-6">
                        ¿Alguien te molesta?
                    </h2>
                    <p class="col-6">
                        Puedes bloquearlo y reportarlo, nuestros administradores
                        se haran cargo del problema.
                    </p>
                </div>
            </article>

            <article class="article-faq-form col-12 col-lg-6" >
            <h2>   
                 Envianos tus dudas
            </h2>

            <form class="form-faq col-lg-6" action="{{route("faq.store")}}" method="post">
                @csrf
                <label for="email">Email</label>
                <input class="col-10" type="email" name="email" id="email" value="{{old('email')}}" 
                class="form-control @error('email') is-invalid @enderror" @error('email') placeholder="{{ $message }}"@enderror></textarea>

            <label for="mensaje">Mensaje</label>
            <textarea class="col-10" name="mensaje" id="mensaje" value="{{old('mensaje')}}" cols="30" rows="7" class="form-control @error('mensaje') is-invalid @enderror"
            @error('mensaje') placeholder="{{ $message }}"@enderror></textarea>
                <br>
                <button class="btn btn-dark col-10" type="submit">Enviar</button>
 

            </form>
            </article>

        </section>
        
        <footer id="footer-index" class="col-12 col-lg-12">
            <div class="bloque-footer col-12">
                <div class="col-3">
                    <a class="col-12" href="{{route("home")}}">Inicio</a>
                </div>
                <div class="col-3">
                        <a class="col-12" href="{{route("login")}}">Login</a>
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
</body>

</html>