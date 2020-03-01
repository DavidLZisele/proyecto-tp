<?php
include("pdo.php");

function validarEmail(PDO $bd, String $email)
{
    try 
    {
    
        $consulta = $bd->prepare("select * from usuarios WHERE email = ?");
        $consulta->bindValue(1,$email);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return ($resultado !== false) ? true : false;
    } catch(PDOException $e)
    {
        echo "No se puede validar mail <br>".$e->getMessage();
        exit;
    }
}
function buscarUsuario(PDO $bd, String $email)
{
    try 
    {
        $consulta = $bd->prepare("select * from usuarios WHERE email = ?");
        $consulta->bindValue(1,$email);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    } catch(PDOException $e)
    {
        echo "No se puede validar mail <br>".$e->getMessage();
        exit;
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
        exit;
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
        $bd->rollback();
        exit;
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
        exit;
    }
}
function actualizarDatos(PDO $bd,$usuario)
{
    try
    {
        $bd->beginTransaction();
        $consulta= $bd->prepare("update usuarios set email = ?, fecha_cumpleanios = ?, situacion_sentimental = ?, escuela = ?, universidad = ?, ciudad = ?
        where id = ?");
        $consulta->bindValue(1,$usuario["email"]);
        $consulta->bindValue(2,$usuario["fecha_cumpleanios"]);
        $consulta->bindValue(3,$usuario["situacion_sentimental"]);
        $consulta->bindValue(4,$usuario["escuela"]);
        $consulta->bindValue(5,$usuario["universidad"]);
        $consulta->bindValue(6,$usuario["ciudad"]);
        $consulta->bindValue(7,$usuario["id"]);
        $consulta->execute();
        $bd->commit();

    } catch(PDOException $e)
    {
        echo "No se pudo actualizar al usuario ".$e->getMessage();
        $bd->rollback();
        exit;

    }
}
function actualizarContraseña(PDO $bd,$usuario)
{
    try
    {
        $bd->beginTransaction();
        $consulta= $bd->prepare("update usuarios set contrasenia = ? where id = ?");
        $consulta->bindValue(1,$usuario["contrasenia"]);
        $consulta->bindValue(2,$usuario["id"]);
        $consulta->execute();
        $bd->commit();

    } catch(PDOException $e)
    {
        echo "No se pudo actualizar al usuario ".$e->getMessage();
        $bd->rollback();
        exit;

    }
}
function actualizarFoto(PDO $bd,$usuario)
{
    try
    {
        $bd->beginTransaction();
        $consulta= $bd->prepare("update usuarios set foto = ? where id = ?");
        $consulta->bindValue(1,$usuario["foto"]);
        $consulta->bindValue(2,$usuario["id"]);
        $consulta->execute();
        $bd->commit();

    } catch(PDOException $e)
    {
        echo "No se pudo actualizar al usuario ".$e->getMessage();
        $bd->rollback();
        exit;

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
       exit;
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
        exit;
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
        exit;
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
        exit;
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
        exit;
    }
}
function borrarPublicacion($bd,$id)
{
    try{
        $bd->beginTransaction();
        $consulta = $bd->prepare("delete from posteos where id = ?");
        $consulta->bindValue(1,$id);
        $consulta->execute();
        $bd->commit();

    } catch(PDOException $e)
    {
        echo "Error al borrar publicacion ".$e->getMessage();
        $bd->rollback();
        exit;
    }
}
function publicacionesAmigos($bd,$usuario)
{
    try{
        $consulta = $bd->prepare("select distinct p.id id_posteo,u.id id_usuario, u.nombre,u.foto foto_usuario,contenido_posteo,p.foto foto_posteo,fecha_posteo
        from usuarios u 
        inner join amigos a on (u.id = a.id_usuario or u.id = a.id_amigo)
        inner join posteos p on p.id_usuario = u.id
        where (a.id_usuario = ? or a.id_amigo = ? or u.id = ?) and respuesta = 1
        order by fecha_posteo desc");
        $consulta->bindValue(1,$usuario["id"]);
        $consulta->bindValue(2,$usuario["id"]);
        $consulta->bindValue(3,$usuario["id"]);
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        echo "Error al consultar las publicaciones de los amigos ".$e->getMessage();
        exit;
    }
}
function getPublicaciones($bd,$usuario)
{
    try{
        $consulta = $bd->prepare("select u.id, u.nombre nombre_usuario, u.foto foto_usuario, p.foto foto_posteo, p.contenido_posteo from posteos p
        inner join usuarios u on u.id = id_usuario
        where id_usuario = ?
        order by fecha_posteo desc");
        $consulta->bindValue(1,$usuario["id"]);
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        echo "Error al consultar las publicaciones de los amigos ".$e->getMessage();
        exit;
    }
}
function agregarFoto($bd,$usuario)
{
    try{
        $bd->beginTransaction();
        $consulta = $bd->prepare("insert into fotos_usuario(id_usuario,nombre_foto) values(?,?)");
        $consulta->bindValue(1,$usuario["id"]);
        $consulta->bindValue(2,$usuario["foto"]);
        $consulta->execute();
        $bd->commit();

    } catch(PDOException $e)
    {
        echo "Error al actualizar la foto del usuario ".$e->getMessage();
        $bd->rollback();
        exit;
    }
}
function cantidadFotos($bd,$usuario)
{  
    try{
    $consulta = $bd->prepare("select * from fotos_usuario where id_usuario = ?");
    $consulta->bindValue(1,$usuario["id"]);
    $consulta->execute();
    $res = $consulta-> fetchAll(PDO::FETCH_ASSOC);
    return ($resultado !== false) ? ($consulta->rowCount()+1) : 1;
    } catch(PDOException $e)
    {
    echo "Error al consultar la cantidad de fotos del usuario ".$e->getMessage();
    exit;
    }
}
function cantidadFotosPosteo($bd,$usuario)
{  
    try{
    $consulta = $bd->prepare("select * from fotos_posteo where id_usuario = ?");
    $consulta->bindValue(1,$usuario["id"]);
    $consulta->execute();
    $resultado = $consulta-> fetchAll(PDO::FETCH_ASSOC);
    return ($resultado !== false) ? ($consulta->rowCount()+1) : 1;
    } catch(PDOException $e)
    {
    echo "Error al consultar la cantidad de fotos de las publicaciones del usuario ".$e->getMessage();
    exit;
    }
} 
function agregarFotoPosteo($bd,$usuario,$foto)
{
    try{
        $bd->beginTransaction();
        $consulta = $bd->prepare("insert into fotos_posteo(id_usuario,nombre_foto) values(?,?)");
        $consulta->bindValue(1,$usuario["id"]);
        $consulta->bindValue(2,$foto);
        $consulta->execute();
        $bd->commit();

    } catch(PDOException $e)
    {
        echo "Error al actualizar la foto del usuario ".$e->getMessage();
        $bd->rollback();
        exit;
    }
}
function getPublicacion($bd,$id)
{
    try{
        $consulta = $bd->prepare("select * from posteos where id = ?");
        $consulta->bindValue(1,$id);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e)
    {
        echo "Error al consultar la publicacion ".$e-getMessage();
        exit; 
    }
}
function modificarPosteo($bd,$foto,$contenido,$id)
{
  try{
    $bd->beginTransaction();
    $consulta= $bd->prepare("update posteos set contenido_posteo = ?, foto = ? where id = ? ");
    $consulta -> bindValue(1,$contenido);
    $consulta -> bindValue(2,$foto);
    $consulta -> bindValue(3,$id);
    $consulta->execute();
    $bd->commit();
  } catch(PDOException $e )
  {
    echo "Error al actualizar posteo ".$e->getMessage();
    $bd->rollback();
    exit;
  }
}
?>