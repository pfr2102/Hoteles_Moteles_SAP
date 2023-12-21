<?php 
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.php");
}elseif($_SESSION['TiposHab']==0 or $_SESSION['TiposHab']!=1){
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
                      <h1 class="box-title">Habitacion <button class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="mostrarform()"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- centro -->
                <div class="panel-body table-responsive " id="listadoregistros">
                    <table id="tbllistado" class="table table-striped table-dark table-bordered table-condensed table-hover">
                      <thead>
                        <th>Opcion</th>
                        <th>Tipo de Habitacion</th>
                        <th>Capacidad.Per.</th>
                        <th>Tarifa por Dia</th>
                        <th>Cantidad del Hot.</th>
                        <th>Estado</th>
                      </thead>
                      <tbody>                            
                      </tbody>
                      <tfoot>
                        <th>Opcion</th>
                        <th>Tipo</th>
                        <th>Capacidad.Per.</th>
                        <th>Tarifa por Dia</th>
                        <th>Cantidad del Hot.</th>
                        <th>Estado</th>
                      </tfoot>
                    </table>
                </div>
                <!------------------------------------------------------------------>
                <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog d-flex" role="document">
              <div class="modal-content align-self-center">
                <div class="modal-header" style="background-color: #3c8dbc;">
                    <h3 class="modal-title" id="exampleModalLabel">Registro Tipo de Habitacion</h3>                
                </div>
                <div class="modal-body">
                    <form name="formulario" id="formulario" method="POST">
                        <div class="form-group">
                          <label>Nombre del Tipo de Habitacion:*</label>                            
                          <input type="hidden" name="idhabitacion" id="idhabitacion">
                          <input type="hidden" name="idhotel" id="idhotel" value="<?php echo $_SESSION['idhotel']?>">
                          <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION['idusuario']?>">
                          <input type="text" class="form-control" name="tipo" id="tipo" maxlength="45" placeholder="Nombre del Tipo Habitacion" required>
                        </div>
                        <!--------------------------------->
                        <div class="form-group">
                          <label>Capacidad de personas:*</label>                            
                          <input type="number" class="form-control" name="personas" id="personas" minlength="1" required>
                        </div>
                        <!--------------------------------->
                        <div class="form-group">
                          <label>Tarifa por dia:*</label>                            
                          <input type="number" class="form-control" name="tarifa_dia" id="tarifa_dia" min="1" required>
                        </div>
                        <!--------------------------------->
                        <div class="form-group">
                          <label>Cantidad de habitaciones en el hotel:</label>                            
                          <input type="number" class="form-control" name="cantidad" id="cantidad" minlength="1" required>
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
<script type="text/javascript" src="scripts/habitacion.js"></script>
 <?php 
  }//fin del else que esta hasta arriba
  ob_end_flush();//LIBERAMOS EL ESPACIO EN EL BUFFER
?>