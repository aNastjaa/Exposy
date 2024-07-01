<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
}

$errors = [];
$status_message = '';

function validate_name_fields(?string $field_value, string $field_name): bool {
    global $errors;

    if (is_null($field_value) || empty($field_value)) {
        $errors[$field_name][] = "Please enter your $field_name";
    } else {
        if (strlen($field_value) < 4) {
            $errors[$field_name][] = "$field_name must be at least 4 characters long";
        }
        if (strlen($field_value) > 16) {
            $errors[$field_name][] = "$field_name must not exceed 16 characters";
        }
        if (preg_match('/\s/', $field_value)) {
            $errors[$field_name][] = "$field_name must not contain spaces";
        }
    }

    return !isset($errors[$field_name]) || count($errors[$field_name]) === 0;
}

function validate_email(?string $email): bool {
    global $errors;

    if (is_null($email) || empty($email)) {
        $errors['email'][] = 'Please enter your email';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'Please enter a valid email address';
        }
    }

    return !isset($errors['email']) || count($errors['email']) === 0;
}

function validate_password(?string $password): bool {
    global $errors;

    if (is_null($password) || empty($password)) {
        $errors['password'][] = 'Please enter your password';
    } else {
        if (strlen($password) < 8) {
            $errors['password'][] = 'Password must be at least 8 characters long';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors['password'][] = 'Password must contain at least one lowercase letter';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors['password'][] = 'Password must contain at least one uppercase letter';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors['password'][] = 'Password must contain at least one number';
        }
        if (!preg_match('/[\W_]/', $password)) {
            $errors['password'][] = 'Password must contain at least one special character';
        }
        if (preg_match('/\s/', $password)) {
            $errors['password'][] = 'Password must not contain spaces';
        }
    }

    return !isset($errors['password']) || count($errors['password']) === 0;
}

function validate_sex(?string $sex): bool {
    global $errors;

    if (is_null($sex)) {
        $errors['sex'][] = 'Please select a gender';
    } elseif (!in_array($sex, ['Male', 'Female', 'Diverse'])) {
        $errors['sex'][] = 'Please select a valid gender';
    }

    return !isset($errors['sex']) || count($errors['sex']) === 0;
}

function validate_country(?string $country): bool {
    global $errors;

    $valid_countries = [
        "Germany", "Austria", "Belgium", "Czech Republic", "Denmark", "France",
        "Hungary", "Italy", "Luxembourg", "Netherlands", "Poland", "Slovakia",
        "Switzerland", "Liechtenstein", "Slovenia", "Croatia"
    ];

    if (is_null($country) || $country === 'none') {
        $errors['country'][] = 'Please select a country';
    } elseif (!in_array($country, $valid_countries)) {
        $errors['country'][] = 'Please select a valid country';
    }

    return !isset($errors['country']) || count($errors['country']) === 0;
}

function validate_terms(?string $terms): bool {
    global $errors;

    if (is_null($terms)) {
        $errors['terms'][] = 'You must agree to the terms of service';
    }

    return !isset($errors['terms']) || count($errors['terms']) === 0;
}

$firstname_input = filter_input(INPUT_POST, 'firstname');
$lastname_input = filter_input(INPUT_POST, 'lastname');
$sex_input = filter_input(INPUT_POST, 'sex');
$country_input = filter_input(INPUT_POST, 'country');
$city_input = filter_input(INPUT_POST, 'city');
$email_input = filter_input(INPUT_POST, 'email');
$password_input = filter_input(INPUT_POST, 'pwd');
$terms_input = filter_input(INPUT_POST, 'terms');

$validate_firstname = validate_name_fields($firstname_input, 'firstname');
$validate_lastname = validate_name_fields($lastname_input, 'lastname');
$validate_sex = validate_sex($sex_input);
$validate_country = validate_country($country_input);
$validate_city = validate_name_fields($city_input, 'city');
$validate_email = validate_email($email_input);
$validate_password = validate_password($password_input);
$validate_terms = validate_terms($terms_input);

if (
    $validate_firstname && $validate_lastname && $validate_sex &&
    $validate_country && $validate_city && $validate_email &&
    $validate_password && $validate_terms
) {
    $status_message = "Form submitted successfully";
} else {
    $status_message = "Please fill out all fields correctly and try again";
}

$_SESSION['status_message'] = $status_message;
$_SESSION['errors'] = $errors;
