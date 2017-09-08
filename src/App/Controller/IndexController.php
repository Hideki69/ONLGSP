<?php
namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;


class IndexController
{

    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller de connexion utilisateur
    # --------------------------------------------------------------------------------------------------------------------------- #

      public function indexConnexion(Application $app, Request $request)
      {
        $form = $app['form.factory']->createBuilder(FormType::class)
        ->add('pseudo', TextType::class, [
            'required'      =>  true,
            'label'         =>  false,
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                 'class'            => 'form-control',
                 'placeholder'      => 'Saisissez votre pseudo',
                 'autocomplete'     => 'new-password'
            ]
        ])
        ->add('password', PasswordType::class, [
            'required'      =>  true,
            'label'         =>  false,
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                 'class'            => 'form-control',
                 'placeholder'      => '***********',
                 'autocomplete'     => 'new-password'
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label'         => 'Connexion',
            'attr'          =>  [
                 'class'            => 'btn btn-block btn-primary'
            ]
        ])
        ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) :

        $users = $form->getData();

        $isMailInDb = $app['idiorm.db']->for_table('users')
        ->where(array(
            'pseudo'        => $users['pseudo'],
            'password'     => $app['security.encoder.digest']->encodePassword($users['password'], '')
        ))
        ->count();

            if($isMailInDb) :

            $usersSession = $app['security.encoder.digest']->encodePassword($users['pseudo'].$users['password'].date('YmdHis').uniqid(), '');

            $usersDb = $app['idiorm.db']->for_table('users')->use_id_column('pseudo')->find_one($users['pseudo']);
            $usersDb->set('session', $usersSession);
            $usersDb->set('finSession', date('Y-m-d H:i:s', strtotime('+4 hour')));
            $usersDb->save();

            return $app->redirect( $app['url_generator']->generate('index_access', array('usersSession' => $usersSession)));

            else :

            return $app['twig']->render('connexion.html.twig', [
                'form'=>$form->createView(),
                'error'=>'Identifiant et/ou mot de passe incorrect.',
                'session'=>''
            ]);

            endif;

        endif;

        return $app['twig']->render('connexion.html.twig', [
            'form'       =>$form->createView(),
            'error'      =>'',
            'session'    =>''
        ]);
      }

      # --------------------------------------------------------------------------------------------------------------------------- #
      # Controller de validation d'acces utilisateur
      # --------------------------------------------------------------------------------------------------------------------------- #
      public function indexAccess(Application $app, Request $request, $usersSession)
      {

          $isSessionInDb = $app['idiorm.db']->for_table('users')
          ->where('session', $usersSession)
          ->where_gt('finSession', date('Y-m-d H:i:s'))
          ->find_one();

          if(!$isSessionInDb):

          return $app->redirect( $app['url_generator']->generate('index_connexion') );

          else :

          $usersDb = $app['idiorm.db']->for_table('users')->where('session', $usersSession)->find_result_set();

          return $app['twig']->render('index.html.twig', [
              'session'        => $usersSession,
              'usersdb'        => $usersDb
          ]);

          endif;
      }

    public function IndexDeconnexion(Application $app) {
        # On vide la session de l'utilisateur
        $app['session']->clear();
        # On le redirige sur l'url de notre choix
        return $app->redirect( $app['url_generator']->generate('index_connexion') );
    }
}
