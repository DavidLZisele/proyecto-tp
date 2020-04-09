<?php

$pregunta = [];
$errores = [];
if($_POST)
{
    $preguntas_js = file_get_contents("preguntas.json");
    $preguntas = json_decode($preguntas_js,true);
    if(isset($_POST['email']))
    {
        if(empty($_POST['email']))
        {
            $errores["email"] = "Email vacio";
        }
        elseif ( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) )
        {
            $errores["email"] = "Ingresar un email valido";
        }
    }
    if(isset($_POST['mensaje']))
    {
        if(empty($_POST['mensaje']))
        {
            $errores["mensaje"] = "Mensaje vacio";
        }
    } // ESTA CORRECTO

    if (count($errores) === 0)
    {
        $pregunta['email'] = $_POST['email'];
        $pregunta['mensaje'] = $_POST['mensaje'];
        $preguntas[] = $pregunta;
        $preguntas_js = json_encode($preguntas);
        file_put_contents("preguntas.json",$preguntas_js);
    }

}


?>
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

            <form class="form-faq col-lg-6" action="faq.php" method="post">
                <label for="email">Email</label>
                <input class="col-10" type="email" name="email" id="email" >
                <small> <?=isset($errores["email"]) ? $errores["email"] : "" ?> </small>

                <label for="mensaje">Mensaje</label>
                <textarea class="col-10" name="mensaje" id="mensaje" value="" cols="30" rows="7" ></textarea>
                <small> <?=isset($errores["mensaje"]) ? $errores["mensaje"] : "" ?> </small>
    
                <br>
                <button class="btn btn-dark col-10" type="submit">Enviar</button>
 

            </form>
            </article>

        </section>

        
        
        <footer id="footer-index" class="col-12 col-lg-12">
            <div class="bloque-footer col-12">
                <div class="col-3">
                    <a class="col-12" href="index.html">Inicio</a>
                </div>
                <div class="col-3">
                        <a class="col-12" href="login.php">LogIn</a>
                    </div>
                <div class="col-3">
                    <a href="registro.php" class="col-12">Registro</a>
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