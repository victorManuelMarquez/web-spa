<?php
session_start();
require_once('../../../config.php');
require(PAGE_TOP_HALF);
require(PAGE_NAVBAR);

if (isset($_POST)) {
    $campos = ["tipo", "email", "clave"];
    $i = 0;
    $total = sizeof($campos);
    while ($i < $total && array_key_exists($campos[$i], $_POST))
    {
        $i++;
    }
    if ($i === $total) {
        try {
            require_once(MODELO_USUARIO);
            $result = Usuario::registrar($_POST["tipo"], $_POST["email"], $_POST["clave"]);
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
        <form action="" method="post">
            <fieldset>
                <legend class="text-center fw-bold fs-2">Nuevo Usuario</legend>
                <?php
                require_once(MODELO_USUARIO);
                if (isset($_SESSION["usuario"]) && unserialize($_SESSION["usuario"])->esAdmin()): ?>
                    <div class="mb-3">
                        <label class="form-label" for="selectorTipoUsuario">Cuenta de Usuario</label>
                        <select class="form-control" name="tipo" id="selectorTipoUsuario" required>
                            <option value="">Seleccione...</option>
                            <?php
                            try {
                                $tiposUsuario = Usuario::listarTipos();
                            } catch (PDOException $e) {
                                echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
                            }
                            foreach ($tiposUsuario as $data):?>
                                <option value="<?=$data["id"];?>"><?=$data["tipo"];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else:
                    try {
                        $id_cliente = Usuario::porDefecto();
                    } catch (PDOException $e) {
                        echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
                    }
                ?>
                    <input type="hidden" name="tipo" value="<?=$id_cliente;?>" required/>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label" for="campoEmail">Correo electrónico</label>
                    <input class="form-control" type="email" name="email" id="campoEmail" maxlength="100" autocomplete="off" required/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="campoClave">Contraseña</label>
                    <input class="form-control" type="password" name="clave" id="campoClave" maxlength="8" required/>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="recordar" id="checkRecordar"/>
                    <label class="form-label" for="checkRecordar">Recordar acceso</label>
                </div>
                <div class="btn-group">
                    <button class="btn btn-success" type="submit">Registrarse</button>
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