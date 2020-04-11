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
    <title>Registro</title>
</head>

<body>
    <div class="container col-12 col-md-12 col-lg-12 col-xl-12 contenedor-registro">
        <div class="fondo col-lg-12 mb-5 mb-xl-0 col-xl-7">

        </div>
        <section class="col-lg-12 col-xl-5 section-registro">
        <form action="{{route('register')}}" method="POST" enctype ="multipart/form-data" class="form-registro">
                @csrf
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="email">Email</label>
                    <input class="col-6 form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{old('email')}}">
                    
                        @error('email') 
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="password">Contraseña</label>
                <input class="col-6 form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{old('password')}}">
                    
                        @error('password')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="name">Nombre</label>
                <input class="col-6 form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{old('name')}}">
                    
                        @error('name')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror 
                   
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="surname">Apellido</label>
                <input class="col-6 form-control @error('surname') is-invalid @enderror" type="text" name="surname" id="surname" value="{{old('surname')}}">  
                
                        @error('surname')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror 
                   
                    
                </div>
                <div class="col-8 col-md-6 col-xl-8 bloque-foto-perfil">   
                    <div class="bloque-foto col-6">
                        <input class="col-12 foto_perfil form-control @error('photo') is-invalid @enderror" type="file" name="photo" id="foto-perfil-registro" > 
                        <i class="fa fa-upload imagen-upload" aria-hidden="true"></i>
                         <p >
                            Foto
                         </p>  
                    </div>
                        @error('photo')
                        <span class="invalid-feedback alerta" role="alert">
                                <strong>{{ $message }}</strong>
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
                    <a class="col-12" href="{{route('login')}}">LogIn</a>
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

</body>

</html>