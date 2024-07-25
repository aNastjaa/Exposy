<?php

namespace Crmlva\Exposy;

use PDO;

class Database extends PDO
{
    private static ?Database $instance = null;

    private function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%1$s;port=%2$s;dbname=%3$s;charset=utf8',
            DB_HOST,
            DB_PORT,
            DB_NAME
        );

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Add this option for better error handling
        ];

        parent::__construct($dsn, DB_USER, DB_PASS, $options);
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
