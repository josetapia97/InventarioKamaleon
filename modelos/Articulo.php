<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

class Articulo
{
    //implementando constructor
    public function __construct()
    {
    }

    //insertar registros
    public function insertar($idcategoria, $idempresa, $codigo, $nombre)
    {
        $sql = "INSERT INTO articulo (idcategoria,idempresa,codigo,nombre) VALUES (?, ?, ? , ? )";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('iiss', $idcategoria, $idempresa, $codigo, $nombre);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    //editar registros
    //editar registros

    public function editar($idarticulo, $idcategoria, $idempresa, $codigo, $nombre, $imagen)
    {
        $sql = "UPDATE articulo SET idcategoria = ? ,idempresa = ? ,codigo = ?,nombre = ?, imagen= ? WHERE idarticulo = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('iisssi', $idcategoria, $idempresa, $codigo, $nombre, $imagen, $idarticulo);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function editarimagen($idarticulo, $imagen)
    {
        $sql = "UPDATE articulo SET imagen='$imagen' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }



    //mostrar los datos de un registro a modificar
    public function mostrar($idarticulo)
    {
        $sql = "SELECT * FROM articulo WHERE idarticulo = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idarticulo);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM articulo";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM articulo WHERE idarticulo = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function desactivar($idarticulo)
    {
        $sql = "UPDATE articulo SET activo=0 WHERE idarticulo = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idarticulo);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function activar($idarticulo)
    {
        $sql = "UPDATE articulo SET activo=1 WHERE idarticulo=?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idarticulo);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function arrendado($idarticulo)
    {
        $sql = "UPDATE articulo SET arrendado=1 WHERE idarticulo=?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idarticulo);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function desarrendado($idarticulo)
    {
        $sql = "UPDATE articulo SET arrendado=0 WHERE idarticulo=?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idarticulo);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function CambiaraNuevo($idarticulo)
    {
        $sql = "UPDATE articulo SET condicion=1 WHERE idarticulo = ?";
        $con = getConnection();

        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $idarticulo);
        $stmt->execute();
        var_dump($stmt->error);

        return $stmt->affected_rows;
    }

    public function CambiaraUsado($idarticulo)
    {
        $sql = "UPDATE articulo SET condicion=0 WHERE idarticulo=?";
        $con = getConnection();
        $stmt = $con->prepare($sql);
        // debug  var_dump($con->error);
        $stmt->bind_param('i', $idarticulo);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}
