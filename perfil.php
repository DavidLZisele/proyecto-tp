<?php
session_start();
$usuarios = json_decode(file_get_contents("usuarios.json"),true);
$usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : [];
$ext = '';
$errores = [];
$bandera = 0;
if($_POST)
{
  if(isset($_POST["salir"]))
  {
    session_destroy();
    setcookie("usuario",null,-1);
    setcookie("index",null,-1);
    header("Location:login.php");
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
            <div class="info-personal">
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-pencil"></i></a>
              <p class="col-10">Informacion personal</p>
            </div>
            <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-home"></i></a>
              <p class="col-10">Ciudad</p>
            </div>
            <div>
              <a href="datosusuario.php" class="col-2 a-datosusuario"><i class="fa fa-birthday-cake"></i></a>
              <p class="col-10">Cumpleaños</p>
            </div>
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
                <p>...</p>
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
          <form action="pagina.html" method ="post" enctype="multipart/form-data">
              <input type="text" name="publicacion" class="publicacion" placeholder="Estado">
              <br>
              <br>
               <label for="tipopublicacion">Categoria</label>
               <select name="tipopublicacion" id="tipopublicacion">
                  <option value="terror">Offtopic</option>
                  <option value="terror">Noticias</option>
                  <option value="terror">Deportes</option>
                  <option value="terror">Terror</option>
                  <option value="terror">Tecnologia</option>
               </select>
               <div class="div-subirfoto">
                  <span>
                  <i class="fa fa-camera" aria-hidden="true"></i> Subir imagen
                  </span>
                  <input type="file" name="fotopublic" id="fotopublic">
               </div>
              <br>
              <button type="submit"> <i class="fa fa-pencil"></i> Publicar</button>
          </form>
       </article>
       <article class="publicaciones-perfil">
          <div class="pp col-12">
            <div class="user-public col-2 col-md-2">
              <img src="img/perfil2.jpg" alt="">
            </div>
            <p class="col-9">
              Nombre
            </p>
            <form action="perfil.php" method="post" class="col-1">
            <button type="submit" name ="borrar-publicacion" class="borrar-public" title="Borrar publicacion">  <i class="fa fa-times" aria-hidden="true"></i></button>
            </form>
          </div>
           <p class="texto-publicacion">
             texto
           </p>
           <div class="imagen-public">
             <img src="img/martin1.jpg" alt="">
           </div>
           <div class="interaccion-publicacion">
             <form action="perfil.php" method="POST">
                   <button type="submit" name ="like">
                        <i class="fa fa-thumbs-up"></i>  Like
                   </button>
                    <button type="submit" name="comentar"> <i class="fa fa-comment"></i>  Comentar
                    </button>
             </form>
             
           </div>
       </article>
       
      </div>
       
       <article class="solicitudes-amistad col-12 col-lg-4">
            <h2>
              Solicitud de amistad
            </h2>
      
            <div class="sa col-12">
              <div class="col-1 col-lg-4 foto-solicitud">
                <img src="img/Martin1.jpg" alt="">
              </div>
              <p class="col-8 col-lg-4">
                Nombre
              </p>
              <form action="perfil.php" method="POST" class="col-3 col-lg-4">
                <button type="submit" name="aceptar" class="col-6 check"> <i class="fa fa-check"></i></button>
                  <button type="submit" name="aceptar" class="col-6 remove"> <i class="fa fa-remove"></i></button>
              </form>
            </div>

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