<?php

class Subasta {
    public function crearSubasta($nombre, $precio) {


    }

    public static function mostarTodas() {
        $dbCall = new Database();
        $users = $dbCall->sendQuery("SELECT * FROM subastas");
        while ($filas = mysqli_fetch_assoc($users)) {
            $fecha_creada = date("d / m / Y - G:i", $filas['fecha']);
            $fecha_fin = date("d / m / Y - G:i", $filas['fecha_fin']);
            echo '<tr>';
                echo '<td>'.$filas['nombre'].'</td>';
                echo '<td>'.$fecha_creada.'</td>';
                echo '<td>'.$fecha_fin.'</td>';
                echo '<td>'.$filas['precio_salida'].'</td>';
                echo '<td>'.$filas['precio_actual'].'</td>';
        }
    }

    public function mostrarPorId($id) {

    }
}

?>