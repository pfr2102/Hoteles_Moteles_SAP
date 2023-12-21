<?php 
  if(strlen(session_id()) < 1)
    session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>H/M | ASOCIACION</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">
    <link rel="stylesheet" href="../public/css/personal.css">
    <!--FONT AWSOME-->
     <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />--> 
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/responsive.dataTables.min.css">
    <!---->
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

  </head>
  <body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">
      <header class="main-header">        
        <!-- Logo -->
        <a href="" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H/M</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Hoteles/Moteles</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $_SESSION['rol']?> 
                      <small>Plataforma de gestión de datos estadísticos de la Asociación de H/M</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar Sesion</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>   
            <!------------------------------------------------------->   
            <?php if($_SESSION['General']==1){
              echo '
                <li>
                  <a href="noacceso.php">
                     <i class="fa fa-tasks"></i> <span> General</span>
                  </a>
                </li>  
              ';
            }?>                               
            <!------------------------------------------------------->
            <?php if($_SESSION['Hoteles']==1){
              echo '
                <li class="treeview">
                  <a href="#">
                    <ion-icon name="business-outline"></ion-icon>
                    <span>Hoteles</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="hotel.php"><i class="fa fa-circle-o"></i> Registrar Hotel</a></li>
                  </ul>
                </li>
              ';
            }?> 
                
            <!-------------------------------------------------------> 
            <?php if($_SESSION['TiposHab']==1){
              echo '
                <li>
                  <a href="habitacion.php">
                    <ion-icon name="bed-outline"></ion-icon> <span> Tipos Habitaciones </span>
                  </a>
                </li>
              ';
            }?>                                
            <!------------------------------------------------------->
            <?php if($_SESSION['AccesoA']==1 AND $_SESSION['rol']!='PERSONALIZADO'){
              echo '
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-folder"></i> <span>Acceso Asociacion</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="usuarioA.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                    <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                    
                  </ul>
                </li> 
              ';
            }?> 
            <!------------------------------------------------------->  
            <?php if($_SESSION['rol']=='PERSONALIZADO'){
              echo '
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-folder"></i> <span>Acceso Admin</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="usuario.php"><i class="fa fa-circle-o"></i>Usuarios</a></li>                
                  </ul>
                </li>
              ';
            }?>                                    
            <!------------------------------------------------------->
            <?php if($_SESSION['AccesoH']==1){
              echo '
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-folder"></i> <span>Acceso Hotel</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="usuarioH.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                  </ul>
                </li> 
              ';
            }?>                                                 
            <!------------------------------------------------------->
            <?php if($_SESSION['Captura']==1){
              echo '
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-th"></i>
                    <span>Captura</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="huesped.php"><i class="fa fa-circle-o"></i> Captura Huespedes</a></li>
                    <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Info</a></li>
                  </ul>
                </li> 
              ';
            }?> 
                                     
            <!------------------------------------------------------->
            <?php if($_SESSION['DatosA']==1){
              echo '
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-bar-chart"></i> <span>Datos Asociacion</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="generalAsoc.php"><i class="fa fa-circle-o"></i> General</a></li>                   
                    <li><a href="generalAsocEst.php"><i class="fa fa-circle-o"></i> Por estrellas</a></li>                   
                  </ul>
                </li>
              ';
            }?>                 

            <!------------------------------------------------------->
            <?php if($_SESSION['DatosH']==1){
              echo '
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-bar-chart"></i> <span>Datos Hotel</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="generalHot.php"><i class="fa fa-circle-o"></i> Datos de mi Hotel</a></li>  
                    <li><a href="registrosHuespedFecha.php"><i class="fa fa-circle-o"></i> Registros Huespedes</a></li>
                  </ul>
                </li>
              ';
            }?>                 
             <!------------------------------------------------------->
                                                                                                                                                                   
            <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="cartas.html" target="_bank">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>