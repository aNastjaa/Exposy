<?php

namespace Crmlva\Exposy;

use Crmlva\Exposy\Controllers\LoginController;
use Crmlva\Exposy\Controllers\RegisterController;
use Crmlva\Exposy\Controllers\UserController;
use Crmlva\Exposy\Controllers\UserAccountController; 

final class App
{
    public function bootstrap(): void
    {
        Session::start();
        
        // Retrieve the URL path from the query parameters
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

            case 'account/edit': 
                $this->auth();
                $controller = new UserAccountController();
                $controller->updateAccount();
                break;

            case 'account/edit/password': 
                $this->auth();
                $controller = new UserAccountController();
                $controller->updatePassword();
                break;
                
            case 'account/delete':
                $this->auth();
                $controller = new UserAccountController();
                $controller->deleteAccount();
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
