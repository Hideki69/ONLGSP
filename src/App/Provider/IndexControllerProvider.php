<?php
namespace App\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class IndexControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        # --------------------------------------------------------------------------------------------------------------------#
        # UserController
        # --------------------------------------------------------------------------------------------------------------------#

        # Page d'index de connexion
        $controllers->match('/', 'App\Controller\IndexController::indexConnexion')
        ->method('GET|POST')
        ->bind('index_connexion');
        # Page d'accueil administrateur
        $controllers->get('/users_{usersSession}/', 'App\Controller\IndexController::indexAccess')
        ->assert('usersSession', '[^/]+')
        ->bind('index_access');
        # page de deconnexion de l'utilisateur
        $controllers
        ->get('/deconnexion.html', 'App\Controller\IndexController::indexdeconnexion')
        ->bind('index_deconnexion');
        // $controllers->get('/', 'App\Controller\UserController::userPage')
        // ->bind('index_user');

        $controllers
        ->get('/phpinfo', 'App\Controller\IndexController::phpInfo');

        return $controllers;
    }
}
