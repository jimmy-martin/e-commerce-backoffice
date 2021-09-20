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

        if (!empty($errors)) {
            $this->show('login/form', [
                'errors' => $errors
            ]);
            exit;
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

            // on redirige vers la page d'accueil si l'utilisateur est bien connecté
            global $router;
            header('Location: ' . $router->generate('main-home'));
            exit;
        } else {
            $errors[] = 'L\'email ou le mot de passe renseignés sont incorrects !';
            $this->show('login/form', [
                'errors' => $errors
            ]);
            exit;
        }
    }

    /**
     * Déconnecter un utilisateur
     *
     * @return void
     */
    public function disconnect()
    {
        // on vide le tableau $_SESSION
        $_SESSION = [];

        session_destroy();

        // puisque l'utilisateur n'est plus identifiable et qu'on est sur un Back Office
        // on le redirige vers le formulaire d'identification
        global $router;
        header('Location: ' . $router->generate('login-connect'));
        exit;
    }
}
