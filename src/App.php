<?php

namespace Crmlva\Exposy;

use Crmlva\Exposy\Controllers\AuthController;
use Crmlva\Exposy\Controllers\UserController;

final class App {

    protected function auth(): void {
        $authController = new AuthController();

        if (!$authController->isLoggedIn()) {
            $authController->error(403);   
        }
    }

    public function bootstrap(): void {
        Session::start();

        $url = filter_input(INPUT_GET, 'url');

        switch ($url) {
            case 'login':
                $controller = new UserController();
                $controller->login();

                new View('auth', 'login', [
                    'title' => 'Login'
                ]);
                break;

            case 'register':
                $controller = new UserController();
                
                if ($controller->register()) {
                    $controller->redirect('login');
                }

                new View('auth', 'register', [
                    'errors' => $controller->errors,
                    'title' => 'Register'
                ]);
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
}
