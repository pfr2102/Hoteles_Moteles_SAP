<?php 
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.php");
}elseif($_SESSION['Captura']==0 or $_SESSION['Captura']!=1){
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
                      <h1 class="box-title">Agregar Huespedes <button class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="mostrarform()"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- centro -->
                <div class="panel-body table-responsive " id="listadoregistros">
                    <table id="tbllistado" class="table table-striped table-dark table-bordered table-condensed table-hover">
                      <thead>
                        <th>Opcion</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Salida</th>
                        <th>Dias</th>
                        <th>Tipo Habitacion</th>
                        <th>Costo Reserva</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                      </thead>
                      <tbody>                            
                      </tbody>
                      <tfoot>
                        <th>Opcion</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Salida</th>
                        <th>Dias</th>
                        <th>Tipo Habitacion</th>
                        <th>Costo Reserva</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Usuario</th>                        
                      </tfoot>
                    </table>
                </div>
                <!------------------------------------------------------------------>
                <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog d-flex" role="document">
              <div class="modal-content align-self-center">
                <div class="modal-header" style="background-color: #3c8dbc;">
                    <h3 class="modal-title" id="exampleModalLabel">Registrar Datos Huesped</h3>                
                </div>
                <div class="modal-body">
                    <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Ingreso:*</label>               
                          <input type="hidden" name="idregistro_huesped" id="idregistro_huesped">
                          <input type="hidden" name="idhotel" id="idhotel" value="<?php echo $_SESSION['idhotel']?>">
                          <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION['idusuario']?>">
                          <input type="hidden" class="form-control" name="costo_reserva" id="costo_reserva" value="1">
                          <input type="DATE" class="form-control" name="fecha_ingreso" id="fecha_ingreso" required>
                        </div>
                        <!--------------------------------->
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Salida:*</label>                            
                          <input type="DATE" class="form-control" name="fecha_salida" id="fecha_salida" required> 
                        </div>
                        <!--------------------------------->
                        <!--<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Costo Total Reserva:*</label>                            
                          <input type="number" class="form-control" name="costo_reserva" id="costo_reserva" minlength="0.05" required>
                        </div> -->
                        <!--------------------------------->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Motivo:*</label>  
                          <select class ="form-control selectpicker" name = "motivo" id = "motivo" required>
                              <option value="TRABAJO">POR TRABAJO</option>                              
                              <option value="PLACER">POR PLACER</option>
                            </select>
                        </div>
                        <!--------------------------------->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Estado de Origen:*</label>  
                          <select id="idestado" name="idestado" class="form-control selectpicker" data-live-search="true" required>
                          </select>
                        </div>
                        <!--------------------------------->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Tipo de Habitacion:*</label>  
                          <select id="idhabitacion" name="idhabitacion" class="form-control selectpicker" data-live-search="true" required>
                          </select>
                        </div>
                              
                        <!--------------------------------->
                        <div class="form-group">
                          <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button> 
                          <button class="btn btn-danger" type="button" onclick="limpiar()" data-dismiss="modal" aria-label="Close" id="cancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>              
                        </div>
                    </form>
                </div>
              </div>
            </div>
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
<script type="text/javascript" src="scripts/huesped.js"></script>
 <?php 
  }//fin del else que esta hasta arriba
  ob_end_flush();//LIBERAMOS EL ESPACIO EN EL BUFFER
?>