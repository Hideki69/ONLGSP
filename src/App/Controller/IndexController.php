<?php
namespace App\Controller;

use Silex\Application;

class IndexController
{
    public function indexPage(Application $app)
    {
        return $app['twig']->render('index.html.twig');
    }

    public function deconnexionPage(Application $app) {
        # On vide la session de l'utilisateur
        $app['session']->clear();
        # On le redirige sur l'url de notre choix
        return $app->redirect( $app['url_generator']->generate('index_home') );
    }
}