<?php

use Silex\Provider\AssetServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silex\Provider\HttpFragmentServiceProvider;

#1 : Activation du Debuggage
$app['debug'] = true;

#2 : Gestion de nos Controllers via ControllerProvider
require PATH_SRC . '/routes.php';

#3 : Permet le rendu d'un controller dans la vue
#  : https://silex.symfony.com/doc/2.0/providers/twig.html#rendering-a-controller
$app->register(new HttpFragmentServiceProvider());

#4 : Activation de Twig
# : composer require twig/twig
# : composer require symfony/twig-bridge
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => [
        PATH_VIEWS,
        PATH_RESSOURCES .'/layout'
    ],
));

#5 : Activation de Asset
$app->register(new AssetServiceProvider());

#6 : Importations pour les Formulaires
$app->register(new FormServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

#7 : Protection CSRF des Formulaires
$app->register(new CsrfServiceProvider());

#8 : Service de Validation
$app->register(new ValidatorServiceProvider());

#9 : Doctrine DBAL et Idiorm ORM
require PATH_RESSOURCES . '/config/database.config.php';

#10 : Sécurisation de notre Application
require PATH_RESSOURCES . '/config/security.php';

#11 : Gestion des Erreurs
#   : https://gist.github.com/tournasdim/171b443065936bbb5ef3
$app->error(function (\Exception $e) use ($app) {
    if ($e instanceof NotFoundHttpException) {
        return $app['twig']->render('erreur.html.twig', [
            'message' => $e->getMessage()
        ]);
    };
});

#12 : On retourne $app
return $app;
