<?php

namespace Crmlva\Exposy;

use PDO;

class Database extends PDO
{

    public function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%1$s;port=%2$s;dbname=%3$s;charset=utf8',
            DB_HOST,
            DB_PORT,
            DB_NAME
        );

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        parent::__construct($dsn, DB_USER, DB_PASS);
    }

}