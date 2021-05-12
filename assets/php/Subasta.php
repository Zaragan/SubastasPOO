<?php

include_once("assets/php/pdo.php");
class Subasta {
    static public function crearSubasta($nombre, $precio, $tiempo) {
        //  Filtramos
        $nombre = strip_tags(addslashes($nombre));
        $precio_salida = strip_tags(addslashes($precio));
        //  Creamos el tiempo
        $unixTime = time();
        switch ($tiempo) {
        case '1day':
            $setTime = 86400;
            $fecha_fin = $unixTime+$setTime;
            break;
        case '1week':
            $setTime = 604800;
            $fecha_fin = $unixTime+$setTime;
            break;
        case '1month':
            $setTime = 18144000;
            $fecha_fin = $unixTime+$setTime;
            break;
        }   
        Database::addQuery("INSERT INTO `subastas`(uid, nombre, fecha, fecha_fin, precio_salida, precio_actual) VALUES ($_SESSION[uid],'$nombre','$unixTime','$fecha_fin','$precio_salida','$precio_salida')", null);
        header('Location: Index.php');
    }

    static public function mostarTodas() {
        $subastas = Database::addQuery("SELECT * FROM subastas", null);
        foreach($subastas as $row) {
            $fecha_creada = date("d / m / Y - G:i", $row['fecha']);
            $fecha_fin = date("d / m / Y - G:i", $row['fecha_fin']);
            echo '<tr>';
                echo '<td>'.$row['nombre'].'</td>';
                echo '<td>'.$fecha_creada.'</td>';
                echo '<td>'.$fecha_fin.'</td>';
                echo '<td>'.$row['precio_salida'].'</td>';
                echo '<td>'.$row['precio_actual'].'</td>';
                echo '<td><form method="post"><input type="text" name="puja"></td>';
                echo '<td><input type="submit" value="pujar" name="'.$row['sid'].'" class="btn"></form></td>';
            echo '</tr>';
        }
    }

    static public function mostrarPorId($sid) {
        $subasta = Database::addQuery("SELECT * FROM subastas WHERE sid=?", $sid);
        foreach($subasta as $row) {
            $fecha_creada = date("d / m / Y - G:i", $row['fecha']);
            $fecha_fin = date("d / m / Y - G:i", $row['fecha_fin']);
            echo '<tr>';
                echo '<td>'.$row['nombre'].'</td>';
                echo '<td>'.$fecha_creada.'</td>';
                echo '<td>'.$fecha_fin.'</td>';
                echo '<td>'.$row['precio_salida'].'</td>';
                echo '<td>'.$row['precio_actual'].'</td>';
            echo '</tr>';
        }
    }

    static public function pujar($sid, $cantidad) {
        $subasta = Database::addQuery("SELECT precio_actual FROM subastas WHERE sid=?", $sid);
        header('Location: Index.php?cantidad='.$subasta.'');
    }
}

?>