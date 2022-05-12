<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

class Atributos
{
    //implementando constructor
    public function __construct()
    {
    }

    //insertar registros
    public function insertar($idcaracteristica, $idarticulo, $valor)
    {
        $sql = "INSERT INTO atributos (idcaracteristica,idarticulo,valor) VALUES (? , ? , ? )";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('iis', $idcaracteristica, $idarticulo, $valor);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    //editar registros
    //editar registros

    public function editar($idatributos, $idcaracteristica, $idarticulo, $valor)
    {
        $sql = "UPDATE atributos SET idcaracteristica = ? ,idarticulo = ? ,valor = ? WHERE idatributos = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('iisi', $idcaracteristica, $idarticulo, $valor, $idatributos);
        $stmt->execute();
        return $stmt->affected_rows;
    }


    //mostrar los datos de un registro a modificar
    public function mostrar($idatributos)
    {
        $sql = "SELECT * FROM atributos WHERE idatributos = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idatributos);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM atributos";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM atributos WHERE idatributos = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }
}
