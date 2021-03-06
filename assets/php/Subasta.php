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
        Database::addQuery("INSERT INTO `subastas`(uid, nombre, fecha, fecha_fin, precio_salida, precio_actual, puja) VALUES ($_SESSION[uid],'$nombre','$unixTime','$fecha_fin','$precio_salida','$precio_salida','$_SESSION[nombre]')", null);
        header('Location: Index.php');
    }

    static public function mostarSubastas() {
        $subastas = Database::addQuery("SELECT * FROM subastas", null);
        foreach($subastas as $row) {
            $fecha_creada = date("d / m / Y - G:i", $row['fecha']);
            $fecha_fin = date("d / m / Y - G:i", $row['fecha_fin']);
            $fecha = time();
            if($row['fecha_fin'] <= $fecha) {
                Database::addQuery("UPDATE `subastas` SET `caducada`= 1 WHERE sid=?", $row['sid']);
            }
            if($row['caducada'] == 1) {
                continue;
            } else {
                echo '<tr>';
                    if($_SESSION['level'] == 1) {
                        echo '<td>'.$row['sid'].'</td>';
                        echo '<td>'.$row['nombre'].'</td>';
                    } else {
                        echo '<td>'.$row['nombre'].'</td>';
                    };
                    echo '<td>'.$fecha_creada.'</td>';
                    echo '<td>'.$fecha_fin.'</td>';
                    echo '<td>'.$row['precio_salida'].'</td>';
                    echo '<td>'.$row['precio_actual'].'</td>';
                    echo '<td>'.$row['puja'].'</td>';
                    echo '<td><form method="post"><input type="text" name="puja"></td>';
                    echo '<input type="hidden" name="sid" value="'.$row['sid'].'" readonly>';
                    echo '<td><input type="submit" value="Pujar" name="pujar" class="btn"></form></td>';
                echo '</tr>';
            }
        }
    }

    static public function mostrarTodas() {
        $subastas = Database::addQuery("SELECT * FROM subastas", null);
        foreach($subastas as $row) {
            $fecha_creada = date("d / m / Y - G:i", $row['fecha']);
            $fecha_fin = date("d / m / Y - G:i", $row['fecha_fin']);
            echo '<tr>';
                if($_SESSION['level'] == 1) {
                    echo '<td>'.$row['sid'].'</td>';
                    echo '<td>'.$row['nombre'].'</td>';
                } else {
                    echo '<td>'.$row['nombre'].'</td>';
                };
                echo '<td>'.$fecha_creada.'</td>';
                echo '<td>'.$fecha_fin.'</td>';
                echo '<td>'.$row['precio_salida'].'</td>';
                echo '<td>'.$row['precio_actual'].'</td>';
                echo '<td>'.$row['puja'].'</td>';
                echo '<td><form method="post"><input type="text" name="puja"></td>';
                    echo '<input type="hidden" name="sid" value="'.$row['sid'].'" readonly>';
                    echo '<td><input type="submit" value="Pujar" name="pujar" class="btn"></form></td>';
                if($_SESSION['level'] == 1) {
                    if($row['caducada'] == 1){
                        echo '<td>Si</td>';
                    } else {
                        echo '<td>No</td>';
                    }
                };
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

    static public function mostrarPropias($uid) {
        //      SID NOMBRE FECHA    FECHA_FIN   PRECIO_SALIDA   PRECIO_ACTUAL   PUJA    CADUCADA
        $subasta = Database::addQuery("SELECT subastas.sid,subastas.nombre,subastas.fecha,subastas.fecha_fin,subastas.precio_salida,subastas.precio_actual,subastas.puja,subastas.caducada FROM `subastas` INNER JOIN `users` ON subastas.uid=users.uid WHERE subastas.uid=?", $uid);
        foreach($subasta as $row) {
            $fecha_creada = date("d / m / Y - G:i", $row['fecha']);
            $fecha_fin = date("d / m / Y - G:i", $row['fecha_fin']);
            echo '<tr>';
            echo '<td>'.$row['sid'].'</td>';
            echo '<td>'.$row['nombre'].'</td>';
            echo '<td>'.$fecha_creada.'</td>';
            echo '<td>'.$fecha_fin.'</td>';
            echo '<td>'.$row['precio_salida'].'</td>';
            echo '<td>'.$row['precio_actual'].'</td>';
            echo '<td>'.$row['puja'].'</td>';
            if($row['caducada'] == 1) {
                echo '<td>Si</td>';
            } else {
                echo '<td>No</td>';
            }
            echo '<td><form method="post"></td>';
            echo '<input type="hidden" name="sid" value="'.$row['sid'].'" readonly>';
            echo '<td><input type="submit" value="Borrar" name="borrar" class="btn"></form></td>';
        echo '</tr>';
        }
    }

    static public function sBorrar($sid) {
        Database::addQuery("DELETE FROM `subastas` WHERE sid=?", $sid);
    }

    static public function pujar($sid, $cantidad, $uid) {
        
        //  Sacamos el precio de la subasta y calculamos el 15%
        $precio_actual = Database::addQuery("SELECT precio_actual FROM subastas WHERE sid=?", $sid);
        foreach($precio_actual as $row) {
            $precio_actual = $row['precio_actual'];
        }
        $precio_actual += $precio_actual*15/100;
        
        //  Sacamos la moneda del usuario
        $moneda = Database::addQuery("SELECT moneda FROM users WHERE uid=?", $_SESSION['uid']);
        foreach($moneda as $row) {
            $moneda = $row['moneda'];
        }
        //  Si precio es mayor que moneda eres pobre
        if ($precio_actual > $moneda) {
            header('Location: Index.php?mensaje=error_pobre');
        //  Si precio es mayor que tu puja, mete mas dinero
        } else if ($precio_actual > $cantidad) {
            header('Location: Index.php?mensaje=error_minima_puja');
        } else if ($moneda <= $cantidad) {
            header('Location: Index.php?mensaje=error_pobre');
        } else {
            Database::addQuery("UPDATE `subastas` SET `precio_actual`= $cantidad, `puja` = '$_SESSION[nombre]' WHERE sid=?", $sid);
            $moneda -= $cantidad;
            Database::addQuery("UPDATE `users` SET `moneda`= $moneda WHERE uid=?", $_SESSION['uid']);
            header('Location: Index.php');
        }        
    }
}

?>