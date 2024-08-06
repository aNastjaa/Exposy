<?php
namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use Crmlva\Exposy\Database;

class Event extends Model
{
    public function getAllEvents(?string $selectedCity = null, ?string $selectedCategory = null): array
    {
        $query = "SELECT * FROM events WHERE 1=1"; // Base query

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
}
