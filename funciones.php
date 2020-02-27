<?php
include("pdo.php");

function validarEmail(PDO $bd, String $email)
{
    try 
    {
        $bd->beginTransaction();
        $consulta = $bd->prepare("select * from usuarios WHERE email = ?");
        $consulta->bindValue(1,$email);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        $bd-> commit();
        return ($resultado !== false) ? true : false;
    } catch(PDOException $e)
    {
        echo "No se puede validar mail <br>".$e->getMessage();
    }
}
function buscarUsuario(PDO $bd, String $email)
{
    try 
    {
        $bd->beginTransaction();
        $consulta = $bd->prepare("select * from usuarios WHERE email = ?");
        $consulta->bindValue(1,$email);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        $bd-> commit();
        return $resultado;
    } catch(PDOException $e)
    {
        echo "No se puede validar mail <br>".$e->getMessage();
    }
}
function cantidadUsuarios(PDO $bd)
{
    try 
    {
        $consulta = $bd->prepare("select * from usuarios");
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return ($resultado !== false) ? $consulta->rowCount() : 1;
    } catch(PDOException $e)
    {
        echo "No se puede consultar la cantidad de usuarios <br>".$e->getMessage();
    }
}
function guardarUsuario(PDO $bd,$datos,$foto)
{
    $contraseña = password_hash($datos["contraseña"],PASSWORD_DEFAULT);
    try 
    {
        $bd->beginTransaction();
        $consulta = $bd->prepare("insert into usuarios(nombre,apellido,email,contrasenia,foto) values(?,?,?,?,?)");
        $consulta->bindValue(1,$datos["nombre"]);
        $consulta->bindValue(2,$datos["apellido"]);
        $consulta->bindValue(3,$datos["email"]);
        $consulta->bindValue(4,$contraseña);
        $consulta->bindValue(5,$foto);
        $consulta->execute();
        $id = $bd->lastInsertID();
        $bd->commit();
        return $id;
    } catch(PDOException $e)
    {
        echo "No se puede consultar la cantidad de usuarios <br>".$e->getMessage();
    }
}
function getCategorias(PDO $bd)
{
    try 
    {
        $consulta = $bd->prepare("select * from categorias");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
       
    } catch(PDOException $e)
    {
        echo "No se puede consultar las categorias de los posteos<br>".$e->getMessage();
    }
}
function actualizarUsuario(PDO $bd,$usuario)
{
    try
    {
        $bd->beginTransaction();
        $consulta= $bd->prepare("update usuarios set email = ?, contrasenia = ?, foto = ?, fecha_cumpleanios = ?, situacion_sentimental = ?, escuela = ?, universidad = ?, ciudad = ?
        where id = ?");
        $consulta->bindValue(1,$usuario["email"]);
        $consulta->bindValue(2,$usuario["contrasenia"]);
        $consulta->bindValue(3,$usuario["foto"]);
        $consulta->bindValue(4,$usuario["fecha_cumpleanios"]);
        $consulta->bindValue(5,$usuario["situacion_sentimental"]);
        $consulta->bindValue(6,$usuario["escuela"]);
        $consulta->bindValue(7,$usuario["universidad"]);
        $consulta->bindValue(8,$usuario["ciudad"]);
        $consulta->bindValue(9,$usuario["id"]);
        $consulta->execute();
        $bd->commit();
    } catch(PDOException $e)
    {
        echo "No se pudo actualizar al usuario ".$e->getMessage();

    }
}
function guardarPublicacion(PDO $bd,$publicacion,$foto,$usuario)
{
   try 
   {
        $bd->beginTransaction();
        $consulta = $bd->prepare("insert into posteos(fecha_posteo,contenido_posteo,foto,id_categoria,id_usuario) values(current_time(),?,?,?,?)");
        $consulta->bindValue(1,$publicacion["publicacion"]);
        $consulta->bindValue(2,$foto);
        $consulta->bindValue(3,$publicacion["tipopublicacion"]);
        $consulta->bindValue(4,$usuario["id"]);
        $consulta->execute();
        $bd->commit();
   } catch(PDOException $e)
   {
       echo "Error al insertar la publicacion ".$e->getMessage();
       $bd->rollback();
       exit;
   }
}
function buscarPublicaciones($bd,$id)
{
    try{
        $consulta = $bd->prepare("select * from posteos where id_usuario = ?");
        $consulta->bindValue(1,$id);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e)
    {
        echo "Error al buscar publicacion ".$e->getMessage();
        exit;
    }
}
function aceptarSolicitud($bd,$amigo,$usuario)
{
   try{
        $bd->beginTransaction();
        $consulta = $bd->prepare("update amigos set respuesta = ? where id_usuario = ? and id_amigo = ?");
        $consulta->bindValue(1, 1);
        $consulta->bindValue(2,$amigo["id"]);
        $consulta->bindValue(3,$usuario["id"]);
        $consulta->execute();
        $bd->commit();
   } catch(PDOException $e)
   {
       echo "Error al aceptar amistad ".$e->getMessage();
       $bd->rollback();
   }
}

function eliminarSolicitud($bd,$amigo,$usuario)
{
    try{
        $bd->beginTransaction();
        $consulta = $bd->prepare("update amigos set respuesta = ? where id_usuario = ? and id_amigo = ?");
        $consulta->bindValue(1, 0);
        $consulta->bindValue(2,$usuario["id"]);
        $consulta->bindValue(3,$amigo["id"]);
        $consulta->execute();
        $bd->commit();
    }catch(PDOException $e)
    {
        echo "Error al eliminar amistad ".$e->getMessage();
        $bd->rollback();
    }
}
function mandarSolicitud($bd,$amigo,$usuario)
{
    try{
        $bd->beginTransaction();
        $consulta =$bd->prepare("insert into amigos values(?,?,current_date(),?)");
        $consulta->bindValue(1,$usuario["id"]);
        $consulta->bindValue(2,$amigo["id"]);
        $consulta->bindValue(3,3);
        $consulta->execute();
        $bd->commit();
    } catch(PDOException $e)
    {
        echo "Error al mandar amistad ".$e->getMessage();
        $bd->rollback();
    }
}
function getAmigos($bd,$usuario)
{
    try{
        $consulta = $bd->prepare("select usuarios.* from amigos inner join usuarios on id = id_usuario or id = id_amigo where (id_usuario = ? or id_amigo = ?) and id != ? and respuesta = 1");
        $consulta->bindValue(1,$usuario["id"]);
        $consulta->bindValue(2,$usuario["id"]);
        $consulta->bindValue(3,$usuario["id"]);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e)
    {
        echo "Error al buscar amigos ".$e->getMessage(); 
    }
}
function getSolicitudes($bd,$usuario)
{
    try{
        $consulta = $bd->prepare("select usuarios.* from amigos inner join usuarios on (id = id_usuario or id = id_amigo) where id_amigo = ? and id != ? and respuesta = 3");
        $consulta->bindValue(1,$usuario["id"]);
        $consulta->bindValue(2,$usuario["id"]);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e)
    {
        echo "Error al buscar amigos ".$e->getMessage(); 
    }
}
?>