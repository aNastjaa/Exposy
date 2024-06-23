<?php
session_start();

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Function to validate username
function validate_username($username) {
    $errors = [];

    // Check length
    if (strlen($username) < 4 || strlen($username) > 16) {
        $errors[] = "Username must be between 4 and 16 characters.";
    }

    // Check for spaces
    if (strpos($username, ' ') !== false) {
        $errors[] = "Username must not contain spaces.";
    }

    return $errors;
}

// Function to validate email
function validate_email($email) {
    $errors = [];

    // Check if valid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    return $errors;
}

// Function to validate password
function validate_password($password) {
    $errors = [];

    // Check length
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Check requirements
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Password must contain at least one number.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must contain at least one special character.";
    }

    // Check for spaces
    if (strpos($password, ' ') !== false) {
        $errors[] = "Password must not contain spaces.";
    }

    return $errors;
}

// Function to validate radio input
function validate_radio($radioValue) {
    $errors = [];

    // Check if a radio option is selected
    if (empty($radioValue)) {
        $errors[] = "Please select a sex.";
    }

    return $errors;
}

// Function to validate select input
function validate_select($selectValue) {
    $errors = [];

    // Check if an option is selected
    if ($selectValue === "none") {
        $errors[] = "Please select a country.";
    }

    return $errors;
}

// Function to validate checkbox input
function validate_checkbox($checkboxValue) {
    $errors = [];

    // Check if checkbox is checked
    if (empty($checkboxValue)) {
        $errors[] = "You must agree to the terms.";
    }

    return $errors;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $firstname = isset($_POST['firstname']) ? sanitize_input($_POST['firstname']) : '';
    $lastname = isset($_POST['lastname']) ? sanitize_input($_POST['lastname']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $password = isset($_POST['pwd']) ? sanitize_input($_POST['pwd']) : '';
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : 'none';
    $city = isset($_POST['city']) ? sanitize_input($_POST['city']) : '';
    $terms = isset($_POST['terms']) ? $_POST['terms'] : '';

    // Validate inputs
    $errors = [];

    $errors = array_merge($errors, validate_username($firstname));
    $errors = array_merge($errors, validate_username($lastname));
    $errors = array_merge($errors, validate_email($email));
    $errors = array_merge($errors, validate_password($password));
    $errors = array_merge($errors, validate_radio($sex));
    $errors = array_merge($errors, validate_select($country));
    $errors = array_merge($errors, validate_username($city)); 
    $errors = array_merge($errors, validate_checkbox($terms));

    // If no errors, set success message and redirect
    if (empty($errors)) {
        $_SESSION['success'] = "Form submitted successfully!";
        header("Location: ./pages/account.php"); // Redirect to success page or wherever needed
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ./pages/account.php#profile-form"); // Redirect back to form with errors
        exit();
    }
} else {
    // Handle if not a POST request
    $_SESSION['errors'] = ["Invalid request method."];
    header("Location: ./pages/account.php"); // Redirect back to form with errors
    exit();
}
?>