<?php 
require_once "../modelos/Hotel.php";

$hotel = new Hotel();

$idhotel = isset($_POST["idhotel"])? limpiarCadena($_POST["idhotel"]) : "";
$idestado = isset($_POST["idestado"])? limpiarCadena($_POST["idestado"]) : "";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]) : "";
$categoria = isset($_POST["categoria"])? limpiarCadena($_POST["categoria"]) : "";
$tot_habitaciones = isset($_POST["tot_habitaciones"])? limpiarCadena($_POST["tot_habitaciones"]) : "";
$direccion = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"])? limpiarCadena($_POST["email"]) : "";
$estrellas = isset($_POST["estrellas"])? limpiarCadena($_POST["estrellas"]) : "";
$imagen = isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		//validar que la imagen exista
		if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
			$imagen = $_POST["imagenactual"];
		}else{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			//validar que la imagen tenga solo uno de los siguientes formatos
			if($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png"){
				$imagen = round(microtime(true)).'.'.end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/hoteles/".$imagen);
			}
		}

		if (empty($idhotel)){
			$rspta = $hotel->insertar($nombre, $categoria, $tot_habitaciones, $direccion, $telefono, $email, $estrellas, $imagen, $idestado);
			echo $rspta ? "Hotel registrado" : "Hotel no se pudo registrar";
		}else{
			$rspta = $hotel->editar($idhotel, $nombre, $categoria, $tot_habitaciones, $direccion, $telefono, $email, $estrellas, $imagen, $idestado);
			echo $rspta ? "Hotel actualizado" : "Hotel no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta = $hotel->desactivar($idhotel);
		echo $rspta ? "Hotel desactivado" : "Hotel no se pudo desactivar";
	break;

	case 'activar':
		$rspta = $hotel->activar($idhotel);
		echo $rspta ? "Hotel activado" : "Hotel no se pudo activar";
	break;

	case 'mostrar':
		$rspta = $hotel->mostrar($idhotel);
		echo json_encode($rspta);		
	break;


	case 'listar':
		$rspta = $hotel->listar();
		//Vamos a declarar un array
		$data = array();
		while($reg = $rspta->fetch_object()){
			$data[] = array(
				"0"=>($reg->condicion)? 
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idhotel.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idhotel.')" ><ion-icon name="trash"></ion-icon></button>'
				:
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idhotel.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idhotel.')" ><ion-icon name="checkbox-outline"></ion-icon></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->categoria,
				"3"=>$reg->tot_habitaciones,
				"4"=>$reg->telefono,
				"5"=>$reg->estrellas,
				"6"=>$reg->estado,
				"7"=>"<img src = '../files/hoteles/".$reg->imagen."' height='50px' width='50px' style='border-radius: 40%;'>",
				"8"=>($reg->condicion)? '<span class="label bg-green">Activo</span>' : '<span class="label bg-red">Inactivo</span>'
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

	default:
		break;
}


?>