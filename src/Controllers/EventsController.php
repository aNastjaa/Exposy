<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Session;

class EventsController extends Controller
{
    public function showEvents(): void
    {

        $userId = Session::get('user_id');
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        $this->renderView('events', [
            'title' => 'Events',
            'currentPage' => 'events'
        ]);
    }
}
