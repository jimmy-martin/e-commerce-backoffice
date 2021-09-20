<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController
{
    /**
     * List all users
     *
     * @return void
     */
    public function list()
    {
        $users = AppUser::findAll();

        $this->checkAuthorization(['admin']);

        $this->show('user/list', [
            'users' => $users
        ]);
    }

    /**
     * Formulaire d'ajout d'un utilisateur
     *
     * @return void
     */
    public function add()
    {
        $this->checkAuthorization(['admin']);

        $this->show('user/add');
    }

    /**
     * Ajout d'un utilisateur
     *
     * @return void
     */
    public function create()
    {
        $this->checkAuthorization(['admin']);

        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        $errors = [];
        if (!$lastname) {
            $errors[] = 'Nom de famille absent ou incorrect';
        }
        if (!$firstname) {
            $errors[] = 'Prénom absent ou incorrect';
        }
        if (!$email) {
            $errors[] = 'Email absent ou incorrect';
        }
        if (!$password) {
            $errors[] = 'Mot de passe absent ou incorrect';
        }
        if (!$status) {
            $errors[] = 'Status absent ou incorrect';
        }
        if (!$role) {
            $errors[] = 'Role absent ou incorrect';
        }

        if (empty($errors)) {

            $user = new AppUser();

            $user->setLastname($lastname);
            $user->setFirstname($firstname);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setStatus($status);
            $user->setRole($role);

            $result = $user->save();

            if ($result) {
                header('Location: /user/list');
                exit;
            } else {
                $errors[] = 'Erreur lors de l\'ajout de ce nouvel utilisateur dans la base de données!';
                $this->show('user/add', [
                    'errors' => $errors
                ]);
                exit;
            }
        } else {
            $this->show('user/add', [
                'errors' => $errors
            ]);
            exit;
        }
    }
}