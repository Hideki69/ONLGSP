<?php
namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        ->add('pseudo', TextType::class, [
            'required'      =>  true,
            'label'         =>  'Identifiant',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                 'class'            => 'form-control',
            'placeholder'       => 'Saisissez votre identifiant',
                 'autocomplete'     => 'new-password'
            ]
        ])
        ->add('password', PasswordType::class, [
            'required'      =>  true,
            'label'         =>  'Mot de passe',
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
            'pseudo'        => $admin['pseudo'],
            'password'     => $app['security.encoder.digest']->encodePassword($admin['password'], '')
        ))
        ->count();
            
            if($isMailInDb) :
            
            $adminSession = $app['security.encoder.digest']->encodePassword($admin['pseudo'].$admin['password'].date('YmdHis').uniqid(), '');
            
            $adminDb = $app['idiorm.db']->for_table('admin')->use_id_column('pseudo')->find_one($admin['pseudo']);
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
            'admindb'        => $adminDb,
            'menu'           => 'accueil'
        ]);
        
        endif;
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controller d'inscription d'administrateur (a supprimer apres test)
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminInscription(Application $app, Request $request)
    {
    
        $form = $app['form.factory']->createBuilder(FormType::class)
        ->add('pseudo', TextType::class, [
        'required'     =>  true,
        'label'        =>  'Identifiant',
        'constraints'  =>  array(new NotBlank()),
        'attr'         =>  [
            'class'             => 'form-control',
            'placeholder'       => 'Saisissez votre identifiant',
            'autocomplete'      => 'new-password'
            ]
        ])
        ->add('password', PasswordType::class, [
        'required'       =>  true,
        'label'          =>  'Mot de passe',
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
        
            $isMailInDb = $app['idiorm.db']->for_table('admin')->where('pseudo', $admin['pseudo'])->count();
            
             if(!$isMailInDb) :
                    
                $adminDb1 = $app['idiorm.db']->for_table('admin')->create();
                $adminDb1->pseudo       = $admin['pseudo'];
                $adminDb1->password     = $app['security.encoder.digest']->encodePassword($admin['password'], '');
                $adminDb1->ip           = $admin['ip'];
                $adminDb1->actif        = '1';
                $adminDb1->save();
                
                $adminDbA = $app['idiorm.db']->for_table('admin')->where('pseudo', $admin['pseudo'])->find_one();
                
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
    # Controlleur edit administrateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminEdit(Application $app, Request $request, $adminSession)
    {
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else:
        
        $adminInfos = $app['idiorm.db']->for_table('adminDetails')->where('idAdmin', $isSessionInDb['idAdmin'])->find_one();
        
        
        $form = $app['form.factory']->createBuilder(FormType::class)
        ->add('passwordAdmin', PasswordType::class, [
            'required'      =>  true,
            'label'         =>  'Mot de passe*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Mot de passe'
            ]
        ])
        ->add('emailAdmin', EmailType::class, [
            'required'      =>  true,
            'label'         =>  'Adresse Email*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'value'         =>  $isSessionInDb['email'],
                'placeholder'   => 'Saisissez l\'email',
                'autocomplete'  => 'new-password'
            ]
        ])
        ->add('nomAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Nom',
            'attr'          =>  [
                'value'         =>  $adminInfos['nom'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le nom'
            ]
        ])
        ->add('prenomAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Prénom',
            'attr'          =>  [
                'value'         =>  $adminInfos['prenom'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le prénom'
            ]
        ])
        ->add('adresseAdmin', TextareaType::class, [
            'required'      =>  false,
            'label'         =>  'Adresse',
            'data'          => $adminInfos['adresse'],
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez l\'adresse'
            ]
        ])
        ->add('cpAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Code Postal',
            'attr'          =>  [
                'value'         =>  $adminInfos['cp'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le code postal'
            ]
        ])
        ->add('villeAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Ville',
            'attr'          =>  [
                'value'         =>  $adminInfos['ville'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez la ville'
            ]
        ])
        ->add('paysAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Pays',
            'attr'          =>  [
                'value'         =>  $adminInfos['pays'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le pays'
            ]
        ])
        ->add('telephoneAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Téléphone',
            'attr'          =>  [
                'value'         =>  $adminInfos['telephone'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le téléphone'
            ]
        ])
        ->add('idAdmin', HiddenType::class, [
            'required'      =>  false,
            'label'         =>  false,
            'attr'          =>  [
                'value'         =>  $adminInfos['idAdmin']
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label'     => 'Modifier',
            'attr'      =>  [
                'class'     => 'btn btn-block btn-primary'
            ]
        ])
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()):
        
        $admin = $form->getData();
        
        $form1 = $app['form.factory']->createBuilder(FormType::class)
        ->add('passwordAdmin', PasswordType::class, [
            'required'      =>  true,
            'label'         =>  'Mot de passe*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Mot de passe'
            ]
        ])
        ->add('emailAdmin', EmailType::class, [
            'required'      =>  true,
            'label'         =>  'Adresse Email*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'value'         =>  $admin['emailAdmin'],
                'placeholder'   => 'Saisissez l\'email',
                'autocomplete'  => 'new-password'
            ]
        ])
        ->add('nomAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Nom',
            'attr'          =>  [
                'value'         =>  $admin['nomAdmin'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le nom'
            ]
        ])
        ->add('prenomAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Prénom',
            'attr'          =>  [
                'value'         =>  $admin['prenomAdmin'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le prénom'
            ]
        ])
        ->add('adresseAdmin', TextareaType::class, [
            'required'      =>  false,
            'label'         =>  'Adresse',
            'data'          => $admin['adresseAdmin'],
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez l\'adresse'
            ]
        ])
        ->add('cpAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Code Postal',
            'attr'          =>  [
                'value'         =>  $admin['cpAdmin'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le code postal'
            ]
        ])
        ->add('villeAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Ville',
            'attr'          =>  [
                'value'         =>  $admin['villeAdmin'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez la ville'
            ]
        ])
        ->add('paysAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Pays',
            'attr'          =>  [
                'value'         =>  $admin['paysAdmin'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le pays'
            ]
        ])
        ->add('telephoneAdmin', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Téléphone',
            'attr'          =>  [
                'value'         =>  $admin['telephoneAdmin'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le téléphone'
            ]
        ])
        ->add('idAdmin', HiddenType::class, [
            'required'      =>  false,
            'label'         =>  false,
            'attr'          =>  [
                'value'         =>  $admin['idAdmin']
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label'     => 'Modifier',
            'attr'      =>  [
                'class'     => 'btn btn-block btn-primary'
            ]
        ])
        ->getForm();
        
        $form1->handleRequest($request);
        
        # ------------------------------------------------------------ #
        # Controle des champs avec indications erreur (a faire)
        # ------------------------------------------------------------ #
        $erreurModif = [];
        
        if($isSessionInDb['email'] != $admin['emailAdmin']):
        
        if($app['idiorm.db']->for_table('admin')->where('email',$admin['emailAdmin'])->find_one()):
        
        $erreurModif[] = 'L\'adresse email que vous avez saisi existe déjà !';
        
        endif;
        
        endif;
        
        if(count($erreurModif) > 0):
        
        return $app['twig']->render('admin_edit.html.twig', [
            'session'       => $adminSession,
            'form'          => $form1->createView(),
            'erreur'        => $erreurModif,
            'valid'         => '',
            'menu'           => 'mon_compte'
        ]);
        
        endif;
        # ------------------------------------------------------------ #
        
        $userBd1 = $app['idiorm.db']->for_table('admin')->use_id_column('idAdmin')->find_one($admin['idAdmin']);
        $userBd1->set('password', $admin['passwordAdmin']);
        $userBd1->set('email', $admin['emailAdmin']);
        $userBd1->save();
        
        $userBd2 = $app['idiorm.db']->for_table('adminDetails')->use_id_column('idAdmin')->find_one($admin['idAdmin']);
        
        $userBd2->set('nom', $admin['nomAdmin']);
        $userBd2->set('prenom', $admin['prenomAdmin']);
        $userBd2->set('adresse', $admin['adresseAdmin']);
        $userBd2->set('cp', $admin['cpAdmin']);
        $userBd2->set('ville', $admin['villeAdmin']);
        $userBd2->set('pays', $admin['paysAdmin']);
        $userBd2->set('telephone', $admin['telephoneAdmin']);
        $userBd2->save();
        
        
        if(!$userBd1 || !$userBd2):
        
        $erreurModif[] = 'Erreur d\'enregistrement dans la base de données !';
        
        return $app['twig']->render('admin_edit.html.twig', [
            'session'       => $adminSession,
            'form'          => $form1->createView(),
            'erreur'        => $erreurModif,
            'valid'         => '',
            'menu'           => 'mon_compte'
        ]);
        else:
        return $app['twig']->render('admin_edit.html.twig', [
            'session'       => $adminSession,
            'form'          => $form1->createView(),
            'erreur'        => '',
            'valid'         => 'Vos modifications ont été éffectuées !',
            'menu'           => 'mon_compte'
        ]);
        endif;
        
        endif;
        
        endif;
        
        return $app['twig']->render('admin_edit.html.twig', [
            'session'       => $adminSession,
            'form'          => $form->createView(),
            'erreur'        => '',
            'valid'         => '',
            'menu'           => 'mon_compte'
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