<nav class="navbar navbar-expand-lg fixed-top bg-light shadow-sm">
    <!-- CONTENIDO DINÁMICO AQUÍ -->
    <div class="container py-1">
        <a class="navbar-brand text-secondary mx-0" href="/">
            <img src="<?=PROJECT_LOGO;?>" class="d-inline-block align-text-top" alt width="32" height="32">
            <span class="fs-5 fw-bold ms-1"><?=PROJECT_MAIN_TITLE;?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuDesplegable" aria-controls="menuDesplegable" aria-expanded="false" aria-label="Navegar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuDesplegable">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0"></ul>
            <ul class="navbar-nav mx-0 mb-2 mb-lg-0">
                <?php if (isset($_SESSION["usuario"])): ?>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="btn btn-outline-primary" href="<?=LOGOUT_PAGE;?>">
                            <i class="bi bi-box-arrow-in-left me-1"></i>
                            Cerrar Sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="btn btn-outline-primary" href="<?=LOGIN_PAGE;?>">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Iniciar Sesión
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item mb-2 mb-lg-0">
                    <a class="btn btn-primary" href="<?=SIGNIN_PAGE;?>">
                        <i class="bi bi-person-circle me-1"></i>
                        Registrarse
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>