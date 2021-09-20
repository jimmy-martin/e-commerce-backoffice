<?php

namespace App\Controllers;

use App\Models\AppUser;

class LoginController extends CoreController
{
    /**
     * Afficher le formulaire de connexion
     *
     * @return void
     */
    public function connect()
    {
        $this->show('login/form');
    }

    /**
     * Récupération des données du formulaire
     *
     * @return void
     */
    public function authenticate()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $errors = [];
        if (!$email) {
            $errors[] = 'Email absent ou incorrect';
        }
        if (!$password) {
            $errors[] = 'Mot de passe absent ou incorrect';
        }

        if (empty($errors)){
            $user = AppUser::findByEmail($email);

            // Jé verifie si j'ai bien un utilisateur avec cet email et ce mot de passe
            if($user && $user->getPassword() === $password){
                // echo 'Tout est bon !';
                $_SESSION['userId'] = $user->getId();
                $_SESSION['userObject'] = $user;
                header('Location: /');
                exit;
            } else {
                echo 'L\'email ou le mot de passe renseignés sont incorrects !';
            }
        } else {

            $this->show('login/form', [
                'errors' => $errors
            ]);
        }
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @return void
     */
    public function disconnect()
    {
        // TODO
    }
}