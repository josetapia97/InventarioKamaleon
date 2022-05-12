<?php
require_once "../modelos/Categoria.php";

$categoria = new Categoria();
$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$propiedades = isset($_POST["propiedades"]) ? limpiarCadena($_POST["propiedades"]) : "";


switch ($_GET["op"]) {
    case 'insertar':
        if (empty($idcategoria)) {
            $res = $categoria->insertar($nombre, $propiedades);
            echo $res ? "Categoria registrada" : "Categoria no se pudo ingresar";
        }
        break;
    case 'editar':
        $res = $categoria->editar($idcategoria, $nombre, $propiedades);
        echo $res ? "Categoria actualizada" : "Categoria no se pudo actualizar";
        break;
    case 'mostrar':
        $res = $categoria->mostrar($idcategoria);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $categoria->listar();
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
    case 'eliminar':
        $res = $categoria->eliminar($idcategoria);

        $response = array(
         "affectedRows" => $res
        );

        echo json_encode($response);

    
    break;
}
