<?php

use Illuminate\Database\Connection;

class Eloquent extends App {

    public function __construct()
    {
        parent::__construct();
    }

    public static function query()
    {
        return new Connection(new PDO($_ENV['DB_DRIVER'].':'.$_ENV['DB_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']));
    }

    /**
     * Daftar kustomisasi setiap instance
     */
    public static function raw($query){
        return self::query()->raw($query);
    }

}
