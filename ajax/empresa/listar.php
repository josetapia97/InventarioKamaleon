<?php

require_once "../modelos/Empresa.php";

$empresa = new Empresa();

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  $res = $empresa->listar();
  $data = array();

  $data = $res->fetch_all();
  $resultData = array();

  foreach ($data as $elem) {
    array_push($resultData, array(
      $elem[1], $elem[2], 0, '<button class="btn btn-warning" onclick="mostrar(' . $elem[0] . ')"><i class="fa fa-pencil" ></i></button>'
        . '<button class="btn btn-danger" onclick="desactivar(' . $elem[0] . ')"><i class="fa fa-close" ></i></button>'
    ));
  }

  $results = [
    "sEcho" => 1, //informacion para datatable
    "iTotalRecords" => count($data), //enviamos el total de registros al datatable
    "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
    "data" => $resultData
  ];


  echo json_encode($results);
}
