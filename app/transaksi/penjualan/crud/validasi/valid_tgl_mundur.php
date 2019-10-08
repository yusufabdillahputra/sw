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

    $sql = "select fkt_mundur from autority where user_id = 'fauzan'";

    $result = $db->first($sql, false);
    $fkt_mundur = $result['fkt_mundur'];

    if ($fkt_mundur == 'Y') {
        $status = array(
            'code' => 200
        );
        print json_encode($status);
    } else if ($fkt_mundur == 'N') {
        if ($date1 == $date2) {
            $status = array(
                'code' => 200
            );
            print json_encode($status);
        } else if ($date1 < $date2) {
            $status = array(
                'code' => 401,
                'message' => "Anda tidak mempunyai otoritas untuk membuat faktur mundur tanggal."
            );
            print json_encode($status);
        }
    }

}