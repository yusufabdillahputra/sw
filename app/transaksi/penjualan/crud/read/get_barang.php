<?php
/**
 * Autoload (Wajib include di semua CRUD)
 */
spl_autoload_register(function ($class_name) {
    $php_self_exp = explode('/', $_SERVER['PHP_SELF']);
    include($_SERVER['DOCUMENT_ROOT'] . '/'.$php_self_exp[1].'/config/system/' . $class_name . '.php');
});

/**
 * Path : root_path/config/SQLAnywhere
 */
$db = new SQLAnywhere();

/**
 * Proses CRUD
 * Contoh : $db->get('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

$sql = 'SELECT ID, NAMA FROM Barang ORDER BY NAMA ASC';
$fetch = $db->get($sql, false);

$result = array();
foreach ($fetch as $row) {
    array_push($result, [
        'barang'      => $row['ID'],
        'productname' => $row['NAMA']
    ]);
}
echo json_encode($result);