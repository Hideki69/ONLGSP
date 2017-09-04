<?php

// 1 : Quelques Constantes Utiles...
define('PATH_ROOT', $_SERVER["DOCUMENT_ROOT"]);
define('PATH_PRIVATE', PATH_ROOT . '/private');
define('PATH_SRC', PATH_ROOT . '/src');
define('PATH_RESSOURCES', PATH_ROOT . '/ressources/admin');
define('PATH_VIEWS', PATH_RESSOURCES . '/views');
define('PATH_VENDOR', PATH_ROOT . '/vendor');

// 2 : Importation de l'Autoloader
require_once PATH_VENDOR . '/autoload.php';

// 3 : Instanciation de l'Application
$app = new Silex\Application();

// 4 : Configuration de l'Application.
require PATH_SRC.'/adminApp.php';

// 5 : Execution de l'Application
$app->run();
















