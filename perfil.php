<?php
session_start();
$usuarios = json_decode(file_get_contents("usuarios.json"),true);
$usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : [];
$ext = '';
if($_POST)
{
  if(isset($_POST["salir"]))
  {
    session_destroy();
    setcookie("usuario", "", -1);
    header("Location:http://localhost/proyecto-tp/index.html");
  }
  else if(isset($_POST["boton-foto"]))
  {
    $ext = pathinfo($_FILES["cambiarfoto"]["name"],PATHINFO_EXTENSION);
    if($_FILES["cambiarfoto"]["error"]==0 && ($ext== "jpg" ||$ext== "png") )
    {
      $_SESSION["usuario"]["foto"] = $usuario["id"].".".$ext;
      $usuario = $_SESSION["usuario"];
      $usuarios[$_SESSION["index"]] = $usuario;
      file_put_contents("usuarios.json", json_encode($usuarios));
      move_uploaded_file($_FILES["cambiarfoto"]["tmp_name"],"perfiles/".$usuario["id"].".".$ext);
      header("Location:http://localhost/proyecto-tp/perfil.php");

    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    html, body, h1, h2, h3, h4, h5 {font-family: "Arial", sans-serif}
    </style>
</head>
<body>

    <body class="w3-theme-l5">
    
    <!-- Navbar -->
    <div class="w3-top">
     <div class="w3-bar w3-left-align w3-large bg-nav">
      <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Home</a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Noticias"><i class="fa fa-globe"></i></a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Configuración"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Mensajes"><i class="fa fa-envelope"></i></a>
      <div class="w3-dropdown-hover w3-hide-small">
        <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span class="w3-badge w3-right w3-small w3-green">3</span></button>     
        <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
          <a href="#" class="w3-bar-item w3-button">Solicitud de amistad</a>
          <a href="#" class="w3-bar-item w3-button">Joana publico en tu muro</a>
          <a href="#" class="w3-bar-item w3-button">Joana le gusta tu publicación</a>
        </div>
      </div>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="Mi Perfil">
        <img src="img/perfil.jpg" class="w3-circle" style="height:23px;width:23px" alt="Avatar">
      </a>
     </div>
    </div>
    
    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large">Mi Perfil</a>
    </div>
    
    <!-- Page Container -->
    <div class="w3-container w3-content bg-cmain" style="max-width:1400px;margin-top:51px;padding-top:15px;">    
      <!-- The Grid -->
      <div class="w3-row">
        <!-- Left Column -->
        <div class="w3-col m3">
          <!-- Profile -->
          <div class="w3-card w3-round w3-white">
            <div class="w3-container">
             <h4 class="w3-center">
               <?= $usuario["nombre"]." ".$usuario["apellido"] ?>
             </h4>                            
              <form action="perfil.php" method="POST" enctype="multipart/form-data" class="form-perfil">
              <p class="w3-center">
                <img src="perfiles/<?=$usuario["foto"]?>" class="w3-square" alt="Avatar">
              </p>
               <div class="foto-perfil">
                 <div class="bloque-foto-perfil">
                      <i class="fa fa-camera" aria-hidden="true"></i>
                      <input type="file" name="cambiarfoto" id="cambiarfoto">   
                 </div>        
                   <div class="bloque-boton-perfil">
                        <button type="submit" name="boton-foto">
                            <i class="fa fa-upload" aria-hidden="true"></i>
                         </button>  
                   </div>  
              </div>          
              </form>
            <hr>
             <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i>Programador Web Full Stack</p>
             <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> Rosario, Argentina</p>
             <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> 1 Abril, 1998</p>
            </div>
            <form action="perfil.php" method = "POST">
              <button type="submit" name="salir">Salir</button>
            </form>
          </div>
          <br>
          
          <!-- Accordion -->
          <div class="w3-card w3-round">
            <div class="w3-white">
              <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Mis Grupos</button>
              <div id="Demo1" class="w3-hide w3-container">
                <p>...</p>
              </div>
              <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> Mis Eventos</button>
              <div id="Demo2" class="w3-hide w3-container">
                <p>...</p>
              </div>
              <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> Mis Fotos</button>
              <div id="Demo3" class="w3-hide w3-container">
             <div class="w3-row-padding">
             <br>
               <div class="w3-half">
                 <img src="img/New York.jpg" style="width:100%" class="w3-margin-bottom">
               </div>
               <div class="w3-half">
                 <img src="img/Bar.png" style="width:100%" class="w3-margin-bottom">
               </div>
               <div class="w3-half">
                 <img src="img/perfil2.jpg" style="width:100%" class="w3-margin-bottom">
               </div>
             </div>
              </div>
            </div>      
          </div>
          <br>
          
          <!-- Interests --> 
          
          <br>
          
              
        <!-- End Left Column -->
        </div>
        
        <!-- Middle Column -->
        <div class="w3-col m7">
        
          <div class="w3-row-padding">
            <div class="w3-col m12">
              <div class="w3-card w3-round w3-white">
                <div class="w3-container w3-padding">
                  <h6 class="w3-opacity"></h6>
                  <p contenteditable="true" class="w3-border w3-padding">Estado: </p>
                  <button type="button" class="w3-button w3-theme"><i class="fa fa-pencil"></i>  Publicar</button> 
                </div>
              </div>
            </div>
          </div>
          
          <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
            <img src="img/Martin1.jpg" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px; height: 60px;">
            <span class="w3-right w3-opacity">1 min</span>
            <h4>Martin Gonalez</h4><br>
            <hr class="w3-clear">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              <div class="w3-row-padding" style="margin:0 -16px">
                <div class="w3-half">
                  <img src="img/Martin2.jpg" style="width:100%" alt="Northern Lights" class="w3-margin-bottom">
                </div>
                <div class="w3-half">
                  <img src="img/Martin hollywood.jpg" style="width:100%" alt="Nature" class="w3-margin-bottom">
              </div>
            </div>
            <button type="button" class="w3-button w3-margin-bottom bg-like-comm"><i class="fa fa-thumbs-up"></i>  Like</button> 
            <button type="button" class="w3-button w3-margin-bottom bg-like-comm"><i class="fa fa-comment"></i>  Comentar</button> 
          </div>
          
          <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
            <img src="img/Joanna.jpg" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
            <span class="w3-right w3-opacity">16 min</span>
            <h4>Joana Diaz</h4><br>
            <hr class="w3-clear">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <button type="button" class="w3-button w3-margin-bottom bg-like-comm"><i class="fa fa-thumbs-up"></i>  Like</button> 
            <button type="button" class="w3-button w3-margin-bottom bg-like-comm"><i class="fa fa-comment"></i>  Comentar</button> 
          </div>  
    
          <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
            <img src="img/MariaA.jpg" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px;">
            <span class="w3-right w3-opacity">32 min</span>
            <h4>Maria Angeles Gomez </h4><br>
            <hr class="w3-clear">
            <p>Has visto esto?</p>
            <img src="img/Viaje.jpg" style="width:100%" class="w3-margin-bottom">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <button type="button" class="w3-button w3-margin-bottom bg-like-comm"><i class="fa fa-thumbs-up"></i>  Like</button> 
            <button type="button" class="w3-button w3-margin-bottom bg-like-comm"><i class="fa fa-comment"></i>  Comentar</button> 
          </div> 
          
        <!-- End Middle Column -->
        </div>
        
        <!-- Right Column -->
        <div class="w3-col m2">
                  
          <div class="w3-card w3-round w3-white w3-center">
            <div class="w3-container">
              <p>Solicitud de Amistad</p>
              <img src="img/Juan Carlos.jpg" alt="Avatar" style="width:50%"><br>
              <span>Juan Carlos Rodriguez</span>
              <div class="w3-row w3-opacity">
                <div class="w3-half">
                  <button class="w3-button w3-block w3-green w3-section" title="Accept"><i class="fa fa-check"></i></button>
                </div>
                <div class="w3-half">
                  <button class="w3-button w3-block w3-red w3-section" title="Decline"><i class="fa fa-remove"></i></button>
                </div>
              </div>
            </div>
          </div>
          <br>

          <div class="w3-card w3-round w3-white w3-hide-small">
              <div class="w3-container">
                <p>Interests</p>
                <p>
                  <span class="w3-tag w3-small w3-theme-d5">Noticias</span>               
                  <span class="w3-tag w3-small w3-theme">Juegos</span>
                  <span class="w3-tag w3-small w3-theme-l1">Amigos</span>
                  <span class="w3-tag w3-small w3-theme-l2">Comida</span>
                  <span class="w3-tag w3-small w3-theme-l3">Diseño</span>
                  <span class="w3-tag w3-small w3-theme-l4">Arte</span>
                  <span class="w3-tag w3-small w3-theme-l5">Fotos</span>
                </p>
              </div>
            </div>
        <!-- End Right Column -->
        </div>
        
      <!-- End Grid -->
      </div>
      
    <!-- End Page Container -->
    </div>
    
    <!-- Footer -->
    <footer class="w3-container w3-theme-d3 w3-padding-16">
      <h5>Digital House Full Stack - Sardilla Loves</h5>
    </footer>
    
    <footer class="w3-container w3-theme-d5">
      
    </footer>
     
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
    
</body>
</html>