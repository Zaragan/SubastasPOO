<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "proyectos";
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli($this->host,$this->username,$this->password,$this->db);
        $this->conexion->set_charset("utf8");
        if($this->conexion->connect_errno) {
            echo "Lo sentimos, este sitio web está experimentando problemas.";
            exit;
        }
    }

    public function sendQuery($sentencia) {
        $sentencia = stripcslashes(ltrim(rtrim($sentencia)));
        return mysqli_query($this->conexion, $sentencia);
    }

    public function query($sentencia) {
        $sentencia = stripcslashes(ltrim(rtrim($sentencia)));
        $tipo = strtoupper(substr($sentencia,0,6));
		switch($tipo){
            case 'SELECT':
                $resultado = mysqli_query($this->conexion, $sentencia);
                
                if($resultado != false) {
                    if(mysqli_num_rows($resultado) == 0) {
                        return false;
                    } else {
                        while ($filas = mysqli_fetch_assoc($resultado)) {
                            $fila = $filas;
                        }
                        mysqli_free_result($resultado);
                    }
                    return $fila;
                } else {
                    header('Location: Index.php?mensaje=mensaje_error');
                }
                break;
/*                
            case 'INSERT':
                $resultado = mysqli_query($this->conexion, $sentencia);
                if(!$resultado){
                    $this->error = mysqli_error();
                }
                break;

            case 'DELETE':
                case 'UPDATE' :
                $resultado = mysql_query($query,$this->conexion);
                if(!$resultado){
                    $this->error = mysqli_error();
                }else{
                    return mysql_affected_rows();
                }
                break;
                */
            default:
            $this->error = "Tipo de consulta no permitida";
        }
    }

    public function __destruct() {
        mysqli_close($this->conexion);
    }
}

?>