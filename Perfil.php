<?php
include("assets/php/Usuario.php");
include("assets/php/Subasta.php");
include("assets/php/Funciones.php");
session_start();

if(isset($_POST['borrar'])) {Subasta::sBorrar($_POST['sid']);}
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

    <div class="main">
        <table>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Precio Salida</th>
                <th>Precio Actual</th>
                <th>Usuario</th>
                <th>¿Caducada</th>
            </tr>
            <?php Subasta::mostrarPropias($_SESSION['uid']); ?>
        </table>
    </div>
    
    
    
    
</body>
</html>