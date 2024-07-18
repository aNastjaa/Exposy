<?php

namespace Crmlva\Exposy;

abstract class Model 
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }
}