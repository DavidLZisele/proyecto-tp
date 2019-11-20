<?php 
    $usuario = null;
    $password = null;
    $nombre = null;
    $apellido = null;
    $email = null;
    $errores = [];
    if($_POST)
    {
        $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : '';
        $password = isset($_POST["contraseña"]) ? $_POST["contraseña"] : '';
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : '';
        $email = isset($_POST["email"]) ? $_POST["email"] : ''; 
        if(strlen($usuario)>=5 && strlen($password)>=5 && strlen($email)>=5 && strlen($nombre)>=3 && !is_numeric($nombre) && strlen($apellido)>=3 && !is_numeric($apellido)   )
        {
            header('Location:http://localhost/proyecto-tp/index.html');
        } if (strlen($usuario)<=5)
        {
            $errores[0] = "El usuario debe tener mas de 5 caracteres";
        }
         if (strlen($password)<=5)
        {
            $errores[1] = "La contraseña debe tener mas de 5 caracteres";
        }  if( strlen($nombre)<3 || is_numeric($nombre))
        {
            $errores[2] = "Ingrese un nombre valido, no puede tener numeros ni ser vacio ";
        }
        if( strlen($apellido)<3 || is_numeric($apellido))
        {
            $errores[3] = "Ingrese un apellido valido, no puede tener numeros ni ser vacio";
        }  if (strlen($email)<=5)
        {
            $errores[4] = "El email debe tener mas de 5 caracteres";
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
    <title>Document</title>
</head>

<body>
    <div class="container col-12 col-md-12 col-lg-12 col-xl-12 contenedor-registro">
        <div class="fondo col-lg-8">

        </div>
        <section class="col-lg-4">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="form-registro">
                <div class="col-12">
                    <label class="col-6" for="usuario">Usuario</label>
                    <input class="col-6" type="text" name="usuario" id="usuario" value="<?= $usuario ?>">
                     <?php if(strlen($usuario)<=5 && count($errores)!=0) : ?>
                        <p class="error col-12">
                            <?= $errores[0] ?>
                        </p>
                     <?php endif; ?>     
                </div>
                <div class="col-12">
                    <label class="col-6" for="contraseña">Contraseña</label>
                    <input class="col-6" type="password" name="contraseña" id="contraseña" value="<?= $password ?>">
                    <?php if(strlen($password) <=5 && count($errores)!=0) : ?>
                        <p class="error col-12">
                            <?= $errores[1] ?>
                        </p>
                     <?php endif; ?>   
                </div>
                <div class="col-12">
                    <label class="col-6" for="nombre">Nombre</label>
                    <input class="col-6" type="text" name="nombre" id="nombre" value="<?= $nombre ?>">
                    <?php if( (strlen($nombre)<3 || is_numeric($nombre)) && count($errores)!=0) : ?>
                        <p class="error col-12">
                            <?= $errores[2]?>
                        </p>
                     <?php endif; ?>  
                </div>
                <div class="col-12">
                    <label class="col-6" for="apellido">Apellido</label>
                    <input class="col-6" type="text" name="apellido" id="apellido" value="<?= $apellido ?>">  
                    <?php if( (strlen($apellido)<3 || is_numeric($apellido)) && count($errores)!=0 ) : ?>
                        <p class="error col-12">
                            <?= $errores[3] ?>
                        </p>
                     <?php endif; ?>  
                </div>
                <div class="col-12">
                    <label class="col-6" for="email">Email</label>
                    <input class="col-6" type="email" name="email" id="email" value="<?= $email ?>"> 
                    <?php if(  strlen($email)<=5 && count($errores)!=0) : ?>
                        <p class="error col-12">
                            <?= $errores[4] ?>
                        </p>
                     <?php endif; ?>    
                </div>
                <div class="col-12 bloque-boton-registro">
                    <button class="col-6" type="submit">Registrarte</button>

                </div>
    </form>
    </section>
    </div>

</body>

</html>