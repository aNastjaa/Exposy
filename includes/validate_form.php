<?php
// Function to sanitize and validate input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Validate and sanitize each input field
$errors = [];

// First name validation
if (isset($_POST['firstname'])) {
    $firstname = sanitizeInput($_POST['firstname']);
    if (!preg_match('/^[a-zA-Z]{4,16}$/', $firstname)) {
        $errors['firstname'] = "Invalid first name. Must be 4-16 characters long and contain only letters.";
    }
} else {
    $errors['firstname'] = "First name is required.";
}

// Last name validation
if (isset($_POST['lastname'])) {
    $lastname = sanitizeInput($_POST['lastname']);
    if (!preg_match('/^[a-zA-Z]{4,16}$/', $lastname)) {
        $errors['lastname'] = "Invalid last name. Must be 4-16 characters long and contain only letters.";
    }
} else {
    $errors['lastname'] = "Last name is required.";
}

// Email validation
if (isset($_POST['email'])) {
    $email = sanitizeInput($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
} else {
    $errors['email'] = "Email is required.";
}

// Password validation
if (isset($_POST['pwd'])) {
    $password = sanitizeInput($_POST['pwd']);
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $password)) {
        $errors['pwd'] = "Invalid password format.";
    }
} else {
    $errors['pwd'] = "Password is required.";
}

// Sex validation
if (isset($_POST['sex'])) {
    $sex = sanitizeInput($_POST['sex']);
    $validSexOptions = ['Male', 'Female', 'Diverse'];
    if (!in_array($sex, $validSexOptions)) {
        $errors['sex'] = "Invalid sex option selected.";
    }
} else {
    $errors['sex'] = "Sex selection is required.";
}

// Country validation
if (isset($_POST['country']) && $_POST['country'] !== 'none') {
    $country = sanitizeInput($_POST['country']);
    // Additional validation for country can be added if needed
} else {
    $errors['country'] = "Please select a country.";
}

// City validation
if (isset($_POST['city'])) {
    $city = sanitizeInput($_POST['city']);
    if (!preg_match('/^[a-zA-Z]{4,}$/', $city)) {
        $errors['city'] = "Invalid city name.";
    }
} else {
    $errors['city'] = "City is required.";
}

// Terms checkbox validation
if (!isset($_POST['terms'])) {
    $errors['terms'] = "You must agree to the terms.";
}

// Return errors if any, or success message
if (!empty($errors)) {
    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($errors);
    exit;
} else {
    echo json_encode(['message' => 'Form submitted successfully.']);
    exit;
}
?>
