<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Session;

class AuthController extends Controller
{
    public function isLoggedIn(): bool
    {
        return Session::has('user_id');
    }
}
