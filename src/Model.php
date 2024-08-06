<?php

namespace Crmlva\Exposy;

use PDO;
abstract class Model 
{
    protected $database;

    public function __construct()
    {
        $this->database = self::getDatabaseInstance();
    }

    public static function getDatabaseInstance(): Database
    {
        return Database::getInstance();
    }

    protected function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->database->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchOne(string $query, array $params = []): ?array
    {
        $stmt = $this->database->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
