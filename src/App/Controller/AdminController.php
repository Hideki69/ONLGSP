<?php
namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminController
{ 
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller de connexion administrateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminConnexion(Application $app, Request $request)
    {
        $form = $app['form.factory']->createBuilder(FormType::class)
        ->add('email', EmailType::class, [
            'required'      =>  true,
            'label'         =>  false,
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                 'class'            => 'form-control',
                 'placeholder'      => 'Saisissez votre email',
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
        
        $admin = $form->getData();
        
        $isMailInDb = $app['idiorm.db']->for_table('admin')
        ->where(array(
            'email'        => $admin['email'],
            'password'     => $app['security.encoder.digest']->encodePassword($admin['password'], '')
        ))
        ->count();
            
            if($isMailInDb) :
            
            $adminSession = $app['security.encoder.digest']->encodePassword($admin['email'].$admin['password'].date('YmdHis').uniqid(), '');
            
            $adminDb = $app['idiorm.db']->for_table('admin')->use_id_column('email')->find_one($admin['email']);
            $adminDb->set('session', $adminSession);
            $adminDb->set('finSession', date('Y-m-d H:i:s', strtotime('+4 hour')));
            $adminDb->save();
            
            return $app->redirect( $app['url_generator']->generate('admin_access', array('adminSession' => $adminSession)));

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
    # Controller de validation d'acces administrateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminAccess(Application $app, Request $request, $adminSession)
    {
      
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else :
        
        $adminDb = $app['idiorm.db']->for_table('admin')->where('session', $adminSession)->find_result_set();

        return $app['twig']->render('index.html.twig', [
            'session'        => $adminSession,
            'admindb'        => $adminDb 
        ]);
        
        endif;
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller d'inscription d'administrateur (a supprimer apres test)
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminInscription(Application $app, Request $request)
    {
    
        $form = $app['form.factory']->createBuilder(FormType::class)
        ->add('email', EmailType::class, [
        'required'     =>  true,
        'label'        =>  false,
        'constraints'  =>  array(new NotBlank()),
        'attr'         =>  [
            'class'             => 'form-control',
            'placeholder'       => 'Saisissez votre email',
            'autocomplete'      => 'new-password'
            ]
        ])
        ->add('password', PasswordType::class, [
        'required'       =>  true,
        'label'          =>  false,
        'constraints'    =>  array(new NotBlank()),
        'attr'           =>  [
            'class'             => 'form-control',
            'autocomplete'      => 'new-password'
            ]
        ])
        ->add('ip', HiddenType::class, [
        'label'         =>  false,
        'attr'          =>  [
            'value'             => $_SERVER['REMOTE_ADDR']
            ]
        ])
        ->add('submit', SubmitType::class, [
        'label'         =>  'S\'inscrire',
        'attr'          =>  [
            'class'             => 'btn btn-block btn-primary'
            ]
        ])
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) :
            
            $admin = $form->getData();
        
            $isMailInDb = $app['idiorm.db']->for_table('admin')->where('email', $admin['email'])->count();
            
             if(!$isMailInDb) :
                    
                $adminDb1 = $app['idiorm.db']->for_table('admin')->create();
                $adminDb1->email        = $admin['email'];
                $adminDb1->password     = $app['security.encoder.digest']->encodePassword($admin['password'], '');
                $adminDb1->ip           = $admin['ip'];
                $adminDb1->actif        = '1';
                $adminDb1->save();
                
                $adminDbA = $app['idiorm.db']->for_table('admin')->where('email', $admin['email'])->find_one();
                
                $adminDb2 = $app['idiorm.db']->for_table('adminDetails')->create();
                $adminDb2->idAdmin        = $adminDbA['idAdmin'];
                $adminDb2->save();
                        
                return $app->redirect( $app['url_generator']->generate('admin_connexion') );
                        
            else :
            
                return $app['twig']->render('inscription.html.twig', [
                    'form'      => $form->createView(),
                    'error'     => 'Cette adresse mail existe deja !',
                    'session'   => ''
                ]);
   
            endif;
                
        endif;
        
            return $app['twig']->render('inscription.html.twig', [
                'form'     => $form->createView(),
                'error'    => '',
                'session'   => ''
            ]);
        
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur de deconnexion administrateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function deconnexion(Application $app)
    {
    $app['session']->clear();
        
    return $app->redirect( $app['url_generator']->generate('admin_connexion') );
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur d'information php
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function phpInfo()
    {
    return phpinfo();
    }
}