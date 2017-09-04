<?php
namespace App\Controller;

use Silex\Application;
use Symfony\Component\Process\Process;

class AdminGamesController
{ 
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller de connexion administrateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function AdminGames(Application $app,  $adminSession)
    {
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
       else:

        //$process = new Process('sudo -u ONLGSP top -bn1');
        $process = new Process('sudo -u ONLGSP bash /home/ONLGSP/minecraft/mcserver install');
        $process->run();
        $output = $process->getOutput();

            return $app['twig']->render('games_liste.html.twig',[
            'session'       => $adminSession,
            'iterator'      => $output
          
            ]);

        endif;    }
}