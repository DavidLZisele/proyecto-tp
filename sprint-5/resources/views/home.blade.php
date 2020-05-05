@extends('layouts.head')
@section('title')
    Home
  @endsection
@section('content')
    <div class="container col-12 col-md-12 col-lg-12 col-xl-12" id="index">
        <div class="bloque-nombre-red col-12 col-xl-8">

        </div>

        <section id="index-section" class="col-12 col-xl-4">
            <article class="article-index" class="col-8 col-xl-12">
                <div class="bloque-article">
                    <i class="fa fa-search col-1" aria-hidden="true"></i>
                    <h3 class="col-11">
                        Sigue lo que te interesa
                    </h3>
                </div>
                <div class="bloque-article">
                    <i class="fa fa-users col-1" aria-hidden="true"></i>
                    <h3 class="col-11">
                        Entérate de lo que está hablando la gente.
                    </h3>
                </div>
                <div class="bloque-article">
                    <i class="fa fa-comment-o col-1" aria-hidden="true"></i>
                    <h3 class="col-11">
                        Únete a la conversación.
                    </h3>
                </div>
                <div class="registrate col-12">
                    <a href="{{route("register")}}">Registrate</a>
                </div>
                <div class="login col-12">
                    <a href="{{route("login")}}">Inicia Sesion</a>
                </div>

            </article>
        </section>
        <footer id="footer-index" class="col-12 col-lg-12">
            <div class="bloque-footer col-12">
                <div class="col-4">
                    <a class="col-12" href="{{route("register")}}">Registro</a>
                </div>
                <div class="col-4">
                    <a href="{{route("faq.create")}}" class="col-12">F.A.Q</a>
                </div>
                <div class="col-4">
                    <p class="col-12">
                        © 2019 Social.
                    </p>
                </div>
            </div>
    </div>

    </footer>
@endsection
