<?php

class Subasta {
    public function crearSubasta($nombre, $precio) {


    }

    public static function mostarTodas() {
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

    public function mostrarPorId($id) {

    }
}

?>