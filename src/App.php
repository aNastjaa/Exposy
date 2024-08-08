<?php
namespace Crmlva\Exposy;

use Crmlva\Exposy\Controllers\LoginController;
use Crmlva\Exposy\Controllers\RegisterController;
use Crmlva\Exposy\Controllers\UserController;
use Crmlva\Exposy\Controllers\UserAccountController;
use Crmlva\Exposy\Controllers\EventsController; 
use Crmlva\Exposy\Enums\CityEnum;
use Crmlva\Exposy\Enums\CategoryEnum;

final class App
{
    public function bootstrap(): void
    {
        Session::start();
        
        $cities = CityEnum::values();
        $categories = CategoryEnum::values();

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

                case 'upload-photo':
                    $this->auth();
                    $controller = new UserController();
                    $controller->uploadPhoto();
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

            case 'events':
                $controller = new EventsController();
                $controller->showEvents();
                new View('layout', 'events', [
                    'title' => 'Events',
                    'currentPage' => 'events',
                ]);
                break;

            case 'save-event': 
                $this->auth();
                $controller = new EventsController();
                $controller->saveEvent();
                header('Location: /account');
                exit();
                break;

            case 'delete-saved-event':
                $this->auth();
                $controller = new EventsController();
                $controller->deleteSavedEvent();
                break;

            case '':
            case null:
                new View('layout', 'index', [
                    'title' => 'Home'
                ]);
                break;

            default:
                new View('error', '404', [
                    'title' => 'Page Not Found',
                    'currentPage' => '404', 
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

    public static function getUserPhotoUrl($photo = null): string
    {
        return Util::getUserPhotoUrl($photo);
    }
}
