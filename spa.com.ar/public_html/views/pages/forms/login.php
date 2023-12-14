<?php
session_start();
require_once('../../../config.php');
require(PAGE_TOP_HALF);
require(PAGE_NAVBAR);

if (isset($_POST) && isset($_POST["email"]) && isset($_POST["clave"])) {
    try {
        require_once(MODELO_USUARIO);
        $usuario = Usuario::logear($_POST["email"], $_POST["clave"]);
        if ($usuario !== null) {
            $_SESSION["usuario"] = serialize($usuario);
            header("Location: /");
            die();
        }
    } catch (PDOException $e) {
        echo '<script>window.alert("' . $e->getMessage() . '"); window.location.href = "/"; </script>';
    } catch (TypeError $e) {
        echo '<script>window.alert("Correo y/o contraseña incorrecta.");</script>';
    }
}

?>

<main class="container my-5">
    <div class="card card-body">
        <form action="" method="post">
            <fieldset>
                <legend class="text-center fw-bold fs-2">Iniciar Sesión</legend>
                <div class="mb-3">
                    <label class="form-label" for="campoEmail">Correo electrónico</label>
                    <input class="form-control" type="email" name="email" id="campoEmail" maxlength="100" autocomplete="on" required/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="campoClave">Contraseña</label>
                    <input class="form-control" type="password" name="clave" id="campoClave" maxlength="8" required/>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="recordar" id="checkRecordar"/>
                    <label class="form-label" for="checkRecordar">Recordar acesso</label>
                </div>
                <button class="btn btn-success" type="submit">Acceder</button>
            </fieldset>
        </form>
    </div>
</main>

<?php
require(PAGE_FOOTER);
require(PAGE_BOTTOM_HALF);
?>