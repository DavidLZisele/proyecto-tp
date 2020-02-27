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
function buscarEmail(PDO $bd, String $email)
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
        $id = lastInsertID();
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
?>