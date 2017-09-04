<?php
namespace App\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class IndexControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers->get('/', 'App\Controller\IndexController::indexPage')->bind('index_home');
       
        return $controllers;
    }
}