<?php 
require_once "globales.php";

$conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME,33085);

mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

//Si tenemos un posible error en la conexion lo mostramos
if(mysqli_connect_errno()){
	printf("Fallo conexion a la BD: %\n",mysqli_connect_errno());
	exit();
}

if(!function_exists('ejecutarConsulta')){

	function ejecutarConsulta($sql){
		global $conexion;
		$query = $conexion->query($sql);
		cerrarConexion();
		return $query;
	}
	function ejecutarConsultaAbierta($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $query;
	}

	function ejecutarConsultaSimpleFila($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$row = $query->fetch_assoc();
		cerrarConexion();
		return $row;
	}

	function ejecutarConsulta_retornaID($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $conexion->insert_id;
	}
	/*function ejecutarConsulta_retornaID($sql){
		global $conexion;
		$query = $conexion->query($sql);
		$insert_id = $conexion->insert_id;
		cerrarConexion();
		return $insert_id;
	}*/

	function limpiarCadena($str){
		global $conexion;
		$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}
	/*function limpiarCadena($str){
		global $conexion;
		$str = mysqli_real_escape_string($conexion,trim($str));
		$str = htmlspecialchars($str);
		cerrarConexion();
		return $str;
	}*/

	function cerrarConexion(){
		global $conexion;
		$conexion->close();
	}
}

?>