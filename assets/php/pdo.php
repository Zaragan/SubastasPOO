<?php

class Database extends PDO {

    public function __construct($file = 'settings.ini') {
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');
       
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['name'];
       
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }

    static public function addQuery($sentencia, $param1) {
        $conexion = new Database();
        $query = $conexion->prepare($sentencia);
        if($param1 == null) {
            $query->execute();
        } else {
            $query->bindParam(1, $param1);
            $query->execute();
        }
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

?>