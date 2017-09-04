<?php

use Idiorm\Silex\Provider\IdiormServiceProvider;

#1 : Connexion BDD
define('DBHOST',     'localhost');
define('DBNAME',     '');
define('DBUSERNAME', '');
define('DBPASSWORD', '');

#2 : Doctrine DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => DBHOST,
        'dbname'    => DBNAME,
        'user'      => DBUSERNAME,
        'password'  => DBPASSWORD
    ),
));

#3 : Idiorm ORM
$app->register(new IdiormServiceProvider(), array(
    'idiorm.db.options' => array(
        'connection_string' => 'mysql:host='.DBHOST.';dbname='.DBNAME,
        'username' => DBUSERNAME,
        'password' => DBPASSWORD,
        'id_column_overrides' => array()
    )
));
