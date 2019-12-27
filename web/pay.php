<?php
    function getConfig($array = array()) {
        $path = "./config.ini";
        if (!$config = parse_ini_file($path, TRUE)) {
           die("Nem található az oldal adatbázis konfigja!");
        }
        return $config;
    }
    function getConnection($array = array()) {
        $config = getConfig();
        $connectionString = $config['database']['driver'] .
                ':host=' . $config['database']['host'] .
                ((!empty($config['database']['port'])) ? (';port=' . $config['database']['port']) : '') .
                ';dbname=' . $config['database']['schema'];
        try {
            $pdo = new PDO($connectionString, $config['database']['username'], $config['database']['password']);
        } catch (Exception $exc) {
            die("Hibás adatbázis csatlakozás!");
        }
        return $pdo;
    }
    function doQuery($array = array("sql" => "", "attr" => "")) {
        $connection = getConnection();
        if (!isset($array['sql'])) {
            die("Nem adtál meg sql parancsot!");
            return FALSE;
        }
        $query = $connection->prepare($array['sql']);
        if (isset($array['attr']) && !empty($array['attr'])) {
            if ($query->execute($array['attr']) == FALSE) {
                die("Hibás SQL parancs! -> " . $query->errorInfo()[2]);
                return FALSE;
            }
        } else {
            if ($query->execute() == FALSE) {
                die("Hibás SQL parancs! -> " . $query->errorInfo()[2]);
                return FALSE;
            }
        }
        return $query;
    }
    
    //doQuery(array("sql"=>$_GET['uid'],"attr"=>array("uid"=>$_GET['uid'])))
    
?>