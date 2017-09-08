<?php
namespace App\Controller;

use Silex\Application;

class AdminGamesController
{
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller de liste des server jeux installés
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function AdminGames(Application $app,  $adminSession)
    {
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else :
        
        $usersDb = $app['idiorm.db']->for_table('view_users')->where(array('roleUsers' => '9', 'actifUsers' => '1'))->find_many();
        $jeuxUsersDb = $app['idiorm.db']->for_table('usersJeux')->join('jeux', array('usersJeux.idjeux', '=', 'jeux.idJeux'))->find_many();
        
        return $app['twig']->render('games_liste.html.twig', [
            'session'        => $adminSession,
            'usersDb'        => $usersDb,
            'usersJeuxDb'   => $jeuxUsersDb,
            'menu'           => 'servers_jeux'
        ]);
        endif;
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller ajout de servers jeux
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function AdminGamesAdd(Application $app,  $adminSession, $idUsers)
    {
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else :
        
        $usersDb = $app['idiorm.db']->for_table('users')->where('idUsers',$idUsers)->find_one();
        
        //$usersJeuxDb = $app['idiorm.db']->for_table('usersJeux')->select('idJeux')->find_many();
        
        //$jeuxDb = $app['idiorm.db']->for_table('jeux')
        //->where('actif','1')->find_many();
        
        $usersJeuxDb = $app['idiorm.db']->for_table('usersJeux')
        ->table_alias('uj')
        ->raw_query('SELECT j.* FROM jeux j where j.actif = 1')
        ->find_many();
        
   
        return $app['twig']->render('games_add.html.twig', [
            'session'       => $adminSession,
            'pseudo'        => $usersDb['pseudo'],
            'usersDb'       => $usersDb,
            'jeuxDb'        => $usersJeuxDb,
            'menu'          => 'servers_jeux'
        ]);
        endif;
    }
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller des commandes des servers jeux
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function AdminCmdServer(Application $app, $adminSession, $idUsersJeux, $nom, $action)
    {
        
        require_once 'cmd/cmdJeux.php';
        
        function cmdServer($ip,$login,$password, $cmd)
        {
            $passe= $password;
            $connection=@ssh2_connect($ip, 22);
            
            if(!$connection):
            return "Erreur de lancement de la commande";
            
            else:
            @ssh2_auth_password($connection,$login,$passe);
            $ssh2_exec_1=ssh2_exec($connection, 'rm - /var/log/auth.log');
            stream_set_blocking($ssh2_exec_1,true);
            stream_get_contents($ssh2_exec_1);
            $ssh2_exec=@ssh2_exec($connection, $cmd);
            stream_set_blocking($ssh2_exec, true);
            $info=stream_get_contents($ssh2_exec);
            return $info;
            
            endif;
        }
        if($action == 'start' || $action == 'restart'):
        $etat = 'start';
        else:
        $etat = 'stop';
        endif;
        
        
        if($action == 'delete'):
        $userJeuxBd = $app['idiorm.db']->for_table('usersJeux')->use_id_column('idUsersJeux')->find_one($idUsersJeux);
        $userJeuxBd->delete();
        else:
        $userJeuxBd = $app['idiorm.db']->for_table('usersJeux')->use_id_column('idUsersJeux')->find_one($idUsersJeux);
        $userJeuxBd->set('etatJeux',$etat);
        $userJeuxBd->save();
        endif;
        
        
        cmdServer('127.0.0.1', 'ONLGSP', 'webforce3', cmdJeux($nom, $action));
        
        return $app->redirect( $app['url_generator']->generate('admin_games', array('adminSession' => $adminSession)) );
        
        
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller des commandes des servers jeux
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function AdminGamesUserAdd(Application $app, $adminSession, $idUsers, $idJeux, $nom)
    {
        
        require_once 'cmd/cmdJeux.php';
        
        function cmdServer($ip,$login,$password, $cmd)
        {
            $passe= $password;
            $connection=@ssh2_connect($ip, 22);
            
            if(!$connection):
            return "Erreur de lancement de la commande";
            
            else:
            @ssh2_auth_password($connection,$login,$passe);
            $ssh2_exec_1=ssh2_exec($connection, 'rm - /var/log/auth.log');
            stream_set_blocking($ssh2_exec_1,true);
            stream_get_contents($ssh2_exec_1);
            $ssh2_exec=@ssh2_exec($connection, $cmd);
            stream_set_blocking($ssh2_exec, true);
            $info=stream_get_contents($ssh2_exec);
            return $info;
            
            endif;
        }
        
        $userJeuxBdA = $app['idiorm.db']->for_table('usersJeux')->where(array('idJeux'=>$idJeux))->find_one();
        
        if(!$userJeuxBdA):
        $userJeuxBd1 = $app['idiorm.db']->for_table('usersJeux')->create();
        $userJeuxBd1->idUsers    = $idUsers;
        $userJeuxBd1->idJeux    = $idJeux;
        $userJeuxBd1->etatJeux  = 'stop';
        $userJeuxBd1->dateFin   = date('Y-m-d H:i:s', strtotime('+4 hour'));
        $userJeuxBd1->save();
        
       
        return $app['twig']->render('games_cmd.html.twig',[
            'session'       => $adminSession,
            'output'        => cmdServer('127.0.0.1', 'ONLGSP', 'webforce3', cmdJeux($nom, 'update')),
            'action'        => 'install',
            'menu'          => 'servers_jeux',
            'nom'           => $nom
        ]);
    
        endif;
        
        return $app->redirect( $app['url_generator']->generate('admin_games', array('adminSession' => $adminSession)) );
        
        
        
    }
}