<?php 
require_once "../modelos/Habitacion.php";

$habitacion = new Habitacion();

$tipo = isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]) : "";
$personas = isset($_POST["personas"])? limpiarCadena($_POST["personas"]) : "";
$tarifa_dia = isset($_POST["tarifa_dia"])? limpiarCadena($_POST["tarifa_dia"]) : "";
$cantidad = isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]) : "";
$idhotel = isset($_POST["idhotel"])? limpiarCadena($_POST["idhotel"]) : "";
$idusuario = isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]) : "";
$idhabitacion = isset($_POST["idhabitacion"])? limpiarCadena($_POST["idhabitacion"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idhabitacion)){
		    $rspta = $habitacion->insertar($tipo, $personas, $tarifa_dia, $cantidad, $idhotel, $idusuario);
		    echo $rspta ? "Habitación registrada" : "Habitación no se pudo registrar";
		}else{
			$rspta = $habitacion->editar($idhabitacion, $tipo, $personas, $tarifa_dia, $cantidad, $idhotel, $idusuario);
			echo $rspta ? "Habitación actualizada" : "Habitación no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta = $habitacion->desactivar($idhabitacion);
		echo $rspta ? "Habitación desactivada" : "Habitación no se pudo desactivar";
	break;

	case 'activar':
		$rspta = $habitacion->activar($idhabitacion);
		echo $rspta ? "Habitación activada" : "Habitación no se pudo activar";
	break;

	case 'mostrar':
		$rspta = $habitacion->mostrar($idhabitacion);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);		
	break;

	case 'listar':
		$hotel = $_GET['hotel'];
		$rspta = $habitacion->listar($hotel);
		//Vamos a declarar un array
		$data = array();
		while($reg = $rspta->fetch_object()){
			$data[] = array(
				"0"=>($reg->condicion)? 
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idhabitacion.')" data-toggle="modal" data-target="#myModal"><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idhabitacion.')" ><ion-icon name="trash"></ion-icon></button>'
				:
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idhabitacion.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idhabitacion.')" ><i class="fa fa-check"></i></button>',
				"1"=>$reg->tipo,
				"2"=>$reg->personas,
				"3"=>$reg->tarifa_dia,
				"4"=>$reg->cantidad,
				"5"=>($reg->condicion)? '<span class="label bg-green">Activo</span>' : '<span class="label bg-red">Inactivo</span>'
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
}

?>