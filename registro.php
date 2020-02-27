<?php 
session_start();
include("funciones.php");
    $usuario = null;
    $password = null;
    $nombre = null;
    $apellido = null;
    $email = null;
    $errores = [];
    $ext = null;
    $validar_archivo = null;
    $bandera = 0;
    $foto = [];
    $id = 0;
    $validarEmail = '';
    if(isset($_COOKIE["usuario"]))
    {
        $_SESSION["usuario"] = json_decode($_COOKIE["usuario"],true);
        header("Location:perfil.php");
    }
    else if(isset($_SESSION["usuario"]))
    {
        header("Location:perfil.php");
    }
    else if($_POST)
    {
        $datos = $_POST;
        $password = isset($_POST["contraseña"]) ? $_POST["contraseña"] : '';
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : '';
        $email = isset($_POST["email"]) ? $_POST["email"] : ''; 
        $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : [];
        $ext =  pathinfo($foto["name"],PATHINFO_EXTENSION);
        $validar_archivo = $foto["error"];
        if(strlen($password)>=5 && strlen($email)>=5 && strlen($nombre)>=3 && !is_numeric($nombre) && strlen($apellido)>=3 && !is_numeric($apellido)  && ($ext == "jpg" || $ext == "png") && $validar_archivo == 0)
        {

            $validarEmail = validarEmail($bd,$email);

            if(!$validarEmail)
            {
                $foto = (cantidadUsuarios($bd)).".".$ext;
                $id = guardarUsuario($bd,$datos,$foto);
                $_SESSION["usuario"] = [
                    "id" => $id,
                    "nombre"=> $nombre,
                    "apellido"=> $apellido,
                    "email" => $email,
                    "contrasenia" => password_hash($password,PASSWORD_DEFAULT),
                    "foto" => $foto
                ];
                agregarFoto($bd,$_SESSION["usuario"]);     
                   
                if(isset($_POST["recordar"]))
            {
                setcookie("usuario", json_encode($_SESSION["usuario"]), time() + 60*60*24*365);
            }
            move_uploaded_file($_FILES["foto"]["tmp_name"], "perfiles/".$foto);     
             header('Location:perfil.php');
            } else
            {
                $errores[5] ="Email ya ingresado";
            }
        }
        if (strlen($password)<=5)
        {
            $errores[0] = "Contraseña invalida";
        } 
          if( strlen($nombre)<3 || is_numeric($nombre))
        {
            $errores[1] = "Nombre invalido";
        }
        if( strlen($apellido)<3 || is_numeric($apellido))
        {
            $errores[2] = "Apellido invalido";
        }  
        if (strlen($email)<=5)
        {
            $errores[3] = "Email invalido";
        }
        if( ($ext != "png" && $ext != "jpg")|| $validar_archivo !=0 )
        {
            $errores[4] = "Foto en jpg o png";
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
    <title>Registro</title>
</head>

<body>
    <div class="container col-12 col-md-12 col-lg-12 col-xl-12 contenedor-registro">
        <div class="fondo col-lg-12 mb-5 mb-xl-0 col-xl-7">

        </div>
        <section class="col-lg-12 col-xl-5 section-registro">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype ="multipart/form-data" class="form-registro">
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="email">Email</label>
                    <input class="col-6" type="email" name="email" id="email" value="<?= $email ?>">
                    <div class="bloque-error-registro  col-12">
                     <?php if((strlen($email)<=5) && count($errores)!=0) : ?>
                        <p  class="error col-10">
                            <?= $errores[3] ?>
                        </p>
                     <?php endif; ?>    
                     </div> 
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="contraseña">Contraseña</label>
                    <input class="col-6" type="password" name="contraseña" id="contraseña" value="<?= $password ?>">
                    <div class="bloque-error-registro  col-12">
                    <?php if(strlen($password) <=5 && count($errores)!=0) : ?>
                        <p  class="error col-10">
                            <?= $errores[0] ?>
                        </p>
                     <?php endif; ?>   
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="nombre">Nombre</label>
                    <input class="col-6" type="text" name="nombre" id="nombre" value="<?= $nombre ?>">
                    <div class="bloque-error-registro  col-12">
                    <?php if( (strlen($nombre)<3 || is_numeric($nombre)) && count($errores)!=0) : ?>
                        <p  class="error col-10">
                            <?= $errores[1]?>
                        </p>
                     <?php endif; ?>  
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-12">
                    <label class="col-6" for="apellido">Apellido</label>
                    <input class="col-6" type="text" name="apellido" id="apellido" value="<?= $apellido ?>">  
                    <div class="bloque-error-registro  col-12">
                         <?php if( (strlen($apellido)<3 || is_numeric($apellido)) && count($errores)!=0 ) : ?>
                            <p class="error col-10">
                                <?= $errores[2] ?>
                             </p>
                        <?php endif; ?> 
                    </div>
                    
                </div>
                <div class="col-8 col-md-6 col-xl-8 bloque-foto-perfil">   
                    <div class="bloque-foto col-6">
                        <input class="col-12 foto_perfil" type="file" name="foto" id="foto-perfil-registro" > 
                        <i class="fa fa-upload imagen-upload" aria-hidden="true"></i>
                         <p >
                            Foto
                         </p>  
                    </div>
                      
                    <div class="bloque-error-registro  col-12">
                        <?php if( ($ext!="jpg" && $ext!="png" || $validar_archivo!=0 || count($_FILES)==0) && count($errores)!=0 ) : ?>
                            <p class="error error2 col-10">
                                <?= $errores[4] ?>  
                            </p>
                         <?php endif; ?>
                    </div>
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
                <div class="bloque-error-registro  col-12">
                        <?php if( $bandera && count($errores)!=0 ) : ?>
                            <p class="error col-10">
                                <?= $errores[5] ?>  
                            </p>
                         <?php endif; ?>
                </div>
    </form>
    </section>

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

</body>

</html>