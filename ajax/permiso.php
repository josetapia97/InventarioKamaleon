<?php
require_once "../modelos/Permiso.php";

$permiso = new Permiso();
$idpermiso = isset($_POST["idpermiso"]) ? limpiarCadena($_POST["idpermiso"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";



switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idpermiso)) {
            $res = $permiso->insertar($nombre);
            echo $res ? "Permiso registrado" : "Permiso no se pudo resgistrar";
        } else {
            $res = $permiso->editar($idpermiso, $nombre);
            echo $res ? "Permiso actualizado" : "Permiso no se pudo actualizar";
        }
        break;
    case 'mostrar':
        $res = $permiso->mostrar($idpermiso);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $permiso->listar();
        //se declara array
        $data = array();

        $data = $res->fetch_all();
        $results = [
            "sEcho" => 1, //informacion para datatable
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "data" => $data
        ];

        echo json_encode($results);


        break;
}