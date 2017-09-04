<?php
namespace App\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        # --------------------------------------------------------------------------------------------------------------------#
        # AdminController
        # --------------------------------------------------------------------------------------------------------------------#
                
        # Page d'index de connexion
        $controllers->match('/', 'App\Controller\AdminController::AdminConnexion')
        ->method('GET|POST')
        ->bind('admin_connexion');
        # Page d'accueil administrateur
        $controllers->get('/admin_{adminSession}/', 'App\Controller\AdminController::AdminAccess')
        ->assert('adminSession', '[^/]+')
        ->bind('admin_access');
        # page de deconnexion de l'administrateur
        $controllers
        ->get('/deconnexion.html', 'App\Controller\AdminController::deconnexion')
        ->bind('admin_deconnexion');
        # page d'inscription d'aministrateur (version test a supprimer apres)
        $controllers
        ->match('/inscription_administrateur/', 'App\Controller\AdminController::adminInscription')
        ->method('GET|POST')
        ->bind('admin_inscription');
        # page d'information php
        $controllers
        ->get('/phpinfo', 'App\Controller\AdminController::phpInfo');
        
        # --------------------------------------------------------------------------------------------------------------------#
        # AdminUsersController
        # --------------------------------------------------------------------------------------------------------------------#
        
        # Page liste des utilisateurs
        $controllers->match('/admin_{adminSession}/users/liste_users.html', 'App\Controller\AdminUsersController::AdminUsers')
        ->method('GET|POST')
        ->bind('admin_users');
        # Page modifier utilisateur
        $controllers->match('/admin_{adminSession}/users/edit_user_id_{usersId}.html', 'App\Controller\AdminUsersController::AdminUsersEdit')
        ->method('GET|POST')
        ->bind('admin_users_edit');
        # Page ajouter d'utilisateur
        $controllers->match('/admin_{adminSession}/users/add_user.html', 'App\Controller\AdminUsersController::AdminUsersAdd')
        ->method('GET|POST')
        ->bind('admin_users_add');
        # Page supprimer utilisateur
        $controllers->get('/admin_{adminSession}/users/del_user_id_{usersId}.html', 'App\Controller\AdminUsersController::AdminUsersDel')
        ->bind('admin_users_del');
        # Page activer utilisateur
        $controllers->get('/admin_{adminSession}/users/active_user_id_{usersId}.html', 'App\Controller\AdminUsersController::AdminUsersActive')
        ->bind('admin_users_active');
        # Page désactiver utilisateur
        $controllers->get('/admin_{adminSession}/users/desactive_user_id_{usersId}.html', 'App\Controller\AdminUsersController::AdminUsersDesactive')
        ->bind('admin_users_desactive');
        
        # --------------------------------------------------------------------------------------------------------------------#
        # AdminGamesController
        # --------------------------------------------------------------------------------------------------------------------#
        # Page liste des utilisateurs
        $controllers->get('/admin_{adminSession}/games/liste_games.html', 'App\Controller\AdminGamesController::AdminGames')
        ->bind('admin_games');
        
               
        return $controllers;
    } 
}