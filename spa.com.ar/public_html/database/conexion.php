<?php

class Conexion {

    // crea la conexión.
    public static function conectar(): PDO {
        $properties = parse_ini_file("credenciales.ini", true);
        if ($properties) {
            $driver = $properties["database"]["driver"];
            $host = $properties["database"]["host"];
            $port = $properties["database"]["port"];
            $schema = $properties["database"]["schema"];
            $username = $properties["database"]["username"];
            $password = $properties["database"]["password"];
            $pdo = new PDO("$driver:host=$host;port=$port;dbname=$schema", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } else {
            throw new Exception("No se pudo cargar las credenciales.");
        }
        return $pdo;
    }

}

?>