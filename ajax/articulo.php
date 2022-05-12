<?php
require_once "../modelos/Articulo.php";

$articulo = new Articulo();
$idarticulo = isset($_POST["idarticulo"]) ? limpiarCadena($_POST["idarticulo"]) : "";
$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";
$idempresa = isset($_POST["idempresa"]) ? limpiarCadena($_POST["idempresa"]) : "";
$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";



switch ($_GET["op"]) {
    case 'guardar':

        if (empty($idarticulo)) {
            $res = $articulo->insertar($idcategoria, $idempresa, $codigo, $nombre);
            echo $res ? "Articulo registrado" : "Articulo no se pudo resgistrar";
        }
        break;
    case 'editar':
        $res = $articulo->editar($idarticulo,$idcategoria, $idempresa, $codigo, $nombre,$imagen);
        echo $res ? "Articulo actualizado" : "Articulo no se pudo actualizar";
        break;
    case 'mostrar':
        $res = $articulo->mostrar($idarticulo);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $articulo->listar();
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
        $res = $articulo->desactivar($idarticulo);
        sleep(1);
        echo $res ? "Articulo Desactivado" : "Articulo no se puede desactivar";
        break;

    case 'activar':
        $res = $articulo->activar($idarticulo);
        echo $res ? "Articulo activado" : "Articulo no se puede activar";
        break;
    case 'cambiaranuevo':
        $res = $articulo->CambiaraNuevo($idarticulo);
        echo $res ? "Articulo nuevo" : "El estado del articulo no se pudo cambiar";
        break;
    
    case 'cambiarausado':
        $res = $articulo->CambiaraUsado($idarticulo);
        sleep(1);
        echo $res ? "Articulo usado" : "El estado del articulo no se pudo cambiar";
         break;

    
}
