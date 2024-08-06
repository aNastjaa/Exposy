<?php
namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;

class Event extends Model
{
    public function getAllEvents(): array
    {
        $query = "SELECT * FROM events";
        return $this->fetchAll($query);
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
}
