<?php
require_once __DIR__ . '/../scripts/user.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        require __DIR__ . '/../templates/signup_form.php';
    }

    public function add() {
        session_start();
        $errors = []; // Initialize $errors array

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input fields using functions from validate_form.php
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['pwd'] ?? '';
            $password_repeat = $_POST['pwd_rep'] ?? '';
            $terms = $_POST['terms'] ?? '';

            $validate_username = validate_string_field($username, 'username', 4, 16);
            $validate_email = validate_email($email);
            $validate_password = validate_password($password);
            $validate_password_repeat = validate_password_repeat($password, $password_repeat);
            $validate_terms = validate_terms($terms);

            // Check if there are any validation errors
            if (
                !$validate_username || !$validate_email || !$validate_password ||
                !$validate_password_repeat || !$validate_terms
            ) {
                // Store errors in session and redirect back to signup form
                $_SESSION['errors'] = $errors;
                header('Location: /signup_form.php');
                exit;
            }

            // Check if email already exists
            $existingUser = $this->userModel->getUserByEmail($email);
            if ($existingUser) {
                $errors['email'] = 'Email already exists. Please choose a different email.';
            } else {
                // Add user to database
                $userId = $this->userModel->addUser($username, $email, $password);
                if ($userId) {
                    // Redirect to account page after successful registration
                    $_SESSION['status_message'] = 'User registered successfully!';
                    header('Location: /account.php');
                    exit;
                } else {
                    $errors['general'] = 'Failed to add user. Please try again later.';
                }
            }
        }

        // If validation errors or registration failed, render signup form again with errors
        $_SESSION['errors'] = $errors;
        $this->index();
    }
}
