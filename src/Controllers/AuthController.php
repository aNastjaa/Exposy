<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Session;

class AuthController extends Controller {

    public array $errors = [];

    public function isLoggedIn(): bool
    {
        return Session::has('user_id'); // Check if 'user_id' is present in the session
    }
}

