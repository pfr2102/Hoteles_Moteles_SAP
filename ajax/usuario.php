<?php 
session_start();//iniciamos sesion para los login
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]) : "";
$idhotel = isset($_POST["idhotel"])? limpiarCadena($_POST["idhotel"]) : "";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"])? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"])? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"])? limpiarCadena($_POST["clave"]) : "";
$rol = isset($_POST["rol"])? limpiarCadena($_POST["rol"]) : "";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/".$imagen);
			}
		}

		//Hash SHA256 en la contraseña para encriptar
		$clavehash = hash("SHA256", $clave);

		if (empty($idusuario)){
		    $rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $rol, $imagen, $idhotel,
		    	$_POST['permiso']);
		    echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
		}else{
			$rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $rol, $imagen , $_POST['permiso']);
			echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta = $usuario->desactivar($idusuario);
		echo $rspta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
	break;

	case 'activar':
		$rspta = $usuario->activar($idusuario);
		echo $rspta ? "Usuario activado" : "Usuario no se pudo activar";
	break;

	case 'mostrar':
		$rspta = $usuario->mostrar($idusuario);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);		
	break;


	case 'listar':
		$rspta = $usuario->listar();
		//Vamos a declarar un array
		$data = array();
		while($reg = $rspta->fetch_object()){
			$data[] = array(
				"0"=>($reg->condicion)? 
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')" ><ion-icon name="trash"></ion-icon></button>'
				:
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')" ><i class="fa fa-check"></i></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->tipo_documento,
				"3"=>$reg->telefono,
				"4"=>$reg->email,
				"5"=>$reg->login,
				"6"=>$reg->rol,
				"7"=>$reg->nombreH,
				"8"=>"<img src = '../files/usuarios/".$reg->imagen."' height='50px' width='65px' style='border-radius: 30%;'>",
				"9"=>($reg->condicion)? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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

	    //este no lista a los de rol personalizados 
	case 'listarFiltro':
		$rspta = $usuario->listar2();
		//Vamos a declarar un array
		$data = array();
		while($reg = $rspta->fetch_object()){
			$data[] = array(
				"0"=>($reg->condicion)? 
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')" ><ion-icon name="trash"></ion-icon></button>'
				:
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')" ><i class="fa fa-check"></i></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->tipo_documento,
				"3"=>$reg->telefono,
				"4"=>$reg->email,
				"5"=>$reg->login,
				"6"=>$reg->rol,
				"7"=>$reg->nombreH,
				"8"=>"<img src = '../files/usuarios/".$reg->imagen."' height='50px' width='65px' style='border-radius: 30%;'>",
				"9"=>($reg->condicion)? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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


	case 'listarCapturistas':
		$hotel = $_GET['hotel'];
		$rspta = $usuario->listarCapturstas($hotel);
		//Vamos a declarar un array
		$data = array();
		while($reg = $rspta->fetch_object()){
			$data[] = array(
				"0"=>($reg->condicion)? 
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')" ><ion-icon name="trash"></ion-icon></button>'
				:
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><ion-icon name="create"></ion-icon></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')" ><i class="fa fa-check"></i></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->tipo_documento,
				"3"=>$reg->num_documento,
				"4"=>$reg->telefono,
				"5"=>$reg->email,
				"6"=>$reg->login,
				"7"=>$reg->rol,
				"8"=>"<img src = '../files/usuarios/".$reg->imagen."' height='50px' width='65px' style='border-radius: 30%;'>",
				"9"=>($reg->condicion)? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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

	case'selectHotel':
		require_once "../modelos/Hotel.php";
		$hotel = new Hotel();
		$rspta = $hotel->select();

		while($reg = $rspta->fetch_object()){
			echo '<option value ='.$reg->idhotel.'>'.$reg->nombre.'</option>';
		}
	break;

	case 'permisos':
		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores = array();
		//Almacenar los permisos asignados al usuario en el array
		while($per = $marcados->fetch_object()){
			array_push($valores, $per->idpermiso);
		}
		//Obtener todos los permisos de la tabla permisos	
		require_once "../modelos/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();	
		//Mostrar todos los permisos en la vista
		while($reg = $rspta->fetch_object()){
			$sw=in_array($reg->idpermiso, $valores)?'checked':'';
			echo '<li> <input type="checkbox" '.$sw.' name = "permiso[]" value="'.$reg->idpermiso.'" id="check'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
		}
	break;

	case 'verificar':
		$logina=$_POST['logina'];
	    $clavea=$_POST['clavea'];
	    //Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clavea);
		$rspta=$usuario->verificar($logina, $clavehash);
		$fetch=$rspta->fetch_object();

		if (isset($fetch)){
	        //Declaramos las variables de sesión
	        $_SESSION['idusuario']=$fetch->idusuario;
	        $_SESSION['nombre']=$fetch->nombre;
	        $_SESSION['imagen']=$fetch->imagen;
	        $_SESSION['login']=$fetch->login;
	        $_SESSION['rol']=$fetch->rol;
	        $_SESSION['idhotel']=$fetch->idhotel;

	        //Obtenemos los permisos del usuario
	    	$marcados = $usuario->listarmarcados($fetch->idusuario);

	    	//Declaramos el array para almacenar todos los permisos marcados
			$valores=array();

			//Almacenamos los permisos marcados en el array
			while ($per = $marcados->fetch_object()){
					array_push($valores, $per->idpermiso);
			}
			//Determinamos los accesos del usuario
			in_array(1,$valores)?$_SESSION['General']=1:$_SESSION['General']=0;
			in_array(2,$valores)?$_SESSION['Hoteles']=1:$_SESSION['Hoteles']=0;
			in_array(3,$valores)?$_SESSION['TiposHab']=1:$_SESSION['TiposHab']=0;
			in_array(4,$valores)?$_SESSION['AccesoA']=1:$_SESSION['AccesoA']=0;
			in_array(5,$valores)?$_SESSION['AccesoH']=1:$_SESSION['AccesoH']=0;
			in_array(6,$valores)?$_SESSION['Captura']=1:$_SESSION['Captura']=0;
			in_array(7,$valores)?$_SESSION['DatosA']=1:$_SESSION['DatosA']=0;
			in_array(8,$valores)?$_SESSION['DatosH']=1:$_SESSION['DatosH']=0;
	    }
	    echo json_encode($fetch);
	break;

	case 'salir':
		//limpiar las variables de sesion
		session_unset();
		//Destruimos la sesion
		session_destroy();
		header("location:../index.php");
	break;

	default;
    	break;
}

?>