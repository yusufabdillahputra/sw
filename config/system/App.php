<?php

use Dotenv\Dotenv;

class App
{

    public function __construct()
    {
        require __DIR__ . '\..\..\vendor\autoload.php';
        $dotenv = Dotenv::create(__DIR__ . '\..\..');
        $dotenv->load();
    }

}
