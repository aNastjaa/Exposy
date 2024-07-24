<?php

namespace Crmlva\Exposy\Validators;

use Crmlva\Exposy\Enums\GenderEnum;
use Crmlva\Exposy\Enums\CountryEnum;

class Validation {
    private array $errors = [];

    public function validateStringField(?string $field_value, string $field_name, int $min_length, int $max_length): bool {
        if (is_null($field_value) || empty($field_value)) {
            $this->errors[$field_name][] = "Please enter your $field_name";
        } else {
            if (strlen($field_value) < $min_length) {
                $this->errors[$field_name][] = "$field_name must be at least $min_length characters long";
            }
            if (strlen($field_value) > $max_length) {
                $this->errors[$field_name][] = "$field_name must not exceed $max_length characters";
            }
            if (preg_match('/\s/', $field_value)) {
                $this->errors[$field_name][] = "$field_name must not contain spaces";
            }
        }

        return !isset($this->errors[$field_name]) || count($this->errors[$field_name]) === 0;
    }

    public function validateEmail(?string $email): bool {
        if (is_null($email) || empty($email)) {
            $this->errors['email'][] = 'Please enter your email';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'][] = 'Please enter a valid email address';
            }
        }

        return !isset($this->errors['email']) || count($this->errors['email']) === 0;
    }

    public function validatePassword(?string $password): bool {
        if (is_null($password) || empty($password)) {
            $this->errors['password'][] = 'Please enter your password';
        } else {
            if (strlen($password) < 8) {
                $this->errors['password'][] = 'Password must be at least 8 characters long';
            }
            if (!preg_match('/[a-z]/', $password)) {
                $this->errors['password'][] = 'Password must contain at least one lowercase letter';
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $this->errors['password'][] = 'Password must contain at least one uppercase letter';
            }
            if (!preg_match('/[0-9]/', $password)) {
                $this->errors['password'][] = 'Password must contain at least one number';
            }
            if (!preg_match('/[\W_]/', $password)) {
                $this->errors['password'][] = 'Password must contain at least one special character';
            }
            if (preg_match('/\s/', $password)) {
                $this->errors['password'][] = 'Password must not contain spaces';
            }
        }

        return !isset($this->errors['password']) || count($this->errors['password']) === 0;
    }

    public function validatePasswordRepeat(?string $password, ?string $password_repeat): bool {
        if ($password !== $password_repeat) {
            $this->errors['password_repeat'][] = 'Passwords do not match';
        }

        return !isset($this->errors['password_repeat']) || count($this->errors['password_repeat']) === 0;
    }

    public function validateSex(?string $sex): bool {
        if (is_null($sex)) {
            $this->errors['sex'][] = 'Please select a gender';
        } elseif (!in_array($sex, GenderEnum::getAll())) {
            $this->errors['sex'][] = 'Please select a valid gender';
        }

        return !isset($this->errors['sex']) || count($this->errors['sex']) === 0;
    }

    public function validateCountry(?string $country): bool {
        if (is_null($country) || $country === 'none') {
            $this->errors['country'][] = 'Please select a country';
        } elseif (!in_array($country, CountryEnum::getAll())) {
            $this->errors['country'][] = 'Please select a valid country';
        }

        return !isset($this->errors['country']) || count($this->errors['country']) === 0;
    }

    public function validateTerms(?string $terms): bool {
        if (is_null($terms)) {
            $this->errors['terms'][] = 'You must agree to the terms of service';
        }

        return !isset($this->errors['terms']) || count($this->errors['terms']) === 0;
    }

    public function clearErrors(): void {
        $this->errors = [];
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
