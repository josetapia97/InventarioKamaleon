<?php
require_once "../modelos/Usuario.php";

$usuario = new Usuario();
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$idempresa = isset($_POST["idempresa"]) ? limpiarCadena($_POST["idempresa"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellido = isset($_POST["apellido"]) ? limpiarCadena($_POST["apellido"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
$pass = isset($_POST["pass"]) ? limpiarCadena($_POST["pass"]) : "";
$activo = isset($_POST["activo"]) ? limpiarCadena($_POST["activo"]) : "";


switch ($_GET["op"]) {
    case 'guardar':
        if (empty($idusuario)) {
            $passhash = md5($pass);
            $res = $usuario->insertar($idempresa, $nombre, $apellido, $correo, $passhash);
            echo $res ? "Usuario registrado" : "Usuario no se pudo resgistrar";
        }
        break;
    case 'editar':
        $passhash = md5($pass);
        $res = $usuario->editar($idusuario, $idempresa, $nombre, $apellido, $correo,$passhash);
        echo $res ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        break;
    case 'editarpass':
        $passhash = md5($pass);
        $res = $usuario->editarpass($idusuario, $passhash);
        echo $res ? "Contraseña actualizada" : "Contraseña no se pudo actualizar";
        break;

    case 'mostrar':
        $res = $usuario->mostrar($idusuario);
        //utiliza json
        echo json_encode($res);
        break;
    case 'listar':
        $res = $usuario->listar();
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
        $res = $usuario->desactivar($idusuario);
        sleep(1);
        echo $res ? "Usuario Desactivado" : "Usuario no se puede desactivar";
        break;

    case 'activar':
        $res = $usuario->activar($idusuario);
        echo $res ? "Usuario activado" : "Usuario no se puede activar";
        break;
    case 'haceradmin':
        $res = $usuario->haceradmin($idusuario);
        echo $res ? "Ahora es admin" : "Usuario no se puede hacer admin";
        break;
    
    case 'quitaradmin':
        $res = $usuario->quitaradmin($idusuario);
        sleep(1);
        echo $res ? "Usuario Observer" : "No se puede quitar Admin";
         break;

}
