<?php
require_once "../modelos/Caracteristica.php";

$caracteristica = new Caracteristica();
$idcaracteristica = isset($_POST["idcaracteristica"]) ? limpiarCadena($_POST["idcaracteristica"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";



switch ($_GET["op"]) {
    case 'guardar':

        if (empty($idcaracteristica)) {
            $res = $caracteristica->insertar($nombre);
            echo $res ? "Caracteristica registrada" : "Caracteristica no se pudo resgistrar";
        }
        break;
    case 'editar':
        $res = $caracteristica->editar($idcaracteristica, $nombre);
        echo $res ? "Caracteristica actualizada" : "Caracteristica no se pudo actualizar";
        break;
    case 'mostrar':
        $res = $caracteristica->mostrar($idcaracteristica);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $caracteristica->listar();
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
    case 'eliminar':
        $res = $caracteristica->eliminar($idcaracteristica);
    
        $response = array(
            "affectedRows" => $res
        );
    
        echo json_encode($response);
    
        
    break;

    
}
