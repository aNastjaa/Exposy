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
    // Display events with optional filters
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

        $selectedCity = $_GET['city-filter'] ?? 'none';
        $selectedCategory = $_GET['category-filter'] ?? 'none';

        $validCities = CityEnum::values();
        $validCategories = CategoryEnum::values();

        $selectedCity = in_array($selectedCity, $validCities) ? $selectedCity : null;
        $selectedCategory = in_array($selectedCategory, $validCategories) ? $selectedCategory : null;

        $globalEvents = $eventModel->getAllEvents($selectedCity, $selectedCategory);

        $localEvents = $this->formatEventsDate($localEvents);
        $globalEvents = $this->formatEventsDate($globalEvents);

        $this->renderView('events', [
            'title' => 'Events',
            'city' => $city,
            'localEvents' => $localEvents,
            'globalEvents' => $globalEvents,
            'selectedCity' => $selectedCity,
            'selectedCategory' => $selectedCategory
        ]);
    }

    // Helper function to format date for events
    private function formatEventsDate(array $events): array
    {
        foreach ($events as &$event) {
            $event['date'] = $this->formatDate($event['date']);
        }
        return $events;
    }

    // Format date string
    private function formatDate(string $date): string
    {
        $dateTime = new \DateTime($date);
        return $dateTime->format('F j, Y');
    }

    public function saveEvent(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->sendJsonResponse(false, ['message' => 'User not authenticated'], 403);
            return;
        }

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            
            $eventId = filter_input(INPUT_POST, 'event_id', FILTER_SANITIZE_NUMBER_INT);

            if (!$eventId) {
                $this->sendJsonResponse(false, ['message' => 'Event ID is missing!'], 422);
                return;
            }

            $eventModel = new Event();
            $response = $eventModel->saveEventForUser($userId, $eventId);

            $this->sendJsonResponse($response['success'], ['message' => $response['message']], $response['success'] ? 200 : 500);
        } else {
            $this->sendJsonResponse(false, ['message' => 'Invalid request method'], 405);
        }
    }

    // Delete a saved event
    public function deleteSavedEvent(): void
    {
        if (!Session::has('user_id')) {
            $this->sendJsonResponse(false, ['message' => 'User not authenticated'], 403);
            return;
        }

        $eventId = filter_input(INPUT_POST, 'event_id', FILTER_SANITIZE_NUMBER_INT);
        $userId = Session::get('user_id');

        if ($eventId && $userId) {
            $eventModel = new Event();
            $success = $eventModel->deleteSavedEvent($userId, $eventId);

            $this->sendJsonResponse($success, [
                'message' => $success ? 'Event deleted successfully' : 'Error deleting event'
            ], $success ? 200 : 500);
        } else {
            $this->sendJsonResponse(false, ['message' => 'Invalid request'], 422);
        }
    }

    // Helper function to send JSON response
    private function sendJsonResponse(bool $success, array $data, int $statusCode): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success] + $data);
        http_response_code($statusCode);
        exit();
    }

    public function showUserSavedEvents(): void
{
    $userId = Session::get('user_id');
    if (!$userId) {
        $this->redirect('/login');
        return;
    }
    
    $eventModel = new Event();
    $savedEvents = $eventModel->getSavedEventsByUserId($userId);

    foreach ($savedEvents as &$event) {
        $event['date'] = $this->formatDate($event['date']);
    }

    $this->renderView('saved-events', [
        'title' => 'Saved Events',
        'savedEvents' => $savedEvents
    ]);
}


}
