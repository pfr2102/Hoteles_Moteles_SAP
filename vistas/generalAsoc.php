<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.php");
}
else
{
require 'header.php';

if ($_SESSION['DatosA']==1)
{
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
                          <h1 class="box-title">Datos Generales de la Asociacion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                      
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                          <input type="hidden" name="idhotel" id="idhotel" value="<?php echo $_SESSION["idhotel"]?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                        </div>     
                                 
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-aqua">
                            <!-------------------------->
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong id="ocupacion"> </strong>
                              </h4>
                              <p>% Ocupacion</p>
                            </div>
                            <!-------------------------->
                            <div class="icon"  style="/*color: white;">
                              <ion-icon name="calendar"></ion-icon>
                            </div>
                            <!-------------------------->
                            <a href="#" class="small-box-footer">Porcentajes de ocupacion<i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      <!------------------------------------------------------------------>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-green">
                            <!-------------------------->
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong id="tarifa"> </strong>
                              </h4>
                              <p>Tarifa Promedio</p>
                            </div>
                            <!-------------------------->
                            <div class="icon">
                              <ion-icon name="cash"></ion-icon>
                            </div>
                            <!-------------------------->
                            <a href="#" class="small-box-footer">Tarifa Promedio <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                    </div><!--fin 1er panel body-->
                     <!--------------------------------------------------------------------------------------------------->
                    <div class="panel-body">

                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                         <div class="box box-primary">
                          <div class="box-header with-border">
                            Visitas de otro estado
                          </div>
                          <div class="box-body">
                            <canvas id="visitas" width="400" height="300"></canvas>
                          </div>
                         </div>
                       </div>
                       <!------------------------------------------>
                       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                         <div class="box box-primary">
                          <div class="box-header with-border">
                            Visitas por motivo
                          </div>
                          <div class="box-body">
                            <canvas id="motivos" width="400" height="300"></canvas>
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
}
else{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="../public/js/chart.min.js"></script>
<script type="text/javascript" src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript" src="scripts/generalAsoc.js"></script>
<?php 
}
ob_end_flush();
?>