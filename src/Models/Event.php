<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use PDO;

class Event extends Model
{
    public int $id;
    public string $title;
    public string $img;
    public string $gallery;
    public string $date;
    public string $city;
    public string $created_at;

    public function __construct()
    {
        $this->database = \Crmlva\Exposy\Database::getInstance();
    }

    /**
     * Get events by city.
     *
     * @param string $city
     * @return array
     */
    public function getEventsByCity(string $city): array
    {
        $query = "SELECT img, title, gallery, date FROM events WHERE city = :city";
        $stmt = $this->database->prepare($query);
        $stmt->execute(['city' => $city]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
