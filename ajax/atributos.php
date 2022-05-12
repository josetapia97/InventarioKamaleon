<?php
require_once "../modelos/Atributos.php";

$atributos = new Atributos();
$idatributos = isset($_POST["idatributos"]) ? limpiarCadena($_POST["idatributos"]) : "";
$idcaracteristica = isset($_POST["idcaracteristica"]) ? limpiarCadena($_POST["idcaracteristica"]) : "";
$valor = isset($_POST["valor"]) ? limpiarCadena($_POST["valor"]) : "";



switch ($_GET["op"]) {
    case 'guardar':

        if (empty($idatributos)) {
            $res = $atributos->insertar($idcaracteristica, $idarticulo, $valor);
            echo $res ? "Atributo registrado" : "Atributo no se pudo resgistrar";
        }
        break;
    case 'editar':
        $res = $atributos->editar($idatributos, $idcaracteristica, $idarticulo, $valor);
        echo $res ? "Atributo actualizado" : "Atributo no se pudo actualizar";
        break;
    case 'mostrar':
        $res = $atributos->mostrar($idatributos);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $atributos->listar();
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
         $res = $atributos->eliminar($idatributos);
        
         $response = array(
             "affectedRows" => $res
         );
      
         echo json_encode($response);
        
            
    break;

}