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
        $this->checkAuthorization(['admin', 'superadmin']);

        $users = AppUser::findAll();

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
        $this->checkAuthorization(['admin', 'superadmin']);

        $this->show('user/add', [
            'user' => new AppUser(),
        ]);
    }

    /**
     * Ajout d'un utilisateur
     *
     * @return void
     */
    public function create()
    {
        $this->checkAuthorization(['admin', 'superadmin']);

        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        // On va imposer un mot de passe avec des caracteres et une longueur spécifiques
        /* 
        On veut au moins:
        - une lettre en minuscule
        - une lettre en majuscule
        - un chiffre
        - un caractère spécial
        - 8 caractères
        */ 
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/m";

        $password = filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $regex]]);

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

        $user = new AppUser();

        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setStatus($status);
        $user->setRole($role);

        if (empty($errors)) {
            $result = $user->save();

            if ($result) {
                header('Location: /user/list');
                exit;
            } else {
                $errors[] = 'Erreur lors de l\'ajout de ce nouvel utilisateur dans la base de données!';
                $this->show('user/add', [
                    'errors' => $errors,
                    'user' => $user
                ]);
                exit;
            }
        } else {
            $this->show('user/add', [
                'errors' => $errors,
                'user' => $user
            ]);
            exit;
        }
    }

    /**
     * Displays form to edit an user
     *
     * @param $id user' id
     * @return void
     */
    public function update($id)
    {
        $this->checkAuthorization(['admin', 'superadmin']);
        
        $user = AppUser::find($id);        

        $this->show('user/add', [
            'user' => $user
        ]);
    }

    /**
     * Modifier un utilisateur
     *
     * @return void
     */
    public function edit($id)
    {
        $this->checkAuthorization(['admin', 'superadmin']);

        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        // On va imposer un mot de passe avec des caracteres et une longueur spécifiques
        /* 
        On veut au moins:
        - une lettre en minuscule
        - une lettre en majuscule
        - un chiffre
        - un caractère spécial
        - 8 caractères
        */ 
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/m";

        $password = filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $regex]]);

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

            $user = AppUser::find($id);

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
                $errors[] = 'Erreur lors de la modification de cet utilisateur dans la base de données!';
                $this->show('user/add', [
                    'errors' => $errors,
                    'user' => AppUser::find($id)
                ]);
                exit;
            }
        } else {
            $this->show('user/add', [
                'errors' => $errors,
                'user' => AppUser::find($id)
            ]);
            exit;
        }
    }

    /**
     * Delete an user into the database
     *
     * @param $id user' id
     * @return void
     */
    public function delete($id)
    {
        $this->checkAuthorization(['admin', 'superadmin']);

        $user = AppUser::find($id);

        if($user){

            $result = $user->delete();
    
            if ($result) {
                header('Location: /user/list');
                exit;
            } else {
                echo 'Une erreur s\'est produite !';
            }
        } else {
            $this->show('error/err404');
        }
    }
}
