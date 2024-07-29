<?php

namespace Crmlva\Exposy;

use Crmlva\Exposy\Controllers\LoginController;
use Crmlva\Exposy\Controllers\RegisterController;
use Crmlva\Exposy\Controllers\UserController;

final class App
{
    public function bootstrap(): void
    {
        Session::start();
        
        $url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

        switch ($url) {
            case 'login':
                $controller = new LoginController();
                $controller->handleLogin();
                break;

            case 'register':
                $controller = new RegisterController();
                $controller->handleRegistration();
                break;

            case 'account':
                $this->auth();
                $controller = new UserController();
                $controller->profile();
                break;

            case '':
            case null:
                new View('layout', 'index', [
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

    private function auth(): void
    {
        if (!Session::has('user_id')) {
            header('Location: /login');
            exit();
        }
    }
}
