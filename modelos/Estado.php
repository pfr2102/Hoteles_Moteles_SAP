<?php 

//incluimos inicialmente la conexion a la BD
require "../config/Conexion.php";

Class Estado{
	//Implementar nuestro constructor
	public function __construct(){

	}

	//Implementar un metodo para listar los estados
	public function select(){
		$sql = "SELECT * FROM estado";
		return ejecutarConsulta($sql);
	}
}

?>