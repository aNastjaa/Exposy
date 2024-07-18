<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;

class AuthController extends Controller {

    public array $errors = [];

    public function isLoggedIn() : bool
    {
        return false;
    }

}