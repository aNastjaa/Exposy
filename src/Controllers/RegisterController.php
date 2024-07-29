<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Validators\Validation;
use Crmlva\Exposy\View;

class RegisterController extends Controller
{
    private Validation $validator;

    public function __construct()
    {
        $this->validator = new Validation();
    }

    public function handleRegistration(): void
    {
        $errors = [];
        $submitted_data = [];

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $submitted_data = $this->getData();
            $isValid = $this->validateRegister($submitted_data);

            if ($isValid) {
                $userModel = new User();

                // Check for existing username or email
                if ($userModel->getByUsername($submitted_data['username'])) {
                    $this->validator->addError('username', 'This username is already taken.');
                    $isValid = false;
                }
                if ($userModel->getByEmail($submitted_data['email'])) {
                    $this->validator->addError('email', 'This email is already registered.');
                    $isValid = false;
                }

                if ($isValid) {
                    $createResult = $userModel->create(
                        $submitted_data['username'],
                        $submitted_data['email'],
                        $submitted_data['password']
                    );

                    if (is_numeric($createResult)) {
                        Session::set('status_message', 'Registration successful. Please log in.');
                        $this->redirect('/login');
                        return;
                    } else {
                        $errors['general'] = 'An error occurred while creating the account.';
                    }
                } else {
                    $errors = $this->validator->getErrors();
                }
            } else {
                $errors = $this->validator->getErrors();
            }
        }

        $this->showRegistrationForm($submitted_data, $errors);
    }

    private function showRegistrationForm(array $submitted_data = [], array $errors = []): void
    {
        new View('auth', 'register', [
            'errors' => $errors,
            'submitted_data' => $submitted_data
        ]);
    }

    private function validateRegister(array $data): bool
    {
        $this->validator->clearErrors();
        $this->validator->validateStringField($data['username'] ?? null, 'username', 3, 20);
        $this->validator->validateEmail($data['email'] ?? null);
        $this->validator->validatePassword($data['password'] ?? null);
        $this->validator->validatePasswordRepeat($data['password'] ?? null, $data['pwd_rep'] ?? null);
        $this->validator->validateTerms($data['terms'] ?? null);

        return empty($this->validator->getErrors());
    }
}
