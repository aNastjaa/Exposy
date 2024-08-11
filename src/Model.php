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
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result !== false ? $result : null; 
    }

    protected function execute(string $query, array $params = []): bool
    {
        $stmt = $this->database->prepare($query);
        return $stmt->execute($params);
    }
}
