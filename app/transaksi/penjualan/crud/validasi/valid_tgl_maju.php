<?php
/**
 * Autoload (Wajib include di semua CRUD)
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    include($_SERVER['DOCUMENT_ROOT'] . '/' . $php_self_exp[1] . '/config/system/' . $class_name . '.php');
});

/**
 * Path : root_path/config/SQLAnywhere
 */
$db = new SQLAnywhere();

/**
 * Proses CRUD
 * Contoh : $db->rawSql('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

if (isset($_POST['tgl'])) {
    $tgl = htmlspecialchars($_POST['tgl']);

    $date1 = strtotime($tgl);
    $date2 = strtotime('now');
    $date3 = strtotime("+3 days", $date2);

    $sql = "select fkt_maju from autority where user_id = 'fauzan'";

    $fetch = $db->first($sql, false);
    $fkt_maju = $fetch['fkt_maju'];

    if ($fkt_maju == 'Y') {
        $status = array(
            'code' => 200
        );
        print json_encode($status);
    } if ($fkt_maju == 'N') {
        if ($date1 == $date2) {
            $status = array(
                'code' => 200
            );
            print json_encode($status);
        } if ($date1 <= $date3) {
            $status = array(
                'code' => 200
            );
            print json_encode($status);
        } if ($date1 > $date3) {
            $status = array(
                'code' => 401,
                'message' => "Anda tidak berhak untuk membuka faktur H+3."
            );
            print json_encode($status);
        }
    }

}