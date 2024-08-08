<?php
namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use Crmlva\Exposy\Database;

class Event extends Model
{
    // Fetch all events with optional filters
    public function getAllEvents(?string $selectedCity = null, ?string $selectedCategory = null): array
    {
        $query = "SELECT * FROM events WHERE 1=1";
        $params = [];
        
        if ($selectedCity) {
            $query .= " AND city = :city";
            $params['city'] = $selectedCity;
        }

        if ($selectedCategory) {
            $query .= " AND category = :category";
            $params['category'] = $selectedCategory;
        }

        return $this->fetchAll($query, $params);
    }

    // Fetch events by city
    public function getEventsByCity(string $city): array
    {
        $query = "SELECT * FROM events WHERE city = :city";
        return $this->fetchAll($query, ['city' => $city]);
    }

    // Fetch a single event by its ID
    public function getEventById(int $id): ?array
    {
        $query = "SELECT * FROM events WHERE id = :id";
        return $this->fetchOne($query, ['id' => $id]);
    }

    // Save an event for a user
    public function saveEventForUser(int $userId, int $eventId): array
    {
        if ($this->checkIfEventSaved($userId, $eventId)) {
            return [
                'success' => false,
                'message' => 'This event is already saved.'
            ]; // Event already saved
        }

        $query = "INSERT INTO saved_events (user_id, event_id) VALUES (:user_id, :event_id)";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $result = $stmt->execute(['user_id' => $userId, 'event_id' => $eventId]);

        return $result
            ? ['success' => true, 'message' => 'Event saved successfully!']
            : ['success' => false, 'message' => 'Failed to save event'];
    }

    // Check if an event is already saved for a user
    private function checkIfEventSaved(int $userId, int $eventId): bool
    {
        $query = "SELECT COUNT(*) FROM saved_events WHERE user_id = :user_id AND event_id = :event_id";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $userId, 'event_id' => $eventId]);
        return $stmt->fetchColumn() > 0;
    }

    // Get all saved events for a user
    public function getSavedEventsByUserId(int $userId): array
    {
        $query = "SELECT e.* FROM events e
                  INNER JOIN saved_events se ON e.id = se.event_id
                  WHERE se.user_id = :user_id";
        return $this->fetchAll($query, ['user_id' => $userId]);
    }

    // Delete a saved event for a user
    public function deleteSavedEvent(int $userId, int $eventId): bool
    {
        $query = "DELETE FROM saved_events WHERE user_id = :user_id AND event_id = :event_id";
        return $this->execute($query, ['user_id' => $userId, 'event_id' => $eventId]);
    }
}
