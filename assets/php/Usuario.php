<?php
include_once("assets/php/pdo.php");
class Usuario {

    static public function crearUsuario($username, $password) {
        if(Funciones::validarEmail($username) == true) {
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
        if(Funciones::validarEmail($username) == true)  {
            $user = Database::addQuery("SELECT * FROM `users` WHERE username=?", $username);
            foreach($user as $row) {
                if($row['username'] == $username && password_verify($password, $row['password']) == true) {
                    $_SESSION['uid']=$row['uid'];
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

    static public function getMoneda($username) {
        $user = Database::addQuery("SELECT * FROM `users` WHERE uid=?", $username);
        foreach($user as $row) {
            $moneda = $row['moneda'];
            return $moneda;
        }
    }

    static public function addmoneda($moneda, $uid) {
        $antes = Database::addQuery("SELECT moneda FROM `users` WHERE uid=?", $uid);
        foreach($antes as $row) {
            $despues = $moneda + $row['moneda'];
        }
        Database::addQuery("UPDATE `users` SET `moneda`= $despues WHERE uid=?", $uid);
    }
}
?>