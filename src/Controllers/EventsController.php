<?php
namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\Event;
use Crmlva\Exposy\Models\User;
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

        $userModel = new User();
        $city = $userModel->getCityByUserId($userId);

        $eventModel = new Event();
        $localEvents = $eventModel->getEventsByCity($city);
        $globalEvents = $eventModel->getAllEvents();

        foreach ($localEvents as &$event) {
            $event['date'] = $this->formatDate($event['date']);
        }

        foreach ($globalEvents as &$event) {
            $event['date'] = $this->formatDate($event['date']);
        }

        $this->renderView('events', [
            'title' => 'Events',
            'city' => $city,
            'localEvents' => $localEvents,
            'globalEvents' => $globalEvents,
        ]);
    }

    private function formatDate(string $date): string
    {
        $dateTime = new \DateTime($date);
        return $dateTime->format('F j, Y');
    }
}
