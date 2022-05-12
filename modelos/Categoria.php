<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

Class Categoria{
    //implementando constructor
    public function __construct(){

    }

    //insertar registros

    public function insertar($nombre, $propiedades)
    {
        $sql = "INSERT INTO categoria (nombre,propiedades) VALUES ( ?, ? )";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('ss', $nombre, $propiedades);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    //editar registros

    public function editar($idcategoria, $nombre, $propiedades)
    {
        $sql = "UPDATE categoria SET nombre = ? ,propiedades = ? WHERE idcategoria = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('ssi', $nombre, $propiedades, $idcategoria);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function mostrar($idcategoria)
    {
        $sql = "SELECT * FROM categoria WHERE idcategoria = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idcategoria);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM categoria";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM categoria WHERE idcategoria = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }
    
    /*----------------------------*/

    //mostrar los datos de un registro a modificar
    

}
