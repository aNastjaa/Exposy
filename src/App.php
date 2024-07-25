<?php

namespace Crmlva\Exposy;

use Crmlva\Exposy\Controllers\AuthController;
use Crmlva\Exposy\Controllers\UserController;

final class App {

    protected function auth(): void {
        $authController = new AuthController();

        if (!$authController->isLoggedIn()) {
            $this->redirect('/login'); 
        }
    }

    public function bootstrap(): void
{
    Session::start();
    
    $url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

    switch ($url) {
        case 'login':
            $controller = new UserController();
            $controller->login();
            break;

        case 'register':
            $controller = new UserController();
            $controller->register();
            break;

        case 'account':
            $this->auth();
            new View('main', 'account', [
                'title' => 'Account'
            ]);
            break;

        case 'events':
            $this->auth();
            new View('main', 'events', [
                'title' => 'Events'
            ]);
            break;

        case '':
        case null:
            new View('main', 'index', [
                'title' => 'Home'
            ]);
            break;

        default:
            new View('error', '404', [
                'title' => 'Page Not Found'
            ]);
            break;
    }
}

    public function redirect(string $url): void
{
    header("Location: $url");
    exit(); 
}
}
