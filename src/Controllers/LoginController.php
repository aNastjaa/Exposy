<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Util;
use Crmlva\Exposy\Validators\Validation;
use Crmlva\Exposy\View;

class LoginController extends Controller
{
    private Validation $validator;

    public function __construct()
    {
        $this->validator = new Validation();
    }

    public function handleLogin(): void
    {
        $errors = Session::get('errors', []);
        $status_message = Session::get('status_message', '');
        $submitted_data = Session::get('submitted_data', []);

        if (!$this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            Session::clear('errors');
            Session::clear('status_message');
            Session::clear('submitted_data');
            new View('auth', 'login', [
                'errors' => $errors,
                'status_message' => $status_message,
                'submitted_data' => $submitted_data
            ]);
            return;
        }

        $data = $this->getData();

        if (!$this->validateLogin($data)) {
            Session::set('errors', $this->validator->getErrors());
            Session::set('status_message', 'Please correct the errors and try again');
            Session::set('submitted_data', $data);
            $this->redirect('/login');
            return;
        }

        if ($this->compareCredentials($data['email'] ?? '', $data['password'] ?? '')) {
            $userModel = new User();
            $user = $userModel->getByEmail($data['email']);
            $userId = $user ? $user['id'] : null;

            if ($userId) {
                Session::set('status_message', 'Login successful');
                Session::set('user_id', $userId);
                $this->redirect('/account');
            } else {
                Session::set('errors', ['email' => 'Invalid email or password']);
                Session::set('status_message', 'Login failed. Invalid credentials');
                Session::set('submitted_data', $data);
                $this->redirect('/login');
            }
        } else {
            Session::set('errors', ['email' => 'Invalid email or password']);
            Session::set('status_message', 'Login failed. Invalid credentials');
            Session::set('submitted_data', $data);
            $this->redirect('/login');
        }
    }

    private function compareCredentials(string $email, string $password): bool
    {
        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user) {
            return Util::verifyPassword($password, $user['password']);
        }

        return false;
    }

    private function validateLogin(array $data): bool
    {
        $this->validator->clearErrors();

        $isValid = true;
        $isValid &= $this->validator->validateEmail($data['email'] ?? null);
        $isValid &= $this->validator->validatePassword($data['password'] ?? null);

        return $isValid;
    }
}
