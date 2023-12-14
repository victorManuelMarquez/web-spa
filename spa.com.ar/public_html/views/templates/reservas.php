<div class="divisor"></div>
<div class="container-fluid" id="reservas">
    <div class="container py-5 w-lg-50">
        <form action="<?=PAGE_RESERVAR_TURNO;?>" method="post" id="formReservaServicio">
            <fieldset>
                <legend class="text-center fs-2 fw-bold">Reservar un turno</legend>
                <?php if (isset($_SESSION["usuario"])): ?>
                    <input type="hidden" name="idUsuario" value="<?=unserialize($_SESSION["usuario"])->getId();?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label" for="servicioReserva">Servicio</label>
                    <input type="hidden" name="id" value="" id="idServicioReserva"/>
                    <input class="form-control" readonly type="text" name="servicio" value="" id="servicioReserva" placeholder="Escoga un servicio del catálogo..."/>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <div class="mb-3">
                        <label class="form-label" for="dniReserva">Documento de Identidad</label>
                        <input class="form-control" disabled type="text" name="dni" id="dniReserva" minlength="7" maxlength="9" required/>
                    </div>
                    <div class="mb-3 flex-fill">
                        <label class="form-label" for="nombreCompletoReserva">Nombre Completo</label>
                        <input class="form-control" disabled type="text" name="nombreCompleto" id="nombreCompletoReserva" minlength="1" maxlength="100" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="fechaReserva">Fecha</label>
                        <input class="form-control" disabled type="datetime-local" name="fechaReserva" id="fechaReserva" required/>
                    </div>
                </div>
                <button class="btn btn-primary disabled" type="submit" id="btnReservarReserva">Reservar</button>
            </fieldset>
        </form>
        <?php if (isset($_SESSION["usuario"])): ?>
            <div class="pt-5 overflow-x-auto">
                <h1 class="text-center text-primary pb-3">Turnos</h1>
                <table class="table table-striped-columns" id="tablaReservas">
                    <thead>
                        <tr>
                            <th scope="col">Categoría</th>
                            <th scope="col">Servicio</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Nombre Completo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Atendido</th>
                            <th scope="col">Cancelado</th>
                            <th scope="col">Gestión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once(PROJECT_DB_CONEXION);
                        try {
                            $tipo = unserialize($_SESSION["usuario"])->getTipo();
                            $id_usuario = unserialize($_SESSION["usuario"])->getId();
                            $pdo = Conexion::conectar();
                            if (unserialize($_SESSION["usuario"])->esAdmin() ||
                            unserialize($_SESSION["usuario"])->esProfesional()) {
                                $statement = $pdo->prepare("CALL seleccionar_reservas(:tipoUsuario)");
                                $statement->bindParam(":tipoUsuario", $tipo, PDO::PARAM_STR);
                            } else {
                                $statement = $pdo->prepare("CALL seleccionar_reservas_de_usuario(:idUsuario)");
                                $statement->bindParam(":idUsuario", $id_usuario, PDO::PARAM_INT);
                            }
                            if ($statement->execute()) {
                                $resultset = $statement->fetchAll();
                            }
                            $pdo = null;
                        } catch (PDOException $e) {
                            echo '<script>window.alert("' . $e->getMessage() . '");</script>';
                        }
                        foreach ($resultset as $table => $row): ?>
                            <tr>
                                <form action="<?=PAGE_EDITAR_TURNO;?>" method="post">
                                    <?php foreach ($row as $column => $data): ?>
                                        <?php if ($column == "id"): $id = $data;  elseif ($column == "atendido" || $column == "cancelado"): ?>
                                            <td>
                                                <input class="form-check-input" type="checkbox" name="<?=$column?>" id="<?=$column . '_' . $id;?>" <?=$data == 0 ? '' : 'checked';?>>
                                            </td>
                                        <?php else: ?>
                                            <td><?=$data?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" disabled type="submit">Aplicar</button>
                                            <button class="btn btn-outline-primary" disabled type="reset">Deshacer</button>
                                        </div>
                                    </td>
                                    <input type="hidden" name="id" value="<?=$id;?>">
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="divisor"></div>