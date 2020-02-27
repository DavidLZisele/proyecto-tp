<?php
session_start();
require("funciones.php");
$usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : [];
$ext = '';
$errores = [];
$bandera = 0;
if($_POST)
{
  if(isset($_POST["cambiarfoto"]))
  {
    $ext = pathinfo($_FILES["cambiar-foto"]["name"],PATHINFO_EXTENSION);
    if($_FILES["cambiar-foto"]["error"]==0 && ($ext== "jpg" ||$ext== "png") )
    {
      $nombre_foto =  $usuario["id"]."_".(cantidadFotos($bd,$usuario)+1).".".$ext;
      $usuario["foto"] = $nombre_foto;
      $_SESSION["usuario"] =$usuario;
      if(isset($_COOKIE["usuario"]))
      {
        $_COOKIE["usuario"] = json_encode($usuario);
      }
      actualizarFoto($bd,$usuario);
      agregarFoto($bd,$usuario);
      move_uploaded_file($_FILES["cambiar-foto"]["tmp_name"],"perfiles/".$nombre_foto);
      header("Location:perfil.php");
    } else 
    {
      $errores[0] = "Error al actualizar la foto";
      $bandera = 2;
    }
  } else if(isset($_POST["cambiarcontraseña"]))
  {
    if(password_verify($_POST["password1"], $usuario["contrasenia"]) && $_POST["password2"] == $_POST["password3"] && strlen($_POST["password3"])>=5 && strlen($_POST["password2"])>=5 && $_POST["password1"] != $_POST["password2"])
    {
      $usuario["contrasenia"] = password_hash($_POST["password2"],PASSWORD_DEFAULT);
      session_destroy();
      if(isset($_COOKIE["usuario"]))
      {
        setcookie("usuario",null,-1);
        setcookie("index",null,-1);
      }
      actualizarContraseña($bd,$usuario);
      header("Location:login.php");
    } else 
    {
      $errores[0] = "Error al actualizar la contraseña";
      $bandera = 1;
    }
  } else if(isset($_POST["cambiardatos"]))
  {
    if(strlen($_POST["ciudad"])!=0 &&strlen($_POST["email"])!=0 && strlen($_POST["fecha"])!=0 && strlen($_POST["escuela"])!=0 && strlen($_POST["universidad"])!=0)
    {
      $usuario["email"]= $_POST["email"];
      $usuario["fecha_cumpleanios"] = $_POST["fecha"];
      $usuario["escuela"] = $_POST["escuela"];
      $usuario["universidad"] = $_POST["universidad"];
      $usuario["situacion_sentimental"] = $_POST["relacion"];
      $usuario["ciudad"]= $_POST["ciudad"];
      actualizarDatos($bd,$usuario);  
      $_SESSION["usuario"] = $usuario;
      if(isset($_COOKIE["usuario"]))
      {
        $_COOKIE["usuario"] = json_encode($usuario);
      }
      header("Location:perfil.php");   
    } else 
    {
      $bandera = 3;
      $errores[0] = "Error al actualizar datos";
    }
   
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Montserrat:400,700&display=swap" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container col-12 contenedor-datousuario">
        <div class="accordion col-8 col-md-6 col-xl-4" id="accordionExample">
        <a href="perfil.php" class="volver">
              Volver
        </a>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Cambiar datos personales
        </button>
      </h2>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
      <form action="datosusuario.php" method = "POST">
            <div>
                <p>
                <input type="email" name="email" id="email" value="<?=$usuario['email']?>" placeholder="Email">
                </p>
                 <p>
                  Dia de nacimiento
                  <br>
                 <input type="date" name="fecha" id="fecha-cumple" value="<?=$usuario['fecha']?>">
                 </p>
                 <p>
                 <?php if(isset($usuario["escuela"])) :?>
                 <input type="text" name="escuela" id="escuela" value="<?=$usuario['escuela']?>" placeholder="Escuela">
                 <?php else : ?>
                  <input type="text" name="escuela" id="escuela" value="" placeholder="Escuela">
                 <?php endif;?>
                 </p>
                 <p>
                 <?php if(isset($usuario["universidad"])) :?>
                 <input type="text" name="universidad" id="universidad" value="<?=$usuario['universidad']?>" placeholder="Universidad">
                 <?php else : ?>
                  <input type="text" name="universidad" id="universidad" value="" placeholder="Universidad">
                 <?php endif;?>
                 </p>
                 <p>
                 <?php if(isset($usuario["ciudad"])) :?>
                 <input type="text" name="ciudad" id="ciudad" value="<?=$usuario['ciudad']?>" placeholder="ciudad">
                 <?php else : ?>
                  <input type="text" name="ciudad" id="ciudad" value="" placeholder="ciudad">
                 <?php endif;?>
                 </p>
                 <p>
                 Situación sentimental
                 <br>
                 <select name="relacion" id="relacion" value ="<?= $usuario["situacion_sentimental"] ?>">
                    <option value="Soltero">Soltero</option>
                    <option value="En pareja">En pareja</option>
                    <option value="Casado">Casado</option>
                    <option value="Divorciado">Divorciado</option>
                    </select>           
                 </p>
                 <p>
                     <button type="submit" name="cambiardatos" id="cambiardatos">Aceptar</button>
                     <?php if($bandera == 3 && count($errores)!=0) : ?>
                          <p class="error-perfil">
                            <?= $errores[0] ?>
                          </p>
                     <?php endif;?>
                 </p>        
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Cambiar contraseña
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
      <form action="datosusuario.php" method = "POST">
            <div>
                <p>
                <input type="password" name="password1" id="" value="" placeholder ="Contraseña actual">
                </p>
                 <p>
                 <input type="password" name="password2" id="" value="" placeholder ="Contraseña nueva">
                 </p>
                 <p>
                 <input type="password" name="password3" id="" value="" placeholder ="Confirmar contraseña">
                 </p>
                 <p>
                     <button type="submit" name="cambiarcontraseña" id="cambiarcontraseña">Aceptar</button>
                     <?php if($bandera == 1 && count($errores)!=0) : ?>
                          <p class="error-perfil">
                            <?= $errores[0] ?>
                          </p>
                     <?php endif;?>
                 </p>        
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Cambiar foto
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
      <form action="datosusuario.php" method = "POST" enctype="multipart/form-data">
            <div>
                <p class="cambiarfotoperfil">
                <i class="fa fa-camera" aria-hidden="true"></i>
                  <span>Cambiar foto</span>
                <input type="file" name="cambiar-foto" id="cambiar-foto">
                </p>
                 <p>
                     <button type="submit" name="cambiarfoto" id="cambiarfoto">Aceptar</button>
                     <?php if($bandera == 2 && count($errores)!=0) : ?>
                          <p class="error-perfil">
                            <?= $errores[0] ?>
                          </p>
                     <?php endif;?>
                 </p>        
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
    </div>
</body>
</html>