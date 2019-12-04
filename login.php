<?php
session_start();
    $usuario = ""; 
    $password ="";
    $errores = [];
    $user = [];
    $bandera = 0;
    $index_usuario = false;
    $usuarios_json = file_get_contents("usuarios.json");
    $usuarios = json_decode($usuarios_json,true);
    if(isset($_COOKIE["usuario"])&& isset($_COOKIE["index"]))
    {
        $user = json_decode($_COOKIE["usuario"],true);
        $usuario = $user["usuario"];
        $password = $user["password"];
        $_SESSION["usuario"] = $user;
        $_SESSION["index"] = $_COOKIE["index"]; 
        header("Location:perfil.php");
    } 
    else if(isset($_SESSION["usuario"]))
    {
        header("Location:perfil.php");
    }
    else if($_POST)
 {
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "" ;
    $password = isset($_POST["password"]) ? $_POST["password"] : "" ;
    
    $usernames = array_column($usuarios, 'usuario');
    $index_usuario = array_search($usuario, $usernames);
     if($index_usuario !== false)
    {
        if(password_verify($password, $usuarios[$index_usuario]["password"]))
        {
            $user = $usuarios[$index_usuario];
            $_SESSION["usuario"] = $user;
            $_SESSION["index"] = $index_usuario;
            if(isset($_POST["recordar"]))
            {
                setcookie("usuario", json_encode($user), time() + 60*60*24*365);
                setcookie("index", $index_usuario, time() + 60*60*24*365);
            }
            header("Location:perfil.php");
        } else 
        {
            $bandera = 1;
            $errores[2] = "Contraseña incorrecta";
        }     
    } else if($index_usuario === false )
    {
        $errores[0] = "No se encontro el usuario";
    } 
    else if($usuario == '' && $password != '')
    {
        $errores[1] = "Ingrese usuario";
    }else if($usuario != '' && $password == '')
    {
        $errores[2] = "Ingrese contraseña";
    } else if($usuario == '' && $password == '')
    {
        $errores[0] = "Ingrese usuario y contraseña";
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
    <title>LogIn</title>
</head>

<body>
    <div class="container col-12 col-md-12 col-lg-12 col-xl-12 contenedor-login">
        <section>
            <article>
                <div class="col-2">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user"
                        class="svg-inline--fa fa-user fa-w-14 " role="img" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512">
                        <path fill="currentColor"
                            d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z">
                        </path>
                    </svg>
                </div>
                <form action="login.php" method="POST">
                    <p class="col-12">
                        <label for="usuario" class="col-12">Usuario</label>
                        <input type="text" name="usuario" id="usuario" class="col-9" value="<?= $usuario ?>">
                         <?php if($usuario == ''&& $password != '' && count($errores)!=0) : ?>
                          <p class="error">
                              <?= $errores[1]?>
                         </p>
                          <?php endif ; ?>  
                         
                    </p>
                    <p class="col-12">
                        <label for="password" class="col-12">Contraseña</label>
                        <input type="password" name="password" id="password" class="col-9" value="<?= $password ?>">
                        <?php if( ($password == '' && $usuario != '' || $bandera == 1)  && count($errores)!=0) : ?>
                          <p class="error">
                              <?= $errores[2]?>
                          </p>
                          <?php endif ; ?>  
                    </p>
                    <p class="col-12 recordar">
                        <input type="checkbox" name="recordar" id="recordar" value="true"> 
                        <span>
                         Recordarme?
                        </span>
                    </p>
                    <p class="col-12">
                        <button type="submit" class="col-9">Ingresar</button>
                            <?php if(($usuario == '' && $password == '' ||  $index_usuario === false ) && count($errores)!=0) : ?>
                            <p class="error">
                              <?= $errores[0] ?>
                          </p>
                          
                          <?php endif ; ?>
                    </p>
                 

                </form>
            </article>

        </section>
        <footer id="footer-login" class="col-12 col-lg-12">
            <div class="bloque-footer col-12">
                 <div class="col-3">
                    <a class="col-12" href="index.html">Inicio</a>
                </div>
                <div class="col-3">
                    <a class="col-12" href="registro.php">Registro</a>
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
</body>

</html>