<?php 

//incluimos inicialmente la conexion a la BD
require "../config/Conexion.php";

Class Permiso{
	//Implementar nuestro constructor
	public function __construct(){

	}

	//Implementar un metodo para listar los registros
	public function listar(){
		$sql = "SELECT * FROM permiso";
		return ejecutarConsulta($sql);
	}
}

?>