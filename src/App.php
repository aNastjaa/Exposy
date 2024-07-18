<?php

namespace Crmlva\Exposy;

use Crmlva\Exposy\Controllers\AuthController;
use Crmlva\Exposy\Controllers\UserController;

final class App {

    protected function auth() : void {
        $authController = new AuthController();

        if ( !$authController->isLoggedIn() )
        {
            $authController->error(403);   
        }
    }

    public function bootstrap() : void 
    {
        Session::start();

        $url = filter_input(INPUT_GET, 'url');

        switch($url) {

            case 'login':
                $controller = new UserController();
                $controller->login();

                (new View('auth','login', [
                    'title' => 'test'
                ]));
                break;

            case 'register':
                $controller = new UserController();
                
                if( $controller->register() ) {
                    $controller->redirect('login');
                }

                (new View('auth','register', [
                    'errors' => $controller->errors 
                ]));
                break;

            case 'dashboard':
                $this->auth();
                
                break;

            default:
                (new View('error', 404));
                break;
                
        }
    }    

}