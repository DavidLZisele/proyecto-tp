<?php
session_start();
include("funciones.php");
$pub = getPublicacion($bd,$_GET["id_pub"]);
if($_POST)
{
    $foto = '';
    if(strlen($_POST["contenido"])>0)
    {
        if(isset($_FILES["foto"]))
        {
            $ext = pathinfo($_FILES["foto-pub"]["name"],PATHINFO_EXTENSION);
            $error = $_FILES["foto-pub"]["error"];
            $foto  = $_SESSION["usuario"]["id"]."_".cantidadFotosPosteo($bd,$_SESSION["usuario"]).$ext;
             agregarFotoPosteo($bd,$_SESSION["usuario"],$foto);
        }
    }
    echo "<pre>";
    modificarPosteo($bd,$foto,$_POST["contenido"],$_POST["id_posteo"]);
    header("Location:perfil.php");
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
    <title>Modificar Publicacion</title>
</head>
<body>
    <div class="container col-12 contenedor-modpub">
            <form action="modificarPub.php" method = "POST" enctype="multipart/form-data" class="col-8 col-md-6 col-lg-4">
                 <input type="hidden" name="id_posteo" value="<?=$pub["id"] ?>">
                 <div>
                    <input type="text" name="contenido" id="contenido" value="<?=$pub["contenido_posteo"]?>" class="col-12 contenido-posteo">
                </div>
                <div class="div-foto-modificarpub">
                    <span>
                        FOTO
                    </span>
                    <input type="file" name="foto-pub" id="foto-pub">
                </div>
                <button type="submit">Aceptar</button>
            </form>
    </div>
</body>
</html>