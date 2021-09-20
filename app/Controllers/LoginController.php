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
            $errors[] = 'Email non renseigné';
        }
        if (!$password) {
            $errors[] = 'Mot de passe non renseigné';
        }

        if(!empty($errors)){
            $this->show('login/form', [
                'errors' => $errors
            ]);
        }

        $user = AppUser::findByEmail($email);

        if ($user) {
            // Jé verifie si l'utilisateur que j'ai trouve a le meme mot de passe que celui rentre par l'utilisateur dans le formulaire
            $isPassCorrect = password_verify($password, $user->getPassword());
        } else {
            $isPassCorrect = false;
        }

        if ($isPassCorrect) {
            $_SESSION['userId'] = $user->getId();
            $_SESSION['userObject'] = $user;
            header('Location: /');
            exit;
        } else {
            $errors[] = 'L\'email ou le mot de passe renseignés sont incorrects !';
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
