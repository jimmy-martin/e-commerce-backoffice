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
}