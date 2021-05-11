<?php

class Subasta {
    static public function crearSubasta($nombre, $precio) {
        
    }

    /*public function crearSubasta() {
        $nombre = strip_tags(addslashes($_POST['nombre']));
        $fecha = strip_tags(addslashes($_POST['time']));
        $precio_salida = strip_tags(addslashes($_POST['precio']));
        $unixTime = time();
        switch ($fecha) {
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
        $dbCall = new Database(); 
        $getSubastas = $dbCall->setQuery("SELECT subastas FROM subastausers WHERE email=$_SESSION[email]");
        $fila = mysqli_fetch_assoc($getSubastas);
        $fila['subastas']++;
        $dbCall->setQuery("INSERT INTO `subastas`(nombre, fecha, fecha_fin, precio_salida, precio_actual) VALUES ('$nombre','$unixTime','$fecha_fin','$precio_salida','$precio_salida')");
        $dbCall->setQuery("UPDATE `subastausers` SET `subastas`=$fila[subastas] WHERE email=$_SESSION[email]");
    }*/

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
}

?>