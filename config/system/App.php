<?php

class App
{

    protected $DB;

    public function __construct()
    {
        $this->DB = [
            'DB_USERNAME' => "dba",
            'DB_PASSWORD' => "fauzan123",
            'DB_NAME' => "sejahtera"
        ];
    }

}
