<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\View;

class UserController extends Controller
{
    public function profile(): void
{
    $userId = Session::get('user_id');
    if (!$userId) {
        $this->redirect('/login');
        return;
    }

    $userModel = new User();
    $user = $userModel->getById($userId);

    if ($user) {
        new View('layout', 'account', [
            'username' => $user['username'],
            // 'city' => $user['city'],
            // 'country' => $user['country'],
            'title' => 'Account'
        ]);
    } else {
        $this->error(404);
    }
}

}
