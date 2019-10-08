<?php

class SQLAnywhere extends App {

    protected $connection;

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
    public function get($sql, $json = false, $result_type = 'ARRAY') {
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

    public function first($sql, $json = false, $result_type = 'ARRAY') {
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
                return json_encode($result[0]);
            } elseif ($json == false) {
                return $result[0];
            }
        } catch (Exception $error) {
            return $error;
        }
    }

    public function insert($sql, $return_status = false) {
        try {
            sasql_query($this->connection, $sql);
            if ($return_status == true) {
                $status = array(
                    'code' => 200,
                    'message' => 'Insert berhasil',
                    'sql' => $sql
                );
                return json_encode($status);
            }
        } catch (Exception $error) {
            $status = array(
                'code' => 500,
                'message' => "Internal Server Error : <br>".$error."<hr>",
                'sql' => $sql
            );
            return json_encode($status);
        }
    }

    public function update($sql, $return_status = false) {
        try {
            sasql_query($this->connection, $sql);
            if ($return_status == true) {
                $status = array(
                    'code' => 200,
                    'message' => 'Update berhasil',
                    'sql' => $sql
                );
                return json_encode($status);
            }
        } catch (Exception $error) {
            $status = array(
                'code' => 500,
                'message' => "Internal Server Error : <br>".$error."<hr>",
                'sql' => $sql
            );
            return json_encode($status);
        }
    }

    public function delete($sql, $return_status = false) {
        try {
            sasql_query($this->connection, $sql);
            if ($return_status == true) {
                $status = array(
                    'code' => 200,
                    'message' => 'Delete berhasil',
                    'sql' => $sql
                );
                return json_encode($status);
            }
        } catch (Exception $error) {
            $status = array(
                'code' => 500,
                'message' => "Internal Server Error : <br>".$error."<hr>",
                'sql' => $sql
            );
            return json_encode($status);
        }
    }

}
