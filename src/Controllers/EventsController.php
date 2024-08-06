<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\Event;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Enums\CityEnum;
use Crmlva\Exposy\Enums\CategoryEnum;

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

        // Get filter parameters from the request (GET)
        $selectedCity = $_GET['city-filter'] ?? 'none';
        $selectedCategory = $_GET['category-filter'] ?? 'none';

        // Validate selected city and category against enum values
        $validCities = CityEnum::values();
        $validCategories = CategoryEnum::values();

        $selectedCity = in_array($selectedCity, $validCities) ? $selectedCity : null;
        $selectedCategory = in_array($selectedCategory, $validCategories) ? $selectedCategory : null;

        // Filter global events based on selected city and category
        $globalEvents = $eventModel->getAllEvents($selectedCity, $selectedCategory);

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
            'selectedCity' => $selectedCity,
            'selectedCategory' => $selectedCategory
        ]);
    }

    private function formatDate(string $date): string
    {
        $dateTime = new \DateTime($date);
        return $dateTime->format('F j, Y');
    }
}
