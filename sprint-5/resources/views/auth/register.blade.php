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
<div class="container col-12 col-md-12 col-lg-12 col-xl-12 contenedor-registro">
    <div class="fondo col-lg-12 mb-5 mb-xl-0 col-xl-7">

    </div>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                     @enderror
              </div>
        </div>
        <div class="form-group row">
            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('surname') }}</label>

             <div class="col-md-6">
                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="name" autofocus>

                @error('surname')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                   </span>
                @enderror
             </div>
            </div>

            <div class="form-group row">
               <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>
             </div>

            <div class="form-group row">
               <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
             </div>

             <div class="form-group row">
                 <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                    <div class="col-md-6 photo">
                       <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value="{{ old('photo') }}" required autocomplete="name" autofocus>
                        @error('photo')
                           <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            </div>
                        </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                       <button type="submit" class="boton-registro">
                            {{ __('Register') }}
                        </button>
                 </div>
              </div>
      </form>
      <footer id="footer-registro" class="col-12 col-lg-12 mt-auto">
        <div class="bloque-footer col-12">
             <div class="col-3">
                <a class="col-12" href="index.html">Inicio</a>
            </div>
            <div class="col-3">
                <a class="col-12" href="login.php">LogIn</a>
            </div>
            <div class="col-3">
                <a href="faq.php" class="col-12">F.A.Q</a>
            </div>
            <div class="col-3">
                <p>
                    © 2019 Social.
                </p>
            </div>
        </div>

</footer>     
</div>
</html>