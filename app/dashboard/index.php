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
$date1 = Date('Y-d-m', strtotime('01/10/2019'));
$date2 = Date('Y-m-d');
$date3 = Date('Y-m-d', strtotime($date2 . "+3 days"));

echo $date3 . " dan " . $date1;

$sql = "select fkt_mundur, fkt_maju from autority where user_id = 'fauzan'";

$result = $db->get($sql, false);

foreach ($result as $value) {
    $fkt_mundur = $value['fkt_mundur'];
    $fkt_maju = $value['fkt_maju'];
}

if ($fkt_mundur == 'N' && $date1 < $date2) {
    $pesan1 = "Anda tidak mempunyai otoritas untuk membuat faktur mundur tanggal.";
} else {
    $pesan1 = "";
}

if ($fkt_maju == 'N' && $date1 >= $date3) {
    $pesan2 = "Anda tidak berhak untuk membuka faktur H+3.";
} else {
    $pesan2 = "";
}

$status = array(
    'code' => 200,
    'message1' => $pesan1,
    'message2' => $pesan2,
    'sql' => $result
);

print_r($status);