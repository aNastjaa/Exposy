<?php
$errors = []; 

// Function to sanitize and validate input
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Function to validate text input
function validateText($input, $fieldName) {
    global $errors;
    if (empty($input)) {
        $errors[$fieldName] = ucfirst($fieldName) . " is required.";
        return false;
    } elseif (!preg_match('/^[a-zA-Z\s]{4,}$/', $input)) {
        $errors[$fieldName] = "Invalid " . $fieldName . " format.";
        return false;
    }
    return true;
}

// Function to validate email input
function validateEmail($email) {
    global $errors;
    if (empty($email)) {
        $errors['email'] = "Email is required.";
        return false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
        return false;
    }
    return true;
}

// Function to validate password input
function validatePassword($password) {
    global $errors;
    if (empty($password)) {
        $errors['pwd'] = "Password is required.";
        return false;
    } elseif (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+}{":;\'?\/\\><.,])(?!.*\s).{8,}$/', $password)) {
        $errors['pwd'] = "Password does not meet requirements.";
        return false;
    }
    return true;
}

// Validate form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate each field
    $firstname = sanitizeInput($_POST['firstname']);
    $lastname = sanitizeInput($_POST['lastname']);
    $email = sanitizeInput($_POST['email']);
    $city = sanitizeInput($_POST['city']);
    $pwd = sanitizeInput($_POST['pwd']);
    $terms = isset($_POST['terms']) ? true : false;
    $country = $_POST['country'];
    $sex = isset($_POST['sex']) ? sanitizeInput($_POST['sex']) : "";

    // Validate each input field
    validateText($firstname, 'firstname');
    validateText($lastname, 'lastname');
    validateEmail($email);
    validateText($city, 'city');
    validatePassword($pwd);
    if (!$terms) {
        $errors['terms'] = "You must agree to the terms.";
    }
    if ($country === 'none') {
        $errors['country'] = "Please select your country.";
    }
}

// If no errors, set success message and process further actions
if (empty($errors) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $success = "Form submitted successfully!";

}
?>

<!-- PHP to display error messages and success message -->
<?php if (!empty($errors)) : ?>
    <div class="form-row">
        <p>There were errors in your form:</p>
        <ul class="error-messages">
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <div class="form-row">
        <p><?= $success ?></p>
    </div>
<?php endif; ?>
