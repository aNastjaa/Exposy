<?php

namespace Crmlva\Exposy;

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
}
