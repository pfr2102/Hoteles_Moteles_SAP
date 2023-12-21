<?php 

// Incluimos inicialmente la conexión a la BD
require "../config/Conexion.php";

class Habitacion {
	// Implementar nuestro constructor
	public function __construct() {

	}

	// Implementamos un método para insertar registros
	public function insertar($tipo, $personas, $tarifa_dia, $cantidad, $idhotel, $idusuario) {
		$sql = "INSERT INTO habitacion (tipo, personas, tarifa_dia, cantidad, idhotel, idusuario) 
		VALUES('$tipo', '$personas', '$tarifa_dia', '$cantidad','$idhotel','$idusuario')";
		return ejecutarConsulta($sql);
	}

	// Implementar un método para editar registros
	public function editar($idhabitacion, $tipo, $personas, $tarifa_dia, $cantidad, $idhotel, $idusuario) {
		$sql = "UPDATE habitacion SET tipo = '$tipo', personas = '$personas', tarifa_dia = '$tarifa_dia', cantidad = '$cantidad', idhotel = '$idhotel', idusuario = '$idusuario' WHERE idhabitacion = '$idhabitacion'";
		return ejecutarConsulta($sql);
	}

	// Implementamos un método para desactivar habitaciones en lugar de eliminar
	public function desactivar($idhabitacion){
		$sql = "UPDATE habitacion SET condicion = '0' WHERE idhabitacion = '$idhabitacion'";
		return ejecutarConsulta($sql);
	}

	// Implementamos un método para activar habitaciones 
	public function activar($idhabitacion){
		$sql = "UPDATE habitacion SET condicion = '1' WHERE idhabitacion = '$idhabitacion'";
		return ejecutarConsulta($sql);
	}

	// Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idhabitacion) {
		$sql = "SELECT * FROM habitacion WHERE idhabitacion = '$idhabitacion'";
		return ejecutarConsultaSimpleFila($sql);		
	}

	// Implementar un método para listar los registros
	public function listar($idhotel) {
		$sql = "SELECT * FROM habitacion WHERE idhotel = '$idhotel'";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para listar las habitaciones de cada hotel en un conbobox
	public function select($idhotel){
		$sql = "SELECT idhabitacion, tipo FROM habitacion WHERE idhotel = '$idhotel'";
		return ejecutarConsulta($sql);
	}
}

?>
