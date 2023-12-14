<?php
session_start();
require_once('../../config.php');

if (isset($_POST)) {
    $campos = ["idUsuario", "id", "dni", "nombreCompleto", "fechaReserva"];
    $i = 0;
    $total = sizeof($campos);
    while ($i < $total && array_key_exists($campos[$i], $_POST))
    {
        $i++;
    }
    if ($i === $total) {
        try {
            require_once(PROJECT_DB_CONEXION);
            $pdo = Conexion::conectar();
            $pdo->beginTransaction();
            $statement = $pdo->prepare("CALL insertar_reserva(:idUsuario, :idServicio, :dni, :nombreCompleto, NOW(), :fecha)");
            $statement->bindParam(":idUsuario", $_POST["idUsuario"], PDO::PARAM_INT);
            $statement->bindParam(":idServicio", $_POST["id"], PDO::PARAM_INT);
            $statement->bindParam(":dni", $_POST["dni"], PDO::PARAM_STR);
            $statement->bindParam(":nombreCompleto", $_POST["nombreCompleto"], PDO::PARAM_STR);
            $statement->bindParam(":fecha", $_POST["fechaReserva"], PDO::PARAM_STR);
            $statement->execute() ? $pdo->commit() : $pdo->rollBack();
            $result = $statement->rowCount();
            $statement = null;
            $pdo = null;
            if ($result > 0) {
                header("Location: /");
                die();
            } else exit();
        } catch (PDOException $e) {
            echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
        }
    }
}

?>