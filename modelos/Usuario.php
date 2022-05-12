<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

class Usuario
{
    //implementando constructor
    public function __construct()
    {
    }

    //insertar registros
    public function insertar($idempresa, $nombre, $apellido, $correo, $pass)
    {
        $sql = "INSERT INTO usuario (idempresa,nombre,apellido,correo,pass) VALUES (?, ?, ? , ? , ? )";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('issss', $idempresa, $nombre, $apellido, $correo, $pass);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    //editar registros
    //editar registros

    public function editar($idusuario, $idempresa, $nombre, $apellido, $correo, $pass)
    {
        $sql = "UPDATE usuario SET idempresa = ? ,nombre = ? ,apellido = ?,correo = ?, pass= ? WHERE idusuario = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('issssi', $idempresa, $nombre, $apellido, $correo,$pass, $idusuario);
        $stmt->execute();
        return $stmt->affected_rows;
    }


    //editar pass
    public function editarpass($idusuario, $pass)
    {
        $sql = "UPDATE usuario SET pass='$pass' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //desactivar (articulo, usuario,contrato,usuariofinal) y condicion(articulo)



    public function buscarcorreo($correo)
    {
        $sql = "SELECT * FROM usuario WHERE correo ='$correo' and activo = 1";
        return ejecutarConsultaSimpleFila($sql);
    }





    //mostrar los datos de un registro a modificar
    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idusuario);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM usuario";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM usuario WHERE idusuario = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuario SET activo=0 WHERE idusuario = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idusuario);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function activar($idusuario)
    {
        $sql = "UPDATE usuario SET activo=1 WHERE idusuario=?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idusuario);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function haceradmin($idusuario)
    {
        $sql = "UPDATE usuario SET esadmin=1 WHERE idusuario = ?";
        $con = getConnection();

        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $idusuario);
        $stmt->execute();
        var_dump($stmt->error);

        return $stmt->affected_rows;
    }

    public function quitaradmin($idusuario)
    {
        $sql = "UPDATE usuario SET esadmin=0 WHERE idusuario=?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idusuario);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}
