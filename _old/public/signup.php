<link rel="stylesheet" href="/css/login_signup.css">
<script src="/js/password.js" defer></script>

<?php
include __DIR__ . '/../scripts/validate_form.php';
include __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../controllers/user_controller.php';

$controller = new UserController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case '/add':
        $controller->add();
        break;
    case '/':
    default:
        $controller->index();
        break;
}

