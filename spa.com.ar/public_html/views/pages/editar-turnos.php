<?php
session_start();
require('../../config.php');
require_once(PROJECT_DB_CONEXION);
if (isset($_POST) && isset($_POST["id"]) && (isset($_POST["atendido"]) || isset($_POST["cancelado"]))) {
    try {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("CALL actualizar_reserva(:id, :atendido, :cancelado)");
        $statement->bindParam(":id", $_POST["id"], PDO::PARAM_INT);
        $atendido = isset($_POST["atendido"]) ? true : false;
        $cancelado = isset($_POST["cancelado"]) ? true : false;
        $statement->bindParam(":atendido", $atendido, PDO::PARAM_BOOL);
        $statement->bindParam(":cancelado", $cancelado, PDO::PARAM_BOOL);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            header("Location: /");
            die();
        } else exit();
        $statement = null;
        $pdo = null;
    } catch (PDOException $e) {
        echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
    }
}
?>