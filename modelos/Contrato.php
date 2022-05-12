<?php
//conexion a bd
require_once __DIR__ . "\..\config\conexion.php";

class Contrato
{
    //implementando constructor
    public function __construct()
    {
    }

    //insertar registros
    public function insertar($idarticulo, $idusuariofinal, $idempresa, $valorarticulo)
    {
        getConnection()->autocommit(false);

        try {
            $sql = "INSERT INTO contrato (idarticulo,idusuariofinal,idempresa,fechainicio,valorarticulo) VALUES (?, ?, ? , SYSDATE() , ? )";
            $stmt = getConnection()->prepare($sql);
            $stmt->bind_param('iiii', $idarticulo, $idusuariofinal, $idempresa, $valorarticulo);
            $stmt->execute();
    
            if ( $stmt->affected_rows == 0 ){
                getConnection()->rollback();
                return false;
            }
    
            require_once('Articulo.php');
            $Articulo = new Articulo();
            $activado = $Articulo->arrendado( $idarticulo );
            if( !empty($activado) ){ // Activado correctamente
                getConnection()->commit();
                return true;
            }
        } catch (\Throwable $th) {
            getConnection()->rollback();
            return false;
            //throw $th;
        }
        // no se activo el articulo, cancelar todo
        return false;
    }

    //editar registros
    //editar registros

    public function editar($idcontrato, $idarticulo, $idusuariofinal, $idempresa, $fechainicio, $fechatermino, $valorarticulo)
    {
        $sql = "UPDATE contrato SET idarticulo = ? ,idusuariofinal = ? ,idempresa = ?, fechainicio = ?, fechatermino = ?, valorarticulo= ? WHERE idcontrato = ?";
        $con = getConnection();
        $stmt = $con -> prepare($sql);
        $stmt->bind_param('iiissii', $idarticulo, $idusuariofinal, $idempresa, $fechainicio, $fechatermino, $valorarticulo, $idcontrato);
        $stmt->execute();
        return $stmt->affected_rows;
    }



    //mostrar los datos de un registro a modificar
    public function mostrar($idcontrato)
    {
        $sql = "SELECT * FROM contrato WHERE idcontrato = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $idcontrato);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return empty($result) ? [] : $result[0];
    }

    public function listar()
    {
        $sql = "SELECT * FROM contrato";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM contrato WHERE idcontrato = ?";

        $stmt = getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function finalizarcontrato($idcontrato)
    {
        getConnection()->autocommit(false);

        try {

            $sql = "UPDATE contrato SET vigente=0, fechatermino= SYSDATE() WHERE idcontrato = ?";
            $stmt = getConnection()->prepare($sql);
            $stmt->bind_param('i', $idcontrato);
            $stmt->execute();
    
            if ( $stmt->affected_rows == 0 ){
                throw new Exception("No se pudo finalizar el contrato", 1);
            }

            $contrato = $this->mostrar( $idcontrato );

            require_once('Articulo.php');
            $Articulo = new Articulo();

            $desarm = $Articulo->desarrendado( $contrato['idarticulo'] );
            if( !empty($desarm) ){ // Activado correctamente
                getConnection()->commit();
                return true;
            }
            throw new Exception("No se pudo desarrendar el articulo", 1);
        } catch (\Throwable $th) {
            getConnection()->rollback();
            return false;
            //throw $th;
        }
        // no se activo el articulo, cancelar todo
        return false;
    }

    public function activar($idcontrato)
    {
        getConnection()->autocommit(false);

        try {

            $sql = "UPDATE contrato SET vigente=1, fechatermino= NULL WHERE idcontrato = ?";
            $stmt = getConnection()->prepare($sql);
            $stmt->bind_param('i', $idcontrato);
            $stmt->execute();
    
            if ( $stmt->affected_rows == 0 ){
                throw new Exception("No se pudo activar el contrato", 1);
            }

            $contrato = $this->mostrar( $idcontrato );

            require_once('Articulo.php');
            $Articulo = new Articulo();

            $desarm = $Articulo->arrendado( $contrato['idarticulo'] );
            if( !empty($desarm) ){ // Activado correctamente
                getConnection()->commit();
                return true;
            }
            throw new Exception("No se pudo arrendar el articulo", 1);
        } catch (\Throwable $th) {
            getConnection()->rollback();
            return false;
            //throw $th;
        }
        // no se desactivo el articulo, cancelar todo
        return false;
    }

    /*************************************** */
    public function listarpatrimonio()
    {
        $sql = "SELECT e.razonsocial, 
                 nvl( 	(SELECT SUM(C.valorarticulo)
                    FROM articulo A
                    INNER JOIN CONTRATO C ON A.IDARTICULO = C.IDARTICULO
                    JOIN usuariofinal U ON C.idusuariofinal = U.idusuariofinal WHERE A.arrendado != 1 AND U.idempresa = E.IDEMPRESA ),
                     0) AS patrimonio
                 FROM empresa E";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function articarrendados()
    {
        $sql = "SELECT E.razonsocial, C.nombre as categoria, A.idarticulo, A.nombre as articulo
        FROM articulo A  inner join categoria C
        on A.idcategoria = C.idcategoria
        inner JOIN empresa E
        on A.idempresa = E.idempresa 
        WHERE A.arrendado = 1 AND A.ACTIVO = 1";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function articdisponibles()
    {
        $sql = "SELECT E.razonsocial, C.nombre as categoria, A.idarticulo, A.nombre as articulo
        FROM articulo A  inner join categoria C
        on A.idcategoria = C.idcategoria
        inner JOIN empresa E
        on A.idempresa = E.idempresa 
        WHERE A.ARRENDADO = 0 AND A.ACTIVO = 1";
        /** columnas razonsocial, categoria, idarticulo, articulo */
        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function caracporartic()
    {
        $sql = "SELECT AR.idarticulo, AR.nombre as articulo, AR.activo,C.nombre as caracteristica, A.valor 
        FROM atributos A INNER JOIN caracteristica C ON A.idcaracteristica = C.idcaracteristica 
        INNER JOIN articulo AR ON AR.idarticulo = A.idarticulo WHERE ar.idarticulo = 1";
        /** idarticulo, articulo, activo , caracteristica,valor*/
        $stmt = getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    public function valorartvigen()
    {
        $sql = "SELECT A.idarticulo,A.nombre, C.valorarticulo 
        FROM articulo A INNER JOIN contrato C ON A.idarticulo = C.idarticulo 
        where c.vigente = 1";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();
        /**idarticulo, nombre, valorarticulo */
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function repContratos()
    {
        $sql = "SELECT C.idcontrato, E.razonsocial, A.nombre as articulo, T.nombre,T.apellido,C.fechainicio,C.fechatermino,C.valorarticulo as valor,C.vigente 
        FROM contrato C INNER JOIN empresa E ON c.idempresa = e.idempresa 
        INNER JOIN articulo A ON A.idarticulo = C.idarticulo 
        INNER JOIN usuariofinal T on C.idusuariofinal=T.idusuariofinal";

        $stmt = getConnection()->prepare($sql);
        $stmt->execute();
        /**idcontrato, razonsocial, articulo,nombre,apellido,fechainicio,fechatermino,valor,vigente */
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
