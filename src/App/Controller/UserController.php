<?php
namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    public function userPage(Application $app, Request $request)
    {
        return '<h1>Page Utilisateur</h1>';
    }      
}