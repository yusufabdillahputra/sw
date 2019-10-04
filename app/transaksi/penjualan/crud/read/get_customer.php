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
 * Contoh : $db->get('sql_script', 'json_condition', 'result_type')
 *
 * Disarankan untuk menggunakan htmlspecialchars() setiap request POST/GET AJAX,
 * DOC : https://www.php.net/manual/en/function.htmlspecialchars.php
 */

$sql = "select cs.id, cs.nama, cs.kode_tipe, th.nama_tipe, dateformat(dateadd(day, cs.payment_due, NOW()),'dd/mm/yyyy') as tgl_jth_tempo, dateformat(NOW(), 'mm/dd/yyyy') as tgl_transaksi from customer cs, tipe_harga th where cs.kode_tipe = th.kode_tipe";
$fetch = $db->get($sql, false);
$result = array();
foreach ($fetch as $row) {
    array_push($result, [
        'id' => $row['id'],
        'nama' => $row['nama'],
        'kode_tipe' => $row['kode_tipe'],
        'nama_tipe' => $row['nama_tipe'],
        'tgl_jth_tempo' => $row['tgl_jth_tempo'],
        'tgl_transaksi' => $row['tgl_transaksi']
    ]);
}
echo json_encode($result);