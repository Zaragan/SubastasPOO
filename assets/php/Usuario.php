<?php
include('db.php');
include('Funciones.php');
class Usuario {

    public static function crearUsuario($username, $password) {
        if (validarEmail($username) == true) {   
            $hashpass = password_hash($password, PASSWORD_ARGON2ID);
            $dbCall = new Database;
            $listar = $dbCall->query("SELECT * FROM users");
            $searchForEmail = false;
            if($listar['username'] == $username) {
                $searchForEmail = true;
                header('Location: Index.php?mensaje=en_uso');
            }
            if ($searchForEmail == false) {
                echo $hashpass."<br>";
                echo $username;
                $dbCall->query("INSERT INTO `users`(`username`, `password`) VALUES ('$username','$hashpass')");
            }
        } else {
            header('Location: Index.php?mensaje=error_formatoEmail');
        }
    }

    public static function identificarUsuario($username, $password) {
        if(validarEmail($username) == true)  {
            $dbCall = new Database;
            $listar = $dbCall->query("SELECT * FROM `users` WHERE username='$username'");
            /*while($filas = $listar->fetch_assoc()){}*/
            if ($listar != false) {
                if($listar['username'] == $username && password_verify($password, $listar['password']) == true) {
                    $_SESSION['id']=$listar['id'];
                    $_SESSION['username']=$listar['username'];
                    $_SESSION['level']=$listar['level'];
                    $_SESSION['moneda']=$listar['moneda'];
                } else {
                    header('Location: Index.php?mensaje=mensaje_error');
                }
            } else {
                header('Location: Index.php?mensaje=mensaje_error');
            }
            

        } else {
            header('Location: Index.php?mensaje=error_formatoEmail');
        }
    }

}
?>