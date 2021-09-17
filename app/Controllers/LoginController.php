<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Models\CoreModel;

class LoginController extends CoreController
{
    public function connection()
    {
        $this->show('login/form');
    }

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
                echo 'Tout est bon !';
            } else {
                echo 'L\'email ou le mot de passe renseignés sont incorrects !';
            }
        } else {
            echo 'Certaines données sont manquantes ou incorrectes !';
            foreach ($errors as $value) {
                echo "<div>$value</div>";
            }
        }
    }
}