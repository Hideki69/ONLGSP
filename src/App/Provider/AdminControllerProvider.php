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
        $controllers->match('/', 'App\Controller\AdminController::adminConnexion')
        ->method('GET|POST')
        ->bind('admin_connexion');
        
        # Page d'accueil administrateur
        $controllers->get('/admin_{adminSession}/', 'App\Controller\AdminController::adminAccess')
        ->assert('adminSession', '[^/]+')
        ->bind('admin_access');
        
        # page de deconnexion de l'administrateur
        $controllers
        ->get('/deconnexion.html', 'App\Controller\AdminController::deconnexion')
        ->bind('admin_deconnexion');
        
        # page modifier aministrateur (profil menu)
        $controllers
        ->match('/admin_{adminSession}/mon_compte/mes_informations.html', 'App\Controller\AdminController::adminEdit')
        ->method('GET|POST')
        ->bind('admin_edit');
        
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
        $controllers->match('/admin_{adminSession}/users/liste_users.html', 'App\Controller\AdminUsersController::adminUsers')
        ->method('GET|POST')
        ->bind('admin_users');
        
        # Page modifier utilisateur
        $controllers->match('/admin_{adminSession}/users/edit_user_id_{usersId}.html', 'App\Controller\AdminUsersController::adminUsersEdit')
        ->method('GET|POST')
        ->bind('admin_users_edit');
        
        # Page ajouter d'utilisateur
        $controllers->match('/admin_{adminSession}/users/add_user.html', 'App\Controller\AdminUsersController::adminUsersAdd')
        ->method('GET|POST')
        ->bind('admin_users_add');
        
        # Page supprimer utilisateur
        $controllers->get('/admin_{adminSession}/users/del_user_id_{usersId}.html', 'App\Controller\AdminUsersController::adminUsersDel')
        ->bind('admin_users_del');
        
        # Page activer utilisateur
        $controllers->get('/admin_{adminSession}/users/active_user_id_{usersId}.html', 'App\Controller\AdminUsersController::adminUsersActive')
        ->bind('admin_users_active');
        
        # Page désactiver utilisateur
        $controllers->get('/admin_{adminSession}/users/desactive_user_id_{usersId}.html', 'App\Controller\AdminUsersController::adminUsersDesactive')
        ->bind('admin_users_desactive');
        
        # --------------------------------------------------------------------------------------------------------------------#
        # AdminGamesController
        # --------------------------------------------------------------------------------------------------------------------#
        # Page liste servers jeux utilisateurs
        $controllers->get('/admin_{adminSession}/games/liste_games.html', 'App\Controller\AdminGamesController::adminGames')
        ->bind('admin_games');
        
        # Page add jeux utilisateurs
        $controllers->get('/admin_{adminSession}/games/user_{idUsers}/add_games.html', 'App\Controller\AdminGamesController::adminGamesAdd')
        ->bind('admin_games_add');
        
        # Page cmd server de l'utilisateur
        $controllers->get('/admin_{adminSession}/games/{idUsersJeux}/{nom}_{action}.html', 'App\Controller\AdminGamesController::adminCmdServer')
        ->bind('admin_cmdServer');
        
        # Page cmd server de l'utilisateur
        $controllers->get('/admin_{adminSession}/games/{idJeux}/user_{idUsers}/{nom}_install.html', 'App\Controller\AdminGamesController::adminGamesUserAdd')
        ->bind('admin_games_user_add');
        
        
        return $controllers;
    } 
}