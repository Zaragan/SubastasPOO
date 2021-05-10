<?php
include('pdo.php');
include('Funciones.php');
class Usuario {

    static public function crearUsuario($username, $password) {
        if(validarEmail($username) == true) {
            $hashpass = password_hash($password, PASSWORD_ARGON2ID);
            $user = Database::addQuery("SELECT username FROM users", null);
            $isRegistered = false;
            foreach($user as $row) {
                if ($row['username']==$username) {
                    $isRegistered = true;
                    header('Location: index.php?mensaje=error_enUso');
                    break;
                } 
            }
            if($isRegistered == false) {
                Database::addQuery("INSERT INTO `users`(`username`, `password`) VALUES ('$username','$hashpass')", null);
                Usuario::identificarUsuario($username, $password);
                header('Location: Index.php');
            }
        } else {
            header('Location: Index.php?mensaje=error_formatoEmail');
        }
    }

    static public function identificarUsuario($username, $password) {
        if(validarEmail($username) == true)  {
            $user = Database::addQuery("SELECT * FROM `users` WHERE username=?", $username);
            foreach($user as $row) {
                if($row['username'] == $username && password_verify($password, $row['password']) == true) {
                    $_SESSION['id']=$row['id'];
                    $_SESSION['username']=$row['username'];
                    $_SESSION['level']=$row['level'];
                    $_SESSION['moneda']=$row['moneda'];
                } else {
                    header('Location: Index.php?mensaje=error_datosMal');
                }
            }
        } else {
            header('Location: Index.php?mensaje=error_formatoEmail');
        }
    }
}
?>