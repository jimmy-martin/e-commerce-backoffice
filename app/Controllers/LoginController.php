<?php

namespace App\Controllers;

use App\Models\CoreModel;

class LoginController extends CoreController
{
    public function connection()
    {
        $this->show('login/form');
    }
}