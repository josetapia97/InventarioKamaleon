<?php
require_once "../modelos/Usuariofinal.php";

$usuariof = new Usuariofinal();
$idusuariofinal = isset($_POST["idusuariofinal"]) ? limpiarCadena($_POST["idusuariofinal"]) : "";
$idempresa = isset($_POST["idempresa"]) ? limpiarCadena($_POST["idempresa"]) : "";
$rut = isset($_POST["rut"]) ? limpiarCadena($_POST["rut"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellido = isset($_POST["apellido"]) ? limpiarCadena($_POST["apellido"]) : "";
$activo = isset($_POST["activo"]) ? limpiarCadena($_POST["activo"]) : ""; //los atributos por defecto igual debo limpiarlos?
$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";


switch ($_GET["op"]) {
    case 'guardar':

        if (empty($idusuariofinal)) {
            $res = $usuariof->insertar($idempresa, $rut, $nombre, $apellido, $correo);
            echo $res ? "Trabajador registrado" : "Trabajador no se pudo resgistrar";
        }
        break;
    case 'editar':
        $res = $usuariof->editar($idusuariofinal, $idempresa, $rut, $nombre, $apellido, $correo);
        echo $res ? "Trabajador actualizado" : "Trabajador no se pudo actualizar";
        break;
    case 'mostrar':
        $res = $usuariof->mostrar($idusuariofinal);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $usuariof->listar();
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
    case 'desactivar':
        $res = $usuariof->desactivar($idusuariofinal);
        sleep(1);
        echo $res ? "Trabajador Desactivado" : "Trabajador no se puede desactivar";
        break;

    case 'activar':
        $res = $usuariof->activar($idusuariofinal);
        echo $res ? "Trabajador activado" : "Trabajador no se puede activar";
        break;
}