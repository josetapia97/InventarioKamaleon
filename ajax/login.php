<?php

session_start();
require '../modelos/Usuario.php';


$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
$pass = isset($_POST["pass"]) ? limpiarCadena($_POST["pass"]) : "";




function login($correo, $pass)
{
  $usuario = new Usuario();

  $res = $usuario->buscarcorreo($correo);
  if (empty($res)) {
    return;
  }
  
  $usuario = $res;
  $passhash = $usuario['pass'];
  if ( md5($pass) == $passhash){
    if($usuario['esadmin']==1){
      $_SESSION['admin']=true;
    }else{
      $_SESSION['admin']=false;
    }
    
    $_SESSION['id'] = $usuario['idusuario'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['apellido'] = $usuario['apellido'];
    $_SESSION['empresa'] = $usuario['idempresa'];
    $_SESSION['correo'] = $usuario['correo'];
    return true;
  } else {
    return false;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = $_POST['correo'];
  $pass = $_POST['pass'];

  $logged = login($correo, $pass);
  if ($logged) {
   header("Location: ../index.php");
    exit();
  } else {
   header("Location: ../login.php?msj=1");
    exit();
  }
}
