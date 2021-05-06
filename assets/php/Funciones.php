<?php

function menu() {
    if (!isset($_SESSION['level'])) {
        //          DESCONECTADO
        $menu = '<ul>
                    <form method="POST" class="usuario">
                    <li><label for="user">Usuario: </label></li>
                    <li><input type="text" name="user" id="user" required></li>
                    <li><label for="password">Contraseña: </label></li>
                    <li><input type="password" name="password" id="password" required></li>
                    <li><input type="submit" value="Identificar" name="identificar" class="btn subm">
                    <li><input type="submit" value="Registrar" name="crear_usuario" class="btn subm">
                    </form>
                </ul>';
    } else if ($_SESSION['level'] == 1){
        //          ADMIN ZONE
        $menu = '<ul>
                    <li><a href="Index.php">Inicio</a></li>
                    <li><a href="Subastar.php">Crear subastas</a></li>
                    <li>Moneda: '.$_SESSION['moneda'].'</li>
                    <li class="menu"><p>Bienvenido admin '.$_SESSION['username'].'</p><a href="assets/php/desconectar.php">Desconectar</a></li>
                </ul>';
    } else {
        //          USER ZONE
        $menu = '<ul>
                    <li><a href="Index.php">Inicio</a></li>
                    <li><a href="Subastar.php">Crear subastas</a></li>
                    <li>Moneda: '.$_SESSION['moneda'].'</li>
                    <li class="menu"><p>Bienvenido '.$_SESSION['username'].'</p><a href="assets/php/desconectar.php">Desconectar</a></li>
                </ul>';
    }
    echo $menu;
}

function main(){
    if (isset($_SESSION['level'])) {
        //      NO LOGIN
        $main = '';
    }
    echo $main;
}




function filtrado($frase) {
    $filtrada = strip_tags(addslashes($frase));
    return $filtrada;
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

?>