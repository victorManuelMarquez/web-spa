<?php
session_start();
require_once('../../config.php');
require(PAGE_TOP_HALF);
require(PAGE_NAVBAR);
if (isset($_POST["categoria"])) {
    try {
        require_once(MODELO_CATEGORIA);
        $result = Categoria::crear($_POST["categoria"]);
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
                <legend class="text-center fw-bold fs-2">Nueva Categoría</legend>
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre</label>
                    <input class="form-control" type="text" name="categoria" id="nombre" minlength="1" maxlength="100" placeholder="Categoría" required/>
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