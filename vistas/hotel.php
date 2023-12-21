<?php 
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.php");
}elseif($_SESSION['Hoteles']==0 or $_SESSION['Hoteles']!=1){
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
                          <h1 class="box-title">Hotel <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive " id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-dark table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opcion</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Tot.Habitaciones</th>
                            <th>Telefono</th>
                            <th>Estrellas</th>
                            <th>Estado Nacional</th>
                            <th>Imagen</th>                                                        
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opcion</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Tot.Habitaciones</th>
                            <th>Telefono</th>
                            <th>Estrellas</th>
                            <th>Estado Nacional</th>
                            <th>Imagen</th>                            
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <!------------------------------------------------------------------>
                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nombre:*</label>                            
                            <input type="hidden" name="idhotel" id="idhotel">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" required>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Categoria:*</label>         
                            <select id="categoria" name="categoria" class="form-control selectpicker" data-live-search="true" required>
                                <option value="">Selecciona una categoría</option>
                                <option value="Turismo">Turismo</option>
                                <option value="Negocios">Negocios</option>
                                <option value="Todo Incluido">Todo Incluido</option>
                                <option value="Boutique">Boutique</option>
                                <option value="Resort">Resort</option>
                                <option value="Motel">Motel</option>
                            </select>
                          </div>                          
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Estado:*</label>         
                            <select id="idestado" name="idestado" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Total de habitaciones del Hotel:*</label>                            
                            <input type="number" class="form-control" name="tot_habitaciones" id="tot_habitaciones" required>
                          </div>
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Direccion:*</label>                            
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="100" placeholder="Direccion" required>
                          </div>
                          <!--------------------------------->    
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Telefono:</label>                            
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="25" placeholder="Telefono">
                          </div>
                          <!--------------------------------->    
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>                            
                            <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>
                          <!--------------------------------->                        
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Estrellas:*</label>                            
                            <input type="number" class="form-control" name="estrellas" id="estrellas" max="5" min="1" required>
                          </div>
                          
                          <!--------------------------------->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Logotipo:</label>                            
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
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
 <script type="text/javascript" src="scripts/hotel.js"></script>
 <!--Libreria para poder hacer codigos de barra-->
 <script src="../public/js/JsBarcode.all.min.js"></script>
  <!--Libreria para podera-->
 <script src="../public/js/jquery.PrintArea.js"></script>
<?php 
  }//fin del else que esta hasta arriba
  ob_end_flush();//LIBERAMOS EL ESPACIO EN EL BUFFER
?>