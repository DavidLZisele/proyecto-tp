<?php
session_start();
require("funciones.php");
$usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : [];
$ext = '';
$errores = [];
$bandera = 0;
$informe_envio = '';
if($_POST)
{
  if(isset($_POST["salir"]))
  {
    session_destroy();
    setcookie("usuario",null,-1);
    setcookie("index",null,-1);
    header("Location:login.php");
  } else if(isset($_POST["subir-publicacion"]))
  {
    $publicacion = $_POST;
    if(strlen($publicacion["publicacion"])!= 0)
    {
      $foto = '';
      if(isset($_FILES["fotopublic"]))
      {
        $ext = pathinfo($_FILES["fotopublic"]["name"],PATHINFO_EXTENSION);
        $error_foto_public = $_FILES["fotopublic"]["error"];
        if($error_foto_public == 0 && ($ext  == "jpg" || $ext == "png"))
        {
          $foto = $usuario["id"]."_".cantidadFotosPosteo($bd,$usuario).".".$ext;
          move_uploaded_file($_FILES["fotopublic"]["tmp_name"],"publicaciones/".$foto);
        } else 
        {
          $errores[0] = "Error al subir foto";
        }
      }
      guardarPublicacion($bd,$publicacion,$foto,$usuario);
      agregarFotoPosteo($bd,$usuario,$foto);
      header("Location:perfil.php");
    } else 
    {
      $errores[0] = "Error al subir la publicacion";
    }
  } else if(isset($_POST["aceptar"]))
  {
      foreach(getSolicitudes($bd,$usuario) as $amigo)
      {
          if($_POST["aceptar"] == $amigo["id"])
          {
              aceptarSolicitud($bd,$amigo,$usuario);
              aceptarSolicitud($bd,$usuario,$amigo);
              break;
          }
          header("Location:perfil.php");
      }
  } else if(isset($_POST["rechazar"]))
  {
    foreach(getSolicitudes($bd,$usuario) as $amigo)
    {
      if($_POST["aceptar"] == $amigo["id"])
      {
        eliminarSolicitud($bd,$amigo,$usuario);
          break;
      }
      header("Location:perfil.php");
    }
  } else if(isset($_POST["buscaramigo"]))
  {
      $email = $_POST["amigo"];
      $amigo = buscarUsuario($bd,$email);
      if($amigo !==false)
      {
        mandarSolicitud($bd,$amigo,$usuario);
        $informe_envio = "Se envio la solicitud";
      } else 
      {
        $bandera = 1;
        $errores[0] = "No se encontro usuario";
      }
  } else if(isset($_POST["borrar-publicacion"]))
  {
      borrarPublicacion($bd,$_POST["borrar-publicacion"]);
      header("Location:perfil.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Perfil</title>
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
  <div class="container col-12 contenedor-perfil">
    <header class = "header-perfil col-12">
      <ul class="nav nav-pills col-8">
        <li class="nav-item dropdown">  
            <a class="nav-link socialperfil" href="#" title="Noticias">Social</i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Noticias"><i class="fa fa-globe"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Configuracion"><i class="fa fa-user"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Mensajes"><i class="fa fa-envelope"></i></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
            aria-expanded="false" title="Notificaciones"><i class="fa fa-bell"></i></a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Solicitud de amistad</a>
          </div>
        </li>
      </ul>
      <ul class="nav nav-pills col-4 justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="datosusuario.php" title="Configuracion cuenta"><i class="fa fa-cog"></i></a>
        </li>
        <li class="nav-item li-salir">
          <form action="perfil.php" method="POST">
            <button type="submit" name="salir">Salir</button>
          </form>
        </li>
      </ul>
    </header>
     <section class="seccion-perfil col-12">
       <div class="col-lg-3">  
        <article class="informacion">
          <p class="nombre-perfil">
            <?= $usuario["nombre"]." ".$usuario["apellido"] ?>
          </p>
          <div class="bloke-imagen-perfil">
            <img src="perfiles/<?= $usuario["foto"] ?>" alt="foto">
          </div>
          <div class="bloke-info col-12">
           <div class="datosusuario-bloque">
           <?php if(isset($usuario["escuela"])) : ?>
              <div class="col-12">
                    <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
</a>
                    <p class="col-10"><?= $usuario["escuela"] ?></p>
              </div>
              <?php else :?>
                <div class="col-12">
                    <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
</a>
                    <p class="col-10">Escuela</p>
              </div>
              <?php endif;?>
              <?php if(isset($usuario["universidad"])) :?>
                  <div class="col-12">
                    <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
</a>
                    <p class="col-10"><?= $usuario["universidad"] ?></p>
                  </div>
              <?php else :?>
                <div class="col-12">
                    <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
</a>
                    <p class="col-10">Universidad</p>
                  </div>
              <?php endif?>
              <?php if(isset($usuario["situacion_sentimental"])) : ?>
                <div class="col-12">
                    <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-heart" aria-hidden="true"></i>
</a>
                    <p class="col-10"><?= $usuario["situacion_sentimental"] ?></p>
                 </div>
                <?php else : ?>
                  <div class="col-12">
                    <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-heart" aria-hidden="true"></i>
</a>
                    <p class="col-10">Relacion</p>
                 </div>
                 <?php endif;?>
           </div>
           <?php if(isset($usuario["ciudad"])) :?>
            <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-map-marker" aria-hidden="true"></i>
</a>
              <p class="col-10"><?=$usuario["ciudad"] ?></p>
            </div>
            <?php else :?>
              <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-map-marker" aria-hidden="true"></i>
</a>
              <p class="col-10">Ciudad</p>
            </div>
           <?php endif;?>
            <?php if(isset($usuario["fecha_cumpleanios"])) :?>
            <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-birthday-cake"></i></a>
              <p class="col-10"><?=$usuario["fecha_cumpleanios"] ?></p>
            </div>
            <?php else :?>
              <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-birthday-cake"></i></a>
              <p class="col-10">Cumpleaños</p>
            </div>
            <?php endif;?>
          </div>
        </article>
        <article class="mis-perfil">
          <div class="w3-card w3-round">
            <div class="w3-white">
              <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Mis Grupos</button>
              <div id="Demo1" class="w3-hide w3-container">
                <p>...</p>
              </div>
              <button onclick="myFunction('Demo4')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> Mis Amigos</button>
              <div id="Demo4" class="w3-hide w3-container">
                <?php foreach(getAmigos($bd,$usuario) as $amigo) :?>
                <p class="p-amigo" class="col-12">
                  <img src="perfiles/<?=$amigo["foto"]?>" alt="">
                  <?=$amigo["nombre"]." ".$amigo["apellido"]?>
                </p>
                <?php endforeach;?>
              </div>
              <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> Mis Eventos</button>
              <div id="Demo2" class="w3-hide w3-container">
                <p>...</p>
              </div>
               <div id="Demo2" class="w3-hide w3-container">
                <p>...</p>
              </div>
              <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-camera fa-fw w3-margin-right"></i> Mis Fotos</button>
              <div id="Demo3" class="w3-hide w3-container">
             <div class="w3-row-padding">
             <br>
               <div class="w3-half">
                 <img src="" style="width:100%" class="w3-margin-bottom">
               </div>
             </div>
              </div>
            </div>
              </div>
        </article>

       </div>
      <div class="col-lg-5">
        <article class="publicacion-perfil">
          <form action="perfil.php" method ="post" enctype="multipart/form-data">
              <input type="text" name="publicacion" class="publicacion" placeholder="Estado">
              <br>
              <br>
               <label for="tipopublicacion">Categoria</label>
               <select name="tipopublicacion" id="tipopublicacion">
                  <?php foreach(getCategorias($bd) as $categoria) : ?>
                  <option value="<?=$categoria["id"] ?>">
                      <?= $categoria["descripcion"] ?>
                  </option>
                  <?php endforeach;?>
               </select>
               <div class="div-subirfoto">
                  <span>
                  <i class="fa fa-camera" aria-hidden="true"></i> Subir imagen
                  </span>
                  <input type="file" name="fotopublic" id="fotopublic">
               </div>
              <br>
              <button type="submit" name ="subir-publicacion"> <i class="fa fa-pencil"></i> Publicar</button>
          </form>
       </article>
       <article class="publicaciones-perfil"> 
        <?php foreach(publicacionesAmigos($bd,$usuario) as $pub) :?>
          <?php if($pub["id_usuario"]==$usuario["id"]) :?>
            <div class="pp col-12">
            <div class="user-public col-2 col-md-2 col-lg-3">
              <img src="perfiles/<?=$pub["foto_usuario"]?>" alt="">
            </div>
            <p class="col-9 col-lg-6">
              <?= $pub["nombre"] ?>
            </p>
            <form action="perfil.php" method="post" class="col-1">
            <button type="submit" name ="borrar-publicacion" class="borrar-public" title="Borrar publicacion" value="<?=$pub["id_posteo"]?>">  <i class="fa fa-times" aria-hidden="true"></i></button>
            </form>
          </div>
           <p class="texto-publicacion">
             <?= $pub["contenido_posteo"] ?>
           </p>
           <?php if(strlen($pub["foto_posteo"])!=0) :?>
           <div class="imagen-public">
             <img src="publicaciones/<?=$pub["foto_posteo"]?>" alt="no se encontro la foto">
           </div>
           <?php endif;?>
           <div class="interaccion-publicacion">
             <form action="perfil.php" method="POST">
                   <button type="submit" name ="like">
                        <i class="fa fa-thumbs-up"></i>  Like
                   </button>
                    <button type="submit" name="comentar"> <i class="fa fa-comment"></i>  Comentar</button>
             </form>       
           </div>
           <form action="modificarPub.php" method="GET" class="editar-publicacion-form">
               <input type="hidden" name="id_pub" value="<?=$pub["id_posteo"]?>">
               <button type="submit"><i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
             </form> 
          <?php else :?>
            <div class="pp col-12">
            <div class="user-public col-2 col-md-2 col-lg-3">
              <img src="perfiles/<?=$pub["foto_usuario"]?>" alt="">
            </div>
            <p class="col-9 col-lg-6">
              <?= $pub["nombre"] ?>
            </p>
            <form action="perfil.php" method="post" class="col-1">
            </form>
          </div>
           <p class="texto-publicacion">
             <?= $pub["contenido_posteo"] ?>
           </p>
           <?php if(strlen($pub["foto_posteo"])!=0) :?>
           <div class="imagen-public">
             <img src="publicaciones/<?=$pub["foto_posteo"]?>" alt="no se encontro la foto">
           </div>
           <?php endif;?>
           <div class="interaccion-publicacion">
             <form action="perfil.php" method="POST">
                   <button type="submit" name ="like">
                        <i class="fa fa-thumbs-up"></i>  Like
                   </button>
                    <button type="submit" name="comentar"> <i class="fa fa-comment"></i>  Comentar
                    </button>
                    
             </form>        
           </div>
          <?php endif;?>
          
        <?php endforeach;?>
       </article>
       
      </div>
       
       <article class="solicitudes-amistad col-11 col-lg-3">
            <h3>
              Agregar amigos
            </h3>
            <div class="sa-2 col-12">
              <form action="perfil.php" method="POST">
                <input type="email" name="amigo" id ="amigo" placeholder="Ingrese mail amigo" class="buscaramigo">
                <button type="submit" name="buscaramigo" class="buscaramigo">Buscar</button>
                <?php if($bandera==1 && count($errores)!=0) :?>
                <p class="error-buscaramigo">
                  <?= $errores[0] ?>
                </p>
                <?php else :?>
                  <p class="info-buscaramigo">
                      <?php $informe_envio?>
                  </p>
                <?php endif;?>
              </form>
            </div>
            <h3>
              Solicitudes de amistad
            </h3>
            <?php foreach(getSolicitudes($bd,$usuario) as $amigo) :?>
            <div class="sa col-12">
              <div class="col-3 col-lg-4 col-xl-4 foto-solicitud">
                <img src="perfiles/<?=$amigo["foto"]?>" alt="">
              </div>
              <p class="col-6 col-lg-3 col-xl-3">
                <?= $amigo["nombre"] ?>
              </p>
              <form action="perfil.php" method="POST" class="col-3 col-lg-5 col-xl-5">
                <button type="submit" name="aceptar" class="col-6 check" value="<?=$amigo["id"]?>"> <i class="fa fa-check"></i></button>
                  <button type="submit" name="rechazar" class="col-6 remove" value="<?=$amigo["id"]?>"> <i class="fa fa-remove"></i></button>
              </form>
            </div>
            <?php endforeach;?>
       </article>
     </section>
  </div>
  <script>
    // Accordion
    function myFunction(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
      } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
      }
    }
    
    // Used to toggle the menu on smaller screens when clicking on the menu button
    function openNav() {
      var x = document.getElementById("navDemo");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else { 
        x.className = x.className.replace(" w3-show", "");
      }
    }
    </script>
    

</body>

</html>