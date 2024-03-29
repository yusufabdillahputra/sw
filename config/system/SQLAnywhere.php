<?php

class SQLAnywhere {

    public $DB_USERNAME = 'dba';
    public $DB_PASSWORD = 'sejahtera2';
    public $DB_NAME = 'sejahtera_new';

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
            $connection = sasql_connect("ServerName=".$this->DB_NAME.";uid=".$this->DB_USERNAME.";PWD=".$this->DB_PASSWORD);
            $query = sasql_query($connection, $sql);
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

            /**
             * Clean Up
             */
            sasql_free_result($query);
            sasql_disconnect($connection);

            /**
             * Set result
             */
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
            $connection = sasql_connect("ServerName=".$this->DB_NAME.";uid=".$this->DB_USERNAME.";PWD=".$this->DB_PASSWORD);
            $query = sasql_query($connection, $sql);
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

            /**
             * Clean Up
             */
            sasql_free_result($query);
            sasql_disconnect($connection);

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
            $connection = sasql_connect("ServerName=".$this->DB_NAME.";uid=".$this->DB_USERNAME.";PWD=".$this->DB_PASSWORD);
            $query = sasql_query($connection, $sql);
            if ($return_status == true) {
                $status = array(
                    'code' => 200,
                    'message' => 'Insert berhasil',
                    'sql' => $sql
                );
                return json_encode($status);
            }

            /**
             * Clean Up
             */
            sasql_free_result($query);
            sasql_disconnect($connection);

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
            $connection = sasql_connect("ServerName=".$this->DB_NAME.";uid=".$this->DB_USERNAME.";PWD=".$this->DB_PASSWORD);
            $query = sasql_query($connection, $sql);
            if ($return_status == true) {
                $status = array(
                    'code' => 200,
                    'message' => 'Update berhasil',
                    'sql' => $sql
                );
                return json_encode($status);
            }

            /**
             * Clean Up
             */
            sasql_free_result($query);
            sasql_disconnect($connection);

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
            $connection = sasql_connect("ServerName=".$this->DB_NAME.";uid=".$this->DB_USERNAME.";PWD=".$this->DB_PASSWORD);
            $query = sasql_query($connection, $sql);
            if ($return_status == true) {
                $status = array(
                    'code' => 200,
                    'message' => 'Delete berhasil',
                    'sql' => $sql
                );
                return json_encode($status);
            }

            /**
             * Clean Up
             */
            sasql_free_result($query);
            sasql_disconnect($connection);

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
