<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

class Usuariofinal
{
    //implementando constructor
    public function __construct()
    {
    }

    //insertar registros
    public function insertar($idempresa, $rut, $nombre, $apellido, $correo)
    {
        $sql = "INSERT INTO usuariofinal (idempresa, rut, nombre, apellido, correo) VALUES (?, ?, ? , ? , ? )";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('issss', $idempresa, $rut, $nombre, $apellido, $correo);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    //editar registros
    //editar registros

    public function editar($idusuariofinal, $idempresa, $rut, $nombre, $apellido, $correo)
    {
        $sql = "UPDATE usuariofinal SET idempresa = ? ,rut = ? ,nombre = ?,apellido = ?, correo = ? WHERE idusuariofinal = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('issssi', $idempresa, $rut, $nombre, $apellido, $correo, $idusuariofinal);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function buscarcorreo($correo)
    {
        $sql = "SELECT * FROM usuariofinal WHERE correo ='$correo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //mostrar los datos de un registro a modificar
    public function mostrar($idusuariofinal)
    {
        $sql = "SELECT * FROM usuariofinal WHERE idusuariofinal = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idusuariofinal);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM usuariofinal";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM usuariofinal WHERE idusuariofinal = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function desactivar($idusuariofinal)
    {
        $sql = "UPDATE usuariofinal SET activo=0 WHERE idusuariofinal = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idusuariofinal);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function activar($idusuariofinal)
    {
        $sql = "UPDATE usuariofinal SET activo=1 WHERE idusuariofinal=?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idusuariofinal);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}
