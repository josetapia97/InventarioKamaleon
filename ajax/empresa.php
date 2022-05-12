<?php
require_once "../modelos/Empresa.php";

$empresa = new Empresa();
$idempresa = isset($_POST["idempresa"]) ? limpiarCadena($_POST["idempresa"]) : "";
$razonsocial = isset($_POST["razonsocial"]) ? limpiarCadena($_POST["razonsocial"]) : "";
$rut = isset($_POST["rut"]) ? limpiarCadena($_POST["rut"]) : "";
$patrimonio = isset($_POST["patrimonio"]) ? limpiarCadena($_POST["patrimonio"]) : "";

header('Content-Type: application/json; charset=utf-8');

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idempresa)) {
            $res = $empresa->insertar($razonsocial, $rut, $patrimonio);
            echo $res ? "Empresa registrada" : "Empresa no se pudo resgistrar";
        } else {
            $res = $empresa->editar($idempresa, $razonsocial, $rut, $patrimonio);
            echo $res ? "Empresa actualizada" : "Empresa no se pudo actualizar";
        }
        break;
    case 'mostrar':
        $res = $empresa->mostrar($idempresa);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $empresa->listar();
        //aqui en el indice 0 iría: '<button class="btn btn-warning onclick="mostrar('.$reg->idempresa.')"><i class="fa fa-pencil" ></i></button>'
        // . '<button class="btn btn-danger onclick="desactivar('.$reg->idempresa.')"><i class="fa fa-close" ></i></button>'
        //se declara array
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


        break;
}
