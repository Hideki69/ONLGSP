<?php
namespace App\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class UserControllerProvider implements ControllerProviderInterface
{
 	public function connect(Application $app)
    	{
	$controllers = $app['controllers_factory'];
	


	return $controllers;

	}
}