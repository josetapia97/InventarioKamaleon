<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

class Empresa
{
    //implementando constructor
    public function __construct()
    {
    }

    //insertar registros

    public function insertar($razon, $rut, $patrimonio)
    {
        $sql = "INSERT INTO empresa (razonsocial,rut,patrimonio) VALUES (?, ?, ?)";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('ssi', $razon, $rut, $patrimonio);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    //editar registros
    public function editar($idempresa, $razon, $rut, $patrimonio)
    {
        $sql = "UPDATE empresa SET razonsocial = ? ,rut = ? ,patrimonio = ? WHERE idempresa = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('ssii', $razon, $rut, $patrimonio, $idempresa);
        $stmt->execute();
        return $stmt->affected_rows;
    }


    public function mostrar($idempresa)
    {
        $sql = "SELECT * FROM empresa WHERE idempresa = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idempresa);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM empresa";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM empresa WHERE idempresa = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }
}
