<?php

class App
{

    protected $DB;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->DB = [
            'DB_USERNAME' => "dba",
            'DB_PASSWORD' => "fauzan123",
            'DB_NAME' => "sejahtera"
        ];
    }

}
