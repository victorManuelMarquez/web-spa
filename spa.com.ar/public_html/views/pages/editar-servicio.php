<?php
session_start();
require_once('../../config.php');
require(PAGE_TOP_HALF);
require(PAGE_NAVBAR);
require_once(MODELO_SERVICIOS);

if (isset($_GET["id"])) {
    try {
        $servicio = Servicio::buscarPorId($_GET["id"]);
    } catch (PDOException $e) {
        echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
    }
}

if (isset($_POST)) {
    $campos = ["id", "idCategoria", "nombre", "media", "info", "tarifa"];
    $i = 0;
    $total = sizeof($campos);
    while ($i < $total && array_key_exists($campos[$i], $_POST))
    {
        $i++;
    }
    if ($i === $total) {
        try {
            $result = Servicio::actualizar($_POST["id"], $_POST["idCategoria"], $_POST["nombre"], $_POST["media"], $_POST["info"], $_POST["tarifa"]);
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

<main class="container py-5">
    <div class="card card-body">
        <form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <fieldset>
                <input type="hidden" name="id" value="<?=$servicio->getId();?>">
                <legend class="text-center fw-bold fs-2">Editar Servicio</legend>
                <div class="mb-3">
                    <label class="form-label" for="categoriaSelector">Categoría</label>
                    <select class="form-control" name="idCategoria" id="categoriaSelector" required>
                        <option value="">Seleccione</option>
                        <?php
                        require_once(MODELO_CATEGORIA);
                        foreach (Categoria::listarTodas() as $categoria): ?>
                            <option value="<?=$categoria->getId();?>" <?=$servicio->getCategoria()->getId() === $categoria->getId() ? 'selected="selected"' : '';?>><?=$categoria->getNombre();?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nombreServicio">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombreServicio" minlength="1" maxlength="100" placeholder="<?=$servicio->getNombre();?>" required/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mediaServicio">Imagen ilustrativa</label>
                    <input class="form-control" type="link" name="media" id="mediaServicio" maxlength="240"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="infoServicio">Descripción</label>
                    <textarea class="form-control" name="info" id="infoServicio" rows="5" minlength="1" maxlength="240" placeholder="<?=$servicio->getInfo();?>" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="tarifaServicio">Tarifa Actual</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input class="form-control" type="number" name="tarifa" id="tarifaServicio" min="0" max="99999999" step="any" placeholder="<?=$servicio->getTarifa();?>" required/>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btn btn-success" type="submit">Guardar</button>
                    <button class="btn btn-outline-success" type="reset">Restablecer</button>
                </div>
            </fieldset>
        </form>
    </div>
</main>

<?php
require(PAGE_FOOTER);
require(PAGE_BOTTOM_HALF);
?>