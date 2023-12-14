<?php
session_start();

if (isset($_POST["id"])) {
    try {
        require_once("../../config.php");
        require_once(MODELO_SERVICIOS);
        if (Servicio::eliminar($_POST["id"]) > 0) {
            header("Location: /");
            die();
        } else exit();
    } catch (PDOException $e) {
        echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
    }
}

?>

<form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="formulario">
    <input type="hidden" name="id" value="<?=$_GET["id"];?>">
</form>

<script>
    if (window.confirm("¿Seguro que desea borrar el servicio <?=$_GET["nombre"];?> y las reservas asociadas?") && window.confirm("Última oportunidad. ¿Aún desea proceder?")) {
        let form = document.getElementById("formulario");
        form.submit();
    } else {
        document.location.href = "/";
    }
</script>