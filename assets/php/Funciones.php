<?php

class Funciones {

    static public function menu() {
        if (!isset($_SESSION['level'])) {
            //          DESCONECTADO
            $menu = '<ul>
                        <form method="POST" class="usuario">
                        <li><label for="user">Usuario: </label></li>
                        <li><input type="text" name="user" id="user" required></li>
                        <li><label for="password">Contraseña: </label></li>
                        <li><input type="password" name="password" id="password" required></li>
                        <li><input type="submit" value="Identificar" name="identificar" class="btn"></li>
                        <li><input type="submit" value="Registrar" name="crear_usuario" class="btn"></li>
                        </form>
                    </ul>';
        } else if ($_SESSION['level'] == 1){
            //          ADMIN ZONE
            $menu = '<ul>
                        <li><a href="Index.php">Inicio</a></li>
                        <li><a href="Index.php?page=new_subasta">Crear subastas</a></li>
                        <li>Moneda: '.Usuario::getMoneda($_SESSION['uid']).'</li>
                        <li class="menu"></li>
                        <li class="menu"><p><a href="perfil.php">Perfil admin: '.$_SESSION['username'].'</a></p><a href="assets/php/desconectar.php">Desconectar</a></li>
                    </ul>';
        } else {
            //          USER ZONE
            $menu = '<ul>
                        <li><a href="Index.php">Inicio</a></li>
                        <li><a href="Index.php?page=new_subasta">Crear subastas</a></li>
                        <li>Moneda: '.Usuario::getMoneda($_SESSION['uid']).'</li>
                        <li class="menu"><p><a href="perfil.php">Perfil '.$_SESSION['username'].'</a></p><a href="assets/php/desconectar.php">Desconectar</a></li>
                    </ul>';
        }
        echo $menu;
    }

    static public function filtrado($frase) {
        $filtrada = strip_tags(addslashes($frase));
        return $filtrada;
    }

    static public function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    static public function parse_email($email) {
        $parts = explode("@", $email);
        $domain = array_pop($parts);
        $name = implode("@",$parts);
        return $name;

    }
   
}

?>