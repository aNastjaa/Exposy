<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Models\User;

class AuthController extends Controller {

    public array $errors = [];

    public function isLoggedIn(): bool
    {
        return Session::has('user_id');
    }

    public function login(array $data): bool
    {
        $email = $data['email'] ?? null;
        $password = $data['pwd'] ?? null;

        if (!$email || !$password) {
            $this->errors['login'] = 'Email and password are required.';
            return false;
        }

        $user = User::findByEmail($email);
        if (!$user || !$user->verifyPassword($password)) {
            $this->errors['login'] = 'Invalid email or password.';
            return false;
        }

        Session::set('user_id', $user->id);
        return true;
    }
}
