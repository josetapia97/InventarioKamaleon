<?php
//conexion a bd
require_once "../config/conexion.php";

Class Permiso{
    //implementando constructor
    public function __construct(){

    }

    //insertar registros

    public function insertar($nombre){
        $sql="INSERT INTO permiso (nombre) VALUES ('$nombre')";
        return ejecutarConsulta($sql);
    }
    //editar registros
    public function editar($idpermiso,$nombre){
        $sql="UPDATE permiso SET nombre='$nombre' WHERE idpermiso='$idpermiso'";
        return ejecutarConsulta($sql);
    }
    public function mostrar($idpermiso){
        $sql="SELECT * FROM permiso WHERE idempresa ='$idpermiso'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql ="SELECT * FROM permiso";
        return ejecutarConsulta($sql);
    }
}
