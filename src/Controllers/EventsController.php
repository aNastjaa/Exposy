<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\Event;
use Crmlva\Exposy\Models\Comment;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Enums\CityEnum;
use Crmlva\Exposy\Enums\CategoryEnum;
use Crmlva\Exposy\Database; 

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
        $user = $userModel->find($userId);

        if ($user === null) {
            $this->redirect('/login');
            return;
        }

        // Attempt to get the user's city
        $city = $userModel->getCityByUserId($userId);
        $username = $user->username;

        // Validate the city value
        if (empty($city)) {
            // Provide a default city or handle the lack of a city gracefully
            $city = 'Default City'; // Use a default city if applicable
        }

        $eventModel = new Event();
        $localEvents = $eventModel->getEventsByCity($city);

        // Retrieve filter parameters
        $selectedCity = $_GET['city-filter'] ?? 'none';
        $selectedCategory = $_GET['category-filter'] ?? 'none';

        $validCities = CityEnum::values();
        $validCategories = CategoryEnum::values();

        $selectedCity = in_array($selectedCity, $validCities) ? $selectedCity : null;
        $selectedCategory = in_array($selectedCategory, $validCategories) ? $selectedCategory : null;

        $globalEvents = $eventModel->getAllEvents($selectedCity, $selectedCategory);

        // Fetch the PDO instance from the Database class
        $database = Database::getInstance();
        $commentModel = new Comment($database);

        // Fetch comments and usernames for each global event
        foreach ($globalEvents as &$event) {
            $event['comments'] = $commentModel->getCommentsByEventId($event['id']);
            foreach ($event['comments'] as &$comment) {
                $comment['username'] = $commentModel->getUsernameById($comment['user_id']);
            }
        }

        $localEvents = $this->formatEventsDate($localEvents);
        $globalEvents = $this->formatEventsDate($globalEvents);

        $this->renderView('events', [
            'title' => 'Events',
            'city' => $city,
            'username' => $username,
            'localEvents' => $localEvents,
            'globalEvents' => $globalEvents,
            'selectedCity' => $selectedCity,
            'selectedCategory' => $selectedCategory,
            'user_id' => $userId
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
            $eventId = $_POST['event_id'] ?? null;

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

        $eventId = $_POST['event_id'] ?? null;
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

    public function addComment(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->sendJsonResponse(false, ['message' => 'User not authenticated'], 403);
            return;
        }

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $eventId = $_POST['event_id'] ?? null;
            $commentText = $_POST['comment'] ?? '';

            if (!$eventId || !$commentText) {
                $this->sendJsonResponse(false, ['message' => 'Missing event ID or comment text'], 422);
                return;
            }

            $database = Database::getInstance();
            $commentModel = new Comment($database);
            $result = $commentModel->addComment((int)$eventId, $userId, $commentText);

            $this->sendJsonResponse($result, ['message' => $result ? 'Comment added successfully' : 'Failed to add comment'], $result ? 200 : 500);
        } else {
            $this->sendJsonResponse(false, ['message' => 'Invalid request method'], 405);
        }
    }

    public function updateComment(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->sendJsonResponse(false, ['message' => 'User not authenticated'], 403);
            return;
        }

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $commentId = $_POST['comment_id'] ?? null;
            $commentText = $_POST['comment'] ?? '';

            if (!$commentId || !$commentText) {
                $this->sendJsonResponse(false, ['message' => 'Missing comment ID or comment text'], 422);
                return;
            }

            $database = Database::getInstance();
            $commentModel = new Comment($database);
            $result = $commentModel->updateComment((int)$commentId, $commentText);

            $this->sendJsonResponse($result, ['message' => $result ? 'Comment updated successfully' : 'Failed to update comment'], $result ? 200 : 500);
        } else {
            $this->sendJsonResponse(false, ['message' => 'Invalid request method'], 405);
        }
    }

    public function deleteComment(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->sendJsonResponse(false, ['message' => 'User not authenticated'], 403);
            return;
        }

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $commentId = $_POST['comment_id'] ?? null;

            if (!$commentId) {
                $this->sendJsonResponse(false, ['message' => 'Missing comment ID'], 422);
                return;
            }

            $database = Database::getInstance();
            $commentModel = new Comment($database);
            $success = $commentModel->deleteComment((int)$commentId);

            $this->sendJsonResponse($success, [
                'message' => $success ? 'Comment deleted successfully' : 'Failed to delete comment'
            ], $success ? 200 : 500);
        } else {
            $this->sendJsonResponse(false, ['message' => 'Invalid request method'], 405);
        }
    }

    // Display saved events for a user
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

    private function sendJsonResponse(bool $success, array $data, int $statusCode): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success] + $data);
        http_response_code($statusCode);
        exit();
    }
}
