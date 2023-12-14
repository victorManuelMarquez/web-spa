<?php
session_start();
require_once('../../config.php');
require(PAGE_TOP_HALF);
require(PAGE_NAVBAR);

if (isset($_POST["id"]) && isset($_POST["nombre"])) {
    try {
        require_once(MODELO_CATEGORIA);
        $result = Categoria::actualizar($_POST["id"], $_POST["nombre"]);
        var_dump($result);
        if ($result > 0)
        {
            header("Location: /");
            die();
        } else exit();
    } catch (PDOException $e) {
        echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
    }
}

?>

<main class="container py-5">
    <div class="card card-body">
        <form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <fieldset>
                <input type="hidden" name="id" value="<?=$_GET["id"];?>">
                <legend class="text-center fw-bold fs-2">Editar Categoría</legend>
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nuevo Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" minlength="1" maxlength="100" placeholder="<?=$_GET["nombre"];?>" required/>
                </div>
            </fieldset>
            <div class="btn-group">
                <button class="btn btn-success fw-bold" type="submit">Guardar</button>
                <button class="btn btn-outline-success fw-bold" type="reset">Limpiar</button>
            </div>
        </form>
    </div>
</main>

<?php
require(PAGE_FOOTER);
require(PAGE_BOTTOM_HALF);
?>