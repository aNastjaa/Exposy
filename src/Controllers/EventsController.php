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
        // Check if the user is logged in
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        // Fetch the user's city
        $userModel = new User();
        $city = $userModel->getCityByUserId($userId);

        // Fetch events for the user's city
        $eventModel = new Event();
        $events = $eventModel->getEventsByCity($city);

        // Format the event dates
        foreach ($events as &$event) {
            $event['date'] = $this->formatDate($event['date']);
        }

        // If no events are found, set a message
        if (empty($events)) {
            $message = "Looks like $city is taking a little nap! 💤 <br> Check back soon or explore events in nearby cities to keep the fun rolling!";
        }

        // Render the view with events data
        $this->renderView('events', [
            'title' => 'Events',
            'city' => $city,
            'events' => $events,
            'message' => $message ?? null,
        ]);
    }

    private function formatDate(string $date): string
    {
        $dateTime = new \DateTime($date);
        return $dateTime->format('F j, Y');
    }
}

