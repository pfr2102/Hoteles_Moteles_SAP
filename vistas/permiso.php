<?php 
//Activamos el almacenamiento en el buffer

ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.php");
}elseif($_SESSION['AccesoA']==0 or $_SESSION['AccesoA']!=1){
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
                          <h1 class="box-title">Permiso <button class="btn btn-success"  id="btnagregar"  onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive " id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-dark table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nombre</th>
                          </tfoot>
                        </table>
                    </div> 
                    <!----------------------------------------------------------------------------->
                    <div class="panel-body table-responsive ">
                      <h3>Roles</h3>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                          <div class="small-box bg-yellow">
                            <!-------------------------->
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>Director</strong>
                              </h4>
                              <p>--Hoteles</p>
                              <p>--General</p>
                              <p>--Datos Asociacion</p>
                              <p>--Acceso Asociacion</p>
                            </div>
                            <!-------------------------->
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <!-------------------------->
                            <a href="usuarioA.php" class="small-box-footer">Administrar <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      <!------------------------------------------------------->
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                          <div class="small-box bg-green">
                            <!-------------------------->
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>Gerente</strong>
                              </h4>
                              <p>--Tipos Habitaciones</p>
                              <p>--General</p>
                              <p>--Datos Hotel</p>
                              <p>--Acceso Hotel</p>
                            </div>
                            <!-------------------------->
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <!-------------------------->
                            <a href="usuarioA.php" class="small-box-footer">Administrar <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      <!------------------------------------------------------->
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                          <div class="small-box bg-gray">
                            <!-------------------------->
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>Capturista</strong>
                              </h4>
                              <p>--Captura</p>
                              <p>################</p>
                              <p>################</p>
                              <p>################</p>
                            </div>
                            <!-------------------------->
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <!-------------------------->
                            <a href="usuarioA.php" class="small-box-footer">Administrar <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      <!------------------------------------------------------->
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
 <script type="text/javascript" src="scripts/permiso.js"></script>
 <?php 
  }//fin del else que esta hasta arriba
  ob_end_flush();//LIBERAMOS EL ESPACIO EN EL BUFFER
?>