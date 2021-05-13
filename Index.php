<?php
include("assets/php/Usuario.php");
include("assets/php/Subasta.php");
include("assets/php/Funciones.php");
session_start();

//  MENSAJES DE ERROR
$log_error = "";
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_formatoEmail')){$log_error = "<br><br>El formato del email es erroneo.";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_enUso')){$log_error = "<br><br>Su usuario ya está en uso.";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_datosMal')){$log_error = "<br><br>Su usuario o contraseña son incorrectos";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_minima_puja')){$log_error = "<br><br>Su puja no se realizó. Tiene que pujar un 15% más que el precio actual.";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_pobre')){$log_error = "<br><br>No tienes moneda suficiente para esa puja.";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='sin_permiso')){$log_error = "<br><br>No tienes permiso para acceder a esta URL";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='inicia')){$log_error = "<br><br>Registrado. Identificate ahora.";}

if(isset($_POST['crear_usuario'])) {
    Usuario::crearUsuario($_POST['user'],$_POST['password']);
}
if(isset($_POST['identificar'])) {
    Usuario::identificarUsuario($_POST['user'],$_POST['password']);
}
if(isset($_POST['enviar'])) {
    Subasta::crearSubasta($_POST['sNombre'],$_POST['sPrecio'],$_POST['tiempo']);
}
if(isset($_POST['pujar'])) {
    Subasta::pujar($_POST['sid'], $_POST['puja']);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
	<link rel="stylesheet" href="assets/css/main.css">
    <title>Subastas</title>
</head>
<body>
    <!-- // Menu superior -->
    <div class="header"><?php Funciones::menu();?></div>
    <!-- // Menu creacion de subastas -->
    <p style="width:100%; text-align:center; color:red"><?php echo $log_error;  ?></p>
    <?php if(isset($_GET['page'])&&($_GET['page']=='new_subasta')){ ?>
        <div class="main">
            <p>Creación de subasta</p> <br />
            <form method="post">
                <label for="sNombre">Nombre: </label>
                <input type="text" name="sNombre" id="sPrecio">
                <label for="sPrecio">Precio: </label>
                <input name="sPrecio" id="sPrecio">
                <select name="tiempo" id="timepo">
                    <option value="1day">1 día</option>
                    <option value="1week">1 mes</option>
                    <option value="1month">1 año</option>
                </select>
                <input type="submit" value="Enviar" name="enviar" class="btn">
            </form>
        </div>
    <?php } ?>
    <!-- // Muestra la tabla de subastas -->
    <div class="main">
    <?php if(isset($_SESSION['level'])) { ?>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Precio Salida</th>
                    <th>Precio Actual</th>
                    <th>Puja</th>
                </tr>
                <?php Subasta::mostarTodas() ?>
            </table>
        <?php } else {echo '<p style="width: 100%" class="tac">Bienvenido. Esta es la página principal para las subastas, identifícate para poder ver la lista de subastas.</p>';} ?>
    </div>
    
    
    
    
</body>
</html>