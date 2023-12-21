<?php 

// Incluimos inicialmente la conexión a la BD
require "../config/Conexion.php";

class Huesped {
	// Implementar nuestro constructor
	public function __construct() {

	}

	// Implementamos un método para insertar registros
	public function insertar($fecha_ingreso, $fecha_salida, $costo_reserva, $motivo, $idhotel, $idestado, $idhabitacion	,$idusuario) {
		$sql = "INSERT INTO registro_huesped (fecha_ingreso, fecha_salida, costo_reserva, motivo, idhotel, idestado, idhabitacion, idusuario) 
		VALUES('$fecha_ingreso', '$fecha_salida', '$costo_reserva', '$motivo', '$idhotel', '$idestado', '$idhabitacion'	,'$idusuario')";
		return ejecutarConsulta($sql);
	}

	// Implementar un método para editar registros
	public function editar($idregistro_huesped, $fecha_ingreso, $fecha_salida, $costo_reserva, $motivo, $idhotel, $idestado, $idhabitacion, $idusuario) {
	    $sql = "UPDATE registro_huesped SET fecha_ingreso = '$fecha_ingreso', fecha_salida = '$fecha_salida', costo_reserva = '$costo_reserva', motivo = '$motivo', idhotel = '$idhotel', idestado = '$idestado', idhabitacion = '$idhabitacion', idusuario = '$idusuario' WHERE idregistro_huesped = '$idregistro_huesped'";
	    return ejecutarConsulta($sql);
	}

	// Implementar un metodo para eliminar definitivamente un registro
	public function eliminar($idregistro_huesped){
	    $sql = "DELETE FROM registro_huesped WHERE idregistro_huesped = '$idregistro_huesped'";
	    return ejecutarConsulta($sql);
	}

	// Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idregistro_huesped) {
	    $sql = "SELECT * FROM registro_huesped WHERE idregistro_huesped = '$idregistro_huesped'";
	    return ejecutarConsultaSimpleFila($sql);        
	}

	// Implementar un método para listar los registros
	public function listar($idhotel, $idusuario) {
	    $sql = "SELECT rh.idregistro_huesped, rh.fecha_ingreso, rh.fecha_salida, rh.dias_reserva, h.tipo as tipo_habitacion, rh.costo_reserva, rh.motivo,  e.nombre as estado, u.login as usuario, rh.idhotel, rh.idusuario FROM registro_huesped rh 
	    INNER JOIN estado e ON e.idestado=rh.idestado
	    INNER JOIN habitacion h ON h.idhabitacion=rh.idhabitacion
	    INNER JOIN usuario u ON u.idusuario=rh.idusuario
	    WHERE rh.idhotel = '$idhotel' AND rh.idusuario = '$idusuario'";
	    return ejecutarConsulta($sql);
	}

	
}

?>
