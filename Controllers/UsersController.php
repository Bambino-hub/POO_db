<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{

    public function login()
    {
        // on verifie si le formulaire est complet
        if (Form::validate($_POST, ['email', 'password'])) {
            // si le formulaire est complet 
            // on va chercher dans la base de donnée l'email de l'utilisateur
            $usermodel = new UsersModel;
            $user1 = $usermodel->findOneByEmail(strip_tags($_POST['email']));

            // si l'utilisateur n'existe pas 
            if (!$user1) {
                // on envoie un message de session 
                $_SESSION['erreur'] = "l'adress email et / ou le mot de passe est incorrect";
                header('Location: index.php?p=users/login');
                exit;
            }

            //si l'utilisateur exite
            // on hydrate l'utilisateur
            $user = $usermodel->hydrate($user1);

            // on verifie si le mot de passe est correct 
            if (password_verify($_POST['password'], $user->getPassword())) {
                // si le mot de passe est bon , on cree la session
                $user->setSession();

                
                header('Location: index.php?p=annonce/index');
            } else {
                $_SESSION['erreur'] = "l'adress email et / ou le mot de passe est incorrect";
                header('Location: index.php?p=users/login');
                exit;
            }
        }
        $form = new Form;
        $form->beginForm()
            ->addLabel('email', 'E-mail:')
            ->addInput('email', 'email', 'email', '', [
                'class' => 'form-control',

            ])
            ->addLabel('password', 'password',)
            ->addInput('password', 'password',  'password', '', [
                'class' => 'form-control',

            ])
            ->addbutton('submit', [
                'class' => 'btn btn-primary',
            ])
            ->endForm();

        // var_dump($form);
        $this->render('users/login.php', ['loginForm' => $form->create()]);
    }

    /**
     * function to logout user
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    /**
     * registration for users
     *
     * @return void
     */
    public function register()
    {
        // we verified if form isvalid
        if (Form::validate($_POST, ['email', 'password'])) {
            // si le formulaire est valide 
            // on netoye l'email
            $email = strip_tags($_POST['email']);

            // on chiffre le not de pass
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // on hydrate l'utlisatuer
            $user = new UsersModel;
            $user->setEmail($email)
                ->setPassword($password);

            // on stock l'utilisateur
            $user->create();
        }
        $form = new Form;
        $form->beginForm()
            ->addLabel('email', 'E-mail')
            ->addInput('email', 'email', 'email', '', [
                'class' => 'form-control',

            ])
            ->addLabel('password', 'password',)
            ->addInput('password', 'password', 'password', '', [
                'class' => 'form-control',

            ])
            ->addbutton('submit', [
                'class' => 'btn btn-primary',
            ])
            ->endForm();
        $this->render('users/register.php', ['registerForm' => $form->create()]);
    }
}
