<?php

require_once "../../modelos/Empresa.php";

session_start();

if ( empty($_SESSION['admin']) ){
  http_response_code(403);
  die( "Bad Request" );
}

$empresa = new Empresa();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = $_POST['id'];

  $res = $empresa->eliminar($id);

  $response = array(
    "affectedRows" => $res
  );

  echo json_encode($response);
}
