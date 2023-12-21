<?php 

//incluimos inicialmente la conexion a la BD
require "../config/Conexion.php";

Class Hotel{
	//Implementar nuestro constructor
	public function __construct(){

	}
	//Implementamos un metodo para insertar registros
	public function insertar($nombre, $categoria, $tot_habitaciones, $direccion, $telefono, $email, $estrellas, $imagen, $idestado){
		$sql = "INSERT INTO hotel (nombre, categoria, tot_habitaciones, direccion, telefono, email, estrellas, imagen, idestado) 
				VALUES('$nombre', '$categoria', '$tot_habitaciones', '$direccion', '$telefono', '$email', '$estrellas', '$imagen', '$idestado')";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para editar registros
	public function editar($idhotel, $nombre, $categoria, $tot_habitaciones, $direccion, $telefono, $email, $estrellas, $imagen, $idestado){
		$sql = "UPDATE hotel SET nombre='$nombre', categoria='$categoria', tot_habitaciones='$tot_habitaciones', direccion='$direccion', telefono='$telefono', email='$email', estrellas='$estrellas', imagen='$imagen', idestado='$idestado' WHERE idhotel='$idhotel'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un metodo para desactivar hoteles en lugar de eliminar
	public function desactivar($idhotel){
		$sql = "UPDATE hotel SET condicion = '0' WHERE idhotel = '$idhotel'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un metodo para activar hoteles en lugar de eliminar
	public function activar($idhotel){
		$sql = "UPDATE hotel SET condicion = '1' WHERE idhotel = '$idhotel'";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para mostrar los datos de un registro a modificar
	public function mostrar($idhotel){
		$sql = "SELECT * FROM hotel WHERE idhotel = '$idhotel'";
		return ejecutarConsultaSimpleFila($sql);		
	}

	//Implementar un metodo para listar los registros
	public function listar(){
		$sql = "SELECT h.idhotel, h.nombre, h.categoria, h.tot_habitaciones, h.telefono,  h.estrellas, e.nombre as estado, h.imagen, h.condicion FROM hotel h INNER JOIN estado e ON h.idestado = e.idestado WHERE h.idhotel <> 1";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para listar los estados
	public function select(){
		$sql = "SELECT idhotel ,nombre FROM hotel WHERE condicion = 1 AND idhotel <> 1";
		return ejecutarConsulta($sql);
	}
}

?>
