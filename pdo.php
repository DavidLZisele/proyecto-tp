<?php 
$dsn = 'mysql:host=localhost;dbname=red_social;port=3306';
$user = 'root';
$pass = '';

function abrirBaseDeDatos($dsn, $user, $pass) {
  try {
    return new PDO($dsn,$user,$pass);
  } catch (PDOException $Exception){
      echo $Exception->getMessage();
      exit;
  } 
}

$bd = abrirBaseDeDatos($dsn, $user, $pass);
?>