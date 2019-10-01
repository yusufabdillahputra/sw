<?php

use Evolution\CodeIgniterDB as CI;

class Codeigniter extends App
{

    public function __construct()
    {
        parent::__construct();
    }

    public static function query()
    {
        $connection = array(
            'dsn' => $_ENV['DB_DSN'],
            'hostname' => '',
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'database' => $_ENV['DB_NAME'],
            'dbdriver' => $_ENV['DB_DRIVER'],
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => TRUE,
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        $db =& CI\DB($connection);
        return $db;
    }

    /**
     * Daftar kustomisasi setiap instance
     */


}
