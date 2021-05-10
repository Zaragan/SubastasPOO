<?php
include("assets/php/Usuario.php");
include("assets/php/Subasta.php");
session_start();

//  MENSAJES DE ERROR
$log_error = "";
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_formatoEmail')){$log_error = "El formato del email es erroneo.";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_enUso')){$log_error = "Su usuario ya está en uso.";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='error_datosMal')){$log_error = "Su usuario o contraseña son incorrectos";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='gracias')){$log_error = "Gracias por utilizar nuestra web";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='sin_permiso')){$log_error = "No tienes permiso para acceder a esta URL";}
if(isset($_GET['mensaje'])&&($_GET['mensaje']=='inicia')){$log_error = "Registrado. Identificate ahora.";}

if(isset($_POST['crear_usuario'])) {
    Usuario::crearUsuario($_POST['user'],$_POST['password']);
}
if(isset($_POST['identificar'])) {
    Usuario::identificarUsuario($_POST['user'],$_POST['password']);
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
    <div class="header"><?php menu();?></div>
    
    <div class="main">
        <?php if(isset($_SESSION['level'])) { ?>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Precio Salida</th>
                    <th>Precio Actual</th>
                </tr>
                <?php Subasta::mostarTodas() ?>
                <?php main(); ?>
            </table>
        <?php } else {echo '<p style="width: 100%" class="tac">Bienvenido. Esta es la página principal para las subastas, identifícate para poder ver la lista de subastas.</p>';} ?>
    </div>
    
    <p style="width:100%"><?php echo $log_error ?></p>
</body>
</html>