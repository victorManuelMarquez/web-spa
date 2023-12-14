<?php

define('PROJECT_MAIN_TITLE', "Salta Spa");

define('PROJECT_PATH', dirname(__FILE__));

define('LOGIN_PAGE', '/views/pages/forms/login.php');
define('SIGNIN_PAGE', '/views/pages/forms/signin.php');
define('LOGOUT_PAGE', '/views/pages/forms/logout.php');
define('PAGE_NUEVA_CATEGORIA', '/views/pages/nueva-categoria.php');
define('PAGE_NUEVO_SERVICIO', '/views/pages/nuevo-servicio.php');
define('PAGE_EDITAR_CATEGORIA', '/views/pages/editar-categoria.php');
define('PAGE_BORRAR_CATEGORIA', '/views/pages/borrar-categoria.php');
define('PAGE_EDITAR_SERVICIO', '/views/pages/editar-servicio.php');
define('PAGE_BORRAR_SERVICIO', '/views/pages/borrar-servicio.php');
define('PAGE_RESERVAR_TURNO', '/views/pages/reservar-turno.php');
define('PAGE_EDITAR_TURNO', '/views/pages/editar-turnos.php');

define('PAGE_TOP_HALF', PROJECT_PATH . '/views/templates/top_half_page.php');
define('PAGE_BOTTOM_HALF', PROJECT_PATH . '/views/templates/bottom_half_page.php');
define('PAGE_NAVBAR', PROJECT_PATH . '/views/templates/navbar.php');
define('PAGE_HEADER', PROJECT_PATH . '/views/templates/header.php');
define('PAGE_MAIN_CONTENT', PROJECT_PATH . '/views/templates/main_content_page.php');
define('PAGE_FOOTER', PROJECT_PATH . '/views/templates/footer.php');

define('CONTENT_GALERIA_SERVICIOS', PROJECT_PATH . '/views/templates/galeria.php');
define('CONTENT_RESERVAS', PROJECT_PATH . '/views/templates/reservas.php');

define('PAGE_CSS_DIR', '/assets/css');
define('MAIN_PAGE_STYLE', PAGE_CSS_DIR . '/estilos.css');

define('PAGE_SCRIPTS_DIR', '/assets/js');
define('FORM_SCRIPT', PAGE_SCRIPTS_DIR . '/formularios.js');
define('SCRIPT_RESERVAS', PAGE_SCRIPTS_DIR . '/reservas.js');

define('PAGE_IMG_DIR', '/assets/img');
define('PROJECT_LOGO', PAGE_IMG_DIR . '/flower-spa-icon.svg');

define('PROJECT_DB_CONEXION', PROJECT_PATH . '/database/conexion.php');

define('PROJECT_MODELS', PROJECT_PATH . '/models');
define('MODELO_CATEGORIA', PROJECT_MODELS . '/categoria.php');
define('MODELO_SERVICIOS', PROJECT_MODELS . '/servicio.php');
define('MODELO_USUARIO', PROJECT_MODELS . '/usuario.php');
?>