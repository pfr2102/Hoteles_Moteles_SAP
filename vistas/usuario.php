<?php 
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.php");
}elseif($_SESSION['rol']!="PERSONALIZADO"){
  require 'noacceso.php';
}
else{//LA CERRADURA DE ESTE ELSE ESTA ESTA ABAJO


  require 'header.php';
?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Usuario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive " id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-dark table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Rol</th>
                            <th>Hotel</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Rol</th>
                            <th>Hotel</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <!------------------------------------------------------------------>
                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nombre:*</label>                            
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Rol:*</label>    
                            <select class ="form-control selectpicker" name = "rol" id = "rol" required>
                              <option value="PERSONALIZADO">PERSONALIZADO</option>                              
                              <option value="CAPTURISTA">CAPTURISTA</option>
                              <option value="GERENTE">GERENTE</option>
                              <option value="DIRECTOR">DIRECTOR</option>
                            </select>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Hotel:*</label>  
                            <div id="idhotelc">
                              <select id="idhotel" name="idhotel" class="form-control selectpicker" data-live-search="true" required>
                              </select>
                            </div>  
                            <div id="idhotelc2">
                              <select  class="form-control" data-live-search="true" disabled="true">
                                <option selected>YA NO PUDES SELECCIONAR</option>
                              </select>
                            </div>                            
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento:*</label>    
                            <select class ="form-control selectpicker" name = "tipo_documento" id = "tipo_documento" required>
                              <option value="RFC">RFC</option>
                              <option value="CURP">CURP</option>
                              <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>                          
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Numero:*</label>                            
                            <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento" required>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Direccion:*</label>                            
                            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" maxlength="70">
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Telefono:</label>                            
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="telefono" maxlength="20">
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:*</label>                            
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" maxlength="50">
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cargo:</label>                            
                            <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Cargo" maxlength="20">
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Login:</label>                            
                            <input type="text" class="form-control" name="login" id="login" placeholder="Login" maxlength="20" required>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Clave:</label>                            
                            <input type="password" class="form-control" name="clave" id="clave" placeholder="Clave" maxlength="64" required>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Permisos:</label>
                            <ul style="list-style: none;" id = "permisos">
                              
                            </ul>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>                            
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id = "imagenactual" value="user2.png"> <br>
                            <img src="" width="150px" height="120px" id = "imagenmuestra">
                          </div>
                          <!--------------------------------->

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button> 
                            <button class="btn btn-danger" type="button" onclick="mostrarform(false)"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>                                             
                          </div>

                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

 <?php 
  require 'footer.php';
 ?>   
 <script type="text/javascript" src="scripts/usuario.js"></script>
  <?php 
  }//fin del else que esta hasta arriba
  ob_end_flush();//LIBERAMOS EL ESPACIO EN EL BUFFER
?>