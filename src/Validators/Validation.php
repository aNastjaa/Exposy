<?php

namespace Crmlva\Exposy\Validators;

use Crmlva\Exposy\Enums\GenderEnum;
use Crmlva\Exposy\Enums\CountryEnum;
use Crmlva\Exposy\Models\User;

class Validation
{
    private array $errors = [];

    /**
     * Validates a string field based on minimum and maximum length constraints.
     *
     * @param string|null $field_value
     * @param string $field_name
     * @param int $min_length
     * @param int $max_length
     * @return bool
     */
    public function validateStringField(?string $field_value, string $field_name, int $min_length, int $max_length): bool
    {
        if (is_null($field_value) || trim($field_value) === '') {
            $this->errors[$field_name][] = "Please enter your $field_name.";
        } else {
            if (strlen($field_value) < $min_length) {
                $this->errors[$field_name][] = "$field_name must be at least $min_length characters long.";
            }
            if (strlen($field_value) > $max_length) {
                $this->errors[$field_name][] = "$field_name must not exceed $max_length characters.";
            }
            if (preg_match('/\s/', $field_value)) {
                $this->errors[$field_name][] = "$field_name must not contain spaces.";
            }
        }

        return empty($this->errors[$field_name]);
    }

    /**
     * Validates the email format.
     *
     * @param string|null $email
     * @return bool
     */
    public function validateEmail(?string $email): bool
    {
        if (is_null($email) || trim($email) === '') {
            $this->errors['email'][] = 'Please enter your email.';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'][] = 'Please enter a valid email address.';
            }
        }

        return empty($this->errors['email']);
    }

    /**
     * Validates a password against security and complexity criteria.
     *
     * @param string|null $password
     * @return bool
     */
    public function validatePassword(?string $password): bool
    {
        return $this->checkPasswordCriteria($password, 'password');
    }

    /**
     * Validates a new password against security and complexity criteria.
     *
     * @param string|null $new_password
     * @return bool
     */
    public function validateNewPassword(?string $new_password): bool
    {
        return $this->checkPasswordCriteria($new_password, 'new-password');
    }

    /**
     * Checks password criteria including length, character variety, and lack of spaces.
     *
     * @param string|null $password
     * @param string $field_name
     * @return bool
     */
    private function checkPasswordCriteria(?string $password, string $field_name): bool
    {
        if (is_null($password) || trim($password) === '') {
            $this->errors[$field_name][] = "Please enter your $field_name.";
        } else {
            if (strlen($password) < 8) {
                $this->errors[$field_name][] = 'Password must be at least 8 characters long.';
            }
            if (!preg_match('/[a-z]/', $password)) {
                $this->errors[$field_name][] = 'Password must contain at least one lowercase letter.';
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $this->errors[$field_name][] = 'Password must contain at least one uppercase letter.';
            }
            if (!preg_match('/[0-9]/', $password)) {
                $this->errors[$field_name][] = 'Password must contain at least one number.';
            }
            if (!preg_match('/[\W_]/', $password)) {
                $this->errors[$field_name][] = 'Password must contain at least one special character.';
            }
            if (preg_match('/\s/', $password)) {
                $this->errors[$field_name][] = 'Password must not contain spaces.';
            }
        }

        return empty($this->errors[$field_name]);
    }

    /**
     * Validates password and its confirmation match.
     *
     * @param string|null $password
     * @param string|null $password_repeat
     * @return bool
     */
    public function validatePasswordRepeat(?string $password, ?string $password_repeat): bool
    {
        if ($password !== $password_repeat) {
            $this->errors['password_repeat'][] = 'Passwords do not match.';
        }

        return empty($this->errors['password_repeat']);
    }

    /**
     * Validates old password against the stored password in the database.
     *
     * @param string|null $old_password
     * @param int $user_id
     * @return bool
     */
    public function validateOldPassword(?string $old_password, int $user_id): bool
    {
        if (is_null($old_password) || trim($old_password) === '') {
            $this->errors['old_password'][] = 'Please enter your old password.';
            return false;
        }

        $user = new User();
        $user = $user->find($user_id);

        if (!$user || !password_verify($old_password, $user->password)) {
            $this->errors['old_password'][] = 'Old password is incorrect.';
            return false;
        }

        return true;
    }

    /**
     * Validates gender against available options using GenderEnum.
     *
     * @param string|null $gender
     * @return bool
     */
    public function validateGender(?string $gender): bool
    {
        if (is_null($gender) || trim($gender) === '') {
            $this->errors['gender'][] = 'Please select a gender.';
        } elseif (!in_array($gender, GenderEnum::getAll(), true)) {
            $this->errors['gender'][] = 'Please select a valid gender.';
        }

        return empty($this->errors['gender']);
    }

    /**
     * Validates country against available options using CountryEnum.
     *
     * @param string|null $country
     * @return bool
     */
    public function validateCountry(?string $country): bool
    {
        if (is_null($country) || $country === 'none') {
            $this->errors['country'][] = 'Please select a country.';
        } elseif (!in_array($country, CountryEnum::getAll(), true)) {
            $this->errors['country'][] = 'Please select a valid country.';
        }

        return empty($this->errors['country']);
    }

    /**
     * Validates acceptance of terms.
     *
     * @param string|null $terms
     * @return bool
     */
    public function validateTerms(?string $terms): bool
    {
        if (is_null($terms) || trim($terms) === '') {
            $this->errors['terms'][] = 'You must agree to the terms of service.';
        }

        return empty($this->errors['terms']);
    }

    /**
     * Clears all validation errors.
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Retrieves all validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Adds an error message for a specific field.
     *
     * @param string $field
     * @param string $message
     */
    public function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}

