<h1 class="text-center text-primary pt-5">Catálogo</h1>
<div class="row g-5 py-5" data-masonry='{ "percentPosition": true }'>
    <div class="col-md-12">
        <div class="row row-cols-1 row-cols-xl-3 g-3">
            <?php
            require_once(MODELO_SERVICIOS);
            require_once(MODELO_CATEGORIA);
            require_once(MODELO_USUARIO);
            $servicios = Servicio::todosLosServicios();
            foreach ($servicios as $servicio): ?>
                <div class="col">
                    <div class="card rounded-3 shadow-sm text-center">
                        <div class="card-header">
                            <span class="badge rounded-pill text-bg-primary mb-2"><?=$servicio->getCategoria()->getNombre();?></span>
                            <h3 class="my-0 fw-normal"><?=$servicio->getNombre();?></h3>
                        </div>
                        <img src="<?=$servicio->getMedia();?>" alt class="card-img-top"/>
                        <div class="card-body administracion">
                            <h4 class="fw-bold">$<?=$servicio->getTarifa();?></h4>
                            <p class="card-text text-secondary text-start my-3"><?=$servicio->getInfo();?></p>
                            <a class="btn btn-primary w-100" href="#reservas" role="button" onclick="reservarServicio(this, '<?=$servicio->getNombre();?>');" id="<?=$servicio->getId();?>">Reservar</a>
                            <?php if (isset($_SESSION["usuario"]) && unserialize($_SESSION["usuario"])->esAdmin()): ?>
                            <hr>
                            <div class="card">
                                <div class="card-header"><i class="bi bi-wrench-adjustable me-2"></i>Categoría</div>
                                <div class="list-group list-group-flush">
                                    <a class="list-group-item list-group-item-action" href="<?=PAGE_EDITAR_CATEGORIA;?>?id=<?=$servicio->getCategoria()->getId();?>&nombre=<?=$servicio->getCategoria()->getNombre();?>">
                                        <i class="bi bi-pencil-square fs-6 fw-bold"></i>
                                        <span class="d-none d-md-inline-block">Editar</span>
                                    </a>
                                    <a class="list-group-item list-group-item-action" href="<?=PAGE_BORRAR_CATEGORIA;?>?id=<?=$servicio->getCategoria()->getId();?>&nombre=<?=$servicio->getCategoria()->getNombre();?>">
                                        <i class="bi bi-trash3-fill fs-6 fw-bold"></i>
                                        <span class="d-none d-md-inline-block">Borrar</span>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="card">
                                <div class="card-header"><i class="bi bi-wrench-adjustable me-2"></i>Servicios</div>
                                <div class="list-group list-group-flush">
                                    <a class="list-group-item list-group-item-action" href="<?=PAGE_NUEVO_SERVICIO;?>">
                                        <i class="bi bi-plus-lg fs-6 fw-bold"></i>
                                        <span class="d-none d-md-inline-block">Añadir</span>
                                    </a>
                                    <a class="list-group-item list-group-item-action" href="<?=PAGE_EDITAR_SERVICIO;?>?id=<?=$servicio->getId();?>">
                                        <i class="bi bi-pencil-square fs-6 fw-bold"></i>
                                        <span class="d-none d-md-inline-block ms-1">Editar</span>
                                    </a>
                                    <a class="list-group-item list-group-item-action" href="<?=PAGE_BORRAR_SERVICIO;?>?id=<?=$servicio->getId();?>&nombre=<?=$servicio->getNombre();?>">
                                        <i class="bi bi-trash3-fill fs-6 fw-bold"></i>
                                        <span class="d-none d-md-inline-block ms-1">Borrar</span>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (isset($_SESSION["usuario"]) && unserialize($_SESSION["usuario"])->esAdmin()): ?>
                <div class="col">
                    <a class="btn btn-primary" href="<?=PAGE_NUEVA_CATEGORIA;?>" role="button">
                        <i class="bi bi-plus-lg fs-6 fw-bold"></i>
                        <span class="d-none d-md-inline-block">Nueva Categoría</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>