<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500&family=Pacifico&family=Patua+One&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
    <form method="post" id="frmAcceso">
        <h1 class="titulo">Inicio de Sesión</h1>
        <label for="">            
            <i class="fa-solid fa-user"></i>
            <input type="text" id="logina" name="logina"  placeholder="Nombre de Usuario">
        </label>
        <label for="">            
            <i class="fa-solid fa-lock"></i>
            <input type="password"  id="clavea" name="clavea" placeholder="Password">
        </label>
        <a href="https://www.facebook.com/profile.php?id=100087861972680" class="link" target="_bank">Comunícate con el admin. si tienes un problema</a>

        <button type="submit" class="boton">Ingresar</button>
        <!--<a href="index.php" class="boton">Ingresar</a>-->
    </form>

   <!-- jQuery 2.1.4 -->
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../public/js/bootstrap.min.js"></script>
    <!--scripts para alertas dinamicos-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="scripts/login.js"></script>
</body>
</html>