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

        $selectedCity = $_GET['city-filter'] ?? 'none';
        $selectedCategory = $_GET['category-filter'] ?? 'none';

        $validCities = CityEnum::values();
        $validCategories = CategoryEnum::values();

        $selectedCity = in_array($selectedCity, $validCities) ? $selectedCity : null;
        $selectedCategory = in_array($selectedCategory, $validCategories) ? $selectedCategory : null;

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

    // Assuming this is in your PHP code for the /account endpoint
    public function saveEvent(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->sendJsonResponse(false, ['message' => 'User not authenticated'], 403);
            return;
        }
    
        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Log received data to debug
            error_log('Received Data: ' . print_r($data, true));
    
            $eventId = $data['event_id'] ?? null;
    
            if (!$eventId) {
                $this->sendJsonResponse(false, ['message' => 'Event ID is missing!'], 422);
                return;
            }
    
            // Assume saveEventForUser is a method that processes the event ID
            $eventModel = new Event();
            $result = $eventModel->saveEventForUser($userId, $eventId);
    
            if ($result) {
                $this->sendJsonResponse(true, ['message' => 'Event saved successfully!'], 200);
            } else {
                $this->sendJsonResponse(false, ['message' => 'Failed to save event'], 500);
            }
        } else {
            $this->sendJsonResponse(false, ['message' => 'Invalid request method'], 405);
        }
    }
    

    private function sendJsonResponse(bool $success, array $data, int $statusCode): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success] + $data);
        http_response_code($statusCode);
        exit();
    }

    public function deleteSavedEvent(): void
    {
        // Ensure user is authenticated
        if (!Session::has('user_id')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'User not authenticated']);
            exit();
        }

        // Get event ID from POST request
        $eventId = filter_input(INPUT_POST, 'event_id', FILTER_SANITIZE_NUMBER_INT);
        $userId = Session::get('user_id');

        if ($eventId && $userId) {
            $eventModel = new Event();
            $success = $eventModel->deleteSavedEvent($userId, $eventId);

            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Event deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting event']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }

        exit();
    }
}
