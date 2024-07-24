<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Util;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\View;
use Crmlva\Exposy\Validators\Validation;

class UserController extends Controller
{
    private Validation $validator;

    public function __construct()
    {
        $this->validator = new Validation();
    }

    protected function compareCredentials(string $email, string $password): bool
    {
        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user) {
            return Util::verifyPassword($password, $user['password']);
        }

        return false;
    }

    protected function validateRegister(array $data): bool
    {
        $isValid = true;

        // Validate each field
        $isValid &= $this->validator->validateStringField($data['username'] ?? null, 'username', 3, 50);
        $isValid &= $this->validator->validateEmail($data['email'] ?? null);
        $isValid &= $this->validator->validatePassword($data['password'] ?? null);
        $isValid &= $this->validator->validatePasswordRepeat($data['password'] ?? null, $data['pwd_rep'] ?? null);
        $isValid &= $this->validator->validateTerms($data['terms'] ?? null);

        return $isValid;
    }

    public function register(): void
    {
        // Get any existing errors and status messages from the session
        $errors = Session::get('errors', []);
        $status_message = Session::get('status_message', '');
        $submitted_data = Session::get('submitted_data', []);

        if (!$this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            // Render the registration page if it's not a POST request
            // Clear the errors and submitted data after rendering
            Session::clear('errors');
            Session::clear('status_message');
            Session::clear('submitted_data');
            $view = new View('layout', 'register', ['errors' => $errors, 'status_message' => $status_message, 'submitted_data' => $submitted_data]);
            return;
        }

        $data = $this->getData();

        if ($this->validateRegister($data)) {
            // If valid, proceed with registration logic
            $userModel = new User();
            $userId = $userModel->create(
                $data['username'],
                $data['email'],
                $data['password']
            );

            if ($userId) {
                Session::set('status_message', 'Registration successful. Please log in.');
                $this->redirect('/login');
            } else {
                Session::set('status_message', 'Registration failed. Please try again.');
                $this->redirect('/register');
            }
        } else {
            // Validation failed, set errors and submitted data in session and redirect back to registration page
            Session::set('errors', $this->validator->getErrors());
            Session::set('status_message', 'Please correct the errors and try again');
            Session::set('submitted_data', $data); // Store the submitted data
            $this->redirect('/register');
        }
    }

    public function login(): void
    {
        // Get any existing errors and status messages from the session
        $errors = Session::get('errors', []);
        $status_message = Session::get('status_message', '');
        $submitted_data = Session::get('submitted_data', []);

        if (!$this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            // Render the login page if it's not a POST request
            // Clear the errors and submitted data after rendering
            Session::clear('errors');
            Session::clear('status_message');
            Session::clear('submitted_data');
            $view = new View('layout', 'login', ['errors' => $errors, 'status_message' => $status_message, 'submitted_data' => $submitted_data]);
            return;
        }

        $data = $this->getData();

        if ($this->compareCredentials($data['email'] ?? '', $data['password'] ?? '')) {
            // Handle successful login
            Session::set('status_message', 'Login successful');
            Session::set('user_id', $data['email']); // Replace with actual user ID from DB
            $this->redirect('/account'); // Redirect to a user account page or dashboard
        } else {
            Session::set('status_message', 'Login failed. Invalid credentials');
            $this->redirect('/login');
        }
    }

    public function isLoggedIn(): bool
    {
        return Session::has('user_id'); // Assuming 'user_id' is set in session upon successful login
    }
}
