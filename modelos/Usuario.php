<?php 

require "../config/Conexion.php";

class Usuario {
    
    public function __construct() {
        
    }

    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $rol, $imagen, $idhotel, $permisos) {
        $sql = "INSERT INTO usuario(nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, rol, imagen, idhotel, condicion) VALUES('$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email', '$cargo', '$login', '$clave','$rol', '$imagen', '$idhotel', '1')";

        $idusuarionew = ejecutarConsulta_retornaID($sql);

        $sw = true;
        for($num_elementos=0; $num_elementos  < count($permisos) ; $num_elementos++) {
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew','$permisos[$num_elementos]')"; 
            ejecutarConsultaAbierta($sql_detalle) or $sw=false;
        }
        return $sw;
    }

    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $rol, $imagen, $permisos) {
        $sql = "UPDATE usuario SET nombre = '$nombre', tipo_documento = '$tipo_documento', num_documento = '$num_documento', direccion = '$direccion', telefono = '$telefono', email = '$email', cargo = '$cargo', login = '$login', clave = '$clave',rol = '$rol' ,imagen = '$imagen' WHERE idusuario = '$idusuario'";
        ejecutarConsultaAbierta($sql);
        //Eliminar todos lso permisos asignados para volverlos a registrar
        $sqldel = "DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
        ejecutarConsultaAbierta($sqldel);
        //volver a insertar los nuevos permisos        
        $sw = true;
        for($num_elementos=0; $num_elementos  < count($permisos) ; $num_elementos++) { 
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario','$permisos[$num_elementos]')"; 
            ejecutarConsultaAbierta($sql_detalle) or $sw=false;
        }
        cerrarConexion();
        return $sw;
    }

    public function desactivar($idusuario) {
        $sql = "UPDATE usuario SET condicion = '0' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }

    public function activar($idusuario) {
        $sql = "UPDATE usuario SET condicion = '1' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idusuario) {
        $sql = "SELECT * FROM usuario WHERE idusuario = '$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

   
    //Es un listar en donde ya se puede ver el nombre del hotel al cual esta asignado cada usuario
    public function listar(){
        $sql = "SELECT u.idusuario ,u.nombre, u.tipo_documento, u.telefono, u.email, u.login, h.nombre as nombreH, u.rol, u.imagen, u.condicion FROM usuario u
            INNER JOIN hotel h ON u.idhotel = h.idhotel";
        return ejecutarConsulta($sql);
    }  
    //Es un listar en donde no muestra los usuario de rol personalizado
    public function listar2(){
        $sql = "SELECT u.idusuario ,u.nombre, u.tipo_documento, u.telefono, u.email, u.login, h.nombre as nombreH, u.rol, u.imagen, u.condicion FROM usuario u
            INNER JOIN hotel h ON u.idhotel = h.idhotel 
            WHERE rol<>'PERSONALIZADO'";
        return ejecutarConsulta($sql);
    } 

    public function listarCapturstas($idhotel) {
        $sql = "SELECT * FROM usuario WHERE rol = 'CAPTURISTA' and idhotel='$idhotel'";
        return ejecutarConsulta($sql);
    }

    //Implementar un metodo para listar los permisos marcados
    public function listarmarcados($idusuario){
        $sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";
        return ejecutarConsultaAbierta($sql);
    }

    //Funcion para verificar el acceso al sistema
    public function verificar($login,$clave){
        $sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login,rol,idhotel FROM usuario WHERE login = '$login' AND clave='$clave' AND condicion='1'";
        return ejecutarConsultaAbierta($sql);
    }

}
?>
