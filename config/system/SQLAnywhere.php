<?php

class SQLAnywhere extends App {

    public function __construct()
    {
        parent::__construct();
        $this->connection = sasql_connect("ServerName=".$this->DB['DB_NAME'].";uid=".$this->DB['DB_USERNAME'].";PWD=".$this->DB['DB_PASSWORD']);
    }


    /**
     * SQL Anywhere PHP API reference : http://dcx.sap.com/1101/en/dbprogramming_en11/php-api.html
     * Doc : sasql_fetch_assoc => http://dcx.sap.com/1101/en/dbprogramming_en11/php-fetch-assoc.html
     *       sasql_fetch_object => http://dcx.sap.com/1101/en/dbprogramming_en11/php-fetch-object.html
     *
     * @param $sql
     * @param bool $json
     * @param $result_type
     * @return array|Exception|false|string
     */
    public function rawSql($sql, $json = true, $result_type = 'ARRAY') {
        try {
            $query = sasql_query($this->connection, $sql);
            if ($result_type == 'ARRAY') {
                $result = array();
                while ($row = sasql_fetch_assoc($query)) {
                    array_push($result, $row);
                }
            } elseif ($result_type == 'OBJECT') {
                $result = array();
                while ($row = sasql_fetch_object($query)) {
                    $result[] = $row;
                }
            }
            if ($json == true) {
                return json_encode($result);
            } elseif ($json == false) {
                return $result;
            }
        } catch (Exception $error) {
            return $error;
        }
    }



}
