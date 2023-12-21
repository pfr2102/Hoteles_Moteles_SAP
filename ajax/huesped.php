<?php 
require_once "../modelos/Huesped.php";

$registroHuesped = new Huesped();

$idregistro_huesped = isset($_POST["idregistro_huesped"])? limpiarCadena($_POST["idregistro_huesped"]) : "";
$fecha_ingreso = isset($_POST["fecha_ingreso"])? limpiarCadena($_POST["fecha_ingreso"]) : "";
$fecha_salida = isset($_POST["fecha_salida"])? limpiarCadena($_POST["fecha_salida"]) : "";
$costo_reserva = isset($_POST["costo_reserva"])? limpiarCadena($_POST["costo_reserva"]) : "";
$motivo = isset($_POST["motivo"])? limpiarCadena($_POST["motivo"]) : "";
$idhotel = isset($_POST["idhotel"])? limpiarCadena($_POST["idhotel"]) : "";
$idestado = isset($_POST["idestado"])? limpiarCadena($_POST["idestado"]) : "";
$idhabitacion = isset($_POST["idhabitacion"])? limpiarCadena($_POST["idhabitacion"]) : "";
$idusuario = isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]) : "";


switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idregistro_huesped)){
		    $rspta = $registroHuesped->insertar($fecha_ingreso, $fecha_salida, $costo_reserva, $motivo, $idhotel, $idestado, $idhabitacion, $idusuario);
		    echo $rspta ? "Registro de huésped guardado" : "Registro de huésped no se pudo guardar";
		}else{
			$rspta = $registroHuesped->editar($idregistro_huesped, $fecha_ingreso, $fecha_salida, $costo_reserva, $motivo, $idhotel, $idestado, $idhabitacion, $idusuario);
			echo $rspta ? "Registro de huésped actualizado" : "Registro de huésped no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta = $registroHuesped->eliminar($idregistro_huesped);
		echo $rspta ? "Registro eliminado" : "Registro no se pudo eliminar";
	break;

	case 'mostrar':
		$rspta = $registroHuesped->mostrar($idregistro_huesped);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);		
	break;

	case 'listar':
		$hotel = $_GET['hotel'];
		$usuario = $_GET['usuario'];
		$rspta = $registroHuesped->listar($hotel, $usuario);
		//Vamos a declarar un array
		$data = array();
		while($reg = $rspta->fetch_object()){
			$data[] = array(
				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idregistro_huesped.')" data-toggle="modal" data-target="#myModal"><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-danger" onclick="eliminar('.$reg->idregistro_huesped.')" ><ion-icon name="trash"></ion-icon></button>',				
				"1"=>$reg->fecha_ingreso,
				"2"=>$reg->fecha_salida,
				"3"=>$reg->dias_reserva,
				"4"=>$reg->tipo_habitacion,
				"5"=>$reg->costo_reserva,
				"6"=>$reg->motivo,
				"7"=>$reg->estado,
				"8"=>$reg->usuario
			);
		}//while
		$results = array(
				"sEcho"=>1,//informacion para datatables
				"iTotalRecords"=>count($data),//enviamos el total de registros al datatable
				"iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
				"aaData"=>$data
		);
		echo json_encode($results);
	break;


	case'selectEstado':
		require_once "../modelos/Estado.php";
		$estado = new Estado();
		$rspta = $estado->select();

		while($reg = $rspta->fetch_object()){
			echo '<option value ='.$reg->idestado.'>'.$reg->nombre.'</option>';
		}
	break;

	case'selectHabitacion':
		require_once "../modelos/Habitacion.php";
		$hotel = $_GET['hotel'];
		$habitacion = new Habitacion();
		$rspta = $habitacion->select($hotel);

		while($reg = $rspta->fetch_object()){
			echo '<option value ='.$reg->idhabitacion.'>'.$reg->tipo.'</option>';
		}
	break;
}

?>