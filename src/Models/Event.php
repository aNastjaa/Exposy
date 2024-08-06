<?php
namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use Crmlva\Exposy\Database;

class Event extends Model
{
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

    public function getEventsByCity(string $city): array
    {
        $query = "SELECT * FROM events WHERE city = :city";
        return $this->fetchAll($query, ['city' => $city]);
    }

    public function getEventById(int $id): ?array
    {
        $query = "SELECT * FROM events WHERE id = :id";
        return $this->fetchOne($query, ['id' => $id]);
    }

    public function saveEvent(int $userId, int $eventId): bool
    {
        $db = Database::getInstance();
        $query = "INSERT INTO saved_events (user_id, event_id) VALUES (:user_id, :event_id)";
        $stmt = $db->prepare($query);
        return $stmt->execute(['user_id' => $userId, 'event_id' => $eventId]);
    }

    public function saveEventForUser(int $userId, int $eventId): bool
    {
        $existingSavedEvent = $this->checkIfEventSaved($userId, $eventId);

        if ($existingSavedEvent) {
            
            return false; 
        }

        return $this->saveEvent($userId, $eventId);
    }

    private function checkIfEventSaved(int $userId, int $eventId): bool
    {
        $db = Database::getInstance(); 
        $query = "SELECT COUNT(*) FROM saved_events WHERE user_id = :user_id AND event_id = :event_id";
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $userId, 'event_id' => $eventId]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function getSavedEventsByUserId(int $userId): array
    {
        $query = "SELECT e.* FROM events e
                  INNER JOIN saved_events se ON e.id = se.event_id
                  WHERE se.user_id = :user_id";
        return $this->fetchAll($query, ['user_id' => $userId]);
    }
}
