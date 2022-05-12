<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

Class Caracteristica{
    //implementando constructor
    public function __construct(){

    }

    //insertar registros

    public function insertar($nombre)
    {
        $sql = "INSERT INTO caracteristica(nombre) VALUES  (?) ";
        $con = getConnection();
        $stmt= $con ->prepare($sql);
        var_dump($con->error);
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    //editar registros

    public function editar($idcaracteristica, $nombre)
    {
        $sql = "UPDATE caracteristica SET nombre = ? WHERE idcaracteristica = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('is', $idcaracteristica, $nombre);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function mostrar($idcaracteristica)
    {
        $sql = "SELECT * FROM caracteristica WHERE idcaracteristica = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idcaracteristica);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM caracteristica";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM caracteristica WHERE idcaracteristica = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }
    
    

}
