<?php

class Database extends PDO {

    public function __construct($file = 'settings.ini') {
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');
       
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['table'];
       
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }

    static public function addQuery($sentencia) {
        $conexion = new Database();
        $query = $conexion->prepare($sentencia);
        $query->execute();
        $query->fetchAll(PDO::FETCH_ASSOC);
        return $query;
    }

    static public function getInfo() {
        $conexion = new Database();
        $getInfo = $conexion->prepare("SELECT id,email,moneda FROM users");
        if (!$getInfo) {
            print "feo";
        }
        $getInfo->execute();
        return $getInfo;
    }

    static public function getUserInfo($a) {
        $conexion = new Database();
        $getInfo = $conexion->prepare("SELECT id,email,moneda FROM users WHERE id=?");
        $getInfo->bindParam(1, $a);
        $getInfo->execute();
        while($filas = $getInfo->fetch(PDO::FETCH_BOTH)) {
            print "ID=".$filas[0]." email=".$filas[1]." moneda=".$filas[2];
        }
    }
}

?>