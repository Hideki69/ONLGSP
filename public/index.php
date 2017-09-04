<?php

// 1 : Quelques Constantes Utiles...
define('PATH_ROOT', dirname(__DIR__));
define('PATH_PUBLIC', PATH_ROOT . '/public');
define('PATH_SRC', PATH_ROOT . '/src');
define('PATH_RESSOURCES', PATH_ROOT . '/ressources/user');
define('PATH_VIEWS', PATH_RESSOURCES . '/views');
define('PATH_VENDOR', PATH_ROOT . '/vendor');

// 2 : Importation de l'Autoloader
require_once PATH_VENDOR . '/autoload.php';

// 3 : Instanciation de l'Application
$app = new Silex\Application();

// 4 : Configuration de l'Application.
require PATH_SRC . '/app.php';

// 5 : Execution de l'Application
$app->run();
















