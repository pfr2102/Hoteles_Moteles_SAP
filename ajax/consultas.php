<?php 
require_once "../modelos/Consultas.php";

$consulta=new Consultas();


switch ($_GET["op"]){

	case 'registrosfecha':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idhotel=$_REQUEST["idhotel"];

		$rspta=$consulta->RegistrosHuespedfecha($fecha_inicio,$fecha_fin,$idhotel);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha_ingreso,
 				"1"=>$reg->fecha_salida,
 				"2"=>$reg->dias_reserva,
 				"3"=>$reg->fecha_registro,
 				"4"=>$reg->tipo_habitacion,
 				"5"=>$reg->costo_reserva,
 				"6"=>$reg->motivo,
 				"7"=>$reg->estado,
 				"8"=>'<span class="label bg-purple">'.$reg->usuario.'</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	///CASOS PARA CONSULTAS ESTADISTICAS DE TODA LA ASOCIACION///

	case 'tarifaOcupacionAsoc':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

		$rspta=$consulta->tarifaOcupacionAsoc($fecha_inicio,$fecha_fin);
		echo json_encode($rspta);
	break;

	case 'visitaEstadosAsoc':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

		$consulta2 = new Consultas();
	    //Datos para mostrar el grafico de barras de las compras
	    $visitas = $consulta2->visitaEstadosAsoc($fecha_inicio, $fecha_fin);
	    $estados = '';
	    $totalEst = '';
	    if($visitas){
		    while($regEst = $visitas->fetch_object()){
		        $estados = $estados.'"'.$regEst->estado.'"|';
		        $totalEst = $totalEst.$regEst->cantidad.'|';
		    }
		}
	    //Quitar la ultima coma de las 2 cadenas
	    $estados = substr($estados, 0,-1);
	    $totalEst = substr($totalEst,0,-1);

	    // Crear el array asociativo
		$data = array(
			"estados" => $estados,
			"totalEst" => $totalEst
		);
		// Convertir el array en objeto JSON
		echo json_encode($data);
	break;

	case 'motivoAsoc':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

		$consulta2 = new Consultas();
	    //Datos para mostrar el grafico de barras de las compras
	    $motivos = $consulta2->motivoAsoc($fecha_inicio, $fecha_fin);
	    $motivoNOM = '';
	    $total = '';
	    if($motivos){
		    while($regMot = $motivos->fetch_object()){
		        $motivoNOM = $motivoNOM.'"'.$regMot->motivo.'"|';
		        $total = $total.$regMot->total.'|';
		    }
		}
	    //Quitar la ultima coma de las 2 cadenas
	    $motivoNOM = substr($motivoNOM, 0,-1);
	    $total = substr($total,0,-1);

	    // Crear el array asociativo
		$data = array(
			"motivo" => $motivoNOM,
			"total" => $total
		);
		// Convertir el array en objeto JSON
		echo json_encode($data);
	break;


	///CASOS PARA CONSULTAS ESTADISTICAS POR HOTEL///

	case 'tarifaOcupacionHot':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idhotal=$_REQUEST["idhotel"];

		$rspta=$consulta->tarifaOcupacionHot($fecha_inicio,$fecha_fin,$idhotal);
		echo json_encode($rspta);
	break;

	case 'visitaEstadosHot':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idhotel=$_REQUEST["idhotel"];

		$consulta2 = new Consultas();
	    //Datos para mostrar el grafico de barras de las compras
	    $visitas = $consulta2->visitaEstadosHot($fecha_inicio, $fecha_fin,$idhotel);
	    $estados = '';
	    $totalEst = '';
	    if($visitas){
		    while($regEst = $visitas->fetch_object()){
		        $estados = $estados.'"'.$regEst->estado.'"|';
		        $totalEst = $totalEst.$regEst->cantidad.'|';
		    }
		}
	    //Quitar la ultima coma de las 2 cadenas
	    $estados = substr($estados, 0,-1);
	    $totalEst = substr($totalEst,0,-1);

	    // Crear el array asociativo
		$data = array(
			"estados" => $estados,
			"totalEst" => $totalEst
		);
		// Convertir el array en objeto JSON
		echo json_encode($data);
	break;

	case 'motivoHot':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idhotel=$_REQUEST["idhotel"];

		$consulta2 = new Consultas();
	    //Datos para mostrar el grafico de barras de las compras
	    $motivos = $consulta2->motivoHot($fecha_inicio, $fecha_fin, $idhotel);
	    $motivoNOM = '';
	    $total = '';
	    if($motivos){
		    while($regMot = $motivos->fetch_object()){
		        $motivoNOM = $motivoNOM.'"'.$regMot->motivo.'"|';
		        $total = $total.$regMot->total.'|';
		    }
		}
	    //Quitar la ultima coma de las 2 cadenas
	    $motivoNOM = substr($motivoNOM, 0,-1);
	    $total = substr($total,0,-1);

	    // Crear el array asociativo
		$data = array(
			"motivo" => $motivoNOM,
			"total" => $total
		);
		// Convertir el array en objeto JSON
		echo json_encode($data);
	break;



	///CASOS PARA CONSULTAS ESTADISTICAS POR ESTRELLAS///

	case 'tarifaOcupacionEst':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$estrellas=$_REQUEST["estrellas"];

		$rspta=$consulta->tarifaOcupacionEst($fecha_inicio,$fecha_fin,$estrellas);
		echo json_encode($rspta);
	break;

	case 'visitaEstadosEst':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$estrellas=$_REQUEST["estrellas"];

		$consulta2 = new Consultas();
	    //Datos para mostrar el grafico de barras de las compras
	    $visitas = $consulta2->visitaEstadosEst($fecha_inicio, $fecha_fin,$estrellas);
	    $estados = '';
	    $totalEst = '';
	    if($visitas){
		    while($regEst = $visitas->fetch_object()){
		        $estados = $estados.'"'.$regEst->estado.'"|';
		        $totalEst = $totalEst.$regEst->cantidad.'|';
		    }
		}
	    //Quitar la ultima coma de las 2 cadenas
	    $estados = substr($estados, 0,-1);
	    $totalEst = substr($totalEst,0,-1);

	    // Crear el array asociativo
		$data = array(
			"estados" => $estados,
			"totalEst" => $totalEst
		);
		// Convertir el array en objeto JSON
		echo json_encode($data);
	break;

	case 'motivoEst':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$estrellas=$_REQUEST["estrellas"];

		$consulta2 = new Consultas();
	    //Datos para mostrar el grafico de barras de las compras
	    $motivos = $consulta2->motivoEst($fecha_inicio, $fecha_fin, $estrellas);
	    $motivoNOM = '';
	    $total = '';
	    if($motivos){
		    while($regMot = $motivos->fetch_object()){
		        $motivoNOM = $motivoNOM.'"'.$regMot->motivo.'"|';
		        $total = $total.$regMot->total.'|';
		    }
		}
	    //Quitar la ultima coma de las 2 cadenas
	    $motivoNOM = substr($motivoNOM, 0,-1);
	    $total = substr($total,0,-1);

	    // Crear el array asociativo
		$data = array(
			"motivo" => $motivoNOM,
			"total" => $total
		);
		// Convertir el array en objeto JSON
		echo json_encode($data);
	break;


}
?>