<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;

class UserController extends Controller {

    public array $errors = [];

    protected function compareCredentials(string $email, string $password) : bool {
        
        // $this->errors[$name][] = '';

        return true;
    }

    protected function validateRegister(array $data) : bool {
        
        return true;
    }

    public function register() : bool
    {
        // überprüfen ob der Nutzer das Formular abgeschickt hat
        if ( !$this->isRequestMethod( self::REQUEST_METHOD_POST ) ) {
            
            return false;
        }

        $data = $this->getData();

        if ( $this->validateRegister( $data ) ) {
            
            return (new User())->create( $data['username'], $data['email'], $data['password'] );
        }

        return false;
    }

    public function login() : bool 
    {
        // überprüfen ob der Nutzer das Formular abgeschickt hat
        if ( !$this->isRequestMethod( self::REQUEST_METHOD_POST ) ) {

            return false;
        }

        $data = $this->getData();

        if ( $this->compareCredentials( $data['email'], $data['password'] ) ) {
            
        }

        return false;
    }

}