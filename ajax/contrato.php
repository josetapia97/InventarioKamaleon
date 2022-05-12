<?php
require_once "../modelos/Contrato.php";

$contrato = new Contrato();
$idcontrato = isset($_POST["idcontrato"]) ? limpiarCadena($_POST["idcontrato"]) : "";
$idarticulo = isset($_POST["idarticulo"]) ? limpiarCadena($_POST["idarticulo"]) : "";
$idusuariofinal = isset($_POST["idusuariofinal"]) ? limpiarCadena($_POST["idusuariofinal"]) : "";
$idempresa = isset($_POST["idempresa"]) ? limpiarCadena($_POST["idempresa"]) : "";
$fechainicio = isset($_POST["fechainicio"]) ? limpiarCadena($_POST["fechainicio"]) : "";
$fechatermino = isset($_POST["fechatermino"]) ? limpiarCadena($_POST["fechatermino"]) : "";
$valorarticulo = isset($_POST["valorarticulo"]) ? limpiarCadena($_POST["valorarticulo"]) : "";
$vigente = isset($_POST["vigente"]) ? limpiarCadena($_POST["vigente"]) : "";


switch ($_GET["op"]) {
    case 'guardar':

        if (empty($idcontrato)) {
            $res = $contrato->insertar($idarticulo, $idusuariofinal, $idempresa, $valorarticulo);
            echo $res ? "Contrato registrado" : "Contrato no se pudo resgistrar";
        }
        break;
    case 'editar':
        $res = $contrato->editar($idcontrato,$idarticulo, $idusuariofinal, $idempresa,$fechainicio,$fechatermino, $valorarticulo);
        echo $res ? "Contrato actualizado" : "Contrato no se pudo actualizar";
        break;
    break;
    case 'eliminar':
        $res = $contrato->eliminar($idcontrato);
    
        $response = array(
            "affectedRows" => $res
        );
    
        echo json_encode($response);
    
    break;
    case 'mostrar':
        $res = $contrato->mostrar($idcontrato);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $contrato->listar();
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
        //CASE ACTIVAR
        //Case desactivar
    case 'finalizarcontrato':
        $res = $contrato->finalizarcontrato($idcontrato);
        sleep(1);
        echo $res ? "Contrato finalizado, revisar fecha de termino" : "Contrato no se pudo finalizar";
        break;

    case 'activar':
        $res = $contrato->activar($idcontrato);
        echo $res ? "Contrato activado, revisar fecha de termino" : "Contrato no pudo hacerse vigente";
        break;
    
}
