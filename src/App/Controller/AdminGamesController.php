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

	
#	$output = shell_exec('sudo mkdir insurgency 2>&1');
#	echo "<pre>$output</pre>";
#
#	$output = shell_exec('cd insurgency && sudo wget -N --no-check-certificate https://gameservermanagers.com/dl/linuxgsm.sh 2>&1');
#	echo "<pre>$output</pre>";
#
#	$output = shell_exec('sudo chown -R www-data /var/www/html/private/insurgency 2>&1');
#	echo "<pre>$output</pre>";
#
#	$output = shell_exec('sudo -u www-data chmod +x linuxgsm.sh  2>&1');
#	echo "<pre>$output</pre>";
#
#	$output = shell_exec('bash linuxgsm.sh insserver 2>&1');
#	echo "<pre>$output</pre>";
#
#	$output = shell_exec('ls 2>&1');
#	echo "<pre>$output</pre>";

	$output = shell_exec('sudo -u ONLGSP mkdir /home/ONLGSP/insurgency 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo -u ONLGSP cd /home/ONLGSP/insurgency 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo wget -N --no-check-certificate https://gameservermanagers.com/dl/linuxgsm.sh 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo cp /var/www/html/private/linuxgsm.sh /home/ONLGSP/insurgency/linuxgsm.sh 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo chown ONLGSP /home/ONLGSP/insurgency/linuxgsm.sh 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo chown ONLGSP /var/www/html/private 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo -u ONLGSP chmod +x /home/ONLGSP/insurgency/linuxgsm.sh 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo -u ONLGSP bash /home/ONLGSP/insurgency/linuxgsm.sh insserver 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo cp /var/www/html/private/insserver /home/ONLGSP/insurgency/insserver 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo chown ONLGSP /home/ONLGSP/insurgency/insserver 2>&1');
	echo "<pre>$output</pre>";

	$output = shell_exec('sudo -u ONLGSP bash /home/ONLGSP/insurgency/insserver install 2>&1');
	echo "<pre>$output</pre>";

            return $app['twig']->render('games_liste.html.twig',[
            'session'       => $adminSession,
            'iterator'      => $output
          
            ]);

        endif;    }
}