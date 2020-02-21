<?php
session_start();
$usuarios = json_decode(file_get_contents("usuarios.json"),true);
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
      $usuario["foto"] = $usuario["id"].".".$ext;
      $_SESSION["usuario"] =$usuario;
      $usuarios[$_SESSION["index"]] = $usuario;
      if(isset($_COOKIE["usuario"])&& isset($_COOKIE["index"]))
      {
        $_COOKIE["usuario"] = json_encode($usuario);
      }
      file_put_contents("usuarios.json", json_encode($usuarios));
      move_uploaded_file($_FILES["cambiar-foto"]["tmp_name"],"perfiles/".$usuario["id"].".".$ext);
      header("Location:perfil.php");
    } else 
    {
      $errores[0] = "Error al actualizar la contraseña";
      $bandera = 2;
    }
  } else if(isset($_POST["cambiarcontraseña"]))
  {
    if(password_verify($_POST["password1"], $usuario["password"]) && $_POST["password2"] == $_POST["password3"] && strlen($_POST["password3"])>=5 && strlen($_POST["password2"])>=5 && $_POST["password1"] != $_POST["password2"])
    {
      $usuario["password"] = password_hash($_POST["password2"],PASSWORD_DEFAULT);
      $usuarios[$_SESSION["index"]] = $usuario;
      file_put_contents("usuarios.json", json_encode($usuarios));
      session_destroy();
      if(isset($_COOKIE["usuario"])&& isset($_COOKIE["index"]))
      {
        setcookie("usuario",null,-1);
        setcookie("index",null,-1);
      }
      header("Location:login.php");
    } else 
    {
      $errores[0] = "Error al actualizar la contraseña";
      $bandera = 1;
    }
  } else if(isset($_POST["cambiardatos"]))
  {
    $usuario["email"]= $_POST["email"];
    $usuario["fecha"] = $_POST["fecha"];
    $usuarios[$_SESSION["index"]] = $usuario;
    file_put_contents("usuarios.json", json_encode($usuarios));
    $_SESSION["usuario"] = $usuario;
    if(isset($_COOKIE["usuario"]))
    {
      $_COOKIE["usuario"] = json_encode($usuario);
    }
    header("Location:perfil.php");
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
      <form action="datosusuarios.php" method = "POST">
            <div>
                <p>
                <input type="email" name="email" id="email" value="" placeholder="Email">
                </p>
                 <p>
                 <input type="date" name="fecha" id="fecha-cumple" value="">
                 </p>
                 <p>
                     <button type="submit" name="cambiardatos" id="cambiardatos">Aceptar</button>
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
      <form action="datosusuarios.php" method = "POST">
            <div>
                <p>
                <input type="text" name="password1" id="" value="" placeholder ="Contraseña actual">
                </p>
                 <p>
                 <input type="text" name="password2" id="" value="" placeholder ="Contraseña nueva">
                 </p>
                 <p>
                 <input type="text" name="password3" id="" value="" placeholder ="Confirmar contraseña">
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
      <form action="datosusuarios.php" method = "POST" enctype="multipart/form-data">
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