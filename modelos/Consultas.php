<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct(){

	}

	public function RegistrosHuespedfecha($fecha_inicio,$fecha_fin,$idhotel){
		$sql="SELECT rh.fecha_ingreso, rh.fecha_salida, rh.dias_reserva, rh.fecha_registro,h.tipo as tipo_habitacion, rh.costo_reserva, rh.motivo,  e.nombre as estado, u.login as usuario FROM registro_huesped rh 
	    INNER JOIN estado e ON e.idestado=rh.idestado
	    INNER JOIN habitacion h ON h.idhabitacion=rh.idhabitacion
	    INNER JOIN usuario u ON u.idusuario=rh.idusuario
		WHERE fecha_ingreso <= '$fecha_fin' AND fecha_salida >= '$fecha_inicio' AND rh.idhotel='$idhotel'";
		return ejecutarConsulta($sql);		
	}

	/////////////////////////////////FUNCIONES ESTADISTICAS ASOCIACION////////////////////////////////////////
	public function tarifaOcupacionAsoc($fecha_inicio, $fecha_fin){
		$sql="call calcular_dias_intersectados_totales('$fecha_inicio','$fecha_fin');";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function visitaEstadosAsoc($fecha_inicio, $fecha_fin){
		$sql = "SELECT E.nombre as 'estado', COUNT(*) as 'cantidad' FROM registro_huesped H
			INNER JOIN estado E ON E.idestado=H.idestado
			WHERE fecha_ingreso <= '".$fecha_fin."' AND fecha_salida >= '".$fecha_inicio."'
			GROUP BY H.idestado";
		return ejecutarConsultaAbierta($sql);

	}

	public function motivoAsoc($fecha_inicio, $fecha_fin){
		$sql = "SELECT motivo ,COUNT(*) as total FROM registro_huesped WHERE fecha_ingreso <= '$fecha_fin' AND fecha_salida >= '$fecha_inicio' GROUP BY motivo";
		return ejecutarConsultaAbierta($sql);
	}



	/////////////////////////////////FUNCIONES ESTADISTICAS POR HOTEL////////////////////////////////////////
	public function tarifaOcupacionHot($fecha_inicio, $fecha_fin, $idhotel){
		$sql="call calcular_dias_intersectados_totales_hotel('$fecha_inicio','$fecha_fin','$idhotel');";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function visitaEstadosHot($fecha_inicio, $fecha_fin, $idhotel){
		$sql = "SELECT E.nombre as 'estado', COUNT(*) as 'cantidad' FROM registro_huesped H
			INNER JOIN estado E ON E.idestado=H.idestado
			WHERE fecha_ingreso <= '".$fecha_fin."' AND fecha_salida >= '".$fecha_inicio."' AND idhotel = '$idhotel'
			GROUP BY H.idestado";
		return ejecutarConsultaAbierta($sql);
	}

	public function motivoHot($fecha_inicio, $fecha_fin, $idhotel){
		$sql = "SELECT motivo ,COUNT(*) as total FROM registro_huesped WHERE fecha_ingreso <= '$fecha_fin' AND fecha_salida >= '$fecha_inicio' AND idhotel = '$idhotel' GROUP BY motivo";
		return ejecutarConsultaAbierta($sql);
	}


	/////////////////////////////////FUNCIONES ESTADISTICAS POR ESTRELLAS////////////////////////////////////////
	public function tarifaOcupacionEst($fecha_inicio, $fecha_fin, $estrellas){
	    $sql = "call calcular_dias_intersectados_totales_estrellas('$fecha_inicio','$fecha_fin','$estrellas');";
	    return ejecutarConsultaSimpleFila($sql);
	}

	public function visitaEstadosEst($fecha_inicio, $fecha_fin, $estrellas){
		$sql = "SELECT E.nombre as 'estado', COUNT(*) as 'cantidad' FROM registro_huesped RH
			INNER JOIN estado E ON E.idestado=RH.idestado
			INNER JOIN hotel H ON H.idhotel=RH.idhotel
			WHERE RH.fecha_ingreso <= '".$fecha_fin."' AND RH.fecha_salida >= '".$fecha_inicio."' AND H.estrellas = '$estrellas'
			GROUP BY RH.idestado";
		return ejecutarConsultaAbierta($sql);
	}
	/*SELECT E.nombre as 'estado', COUNT(*) as 'cantidad' FROM registro_huesped RH
			INNER JOIN estado E ON E.idestado=RH.idestado
			INNER JOIN hotel H ON H.idhotel=RH.idhotel
			WHERE RH.fecha_ingreso <= '2023-06-01' AND RH.fecha_salida >= '2023-01-01' AND H.estrellas = 5
			GROUP BY RH.idestado;*/
			
	public function motivoEst($fecha_inicio, $fecha_fin, $estrellas){
	    $sql = "SELECT motivo, COUNT(*) as total FROM registro_huesped RH
	        INNER JOIN hotel H ON H.idhotel = RH.idhotel
	        WHERE RH.fecha_ingreso <= '$fecha_fin' AND RH.fecha_salida >= '$fecha_inicio' AND H.estrellas = '$estrellas'
	        GROUP BY motivo";
	    return ejecutarConsultaAbierta($sql);
	}

	
}

?>