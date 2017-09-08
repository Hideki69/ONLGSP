<?php
namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class adminUsersController
{  
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur liste utilisateurs
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function AdminUsers(Application $app,  $adminSession)
    {
    $isSessionInDb = $app['idiorm.db']->for_table('admin')
    ->where('session', $adminSession)
    ->where_gt('finSession', date('Y-m-d H:i:s'))
    ->find_one();
        
        if(!$isSessionInDb):
        
            return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else:
        
            $usersListeDb = $app['idiorm.db']->for_table('view_users')->select('*')->where('roleUsers','9')->order_by_desc('idUsers')->find_result_set();
        
            return $app['twig']->render('users_liste.html.twig', [
            'session'       => $adminSession,
            'usersListeDb'  => $usersListeDb,
                'userDb'        => '',
                'menu'           => 'users'
            ]);
        
        endif;
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur edit utilisateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminUsersEdit(Application $app, Request $request, $usersId,  $adminSession)
    {
    $isSessionInDb = $app['idiorm.db']->for_table('admin')
    ->where('session', $adminSession)
    ->where_gt('finSession', date('Y-m-d H:i:s'))
    ->find_one();
        
        if(!$isSessionInDb):
        
            return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else:
        
            $usersInfos = $app['idiorm.db']->for_table('view_users')->select('*')->where('idUsers', $usersId)->find_one();
        
        
            $form = $app['form.factory']->createBuilder(FormType::class)
            ->add('pseudoUsers', TextType::class, [
            'required'      =>  true,
            'label'         =>  'Pseudo*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'value'         =>  $usersInfos['pseudoUsers'],
                'placeholder'   => 'Saisissez le pseudo'
                ]
            ])
            ->add('emailUsers', EmailType::class, [
            'required'      =>  true,
            'label'         =>  'Adresse Email*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'value'         =>  $usersInfos['emailUsers'],
                'placeholder'   => 'Saisissez l\'email',
                'autocomplete'  => 'new-password'
                ]
            ])
            ->add('nomUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Nom',
            'attr'          =>  [
                'value'         =>  $usersInfos['nomUsers'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le nom'
                ]
            ])
            ->add('prenomUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Prénom',
            'attr'          =>  [
                'value'         =>  $usersInfos['prenomUsers'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le prénom'
                ]
            ])
            ->add('adresseUsers', TextareaType::class, [
            'required'      =>  false,
            'label'         =>  'Adresse',
            'data'          => $usersInfos['adresseUsers'],
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez l\'adresse'
                ]
            ])
            ->add('cpUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Code Postal',
            'attr'          =>  [
                'value'         =>  $usersInfos['cpUsers'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le code postal'
                ]
            ])
            ->add('villeUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Ville',
            'attr'          =>  [
                'value'         =>  $usersInfos['villeUsers'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez la ville'
                ]
            ])
            ->add('paysUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Pays',
            'attr'          =>  [
                'value'         =>  $usersInfos['paysUsers'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le pays'
                ]
            ])
            ->add('telephoneUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Téléphone',
            'attr'          =>  [
                'value'         =>  $usersInfos['telephoneUsers'],
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le téléphone'
                ]
            ])
            ->add('idUsers', HiddenType::class, [
            'required'      =>  false,
            'label'         =>  false,
            'attr'          =>  [
                'value'         =>  $usersInfos['idUsers']
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
            
                $user = $form->getData();
                
                $form1 = $app['form.factory']->createBuilder(FormType::class)
                ->add('pseudoUsers', TextType::class, [
                    'required'      =>  true,
                    'label'         =>  'Pseudo*',
                    'constraints'   =>  array(new NotBlank()),
                    'attr'          =>  [
                        'class'         => 'form-control',
                        'value'         =>  $user['pseudoUsers'],
                        'placeholder'   => 'Saisissez le pseudo'
                    ]
                ])
                ->add('emailUsers', EmailType::class, [
                    'required'      =>  true,
                    'label'         =>  'Adresse Email*',
                    'constraints'   =>  array(new NotBlank()),
                    'attr'          =>  [
                        'class'         => 'form-control',
                        'value'         =>  $user['emailUsers'],
                        'placeholder'   => 'Saisissez l\'email',
                        'autocomplete'  => 'new-password'
                    ]
                ])
                ->add('nomUsers', TextType::class, [
                    'required'      =>  false,
                    'label'         =>  'Nom',
                    'attr'          =>  [
                        'value'         =>  $user['nomUsers'],
                        'class'         => 'form-control',
                        'placeholder'   => 'Saisissez le nom'
                    ]
                ])
                ->add('prenomUsers', TextType::class, [
                    'required'      =>  false,
                    'label'         =>  'Prénom',
                    'attr'          =>  [
                        'value'         =>  $user['prenomUsers'],
                        'class'         => 'form-control',
                        'placeholder'   => 'Saisissez le prénom'
                    ]
                ])
                ->add('adresseUsers', TextareaType::class, [
                    'required'      =>  false,
                    'label'         =>  'Adresse',
                    'data'          => $user['adresseUsers'],
                    'attr'          =>  [
                        'class'         => 'form-control',
                        'placeholder'   => 'Saisissez l\'adresse'
                    ]
                ])
                ->add('cpUsers', TextType::class, [
                    'required'      =>  false,
                    'label'         =>  'Code Postal',
                    'attr'          =>  [
                        'value'         =>  $user['cpUsers'],
                        'class'         => 'form-control',
                        'placeholder'   => 'Saisissez le code postal'
                    ]
                ])
                ->add('villeUsers', TextType::class, [
                    'required'      =>  false,
                    'label'         =>  'Ville',
                    'attr'          =>  [
                        'value'         =>  $user['villeUsers'],
                        'class'         => 'form-control',
                        'placeholder'   => 'Saisissez la ville'
                    ]
                ])
                ->add('paysUsers', TextType::class, [
                    'required'      =>  false,
                    'label'         =>  'Pays',
                    'attr'          =>  [
                        'value'         =>  $user['paysUsers'],
                        'class'         => 'form-control',
                        'placeholder'   => 'Saisissez le pays'
                    ]
                ])
                ->add('telephoneUsers', TextType::class, [
                    'required'      =>  false,
                    'label'         =>  'Téléphone',
                    'attr'          =>  [
                        'value'         =>  $user['telephoneUsers'],
                        'class'         => 'form-control',
                        'placeholder'   => 'Saisissez le téléphone'
                    ]
                ])
                ->add('idUsers', HiddenType::class, [
                    'required'      =>  false,
                    'label'         =>  false,
                    'attr'          =>  [
                        'value'         =>  $user['idUsers']
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
                if($usersInfos['pseudoUsers'] != $user['pseudoUsers']):

                    if($app['idiorm.db']->for_table('users')->where('pseudo', $user['pseudoUsers'])->find_one()):
                        
                        $erreurModif[] = 'Le pseudo que vous avez saisi existe déjà !';
                      
                    endif;
                    
                endif;
                
                if($usersInfos['emailUsers'] != $user['emailUsers']):
                
                    if($app['idiorm.db']->for_table('users')->where('email', $user['emailUsers'])->find_one()):
                        
                        $erreurModif[] = 'L\'adresse email que vous avez saisi existe déjà !';
                                        
                    endif;
                
                endif;
                
                if(count($erreurModif) > 0):
                
                    return $app['twig']->render('users_edit.html.twig', [
                    'session'       => $adminSession,
                    'usersId'       => $usersInfos['idUsers'],
                    'form'          => $form1->createView(),
                    'usersPseudo'   => $usersInfos['pseudoUsers'],
                    'erreur'        => $erreurModif,
                        'valid'         => '',
                'menu'           => 'users'
                    ]);
                
                endif;
                # ------------------------------------------------------------ #

                $userBd1 = $app['idiorm.db']->for_table('users')->use_id_column('idUsers')->find_one($user['idUsers']);
                $userBd1->set('pseudo', $user['pseudoUsers']);
                $userBd1->set('email', $user['emailUsers']);
                $userBd1->save();
                
                $userBd2 = $app['idiorm.db']->for_table('usersDetails')->use_id_column('idUsers')->find_one($user['idUsers']);
                
                $userBd2->set('nom', $user['nomUsers']);
                $userBd2->set('prenom', $user['prenomUsers']);
                $userBd2->set('adresse', $user['adresseUsers']);
                $userBd2->set('cp', $user['cpUsers']);
                $userBd2->set('ville', $user['villeUsers']);
                $userBd2->set('pays', $user['paysUsers']);
                $userBd2->set('telephone', $user['telephoneUsers']);
                $userBd2->save();
                
            
                if(!$userBd1 || !$userBd2):
                
                    $erreurModif[] = 'Erreur d\'enregistrement dans la base de données !';
                
                    return $app['twig']->render('users_edit.html.twig', [
                    'session'       => $adminSession,
                    'usersId'       => $usersInfos['idUsers'],
                    'form'          => $form1->createView(),
                    'usersPseudo'   => $usersInfos['pseudoUsers'],
                    'erreur'        => $erreurModif,
                        'valid'         => '',
                'menu'           => 'users'
                    ]);
                else:
                    return $app['twig']->render('users_edit.html.twig', [
                    'session'       => $adminSession,
                    'usersId'       => $user['idUsers'],
                    'form'          => $form1->createView(),
                    'usersPseudo'   => $user['pseudoUsers'],
                    'erreur'        => '',
                        'valid'         => 'Vos modifications ont été éffectuées !',
                'menu'           => 'users'
                    ]);
                endif;
                
            endif;
                
        endif;
            
        return $app['twig']->render('users_edit.html.twig', [
        'session'       => $adminSession,
        'usersId'       => $usersInfos['idUsers'],
        'form'          => $form->createView(),
        'usersPseudo'   => $usersInfos['pseudoUsers'],
        'erreur'        => '',
            'valid'         => '',
                'menu'           => 'users'
        ]);
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur ajouter utilisateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminUsersAdd(Application $app, Request $request, $adminSession)
    {
    $isSessionInDb = $app['idiorm.db']->for_table('admin')
    ->where('session', $adminSession)
    ->where_gt('finSession', date('Y-m-d H:i:s'))
    ->find_one();
        
        if(!$isSessionInDb):
        
            return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else:
        
            $form = $app['form.factory']->createBuilder(FormType::class)
            ->add('pseudoUsers', TextType::class, [
            'required'      =>  true,
            'label'         =>  'Pseudo*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le pseudo'
                ]
            ])
            ->add('emailUsers', EmailType::class, [
            'required'      =>  true,
            'label'         =>  'Adresse Email*',
            'constraints'   =>  array(new NotBlank()),
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez l\'email',
                'autocomplete'  => 'new-password'
                ]
            ])
            ->add('nomUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Nom',
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le nom'
                ]
            ])
            ->add('prenomUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Prénom',
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le prénom'
                ]
            ])
            ->add('adresseUsers', TextareaType::class, [
            'required'      =>  false,
            'label'         =>  'Adresse',
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez l\'adresse'
                ]
            ])
            ->add('cpUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Code Postal',
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le code postal'
                ]
            ])
            ->add('villeUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Ville',
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez la ville'
                ]
            ])
            ->add('paysUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Pays',
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le pays'
                ]
            ])
            ->add('telephoneUsers', TextType::class, [
            'required'      =>  false,
            'label'         =>  'Téléphone',
            'attr'          =>  [
                'class'         => 'form-control',
                'placeholder'   => 'Saisissez le téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
            'label'     => 'Ajouter',
            'disabled'  =>  true,
            'attr'      =>  [
                'class'     => 'btn btn-block btn-primary'
                ]
            ])
            ->getForm();
        
            $form->handleRequest($request);
        
            if($form->isValid()):
            
                $user = $form->getData();
            
                $form1 = $app['form.factory']->createBuilder(FormType::class)
                ->add('pseudoUsers', TextType::class, [
                'required'      =>  true,
                'label'         =>  'Pseudo*',
                'constraints'   =>  array(new NotBlank()),
                'attr'          =>  [
                    'class'         => 'form-control',
                    'value'         =>  $user['pseudoUsers'],
                    'placeholder'   => 'Saisissez le pseudo'
                    ]
                ])
                ->add('emailUsers', EmailType::class, [
                'required'      =>  true,
                'label'         =>  'Adresse Email*',
                'constraints'   =>  array(new NotBlank()),
                'attr'          =>  [
                    'class'         => 'form-control',
                    'value'         =>  $user['emailUsers'],
                    'placeholder'   => 'Saisissez l\'email',
                    'autocomplete'  => 'new-password'
                    ]
                ])
                ->add('nomUsers', TextType::class, [
                'required'      =>  false,
                'label'         =>  'Nom',
                'attr'          =>  [
                    'value'         =>  $user['nomUsers'],
                    'class'         => 'form-control',
                    'placeholder'   => 'Saisissez le nom'
                    ]
                ])
                ->add('prenomUsers', TextType::class, [
                'required'      =>  false,
                'label'         =>  'Prénom',
                'attr'          =>  [
                    'value'         =>  $user['prenomUsers'],
                    'class'         => 'form-control',
                    'placeholder'   => 'Saisissez le prénom'
                    ]
                ])
                ->add('adresseUsers', TextareaType::class, [
                'required'      =>  false,
                'label'         =>  'Adresse',
                'data'          => $user['adresseUsers'],
                'attr'          =>  [
                    'class'         => 'form-control',
                    'placeholder'   => 'Saisissez l\'adresse'
                    ]
                ])
                ->add('cpUsers', TextType::class, [
                'required'      =>  false,
                'label'         =>  'Code Postal',
                'attr'          =>  [
                    'value'         =>  $user['cpUsers'],
                    'class'         => 'form-control',
                    'placeholder'   => 'Saisissez le code postal'
                    ]
                ])
                ->add('villeUsers', TextType::class, [
                'required'      =>  false,
                'label'         =>  'Ville',
                'attr'          =>  [
                    'value'         =>  $user['villeUsers'],
                    'class'         => 'form-control',
                    'placeholder'   => 'Saisissez la ville'
                    ]
                ])
                ->add('paysUsers', TextType::class, [
                'required'      =>  false,
                'label'         =>  'Pays',
                'attr'          =>  [
                    'value'         =>  $user['paysUsers'],
                    'class'         => 'form-control',
                    'placeholder'   => 'Saisissez le pays'
                    ]
                ])
                ->add('telephoneUsers', TextType::class, [
                'required'      =>  false,
                'label'         =>  'Téléphone',
                'attr'          =>  [
                    'value'         =>  $user['telephoneUsers'],
                    'class'         => 'form-control',
                    'placeholder'   => 'Saisissez le téléphone'
                    ]
                ])
                ->add('submit', SubmitType::class, [
                'label'         => 'Ajouter',
                'disabled'  => true,
                'attr'          =>  [
                    'class'         => 'btn btn-block btn-primary'
                    ]
                ])
                ->getForm();
                
                # ------------------------------------------------------------ #
                # Controle des champs avec indications erreur (a faire)
                # ------------------------------------------------------------ #
                $erreurAjout = [];
                
                if($app['idiorm.db']->for_table('users')->where('pseudo', $user['pseudoUsers'])->find_one()):
                
                $erreurAjout[] = 'Le pseudo que vous avez saisi existe déjà !';
                
                endif;
                
                if($app['idiorm.db']->for_table('users')->where('email', $user['emailUsers'])->find_one()):
                
                $erreurAjout[] = 'L\'adresse email que vous avez saisi existe déjà !';
                
                endif;
                
            
                if(count($erreurAjout) == 0):
                
                    $usersDb1 = $app['idiorm.db']->for_table('users')->create();
                    $usersDb1->email        = $user['emailUsers'];
                    $usersDb1->pseudo       = $user['pseudoUsers'];
                    $usersDb1->role         = '9';
                    $usersDb1->save();
                    
                    $idUserDb = $app['idiorm.db']->for_table('users')->where('email',$user['emailUsers'])->find_one();
                    
                    $usersDb2 = $app['idiorm.db']->for_table('usersDetails')->create();
                    $usersDb2->idUsers      = $idUserDb['idUsers'];
                    $usersDb2->nom          = $user['nomUsers'];
                    $usersDb2->prenom       = $user['prenomUsers'];
                    $usersDb2->adresse      = $user['adresseUsers'];
                    $usersDb2->cp           = $user['cpUsers'];
                    $usersDb2->ville        = $user['villeUsers'];
                    $usersDb2->pays         = $user['paysUsers'];
                    $usersDb2->telephone    = $user['telephoneUsers'];
                    $usersDb2->save();
                
                    if(!$usersDb1 || !$usersDb2):
                    
                        $erreurAjout[] = 'Erreur d\'enregistrement dans la base de données ! Contactez ONLGSP.';
                    
                        return $app['twig']->render('users_add.html.twig', [
                        'form'      => $form1->createView(),
                        'erreur'    => $erreurAjout,
                        'valid'     => '',
                            'session'   => $adminSession,
                            'menu'           => 'users'
                        ]);
                    
                    else:
                    
                        return $app['twig']->render('users_add.html.twig', [
                        'form'      => $form->createView(),
                        'erreur'    => '',
                        'valid'     => 'Nouveau utilisateur enregistré avec succès ! ',
                            'session'   => $adminSession,
                            'menu'           => 'users'
                        ]);
                    
                    endif;
                
                else:
                
                    return $app['twig']->render('users_add.html.twig', [
                    'form'      => $form1->createView(),
                    'erreur'    => $erreurAjout,
                    'valid'     => '',
                        'session'   => $adminSession,
                        'menu'           => 'users'
                    ]);
                
                endif;
            
            endif;
        
            return $app['twig']->render('users_add.html.twig', [
            'form'      => $form->createView(),
            'erreur'    => '',
            'valid'     => '',
                'session'   => $adminSession,
                'menu'           => 'users'
            ]);
        
        endif;  
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur supprimer utilisateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminUsersDel(Application $app, $adminSession, $usersId)
    {
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else:
        
        $delUser = $app['idiorm.db']->for_table('users')->use_id_column('idUsers')->find_one($usersId);
        $delUser->delete();
        
        return $app->redirect( $app['url_generator']->generate('admin_users', array('adminSession' => $adminSession)) );
        
        endif;
        
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur activer utilisateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminUsersActive(Application $app, $adminSession, $usersId)
    {
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else:
        
        $userBd1 = $app['idiorm.db']->for_table('users')->use_id_column('idUsers')->find_one($usersId);
        $userBd1->set('actif', '1');
        $userBd1->save();
        
        return $app->redirect( $app['url_generator']->generate('admin_users', array('adminSession' => $adminSession)) );
        
        endif;
        
    }
    
    
    # --------------------------------------------------------------------------------------------------------------------------- #
    # Controlleur activer utilisateur
    # --------------------------------------------------------------------------------------------------------------------------- #
    public function adminUsersDesactive(Application $app, $adminSession, $usersId)
    {
        $isSessionInDb = $app['idiorm.db']->for_table('admin')
        ->where('session', $adminSession)
        ->where_gt('finSession', date('Y-m-d H:i:s'))
        ->find_one();
        
        if(!$isSessionInDb):
        
        return $app->redirect( $app['url_generator']->generate('admin_connexion') );
        
        else:
        
        $userBd1 = $app['idiorm.db']->for_table('users')->use_id_column('idUsers')->find_one($usersId);
        $userBd1->set('actif', '0');
        $userBd1->save();
        
        return $app->redirect( $app['url_generator']->generate('admin_users', array('adminSession' => $adminSession)) );
        
        endif;
        
    }
    
}

