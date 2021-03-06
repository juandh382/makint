<?php
session_start();

/* El orden de estos scripts es importante para su funcionalidad. No se deben de importar en orden distinto */

include 'vendor/autoload.php';

/** IMPORTACION DE LA BASE DE DATOS */

require_once 'config/db.php';

/** IMPORTACION DE LAS PRINCIPALES CONSTANTES */

require_once 'config/globals.php';


/* LAYOUT */

require_once 'views/layout/header.php';
require_once 'views/layout/sidebar.php';


/* CONTROLADORES */
require 'helpers/utils.php';
require 'controllers/ErrorController.php';
require 'controllers/MainController.php';
require 'controllers/UserController.php';

function show_error()
{
	$error = new ErrorController();
	$error->index();
}

if (isset($_GET['controller'])) {
	$nombre_controlador = $_GET['controller'] . 'Controller';

}
elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
	$nombre_controlador = controller_default;


}
else {
	show_error();
	exit();
}

if (class_exists($nombre_controlador)) {
	$controlador = new $nombre_controlador();

	if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
		$action = $_GET['action'];
		$controlador->$action();
	}
	elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
		$action_default = action_default;
		$controlador->$action_default();
	}
	else {
		show_error();
	}
}
else {
	show_error();
}

require_once 'views/layout/footer.php';